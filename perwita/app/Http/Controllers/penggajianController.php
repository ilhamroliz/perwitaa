<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

class penggajianController extends Controller
{
    public function index(){
      $data = DB::table('d_mitra')
              ->join('d_mitra_divisi', 'md_mitra', '=', 'm_id')
              ->groupBy('m_name')
              ->get();

      return view('penggajian.index', compact('data'));
    }

    public function gaji(Request $request){
      dd($request);
    }

    public function getpekerja(Request $request){
      $data = DB::table('d_pekerja')
            ->where('p_id', $request->id)
            ->select('p_name', 'p_nip', 'p_nip_mitra')
            ->get();

      return response()->json($data);
    }

    public function simpan(Request $request, $id){
      DB::beginTransaction();
      try {

        $tmp = str_replace('.', '', $request->totalgaji);
        $gaji = str_replace('Rp ', '', $tmp);

        $detailid = DB::table('d_payroll')
                    ->where('p_pekerja', $id)
                    ->max('p_detailid');

        DB::table('d_payroll')
          ->insert([
            'p_pekerja' => $id,
            'p_detailid' => $detailid + 1,
            'p_date' => Carbon::now('Asia/Jakarta'),
            'p_start_periode' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
            'p_end_periode' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
            'p_value' => $gaji,
            'p_status' => 'P'
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

    public function proses(Request $request, $id){
      DB::beginTransaction();
      try {

        $tmp = str_replace('.', '', $request->totalgaji);
        $gaji = str_replace('Rp ', '', $tmp);

        $detailid = DB::table('d_payroll')
                    ->where('p_pekerja', $id)
                    ->max('p_detailid');

        DB::table('d_payroll')
          ->insert([
            'p_pekerja' => $id,
            'p_detailid' => $detailid + 1,
            'p_date' => Carbon::now('Asia/Jakarta'),
            'p_start_periode' => Carbon::createFromFormat('d/m/Y', $request->start, 'Asia/Jakarta'),
            'p_end_periode' => Carbon::createFromFormat('d/m/Y', $request->end, 'Asia/Jakarta'),
            'p_value' => $gaji,
            'p_status' => 'Y'
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
}
