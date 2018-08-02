<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class approvalpenjualanController extends Controller
{
    public function index(){
      $data = DB::table('d_sales')
            ->join('d_mitra', 'm_id', '=', 's_member')
            ->select('s_id', 's_date', 'm_name', 's_nota', 's_total_net')
            ->where('s_isapproved', 'P')
            ->get();

      return view('approvalpenjualan.index', compact('data'));
    }
}
