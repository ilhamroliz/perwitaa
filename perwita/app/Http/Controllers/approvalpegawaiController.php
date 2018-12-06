<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Http\Controllers\AksesUser;

class approvalpegawaiController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

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
            'p_status_approval' => 'Y',
            'p_nip' => $this->getnewnota($request->id)
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
            'p_status_approval' => 'N',
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

        for ($i=0; $i < count($request->pilih); $i++) {
          $nik = $this->getnewnota($request->pilih[$i]);

          DB::table('d_pegawai')
            ->where('p_id', $request->pilih[$i])
            ->update([
              'p_status_approval' => 'Y',
              'p_nip' => $nik
            ]);

        }

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

    public function getnewnota($id){
      $tmp = ((int)$id);
      $kode = sprintf("%06s", $tmp);

      $finalkode = 'PNG-' . $kode;

      return $finalkode;
    }
}
