<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\d_pekerja_mutation;

use Carbon\Carbon;

use Session;

class SuratPeringatanController extends Controller
{
    public function index()
    {
        $data = DB::table('d_master_sp')
              ->get();

        return view('surat-peringatan.index', compact('data'));
    }

    public function data(){

      $data = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
            ->join('d_surat_pringatan', 'sp_pekerja', '=', 'p_id')
            ->join('d_mitra_divisi', function($e){
              $e->on('m_id', '=', 'md_mitra');
              $e->on('mp_divisi', '=', 'md_id');
            })
            ->select('sp_no', 'sp_date_start', 'sp_date_end', 'jp_name', 'sp_note', 'sp_id', 'mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'p_nip_mitra', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
            ->where('sp_isapproved','Y')
            ->get();

      if (count($data) > 0) {
        return response()->json($data);
      }

    }

    public function simpan(Request $request, $id){
      DB::beginTransaction();
      try {

        $kode = "";

        $queryid = DB::table('d_surat_pringatan')
            ->MAX('sp_id');

            if ($queryid == null) {
              $queryid = 0;
            }

        $querykode = DB::select(DB::raw("SELECT MAX(MID(sp_no,4,5)) as counter, MAX(MID(sp_no,13,2)) as bulan, MAX(RIGHT(sp_no,4)) as tahun FROM d_surat_pringatan"));

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

        $finalkode = 'SP.' . $kode . '/PN' . '/' . date('m') . '/' . date('Y');

        DB::table('d_surat_pringatan')
            ->insert([
              'sp_id' => $queryid + 1,
              'sp_no' => $finalkode,
              'sp_pekerja' => $id,
              'sp_jenis' => $request->sp,
              'sp_date_start' => Carbon::createFromFormat('d/m/Y',$request->start,'Asia/Jakarta'),
              'sp_date_end' => Carbon::createFromFormat('d/m/Y',$request->end,'Asia/Jakarta'),
              'sp_note' => $request->keterangan,
              'sp_insert' => Carbon::now('Asia/Jakarta')
            ]);

        $iddivisi = DB::table('d_mitra_pekerja')
                  ->select('mp_divisi')
                  ->where('mp_pekerja',$id)
                  ->get();

        $idmitra = DB::table('d_mitra_pekerja')
                  ->select('mp_mitra')
                  ->where('mp_pekerja',$id)
                  ->get();

        $pm_detailid = DB::table('d_pekerja_mutation')
                  ->select('pm_detailid')
                  ->where('pm_pekerja',$id)
                  ->MAX('pm_detailid');

        d_pekerja_mutation::insert([
          'pm_pekerja' => $id,
          'pm_detailid' => $pm_detailid + 1,
          'pm_mitra' => $idmitra[0]->mp_mitra,
          'pm_divisi' => $iddivisi[0]->mp_divisi,
          'pm_detail' => $request->sp,
          'pm_status' => 'Aktif',
          'pm_note' => $request->keterangan,
          'pm_insert_by' => Session::get('mem')
        ]);

        $pelanggaran = [];
        array_push($pelanggaran,$request->pelanggaran);

        for ($i=0; $i < count($pelanggaran[0]); $i++) {
          $spd_detailid = DB::table('d_surat_pringatan_dt')
            ->where('spd_surat_peringatan',$queryid + 1)
            ->MAX('spd_detailid');

            if ($spd_detailid == null) {
              $spd_detailid = 0;
            }

          DB::table('d_surat_pringatan_dt')
              ->insert([
                'spd_surat_peringatan' => $queryid + 1,
                'spd_detailid' => $spd_detailid + 1,
                'spd_pelanggaran' => $pelanggaran[0][$i]
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

    public function getsp(Request $request){
      $keyword = $request->term;

      $data = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_mitra_divisi', function($e){
              $e->on('m_id', '=', 'md_mitra');
              $e->on('mp_divisi', '=', 'md_id');
            })
            ->select('p_id','mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'p_nip_mitra', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
            ->whereRaw("mp_status = 'Aktif' AND mp_isapproved = 'Y' AND p_name LIKE '%".$keyword."%' OR p_nip_mitra LIKE '%".$keyword."%' OR p_nip LIKE '%".$keyword."%'")
            ->LIMIT(20)
            ->get();

            if ($data == null) {
                $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
            } else {

                foreach ($data as $query) {
                    $results[] = ['id' => $query->p_id, 'label' => $query->p_name . ' (' . $query->p_nip_mitra . ' ' . $query->p_nip. ')'];
                }
            }

            return response()->json($results);
    }

    public function getdata(Request $request){
      $data = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
            ->join('d_mitra_divisi', function($e){
              $e->on('m_id', '=', 'md_mitra');
              $e->on('mp_divisi', '=', 'md_id');
            })
            ->select('mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'jp_name', 'p_nip_mitra', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
            ->where('p_id', $request->id)
            ->get();

      $sp = DB::table('d_surat_pringatan')
          ->where('sp_pekerja',$request->id)
          ->get();

      if (empty($sp)) {

      } else {
        $sp[0]->sp_date_end = Carbon::Parse($sp[0]->sp_date_end)->format('d/m/Y');
      }


        return response()->json([
          'data' => $data,
          'sp' => $sp
        ]);
    
    }

    public function cari(){
      return view('surat-peringatan.cari');
    }

    public function getcari(Request $request){
      $id = $request->id;

      $surat = DB::table('d_surat_pringatan')
          ->where('sp_pekerja',$id)
          ->where('sp_isapproved','Y')
          ->get();

      if(!empty($surat[0]->sp_date_start)){
        $surat[0]->sp_date_start = Carbon::Parse($surat[0]->sp_date_start)->format('d/m/Y');
      }

      if (!empty($surat[0]->sp_date_end)) {
        $surat[0]->sp_date_end = Carbon::Parse($surat[0]->sp_date_end)->format('d/m/Y');
      }


      $pekerja = DB::table('d_mitra_pekerja')
          ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
          ->join('d_mitra', 'm_id', '=', 'mp_mitra')
          ->join('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
          ->join('d_mitra_divisi', function($e){
                $e->on('m_id', '=', 'md_mitra');
                $e->on('mp_divisi', '=', 'md_id');
          })
          ->select('mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'p_nip_mitra', 'jp_name', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
          ->where('mp_id', $id)
          ->get();

    for ($i=0; $i < count($surat); $i++) {
      $data[$i] = array(
        'sp_id' => $surat[$i]->sp_id,
        'sp_no' => $surat[$i]->sp_no,
        'p_name' => $pekerja[0]->p_name,
        'p_jabatan' => $pekerja[0]->jp_name,
        'md_name' => $pekerja[0]->md_name,
        'sp_date_start' => $surat[$i]->sp_date_start,
        'sp_date_end' => $surat[$i]->sp_date_end,
        'sp_note' => $surat[$i]->sp_note,
        'sp_isapproved' => $surat[$i]->sp_isapproved
      );
    }

    if (empty($data)) {
      return response()->json([
        'status' => 'kosong'
      ]);
    } else {
      return response()->json($data);
    }

    }

    public function detail(Request $request){
      $id = $request->id;

      $data = DB::table('d_mitra_pekerja')
          ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
          ->join('d_surat_pringatan', 'sp_pekerja', '=', 'p_id')
          ->join('d_mitra', 'm_id', '=', 'mp_mitra')
          ->join('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
          ->join('d_surat_pringatan_dt', 'spd_surat_peringatan', '=', 'sp_id')
          ->join('d_mitra_divisi', function($e){
                $e->on('m_id', '=', 'md_mitra');
                $e->on('mp_divisi', '=', 'md_id');
          })
          ->select('sp_no','p_name','md_name','sp_date_start','jp_name','sp_date_end','sp_note','sp_isapproved','sp_jenis', 'spd_pelanggaran', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
          ->where('sp_id',$id)
          ->get();

      if (empty($data[0]->sp_date_start)) {

      } else {
        $data[0]->sp_date_start = Carbon::parse($data[0]->sp_date_start)->format('d/m/Y');
      }

      if (empty($data[0]->sp_date_end)) {

      } else {
        $data[0]->sp_date_end = Carbon::parse($data[0]->sp_date_end)->format('d/m/Y');
      }


      return response()->json($data);

    }

    public function hapus(Request $request){
      DB::beginTransaction();
      try {
        DB::table('d_surat_pringatan')
            ->where('sp_id', $request->id)
            ->DELETE();

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
      $id = $request->id;

      $data = DB::table('d_mitra_pekerja')
          ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
          ->join('d_surat_pringatan', 'sp_pekerja', '=', 'p_id')
          ->join('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
          ->join('d_mitra', 'm_id', '=', 'mp_mitra')
          ->join('d_mitra_divisi', function($e){
                $e->on('m_id', '=', 'md_mitra');
                $e->on('mp_divisi', '=', 'md_id');
          })
          ->select('sp_no','p_name','md_name','sp_date_start','sp_date_end','jp_name','sp_note','sp_isapproved', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
          ->where('sp_id',$id)
          ->get();

      $data[0]->sp_date_start = Carbon::parse($data[0]->sp_date_start)->format('d/m/Y');
      $data[0]->sp_date_end = Carbon::parse($data[0]->sp_date_end)->format('d/m/Y');

      return response()->json($data);
    }

    public function update(Request $request, $id){
      DB::beginTransaction();
      try {
        $d_surat_pringatan = DB::table('d_surat_pringatan')
                           ->where('sp_id',$id)
                           ->update([
                             'sp_date_start' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
                             'sp_date_end' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
                             'sp_note' => $request->keterangan
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

    public function filter(Request $request){

      if (empty($request->start) || empty($request->end)) {
        return response()->json([
          'status' => 'kosong'
        ]);
      } else {
        $start = Carbon::createFromFormat('d/m/Y', $request->start);
        $end = Carbon::createFromFormat('d/m/Y', $request->end);
      }

      $data = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_surat_pringatan', 'sp_pekerja', '=', 'p_id')
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
            ->join('d_mitra_divisi', function($e){
              $e->on('m_id', '=', 'md_mitra');
              $e->on('mp_divisi', '=', 'md_id');
            })
            ->select('sp_no', 'sp_date_start', 'sp_date_end', 'sp_note', 'sp_id', 'jp_name', 'mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'p_nip_mitra', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
            ->where('sp_isapproved','Y')
            ->where(function($q) use ($start, $end){
              $q->orWhere('sp_date_start', '<=', $start);
              $q->orWhere('sp_date_end', '<=', $end);
            })
            ->get();

      return response()->json($data);
    }

    public function getpelanggaran(Request $request){
        $data = DB::table('d_master_sp')
              ->where('ms_id', $request->id)
              ->get();

        return response()->json($data);
    }

}
