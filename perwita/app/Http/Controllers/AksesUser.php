<?php
/**
 * Created by PhpStorm.
 * User: Ilham Rolis
 * Date: 30/08/2018
 * Time: 14:56
 */

namespace App\Http\Controllers;
use Auth;
use DB;

class AksesUser
{
    public static function checkAkses($a_id, $aksi)
    {
        $m_id = Auth::user()->m_id;
        $cek = null;
        if ($aksi == 'read'){
            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $m_id)
                ->where('ma_access', '=', $a_id)
                ->where('ma_read', '=', 'Y')
                ->get();
        } elseif ($aksi == 'insert'){
            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $m_id)
                ->where('ma_access', '=', $a_id)
                ->where('ma_insert', '=', 'Y')
                ->get();
        } elseif ($aksi == 'update'){
            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $m_id)
                ->where('ma_access', '=', $a_id)
                ->where('ma_update', '=', 'Y')
                ->get();
        } elseif ($aksi == 'delete'){
            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $m_id)
                ->where('ma_access', '=', $a_id)
                ->where('ma_delete', '=', 'Y')
                ->get();
        }

        if (count($cek) > 0){
            return true;
        } else {
            return false;
        }
    }

    public static function aksesSidebar()
    {
        $m_id = Auth::user()->m_id;
        $cek = DB::select("select ma_access, ma_read, a_name, a_order from d_mem_access join d_access on a_id = ma_access where ma_mem = '".$m_id."' group by a_parrent order by a_order");
        return $cek;
    }
}
