<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

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
            ->select('m_id', 'm_name', 'm_note', 'mm_detailid', 'mm_mou', 'mm_mou_start', 'mm_mou_end')
            ->get();

        $mou = collect($data);
        return Datatables::of($mou)
            ->editColumn('mm_mou_start', function ($mou) {
                return Carbon::now();
            })

            ->addColumn('action', function ($pekerja) {
                return '<div class="text-center">
                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail(' . $pekerja->p_id . ')"><i class="glyphicon glyphicon-folder-open"></i></button>
                    <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="data-pekerja/' . $pekerja->p_id . '/edit"><i class="glyphicon glyphicon-edit"></i></a>
                    <button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus(' . $pekerja->p_id . ')"><i class="glyphicon glyphicon-trash"></i></button>
                  </div>';
            })
            ->make(true);
    }
}
