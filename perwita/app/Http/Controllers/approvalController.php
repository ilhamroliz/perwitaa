<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\carbon;

class approvalController extends Controller
{
  public function cekapproval(){
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
      $pekerja[0]->p_insert = Carbon::parse($pekerja[0]->p_insert)->diffForHumans();
      $mitra[0]->m_insert = Carbon::parse($mitra[0]->m_insert)->diffForHumans();
      $data = [];
      $data[0] = $pekerja[0];
      $data[1] = $mitra[0];
//dd($ago);
    return response()->json([
      'data' => $data
    ]);
  //  dd($count);
  }
}
