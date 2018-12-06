<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

use Session;

class approvalpegawaiphkController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_pegawai_phk')
            ->join('d_pegawai', 'd_pegawai.p_id', '=', 'd_pegawai_phk.pp_pekerja')
            ->leftjoin('d_jabatan', 'j_id', '=' , 'd_pegawai.p_jabatan')
            ->select('d_pegawai.p_name', 'j_name', 'd_pegawai_phk.pp_id', 'd_pegawai_phk.pp_no', 'd_pegawai_phk.pp_date', 'd_pegawai_phk.pp_keterangan', 'd_pegawai.p_jabatan')
            ->where('d_pegawai_phk.pp_isapproved', 'P')
            ->get();

          $count = DB::table('d_phk')
                  ->where('p_isapproved', 'P')
                  ->get();

                  DB::table('d_notifikasi')
                    ->where('n_fitur', 'PHK')
                    ->update([
                        'n_qty' => count($count)
                    ]);

      return view('approvalpegawaiphk.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

        $data = DB::table('d_pegawai_phk')
              ->where('pp_id', $request->id)
              ->get();

        $detailid = DB::table('d_pegawai_mutation')
                ->where('pm_pegawai', $data[0]->pp_pekerja)
                ->max('pm_detailid');

        DB::table('d_pegawai_phk')
              ->where('pp_id', $request->id)
              ->update([
                'pp_isapproved' => 'Y'
              ]);

        DB::table('d_pegawai_mutation')
            ->insert([
              'pm_pegawai' => $data[0]->pp_pekerja,
              'pm_detailid' => $detailid + 1,
              'pm_date' => Carbon::now('Asia/Jakarta'),
              'pm_detail' => $data[0]->pp_keterangan,
              'pm_status' => 'Ex',
              'pm_note' => $data[0]->pp_keterangan,
              'pm_insert_by' => Session::get('mem'),
              'pm_reff' => $data[0]->pp_no
            ]);

            $count = DB::table('d_pegawai_phk')
                    ->where('pp_isapproved', 'P')
                    ->get();

                    DB::table('d_notifikasi')
                      ->where('n_fitur', 'PHK Pegawai')
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

        $data = DB::table('d_pegawai_phk')
              ->whereIn('pp_id', $request->pilih)
              ->get();

              DB::table('d_pegawai_phk')
                    ->whereIn('pp_id', $request->pilih)
                    ->update([
                      'pp_isapproved' => 'Y'
                    ]);

        for ($i=0; $i < count($data); $i++) {
          $detailid = DB::table('d_pegawai_mutation')
                  ->where('pm_pegawai', $data[$i]->pp_pekerja)
                  ->max('pm_detailid');

          DB::table('d_pegawai_mutation')
              ->insert([
                'pm_pegawai' => $data[$i]->pp_pekerja,
                'pm_detailid' => $detailid + 1,
                'pm_date' => Carbon::now('Asia/Jakarta'),
                'pm_detail' => $data[0]->pp_keterangan,
                'pm_status' => 'Ex',
                'pm_note' => $data[$i]->pp_keterangan,
                'pm_insert_by' => Session::get('mem'),
                'pm_reff' => $data[$i]->pp_no
              ]);
        }

        $count = DB::table('d_pegawai_phk')
                ->where('pp_isapproved', 'P')
                ->get();

                DB::table('d_notifikasi')
                  ->where('n_fitur', 'PHK Pegawai')
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

        DB::table('d_pegawai_phk')
            ->where('pp_id', $request->id)
            ->update([
              'pp_isapproved' => 'N'
            ]);

            $count = DB::table('d_pegawai_phk')
                    ->where('pp_isapproved', 'P')
                    ->get();

                    DB::table('d_notifikasi')
                      ->where('n_fitur', 'PHK Pegawai')
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

        DB::table('d_pegawai_phk')
            ->whereIn('pp_id', $request->pilih)
            ->update([
              'pp_isapproved' => 'N'
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
