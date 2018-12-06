<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

use Session;

class approvallphkController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_phk')
            ->join('d_pekerja', 'd_pekerja.p_id', '=', 'd_phk.p_pekerja')
            ->select('d_pekerja.p_name', 'd_phk.p_id', 'd_phk.p_no', 'd_phk.p_date', 'd_phk.p_keterangan', 'd_pekerja.p_jabatan')
            ->where('d_phk.p_isapproved', 'P')
            ->get();

          for ($i=0; $i < count($data); $i++) {
            $jabatan = DB::table('d_jabatan_pelamar')
                    ->where('jp_id', $data[$i]->p_jabatan)
                    ->get();

            if (count($jabatan) > 0) {
              $data[$i]->p_jabatan = $jabatan[$i]->jp_name;
            } else {
              $data[$i]->p_jabatan = '-';
            }
          }

          $count = DB::table('d_phk')
                  ->where('p_isapproved', 'P')
                  ->get();

                  DB::table('d_notifikasi')
                    ->where('n_fitur', 'PHK')
                    ->update([
                        'n_qty' => count($count)
                    ]);

      return view('approvalphk.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

        $data = DB::table('d_phk')
              ->join('d_mitra_pekerja', function($e){
                $e->on('mp_pekerja', '=', 'p_pekerja')
                  ->on('mp_contract', '=', 'p_contract')
                  ->on('mp_id', '=', 'p_contract_detailid');
              })
              ->where('p_id', $request->id)
              ->get();

        $detailid = DB::table('d_pekerja_mutation')
                ->where('pm_pekerja', $data[0]->p_pekerja)
                ->max('pm_detailid');

        DB::table('d_phk')
              ->where('p_id', $request->id)
              ->update([
                'p_isapproved' => 'Y'
              ]);

        DB::table('d_mitra_pekerja')
            ->where('mp_contract', $data[0]->p_contract)
            ->where('mp_id', $data[0]->p_contract_detailid)
            ->update([
              'mp_status' => 'Tidak'
            ]);

        DB::table('d_pekerja_mutation')
            ->insert([
              'pm_pekerja' => $data[0]->p_pekerja,
              'pm_detailid' => $detailid + 1,
              'pm_date' => Carbon::now('Asia/Jakarta'),
              'pm_mitra' => $data[0]->mp_mitra,
              'pm_divisi' => $data[0]->mp_divisi,
              'pm_detail' => $data[0]->p_keterangan,
              'pm_status' => 'Ex',
              'pm_note' => $data[0]->p_keterangan,
              'pm_insert_by' => Session::get('mem'),
              'pm_reff' => $data[0]->p_no
            ]);

            $count = DB::table('d_phk')
                    ->where('p_isapproved', 'P')
                    ->get();

                    DB::table('d_notifikasi')
                      ->where('n_fitur', 'PHK')
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

        $data = DB::table('d_phk')
              ->join('d_mitra_pekerja', function($e){
                $e->on('mp_pekerja', '=', 'p_pekerja')
                  ->on('mp_contract', '=', 'p_contract')
                  ->on('mp_id', '=', 'p_contract_detailid');
              })
              ->whereIn('p_id', $request->pilih)
              ->get();

              DB::table('d_phk')
                    ->whereIn('p_id', $request->pilih)
                    ->update([
                      'p_isapproved' => 'Y'
                    ]);

        for ($i=0; $i < count($data); $i++) {
          $detailid = DB::table('d_pekerja_mutation')
                  ->where('pm_pekerja', $data[$i]->p_pekerja)
                  ->max('pm_detailid');

          DB::table('d_mitra_pekerja')
              ->where('mp_contract', $data[$i]->p_contract)
              ->where('mp_id', $data[$i]->p_contract_detailid)
              ->update([
                'mp_status' => 'Tidak'
              ]);

          DB::table('d_pekerja_mutation')
              ->insert([
                'pm_pekerja' => $data[$i]->p_pekerja,
                'pm_detailid' => $detailid + 1,
                'pm_date' => Carbon::now('Asia/Jakarta'),
                'pm_mitra' => $data[$i]->mp_mitra,
                'pm_divisi' => $data[$i]->mp_divisi,
                'pm_detail' => $data[0]->p_keterangan,
                'pm_status' => 'Ex',
                'pm_note' => $data[$i]->p_keterangan,
                'pm_insert_by' => Session::get('mem'),
                'pm_reff' => $data[$i]->p_no
              ]);
        }

        $count = DB::table('d_phk')
                ->where('p_isapproved', 'P')
                ->get();

                DB::table('d_notifikasi')
                  ->where('n_fitur', 'PHK')
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

        DB::table('d_phk')
            ->where('p_id', $request->id)
            ->update([
              'p_isapproved' => 'N'
            ]);

            $count = DB::table('d_phk')
                    ->where('p_isapproved', 'P')
                    ->get();

                    DB::table('d_notifikasi')
                      ->where('n_fitur', 'PHK')
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

        DB::table('d_phk')
            ->whereIn('p_id', $request->pilih)
            ->update([
              'p_isapproved' => 'N'
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
