<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\d_notifikasi;

use App\Http\Controllers\AksesUser;

class pegawairemunerasiController extends Controller
{
    public function index(){
      if (!AksesUser::checkAkses(40, 'read')) {
          return redirect('not-authorized');
      }

      return view('pegawairemunerasi.index');
    }

    public function simpan(Request $request, $idpekerja){
      if (!AksesUser::checkAkses(40, 'insert')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        $id = DB::table('d_pegawai_remunerasi')
            ->max('pr_id');
        $temp = str_replace('Rp. ', '', $request->gajiawal);
        $temp1 = str_replace('.', '', $temp);
        $gajiawal = (int)$temp1;

        $tmp = str_replace('Rp. ', '', $request->gajiterbaru);
        $tmp1 = str_replace('.', '', $tmp);
        $gajiterbaru = (int)$tmp1;

        if ($id == null) {
          $id = 0;
        }

        $kode = "";

        $querykode = DB::select(DB::raw("SELECT MAX(LEFT(pr_no,5)) as counter, MAX(MID(pr_no,14,2)) as bulan, MAX(MID(pr_no,17)) as tahun FROM d_pegawai_remunerasi"));

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


        $finalkode = $kode . '/RMS' . '/' . 'PN/' . date('m') . '/' . date('Y');

        DB::table('d_pegawai_remunerasi')
            ->insert([
              'pr_id' => $id + 1,
              'pr_no' => $finalkode,
              'pr_pegawai' => $idpekerja,
              'pr_awal' => $gajiawal,
              'pr_terbaru' => $gajiterbaru,
              'pr_note' => $request->keterangan
            ]);

            $jumlah = DB::select("select count(pr_id) as jumlah from d_pegawai_remunerasi where pr_isapproved = 'P'");
            $jumlah = $jumlah[0]->jumlah;

            d_notifikasi::where('n_fitur', '=', 'Remunerasi Pegawai')
                ->where('n_detail', '=', 'Create')
                ->update([
                    'n_qty' => $jumlah
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

    public function getcari(Request $request){
      $data = DB::table('d_pegawai_remunerasi')
            ->join('d_pegawai', 'p_id', '=', 'pr_pegawai')
            ->select('p_name', 'pr_id', 'pr_no', 'pr_awal', 'pr_terbaru', 'pr_note', 'p_jabatan')
            ->where('pr_pegawai', $request->id)
            ->get();

            $jabatan = DB::table('d_jabatan')
                    ->where('j_id', $data[0]->p_jabatan)
                    ->get();

            if (count($jabatan) > 0) {
              $data[0]->p_jabatan = $jabatan[0]->j_name;
            } else {
              $data[0]->p_jabatan = '-';
            }

      if (count($data)) {
       return response()->json($data);
     } else {
       return response()->json([
         'status' => 'kosong'
       ]);
     }
    }

    public function getdata(Request $request){
      $data = DB::table('d_pegawai')
             ->select('p_name', 'p_jabatan')
             ->where('p_id',$request->id)
             ->get();

             $jabatan = DB::table('d_jabatan')
                     ->where('j_id', $data[0]->p_jabatan)
                     ->get();

             if (count($jabatan) > 0) {
               $data[0]->p_jabatan = $jabatan[0]->j_name;
             } else {
               $data[0]->p_jabatan = '-';
             }

      if (count($data) > 0) {
       return response()->json($data);
     } else {
       return response()->json([
         'status' => 'kosong'
       ]);
     }
    }

    public function cari(){
      return view('pegawairemunerasi.cari');
    }

    public function data(){
      $data = DB::table('d_pegawai_remunerasi')
            ->join('d_pegawai', 'p_id', '=', 'pr_pegawai')
            ->leftjoin('d_jabatan', 'j_id', '=', 'p_jabatan')
            ->select('p_name', 'pr_id', 'pr_no', 'pr_awal', 'pr_terbaru', 'pr_note', 'p_jabatan', 'j_name')
            ->get();


      if (count($data) > 0) {
          return response()->json($data);
      } else {
        return response()->json([
          'status' => 'kosong'
        ]);
      }

    }

    public function detail(Request $request){
      $data = DB::table('d_pegawai_remunerasi')
            ->join('d_pegawai', 'p_id', '=', 'pr_pegawai')
            ->leftjoin('d_jabatan', 'j_id', '=', 'p_jabatan')
            ->select('p_name', 'pr_id', 'pr_no', 'pr_awal', 'pr_terbaru', 'pr_note', 'pr_isapproved', 'j_name')
            ->where('pr_id', $request->id)
            ->get();

      return response()->json($data);
    }

    public function hapus(Request $request){
      if (!AksesUser::checkAkses(40, 'delete')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        $no = DB::table('d_pegawai_remunerasi')
            ->where('pr_id', $request->id)
            ->get();

        DB::table('d_pegawai_remunerasi')
            ->where('pr_id', $request->id)
            ->delete();

        DB::table('d_pegawai_mutation')
            ->where('pm_reff', $no[0]->pr_no)
            ->where('pm_pegawai', $no[0]->pr_pegawai)
            ->update([
              'pm_note' => 'Dihapus'
            ]);

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

    public function update(Request $request, $id){
      if (!AksesUser::checkAkses(40, 'update')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {
        $request->gajiawal = str_replace('Rp. ', '', $request->gajiawal);
        $request->gajiawal = str_replace('.', '', $request->gajiawal);
        $request->gajiawal = (int)$request->gajiawal;

        $request->gajiterbaru = str_replace('Rp. ', '', $request->gajiterbaru);
        $request->gajiterbaru = str_replace('.', '', $request->gajiterbaru);
        $request->gajiterbaru = (int)$request->gajiterbaru;

        DB::table('d_pegawai_remunerasi')
           ->where('pr_id', $request->id)
           ->update([
             'pr_awal' => $request->gajiawal,
             'pr_terbaru' => $request->gajiterbaru,
             'pr_note' => $request->keterangan
           ]);

           $no = DB::table('d_pegawai_remunerasi')
               ->where('pr_id', $request->id)
               ->get();

               DB::table('d_pegawai_mutation')
                   ->where('pm_reff', $no[0]->pr_no)
                   ->where('pm_pegawai', $no[0]->pr_pegawai)
                   ->update([
                     'pm_note' => $request->keterangan
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
