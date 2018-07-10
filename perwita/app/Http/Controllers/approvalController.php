<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

use Carbon\Carbon;

class approvalController extends Controller
{
  public function cekapproval(){
    if (Session::get('jabatan') == 1 || Session::get('jabatan') == 6) {

    $pekerja = DB::select("select p_insert, count(p_id) as jumlah, 'Approval Pelamar' as catatan
              from d_pekerja
              where p_date_approval is null
              order by p_insert desc");

    $mitra = DB::select("select m_insert, count(m_id) as jumlah, 'Approval Mitra' as catatan
              from d_mitra
              where m_date_approval is null
              order by m_insert desc");

    $pembelian = DB::table('d_purchase')
        ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
        ->join('d_supplier', 's_id', '=', 'p_supplier')
        ->selectRaw('p_date, count(p_id) as jumlah, "Approval Pembelian" as catatan')
        ->where('pd_receivetime', null)
        ->where('p_isapproved', 'P')
        ->groupBy('p_nota')
        ->get();



      $hitung = 0;
      if ($pekerja[0]->jumlah > 0) {
        $hitung += 1;
      }
      if ($mitra[0]->jumlah > 0) {
        $hitung += 1;
      }
      if ($pembelian[0]->jumlah > 0) {
        $hitung += 1;
      }

      Carbon::setLocale('id');
      $pekerja[0]->p_insert = Carbon::parse($pekerja[0]->p_insert)->diffForHumans();
      $mitra[0]->m_insert = Carbon::parse($mitra[0]->m_insert)->diffForHumans();
      $pembelian[0]->p_date = Carbon::parse($pembelian[0]->p_date)->diffForHumans();
      $data = [];
      $data[0] = $pekerja[0];
      $data[1] = $mitra[0];
      $data[2] = $pembelian[0];
//dd($ago);
    return response()->json([
      'data' => $data
    ]);

  }
  //  dd($count);
  }
}
