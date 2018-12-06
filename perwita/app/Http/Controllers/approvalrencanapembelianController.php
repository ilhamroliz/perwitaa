<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Http\Controllers\AksesUser;

class approvalrencanapembelianController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

    $data = DB::select('select m_name, d_purchase_planning.*, sum(ppd_qty) as jumlah from d_purchase_planning inner join d_purchase_planning_dt on ppd_purchase_planning = pp_id inner join d_item on i_id = ppd_item inner join d_item_dt on ppd_item = id_item and ppd_item_dt = id_detailid inner join d_size on s_id = id_size inner join d_mem on pp_mem = m_id and pp_isapproved = "P" group by pp_id');

    $count = DB::table('d_purchase_planning')
            ->where('pp_isapproved', 'P')
            ->get();

    DB::table('d_notifikasi')
        ->where('n_fitur', 'Rencana Pembelian')
        ->update([
          'n_qty' => count($count)
        ]);

    return view('approvalrencanapembelian.index', compact('data'));

    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_purchase_planning')
            ->where('pp_id', $request->id)
            ->update([
              'pp_isapproved' => 'Y'
            ]);

        $count = DB::table('d_purchase_planning')
                ->where('pp_isapproved', 'P')
                ->get();

        DB::table('d_notifikasi')
            ->where('n_fitur', 'Rencana Pembelian')
            ->update([
              'n_qty' => count($count)
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

    public function tolak(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_purchase_planning')
            ->where('pp_id', $request->id)
            ->update([
              'pp_isapproved' => 'N'
            ]);

        $count = DB::table('d_purchase_planning')
                ->where('pp_isapproved', 'P')
                ->get();

        DB::table('d_notifikasi')
            ->where('n_fitur', 'Rencana Pembelian')
            ->update([
              'n_qty' => count($count)
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

    public function tolaklist(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_purchase_planning')
            ->whereIn('pp_id', $request->pilih)
            ->update([
              'pp_isapproved' => 'N'
            ]);

      $count = DB::table('d_purchase_planning')
              ->where('pp_isapproved', 'P')
              ->get();

      DB::table('d_notifikasi')
          ->where('n_fitur', 'Rencana Pembelian')
          ->update([
            'n_qty' => count($count)
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

    public function setujuilist(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_purchase_planning')
            ->whereIn('pp_id', $request->pilih)
            ->update([
              'pp_isapproved' => 'Y'
            ]);

      $count = DB::table('d_purchase_planning')
              ->where('pp_isapproved', 'P')
              ->get();

      DB::table('d_notifikasi')
          ->where('n_fitur', 'Rencana Pembelian')
          ->update([
            'n_qty' => count($count)
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
