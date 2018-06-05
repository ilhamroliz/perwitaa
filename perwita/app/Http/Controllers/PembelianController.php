<?php

namespace App\Http\Controllers;

use App\d_purchase;
use App\d_purchase_dt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Response;

class PembelianController extends Controller
{
    public function index()
    {

        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->select('*')
            ->take(20)
            ->groupBy('p_nota')
            ->get();

        return view('pembelian.index', compact('data'));
    }

    public function create()
    {

        $supplier = DB::table('d_supplier')
            ->select('s_id', 's_company')
            ->where('s_isactive', '=', 'Y')
            ->get();

        $angka = rand(10, 99);
        $tanggal = date('y/m/d/His');
        $nota = 'PO-' . $tanggal . '/'. $angka;

        return view('pembelian.create', compact('supplier', 'nota'));
    }

    public function getItem(Request $request)
    {
        $cari = $request->term;

        $data = DB::table('d_item')
            ->join('d_item_dt', 'id_item', '=', 'i_id')
            ->join('d_size', 's_id', '=', 'id_size')
            ->select('i_id', 'id_detailid', 'i_nama', 's_nama', 'id_price', 'i_warna', DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'))
            ->whereRaw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") like "%'.$cari.'%"')
            ->where('i_isactive', '=', 'Y')
            ->take(50)->get();

        if ($data == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($data as $query) {
                $results[] = ['id' => $query->i_id, 'label' => $query->nama, 'harga' => $query->id_price, 'warna' => $query->i_warna, 'i_nama' => $query->i_nama, 'ukuran' => $query->s_nama, 'detailid' => $query->id_detailid ];
            }
        }

        return Response::json($results);
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try {

            $id = DB::table('d_purchase')
                ->max('p_id');

            $id = $id + 1;
            $gross = 0;

            for ($i = 0; $i < count($request->qty); $i++){
                $qty = $request->qty[$i];
                $harga = str_replace(".", '', $request->harga[$i]);
                $gross = ($qty * $harga) + $gross;
            }
            $comp = Session::get('mem_comp');

            $data = array(
                'p_id' => $id,
                'p_comp' => $comp,
                'p_date' => Carbon::now('Asia/Jakarta'),
                'p_supplier' => $request->supplier,
                'p_nota' => $request->nota,
                'p_total_gross' => $gross,
                'p_disc_percent' => 0,
                'p_disc_value' => 0,
                'p_pajak' => 0,
                'p_total_net' => $gross,
                'p_jurnal' => '1234'
            );

            d_purchase::insert($data);

            $detailid = DB::table('d_purchase_dt')
                ->where('pd_purchase', '=', $id)
                ->max('pd_detailid');

            $detailid = $detailid + 1;
            $pd = [];

            for ($i = 0; $i < count($request->qty); $i++){
                $data_dt = array(
                    'pd_purchase' => $id,
                    'pd_detailid' => $detailid + $i,
                    'pd_comp' => $comp,
                    'pd_qty' => $request->qty[$i],
                    'pd_value' => str_replace(".", '', $request->harga[$i]),
                    'pd_item' => $request->id[$i],
                    'pd_item_dt' => $request->iddt[$i],
                    'pd_total_gross' => $request->qty[$i] * str_replace(".", '', $request->harga[$i]),
                    'pd_disc_percent' => 0,
                    'pd_disc_value' => $request->disc[$i],
                    'pd_total_net' => ($request->qty[$i] * str_replace(".", '', $request->harga[$i])) - str_replace(".", '', $request->disc[$i]),
                    'pd_barang_masuk' => 0,
                    'pd_receivetime' => null
                );
                array_push($pd, $data_dt);
            }
            d_purchase_dt::insert($pd);

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }

    }
}
