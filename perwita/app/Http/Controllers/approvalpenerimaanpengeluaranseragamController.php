<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use Session;

use App\Http\Controllers\AksesUser;

use DB;

class approvalpenerimaanpengeluaranseragamController extends Controller
{
    public function index(){

      if (!AksesUser::checkAkses(55, 'read')){
          return redirect('not-authorized');
      }

      $data = DB::table('d_sales_received')
                ->join('d_sales', 's_id', '=', 'sr_sales')
                ->join('d_item', 'i_id', '=', 'sr_item')
                ->join('d_item_dt', function($e){
                  $e->on('id_item', '=', 'i_id')
                    ->on('id_detailid', '=', 'sr_item_dt');
                })
                ->join('d_kategori', 'k_id', '=', 'i_kategori')
                ->join('d_size', 'd_size.s_id', '=', 'id_size')
                ->join('d_mem', 'm_id', '=', 'sr_penerima')
                ->join('d_mitra', 'd_mitra.m_id', '=', 's_member')
                ->join('d_mitra_divisi', function($e){
                  $e->on('md_mitra', '=', 'd_mitra.m_id')
                    ->on('md_id', '=', 's_divisi');
                })
                ->where('sr_isapproved', 'P')
                ->get();

      $count = DB::table('d_sales_received')
                    ->where('sr_isapproved', 'P')
                    ->count();

      DB::table('d_notifikasi')
            ->where('n_fitur', 'Penerimaan Pengeluaran Seragam')
            ->update([
              'n_qty' => $count
            ]);

      return view('approvalpenerimaanpengeluaranseragam.index', compact('data'));
    }

    public function setujui(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_sales_received')
            ->where('sr_detailid', $request->id)
            ->update([
              'sr_isapproved' => 'Y'
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

        DB::table('d_sales_received')
            ->where('sr_detailid', $request->id)
            ->update([
              'sr_isapproved' => 'N'
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

        DB::table('d_sales_received')
            ->whereIn('sr_detailid', $request->pilih)
            ->update([
              'sr_isapproved' => 'Y'
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

        DB::table('d_sales_received')
            ->whereIn('sr_detailid', $request->pilih)
            ->update([
              'sr_isapproved' => 'N'
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
