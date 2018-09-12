<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

class dapanController extends Controller
{
  public function index(){
    return view('dapan.index');
  }

  public function getfaskes(Request $request){
    $data = DB::table('d_faskes')
            ->where('f_id', $request->id)
            ->get();

    return response()->json($data);
  }

  public function simpan(Request $request, $id){
    DB::beginTransaction();
    try {
      $check = DB::table('d_dapan')
              ->where('d_pekerja', $id)
              ->get();

      if (!empty($check)) {
          for ($i=0; $i < count($check); $i++) {
            if ($check[$i]->b_status == 'Y') {
              return response()->json([
                'status' => 'ada'
              ]);
            } else {
          $pekerja = DB::table('d_mitra_pekerja')
                    ->where('mp_pekerja', $id)
                    ->get();

          DB::table('d_dapan')
              ->insert([
                'd_no' => $request->nobpjs,
                'd_pekerja' => $id,
                'd_date' => Carbon::createFromFormat('d/m/Y', $request->tmt, 'Asia/Jakarta'),
                'd_faskes' => $request->faskes,
                'd_kelas' => $request->kelas,
                'd_mitra' => $pekerja[0]->mp_mitra,
                'd_divisi' => $pekerja[0]->mp_divisi,
                'd_status' => 'Y',
                'd_insert' => Carbon::now('Asia/Jakarta')
              ]);
        }
      }
    } else {
    $pekerja = DB::table('d_mitra_pekerja')
              ->where('mp_pekerja', $id)
              ->get();

    DB::table('d_dapan')
        ->insert([
          'd_no' => $request->nobpjs,
          'd_pekerja' => $id,
          'd_date' => Carbon::createFromFormat('d/m/Y', $request->tmt, 'Asia/Jakarta'),
          'd_faskes' => $request->faskes,
          'd_kelas' => $request->kelas,
          'd_mitra' => $pekerja[0]->mp_mitra,
          'd_divisi' => $pekerja[0]->mp_divisi,
          'd_status' => 'Y',
          'd_insert' => Carbon::now('Asia/Jakarta')
        ]);
      }


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

  public function cari(){
    return view('dapan.cari');
  }

  public function data(){
    $data = DB::table('d_dapan')
            ->join('d_pekerja', 'p_id', '=', 'd_pekerja')
            ->join('d_mitra', 'm_id', '=', 'd_mitra')
            ->join('d_mitra_divisi', 'md_id', '=', 'd_divisi')
            ->select('p_name', 'm_name', 'md_name', 'd_date', 'd_kelas', 'd_status', 'd_no', 'd_faskes')
            ->get();

    for ($i=0; $i < count($data); $i++) {
      $data[$i]->d_date = Carbon::parse($data[$i]->d_date)->format('d/m/Y');
     }

    return response()->json($data);
  }

  public function getdata(Request $request){
    $data = DB::table('d_dapan')
            ->join('d_pekerja', 'p_id', '=', 'd_pekerja')
            ->join('d_mitra', 'm_id', '=', 'd_mitra')
            ->join('d_mitra_divisi', 'md_id', '=', 'd_divisi')
            ->select('p_name', 'm_name', 'md_name', 'd_date', 'd_kelas', 'd_status', 'd_no', 'd_faskes')
            ->where('p_id', $request->id)
            ->get();

    if (empty($data)) {
      return response()->json([
        'status' => 'kosong'
      ]);
    } else {
      return response()->json($data);
    }
  }

  public function hapus(Request $request){
    DB::beginTransaction();
    try {

      DB::table('d_dapan')
          ->where('d_no', $request->id)
          ->Delete();

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

  public function nonaktif(Request $request){
    DB::beginTransaction();
    try {

      DB::table('d_dapan')
          ->where('d_no', $request->id)
          ->update([
            'd_status' => 'N'
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
