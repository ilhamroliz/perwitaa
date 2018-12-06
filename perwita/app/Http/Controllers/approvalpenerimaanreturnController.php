<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

use Session;

class approvalpenerimaanreturnController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_return_seragam_approval')
                  ->join('d_return_seragam_ganti', 'rsg_detailid', '=', 'rsa_return_ganti')
                  ->join('d_item', 'i_id', '=', 'rsg_item')
                  ->join('d_item_dt', function($e){
                    $e->on('id_item', '=', 'i_id')
                      ->on('id_detailid', '=', 'rsg_item_dt');
                  })
                  ->join('d_kategori', 'k_id', '=', 'i_kategori')
                  ->join('d_size', 's_id', '=', 'id_size')
                  ->join('d_return_seragam', 'rs_id', '=', 'rsa_return')
                  ->where('rsa_isapproved', 'P')
                  ->get();


      $count = DB::table('d_return_seragam_approval')
                    ->where('rsa_isapproved', 'P')
                    ->count();

            DB::table('d_notifikasi')
                  ->where('n_fitur', 'Penerimaan Return')
                  ->update([
                    'n_qty' => $count
                  ]);

      return view('approvalpenerimaanreturn.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

        $idreturn = DB::table('d_return_seragam_approval')
                        ->where('rsa_id', $request->id)
                        ->get();

        $return = DB::table('d_return_seragam')
                      ->join('d_return_seragam_dt', 'rs_id', '=', 'rsd_return')
                      ->join('d_return_seragam_ganti', function($e){
                        $e->on('rsg_return_seragam', '=', 'rsd_return')
                          ->on('rsg_detailid_return', '=', 'rsd_detailid');
                      })
                      ->where('rs_id', $idreturn[0]->rsa_return)
                      ->get();

        $cek = $return[0]->rsg_qty - $return[0]->rsg_barang_masuk;
        if ($cek < $idreturn[0]->rsa_qty) {
          return response()->json([
            'status' => 'tidak sesuai'
          ]);
        } else {
          DB::table('d_return_seragam_approval')
                ->where('rsa_id', $request->id)
                ->update([
                  'rsa_isapproved' => 'Y'
                ]);

          $comp = DB::table('d_return_seragam')
                  ->join('d_purchase', 'p_id', '=', 'rs_purchase')
                  ->where('rs_id', $idreturn[0]->rsa_return)
                  ->get();

          DB::table('d_return_seragam_ganti')
              ->where('rsg_return_seragam', $idreturn[0]->rsa_return)
              ->where('rsg_detailid', $idreturn[0]->rsa_return_ganti)
              ->update([
                'rsg_barang_masuk' => $return[0]->rsg_barang_masuk + $idreturn[0]->rsa_qty
              ]);

          $stock = DB::table('d_stock')
                  ->where('s_comp', $comp[0]->p_comp)
                  ->where('s_position', $comp[0]->p_comp)
                  ->where('s_item', $return[0]->rsg_item)
                  ->where('s_item_dt', $return[0]->rsg_item_dt)
                  ->get();

          DB::table('d_stock')
                  ->where('s_comp', $comp[0]->p_comp)
                  ->where('s_position', $comp[0]->p_comp)
                  ->where('s_item', $return[0]->rsg_item)
                  ->where('s_item_dt', $return[0]->rsg_item_dt)
                  ->update([
                    's_qty' => $stock[0]->s_qty + $idreturn[0]->rsa_qty
                  ]);

          $detailid = DB::table('d_stock_mutation')
                      ->where('sm_stock', $stock[0]->s_id)
                      ->max('sm_detailid');

          $hpp = DB::table('d_return_seragam_dt')
                  ->where('rsd_return', $idreturn[0]->rsa_return)
                  ->where('rsd_detailid', $return[0]->rsg_detailid_return)
                  ->select('rsd_hpp')
                  ->get();

          $nota = DB::table('d_return_seragam')
                  ->where('rs_id', $idreturn[0]->rsa_return)
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
                'sm_qty' => $idreturn[0]->rsa_return,
                'sm_use' => 0,
                'sm_hpp' => $hpp[0]->rsd_hpp,
                'sm_sell' => $hpp[0]->rsd_hpp,
                'sm_nota' => $nota[0]->rs_nota,
                'sm_delivery_order' => $idreturn[0]->rsa_nodo,
                'sm_petugas' => Session::get('mem')
              ]);
        }

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

    public function tolak(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_return_seragam_approval')
                ->where('rsa_id', $request->id)
                ->delete();

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

    public function setujuilist(Request $request){
      DB::beginTransaction();
      try {

        for ($i=0; $i < count($request->pilih); $i++) {
          $id = $request->pilih[$i];

          $idreturn = DB::table('d_return_seragam_approval')
                          ->where('rsa_id', $id)
                          ->get();

          $return = DB::table('d_return_seragam')
                        ->join('d_return_seragam_dt', 'rs_id', '=', 'rsd_return')
                        ->join('d_return_seragam_ganti', function($e){
                          $e->on('rsg_return_seragam', '=', 'rsd_return')
                            ->on('rsg_detailid_return', '=', 'rsd_detailid');
                        })
                        ->where('rs_id', $idreturn[0]->rsa_return)
                        ->get();

          $cek = $return[0]->rsg_qty - $return[0]->rsg_barang_masuk;
          if ($cek < $idreturn[0]->rsa_qty) {
            return response()->json([
              'status' => 'tidak sesuai'
            ]);
          } else {
            DB::table('d_return_seragam_approval')
                  ->where('rsa_id', $id)
                  ->update([
                    'rsa_isapproved' => 'Y'
                  ]);

            $comp = DB::table('d_return_seragam')
                    ->join('d_purchase', 'p_id', '=', 'rs_purchase')
                    ->where('rs_id', $idreturn[0]->rsa_return)
                    ->get();

            DB::table('d_return_seragam_ganti')
                ->where('rsg_return_seragam', $idreturn[0]->rsa_return)
                ->where('rsg_detailid', $idreturn[0]->rsa_return_ganti)
                ->update([
                  'rsg_barang_masuk' => $return[0]->rsg_barang_masuk + $idreturn[0]->rsa_qty
                ]);

            $stock = DB::table('d_stock')
                    ->where('s_comp', $comp[0]->p_comp)
                    ->where('s_position', $comp[0]->p_comp)
                    ->where('s_item', $return[0]->rsg_item)
                    ->where('s_item_dt', $return[0]->rsg_item_dt)
                    ->get();

            DB::table('d_stock')
                    ->where('s_comp', $comp[0]->p_comp)
                    ->where('s_position', $comp[0]->p_comp)
                    ->where('s_item', $return[0]->rsg_item)
                    ->where('s_item_dt', $return[0]->rsg_item_dt)
                    ->update([
                      's_qty' => $stock[0]->s_qty + $idreturn[0]->rsa_qty
                    ]);

            $detailid = DB::table('d_stock_mutation')
                        ->where('sm_stock', $stock[0]->s_id)
                        ->max('sm_detailid');

            $hpp = DB::table('d_return_seragam_dt')
                    ->where('rsd_return', $idreturn[0]->rsa_return)
                    ->where('rsd_detailid', $return[0]->rsg_detailid_return)
                    ->select('rsd_hpp')
                    ->get();

            $nota = DB::table('d_return_seragam')
                    ->where('rs_id', $idreturn[0]->rsa_return)
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
                  'sm_qty' => $idreturn[0]->rsa_return,
                  'sm_use' => 0,
                  'sm_hpp' => $hpp[0]->rsd_hpp,
                  'sm_sell' => $hpp[0]->rsd_hpp,
                  'sm_nota' => $nota[0]->rs_nota,
                  'sm_delivery_order' => $idreturn[0]->rsa_nodo,
                  'sm_petugas' => Session::get('mem')
                ]);
          }
        }

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

    public function tolaklist(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_return_seragam_approval')
            ->whereIn('rsa_id', $request->pilih)
            ->delete();

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
        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      }
    }

}
