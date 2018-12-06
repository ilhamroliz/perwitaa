<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

use App\Http\Controllers\AksesUser;

use Carbon\Carbon;

class approvalController extends Controller
{
    public function cekapproval()
    {
        if (!AksesUser::checkAkses(55, 'read')){
            return redirect('not-authorized');
        }

        Carbon::setLocale('id');

        $data = DB::table('d_notifikasi')
            ->select('n_fitur', 'n_qty', 'n_url', 'n_insert', DB::raw('n_id as count'))
            ->where('n_qty', '>', 0)
            ->get();


        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->n_insert = Carbon::parse($data[$i]->n_insert)->diffForHumans();
            $data[$i]->count = count($data);
        }

        if (empty($data)) {
            return response()->json([
                'status' => 'kosong'
            ]);
        } else {
            return response()->json($data);
        }
    }

}
