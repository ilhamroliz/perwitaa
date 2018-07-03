<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Yajra\Datatables\Datatables;

class MouController extends Controller
{
    public function index()
    {
        return view ('mou-mitra.index');
    }

    public function table(Request $request)
    {
        $data = DB::table('d_mitra')
            ->leftJoin('d_mitra_mou', 'mm_mitra', '=', 'm_id')
            ->select('m_id', 'm_name', 'm_note', 'mm_detailid', 'mm_mou', DB::raw('DATE_FORMAT(mm_mou_start, "%d/%m/%Y") as mm_mou_start'), DB::raw('DATE_FORMAT(mm_mou_end, "%d/%m/%Y") as mm_mou_end'))
            ->where('mm_status', '=', 'Aktif')
            ->get();

        $mou = collect($data);
        return Datatables::of($mou)
            ->addColumn('sisa', function ($mou) {
                Carbon::setLocale('id');
                $akhir = Carbon::createFromFormat('d/m/Y', $mou->mm_mou_end)->diffForHumans(null, true);
                return $akhir;
            })
            ->addColumn('action', function ($mou) {
                return '<div class="text-center">
                    <button style="margin-left:5px;" title="Perpanjang" data-toggle="modal" data-target="#myModal" type="button" class="btn btn-info btn-xs" onclick="perpanjang(' . $mou->m_id . ')"><i class="glyphicon glyphicon-export"></i></button>
                    <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="data-mitra/' . $mou->m_id . '/edit"><i class="glyphicon glyphicon-edit"></i></a>
                    <button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Non Aktif" onclick="hapus(' . $mou->m_id . ')"><i class="glyphicon glyphicon-remove"></i></button>
                  </div>';
            })
            ->make(true);
    }
}
