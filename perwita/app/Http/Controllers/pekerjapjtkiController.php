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

use App\Http\Controllers\AksesUser;

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

class pekerjapjtkiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      if (!AksesUser::checkAkses(11, 'read')) {
          return redirect('not-authorized');
      }

        return view('pekerja-pjtki.index');
    }

    public function data()
    {
        DB::statement(DB::raw('set @rownum=0'));

        $pekerja = DB::select("select @rownum := @rownum + 1 as number, pp_id, pp_name, pp_nip, pp_sex, pp_address, pp_hp, ppm_detailid, ppm_status from d_pekerja_pjtki p join d_pekerja_pjtki_mutation pm on pp_id = ppm_pekerja cross join (select @rownum := 0) r where ppm_detailid = (select max(ppm_detailid) from d_pekerja_pjtki_mutation where ppm_pekerja = p.pp_id) and ppm_status = 'Aktif' order by pp_name");

        $pekerja = collect($pekerja);

        return Datatables::of($pekerja)
            ->editColumn('ppm_status', function ($pekerja) {

                if ($pekerja->ppm_status == 'Calon')
                    return '<div class="text-center"><span class="label label-warning ">Calon</span></div>';
                if ($pekerja->ppm_status == 'Aktif')
                    return '<div class="text-center"><span class="label label-success ">Aktif</span></div>';
                if ($pekerja->ppm_status == 'Ex')
                    return '<div class="text-center"><span class="label label-danger ">Tidak Aktif</span></div>';
            })
            ->addColumn('action', function ($pekerja) {
                return '<div class="text-center">
                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail(' . $pekerja->pp_id . ')"><i class="glyphicon glyphicon-folder-open"></i></button>
                    <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="data-pekerja/' . $pekerja->pp_id . '/edit"><i class="glyphicon glyphicon-edit"></i></a>
                  </div>';
            })
            ->make(true);
    }

    public function dataCalon()
    {
        DB::statement(DB::raw('set @rownum=0'));

        $pekerja = DB::select("select @rownum := @rownum + 1 as number, pp_id, pp_name, pp_sex, pp_address, pp_hp, ppm_detailid, ppm_status from d_pekerja_pjtki p join d_pekerja_pjtki_mutation pm on pp_id = ppm_pekerja cross join (select @rownum := 0) r where ppm_detailid = (select max(ppm_detailid) from d_pekerja_pjtki_mutation where ppm_pekerja = p.pp_id) and ppm_status = 'Calon' order by pp_name");

        $pekerja = collect($pekerja);

        return Datatables::of($pekerja)
            ->editColumn('ppm_status', function ($pekerja) {

                if ($pekerja->ppm_status == 'Calon')
                    return '<div class="text-center"><span class="label label-warning ">Calon</span></div>';
                if ($pekerja->ppm_status == 'Aktif')
                    return '<div class="text-center"><span class="label label-success ">Aktif</span></div>';
                if ($pekerja->ppm_status == 'Ex')
                    return '<div class="text-center"><span class="label label-danger ">Tidak Aktif</span></div>';
            })
            ->addColumn('action', function ($pekerja) {
                return '<div class="text-center">
                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail(' . $pekerja->pp_id . ')"><i class="glyphicon glyphicon-folder-open"></i></button>
                    <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="data-pekerja/' . $pekerja->pp_id . '/edit"><i class="glyphicon glyphicon-edit"></i></a>
                    <button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus(' . $pekerja->pp_id . ')"><i class="glyphicon glyphicon-trash"></i></button>
                  </div>';
            })
            ->make(true);
    }

    public function dataEx()
    {
        DB::statement(DB::raw('set @rownum=0'));

        $pekerja = DB::select("select @rownum := @rownum + 1 as number, pp_id, pp_name, pp_nip, pp_sex, pp_address, pp_hp, ppm_detailid, ppm_status from d_pekerja_pjtki p join d_pekerja_pjtki_mutation pm on pp_id = ppm_pekerja cross join (select @rownum := 0) r where ppm_detailid = (select max(ppm_detailid) from d_pekerja_pjtki_mutation where ppm_pekerja = p.pp_id) and ppm_status = 'Ex' order by pp_name");

        $pekerja = collect($pekerja);

        return Datatables::of($pekerja)
            ->editColumn('ppm_status', function ($pekerja) {

                if ($pekerja->ppm_status == 'Calon')
                    return '<div class="text-center"><span class="label label-warning ">Calon</span></div>';
                if ($pekerja->ppm_status == 'Aktif')
                    return '<div class="text-center"><span class="label label-success ">Aktif</span></div>';
                if ($pekerja->ppm_status == 'Ex')
                    return '<div class="text-center"><span class="label label-danger ">Tidak Aktif</span></div>';
            })
            ->addColumn('action', function ($pekerja) {
                return '<div class="text-center">
                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail(' . $pekerja->pp_id . ')"><i class="glyphicon glyphicon-folder-open"></i></button>
                    <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="data-pekerja/' . $pekerja->pp_id . '/edit"><i class="glyphicon glyphicon-edit"></i></a>
                    <button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus(' . $pekerja->pp_id . ')"><i class="glyphicon glyphicon-trash"></i></button>
                  </div>';
            })
            ->make(true);
    }

    public function tambah()
    {

        $jabPelamar = DB::table('d_jabatan_pelamar')
            ->select('*')
            ->orderBy('jp_name')
            ->get();

        return view('pekerja-pjtki.formTambah', compact('jabPelamar'));

    }

    public function simpan(Request $request)
    {
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

            $idPekerja = DB::table('d_pekerja_pjtki')
                ->max('pp_id');

            $idPekerja = $idPekerja + 1;

            $imgPath = null;
            $tgl = carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'image/uploads/pekerja/' . $idPekerja;
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

            if ($saatini == 'Kuliah') {
                $saatini = 'Kuliah di ' . $kuliahnow;
            }

            DB::table('d_pekerja_pjtki')->insert(array(
                "pp_id" => $idPekerja,
                "pp_jabatan_lamaran" => strtoupper($jabatanpelamar),
                "pp_nip" => null,
                "pp_ktp" => $no_ktp,
                "pp_name" => $nama,
                "pp_sex" => $jenkel,
                "pp_birthplace" => $tempat_lahir,
                "pp_birthdate" => $tanggal_lahir,
                "pp_hp" => $no_hp,
                "pp_telp" => $no_tlp,
                "pp_status" => strtoupper($status),
                "pp_many_kids" => strtoupper($jml_anak),
                "pp_religion" => strtoupper($agama),
                "pp_address" => strtoupper($alamat),
                "pp_rt_rw" => strtoupper($rt),
                "pp_kel" => strtoupper($desa),
                "pp_kecamatan" => strtoupper($kecamatan),
                "pp_city" => strtoupper($kota),
                "pp_address_now" => strtoupper($alamat_now),
                "pp_rt_rw_now" => strtoupper($rt_now),
                "pp_kel_now" => strtoupper($desa_now),
                "pp_kecamatan_now" => strtoupper($kecamatan_now),
                "pp_city_now" => strtoupper($kota_now),
                "pp_name_family" => strtoupper($nama_keluarga),
                "pp_address_family" => strtoupper($alamat_keluarga),
                "pp_telp_family" => strtoupper($telp_keluarga),
                "pp_hp_family" => strtoupper($hp_keluarga),
                "pp_hubungan_family" => strtoupper($hubungan_keluarga),
                "pp_wife_name" => strtoupper($wife_name),
                "pp_wife_birth" => strtoupper($wife_tanggal),
                "pp_wife_birthplace" => strtoupper($wife_lahir),
                "pp_dad_name" => strtoupper($dadname),
                "pp_dad_job" => strtoupper($dadjob),
                "pp_mom_name" => strtoupper($momname),
                "pp_mom_job" => strtoupper($momjob),
                "pp_job_now" => strtoupper($saatini),
                "pp_weight" => strtoupper($beratbadan),
                "pp_height" => strtoupper($tinggibadan),
                "pp_seragam_size" => strtoupper($ukuranbaju),
                "pp_celana_size" => strtoupper($ukurancelana),
                "pp_sepatu_size" => strtoupper($ukuransepatu),
                "pp_kpk" => null,
                "pp_bu" => null,
                "pp_ktp_expired" => null,
                "pp_ktp_seumurhidup" => null,
                "pp_education" => strtoupper($pendidikan),
                "pp_kpj_no" => null,
                "pp_state" => strtoupper($warga_negara),
                "pp_note" => null,
                "pp_img" => $imgPath,
                "pp_insert_by" => Session::get('mem'),
                "pp_insert" => Carbon::now('Asia/Jakarta'),
                "pp_update" => Carbon::now('Asia/Jakarta')
            ));

            $addKeterampilan = [];
            for ($i = 0; $i < count($keterampilan); $i++) {
                $temp = [];
                if ($keterampilan[$i] != '' || $keterampilan != null) {
                    $temp = array(
                        'ppk_pekerja' => $idPekerja,
                        'ppk_detailid' => $i + 1,
                        'ppk_keterampilan' => strtoupper($keterampilan[$i])
                    );
                    array_push($addKeterampilan, $temp);
                }
            }
            DB::table('d_pekerja_pjtki_keterampilan')->insert($addKeterampilan);

            $addBahasa = [];
            for ($i = 0; $i < count($bahasa); $i++) {
                $temp = [];
                if ($bahasa[$i] == 'Lain' && $bahasa_lain != '') {
                    $temp = array(
                        'ppl_pekerja' => $idPekerja,
                        'ppl_detailid' => $i + 1,
                        'ppl_language' => strtoupper($bahasa_lain)
                    );
                } else {
                    if ($bahasa[$i] != null || $bahasa[$i] != '') {
                        $temp = array(
                            'ppl_pekerja' => $idPekerja,
                            'ppl_detailid' => $i + 1,
                            'ppl_language' => strtoupper($bahasa[$i])
                        );
                    }
                }
                array_push($addBahasa, $temp);
            }
            DB::table('d_pekerja_pjtki_language')->insert($addBahasa);

            $addSIM = [];
            for ($i = 0; $i < count($sim); $i++) {
                $temp = [];
                if ($sim[$i] != null || $sim[$i] != '') {
                    $temp = array(
                        'pps_pekerja' => $idPekerja,
                        'pps_detailid' => $i + 1,
                        'pps_sim' => $sim[$i],
                        'pps_note' => strtoupper($simket)
                    );
                    array_push($addSIM, $temp);
                }
            }
            DB::table('d_pekerja_pjtki_sim')->insert($addSIM);

            $addPengalaman = [];
            for ($i = 0; $i < count($pengalaman_corp); $i++) {
                $temp = [];
                if ($pengalaman_corp[$i] != null || $pengalaman_corp[$i] != '') {
                    $temp = array(
                        'ppp_pekerja' => $idPekerja,
                        'ppp_detailid' => $i + 1,
                        'ppp_perusahaan' => strtoupper($pengalaman_corp[$i]),
                        'ppp_start' => $start_pengalaman[$i],
                        'ppp_end' => $end_pengalaman[$i],
                        'ppp_jabatan' => strtoupper($jabatan_pengalaman[$i])
                    );
                    array_push($addPengalaman, $temp);
                }
            }
            DB::table('d_pekerja_pjtki_pengalaman')->insert($addPengalaman);

            $addReferensi = [];
            for ($i = 0; $i < count($referensi); $i++) {
                $temp = [];
                if ($referensi[$i] == 'Lain') {
                    $temp = array(
                        'ppr_pekerja' => $idPekerja,
                        'ppr_detailid' => $i + 1,
                        'ppr_referensi' => strtoupper($referensi_lain)
                    );
                } else {
                    if ($referensi[$i] != null || $referensi[$i] != '') {
                        $temp = array(
                            'ppr_pekerja' => $idPekerja,
                            'ppr_detailid' => $i + 1,
                            'ppr_referensi' => strtoupper($referensi[$i])
                        );
                    }
                }
                array_push($addReferensi, $temp);
            }
              DB::table('d_pekerja_pjtki_referensi')->insert($addReferensi);

            $addChild = [];
            for ($i = 0; $i < count($childname); $i++) {
                $temp = [];
                if ($childname[$i] != '' || $childname[$i] != null || $childname[$i] != ' ' || $childname[$i] != "") {
                    if ($childdate[$i] != "") {
                        $childdate[$i] = Carbon::createFromFormat('d/m/Y', $childdate[$i], 'Asia/Jakarta');
                        $temp = array(
                            'ppc_pekerja' => $idPekerja,
                            'ppc_detailid' => $i + 1,
                            'ppc_child_name' => strtoupper($childname[$i]),
                            'ppc_birth_date' => $childdate[$i],
                            'ppc_birth_place' => strtoupper($childplace[$i])
                        );
                        array_push($addChild, $temp);
                    }
                }
            }
            DB::table('d_pekerja_pjtki_child')->insert($addChild);

            DB::table('d_pekerja_pjtki_mutation')->insert(array(
                'ppm_pekerja' => $idPekerja,
                'ppm_detailid' => 1,
                'ppm_date' => Carbon::now('Asia/Jakarta'),
                'ppm_detail' => 'Masuk',
                'ppm_status' => 'Calon',
                'ppm_insert_by' => Session::get('mem')
            ));

            DB::commit();
            Session::flash('sukses', 'data pekerja baru anda berhasil disimpan');
            return redirect('pekerja-pjtki/data-pekerja');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('gagal', 'data pekerja tidak dapat di simpan');
            return redirect('pekerja-pjtki/data-pekerja');
        }
    }

    public function edit($id)
    {
        $jabatan = DB::table('d_jabatan_pelamar')
            ->select('jp_name', 'jp_id')->get();

        $pekerja = DB::table('d_pekerja_pjtki')
            ->where('pp_id', '=', $id)
            ->select('pp_name'
                , 'pp_address'
                , 'pp_rt_rw'
                , 'pp_kecamatan'
                , 'pp_kel'
                , 'pp_nip'
                , 'pp_city'
                , 'pp_jabatan_lamaran'
                , 'pp_address_now'
                , 'pp_rt_rw_now'
                , 'pp_kecamatan_now'
                , 'pp_kel_now'
                , 'pp_city_now'
                , 'pp_birthplace'
                , 'pp_birthdate'
                , 'pp_ktp'
                , 'pp_telp'
                , 'pp_hp'
                , 'pp_sex'
                , 'pp_state'
                , 'pp_status'
                , 'pp_many_kids'
                , 'pp_religion'
                , 'pp_education'
                , 'pp_name_family'
                , 'pp_address_family'
                , 'pp_telp_family'
                , 'pp_hp_family'
                , 'pp_address_family'
                , 'pp_hubungan_family'
                , 'pp_wife_name'
                , 'pp_wife_birth'
                , 'pp_wife_birthplace'
                , 'pp_dad_name'
                , 'pp_dad_job'
                , 'pp_mom_name'
                , 'pp_mom_job'
                , 'pp_job_now'
                , 'pp_weight'
                , 'pp_height'
                , 'pp_seragam_size'
                , 'pp_celana_size'
                , 'pp_sepatu_size'
                , 'pp_img')
            ->get();

        $child = DB::table('d_pekerja_pjtki_child')
            ->select('ppc_child_name', 'ppc_birth_place', 'ppc_birth_date')
            ->where('ppc_pekerja', '=', $id)
            ->get();

        $keterampilan = DB::table('d_pekerja_pjtki_keterampilan')
            ->select('ppk_keterampilan')
            ->where('ppk_pekerja', '=', $id)
            ->get();

        // $bahasa = DB::table('d_pekerja_language')
        //        ->select('pl_language')
        //        ->where('pl_pekerja', '=', $id)
        //        ->get();

        $bahasa = DB::select("select ppl_pekerja, (select ppl_language from d_pekerja_pjtki_language ppl where ppl.ppl_pekerja = '$id' and ppl.ppl_language = 'INDONESIA') as indonesia, (select ppl_language from d_pekerja_pjtki_language ppl where ppl.ppl_pekerja = '$id' and ppl.ppl_language = 'INGGRIS') as inggris, (select ppl_language from d_pekerja_pjtki_language ppl where ppl.ppl_pekerja = '$id' and ppl.ppl_language = 'MANDARIN') as mandarin, (select ppl_language from d_pekerja_pjtki_language ppl where ppl.ppl_pekerja = '$id' and ppl.ppl_language != 'INDONESIA' and ppl.ppl_language != 'INGGRIS' and ppl.ppl_language != 'MANDARIN') as lain from d_pekerja_pjtki_language dpl where ppl_pekerja = '$id' group by ppl_pekerja");
        //dd($bahasa);

        $pengalaman = DB::table('d_pekerja_pjtki_pengalaman')
            ->select('ppp_perusahaan', 'ppp_start', 'ppp_end', 'ppp_jabatan')
            ->where('ppp_pekerja', '=', $id)
            ->get();

        $referensi = DB::select("select *,
(select ppr_referensi from d_pekerja_pjtki_referensi pr where pr.ppr_pekerja = '$id' and pr.ppr_referensi = 'TEMAN') as teman,
(select ppr_referensi from d_pekerja_pjtki_referensi pr where pr.ppr_pekerja = '$id' and pr.ppr_referensi = 'KELUARGA') as keluarga,
(select ppr_referensi from d_pekerja_pjtki_referensi pr where pr.ppr_pekerja = '$id' and pr.ppr_referensi = 'KORAN') as koran,
(select ppr_referensi from d_pekerja_pjtki_referensi pr where pr.ppr_pekerja = '$id' and pr.ppr_referensi = 'INTERNET') as internet,
(select ppr_referensi from d_pekerja_pjtki_referensi pr where pr.ppr_pekerja = '$id' and pr.ppr_referensi != 'TEMAN' and pr.ppr_referensi != 'KELUARGA' and pr.ppr_referensi != 'KORAN' and pr.ppr_referensi != 'INTERNET') as lain
from d_pekerja_pjtki_referensi dpr
where ppr_pekerja = '$id'
group by ppr_pekerja");

        $sim = DB::select("select pps_pekerja,
(select pps_sim from d_pekerja_pjtki_sim ps where ps.pps_pekerja = '$id' and ps.pps_sim = 'SIM C') as simc,
(select pps_sim from d_pekerja_pjtki_sim ps where ps.pps_pekerja = '$id' and ps.pps_sim = 'SIM A') as sima,
(select pps_sim from d_pekerja_pjtki_sim ps where ps.pps_pekerja = '$id' and ps.pps_sim = 'SIM B') as simb,
(select pps_note from d_pekerja_pjtki_sim ps where ps.pps_pekerja = '$id' and ps.pps_note != '') as note
from d_pekerja_pjtki_sim dps
where pps_pekerja = '$id'
group by pps_pekerja");
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

        return view('pekerja-pjtki.formEdit', compact('id', 'pekerja', 'jabatan', 'child', 'keterampilan', 'bahasa', 'pengalaman', 'referensi', 'sim'));

    }

    public function perbarui(Request $request)
    {
         DB::beginTransaction();
          try {
        $id = $request->id;
        $imglama = $request->imglama;

        DB::table('d_pekerja_pjtki')->where('pp_id', '=', $id)
            ->delete();

        DB::table('d_pekerja_pjtki_child')->where('ppc_pekerja', '=', $id)
            ->delete();

        DB::table('d_pekerja_pjtki_keterampilan')->where('ppk_pekerja', '=', $id)
            ->delete();

        DB::table('d_pekerja_pjtki_language')->where('ppl_pekerja', '=', $id)
            ->delete();

        DB::table('d_pekerja_pjtki_pengalaman')->where('ppp_pekerja', '=', $id)
            ->delete();

        DB::table('d_pekerja_pjtki_referensi')->where('ppr_pekerja', '=', $id)
            ->delete();

        DB::table('d_pekerja_pjtki_sim')->where('pps_pekerja', '=', $id)
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
            $dir = 'image/uploads/pekerja/' . $id;
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


            DB::table('d_pekerja_pjtki')->insert(array(
                "pp_id" => $id,
                "pp_jabatan_lamaran" => strtoupper($jabatanpelamar),
                "pp_nip" => null,
                "pp_ktp" => $no_ktp,
                "pp_name" => $nama,
                "pp_sex" => $sex,
                "pp_birthplace" => $tempat_lahir,
                "pp_birthdate" => $tanggal_lahir,
                "pp_hp" => $no_hp,
                "pp_telp" => $no_tlp,
                "pp_status" => strtoupper($status),
                "pp_many_kids" => strtoupper($jml_anak),
                "pp_religion" => strtoupper($agama),
                "pp_address" => strtoupper($alamat),
                "pp_rt_rw" => strtoupper($rt),
                "pp_kel" => strtoupper($desa),
                "pp_kecamatan" => strtoupper($kecamatan),
                "pp_city" => strtoupper($kota),
                "pp_address_now" => strtoupper($alamat_now),
                "pp_rt_rw_now" => strtoupper($rt_now),
                "pp_kel_now" => strtoupper($desa_now),
                "pp_kecamatan_now" => strtoupper($kecamatan_now),
                "pp_city_now" => strtoupper($kota_now),
                "pp_name_family" => strtoupper($nama_keluarga),
                "pp_address_family" => strtoupper($alamat_keluarga),
                "pp_telp_family" => strtoupper($telp_keluarga),
                "pp_hp_family" => strtoupper($hp_keluarga),
                "pp_hubungan_family" => strtoupper($hubungan_keluarga),
                "pp_wife_name" => strtoupper($wife_name),
                "pp_wife_birth" => strtoupper($wife_tanggal),
                "pp_wife_birthplace" => strtoupper($wife_lahir),
                "pp_dad_name" => strtoupper($dadname),
                "pp_dad_job" => strtoupper($dadjob),
                "pp_mom_name" => strtoupper($momname),
                "pp_mom_job" => strtoupper($momjob),
                "pp_job_now" => strtoupper($saatini),
                "pp_weight" => strtoupper($beratbadan),
                "pp_height" => strtoupper($tinggibadan),
                "pp_seragam_size" => strtoupper($ukuranbaju),
                "pp_celana_size" => strtoupper($ukurancelana),
                "pp_sepatu_size" => strtoupper($ukuransepatu),
                "pp_kpk" => null,
                "pp_bu" => null,
                "pp_ktp_expired" => null,
                "pp_ktp_seumurhidup" => null,
                "pp_education" => strtoupper($pendidikan),
                "pp_kpj_no" => null,
                "pp_state" => strtoupper($warga_negara),
                "pp_note" => null,
                "pp_img" => $imgPath,
                "pp_insert" => Carbon::now('Asia/Jakarta'),
                "pp_update" => Carbon::now('Asia/Jakarta')
            ));

        } else {

            $imgPath = null;
            $tgl = carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'image/uploads/pekerja/' . $id;
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


            DB::table('d_pekerja_pjtki')->insert(array(
                "pp_id" => $id,
                "pp_jabatan_lamaran" => strtoupper($jabatanpelamar),
                "pp_nip" => null,
                "pp_ktp" => $no_ktp,
                "pp_name" => $nama,
                "pp_sex" => $sex,
                "pp_birthplace" => $tempat_lahir,
                "pp_birthdate" => $tanggal_lahir,
                "pp_hp" => $no_hp,
                "pp_telp" => $no_tlp,
                "pp_status" => strtoupper($status),
                "pp_many_kids" => strtoupper($jml_anak),
                "pp_religion" => strtoupper($agama),
                "pp_address" => strtoupper($alamat),
                "pp_rt_rw" => strtoupper($rt),
                "pp_kel" => strtoupper($desa),
                "pp_kecamatan" => strtoupper($kecamatan),
                "pp_city" => strtoupper($kota),
                "pp_address_now" => strtoupper($alamat_now),
                "pp_rt_rw_now" => strtoupper($rt_now),
                "pp_kel_now" => strtoupper($desa_now),
                "pp_kecamatan_now" => strtoupper($kecamatan_now),
                "pp_city_now" => strtoupper($kota_now),
                "pp_name_family" => strtoupper($nama_keluarga),
                "pp_address_family" => strtoupper($alamat_keluarga),
                "pp_telp_family" => strtoupper($telp_keluarga),
                "pp_hp_family" => strtoupper($hp_keluarga),
                "pp_hubungan_family" => strtoupper($hubungan_keluarga),
                "pp_wife_name" => strtoupper($wife_name),
                "pp_wife_birth" => strtoupper($wife_tanggal),
                "pp_wife_birthplace" => strtoupper($wife_lahir),
                "pp_dad_name" => strtoupper($dadname),
                "pp_dad_job" => strtoupper($dadjob),
                "pp_mom_name" => strtoupper($momname),
                "pp_mom_job" => strtoupper($momjob),
                "pp_job_now" => strtoupper($saatini),
                "pp_weight" => strtoupper($beratbadan),
                "pp_height" => strtoupper($tinggibadan),
                "pp_seragam_size" => strtoupper($ukuranbaju),
                "pp_celana_size" => strtoupper($ukurancelana),
                "pp_sepatu_size" => strtoupper($ukuransepatu),
                "pp_kpk" => null,
                "pp_bu" => null,
                "pp_ktp_expired" => null,
                "pp_ktp_seumurhidup" => null,
                "pp_education" => strtoupper($pendidikan),
                "pp_kpj_no" => null,
                "pp_state" => strtoupper($warga_negara),
                "pp_note" => null,
                "pp_img" => $imglama,
                "pp_insert" => Carbon::now('Asia/Jakarta'),
                "pp_update" => Carbon::now('Asia/Jakarta')
            ));

        }

        $addKeterampilan = [];
        for ($i = 0; $i < count($keterampilan); $i++) {
            $temp = [];
            if ($keterampilan[$i] != '' || $keterampilan != null) {
                $temp = array(
                    'ppk_pekerja' => $id,
                    'ppk_detailid' => $i + 1,
                    'ppk_keterampilan' => strtoupper($keterampilan[$i])
                );
                array_push($addKeterampilan, $temp);
            }
        }
        DB::table('d_pekerja_pjtki_keterampilan')->insert($addKeterampilan);

        $addBahasa = [];
        for ($i = 0; $i < count($bahasa); $i++) {
            $temp = [];
            if ($bahasa[$i] == 'Lain' && $bahasa_lain != '') {
                $temp = array(
                    'ppl_pekerja' => $id,
                    'ppl_detailid' => $i + 1,
                    'ppl_language' => strtoupper($bahasa_lain)
                );
            } else {
                if ($bahasa[$i] != null || $bahasa[$i] != '') {
                    $temp = array(
                        'ppl_pekerja' => $id,
                        'ppl_detailid' => $i + 1,
                        'ppl_language' => strtoupper($bahasa[$i])
                    );
                }
            }
            array_push($addBahasa, $temp);
        }
        DB::table('d_pekerja_pjtki_language')->insert($addBahasa);

        $addSIM = [];
        for ($i = 0; $i < count($sim); $i++) {
            $temp = [];
            if ($sim[$i] != null || $sim[$i] != '') {
                $temp = array(
                    'pps_pekerja' => $id,
                    'pps_detailid' => $i + 1,
                    'pps_sim' => $sim[$i],
                    'pps_note' => strtoupper($simket)
                );
                array_push($addSIM, $temp);
            }
        }
        DB::table('d_pekerja_pjtki_sim')->insert($addSIM);

        $addPengalaman = [];
        for ($i = 0; $i < count($pengalaman_corp); $i++) {
            $temp = [];
            if ($pengalaman_corp[$i] != null || $pengalaman_corp[$i] != '') {
                $temp = array(
                    'ppp_pekerja' => $id,
                    'ppp_detailid' => $i + 1,
                    'ppp_perusahaan' => strtoupper($pengalaman_corp[$i]),
                    'ppp_start' => $start_pengalaman[$i],
                    'ppp_end' => $end_pengalaman[$i],
                    'ppp_jabatan' => strtoupper($jabatan_pengalaman[$i])
                );
                array_push($addPengalaman, $temp);
            }
        }
        DB::table('d_pekerja_pjtki_pengalaman')->insert($addPengalaman);

        $addReferensi = [];
        for ($i = 0; $i < count($referensi); $i++) {
            $temp = [];
            if ($referensi[$i] == 'Lain') {
                $temp = array(
                    'ppr_pekerja' => $id,
                    'ppr_detailid' => $i + 1,
                    'ppr_referensi' => strtoupper($referensi_lain)
                );
            } else {
                if ($referensi[$i] != null || $referensi[$i] != '') {
                    $temp = array(
                        'ppr_pekerja' => $id,
                        'ppr_detailid' => $i + 1,
                        'ppr_referensi' => strtoupper($referensi[$i])
                    );
                }
            }
            array_push($addReferensi, $temp);
        }
        DB::table('d_pekerja_pjtki_referensi')->insert($addReferensi);

        $addChild = [];
        for ($i = 0; $i < count($childname); $i++) {
            $temp = [];
            if ($childname[$i] != '' || $childname[$i] != null || $childname[$i] != ' ' || $childname[$i] != "") {
                if ($childdate[$i] != "") {
                    $childdate[$i] = Carbon::createFromFormat('d/m/Y', $childdate[$i], 'Asia/Jakarta');
                    $temp = array(
                        'ppc_pekerja' => $id,
                        'ppc_detailid' => $i + 1,
                        'ppc_child_name' => strtoupper($childname[$i]),
                        'ppc_birth_date' => $childdate[$i],
                        'ppc_birth_place' => strtoupper($childplace[$i])
                    );
                    array_push($addChild, $temp);
                }
            }
        }
        DB::table('d_pekerja_pjtki_child')->insert($addChild);


        DB::commit();
        Session::flash('sukses', 'data pekerja anda berhasil diperbarui');
        return redirect('pekerja-pjtki/data-pekerja');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('gagal', 'data pekerja anda tidak dapat di perbarui');

            return redirect('pekerja-pjtki/data-pekerja');
        }

    }

    public function hapus($id)
    {

        return DB::transaction(function () use ($id) {
            $pekerja = DB::table('d_pekerja_pjtki')->where('pp_id', $id);
            $pekerja_mutasi = DB::table('d_pekerja_pjtki_mutation')->where('ppm_pekerja', $id);

            $cari_max_pm_detailid = DB::table('d_pekerja_pjtki_mutation')
                ->where('ppm_pekerja', $id)
                ->max('ppm_detailid');

            $pekerja->update([
                'pp_state' => 3,
                'pp_note' => 'Ex'
            ]);

            $pekerja_mutasi->insert([
                'ppm_pekerja' => $id,
                'ppm_detailid' => $cari_max_pm_detailid + 1,
                'ppm_date' => Carbon::now('Asia/Jakarta'),
                'ppm_mitra' => null,
                'ppm_divisi' => null,
                'ppm_detail' => "Ex",
                'ppm_from' => null,
                'ppm_status' => "Ex"
            ]);

            return response()->json([
                'status' => 'berhasil',
            ]);

        });

    }

    public function detail(Request $request)
    {

        $list = DB::table('d_pekerja_pjtki')
            ->leftJoin('d_mitra_pekerja', 'd_pekerja.p_id', '=', 'd_mitra_pekerja.mp_pekerja')
            ->leftjoin('d_mitra', 'd_mitra_pekerja.mp_mitra', '=', 'd_mitra.m_id')
            ->leftjoin('d_mitra_divisi', 'd_mitra_pekerja.mp_divisi', '=', 'd_mitra_divisi.md_id')
            ->leftJoin('d_mitra_contract', function ($join) {
                $join->on('d_mitra_pekerja.mp_contract', '=', 'd_mitra_contract.mc_contractid')
                    ->on('d_mitra_pekerja.mp_mitra', '=', 'd_mitra_contract.mc_mitra');
            })
            ->select('d_pekerja.*', 'd_mitra_pekerja.*', 'd_mitra.*', 'd_mitra_contract.*', 'd_mitra_divisi.*')
            ->where('d_pekerja.p_id', $request->id)
            ->get();

        $data = array();
        foreach ($list as $r) {
            $data[] = (array)$r;
        }
        $i = 0;
        foreach ($data as $key) {
            // add new data
            Carbon::setLocale('id');
            $date1 = new Carbon($key['mc_date']);
            $date2 = new Carbon($key['mc_expired']);
            $datedefault = new Carbon('01-01-1970');
            $data[$i]['sisa_kontrak'] = $date2->diffForHumans();
            $data[$i]['p_birthdate'] = Date('d-m-Y', strtotime($data[$i]['p_birthdate']));
            $data[$i]['p_ktp_expired'] = Date('d-m-Y', strtotime($data[$i]['p_ktp_expired']));
            $data[$i]['mp_selection_date'] = Date('d-m-Y', strtotime($data[$i]['mp_selection_date']));
            $data[$i]['mp_workin_date'] = Date('d-m-Y', strtotime($data[$i]['mp_workin_date']));
            $data[$i]['mc_date'] = Date('d-m-Y', strtotime($data[$i]['mc_date']));
            $data[$i]['mc_expired'] = Date('d-m-Y', strtotime($data[$i]['mc_expired']));

            if ($key['mp_selection_date'] <= $datedefault) {
                $data[$i]['mp_selection_date'] = "-";
            }
            if ($key['mp_workin_date'] <= $datedefault) {
                $data[$i]['mp_workin_date'] = "-";
            }
            if ($key['mc_date'] <= $datedefault) {
                $data[$i]['mc_date'] = "-";
            }
            if ($key['mc_expired'] <= $datedefault) {
                $data[$i]['mc_expired'] = "-";
            }
            $i++;
        }

        // dd($data);
        echo json_encode($data);

    }

    public function detail_mutasi(Request $request)
    {
        $list_mutasi = DB::table('d_pekerja_pjtki_mutation')
            ->leftjoin('d_mitra', 'd_pekerja_mutation.pm_mitra', '=', 'd_mitra.m_id')
            ->leftjoin('d_mitra_divisi', 'd_pekerja_mutation.pm_divisi', '=', 'd_mitra_divisi.md_id')
            ->select('d_pekerja_mutation.*', 'd_mitra.*', 'd_mitra_divisi.*')
            ->where('d_pekerja_mutation.pm_pekerja', '=', $request->id)
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
            if ($key['m_name'] == null) {
                $data[$i]['m_name'] = '-';
            }
            if ($key['md_name'] == null) {
                $data[$i]['md_name'] = '-';
            }
            if ($key['pm_from'] == null) {
                $data[$i]['pm_from'] = '-';
            }
            $i++;
        }


        echo json_encode($data);

    }

    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            return false;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function resign(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;
            $keterangan = $request->keterangan;
            $tanggal = Carbon::createFromFormat('d/m/Y', $request->tanggal);
            $d_mitra_pekerja = d_mitra_pekerja::where('mp_pekerja', $id)->where('mp_status', '=', 'Aktif')->get();

            if ($d_mitra_pekerja[0]->mp_status == 'Aktif') {
                d_mitra_pekerja::where('mp_pekerja', $id)->update([
                    'mp_status' => 'Tidak'
                ]);

                d_pekerja::where('p_id', $id)->update([
                    'p_note' => 'Resign'
                ]);

                $cari_max_pm_detailid = DB::table('d_pekerja_mutation')
                    ->where('pm_pekerja', $id)
                    ->max('pm_detailid');

                $d_pekerja_mutation = d_pekerja_mutation::where('pm_pekerja', $id);
                $d_pekerja_mutation->insert([
                    'pm_pekerja' => $id,
                    'pm_detailid' => $cari_max_pm_detailid + 1,
                    'pm_date' => $tanggal,
                    'pm_mitra' => null,
                    'pm_divisi' => null,
                    'pm_from' => null,
                    'pm_detail' => 'Resign',
                    'pm_status' => 'Ex',
                    'pm_note' => $keterangan
                ]);

                DB::commit();
                return response()->json([
                    'status' => 'berhasil'
                ]);
            }

        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal'
            ]);
        }
    }

}
