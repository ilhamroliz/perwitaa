<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use App\d_pekerja_mutation;

use App\d_pekerja;

use Session;

class approvalpromosiController extends Controller
{
    public function index(){

      $data = DB::table('d_pekerja')
      ->leftJoin('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan_lamaran')
      ->join('d_promosi_demosi', 'd_promosi_demosi.pd_pekerja', '=', 'd_pekerja.p_id')
      ->leftJoin('d_mitra_pekerja', function ($e){
          $e->on('mp_pekerja', '=', 'p_id');
      })
      ->leftJoin('d_mitra', 'm_id', '=', 'mp_mitra')
      ->leftJoin('d_mitra_divisi', function ($q){
          $q->on('md_mitra', '=', 'mp_mitra');
          $q->on('md_id', '=', 'mp_divisi');
          $q->on('md_mitra', '=', 'm_id');
      })
      ->select('pd_id', 'p_id', 'p_name', 'jp_name', 'p_nip', 'p_nip_mitra', 'd_mitra.m_name', 'd_mitra_divisi.md_name', 'pd_no')
      ->where('pd_isapproved', 'P')
      ->groupBy('p_id')
      ->get();

      return view('approvalpromosi.index', compact('data'));

    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_promosi_demosi')
            ->where('pd_id',$request->id)
            ->update([
              'pd_isapproved' => 'Y'
            ]);

            $pc = new promosiController;

            print $pc->approvePromosi($request->pd_no);

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
        DB::table('d_promosi_demosi')
            ->where('pd_id',$request->id)
            ->update([
              'pd_isapproved' => 'N'
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
            DB::table('d_promosi_demosi')
                ->whereIn('pd_id',$request->pilih)
                ->update([
                  'pd_isapproved' => 'Y'
                ]);


            $data = DB::table('d_promosi_demosi')
                ->whereIn('pd_id',$request->pilih)
                ->get();


            for ($i=0; $i < count($data); $i++) {
              $pekerja[] = $data[$i]->pd_pekerja;
              $jabatan[] = $data[$i]->pd_jabatan_sekarang;
            }

            $sekarang = Carbon::now('Asia/Jakarta');

            for ($i=0; $i < count($data); $i++) {
              $detailid[] = DB::table('d_pekerja_mutation')
                  ->selectRaw('pm_detailid')
                  ->where('pm_pekerja', $pekerja[$i])
                  ->max('pm_detailid');
            }

            for ($i=0; $i < count($data); $i++) {
              $status[] = DB::table('d_pekerja_mutation')
                      ->select('pm_status')
                      ->where('pm_pekerja',$pekerja[$i])
                      ->where('pm_detailid',$detailid[$i])
                      ->get();
            }


            $info = DB::table('d_mitra_pekerja')
                ->select(DB::raw('coalesce(mp_mitra, null) as mitra'), DB::raw('coalesce(mp_divisi, null) as divisi'))
                ->where('mp_status', '=', 'Aktif')
                ->whereIn('mp_pekerja', $pekerja)
                ->get();

            for ($i=0; $i < count($data); $i++) {
              d_pekerja_mutation::insert(array(
                  'pm_pekerja' => $pekerja[$i],
                  'pm_detailid' => $detailid[$i] + 1,
                  'pm_date' => $sekarang,
                  'pm_mitra' => $info[$i]->mitra,
                  'pm_divisi' => $info[$i]->divisi,
                  'pm_detail' => 'Promosi',
                  'pm_status' => $status[$i][0]->pm_status,
                  'pm_note' => $data[$i]->pd_note,
                  'pm_insert_by' => Session::get('mem')
              ));
            }

            for ($i=0; $i < count($data); $i++) {
            d_pekerja::where('p_id', '=', $pekerja[$i])
                ->update([
                    'p_jabatan' => $jabatan[$i]
                ]);
              }


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
