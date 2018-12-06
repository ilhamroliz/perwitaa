<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use App\d_pekerja_mutation;

use App\d_pekerja;

use App\Http\Controllers\AksesUser;

use Session;

use App\d_notifikasi;

class approvalpromosiController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_pekerja')
      ->join('d_promosi_demosi', 'd_promosi_demosi.pd_pekerja', '=', 'd_pekerja.p_id')
      ->join('d_mitra_pekerja', function ($e){
          $e->on('mp_pekerja', '=', 'p_id');
      })
      ->join('d_mitra', 'm_id', '=', 'mp_mitra')
      ->join('d_mitra_divisi', function ($q){
          $q->on('md_mitra', '=', 'mp_mitra');
          $q->on('md_id', '=', 'mp_divisi');
          $q->on('md_mitra', '=', 'm_id');
      })
      ->select('pd_id', 'p_id', 'p_name', 'pd_jabatan_awal', 'pd_jabatan_sekarang', 'p_nip', 'p_nip_mitra', 'd_mitra.m_name', 'd_mitra_divisi.md_name', 'pd_no')
      ->where('pd_isapproved', 'P')
      ->groupBy('pd_id')
      ->get();

      $jabatan = DB::select("select pd_pekerja, jpa.jp_name as awal, jpm.jp_name as sekarang from d_promosi_demosi
join d_jabatan_pelamar jpa on jpa.jp_id = pd_jabatan_awal
join d_jabatan_pelamar jpm on jpm.jp_id = pd_jabatan_sekarang");

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->pd_jabatan_awal = $jabatan[$i]->awal;
        $data[$i]->pd_jabatan_sekarang = $jabatan[$i]->sekarang;
      }

      $jumlah = DB::select("select count(pd_id) as jumlah from d_promosi_demosi where pd_isapproved = 'P'");
      $jumlah = $jumlah[0]->jumlah;

      d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi')
          ->where('n_detail', '=', 'Create')
          ->update([
              'n_qty' => $jumlah,
              'n_insert' => Carbon::now()
          ]);


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

            $jumlah = DB::select("select count(pd_id) as jumlah from d_promosi_demosi where pd_isapproved = 'P'");
            $jumlah = $jumlah[0]->jumlah;

            d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi')
                ->where('n_detail', '=', 'Create')
                ->update([
                    'n_qty' => $jumlah,
                    'n_insert' => Carbon::now()
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
        DB::table('d_promosi_demosi')
            ->where('pd_id',$request->id)
            ->update([
              'pd_isapproved' => 'N'
            ]);

            $jumlah = DB::select("select count(pd_id) as jumlah from d_promosi_demosi where pd_isapproved = 'P'");
            $jumlah = $jumlah[0]->jumlah;

            d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi')
                ->where('n_detail', '=', 'Create')
                ->update([
                    'n_qty' => $jumlah,
                    'n_insert' => Carbon::now()
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
                  'pm_status' => 'Aktif',
                  'pm_note' => $data[$i]->pd_note,
                  'pm_insert_by' => Session::get('mem'),
                  'pm_reff' => $data[$i]->pd_no
              ));
            }

            for ($i=0; $i < count($data); $i++) {
            d_pekerja::where('p_id', '=', $pekerja[$i])
                ->update([
                    'p_jabatan' => $jabatan[$i]
                ]);
              }

              $jumlah = DB::select("select count(pd_id) as jumlah from d_promosi_demosi where pd_isapproved = 'P'");
              $jumlah = $jumlah[0]->jumlah;

              d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi')
                  ->where('n_detail', '=', 'Create')
                  ->update([
                      'n_qty' => $jumlah,
                      'n_insert' => Carbon::now()
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
          DB::table('d_promosi_demosi')
              ->where('pd_id',$request->pilih[$i])
              ->update([
                'pd_isapproved' => 'N'
              ]);
        }

        $jumlah = DB::select("select count(pd_id) as jumlah from d_promosi_demosi where pd_isapproved = 'P'");
        $jumlah = $jumlah[0]->jumlah;

        d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi')
            ->where('n_detail', '=', 'Create')
            ->update([
                'n_qty' => $jumlah,
                'n_insert' => Carbon::now()
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
        $data = DB::table('d_promosi_demosi')
              ->join('d_pekerja', 'p_id', '=', 'pd_pekerja')
              ->select('p_name', 'pd_no', 'pd_note', 'pd_jabatan_sekarang', 'pd_jabatan_awal')
              ->where('pd_id',$request->id)
              ->get();

        $awal = DB::table('d_jabatan_pelamar')
                ->select('jp_name')
                ->where('jp_id', $data[0]->pd_jabatan_awal)
                ->get();

        $sekarang = DB::table('d_jabatan_pelamar')
                ->select('jp_name')
                ->where('jp_id', $data[0]->pd_jabatan_sekarang)
                ->get();

        return response()->json([
          'pd_no' => $data[0]->pd_no,
          'pd_pekerja' => $data[0]->p_name,
          'pd_jabatan_awal' => $awal[0]->jp_name,
          'pd_jabatan_sekarang' => $sekarang[0]->jp_name,
          'pd_note' => $data[0]->pd_note
        ]);
    }

}
