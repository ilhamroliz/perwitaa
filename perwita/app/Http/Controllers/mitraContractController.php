<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\d_jabatan;

use App\d_comp;

use App\d_mitra;

use App\d_mitra_contract;

use App\Http\Controllers\mitraPekerjaController;

use App\Http\Controllers\pdmController;

use Yajra\Datatables\Datatables;

use Validator;

use Carbon\carbon;

use DB;

class mitraContractController extends Controller
{
    public function index()
    {
        return view('mitra-contract.index');
    }

    public function data()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $mc = DB::table('d_mitra_contract')
            ->join('d_mitra', 'd_mitra.m_id', '=', 'd_mitra_contract.mc_mitra')
            ->join('d_jabatan_pelamar', 'jp_id', '=', 'd_mitra_contract.mc_jabatan')
            ->join('d_mitra_divisi', function ($q){
                $q->on('d_mitra_contract.mc_divisi', '=', 'd_mitra_divisi.md_id')
                    ->on('d_mitra_contract.mc_mitra', '=', 'd_mitra_divisi.md_mitra');
            })
            ->select('d_mitra_contract.mc_mitra', 'd_mitra_contract.mc_contractid', 'd_mitra_contract.mc_divisi', 'd_mitra_contract.mc_no'
                , 'd_mitra_divisi.md_name'
                , 'd_jabatan_pelamar.jp_name'
                , 'jp_id'
                , 'd_mitra_contract.mc_need'
                , 'd_mitra_contract.mc_fulfilled'
                , 'd_mitra.m_name',
                DB::raw('@rownum  := @rownum  + 1 AS number')
            )
            ->orderBy('d_mitra_contract.mc_insert', 'DESC')
            ->get();

        $mc = collect($mc);

        return Datatables::of($mc)

            ->addColumn('action', function ($mc) {
                return '<div class="text-center">
                    <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="data-kontrak-mitra/' . $mc->mc_mitra . '/' . $mc->mc_contractid . '/edit"><i class="glyphicon glyphicon-edit"></i></a>
                    <a style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus(' . $mc->mc_mitra . ',' . $mc->mc_contractid . ')"><i class="glyphicon glyphicon-trash"></i></a>
                  </div>';
            })
            ->make(true);
    }

    public function tambah()
    {
        $comp = d_comp::get();
        $mitra = d_mitra::get();
        $jabatan = DB::table('d_jabatan_pelamar')->get();
        $d_mitra_divisi = DB::table('d_mitra_divisi')
            ->groupBy('md_name')
            ->get();
        return view('mitra-contract.formTambah', compact('d_mitra_divisi', 'comp', 'mitra','jabatan'));
    }

    public function simpan(Request $request)
    {
        $request->Tanggal_Kontrak = Carbon::createFromFormat('d/m/Y', $request->Tanggal_Kontrak, 'Asia/Jakarta');
        $request->Batas_Kontrak = Carbon::createFromFormat('d/m/Y', $request->Batas_Kontrak, 'Asia/Jakarta');

        $mc_contractid = d_mitra_contract::where('mc_mitra', $request->mitra)->max('mc_contractid') + 1;
        d_mitra_contract::create([
            'mc_mitra' => $request->mitra,
            'mc_contractid' => $mc_contractid,
            'mc_divisi' => $request->divisi,
            'mc_comp' => $request->perusahaan,
            'mc_no' => $request->kontrak,
            'mc_date' => $request->Tanggal_Kontrak,
            'mc_expired' => $request->Batas_Kontrak,
            'mc_need' => $request->Jumlah_Pekerja,
            'mc_fulfilled' => $request->totalPekerja,
            'mc_jabatan' => $request->jabatan,
            'mc_jobdesk' => $request->jobdesk,
            'mc_note' => $request->note,

        ]);

        return response()->json([
            'status' => 'berhasil',
        ]);

    }

    public function edit($mitra, $mc_contractid)
    {
        return DB::transaction(function () use ($mitra, $mc_contractid) {
            $mitra_contract = d_mitra_contract::where('mc_mitra', $mitra)->where('mc_contractid', $mc_contractid)->first();
            $comp = d_comp::get();
            $mitra = d_mitra::get();
            $jabatan = DB::table('d_jabatan_pelamar')->get();
            $d_mitra_divisi = DB::table('d_mitra_divisi')->get();
            if ($mitra_contract != null || $mitra_contract != '') {
                return view('mitra-contract.formEdit', compact('d_mitra_divisi', 'mitra_contract', 'mitra', 'comp','jabatan'));
            }
            return response()->json([
                'status' => 'Data tidak di temukan',
            ]);
        });
    }

    public function perbarui(Request $request, $mitra, $id_detail)
    {
      //  dd($request);
        return DB::transaction(function () use ($request, $mitra, $id_detail) {
            $request->Tanggal_Kontrak = date('Y-m-d', strtotime($request->Tanggal_Kontrak));
            $request->Batas_Kontrak = date('Y-m-d', strtotime($request->Batas_Kontrak));

            $rules = [
                "Tanggal_Kontrak" => 'required|date',
                "Batas_Kontrak" => 'required|date',
                "kontrak" => "required",
                "perusahaan" => "required",
                "mitra" => "required",
                "Jumlah_Pekerja" => "required|numeric",
                "jabatan" => "required",
                "divisi" => "required",
                "jobdesk" => "required",
                "note" => "required",

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'gagal',
                    'data' => $validator->errors()->toArray()
                ]);
            }


            $mitra_contract = d_mitra_contract::where('mc_mitra', $mitra)->where('mc_contractid', $id_detail);
            if (count($mitra_contract->first()) != 0) {
                $mitra_contract->update([
                    'mc_divisi' => $request->divisi,
                    'mc_comp' => $request->perusahaan,
                    'mc_no' => $request->kontrak,
                    'mc_date' => $request->Tanggal_Kontrak,
                    'mc_expired' => $request->Batas_Kontrak,
                    'mc_need' => $request->Jumlah_Pekerja,
                    'mc_fulfilled' => $request->totalPekerja,
                    'mc_jabatan' => $request->jabatan,
                    'mc_jobdesk' => $request->jobdesk,
                    'mc_note' => $request->note,
                ]);

                return response()->json([
                    'status' => 'berhasil',
                ]);


            }
            return response()->json([
                'status' => 'Data tidak di temukan',
            ]);
        });
    }


    public function hapus($mitra, $mc_contractid)
    {
        /*  return DB::transaction(function() use ($mitra,$mc_contractid) {
              $mitra_contract=d_mitra_contract::where('mc_mitra',$mitra)
              ->where('mc_contractid',$mc_contractid);
              if($mitra_contract->delete()){
                     return response()->json([
                          'status' => 'berhasil',
                      ]);
              }
          });*/
        DB::beginTransaction();
        try {
            d_mitra_contract::where('mc_mitra', '=', $mitra)->where('mc_contractid', '=', $mc_contractid)
                ->delete();
            DB::commit();
            return response()->json([
                'status' => 'berhasil',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
            ]);
        }
    }

    public function GetDivisi(Request $request)
    {
        $mitra = $request->mitra;
        $data = DB::table('d_mitra_divisi')
            ->select('md_name', 'md_id')
            ->where('md_mitra', '=', $mitra)
            ->orderBy('md_name')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
