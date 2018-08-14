<?php

namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Response;
use Carbon\Carbon;

class ReturnPembelianController extends Controller
{
    public function index()
    {
        return view('return-pembelian.index');
    }

    public function getData(Request $request)
    {
        $id = $request->id;

        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->join('d_item_dt', function ($q){
                $q
                    ->on('pd_item_dt', '=', 'id_detailid')
                    ->on('i_id', '=', 'id_item');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
            ->select(DB::raw('concat(pd_qty, " ", i_nama, " ", i_warna, " ", coalesce(d_size.s_nama, ""), " ") as nama'), 'pd_qty', DB::raw('cast(pd_value as int) as pd_value'), DB::raw('date_format(p_date, "%d/%m/%Y") as p_date'), 'd_supplier.s_company', 'p_nota', DB::raw('cast(p_total_net as int) as p_total_net'), 'p_id')
            ->where('p_id', '=', $id)
            ->get();

        return Response::json($data);
    }

    public function add(Request $request)
    {
        $nota = $request->nota;
        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->join('d_item_dt', function ($q){
                $q
                    ->on('pd_item_dt', '=', 'id_detailid')
                    ->on('i_id', '=', 'id_item');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
            ->select('i_id', 'id_detailid' ,DB::raw('concat(pd_qty, " ", i_nama, " ", i_warna, " ", coalesce(d_size.s_nama, ""), " ") as nama'), 'pd_qty', DB::raw('cast(pd_value as int) as pd_value'), DB::raw('date_format(p_date, "%d/%m/%Y") as p_date'), DB::raw('d_supplier.s_company as supplier'), 'p_nota', DB::raw('cast(p_total_net as int) as p_total_net'), 'p_id', 'pd_disc_value')
            ->where('p_nota', '=', $nota)
            ->get();

        return view('return-pembelian.create', compact('data'));
    }

    public function lanjut(Request $request)
    {
        $aksi = $request->aksi;
        $nota = $request->nota;
        $id_item = $request->id_item;
        $item_detail = $request->item_detail;
        $jumlah = $request->return;
        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->join('d_item_dt', function ($q){
                $q
                    ->on('pd_item_dt', '=', 'id_detailid')
                    ->on('i_id', '=', 'id_item');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
            ->select('i_id', 'id_detailid', DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(d_size.s_nama, ""), " ") as nama'), DB::raw('concat(i_nama, " ", i_warna, " ") as namaasli'), 'pd_qty', DB::raw('cast(pd_value as int) as pd_value'), DB::raw('date_format(p_date, "%d/%m/%Y") as p_date'), DB::raw('d_supplier.s_company as supplier'), 'p_nota', DB::raw('cast(p_total_net as int) as p_total_net'), 'p_id', 'pd_disc_value')
            ->where('p_nota', '=', $nota)
            ->get();

        for ($i = 0; $i < count($data); $i++){
            for ($j = 0; $j < count($aksi); $j++) {
                if ($id_item[$j] == $data[$i]->i_id && $data[$i]->id_detailid == $item_detail[$j]) {
                    $data[$i]->aksi = $aksi[$i];
                    $data[$i]->jumlah = $jumlah[$i];
                }
            }
        }

        return view('return-pembelian.lanjut', compact('data'));

    }

    public function caribarang(Request $request){
      $keyword = $request->term;

        $data = DB::table('d_item')
              ->join('d_item_dt', 'id_item', '=', 'i_id')
              ->join('d_kategori', 'k_id', '=', 'i_kategori')
              ->join('d_size', 's_id', '=', 'id_size')
              ->where('i_nama', 'Like', '%'.$keyword.'%')
              ->groupBy('i_id')
              ->get();

            if ($data == null) {
                $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
            } else {

                foreach ($data as $query) {
                    $results[] = ['id' => $query->i_id, 'label' => $query->i_nama . ' ' . $query->i_warna];
                }
            }

            return response()->json($results);

    }

    public function getbarang(Request $request){

        $data = DB::table('d_item')
              ->join('d_item_dt', 'id_item', '=', 'i_id')
              ->join('d_kategori', 'k_id', '=', 'i_kategori')
              ->join('d_size', 's_id', '=', 'id_size')
              ->select('s_nama', 's_id')
              ->where('i_id', $request->id)
              ->get();

        return response()->json($data);

    }

    public function simpanlanjut(Request $request){
      
      DB::beginTransaction();
      try {

        $id = DB::table('d_return_seragam')
            ->max('rs_id');

        if ($id == null) {
            $id = 0;
        }

        $querykode = DB::select(DB::raw("SELECT MAX(MID(rs_nota,8,3)) as counter, MAX(MID(rs_nota,12,2)) as tanggal, MAX(MID(rs_nota,15,2)) as bulan, MAX(MID(rs_nota,18)) as tahun FROM d_return_seragam"));

        if (count($querykode) > 0) {
          if ($querykode[0]->tanggal != date('d') || $querykode[0]->bulan != date('m') || $querykode[0]->tahun != date('Y')) {
              $kode = "001";
          } else {
            foreach($querykode as $k)
              {
                $tmp = ((int)$k->counter)+1;
                $kode = sprintf("%03s", $tmp);
              }
          }
        } else {
          $kode = "001";
        }

        $finalkode = 'Return-' . $kode . '/' . date('d') . '/' . date('m') . '/' . date('Y');

        DB::table('d_return_seragam')
            ->insert([
              'rs_id' => $id + 1,
              'rs_nota' => $finalkode,
              'rs_purchase' => $request->idpurchase,
              'rs_date' => Carbon::now('Asia/Jakarta'),
              'rs_isapproved' => 'P'
            ]);

        $rsdhpp = DB::table('d_purchase_dt')
                ->selectRaw("(pd_total_net / pd_qty) as hasil")
                ->where('pd_purchase', $request->idpurchase)
                ->whereIn('pd_item', $request->i_id)
                ->whereIn('pd_item_dt', $request->id_detailid)
                ->get();

        for ($i=0; $i < count($request->i_id); $i++) {

          $rsddetailid = DB::table('d_return_seragam_dt')
                      ->where('rsd_return', $id + 1)
                      ->max('rsd_detailid');

                      if ($rsddetailid == null) {
                        $rsddetailid = 0;
                      }

          DB::table('d_return_seragam_dt')
              ->insert([
                'rsd_return' => $id + 1,
                'rsd_detailid' => $rsddetailid + 1,
                'rsd_item' => $request->i_id[$i],
                'rsd_itemdt' => $request->id_detailid[$i],
                'rsd_hpp' => $rsdhpp[$i]->hasil,
                'rsd_action' => $request->aksi[$i],
                'rsd_note' => $request->keterangan_sejenis[$i]
              ]);

        }

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
