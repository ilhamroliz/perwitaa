<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\d_mem;

use App\d_access;
use Illuminate\Support\Facades\Crypt;

class manajemenPenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $member = DB::table('d_mem')
            ->join('d_jabatan', 'm_jabatan', '=', 'j_id')
            ->leftJoin('d_mem_comp', 'mc_mem', '=', 'm_id')
            ->leftJoin('d_comp', 'c_id', '=', 'mc_comp')
            ->select('d_mem.*', 'd_jabatan.j_name', 'c_name')
            ->orderBy('m_name')
            ->get();

        return view('manajemen-pengguna.index', compact('member'));
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $member = d_mem::where('m_id', $id)->first();
        $acces = d_access::select('a_id', 'a_type')->get();
        return view('manajemen-pengguna.edit', compact('acces', 'member'));
    }

    public function add()
    {
        $jabatan = DB::table('d_jabatan')
            ->get();
        $comp = DB::table('d_comp')
            ->select('c_id', 'c_name')
            ->get();
        return view('manajemen-pengguna.create', compact('jabatan', 'comp'));
    }
}
