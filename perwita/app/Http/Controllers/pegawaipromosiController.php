<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class pegawaipromosiController extends Controller
{
    public function index(){

      $jabatan = DB::table('d_jabatan_pelamar')
          ->get();

      return view('pegawaipromosi.index', compact('jabatan'));

    }
}
