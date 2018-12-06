<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Http\Controllers\AksesUser;

class approvalpegawairemunerasiController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_pegawai_remunerasi')
          ->join('d_pegawai', 'p_id', '=', 'pr_pegawai')
          ->leftjoin('d_jabatan', 'j_id', '=', 'p_jabatan')
          ->select('pr_no', 'p_name', 'j_name', 'pr_awal', 'pr_terbaru', 'pr_note', 'pr_id')
          ->where('pr_isapproved', 'P')
          ->get();

          $count = DB::table('d_pegawai_remunerasi')
                ->where('pr_isapproved', 'P')
              ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Remunerasi Pegawai')
              ->update([
                'n_qty' => count($count)
              ]);


      return view('approvalpegawairemunerasi.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {
        DB::table('d_pegawai_remunerasi')
          ->where('pr_id',$request->id)
          ->update([
            'pr_isapproved' => 'Y'
          ]);

        $pekerja = DB::table('d_pegawai_remunerasi')
              ->where('pr_id', $request->id)
              ->get();

        $detailid = DB::table('d_pegawai_mutation')
              ->select('pm_detailid')
              ->where('pm_pegawai', $pekerja[0]->pr_pegawai)
              ->max('pm_detailid');

        d_pekerja_mutation::insert([
          'pm_pekerja' => $pekerja[0]->pr_pegawai,
          'pm_detailid' => $detailid + 1,
          'pm_detail' => 'Remunerasi',
          'pm_status' => 'Aktif',
          'pm_note' => $pekerja[0]->pr_note,
          'pm_insert_by' => Session::get('mem'),
          'pm_reff' => $pekerja[0]->pr_no
        ]);

        $count = DB::table('d_pegawai_remunerasi')
              ->where('pr_isapproved', 'P')
            ->get();

        DB::table('d_notifikasi')
            ->where('n_fitur', 'Remunerasi')
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
        DB::table('d_pegawai_remunerasi')
          ->where('pr_id',$request->id)
          ->update([
            'pr_isapproved' => 'N'
          ]);

          $count = DB::table('d_pegawai_remunerasi')
                ->where('pr_isapproved', 'P')
              ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Remunerasi')
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
        DB::table('d_pegawai_remunerasi')
          ->whereIn('pr_id', $request->pilih)
          ->update(['pr_isapproved' => 'Y']);

          $pekerja = DB::table('d_pegawai_remunerasi')
                  ->whereIn('pr_id', $request->pilih)
                  ->select('pr_pegawai')
                  ->get();

          $note = DB::table('d_pegawai_remunerasi')
                ->whereIn('pr_id', $request->pilih)
                ->select('pr_note')
                ->get();

          for ($i=0; $i < count($pekerja); $i++) {
            $detailid = DB::table('d_pekerja_mutation')
                    ->where('pm_pegawai', '=', $pekerja[$i]->pr_pegawai)
                    ->max('pm_detailid');

            $detailid = $detailid + 1;

            $mitra = DB::table('d_pegawai_mutation')
                   ->select('pm_mitra', 'pm_divisi')
                   ->where('pm_detailid', $detailid[$i])
                   ->where('pm_pegawai', $pekerja[$i]->pr_pegawai)
                   ->get();

            $r_no = DB::table('d_pegawai_remunerasi')
                  ->select('pr_no')
                  ->whereIn('pr_id', $request->pilih)
                  ->get();


            DB::table('d_pegawai_mutation')->insert([
              'pm_pegawai' => $pekerja[$i]->pr_pegawai,
              'pm_detailid' => $detailid + $i,
              'pm_detail' => 'Remunerasi',
              'pm_status' => 'Aktif',
              'pm_note' => $note[$i]->pr_note,
              'pm_insert_by' => Session::get('mem'),
              'pm_reff' => $r_no[$i]->pr_no
            ]);
          }

          $count = DB::table('d_pegawai_remunerasi')
                ->where('pr_isapproved', 'P')
              ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Remunerasi Pegawai')
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
        DB::table('d_pegawai_remunerasi')
          ->whereIn('pr_id', $request->pilih)
          ->update(['pr_isapproved' => 'N']);

          $count = DB::table('d_pegawai_remunerasi')
                ->where('pr_isapproved', 'P')
              ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Remunerasi Pegawai')
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
