<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\d_comp;

use App\d_mitra;

use App\d_mitra_contract;

use Yajra\Datatables\Datatables;

use Validator;

use Carbon\carbon;

use DB;

class mitraContractController extends Controller
{
    public function index() {
        return view('mitra-contract.index');
    }
    public function cari(){
      return view('mitra-contract.cari');
    }
    public function data() {
        DB::statement(DB::raw('set @rownum=0'));
        $mc=DB::table('d_mitra_contract')
                   ->join('d_mitra','d_mitra.m_id','=','d_mitra_contract.mc_mitra')
                   ->join('d_comp','d_comp.c_id','=','d_mitra_contract.mc_comp')
                   ->select('d_mitra_contract.mc_mitra'
                           ,'d_mitra_contract.mc_contractid'
                           ,'d_mitra_contract.mc_no'
                           ,'d_mitra_contract.mc_date'
                           ,'d_mitra_contract.mc_expired'
                           ,'d_mitra_contract.mc_need'
                           ,'d_mitra_contract.mc_fulfilled'
                           ,'d_mitra.m_name'
                           ,'d_comp.c_name',
                           DB::raw('@rownum  := @rownum  + 1 AS number')
                           )
                   ->get();
        $mc=collect($mc);

        return Datatables::of($mc)
                ->editColumn('mc_date', function ($mc) {
                            return $mc->mc_date ? with(new Carbon($mc->mc_date))->format('d-F-Y') : '';

                    })
                ->editColumn('mc_expired', function ($mc) {
                            return $mc->mc_expired ? with(new Carbon($mc->mc_expired))->format('d-F-Y') : '';

                    })
                       ->addColumn('action', function ($mc) {
                            return' <div class="dropdown">
                                            <button class="btn btn-primary btn-flat btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                Kelola
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="data-kontrak-mitra/' . $mc->mc_mitra .'/'.$mc->mc_contractid.'/edit" ><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a class="btn-delete" onclick="hapus('.$mc->mc_mitra.','.$mc->mc_contractid.')"></i>Hapus Data</a></li>
                                            </ul>
                                        </div>';
                        })
                        ->make(true);
    }
    public function tambah(){
        $comp=d_comp::get();
        $mitra=d_mitra::get();
        return view('mitra-contract.formTambah',compact('comp','mitra'));
    }
    public function simpan(Request $request) {
        $request->Tanggal_Kontrak=date('Y-m-d', strtotime($request->Tanggal_Kontrak));
        $request->Batas_Kontrak=date('Y-m-d', strtotime($request->Batas_Kontrak));
          $rules = [
                "Tanggal_Kontrak" => 'required|date',
                "Batas_Kontrak" => 'required|date',
                "No_Kontrak" => "required",
                "perusahaan" => "required",
                "mitra" => "required",
                "Jumlah_Pekerja" => "required|numeric",
            ];

      $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                        'status' => 'gagal',
                        'data' => $validator->errors()->toArray()
            ]);
        }

        $mc_contractid=d_mitra_contract::where('mc_mitra',$request->mitra)->max('mc_contractid')+1;
        d_mitra_contract::create([
            'mc_mitra'      =>$request->mitra,
            'mc_contractid' =>$mc_contractid,
            'mc_comp'       =>$request->perusahaan,
            'mc_no'         =>$request->No_Kontrak,
            'mc_date'       =>$request->Tanggal_Kontrak,
            'mc_expired'    =>$request->Batas_Kontrak,
            'mc_need'       =>$request->Jumlah_Pekerja,
        ]);

        return response()->json([
                            'status' => 'berhasil',
               ]);

    }

    public function edit($mitra,$id_detail) {
           return DB::transaction(function() use ($mitra,$id_detail) {
            $mitra_contract=d_mitra_contract::where('mc_mitra',$mitra)->where('mc_contractid',$id_detail)->first();
            $comp=d_comp::get();
            $mitra=d_mitra::get();
            if(count($mitra_contract)!=0){
                return view('mitra-contract.formEdit',compact('mitra_contract','mitra','comp'));
            }
               return response()->json([
                        'status' => 'Data tidak di temukan',
                    ]);
        });
    }
    public function perbarui(Request $request,$mitra,$id_detail) {
           return DB::transaction(function() use ($request,$mitra,$id_detail) {
            $request->Tanggal_Kontrak=date('Y-m-d', strtotime($request->Tanggal_Kontrak));
            $request->Batas_Kontrak=date('Y-m-d', strtotime($request->Batas_Kontrak));

              $rules = [
                    "Tanggal_Kontrak" => 'required|date',
                    "Batas_Kontrak" => 'required|date',
                    "No_Kontrak" => "required",
                    "perusahaan" => "required",
                    "mitra" => "required",
                    "Jumlah_Pekerja" => "required|numeric",
                ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                            'status' => 'gagal',
                            'data' => $validator->errors()->toArray()
                ]);
            }


            $mitra_contract=d_mitra_contract::where('mc_mitra',$mitra)->where('mc_contractid',$id_detail);
            if(count($mitra_contract->first())!=0){
                $mitra_contract->update([
                    'mc_comp'       =>$request->perusahaan,
                    'mc_no'         =>$request->No_Kontrak,
                    'mc_date'       =>$request->Tanggal_Kontrak,
                    'mc_expired'    =>$request->Batas_Kontrak,
                    'mc_need'       =>$request->Jumlah_Pekerja,
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

    public function hapus($mitra,$id_detail) {
        return DB::transaction(function() use ($mitra,$id_detail) {
            $mitra_contract=d_mitra_contract::where('mc_mitra',$mitra)->where('mc_contractid',$id_detail);
            if($mitra_contract->delete()){
                   return response()->json([
                        'status' => 'berhasil',
                    ]);
            }
        });

    }

    public function nomou(){
      $data = DB::select(DB::raw("SELECT MAX(LEFT(mc_no,5)) as Kodemax From d_mitra_contract WHERE DATE_FORMAT(mc_insert, '%m/%Y') = DATE_FORMAT(CURRENT_DATE(), '%m/%Y')"));

    }
}
