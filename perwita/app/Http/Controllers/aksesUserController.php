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
            ->select('d_mem.*', 'd_jabatan.j_name', 'c_name')
            ->orderBy('m_name')
            ->get();

        $user = collect($user);
        return Datatables::of($user)
            ->addColumn('aksi', function ($user){
                return '<div class="">
                    <button style="margin-left:5px;" title="Akses" type="button" class="btn btn-primary btn-xs" onclick="akses(\'' . Crypt::encrypt($user->m_id) . '\')"><i class="glyphicon glyphicon-wrench"></i></button>
                  </div>';
            })
            ->make(true);
    }

    public function tambah_user()
    {
        $group = d_group::get();
        $access = d_access::get();
        return view('/system/hakuser/tambah_user', compact('access', 'group'));
    }


    public function simpanUser(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $m_id = mMember::max('m_id') + 1;
            $passwd = sha1(md5('passwordAllah') . $request->Password);
            mMember::create([
                'm_id' => $m_id,
                'm_username' => $request->Username,
                'm_passwd' => $passwd,
                'm_name' => $request->NamaLengkap,
            ]);

            $hakAkses = d_group::join('d_group_access', 'ga_group', '=', 'g_id')
                ->join('d_access', 'a_id', '=', 'ga_access')
                ->where('g_id', $request->groupAkses)->get();


            for ($i = 0; $i < count($hakAkses); $i++) {
                $ma_id = d_mem_access::max('ma_id') + 1;
                d_mem_access::create([
                    'ma_id' => $ma_id,
                    'ma_mem' => $m_id,
                    'ma_access' => $hakAkses[$i]->a_id,
                    'ma_group' => $hakAkses[$i]->g_id,
                    'ma_type' => 'G',
                    'ma_read' => $hakAkses[$i]->ga_read,
                    'ma_insert' => $hakAkses[$i]->ga_insert,
                    'ma_update' => $hakAkses[$i]->ga_update,
                    'ma_delete' => $hakAkses[$i]->ga_delete
                ]);
            }


            if ($request->groupAkses == null) {
                $hakAkses = d_access::get();

                $ma_id = d_mem_access::max('ma_id') + 1;
                d_mem_access::create([
                    'ma_id' => $ma_id,
                    'ma_mem' => $m_id,
                    'ma_access' => $hakAkses[$i]->a_id,
                    'ma_group' => 0,
                    'ma_type' => 'G'
                ]);

            }


            for ($i = 0; $i < count($request->id_access); $i++) {
                d_mem_access::create([
                    'ma_mem' => $m_id,
                    'ma_access' => $request->id_access[$i],
                    'ma_type' => 'M',
                    'ma_read' => $request->view[$i],
                    'ma_insert' => $request->insert[$i],
                    'ma_update' => $request->update[$i],
                    'ma_delete' => $request->delete[$i],
                ]);
            }

            $data = ['status' => 'sukses', 'm_id' => $m_id];
            return json_encode($data);
        });
    }

    public function editUserAkses($id)
    {
        $id = Crypt::decrypt($id);
        return view('system/hakuser/akses');
    }

    public function perbaruiUser($m_id, Request $request)
    {
        return DB::transaction(function () use ($m_id, $request) {

            $mMember = mMember::where('m_id', $m_id);
            $mMember->update([
                'm_username' => $request->Username,
                'm_name' => $request->NamaLengkap,
            ]);

            $mem_access = d_mem_access::where('ma_mem', $m_id)
                ->where('ma_type', '=', DB::raw("'G'"));

            $hakAkses = d_group::join('d_group_access', 'ga_group', '=', 'g_id')
                ->join('d_access', 'a_id', '=', 'ga_access')
                ->where('g_id', $request->groupAkses)->get();


            if ($mem_access->first()) {
                if ($mem_access->first()->ma_group != $request->groupAkses) {
                    $mem_access = d_mem_access::where('ma_mem', $m_id)
                        ->where('ma_type', '=', DB::raw("'G'"));
                    $mem_access->delete();
                    if ($request->groupAkses != '') {


                        for ($i = 0; $i < count($hakAkses); $i++) {
                            $ma_id = d_mem_access::max('ma_id') + 1;
                            d_mem_access::create([
                                'ma_id' => $ma_id,
                                'ma_mem' => $m_id,
                                'ma_access' => $hakAkses[$i]->a_id,
                                'ma_group' => $hakAkses[$i]->g_id,
                                'ma_type' => 'G',
                                'ma_read' => $hakAkses[$i]->ga_read,
                                'ma_insert' => $hakAkses[$i]->ga_insert,
                                'ma_update' => $hakAkses[$i]->ga_update,
                                'ma_delete' => $hakAkses[$i]->ga_delete
                            ]);
                        }

                    } elseif ($request->groupAkses == null) {
                        $hakAkses = d_access::get();
                        for ($i = 0; $i < count($hakAkses); $i++) {
                            $ma_id = d_mem_access::max('ma_id') + 1;
                            d_mem_access::create([
                                'ma_id' => $ma_id,
                                'ma_mem' => $m_id,
                                'ma_access' => $hakAkses[$i]->a_id,
                                'ma_group' => 0,
                                'ma_type' => 'G'
                            ]);

                        }
                    }

                }

            } else {

                for ($i = 0; $i < count($hakAkses); $i++) {
                    $ma_id = d_mem_access::max('ma_id') + 1;
                    d_mem_access::create([
                        'ma_id' => $ma_id,
                        'ma_mem' => $m_id,
                        'ma_access' => $hakAkses[$i]->a_id,
                        'ma_group' => $hakAkses[$i]->g_id,
                        'ma_type' => 'G',
                        'ma_read' => $hakAkses[$i]->ga_read,
                        'ma_insert' => $hakAkses[$i]->ga_insert,
                        'ma_update' => $hakAkses[$i]->ga_update,
                        'ma_delete' => $hakAkses[$i]->ga_delete
                    ]);
                }

            }


            for ($i = 0; $i < count($request->id_access); $i++) {
                $mem_access = d_mem_access::where('ma_mem', $m_id)
                    ->where('ma_access', $request->id_access[$i])
                    ->where('ma_type', '=', DB::raw("'M'"));
                if ($mem_access->first()) {
                    $mem_access->update([
                        'ma_read' => $request->view[$i],
                        'ma_insert' => $request->insert[$i],
                        'ma_update' => $request->update[$i],
                        'ma_delete' => $request->delete[$i]
                    ]);

                } else {
                    d_mem_access::create([
                        'ma_mem' => $m_id,
                        'ma_access' => $request->id_access[$i],
                        'ma_type' => 'M',
                        'ma_read' => $request->view[$i],
                        'ma_insert' => $request->insert[$i],
                        'ma_update' => $request->update[$i],
                        'ma_delete' => $request->delete[$i],
                    ]);

                }

            }

            $data = ['status' => 'sukses'];
            return json_encode($data);
        });
    }

}


    

