<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class rekeningController extends Controller
{
    public function index()
    {
        return view('rekening.index');
    }

    public function getData(Request $request)
    {
        $key = $request->term;
        $data = DB::table('d_pekerja')
            ->select('p_id', 'p_nip', 'p_nip_mitra', 'p_norek', 'p_name')
            ->where(function ($q) use ($key) {
                $q->orWhere('p_nip', 'like', '%'.$key.'%');
                $q->orWhere('p_nip_mitra', 'like', '%'.$key.'%');
                $q->orWhere('p_name', 'like', '%'.$key.'%');
            })
            ->get();

        if ($data == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($data as $query) {
                $results[] = ['data' => $query, 'label' => $query->p_name.' ('.$query->p_nip.' | '.$query->p_nip_mitra.')'];
            }
        }

        return response()->json($results);
    }
}
