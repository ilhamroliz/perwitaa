<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\PenerimaanController;

use DB;

use Carbon\Carbon;

use App\Http\Controllers\AksesUser;

use Session;

class approvalpenerimaanseragamController extends Controller
{
    public function index()
    {

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

        $count = DB::table('d_purchase_approval')
            ->where('pa_isapproved', 'P')
            ->count();

        DB::table('d_notifikasi')
            ->where('n_fitur', 'Penerimaan Seragam')
            ->update([
                'n_qty' => $count
            ]);

        $data = DB::table('d_purchase_approval')
            ->join('d_item', 'i_id', '=', 'pa_item')
            ->join('d_item_dt', function($e){
              $e->on('id_item', '=', 'pa_item')
                ->on('id_detailid', '=', 'pa_item_dt');
            })
            ->join('d_size', 's_id', '=', 'id_size')
            ->join('d_mem', 'm_id', '=', 'pa_penerima')
            ->where('pa_isapproved', 'P')
            ->get();

        return view('approvalpenerimaanseragam.index', compact('data'));
    }

    public function setujui(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = DB::table('d_purchase_approval')
                ->where('pa_detailid', $request->id)
                ->where('pa_purchase', $request->purchase)
                ->get();

            $check = DB::table('d_purchase_dt')
                ->where('pd_purchase', $data[0]->pa_purchase)
                ->where('pd_comp', Session::get('mem_comp'))
                ->where('pd_item', $data[0]->pa_item)
                ->where('pd_item_dt', $data[0]->pa_item_dt)
                ->get();

            $sisa = (int)$check[0]->pd_qty - (int)$check[0]->pd_barang_masuk;
            if ($sisa < $data[0]->pa_qty) {
                return response()->json([
                    'status' => 'barang masuk tidak sesuai'
                ]);
            } else {
                DB::table('d_purchase_approval')
                    ->where('pa_detailid', $request->id)
                    ->update([
                        'pa_isapproved' => 'Y'
                    ]);

                $dt = DB::table('d_purchase_dt')
                    ->where('pd_purchase', $data[0]->pa_purchase)
                    ->where('pd_comp', Session::get('mem_comp'))
                    ->where('pd_item', $data[0]->pa_item)
                    ->where('pd_item_dt', $data[0]->pa_item_dt)
                    ->get();

                $penerimaan = new PenerimaanController;

                $penerimaan->approvePenerimaan($data[0]->pa_purchase, $dt[0]->pd_detailid, $data[0]->pa_qty, $data[0]->pa_do);
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

    public function setujuilist(Request $request)
    {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($request->pilih); $i++) {

                $data = DB::table('d_purchase_approval')
                    ->where('pa_detailid', $request->pilih[$i])
                    ->where('pa_purchase', $request->purchase[$i])
                    ->get();

                $check = DB::table('d_purchase_dt')
                    ->where('pd_purchase', $data[0]->pa_purchase)
                    ->where('pd_comp', Session::get('mem_comp'))
                    ->where('pd_item', $data[0]->pa_item)
                    ->where('pd_item_dt', $data[0]->pa_item_dt)
                    ->get();

                $sisa = (int)$check[0]->pd_qty - (int)$check[0]->pd_barang_masuk;
                if ($sisa < $data[0]->pa_qty) {
                    return response()->json([
                        'status' => 'barang masuk tidak sesuai'
                    ]);
                } else {
                    DB::table('d_purchase_approval')
                        ->where('pa_detailid', $request->pilih[$i])
                        ->update([
                            'pa_isapproved' => 'Y'
                        ]);

                    $dt = DB::table('d_purchase_dt')
                        ->where('pd_purchase', $data[0]->pa_purchase)
                        ->where('pd_comp', Session::get('mem_comp'))
                        ->where('pd_item', $data[0]->pa_item)
                        ->where('pd_item_dt', $data[0]->pa_item_dt)
                        ->get();

                    $penerimaan = new PenerimaanController;

                    $penerimaan->approvePenerimaan($data[0]->pa_purchase, $dt[0]->pd_detailid, $data[0]->pa_qty, $data[0]->pa_do);
                }
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

    public function tolak(Request $request)
    {
        DB::beginTransaction();
        try {

            DB::table('d_purchase_approval')
                ->where('pa_detailid', $request->id)
                ->where('pa_purchase', $request->purchase)
                ->update([
                    'pa_isapproved' => 'N'
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

    public function tolaklist(Request $request)
    {
        DB::beginTransaction();
        try {

            DB::table('d_purchase_approval')
                ->whereIn('pa_detailid', $request->pilih)
                ->whereIn('pa_purchase', $request->purchase)
                ->update([
                    'pa_isapproved' => 'N'
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

    public function detail(Request $request)
    {
        $id = $request->id;

        $data = DB::table('d_purchase_approval')
            ->where('pa_detailid', $id)
            ->where('pa_purchase', $request->purchase)
            ->get();

        $info = DB::table('d_purchase')
            ->join('d_purchase_dt', 'p_id', '=', 'pd_purchase')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->join('d_item_dt', function ($q) {
                $q->on('id_item', '=', 'i_id');
                $q->on('id_detailid', '=', 'pd_item_dt');
                $q->on('id_item', '=', 'pd_item');
            })
            ->join('d_size', 's_id', '=', 'id_size')
            ->select(DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'd_purchase.*', 'd_purchase_dt.*')
            ->where('p_id', '=', $data[0]->pa_purchase)
            ->get();

        return response()->json([
            'status' => 'sukses',
            'data' => $info
        ]);
    }
}
