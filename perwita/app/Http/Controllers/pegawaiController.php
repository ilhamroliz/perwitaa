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

use Carbon\carbon;

class pegawaiController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        return view('pegawai.index');
    }
    public function data() {
        DB::statement(DB::raw('set @rownum=0'));
        $pegawai = d_pegawai::select(DB::raw('@rownum  := @rownum  + 1 AS number'),'d_pegawai.*')->get();
        return Datatables::of($pegawai)
                       ->addColumn('action', function ($pegawai) {
                            return' <div class="dropdown">
                                            <button class="btn btn-primary btn-flat btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                Kelola
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="data-pegawai/' . $pegawai->p_id .'/edit" ><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a class="btn-delete" onclick="hapus('.$pegawai->p_id.')"></i>Hapus Data</a></li>
                                            </ul>
                                        </div>';
                        })
                        ->make(true);
    }
    public function tambah() {
      $jabPelamar = DB::table('d_jabatan_pelamar')
          ->select('*')
          ->orderBy('jp_name')
          ->get();

        return view('pegawai.formTambah', compact('jabPelamar'));
    }
    public function simpan(Request $request) {
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
        $pegawai=d_pegawai::where('p_id',$id)->first();
        return view('pegawai.formEdit',compact('pegawai'));
    }
    public function perbarui(Request $request,$id) {
        return DB::transaction(function() use ($request,$id) {

        $pegawai=d_pegawai::where('p_id',$id);
           $rules = [
                'NIK' => 'required',
                'Nama_Lengkap' => 'required',
                'Jenis_Kelamin' => 'required',
                'Tempat_Lahir' => 'required',
                'Tanggal_Lahir' => 'required',
                'Alamat' => 'required',
                'No_Telp' => 'required',
                'Nama_Ibu' => 'required',
                'Pendidikan' => 'required',
                'Tanggal_Masuk_Kerja' => 'required',
                'No_KTP' => 'required',
                'No_Rekening' => 'required',
                'No_KPK' => 'required',
                'No_JP' => 'required',
                'No_KPJ' => 'required',
            ];
              $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                                'status' => 'gagal',
                                'data' => $validator->errors()->toArray()
                    ]);
                }
                 $pegawai->update([
                    "p_nik"=>$request->NIK,
                    "p_nama_lengkap"=>$request->Nama_Lengkap,
                    "p_jenis_kelamin"=>$request->Jenis_Kelamin,
                    "p_tempat_lahir"=>$request->Tempat_Lahir,
                    "p_tgl_lahir"=>$request->Tanggal_Lahir,
                    "p_alamat"=>$request->Alamat,
                    "p_notelp"=>$request->No_Telp,
                    "p_nama_ibu"=>$request->Nama_Ibu,
                    "p_pendidikan"=>$request->Pendidikan,
                    "p_tgl_masuk_kerja"=>$request->Tanggal_Masuk_Kerja,
                    "p_no_ktp"=>$request->No_KTP,
                    "p_no_rekening"=>$request->No_Rekening,
                    "p_no_kpk"=>$request->No_KPK,
                    "p_no_jp"=>$request->No_JP,
                    "p_no_kpj"=>$request->No_KPJ,
                  ]);

                  return response()->json([
                        'status' => 'berhasil',
            ]);
        });
    }
    public function hapus($id) {
        return DB::transaction(function() use ($id) {
            $pegawai=d_pegawai::where('p_id',$id);
            if($pegawai->delete()){
                   return response()->json([
                        'status' => 'berhasil',
                    ]);
            }
        });

    }
}
