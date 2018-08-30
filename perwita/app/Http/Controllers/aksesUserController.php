<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\d_access;

use App\d_group;

use App\d_mem_access;

use App\mMember;

use Auth;

use DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\Datatables\Datatables;

class aksesUserController extends Controller
{
    public function indexAksesUser()
    {
        return view('/system/hakuser/user', compact('mem'));
    }

    public function dataUser()
    {
        $user = DB::table('d_mem')
            ->join('d_jabatan', 'm_jabatan', '=', 'j_id')
            ->leftJoin('d_mem_comp', 'mc_mem', '=', 'm_id')
            ->leftJoin('d_comp', 'c_id', '=', 'mc_comp')
            ->select('d_mem.*', 'd_jabatan.j_name', 'c_name', 'j_id')
            ->orderBy('m_name')
            ->get();

        $user = collect($user);
        return Datatables::of($user)
            ->addColumn('aksi', function ($user){
                if ($user->j_id == 1 || $user->j_id == 2){
                    return '<div class="">
                        <button style="margin-left:5px;" title="Akses" type="button" class="btn btn-primary btn-xs" onclick="akses(\'' . Crypt::encrypt($user->m_id) . '\')" disabled><i class="glyphicon glyphicon-wrench"></i></button>
                     </div>';
                } else {
                    return '<div class="">
                        <button style="margin-left:5px;" title="Akses" type="button" class="btn btn-primary btn-xs" onclick="akses(\'' . Crypt::encrypt($user->m_id) . '\')"><i class="glyphicon glyphicon-wrench"></i></button>
                     </div>';
                }
            })
            ->make(true);
    }

    public function editUserAkses($id)
    {
        $id = Crypt::decrypt($id);
        $user = DB::table('d_mem')
            ->join('d_jabatan', 'j_id', '=', 'm_jabatan')
            ->join('d_mem_comp', 'mc_mem', '=', 'm_id')
            ->join('d_comp', 'c_id', '=', 'mc_comp')
            ->select('d_mem.*', 'j_id', 'j_name', 'd_comp.*', DB::raw('DATE_FORMAT(m_lastlogin, "%d/%m/%Y %h:%i") as m_lastlogin'), DB::raw('DATE_FORMAT(m_lastlogout, "%d/%m/%Y %h:%i") as m_lastlogout'))
            ->where('m_id', '=', $id)
            ->first();

        $akses = DB::table('d_access')
            ->join('d_mem_access', 'a_id', '=', 'ma_access')
            ->where('ma_mem', '=', $id)
            ->get();

        $id = Crypt::encrypt($id);

        return view('system/hakuser/akses', compact('akses', 'user', 'id'));
    }

    public function save(Request $request)
    {
        //dd($request);
        DB::beginTransaction();
        try {
            $read = $request->read;
            $insert = $request->insert;
            $update = $request->update;
            $delete = $request->delete;
            $id = Crypt::decrypt($request->id);

            $akses = DB::table('d_access')
                ->select('a_id')
                ->get();

            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $id)
                ->get();

            if (count($cek) > 0){
                //== update data
                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->update([
                        'ma_read' => 'N',
                        'ma_insert' => 'N',
                        'ma_update' => 'N',
                        'ma_delete' => 'N'
                    ]);

                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->whereIn('ma_access', $read)
                    ->update([
                        'ma_read' => 'Y'
                    ]);

                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->whereIn('ma_access', $insert)
                    ->update([
                        'ma_insert' => 'Y'
                    ]);

                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->whereIn('ma_access', $update)
                    ->update([
                        'ma_update' => 'Y'
                    ]);

                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->whereIn('ma_access', $delete)
                    ->update([
                        'ma_delete' => 'Y'
                    ]);
            } else {
                //== create data
                $addAkses = [];
                for ($i = 0; $i < count($akses); $i++){
                    $temp = [
                        'ma_mem' => $id,
                        'ma_access' => $akses[$i]->a_id
                    ];
                    array_push($addAkses, $temp);
                }
                DB::table('d_mem_access')->insert($addAkses);

                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->whereIn('ma_access', $read)
                    ->update([
                        'ma_read' => 'Y'
                    ]);

                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->whereIn('ma_access', $insert)
                    ->update([
                        'ma_insert' => 'Y'
                    ]);

                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->whereIn('ma_access', $update)
                    ->update([
                        'ma_update' => 'Y'
                    ]);

                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->whereIn('ma_access', $delete)
                    ->update([
                        'ma_delete' => 'Y'
                    ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

}