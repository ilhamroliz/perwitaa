<?php

namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
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

            //00001/PMS/PN/bulan/2018
            $id = DB::table('d_promosi_demosi')
                ->max('pd_id');

            if ($jenis == 'Promosi'){
                $cek = DB::table('d_promosi_demosi')
                    ->select(DB::raw('coalesce(max(left(pd_no, 5)) + 1, "00001") as counter'))
                    ->where(DB::raw('mid(pd_no, 4)'), '=', $tahun)

            } elseif ($jenis == 'Demosi'){

            }

        } catch (\Exception $e){

        }
    }

}
