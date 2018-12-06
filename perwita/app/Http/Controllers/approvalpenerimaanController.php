<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\AksesUser;

use DB;

class approvalpenerimaanController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_mitra_contract')
            ->join('d_mitra', 'm_id', '=', 'mc_mitra')
            ->join('d_mitra_divisi', 'md_id', '=', 'mc_divisi')
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'mc_jabatan')
            ->select('m_name', 'md_name', 'jp_name', 'mc_no', 'mc_need', 'mc_fulfilled', 'mc_contractid', 'mc_mitra', 'mc_divisi')
            ->where('mc_isapproved', 'P')
            ->get();

            $count = DB::table('d_mitra_contract')
                ->where('mc_isapproved', 'P')
                ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', 'Permintaan Pekerja')
                ->update([
                  'n_qty' => count($count)
                ]);

      return view('approvalpenerimaan.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_mitra_contract')
              ->where('mc_contractid',$request->id)
              ->update([
                'mc_isapproved' => 'Y'
              ]);

              $count = DB::table('d_mitra_contract')
                  ->where('mc_isapproved', 'P')
                  ->get();

              DB::table('d_notifikasi')
                  ->where('n_fitur', 'Permintaan Pekerja')
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

        DB::table('d_mitra_contract')
              ->where('mc_contractid',$request->id)
              ->update([
                'mc_isapproved' => 'N'
              ]);

              $count = DB::table('d_mitra_contract')
                  ->where('mc_isapproved', 'P')
                  ->get();

              DB::table('d_notifikasi')
                  ->where('n_fitur', 'Permintaan Pekerja')
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

          DB::table('d_mitra_contract')
            ->whereIn('mc_contractid', $request->pilih)
            ->update([
              'mc_isapproved' => 'Y'
            ]);

            $count = DB::table('d_mitra_contract')
                ->where('mc_isapproved', 'P')
                ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', 'Permintaan Pekerja')
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
        DB::table('d_mitra_contract')
          ->whereIn('mc_contractid', $request->pilih)
          ->update([
            'mc_isapproved' => 'N'
          ]);

          $count = DB::table('d_mitra_contract')
              ->where('mc_isapproved', 'P')
              ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Permintaan Pekerja')
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
