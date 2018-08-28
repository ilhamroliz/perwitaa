<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class JabatanController extends Controller
{
    public function index()
    {
        $data = DB::table('d_jabatan')
            ->get();
        return view('master-jabatan.index', compact('data'));
    }
}
