<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\d_mitra_pekerja;

use App\d_pekerja;

use App\d_pekerja_mutation;

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
            ->select('p_name', 'md_name', 'm_name', 'p_education', 'p_address', 'p_hp', 'mp_id', 'mp_contract', 'mp_pekerja')
            ->where('mp_mitra',$mitra)
            ->where('mp_divisi',$divisi)
            ->where('mp_isapproved', 'P')
            ->get();

      return view('approvalmitrapekerja.pekerja', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

      $ap = new mitraPekerjaController;

      print $ap->approvePekerja($request->mp_pekerja, $request->mp_contract);

        d_mitra_pekerja::where('mp_id',$request->mp_id)
                ->update([
                  'mp_isapproved' => 'Y'
                ]);

        DB::select("update d_mitra_contract
                    set mc_fulfilled =
                    (select count(mp_pekerja) from d_mitra_pekerja where mp_contract = '".$request->mp_contract."' and mp_isapproved = 'Y') where mc_contractid = '".$request->mp_contract."'");

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
                    (select count(mp_pekerja) from d_mitra_pekerja where mp_contract = '".$request->mp_contract."' and mp_isapproved = 'Y') where mc_contractid = '".$request->mp_contract."'");

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

        $sekarang = Carbon::now('Asia/Jakarta');

        $data = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->where('mp_contract', '=', $request->kontrak)
            ->whereIn('mp_id', $request->pilih)
            ->where('mp_isapproved', '=', 'P')
            ->get();

        $ap = new mitraPekerjaController;

        for ($i=0; $i < count($data); $i++) {
          if (empty($data[$i]->p_nip)) {
              $temp = $ap->getNewNik(count($data));
              $data[$i]->p_nip = $temp[$i];
          }
        }

        for ($i=0; $i < count($request->pilih); $i++) {
          d_pekerja::where('p_id', '=', $request->pilih[$i])
              ->update([
                  'p_note' => 'Seleksi',
                  'p_workdate' => $data[$i]->mp_workin_date,
                  'p_nip' => strtoupper($data[$i]->p_nip),
                  'p_nip_mitra' => strtoupper($data[$i]->mp_mitra_nik)
              ]);
        }



        for ($i=0; $i < count($request->pilih); $i++) {
          $pm_detail[] = DB::table('d_pekerja_mutation')
              ->select('pm_detailid')
              ->where('pm_pekerja', $request->pilih[$i])
              ->max('pm_detailid');
        }

        for ($i=0; $i < count($request->pilih); $i++) {
          $tempMutasi[] = array(
              'pm_pekerja' => $request->pilih[$i],
              'pm_detailid' => $pm_detail[$i] + 1,
              'pm_date' => $sekarang,
              'pm_mitra' => $data[$i]->mp_mitra,
              'pm_divisi' => $data[$i]->mp_divisi,
              'pm_detail' => 'Seleksi',
              'pm_from' => null,
              'pm_status' => 'Aktif'
          );
        }

        for ($i=0; $i < count($request->pilih); $i++) {
          d_pekerja_mutation::insert($tempMutasi[$i]);
        }

        DB::select("update d_mitra_contract set mc_fulfilled = (select count(mp_pekerja) from d_mitra_pekerja where mp_contract = " . $request->kontrak . " and mp_isapproved = 'Y') where mc_contractid = '".$request->kontrak."'");

      d_mitra_pekerja::whereIn('mp_id', $request->pilih)
            ->update([
              'mp_isapproved' => 'Y'
            ]);

      DB::select("update d_mitra_contract set mc_fulfilled = (select count(mp_pekerja) from d_mitra_pekerja where mp_contract = ".$request->kontrak." and mp_isapproved = 'Y') where mc_contractid = ".$request->kontrak."");

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

      DB::select("update d_mitra_contract set mc_fulfilled = (select count(mp_pekerja) from d_mitra_pekerja where mp_contract = ".$request->kontrak." and mp_isapproved = 'Y') where mc_contractid = ".$request->kontrak."");

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

    public function print(Request $request){
      $data = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_mitra_contract', 'mc_contractid', '=', 'mp_contract')
            ->join('d_mitra_divisi', 'md_id', '=', 'mp_divisi')
            ->select('p_name','mp_selection_date','mp_workin_date', 'mc_no', 'mp_status', 'm_name', 'md_name', 'p_nip', 'p_nip_mitra', 'm_address', 'm_phone', 'mc_date', 'mc_expired')
            ->where('mp_contract',$request->mp_contract)
            ->where('mp_isapproved','Y')
            ->get();

      for ($i=0; $i < count($data); $i++) {
        if (!empty($data)) {
          $data[$i]->mp_selection_date = Carbon::parse($data[$i]->mp_selection_date)->format('d/m/Y');
          $data[$i]->mp_workin_date = Carbon::parse($data[$i]->mp_workin_date)->format('d/m/Y');
          $data[$i]->mc_expired = Carbon::parse($data[$i]->mc_expired)->format('d/m/Y');
          $data[$i]->mc_date = Carbon::parse($data[$i]->mc_date)->format('d/m/Y');
        }
      }

      return view('approvalmitrapekerja.print', compact('data'));
    }
}