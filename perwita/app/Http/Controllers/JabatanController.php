<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Yajra\Datatables\Datatables;

class JabatanController extends Controller
{
    public function index()
    {
        $data = DB::table('d_jabatan')
            ->get();
        return view('master-jabatan.index', compact('data'));
    }

    public function data()
    {
        $jabatan = DB::table('d_jabatan')
            ->where('j_isactive', '=', 'Y')
            ->get();
        $data = collect($jabatan);
        return Datatables::of($data)->make(true);
    }

    public function table()
    {
        $jabatan = DB::table('d_jabatan')
            ->get();
        $data = collect($jabatan);
        return Datatables::of($data)
            ->addColumn('edit', function ($data){
                if ($data->j_editable == 'N'){
                    return '<button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" disabled><i class="glyphicon glyphicon-edit"></i></button>';
                } else {
                    return '<button style="margin-left:5px;" data-toggle="modal" data-target="#myModal" title="Edit" onclick="edit('. $data->j_id .', \''. $data->j_name .'\')" type="button" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></button>';
                }
            })
            ->addColumn('aksi', function ($data){
                //return '<input class="form-control" type="checkbox" name="pilih[]" value="' . $data->j_id . '">';
                if ($data->j_isactive == 'Y'){
                    return '<div class="checkbox checkbox-primary checkbox-single checkbox-inline">
                                    <input type="checkbox" name="pilih[]" value="' . $data->j_id . '" checked>
                                    <label class="">  </label>
                                </div>';
                } else {
                    return '<div class="checkbox checkbox-primary checkbox-single checkbox-inline">
                                    <input type="checkbox" name="pilih[]" value="' . $data->j_id . '">
                                    <label class="">  </label>
                                </div>';
                }
            })
            ->make(true);
    }

    public function rename(Request $request)
    {
        $id = $request->idjabatan;
        $nama = $request->namajabatan;
        DB::table('d_jabatan')
            ->where('j_id', '=', $id)
            ->update([
                'j_name' => $nama
            ]);
        return response()->json([
            'status' => 'sukses'
        ]);
    }
}
