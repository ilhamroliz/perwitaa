<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Http\Controllers\AksesUser;

class potonganController extends Controller
{
    public function index(){
      if (!AksesUser::checkAkses(59, 'read')) {
          return redirect('not-authorized');
      }
      $data = DB::table('d_mitra')
              ->join('d_mitra_divisi', 'md_mitra', '=', 'm_id')
              ->groupBy('m_name')
              ->get();

      return view('potongan.index', compact('data'));
    }

    public function simpan(Request $request){
      if (!AksesUser::checkAkses(59, 'insert')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        for ($i=0; $i < count($request->bpjskes); $i++) {
          if ($request->bpjskes[$i] == "") {

          } else {
            $tmp = str_replace('.', '', $request->bpjskes[$i]);
            $bpjskes = str_replace('Rp ', '', $tmp);

            DB::table('d_bpjs_kesehatan')
              ->where('b_pekerja', $request->p_id[$i])
              ->where('b_status', 'Y')
              ->update([
                'b_value' => $bpjskes
              ]);
          }
        }

        for ($i=0; $i < count($request->bpjsketjht); $i++) {
          if ($request->bpjsketjht[$i] == "") {

          } else {
            $tmp = str_replace('.', '', $request->bpjsketjht[$i]);
            $bpjsketjht = str_replace('Rp ', '', $tmp);

            $tmp = str_replace('.', '', $request->bpjsketpens[$i]);
            $bpjsketpens = str_replace('Rp ', '', $tmp);

            DB::table('d_bpjs_ketenagakerjaan')
              ->where('b_pekerja', $request->p_id[$i])
              ->where('b_status', 'Y')
              ->update([
                'b_value_jht' => $bpjsketjht,
                'b_value' => $bpjsketjht + $bpjsketpens
              ]);
          }
        }

        for ($i=0; $i < count($request->bpjsketpens); $i++) {
          if ($request->bpjsketpens[$i] == "") {

          } else {
            $tmp = str_replace('.', '', $request->bpjsketpens[$i]);
            $bpjsketpens = str_replace('Rp ', '', $tmp);

            $tmp = str_replace('.', '', $request->bpjsketjht[$i]);
            $bpjsketjht = str_replace('Rp ', '', $tmp);

            DB::table('d_bpjs_ketenagakerjaan')
              ->where('b_pekerja', $request->p_id[$i])
              ->where('b_status', 'Y')
              ->update([
                'b_value_pensiun' => $bpjsketpens,
                'b_value' => $bpjsketjht + $bpjsketpens
              ]);
          }
        }

        for ($i=0; $i < count($request->rbh); $i++) {
          if ($request->rbh[$i] == "") {

          } else {
            $tmp = str_replace('.', '', $request->rbh[$i]);
            $rbh = str_replace('Rp ', '', $tmp);

            DB::table('d_rbh')
              ->where('r_pekerja', $request->p_id[$i])
              ->where('r_status', 'Y')
              ->update([
                'r_value' => $rbh
              ]);
          }
        }

        for ($i=0; $i < count($request->dapan); $i++) {
          if ($request->dapan[$i] == "") {

          } else {
            $tmp = str_replace('.', '', $request->dapan[$i]);
            $dapan = str_replace('Rp ', '', $tmp);

            DB::table('d_dapan')
              ->where('d_pekerja', $request->p_id[$i])
              ->where('d_status', 'Y')
              ->update([
                'd_value' => $dapan
              ]);
          }
        }

        for ($i=0; $i < count($request->potonganlain); $i++) {
          if ($request->potonganlain[$i] == "") {

          } else {
            $check = DB::table('d_potonganlain')
              ->where('p_pekerja', $request->p_id[$i])
              ->get();

            if (count($check) > 0) {
              $tmp = str_replace('.', '', $request->potonganlain[$i]);
              $potonganlain = str_replace('Rp ', '', $tmp);

              DB::table('d_potonganlain')
                ->where('p_pekerja', $request->p_id[$i])
                ->update([
                  'p_value' => $potonganlain
                ]);
            } else {
              $id = DB::table('d_potonganlain')
                    ->max('p_id');

              if (empty($id)) {
                $id = 0;
              }

              $tmp = str_replace('.', '', $request->potonganlain[$i]);
              $potonganlain = str_replace('Rp ', '', $tmp);

              DB::table('d_potonganlain')
                ->insert([
                  'p_id' => $id + 1,
                  'p_pekerja' => $request->p_id[$i],
                  'p_value' => $potonganlain
                ]);
            }
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
            ->leftJoin('d_potonganlain', 'p_pekerja', '=', 'd_pekerja.p_id')
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select(
              'p_name', 'd_pekerja.p_id', DB::raw("COALESCE(p_value, '') as p_value"), DB::raw("COALESCE(d_dapan.d_value, '') as biked_value"), DB::raw("COALESCE(d_rbh.r_value, '') as biker_value"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value_pensiun, '') as b_value_pensiun"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value_jht, '') as b_value_jht"), DB::raw("COALESCE(d_bpjs_kesehatan.b_value, '') as bikes_value"), DB::raw("COALESCE(r_status, '-') as statusr"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_status, '-') as statusket"), DB::raw("COALESCE(d_bpjs_kesehatan.b_status, '-') as statuskes"), DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_no, '-') as d_no"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
            )
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
            ->leftJoin('d_potonganlain', 'p_pekerja', '=', 'd_pekerja.p_id')
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select(
              'p_name', 'd_pekerja.p_id', DB::raw("COALESCE(p_value, '') as p_value"), DB::raw("COALESCE(d_dapan.d_value, '') as biked_value"), DB::raw("COALESCE(d_rbh.r_value, '') as biker_value"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value_pensiun, '') as b_value_pensiun"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value_jht, '') as b_value_jht"), DB::raw("COALESCE(d_bpjs_kesehatan.b_value, '') as bikes_value"), DB::raw("COALESCE(r_status, '-') as statusr"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_status, '-') as statusket"), DB::raw("COALESCE(d_bpjs_kesehatan.b_status, '-') as statuskes"), DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_no, '-') as d_no"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
            )
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
            ->leftJoin('d_potonganlain', 'p_pekerja', '=', 'd_pekerja.p_id')
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select(
              'p_name', 'd_pekerja.p_id', DB::raw("COALESCE(p_value, '') as p_value"), DB::raw("COALESCE(d_dapan.d_value, '') as biked_value"), DB::raw("COALESCE(d_rbh.r_value, '') as biker_value"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value_pensiun, '') as b_value_pensiun"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value_jht, '') as b_value_jht"), DB::raw("COALESCE(d_bpjs_kesehatan.b_value, '') as bikes_value"), DB::raw("COALESCE(r_status, '-') as statusr"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_status, '-') as statusket"), DB::raw("COALESCE(d_bpjs_kesehatan.b_status, '-') as statuskes"), DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_no, '-') as d_no"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
            )
            ->where('mp_mitra', '=', $mitra)
            ->where('mp_divisi', '=', $divisi)
            ->where('mp_isapproved', 'Y')
            ->get();

       // $p_id = [];
       //
       // for ($i=0; $i < count($pekerja); $i++) {
       //   $p_id[$i] = $pekerja[$i]->p_id;
       // }
       //
       //  $bpjskes = DB::table('d_bpjs_kesehatan')
       //              ->whereIn('b_pekerja', $p_id)
       //              ->get();
      }



          return response()->json($pekerja);
    }

    public function getdata(Request $request){
      $key = $request->term;
      $data = DB::table('d_mitra_pekerja')
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
          ->leftJoin('d_potonganlain', 'p_pekerja', '=', 'd_pekerja.p_id')
          ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
          ->join('d_mitra', 'm_id', '=', 'mp_mitra')
          ->leftJoin('d_mitra_divisi', function ($q){
              $q->on('md_mitra', '=', 'mp_mitra')
                  ->on('md_id', '=', 'mp_divisi');
          })
          ->select(
            'p_name', 'p_nip_mitra', 'd_pekerja.p_id', DB::raw("COALESCE(p_value, '') as p_value"), DB::raw("COALESCE(d_dapan.d_value, '') as biked_value"), DB::raw("COALESCE(d_rbh.r_value, '') as biker_value"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value_pensiun, '') as b_value_pensiun"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value_jht, '') as b_value_jht"), DB::raw("COALESCE(d_bpjs_kesehatan.b_value, '') as bikes_value"), DB::raw("COALESCE(r_status, '-') as statusr"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_status, '-') as statusket"), DB::raw("COALESCE(d_bpjs_kesehatan.b_status, '-') as statuskes"), DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_no, '-') as d_no"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
          )
          ->where('mp_isapproved', 'Y')
          ->where(function ($q) use ($key) {
              $q->orWhere('p_nip', 'like', '%'.$key.'%');
              $q->orWhere('p_nip_mitra', 'like', '%'.$key.'%');
              $q->orWhere('p_name', 'like', '%'.$key.'%');
          })
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
