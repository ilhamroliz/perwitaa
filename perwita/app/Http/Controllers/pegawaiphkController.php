<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

class pegawaiphkController extends Controller
{
    public function index(){
      if (!AksesUser::checkAkses(41, 'read')) {
          return redirect('not-authorized');
      }

      return view('pegawaiphk.index');
    }

    public function carino(Request $request){
      $keyword = $request->term;

      $data = DB::table('d_pegawai')
                ->leftjoin('d_jabatan', 'j_id', '=', 'p_jabatan')
                ->select('p_name', 'j_name', 'p_nip', 'p_id')
                ->where('p_nip', 'LIKE', '%'.$keyword.'%')
                ->groupBy('p_id')
                ->limit(20)
                ->get();

            if ($data == null) {
                $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
            } else {

                foreach ($data as $query) {
                    $results[] = ['id' => $query->p_id, 'label' => $query->p_name . ' (' . $query->p_nip . ')'];
                }
            }

            return response()->json($results);
    }

    public function getdata(Request $request){
      $data = DB::table('d_pegawai')
              ->leftjoin('d_jabatan', 'j_id', '=', 'p_jabatan')
              ->select('p_name', 'j_name')
              ->where('p_id', $request->id)
              ->get();

      if (count($data) > 0) {
       return response()->json($data);
     } else {
       return response()->json([
         'status' => 'kosong'
       ]);
     }
    }

    public function simpan(Request $request, $idpekerja){
      if (!AksesUser::checkAkses(41, 'insert')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        $id = DB::table('d_pegawai_phk')
            ->max('pp_id');

        if ($id == null) {
          $id = 0;
        }

        $kode = "";

        $querykode = DB::select(DB::raw("SELECT MAX(MID(pp_no,5,5)) as counter, MAX(MID(pp_no,14,2)) as bulan, MAX(MID(pp_no,17)) as tahun FROM d_pegawai_phk"));

        if (count($querykode) > 0) {
          if ($querykode[0]->bulan != date('m') || $querykode[0]->tahun != date('Y')) {
              $kode = "00001";
          } else {
            foreach($querykode as $k)
              {
                $tmp = ((int)$k->counter)+1;
                $kode = sprintf("%05s", $tmp);
              }
          }
        } else {
          $kode = "00001";
        }


        $finalkode = 'PHK.' . $kode . '/' . date('m') . '/' . date('Y');

        DB::table('d_pegawai_phk')
            ->insert([
              'pp_id' => $id + 1,
              'pp_no' => $finalkode,
              'pp_pekerja' => $idpekerja,
              'pp_date' => Carbon::now('Asia/Jakarta'),
              'pp_keterangan' => $request->keterangan
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

    public function cari(){
      return view('pegawaiphk.cari');
    }

    public function data(){
      $data = DB::table('d_pegawai_phk')
            ->join('d_pegawai', 'd_pegawai.p_id', '=', 'd_pegawai_phk.pp_pekerja')
            ->leftJoin('d_jabatan', 'j_id', '=', 'p_jabatan')
            ->select('d_pegawai.p_name', 'j_name', 'd_pegawai_phk.pp_id', 'd_pegawai_phk.pp_no', 'd_pegawai_phk.pp_date', 'd_pegawai_phk.pp_keterangan', 'd_pegawai.p_jabatan')
            ->get();


      if (count($data) > 0) {
          return response()->json($data);
      } else {
        return response()->json([
          'status' => 'kosong'
        ]);
      }
    }

    public function getcari(Request $request){
      $data = DB::table('d_pegawai_phk')
            ->join('d_pegawai', 'd_pegawai.p_id', '=', 'd_pegawai_phk.pp_pekerja')
            ->leftJoin('d_jabatan', 'j_id', '=', 'p_jabatan')
            ->select('d_pegawai.p_name', 'j_name', 'd_pegawai_phk.pp_id', 'd_pegawai_phk.pp_no', 'd_pegawai_phk.pp_date', 'd_pegawai_phk.pp_keterangan', 'd_pegawai.p_jabatan')
            ->where('d_pegawai_phk.pp_pekerja', $request->id)
            ->get();


      if (count($data)) {
       return response()->json($data);
     } else {
       return response()->json([
         'status' => 'kosong'
       ]);
     }
    }

    public function detail(Request $request){
        $data = DB::table('d_pegawai_phk')
              ->join('d_pegawai', 'd_pegawai.p_id', '=', 'd_pegawai_phk.pp_pekerja')
              ->leftJoin('d_jabatan', 'j_id', '=', 'p_jabatan')
              ->select('d_pegawai.p_name', 'j_name', 'd_pegawai_phk.pp_id', 'd_pegawai_phk.pp_no', 'd_pegawai_phk.pp_date', 'd_pegawai_phk.pp_keterangan', 'd_pegawai.p_jabatan', 'd_pegawai_phk.pp_isapproved')
              ->where('d_pegawai_phk.pp_id', $request->id)
              ->get();


        return response()->json($data);
    }

    public function hapus(Request $request){
      if (!AksesUser::checkAkses(41, 'delete')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        $no = DB::table('d_pegawai_phk')
            ->where('pp_id', $request->id)
            ->get();

        DB::table('d_pegawai_phk')
            ->where('pp_id', $request->id)
            ->DELETE();

        DB::table('d_pegawai_mutation')
            ->where('pm_reff', $no[0]->pp_no)
            ->where('pm_pegawai', $no[0]->pp_pekerja)
            ->update([
              'pm_note' => 'Dihapus'
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


}
