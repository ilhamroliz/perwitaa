<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

class phkController extends Controller
{
    public function index(){
      if (!AksesUser::checkAkses(10, 'read')) {
          return redirect('not-authorized');
      }

      return view('PHK.index');
    }

    public function carino(Request $request){

      $keyword = $request->term;

      $data = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_mitra_divisi', function($e){
              $e->on('m_id', '=', 'md_mitra');
              $e->on('mp_divisi', '=', 'md_id');
            })
            ->select('p_id','mp_id','p_name','md_name', 'mp_mitra_nik', 'p_nip', 'p_nip_mitra', DB::Raw("coalesce(p_jabatan, '-') as p_jabatan"))
            ->whereRaw("mp_status = 'Aktif' AND mp_isapproved = 'Y' AND p_nip LIKE '%".$keyword."%' OR p_name LIKE '%".$keyword."%'")
            ->LIMIT(20)
            ->get();

            for ($i=0; $i < count($data); $i++) {
              $jabatan[] = DB::table('d_jabatan_pelamar')
                      ->where('jp_id', $data[$i]->p_jabatan)
                      ->get();
            }

            if ($data == null) {
                $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
            } else {

                foreach ($data as $query) {
                    $results[] = ['id' => $query->p_id, 'label' => $query->p_name . ' (' . $query->p_nip . ')'];
                }
            }

            return response()->json($results);
    }

    public function getdata(Request $request){
      $data = DB::table('d_pekerja')
             ->select('p_name', 'p_jabatan', DB::raw("coalesce(p_gaji_pokok, '') as bpjskes"), DB::raw("COALESCE(p_gaji_pokok, '-') as jht"), DB::raw("COALESCE(p_gaji_pokok, '-') as pensiun"))
             ->where('p_id',$request->id)
             ->get();

             $jabatan = DB::table('d_jabatan_pelamar')
                     ->where('jp_id', $data[0]->p_jabatan)
                     ->get();

             if (count($jabatan) > 0) {
               $data[0]->p_jabatan = $jabatan[0]->jp_name;
             } else {
               $data[0]->p_jabatan = '-';
             }

       $percentage = 1;

       $new_width = ($percentage / 100) * $data[0]->bpjskes;

       $data[0]->bpjskes = $new_width;

       $percentage = 2;

       $new_width = ($percentage / 100) * $data[0]->jht;

       $data[0]->jht = $new_width;

       $percentage = 1;

       $new_width = ($percentage / 100) * $data[0]->pensiun;

       $data[0]->pensiun = $new_width;


      if (count($data) > 0) {
       return response()->json($data);
     } else {
       return response()->json([
         'status' => 'kosong'
       ]);
     }
    }

    public function simpan(Request $request, $idpekerja){
      if (!AksesUser::checkAkses(10, 'insert')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        $id = DB::table('d_phk')
            ->max('p_id');

        if ($id == null) {
          $id = 0;
        }

        $mitrapekerja = DB::table('d_mitra_pekerja')
                        ->where('mp_status', 'Aktif')
                        ->where('mp_pekerja', $idpekerja)
                        ->get();

        $kode = "";

        $querykode = DB::select(DB::raw("SELECT MAX(MID(p_no,5,5)) as counter, MAX(MID(p_no,14,2)) as bulan, MAX(MID(p_no,17)) as tahun FROM d_phk"));

        if (count($querykode) > 0) {
          if ($querykode[0]->bulan != date('m') || $querykode[0]->tahun != date('Y')) {
              $kode = "00001";
          } else {
            foreach($querykode as $k)
              {
                $tmp = ((int)$k->counter)+1;
                $kode = sprintf("%05s", $tmp);
              }
          }
        } else {
          $kode = "00001";
        }


        $finalkode = 'PHK.' . $kode . '/' . date('m') . '/' . date('Y');

        DB::table('d_phk')
            ->insert([
              'p_id' => $id + 1,
              'p_contract' => $mitrapekerja[0]->mp_contract,
              'p_contract_detailid' => $mitrapekerja[0]->mp_id,
              'p_no' => $finalkode,
              'p_pekerja' => $idpekerja,
              'p_date' => Carbon::now('Asia/Jakarta'),
              'p_keterangan' => $request->keterangan
            ]);

            $count = DB::table('d_phk')
                    ->where('p_isapproved', 'P')
                    ->get();

            DB::table('d_notifikasi')
              ->where('n_fitur', 'PHK')
              ->update([
                'n_qty' => count($count)
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

    public function cari(){
      return view('PHK.cari');
    }

    public function data(){
      $data = DB::table('d_phk')
            ->join('d_pekerja', 'd_pekerja.p_id', '=', 'd_phk.p_pekerja')
            ->select('d_pekerja.p_name', 'd_phk.p_id', 'd_phk.p_no', 'd_phk.p_date', 'd_phk.p_keterangan', 'd_pekerja.p_jabatan')
            ->get();


      if (count($data) > 0) {
          return response()->json($data);
      } else {
        return response()->json([
          'status' => 'kosong'
        ]);
      }
    }

    public function getcari(Request $request){
      $data = DB::table('d_phk')
            ->join('d_pekerja', 'd_pekerja.p_id', '=', 'd_phk.p_pekerja')
            ->select('d_pekerja.p_name', 'd_phk.p_id', 'd_phk.p_no', 'd_phk.p_date', 'd_phk.p_keterangan', 'd_pekerja.p_jabatan')
            ->where('d_phk.p_pekerja', $request->id)
            ->get();

            $jabatan = DB::table('d_jabatan_pelamar')
                    ->where('jp_id', $data[0]->p_jabatan)
                    ->get();

            if (count($jabatan) > 0) {
              $data[0]->p_jabatan = $jabatan[0]->jp_name;
            } else {
              $data[0]->p_jabatan = '-';
            }

      if (count($data)) {
       return response()->json($data);
     } else {
       return response()->json([
         'status' => 'kosong'
       ]);
     }
    }

    public function detail(Request $request){
        $data = DB::table('d_phk')
              ->join('d_pekerja', 'd_pekerja.p_id', '=', 'd_phk.p_pekerja')
              ->select('d_pekerja.p_name', 'd_phk.p_id', 'd_phk.p_no', 'd_phk.p_date', 'd_phk.p_keterangan', 'd_pekerja.p_jabatan', 'd_phk.p_isapproved')
              ->where('d_phk.p_id', $request->id)
              ->get();

              $jabatan = DB::table('d_jabatan_pelamar')
                      ->where('jp_id', $data[0]->p_jabatan)
                      ->get();

              if (count($jabatan) > 0) {
                $data[0]->p_jabatan = $jabatan[0]->jp_name;
              } else {
                $data[0]->p_jabatan = '-';
              }

        return response()->json($data);
    }

    public function hapus(Request $request){
      if (!AksesUser::checkAkses(10, 'delete')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        $no = DB::table('d_phk')
            ->where('p_id', $request->id)
            ->get();

        DB::table('d_phk')
            ->where('p_id', $request->id)
            ->DELETE();

        DB::table('d_pekerja_mutation')
            ->where('pm_reff', $no[0]->p_no)
            ->where('pm_pekerja', $no[0]->p_pekerja)
            ->update([
              'pm_note' => 'Dihapus'
            ]);

            $count = DB::table('d_phk')
                    ->where('p_isapproved', 'P')
                    ->get();

            DB::table('d_notifikasi')
              ->where('n_fitur', 'PHK')
              ->update([
                'n_qty' => count($count)
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

    public function print(Request $request){
      $data = DB::table('d_phk')
            ->join('d_pekerja', 'd_pekerja.p_id', '=', 'd_phk.p_pekerja')
            ->join('d_mitra_pekerja', function($e){
              $e->on('mp_contract', '=', 'd_phk.p_contract')
                ->on('mp_id', '=', 'd_phk.p_contract_detailid');
            })
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_mitra_divisi', function($e){
              $e->on('md_mitra', '=', 'mp_mitra')
                ->on('md_id', '=', 'mp_divisi');
            })
            ->where('d_phk.p_id', $request->id)
            ->get();

            $jabatan = DB::table('d_jabatan_pelamar')
                    ->where('jp_id', $data[0]->p_jabatan)
                    ->get();

            if (count($jabatan) > 0) {
              $data[0]->p_jabatan = $jabatan[0]->jp_name;
            } else {
              $data[0]->p_jabatan = '-';
            }

      return view('PHK.print', compact('data'));
    }
}
