<?php

namespace App\Http\Controllers;

use App\d_purchase_dt;
use App\d_stock;
use App\d_stock_mutation;
use App\d_purchase_approval;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Response;

class PenerimaanController extends Controller
{
    public function index()
    {
        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->select('p_nota', 's_company')
            ->where('pd_receivetime', '=', null)
            ->where('p_isapproved', '=', 'Y')
            ->groupBy('p_nota')
            ->get();

        return view('penerimaan-pembelian.index', compact('data'));
    }

    public function cari(Request $request)
    {
        $nota = $request->nota;

        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->join('d_item', 'pd_item', '=', 'i_id')
            ->join('d_item_dt', function ($q) {
                $q->on('pd_item_dt', '=', 'id_detailid')
                    ->on('pd_item', '=', 'id_item');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->select('p_nota', 's_company', DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'pd_qty', 'pd_barang_masuk', DB::raw('(pd_qty - pd_barang_masuk) as sisa'), 'p_id', 'pd_detailid')
            ->where('p_nota', '=', $nota)
            ->get();

        return Response::json($data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $p_id = $request->id;
            $p_detailid = $request->dt;
            $qty = $request->sisa;
            $nodo = strtoupper($request->nodo);

            $info = DB::table('d_purchase_dt')
                ->select('pd_item', 'pd_item_dt')
                ->where('pd_purchase', '=', $p_id)
                ->where('pd_detailid', '=', $p_detailid)
                ->first();

            $item = $info->pd_item;
            $itemdt = $info->pd_item_dt;

            $idPa = DB::table('d_purchase_approval')
                ->where('pa_purchase', '=', $p_id)
                ->max('pa_detailid');

            ++$idPa;

            DB::table('d_purchase_approval')
                ->insert([
                    'pa_purchase' => $p_id,
                    'pa_detailid' => $idPa,
                    'pa_date' => Carbon::now('Asia/Jakarta'),
                    'pa_item' => $item,
                    'pa_item_dt' => $itemdt,
                    'pa_qty' => $qty,
                    'pa_do' => $nodo,
                    'pa_isapproved' => 'P'
                ]);

            DB::table('d_notifikasi')
                ->where('n_fitur', '=', 'Penerimaan Seragam')
                ->where('n_detail', '=', 'Create')
                ->update([
                    'n_qty' => DB::raw('(n_qty + 1)'),
                    'n_insert' => Carbon::now('Asia/Jakarta')
                ]);

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            perwitaController::log('update Penerimaan Controller', $nodo);
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function approvePenerimaan($id, $dt, $qty, $nodo)
    {
        DB::beginTransaction();
        try {

            $getStockLama = DB::table('d_purchase_dt')
                ->select('pd_barang_masuk', 'pd_qty')
                ->where('pd_purchase', '=', $id)
                ->where('pd_detailid', '=', $dt)
                ->get();

            $updateBarang = $getStockLama[0]->pd_barang_masuk + $qty;
            $sekarang = Carbon::now('Asia/Jakarta');

            if ($updateBarang == $getStockLama[0]->pd_qty) {
                $data = array('pd_barang_masuk' => $updateBarang, 'pd_receivetime' => $sekarang);
                d_purchase_dt::where('pd_purchase', '=', $id)->where('pd_detailid', '=', $dt)->update($data);
            } else {
                $data = array('pd_barang_masuk' => $updateBarang);
                d_purchase_dt::where('pd_purchase', '=', $id)->where('pd_detailid', '=', $dt)->update($data);
            }

//========== cek id stock

            $comp = Session::get('mem_comp');
            $info = DB::table('d_purchase')
                ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
                ->select('pd_item', 'pd_item_dt', 'pd_qty', 'pd_total_net', 'p_nota')
                ->where('p_id', '=', $id)
                ->where('pd_detailid', '=', $dt)
                ->first();

            $idStok = DB::table('d_stock')
                ->select('s_id')
                ->where('s_comp', '=', $comp)
                ->where('s_item', '=', $info->pd_item)
                ->where('s_item_dt', '=', $info->pd_item_dt)
                ->where('s_position', '=', $comp)
                ->get();

            $hargaJual = DB::table('d_item_dt')
                ->select('id_price')
                ->where('id_item', '=', $info->pd_item)
                ->where('id_detailid', '=', $info->pd_item_dt)
                ->get();

//========== buat data stok baru
            if (count($idStok) < 1) {
                $idStok = DB::table('d_stock')
                    ->max('s_id');
                $idStok = $idStok + 1;

                $stock = array(
                    's_id' => $idStok,
                    's_comp' => $comp,
                    's_position' => $comp,
                    's_item' => $info->pd_item,
                    's_item_dt' => $info->pd_item_dt,
                    's_qty' => $qty,
                    's_insert' => $sekarang,
                    's_update' => $sekarang
                );

                d_stock::insert($stock);

                $mutasi = array(
                    'sm_stock' => $idStok,
                    'sm_detailid' => 1,
                    'sm_comp' => $comp,
                    'sm_date' => $sekarang,
                    'sm_item' => $info->pd_item,
                    'sm_item_dt' => $info->pd_item_dt,
                    'sm_detail' => 'Pembelian',
                    'sm_qty' => $qty,
                    'sm_use' => 0,
                    'sm_hpp' => $info->pd_total_net / $info->pd_qty,
                    'sm_sell' => $hargaJual[0]->id_price,
                    'sm_nota' => $info->p_nota,
                    'sm_delivery_order' => strtoupper($nodo),
                    'sm_petugas' => Session::get('mem')
                );

                d_stock_mutation::insert($mutasi);

//========== update qty jika data sudah ada
            } else {
                $idStok = $idStok[0]->s_id;

                $stock = DB::table('d_stock')
                    ->where('s_id', '=', $idStok)
                    ->first();

                $stockAkhir = $stock->s_qty + $qty;
                $update = array('s_qty' => $stockAkhir);

                d_stock::where('s_id', '=', $idStok)->update($update);
                $getSMdt = DB::table('d_stock_mutation')
                    ->where('sm_stock', '=', $idStok)
                    ->max('sm_detailid');
                $detailid = $getSMdt + 1;

                $mutasi = array(
                    'sm_stock' => $idStok,
                    'sm_detailid' => $detailid,
                    'sm_comp' => $comp,
                    'sm_date' => $sekarang,
                    'sm_item' => $info->pd_item,
                    'sm_item_dt' => $info->pd_item_dt,
                    'sm_detail' => 'Pembelian',
                    'sm_qty' => $qty,
                    'sm_use' => 0,
                    'sm_hpp' => $info->pd_total_net / $info->pd_qty,
                    'sm_sell' => $hargaJual[0]->id_price,
                    'sm_nota' => $info->p_nota,
                    'sm_delivery_order' => strtoupper($nodo),
                    'sm_petugas' => Session::get('mem')
                );

                d_stock_mutation::insert($mutasi);
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            perwitaController::log('approvePenerimaan', $nodo);
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function history()
    {
        return view('penerimaan-pembelian.history');
    }

    public function findHistory(Request $req) {
        $d_purchase_approval = new d_purchase_approval();
        $tgl_awal = $req->tgl_awal;
        $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
        $tgl_akhir = $req->tgl_akhir;
        $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
        $data = $d_purchase_approval->where('pa_isapproved', 'Y');

        if($tgl_awal != '' && $tgl_akhir != '') {
            $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
            $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));

            if($tgl_awal != $tgl_akhir) {
                $items = $data->whereBetween('pa_date', array($tgl_awal, $tgl_akhir));
            }
            else {
                $items = $data->where(DB::raw('DATE(pa_date)'), $tgl_awal);
            }
        }
        else {
            $now = date('Y-m-d');
            $items = $data->where(DB::raw('DATE(pa_date)'), $now);
        }

        $items = $items->orderBy('pa_date', 'DESC')->get();

        $params = '';
        $x = 0;
        foreach ($items as $item) {
            $purchase = $item->d_purchase;
            if($purchase != null ) {
                $purchase = $purchase->where('p_isapproved', 'Y')->first();
                if($purchase != null) {

                    $params .= $x > 0 ? ', ' : '';

                    $d_item = $item->d_item;
                    $d_item_dt = $item->d_item_dt;
                    $seragam = $d_item->i_nama . ' ' . $d_item->i_warna . ' size ' . $d_item_dt->d_size->s_nama;
                    $penerima = '';
                    if($item->d_stock_mutation != null) {
                        if($item->d_stock_mutation->d_mem != null) {
                            $penerima = $item->d_stock_mutation->d_mem->m_name;
                        }
                    }
                    $params .= "{\"pa_purchase\" : \"{$item->pa_purchase}\", \"pa_date\" : \"{$item->pa_date}\", \"pa_qty\" : {$item->pa_qty}, \"pa_do\" : \"{$item->pa_do}\", \"seragam\" : \"$seragam\", \"penerima\" : \"$penerima\" }";
                    $x++;
                }
            }

        }

        $result = "{\"data\" : [$params]}";
        return response($result, 200)->header('Content-Type', 'application/json');
    }

    public function cariHistory(Request $request)
    {
        $cari = $request->term;

        $data = DB::select("select s_company, p_nota, pd_receivetime from d_purchase inner join d_supplier on s_id = p_supplier inner join d_purchase_dt on pd_purchase = p_id where (s_company like '%".$cari."%' or p_nota like '%".$cari."%') and pd_receivetime is not null and p_id not in (select pd_purchase from d_purchase_dt where pd_receivetime is null) group by p_id limit 20");
        if ($data == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($data as $query) {
                $results[] = ['id' => $query->p_nota, 'label' => $query->p_nota . ' ('.$query->s_company.')' ];
            }
        }

        return Response::json($results);
    }

    public function detailHistory(Request $request)
    {
        $nota = $request->nota;
        $data = DB::table('d_stock_mutation')
            ->join('d_item', 'sm_item', '=', 'i_id')
            ->join('d_item_dt', function ($q){
                $q->on('i_id', '=', 'id_item');
                $q->on('sm_item_dt', '=', 'id_detailid');
            })
            ->join('d_size', 's_id', '=', 'id_size')
            ->join('d_mem', 'm_id', '=', 'sm_petugas')
            ->select('d_stock_mutation.*', DB::raw('date_format(sm_date, "%d/%m/%Y %H:%i") as sm_date'), DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'm_name')
            ->where('sm_nota', '=', $nota)
            ->get();

        return Response::json($data);
    }

    public function print()
    {
        $data = DB::table('d_stock_mutation')
            ->join('d_stock', 'd_stock.s_id', '=', 'sm_stock')
            ->join('d_item', 'i_id', '=', 'sm_item')
            ->join('d_item_dt', function ($e) {
                $e->on('id_item', '=', 'i_id');
                $e->on('id_detailid', '=', 'sm_item_dt');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->select('sm_date', 'sm_qty', 'sm_nota', 'sm_delivery_order', 'i_nama', 'i_warna', 'k_nama', 's_nama')
            ->get();

        // dd($data);
        return view('penerimaan-pembelian.print', compact('data'));
    }
}
