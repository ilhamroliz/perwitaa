<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class phkController extends Controller
{
    public function index(){
      return view('PHK.index');
    }

    public function carino(Request $request){

      dd($request);
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
}
