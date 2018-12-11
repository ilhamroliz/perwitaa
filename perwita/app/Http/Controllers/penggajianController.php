<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use Session;

use Terbilang;

use App\Http\Controllers\AksesUser;

class penggajianController extends Controller
{

    public function index(){
      if (!AksesUser::checkAkses(60, 'read')) {
          return redirect('not-authorized');
      }
      $data = DB::table('d_mitra')
              ->join('d_mitra_divisi', 'md_mitra', '=', 'm_id')
              ->groupBy('m_name')
              ->get();

      return view('penggajian.index', compact('data'));
    }

    public function tambah(){
      if (!AksesUser::checkAkses(60, 'insert')) {
          return redirect('not-authorized');
      }
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
            ->select(
              'p_name', 'p_id', 'p_gaji_pokok', 'p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport', DB::raw("COALESCE(d_dapan.d_value, '') as biked_value"), DB::raw("COALESCE(d_rbh.r_value, '') as biker_value"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value, '') as biket_value"), DB::raw("COALESCE(d_bpjs_kesehatan.b_value, '') as bikes_value"), DB::raw("COALESCE(d_status, '-') as ansuransi"), DB::raw("COALESCE(d_status, '-') as tunjangan"), DB::raw("COALESCE(d_status, '-') as statusd"), DB::raw("COALESCE(r_status, '-') as statusr"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_status, '-') as statusket"), DB::raw("COALESCE(d_bpjs_kesehatan.b_status, '-') as statuskes"), DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_no, '-') as d_no"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
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
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select(
              'p_name', 'p_id', 'p_gaji_pokok', 'p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport', DB::raw("COALESCE(d_dapan.d_value, '') as biked_value"), DB::raw("COALESCE(d_rbh.r_value, '') as biker_value"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value, '') as biket_value"), DB::raw("COALESCE(d_bpjs_kesehatan.b_value, '') as bikes_value"), DB::raw("COALESCE(d_status, '-') as ansuransi"), DB::raw("COALESCE(d_status, '-') as tunjangan"), DB::raw("COALESCE(d_status, '-') as statusd"), DB::raw("COALESCE(r_status, '-') as statusr"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_status, '-') as statusket"), DB::raw("COALESCE(d_bpjs_kesehatan.b_status, '-') as statuskes"), DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_no, '-') as d_no"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
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
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra')
                    ->on('md_id', '=', 'mp_divisi');
            })
            ->select(
              'p_name', 'p_id', 'p_gaji_pokok', 'p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport', DB::raw("COALESCE(d_dapan.d_value, '') as biked_value"), DB::raw("COALESCE(d_rbh.r_value, '') as biker_value"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value, '') as biket_value"), DB::raw("COALESCE(d_bpjs_kesehatan.b_value, '') as bikes_value"), DB::raw("COALESCE(d_status, '-') as ansuransi"), DB::raw("COALESCE(d_status, '-') as tunjangan"), DB::raw("COALESCE(d_status, '-') as statusd"), DB::raw("COALESCE(r_status, '-') as statusr"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_status, '-') as statusket"), DB::raw("COALESCE(d_bpjs_kesehatan.b_status, '-') as statuskes"), DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_no, '-') as d_no"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
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

      for ($i=0; $i < count($pekerja); $i++) {
        $pekerja[$i]->tunjangan = (int)$pekerja[$i]->p_tjg_makan + (int)$pekerja[$i]->p_tjg_jabatan + (int)$pekerja[$i]->p_tjg_transport;
        $pekerja[$i]->ansuransi = (int)$pekerja[$i]->bikes_value + (int)$pekerja[$i]->biket_value + (int)$pekerja[$i]->biker_value + (int)$pekerja[$i]->biked_value;
        $pekerja[$i]->p_gaji_pokok = (int)$pekerja[$i]->p_gaji_pokok;
      }



          return response()->json($pekerja);
    }

    public function simpan(Request $request){
      if (!AksesUser::checkAkses(60, 'insert')) {
          return redirect('not-authorized');
      }
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

          for ($i=0; $i < count($request->p_id); $i++) {
            $detailid = DB::table('d_payroll_dt')
                        ->where('pd_payroll', $id + 1)
                        ->max('pd_detailid');

                $gajipokok = DB::table('d_pekerja')
                                ->where('p_id', $request->p_id[$i])
                                ->select('p_gaji_pokok')
                                ->get();

                $tunjangan = DB::table('d_pekerja')
                                ->where('p_id', $request->p_id[$i])
                                ->select('p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport')
                                ->get();

                $kesehatan = DB::table('d_bpjs_kesehatan')
                                ->where('b_pekerja', $request->p_id[$i])
                                ->where('b_status', 'Y')
                                ->select('b_value')
                                ->get();

                $ketenagakerjaan = DB::table('d_bpjs_ketenagakerjaan')
                                ->where('b_pekerja', $request->p_id[$i])
                                ->where('b_status', 'Y')
                                ->select('b_value')
                                ->get();

                $rbh = DB::table('d_rbh')
                                ->where('r_pekerja', $request->p_id[$i])
                                ->where('r_status', 'Y')
                                ->select('r_value')
                                ->get();

                $dapan = DB::table('d_dapan')
                                ->where('d_pekerja', $request->p_id[$i])
                                ->where('d_status', 'Y')
                                ->select('d_value')
                                ->get();

                if (empty($rbh)) {
                  $rbhinsert = 0;
                } else {
                  $rbhinsert = $rbh[0]->r_value;
                }

                if (empty($ketenagakerjaan)) {
                  $ketenagakerjaaninsert = 0;
                } else {
                  $ketenagakerjaaninsert = $ketenagakerjaan[0]->b_value;
                }

                if (empty($dapan)) {
                  $dapaninsert = 0;
                } else {
                  $dapaninsert = $dapan[0]->d_value;
                }

                if (empty($kesehatan)) {
                  $kesehataninsert = 0;
                } else {
                  $kesehataninsert = $kesehatan[0]->b_value;
                }

                $tmp = str_replace('.', '', $request->potonganlain[$i]);
                $potonganlain = str_replace('Rp ', '', $tmp);

                $tmp1 = str_replace('.', '', $request->totalgaji[$i]);
                $totalgaji = str_replace('Rp ', '', $tmp1);

            DB::table('d_payroll_dt')
              ->insert([
                'pd_payroll' => $id + 1,
                'pd_detailid' => $detailid + 1,
                'pd_pekerja' => $request->p_id[$i],
                'pd_gaji_pokok' => $gajipokok[0]->p_gaji_pokok,
                'pd_tjg_jabatan' => $tunjangan[0]->p_tjg_jabatan,
                'pd_tjg_makan' => $tunjangan[0]->p_tjg_makan,
                'pd_tjg_transport' => $tunjangan[0]->p_tjg_transport,
                'pd_bpjs_kes' => $kesehataninsert,
                'pd_bpjs_tk' => $ketenagakerjaaninsert,
                'pd_bpjs_rbh' => $rbhinsert,
                'pd_bpjs_dapan' => $dapaninsert,
                'pd_lain' => $potonganlain,
                'pd_reff' => $request->noreff[$i],
                'pd_total' => $totalgaji,
                'pd_note' => $request->Keterangan[$i]
              ]);

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
      if (!AksesUser::checkAkses(60, 'insert')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        for ($z=0; $z < count($request->p_id); $z++) {
          if ($request->gajipokok[$z] == 'Rp. 0') {
             return response()->json([
               'status' => 'tidak lengkap'
             ]);
          }
          else if ($request->tunjangan[$z] == 'Rp. 0') {
             return response()->json([
               'status' => 'tidak lengkap'
             ]);
          }
          else if ($request->ansuransi[$z] == 'Rp. 0') {
             return response()->json([
               'status' => 'tidak lengkap'
             ]);
          }
          else if ($request->total[$z] == 'Rp. 0') {
             return response()->json([
               'status' => 'tidak lengkap'
             ]);
          } else {
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

              for ($i=0; $i < count($request->p_id); $i++) {
                $detailid = DB::table('d_payroll_dt')
                            ->where('pd_payroll', $id + 1)
                            ->max('pd_detailid');

                    $gajipokok = DB::table('d_pekerja')
                                    ->where('p_id', $request->p_id[$i])
                                    ->select('p_gaji_pokok')
                                    ->get();

                    $tunjangan = DB::table('d_pekerja')
                                    ->where('p_id', $request->p_id[$i])
                                    ->select('p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport')
                                    ->get();

                    $kesehatan = DB::table('d_bpjs_kesehatan')
                                    ->where('b_pekerja', $request->p_id[$i])
                                    ->where('b_status', 'Y')
                                    ->select('b_value')
                                    ->get();

                    $ketenagakerjaan = DB::table('d_bpjs_ketenagakerjaan')
                                    ->where('b_pekerja', $request->p_id[$i])
                                    ->where('b_status', 'Y')
                                    ->select('b_value', 'b_value_jht', 'b_value_pensiun')
                                    ->get();

                    $rbh = DB::table('d_rbh')
                                    ->where('r_pekerja', $request->p_id[$i])
                                    ->where('r_status', 'Y')
                                    ->select('r_value')
                                    ->get();

                    $dapan = DB::table('d_dapan')
                                    ->where('d_pekerja', $request->p_id[$i])
                                    ->where('d_status', 'Y')
                                    ->select('d_value')
                                    ->get();

                    if (empty($rbh)) {
                      $rbhinsert = 0;
                    } else {
                      $rbhinsert = $rbh[0]->r_value;
                    }

                    if (empty($ketenagakerjaan[0]->b_value)) {
                      $ketenagakerjaaninsert = 0;
                    } else {
                      $ketenagakerjaaninsert = $ketenagakerjaan[0]->b_value;
                    }

                    if (empty($ketenagakerjaan[0]->b_value_jht)) {
                      $ketenagakerjaaninsertjht = 0;
                    } else {
                      $ketenagakerjaaninsertjht = $ketenagakerjaan[0]->b_value_jht;
                    }

                    if (empty($ketenagakerjaan[0]->b_value_pensiun)) {
                      $ketenagakerjaaninsertpensiun = 0;
                    } else {
                      $ketenagakerjaaninsertpensiun = $ketenagakerjaan[0]->b_value_pensiun;
                    }

                    if (empty($dapan)) {
                      $dapaninsert = 0;
                    } else {
                      $dapaninsert = $dapan[0]->d_value;
                    }

                    if (empty($kesehatan)) {
                      $kesehataninsert = 0;
                    } else {
                      $kesehataninsert = $kesehatan[0]->b_value;
                    }

                    $tmp = str_replace('.', '', $request->potonganlain[$i]);
                    $potonganlain = str_replace('Rp. ', '', $tmp);

                    $tmp1 = str_replace('.', '', $request->total[$i]);
                    $total = str_replace('Rp. ', '', $tmp1);

                DB::table('d_payroll_dt')
                  ->insert([
                    'pd_payroll' => $id + 1,
                    'pd_detailid' => $detailid + 1,
                    'pd_pekerja' => $request->p_id[$i],
                    'pd_gaji_pokok' => $gajipokok[0]->p_gaji_pokok,
                    'pd_tjg_jabatan' => $tunjangan[0]->p_tjg_jabatan,
                    'pd_tjg_makan' => $tunjangan[0]->p_tjg_makan,
                    'pd_tjg_transport' => $tunjangan[0]->p_tjg_transport,
                    'pd_bpjs_kes' => $kesehataninsert,
                    'pd_bpjs_tk' => $ketenagakerjaaninsert,
                    'pd_bpjs_tk_jht' => $ketenagakerjaaninsertjht,
                    'pd_bpjs_tk_pensiun' => $ketenagakerjaaninsertpensiun,
                    'pd_bpjs_rbh' => $rbhinsert,
                    'pd_bpjs_dapan' => $dapaninsert,
                    'pd_lain' => $potonganlain,
                    'pd_reff' => $request->noreff[$i],
                    'pd_total' => $total,
                    'pd_note' => $request->Keterangan[$i]
                  ]);

                  if ($kesehataninsert != 0) {
                    $bpjskes = DB::table('d_bpjs_kesehatan')
                                      ->where('b_pekerja', $request->p_id[$i])
                                      ->where('b_status', 'Y')
                                      ->get();

                    $detailid = DB::table('d_bpjskes_iuran')
                                ->where('bi_no_bpjs', $bpjskes[0]->b_no)
                                ->max("bi_detailid");

                                if ($detailid == null) {
                                  $detailid = 0;
                                }

                      DB::table('d_bpjskes_iuran')
                        ->insert([
                          'bi_no_bpjs' => $bpjskes[0]->b_no,
                          'bi_detailid' => $detailid + 1,
                          'bi_no_pay' => $finalkode,
                          'bi_value' => $kesehataninsert,
                          'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                          'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                          'bi_status' => 'Y',
                          'bi_mem' => Session::get('mem'),
                          'bi_insert' => Carbon::now('Asia/Jakarta')
                        ]);
                  }

                  if ($ketenagakerjaaninsert != 0) {
                    $bpjsket = DB::table('d_bpjs_ketenagakerjaan')
                                      ->where('b_pekerja', $request->p_id[$i])
                                      ->where('b_status', 'Y')
                                      ->get();

                    $detailid = DB::table('d_bpjsket_iuran')
                                ->where('bi_no_bpjs', $bpjsket[0]->b_no)
                                ->max("bi_detailid");

                                if ($detailid == null) {
                                  $detailid = 0;
                                }

                      DB::table('d_bpjsket_iuran')
                        ->insert([
                          'bi_no_bpjs' => $bpjsket[0]->b_no,
                          'bi_detailid' => $detailid + 1,
                          'bi_no_pay' => $finalkode,
                          'bi_value' => $ketenagakerjaaninsert,
                          'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                          'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                          'bi_status' => 'Y',
                          'bi_mem' => Session::get('mem'),
                          'bi_insert' => Carbon::now('Asia/Jakarta')
                        ]);
                  }

                  if ($rbhinsert != 0) {
                    $rbh = DB::table('d_rbh')
                                      ->where('r_pekerja', $request->p_id[$i])
                                      ->where('r_status', 'Y')
                                      ->get();

                    $detailid = DB::table('d_rbh_iuran')
                                ->where('ri_no_rbh', $rbh[0]->r_no)
                                ->max("ri_detailid");

                                if ($detailid == null) {
                                  $detailid = 0;
                                }

                      DB::table('d_rbh_iuran')
                        ->insert([
                          'ri_no_rbh' => $rbh[0]->r_no,
                          'ri_detailid' => $detailid + 1,
                          'ri_no_pay' => $finalkode,
                          'ri_value' => $rbhinsert,
                          'ri_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                          'ri_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                          'ri_status' => 'Y',
                          'ri_mem' => Session::get('mem'),
                          'ri_insert' => Carbon::now('Asia/Jakarta')
                        ]);
                  }

                  if ($dapaninsert != 0) {
                    $dapan = DB::table('d_dapan')
                                      ->where('d_pekerja', $request->p_id[$i])
                                      ->where('d_status', 'Y')
                                      ->get();

                    $detailid = DB::table('d_dapan_iuran')
                                ->where('di_no_dapan', $dapan[0]->d_no)
                                ->max("di_detailid");

                                if ($detailid == null) {
                                  $detailid = 0;
                                }

                      DB::table('d_dapan_iuran')
                        ->insert([
                          'di_no_dapan' => $dapan[0]->d_no,
                          'di_detailid' => $detailid + 1,
                          'di_no_pay' => $finalkode,
                          'di_value' => $dapaninsert,
                          'di_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                          'di_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                          'di_status' => 'Y',
                          'di_mem' => Session::get('mem'),
                          'di_insert' => Carbon::now('Asia/Jakarta')
                        ]);
                  }

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

    public function edit(Request $request){
      if (!AksesUser::checkAkses(60, 'update')) {
          return redirect('not-authorized');
      }
      $nota = $request->nota;

      return view('penggajian.lanjutkan', compact('nota'));
    }

    public function editval(Request $request){
      if (!AksesUser::checkAkses(60, 'update')) {
          return redirect('not-authorized');
      }
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
              ->leftJoin('d_bpjs_kesehatan', function($q){
                $q->on('d_bpjs_kesehatan.b_pekerja', '=', 'pd_pekerja');
                $q->where('d_bpjs_kesehatan.b_status', '=', 'Y');
              })
              ->leftJoin('d_bpjs_ketenagakerjaan', function($e){
                $e->on('d_bpjs_ketenagakerjaan.b_pekerja', '=', 'pd_pekerja')
                  ->where('d_bpjs_ketenagakerjaan.b_status', '=', 'Y');
              })
              ->leftJoin('d_rbh', function($z){
                $z->on('r_pekerja', '=', 'pd_pekerja')
                  ->where('r_status', '=', 'Y');
              })
              ->leftJoin('d_dapan', function($z){
                $z->on('d_pekerja', '=', 'pd_pekerja')
                  ->where('d_status', '=', 'Y');
              })
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
              ->leftJoin('d_dapan_iuran', function($e){
                $e->on('d_dapan_iuran.di_no_dapan', '=', 'd_dapan.d_no')
                  ->on('d_dapan_iuran.di_no_pay', '=', 'p_no');
              })
              ->select(
                'p_name', 'pd_lain', 'pd_total', 'pd_reff', 'pd_note', 'd_pekerja.p_id', 'p_gaji_pokok', 'p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport', DB::raw("COALESCE(d_dapan.d_value, '') as biked_value"), DB::raw("COALESCE(d_rbh.r_value, '') as biker_value"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value, '') as biket_value"), DB::raw("COALESCE(d_bpjs_kesehatan.b_value, '') as bikes_value"), DB::raw("COALESCE(d_status, '-') as ansuransi"), DB::raw("COALESCE(d_status, '-') as tunjangan"), DB::raw("COALESCE(d_status, '-') as statusd"), DB::raw("COALESCE(r_status, '-') as statusr"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_status, '-') as statusket"), DB::raw("COALESCE(d_bpjs_kesehatan.b_status, '-') as statuskes"), DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_no, '-') as d_no"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
              )
              ->where('p_no', $request->nota)
              ->where('mp_isapproved', 'Y')
              ->get();

              for ($i=0; $i < count($data); $i++) {
                $data[$i]->tunjangan = (int)$data[$i]->p_tjg_makan + (int)$data[$i]->p_tjg_jabatan + (int)$data[$i]->p_tjg_transport;
                $data[$i]->ansuransi = (int)$data[$i]->bikes_value + (int)$data[$i]->biket_value + (int)$data[$i]->biker_value + (int)$data[$i]->biked_value;
                $data[$i]->p_gaji_pokok = (int)$data[$i]->p_gaji_pokok;
              }

      return response()->json($data);
    }

    public function printbank(Request $request){
      $data = DB::table('d_payroll')
              ->join('d_payroll_dt', 'pd_payroll', '=', 'd_payroll.p_id')
              ->join('d_pekerja', 'd_pekerja.p_id', '=', 'pd_pekerja')
              ->select('p_name', 'p_norek', 'pd_total', 'pd_reff')
              ->where('p_no', $request->nota)
              ->get();

      return view('penggajian.printbank', compact('data'));
    }

    public function printpekerja(Request $request){
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
              ->leftJoin('d_bpjs_kesehatan', function($q){
                $q->on('d_bpjs_kesehatan.b_pekerja', '=', 'd_pekerja.p_id');
                $q->where('d_bpjs_kesehatan.b_status', '=', 'Y');
              })
              ->leftJoin('d_bpjs_ketenagakerjaan', function($e){
                $e->on('d_bpjs_ketenagakerjaan.b_pekerja', '=', 'd_pekerja.p_id')
                  ->where('d_bpjs_ketenagakerjaan.b_status', '=', 'Y');
              })
              ->leftJoin('d_rbh', function($z){
                $z->on('r_pekerja', '=', 'd_pekerja.p_id')
                  ->where('r_status', '=', 'Y');
              })
              ->leftJoin('d_dapan', function($z){
                $z->on('d_pekerja', '=', 'd_pekerja.p_id')
                  ->where('d_status', '=', 'Y');
              })
              ->select(
                'p_name', 'p_tjg_transport', 'p_tjg_makan', 'p_tjg_jabatan', 'pd_note', 'pd_total', 'p_nip_mitra', 'd_pekerja.p_id', 'p_gaji_pokok', 'p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport', DB::raw("COALESCE(d_dapan.d_value, '') as biked_value"), DB::raw("COALESCE(d_rbh.r_value, '') as biker_value"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value, '') as biket_value"), DB::raw("COALESCE(d_bpjs_kesehatan.b_value, '') as bikes_value"), DB::raw("COALESCE(d_status, '-') as ansuransi"), DB::raw("COALESCE(d_status, '-') as tunjangan"), DB::raw("COALESCE(d_status, '-') as statusd"), DB::raw("COALESCE(r_status, '-') as statusr"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_status, '-') as statusket"), DB::raw("COALESCE(d_bpjs_kesehatan.b_status, '-') as statuskes"), DB::raw("COALESCE(p_nip, '-') as p_nip"), DB::raw("COALESCE(d_bpjs_kesehatan.b_no, '-') as b_nokes"), DB::raw("COALESCE(d_no, '-') as d_no"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_no, '-') as b_noket"), DB::raw("COALESCE(d_rbh.r_no, '-') as r_no")
              )
              ->where('p_no', $request->nota)
              ->where('mp_isapproved', 'Y')
              ->get();

        return view('penggajian.printpekerja', compact('data'));
    }

    public function simpanedit(Request $request){
      if (!AksesUser::checkAkses(60, 'update')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        $id = DB::table('d_payroll')
              ->where('p_no', $request->nota)
              ->get();

        DB::table('d_payroll')
          ->where('p_no', $request->nota)
          ->delete();

        DB::table('d_payroll_dt')
          ->where('pd_payroll', $id[0]->p_id)
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

        DB::table('d_dapan_iuran')
          ->where('di_no_pay', $request->nota)
          ->delete();

          DB::table('d_payroll')
            ->insert([
              'p_id' => $id[0]->p_id,
              'p_no' => $request->nota,
              'p_date' => Carbon::now('Asia/Jakarta'),
              'p_start_periode' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
              'p_end_periode' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
              'p_status' => 'P'
            ]);

            for ($i=0; $i < count($request->p_id); $i++) {
              $detailid = DB::table('d_payroll_dt')
                          ->where('pd_payroll', $id[0]->p_id)
                          ->max('pd_detailid');

                  $gajipokok = DB::table('d_pekerja')
                                  ->where('p_id', $request->p_id[$i])
                                  ->select('p_gaji_pokok')
                                  ->get();

                  $tunjangan = DB::table('d_pekerja')
                                  ->where('p_id', $request->p_id[$i])
                                  ->select('p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport')
                                  ->get();

                  $kesehatan = DB::table('d_bpjs_kesehatan')
                                  ->where('b_pekerja', $request->p_id[$i])
                                  ->where('b_status', 'Y')
                                  ->select('b_value')
                                  ->get();

                  $ketenagakerjaan = DB::table('d_bpjs_ketenagakerjaan')
                                  ->where('b_pekerja', $request->p_id[$i])
                                  ->where('b_status', 'Y')
                                  ->select('b_value')
                                  ->get();

                  $rbh = DB::table('d_rbh')
                                  ->where('r_pekerja', $request->p_id[$i])
                                  ->where('r_status', 'Y')
                                  ->select('r_value')
                                  ->get();

                  $dapan = DB::table('d_dapan')
                                  ->where('d_pekerja', $request->p_id[$i])
                                  ->where('d_status', 'Y')
                                  ->select('d_value')
                                  ->get();

                  if (empty($rbh)) {
                    $rbhinsert = 0;
                  } else {
                    $rbhinsert = $rbh[0]->r_value;
                  }

                  if (empty($ketenagakerjaan)) {
                    $ketenagakerjaaninsert = 0;
                  } else {
                    $ketenagakerjaaninsert = $ketenagakerjaan[0]->b_value;
                  }

                  if (empty($dapan)) {
                    $dapaninsert = 0;
                  } else {
                    $dapaninsert = $dapan[0]->d_value;
                  }

                  if (empty($kesehatan)) {
                    $kesehataninsert = 0;
                  } else {
                    $kesehataninsert = $kesehatan[0]->b_value;
                  }

                  $tmp = str_replace('.', '', $request->potonganlain[$i]);
                  $potonganlain = str_replace('Rp ', '', $tmp);

                  $tmp1 = str_replace('.', '', $request->totalgaji[$i]);
                  $totalgaji = str_replace('Rp ', '', $tmp1);

              DB::table('d_payroll_dt')
                ->insert([
                  'pd_payroll' => $id[0]->p_id,
                  'pd_detailid' => $detailid + 1,
                  'pd_pekerja' => $request->p_id[$i],
                  'pd_gaji_pokok' => $gajipokok[0]->p_gaji_pokok,
                  'pd_tjg_jabatan' => $tunjangan[0]->p_tjg_jabatan,
                  'pd_tjg_makan' => $tunjangan[0]->p_tjg_makan,
                  'pd_tjg_transport' => $tunjangan[0]->p_tjg_transport,
                  'pd_bpjs_kes' => $kesehataninsert,
                  'pd_bpjs_tk' => $ketenagakerjaaninsert,
                  'pd_bpjs_rbh' => $rbhinsert,
                  'pd_bpjs_dapan' => $dapaninsert,
                  'pd_lain' => $potonganlain,
                  'pd_reff' => $request->noreff[$i],
                  'pd_total' => $totalgaji,
                  'pd_note' => $request->Keterangan[$i]
                ]);

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

    public function prosesedit(Request $request){
      if (!AksesUser::checkAkses(60, 'update')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        $id = DB::table('d_payroll')
              ->where('p_no', $request->nota)
              ->get();

        DB::table('d_payroll')
          ->where('p_no', $request->nota)
          ->delete();

        DB::table('d_payroll_dt')
          ->where('pd_payroll', $id[0]->p_id)
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

          DB::table('d_payroll')
            ->insert([
              'p_id' => $id[0]->p_id,
              'p_no' => $request->nota,
              'p_date' => Carbon::now('Asia/Jakarta'),
              'p_start_periode' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
              'p_end_periode' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
              'p_status' => 'Y'
            ]);

            for ($i=0; $i < count($request->p_id); $i++) {
              $detailid = DB::table('d_payroll_dt')
                          ->where('pd_payroll', $id[0]->p_id)
                          ->max('pd_detailid');

                  $gajipokok = DB::table('d_pekerja')
                                  ->where('p_id', $request->p_id[$i])
                                  ->select('p_gaji_pokok')
                                  ->get();

                  $tunjangan = DB::table('d_pekerja')
                                  ->where('p_id', $request->p_id[$i])
                                  ->select('p_tjg_jabatan', 'p_tjg_makan', 'p_tjg_transport')
                                  ->get();

                  $kesehatan = DB::table('d_bpjs_kesehatan')
                                  ->where('b_pekerja', $request->p_id[$i])
                                  ->where('b_status', 'Y')
                                  ->select('b_value')
                                  ->get();

                  $ketenagakerjaan = DB::table('d_bpjs_ketenagakerjaan')
                                  ->where('b_pekerja', $request->p_id[$i])
                                  ->where('b_status', 'Y')
                                  ->select('b_value')
                                  ->get();

                  $rbh = DB::table('d_rbh')
                                  ->where('r_pekerja', $request->p_id[$i])
                                  ->where('r_status', 'Y')
                                  ->select('r_value')
                                  ->get();

                  $dapan = DB::table('d_dapan')
                                  ->where('d_pekerja', $request->p_id[$i])
                                  ->where('d_status', 'Y')
                                  ->select('d_value')
                                  ->get();

                  if (empty($rbh)) {
                    $rbhinsert = 0;
                  } else {
                    $rbhinsert = $rbh[0]->r_value;
                  }

                  if (empty($ketenagakerjaan)) {
                    $ketenagakerjaaninsert = 0;
                  } else {
                    $ketenagakerjaaninsert = $ketenagakerjaan[0]->b_value;
                  }

                  if (empty($dapan)) {
                    $dapaninsert = 0;
                  } else {
                    $dapaninsert = $dapan[0]->d_value;
                  }

                  if (empty($kesehatan)) {
                    $kesehataninsert = 0;
                  } else {
                    $kesehataninsert = $kesehatan[0]->b_value;
                  }

                  $tmp = str_replace('.', '', $request->potonganlain[$i]);
                  $potonganlain = str_replace('Rp. ', '', $tmp);

                  $tmp1 = str_replace('.', '', $request->totalgaji[$i]);
                  $totalgaji = str_replace('Rp. ', '', $tmp1);

              DB::table('d_payroll_dt')
                ->insert([
                  'pd_payroll' => $id[0]->p_id,
                  'pd_detailid' => $detailid + 1,
                  'pd_pekerja' => $request->p_id[$i],
                  'pd_gaji_pokok' => $gajipokok[0]->p_gaji_pokok,
                  'pd_tjg_jabatan' => $tunjangan[0]->p_tjg_jabatan,
                  'pd_tjg_makan' => $tunjangan[0]->p_tjg_makan,
                  'pd_tjg_transport' => $tunjangan[0]->p_tjg_transport,
                  'pd_bpjs_kes' => $kesehataninsert,
                  'pd_bpjs_tk' => $ketenagakerjaaninsert,
                  'pd_bpjs_rbh' => $rbhinsert,
                  'pd_bpjs_dapan' => $dapaninsert,
                  'pd_lain' => $potonganlain,
                  'pd_reff' => $request->noreff[$i],
                  'pd_total' => $totalgaji,
                  'pd_note' => $request->Keterangan[$i]
                ]);

                if ($kesehataninsert != 0) {
                  $bpjskes = DB::table('d_bpjs_kesehatan')
                                    ->where('b_pekerja', $request->p_id[$i])
                                    ->where('b_status', 'Y')
                                    ->get();

                  $detailid = DB::table('d_bpjskes_iuran')
                              ->where('bi_no_bpjs', $bpjskes[0]->b_no)
                              ->max("bi_detailid");

                    DB::table('d_bpjskes_iuran')
                      ->insert([
                        'bi_no_bpjs' => $bpjskes[0]->b_no,
                        'bi_detailid' => $detailid + 1,
                        'bi_no_pay' => $request->nota,
                        'bi_value' => $kesehataninsert,
                        'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                        'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                        'bi_status' => 'Y',
                        'bi_mem' => Session::get('mem'),
                        'bi_insert' => Carbon::now('Asia/Jakarta')
                      ]);
                }

                if ($ketenagakerjaaninsert != 0) {
                  $bpjsket = DB::table('d_bpjs_ketenagakerjaan')
                                    ->where('b_pekerja', $request->p_id[$i])
                                    ->where('b_status', 'Y')
                                    ->get();

                  $detailid = DB::table('d_bpjsket_iuran')
                              ->where('bi_no_bpjs', $bpjsket[0]->b_no)
                              ->max("bi_detailid");

                    DB::table('d_bpjsket_iuran')
                      ->insert([
                        'bi_no_bpjs' => $bpjskes[0]->b_no,
                        'bi_detailid' => $detailid + 1,
                        'bi_no_pay' => $request->nota,
                        'bi_value' => $ketenagakerjaaninsert,
                        'bi_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                        'bi_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                        'bi_status' => 'Y',
                        'bi_mem' => Session::get('mem'),
                        'bi_insert' => Carbon::now('Asia/Jakarta')
                      ]);
                }

                if ($rbhinsert != 0) {
                  $rbh = DB::table('d_rbh')
                                    ->where('r_pekerja', $request->p_id[$i])
                                    ->where('r_status', 'Y')
                                    ->get();

                  $detailid = DB::table('d_rbh_iuran')
                              ->where('ri_no_rbh', $rbh[0]->r_no)
                              ->max("ri_detailid");

                    DB::table('d_rbh_iuran')
                      ->insert([
                        'ri_no_rbh' => $rbh[0]->r_no,
                        'ri_detailid' => $detailid + 1,
                        'ri_no_pay' => $request->nota,
                        'ri_value' => $rbhinsert,
                        'ri_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                        'ri_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                        'ri_status' => 'Y',
                        'ri_mem' => Session::get('mem'),
                        'ri_insert' => Carbon::now('Asia/Jakarta')
                      ]);
                }

                if ($dapaninsert != 0) {
                  $dapan = DB::table('d_dapan')
                                    ->where('d_pekerja', $request->p_id[$i])
                                    ->where('d_status', 'Y')
                                    ->get();

                  $detailid = DB::table('d_dapan_iuran')
                              ->where('di_no_dapan', $dapan[0]->d_no)
                              ->max("di_detailid");

                    DB::table('d_dapan_iuran')
                      ->insert([
                        'di_no_dapan' => $dapan[0]->d_no,
                        'di_detailid' => $detailid + 1,
                        'di_no_pay' => $request->nota,
                        'di_value' => $dapaninsert,
                        'di_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                        'di_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                        'di_status' => 'Y',
                        'di_mem' => Session::get('mem'),
                        'di_insert' => Carbon::now('Asia/Jakarta')
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

    public function ambildata(Request $request){
      $data = DB::table('d_mitra_pekerja')
              ->where('mp_mitra', $request->mitra)
              ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
              ->leftJoin('d_bpjs_kesehatan', 'd_bpjs_kesehatan.b_pekerja', '=', 'mp_pekerja')
              ->leftJoin('d_bpjs_ketenagakerjaan', 'd_bpjs_ketenagakerjaan.b_pekerja', '=', 'mp_pekerja')
              ->leftJoin('d_dapan', 'd_pekerja', '=', 'mp_pekerja')
              ->leftJoin('d_rbh', 'r_pekerja', '=', 'mp_pekerja')
              ->leftJoin('d_potonganlain', 'p_pekerja', '=', 'mp_pekerja')
              ->select('d_pekerja.p_id', 'p_name', 'p_nip', DB::raw("COALESCE(p_tjg_makan, 0) as p_tjg_makan"), DB::raw("COALESCE(p_tjg_makan, 0) as p_tjg_makan"), DB::raw("COALESCE(p_tjg_jabatan, 0) as p_tjg_jabatan"), DB::raw("COALESCE(p_tjg_transport, 0) as p_tjg_transport"), DB::raw("COALESCE(p_gaji_pokok, 0) as p_gaji_pokok"), DB::raw("COALESCE(r_value, 0) as r_value"), DB::raw("COALESCE(d_value, 0) as d_value"), DB::raw("COALESCE(p_value, 0) as p_value"), DB::raw("COALESCE(d_bpjs_kesehatan.b_value, 0) as b_valuekes"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value, 0) as b_valueket"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value, 0) as ansuransi"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value, 0) as tunjangan"), DB::raw("COALESCE(d_bpjs_ketenagakerjaan.b_value, 0) as total"))
              ->get();

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->total = $data[$i]->p_gaji_pokok + $data[$i]->p_tjg_makan + $data[$i]->p_tjg_jabatan + $data[$i]->p_tjg_transport - $data[$i]->r_value + $data[$i]->d_value + $data[$i]->b_valuekes + $data[$i]->b_valueket - $data[$i]->p_value;
        $data[$i]->ansuransi = $data[$i]->b_valuekes + $data[$i]->b_valueket + $data[$i]->r_value + $data[$i]->d_value;
        $data[$i]->tunjangan = $data[$i]->p_tjg_makan + $data[$i]->p_tjg_jabatan + $data[$i]->p_tjg_transport;
      }

      return response()->json($data);
    }

    public function cetak(Request $request){
      $data = DB::table('d_pekerja')
              ->leftjoin('d_jabatan_pelamar', 'jp_id', '=', 'd_pekerja.p_jabatan')
              ->leftjoin('d_bpjs_kesehatan', 'd_bpjs_kesehatan.b_pekerja', '=', 'd_pekerja.p_id')
              ->leftjoin('d_bpjs_ketenagakerjaan', 'd_bpjs_ketenagakerjaan.b_pekerja', '=', 'd_pekerja.p_id')
              ->leftjoin('d_potonganlain', 'p_pekerja', '=', 'd_pekerja.p_id')
              ->leftjoin('d_payroll_dt', 'pd_pekerja', '=', 'd_pekerja.p_id')
              ->leftjoin('d_payroll', 'd_payroll.p_id', '=', 'pd_payroll')
              ->where('d_pekerja.p_id', $request->id)
              ->select('p_name', 'p_start_periode', 'b_value_jht', 'b_value_pensiun', 'p_end_periode', 'p_nip', 'p_nip_mitra', 'p_value', 'jp_name', DB::raw("coalesce(d_bpjs_kesehatan.b_value) as terbilang"), DB::raw("coalesce(d_bpjs_kesehatan.b_value) as ansuransi"), DB::raw("coalesce(d_bpjs_kesehatan.b_value) as tunjangan"), DB::raw("coalesce(d_bpjs_kesehatan.b_value) as totalgajikotor"), DB::raw("coalesce(d_bpjs_kesehatan.b_value) as gajiditerima"), DB::raw("coalesce(d_bpjs_kesehatan.b_value) as bikes_value"), DB::raw("coalesce(d_bpjs_ketenagakerjaan.b_value) as biket_value"), 'p_gaji_pokok', 'p_tjg_makan', 'p_tjg_jabatan', 'p_tjg_transport')
              ->get();

        for ($i=0; $i < count($data); $i++) {
          $data[$i]->gajiditerima = $data[$i]->p_gaji_pokok + $data[$i]->p_tjg_makan + $data[$i]->p_tjg_jabatan + $data[$i]->p_tjg_transport - $data[$i]->bikes_value + $data[$i]->biket_value - $data[$i]->p_value;
          $data[$i]->ansuransi = $data[$i]->bikes_value + $data[$i]->biket_value;
          $data[$i]->tunjangan = $data[$i]->p_tjg_makan + $data[$i]->p_tjg_jabatan + $data[$i]->p_tjg_transport;
          $data[$i]->totalgajikotor = $data[$i]->p_gaji_pokok + $data[$i]->p_tjg_makan + $data[$i]->p_tjg_jabatan + $data[$i]->p_tjg_transport;
          $data[$i]->terbilang = Terbilang::make($data[$i]->gajiditerima, ' rupiah');;
        }

      return view('penggajian.print', compact('data'));
    }
}
