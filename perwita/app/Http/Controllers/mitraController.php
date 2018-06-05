<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\d_mitra;

use Yajra\Datatables\Datatables;

use Validator;

use DB;

class mitraController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        return view('mitra.index');
    } 
    public function data() {       
        DB::statement(DB::raw('set @rownum=0'));
        $mitra = d_mitra::select(DB::raw('@rownum  := @rownum  + 1 AS number'),'m_id','m_name','m_address','m_phone','m_fax'
                            ,'m_note')->orderBy('m_name')->get();
        return Datatables::of($mitra)
                       ->addColumn('action', function ($mitra) {
                            return'<div class="text-center">
                            <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="data-mitra/' . $mitra->m_id .'/edit" ><i class="glyphicon glyphicon-edit"></i></a>
                    <button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus('.$mitra->m_id.')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                        })
                        ->make(true);
    }

    public function tambah() {
        return view('mitra.formTambah');
    }
    public function simpan(Request $request) {
      return DB::transaction(function() use ($request) {
           $rules = [
                'Nama_Mitra' => 'required',
                'Alamat' => 'required',
                'No_Telp' => 'required|numeric',
                'Fax' => 'required',
                'Keterangan' => 'required',               
            ];
      $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                        'status' => 'gagal',
                        'data' => $validator->errors()->toArray()
            ]);
        }
          
      $id=d_mitra::max('m_id')+1;
      d_mitra::create([          
        "m_id"=>$id,
        "m_name"=>$request->Nama_Mitra,
        "m_address"=>$request->Alamat,
        "m_phone"=>$request->No_Telp,
        "m_fax"=>$request->Fax,
        "m_note"=>$request->Keterangan,      
      ]); 
      
       return response()->json([
                        'status' => 'berhasil',                        
            ]);
      
    });
    }
    public function edit($id) {        
        $mitra=d_mitra::where('m_id',$id)->first();        
        return view('mitra.formEdit',compact('mitra'));
    }
  
    public function hapus($id) {
        return DB::transaction(function() use ($id) {
            $cek = DB::table('d_mitra_contract')
                ->select('mc_no')
                ->where('mc_mitra', '=', $id)
                ->get();
            if (count($cek) > 0){
                return response()->json([
                    'status' => 'gagal'
                ]);
            }
            $mitra=d_mitra::where('m_id',$id);
            if($mitra->delete()){
                   return response()->json([
                        'status' => 'berhasil',                        
                    ]);
            }
        });        
    }

    public function perbarui(Request $request)
    {
        $data = array(
            'm_name' => $request->Nama_Mitra,
            'm_address' => $request->Alamat,
            'm_phone' => $request->No_Telp,
            'm_fax' => $request->Fax,
            'm_note' => $request->Keterangan
        );
        d_mitra::where('m_id', '=', $request->m_id)->update($data);
        return response()->json([
            'status' => 'berhasil'
        ]);
    }

}
