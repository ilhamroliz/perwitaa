<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use Session;

use App\Http\Controllers\AksesUser;

class approvalopnameController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_stock_opname')
          ->join('d_stock_opname_dt', 'so_id', '=', 'sod_stock_opname')
          ->join('d_item', 'i_id', '=', 'sod_item')
          ->join('d_item_dt', function ($e) {
              $e->on('id_detailid', '=', 'sod_item_dt');
              $e->on('id_item', '=', 'sod_item');
              $e->on('id_item', '=', 'i_id');
          })
          ->join('d_size', 'd_size.s_id', '=', 'id_size')
          ->select(DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'so_nota', DB::raw('date_format(so_date, "%d/%m/%Y") as so_date'), 'so_isapproved')
          ->where('so_isapproved', '=', 'P')
          ->groupBy('so_id')
          ->get();

          $count = DB::table('d_stock_opname')
              ->where('so_isapproved', 'P')
              ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Opname')
              ->update([
                'n_qty' => count($count)
              ]);

      return view('approvalopname.index', compact('data'));

    }

    public function detail(Request $request){

        $data = DB::table('d_stock_opname')
              ->join('d_stock_opname_dt', 'sod_stock_opname', '=', 'so_id')
              ->join('d_item', 'i_id', '=', 'sod_item')
              ->join('d_item_dt', function ($e) {
                  $e->on('id_detailid', '=', 'sod_item_dt');
                  $e->on('id_item', '=', 'sod_item');
                  $e->on('id_item', '=', 'i_id');
              })
              ->join('d_size', 'd_size.s_id', '=', 'id_size')
              ->where('so_nota', $request->id)
              ->select(DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'so_nota', DB::raw('date_format(so_date, "%d/%m/%Y") as so_date'), 'sod_qty_sistem', 'sod_qty_real', 'sod_aksi', 'sod_keterangan')
              ->get();

        return response()->json($data);

    }

    public function setujui(Request $request){

      DB::beginTransaction();
      try {
          $nota = $request->nota;
          $info = DB::table('d_stock_opname')
              ->join('d_stock_opname_dt', 'sod_stock_opname', '=', 'so_id')
              ->where('so_nota', '=', $nota)
              ->get();

          DB::table('d_stock_opname')
              ->where('so_nota', $request->nota)
              ->update([
                'so_isapproved' => 'Y'
              ]);

          $item = $info[0]->sod_item;
          $item_dt = $info[0]->sod_item_dt;
          $qty_sistem = $info[0]->sod_qty_sistem;
          $qty_real = $info[0]->sod_qty_real;
          $aksi = $info[0]->sod_aksi;
          $sisa = $qty_sistem - $qty_real;
          $sekarang = Carbon::now('Asia/Jakarta');

          $mutasi = DB::table('d_stock')
              ->join('d_stock_mutation', 's_id', '=', 'sm_stock')
              ->select('d_stock.*', 'd_stock_mutation.*', DB::raw('(sm_qty - sm_use) as sm_sisa'))
              ->where('s_item', '=', $item)
              ->where('s_item_dt', '=', $item_dt)
              ->where('s_comp', '=', Session::get('mem_comp'))
              ->where('sm_detail', '=', 'Pembelian')
              ->where('sm_qty', '>', 'sm_use')
              ->get();

          if ($aksi == 'real'){
              if ($sisa > 0){
                  //========= mengurangi stock
                  for ($i = 0; $i < count($mutasi); $i++){
                      if ($mutasi[$i]->sm_sisa >= $sisa){
                          DB::table('d_stock_mutation')
                              ->where('sm_stock', '=', $mutasi[$i]->sm_stock)
                              ->where('sm_detailid', '=', $mutasi[$i]->sm_detailid)
                              ->update([
                                  'sm_use' => $mutasi[$i]->sm_use + $sisa
                              ]);

                          $getdetailid = DB::table('d_stock_mutation')
                              ->where('sm_stock', '=', $mutasi[$i]->sm_stock)
                              ->max('sm_detailid');

                          $detailid = $getdetailid + 1;

                          DB::table('d_stock_mutation')
                              ->insert([
                                  'sm_stock' => $mutasi[$i]->sm_stock,
                                  'sm_detailid' => $detailid,
                                  'sm_comp' => Session::get('mem_comp'),
                                  'sm_date' => $sekarang,
                                  'sm_item' => $mutasi[$i]->sm_item,
                                  'sm_item_dt' => $mutasi[$i]->sm_item_dt,
                                  'sm_detail' => 'Pengeluaran',
                                  'sm_qty' => $sisa,
                                  'sm_use' => '0',
                                  'sm_hpp' => $mutasi[$i]->sm_hpp,
                                  'sm_sell' => $mutasi[$i]->sm_sell,
                                  'sm_nota' => $nota,
                                  'sm_delivery_order' => $mutasi[$i]->sm_nota,
                                  'sm_petugas' => Session::get('mem')
                              ]);

                          DB::table('d_stock')
                              ->where('s_id', '=', $mutasi[$i]->s_id)
                              ->update([
                                  's_qty' => DB::raw('s_qty - ' . $sisa)
                              ]);
                          $sisa = 0;
                          $i = count($mutasi);

                      } elseif ($mutasi[$i]->sm_sisa < $sisa){
                          $sisa = $sisa - $mutasi[$i]->sm_qty;
                          DB::table('d_stock_mutation')
                              ->where('sm_stock', '=', $mutasi[$i]->sm_stock)
                              ->where('sm_detailid', '=', $mutasi[$i]->sm_detailid)
                              ->update([
                                  'sm_use' => $mutasi[$i]->sm_qty
                              ]);

                          $getdetailid = DB::table('d_stock_mutation')
                              ->where('sm_stock', '=', $mutasi[$i]->sm_stock)
                              ->max('sm_detailid');

                          $detailid = $getdetailid + 1;

                          DB::table('d_stock_mutation')
                              ->insert([
                                  'sm_stock' => $mutasi[$i]->sm_stock,
                                  'sm_detailid' => $detailid,
                                  'sm_comp' => Session::get('mem_comp'),
                                  'sm_date' => $sekarang,
                                  'sm_item' => $mutasi[$i]->sm_item,
                                  'sm_item_dt' => $mutasi[$i]->sm_item_dt,
                                  'sm_detail' => 'Pengeluaran',
                                  'sm_qty' => $mutasi[$i]->sm_qty,
                                  'sm_use' => '0',
                                  'sm_hpp' => $mutasi[$i]->sm_hpp,
                                  'sm_sell' => $mutasi[$i]->sm_sell,
                                  'sm_nota' => $nota,
                                  'sm_delivery_order' => $mutasi[$i]->sm_nota,
                                  'sm_petugas' => Session::get('mem')
                              ]);

                          DB::table('d_stock')
                              ->where('s_id', '=', $mutasi[$i]->s_id)
                              ->update([
                                  's_qty' => DB::raw('(s_qty - ' . $mutasi[$i]->sm_qty. ')')
                              ]);
                      }
                  }
              } elseif ($sisa < 0){
                  //======== menambah stock
                  $sisa = abs($sisa);
                  $counter = count($mutasi) - 1;

                  $getdetailid = DB::table('d_stock_mutation')
                      ->where('sm_stock', '=', $mutasi[0]->sm_stock)
                      ->max('sm_detailid');

                  $detailid = $getdetailid + 1;

                  DB::table('d_stock_mutation')
                      ->insert([
                          'sm_stock' => $mutasi[0]->sm_stock,
                          'sm_detailid' => $detailid,
                          'sm_comp' => Session::get('mem_comp'),
                          'sm_date' => $sekarang,
                          'sm_item' => $mutasi[0]->sm_item,
                          'sm_item_dt' => $mutasi[0]->sm_item_dt,
                          'sm_detail' => 'Pembelian',
                          'sm_qty' => $sisa,
                          'sm_use' => '0',
                          'sm_hpp' => $mutasi[$counter]->sm_hpp,
                          'sm_sell' => $mutasi[$counter]->sm_sell,
                          'sm_nota' => $nota,
                          'sm_delivery_order' => $nota,
                          'sm_petugas' => Session::get('mem')
                      ]);

                  DB::table('d_stock')
                      ->where('s_id', '=', $mutasi[0]->s_id)
                      ->update([
                          's_qty' => DB::raw('(s_qty + ' . $sisa. ')')
                      ]);
              } else {
                  //======== tidak perlu ada penanganan khusus
              }
          } elseif ($aksi == 'sistem'){
              //======== tidak perlu ada penanganan khusus
          }

          $count = DB::table('d_stock_opname')
              ->where('so_isapproved', 'P')
              ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Opname')
              ->update([
                'n_qty' => count($count)
              ]);

          DB::commit();
          return response()->json([
              'status' => 'sukses'
          ]);
      } catch (\Exception $e){
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'data' => $e
          ]);
      }
    }

    public function setujuilist(Request $request){

      DB::beginTransaction();
      try {

        for ($z=0; $z < count($request->pilih); $z++) {
          $nota = $request->pilih[$z];
          $info = DB::table('d_stock_opname')
              ->join('d_stock_opname_dt', 'sod_stock_opname', '=', 'so_id')
              ->where('so_nota', '=', $nota)
              ->get();

          DB::table('d_stock_opname')
              ->where('so_nota', $nota)
              ->update([
                'so_isapproved' => 'Y'
              ]);

          $item = $info[0]->sod_item;
          $item_dt = $info[0]->sod_item_dt;
          $qty_sistem = $info[0]->sod_qty_sistem;
          $qty_real = $info[0]->sod_qty_real;
          $aksi = $info[0]->sod_aksi;
          $sisa = $qty_sistem - $qty_real;
          $sekarang = Carbon::now('Asia/Jakarta');

          $mutasi = DB::table('d_stock')
              ->join('d_stock_mutation', 's_id', '=', 'sm_stock')
              ->select('d_stock.*', 'd_stock_mutation.*', DB::raw('(sm_qty - sm_use) as sm_sisa'))
              ->where('s_item', '=', $item)
              ->where('s_item_dt', '=', $item_dt)
              ->where('s_comp', '=', Session::get('mem_comp'))
              ->where('sm_detail', '=', 'Pembelian')
              ->where('sm_qty', '>', 'sm_use')
              ->get();

          if ($aksi == 'real'){
              if ($sisa > 0){
                  //========= mengurangi stock
                  for ($i = 0; $i < count($mutasi); $i++){
                      if ($mutasi[$i]->sm_sisa >= $sisa){
                          DB::table('d_stock_mutation')
                              ->where('sm_stock', '=', $mutasi[$i]->sm_stock)
                              ->where('sm_detailid', '=', $mutasi[$i]->sm_detailid)
                              ->update([
                                  'sm_use' => $mutasi[$i]->sm_use + $sisa
                              ]);

                          $getdetailid = DB::table('d_stock_mutation')
                              ->where('sm_stock', '=', $mutasi[$i]->sm_stock)
                              ->max('sm_detailid');

                          $detailid = $getdetailid + 1;

                          DB::table('d_stock_mutation')
                              ->insert([
                                  'sm_stock' => $mutasi[$i]->sm_stock,
                                  'sm_detailid' => $detailid,
                                  'sm_comp' => Session::get('mem_comp'),
                                  'sm_date' => $sekarang,
                                  'sm_item' => $mutasi[$i]->sm_item,
                                  'sm_item_dt' => $mutasi[$i]->sm_item_dt,
                                  'sm_detail' => 'Pengeluaran',
                                  'sm_qty' => $sisa,
                                  'sm_use' => '0',
                                  'sm_hpp' => $mutasi[$i]->sm_hpp,
                                  'sm_sell' => $mutasi[$i]->sm_sell,
                                  'sm_nota' => $nota,
                                  'sm_delivery_order' => $mutasi[$i]->sm_nota,
                                  'sm_petugas' => Session::get('mem')
                              ]);

                          DB::table('d_stock')
                              ->where('s_id', '=', $mutasi[$i]->s_id)
                              ->update([
                                  's_qty' => DB::raw('s_qty - ' . $sisa)
                              ]);
                          $sisa = 0;
                          $i = count($mutasi);

                      } elseif ($mutasi[$i]->sm_sisa < $sisa){
                          $sisa = $sisa - $mutasi[$i]->sm_qty;
                          DB::table('d_stock_mutation')
                              ->where('sm_stock', '=', $mutasi[$i]->sm_stock)
                              ->where('sm_detailid', '=', $mutasi[$i]->sm_detailid)
                              ->update([
                                  'sm_use' => $mutasi[$i]->sm_qty
                              ]);

                          $getdetailid = DB::table('d_stock_mutation')
                              ->where('sm_stock', '=', $mutasi[$i]->sm_stock)
                              ->max('sm_detailid');

                          $detailid = $getdetailid + 1;

                          DB::table('d_stock_mutation')
                              ->insert([
                                  'sm_stock' => $mutasi[$i]->sm_stock,
                                  'sm_detailid' => $detailid,
                                  'sm_comp' => Session::get('mem_comp'),
                                  'sm_date' => $sekarang,
                                  'sm_item' => $mutasi[$i]->sm_item,
                                  'sm_item_dt' => $mutasi[$i]->sm_item_dt,
                                  'sm_detail' => 'Pengeluaran',
                                  'sm_qty' => $mutasi[$i]->sm_qty,
                                  'sm_use' => '0',
                                  'sm_hpp' => $mutasi[$i]->sm_hpp,
                                  'sm_sell' => $mutasi[$i]->sm_sell,
                                  'sm_nota' => $nota,
                                  'sm_delivery_order' => $mutasi[$i]->sm_nota,
                                  'sm_petugas' => Session::get('mem')
                              ]);

                          DB::table('d_stock')
                              ->where('s_id', '=', $mutasi[$i]->s_id)
                              ->update([
                                  's_qty' => DB::raw('(s_qty - ' . $mutasi[$i]->sm_qty. ')')
                              ]);
                      }
                  }
              } elseif ($sisa < 0){
                  //======== menambah stock
                  $sisa = abs($sisa);
                  $counter = count($mutasi) - 1;

                  $getdetailid = DB::table('d_stock_mutation')
                      ->where('sm_stock', '=', $mutasi[0]->sm_stock)
                      ->max('sm_detailid');

                  $detailid = $getdetailid + 1;

                  DB::table('d_stock_mutation')
                      ->insert([
                          'sm_stock' => $mutasi[0]->sm_stock,
                          'sm_detailid' => $detailid,
                          'sm_comp' => Session::get('mem_comp'),
                          'sm_date' => $sekarang,
                          'sm_item' => $mutasi[0]->sm_item,
                          'sm_item_dt' => $mutasi[0]->sm_item_dt,
                          'sm_detail' => 'Pembelian',
                          'sm_qty' => $sisa,
                          'sm_use' => '0',
                          'sm_hpp' => $mutasi[$counter]->sm_hpp,
                          'sm_sell' => $mutasi[$counter]->sm_sell,
                          'sm_nota' => $nota,
                          'sm_delivery_order' => $nota,
                          'sm_petugas' => Session::get('mem')
                      ]);

                      DB::table('d_stock')
                          ->where('s_id', '=', $mutasi[0]->s_id)
                          ->update([
                              's_qty' => DB::raw('(s_qty + ' . $sisa. ')')
                          ]);
              } else {
                  //======== tidak perlu ada penanganan khusus
              }
          } elseif ($aksi == 'sistem'){
              //======== tidak perlu ada penanganan khusus
          }

        }

        $count = DB::table('d_stock_opname')
            ->where('so_isapproved', 'P')
            ->get();

        DB::table('d_notifikasi')
            ->where('n_fitur', 'Opname')
            ->update([
              'n_qty' => count($count)
            ]);

          DB::commit();
          return response()->json([
              'status' => 'sukses'
          ]);
      } catch (\Exception $e){
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'data' => $e
          ]);
      }

    }

    public function tolak(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_stock_opname')
          ->where('so_nota', $request->id)
          ->update([
            'so_isapproved' => 'N'
          ]);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'berhasil'
        ]);
      }

    }

    public function tolaklist(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_stock_opname')
          ->whereIn('so_nota', $request->pilih)
          ->update([
            'so_isapproved' => 'N'
          ]);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'berhasil'
        ]);
      }
    }
}
