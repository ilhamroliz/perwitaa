<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class approvalremunerasiController extends Controller
{
    public function index(){
      $data = DB::table('d_remunerasi')
          ->join('d_pekerja', 'p_id', '=', 'r_pekerja')
          ->leftjoin('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
          ->select('r_no', 'p_name', 'jp_name', 'r_nilai', 'r_note', 'r_id')
          ->where('r_isapproved', 'P')
          ->get();

      return view('approvalremunerasi.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {
        DB::table('d_remunerasi')
          ->where('r_id',$request->id)
          ->update([
            'r_isapproved' => 'Y'
          ]);
        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }

    }

    public function tolak(Request $request){
      DB::beginTransaction();
      try {
        DB::table('d_remunerasi')
          ->where('r_id',$request->id)
          ->update([
            'r_isapproved' => 'N'
          ]);
        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }

    public function setujuilist(Request $request){
      DB::beginTransaction();
      try {
        DB::table('d_remunerasi')
          ->whereIn('r_id', $request->pilih)
          ->update(['r_isapproved' => 'Y']);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }

    }

    public function tolaklist(Request $request){
      DB::beginTransaction();
      try {
        DB::table('d_remunerasi')
          ->whereIn('r_id', $request->pilih)
          ->update(['r_isapproved' => 'N']);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }

    }
}
