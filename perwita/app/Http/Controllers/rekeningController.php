<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\AksesUser;

class rekeningController extends Controller
{
    public function index()
    {
      if (!AksesUser::checkAkses(56, 'read')) {
          return redirect('not-authorized');
      }

        return view('rekening.index');
    }

    public function getData(Request $request)
    {
        $key = $request->term;
        $data = DB::table('d_pekerja')
            ->select('p_id', 'p_nip', 'p_nip_mitra', DB::raw('coalesce(p_norek, "") as p_norek'), 'p_name')
            ->where(function ($q) use ($key) {
                $q->orWhere('p_nip', 'like', '%'.$key.'%');
                $q->orWhere('p_nip_mitra', 'like', '%'.$key.'%');
                $q->orWhere('p_name', 'like', '%'.$key.'%');
            })
            ->where('p_status_approval', '=', 'Y')
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

    public function save(Request $request)
    {
      if (!AksesUser::checkAkses(56, 'insert')) {
          return redirect('not-authorized');
      }
        $rekening = $request->norek;
        $id = $request->id;
        DB::beginTransaction();
        try{
            DB::table('d_pekerja')
                ->where('p_id', '=', $id)
                ->update([
                    'p_norek' => $rekening
                ]);
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }
}
