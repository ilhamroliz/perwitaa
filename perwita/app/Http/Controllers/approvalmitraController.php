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
      $mitra = d_mitra::select(DB::raw('@rownum  := @rownum  + 1 AS number'),'d_mitra.*')->where('m_status_approval', '=', null)->get();
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
        if (count($pekerja) > 0) {
          $hitung += 1;
        }
        if (count($mitra) > 0) {
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
}
