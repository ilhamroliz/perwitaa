<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

use Session;

class approvalreturnpembelianController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_return_seragam')
              ->join('d_purchase', 'p_id', '=', 'rs_purchase')
              ->join('d_supplier', 's_id', '=', 'p_supplier')
              ->where('rs_isapproved', 'P')
              ->get();

      $count =  DB::table('d_return_seragam')
            ->where('rs_isapproved', 'P')
            ->get();

      DB::table('d_notifikasi')
          ->where('n_fitur', 'Return Pembelian')
          ->update([
            'n_qty' => count($count)
          ]);

      return view('approvalreturnpembelian.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

        $return = DB::table('d_return_seragam_dt')
                ->join('d_return_seragam_ganti', 'rsg_return_seragam', '=', 'rsd_return')
                ->join('d_return_seragam', 'rs_id', '=', 'rsd_return')
                ->join('d_purchase', 'p_id', '=', 'rs_purchase')
                ->where('rsd_return', $request->id)
                ->where('rsd_action', 'barang')
                ->get();

        $ketersediaan = DB::table('d_stock_mutation')
                    ->where('sm_nota', $return[0]->p_nota)
                    ->where('sm_item', $return[0]->rsd_item)
                    ->where('sm_item_dt', $return[0]->rsd_itemdt)
                    ->select(DB::raw('SUM(sm_qty - sm_use) as sum'))
                    ->get();

      if ($return[0]->rsd_qty > $ketersediaan[0]->sum) {
          return response()->json([
            'status' => 'tidaksedia'
          ]);
      } else {
        DB::table('d_return_seragam')
          ->where('rs_id', $request->id)
          ->update([
            'rs_isapproved' => 'Y'
          ]);

        for ($i=0; $i < count($return); $i++) {

            $stock = DB::table('d_stock')
                  ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
                  ->select('d_stock.*', 'd_stock_mutation.*', DB::raw('(sm_qty - sm_use) as sm_sisa'))
                  ->where('sm_item', $return[$i]->rsd_item)
                  ->where('sm_item_dt', $return[$i]->rsd_itemdt)
                  ->where('s_comp', $return[$i]->p_comp)
                  ->where('sm_nota', $return[$i]->p_nota)
                  ->where(DB::raw('(sm_qty - sm_use)'), '>', 0)
                  ->get();

              $permintaan = $return[$i]->rsg_qty;

              DB::table('d_stock')
              ->where('s_id', $stock[$i]->sm_stock)
              ->where('s_item', $stock[$i]->sm_item)
              ->where('s_item_dt', $stock[$i]->sm_item_dt)
              ->update([
                's_qty' => $stock[$i]->s_qty - $permintaan
              ]);

          for ($j=0; $j < count($stock); $j++) {
            //Terdapat sisa permintaan

            $detailid = DB::table('d_stock_mutation')
                      ->max('sm_detailid');

             if ($permintaan > $stock[$j]->sm_sisa && $permintaan != 0) {

               DB::table('d_stock_mutation')
                  ->where('sm_stock', '=', $stock[$j]->sm_stock)
                  ->where('sm_detailid', '=', $stock[$j]->sm_detailid)
                  ->update([
                    'sm_use' => $stock[$j]->sm_qty
                  ]);

              $permintaan = $permintaan - $stock[$j]->sm_sisa;

                DB::table('d_stock_mutation')
                  ->insert([
                    'sm_stock' => $stock[$j]->sm_stock,
                    'sm_detailid' => $detailid + 1,
                    'sm_comp' => $stock[$j]->sm_comp,
                    'sm_date' => Carbon::now('Asia/Jakarta'),
                    'sm_item' => $stock[$i]->sm_item,
                    'sm_item_dt' => $stock[$i]->sm_item_dt,
                    'sm_detail' => 'Pengeluaran',
                    'sm_qty' => $stock[$j]->sm_sisa,
                    'sm_use' => 0,
                    'sm_hpp' => $stock[$j]->sm_hpp,
                    'sm_sell' => $stock[$j]->sm_sell,
                    'sm_nota' => $return[$i]->p_nota,
                    'sm_delivery_order' => $stock[$j]->sm_delivery_order,
                    'sm_petugas' => Session::get('mem')
                  ]);

             } elseif ($permintaan <= $stock[$j]->sm_sisa && $permintaan != 0) {
                //Langsung Eksekusi / Tidak terdapat sisa

                $detailid = DB::table('d_stock_mutation')
                          ->max('sm_detailid');

                DB::table('d_stock_mutation')
                   ->where('sm_stock', '=', $stock[$j]->sm_stock)
                   ->where('sm_detailid', '=', $stock[$j]->sm_detailid)
                   ->update([
                     'sm_use' => $permintaan + $stock[$j]->sm_use
                   ]);

                 DB::table('d_stock_mutation')
                   ->insert([
                     'sm_stock' => $stock[$j]->sm_stock,
                     'sm_detailid' => $detailid + 1,
                     'sm_comp' => $stock[$j]->sm_comp,
                     'sm_date' => Carbon::now('Asia/Jakarta'),
                     'sm_item' => $stock[$i]->sm_item,
                     'sm_item_dt' => $stock[$i]->sm_item_dt,
                     'sm_detail' => 'Pengeluaran',
                     'sm_qty' => $permintaan,
                     'sm_use' => 0,
                     'sm_hpp' => $stock[$j]->sm_hpp,
                     'sm_sell' => $stock[$j]->sm_sell,
                     'sm_nota' => $return[$i]->p_nota,
                     'sm_delivery_order' => $stock[$j]->sm_delivery_order,
                     'sm_petugas' => Session::get('mem')
                   ]);

                  $permintaan = 0;
                  $j = count($stock) + 1;
             }
          }
        }
      }

      $count =  DB::table('d_return_seragam')
            ->where('rs_isapproved', 'P')
            ->get();

      DB::table('d_notifikasi')
          ->where('n_fitur', 'Return Pembelian')
          ->update([
            'n_qty' => count($count)
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

        DB::table('d_return_seragam')
            ->where('rs_id', $request->id)
            ->update([
              'rs_isapproved' => 'N'
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

        DB::table('d_return_seragam')
            ->whereIn('rs_id', $request->pilih)
            ->update([
              'rs_isapproved' => 'N'
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

        for ($z=0; $z < count($request->pilih); $z++) {

          $id = $request->pilih[$z];

        $return = DB::table('d_return_seragam_dt')
                ->join('d_return_seragam_ganti', 'rsg_return_seragam', '=', 'rsd_return')
                ->join('d_return_seragam', 'rs_id', '=', 'rsd_return')
                ->join('d_purchase', 'p_id', '=', 'rs_purchase')
                ->where('rsd_return', $id)
                ->where('rsd_action', 'barang')
                ->get();

                $ketersediaan = DB::table('d_stock_mutation')
                            ->where('sm_nota', $return[0]->p_nota)
                            ->where('sm_item', $return[0]->rsd_item)
                            ->where('sm_item_dt', $return[0]->rsd_itemdt)
                            ->select(DB::raw('SUM(sm_qty - sm_use) as sum'))
                            ->get();

              if ($return[0]->rsd_qty > $ketersediaan[0]->sum) {
                return response()->json([
                  'status' => 'tidaksedia'
                ]);
              } else {
                DB::table('d_return_seragam')
                  ->where('rs_id', $id)
                  ->update([
                    'rs_isapproved' => 'Y'
                  ]);

                for ($i=0; $i < count($return); $i++) {

                    $stock = DB::table('d_stock')
                          ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
                          ->select('d_stock.*', 'd_stock_mutation.*', DB::raw('(sm_qty - sm_use) as sm_sisa'))
                          ->where('sm_item', $return[$i]->rsd_item)
                          ->where('sm_item_dt', $return[$i]->rsd_itemdt)
                          ->where('s_comp', $return[$i]->p_comp)
                          ->where('sm_nota', $return[$i]->p_nota)
                          ->where(DB::raw('(sm_qty - sm_use)'), '>', 0)
                          ->get();

                      $permintaan = $return[$i]->rsg_qty;

                      DB::table('d_stock')
                      ->where('s_id', $stock[$i]->sm_stock)
                      ->where('s_item', $stock[$i]->sm_item)
                      ->where('s_item_dt', $stock[$i]->sm_item_dt)
                      ->update([
                        's_qty' => $stock[$i]->s_qty - $permintaan
                      ]);

                  for ($j=0; $j < count($stock); $j++) {
                    //Terdapat sisa permintaan

                    $detailid = DB::table('d_stock_mutation')
                              ->max('sm_detailid');

                     if ($permintaan > $stock[$j]->sm_sisa && $permintaan != 0) {

                       DB::table('d_stock_mutation')
                          ->where('sm_stock', '=', $stock[$j]->sm_stock)
                          ->where('sm_detailid', '=', $stock[$j]->sm_detailid)
                          ->update([
                            'sm_use' => $stock[$j]->sm_qty
                          ]);

                      $permintaan = $permintaan - $stock[$j]->sm_sisa;

                        DB::table('d_stock_mutation')
                          ->insert([
                            'sm_stock' => $stock[$j]->sm_stock,
                            'sm_detailid' => $detailid + 1,
                            'sm_comp' => $stock[$j]->sm_comp,
                            'sm_date' => Carbon::now('Asia/Jakarta'),
                            'sm_item' => $stock[$i]->sm_item,
                            'sm_item_dt' => $stock[$i]->sm_item_dt,
                            'sm_detail' => 'Pengeluaran',
                            'sm_qty' => $stock[$j]->sm_sisa,
                            'sm_use' => 0,
                            'sm_hpp' => $stock[$j]->sm_hpp,
                            'sm_sell' => $stock[$j]->sm_sell,
                            'sm_nota' => $return[$i]->p_nota,
                            'sm_delivery_order' => $stock[$j]->sm_delivery_order,
                            'sm_petugas' => Session::get('mem')
                          ]);

                     } elseif ($permintaan <= $stock[$j]->sm_sisa && $permintaan != 0) {
                        //Langsung Eksekusi / Tidak terdapat sisa

                        $detailid = DB::table('d_stock_mutation')
                                  ->max('sm_detailid');

                        DB::table('d_stock_mutation')
                           ->where('sm_stock', '=', $stock[$j]->sm_stock)
                           ->where('sm_detailid', '=', $stock[$j]->sm_detailid)
                           ->update([
                             'sm_use' => $permintaan + $stock[$j]->sm_use
                           ]);

                         DB::table('d_stock_mutation')
                           ->insert([
                             'sm_stock' => $stock[$j]->sm_stock,
                             'sm_detailid' => $detailid + 1,
                             'sm_comp' => $stock[$j]->sm_comp,
                             'sm_date' => Carbon::now('Asia/Jakarta'),
                             'sm_item' => $stock[$i]->sm_item,
                             'sm_item_dt' => $stock[$i]->sm_item_dt,
                             'sm_detail' => 'Penjualan',
                             'sm_qty' => $permintaan,
                             'sm_use' => 0,
                             'sm_hpp' => $stock[$j]->sm_hpp,
                             'sm_sell' => $stock[$j]->sm_sell,
                             'sm_nota' => $return[$i]->p_nota,
                             'sm_delivery_order' => $stock[$j]->sm_delivery_order,
                             'sm_petugas' => Session::get('mem')
                           ]);

                          $permintaan = 0;
                          $j = count($stock) + 1;
                     }
                  }
                }
              }
            }

            $count =  DB::table('d_return_seragam')
                  ->where('rs_isapproved', 'P')
                  ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', 'Return Pembelian')
                ->update([
                  'n_qty' => count($count)
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
