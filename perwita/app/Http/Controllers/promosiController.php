<?php

namespace App\Http\Controllers;

use App\d_pekerja;
use App\d_pekerja_mutation;
use App\d_promosi_demosi;
use App\d_notifikasi;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;

use App\Http\Controllers\AksesUser;

class promosiController extends Controller
{
    public function index()
    {

      if (!AksesUser::checkAkses(8, 'read')) {
          return redirect('not-authorized');
      }

        $jabatan = DB::table('d_jabatan_pelamar')
            ->get();

        return view('promosi.index', compact('jabatan'));
    }

    public function getData()
    {
        $pekerja = DB::table('d_pekerja')
            ->leftJoin('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan')
            ->leftjoin('d_promosi_demosi', 'pd_jabatan_awal', '=', 'jp_id')
            ->leftJoin('d_mitra_pekerja', function ($e) {
                $e->on('mp_pekerja', '=', 'p_id');
            })
            ->leftJoin('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q) {
                $q->on('md_mitra', '=', 'mp_mitra');
                $q->on('md_id', '=', 'mp_divisi');
                $q->on('md_mitra', '=', 'm_id');
            })
            ->select('p_id', 'p_name', 'jp_name', 'p_nip', 'p_jabatan', 'p_nip_mitra', 'd_mitra.m_name', 'd_mitra_divisi.md_name', DB::raw('pd_jabatan_awal as pd_jabatan_awal, pd_jabatan_sekarang as pd_jabatan_sekarang'))
            ->where('p_note', '!=', 'Calon')
            ->where('p_note', '!=', 'Ex')
            ->where('mp_status', '=', 'Aktif')
            ->groupBy('p_id')
            ->get();

        for ($i = 0; $i < count($pekerja); $i++) {
            if ($pekerja[$i]->pd_jabatan_awal == 1) {
                $pekerja[$i]->pd_jabatan_awal = 'Manager';
            } elseif ($pekerja[$i]->pd_jabatan_awal == 2) {
                $pekerja[$i]->pd_jabatan_awal = 'Supervisor';
            } elseif ($pekerja[$i]->pd_jabatan_awal == 3) {
                $pekerja[$i]->pd_jabatan_awal = 'Staff';
            } elseif ($pekerja[$i]->pd_jabatan_awal == 4) {
                $pekerja[$i]->pd_jabatan_awal = 'Operator';
            }

        }

        for ($i = 0; $i < count($pekerja); $i++) {
            if ($pekerja[$i]->pd_jabatan_sekarang == 1) {
                $pekerja[$i]->pd_jabatan_sekarang = 'Manager';
            } elseif ($pekerja[$i]->pd_jabatan_sekarang == 2) {
                $pekerja[$i]->pd_jabatan_sekarang = 'Supervisor';
            } elseif ($pekerja[$i]->pd_jabatan_sekarang == 3) {
                $pekerja[$i]->pd_jabatan_sekarang = 'Staff';
            } elseif ($pekerja[$i]->pd_jabatan_sekarang == 4) {
                $pekerja[$i]->pd_jabatan_sekarang = 'Operator';
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
        $pekerja = DB::table('d_pekerja')
            ->leftJoin('d_jabatan_pelamar', 'jp_id', '=', 'p_jabatan_lamaran')
            ->leftJoin('d_mitra_pekerja', function ($e) {
                $e->on('mp_pekerja', '=', 'p_id');
            })
            ->leftJoin('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q) {
                $q->on('md_mitra', '=', 'mp_mitra');
                $q->on('md_id', '=', 'mp_divisi');
                $q->on('md_mitra', '=', 'm_id');
            })
            ->select('p_id', 'p_name', 'jp_name', 'p_nip', 'p_nip_mitra', 'd_mitra.m_name', 'd_mitra_divisi.md_name')
            ->where('p_note', '!=', 'Calon')
            ->where('p_note', '!=', 'Ex')
            ->where('mp_status', '=', 'Aktif')
            ->where('p_id', '=', $id)
            ->groupBy('p_id')
            ->get();

        return response()->json([
            'data' => $pekerja
        ]);
    }

    public function save(Request $request)
    {
      if (!AksesUser::checkAkses(8, 'insert')) {
          return redirect('not-authorized');
      }

        DB::beginTransaction();
        try {
            $note = $request->note;
            $jabatan = $request->jabatan;
            $jenis = $request->jenis;
            $sekarang = Carbon::now('Asia/Jakarta');
            $pekerja = $request->pekerja;

            //00001/PMS/PN/bulan/2018
            $jabatanAwal = DB::table('d_pekerja')
                ->select('p_jabatan', 'p_jabatan_lamaran')
                ->where('p_id', '=', $pekerja)
                ->get();

            if ($jabatanAwal[0]->p_jabatan == null || $jabatanAwal[0]->p_jabatan == '') {
                $jabatanAwal = $jabatanAwal[0]->p_jabatan_lamaran;
            } else {
                $jabatanAwal = $jabatanAwal[0]->p_jabatan;
            }

            $id = DB::table('d_promosi_demosi')
                ->max('pd_id');

            $tempKode = '';
            if ($jenis == 'Promosi') {
                $cek = DB::table('d_promosi_demosi')
                    ->select(DB::raw('coalesce(max(left(pd_no, 5)) + 1, "00001") as counter'))
                    ->where(DB::raw('mid(pd_no, 7,3)'), '=', 'PMS')
                    ->where(DB::raw('mid(pd_no, 14,2)'), '=', $sekarang->format("m"))
                    ->where(DB::raw('right(pd_no, 4)'), '=', $sekarang->year)
                    ->get();

                foreach ($cek as $x) {
                    $temp = ((int)$x->counter);
                    $kode = sprintf("%05s", $temp);
                }
                $tempKode = $kode . '/' . 'PMS/PN/' . $sekarang->format("m") . '/' . $sekarang->year;

            } elseif ($jenis == 'Demosi') {
                $cek = DB::table('d_promosi_demosi')
                    ->select(DB::raw('coalesce(max(left(pd_no, 5)) + 1, "00001") as counter'))
                    ->where(DB::raw('mid(pd_no, 7,3)'), '=', 'DMS')
                    ->where(DB::raw('mid(pd_no, 14,2)'), '=', $sekarang->format("m"))
                    ->where(DB::raw('right(pd_no, 4)'), '=', $sekarang->year)
                    ->get();

                foreach ($cek as $x) {
                    $temp = ((int)$x->counter);
                    $kode = sprintf("%05s", $temp);
                }
                $tempKode = $kode . '/' . 'DMS/PN/' . $sekarang->format("m") . '/' . $sekarang->year;
            }

            d_promosi_demosi::insert(array(
                'pd_id' => $id + 1,
                'pd_no' => $tempKode,
                'pd_pekerja' => $pekerja,
                'pd_jabatan_awal' => $jabatanAwal,
                'pd_jabatan_sekarang' => $jabatan,
                'pd_note' => $note,
                'pd_isapproved' => 'P',
                'pd_insert' => $sekarang
            ));

            $jumlah = DB::select("select count(pd_id) as jumlah from d_promosi_demosi where pd_isapproved = 'P'");
            $jumlah = $jumlah[0]->jumlah;

            d_notifikasi::where('n_fitur', '=', 'Promosi & Demosi')
                ->where('n_detail', '=', 'Create')
                ->update([
                    'n_qty' => $jumlah,
                    'n_insert' => Carbon::now()
                ]);

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function approvePromosi($nomor)
    {

        $data = DB::table('d_promosi_demosi')
            ->where('pd_no', '=', $nomor)
            ->get();

        $pekerja = $data[0]->pd_pekerja;
        $jabatan = $data[0]->pd_jabatan_sekarang;
        $sekarang = Carbon::now('Asia/Jakarta');

        $detailid = DB::table('d_pekerja_mutation')
            ->select(DB::raw('max(pm_detailid) as detailid'), 'pm_status')
            ->where('pm_pekerja', '=', $pekerja)
            ->get();

        $info = DB::table('d_mitra_pekerja')
            ->select(DB::raw('coalesce(mp_mitra, null) as mitra'), DB::raw('coalesce(mp_divisi, null) as divisi'))
            ->where('mp_status', '=', 'Aktif')
            ->where('mp_pekerja', '=', $pekerja)
            ->get();

        d_pekerja_mutation::insert(array(
            'pm_pekerja' => $pekerja,
            'pm_detailid' => $detailid[0]->detailid + 1,
            'pm_date' => $sekarang,
            'pm_mitra' => $info[0]->mitra,
            'pm_divisi' => $info[0]->divisi,
            'pm_detail' => 'Promosi',
            'pm_status' => 'Aktif',
            'pm_note' => $data[0]->pd_note,
            'pm_insert_by' => Session::get('mem'),
            'pm_reff' => $nomor
        ));

        d_pekerja::where('p_id', '=', $pekerja)
            ->update([
                'p_jabatan' => $jabatan
            ]);

    }

    public function cari()
    {
        $jabatan = DB::table('d_jabatan_pelamar')
            ->get();

        return view('promosi.cari', compact('jabatan'));
    }

    public function data()
    {
        $data = DB::table('d_promosi_demosi')
            ->join('d_pekerja', 'p_id', '=', 'pd_pekerja')
            ->join('d_mitra_pekerja', 'mp_pekerja', '=', 'pd_pekerja')
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'pd_jabatan_sekarang')
            ->leftJoin('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q) {
                $q->on('md_mitra', '=', 'mp_mitra');
                $q->on('md_id', '=', 'mp_divisi');
                $q->on('md_mitra', '=', 'm_id');
            })
            ->select('pd_no', 'p_name', 'jp_name', 'p_nip', 'p_nip_mitra', 'm_name', 'md_name', 'pd_id', 'pd_jabatan_awal', 'pd_jabatan_sekarang')
            ->get();

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]->pd_jabatan_awal == 1) {
                $data[$i]->pd_jabatan_awal = 'Manager';
            } elseif ($data[$i]->pd_jabatan_awal == 2) {
                $data[$i]->pd_jabatan_awal = 'Supervisor';
            } elseif ($data[$i]->pd_jabatan_awal == 3) {
                $data[$i]->pd_jabatan_awal = 'Staff';
            } elseif ($data[$i]->pd_jabatan_awal == 4) {
                $data[$i]->pd_jabatan_awal = 'Operator';
            } elseif ($data[$i]->pd_jabatan_awal == 0) {
                $data[$i]->pd_jabatan_awal = '-';
            }

        }

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]->pd_jabatan_sekarang == 1) {
                $data[$i]->pd_jabatan_sekarang = 'Manager';
            } elseif ($data[$i]->pd_jabatan_sekarang == 2) {
                $data[$i]->pd_jabatan_sekarang = 'Supervisor';
            } elseif ($data[$i]->pd_jabatan_sekarang == 3) {
                $data[$i]->pd_jabatan_sekarang = 'Staff';
            } elseif ($data[$i]->pd_jabatan_sekarang == 4) {
                $data[$i]->pd_jabatan_sekarang = 'Operator';
            } elseif ($data[$i]->pd_jabatan_sekarang == 0) {
                $data[$i]->pd_jabatan_sekarang = '-';
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

    public function getno(Request $request)
    {
        $keyword = $request->term;

        $data = DB::table('d_promosi_demosi')
            ->join('d_pekerja', 'p_id', '=', 'pd_pekerja')
            ->join('d_mitra_pekerja', 'mp_pekerja', '=', 'pd_pekerja')
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'pd_jabatan_sekarang')
            ->leftJoin('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q) {
                $q->on('md_mitra', '=', 'mp_mitra');
                $q->on('md_id', '=', 'mp_divisi');
                $q->on('md_mitra', '=', 'm_id');
            })
            ->select('pd_no', 'p_name', 'jp_name', 'p_nip', 'p_nip_mitra', 'm_name', 'md_name', 'pd_id')
            ->ORwhere('pd_no', 'LIKE', '%' . $keyword . '%')
            ->ORwhere('p_name', 'LIKE', '%' . $keyword . '%')
            ->groupBy('pd_id')
            ->LIMIT(20)
            ->get();

        if ($data == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($data as $query) {
                $results[] = ['id' => $query->pd_id, 'label' => $query->p_name . ' (' . $query->pd_no . ' )'];
            }
        }

        return response()->json($results);
    }

    public function getcari(Request $request)
    {
        $data = DB::table('d_promosi_demosi')
            ->join('d_pekerja', 'p_id', '=', 'pd_pekerja')
            ->join('d_mitra_pekerja', 'mp_pekerja', '=', 'pd_pekerja')
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'pd_jabatan_sekarang')
            ->leftJoin('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q) {
                $q->on('md_mitra', '=', 'mp_mitra');
                $q->on('md_id', '=', 'mp_divisi');
                $q->on('md_mitra', '=', 'm_id');
            })
            ->select('pd_no', 'p_name', 'jp_name', 'pd_jabatan_awal', 'pd_jabatan_sekarang', 'p_nip', 'p_nip_mitra', 'm_name', 'md_name', 'pd_id')
            ->where('pd_id', $request->id)
            ->get();


        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]->pd_jabatan_awal == 1) {
                $data[$i]->pd_jabatan_awal = 'Manager';
            } elseif ($data[$i]->pd_jabatan_awal == 2) {
                $data[$i]->pd_jabatan_awal = 'Supervisor';
            } elseif ($data[$i]->pd_jabatan_awal == 3) {
                $data[$i]->pd_jabatan_awal = 'Staff';
            } elseif ($data[$i]->pd_jabatan_awal == 4) {
                $data[$i]->pd_jabatan_awal = 'Operator';
            } elseif ($data[$i]->pd_jabatan_awal == 0) {
                $data[$i]->pd_jabatan_awal = '-';
            }

        }

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]->pd_jabatan_sekarang == 1) {
                $data[$i]->pd_jabatan_sekarang = 'Manager';
            } elseif ($data[$i]->pd_jabatan_sekarang == 2) {
                $data[$i]->pd_jabatan_sekarang = 'Supervisor';
            } elseif ($data[$i]->pd_jabatan_sekarang == 3) {
                $data[$i]->pd_jabatan_sekarang = 'Staff';
            } elseif ($data[$i]->pd_jabatan_sekarang == 4) {
                $data[$i]->pd_jabatan_sekarang = 'Operator';
            } elseif ($data[$i]->pd_jabatan_sekarang == 0) {
                $data[$i]->pd_jabatan_sekarang = '-';
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

    public function detail(Request $request)
    {
        $data = DB::table('d_promosi_demosi')
            ->join('d_pekerja', 'p_id', '=', 'pd_pekerja')
            ->join('d_mitra_pekerja', 'mp_pekerja', '=', 'pd_pekerja')
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'pd_jabatan_sekarang')
            ->leftJoin('d_mitra', 'm_id', '=', 'mp_mitra')
            ->leftJoin('d_mitra_divisi', function ($q) {
                $q->on('md_mitra', '=', 'mp_mitra');
                $q->on('md_id', '=', 'mp_divisi');
                $q->on('md_mitra', '=', 'm_id');
            })
            ->select('pd_no', 'p_name', 'p_nip', 'p_nip_mitra', 'm_name', 'md_name', 'pd_id', 'pd_note', 'pd_jabatan_awal', 'pd_jabatan_sekarang', 'pd_isapproved')
            ->where('pd_id', $request->id)
            ->get();

        $jabatanawal = DB::table('d_jabatan_pelamar')
            ->where('jp_id', $data[0]->pd_jabatan_awal)
            ->get();

        $jabatansekarang = DB::table('d_jabatan_pelamar')
            ->where('jp_id', $data[0]->pd_jabatan_sekarang)
            ->get();

        return response()->json([$data, $jabatanawal, $jabatansekarang]);
    }

    public function hapus(Request $request)
    {
      if (!AksesUser::checkAkses(8, 'delete')) {
          return redirect('not-authorized');
      }

        DB::beginTransaction();
        try {

            $pekerja = DB::table('d_promosi_demosi')
                ->select('pd_no')
                ->where('pd_id', $request->id)
                ->get();

            d_pekerja_mutation::where('pm_reff', $pekerja[0]->pd_no)
                ->where('pm_detail', 'Promosi')
                ->update([
                    'pm_note' => 'dihapus'
                ]);


            DB::table('d_promosi_demosi')
                ->where('pd_id', $request->id)
                ->delete();

            $count = DB::table('d_promosi_demosi')
                ->where('pd_isapproved', 'P')
                ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', 'Promosi')
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

    public function edit(Request $request)
    {
      if (!AksesUser::checkAkses(8, 'update')) {
          return redirect('not-authorized');
      }

        $data = DB::table('d_promosi_demosi')
            ->where('pd_id', $request->id)
            ->get();

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
      if (!AksesUser::checkAkses(8, 'update')) {
          return redirect('not-authorized');
      }

        DB::beginTransaction();
        try {
            DB::table('d_promosi_demosi')
                ->where('pd_id', $id)
                ->update([
                    'pd_jabatan_sekarang' => $request->jabatanBaru,
                    'pd_note' => $request->note
                ]);

            $pekerja = DB::table('d_promosi_demosi')
                ->select('pd_no', 'pd_pekerja')
                ->where('pd_id', $id)
                ->get();

            d_pekerja_mutation::where('pm_reff', $pekerja[0]->pd_no)
                ->where('pm_detail', 'Promosi')
                ->update([
                    'pm_note' => $request->note
                ]);

            d_pekerja::where('p_id', $pekerja[0]->pd_pekerja)
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

    public function print(Request $request)
    {
        $data = DB::table('d_pekerja')
            ->join('d_promosi_demosi', 'd_promosi_demosi.pd_pekerja', '=', 'd_pekerja.p_id')
            ->join('d_mitra_pekerja', function ($e) {
                $e->on('mp_pekerja', '=', 'p_id');
            })
            ->join('d_mitra', 'm_id', '=', 'mp_mitra')
            ->join('d_mitra_divisi', function ($q) {
                $q->on('md_mitra', '=', 'mp_mitra');
                $q->on('md_id', '=', 'mp_divisi');
                $q->on('md_mitra', '=', 'm_id');
            })
            ->select('pd_id', 'p_id', 'p_name', 'pd_jabatan_awal', 'pd_jabatan_sekarang', 'p_nip', 'p_nip_mitra', 'd_mitra.m_name', 'd_mitra_divisi.md_name', 'pd_no', 'p_address', 'm_name', 'md_name')
            ->where('pd_id', $request->id)
            ->get();

        $jabatan = DB::select("select pd_pekerja, jpa.jp_name as awal, jpm.jp_name as sekarang from d_promosi_demosi
      join d_jabatan_pelamar jpa on jpa.jp_id = pd_jabatan_awal
      join d_jabatan_pelamar jpm on jpm.jp_id = pd_jabatan_sekarang");

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->pd_jabatan_awal = $jabatan[$i]->awal;
            $data[$i]->pd_jabatan_sekarang = $jabatan[$i]->sekarang;
        }

        return view('promosi.print', compact('data'));
    }

}
