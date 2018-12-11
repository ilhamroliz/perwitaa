<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use Yajra\Datatables\Datatables;

use App\d_notifikasi;

use App\d_pegawai;

use App\Http\Controllers\AksesUser;

class pegawaipromosiController extends Controller
{
    public function index(){
      if (!AksesUser::checkAkses(39, 'read')) {
          return redirect('not-authorized');
      }

      $jabatan = DB::table('d_jabatan')
          ->where('j_isactive', 'Y')
          ->get();

      return view('pegawaipromosi.index', compact('jabatan'));

    }

    public function data(){
      $pekerja = DB::table('d_pegawai')
          ->leftJoin('d_jabatan', 'j_id', '=', 'p_jabatan')
          ->leftjoin('d_pegawai_promosi_demosi', 'ppd_jabatan_awal', '=', 'j_id')
          ->select('p_id', 'p_name', 'p_nip', 'p_jabatan', DB::raw('ppd_jabatan_awal as ppd_jabatan_awal, ppd_jabatan_sekarang as ppd_jabatan_sekarang'))
          ->where('p_status_approval', 'Y')
          ->groupBy('p_id')
          ->get();

          for ($i=0; $i < count($pekerja); $i++) {
           if ($pekerja[$i]->ppd_jabatan_awal == 1) {
             $pekerja[$i]->ppd_jabatan_awal = 'Superuser';
           } elseif ($pekerja[$i]->ppd_jabatan_awal == 2) {
             $pekerja[$i]->ppd_jabatan_awal = 'Admin';
           } elseif ($pekerja[$i]->ppd_jabatan_awal == 3) {
             $pekerja[$i]->ppd_jabatan_awal = 'Manager';
           } elseif ($pekerja[$i]->ppd_jabatan_awal == 4) {
             $pekerja[$i]->ppd_jabatan_awal = 'Asst Manager';
           } elseif ($pekerja[$i]->ppd_jabatan_awal == 5) {
             $pekerja[$i]->ppd_jabatan_awal = 'Supervisor';
           } elseif ($pekerja[$i]->ppd_jabatan_awal == 6) {
             $pekerja[$i]->ppd_jabatan_awal = 'Asst Supervisor';
           }
           }

           for ($i=0; $i < count($pekerja); $i++) {
             if ($pekerja[$i]->ppd_jabatan_sekarang == 1) {
               $pekerja[$i]->ppd_jabatan_sekarang = 'Superuser';
             } elseif ($pekerja[$i]->ppd_jabatan_sekarang == 2) {
               $pekerja[$i]->ppd_jabatan_sekarang = 'Admin';
             } elseif ($pekerja[$i]->ppd_jabatan_sekarang == 3) {
               $pekerja[$i]->ppd_jabatan_sekarang = 'Manager';
             } elseif ($pekerja[$i]->ppd_jabatan_sekarang == 4) {
               $pekerja[$i]->ppd_jabatan_sekarang = 'Asst Manager';
             } elseif ($pekerja[$i]->ppd_jabatan_sekarang == 5) {
               $pekerja[$i]->ppd_jabatan_sekarang = 'Supervisor';
             } elseif ($pekerja[$i]->ppd_jabatan_sekarang == 6) {
               $pekerja[$i]->ppd_jabatan_sekarang = 'Asst Supervisor';
             }
           }

      $pekerja = collect($pekerja);

      return Datatables::of($pekerja)
          ->addColumn('action', function ($pekerja) {
              return '<div class="text-center">
                  <button style="margin-left:5px;" title="Demosi" type="button" class="btn btn-warning btn-xs" onclick="demosi(' . $pekerja->p_id . ')"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>
                  <button style="margin-left:5px;" type="button" class="btn btn-primary btn-xs" title="Promosi" onclick="promosi(' . $pekerja->p_id . ')"><i class="glyphicon glyphicon-circle-arrow-up"></i></button>
                </div>';
          })
          ->make(true);
    }

    public function getdetail(Request $request)
    {
        $id = $request->id;
        $pekerja = DB::table('d_pegawai')
            ->leftJoin('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan_lamaran')
            ->select('p_id', 'p_name', 'jp_name', 'p_nip')
            ->where('p_id', '=', $id)
            ->groupBy('p_id')
            ->get();

        return response()->json([
            'data' => $pekerja
        ]);
    }

    public function simpan(Request $request)
    {
      if (!AksesUser::checkAkses(39, 'insert')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try{
            $note = $request->note;
            $jabatan = $request->jabatan;
            $jenis = $request->jenis;
            $sekarang = Carbon::now('Asia/Jakarta');
            $pekerja = $request->pekerja;

            //00001/PMS/PN/bulan/2018
            $jabatanAwal = DB::table('d_pegawai')
                ->select('p_jabatan', 'p_jabatan_lamaran')
                ->where('p_id', '=', $pekerja)
                ->get();

            if ($jabatanAwal[0]->p_jabatan == null || $jabatanAwal[0]->p_jabatan == ''){
                $jabatanAwal = $jabatanAwal[0]->p_jabatan_lamaran;
            } else {
                $jabatanAwal = $jabatanAwal[0]->p_jabatan;
            }

            $id = DB::table('d_pegawai_promosi_demosi')
                ->max('ppd_id');

            $tempKode = '';
            if ($jenis == 'Promosi'){
                $cek = DB::table('d_pegawai_promosi_demosi')
                    ->select(DB::raw('coalesce(max(left(ppd_no, 5)) + 1, "00001") as counter'))
                    ->where(DB::raw('mid(ppd_no, 7,3)'), '=', 'PMS')
                    ->where(DB::raw('mid(ppd_no, 14,2)'), '=', $sekarang->format("m"))
                    ->where(DB::raw('right(ppd_no, 4)'), '=', $sekarang->year)
                    ->get();

                foreach ($cek as $x) {
                    $temp = ((int)$x->counter);
                    $kode = sprintf("%05s",$temp);
                }
                $tempKode = $kode . '/' . 'PMS/PN/' . $sekarang->format("m") . '/' . $sekarang->year;

            } elseif ($jenis == 'Demosi'){
                $cek = DB::table('d_pegawai_promosi_demosi')
                    ->select(DB::raw('coalesce(max(left(pd_no, 5)) + 1, "00001") as counter'))
                    ->where(DB::raw('mid(ppd_no, 7,3)'), '=', 'DMS')
                    ->where(DB::raw('mid(ppd_no, 14,2)'), '=', $sekarang->format("m"))
                    ->where(DB::raw('right(ppd_no, 4)'), '=', $sekarang->year)
                    ->get();

                foreach ($cek as $x) {
                    $temp = ((int)$x->counter);
                    $kode = sprintf("%05s",$temp);
                }
                $tempKode = $kode . '/' . 'DMS/PN/' . $sekarang->format("m") . '/' . $sekarang->year;
            }

            DB::table('d_pegawai_promosi_demosi')->insert(array(
                'ppd_id' => $id + 1,
                'ppd_no' => $tempKode,
                'ppd_pegawai' => $pekerja,
                'ppd_jabatan_awal' => $jabatanAwal,
                'ppd_jabatan_sekarang' => $jabatan,
                'ppd_note' => $note,
                'ppd_isapproved' => 'P',
                'ppd_insert' => $sekarang
            ));

            $jumlah = DB::select("select count(ppd_id) as jumlah from d_pegawai_promosi_demosi where ppd_isapproved = 'P'");
            $jumlah = $jumlah[0]->jumlah;

            d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi Pegawai')
                ->where('n_detail', '=', 'Create')
                ->update([
                    'n_qty' => $jumlah,
                    'n_insert' => Carbon::now()
                ]);

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);

        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
}

  public function cari(){
    $jabatan = DB::table('d_jabatan')
              ->where('j_isactive', 'Y')
              ->get();

    return view('pegawaipromosi.cari', compact('jabatan'));
  }

  public function tabelcari(){

      $data = DB::table('d_pegawai_promosi_demosi')
            ->join('d_pegawai', 'p_id', '=', 'ppd_pegawai')
            ->join('d_jabatan', 'j_id', '=', 'ppd_jabatan_sekarang')
            ->select('ppd_no', 'p_name', 'j_name', 'p_nip', 'ppd_id', 'ppd_jabatan_awal', 'ppd_jabatan_sekarang')
            ->get();

            for ($i=0; $i < count($data); $i++) {
             if ($data[$i]->ppd_jabatan_awal == 1) {
               $data[$i]->ppd_jabatan_awal = 'Superuser';
             } elseif ($data[$i]->ppd_jabatan_awal == 2) {
               $data[$i]->ppd_jabatan_awal = 'Admin';
             } elseif ($data[$i]->ppd_jabatan_awal == 3) {
               $data[$i]->ppd_jabatan_awal = 'Manager';
             } elseif ($data[$i]->ppd_jabatan_awal == 4) {
               $data[$i]->ppd_jabatan_awal = 'Asst Manager';
             } elseif ($data[$i]->ppd_jabatan_awal == 5) {
               $data[$i]->ppd_jabatan_awal = 'Supervisor';
             } elseif ($data[$i]->ppd_jabatan_awal == 6) {
               $data[$i]->ppd_jabatan_awal = 'Asst Supervisor';
             }
             }

             for ($i=0; $i < count($data); $i++) {
               if ($data[$i]->ppd_jabatan_sekarang == 1) {
                 $data[$i]->ppd_jabatan_sekarang = 'Superuser';
               } elseif ($data[$i]->ppd_jabatan_sekarang == 2) {
                 $data[$i]->ppd_jabatan_sekarang = 'Admin';
               } elseif ($data[$i]->ppd_jabatan_sekarang == 3) {
                 $data[$i]->ppd_jabatan_sekarang = 'Manager';
               } elseif ($data[$i]->ppd_jabatan_sekarang == 4) {
                 $data[$i]->ppd_jabatan_sekarang = 'Asst Manager';
               } elseif ($data[$i]->ppd_jabatan_sekarang == 5) {
                 $data[$i]->ppd_jabatan_sekarang = 'Supervisor';
               } elseif ($data[$i]->ppd_jabatan_sekarang == 6) {
                 $data[$i]->ppd_jabatan_sekarang = 'Asst Supervisor';
               }
             }

             $tmp = collect($data);

         return Datatables::of($tmp)
              ->addColumn('action', function ($tmp) {
                   return '<div class="text-center">
                             <a style="margin-left:5px;" title="Detail" type="button" onclick="detail('. $tmp->ppd_id .')"  class="btn btn-info btn-xs"><i class="glyphicon glyphicon-folder-open"></i></a>
                             <a style="margin-left:5px;" title="Edit" type="button" onclick="edit('. $tmp->ppd_id .')"  class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
                             <a style="margin-left:5px;" title="Hapus" type="button" onclick="hapus('. $tmp->ppd_id .')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
                           </div>';
               })
               ->make(true);
  }

  public function detail(Request $request){
    $data = DB::table('d_pegawai_promosi_demosi')
          ->join('d_pegawai', 'p_id', '=', 'ppd_pegawai')
          ->join('d_jabatan', 'j_id', '=', 'ppd_jabatan_sekarang')
          ->select('ppd_no', 'p_name', 'p_nip', 'ppd_id', 'ppd_note', 'ppd_jabatan_awal', 'ppd_jabatan_sekarang', 'ppd_isapproved')
          ->where('ppd_id', $request->id)
          ->get();

    $jabatanawal = DB::table('d_jabatan')
                ->where('j_id',$data[0]->ppd_jabatan_awal)
                ->get();

    $jabatansekarang = DB::table('d_jabatan')
                ->where('j_id',$data[0]->ppd_jabatan_sekarang)
                ->get();

    return response()->json([$data, $jabatanawal, $jabatansekarang]);
  }

  public function getno(Request $request){
    $keyword = $request->term;

    $data = DB::table('d_pegawai_promosi_demosi')
              ->join('d_pegawai', 'p_id', '=', 'ppd_pegawai')
              ->join('d_jabatan', 'j_id', '=', 'ppd_jabatan_sekarang')
              ->select('ppd_no', 'p_name', 'j_name', 'p_nip', 'ppd_id')
              ->where('ppd_no', 'LIKE', '%'.$keyword.'%')
              ->groupBy('ppd_id')
              ->LIMIT(20)
              ->get();

          if ($data == null) {
              $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
          } else {

              foreach ($data as $query) {
                  $results[] = ['id' => $query->ppd_id, 'label' => $query->p_name . ' (' . $query->ppd_no . ')'];
              }
          }

          return response()->json($results);
  }

  public function getdata(Request $request){
    $data = DB::table('d_pegawai_promosi_demosi')
          ->join('d_pegawai', 'p_id', '=', 'ppd_pegawai')
          ->join('d_jabatan', 'j_id', '=', 'ppd_jabatan_sekarang')
          ->select('ppd_no', 'p_name', 'j_name', 'ppd_jabatan_awal', 'ppd_jabatan_sekarang', 'p_nip', 'ppd_id')
          ->where('ppd_id', $request->id)
          ->get();


          for ($i=0; $i < count($data); $i++) {
           if ($data[$i]->ppd_jabatan_awal == 1) {
             $data[$i]->ppd_jabatan_awal = 'Superuser';
           } elseif ($data[$i]->ppd_jabatan_awal == 2) {
             $data[$i]->ppd_jabatan_awal = 'Admin';
           } elseif ($data[$i]->ppd_jabatan_awal == 3) {
             $data[$i]->ppd_jabatan_awal = 'Manager';
           } elseif ($data[$i]->ppd_jabatan_awal == 4) {
             $data[$i]->ppd_jabatan_awal = 'Asst Manager';
           } elseif ($data[$i]->ppd_jabatan_awal == 5) {
             $data[$i]->ppd_jabatan_awal = 'Supervisor';
           } elseif ($data[$i]->ppd_jabatan_awal == 6) {
             $data[$i]->ppd_jabatan_awal = 'Asst Supervisor';
           } elseif ($data[$i]->ppd_jabatan_awal == null) {
             $data[$i]->ppd_jabatan_awal = '-';
           }
           }

           for ($i=0; $i < count($data); $i++) {
             if ($data[$i]->ppd_jabatan_sekarang == 1) {
               $data[$i]->ppd_jabatan_sekarang = 'Superuser';
             } elseif ($data[$i]->ppd_jabatan_sekarang == 2) {
               $data[$i]->ppd_jabatan_sekarang = 'Admin';
             } elseif ($data[$i]->ppd_jabatan_sekarang == 3) {
               $data[$i]->ppd_jabatan_sekarang = 'Manager';
             } elseif ($data[$i]->ppd_jabatan_sekarang == 4) {
               $data[$i]->ppd_jabatan_sekarang = 'Asst Manager';
             } elseif ($data[$i]->ppd_jabatan_sekarang == 5) {
               $data[$i]->ppd_jabatan_sekarang = 'Supervisor';
             } elseif ($data[$i]->ppd_jabatan_sekarang == 6) {
               $data[$i]->ppd_jabatan_sekarang = 'Asst Supervisor';
             } elseif ($data[$i]->ppd_jabatan_sekarang == null) {
               $data[$i]->ppd_jabatan_sekarang = '-';
             }
           }

    if (count($data) > 0) {
      return response()->json($data);
    } else {
      return response()->json([
        'status' => 'kosong'
      ]);
    }
  }

  public function hapus(Request $request){
    if (!AksesUser::checkAkses(39, 'delete')) {
        return redirect('not-authorized');
    }
    DB::beginTransaction();
    try {

      $pekerja = DB::table('d_pegawai_promosi_demosi')
              ->select('ppd_no')
              ->where('ppd_id',$request->id)
              ->get();

      DB::table('d_pegawai_mutation')->where('pm_reff',$pekerja[0]->ppd_no)
              ->where('pm_detail', 'Promosi')
              ->update([
                'pm_note' => 'dihapus'
              ]);


      DB::table('d_pegawai_promosi_demosi')
        ->where('ppd_id', $request->id)
        ->delete();

        $count = DB::table('d_pegawai_promosi_demosi')
                ->where('ppd_isapproved', 'P')
                ->get();

        DB::table('d_notifikasi')
          ->where('n_fitur', 'Promosi & Demosi Pegawai')
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

  public function edit(Request $request){
    if (!AksesUser::checkAkses(39, 'update')) {
        return redirect('not-authorized');
    }
    $data = DB::table('d_pegawai_promosi_demosi')
          ->where('ppd_id', $request->id)
          ->get();

    return response()->json($data);
  }

  public function update(Request $request, $id){
    if (!AksesUser::checkAkses(39, 'update')) {
        return redirect('not-authorized');
    }
    DB::beginTransaction();
    try {

      DB::table('d_pegawai_promosi_demosi')
          ->where('ppd_id', $id)
          ->update([
            'ppd_jabatan_sekarang' => $request->jabatanBaru,
            'ppd_note' => $request->note
          ]);

      $pekerja = DB::table('d_pegawai_promosi_demosi')
              ->select('ppd_no', 'ppd_pegawai')
              ->where('ppd_id',$id)
              ->get();

      DB::table('d_pegawai_mutation')->where('pm_reff',$pekerja[0]->ppd_no)
              ->where('pm_detail', 'Promosi')
              ->update([
                'pm_note' => $request->note
              ]);

      d_pegawai::where('p_id', $pekerja[0]->ppd_pegawai)
              ->update([
                'p_jabatan' => $request->jabatanBaru
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
