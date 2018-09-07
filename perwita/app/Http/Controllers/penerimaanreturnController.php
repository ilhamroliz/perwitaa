<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

use Carbon\Carbon;

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

        $comp = DB::table('d_return_seragam')
                ->join('d_purchase', 'p_id', '=', 'rs_purchase')
                ->where('rs_id', $request->id)
                ->get();

        DB::table('d_return_seragam_ganti')
            ->where('rsg_return_seragam', $request->id)
            ->where('rsg_detailid', $request->dt)
            ->update([
              'rsg_barang_masuk' => $request->sisa
            ]);

        $stock = DB::table('d_stock')
                ->where('s_comp', $comp[0]->p_comp)
                ->where('s_position', $comp[0]->p_comp)
                ->where('s_item', $request->item)
                ->where('s_item_dt', $request->itemdt)
                ->get();

        DB::table('d_stock')
                ->where('s_comp', $comp[0]->p_comp)
                ->where('s_position', $comp[0]->p_comp)
                ->where('s_item', $request->item)
                ->where('s_item_dt', $request->itemdt)
                ->update([
                  's_qty' => $stock[0]->s_qty + $request->sisa
                ]);

        $detailid = DB::table('d_stock_mutation')
                    ->where('sm_stock', $stock[0]->s_id)
                    ->max('sm_detailid');

        $hpp = DB::table('d_return_seragam_dt')
                ->where('rsd_return', $request->id)
                ->where('rsd_detailid', $request->rsgreturn)
                ->select('rsd_hpp')
                ->get();

        $nota = DB::table('d_return_seragam')
                ->where('rs_id', $request->id)
                ->get();

        DB::table('d_stock_mutation')
            ->insert([
              'sm_stock' => $stock[0]->s_id,
              'sm_detailid' => $detailid + 1,
              'sm_comp' => $stock[0]->s_comp,
              'sm_date' => Carbon::now('Asia/Jakarta'),
              'sm_item' => $stock[0]->s_item,
              'sm_item_dt' => $stock[0]->s_item_dt,
              'sm_detail' => 'Pembelian',
              'sm_qty' => $request->sisa,
              'sm_use' => 0,
              'sm_hpp' => $hpp[0]->rsd_hpp,
              'sm_sell' => $hpp[0]->rsd_hpp,
              'sm_nota' => $nota[0]->rs_nota,
              'sm_delivery_order' => $request->nodo,
              'sm_petugas' => Session::get('mem')
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
