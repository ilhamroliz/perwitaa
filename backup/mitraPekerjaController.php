<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\d_mitra_pekerja;

use App\d_pekerja;

use App\d_mitra_contract;

use Yajra\Datatables\Datatables;

use Validator;

use Carbon\carbon;

use DB;

class mitraPekerjaController extends Controller
{

    public function index(){
      return view('mitra-pekerja.index');

    }

    public function data() {

//select * from d_mitra_contract join d_mitra_pekerja
//on d_mitra_pekerja.mp_contract=d_mitra_contract.mc_contractid
//and d_mitra_pekerja.mp_mitra=d_mitra_contract.mc_mitra
//and d_mitra_pekerja.mp_comp=d_mitra_contract.mc_comp
//join d_mitra on d_mitra.m_id=d_mitra_pekerja.mp_mitra
//join d_comp on d_comp.c_id=d_mitra_pekerja.mp_comp

        DB::statement(DB::raw('set @rownum=0'));
        $mc=DB::table('d_mitra_contract')
                   ->join('d_mitra','d_mitra.m_id','=','d_mitra_contract.mc_mitra')
                   ->join('d_comp','d_comp.c_id','=','d_mitra_contract.mc_comp')
                   ->join('d_mitra_pekerja', function($join)
                         {
                             $join->on('d_mitra_pekerja.mp_contract','=','d_mitra_contract.mc_contractid');
                             $join->on('d_mitra_pekerja.mp_mitra','=','d_mitra_contract.mc_mitra');
                             $join->on('d_mitra_pekerja.mp_comp','=','d_mitra_contract.mc_comp');
                         })
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
                   ->groupBy('mc_no')
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
                                                <li><a href="data-pekerja-mitra/' . $mc->mc_mitra .'/'.$mc->mc_contractid.'/edit" ><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a class="btn-delete" onclick="hapus('.$mc->mc_mitra.','.$mc->mc_contractid.')"></i>Hapus Data</a></li>
                                            </ul>
                                        </div>';
                        })
                        ->make(true);

    }

    public function tambah() {
        $mitra_contract=d_mitra_contract::where('mc_status_mp','0')->get();
        $pekerja=d_pekerja::where('p_isapproved', 'Y')->get();
        return view('mitra-pekerja.formTambah',compact('pekerja','mitra_contract')) ;
    }
    public function simpan(Request $request) {
        $rules = [
            "Kontrak" => 'required',
            //"Jumlah_Pekerja" => 'required|date',
            "totalPekerja" => "required",
        ];

      $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                        'status' => 'gagal',
                        'data' => $validator->errors()->toArray()
            ]);
        }
        $cekSelected=count($request->pilih);
        if($cekSelected==0){
            return response()->json([
                        'status' => 'gagal',
                        'data' => 'Belum ada detail pekerja yang di masukkan.'
            ]);
        }

        $totalPekerja=0;
        for ($index = 0; $index <count($request->chek) ; $index++) {



         if($request->chek[$index]=='1'){
        $id_mitra_pekerja=d_mitra_pekerja::max('mp_id');
                d_mitra_pekerja::create([
                 'mp_id'=>$id_mitra_pekerja+1,
                 'mp_comp'=>$request->perusahaan,
                 'mp_pekerja'=>$request->pekerja[$index],
                 'mp_mitra'=>$request->mitra,
                 'mp_contract'=>$request->Kontrak,
                 'mp_state'=>0
                ]);
                $totalPekerja++;
         }
        }
        $update_mitra_contract=d_mitra_contract::
                where('mc_mitra',$request->mitra)->
                where('mc_contractid',$request->Kontrak);
        $update_mitra_contract->update([
                'mc_status_mp'=>'1',
                'mc_fulfilled'=>$totalPekerja
        ]);

        $countmp = DB::table('d_mitra_pekerja')
            ->where('mp_isapproved', 'P')
            ->get();

        DB::table('d_notifikasi')
            ->where('n_fitur', 'Penerimaan Pekerja')
            ->update([
              'n_qty' => count($countmp),
              'n_insert' => Carbon::now()
            ]);

        return response()->json([
                            'status' => 'berhasil',
               ]);

    }

    public function edit($mitra,$kontrak) {

           $update_mitra_contract=DB::table('d_mitra_contract')
                   ->join('d_mitra','d_mitra.m_id','=','d_mitra_contract.mc_mitra')
                   ->join('d_comp','d_comp.c_id','=','d_mitra_contract.mc_comp')
                   ->select('d_mitra_contract.mc_mitra'
                           ,'d_mitra_contract.mc_contractid'
                           ,'d_mitra_contract.mc_no'
                           ,'d_mitra_contract.mc_date'
                           ,'d_mitra_contract.mc_expired'
                           ,'d_mitra_contract.mc_need'
                           ,'d_mitra_contract.mc_fulfilled'
                           ,'d_mitra_contract.mc_comp'
                           ,'d_mitra.m_name'
                           ,'d_comp.c_name'
                           )
                   ->where('d_mitra_contract.mc_mitra',$mitra)
                   ->where('d_mitra_contract.mc_contractid',$kontrak)
                   ->first();
            $update_mitra_pekerja=d_mitra_pekerja::
                                      where('mp_comp',$update_mitra_contract->mc_comp)
                                    ->where('mp_mitra',$update_mitra_contract->mc_mitra)
                                    ->where('mp_contract',$update_mitra_contract->mc_contractid)
                                    ->get();
              $pekerja=DB::table('d_pekerja')
                   ->leftjoin('d_mitra_pekerja',function($join) use ($update_mitra_contract){
                       $join->on('d_mitra_pekerja.mp_pekerja','=','d_pekerja.p_id')
                       ->where('d_mitra_pekerja.mp_comp','=','AA00000031')->
                       where('d_mitra_pekerja.mp_mitra','=',$update_mitra_contract->mc_mitra);
                    })->get();

               //dd($pekerja);
            return view('mitra-pekerja.formEdit',compact('update_mitra_contract','update_mitra_pekerja','pekerja'));
    }

    public function mitraContrak($mitra,$kontrak) {
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
                           ,'d_mitra_contract.mc_comp'
                           ,'d_mitra.m_name'
                           ,'d_comp.c_name'
                           )
                   ->where('d_mitra_contract.mc_mitra',$mitra)
                   ->where('d_mitra_contract.mc_contractid',$kontrak)
                   ->first();


          $mc->mc_date=date('d-F-Y', strtotime($mc->mc_date));
          $mc->mc_expired=date('d-F-Y', strtotime($mc->mc_expired));
          if(count($mc)!=0){
               return response()->json([
                            'status' => 'berhasil',
                            'data' => $mc,
               ]);
          }
          if(count($mc)==0){
               return response()->json([
                            'status' => 'berhasil',
                            'data' => 'Data Kosong',
               ]);
          }


    }

}
