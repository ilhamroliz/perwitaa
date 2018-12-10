<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\d_notifikasi;

use DB;

use App\Http\Controllers\AksesUser;

class remunerasiController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(9, 'read')) {
          return redirect('not-authorized');
      }

      return view('remunerasi.index');
    }

    public function simpan(Request $request, $idpekerja){
      if (!AksesUser::checkAkses(9, 'insert')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        $id = DB::table('d_remunerasi')
            ->max('r_id');
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

        $queryid = DB::table('d_surat_pringatan')
            ->MAX('sp_id');

            if ($queryid == null) {
              $queryid = 0;
            }

        $querykode = DB::select(DB::raw("SELECT MAX(LEFT(r_no,5)) as counter, MAX(MID(r_no,14,2)) as bulan, MAX(MID(r_no,17)) as tahun FROM d_remunerasi"));

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

        DB::table('d_remunerasi')
            ->insert([
              'r_id' => $id + 1,
              'r_no' => $finalkode,
              'r_pekerja' => $idpekerja,
              'r_awal' => $gajiawal,
              'r_terbaru' => $gajiterbaru,
              'r_note' => $request->keterangan
            ]);

            $jumlah = DB::select("select count(r_id) as jumlah from d_remunerasi where r_isapproved = 'P'");
            $jumlah = $jumlah[0]->jumlah;

            d_notifikasi::where('n_fitur', '=', 'Remunerasi')
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

      $data = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_mitra_divisi', function($e){
              $e->on('m_id', '=', 'md_mitra');
              $e->on('mp_divisi', '=', 'md_id');
            })
            ->select('p_id','mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'p_nip_mitra', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
            ->whereRaw("mp_status = 'Aktif' AND mp_isapproved = 'Y' AND p_nip LIKE '%".$keyword."%'")
            ->LIMIT(20)
            ->get();

            for ($i=0; $i < count($data); $i++) {
              $jabatan[] = DB::table('d_jabatan_pelamar')
                      ->where('jp_id', $data[$i]->p_jabatan)
                      ->get();
            }

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
      $data = DB::table('d_remunerasi')
            ->join('d_pekerja', 'p_id', '=', 'r_pekerja')
            ->select('p_name', 'r_id', 'r_no', 'r_awal', 'r_terbaru', 'r_note', 'p_jabatan')
            ->where('r_pekerja', $request->id)
            ->get();

            $jabatan = DB::table('d_jabatan_pelamar')
                    ->where('jp_id', $data[0]->p_jabatan)
                    ->get();

            if (count($jabatan) > 0) {
              $data[0]->p_jabatan = $jabatan[0]->jp_name;
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
      $data = DB::table('d_pekerja')
             ->select('p_name', 'p_jabatan')
             ->where('p_id',$request->id)
             ->get();

             $jabatan = DB::table('d_jabatan_pelamar')
                     ->where('jp_id', $data[0]->p_jabatan)
                     ->get();

             if (count($jabatan) > 0) {
               $data[0]->p_jabatan = $jabatan[0]->jp_name;
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
      return view('remunerasi.cari');
    }

    public function data(){
      $data = DB::table('d_remunerasi')
            ->join('d_pekerja', 'p_id', '=', 'r_pekerja')
            ->select('p_name', 'r_id', 'r_no', 'r_awal', 'r_terbaru', 'r_note', 'p_jabatan')
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
      $data = DB::table('d_remunerasi')
            ->join('d_pekerja', 'p_id', '=', 'r_pekerja')
            ->select('p_name', 'r_id', 'r_no', 'r_awal', 'r_terbaru', 'r_note', 'r_isapproved')
            ->where('r_id', $request->id)
            ->get();

      return response()->json($data);
    }

    public function hapus(Request $request){
      if (!AksesUser::checkAkses(9, 'delete')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        $no = DB::table('d_remunerasi')
            ->where('r_id', $request->id)
            ->get();

        DB::table('d_remunerasi')
            ->where('r_id', $request->id)
            ->delete();

        DB::table('d_pekerja_mutation')
            ->where('pm_reff', $no[0]->r_no)
            ->where('pm_pekerja', $no[0]->r_pekerja)
            ->update([
              'pm_note' => 'Dihapus'
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

    public function update(Request $request, $id){
      if (!AksesUser::checkAkses(9, 'update')) {
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

        DB::table('d_remunerasi')
           ->where('r_id', $request->id)
           ->update([
             'r_awal' => $request->gajiawal,
             'r_terbaru' => $request->gajiterbaru,
             'r_note' => $request->keterangan
           ]);

           $no = DB::table('d_remunerasi')
               ->where('r_id', $request->id)
               ->get();

               DB::table('d_pekerja_mutation')
                   ->where('pm_reff', $no[0]->r_no)
                   ->where('pm_pekerja', $no[0]->r_pekerja)
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
