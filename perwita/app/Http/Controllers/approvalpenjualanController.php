<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

use App\d_stock_mutation;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

use App\d_stock;

use App\d_sales_dt;

class approvalpenjualanController extends Controller
{
    public function index()
    {

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

        $data = DB::table('d_sales')
            ->join('d_mitra', 'm_id', '=', 's_member')
            ->join('d_mitra_divisi', function($e){
              $e->on('md_mitra', '=', 'm_id')
                ->on('md_id', '=', 's_divisi');
            })
            ->select('s_id', 's_date', 'm_name', 's_nota', 'md_name', 'm_id', 'md_id', DB::raw('md_name as pekerja'), DB::raw('md_name as barang'))
            ->where('s_isapproved', 'P')
            ->get();

        for ($i=0; $i < count($data); $i++) {
          $data[$i]->pekerja = DB::table('d_mitra_pekerja')
                        ->where('mp_mitra', $data[$i]->m_id)
                        ->where('mp_divisi', $data[$i]->md_id)
                        ->count();

          $tmpbarang = DB::table('d_sales_dt')
                                  ->where('sd_sales', $data[$i]->s_id)
                                  ->select(DB::raw('sum(sd_qty) as sd_qty'))
                                  ->first();

          $data[$i]->barang = $tmpbarang->sd_qty;
        }

        $count = DB::table('d_sales')
            ->where('s_isapproved', 'P')
            ->get();

        DB::table('d_notifikasi')
            ->where('n_fitur', 'Pengeluaran')
            ->update([
                'n_qty' => count($count)
            ]);

        return view('approvalpengeluaran.index', compact('data'));

    }

    public function detail(Request $request)
    {
        $data = DB::table('d_sales')
            ->join('d_sales_dt', 'sd_sales', '=', 's_id')
            ->join('d_item', 'i_id', '=', 'sd_item')
            ->join('d_item_dt', function ($e) {
                $e->on('id_item', '=', 'i_id')
                    ->on('id_detailid', '=', 'sd_item_dt');
            })
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->select('s_nama', 'k_nama', 'i_nama', 'i_warna', 'id_price', 's_total_net', 's_total_gross', 's_pajak', 's_total_gross', 's_nota', 'sd_qty', 'sd_value', 'sd_disc_value', 'sd_total_net')
            ->where('sd_sales', $request->id)
            ->get();

        return response()->json($data);
    }

    public function approve(Request $request)
    {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($request->pilih); $i++) {
                $sales = DB::table('d_sales')
                    ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                    ->where('s_id', $request->pilih[$i])
                    ->get();

                $nota = DB::table('d_sales')
                        ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                        ->select('s_nota')
                        ->whereIn('s_id', $request->pilih)
                        ->get();

                DB::table('d_sales')
                    ->whereIn('s_id', $request->pilih)
                    ->update([
                        's_isapproved' => 'Y'
                    ]);

                for ($i = 0; $i < count($sales); $i++) {

                    $stock = DB::table('d_stock')
                        ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
                        ->select('d_stock.*', 'd_stock_mutation.*', DB::raw('(sm_qty - sm_use) as sm_sisa'))
                        ->where('s_item', $sales[$i]->sd_item)
                        ->where('s_item_dt', $sales[$i]->sd_item_dt)
                        ->where('s_comp', $sales[$i]->s_comp)
                        ->where(DB::raw('(sm_qty - sm_use)'), '>', 0)
                        ->get();

                    $permintaan = $sales[$i]->sd_qty;

                    DB::table('d_stock')
                        ->where('s_id', $stock[$i]->sm_stock)
                        ->where('s_item', $stock[$i]->sm_item)
                        ->where('s_item_dt', $stock[$i]->sm_item_dt)
                        ->update([
                            's_qty' => $stock[$i]->s_qty - $permintaan
                        ]);

                    for ($j = 0; $j < count($stock); $j++) {
                        //Terdapat sisa permintaan

                        $detailid = DB::table('d_stock_mutation')
                            ->max('sm_detailid');

                        if ($permintaan > $stock[$j]->sm_sisa && $permintaan != 0) {

                            DB::table('d_stock_mutation')
                                ->where('sm_stock', '=', $stock[$j]->sm_stock)
                                ->where('sm_detailid', '=', $stock[$j]->sm_detailid)
                                ->update([
                                    'sm_use' => $stock[$j]->sm_qty
                                ]);

                            $permintaan = $permintaan - $stock[$j]->sm_sisa;

                            DB::table('d_stock_mutation')
                                ->insert([
                                    'sm_stock' => $stock[$j]->sm_stock,
                                    'sm_detailid' => $detailid + 1,
                                    'sm_comp' => $stock[$j]->sm_comp,
                                    'sm_date' => Carbon::now('Asia/Jakarta'),
                                    'sm_item' => $sales[$i]->sd_item,
                                    'sm_item_dt' => $sales[$i]->sd_item_dt,
                                    'sm_detail' => 'Pengeluaran',
                                    'sm_qty' => $stock[$j]->sm_sisa,
                                    'sm_use' => 0,
                                    'sm_hpp' => $stock[$j]->sm_hpp,
                                    'sm_sell' => $stock[$j]->sm_sell,
                                    'sm_nota' => $sales[$i]->s_nota,
                                    'sm_delivery_order' => $stock[$j]->sm_delivery_order,
                                    'sm_petugas' => Session::get('mem')
                                ]);

                        } elseif ($permintaan <= $stock[$j]->sm_sisa && $permintaan != 0) {
                            //Langsung Eksekusi

                            $detailid = DB::table('d_stock_mutation')
                                ->max('sm_detailid');

                            DB::table('d_stock_mutation')
                                ->where('sm_stock', '=', $stock[$j]->sm_stock)
                                ->where('sm_detailid', '=', $stock[$j]->sm_detailid)
                                ->update([
                                    'sm_use' => $permintaan + $stock[$j]->sm_use
                                ]);

                            DB::table('d_stock_mutation')
                                ->insert([
                                    'sm_stock' => $stock[$j]->sm_stock,
                                    'sm_detailid' => $detailid + 1,
                                    'sm_comp' => $stock[$j]->sm_comp,
                                    'sm_date' => Carbon::now('Asia/Jakarta'),
                                    'sm_item' => $sales[$i]->sd_item,
                                    'sm_item_dt' => $sales[$i]->sd_item_dt,
                                    'sm_detail' => 'Pengeluaran',
                                    'sm_qty' => $permintaan,
                                    'sm_use' => 0,
                                    'sm_hpp' => $stock[$j]->sm_hpp,
                                    'sm_sell' => $stock[$j]->sm_sell,
                                    'sm_nota' => $sales[$i]->s_nota,
                                    'sm_delivery_order' => $stock[$j]->sm_delivery_order,
                                    'sm_petugas' => Session::get('mem')
                                ]);

                            $permintaan = 0;
                            $j = count($stock) + 1;
                        }
                    }
                }

            }

            DB::commit();
            return response()->json([
                'status' => 'berhasil',
                'nota' => $nota
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal'
            ]);
        }
    }

    public function setujuilama(Request $request)
    {
        DB::beginTransaction();
        try {

            $sales = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->where('s_id', $request->id)
                ->get();

            //Insert Pekerja Mutasi
            $pekerja = DB::table('d_seragam_pekerja')
                ->select('sp_pekerja', 'sp_no')
                ->where('sp_sales', $request->id)
                ->get();

            for ($i = 0; $i < count($pekerja); $i++) {
                $detailid = DB::table('d_pekerja_mutation')
                    ->where('pm_pekerja', $pekerja[$i]->sp_pekerja)
                    ->max('pm_detailid');

                $mitrapekerja = DB::table('d_mitra_pekerja')
                    ->where('mp_pekerja', $pekerja[$i]->sp_pekerja)
                    ->get();

                DB::table('d_pekerja_mutation')
                    ->insert([
                        'pm_pekerja' => $pekerja[$i]->sp_pekerja,
                        'pm_detailid' => $detailid + 1,
                        'pm_mitra' => $mitrapekerja[0]->mp_mitra,
                        'pm_divisi' => $mitrapekerja[0]->mp_divisi,
                        'pm_detail' => 'Pemberian Seragam',
                        'pm_status' => 'Aktif',
                        'pm_insert_by' => Session::get('mem'),
                        'pm_reff' => $pekerja[$i]->sp_no
                    ]);
            }

            DB::table('d_sales')
                ->where('s_id', $request->id)
                ->update([
                    's_isapproved' => 'Y'
                ]);

            for ($i = 0; $i < count($sales); $i++) {

                $stock = DB::table('d_stock')
                    ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
                    ->select('d_stock.*', 'd_stock_mutation.*', DB::raw('(sm_qty - sm_use) as sm_sisa'))
                    ->where('s_item', $sales[$i]->sd_item)
                    ->where('s_item_dt', $sales[$i]->sd_item_dt)
                    ->where('s_comp', $sales[$i]->s_comp)
                    ->where(DB::raw('(sm_qty - sm_use)'), '>', 0)
                    ->get();

                $permintaan = $sales[$i]->sd_qty;

                DB::table('d_stock')
                    ->where('s_id', $stock[$i]->sm_stock)
                    ->where('s_item', $stock[$i]->sm_item)
                    ->where('s_item_dt', $stock[$i]->sm_item_dt)
                    ->update([
                        's_qty' => $stock[$i]->s_qty - $permintaan
                    ]);

                for ($j = 0; $j < count($stock); $j++) {
                    //Terdapat sisa permintaan

                    $detailid = DB::table('d_stock_mutation')
                        ->max('sm_detailid');

                    if ($permintaan > $stock[$j]->sm_sisa && $permintaan != 0) {

                        DB::table('d_stock_mutation')
                            ->where('sm_stock', '=', $stock[$j]->sm_stock)
                            ->where('sm_detailid', '=', $stock[$j]->sm_detailid)
                            ->update([
                                'sm_use' => $stock[$j]->sm_qty
                            ]);

                        $permintaan = $permintaan - $stock[$j]->sm_sisa;

                        DB::table('d_stock_mutation')
                            ->insert([
                                'sm_stock' => $stock[$j]->sm_stock,
                                'sm_detailid' => $detailid + 1,
                                'sm_comp' => $stock[$j]->sm_comp,
                                'sm_date' => Carbon::now('Asia/Jakarta'),
                                'sm_item' => $sales[$i]->sd_item,
                                'sm_item_dt' => $sales[$i]->sd_item_dt,
                                'sm_detail' => 'Pengeluaran',
                                'sm_qty' => $stock[$j]->sm_sisa,
                                'sm_use' => 0,
                                'sm_hpp' => $stock[$j]->sm_hpp,
                                'sm_sell' => $stock[$j]->sm_sell,
                                'sm_nota' => $sales[$i]->s_nota,
                                'sm_delivery_order' => $stock[$j]->sm_delivery_order,
                                'sm_petugas' => Session::get('mem')
                            ]);

                    } elseif ($permintaan <= $stock[$j]->sm_sisa && $permintaan != 0) {
                        //Langsung Eksekusi

                        $detailid = DB::table('d_stock_mutation')
                            ->max('sm_detailid');

                        DB::table('d_stock_mutation')
                            ->where('sm_stock', '=', $stock[$j]->sm_stock)
                            ->where('sm_detailid', '=', $stock[$j]->sm_detailid)
                            ->update([
                                'sm_use' => $permintaan + $stock[$j]->sm_use
                            ]);

                        DB::table('d_stock_mutation')
                            ->insert([
                                'sm_stock' => $stock[$j]->sm_stock,
                                'sm_detailid' => $detailid + 1,
                                'sm_comp' => $stock[$j]->sm_comp,
                                'sm_date' => Carbon::now('Asia/Jakarta'),
                                'sm_item' => $sales[$i]->sd_item,
                                'sm_item_dt' => $sales[$i]->sd_item_dt,
                                'sm_detail' => 'Pengeluaran',
                                'sm_qty' => $permintaan,
                                'sm_use' => 0,
                                'sm_hpp' => $stock[$j]->sm_hpp,
                                'sm_sell' => $stock[$j]->sm_sell,
                                'sm_nota' => $sales[$i]->s_nota,
                                'sm_delivery_order' => $stock[$j]->sm_delivery_order,
                                'sm_petugas' => Session::get('mem')
                            ]);

                        $permintaan = 0;
                        $j = count($stock) + 1;
                    }
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'berhasil'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal'
            ]);
        }
    }

    public function setujui(Request $request)
    {
        DB::beginTransaction();
        try {

            $sales = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->where('s_id', $request->id)
                ->get();

            $nota = null;

            if ($sales != null){
                $nota = $sales[0]->s_nota;
            }

            DB::table('d_sales')
                ->where('s_id', $request->id)
                ->update([
                    's_isapproved' => 'Y'
                ]);

            for ($i = 0; $i < count($sales); $i++) {

                $stock = DB::table('d_stock')
                    ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
                    ->select('d_stock.*', 'd_stock_mutation.*', DB::raw('(sm_qty - sm_use) as sm_sisa'))
                    ->where('s_item', $sales[$i]->sd_item)
                    ->where('s_item_dt', $sales[$i]->sd_item_dt)
                    ->where('s_comp', $sales[$i]->s_comp)
                    ->where(DB::raw('(sm_qty - sm_use)'), '>', 0)
                    ->get();

                $permintaan = $sales[$i]->sd_qty;

                DB::table('d_stock')
                    ->where('s_id', $stock[0]->sm_stock)
                    ->where('s_item', $stock[0]->sm_item)
                    ->where('s_item_dt', $stock[0]->sm_item_dt)
                    ->update([
                        's_qty' => $stock[0]->s_qty - $permintaan
                    ]);

                for ($j = 0; $j < count($stock); $j++) {
                    //Terdapat sisa permintaan

                    $detailid = DB::table('d_stock_mutation')
                        ->max('sm_detailid');

                    if ($permintaan > $stock[$j]->sm_sisa && $permintaan != 0) {

                        DB::table('d_stock_mutation')
                            ->where('sm_stock', '=', $stock[$j]->sm_stock)
                            ->where('sm_detailid', '=', $stock[$j]->sm_detailid)
                            ->update([
                                'sm_use' => $stock[$j]->sm_qty
                            ]);

                        $permintaan = $permintaan - $stock[$j]->sm_sisa;

                        DB::table('d_stock_mutation')
                            ->insert([
                                'sm_stock' => $stock[$j]->sm_stock,
                                'sm_detailid' => $detailid + 1,
                                'sm_comp' => $stock[$j]->sm_comp,
                                'sm_date' => Carbon::now('Asia/Jakarta'),
                                'sm_item' => $sales[$i]->sd_item,
                                'sm_item_dt' => $sales[$i]->sd_item_dt,
                                'sm_detail' => 'Pengeluaran',
                                'sm_qty' => $stock[$j]->sm_sisa,
                                'sm_use' => 0,
                                'sm_hpp' => $stock[$j]->sm_hpp,
                                'sm_sell' => $stock[$j]->sm_sell,
                                'sm_nota' => $sales[$i]->s_nota,
                                'sm_delivery_order' => $stock[$j]->sm_delivery_order,
                                'sm_petugas' => Session::get('mem')
                            ]);

                    } elseif ($permintaan <= $stock[$j]->sm_sisa && $permintaan != 0) {
                        //Langsung Eksekusi

                        $detailid = DB::table('d_stock_mutation')
                            ->max('sm_detailid');

                        DB::table('d_stock_mutation')
                            ->where('sm_stock', '=', $stock[$j]->sm_stock)
                            ->where('sm_detailid', '=', $stock[$j]->sm_detailid)
                            ->update([
                                'sm_use' => $permintaan + $stock[$j]->sm_use
                            ]);

                        DB::table('d_stock_mutation')
                            ->insert([
                                'sm_stock' => $stock[$j]->sm_stock,
                                'sm_detailid' => $detailid + 1,
                                'sm_comp' => $stock[$j]->sm_comp,
                                'sm_date' => Carbon::now('Asia/Jakarta'),
                                'sm_item' => $sales[$i]->sd_item,
                                'sm_item_dt' => $sales[$i]->sd_item_dt,
                                'sm_detail' => 'Pengeluaran',
                                'sm_qty' => $permintaan,
                                'sm_use' => 0,
                                'sm_hpp' => $stock[$j]->sm_hpp,
                                'sm_sell' => $stock[$j]->sm_sell,
                                'sm_nota' => $sales[$i]->s_nota,
                                'sm_delivery_order' => $stock[$j]->sm_delivery_order,
                                'sm_petugas' => Session::get('mem')
                            ]);

                        $permintaan = 0;
                        $j = count($stock) + 1;
                    }
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'berhasil',
                'nota' => $nota
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal'
            ]);
        }
    }

    public function tolak(Request $request)
    {
        DB::beginTransaction();
        try {

            DB::table('d_sales')
                ->where('s_id', $request->id)
                ->update([
                    's_isapproved' => 'N'
                ]);

            DB::commit();
            return response()->json([
                'status' => 'berhasil'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal'
            ]);
        }

    }

    public function tolaklist(Request $request)
    {
        DB::beginTransaction();
        try {

            DB::table('d_sales')
                ->whereIn('s_id', $request->pilih)
                ->update([
                    's_isapproved' => 'N'
                ]);

            DB::commit();
            return response()->json([
                'status' => 'berhasil'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal'
            ]);
        }
    }

    public function cetak(Request $request){
      $data = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 'd_sales.s_id')
                ->join('d_item', 'i_id', '=', 'sd_item')
                ->join('d_item_dt', function($e){
                  $e->on('id_item', '=', 'i_id')
                    ->on('id_detailid', '=', 'sd_item_dt');
                })
                ->join('d_size', 'd_size.s_id', '=', 'id_size')
                ->join('d_kategori', 'k_id', '=', 'i_kategori')
                ->join('d_mitra', 'm_id', '=', 's_member')
                ->where('s_nota', $request->id)
                ->get();

      return view('approvalpengeluaran.print', compact('data'));
    }

}
