<?php

namespace App\Http\Controllers;

use App\d_purchase_dt;
use App\d_stock;
use App\d_stock_mutation;
use App\d_purchase_approval;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Response;

class PenerimaanController extends Controller
{
    public function index()
    {
        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->select('p_nota', 's_company')
            ->where('pd_receivetime', '=', null)
            ->where('p_isapproved', '=', 'Y')
            ->groupBy('p_nota')
            ->get();

        return view('penerimaan-pembelian.index', compact('data'));
    }

    public function cari(Request $request)
    {
        $nota = $request->nota;

        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->join('d_item', 'pd_item', '=', 'i_id')
            ->join('d_item_dt', function ($q) {
                $q->on('pd_item_dt', '=', 'id_detailid')
                    ->on('pd_item', '=', 'id_item');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->select('p_nota', 's_company', DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'pd_qty', 'pd_barang_masuk', DB::raw('(pd_qty - pd_barang_masuk) as sisa'), 'p_id', 'pd_detailid')
            ->where('p_nota', '=', $nota)
            ->get();

        return Response::json($data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $p_id = $request->id;
            $p_detailid = $request->dt;
            $qty = $request->sisa;
            $nodo = strtoupper($request->nodo);

            $info = DB::table('d_purchase_dt')
                ->select('pd_item', 'pd_item_dt')
                ->where('pd_purchase', '=', $p_id)
                ->where('pd_detailid', '=', $p_detailid)
                ->first();

            $item = $info->pd_item;
            $itemdt = $info->pd_item_dt;

            $idPa = DB::table('d_purchase_approval')
                ->where('pa_purchase', '=', $p_id)
                ->max('pa_detailid');

            ++$idPa;

            DB::table('d_purchase_approval')
                ->insert([
                    'pa_purchase' => $p_id,
                    'pa_detailid' => $idPa,
                    'pa_date' => Carbon::now('Asia/Jakarta'),
                    'pa_item' => $item,
                    'pa_item_dt' => $itemdt,
                    'pa_qty' => $qty,
                    'pa_do' => $nodo,
                    'pa_isapproved' => 'P'
                ]);

            DB::table('d_notifikasi')
                ->where('n_fitur', '=', 'Penerimaan Seragam')
                ->where('n_detail', '=', 'Create')
                ->update([
                    'n_qty' => DB::raw('(n_qty + 1)'),
                    'n_insert' => Carbon::now('Asia/Jakarta')
                ]);

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            perwitaController::log('update Penerimaan Controller', $nodo);
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function approvePenerimaan($id, $dt, $qty, $nodo)
    {
        DB::beginTransaction();
        try {

            $getStockLama = DB::table('d_purchase_dt')
                ->select('pd_barang_masuk', 'pd_qty')
                ->where('pd_purchase', '=', $id)
                ->where('pd_detailid', '=', $dt)
                ->get();

            $updateBarang = $getStockLama[0]->pd_barang_masuk + $qty;
            $sekarang = Carbon::now('Asia/Jakarta');

            if ($updateBarang == $getStockLama[0]->pd_qty) {
                $data = array('pd_barang_masuk' => $updateBarang, 'pd_receivetime' => $sekarang);
                d_purchase_dt::where('pd_purchase', '=', $id)->where('pd_detailid', '=', $dt)->update($data);
            } else {
                $data = array('pd_barang_masuk' => $updateBarang);
                d_purchase_dt::where('pd_purchase', '=', $id)->where('pd_detailid', '=', $dt)->update($data);
            }

//========== cek id stock

            $comp = Session::get('mem_comp');
            $info = DB::table('d_purchase')
                ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
                ->select('pd_item', 'pd_item_dt', 'pd_qty', 'pd_total_net', 'p_nota')
                ->where('p_id', '=', $id)
                ->where('pd_detailid', '=', $dt)
                ->first();

            $idStok = DB::table('d_stock')
                ->select('s_id')
                ->where('s_comp', '=', $comp)
                ->where('s_item', '=', $info->pd_item)
                ->where('s_item_dt', '=', $info->pd_item_dt)
                ->where('s_position', '=', $comp)
                ->get();

            $hargaJual = DB::table('d_item_dt')
                ->select('id_price')
                ->where('id_item', '=', $info->pd_item)
                ->where('id_detailid', '=', $info->pd_item_dt)
                ->get();

//========== buat data stok baru
            if (count($idStok) < 1) {
                $idStok = DB::table('d_stock')
                    ->max('s_id');
                $idStok = $idStok + 1;

                $stock = array(
                    's_id' => $idStok,
                    's_comp' => $comp,
                    's_position' => $comp,
                    's_item' => $info->pd_item,
                    's_item_dt' => $info->pd_item_dt,
                    's_qty' => $qty,
                    's_insert' => $sekarang,
                    's_update' => $sekarang
                );

                d_stock::insert($stock);

                $mutasi = array(
                    'sm_stock' => $idStok,
                    'sm_detailid' => 1,
                    'sm_comp' => $comp,
                    'sm_date' => $sekarang,
                    'sm_item' => $info->pd_item,
                    'sm_item_dt' => $info->pd_item_dt,
                    'sm_detail' => 'Pembelian',
                    'sm_qty' => $qty,
                    'sm_use' => 0,
                    'sm_hpp' => $info->pd_total_net / $info->pd_qty,
                    'sm_sell' => $hargaJual[0]->id_price,
                    'sm_nota' => $info->p_nota,
                    'sm_delivery_order' => strtoupper($nodo),
                    'sm_petugas' => Session::get('mem')
                );

                d_stock_mutation::insert($mutasi);

//========== update qty jika data sudah ada
            } else {
                $idStok = $idStok[0]->s_id;

                $stock = DB::table('d_stock')
                    ->where('s_id', '=', $idStok)
                    ->first();

                $stockAkhir = $stock->s_qty + $qty;
                $update = array('s_qty' => $stockAkhir);

                d_stock::where('s_id', '=', $idStok)->update($update);
                $getSMdt = DB::table('d_stock_mutation')
                    ->where('sm_stock', '=', $idStok)
                    ->max('sm_detailid');
                $detailid = $getSMdt + 1;

                $mutasi = array(
                    'sm_stock' => $idStok,
                    'sm_detailid' => $detailid,
                    'sm_comp' => $comp,
                    'sm_date' => $sekarang,
                    'sm_item' => $info->pd_item,
                    'sm_item_dt' => $info->pd_item_dt,
                    'sm_detail' => 'Pembelian',
                    'sm_qty' => $qty,
                    'sm_use' => 0,
                    'sm_hpp' => $info->pd_total_net / $info->pd_qty,
                    'sm_sell' => $hargaJual[0]->id_price,
                    'sm_nota' => $info->p_nota,
                    'sm_delivery_order' => strtoupper($nodo),
                    'sm_petugas' => Session::get('mem')
                );

                d_stock_mutation::insert($mutasi);
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            perwitaController::log('approvePenerimaan', $nodo);
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function history()
    {
        return view('penerimaan-pembelian.history');
    }

    public function findHistory(Request $request) {
      if ($request->nota == "" && $request->tgl_awal != "" && $request->tgl_akhir != "") {
        $request->tgl_awal = str_replace('/','-',$request->tgl_awal);
        $request->tgl_akhir = str_replace('/','-',$request->tgl_akhir);

        $start = Carbon::parse($request->tgl_awal)->startOfDay();  //2016-09-29 00:00:00.000000
        $end = Carbon::parse($request->tgl_akhir)->endOfDay(); //2016-09-29 23:59:59.000000

        $data = DB::table('d_purchase')
                      ->leftjoin('d_purchase_approval', 'pa_purchase', '=', 'p_id')
                      ->join('d_item', 'i_id', '=', 'pa_item')
                      ->join('d_item_dt', function($e){
                        $e->on('id_item', '=', 'i_id')
                          ->on('id_detailid', '=', 'pa_item_dt');
                      })
                      ->join('d_kategori', 'k_id', '=', 'i_kategori')
                      ->join('d_size', 's_id', '=', 'id_size')
                      ->leftjoin('d_stock_mutation', 'sm_delivery_order', '=', 'pa_do')
                      ->join('d_mem', 'm_id', '=', 'sm_petugas')
                      ->select('m_username', 'k_nama', 's_nama', 'i_nama', 'pa_do', 'pa_date', 'pa_qty')
                      ->where('pa_date', '>=', $start)
                      ->where('pa_date', '<=', $end)
                      ->where('p_isapproved', 'Y')
                      ->where('pa_isapproved', 'Y')
                      ->get();

      } elseif ($request->nota != "" && $request->tgl_awal == "" && $request->tgl_akhir == "") {
        $data = DB::table('d_purchase')
                      ->leftjoin('d_purchase_approval', 'pa_purchase', '=', 'p_id')
                      ->join('d_item', 'i_id', '=', 'pa_item')
                      ->join('d_item_dt', function($e){
                        $e->on('id_item', '=', 'i_id')
                          ->on('id_detailid', '=', 'pa_item_dt');
                      })
                      ->join('d_kategori', 'k_id', '=', 'i_kategori')
                      ->join('d_size', 's_id', '=', 'id_size')
                      ->leftjoin('d_stock_mutation', 'sm_delivery_order', '=', 'pa_do')
                      ->join('d_mem', 'm_id', '=', 'sm_petugas')
                      ->select('m_username', 'k_nama', 's_nama', 'i_nama', 'pa_do', 'pa_date', 'pa_qty')
                      ->where('p_nota', $request->nota)
                      ->where('p_isapproved', 'Y')
                      ->where('pa_isapproved', 'Y')
                      ->get();

      } elseif ($request->nota != "" && $request->tgl_awal != "" && $request->tgl_akhir != "") {
        $request->tgl_awal = str_replace('/','-',$request->tgl_awal);
        $request->tgl_akhir = str_replace('/','-',$request->tgl_akhir);

        $start = Carbon::parse($request->tgl_awal)->startOfDay();  //2016-09-29 00:00:00.000000
        $end = Carbon::parse($request->tgl_akhir)->endOfDay(); //2016-09-29 23:59:59.000000

        $data = DB::table('d_purchase')
                      ->leftjoin('d_purchase_approval', 'pa_purchase', '=', 'p_id')
                      ->join('d_item', 'i_id', '=', 'pa_item')
                      ->join('d_item_dt', function($e){
                        $e->on('id_item', '=', 'i_id')
                          ->on('id_detailid', '=', 'pa_item_dt');
                      })
                      ->join('d_kategori', 'k_id', '=', 'i_kategori')
                      ->join('d_size', 's_id', '=', 'id_size')
                      ->leftjoin('d_stock_mutation', 'sm_delivery_order', '=', 'pa_do')
                      ->join('d_mem', 'm_id', '=', 'sm_petugas')
                      ->select('m_username', 'k_nama', 's_nama', 'i_nama', 'pa_do', 'pa_date', 'pa_qty')
                      ->where('p_nota', $request->nota)
                      ->where('pa_date', '>=', $start)
                      ->where('pa_date', '<=', $end)
                      ->where('p_isapproved', 'Y')
                      ->where('pa_isapproved', 'Y')
                      ->get();
      }

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->pa_date = Carbon::parse($data[$i]->pa_date)->format('d/m/Y h:i:s');
      }

      return Response::json($data);
    }

    public function cariHistory(Request $request)
    {
        $cari = $request->term;

        $data = DB::select("select s_company, p_nota, pd_receivetime from d_purchase inner join d_supplier on s_id = p_supplier inner join d_purchase_dt on pd_purchase = p_id where (s_company like '%".$cari."%' or p_nota like '%".$cari."%') and pd_receivetime is not null and p_id not in (select pd_purchase from d_purchase_dt where pd_receivetime is null) group by p_id limit 20");
        if ($data == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($data as $query) {
                $results[] = ['id' => $query->p_nota, 'label' => $query->p_nota . ' ('.$query->s_company.')' ];
            }
        }

        return Response::json($results);
    }

    public function detailHistory(Request $request)
    {
        $nota = $request->nota;
        $data = DB::table('d_stock_mutation')
            ->join('d_item', 'sm_item', '=', 'i_id')
            ->join('d_item_dt', function ($q){
                $q->on('i_id', '=', 'id_item');
                $q->on('sm_item_dt', '=', 'id_detailid');
            })
            ->join('d_size', 's_id', '=', 'id_size')
            ->join('d_mem', 'm_id', '=', 'sm_petugas')
            ->select('d_stock_mutation.*', DB::raw('date_format(sm_date, "%d/%m/%Y %H:%i") as sm_date'), DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'm_name')
            ->where('sm_nota', '=', $nota)
            ->get();

        return Response::json($data);
    }

    public function print()
    {
        $data = DB::table('d_stock_mutation')
            ->join('d_stock', 'd_stock.s_id', '=', 'sm_stock')
            ->join('d_item', 'i_id', '=', 'sm_item')
            ->join('d_item_dt', function ($e) {
                $e->on('id_item', '=', 'i_id');
                $e->on('id_detailid', '=', 'sm_item_dt');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->select('sm_date', 'sm_qty', 'sm_nota', 'sm_delivery_order', 'i_nama', 'i_warna', 'k_nama', 's_nama')
            ->get();

        // dd($data);
        return view('penerimaan-pembelian.print', compact('data'));
    }
}
