<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

use DB;

use Carbon\Carbon;

use Yajra\Datatables\Datatables;

use App\Http\Controllers\AksesUser;

class pembagianseragamController extends Controller
{
    public function index(){
      if (!AksesUser::checkAkses(31, 'read')) {
          return redirect('not-authorized');
      }

      return view('pembagianseragam.index');
    }

    public function tambah(){
      if (!AksesUser::checkAkses(31, 'insert')) {
          return redirect('not-authorized');
      }

      $perwita = new perwitaController;

      if ($perwita->getComp()[0] == 'internal') {
        $mitra = DB::table('d_mitra')
                    ->get();
      } elseif ($perwita->getComp()[0] == 'mitra') {
        $mitra = DB::table('d_mitra')
                  ->where('m_id', $perwita->getComp()[2])
                  ->get();
      }

      return view('pembagianseragam.create', compact('mitra'));
    }

    public function getdivisi(Request $request){
      $divisi = DB::table('d_mitra_divisi')
                  ->where('md_mitra', $request->mitra)
                  ->get();

      return response()->json($divisi);
    }

    public function getnota(Request $request){
      $cari = $request->term;

      $perwita = new perwitaController;

      if ($perwita->getComp()[0] == 'internal') {
        $data = DB::table('d_sales_received')
                    ->join('d_sales', 's_id', '=', 'sr_sales')
                    ->where('sr_isapproved', 'Y')
                    ->where('s_isapproved', 'Y')
                    ->where('s_member', $request->mitra)
                    ->select('s_id', 's_nota')
                    ->groupBy('s_id')
                    ->get();
      } elseif ($perwita->getComp()[0] == 'mitra') {
        $data = DB::table('d_sales_received')
                  ->join('d_sales', 's_id', '=', 'sr_sales')
                  ->where('s_member', $perwita->getComp()[2])
                  ->where('sr_isapproved', 'Y')
                  ->where('s_isapproved', 'Y')
                  ->where('sr_isapproved', 'Y')
                  ->where('s_member', $request->mitra)
                  ->select('s_id', 's_nota')
                  ->groupBy('s_id')
                  ->get();
      }

      return response()->json($data);
    }

    public function getseragam(Request $request){
      $data = DB::table('d_sales_received')
                ->join('d_item', 'i_id', '=', 'sr_item')
                ->join('d_item_dt', function($e){
                  $e->on('id_item', '=', 'sr_item')
                    ->on('id_detailid', '=', 'sr_item_dt');
                })
                ->join('d_kategori', 'k_id', '=', 'i_kategori')
                ->join('d_size', 'd_size.s_id', '=', 'id_size')
                ->select('s_nama', 'k_nama', 'i_nama', 'i_warna', 'sr_sales', 'sr_detailid', 'sr_item', 'sr_item_dt', DB::raw('sum(sr_qty) as sr_qty'))
                ->where('sr_sales', $request->s_id)
                ->where('sr_isapproved', 'Y')
                ->groupBy('sr_item_dt')
                ->get();

      $jenis = DB::table('d_sales_received')
                    ->join('d_item', 'i_id', '=', 'sr_item')
                    ->join('d_kategori', 'k_id', '=', 'i_kategori')
                    ->where('sr_sales', $request->s_id)
                    ->where('sr_isapproved', 'Y')
                    ->select('k_nama', 'k_id', 'i_id', 'i_nama', 'i_warna')
                    ->groupBy('i_kategori')
                    ->get();

      if (count($data) == 0) {
        return response()->json([
          'status' => 'kosong'
        ]);
      } else {
        return response()->json([
          'data' => $data,
          'jenis' => $jenis
        ]);
      }
    }

    public function showdata(Request $request){
      $data = DB::table('d_mitra_pekerja')
                  ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
                  ->where('mp_mitra', $request->mitra)
                  ->where('mp_divisi', $request->divisi)
                  ->where('mp_status', 'Aktif')
                  ->where('mp_isapproved', 'Y')
                  ->select('p_id', 'p_name')
                  ->get();

      $sales = [];
      for ($i=0; $i < count($data); $i++) {
        $sales[] = DB::table('d_seragam_pekerja')
                      ->where('sp_sales', $request->sales)
                      ->where('sp_pekerja', $data[$i]->p_id)
                      ->where('sp_mitra', $request->mitra)
                      ->where('sp_divisi', $request->divisi)
                      ->get();
      }

      if (count($sales) == 0) {
        return response()->json([
          'data' => $data,
          'sales' => 'kosong'
        ]);
      } else {
        return response()->json([
          'data' => $data,
          'sales' => $sales
        ]);
      }
    }

    public function simpan(Request $request){
      if (!AksesUser::checkAkses(31, 'insert')) {
          return redirect('not-authorized');
      }

      DB::beginTransaction();
      try {


        $cek = DB::table('d_seragam_pekerja')
                    ->where('sp_sales', $request->nota)
                    ->count();

        if ($cek == 0) {
          $kode = "";

          $querykode = DB::select(DB::raw("SELECT MAX(MID(sp_no,4,3)) as counter, MAX(MID(sp_no,8,2)) as tanggal, MAX(MID(sp_no,11,2)) as bulan, MAX(MID(sp_no,14)) as tahun FROM d_seragam_pekerja"));

          if (count($querykode) > 0) {
            if ($querykode[0]->bulan != date('m') || $querykode[0]->tahun != date('Y') || $querykode[0]->tanggal != date('d')) {
                $kode = "001";
            } else {
              foreach($querykode as $k)
                {
                  $tmp = ((int)$k->counter)+1;
                  $kode = sprintf("%03s", $tmp);
                }
            }
          } else {
            $kode = "001";
          }


          $finalkode = 'PS-' . $kode . '/' . date('d') . '/' . date('m') . '/' . date('Y');


          for ($i=0; $i < count($request->ukuran); $i++) {
            if ($request->ukuran[$i] != "") {

              $id = DB::table('d_seragam_pekerja')
                        ->max('sp_id');

              if ($id == null) {
                $id = 1;
              } else {
                $id += 1;
              }

              $harga = DB::table('d_item_dt')
                    ->select('id_price')
                    ->where('id_item', $request->jenis)
                    ->where('id_detailid', $request->ukuran[$i])
                    ->first();

                    $asd = DB::table('d_sales_dt')
                        ->where('sd_sales', $request->nota)
                        ->where('sd_item', $request->jenis)
                        ->where('sd_item_dt', $request->ukuran[$i])
                        ->first();

                    DB::table('d_sales_dt')
                    ->where('sd_sales', $request->nota)
                    ->where('sd_item', $request->jenis)
                    ->where('sd_item_dt', $request->ukuran[$i])
                    ->update([
                      'sd_use' => $asd->sd_use + 1
                    ]);

              DB::table('d_seragam_pekerja')
                    ->insert([
                      'sp_sales' => $request->nota,
                      'sp_id' => $id,
                      'sp_pekerja' => $request->pekerja[$i],
                      'sp_no' => $finalkode,
                      'sp_date' => Carbon::now('Asia/Jakarta'),
                      'sp_mitra' => $request->mitra,
                      'sp_divisi' => $request->divisi,
                      'sp_item' => $request->jenis,
                      'sp_item_dt' => $request->ukuran[$i],
                      'sp_qty' => 1,
                      'sp_value' => $harga->id_price,
                    ]);

            }
          }
        } else {

          $data = DB::table('d_seragam_pekerja')
                      ->select('sp_no')
                      ->where('sp_sales', $request->nota)
                      ->first();

          $tmp = DB::table('d_seragam_pekerja')
                  ->where('sp_sales', $request->nota)
                  ->get();

          DB::table('d_seragam_pekerja')
                  ->where('sp_sales', $request->nota)
                  ->delete();

          for ($b=0; $b < count($tmp); $b++) {
          $temp = DB::table('d_sales_dt')
          ->where('sd_sales', $tmp[$b]->sp_sales)
          ->where('sd_item', $tmp[$b]->sp_item)
          ->where('sd_item_dt', $tmp[$b]->sp_item_dt)
          ->first();


              DB::table('d_sales_dt')
                  ->where('sd_sales', $tmp[$b]->sp_sales)
                  ->where('sd_item', $tmp[$b]->sp_item)
                  ->where('sd_item_dt', $tmp[$b]->sp_item_dt)
                  ->update([
                    'sd_use' => $temp->sd_use - $tmp[$b]->sp_qty
                  ]);
          }

          for ($i=0; $i < count($request->ukuran); $i++) {
            if ($request->ukuran[$i] != "") {

              $id = DB::table('d_seragam_pekerja')
                        ->max('sp_id');

              if ($id == null) {
                $id = 1;
              } else {
                $id += 1;
              }

              $harga = DB::table('d_item_dt')
                    ->select('id_price')
                    ->where('id_item', $request->jenis)
                    ->where('id_detailid', $request->ukuran[$i])
                    ->first();

              $asd = DB::table('d_sales_dt')
                  ->where('sd_sales', $request->nota)
                  ->where('sd_item', $request->jenis)
                  ->where('sd_item_dt', $request->ukuran[$i])
                  ->first();

              DB::table('d_sales_dt')
              ->where('sd_sales', $request->nota)
              ->where('sd_item', $request->jenis)
              ->where('sd_item_dt', $request->ukuran[$i])
              ->update([
                'sd_use' => $asd->sd_use + 1
              ]);

              DB::table('d_seragam_pekerja')
                    ->insert([
                      'sp_sales' => $request->nota,
                      'sp_id' => $id,
                      'sp_pekerja' => $request->pekerja[$i],
                      'sp_no' => $data->sp_no,
                      'sp_date' => Carbon::now('Asia/Jakarta'),
                      'sp_mitra' => $request->mitra,
                      'sp_divisi' => $request->divisi,
                      'sp_item' => $request->jenis,
                      'sp_item_dt' => $request->ukuran[$i],
                      'sp_qty' => 1,
                      'sp_value' => $harga->id_price,
                    ]);

            }
          }
        }

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::commit();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }

    public function datatable_data(){
      DB::statement(DB::raw('set @rownum=0'));
      $data = DB::table('d_seragam_pekerja')
            ->join('d_sales_dt', function($e){
              $e->on('sd_sales', '=', 'sp_sales')
                ->on('sd_item', '=', 'sp_item')
                ->on('sd_item_dt', '=', 'sp_item_dt');
            })
            ->join('d_mitra', 'm_id', '=', 'sp_mitra')
            ->join('d_mitra_divisi', function($e){
              $e->on('md_mitra', '=', 'm_id')
                ->on('md_id', '=', 'sp_divisi');
            })
            ->select('m_name', 'md_name', 'sd_use', 'sd_qty', 'sp_no', 'sp_sales', 'sp_mitra', 'sp_divisi', 'sp_date', DB::raw('@rownum := @rownum + 1 as number'))
            ->groupBy('sp_no')
            ->get();

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->sp_date = Carbon::parse($data[$i]->sp_date)->format('d/m/Y');
      }

      $list = collect($data);

      return Datatables::of($list)
          ->editColumn('status', function ($list) {
              if ($list->sd_qty > $list->sd_use) {
                  return '<div class="text-center"><span class="badge badge-warning ">Belum Lengkap</span></div>';
              } else {
                  return '<div class="text-center"><span class="badge badge-primary ">Lengkap</span></div>';
              }
          })
          ->editColumn('action', function($list){
              if ($list->sd_qty > $list->sd_use) {
                return '<div align="center"> <button type="button" class="btn btn-info btn-xs" title="Lanjutkan" onclick="lanjutkan('.$list->sp_sales.','.$list->sp_mitra.','.$list->sp_divisi.')"> <i class="fa fa-sign-in"></i> </div>';
              } else {
                return '<div align="center">
                        <button type="button" class="btn btn-info btn-xs" title="Detail" onclick="detail('.$list->sp_sales.','.$list->sp_mitra.','.$list->sp_divisi.')"> <i class="fa fa-folder"></i>
                        </div>';
              }
          })
          ->make(true);
    }

    public function lanjutkan(Request $request){
      $notasales = DB::table('d_sales')
                    ->where('s_id', $request->sales)
                    ->first();

      $mitraselected = $request->mitra;

      $data = DB::table('d_mitra_pekerja')
                  ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
                  ->where('mp_mitra', $request->mitra)
                  ->where('mp_divisi', $request->divisi)
                  ->where('mp_status', 'Aktif')
                  ->where('mp_isapproved', 'Y')
                  ->select('p_id', 'p_name')
                  ->get();

      $sales = [];
      for ($i=0; $i < count($data); $i++) {
        $sales[] = DB::table('d_seragam_pekerja')
                      ->where('sp_sales', $request->sales)
                      ->where('sp_pekerja', $data[$i]->p_id)
                      ->where('sp_mitra', $request->mitra)
                      ->where('sp_divisi', $request->divisi)
                      ->get();
      }

      $perwita = new perwitaController;

      if ($perwita->getComp()[0] == 'internal') {
        $mitra = DB::table('d_mitra')
                    ->get();
      } elseif ($perwita->getComp()[0] == 'mitra') {
        $mitra = DB::table('d_mitra')
                  ->where('m_id', $perwita->getComp()[2])
                  ->get();
      }

      $divisi = DB::table('d_mitra_divisi')
                    ->where('md_id', $request->divisi)
                    ->first();

        $salesreceived = DB::table('d_sales_received')
                  ->join('d_item', 'i_id', '=', 'sr_item')
                  ->join('d_item_dt', function($e){
                    $e->on('id_item', '=', 'sr_item')
                      ->on('id_detailid', '=', 'sr_item_dt');
                  })
                  ->join('d_kategori', 'k_id', '=', 'i_kategori')
                  ->join('d_size', 'd_size.s_id', '=', 'id_size')
                  ->select('s_nama', 'k_nama', 'i_nama', 'i_warna', 'sr_sales', 'sr_detailid', 'sr_item', 'sr_item_dt', DB::raw('sum(sr_qty) as sr_qty'))
                  ->where('sr_sales', $request->sales)
                  ->where('sr_isapproved', 'Y')
                  ->groupBy('sr_item_dt')
                  ->get();

        $jenis = DB::table('d_sales_received')
                      ->join('d_item', 'i_id', '=', 'sr_item')
                      ->join('d_kategori', 'k_id', '=', 'i_kategori')
                      ->where('sr_sales', $request->sales)
                      ->where('sr_isapproved', 'Y')
                      ->select('k_nama', 'k_id', 'i_id', 'i_nama', 'i_warna')
                      ->groupBy('i_kategori')
                      ->get();

      return view('pembagianseragam.lanjutkan', compact('salesreceived', 'jenis', 'notasales', 'mitraselected', 'divisi', 'data', 'sales', 'mitra'));
    }

    public function detail(Request $request){
      $data = DB::table('d_seragam_pekerja')
                  ->join('d_pekerja', 'p_id', '=', 'sp_pekerja')
                  ->join('d_mitra', 'm_id', '=', 'sp_mitra')
                  ->join('d_mitra_divisi', function($e){
                    $e->on('md_mitra', '=', 'sp_mitra')
                      ->on('md_id', '=', 'sp_divisi');
                  })
                  ->join('d_item', 'i_id', '=', 'sp_item')
                  ->join('d_item_dt', function($e){
                    $e->on('id_item', '=', 'sp_item')
                      ->on('id_detailid', '=', 'sp_item_dt');
                  })
                  ->join('d_kategori', 'k_id', '=', 'i_kategori')
                  ->join('d_size', 'd_size.s_id', '=', 'id_size')
                  ->where('sp_sales', $request->sales)
                  ->where('sp_mitra', $request->mitra)
                  ->where('sp_divisi', $request->divisi)
                  ->get();

      return response()->json($data);
    }
}
