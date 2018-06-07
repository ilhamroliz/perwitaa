<?php

namespace App\Http\Controllers;

use App\d_pekerja_mutation;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\d_mitra_pekerja;
use Response;
use App\d_pekerja;
use App\surat;
use Illuminate\Support\Facades\Session;
use Redirect;
use App\d_mitra_contract;

use Yajra\Datatables\Datatables;
use App\Http\Controllers\mitraContractController;
use App\Http\Controllers\pdmController;

use Validator;
use Carbon\carbon;

use DB;

class mitraPekerjaController extends Controller
{

    public function index()
    {
        return view('mitra-pekerja.index');

    }

    public function cari()
    {
        return view('mitra-pekerja.cari');

    }

    public function pencarian(Request $request)
    {
        $kondisi = $request->term;

        $data = DB::table('d_mitra_contract')
            ->leftJoin('d_mitra', 'mc_mitra', '=', 'm_id')
            ->select('mc_no', 'm_name', DB::raw('(mc_need - mc_fulfilled) as sisa'), 'mc_date', 'mc_expired', 'mc_contractid')
            ->where(function ($q) use ($kondisi){
                $q->orWhere('m_name', 'like', '%' . $kondisi . '%')
                    ->orWhere('mc_no', 'like', '%' . $kondisi . '%');
            })
            ->take(50)
            ->get();

        if ($data == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($data as $query) {
                $results[] = ['id' => $query->mc_contractid, 'label' => $query->mc_no . ' (' . $query->m_name . ' Sisa ' . $query->sisa. ')'];
            }
        }

        return Response::json($results);
    }

    public function getDataPencarian(Request $request)
    {
        $id = $request->id;
        $info = DB::table('d_mitra_contract')
            ->join('d_mitra', 'd_mitra.m_id', '=', 'd_mitra_contract.mc_mitra')
            ->join('d_comp', 'd_comp.c_id', '=', 'd_mitra_contract.mc_comp')
            ->join('d_mitra_divisi', function ($q) {
                $q->on('d_mitra_contract.mc_divisi', '=', 'd_mitra_divisi.md_id')
                    ->on('d_mitra_contract.mc_mitra', '=', 'd_mitra_divisi.md_mitra');
            })
            ->select('d_mitra_contract.mc_mitra'
                , 'd_mitra_contract.mc_contractid'
                , 'd_mitra_contract.mc_no'
                , 'd_mitra_contract.mc_divisi'
                , 'd_mitra_divisi.md_name'
                , DB::raw('STR_TO_DATE(mc_date, )')
                , 'd_mitra_contract.mc_expired'
                , 'd_mitra_contract.mc_need'
                , 'd_mitra_contract.mc_fulfilled'
                , 'd_mitra_divisi.md_id'
                , 'd_mitra.m_name'
                , 'd_comp.c_name'
            )
            ->where('mc_contractid', '=', $id)
            ->groupBy('mc_no')
            ->orderBy('d_mitra_contract.mc_date', 'DESC')
            ->get();

        return Response::json($info);
    }

    public function data()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $mc = DB::table('d_mitra_contract')
            ->join('d_mitra', 'd_mitra.m_id', '=', 'd_mitra_contract.mc_mitra')
            ->join('d_comp', 'd_comp.c_id', '=', 'd_mitra_contract.mc_comp')
            ->join('d_mitra_divisi', function ($q) {
                $q->on('d_mitra_contract.mc_divisi', '=', 'd_mitra_divisi.md_id')
                    ->on('d_mitra_contract.mc_mitra', '=', 'd_mitra_divisi.md_mitra');
            })
            ->join('d_mitra_pekerja', function ($join) {
                $join->on('d_mitra_pekerja.mp_contract', '=', 'd_mitra_contract.mc_contractid');
                $join->on('d_mitra_pekerja.mp_mitra', '=', 'd_mitra_contract.mc_mitra');
                $join->on('d_mitra_pekerja.mp_comp', '=', 'd_mitra_contract.mc_comp');
            })
            ->select('d_mitra_contract.mc_mitra'
                , 'd_mitra_contract.mc_contractid'
                , 'd_mitra_contract.mc_no'
                , 'd_mitra_contract.mc_divisi'
                , 'd_mitra_divisi.md_name'
                , 'd_mitra_contract.mc_date'
                , 'd_mitra_contract.mc_expired'
                , 'd_mitra_contract.mc_need'
                , 'd_mitra_contract.mc_fulfilled'
                , 'd_mitra_divisi.md_id'
                , 'd_mitra.m_name'
                , 'd_comp.c_name',
                DB::raw('@rownum  := @rownum  + 1 AS number')
            )
            ->groupBy('mc_no')
            ->orderBy('d_mitra_contract.mc_date', 'DESC')
            ->get();
        $mc = collect($mc);

        return Datatables::of($mc)
            ->editColumn('mc_date', function ($mc) {
                return $mc->mc_date ? with(new Carbon($mc->mc_date))->format('d-m-Y') : '';

            })
            ->editColumn('mc_expired', function ($mc) {
                return $mc->mc_expired ? with(new Carbon($mc->mc_expired))->format('d-m-Y') : '';

            })
            ->addColumn('action', function ($mc) {
                return '<div class="btn-group">
                            <a href="data-pekerja-mitra/' . $mc->mc_mitra . '/' . $mc->mc_contractid . '/edit" ><button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></button></a>
                            <a class="btn-delete" onclick="hapus(' . $mc->mc_mitra . ',' . $mc->mc_contractid . ')"><button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button></a>
                            </div>';
            })
            ->make(true);

    }

    public function tambah()
    {

        $mitra_contract = d_mitra_contract::where('mc_fulfilled', '<', DB::raw('mc_need'))->get();
        $pekerja = d_pekerja::leftJoin('d_mitra_pekerja', 'd_pekerja.p_id', '=', 'd_mitra_pekerja.mp_pekerja')
            ->where('mp_pekerja', '=', null)
            ->get();
        $update_mitra_contract = DB::table('d_mitra_contract')->get();
        return view('mitra-pekerja.formTambah', compact('pekerja1', 'update_mitra_contract', 'pekerja', 'mitra_contract'));
    }

    public function lanjutkan(Request $request)
    {
        $mc_contractid = $request->mc_contractid;
        $no_kontrak = $request->kontrak;
        $seleksi = $request->mp_selection_date;
        $kerja = $request->mp_workin_date;

        $pekerja = DB::table('d_pekerja')
            ->select('p_name', 'p_ktp', 'p_sex', 'p_hp', 'p_id')
            ->whereIn('p_id', $request->pilih)
            ->get();

        $info = DB::table('d_mitra_contract')
            ->leftJoin('d_mitra', 'mc_mitra', '=', 'm_id')
            ->leftJoin('d_mitra_divisi', function ($q) {
                $q->on('mc_divisi', '=', 'md_id')
                    ->on('mc_mitra', '=', 'md_mitra');
            })
            ->select('m_name', 'md_name', 'mc_contractid', 'mc_no', 'mc_need', 'mc_fulfilled')
            ->where('mc_contractid', '=', $mc_contractid)
            ->where('md_id', DB::raw('mc_divisi'))
            ->get();

        return view('mitra-pekerja.formLanjutan', compact('pekerja', 'info', 'seleksi', 'kerja'));
    }

    public function simpan(Request $request)
    {

        DB::beginTransaction();
        try {

            $id_pekerja = $request->id_pekerja;
            $no_kontrak = $request->no_kontrak;
            $nik_mitra = $request->nik_mitra;
            $id_kontrak = $request->id_kontrak;
            $tgl_kerja = $request->tgl_kerja;
            $tgl_seleksi = $request->tgl_seleksi;

            $cekSelected = count($request->id_pekerja);
            if ($cekSelected == 0) {
                return response()->json([
                    'status' => 'gagal',
                    'data' => 'Belum ada detail pekerja yang di masukkan.'
                ]);
            }

            if (count($id_pekerja) != count($nik_mitra)) {
                return response()->json([
                    'status' => 'gagal',
                    'data' => 'Belum ada detail pekerja yang di masukkan.'
                ]);
            }

            $info = DB::table('d_mitra_contract')
                ->select('mc_contractid', 'mc_no', 'mc_mitra', 'mc_divisi', 'mc_comp')
                ->where('mc_contractid', '=', $id_kontrak)
                ->get();

            $data = [];
            $mutasi = [];
            $id_mitra_pekerja = d_mitra_pekerja::max('mp_id');
            $id_mitra_pekerja = $id_mitra_pekerja + 1;
            for ($index = 0; $index < count($id_pekerja); $index++) {
                if ($nik_mitra[$index] != '' || $nik_mitra[$index] != null) {
                    $temp = array(
                        'mp_id' => $id_mitra_pekerja + $index,
                        'mp_comp' => $info[0]->mc_comp,
                        'mp_pekerja' => $id_pekerja[$index],
                        'mp_mitra' => $info[0]->mc_mitra,
                        'mp_divisi' => $info[0]->mc_divisi,
                        'mp_mitra_nik' => strtoupper($nik_mitra[$index]),
                        'mp_selection_date' => Carbon::createFromFormat('d/m/Y', $tgl_seleksi, 'Asia/Jakarta'),
                        'mp_workin_date' => Carbon::createFromFormat('d/m/Y', $tgl_kerja, 'Asia/Jakarta'),
                        'mp_contract' => $id_kontrak,
                        'mp_status' => 'Aktif'
                    );

                    $pm_detail = DB::table('d_pekerja_mutation')
                        ->where('pm_pekerja', '=', $id_pekerja[$index])
                        ->max('pm_detailid');
                    $tempMutasi = array(
                        'pm_pekerja' => $id_pekerja[$index],
                        'pm_detailid' => $pm_detail + 1,
                        'pm_date' => Carbon::now('Asia/Jakarta'),
                        'pm_mitra' => $info[0]->mc_mitra,
                        'pm_divisi' => $info[0]->mc_divisi,
                        'pm_detail' => 'Seleksi',
                        'pm_from' => null,
                        'pm_status' => 'Aktif'
                    );
                    array_push($mutasi, $tempMutasi);
                    array_push($data, $temp);
                } else {
                    return response()->json([
                        'status' => 'gagal',
                        'data' => 'Belum ada detail pekerja yang di masukkan.'
                    ]);
                }
            }
            d_pekerja::whereIn('p_id', $id_pekerja)->update(array('p_note' => 'Seleksi'));
            d_mitra_pekerja::insert($data);
            d_pekerja_mutation::insert($mutasi);
            d_mitra_contract::where('mc_contractid', $id_kontrak)->update([
                'mc_fulfilled' => DB::raw('mc_fulfilled + '. count($id_pekerja))

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

    public function edit($mitra, $kontrak)
    {

        $update_mitra_contract = DB::table('d_mitra_contract')
            ->join('d_mitra', 'd_mitra.m_id', '=', 'd_mitra_contract.mc_mitra')
            ->join('d_comp', 'd_comp.c_id', '=', 'd_mitra_contract.mc_comp')
            ->join('d_mitra_pekerja', 'd_mitra_contract.mc_contractid', '=', 'd_mitra_pekerja.mp_contract')
            ->join('d_mitra_divisi', 'd_mitra_contract.mc_divisi', '=', 'd_mitra_divisi.md_id')
            ->select('d_mitra_contract.mc_mitra'
                , 'd_mitra_contract.mc_contractid'
                , 'd_mitra_contract.mc_no'
                , 'd_mitra_contract.mc_date'
                , 'd_mitra_contract.mc_expired'
                , 'd_mitra_contract.mc_need'
                , 'd_mitra_contract.mc_fulfilled'
                , 'd_mitra_contract.mc_comp'
                , 'd_mitra.m_id'
                , 'd_mitra_divisi.md_id'
                , 'd_comp.c_id'
                , 'd_comp.c_name'
                , 'd_mitra_pekerja.mp_pekerja'
            )
            ->where('d_mitra_contract.mc_mitra', $mitra)
            ->where('d_mitra_contract.mc_contractid', $kontrak)
            ->first();

        $update_mitra_pekerja = d_mitra_pekerja::
        where('mp_comp', $update_mitra_contract->mc_comp)
            ->where('mp_mitra', $update_mitra_contract->mc_mitra)
            /*  ->where('mp_workin_date',$update_mitra_pekerja->mp_workin_date)
              ->where('mp_selection_date',$update_mitra_pekerja->mp_selection_date)*/
            ->where('mp_contract', $update_mitra_contract->mc_contractid)
            ->where('mp_contract', $update_mitra_contract->mc_status_mp)
            ->get();

        $pekerja = DB::table('d_pekerja')
            ->leftjoin('d_mitra_pekerja', 'd_mitra_pekerja.mp_pekerja', '=', 'd_pekerja.p_id')
            ->where('d_mitra_pekerja.mp_contract', '=', $update_mitra_contract->mc_contractid)
            ->where('d_mitra_pekerja.mp_mitra', '=', $update_mitra_contract->mc_mitra);

        $asw = DB::table('d_pekerja')
            ->leftjoin('d_mitra_pekerja', 'd_mitra_pekerja.mp_pekerja', '=', 'd_pekerja.p_id')
            ->where('mp_pekerja', '=', null);

        $anjp = $pekerja->union($asw)
            ->groupBy('p_name')
            ->get();

        /*  $mitra_contract=d_mitra_contract::get();*/

        $d_datedate = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'd_mitra_pekerja.mp_pekerja', '=', 'd_pekerja.p_id')
            ->where('mp_contract', '=', $kontrak)
            ->groupBy('mp_selection_date')
            ->orderby('mp_contract')
            ->get();
        //dd($anjp);
        return view('mitra-pekerja.formEdit', compact('mitra_contract', 'anjp', 'asw', 'a', 'd_datedate', 'd_mitra_pekerja', 'update_mitra_contract', 'update_mitra_pekerja', 'pekerja'));
    }

    public function perbarui(Request $request, $mitra, $mc_contractid)
    {

        for ($i = 0; $i < count($request->chek); $i++) {
            if ($request->chek[$i] == "") {

            } else {
                $anjp = DB::table('d_mitra_pekerja')->where('mp_pekerja', '=', $request->pekerja[$i])->delete();

            }
        }

        for ($a = 0; $a < count($request->chek); $a++) {
            if ($request->chek[$a] == "") {

                $anjp = DB::table('d_mitra_pekerja')
                    ->where('mp_pekerja', '=', $request->pekerja[$a])
                    ->delete();
            }

        }
        $a = new mitraContractController();
        $a->hapus($mitra, $mc_contractid);


        $b = new mitraContractController();
        $b->simpan($request);

        $this->simpan($request);
        return response()->json([
            'status' => 'berhasil',
        ]);


    }


    public function mitraContrak($mitra, $kontrak)
    {

        $mc = DB::table('d_mitra_contract')
            ->join('d_mitra', 'd_mitra.m_id', '=', 'd_mitra_contract.mc_mitra')
            ->join('d_comp', 'd_comp.c_id', '=', 'd_mitra_contract.mc_comp')
            ->join('d_mitra_divisi', function ($q) {
                $q->on('d_mitra_contract.mc_divisi', '=', 'd_mitra_divisi.md_id')
                    ->on('d_mitra_contract.mc_mitra', '=', 'd_mitra_divisi.md_mitra');
            })
            ->select('d_mitra_contract.mc_mitra'
                , 'd_mitra_contract.mc_contractid'
                , 'd_mitra_contract.mc_no'
                , 'd_mitra_contract.mc_divisi'
                , 'd_mitra_contract.mc_date'
                , 'd_mitra_contract.mc_expired'
                , 'd_mitra_contract.mc_need'
                , 'd_mitra_contract.mc_fulfilled'
                , 'd_mitra_contract.mc_comp'
                , 'd_mitra.m_name'
                , 'd_mitra_divisi.md_name'
                , 'd_comp.c_name'
            )
            ->where('d_mitra_contract.mc_mitra', $mitra)
            ->where('d_mitra_contract.mc_contractid', $kontrak)
            ->first();

        $mc->mc_date = date('d-F-Y', strtotime($mc->mc_date));
        $mc->mc_expired = date('d-F-Y', strtotime($mc->mc_expired));
        if ($mc->mc_no != '' || $mc->mc_no != null) {
            return response()->json([
                'status' => 'berhasil',
                'data' => $mc,
            ]);
        }
        if (count($mc) == 0) {
            return response()->json([
                'status' => 'berhasil',
                'data' => 'Data Kosong',
            ]);
        }


    }
    /* public function hapus($mp_pekerja){

       $osas = new pdmController();
             $osas->hapus($mp_pekerja);
     }*/
}

