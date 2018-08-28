<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class approvalpegawaiController extends Controller
{
    public function index(){
      $data = DB::table('d_pegawai')
            ->where('p_status_approval', null)
            ->get();

            $count = DB::table('d_pegawai')
                    ->where('p_status_approval', null)
                    ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', 'Pegawai')
                ->update([
                  'n_qty' => count($count)
                ]);

      return view('approvalpegawai.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_pegawai')
          ->where('p_id', $request->id)
          ->update([
            'p_status_approval' => 'Y'
          ]);

          $count = DB::table('d_pegawai')
                  ->where('p_status_approval', null)
                  ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Pegawai')
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

        DB::table('d_pegawai')
          ->where('p_id', $request->id)
          ->update([
            'p_status_approval' => 'N'
          ]);

          $count = DB::table('d_pegawai')
                  ->where('p_status_approval', null)
                  ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Pegawai')
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

        DB::table('d_pegawai')
          ->whereIn('p_id', $request->pilih)
          ->update([
            'p_status_approval' => 'Y'
          ]);

          $count = DB::table('d_pegawai')
                  ->where('p_status_approval', null)
                  ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Pegawai')
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

        DB::table('d_pegawai')
          ->whereIn('p_id', $request->pilih)
          ->update([
            'p_status_approval' => 'N'
          ]);

          $count = DB::table('d_pegawai')
                  ->where('p_status_approval', null)
                  ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Pegawai')
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
