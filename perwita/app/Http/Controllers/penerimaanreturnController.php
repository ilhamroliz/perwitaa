<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

class penerimaanreturnController extends Controller
{
    public function index(){
      $data = DB::table('d_return_seragam')
              ->where('rs_isapproved', 'Y')
              ->get();

      return view('penerimaanreturn.index', compact('data'));
    }

    public function getnota(Request $request){
      $data = DB::table('d_return_seragam')
              ->join('d_purchase', 'p_id', '=', 'rs_purchase')
              ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
              ->join('d_return_seragam_ganti', 'rsg_return_seragam', '=', 'rs_id')
              ->join('d_item', 'i_id', '=', 'rsg_item')
              ->join('d_item_dt', function($e){
                $e->on('id_detailid', '=', 'rsg_item_dt')
                  ->on('id_item', '=', 'rsg_item');
              })
              ->join('d_kategori', 'k_id', '=', 'i_kategori')
              ->join('d_size', 'd_size.s_id', '=', 'id_size')
              ->where('rs_nota', $request->nota)
              ->select('rs_nota', 's_company', DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'rs_id', 'rsg_detailid', 'rsg_qty', 'rsg_barang_masuk', DB::raw('(rsg_qty - rsg_barang_masuk) as sisa'), 'rs_id', 'rsg_detailid', 'rsg_item', 'rsg_item_dt', 'rsg_detailid_return')
              ->get();

      return response()->json($data);
    }

    public function simpan(Request $request){
      DB::beginTransaction();
      try {

        $id = DB::table('d_return_seragam_approval')
                    ->max('rsa_id');

        if ($id == null) {
          $id = 1;
        } else {
          $id += 1;
        }

        DB::table('d_return_seragam_approval')
              ->insert([
                'rsa_return' => $request->id,
                'rsa_detail_return' => $request->rsgreturn,
                'rsa_return_ganti' => $request->dt,
                'rsa_id' => $id,
                'rsa_qty' => $request->sisa,
                'rsa_nodo' => $request->nodo,
                'rsa_isapproved' => 'P',
                'rsa_insert' => Carbon::now('Asia/Jakarta')
              ]);

        $count = DB::table('d_return_seragam_approval')
                      ->where('rsa_isapproved', 'P')
                      ->count();

        DB::table('d_notifikasi')
              ->where('n_fitur', 'Penerimaan Return')
              ->update([
                'n_qty' => $count
              ]);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }

    }
}
