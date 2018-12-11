<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

class bpjsketenagakerjaanController extends Controller
{
    public function index(Request $request){
      if (!AksesUser::checkAkses(51, 'read')) {
          return redirect('not-authorized');
      }
      $id = $request->id;
      if (!empty($id)) {
      $data =  DB::table('d_pekerja')
          ->leftjoin('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
          ->where('p_id', $request->id)
          ->select('p_name', DB::raw("COALESCE(jp_name, '-') as jp_name"), DB::raw("COALESCE(p_gaji_pokok, '-') as jht"), DB::raw("COALESCE(p_gaji_pokok, '-') as p_gaji_pokok"), DB::raw("COALESCE(p_gaji_pokok, '-') as pensiun"))
          ->get();

          $percentage = 2;

          $new_width = ($percentage / 100) * $data[0]->p_gaji_pokok;

          $data[0]->jht = $new_width;

          $percentage = 1;

          $new_width = ($percentage / 100) * $data[0]->p_gaji_pokok;

          $data[0]->pensiun = $new_width;

        return view('bpjsketenagakerjaan.indexdinamis', compact('id', 'data'));
      } else {
        return view('bpjsketenagakerjaan.index');
      }
    }

    public function getfaskes(Request $request){
      $data = DB::table('d_faskes')
              ->where('f_id', $request->id)
              ->get();

      return response()->json($data);
    }

    public function simpan(Request $request, $id){
      if (!AksesUser::checkAkses(51, 'insert')) {
          return redirect('not-authorized');
      }
      $check = DB::table('d_bpjs_ketenagakerjaan')
              ->where('b_pekerja', $id)
              ->get();


              if (!empty($check)) {
                for ($i=0; $i < count($check); $i++) {
                  if ($check[$i]->b_status == 'Y') {
                    return response()->json([
                      'status' => 'ada'
                    ]);

                  } else {
                    $request->iuranjht = str_replace('.', '', $request->iuranjht);
                    $request->iuranjht = str_replace('Rp ', '', $request->iuranjht);

                    $request->iuranpensiun = str_replace('.', '', $request->iuranpensiun);
                    $request->iuranpensiun = str_replace('Rp ', '', $request->iuranpensiun);

               $pekerja = DB::table('d_mitra_pekerja')
                         ->where('mp_pekerja', $id)
                         ->get();

               DB::table('d_bpjs_ketenagakerjaan')
                   ->insert([
                     'b_no' => $request->nobpjs,
                     'b_pekerja' => $id,
                     'b_date' => Carbon::createFromFormat('d/m/Y', $request->tmt, 'Asia/Jakarta'),
                     'b_mitra' => $pekerja[0]->mp_mitra,
                     'b_divisi' => $pekerja[0]->mp_divisi,
                     'b_value' => $request->iuranjht + $request->iuranpensiun,
                     'b_value_jht' => $request->iuranjht,
                     'b_value_pensiun' => $request->iuranpensiun,
                     'b_status' => 'Y',
                     'b_insert' => Carbon::now('Asia/Jakarta')
                   ]);

                 }
               }
              } else {
                $request->iuranjht = str_replace('.', '', $request->iuranjht);
                $request->iuranjht = str_replace('Rp ', '', $request->iuranjht);

                $request->iuranpensiun = str_replace('.', '', $request->iuranpensiun);
                $request->iuranpensiun = str_replace('Rp ', '', $request->iuranpensiun);

            $pekerja = DB::table('d_mitra_pekerja')
                      ->where('mp_pekerja', $id)
                      ->get();

            DB::table('d_bpjs_ketenagakerjaan')
                ->insert([
                  'b_no' => $request->nobpjs,
                  'b_pekerja' => $id,
                  'b_date' => Carbon::createFromFormat('d/m/Y', $request->tmt, 'Asia/Jakarta'),
                  'b_mitra' => $pekerja[0]->mp_mitra,
                  'b_divisi' => $pekerja[0]->mp_divisi,
                  'b_value' => $request->iuranjht + $request->iuranpensiun,
                  'b_value_jht' => $request->iuranjht,
                  'b_value_pensiun' => $request->iuranpensiun,
                  'b_status' => 'Y',
                  'b_insert' => Carbon::now('Asia/Jakarta')
                ]);

              }

        return response()->json([
          'status' => 'berhasil'
        ]);
  }

    public function cari(){
      return view('bpjsketenagakerjaan.cari');
    }

    public function data(){
      $data = DB::table('d_bpjs_ketenagakerjaan')
              ->join('d_pekerja', 'p_id', '=', 'b_pekerja')
              ->join('d_mitra', 'm_id', '=', 'b_mitra')
              ->join('d_mitra_divisi', 'md_id', '=', 'b_divisi')
              ->select('p_name', 'm_name', 'md_name', 'b_date', 'b_status', 'b_no')
              ->get();

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->b_date = Carbon::parse($data[$i]->b_date)->format('d/m/Y');
       }

      return response()->json($data);
    }

    public function getdata(Request $request){
      $data = DB::table('d_bpjs_ketenagakerjaan')
              ->join('d_pekerja', 'p_id', '=', 'b_pekerja')
              ->join('d_mitra', 'm_id', '=', 'b_mitra')
              ->join('d_mitra_divisi', 'md_id', '=', 'b_divisi')
              ->select('p_name', 'm_name', 'md_name', 'b_date', 'b_status', 'b_no')
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
      if (!AksesUser::checkAkses(51, 'delete')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        DB::table('d_bpjs_ketenagakerjaan')
            ->where('b_no', $request->id)
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

        DB::table('d_bpjs_ketenagakerjaan')
            ->where('b_no', $request->id)
            ->update([
              'b_status' => 'N'
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
