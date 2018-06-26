<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use Yajra\Datatables\Datatables;

use App\d_mitra;

class approvalmitraController extends Controller
{
    public function index(){
      return view('approvalmitra.index');
    }

    public function data(){
      DB::statement(DB::raw('set @rownum=0'));
      $mitra = d_mitra::select(DB::raw('m_id as DT_RowId'),DB::raw('@rownum  := @rownum  + 1 AS number'),'d_mitra.*')->where('m_status_approval', '=', null)->get();
      return Datatables::of($mitra)
                     ->addColumn('action', function ($mitra) {
                          return'<div class="action">
                              <button type="button" onclick="detail('.$mitra->m_id.')" class="btn btn-info btn-sm" name="button"> <i class="glyphicon glyphicon-folder-open"></i> </button>
                              <button type="button" onclick="setujui('.$mitra->m_id.')" class="btn btn-primary btn-sm" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                              <button type="button" onclick="tolak('.$mitra->m_id.')"  class="btn btn-danger btn-sm" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
                          </div>';
                      })
                      ->make(true);
                      //dd($pekerja);
    }

    public function detail(Request $request){
      $id = $request->id;

      $data = DB::table('d_mitra')->selectRaw(
        "*,
        coalesce(m_name, '-') as m_name,
        coalesce(m_address, '-') as m_address,
        coalesce(m_cp, '-') as m_cp,
        coalesce(m_cp_phone, '-') as m_cp_phone,
        coalesce(m_phone, '-') as m_phone,
        coalesce(m_fax, '-') as m_fax,
        coalesce(m_note, '-') as m_note"
        )
      ->where('m_id', $id)->get();

      return response()->json([
        'm_name' => $data[0]->m_name,
        'm_address' => $data[0]->m_address,
        'm_cp' => $data[0]->m_cp,
        'm_cp_phone' => $data[0]->m_cp_phone,
        'm_phone' => $data[0]->m_phone,
        'm_fax' => $data[0]->m_fax,
        'm_note' => $data[0]->m_note
      ]);
    }

    public function cekapprovalmitra(){
      $pekerja = DB::select("select p_insert, count(p_id) as jumlah, 'Approval Pelamar' as catatan
                from d_pekerja
                where p_date_approval is null
                order by p_insert desc");

      $mitra = DB::select("select m_insert, count(m_id) as jumlah, 'Approval Mitra' as catatan
                from d_mitra
                where m_date_approval is null
                order by m_insert desc");

                $hitung = 0;
                if ($pekerja[0]->jumlah > 0) {
                  $hitung += 1;
                } 
                if ($mitra[0]->jumlah > 0) {
                  $hitung += 1;
                }

        Carbon::setLocale('id');
        $ago = Carbon::parse($mitra[0]->m_insert)->diffForHumans();

      return response()->json([
        'insert' => $ago,
        'jumlah' => $mitra[0]->jumlah,
        'catatan' => $mitra[0]->catatan,
        'notif' => $hitung
      ]);
    }

    public function setujui(Request $request){
      // dd($request->id);
      try {
        $d_mitra = d_mitra::where('m_id',$request->id)->where('m_status_approval', null);
        $d_mitra->update([
          'm_status_approval' => 'Y',
          'm_date_approval' => Carbon::now()
        ]);

        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        return response()->json([
          'status' => 'gagal'
        ]);
      }


    }

    public function tolak(Request $request){
      // dd($request);
      try {
        $d_mitra = d_mitra::where('m_id',$request->id)->where('m_status_approval', null);
        $d_mitra->update([
          'm_status_approval' => 'N',
          'm_date_approval' => Carbon::now()
        ]);

        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        return response()->json([
          'status' => 'gagal'
        ]);
      }


    }
}
