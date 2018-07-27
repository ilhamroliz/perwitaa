<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class remunerasiController extends Controller
{
    public function index(){
      return view('remunerasi.index');
    }

    public function simpan(Request $request, $idpekerja){
      DB::beginTransaction();
      try {

        $id = DB::table('d_remunerasi')
            ->max('r_id');
        $temp = str_replace('Rp. ', '', $request->nilairemunerasi);
        $temp1 = str_replace('.', '', $temp);
        $nilairemunerasi = (int)$temp1;

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
              'r_nilai' => $nilairemunerasi,
              'r_note' => $request->keterangan
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
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
            ->join('d_mitra_divisi', function($e){
              $e->on('m_id', '=', 'md_mitra');
              $e->on('mp_divisi', '=', 'md_id');
            })
            ->select('p_id','mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'p_nip_mitra', 'jp_name', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
            ->whereRaw("mp_status = 'Aktif' AND mp_isapproved = 'Y' AND p_nip LIKE '%".$keyword."%'")
            ->LIMIT(20)
            ->get();

            if ($data == null) {
                $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
            } else {

                foreach ($data as $query) {
                    $results[] = ['id' => $query->p_id, 'label' => $query->p_name . ' (' . $query->jp_name . ')'];
                }
            }

            return response()->json($results);
    }

    public function getcari(Request $request){
      $data = DB::table('d_remunerasi')
            ->join('d_pekerja', 'p_id', '=', 'r_pekerja')
            ->select('p_name', 'r_id', 'r_no', 'r_nilai', 'r_note', 'jp_name')
            ->where('r_pekerja', $request->id)
            ->get();

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
             ->join('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
             ->select('p_name', 'jp_name')
             ->where('p_id',$request->id)
             ->get();

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
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
            ->select('p_name', 'r_id', 'r_no', 'r_nilai', 'r_note', 'jp_name')
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
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
            ->select('p_name', 'r_id', 'r_no', 'r_nilai', 'r_note', 'jp_name', 'r_isapproved')
            ->where('r_id', $request->id)
            ->get();

      return response()->json($data);
    }

    public function hapus(Request $request){
      DB::beginTransaction();
      try {
        DB::table('d_remunerasi')
            ->where('r_id', $request->id)
            ->delete();

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'berhasil'
        ]);
      }
    }

    public function update(Request $request, $id){
      DB::beginTransaction();
      try {
        $request->remunerasi = str_replace('Rp. ', '', $request->remunerasi);
        $request->remunerasi = str_replace('.', '', $request->remunerasi);
        $request->remunerasi = (int)$request->remunerasi;

        DB::table('d_remunerasi')
           ->where('r_id', $request->id)
           ->update([
             'r_nilai' => $request->remunerasi,
             'r_note' => $request->keterangan
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
