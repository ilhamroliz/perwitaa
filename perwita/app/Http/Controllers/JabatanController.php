<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\AksesUser;

class JabatanController extends Controller
{
    public function index()
    {
      if (!AksesUser::checkAkses(45, 'read')) {
          return redirect('not-authorized');
      }

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
                    return '<div class="text-center">
                                <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" disabled><i class="glyphicon glyphicon-edit"></i></button>
                                <button style="margin-left:5px;" title="Hapus" type="button" class="btn btn-danger btn-xs" disabled><i class="glyphicon glyphicon-trash"></i></button>
                            </div>';
                } else {
                    return '<div class="text-center">
                                <button style="margin-left:5px;" data-toggle="modal" data-target="#myModal" title="Edit" onclick="edit('. $data->j_id .', \''. $data->j_name .'\')" type="button" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></button>
                                <button style="margin-left:5px;" title="Hapus" type="button" class="btn btn-danger btn-xs" onclick="hapus('. $data->j_id .')" ><i class="glyphicon glyphicon-trash"></i></button>
                            </div>';
                }
            })
            ->addColumn('aksi', function ($data){
                if ($data->j_isactive == 'Y'){
                    return '<div class="text-center"><div class="checkbox checkbox-primary checkbox-single checkbox-inline">
                                    <input type="checkbox" name="pilih[]" value="' . $data->j_id . '" checked>
                                    <label class="">  </label>
                                </div></div>';
                } else {
                    return '<div class="text-center"><div class="checkbox checkbox-primary checkbox-single checkbox-inline">
                                    <input type="checkbox" name="pilih[]" value="' . $data->j_id . '">
                                    <label class="">  </label>
                                </div></div>';
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

    public function update(Request $request)
    {
      if (!AksesUser::checkAkses(45, 'update')) {
          return redirect('not-authorized');
      }
        $pilih = $request->pilih;
        DB::table('d_jabatan')
            ->whereIn('j_id', $pilih)
            ->update([
                'j_isactive' => 'Y'
            ]);

        DB::table('d_jabatan')
            ->whereNotIn('j_id', $pilih)
            ->update([
                'j_isactive' => 'N'
            ]);

        return response()->json([
            'status' => 'sukses'
        ]);
    }

    public function simpan(Request $request)
    {
      if (!AksesUser::checkAkses(45, 'insert')) {
          return redirect('not-authorized');
      }
        $nama = $request->namatambah;
        $id = DB::table('d_jabatan')
            ->max('j_id');
        ++$id;

        DB::table('d_jabatan')
            ->insert([
                'j_id' => $id,
                'j_name' => $nama,
                'j_editable' => 'Y',
                'j_isactive' => 'N'
            ]);

        return response()->json([
            'status' => 'sukses'
        ]);
    }

    public function hapus(Request $request)
    {
      if (!AksesUser::checkAkses(45, 'delete')) {
          return redirect('not-authorized');
      }
        $id = $request->id;
        DB::table('d_jabatan')
            ->where('j_id', '=', $id)
            ->delete();

        return response()->json([
            'status' => 'sukses'
        ]);
    }
}
