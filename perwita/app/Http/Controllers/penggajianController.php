<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use Session;

class penggajianController extends Controller
{

    public function index(){
      $data = DB::table('d_payroll')
              ->where('d_payroll.p_status', 'P')
              ->get();

      return view('penggajian.index', compact('data'));
    }

    public function tambah(){
      $data = DB::table('d_mitra')
              ->join('d_mitra_divisi', 'md_mitra', '=', 'm_id')
              ->groupBy('m_name')
              ->get();

      return view('penggajian.tambah', compact('data'));
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
            ->select(
              'p_name', 'p_id', DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
            )
            ->where('mp_isapproved', 'Y')
            ->get();
      } elseif (!empty($mitra) && $divisi == "all") {
        $pekerja = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->leftJoin('d_bpjs_kesehatan', 'd_bpjs_kesehatan.b_pekerja', '=', 'p_id')
            ->leftJoin('d_bpjs_ketenagakerjaan', 'd_bpjs_ketenagakerjaan.b_pekerja', '=', 'p_id')
            ->leftJoin('d_rbh', 'r_pekerja', '=', 'p_id')
            ->leftJoin('d_rbh_iuran', 'd_rbh_iuran.ri_no_rbh', '=', 'd_rbh.r_no')
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select(
              'p_name', 'p_id', DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
            )
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
            ->select(
              'p_name', 'p_id', DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
            )
            ->where('mp_mitra', '=', $mitra)
            ->where('mp_divisi', '=', $divisi)
            ->where('mp_isapproved', 'Y')
            ->get();
      }



          return response()->json($pekerja);
    }

    public function simpan(Request $request){
      DB::beginTransaction();
      try {

        $id = DB::table('d_payroll')
              ->max('p_id');

        if (empty($id)) {
          $id = 0;
        }

        $kode = "";

        $querykode = DB::select(DB::raw("SELECT MAX(MID(p_no,4,5)) as counter, MAX(MID(p_no,10,2)) as bulan, MAX(MID(p_no,13)) as tahun FROM d_payroll"));

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


        $finalkode = 'PY-' . $kode . '/' . date('m') . '/' . date('Y');

        DB::table('d_payroll')
          ->insert([
            'p_id' => $id + 1,
            'p_no' => $finalkode,
            'p_date' => Carbon::now('Asia/Jakarta'),
            'p_start_periode' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
            'p_end_periode' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
            'p_status' => 'P'
          ]);

        for ($b=0; $b < count($request->p_id); $b++) {

          if ($request->totalgaji[$b] != "") {

            $tmp = str_replace('.', '', $request->totalgaji[$b]);
            $totalgaji = str_replace('Rp ', '', $tmp);

            // $check = DB::table('d_payroll')
            //           ->where('p_pekerja', $request->p_id[$b])
            //           ->get();
            //
            // if (!empty($check)) {
            //   $tmp = str_replace('.', '', $request->totalgaji[$b]);
            //   $totalgaji = str_replace('Rp ', '', $tmp);
            //
            //   DB::table('d_payroll')
            //       ->where('p_pekerja', $request->p_id[$b])
            //       ->update([
            //         'p_start_periode' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
            //         'p_end_periode' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
            //         'p_value' => $totalgaji,
            //         'p_noreff' => $request->noreff[$b],
            //         'p_status' => 'P'
            //       ]);
            // } else {


              $detailid = DB::table('d_payroll_dt')
                          ->where('pd_payroll', $id + 1)
                          ->max('pd_detailid');

              if (empty($detailid)) {
                $detailid = 0;
              }

              DB::table('d_payroll_dt')
                ->insert([
                  'pd_payroll' => $id + 1,
                  'pd_detailid' => $detailid + 1,
                  'pd_pekerja' => $request->p_id[$b],
                  'pd_value' => $totalgaji,
                  'pd_reff' => $request->noreff[$b]
                ]);
            // }
          }
        }

        for ($i=0; $i < count($request->p_id); $i++) {
          if ($request->bpjskes[$i] != "") {
            // $check1 = DB::table('d_bpjs_kesehatan')
            //         ->where('b_pekerja', $request->p_id[$i])
            //         ->get();
            //
            // $check2 = DB::table('d_bpjskes_iuran')
            //         ->where('bi_no_bpjs', $check1[0]->b_no)
            //         ->get();
            //
            // if (!empty($check2)) {
            //   $tmp = str_replace('.', '', $request->bpjskes[$i]);
            //   $bpjskes = str_replace('Rp ', '', $tmp);
            //
            //   DB::table('d_bpjskes_iuran')
            //     ->where('bi_no_bpjs', $check1[0]->b_no)
            //     ->update([
            //       'bi_value' => $bpjskes,
            //       'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
            //       'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
            //       'bi_status' => 'N',
            //       'bi_mem' => Session::get('mem')
            //     ]);
            // } else {
              $nobpjskes = DB::table('d_bpjs_kesehatan')
                            ->where('b_pekerja', $request->p_id[$i])
                            ->select('b_no')
                            ->get();

              $detailid = DB::table('d_bpjskes_iuran')
                          ->where('bi_no_bpjs', $nobpjskes[0]->b_no)
                          ->max('bi_detailid');

              $tmp = str_replace('.', '', $request->bpjskes[$i]);
              $bpjskes = str_replace('Rp ', '', $tmp);

              DB::table('d_bpjskes_iuran')
                  ->insert([
                    'bi_no_bpjs' => $nobpjskes[0]->b_no,
                    'bi_detailid' => $detailid + 1,
                    'bi_no_pay' => $finalkode,
                    'bi_value' => $bpjskes,
                    'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                    'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                    'bi_status' => 'N',
                    'bi_mem' => Session::get('mem'),
                    'bi_insert' => Carbon::now('Asia/Jakarta')
                  ]);
            // }
          }
        }

        for ($j=0; $j < count($request->p_id); $j++) {
          if ($request->bpjsket[$j] != "") {
          //   $check1 = DB::table('d_bpjs_ketenagakerjaan')
          //             ->where('b_pekerja', $request->p_id[$j])
          //             ->get();
          //
          //   $check2 = DB::table('d_bpjsket_iuran')
          //             ->where('bi_no_bpjs', $check1[0]->b_no)
          //             ->get();
          //   if (!empty($check2)) {
          //     $tmp = str_replace('.', '', $request->bpjsket[$j]);
          //     $bpjsket = str_replace('Rp ', '', $tmp);
          //
          //       DB::table('d_bpjsket_iuran')
          //         ->where('bi_no_bpjs', $check1[0]->b_no)
          //         ->update([
          //           'bi_value' => $bpjsket,
          //           'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
          //           'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
          //           'bi_status' => 'N',
          //           'bi_mem' => Session::get('mem')
          //         ]);
          //   } else {
              $nobpjsket = DB::table('d_bpjs_ketenagakerjaan')
                            ->where('b_pekerja', $request->p_id[$j])
                            ->select('b_no')
                            ->get();

              $detailid = DB::table('d_bpjsket_iuran')
                          ->where('bi_no_bpjs', $nobpjsket[0]->b_no)
                          ->max('bi_detailid');

              $tmp = str_replace('.', '', $request->bpjsket[$j]);
              $bpjsket = str_replace('Rp ', '', $tmp);

              DB::table('d_bpjsket_iuran')
                  ->insert([
                    'bi_no_bpjs' => $nobpjsket[0]->b_no,
                    'bi_detailid' => $detailid + 1,
                    'bi_no_pay' => $finalkode,
                    'bi_value' => $bpjsket,
                    'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                    'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                    'bi_status' => 'N',
                    'bi_mem' => Session::get('mem'),
                    'bi_insert' => Carbon::now('Asia/Jakarta')
                  ]);
            // }
          }
        }

        for ($z=0; $z < count($request->p_id); $z++) {
          if ($request->bpjsket[$z] != "") {
            // $check1 = DB::table('d_rbh')
            //               ->where('r_pekerja', $request->p_id[$z])
            //               ->select('r_no')
            //               ->get();
            //
            // $check2 = DB::table('d_rbh_iuran')
            //             ->where('ri_no_rbh', $norbh[0]->r_no)
            //             ->get();
            // if (!empty($check2)) {
            //   $tmp = str_replace('.', '', $request->rbh[$z]);
            //   $rbh = str_replace('Rp ', '', $tmp);
            //
            //   DB::table('d_rbh_iuran')
            //     ->where('ri_no_rbh', $norbh[0]->r_no)
            //     ->update([
            //       'ri_value' => $rbh,
            //       'ri_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
            //       'ri_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
            //       'ri_status' => 'N',
            //       'ri_mem' => Session::get('mem')
            //     ]);
            // } else {
              $norbh = DB::table('d_rbh')
                            ->where('r_pekerja', $request->p_id[$z])
                            ->select('r_no')
                            ->get();

              $detailid = DB::table('d_rbh_iuran')
                          ->where('ri_no_rbh', $norbh[0]->r_no)
                          ->max('ri_detailid');

              $tmp = str_replace('.', '', $request->rbh[$z]);
              $rbh = str_replace('Rp ', '', $tmp);

              DB::table('d_rbh_iuran')
                  ->insert([
                    'ri_no_rbh' => $norbh[0]->b_no,
                    'ri_detailid' => $detailid + 1,
                    'ri_no_pay' => $finalkode,
                    'ri_value' => $rbh,
                    'ri_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                    'ri_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                    'ri_status' => 'N',
                    'ri_mem' => Session::get('mem'),
                    'ri_insert' => Carbon::now('Asia/Jakarta')
                  ]);
            // }
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

    public function proses(Request $request){
      DB::beginTransaction();
      try {

        $id = DB::table('d_payroll')
              ->max('p_id');

        if (empty($id)) {
          $id = 0;
        }

        $kode = "";

        $querykode = DB::select(DB::raw("SELECT MAX(MID(p_no,4,5)) as counter, MAX(MID(p_no,10,2)) as bulan, MAX(MID(p_no,13)) as tahun FROM d_payroll"));

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


        $finalkode = 'PY-' . $kode . '/' . date('m') . '/' . date('Y');

        DB::table('d_payroll')
          ->insert([
            'p_id' => $id + 1,
            'p_no' => $finalkode,
            'p_date' => Carbon::now('Asia/Jakarta'),
            'p_start_periode' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
            'p_end_periode' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
            'p_status' => 'Y'
          ]);

        for ($b=0; $b < count($request->p_id); $b++) {

          if ($request->totalgaji[$b] != "") {

            $tmp = str_replace('.', '', $request->totalgaji[$b]);
            $totalgaji = str_replace('Rp ', '', $tmp);

            // $check = DB::table('d_payroll')
            //           ->where('p_pekerja', $request->p_id[$b])
            //           ->get();
            //
            // if (!empty($check)) {
            //   $tmp = str_replace('.', '', $request->totalgaji[$b]);
            //   $totalgaji = str_replace('Rp ', '', $tmp);
            //
            //   DB::table('d_payroll')
            //       ->where('p_pekerja', $request->p_id[$b])
            //       ->update([
            //         'p_start_periode' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
            //         'p_end_periode' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
            //         'p_value' => $totalgaji,
            //         'p_noreff' => $request->noreff[$b],
            //         'p_status' => 'P'
            //       ]);
            // } else {


              $detailid = DB::table('d_payroll_dt')
                          ->where('pd_payroll', $id + 1)
                          ->max('pd_detailid');

              if (empty($detailid)) {
                $detailid = 0;
              }

              DB::table('d_payroll_dt')
                ->insert([
                  'pd_payroll' => $id + 1,
                  'pd_detailid' => $detailid + 1,
                  'pd_pekerja' => $request->p_id[$b],
                  'pd_value' => $totalgaji,
                  'pd_reff' => $request->noreff[$b]
                ]);
            // }
          }
        }

        for ($i=0; $i < count($request->p_id); $i++) {
          if ($request->bpjskes[$i] != "") {
            // $check1 = DB::table('d_bpjs_kesehatan')
            //         ->where('b_pekerja', $request->p_id[$i])
            //         ->get();
            //
            // $check2 = DB::table('d_bpjskes_iuran')
            //         ->where('bi_no_bpjs', $check1[0]->b_no)
            //         ->get();
            //
            // if (!empty($check2)) {
            //   $tmp = str_replace('.', '', $request->bpjskes[$i]);
            //   $bpjskes = str_replace('Rp ', '', $tmp);
            //
            //   DB::table('d_bpjskes_iuran')
            //     ->where('bi_no_bpjs', $check1[0]->b_no)
            //     ->update([
            //       'bi_value' => $bpjskes,
            //       'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
            //       'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
            //       'bi_status' => 'N',
            //       'bi_mem' => Session::get('mem')
            //     ]);
            // } else {
              $nobpjskes = DB::table('d_bpjs_kesehatan')
                            ->where('b_pekerja', $request->p_id[$i])
                            ->select('b_no')
                            ->get();

              $detailid = DB::table('d_bpjskes_iuran')
                          ->where('bi_no_bpjs', $nobpjskes[0]->b_no)
                          ->max('bi_detailid');

              $tmp = str_replace('.', '', $request->bpjskes[$i]);
              $bpjskes = str_replace('Rp ', '', $tmp);

              DB::table('d_bpjskes_iuran')
                  ->insert([
                    'bi_no_bpjs' => $nobpjskes[0]->b_no,
                    'bi_detailid' => $detailid + 1,
                    'bi_no_pay' => $finalkode,
                    'bi_value' => $bpjskes,
                    'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                    'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                    'bi_status' => 'Y',
                    'bi_mem' => Session::get('mem'),
                    'bi_insert' => Carbon::now('Asia/Jakarta')
                  ]);
            // }
          }
        }

        for ($j=0; $j < count($request->p_id); $j++) {
          if ($request->bpjsket[$j] != "") {
          //   $check1 = DB::table('d_bpjs_ketenagakerjaan')
          //             ->where('b_pekerja', $request->p_id[$j])
          //             ->get();
          //
          //   $check2 = DB::table('d_bpjsket_iuran')
          //             ->where('bi_no_bpjs', $check1[0]->b_no)
          //             ->get();
          //   if (!empty($check2)) {
          //     $tmp = str_replace('.', '', $request->bpjsket[$j]);
          //     $bpjsket = str_replace('Rp ', '', $tmp);
          //
          //       DB::table('d_bpjsket_iuran')
          //         ->where('bi_no_bpjs', $check1[0]->b_no)
          //         ->update([
          //           'bi_value' => $bpjsket,
          //           'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
          //           'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
          //           'bi_status' => 'N',
          //           'bi_mem' => Session::get('mem')
          //         ]);
          //   } else {
              $nobpjsket = DB::table('d_bpjs_ketenagakerjaan')
                            ->where('b_pekerja', $request->p_id[$j])
                            ->select('b_no')
                            ->get();

              $detailid = DB::table('d_bpjsket_iuran')
                          ->where('bi_no_bpjs', $nobpjsket[0]->b_no)
                          ->max('bi_detailid');

              $tmp = str_replace('.', '', $request->bpjsket[$j]);
              $bpjsket = str_replace('Rp ', '', $tmp);

              DB::table('d_bpjsket_iuran')
                  ->insert([
                    'bi_no_bpjs' => $nobpjsket[0]->b_no,
                    'bi_detailid' => $detailid + 1,
                    'bi_no_pay' => $finalkode,
                    'bi_value' => $bpjsket,
                    'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                    'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                    'bi_status' => 'Y',
                    'bi_mem' => Session::get('mem'),
                    'bi_insert' => Carbon::now('Asia/Jakarta')
                  ]);
            // }
          }
        }

        for ($z=0; $z < count($request->p_id); $z++) {
          if ($request->bpjsket[$z] != "") {
            // $check1 = DB::table('d_rbh')
            //               ->where('r_pekerja', $request->p_id[$z])
            //               ->select('r_no')
            //               ->get();
            //
            // $check2 = DB::table('d_rbh_iuran')
            //             ->where('ri_no_rbh', $norbh[0]->r_no)
            //             ->get();
            // if (!empty($check2)) {
            //   $tmp = str_replace('.', '', $request->rbh[$z]);
            //   $rbh = str_replace('Rp ', '', $tmp);
            //
            //   DB::table('d_rbh_iuran')
            //     ->where('ri_no_rbh', $norbh[0]->r_no)
            //     ->update([
            //       'ri_value' => $rbh,
            //       'ri_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
            //       'ri_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
            //       'ri_status' => 'N',
            //       'ri_mem' => Session::get('mem')
            //     ]);
            // } else {
              $norbh = DB::table('d_rbh')
                            ->where('r_pekerja', $request->p_id[$z])
                            ->select('r_no')
                            ->get();

              $detailid = DB::table('d_rbh_iuran')
                          ->where('ri_no_rbh', $norbh[0]->r_no)
                          ->max('ri_detailid');

              $tmp = str_replace('.', '', $request->rbh[$z]);
              $rbh = str_replace('Rp ', '', $tmp);

              DB::table('d_rbh_iuran')
                  ->insert([
                    'ri_no_rbh' => $norbh[0]->b_no,
                    'ri_detailid' => $detailid + 1,
                    'ri_no_pay' => $finalkode,
                    'ri_value' => $rbh,
                    'ri_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                    'ri_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                    'ri_status' => 'Y',
                    'ri_mem' => Session::get('mem'),
                    'ri_insert' => Carbon::now('Asia/Jakarta')
                  ]);
            // }
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

    public function hapus(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_payroll')
          ->where('p_no', $request->nota)
          ->delete();

        DB::table('d_bpjskes_iuran')
          ->where('bi_no_pay', $request->nota)
          ->delete();

        DB::table('d_bpjsket_iuran')
          ->where('bi_no_pay', $request->nota)
          ->delete();

        DB::table('d_rbh_iuran')
          ->where('ri_no_pay', $request->nota)
          ->delete();

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

    public function edit(Request $request){
      $nota = $request->nota;

      return view('penggajian.lanjutkan', compact('nota'));
    }

    public function editval(Request $request){
      $data = DB::table('d_payroll')
              ->join('d_payroll_dt', 'pd_payroll', '=', 'd_payroll.p_id')
              ->join('d_pekerja', 'd_pekerja.p_id', '=', 'pd_pekerja')
              ->join('d_mitra_pekerja', 'mp_pekerja', '=', 'pd_pekerja')
              ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
              ->join('d_mitra', 'm_id', '=', 'mp_mitra')
              ->leftJoin('d_mitra_divisi', function ($q){
                  $q->on('md_mitra', '=', 'mp_mitra')
                      ->on('md_id', '=', 'mp_divisi');
              })
              ->leftJoin('d_bpjs_kesehatan', 'd_bpjs_kesehatan.b_pekerja', '=', 'pd_pekerja')
              ->leftJoin('d_bpjs_ketenagakerjaan', 'd_bpjs_ketenagakerjaan.b_pekerja', '=', 'pd_pekerja')
              ->leftJoin('d_rbh', 'r_pekerja', '=', 'pd_pekerja')
              ->leftJoin('d_bpjskes_iuran',  function($e){
                $e->on('d_bpjskes_iuran.bi_no_bpjs', '=', 'd_bpjs_kesehatan.b_no')
                  ->on('d_bpjskes_iuran.bi_no_pay', '=', 'p_no');
              })
              ->leftJoin('d_bpjsket_iuran', function($e){
                $e->on('d_bpjsket_iuran.bi_no_bpjs', '=', 'd_bpjs_ketenagakerjaan.b_no')
                  ->on('d_bpjsket_iuran.bi_no_pay', '=', 'p_no');
              })
              ->leftJoin('d_rbh_iuran', function($e){
                $e->on('d_rbh_iuran.ri_no_rbh', '=', 'd_rbh.r_no')
                  ->on('d_rbh_iuran.ri_no_pay', '=', 'p_no');
              })
              ->select(
                'p_name', 'd_pekerja.p_id', DB::raw("COALESCE(d_rbh_iuran.ri_value, '') as ri_value"), DB::raw("COALESCE(d_bpjskes_iuran.bi_value, '') as bikes_value"), DB::raw("COALESCE(d_bpjsket_iuran.bi_value, '') as biket_value"), DB::raw("COALESCE(pd_value, '') as p_value"), DB::raw("COALESCE(pd_reff, '') as p_noreff"), DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
              )
              ->where('p_no', $request->nota)
              ->where('mp_isapproved', 'Y')
              ->get();

      return response()->json($data);
    }
}
