<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

use App\d_stock_mutation;

use Carbon\Carbon;

use App\d_stock;

use App\d_sales_dt;

class approvalpenjualanController extends Controller
{
    public function index(){

      $data = DB::table('d_sales')
            ->join('d_mitra', 'm_id', '=', 's_member')
            ->select('s_id', 's_date', 'm_name', 's_nota', 's_total_net')
            ->where('s_isapproved', 'P')
            ->get();

      $count = DB::table('d_sales')
          ->where('s_isapproved', 'P')
          ->get();

      DB::table('d_notifikasi')
        ->where('n_fitur', 'Penjualan')
        ->update([
          'n_qty' => count($count)
        ]);

      return view('approvalpenjualan.index', compact('data'));

    }

    public function detail(Request $request){
       $data = DB::table('d_sales')
            ->join('d_sales_dt', 'sd_sales', '=', 's_id')
            ->join('d_item', 'i_id', '=', 'sd_item')
            ->join('d_item_dt', function($e){
              $e->on('id_item', '=', 'i_id')
                ->on('id_detailid', '=', 'sd_item_dt');
            })
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->select('s_nama', 'k_nama', 'i_nama', 'i_warna', 'id_price', 's_total_net', 's_total_gross', 's_pajak', 's_total_gross', 's_nota', 'sd_qty', 'sd_value', 'sd_disc_value', 'sd_total_net')
            ->where('sd_sales', $request->id)
            ->get();

      return response()->json($data);
    }

    public function setujui(Request $request){

        $sales = DB::table('d_sales')
              ->join('d_sales_dt', 'sd_sales', '=', 's_id')
              ->where('s_id', $request->id)
              ->get();

        $stock = DB::table('d_stock')
                ->where('s_comp', $sales[0]->s_comp)
                ->where('s_position', $sales[0]->s_comp)
                ->get();


        $id = DB::table('d_stock_mutation')
            ->select('sm_stock', 'sm_delivery_order')
            ->where('sm_stock', $stock[0]->s_id)
            ->get();

        $idmax = DB::table('d_stock_mutation')
            ->where('sm_stock', $stock[0]->s_id)
            ->max('sm_detailid');

        $pembelian = DB::table('d_stock_mutation')
            ->where('sm_stock', $stock[0]->s_id)
            ->where('sm_detail', 'Pembelian')
            ->where('sm_comp', $sales[0]->s_comp)
            ->get();

          $idSales = DB::table('d_sales')
              ->max('s_id');
          $idSales = $idSales + 1;
          $detailSales = DB::table('d_sales_dt')
              ->where('sd_sales', '=', $idSales)
              ->max('sd_sales');
          $detailSales = $detailSales + 1;

          $temp_sisa['sisa'] = 0;

          if ($stock[0]->s_comp == $sales[0]->s_comp && $stock[0]->s_comp == $sales[0]->sd_comp && $stock[0]->s_position == $sales[0]->s_comp && $stock[0]->s_position == $sales[0]->sd_comp) {
            DB::table('d_stock')
                ->where('s_comp', $sales[0]->s_comp)
                ->where('s_position', $sales[0]->s_comp)
                ->update([
                  's_qty' => $stock[0]->s_qty - $sales[0]->sd_qty
                ]);
          }

          DB::table('d_sales')
            ->where('s_id', $request->id)
            ->update([
              's_isapproved' => 'Y'
            ]);

          for ($i=0; $i < count($pembelian); $i++) {
            $permintaan = $sales[0]->sd_qty;
            $updateuse = $pembelian[$i]->sm_use + $permintaan;
            $cekStock = $pembelian[$i]->sm_qty - $pembelian[$i]->sm_use;
            $sisaSmQty = $cekStock - $permintaan;

          if ($temp_sisa['sisa'] != 0){
            if ($sisaSmQty < $temp_sisa['sisa']){
                d_stock_mutation::where('sm_stock', '=', $pembelian[$i]->sm_stock)
                    ->where('sm_detailid', '=', $pembelian[$i]->sm_detailid)
                    ->update(array(
                        'sm_use' => $cekStock
                    ));
                $temp_sisa['sisa'] = $sisaSmQty * (-1);
            } else {
              d_stock_mutation::where('sm_stock', '=', $pembelian[$i]->sm_stock)
                  ->where('sm_detailid', '=', $pembelian[$i]->sm_detailid)
                  ->update(array(
                      'sm_use' => $updateuse
                  ));

              $detel = DB::table('d_stock_mutation')
                  ->where('sm_stock', '=', $pembelian[$i]->sm_stock)
                  ->max('sm_detailid');

              $sm_detil = $detel + 1;

              $data = array(
                  'sm_stock' => $pembelian[$i]->sm_stock,
                  'sm_detailid' => $sm_detil,
                  'sm_comp' => Session::get('mem_comp'),
                  'sm_date' => Carbon::now(),
                  'sm_item' => $sales[0]->sd_item,
                  'sm_item_dt' => $sales[0]->sd_item_dt,
                  'sm_detail' => 'Penjualan',
                  'sm_qty' => $sales[0]->sd_qty,
                  'sm_use' => '0',
                  'sm_hpp' => $pembelian[$i]->sm_hpp,
                  'sm_sell' => $pembelian[$i]->sm_sell,
                  'sm_nota' => $sales[0]->s_nota,
                  'sm_delivery_order' => $pembelian[$i]->sm_delivery_order,
                  'sm_petugas' => Session::get('mem')
              );

              d_stock_mutation::insert($data);

              $i = count($pembelian) + 1;
              $temp_sisa['sisa'] = 0;
          }
      } else {
        if ($sisaSmQty < 0){
            d_stock_mutation::where('sm_stock', '=', $pembelian[$i]->sm_stock)
                ->where('sm_detailid', '=', $pembelian[$i]->sm_detailid)
                ->update(array(
                    'sm_use' => $cekStock
                ));
            $temp_sisa['sisa'] = $sisaSmQty * (-1);
        }
        else {
            d_stock_mutation::where('sm_stock', '=', $pembelian[$i]->sm_stock)
                ->where('sm_detailid', '=', $pembelian[$i]->sm_detailid)
                ->update(array(
                    'sm_use' => $updateuse
                ));

            $detel = DB::table('d_stock_mutation')
                ->where('sm_stock', '=', $pembelian[$i]->sm_stock)
                ->max('sm_detailid');

            $sm_detil = $detel + 1;

            $data = array(
                'sm_stock' => $pembelian[$i]->sm_stock,
                'sm_detailid' => $sm_detil,
                'sm_comp' => Session::get('mem_comp'),
                'sm_date' => Carbon::now(),
                'sm_item' => $sales[0]->sd_item,
                'sm_item_dt' => $sales[0]->sd_item_dt,
                'sm_detail' => 'Penjualan',
                'sm_qty' => $sales[0]->sd_qty,
                'sm_use' => '0',
                'sm_hpp' => $pembelian[$i]->sm_hpp,
                'sm_sell' => $pembelian[$i]->sm_sell,
                'sm_nota' => $sales[0]->s_nota,
                'sm_delivery_order' => $pembelian[$i]->sm_delivery_order,
                'sm_petugas' => Session::get('mem')
            );

            d_stock_mutation::insert($data);

            $getQtyStock = DB::table('d_stock')
                ->select('s_qty')
                ->where('s_id', '=', $pembelian[$i]->sm_stock)
                ->max('s_qty');

            $updateQtyStock = $getQtyStock;

            d_stock::where('s_id', '=', $pembelian[$i]->sm_stock)->update(array(
                's_qty' => $updateQtyStock
            ));

            $salesdt = array(
                'sd_sales' => $idSales,
                'sd_detailid' => $detailSales,
                'sd_comp' => Session::get('mem_comp'),
                'sd_item' => $sales[0]->sd_item,
                'sd_item_dt' => $sales[0]->sd_item_dt,
                'sd_qty' => $sales[0]->sd_qty,
                'sd_value' => $sales[0]->sd_value,
                'sd_total_gross' => $sales[0]->sd_value * $sales[0]->sd_qty,
                'sd_disc_percent' => 0,
                'sd_disc_value' => 0,
                'sd_total_net' => $sales[0]->sd_value * $sales[0]->sd_qty,
                'sd_sell' => $pembelian[$i]->sm_sell,
                'sd_hpp' => $pembelian[$i]->sm_hpp
            );

            $detailSales = $detailSales + 1;

            d_sales_dt::insert($salesdt);

            $i = count($pembelian) + 1;
            $temp_sisa['sisa'] = 0;
        }
      }
    }

        $count = DB::table('d_sales')
            ->where('s_isapproved', 'P')
            ->get();

        DB::table('d_notifikasi')
          ->where('n_fitur', 'Penjualan')
          ->update([
            'n_qty' => count($count)
          ]);


        return response()->json([
          'status' => 'berhasil'
        ]);
  }

  public function tolak(Request $request){
    DB::beginTransaction();
    try {

      DB::table('d_sales')
        ->where('s_id', $request->id)
        ->update([
          's_isapproved' => 'N'
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

      DB::table('d_sales')
        ->whereIn('s_id', $request->pilih)
        ->update([
          's_isapproved' => 'N'
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
