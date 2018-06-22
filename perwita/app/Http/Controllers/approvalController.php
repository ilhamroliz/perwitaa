<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

class approvalController extends Controller
{
    public function cekapprovalpelamar(){
      $count = DB::select("select p_insert, count(p_id) as jumlah, 'Approval Pelamar' as catatan
from d_pekerja
where p_date_approval is null
order by p_insert desc");
$hitung = 0;
if (count($count) > 0) {
  $hitung += 1;
}

Carbon::setLocale('id');
$ago = Carbon::parse($count[0]->p_insert)->diffForHumans();
  //dd($ago);
      return response()->json([
        'insert' => $ago,
        'jumlah' => $count[0]->jumlah,
        'catatan' => $count[0]->catatan,
        'notif' => $hitung
      ]);
    //  dd($count);
    }
}
