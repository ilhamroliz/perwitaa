<?php

namespace App\Http\Controllers;

use App\d_pekerja_child;
use App\d_pekerja_keterampilan;
use App\d_pekerja_language;
use App\d_pekerja_pengalaman;
use App\d_pekerja_referensi;
use App\d_pekerja_sim;
use Dompdf\Exception;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\d_pekerja;

use App\d_pekerja_mutation;

use App\d_mitra;

use App\d_mitra_pekerja;

use Yajra\Datatables\Datatables;
use Session;
use Validator;
use File;
use DB;

use App\Http\Controllers\AksesUser;

use Carbon\carbon;

use App\d_pegawai;

class pegawaiController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
      if (!AksesUser::checkAkses(38, 'read')) {
          return redirect('not-authorized');
      }

        return view('pegawai.index');
    }
    public function data() {
        DB::statement(DB::raw('set @rownum=0'));
        $pegawai = d_pegawai::select(DB::raw('@rownum  := @rownum  + 1 AS number'),'d_pegawai.*')->where('p_status_approval', 'Y')->get();
        return Datatables::of($pegawai)
                       ->addColumn('action', function ($pegawai) {
                            return '<div class="text-center">
                                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail(' . $pegawai->p_id . ')"><i class="glyphicon glyphicon-folder-open"></i></button>
                                    <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="data-pegawai/' . $pegawai->p_id .'/edit"><i class="glyphicon glyphicon-edit"></i></a>
                                    </div>';
                        })
                        ->make(true);
    }
    public function tambah() {
      if (!AksesUser::checkAkses(38, 'insert')) {
          return redirect('not-authorized');
      }
      $jabPelamar = DB::table('d_jabatan')
          ->select('*')
          ->where('j_isactive', 'Y')
          ->orderBy('j_name')
          ->get();

        return view('pegawai.formTambah', compact('jabPelamar'));
    }
    public function simpan(Request $request) {
      if (!AksesUser::checkAkses(38, 'insert')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

          $nama = strtoupper($request->nama);
          $jabatanpelamar = strtoupper($request->jabatan_pelamar);
          $alamat = strtoupper($request->alamat);
          $rt = strtoupper($request->rt);
          $desa = strtoupper($request->desa);
          $kecamatan = strtoupper($request->kecamatan);
          $kota = strtoupper($request->kota);
          $alamat_now = strtoupper($request->alamat_now);
          $rt_now = strtoupper($request->rt_now);
          $desa_now = strtoupper($request->desa_now);
          $kecamatan_now = strtoupper($request->kecamatan_now);
          $kota_now = strtoupper($request->kota_now);
          $tempat_lahir = strtoupper($request->tempat_lahir);
          $tanggal_lahir = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir, 'Asia/Jakarta');
          $no_ktp = strtoupper($request->no_ktp);
          $no_tlp = strtoupper($request->no_tlp);
          $no_hp = strtoupper($request->no_hp);
          $warga_negara = strtoupper($request->wn);
          $status = strtoupper($request->status);
          $jml_anak = strtoupper($request->jml_anak);
          $agama = strtoupper($request->agama);
          $agama_lain = strtoupper($request->agamalain);
          $pendidikan = $request->pendidikan;
          $bahasa = $request->bahasa;
          $bahasa_lain = $request->bahasalain;
          $sim = $request->sim;
          $simket = $request->simket;
          $pengalaman_corp = $request->pengalamancorp;
          $start_pengalaman = $request->startpengalaman;
          $end_pengalaman = $request->endpengalaman;
          $jabatan_pengalaman = $request->jabatan;
          $keterampilan = $request->keterampilan;
          $referensi = [];
          if ($request->ref != null) {
              $referensi = $request->ref;
          }
          $referensi_lain = $request->reflain;
          $nama_keluarga = $request->namakeluarga;
          $hubungan_keluarga = $request->hubkeluarga;
          $telp_keluarga = $request->nokeluarga;
          $hp_keluarga = $request->hpkeluarga;
          $alamat_keluarga = $request->alamatkeluarga;
          $wife_name = $request->wifename;
          $wife_lahir = $request->wifelahir;
          $wife_tanggal = null;
          if ($request->wifettl != '' || $request->wifettl != null) {
              $wife_tanggal = Carbon::createFromFormat('d/m/Y', $request->wifettl, 'Asia/Jakarta');
          }
          $childname = $request->childname;
          $childplace = $request->childplace;
          $childdate = $request->childdate;
          $dadname = $request->dadname;
          $momname = $request->momname;
          $dadjob = $request->dadjob;
          $momjob = $request->momjob;
          $saatini = $request->saatini;
          $kuliahnow = $request->kuliahnow;
          $beratbadan = $request->beratbadan;
          $tinggibadan = $request->tinggibadan;
          $ukuranbaju = $request->ukuranbaju;
          $ukurancelana = $request->ukurancelana;
          $ukuransepatu = $request->ukuransepatu;
          $jenkel = $request->jenkel;

          $idPekerja = DB::table('d_pegawai')
              ->max('p_id');

          $idPekerja = $idPekerja + 1;

          $imgPath = null;
          $imgktp = null;
          $imgijazah = null;
          $imgskck = null;
          $imgmedical = null;
          $tgl = carbon::now('Asia/Jakarta');
          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $dir = 'image/uploads/pegawai/' . $idPekerja;
          $childPath = $dir . '/';
          $path = $childPath;
          $file = $request->file('imageUpload');
          $ktp = $request->file('ktpUpload');
          $ijazah = $request->file('ijazahUpload');
          $skck = $request->file('skckUpload');
          $medical = $request->file('medicalUpload');
          $name = null;
          if ($file != null) {
              $name = $folder . '.' . $file->getClientOriginalExtension();
              if (!File::exists($path)) {
                  if (File::makeDirectory($path, 0777, true)) {
                      $file->move($path, $name);
                      $imgPath = $childPath . $name;
                  } else
                      $imgPath = null;
              } else {
                  return 'already exist';
              }
          }

          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $dir = 'image/uploads/pegawai/ktp/' . $idPekerja;
          $childPath = $dir . '/';
          $path = $childPath;
          if ($ktp != null) {
              $namektp = $folder . '-ktp.' . $ktp->getClientOriginalExtension();
              if (!File::exists($path)) {
                  if (File::makeDirectory($path, 0777, true)) {
                      $ktp->move($path, $namektp);
                      $imgktp = $childPath . $namektp;
                  } else
                      $imgktp = null;
              } else {
                  return 'already exist';
              }
          }

          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $dir = 'image/uploads/pegawai/ijazah/' . $idPekerja;
          $childPath = $dir . '/';
          $path = $childPath;
          if ($ijazah != null) {
              $nameijazah = $folder . '-ijazah.' . $ijazah->getClientOriginalExtension();
              if (!File::exists($path)) {
                  if (File::makeDirectory($path, 0777, true)) {
                      $ijazah->move($path, $nameijazah);
                      $imgijazah = $childPath . $nameijazah;
                  } else
                      $imgijazah = null;
              } else {
                  return 'already exist';
              }
          }

          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $dir = 'image/uploads/pegawai/skck/' . $idPekerja;
          $childPath = $dir . '/';
          $path = $childPath;
          if ($skck != null) {
              $nameskck = $folder . '-skck.' . $skck->getClientOriginalExtension();
              if (!File::exists($path)) {
                  if (File::makeDirectory($path, 0777, true)) {
                      $skck->move($path, $nameskck);
                      $imgskck = $childPath . $nameskck;
                  } else
                      $imgskck = null;
              } else {
                  return 'already exist';
              }
          }

          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $dir = 'image/uploads/pegawai/medical/' . $idPekerja;
          $childPath = $dir . '/';
          $path = $childPath;
          if ($medical != null) {
              $namemedical = $folder . '-medical.' . $medical->getClientOriginalExtension();
              if (!File::exists($path)) {
                  if (File::makeDirectory($path, 0777, true)) {
                      $medical->move($path, $namemedical);
                      $imgmedical = $childPath . $namemedical;
                  } else
                      $imgmedical = null;
              } else {
                  return 'already exist';
              }
          }

          if ($agama_lain != '' || $agama_lain != null) {
              $agama = $agama_lain;
          }

          if ($saatini == 'Kuliah') {
              $saatini = 'Kuliah di ' . $kuliahnow;
          }

          DB::table('d_pegawai')->insert(array(
              "p_id" => $idPekerja,
              "p_jabatan_lamaran" => strtoupper($jabatanpelamar),
              "p_nip" => null,
              "p_ktp" => $no_ktp,
              "p_name" => $nama,
              "p_sex" => $jenkel,
              "p_birthplace" => $tempat_lahir,
              "p_birthdate" => $tanggal_lahir,
              "p_hp" => $no_hp,
              "p_telp" => $no_tlp,
              "p_status" => strtoupper($status),
              "p_many_kids" => strtoupper($jml_anak),
              "p_religion" => strtoupper($agama),
              "p_address" => strtoupper($alamat),
              "p_rt_rw" => strtoupper($rt),
              "p_kel" => strtoupper($desa),
              "p_kecamatan" => strtoupper($kecamatan),
              "p_city" => strtoupper($kota),
              "p_address_now" => strtoupper($alamat_now),
              "p_rt_rw_now" => strtoupper($rt_now),
              "p_kel_now" => strtoupper($desa_now),
              "p_kecamatan_now" => strtoupper($kecamatan_now),
              "p_city_now" => strtoupper($kota_now),
              "p_name_family" => strtoupper($nama_keluarga),
              "p_address_family" => strtoupper($alamat_keluarga),
              "p_telp_family" => strtoupper($telp_keluarga),
              "p_hp_family" => strtoupper($hp_keluarga),
              "p_hubungan_family" => strtoupper($hubungan_keluarga),
              "p_wife_name" => strtoupper($wife_name),
              "p_wife_birth" => strtoupper($wife_tanggal),
              "p_wife_birthplace" => strtoupper($wife_lahir),
              "p_dad_name" => strtoupper($dadname),
              "p_dad_job" => strtoupper($dadjob),
              "p_mom_name" => strtoupper($momname),
              "p_mom_job" => strtoupper($momjob),
              "p_job_now" => strtoupper($saatini),
              "p_weight" => strtoupper($beratbadan),
              "p_height" => strtoupper($tinggibadan),
              "p_seragam_size" => strtoupper($ukuranbaju),
              "p_celana_size" => strtoupper($ukurancelana),
              "p_sepatu_size" => strtoupper($ukuransepatu),
              "p_kpk" => null,
              "p_bu" => null,
              "p_ktp_expired" => null,
              "p_ktp_seumurhidup" => null,
              "p_education" => strtoupper($pendidikan),
              "p_kpj_no" => null,
              "p_state" => strtoupper($warga_negara),
              "p_note" => null,
              "p_img" => $imgPath,
              "p_img_ktp" => $imgktp,
              "p_img_ijazah" => $imgijazah,
              "p_img_skck" => $imgskck,
              "p_img_medical" => $imgmedical,
              "p_insert_by" => Session::get('mem'),
              "p_insert" => Carbon::now('Asia/Jakarta'),
              "p_update" => Carbon::now('Asia/Jakarta')
          ));

          $addKeterampilan = [];
          for ($i = 0; $i < count($keterampilan); $i++) {
              $temp = [];
              if ($keterampilan[$i] != '' || $keterampilan != null) {
                  $temp = array(
                      'pk_pegawai' => $idPekerja,
                      'pk_detailid' => $i + 1,
                      'pk_keterampilan' => strtoupper($keterampilan[$i])
                  );
                  array_push($addKeterampilan, $temp);
              }
          }
          DB::table('d_pegawai_keterampilan')->insert($addKeterampilan);

          $addBahasa = [];
          for ($i = 0; $i < count($bahasa); $i++) {
              $temp = [];
              if ($bahasa[$i] == 'Lain' && $bahasa_lain != '') {
                  $temp = array(
                      'pl_pegawai' => $idPekerja,
                      'pl_detailid' => $i + 1,
                      'pl_language' => strtoupper($bahasa_lain)
                  );
              } else {
                  if ($bahasa[$i] != null || $bahasa[$i] != '') {
                      $temp = array(
                          'pl_pegawai' => $idPekerja,
                          'pl_detailid' => $i + 1,
                          'pl_language' => strtoupper($bahasa[$i])
                      );
                  }
              }
              array_push($addBahasa, $temp);
          }
          DB::table('d_pegawai_language')->insert($addBahasa);

          $addSIM = [];
          for ($i = 0; $i < count($sim); $i++) {
              $temp = [];
              if ($sim[$i] != null || $sim[$i] != '') {
                  $temp = array(
                      'ps_pegawai' => $idPekerja,
                      'ps_detailid' => $i + 1,
                      'ps_sim' => $sim[$i],
                      'ps_note' => strtoupper($simket)
                  );
                  array_push($addSIM, $temp);
              }
          }
          DB::table('d_pegawai_sim')->insert($addSIM);

          $addPengalaman = [];
          for ($i = 0; $i < count($pengalaman_corp); $i++) {
              $temp = [];
              if ($pengalaman_corp[$i] != null || $pengalaman_corp[$i] != '') {
                  $temp = array(
                      'pp_pegawai' => $idPekerja,
                      'pp_detailid' => $i + 1,
                      'pp_perusahaan' => strtoupper($pengalaman_corp[$i]),
                      'pp_start' => $start_pengalaman[$i],
                      'pp_end' => $end_pengalaman[$i],
                      'pp_jabatan' => strtoupper($jabatan_pengalaman[$i])
                  );
                  array_push($addPengalaman, $temp);
              }
          }
          DB::table('d_pegawai_pengalaman')->insert($addPengalaman);

          $addReferensi = [];
          for ($i = 0; $i < count($referensi); $i++) {
              $temp = [];
              if ($referensi[$i] == 'Lain') {
                  $temp = array(
                      'pr_pegawai' => $idPekerja,
                      'pr_detailid' => $i + 1,
                      'pr_referensi' => strtoupper($referensi_lain)
                  );
              } else {
                  if ($referensi[$i] != null || $referensi[$i] != '') {
                      $temp = array(
                          'pr_pegawai' => $idPekerja,
                          'pr_detailid' => $i + 1,
                          'pr_referensi' => strtoupper($referensi[$i])
                      );
                  }
              }
              array_push($addReferensi, $temp);
          }
          DB::table('d_pegawai_referensi')->insert($addReferensi);

          $addChild = [];
          for ($i = 0; $i < count($childname); $i++) {
              $temp = [];
              if ($childname[$i] != '' || $childname[$i] != null || $childname[$i] != ' ' || $childname[$i] != "") {
                  if ($childdate[$i] != "") {
                      $childdate[$i] = Carbon::createFromFormat('d/m/Y', $childdate[$i], 'Asia/Jakarta');
                      $temp = array(
                          'pc_pegawai' => $idPekerja,
                          'pc_detailid' => $i + 1,
                          'pc_child_name' => strtoupper($childname[$i]),
                          'pc_birth_date' => $childdate[$i],
                          'pc_birth_place' => strtoupper($childplace[$i])
                      );
                      array_push($addChild, $temp);
                  }
              }
          }
          DB::table('d_pegawai_child')->insert($addChild);

          DB::table('d_pegawai_mutation')->insert(array(
              'pm_pegawai' => $idPekerja,
              'pm_detailid' => 1,
              'pm_date' => Carbon::now('Asia/Jakarta'),
              'pm_detail' => 'Masuk',
              'pm_status' => 'Calon',
              'pm_insert_by' => Session::get('mem')
          ));

          $countpelamar = DB::table('d_pegawai')
              ->where('p_status_approval', null)
              ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Pegawai')
              ->update([
                'n_qty' => count($countpelamar),
                'n_insert' => Carbon::now()
              ]);

              $count = DB::table('d_pegawai')
                      ->where('p_status_approval', null)
                      ->get();

              DB::table('d_notifikasi')
                  ->where('n_fitur', 'Pegawai')
                  ->update([
                    'n_qty' => count($count)
                  ]);

          DB::commit();
          Session::flash('sukses', 'data pegawai baru anda berhasil disimpan');
          return redirect('manajemen-pegawai/data-pegawai');
      } catch (\Exception $e) {
          DB::rollback();
          Session::flash('gagal', 'data pegawai tidak dapat di simpan');
          return redirect('manajemen-pegawai/data-pegawai');
      }
    }
    public function edit($id) {
      if (!AksesUser::checkAkses(38, 'update')) {
          return redirect('not-authorized');
      }
      $jabatan = DB::table('d_jabatan')
          ->select('j_name', 'j_id')->where('j_isactive', 'Y')->get();

      $pekerja = DB::table('d_pegawai')
          ->where('p_id', '=', $id)
          ->select('p_name'
              , 'p_address'
              , 'p_rt_rw'
              , 'p_kecamatan'
              , 'p_kel'
              , 'p_nip'
              , 'p_city'
              , 'p_jabatan_lamaran'
              , 'p_address_now'
              , 'p_rt_rw_now'
              , 'p_kecamatan_now'
              , 'p_kel_now'
              , 'p_city_now'
              , 'p_birthplace'
              , 'p_birthdate'
              , 'p_ktp'
              , 'p_telp'
              , 'p_hp'
              , 'p_sex'
              , 'p_state'
              , 'p_status'
              , 'p_many_kids'
              , 'p_religion'
              , 'p_education'
              , 'p_name_family'
              , 'p_address_family'
              , 'p_telp_family'
              , 'p_hp_family'
              , 'p_address_family'
              , 'p_hubungan_family'
              , 'p_wife_name'
              , 'p_wife_birth'
              , 'p_wife_birthplace'
              , 'p_dad_name'
              , 'p_dad_job'
              , 'p_mom_name'
              , 'p_mom_job'
              , 'p_job_now'
              , 'p_weight'
              , 'p_height'
              , 'p_seragam_size'
              , 'p_celana_size'
              , 'p_sepatu_size'
              , 'p_img'
              , 'p_img_ktp'
              , 'p_img_skck'
              , 'p_img_medical'
              , 'p_img_ijazah')
          ->get();

      $child = DB::table('d_pekerja_child')
          ->select('pc_child_name', 'pc_birth_place', 'pc_birth_date')
          ->where('pc_pekerja', '=', $id)
          ->get();

      $keterampilan = DB::table('d_pekerja_keterampilan')
          ->select('pk_keterampilan')
          ->where('pk_pekerja', '=', $id)
          ->get();

      // $bahasa = DB::table('d_pekerja_language')
      //        ->select('pl_language')
      //        ->where('pl_pekerja', '=', $id)
      //        ->get();

      $bahasa = DB::select("select pl_pegawai, (select pl_language from d_pegawai_language pl where pl.pl_pegawai = '$id' and pl.pl_language = 'INDONESIA') as indonesia, (select pl_language from d_pegawai_language pl where pl.pl_pegawai = '$id' and pl.pl_language = 'INGGRIS') as inggris, (select pl_language from d_pegawai_language pl where pl.pl_pegawai = '$id' and pl.pl_language = 'MANDARIN') as mandarin, (select pl_language from d_pegawai_language pl where pl.pl_pegawai = '$id' and pl.pl_language != 'INDONESIA' and pl.pl_language != 'INGGRIS' and pl.pl_language != 'MANDARIN') as lain from d_pegawai_language dpl where pl_pegawai = '$id' group by pl_pegawai");
      //dd($bahasa);

      $pengalaman = DB::table('d_pegawai_pengalaman')
          ->select('pp_perusahaan', 'pp_start', 'pp_end', 'pp_jabatan')
          ->where('pp_pegawai', '=', $id)
          ->get();

      $referensi = DB::select("select *,
(select pr_referensi from d_pegawai_referensi pr where pr.pr_pegawai = '$id' and pr.pr_referensi = 'TEMAN') as teman,
(select pr_referensi from d_pegawai_referensi pr where pr.pr_pegawai = '$id' and pr.pr_referensi = 'KELUARGA') as keluarga,
(select pr_referensi from d_pegawai_referensi pr where pr.pr_pegawai = '$id' and pr.pr_referensi = 'KORAN') as koran,
(select pr_referensi from d_pegawai_referensi pr where pr.pr_pegawai = '$id' and pr.pr_referensi = 'INTERNET') as internet,
(select pr_referensi from d_pegawai_referensi pr where pr.pr_pegawai = '$id' and pr.pr_referensi != 'TEMAN' and pr.pr_referensi != 'KELUARGA' and pr.pr_referensi != 'KORAN' and pr.pr_referensi != 'INTERNET') as lain
from d_pegawai_referensi dpr
where pr_pegawai = '$id'
group by pr_pegawai");

      $sim = DB::select("select ps_pegawai,
(select ps_sim from d_pegawai_sim ps where ps.ps_pegawai = '$id' and ps.ps_sim = 'SIM C') as simc,
(select ps_sim from d_pegawai_sim ps where ps.ps_pegawai = '$id' and ps.ps_sim = 'SIM A') as sima,
(select ps_sim from d_pegawai_sim ps where ps.ps_pegawai = '$id' and ps.ps_sim = 'SIM B') as simb,
(select ps_note from d_pegawai_sim ps where ps.ps_pegawai = '$id' and ps.ps_note != '') as note
from d_pegawai_sim dps
where ps_pegawai = '$id'
group by ps_pegawai");
      //  dd($sim);
      // $sim = DB::table('d_pekerja_sim')
      //         ->select('ps_sim', 'ps_note')
      //         ->where('ps_pekerja', '=', $id)
      //         ->get();

      // echo "<pre>";
      // print_r($pekerja);
      // echo "</pre>";
      // echo "<pre>";
      // print_r($child);
      // echo "</pre>";
      // echo "<pre>";
      // print_r($keterampilan);
      // echo "</pre>";
      // echo "<pre>";
      // print_r($bahasa);
      // echo "</pre>";
      // echo "<pre>";
      // print_r($pengalaman);
      // echo "</pre>";
      // echo "<pre>";
      // print_r($referensi);
      // echo "</pre>";
      // echo "<pre>";
      // print_r($sim);
      // echo "</pre>";
      // echo "<pre>";
      // print_r($jabatan);
      // echo "</pre>";

      return view('pegawai.formEdit', compact('id', 'pekerja', 'jabatan', 'child', 'keterampilan', 'bahasa', 'pengalaman', 'referensi', 'sim'));

    }
    public function perbarui(Request $request) {
      if (!AksesUser::checkAkses(38, 'update')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
       try {
     $id = $request->id;
     $imglama = $request->imglama;

     DB::table('d_pegawai')->where('p_id', '=', $id)
         ->delete();

     DB::table('d_pegawai_child')->where('pc_pegawai', '=', $id)
         ->delete();

     DB::table('d_pegawai_keterampilan')->where('pk_pegawai', '=', $id)
         ->delete();

     DB::table('d_pegawai_language')->where('pl_pegawai', '=', $id)
         ->delete();

     DB::table('d_pegawai_pengalaman')->where('pp_pegawai', '=', $id)
         ->delete();

     DB::table('d_pegawai_referensi')->where('pr_pegawai', '=', $id)
         ->delete();

     DB::table('d_pegawai_sim')->where('ps_pegawai', '=', $id)
         ->delete();

     $nama = strtoupper($request->nama);
     $jabatanpelamar = strtoupper($request->jabatan_pelamar);
     $alamat = strtoupper($request->alamat);
     $rt = strtoupper($request->rt);
     $desa = strtoupper($request->desa);
     $kecamatan = strtoupper($request->kecamatan);
     $kota = strtoupper($request->kota);
     $alamat_now = strtoupper($request->alamat_now);
     $rt_now = strtoupper($request->rt_now);
     $desa_now = strtoupper($request->desa_now);
     $kecamatan_now = strtoupper($request->kecamatan_now);
     $kota_now = strtoupper($request->kota_now);
     $tempat_lahir = strtoupper($request->tempat_lahir);
     $tanggal_lahir = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir, 'Asia/Jakarta');
     $no_ktp = strtoupper($request->no_ktp);
     $no_tlp = strtoupper($request->no_tlp);
     $no_hp = strtoupper($request->no_hp);
     $warga_negara = strtoupper($request->wn);
     $status = strtoupper($request->status);
     $jml_anak = strtoupper($request->jml_anak);
     $agama = strtoupper($request->agama);
     $agama_lain = strtoupper($request->agamalain);
     $pendidikan = $request->pendidikan;
     $bahasa = $request->bahasa;
     $bahasa_lain = $request->bahasalain;
     $sim = $request->sim;
     $simket = $request->simket;
     $pengalaman_corp = $request->pengalamancorp;
     $start_pengalaman = $request->startpengalaman;
     $end_pengalaman = $request->endpengalaman;
     $jabatan_pengalaman = $request->jabatan;
     $keterampilan = $request->keterampilan;
     $referensi = [];
     if ($request->ref != null) {
         $referensi = $request->ref;
     }
     $referensi_lain = $request->reflain;
     $nama_keluarga = $request->namakeluarga;
     $hubungan_keluarga = $request->hubkeluarga;
     $telp_keluarga = $request->nokeluarga;
     $hp_keluarga = $request->hpkeluarga;
     $alamat_keluarga = $request->alamatkeluarga;
     $wife_name = $request->wifename;
     $wife_lahir = $request->wifelahir;
     $wife_tanggal = null;
     if ($request->wifettl != '' || $request->wifettl != null) {
         $wife_tanggal = Carbon::createFromFormat('d/m/Y', $request->wifettl, 'Asia/Jakarta');
     }
     $childname = $request->childname;
     $childplace = $request->childplace;
     $childdate = $request->childdate;
     $dadname = $request->dadname;
     $momname = $request->momname;
     $dadjob = $request->dadjob;
     $momjob = $request->momjob;
     $saatini = $request->saatini;
     $kuliahnow = $request->kuliahnow;
     $beratbadan = $request->beratbadan;
     $tinggibadan = $request->tinggibadan;
     $ukuranbaju = $request->ukuranbaju;
     $ukurancelana = $request->ukurancelana;
     $ukuransepatu = $request->ukuransepatu;
     $sex = $request->sex;


     if (!empty($request->file('imageUpload'))) {
         $imgPath = null;
         $tgl = carbon::now('Asia/Jakarta');
         $folder = $tgl->year . $tgl->month . $tgl->timestamp;
         $dir = 'image/uploads/pegawai/' . $id;
         $this->deleteDir($dir);
         $childPath = $dir . '/';
         $path = $childPath;
         $file = $request->file('imageUpload');
         $name = null;
         if ($file != null) {
             $name = $folder . '.' . $file->getClientOriginalExtension();
             if (!File::exists($path)) {
                 if (File::makeDirectory($path, 0777, true)) {
                     $file->move($path, $name);
                     $imgPath = $childPath . $name;
                 } else
                     $imgPath = null;
             } else {
                 return 'already exist';
             }
         }

         if ($agama_lain != '' || $agama_lain != null) {
             $agama = $agama_lain;
         }


         if ($saatini == 'kuliah') {
             $saatini = 'Kuliah di ' . $kuliahnow;
         }


         d_pegawai::insert(array(
             "p_id" => $id,
             "p_jabatan_lamaran" => strtoupper($jabatanpelamar),
             "p_nip" => null,
             "p_ktp" => $no_ktp,
             "p_name" => $nama,
             "p_sex" => $sex,
             "p_birthplace" => $tempat_lahir,
             "p_birthdate" => $tanggal_lahir,
             "p_hp" => $no_hp,
             "p_telp" => $no_tlp,
             "p_status" => strtoupper($status),
             "p_many_kids" => strtoupper($jml_anak),
             "p_religion" => strtoupper($agama),
             "p_address" => strtoupper($alamat),
             "p_rt_rw" => strtoupper($rt),
             "p_kel" => strtoupper($desa),
             "p_kecamatan" => strtoupper($kecamatan),
             "p_city" => strtoupper($kota),
             "p_address_now" => strtoupper($alamat_now),
             "p_rt_rw_now" => strtoupper($rt_now),
             "p_kel_now" => strtoupper($desa_now),
             "p_kecamatan_now" => strtoupper($kecamatan_now),
             "p_city_now" => strtoupper($kota_now),
             "p_name_family" => strtoupper($nama_keluarga),
             "p_address_family" => strtoupper($alamat_keluarga),
             "p_telp_family" => strtoupper($telp_keluarga),
             "p_hp_family" => strtoupper($hp_keluarga),
             "p_hubungan_family" => strtoupper($hubungan_keluarga),
             "p_wife_name" => strtoupper($wife_name),
             "p_wife_birth" => strtoupper($wife_tanggal),
             "p_wife_birthplace" => strtoupper($wife_lahir),
             "p_dad_name" => strtoupper($dadname),
             "p_dad_job" => strtoupper($dadjob),
             "p_mom_name" => strtoupper($momname),
             "p_mom_job" => strtoupper($momjob),
             "p_job_now" => strtoupper($saatini),
             "p_weight" => strtoupper($beratbadan),
             "p_height" => strtoupper($tinggibadan),
             "p_seragam_size" => strtoupper($ukuranbaju),
             "p_celana_size" => strtoupper($ukurancelana),
             "p_sepatu_size" => strtoupper($ukuransepatu),
             "p_kpk" => null,
             "p_bu" => null,
             "p_ktp_expired" => null,
             "p_ktp_seumurhidup" => null,
             "p_education" => strtoupper($pendidikan),
             "p_kpj_no" => null,
             "p_state" => strtoupper($warga_negara),
             "p_note" => null,
             "p_img" => $imgPath,
             "p_img_ktp" => $request->imgktplama,
             "p_img_skck" => $request->imgskcklama,
             "p_img_ijazah" => $request->imgijazahlama,
             "p_img_medical" => $request->imgmedicallama,
             "p_insert" => Carbon::now('Asia/Jakarta'),
             "p_update" => Carbon::now('Asia/Jakarta')
         ));

     } elseif (!empty($request->file('ktpUpload'))) {
         $imgktp = null;
         $tgl = carbon::now('Asia/Jakarta');
         $folder = $tgl->year . $tgl->month . $tgl->timestamp;
         $dir = 'image/uploads/pegawai/ktp/' . $idPekerja;
         $this->deleteDir($dir);
         $childPath = $dir . '/';
         $path = $childPath;
         $ktp = $request->file('ktpUpload');
         $namektp = null;
         if ($ktp != null) {
             $namektp = $folder . '-ktp.' . $ktp->getClientOriginalExtension();
             if (!File::exists($path)) {
                 if (File::makeDirectory($path, 0777, true)) {
                     $ktp->move($path, $namektp);
                     $imgktp = $childPath . $namektp;
                 } else
                     $imgktp = null;
             } else {
                 return 'already exist';
             }
         }

         if ($agama_lain != '' || $agama_lain != null) {
             $agama = $agama_lain;
         }


         if ($saatini == 'kuliah') {
             $saatini = 'Kuliah di ' . $kuliahnow;
         }


         d_pegawai::insert(array(
             "p_id" => $id,
             "p_jabatan_lamaran" => strtoupper($jabatanpelamar),
             "p_nip" => null,
             "p_ktp" => $no_ktp,
             "p_name" => $nama,
             "p_sex" => $sex,
             "p_birthplace" => $tempat_lahir,
             "p_birthdate" => $tanggal_lahir,
             "p_hp" => $no_hp,
             "p_telp" => $no_tlp,
             "p_status" => strtoupper($status),
             "p_many_kids" => strtoupper($jml_anak),
             "p_religion" => strtoupper($agama),
             "p_address" => strtoupper($alamat),
             "p_rt_rw" => strtoupper($rt),
             "p_kel" => strtoupper($desa),
             "p_kecamatan" => strtoupper($kecamatan),
             "p_city" => strtoupper($kota),
             "p_address_now" => strtoupper($alamat_now),
             "p_rt_rw_now" => strtoupper($rt_now),
             "p_kel_now" => strtoupper($desa_now),
             "p_kecamatan_now" => strtoupper($kecamatan_now),
             "p_city_now" => strtoupper($kota_now),
             "p_name_family" => strtoupper($nama_keluarga),
             "p_address_family" => strtoupper($alamat_keluarga),
             "p_telp_family" => strtoupper($telp_keluarga),
             "p_hp_family" => strtoupper($hp_keluarga),
             "p_hubungan_family" => strtoupper($hubungan_keluarga),
             "p_wife_name" => strtoupper($wife_name),
             "p_wife_birth" => strtoupper($wife_tanggal),
             "p_wife_birthplace" => strtoupper($wife_lahir),
             "p_dad_name" => strtoupper($dadname),
             "p_dad_job" => strtoupper($dadjob),
             "p_mom_name" => strtoupper($momname),
             "p_mom_job" => strtoupper($momjob),
             "p_job_now" => strtoupper($saatini),
             "p_weight" => strtoupper($beratbadan),
             "p_height" => strtoupper($tinggibadan),
             "p_seragam_size" => strtoupper($ukuranbaju),
             "p_celana_size" => strtoupper($ukurancelana),
             "p_sepatu_size" => strtoupper($ukuransepatu),
             "p_kpk" => null,
             "p_bu" => null,
             "p_ktp_expired" => null,
             "p_ktp_seumurhidup" => null,
             "p_education" => strtoupper($pendidikan),
             "p_kpj_no" => null,
             "p_state" => strtoupper($warga_negara),
             "p_note" => null,
             "p_img" => $imglama,
             "p_img_ktp" => $imgktp,
             "p_img_skck" => $request->imgskcklama,
             "p_img_ijazah" => $request->imgijazahlama,
             "p_img_medical" => $request->imgmedicallama,
             "p_insert" => Carbon::now('Asia/Jakarta'),
             "p_update" => Carbon::now('Asia/Jakarta')
         ));

     } elseif (!empty($request->file('ijazahUpload'))) {
         $imgijazah = null;
         $tgl = carbon::now('Asia/Jakarta');
         $folder = $tgl->year . $tgl->month . $tgl->timestamp;
         $dir = 'image/uploads/pegawai/ijazah/' . $idpekerja;
         $this->deleteDir($dir);
         $childPath = $dir . '/';
         $path = $childPath;
         $ijazah = $request->file('ijazahUpload');
         $nameijazah = null;
         if ($ijazah != null) {
             $nameijazah = $folder . '-ijazah.' . $ijazah->getClientOriginalExtension();
             if (!File::exists($path)) {
                 if (File::makeDirectory($path, 0777, true)) {
                     $ijazah->move($path, $nameijazah);
                     $imgijazah = $childPath . $nameijazah;
                 } else
                     $imgijazah = null;
             } else {
                 return 'already exist';
             }
         }

         if ($agama_lain != '' || $agama_lain != null) {
             $agama = $agama_lain;
         }


         if ($saatini == 'kuliah') {
             $saatini = 'Kuliah di ' . $kuliahnow;
         }


         d_pegawai::insert(array(
             "p_id" => $id,
             "p_jabatan_lamaran" => strtoupper($jabatanpelamar),
             "p_nip" => null,
             "p_ktp" => $no_ktp,
             "p_name" => $nama,
             "p_sex" => $sex,
             "p_birthplace" => $tempat_lahir,
             "p_birthdate" => $tanggal_lahir,
             "p_hp" => $no_hp,
             "p_telp" => $no_tlp,
             "p_status" => strtoupper($status),
             "p_many_kids" => strtoupper($jml_anak),
             "p_religion" => strtoupper($agama),
             "p_address" => strtoupper($alamat),
             "p_rt_rw" => strtoupper($rt),
             "p_kel" => strtoupper($desa),
             "p_kecamatan" => strtoupper($kecamatan),
             "p_city" => strtoupper($kota),
             "p_address_now" => strtoupper($alamat_now),
             "p_rt_rw_now" => strtoupper($rt_now),
             "p_kel_now" => strtoupper($desa_now),
             "p_kecamatan_now" => strtoupper($kecamatan_now),
             "p_city_now" => strtoupper($kota_now),
             "p_name_family" => strtoupper($nama_keluarga),
             "p_address_family" => strtoupper($alamat_keluarga),
             "p_telp_family" => strtoupper($telp_keluarga),
             "p_hp_family" => strtoupper($hp_keluarga),
             "p_hubungan_family" => strtoupper($hubungan_keluarga),
             "p_wife_name" => strtoupper($wife_name),
             "p_wife_birth" => strtoupper($wife_tanggal),
             "p_wife_birthplace" => strtoupper($wife_lahir),
             "p_dad_name" => strtoupper($dadname),
             "p_dad_job" => strtoupper($dadjob),
             "p_mom_name" => strtoupper($momname),
             "p_mom_job" => strtoupper($momjob),
             "p_job_now" => strtoupper($saatini),
             "p_weight" => strtoupper($beratbadan),
             "p_height" => strtoupper($tinggibadan),
             "p_seragam_size" => strtoupper($ukuranbaju),
             "p_celana_size" => strtoupper($ukurancelana),
             "p_sepatu_size" => strtoupper($ukuransepatu),
             "p_kpk" => null,
             "p_bu" => null,
             "p_ktp_expired" => null,
             "p_ktp_seumurhidup" => null,
             "p_education" => strtoupper($pendidikan),
             "p_kpj_no" => null,
             "p_state" => strtoupper($warga_negara),
             "p_note" => null,
             "p_img" => $imglama,
             "p_img_ktp" => $request->imgktplama,
             "p_img_skck" => $request->imgskcklama,
             "p_img_medical" => $request->imgmedicallama,
             "p_img_ijazah" => $imgijazah,
             "p_insert" => Carbon::now('Asia/Jakarta'),
             "p_update" => Carbon::now('Asia/Jakarta')
         ));

     } elseif (!empty($request->file('skckUpload'))) {
         $imgskck = null;
         $tgl = carbon::now('Asia/Jakarta');
         $folder = $tgl->year . $tgl->month . $tgl->timestamp;
         $dir = 'image/uploads/pegawai/skck/' . $idPekerja;
         $this->deleteDir($dir);
         $childPath = $dir . '/';
         $path = $childPath;
         $skck = $request->file('skckUpload');
         $nameskck = null;
         if ($skck != null) {
             $nameskck = $folder . '-skck.' . $skck->getClientOriginalExtension();
             if (!File::exists($path)) {
                 if (File::makeDirectory($path, 0777, true)) {
                     $skck->move($path, $nameskck);
                     $imgskck = $childPath . $nameskck;
                 } else
                     $imgskck = null;
             } else {
                 return 'already exist';
             }
         }

         if ($agama_lain != '' || $agama_lain != null) {
             $agama = $agama_lain;
         }


         if ($saatini == 'kuliah') {
             $saatini = 'Kuliah di ' . $kuliahnow;
         }


         d_pegawai::insert(array(
             "p_id" => $id,
             "p_jabatan_lamaran" => strtoupper($jabatanpelamar),
             "p_nip" => null,
             "p_ktp" => $no_ktp,
             "p_name" => $nama,
             "p_sex" => $sex,
             "p_birthplace" => $tempat_lahir,
             "p_birthdate" => $tanggal_lahir,
             "p_hp" => $no_hp,
             "p_telp" => $no_tlp,
             "p_status" => strtoupper($status),
             "p_many_kids" => strtoupper($jml_anak),
             "p_religion" => strtoupper($agama),
             "p_address" => strtoupper($alamat),
             "p_rt_rw" => strtoupper($rt),
             "p_kel" => strtoupper($desa),
             "p_kecamatan" => strtoupper($kecamatan),
             "p_city" => strtoupper($kota),
             "p_address_now" => strtoupper($alamat_now),
             "p_rt_rw_now" => strtoupper($rt_now),
             "p_kel_now" => strtoupper($desa_now),
             "p_kecamatan_now" => strtoupper($kecamatan_now),
             "p_city_now" => strtoupper($kota_now),
             "p_name_family" => strtoupper($nama_keluarga),
             "p_address_family" => strtoupper($alamat_keluarga),
             "p_telp_family" => strtoupper($telp_keluarga),
             "p_hp_family" => strtoupper($hp_keluarga),
             "p_hubungan_family" => strtoupper($hubungan_keluarga),
             "p_wife_name" => strtoupper($wife_name),
             "p_wife_birth" => strtoupper($wife_tanggal),
             "p_wife_birthplace" => strtoupper($wife_lahir),
             "p_dad_name" => strtoupper($dadname),
             "p_dad_job" => strtoupper($dadjob),
             "p_mom_name" => strtoupper($momname),
             "p_mom_job" => strtoupper($momjob),
             "p_job_now" => strtoupper($saatini),
             "p_weight" => strtoupper($beratbadan),
             "p_height" => strtoupper($tinggibadan),
             "p_seragam_size" => strtoupper($ukuranbaju),
             "p_celana_size" => strtoupper($ukurancelana),
             "p_sepatu_size" => strtoupper($ukuransepatu),
             "p_kpk" => null,
             "p_bu" => null,
             "p_ktp_expired" => null,
             "p_ktp_seumurhidup" => null,
             "p_education" => strtoupper($pendidikan),
             "p_kpj_no" => null,
             "p_state" => strtoupper($warga_negara),
             "p_note" => null,
             "p_img" => $imglama,
             "p_img_ktp" => $request->imgktplama,
             "p_img_ijazah" => $request->imgijazahlama,
             "p_img_medical" => $request->imgmedicallama,
             "p_img_skck" => $imgskck,
             "p_insert" => Carbon::now('Asia/Jakarta'),
             "p_update" => Carbon::now('Asia/Jakarta')
         ));

     } elseif (!empty($request->file('medicalUpload'))) {
         $imgmedical = null;
         $tgl = carbon::now('Asia/Jakarta');
         $folder = $tgl->year . $tgl->month . $tgl->timestamp;
         $dir = 'image/uploads/pegawai/medical/' . $idPekerja;
         $this->deleteDir($dir);
         $childPath = $dir . '/';
         $path = $childPath;
         $medical = $request->file('medicalUpload');
         $namemedical = null;
         if ($medical != null) {
             $namemedical = $folder . '-medical.' . $medical->getClientOriginalExtension();
             if (!File::exists($path)) {
                 if (File::makeDirectory($path, 0777, true)) {
                     $medical->move($path, $namemedical);
                     $imgmedical = $childPath . $namemedical;
                 } else
                     $imgmedical = null;
             } else {
                 return 'already exist';
             }
         }

         if ($agama_lain != '' || $agama_lain != null) {
             $agama = $agama_lain;
         }


         if ($saatini == 'kuliah') {
             $saatini = 'Kuliah di ' . $kuliahnow;
         }


         d_pegawai::insert(array(
             "p_id" => $id,
             "p_jabatan_lamaran" => strtoupper($jabatanpelamar),
             "p_nip" => null,
             "p_ktp" => $no_ktp,
             "p_name" => $nama,
             "p_sex" => $sex,
             "p_birthplace" => $tempat_lahir,
             "p_birthdate" => $tanggal_lahir,
             "p_hp" => $no_hp,
             "p_telp" => $no_tlp,
             "p_status" => strtoupper($status),
             "p_many_kids" => strtoupper($jml_anak),
             "p_religion" => strtoupper($agama),
             "p_address" => strtoupper($alamat),
             "p_rt_rw" => strtoupper($rt),
             "p_kel" => strtoupper($desa),
             "p_kecamatan" => strtoupper($kecamatan),
             "p_city" => strtoupper($kota),
             "p_address_now" => strtoupper($alamat_now),
             "p_rt_rw_now" => strtoupper($rt_now),
             "p_kel_now" => strtoupper($desa_now),
             "p_kecamatan_now" => strtoupper($kecamatan_now),
             "p_city_now" => strtoupper($kota_now),
             "p_name_family" => strtoupper($nama_keluarga),
             "p_address_family" => strtoupper($alamat_keluarga),
             "p_telp_family" => strtoupper($telp_keluarga),
             "p_hp_family" => strtoupper($hp_keluarga),
             "p_hubungan_family" => strtoupper($hubungan_keluarga),
             "p_wife_name" => strtoupper($wife_name),
             "p_wife_birth" => strtoupper($wife_tanggal),
             "p_wife_birthplace" => strtoupper($wife_lahir),
             "p_dad_name" => strtoupper($dadname),
             "p_dad_job" => strtoupper($dadjob),
             "p_mom_name" => strtoupper($momname),
             "p_mom_job" => strtoupper($momjob),
             "p_job_now" => strtoupper($saatini),
             "p_weight" => strtoupper($beratbadan),
             "p_height" => strtoupper($tinggibadan),
             "p_seragam_size" => strtoupper($ukuranbaju),
             "p_celana_size" => strtoupper($ukurancelana),
             "p_sepatu_size" => strtoupper($ukuransepatu),
             "p_kpk" => null,
             "p_bu" => null,
             "p_ktp_expired" => null,
             "p_ktp_seumurhidup" => null,
             "p_education" => strtoupper($pendidikan),
             "p_kpj_no" => null,
             "p_state" => strtoupper($warga_negara),
             "p_note" => null,
             "p_img" => $imglama,
             "p_img_ktp" => $request->imgktplama,
             "p_img_skck" => $request->imgskcklama,
             "p_img_ijazah" => $request->imgijazahlama,
             "p_img_medical" => $imgmedical,
             "p_insert" => Carbon::now('Asia/Jakarta'),
             "p_update" => Carbon::now('Asia/Jakarta')
         ));

     } else {
         $imgPath = null;
         $tgl = carbon::now('Asia/Jakarta');
         $folder = $tgl->year . $tgl->month . $tgl->timestamp;
         $dir = 'image/uploads/pegawai/' . $id;
         $childPath = $dir . '/';
         $path = $childPath;
         $file = $request->file('imageUpload');
         $name = null;
         if ($file != null) {
             $name = $folder . '.' . $file->getClientOriginalExtension();
             if (!File::exists($path)) {
                 if (File::makeDirectory($path, 0777, true)) {
                     $file->move($path, $name);
                     $imgPath = $childPath . $name;
                 } else
                     $imgPath = null;
             } else {
                 return 'already exist';
             }
         }

         if ($agama_lain != '' || $agama_lain != null) {
             $agama = $agama_lain;
         }


         if ($saatini == 'kuliah') {
             $saatini = 'Kuliah di ' . $kuliahnow;
         }


         d_pegawai::insert(array(
             "p_id" => $id,
             "p_jabatan_lamaran" => strtoupper($jabatanpelamar),
             "p_nip" => null,
             "p_ktp" => $no_ktp,
             "p_name" => $nama,
             "p_sex" => $sex,
             "p_birthplace" => $tempat_lahir,
             "p_birthdate" => $tanggal_lahir,
             "p_hp" => $no_hp,
             "p_telp" => $no_tlp,
             "p_status" => strtoupper($status),
             "p_many_kids" => strtoupper($jml_anak),
             "p_religion" => strtoupper($agama),
             "p_address" => strtoupper($alamat),
             "p_rt_rw" => strtoupper($rt),
             "p_kel" => strtoupper($desa),
             "p_kecamatan" => strtoupper($kecamatan),
             "p_city" => strtoupper($kota),
             "p_address_now" => strtoupper($alamat_now),
             "p_rt_rw_now" => strtoupper($rt_now),
             "p_kel_now" => strtoupper($desa_now),
             "p_kecamatan_now" => strtoupper($kecamatan_now),
             "p_city_now" => strtoupper($kota_now),
             "p_name_family" => strtoupper($nama_keluarga),
             "p_address_family" => strtoupper($alamat_keluarga),
             "p_telp_family" => strtoupper($telp_keluarga),
             "p_hp_family" => strtoupper($hp_keluarga),
             "p_hubungan_family" => strtoupper($hubungan_keluarga),
             "p_wife_name" => strtoupper($wife_name),
             "p_wife_birth" => strtoupper($wife_tanggal),
             "p_wife_birthplace" => strtoupper($wife_lahir),
             "p_dad_name" => strtoupper($dadname),
             "p_dad_job" => strtoupper($dadjob),
             "p_mom_name" => strtoupper($momname),
             "p_mom_job" => strtoupper($momjob),
             "p_job_now" => strtoupper($saatini),
             "p_weight" => strtoupper($beratbadan),
             "p_height" => strtoupper($tinggibadan),
             "p_seragam_size" => strtoupper($ukuranbaju),
             "p_celana_size" => strtoupper($ukurancelana),
             "p_sepatu_size" => strtoupper($ukuransepatu),
             "p_kpk" => null,
             "p_bu" => null,
             "p_ktp_expired" => null,
             "p_ktp_seumurhidup" => null,
             "p_education" => strtoupper($pendidikan),
             "p_kpj_no" => null,
             "p_state" => strtoupper($warga_negara),
             "p_note" => null,
             "p_img" => $imglama,
             "p_img_ktp" => $request->imgktplama,
             "p_img_skck" => $request->imgskcklama,
             "p_img_ijazah" => $request->imgijazahlama,
             "p_img_medical" => $request->imgmedicallama,
             "p_insert" => Carbon::now('Asia/Jakarta'),
             "p_update" => Carbon::now('Asia/Jakarta')
         ));

     }

     $addKeterampilan = [];
     for ($i = 0; $i < count($keterampilan); $i++) {
         $temp = [];
         if ($keterampilan[$i] != '' || $keterampilan != null) {
             $temp = array(
                 'pk_pegawai' => $id,
                 'pk_detailid' => $i + 1,
                 'pk_keterampilan' => strtoupper($keterampilan[$i])
             );
             array_push($addKeterampilan, $temp);
         }
     }
     DB::table('d_pegawai_keterampilan')->insert($addKeterampilan);

     $addBahasa = [];
     for ($i = 0; $i < count($bahasa); $i++) {
         $temp = [];
         if ($bahasa[$i] == 'Lain' && $bahasa_lain != '') {
             $temp = array(
                 'pl_pegawai' => $id,
                 'pl_detailid' => $i + 1,
                 'pl_language' => strtoupper($bahasa_lain)
             );
         } else {
             if ($bahasa[$i] != null || $bahasa[$i] != '') {
                 $temp = array(
                     'pl_pegawai' => $id,
                     'pl_detailid' => $i + 1,
                     'pl_language' => strtoupper($bahasa[$i])
                 );
             }
         }
         array_push($addBahasa, $temp);
     }
     DB::table('d_pegawai_language')->insert($addBahasa);

     $addSIM = [];
     for ($i = 0; $i < count($sim); $i++) {
         $temp = [];
         if ($sim[$i] != null || $sim[$i] != '') {
             $temp = array(
                 'ps_pegawai' => $id,
                 'ps_detailid' => $i + 1,
                 'ps_sim' => $sim[$i],
                 'ps_note' => strtoupper($simket)
             );
             array_push($addSIM, $temp);
         }
     }
     DB::table('d_pegawai_sim')->insert($addSIM);

     $addPengalaman = [];
     for ($i = 0; $i < count($pengalaman_corp); $i++) {
         $temp = [];
         if ($pengalaman_corp[$i] != null || $pengalaman_corp[$i] != '') {
             $temp = array(
                 'pp_pegawai' => $id,
                 'pp_detailid' => $i + 1,
                 'pp_perusahaan' => strtoupper($pengalaman_corp[$i]),
                 'pp_start' => $start_pengalaman[$i],
                 'pp_end' => $end_pengalaman[$i],
                 'pp_jabatan' => strtoupper($jabatan_pengalaman[$i])
             );
             array_push($addPengalaman, $temp);
         }
     }
     DB::table('d_pegawai_pengalaman')->insert($addPengalaman);

     $addReferensi = [];
     for ($i = 0; $i < count($referensi); $i++) {
         $temp = [];
         if ($referensi[$i] == 'Lain') {
             $temp = array(
                 'pr_pegawai' => $id,
                 'pr_detailid' => $i + 1,
                 'pr_referensi' => strtoupper($referensi_lain)
             );
         } else {
             if ($referensi[$i] != null || $referensi[$i] != '') {
                 $temp = array(
                     'pr_pegawai' => $id,
                     'pr_detailid' => $i + 1,
                     'pr_referensi' => strtoupper($referensi[$i])
                 );
             }
         }
         array_push($addReferensi, $temp);
     }
     DB::table('d_pegawai_referensi')->insert($addReferensi);

     $addChild = [];
     for ($i = 0; $i < count($childname); $i++) {
         $temp = [];
         if ($childname[$i] != '' || $childname[$i] != null || $childname[$i] != ' ' || $childname[$i] != "") {
             if ($childdate[$i] != "") {
                 $childdate[$i] = Carbon::createFromFormat('d/m/Y', $childdate[$i], 'Asia/Jakarta');
                 $temp = array(
                     'pc_pegawai' => $id,
                     'pc_detailid' => $i + 1,
                     'pc_child_name' => strtoupper($childname[$i]),
                     'pc_birth_date' => $childdate[$i],
                     'pc_birth_place' => strtoupper($childplace[$i])
                 );
                 array_push($addChild, $temp);
             }
         }
     }
     DB::table('d_pegawai_child')->insert($addChild);


     DB::commit();
     Session::flash('sukses', 'data pegawai anda berhasil diperbarui');
     return redirect('manajemen-pegawai/data-pegawai');
 } catch (\Exception $e) {
     DB::rollback();
     Session::flash('gagal', 'data pegawai tidak dapat diperbarui');
     return redirect('manajemen-pegawai/data-pegawai');
 }

}

    public function detail(Request $request)
    {

        $list = DB::table('d_pegawai')
            ->select('d_pegawai.*')
            ->where('d_pegawai.p_id', $request->id)
            ->get();

            $data = array();
            foreach ($list as $r) {
                $data[] = (array)$r;
            }
            $i = 0;
            foreach ($data as $key) {
                // add new data
                Carbon::setLocale('id');
                $datedefault = new Carbon('01-01-1970');
                $data[$i]['p_birthdate'] = Date('d-m-Y', strtotime($data[$i]['p_birthdate']));

              }

        // dd($data);
        echo json_encode($list);

    }

    public function detail_mutasi(Request $request)
    {
        $list_mutasi = DB::table('d_pegawai_mutation')
            ->select('d_pegawai_mutation.*')
            ->where('d_pegawai_mutation.pm_pegawai', '=', $request->id)
            ->get();

        $data = array();
        foreach ($list_mutasi as $r) {
            $data[] = (array)$r;
        }
        $i = 0;
        foreach ($data as $key) {
            // add new data
            Carbon::setLocale('id');
            $data[$i]['pm_date'] = Date('d-m-Y H:i:s', strtotime($data[$i]['pm_date']));

        echo json_encode($data);

    }
}

    public function cari(){
      return view('pegawai.cari');
    }

    public function getno(Request $request){
      $keyword = $request->term;

      $data = DB::table('d_pegawai')
            ->whereRaw("p_name LIKE '%".$keyword."%' OR p_nip LIKE '%".$keyword."%'")
            ->where('p_status_approval', 'Y')
            ->LIMIT(20)
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

    public function getdata(Request $request){
      $data = DB::table('d_pegawai')
              ->where('p_id', $request->id)
              ->get();

      return response()->json($data);
    }

    public function tablecari() {
        DB::statement(DB::raw('set @rownum=0'));
        $pegawai = d_pegawai::select(DB::raw('@rownum  := @rownum  + 1 AS number'),'d_pegawai.*')->where('p_status_approval', 'Y')->get();
        return Datatables::of($pegawai)
                       ->addColumn('action', function ($pegawai) {
                            return '<div class="text-center">
                                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail(' . $pegawai->p_id . ')"><i class="glyphicon glyphicon-folder-open"></i></button>
                                    <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="' . $pegawai->p_id .'/edit"><i class="glyphicon glyphicon-edit"></i></a>
                                    </div>';
                        })
                        ->make(true);
    }

}
