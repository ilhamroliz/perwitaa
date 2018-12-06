<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\d_notifikasi;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

use Session;

use App\d_pegawai;

class approvalpegawaipromosiController extends Controller
{
  public function index(){

    if (!AksesUser::checkAkses(55, 'read')){
        return redirect('not-authorized');
    }

    $data = DB::table('d_pegawai')
    ->join('d_pegawai_promosi_demosi', 'd_pegawai_promosi_demosi.ppd_pegawai', '=', 'd_pegawai.p_id')
    ->select('ppd_id', 'p_id', 'p_name', 'ppd_jabatan_awal', 'ppd_jabatan_sekarang', 'p_nip', 'ppd_no')
    ->where('ppd_isapproved', 'P')
    ->groupBy('ppd_id')
    ->get();

    $jabatan = DB::select("select ppd_pegawai, jpa.j_name as awal, jpm.j_name as sekarang from d_pegawai_promosi_demosi
join d_jabatan jpa on jpa.j_id = ppd_jabatan_awal
join d_jabatan jpm on jpm.j_id = ppd_jabatan_sekarang");

    for ($i=0; $i < count($data); $i++) {
      $data[$i]->ppd_jabatan_awal = $jabatan[$i]->awal;
      $data[$i]->ppd_jabatan_sekarang = $jabatan[$i]->sekarang;
    }

    $jumlah = DB::select("select count(ppd_id) as jumlah from d_pegawai_promosi_demosi where ppd_isapproved = 'P'");
    $jumlah = $jumlah[0]->jumlah;

    d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi Pegawai')
        ->where('n_detail', '=', 'Create')
        ->update([
            'n_qty' => $jumlah,
            'n_insert' => Carbon::now()
        ]);


    return view('approvalpegawaipromosi.index', compact('data'));

  }

  public function setujui(Request $request){
    DB::beginTransaction();
    try {

      DB::table('d_pegawai_promosi_demosi')
          ->where('ppd_id',$request->id)
          ->update([
            'ppd_isapproved' => 'Y'
          ]);

          $data = DB::table('d_pegawai_promosi_demosi')
              ->where('ppd_no', '=', $request->ppd_no)
              ->get();

          $pekerja = $data[0]->ppd_pegawai;
          $jabatan = $data[0]->ppd_jabatan_sekarang;
          $sekarang = Carbon::now('Asia/Jakarta');

          $detailid = DB::table('d_pegawai_mutation')
              ->select(DB::raw('max(pm_detailid) as detailid'), 'pm_status')
              ->where('pm_pegawai', '=', $pekerja)
              ->get();

          DB::table('d_pegawai_mutation')->insert(array(
              'pm_pegawai' => $pekerja,
              'pm_detailid' => $detailid[0]->detailid + 1,
              'pm_date' => $sekarang,
              'pm_detail' => 'Promosi',
              'pm_status' => 'Aktif',
              'pm_note' => $data[0]->ppd_note,
              'pm_insert_by' => Session::get('mem'),
              'pm_reff' => $request->ppd_no
          ));

          d_pegawai::where('p_id', '=', $pekerja)
              ->update([
                  'p_jabatan' => $jabatan
              ]);


              $jumlah = DB::select("select count(ppd_id) as jumlah from d_pegawai_promosi_demosi where ppd_isapproved = 'P'");
              $jumlah = $jumlah[0]->jumlah;

              d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi Pegawai')
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
      DB::table('d_pegawai_promosi_demosi')
          ->where('ppd_id',$request->id)
          ->update([
            'ppd_isapproved' => 'N'
          ]);

          $jumlah = DB::select("select count(ppd_id) as jumlah from d_pegawai_promosi_demosi where ppd_isapproved = 'P'");
          $jumlah = $jumlah[0]->jumlah;

          d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi Pegawai')
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
          DB::table('d_pegawai_promosi_demosi')
              ->whereIn('ppd_id',$request->pilih)
              ->update([
                'ppd_isapproved' => 'Y'
              ]);

          $data = DB::table('d_pegawai_promosi_demosi')
              ->whereIn('ppd_id',$request->pilih)
              ->get();


          for ($i=0; $i < count($data); $i++) {
            $pekerja[] = $data[$i]->ppd_pekerja;
            $jabatan[] = $data[$i]->ppd_jabatan_sekarang;
          }

          $sekarang = Carbon::now('Asia/Jakarta');

          for ($i=0; $i < count($data); $i++) {
            $detailid[] = DB::table('d_pegawai_mutation')
                ->selectRaw('pm_detailid')
                ->where('pm_pekerja', $pekerja[$i])
                ->max('pm_detailid');
          }

          for ($i=0; $i < count($data); $i++) {
            $status[] = DB::table('d_pegawai_mutation')
                    ->select('pm_status')
                    ->where('pm_pegawai',$pekerja[$i])
                    ->where('pm_detailid',$detailid[$i])
                    ->get();
          }

          for ($i=0; $i < count($data); $i++) {
            DB::table('d_pegawai_mutation')->insert(array(
                'pm_pegawai' => $pekerja[$i],
                'pm_detailid' => $detailid[$i] + 1,
                'pm_date' => $sekarang,
                'pm_detail' => 'Promosi',
                'pm_status' => 'Aktif',
                'pm_note' => $data[$i]->ppd_note,
                'pm_insert_by' => Session::get('mem'),
                'pm_reff' => $data[$i]->ppd_no
            ));
          }

          for ($i=0; $i < count($data); $i++) {
          d_pegawai::where('p_id', '=', $pekerja[$i])
              ->update([
                  'p_jabatan' => $jabatan[$i]
              ]);
            }

            $jumlah = DB::select("select count(ppd_id) as jumlah from d_pegawai_promosi_demosi where ppd_isapproved = 'P'");
            $jumlah = $jumlah[0]->jumlah;

            d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi Pegawai')
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
        DB::table('d_pegawai_promosi_demosi')
            ->where('ppd_id',$request->pilih[$i])
            ->update([
              'ppd_isapproved' => 'N'
            ]);
      }

      $jumlah = DB::select("select count(ppd_id) as jumlah from d_pegawai_promosi_demosi where ppd_isapproved = 'P'");
      $jumlah = $jumlah[0]->jumlah;

      d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi Pegawai')
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
      $data = DB::table('d_pegawai_promosi_demosi')
            ->join('d_pegawai', 'p_id', '=', 'ppd_pegawai')
            ->select('p_name', 'ppd_no', 'ppd_note', 'ppd_jabatan_sekarang', 'ppd_jabatan_awal')
            ->where('ppd_id',$request->id)
            ->get();

      $awal = DB::table('d_jabatan')
              ->select('j_name')
              ->where('j_id', $data[0]->ppd_jabatan_awal)
              ->get();

      $sekarang = DB::table('d_jabatan')
              ->select('j_name')
              ->where('j_id', $data[0]->ppd_jabatan_sekarang)
              ->get();

      return response()->json([
        'ppd_no' => $data[0]->ppd_no,
        'ppd_pegawai' => $data[0]->p_name,
        'ppd_jabatan_awal' => $awal[0]->j_name,
        'ppd_jabatan_sekarang' => $sekarang[0]->j_name,
        'ppd_note' => $data[0]->ppd_note
      ]);
  }

}
