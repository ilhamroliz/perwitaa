<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

class phkController extends Controller
{
    public function index(){
      return view('PHK.index');
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

    public function simpan(Request $request, $idpekerja){
      DB::beginTransaction();
      try {

        $id = DB::table('d_phk')
            ->max('p_id');

        if ($id == null) {
          $id = 0;
        }

        $kode = "";

        $querykode = DB::select(DB::raw("SELECT MAX(MID(p_no,5,5)) as counter, MAX(MID(p_no,14,2)) as bulan, MAX(MID(p_no,17)) as tahun FROM d_phk"));

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

        DB::table('d_phk')
            ->insert([
              'p_id' => $id + 1,
              'p_no' => $finalkode,
              'p_pekerja' => $idpekerja,
              'p_date' => Carbon::now('Asia/Jakarta'),
              'p_keterangan' => $request->keterangan
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
