<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Http\Controllers\AksesUser;

class tunjanganController extends Controller
{
    public function index(){
      if (!AksesUser::checkAkses(58, 'read')) {
          return redirect('not-authorized');
      }
      $data = DB::table('d_mitra')
              ->join('d_mitra_divisi', 'md_mitra', '=', 'm_id')
              ->groupBy('m_name')
              ->get();

      return view('tunjangan.index', compact('data'));
    }

    public function simpan(Request $request){
      if (!AksesUser::checkAkses(58, 'insert')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        for ($i=0; $i < count($request->jabatan); $i++) {
          if ($request->jabatan[$i] == 'Rp. 0') {

          } else {
            $tmp = str_replace('.', '', $request->jabatan[$i]);
            $jabatan = str_replace('Rp ', '', $tmp);

            DB::table('d_pekerja')
             ->where('p_id', $request->pekerja[$i])
             ->update([
               'p_tjg_jabatan' => $jabatan
             ]);
          }
        }

        for ($i=0; $i < count($request->makan); $i++) {
          if ($request->makan[$i] == 'Rp. 0') {

          } else {
            $tmp = str_replace('.', '', $request->makan[$i]);
            $makan = str_replace('Rp ', '', $tmp);

            DB::table('d_pekerja')
             ->where('p_id', $request->pekerja[$i])
             ->update([
               'p_tjg_makan' => $makan
             ]);
          }
        }

        for ($i=0; $i < count($request->transport); $i++) {
          if ($request->transport[$i] == 'Rp. 0') {

          } else {
            $tmp = str_replace('.', '', $request->transport[$i]);
            $transport = str_replace('Rp ', '', $tmp);

            DB::table('d_pekerja')
             ->where('p_id', $request->pekerja[$i])
             ->update([
               'p_tjg_transport' => $transport
             ]);
          }
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

    public function cari(Request $request){
      $mitra = $request->mitra;
      $divisi = $request->divisi;

      if ($mitra == 'all') {
        $pekerja = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->leftJoin('d_bpjs_kesehatan', function($q){
              $q->on('d_bpjs_kesehatan.b_pekerja', '=', 'p_id');
              $q->where('d_bpjs_kesehatan.b_status', '=', 'Y');
            })
            ->leftJoin('d_bpjs_ketenagakerjaan', function($e){
              $e->on('d_bpjs_ketenagakerjaan.b_pekerja', '=', 'p_id')
                ->where('d_bpjs_ketenagakerjaan.b_status', '=', 'Y');
            })
            ->leftJoin('d_rbh', function($z){
              $z->on('r_pekerja', '=', 'p_id')
                ->where('r_status', '=', 'Y');
            })
            ->leftJoin('d_dapan', function($z){
              $z->on('d_pekerja', '=', 'p_id')
                ->where('d_status', '=', 'Y');
            })
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select('p_name', 'p_nip', 'p_nip_mitra', 'p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport', 'p_id', DB::raw("COALESCE(p_nip_mitra, '') as p_nip_mitra"), DB::raw("COALESCE(p_nip, '') as p_nip"))
            ->where('mp_isapproved', 'Y')
            ->get();
      } elseif (!empty($mitra) && $divisi == "all") {
        $pekerja = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->leftJoin('d_bpjs_kesehatan', function($q){
              $q->on('d_bpjs_kesehatan.b_pekerja', '=', 'p_id');
              $q->where('d_bpjs_kesehatan.b_status', '=', 'Y');
            })
            ->leftJoin('d_bpjs_ketenagakerjaan', function($e){
              $e->on('d_bpjs_ketenagakerjaan.b_pekerja', '=', 'p_id')
                ->where('d_bpjs_ketenagakerjaan.b_status', '=', 'Y');
            })
            ->leftJoin('d_rbh', function($z){
              $z->on('r_pekerja', '=', 'p_id')
                ->where('r_status', '=', 'Y');
            })
            ->leftJoin('d_dapan', function($z){
              $z->on('d_pekerja', '=', 'p_id')
                ->where('d_status', '=', 'Y');
            })
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select('p_name', 'p_nip', 'p_nip_mitra', 'p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport', 'p_id', DB::raw("COALESCE(p_nip_mitra, '') as p_nip_mitra"), DB::raw("COALESCE(p_nip, '') as p_nip"))
            ->where('mp_mitra', '=', $mitra)
            ->where('mp_isapproved', 'Y')
            ->get();
      }
      else {
        $pekerja = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->leftJoin('d_bpjs_kesehatan', function($q){
              $q->on('d_bpjs_kesehatan.b_pekerja', '=', 'p_id');
              $q->where('d_bpjs_kesehatan.b_status', '=', 'Y');
            })
            ->leftJoin('d_bpjs_ketenagakerjaan', function($e){
              $e->on('d_bpjs_ketenagakerjaan.b_pekerja', '=', 'p_id')
                ->where('d_bpjs_ketenagakerjaan.b_status', '=', 'Y');
            })
            ->leftJoin('d_rbh', function($z){
              $z->on('r_pekerja', '=', 'p_id')
                ->where('r_status', '=', 'Y');
            })
            ->leftJoin('d_dapan', function($z){
              $z->on('d_pekerja', '=', 'p_id')
                ->where('d_status', '=', 'Y');
            })
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select('p_name', 'p_nip', 'p_nip_mitra', 'p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport', 'p_id', DB::raw("COALESCE(p_nip_mitra, '') as p_nip_mitra"), DB::raw("COALESCE(p_nip, '') as p_nip"))
            ->where('mp_mitra', '=', $mitra)
            ->where('mp_divisi', '=', $divisi)
            ->where('mp_isapproved', 'Y')
            ->get();
          }

          return response()->json($pekerja);
    }

    public function getdata(Request $request){
      $key = $request->term;
      $data = DB::table('d_pekerja')
          ->select('p_id', 'p_nip', 'p_nip_mitra', DB::raw('coalesce(p_tjg_makan, "") as p_tjg_makan'), DB::raw('coalesce(p_tjg_jabatan, "") as p_tjg_jabatan'), DB::raw('coalesce(p_tjg_transport, "") as p_tjg_transport'), 'p_name')
          ->where(function ($q) use ($key) {
              $q->orWhere('p_nip', 'like', '%'.$key.'%');
              $q->orWhere('p_nip_mitra', 'like', '%'.$key.'%');
              $q->orWhere('p_name', 'like', '%'.$key.'%');
          })
          ->where('p_status_approval', '=', 'Y')
          ->get();

      if ($data == null) {
          $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
      } else {

          foreach ($data as $query) {
              $results[] = ['data' => $query, 'label' => $query->p_name.' ('.$query->p_nip.' | '.$query->p_nip_mitra.')'];
          }
      }
      return response()->json($results);
    }
}
