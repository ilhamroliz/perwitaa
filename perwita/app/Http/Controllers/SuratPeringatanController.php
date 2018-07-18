<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

class SuratPeringatanController extends Controller
{
    public function index()
    {
        return view('surat-peringatan.index');
    }

    public function simpan(Request $request, $id){
      DB::beginTransaction();
      try {
        $kode = "";

        $queryid = DB::table('d_surat_pringatan')
            ->MAX('sp_id');

        $querykode = DB::select(DB::raw("SELECT MAX(RIGHT(sp_no,5)) as counter, MAX(MID(sp_no,8,2)) as bulan, MAX(MID(sp_no,11,4)) as tahun FROM d_surat_pringatan"));

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

        $finalkode = 'SP/MJI/' . date('m') . '/' . date('Y') . '/' . $kode;

        DB::table('d_surat_pringatan')
            ->insert([
              'sp_id' => $queryid + 1,
              'sp_no' => $finalkode,
              'sp_pekerja' => $id,
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

    public function getsp(Request $request){
      $keyword = $request->term;

      $data = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_mitra_divisi', function($e){
              $e->on('m_id', '=', 'md_mitra');
              $e->on('mp_divisi', '=', 'md_id');
            })
            ->select('mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'p_nip_mitra', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
            ->where('p_name', 'LIKE', '%'.$keyword.'%')
            ->ORwhere('p_nip_mitra', 'LIKE', '%'.$keyword.'%')
            ->ORwhere('p_nip', 'LIKE', '%'.$keyword.'%')
            ->LIMIT(20)
            ->get();

            if ($data == null) {
                $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
            } else {

                foreach ($data as $query) {
                    $results[] = ['id' => $query->mp_id, 'label' => $query->p_name . ' (' . $query->p_nip_mitra . ' ' . $query->p_nip. ')'];
                }
            }

            return response()->json($results);
    }

    public function getdata(Request $request){
      $data = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_mitra_divisi', function($e){
              $e->on('m_id', '=', 'md_mitra');
              $e->on('mp_divisi', '=', 'md_id');
            })
            ->select('mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'p_nip_mitra', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
            ->where('mp_id', $request->id)
            ->get();

      return response()->json($data);
    }

    public function cari(){
      return view('surat-peringatan.cari');
    }

    public function getcari(Request $request){
      $id = $request->id;

      $surat = DB::table('d_surat_pringatan')
          ->where('sp_pekerja',$id)
          ->get();

      $surat[0]->sp_date_start = Carbon::Parse($surat[0]->sp_date_start)->format('d/m/Y');
      $surat[0]->sp_date_end = Carbon::Parse($surat[0]->sp_date_end)->format('d/m/Y');

      $pekerja = DB::table('d_mitra_pekerja')
          ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
          ->join('d_mitra', 'm_id', '=', 'mp_mitra')
          ->join('d_mitra_divisi', function($e){
                $e->on('m_id', '=', 'md_mitra');
                $e->on('mp_divisi', '=', 'md_id');
          })
          ->select('mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'p_nip_mitra', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
          ->where('mp_id', $id)
          ->get();

    for ($i=0; $i < count($surat); $i++) {
      $data[$i] = array(
        'sp_id' => $surat[$i]->sp_id,
        'sp_no' => $surat[$i]->sp_no,
        'p_name' => $pekerja[0]->p_name,
        'p_jabatan' => $pekerja[0]->p_jabatan,
        'md_name' => $pekerja[0]->md_name,
        'sp_date_start' => $surat[$i]->sp_date_start,
        'sp_date_end' => $surat[$i]->sp_date_end,
        'sp_note' => $surat[$i]->sp_note,
        'sp_isapproved' => $surat[$i]->sp_isapproved
      );
    }

      return response()->json($data);
    }

    public function detail(Request $request){
      $id = $request->id;

      $data = DB::table('d_mitra_pekerja')
          ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
          ->join('d_surat_pringatan', 'sp_pekerja', '=', 'p_id')
          ->join('d_mitra', 'm_id', '=', 'mp_mitra')
          ->join('d_mitra_divisi', function($e){
                $e->on('m_id', '=', 'md_mitra');
                $e->on('mp_divisi', '=', 'md_id');
          })
          ->select('sp_no','p_name','md_name','sp_date_start','sp_date_end','sp_note','sp_isapproved', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
          ->where('sp_id',$id)
          ->get();

      $data[0]->sp_date_start = Carbon::parse($data[0]->sp_date_start)->format('d/m/Y');
      $data[0]->sp_date_end = Carbon::parse($data[0]->sp_date_end)->format('d/m/Y');


      return response()->json($data);

    }
}
