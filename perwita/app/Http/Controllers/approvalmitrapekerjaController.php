<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\d_mitra_pekerja;

use App\d_mitra_contract;

use Carbon\Carbon;

class approvalmitrapekerjaController extends Controller
{
    public function index(){
      Carbon::setLocale('id');

      $data = DB::table('d_mitra_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_mitra_divisi', function($e){
              $e->on('md_id', '=', 'mp_divisi')
                ->on('md_mitra', '=', 'm_id');
            })
            ->select('m_name', 'md_name', 'mp_insert', 'mp_mitra', 'mp_divisi', 'mp_contract')
            ->where('mp_isapproved','P')
            ->groupBy('m_id')
            ->get();

      for ($i=0; $i < count($data); $i++) {
          $data[$i]->mp_insert = Carbon::parse($data[$i]->mp_insert)->diffForHumans();
      }

      return view('approvalmitrapekerja.index', compact('data'));
    }

    public function daftarpekerja($mitra, $divisi){
      $data = DB::table('d_mitra_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_mitra_divisi', function($e){
              $e->on('md_id', '=', 'mp_divisi')
                ->on('md_mitra', '=', 'm_id');
            })
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->select('p_name', 'md_name', 'm_name', 'p_education', 'p_address', 'p_hp', 'mp_id', 'mp_contract')
            ->where('mp_mitra',$mitra)
            ->where('mp_divisi',$divisi)
            ->where('mp_isapproved', 'P')
            ->get();

      return view('approvalmitrapekerja.pekerja', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

        d_mitra_pekerja::where('mp_id',$request->mp_id)
                ->update([
                  'mp_isapproved' => 'Y'
                ]);

        DB::select("update d_mitra_contract
                    set mc_fulfilled =
                    (select count(mp_pekerja) from d_mitra_pekerja where mp_contract = '".$request->mp_contract."' and mp_status = 'Aktif' and mp_isapproved = 'Y') where mc_contractid = '".$request->mp_contract."'");

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

        d_mitra_pekerja::where('mp_id',$request->mp_id)
                ->update([
                  'mp_isapproved' => 'N'
                ]);

        DB::select("update d_mitra_contract
                    set mc_fulfilled =
                    (select count(mp_pekerja) from d_mitra_pekerja where mp_contract = '".$request->mp_contract."' and mp_status = 'Aktif' and mp_isapproved = 'Y') where mc_contractid = '".$request->mp_contract."'");

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
      d_mitra_pekerja::whereIn('mp_id', $request->pilih)
            ->update([
              'mp_isapproved' => 'Y'
            ]);

      DB::select("update d_mitra_contract set mc_fulfilled = (select count(mp_pekerja) from d_mitra_pekerja where mp_contract = ".$request->kontrak." and mp_status = 'Aktif' and mp_isapproved = 'Y') where mc_contractid = ".$request->kontrak."");

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
      d_mitra_pekerja::whereIn('mp_id', $request->pilih)
            ->update([
              'mp_isapproved' => 'N'
            ]);

      DB::select("update d_mitra_contract set mc_fulfilled = (select count(mp_pekerja) from d_mitra_pekerja where mp_contract = ".$request->kontrak." and mp_status = 'Aktif' and mp_isapproved = 'Y') where mc_contractid = ".$request->kontrak."");

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
