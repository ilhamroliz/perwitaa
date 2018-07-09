<?php

namespace App\Http\Controllers;

use App\d_purchase;
use App\d_purchase_dt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Response;

class approvalpembelianController extends Controller
{
    public function index(){
      $data = DB::table('d_purchase')
          ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
          ->join('d_supplier', 's_id', '=', 'p_supplier')
          ->select('*')
          ->where('pd_receivetime', null)
          ->where('p_isapproved', 'P')
          ->groupBy('p_nota')
          ->get();

      return view('approvalpembelian.index', compact('data'));
    }

    public function setujui(Request $request){
      $id = $request->id;
      try {
        d_purchase::where('p_id',$id)
                  ->update([
                    'p_isapproved' => 'Y'
                  ]);
        return response()->json([
            'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        return response()->json([
            'status' => 'gagal'
        ]);
      }


    }

    public function tolak(Request $request){
      $id = $request->id;
      try {
        d_purchase::where('p_id',$id)
                  ->update([
                    'p_isapproved' => 'N'
                  ]);
        return response()->json([
            'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        return response()->json([
            'status' => 'gagal'
        ]);
      }


    }

}
