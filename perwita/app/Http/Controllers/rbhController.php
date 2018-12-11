<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

class rbhController extends Controller
{
  public function index(Request $request){
    if (!AksesUser::checkAkses(52, 'read')) {
        return redirect('not-authorized');
    }

    $id = $request->id;
    if (!empty($id)) {
    $data =  DB::table('d_pekerja')
        ->leftjoin('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
        ->where('p_id', $request->id)
        ->select('p_name', DB::raw("COALESCE(jp_name, '-') as jp_name"))
        ->get();

      return view('rbh.indexdinamis', compact('id', 'data'));
    } else {
      return view('rbh.index');
    }
  }

  public function getfaskes(Request $request){
    $data = DB::table('d_faskes')
            ->where('f_id', $request->id)
            ->get();

    return response()->json($data);
  }

  public function simpan(Request $request, $id){
    if (!AksesUser::checkAkses(52, 'insert')) {
        return redirect('not-authorized');
    }
    DB::beginTransaction();
    try {
      $check = DB::table('d_rbh')
              ->where('r_pekerja', $id)
              ->get();

      if (!empty($check)) {
          for ($i=0; $i < count($check); $i++) {
            if ($check[$i]->r_status == 'Y') {
              return response()->json([
                'status' => 'ada'
              ]);
            } else {
              $request->nominal = str_replace('.', '', $request->nominal);
              $request->nominal = str_replace('Rp ', '', $request->nominal);

          $pekerja = DB::table('d_mitra_pekerja')
                    ->where('mp_pekerja', $id)
                    ->get();

          DB::table('d_rbh')
              ->insert([
                'r_no' => $request->nobpjs,
                'r_pekerja' => $id,
                'r_date' => Carbon::createFromFormat('d/m/Y', $request->tmt, 'Asia/Jakarta'),
                'r_faskes' => $request->faskes,
                'r_kelas' => $request->kelas,
                'r_mitra' => $pekerja[0]->mp_mitra,
                'r_divisi' => $pekerja[0]->mp_divisi,
                'r_value' => $request->nominal,
                'r_status' => 'Y',
                'r_insert' => Carbon::now('Asia/Jakarta')
              ]);
        }
      }
    } else {
      $request->nominal = str_replace('.', '', $request->nominal);
      $request->nominal = str_replace('Rp ', '', $request->nominal);

    $pekerja = DB::table('d_mitra_pekerja')
              ->where('mp_pekerja', $id)
              ->get();

    DB::table('d_rbh')
        ->insert([
          'r_no' => $request->nobpjs,
          'r_pekerja' => $id,
          'r_date' => Carbon::createFromFormat('d/m/Y', $request->tmt, 'Asia/Jakarta'),
          'r_faskes' => $request->faskes,
          'r_kelas' => $request->kelas,
          'r_mitra' => $pekerja[0]->mp_mitra,
          'r_divisi' => $pekerja[0]->mp_divisi,
          'r_value' => $request->nominal,
          'r_status' => 'Y',
          'r_insert' => Carbon::now('Asia/Jakarta')
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
    return view('rbh.cari');
  }

  public function data(){
    $data = DB::table('d_rbh')
            ->join('d_pekerja', 'p_id', '=', 'r_pekerja')
            ->join('d_mitra', 'm_id', '=', 'r_mitra')
            ->join('d_mitra_divisi', 'md_id', '=', 'r_divisi')
            ->select('p_name', 'm_name', 'md_name', 'r_date', 'r_kelas', 'r_status', 'r_no', 'r_faskes')
            ->get();

    for ($i=0; $i < count($data); $i++) {
      $data[$i]->r_date = Carbon::parse($data[$i]->r_date)->format('d/m/Y');
     }

    return response()->json($data);
  }

  public function getdata(Request $request){
    $data = DB::table('d_rbh')
            ->join('d_pekerja', 'p_id', '=', 'r_pekerja')
            ->join('d_mitra', 'm_id', '=', 'r_mitra')
            ->join('d_mitra_divisi', 'md_id', '=', 'r_divisi')
            ->select('p_name', 'm_name', 'md_name', 'r_date', 'r_kelas', 'r_status', 'r_no', 'r_faskes')
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
    if (!AksesUser::checkAkses(52, 'delete')) {
        return redirect('not-authorized');
    }
    DB::beginTransaction();
    try {

      DB::table('d_rbh')
          ->where('r_no', $request->id)
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

      DB::table('d_rbh')
          ->where('r_no', $request->id)
          ->update([
            'r_status' => 'N'
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
