<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class penggajianController extends Controller
{
    public function index(){
      $data = DB::table('d_mitra')
              ->join('d_mitra_divisi', 'md_mitra', '=', 'm_id')
              ->groupBy('m_name')
              ->get();

      return view('penggajian.index', compact('data'));
    }
}
