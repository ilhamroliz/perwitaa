<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

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
    }
}
