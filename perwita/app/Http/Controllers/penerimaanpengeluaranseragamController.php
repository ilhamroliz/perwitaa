<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use Session;

class penerimaanpengeluaranseragamController extends Controller
{
    public function index(){
      $perwita = new perwitaController;

      if ($perwita->getComp()[0] == 'internal') {
        $data = DB::table('d_sales')
                    ->get();
      } elseif ($perwita->getComp()[0] == 'mitra') {
        $data = DB::table('d_sales')
                  ->where('s_member', $perwita->getComp()[2])
                  ->get();
      }

      return view('penerimaanpengeluaranseragam.index', compact('data'));
    }

    public function cari(Request $request){
      $data = DB::table('d_sales')
                  ->join('d_sales_dt', 'sd_sales', '=', 'd_sales.s_id')
                  ->join('d_item', 'i_id', '=', 'sd_item')
                  ->join('d_item_dt', function($e){
                    $e->on('id_item', '=', 'i_id')
                      ->on('id_detailid', '=', 'sd_item_dt');
                  })
                  ->join('d_kategori', 'k_id', '=', 'i_kategori')
                  ->join('d_size', 'd_size.s_id', '=', 'id_size')
                  ->select('k_nama', 'i_nama', 's_nama', 'sd_qty', 'd_sales.s_id', 'sd_item', 'sd_item_dt', DB::raw('sd_qty as sisa'))
                  ->where('s_nota', $request->nota)
                  ->get();

      $sales = [];
      for ($i=0; $i < count($data); $i++) {
        $sales[$i] = DB::table('d_sales_received')
                      ->select(DB::raw("sum(sr_qty) as jumlahditerima"), 'd_sales_received.*')
                      ->where('sr_sales', $data[$i]->s_id)
                      ->where('sr_item', $data[$i]->sd_item)
                      ->where('sr_item_dt', $data[$i]->sd_item_dt)
                      ->where('sr_isapproved', 'Y')
                      ->get();
      }

      for ($i=0; $i < count($data); $i++) {
        if ($data[$i]->s_id == $sales[$i][0]->sr_sales && $data[$i]->sd_item == $sales[$i][0]->sr_item && $data[$i]->sd_item_dt == $sales[$i][0]->sr_item_dt) {
          $data[$i]->sisa = $data[$i]->sd_qty - $sales[$i][0]->jumlahditerima;
        }
      }

      return response()->json($data);
    }

    public function simpan(Request $request){
      DB::beginTransaction();
      try {

        $received = DB::table('d_sales_received')
                    ->where('sr_sales', $request->s_id)
                    ->where('sr_item', $request->sd_item)
                    ->where('sr_item_dt', $request->sd_item_dt)
                    ->sum('sr_qty');

        $sales = DB::table('d_sales_dt')
                    ->where('sd_sales', $request->s_id)
                    ->where('sd_item', $request->sd_item)
                    ->where('sd_item_dt', $request->sd_item_dt)
                    ->first();

        $id = DB::table('d_sales_received')
                  ->max('sr_detailid');

        if ($id == null) {
          $id = 1;
        } else {
          $id += 1;
        }

        DB::table('d_sales_received')
            ->insert([
              'sr_sales' => $request->s_id,
              'sr_detailid' => $id,
              'sr_date' => Carbon::now('Asia/Jakarta'),
              'sr_item' => $request->sd_item,
              'sr_item_dt' => $request->sd_item_dt,
              'sr_qty' => $request->qty,
              'sr_penerima' => Session::get('mem')
            ]);

        $count = DB::table('d_sales_received')
                    ->where('sr_isapproved', 'P')
                    ->count();

        DB::table('d_notifikasi')
              ->where('n_fitur', 'Penerimaan Pengeluaran Seragam')
              ->update([
                'n_qty' => $count
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
}
