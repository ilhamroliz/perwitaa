<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Http\Requests;

class RencanaPembelian extends Controller
{
    public function index()
    {
        return view('rencana-pembelian/index');
    }

    public function add()
    {
        return view('rencana-pembelian/create');
    }

    public function getNewNota()
    {
        //PP-001/14/12/2018
        $sekarang = Carbon::now('Asia/Jakarta');
        $tanggal = $sekarang->format('d');
        $bulan = $sekarang->format('m');
        $tahun = $sekarang->format('Y');
        $counter = DB::select("select max(mid(pp_nota,4,3)) as counter, (mid(pp_nota,8,2)) as tanggal, MAX(MID(pp_nota,10,2)) as bulan, (right(pp_nota,4)) as tahun from d_purchase_planning");
        $counter = $counter[0]->counter;

        $tmp = ((int)$counter)+1;
        $kode = sprintf("%03s", $tmp);
        $finalkode = 'PP-'.$kode.'/'.$tanggal.'/'.$bulan.'/'.$tahun;
        return $finalkode;
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try {

            $idItem = $request->id;
            $itemDt = $request->iddt;
            $qty = $request->qty;

            $id = DB::table('d_purchase_planning')
                ->max('pp_id');

            ++$id;

            DB::table('d_purchase_planning')
                ->insert([
                    'pp_id' => $id,
                    'pp_nota' => $this->getNewNota(),
                    'pp_date' => Carbon::now('Asia/Jakarta'),
                    'pp_status' => 'Belum',
                    'pp_isapproved' => 'P',
                    'pp_insert' => Carbon::now('Asia/Jakarta')
                ]);
            $tempPlan = [];
            for ($i = 0; $i < count($idItem); $i++){
                $temp = [
                    'ppd_purchase_planning' => $id,
                    'ppd_detailid' => $i + 1,
                    'ppd_item' => $idItem[$i],
                    'ppd_item_dt' => $itemDt[$i],
                    'ppd_qty' => $qty[$i]
                ];
                array_push($tempPlan, $temp);
            }

            DB::table('d_purchase_planning_dt')->insert($tempPlan);

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);

        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

}
