<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

class penggajianController extends Controller
{
    public function index(){
      $data = DB::table('d_mitra')
              ->join('d_mitra_divisi', 'md_mitra', '=', 'm_id')
              ->groupBy('m_name')
              ->get();

      return view('penggajian.index', compact('data'));
    }

    public function cari(Request $request){
      $mitra = $request->mitra;
      $divisi = $request->divisi;

      if ($mitra == 'all') {
        $pekerja = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->leftJoin('d_bpjs_kesehatan', 'd_bpjs_kesehatan.b_pekerja', '=', 'p_id')
            ->leftJoin('d_bpjs_ketenagakerjaan', 'd_bpjs_ketenagakerjaan.b_pekerja', '=', 'p_id')
            ->leftJoin('d_rbh', 'r_pekerja', '=', 'p_id')
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select('p_name', 'p_id', DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no"))
            ->where('mp_isapproved', 'Y')
            ->get();
      } elseif (!empty($mitra) && $divisi == "all") {
        $pekerja = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->leftJoin('d_bpjs_kesehatan', 'd_bpjs_kesehatan.b_pekerja', '=', 'p_id')
            ->leftJoin('d_bpjs_ketenagakerjaan', 'd_bpjs_ketenagakerjaan.b_pekerja', '=', 'p_id')
            ->leftJoin('d_rbh', 'r_pekerja', '=', 'p_id')
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select('p_name', 'p_id', DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no"))
            ->where('mp_mitra', '=', $mitra)
            ->where('mp_isapproved', 'Y')
            ->get();
      }
      else {
        $pekerja = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->leftJoin('d_bpjs_kesehatan', 'd_bpjs_kesehatan.b_pekerja', '=', 'p_id')
            ->leftJoin('d_bpjs_ketenagakerjaan', 'd_bpjs_ketenagakerjaan.b_pekerja', '=', 'p_id')
            ->leftJoin('d_rbh', 'r_pekerja', '=', 'p_id')
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select('p_name', 'p_id', DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no"))
            ->where('mp_mitra', '=', $mitra)
            ->where('mp_divisi', '=', $divisi)
            ->where('mp_isapproved', 'Y')
            ->get();
      }



          return response()->json($pekerja);
    }

    public function simpan(Request $request){
      // DB::beginTransaction();
      // try {

      dd($request);

      $counttotalpy = 0;
        for ($a=0; $i < count($request->totalgaji); $a++) {
          if ($request->totalgaji[$a] == "") {

          } else {
            $counttotalpy += 1;
          }
        }

        for ($b=0; $i < $counttotalpy; $b++) {

        }

      $countbpjskes = 0;
        for ($i=0; $i < count($request->bpjskes); $i++) {
          if ($request->bpjskes[$i] == "") {

          } else {
            $countbpjskes += 1;
          }
        }

        for ($i=0; $i < $countbpjskes; $i++) {
          $nobpjskes = DB::table('d_bpjs_kesehatan')
                        ->where('b_pekerja', $request->p_id[$i])
                        ->select('b_no')
                        ->get();

          if ($nobpjskes != "") {
            $tmp = str_replace('.', '', $request->bpjskes[$i]);
            $bpjskes = str_replace('Rp .', '', $tmp);
            $detailidkes = DB::table('d_bpjskes_iuran')
                            ->where('bi_no_bpjs', $nobpjskes)
                            ->max('bi_detailid');

            DB::table('d_bpjskes_iuran')
              ->insert([
                'bi_no_bpjs' => $nobpjskes,
                'bi_detailid' => $detailidkes,
                'bi_no_pay' => $bpjskes,

              ]);
          }

        }






      //   DB::commit();
      //   return response()->json([
      //     'status' => 'berhasil'
      //   ]);
      // } catch (\Exception $e) {
      //   DB::rollback();
      //   return response()->json([
      //     'status' => 'gagal'
      //   ]);
      // }

    }
}
