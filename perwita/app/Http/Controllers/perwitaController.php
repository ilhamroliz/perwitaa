<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use DB;
use Storage;

use App\Http\Controllers\AksesUser;

class perwitaController
{
    public static function getComp()
    {
        $m_id = Auth::user()->m_id;
        $data = DB::table('d_mem')
            ->join('d_mem_comp', 'd_mem_comp.mc_mem', '=', 'd_mem.m_id')
            ->select('mc_comp')
            ->where('m_id', '=', $m_id)
            ->first();

        if ($data->mc_comp == 'PWT0000001' || $data->mc_comp == 'PWT0000002' || $data->mc_comp == 'PWT0000003' || $data->mc_comp == 'PWT0000004'){
            $info = [];
            $info[0] = 'internal';
            $info[1] = $data->mc_comp;
            return $info;
        } else {
            $mitra = DB::table('d_mitra_comp')
                ->where('mc_comp', '=', $data->mc_comp)
                ->first();

            $info = [];
            $info[0] = 'mitra';
            $info[1] = $data->mc_comp;
            $info[2] = $mitra->mc_mitra;
            return $info;
        }
    }

    public static function log($fitur, $data)
    {
        $text = '{'.$fitur.' | '.$data.' | '.Carbon::now("Asia/Jakarta")->format("d/m/Y H:m:s").'}';
        Storage::append(asset('customLog/log.txt'), $text);
    }
}
