<?php

namespace App\Http\Controllers;

use App\d_pekerja;
use App\d_pekerja_mutation;
use App\d_promosi_demosi;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;

class promosiController extends Controller
{
    public function index()
    {
        $jabatan = DB::table('d_jabatan_pelamar')
            ->get();

        return view('promosi.index', compact('jabatan'));
    }

    public function getData()
    {
        $pekerja = DB::table('d_pekerja')
            ->leftJoin('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan_lamaran')
            ->leftJoin('d_mitra_pekerja', function ($e){
                $e->on('mp_pekerja', '=', 'p_id');
            })
            ->leftJoin('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra');
                $q->on('md_id', '=', 'mp_divisi');
                $q->on('md_mitra', '=', 'm_id');
            })
            ->select('p_id', 'p_name', 'jp_name', 'p_nip', 'p_nip_mitra', 'd_mitra.m_name', 'd_mitra_divisi.md_name')
            ->where('p_note', '!=', 'Calon')
            ->where('p_note', '!=', 'Ex')
            ->where('mp_status', '=', 'Aktif')
            ->groupBy('p_id')
            ->get();

        $pekerja = collect($pekerja);

        return Datatables::of($pekerja)
            ->addColumn('action', function ($pekerja) {
                return '<div class="text-center">
                    <button style="margin-left:5px;" title="Demosi" type="button" class="btn btn-warning btn-xs" onclick="demosi(' . $pekerja->p_id . ')"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>
                    <button style="margin-left:5px;" type="button" class="btn btn-primary btn-xs" title="Promosi" onclick="promosi(' . $pekerja->p_id . ')"><i class="glyphicon glyphicon-circle-arrow-up"></i></button>
                  </div>';
            })
            ->make(true);
    }

    public function getdetail(Request $request)
    {
        $id = $request->id;
        $pekerja = DB::table('d_pekerja')
            ->leftJoin('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan_lamaran')
            ->leftJoin('d_mitra_pekerja', function ($e){
                $e->on('mp_pekerja', '=', 'p_id');
            })
            ->leftJoin('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q){
                $q->on('md_mitra', '=', 'mp_mitra');
                $q->on('md_id', '=', 'mp_divisi');
                $q->on('md_mitra', '=', 'm_id');
            })
            ->select('p_id', 'p_name', 'jp_name', 'p_nip', 'p_nip_mitra', 'd_mitra.m_name', 'd_mitra_divisi.md_name')
            ->where('p_note', '!=', 'Calon')
            ->where('p_note', '!=', 'Ex')
            ->where('mp_status', '=', 'Aktif')
            ->where('p_id', '=', $id)
            ->groupBy('p_id')
            ->get();

        return response()->json([
            'data' => $pekerja
        ]);
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try{
            $note = $request->note;
            $jabatan = $request->jabatan;
            $jenis = $request->jenis;
            $sekarang = Carbon::now('Asia/Jakarta');
            $pekerja = $request->pekerja;

            //00001/PMS/PN/bulan/2018
            $jabatanAwal = DB::table('d_pekerja')
                ->select('p_jabatan', 'p_jabatan_lamaran')
                ->where('p_id', '=', $pekerja)
                ->get();

            if ($jabatanAwal[0]->p_jabatan == null || $jabatanAwal->p_jabatan == ''){
                $jabatanAwal = $jabatanAwal[0]->p_jabatan_lamaran;
            } else {
                $jabatanAwal = $jabatanAwal[0]->p_jabatan;
            }

            $id = DB::table('d_promosi_demosi')
                ->max('pd_id');

            $tempKode = '';
            if ($jenis == 'Promosi'){
                $cek = DB::table('d_promosi_demosi')
                    ->select(DB::raw('coalesce(max(left(pd_no, 5)) + 1, "00001") as counter'))
                    ->where(DB::raw('mid(pd_no, 7,3)'), '=', 'PMS')
                    ->where(DB::raw('mid(pd_no, 14,2)'), '=', $sekarang->format("m"))
                    ->where(DB::raw('right(pd_no, 4)'), '=', $sekarang->year)
                    ->get();

                foreach ($cek as $x) {
                    $temp = ((int)$x->counter);
                    $kode = sprintf("%05s",$temp);
                }
                $tempKode = $kode . '/' . 'PMS/PN/' . $sekarang->format("m") . '/' . $sekarang->year;

            } elseif ($jenis == 'Demosi'){
                $cek = DB::table('d_promosi_demosi')
                    ->select(DB::raw('coalesce(max(left(pd_no, 5)) + 1, "00001") as counter'))
                    ->where(DB::raw('mid(pd_no, 7,3)'), '=', 'DMS')
                    ->where(DB::raw('mid(pd_no, 14,2)'), '=', $sekarang->format("m"))
                    ->where(DB::raw('right(pd_no, 4)'), '=', $sekarang->year)
                    ->get();

                foreach ($cek as $x) {
                    $temp = ((int)$x->counter);
                    $kode = sprintf("%05s",$temp);
                }
                $tempKode = $kode . '/' . 'DMS/PN/' . $sekarang->format("m") . '/' . $sekarang->year;
            }

            d_promosi_demosi::insert(array(
                'pd_id' => $id + 1,
                'pd_no' => $tempKode,
                'pd_pekerja' => $pekerja,
                'pd_jabatan_awal' => $jabatanAwal,
                'pd_jabatan_sekarang' => $jabatan,
                'pd_note' => $note,
                'pd_isapproved' => 'P',
                'pd_insert' => $sekarang
            ));

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);

        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function approvePromosi($nomor)
    {
        DB::beginTransaction();
        try{
            $data = DB::table('d_promosi_demosi')
                ->where('pd_no', '=', $nomor)
                ->get();

            $pekerja = $data[0]->pd_pekerja;
            $sekarang = Carbon::now('Asia/Jakarta');

            $detailid = DB::table('d_pekerja_mutation')
                ->select(DB::raw('max(pm_detailid) as detailid'), 'pm_status')
                ->where('pm_pekerja', '=', $pekerja)
                ->get();

            $info = DB::table('d_mitra_pekerja')
                ->select(DB::raw('coalesce(mp_mitra, null) as mitra'), DB::raw('coalesce(mp_divisi, null) as divisi'))
                ->where('mp_status', '=', 'Aktif')
                ->where('mp_pekerja', '=', $pekerja)
                ->get();

            d_pekerja_mutation::insert(array(
                'pm_pekerja' => $pekerja,
                'pm_detailid' => $detailid[0]->detailid + 1,
                'pm_date' => $sekarang,
                'pm_mitra' => $info[0]->mitra,
                'pm_divisi' => $info[0]->divisi,
                'pm_detail' => 'Promosi',
                'pm_status' => $detailid[0]->pm_status,
                'pm_note' => $data->pd_note,
                'pm_insert_by' => Session::get('mem')
            ));

            d_pekerja::where('p_id', '=', $pekerja)
                ->update([
                    'p_jabatan' => $jabatan
                ]);
            DB::commit();
            return 'sukses';
        } catch (\Exception $e){
            DB::rollback();
            return 'gagal';
        }
    }

}
