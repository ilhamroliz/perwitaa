<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

use App\d_pekerja_mutation;

use App\Http\Controllers\AksesUser;

class approvalremunerasiController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_remunerasi')
          ->join('d_pekerja', 'p_id', '=', 'r_pekerja')
          ->leftjoin('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
          ->select('r_no', 'p_name', 'jp_name', 'r_awal', 'r_terbaru', 'r_note', 'r_id')
          ->where('r_isapproved', 'P')
          ->get();

          $count = DB::table('d_remunerasi')
                ->where('r_isapproved', 'P')
              ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Remunerasi')
              ->update([
                'n_qty' => count($count)
              ]);

      return view('approvalremunerasi.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {
        DB::table('d_remunerasi')
          ->where('r_id',$request->id)
          ->update([
            'r_isapproved' => 'Y'
          ]);

        $pekerja = DB::table('d_remunerasi')
              ->where('r_id', $request->id)
              ->get();

        $detailid = DB::table('d_pekerja_mutation')
              ->select('pm_detailid')
              ->where('pm_pekerja', $pekerja[0]->r_pekerja)
              ->max('pm_detailid');

        $mitra = DB::table('d_mitra_pekerja')
              ->select('mp_mitra', 'mp_divisi')
              ->where('mp_pekerja', $pekerja[0]->r_pekerja)
              ->get();

        d_pekerja_mutation::insert([
          'pm_pekerja' => $pekerja[0]->r_pekerja,
          'pm_detailid' => $detailid + 1,
          'pm_mitra' => $mitra[0]->mp_mitra,
          'pm_divisi' => $mitra[0]->mp_divisi,
          'pm_detail' => 'Remunerasi',
          'pm_status' => 'Aktif',
          'pm_note' => $pekerja[0]->r_note,
          'pm_insert_by' => Session::get('mem'),
          'pm_reff' => $pekerja[0]->r_no
        ]);

        $count = DB::table('d_remunerasi')
              ->where('r_isapproved', 'P')
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
        DB::table('d_remunerasi')
          ->where('r_id',$request->id)
          ->update([
            'r_isapproved' => 'N'
          ]);

          $count = DB::table('d_remunerasi')
                ->where('r_isapproved', 'P')
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
        DB::table('d_remunerasi')
          ->whereIn('r_id', $request->pilih)
          ->update(['r_isapproved' => 'Y']);

          $pekerja = DB::table('d_remunerasi')
                  ->whereIn('r_id', $request->pilih)
                  ->select('r_pekerja')
                  ->get();

          $note = DB::table('d_remunerasi')
                ->whereIn('r_id', $request->pilih)
                ->select('r_note')
                ->get();

          for ($i=0; $i < count($pekerja); $i++) {
            $detailid = DB::table('d_pekerja_mutation')
                    ->where('pm_pekerja', '=', $pekerja[$i]->r_pekerja)
                    ->max('pm_detailid');

            $detailid = $detailid + 1;

            $mitra = DB::table('d_pekerja_mutation')
                   ->select('pm_mitra', 'pm_divisi')
                   ->where('pm_detailid', $detailid[$i])
                   ->where('pm_pekerja', $pekerja[$i]->r_pekerja)
                   ->get();

            $mitra = DB::table('d_mitra_pekerja')
                    ->select('mp_mitra', 'mp_divisi')
                    ->where('mp_status', '=', 'Aktif')
                    ->where('mp_isapproved', '=', 'Y')
                    ->where('mp_pekerja', '=', $pekerja[$i]->r_pekerja)
                    ->get();

            $r_no = DB::table('d_remunerasi')
                  ->select('r_no')
                  ->whereIn('r_id', $request->pilih)
                  ->get();


            d_pekerja_mutation::insert([
              'pm_pekerja' => $pekerja[$i]->r_pekerja,
              'pm_detailid' => $detailid + $i,
              'pm_mitra' => $mitra[0]->mp_mitra,
              'pm_divisi' => $mitra[0]->mp_divisi,
              'pm_detail' => 'Remunerasi',
              'pm_status' => 'Aktif',
              'pm_note' => $note[$i]->r_note,
              'pm_insert_by' => Session::get('mem'),
              'pm_reff' => $r_no[$i]->r_no
            ]);
          }

          $count = DB::table('d_remunerasi')
                ->where('r_isapproved', 'P')
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

    public function tolaklist(Request $request){
      DB::beginTransaction();
      try {
        DB::table('d_remunerasi')
          ->whereIn('r_id', $request->pilih)
          ->update(['r_isapproved' => 'N']);

          $count = DB::table('d_remunerasi')
                ->where('r_isapproved', 'P')
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
}
