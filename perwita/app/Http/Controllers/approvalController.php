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
    Carbon::setLocale('id');
    $data = [];
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
        ->groupBy('p_id')
        ->get();

    $sp = DB::table('d_surat_pringatan')
        ->selectRaw('sp_insert, count(sp_id) as jumlah, "Approval SP" as catatan')
        ->where('sp_isapproved','P')
        ->get();

    $mitrapekerja = DB::table('d_mitra_pekerja')
        ->selectRaw('mp_insert, count(mp_id) as jumlah, "Approval Mitra Pekerja" as catatan')
        ->where('mp_isapproved','P')
        ->get();

    $promosi = DB::table('d_promosi_demosi')
        ->selectRaw('pd_insert, count(pd_id) as jumlah, "Approval Promosi & Demosi" as catatan')
        ->where('pd_isapproved','P')
        ->get();

    $remunerasi = DB::table('d_remunerasi')
        ->selectRaw('r_insert, count(r_id) as jumlah, "Approval Remunerasi" as catatan')
        ->where('r_isapproved','P')
        ->get();

      $countpembelian = count($pembelian);

      $hitung = 0;
      if (empty($pekerja)) {

      } else {
        if ($pekerja[0]->jumlah > 0) {
          $hitung += 1;
        }
        $pekerja[0]->p_insert = Carbon::parse($pekerja[0]->p_insert)->diffForHumans();
        $data[0] = $pekerja[0];
      }

      if (empty($mitra)) {

      } else {
        if ($mitra[0]->jumlah > 0) {
          $hitung += 1;
        }
        $mitra[0]->m_insert = Carbon::parse($mitra[0]->m_insert)->diffForHumans();
        $data[1] = $mitra[0];
      }

      if (empty($pembelian)) {
        $data[2] = $temp = array(
          'p_date' => '1 detik yang lalu',
          'jumlah' => 0,
          'catatan' => 'Approval Pembelian'
        );
      } else {
        if ($pembelian[0]->jumlah > 0) {
          $hitung += 1;
        }

        $pembelian[0]->p_date = Carbon::parse($pembelian[0]->p_date)->diffForHumans();
        $pembelian[0]->jumlah = $countpembelian;
        $data[2] = $pembelian[0];
      }

      if (empty($sp)) {
        $data[3] = $temp = array(
          'sp_insert' => '1 detik yang lalu',
          'jumlah' => 0,
          'catatan' => 'Approval SP'
        );
      } else {
        if ($sp[0]->jumlah > 0) {
          $hitung += 1;
        }

        $sp[0]->sp_insert = Carbon::parse($sp[0]->sp_insert)->diffForHumans();
        $data[3] = $sp[0];
      }

      if (empty($mitrapekerja)) {
        $data[4] = $temp = array(
          'sp_insert' => '1 detik yang lalu',
          'jumlah' => 0,
          'catatan' => 'Approval Mitra Pekerja'
        );
      } else {
        if ($mitrapekerja[0]->jumlah > 0) {
          $hitung += 1;
        }

        $mitrapekerja[0]->mp_insert = Carbon::parse($mitrapekerja[0]->mp_insert)->diffForHumans();
        $data[4] = $mitrapekerja[0];
      }

      if (empty($promosi)) {
        $data[5] = $temp = array(
          'pd_insert' => '1 detik yang lalu',
          'jumlah' => 0,
          'catatan' => 'Approval Approval Promosi & Demosi'
        );
      } else {
        if ($promosi[0]->jumlah > 0) {
          $hitung += 1;
        }

        $promosi[0]->pd_insert = Carbon::parse($promosi[0]->pd_insert)->diffForHumans();
        $data[5] = $promosi[0];
      }

      if (empty($remunerasi)) {
        $data[6] = $temp = array(
          'pd_insert' => '1 detik yang lalu',
          'jumlah' => 0,
          'catatan' => 'Approval Remunerasi'
        );
      } else {
        if ($remunerasi[0]->jumlah > 0) {
          $hitung += 1;
        }

        $remunerasi[0]->r_insert = Carbon::parse($remunerasi[0]->r_insert)->diffForHumans();
        $data[6] = $remunerasi[0];
      }



// dd($pembelian);
    return response()->json([
      'data' => $data
    ]);

  }
  //  dd($count);
  }
}
