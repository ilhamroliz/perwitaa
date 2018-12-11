<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\AksesUser;

class PerusahaanController extends Controller
{
    public function index()
    {
      if (!AksesUser::checkAkses(46, 'read')) {
          return redirect('not-authorized');
      }
        $data = DB::table('d_jabatan')
            ->get();
        return view('master-perusahaan.index', compact('data'));
    }

    public function data()
    {
        $comp = DB::table('d_comp')
            ->where('c_isactive', '=', 'Y')
            ->get();
        $data = collect($comp);
        return Datatables::of($data)->make(true);
    }

    public function table()
    {
        $comp = DB::table('d_comp')
            ->orderBy('c_editable', 'dsc')
            ->get();

        $data = collect($comp);
        return Datatables::of($data)
            ->addColumn('edit', function ($data){
                if ($data->c_editable == 'N'){
                    return '<div class="text-center">
                                <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" disabled><i class="glyphicon glyphicon-edit"></i></button>
                                <button style="margin-left:5px;" title="Hapus" type="button" class="btn btn-danger btn-xs" disabled><i class="glyphicon glyphicon-trash"></i></button>
                            </div>';
                } else {
                    return '<div class="text-center">
                                <button style="margin-left:5px;" data-toggle="modal" data-target="#myModal" title="Edit" onclick="edit(\''. Crypt::encrypt($data->c_id) .'\', \''. $data->c_name .'\')" type="button" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></button>
                                <button style="margin-left:5px;" title="Hapus" type="button" class="btn btn-danger btn-xs" onclick="hapus(\''. Crypt::encrypt($data->c_id) .'\')" ><i class="glyphicon glyphicon-trash"></i></button>
                            </div>';
                }
            })
            ->addColumn('aksi', function ($data){
                if ($data->c_isactive == 'Y'){
                    return '<div class="text-center"><div class="checkbox checkbox-primary checkbox-single checkbox-inline">
                                    <input type="checkbox" name="pilih[]" value="' . Crypt::encrypt($data->c_id) . '" checked>
                                    <label class="">  </label>
                                </div></div>';
                } else {
                    return '<div class="text-center"><div class="checkbox checkbox-primary checkbox-single checkbox-inline">
                                    <input type="checkbox" name="pilih[]" value="' . Crypt::encrypt($data->c_id) . '">
                                    <label class="">  </label>
                                </div></div>';
                }
            })
            ->make(true);
    }

    public function add()
    {
      if (!AksesUser::checkAkses(46, 'insert')) {
          return redirect('not-authorized');
      }
        $mitra = DB::table('d_mitra')->select('m_id', 'm_name')->get();
        $mem = DB::table('d_mem')->select('m_id', 'm_name')->get();
        return view('master-perusahaan/add', compact('mem', 'mitra'));
    }

    public function save(Request $request)
    {
      if (!AksesUser::checkAkses(46, 'insert')) {
          return redirect('not-authorized');
      }
        $comp = $request->comp;
        $owner = $request->owner;
        $alamat = $request->alamat;

        DB::beginTransaction();
        try{
            $kode = "";
            $querykode = DB::select("SELECT coalesce(max(right(c_id, 7)), '0000000') as id from d_comp where left(c_id, 3) = 'MTR'");
            foreach($querykode as $k)
            {
                $tmp = ((int)$k->id)+1;
                $kode = sprintf("%07s", $tmp);
            }

            $sekarang = Carbon::now('Asia/Jakarta');
            $c_name = DB::table('d_mitra')
                ->select('m_name')
                ->where('m_id', '=', $comp)
                ->first();

            $kode = 'MTR' . $kode;
            DB::table('d_comp')
                ->insert([
                    'c_id' => $kode,
                    'c_owner' => $owner,
                    'c_name' => $c_name->m_name,
                    'c_address' => $alamat,
                    'c_type' => 11,
                    'c_insert' => $sekarang,
                    'c_isactive' => 'Y',
                    'c_editable' => 'Y'
                ]);

            DB::table('d_mitra_comp')
                ->insert([
                    'mc_mitra' => $comp,
                    'mc_comp' => $kode
                ]);

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function update(Request $request)
    {
      if (!AksesUser::checkAkses(46, 'update')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try{
            $pilih = $request->pilih;
            for ($i = 0; $i < count($pilih); $i++){
                $pilih[$i] = Crypt::decrypt($pilih[$i]);
            }
            DB::table('d_comp')
                ->whereIn('c_id', $pilih)
                ->update([
                    'c_isactive' => 'Y'
                ]);
            DB::table('d_comp')
                ->whereNotIn('c_id', $pilih)
                ->update([
                    'c_isactive' => 'N'
                ]);
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function delete(Request $request)
    {
      if (!AksesUser::checkAkses(46, 'delete')) {
          return redirect('not-authorized');
      }
        $id = Crypt::decrypt($request->id);
        DB::beginTransaction();
        try{
            DB::table('d_comp')
                ->where('c_id', '=', $id)
                ->delete();
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }
}
