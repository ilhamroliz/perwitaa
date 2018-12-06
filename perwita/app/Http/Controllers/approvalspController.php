<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\d_pekerja_mutation;

use Session;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

use Auth;

class approvalspController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_mitra_pekerja')
          ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
          ->join('d_surat_pringatan', 'sp_pekerja', '=', 'p_id')
          ->join('d_mitra', 'm_id', '=', 'mp_mitra')
          ->join('d_mitra_divisi', function($e){
                $e->on('m_id', '=', 'md_mitra');
                $e->on('mp_divisi', '=', 'md_id');
          })
          ->select('sp_id','sp_no','p_name','md_name','sp_date_start','sp_date_end','sp_note','sp_isapproved', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
          ->where('sp_isapproved', 'P')
          ->get();

    for ($i=0; $i < count($data); $i++) {
      $data[$i]->sp_date_start = Carbon::Parse($data[$i]->sp_date_start)->format('d/m/Y');
      $data[$i]->sp_date_start = Carbon::Parse($data[$i]->sp_date_end)->format('d/m/Y');
    }

    $count = DB::table('d_surat_pringatan')
          ->where('sp_isapproved', 'P')
          ->get();

    DB::table('d_notifikasi')
        ->where('n_fitur', 'Surat Peringatan')
        ->update([
          'n_qty' => count($count)
        ]);


      return view('approvalsp.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {
        DB::table('d_surat_pringatan')
            ->where('sp_id',$request->id)
            ->update([
              'sp_isapproved' => 'Y',
              'sp_approve_by' => Auth::user()->m_name
            ]);

          $id = DB::table('d_surat_pringatan')
              ->where('sp_id',$request->id)
              ->select('sp_pekerja', 'sp_jenis')
              ->get();

            $iddivisi = DB::table('d_mitra_pekerja')
                      ->select('mp_divisi')
                      ->where('mp_pekerja',$id[0]->sp_pekerja)
                      ->get();

            $idmitra = DB::table('d_mitra_pekerja')
                      ->select('mp_mitra')
                      ->where('mp_pekerja',$id[0]->sp_pekerja)
                      ->get();

            $pm_detailid = DB::table('d_pekerja_mutation')
                      ->select('pm_detailid')
                      ->where('pm_pekerja',$id[0]->sp_pekerja)
                      ->MAX('pm_detailid');

            $nosp = DB::table('d_surat_pringatan')
                  ->where('sp_id', $request->id)
                  ->select('sp_no', 'sp_note')
                  ->get();

            d_pekerja_mutation::insert([
              'pm_pekerja' => $id[0]->sp_pekerja,
              'pm_detailid' => $pm_detailid + 1,
              'pm_mitra' => $idmitra[0]->mp_mitra,
              'pm_divisi' => $iddivisi[0]->mp_divisi,
              'pm_detail' => $id[0]->sp_jenis,
              'pm_status' => 'Aktif',
              'pm_note' => $nosp[0]->sp_note,
              'pm_insert_by' => Session::get('mem'),
              'pm_reff' => $nosp[0]->sp_no
            ]);

            $count = DB::table('d_surat_pringatan')
                  ->where('sp_isapproved', 'P')
                  ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', 'Surat Peringatan')
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
        DB::table('d_surat_pringatan')
            ->where('sp_id',$request->id)
            ->update([
              'sp_isapproved' => 'N'
            ]);

            $count = DB::table('d_surat_pringatan')
                  ->where('sp_isapproved', 'P')
                  ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', 'Surat Peringatan')
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
          DB::table('d_surat_pringatan')
              ->where('sp_id',$request->pilih[$i])
              ->update([
                'sp_isapproved' => 'Y',
                'sp_approve_by' => Auth::user()->m_name
              ]);
        }

        $id = DB::table('d_surat_pringatan')
            ->whereIn('sp_id',$request->pilih)
            ->select('sp_pekerja', 'sp_jenis')
            ->get();

        for ($i=0; $i < count($id); $i++) {

          $iddivisi = DB::table('d_mitra_pekerja')
                    ->select('mp_divisi')
                    ->where('mp_pekerja',$id[$i]->sp_pekerja)
                    ->get();

          $idmitra = DB::table('d_mitra_pekerja')
                    ->select('mp_mitra')
                    ->where('mp_pekerja',$id[$i]->sp_pekerja)
                    ->get();

          $pm_detailid = DB::table('d_pekerja_mutation')
                    ->select('pm_detailid')
                    ->where('pm_pekerja',$id[$i]->sp_pekerja)
                    ->MAX('pm_detailid');

          $nosp = DB::table('d_surat_pringatan')
                ->whereIn('sp_id', $request->pilih)
                ->select('sp_no', 'sp_note')
                ->get();


          d_pekerja_mutation::insert([
            'pm_pekerja' => $id[$i]->sp_pekerja,
            'pm_detailid' => $pm_detailid + 1,
            'pm_mitra' => $idmitra[0]->mp_mitra,
            'pm_divisi' => $iddivisi[0]->mp_divisi,
            'pm_detail' => $id[$i]->sp_jenis,
            'pm_status' => 'Aktif',
            'pm_note' => $nosp[$i]->sp_note,
            'pm_insert_by' => Session::get('mem'),
            'pm_reff' => $nosp[$i]->sp_no
          ]);

        }

        $count = DB::table('d_surat_pringatan')
              ->where('sp_isapproved', 'P')
              ->get();

        DB::table('d_notifikasi')
            ->where('n_fitur', 'Surat Peringatan')
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
        for ($i=0; $i < count($request->pilih); $i++) {
          DB::table('d_surat_pringatan')
              ->where('sp_id',$request->pilih[$i])
              ->update([
                'sp_isapproved' => 'N'
              ]);
        }

        $count = DB::table('d_surat_pringatan')
              ->where('sp_isapproved', 'P')
              ->get();

        DB::table('d_notifikasi')
            ->where('n_fitur', 'Surat Peringatan')
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

    public function detail(Request $request){
      $id = $request->id;

      $data = DB::table('d_mitra_pekerja')
          ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
          ->join('d_surat_pringatan', 'sp_pekerja', '=', 'p_id')
          ->join('d_mitra', 'm_id', '=', 'mp_mitra')
          ->join('d_mitra_divisi', function($e){
                $e->on('m_id', '=', 'md_mitra');
                $e->on('mp_divisi', '=', 'md_id');
          })
          ->select('sp_no','p_name','md_name','sp_date_start','sp_date_end','sp_note','sp_isapproved', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
          ->where('sp_id',$id)
          ->get();

      $data[0]->sp_date_start = Carbon::parse($data[0]->sp_date_start)->format('d/m/Y');
      $data[0]->sp_date_end = Carbon::parse($data[0]->sp_date_end)->format('d/m/Y');

      return response()->json($data);
    }

    public function print(Request $request){
      $data = DB::table('d_mitra_pekerja')
          ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
          ->join('d_surat_pringatan', 'sp_pekerja', '=', 'p_id')
          ->join('d_mitra', 'm_id', '=', 'mp_mitra')
          ->join('d_surat_pringatan_dt', 'spd_surat_peringatan', '=', 'sp_id')
          ->join('d_mitra_divisi', function($e){
                $e->on('m_id', '=', 'md_mitra');
                $e->on('mp_divisi', '=', 'md_id');
          })
          ->select('sp_no','p_name','md_name','sp_date_start','sp_date_end','sp_note','sp_isapproved','sp_jenis', 'spd_pelanggaran', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
          ->where('sp_id',$request->id)
          ->get();

      if (empty($data[0]->sp_date_start)) {

      } else {
        $data[0]->sp_date_start = Carbon::parse($data[0]->sp_date_start)->format('d/m/Y');
      }

      if (empty($data[0]->sp_date_end)) {

      } else {
        $data[0]->sp_date_end = Carbon::parse($data[0]->sp_date_end)->format('d/m/Y');
      }

      return view('approvalsp.print', compact('data'));
    }

}
