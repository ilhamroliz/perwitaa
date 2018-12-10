<?php

namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Response;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\AksesUser;

class ReturnPembelianController extends Controller
{
    public function index()
    {
      if (!AksesUser::checkAkses(28, 'read')) {
          return redirect('not-authorized');
      }

      $data = DB::table('d_return_seragam')
              ->join('d_purchase', 'p_id', '=', 'rs_purchase')
              ->join('d_supplier', 's_id', '=', 'p_supplier')
              ->where('rs_isapproved', 'P')
              ->get();

      return view('return-pembelian.index', compact('data'));
    }

    public function tambah(){
      if (!AksesUser::checkAkses(28, 'insert')) {
          return redirect('not-authorized');
      }

      return view('return-pembelian.tambah');

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
            ->select('i_id', 'id_detailid' ,DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(d_size.s_nama, ""), " ") as nama'), 'pd_qty', DB::raw('cast(pd_value as int) as pd_value'), DB::raw('date_format(p_date, "%d/%m/%Y") as p_date'), DB::raw('d_supplier.s_company as supplier'), 'p_nota', DB::raw('cast(p_total_net as int) as p_total_net'), 'p_id', 'pd_disc_value')
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
      if (!AksesUser::checkAkses(28, 'insert')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        for ($z=0; $z < count($request->i_id); $z++) {
          $ketersediaan = DB::table('d_stock_mutation')
                      ->where('sm_nota', $request->nota)
                      ->where('sm_item', $request->i_id[$z])
                      ->where('sm_item_dt', $request->id_detailid[$z])
                      ->select(DB::raw('SUM(sm_qty - sm_use) as sum'))
                      ->get();
        }

        $qty = array_sum($request->qty);

        if ( $qty > $ketersediaan[0]->sum) {
          return response()->json([
            'status' => 'tidaksedia'
          ]);
        } else {
          for ($i=0; $i < count($request->harga); $i++) {
            $temp[$i] = str_replace('Rp. ', '', $request->harga[$i]);
            $temp1[$i] = str_replace('.', '', $temp[$i]);
            $harga[$i] = $temp1[$i];
          }

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

          $finalkode = 'RETURN-' . $kode . '/' . date('d') . '/' . date('m') . '/' . date('Y');

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
                      'rsd_note' => $request->keterangan_sejenis[$i],
                      'rsd_value' => $request->valueharga[$i],
                      'rsd_qty' => $request->returnd[$i]
                    ]);
        }

          $detailidreturn = DB::table('d_return_seragam_dt')
                        ->where('rsd_return', $id + 1)
                        ->where('rsd_action', 'barang')
                        ->get();

          $querykode = DB::select(DB::raw("SELECT MAX(MID(rsg_no,4,3)) as counter, MAX(MID(rsg_no,8,2)) as tanggal, MAX(MID(rsg_no,11,2)) as bulan, MAX(MID(rsg_no,14)) as tahun FROM d_return_seragam_ganti"));

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

          $finalkode = 'RG-' . $kode . '/' . date('d') . '/' . date('m') . '/' . date('Y');

          for ($i=0; $i < count($request->idtambahitem); $i++) {

            $detailidganti = DB::table('d_return_seragam_ganti')
                          ->where('rsg_return_seragam', $id + 1)
                          ->max('rsg_detailid');

            if ($detailidganti == null) {
              $detailidganti = 0;
            }

            $rsg_item_dt = DB::table('d_item_dt')
                        ->select('id_detailid')
                        ->where('id_item', $request->idtambahitem[$i])
                        ->where('id_size', $request->idsize[$i])
                        ->get();

            DB::table('d_return_seragam_ganti')
                ->insert([
                  'rsg_return_seragam' => $id + 1,
                  'rsg_detailid_return' => $detailidreturn[0]->rsd_detailid,
                  'rsg_detailid' => $detailidganti + 1,
                  'rsg_no' => $finalkode,
                  'rsg_item' => $request->idtambahitem[$i],
                  'rsg_item_dt' => $rsg_item_dt[0]->id_detailid,
                  'rsg_qty' => $request->qty[$i],
                  'rsg_insert' => Carbon::now('Asia/Jakarta'),
                  'rsg_value' => $harga[$i]
                ]);
          }

          $count = DB::table('d_return_seragam')
                  ->where('rs_isapproved', 'P')
                  ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Return Pembelian')
              ->update([
                'n_qty' => count($count)
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

    public function detail(Request $request){

      $uang = DB::table('d_return_seragam')
            ->join('d_return_seragam_dt', 'rsd_return', '=', 'rs_id')
            ->join('d_item', 'i_id', '=', 'rsd_item')
            ->join('d_item_dt', 'id_detailid', '=', 'rsd_itemdt')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->join('d_size', 's_id', '=', 'id_size')
            ->where('rs_id', $request->id)
            ->where('rsd_action', 'uang')
            ->groupBy('rs_id')
            ->get();

      $barang = DB::table('d_return_seragam')
            ->join('d_return_seragam_dt', 'rsd_return', '=', 'rs_id')
            ->join('d_return_seragam_ganti', 'rsg_return_seragam', '=', 'rs_id')
            ->join('d_item', 'i_id', '=', 'rsd_item')
            ->join('d_item_dt', 'id_detailid', '=', 'rsd_itemdt')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->join('d_size', 's_id', '=', 'id_size')
            ->where('rs_id', $request->id)
            ->where('rsd_action', 'barang')
            ->groupBy('rsd_detailid')
            ->get();

      $barangbaru = DB::table('d_return_seragam_ganti')
                  ->leftjoin('d_item', 'i_id', '=', 'rsg_item')
                  ->leftjoin('d_item_dt', 'id_detailid', '=', 'rsg_item_dt')
                  ->leftjoin('d_kategori', 'k_id', '=', 'i_kategori')
                  ->leftjoin('d_size', 's_id', '=', 'id_size')
                  ->where('rsg_return_seragam', $request->id)
                  ->groupBy('rsg_detailid')
                  ->get();

      return response()->json([
        'uang' => $uang,
        'barang' => $barang,
        'barangbaru' => $barangbaru
      ]);

    }

    public function hapus(Request $request){
      if (!AksesUser::checkAkses(28, 'delete')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {

        DB::table('d_return_seragam')
             ->where('rs_id', $request->id)
             ->delete();

         DB::table('d_return_seragam_dt')
              ->where('rsd_return', $request->id)
              ->delete();

        DB::table('d_return_seragam_ganti')
             ->where('rsg_return_seragam', $request->id)
             ->delete();

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

    public function edit(Request $request){
      if (!AksesUser::checkAkses(28, 'update')) {
          return redirect('not-authorized');
      }
      $uang = DB::table('d_return_seragam')
            ->join('d_return_seragam_dt', 'rsd_return', '=', 'rs_id')
            ->join('d_purchase', 'p_id', '=', 'rs_purchase')
            ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
            ->join('d_item', 'i_id', '=', 'rsd_item')
            ->join('d_item_dt', 'id_detailid', '=', 'rsd_itemdt')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->where('rs_id', $request->id)
            ->where('rsd_action', 'uang')
            ->groupBy('rs_id')
            ->get();

      $barang = DB::table('d_return_seragam')
            ->join('d_return_seragam_dt', 'rsd_return', '=', 'rs_id')
            ->join('d_return_seragam_ganti', 'rsg_return_seragam', '=', 'rs_id')
            ->join('d_purchase', 'p_id', '=', 'rs_purchase')
            ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
            ->join('d_item', 'i_id', '=', 'rsd_item')
            ->join('d_item_dt', 'id_detailid', '=', 'rsd_itemdt')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->where('rs_id', $request->id)
            ->where('rsd_action', 'barang')
            ->groupBy('rsd_detailid')
            ->get();

      $barangbaru = DB::table('d_return_seragam_ganti')
                  ->join('d_return_seragam_dt', 'rsd_return', '=', 'rsg_return_seragam')
                  ->leftjoin('d_item', 'i_id', '=', 'rsg_item')
                  ->leftjoin('d_item_dt', 'id_detailid', '=', 'rsg_item_dt')
                  ->leftjoin('d_kategori', 'k_id', '=', 'i_kategori')
                  ->leftjoin('d_size', 's_id', '=', 'id_size')
                  ->where('rsg_return_seragam', $request->id)
                  ->where('rsd_return', $request->id)
                  ->where('rsd_action', 'barang')
                  ->groupBy('rsg_detailid')
                  ->get();

      return view('return-pembelian.edit', compact('uang', 'barang', 'barangbaru'));
    }

    public function update(Request $request){
      if (!AksesUser::checkAkses(28, 'update')) {
          return redirect('not-authorized');
      }
    DB::beginTransaction();
      try {

      for ($i=0; $i < count($request->harga); $i++) {
        $temp[$i] = str_replace('Rp. ', '', $request->harga[$i]);
        $temp1[$i] = str_replace('.', '', $temp[$i]);
        $harga[$i] = $temp1[$i];
      }

      for ($i=0; $i < count($request->rsdreturn); $i++) {
        DB::table('d_return_seragam_dt')
              ->where('rsd_return', $request->rsdreturn[$i])
              ->where('rsd_detailid', $request->rsddetailid[$i])
              ->update([
                'rsd_note' => $request->keterangan_sejenis[$i]
              ]);
            }


        $datagantibarang = DB::table('d_return_seragam_ganti')
                    ->whereIn('rsg_return_seragam', $request->rsdreturn)
                    ->get();

        $detailidreturn = DB::table('d_return_seragam_dt')
                      ->whereIn('rsd_return', $request->rsdreturn)
                      ->where('rsd_action', 'barang')
                      ->get();

        DB::table('d_return_seragam_ganti')
            ->whereIn('rsg_return_seragam', $request->rsdreturn)
            ->delete();

            for ($i=0; $i < count($request->idtambahitem); $i++) {

              $detailidganti = DB::table('d_return_seragam_ganti')
                            ->where('rsg_return_seragam', $request->rsdreturn[0])
                            ->max('rsg_detailid');

              if ($detailidganti == null) {
                $detailidganti = 0;
              }

              $rsg_item_dt = DB::table('d_item_dt')
                          ->select('id_detailid')
                          ->where('id_item', $request->idtambahitem[$i])
                          ->where('id_size', $request->idsize[$i])
                          ->get();

              DB::table('d_return_seragam_ganti')
                  ->insert([
                    'rsg_return_seragam' => $request->rsdreturn[0],
                    'rsg_detailid_return' => $detailidreturn[0]->rsd_detailid,
                    'rsg_detailid' => $detailidganti + 1,
                    'rsg_no' => $datagantibarang[0]->rsg_no,
                    'rsg_item' => $request->idtambahitem[$i],
                    'rsg_item_dt' => $rsg_item_dt[0]->id_detailid,
                    'rsg_qty' => $request->qty[$i],
                    'rsg_insert' => Carbon::now('Asia/Jakarta'),
                    'rsg_value' => $harga[$i]
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

    public function history(){
      return view('return-pembelian.history');
    }

    public function datatable_history(Request $request){
      if ($request->tgl_awal != null && $request->tgl_akhir != null) {
        $start = Carbon::parse($request->tgl_awal)->startOfDay();  //2016-09-29 00:00:00.000000
        $end = Carbon::parse($request->tgl_akhir)->endOfDay(); //2016-09-29 23:59:59.000000

        DB::statement(DB::raw('set @rownum=0'));
        $list = DB::table('d_return_seragam')
                  ->where('rs_isapproved', 'Y')
                  ->select(DB::raw('@rownum  := @rownum  + 1 AS number'), 'rs_nota', 'rs_date', 'rs_id')
                  ->where('rs_date', '>', $start)
                  ->where('rs_date', '<', $end)
                  ->get();

        for ($i=0; $i < count($list); $i++) {
          $list[$i]->rs_date = Carbon::parse($list[$i]->rs_date)->format('d/m/Y h:i:s');
        }

        $data = collect($list);
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="text-center">
                    <button title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail(' . $data->rs_id . ')"><i class="glyphicon glyphicon-folder-open"></i></button>
                  </div>';
            })
            ->make(true);
      } elseif ($request->keyword != null) {
        DB::statement(DB::raw('set @rownum=0'));
        $list = DB::table('d_return_seragam')
                  ->where('rs_isapproved', 'Y')
                  ->select(DB::raw('@rownum  := @rownum  + 1 AS number'), 'rs_nota', 'rs_date', 'rs_id')
                  ->where('rs_id', $request->keyword)
                  ->get();

        for ($i=0; $i < count($list); $i++) {
          $list[$i]->rs_date = Carbon::parse($list[$i]->rs_date)->format('d/m/Y h:i:s');
        }

        $data = collect($list);
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="text-center">
                    <button title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail(' . $data->rs_id . ')"><i class="glyphicon glyphicon-folder-open"></i></button>
                  </div>';
            })
            ->make(true);
      } elseif (condition) {
        // code...
      } else {
        DB::statement(DB::raw('set @rownum=0'));
        $list = DB::table('d_return_seragam')
                  ->where('rs_isapproved', 'Y')
                  ->select(DB::raw('@rownum  := @rownum  + 1 AS number'), 'rs_nota', 'rs_date', 'rs_id')
                  ->get();

        for ($i=0; $i < count($list); $i++) {
          $list[$i]->rs_date = Carbon::parse($list[$i]->rs_date)->format('d/m/Y h:i:s');
        }

        $data = collect($list);
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="text-center">
                    <button title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail(' . $data->rs_id . ')"><i class="glyphicon glyphicon-folder-open"></i></button>
                  </div>';
            })
            ->make(true);
      }
    }

    public function achistory(Request $request){
      $cari = $request->term;

      $data = DB::table('d_return_seragam')
                ->where('rs_nota', 'LiKE', "%$cari%")
                ->limit(20)
                ->get();

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->rs_date = Carbon::parse($data[$i]->rs_date)->format('d/m/Y h:i:s');
      }

      if ($data == null) {
          $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
      } else {

          foreach ($data as $query) {
              $results[] = ['id' => $query->rs_id, 'label' => $query->rs_nota . ' ('.$query->rs_date.')' ];
          }
      }

      return Response::json($results);
    }

    public function cetak(Request $request){

      $uang = DB::table('d_return_seragam')
            ->join('d_return_seragam_dt', 'rsd_return', '=', 'rs_id')
            ->join('d_item', 'i_id', '=', 'rsd_item')
            ->join('d_item_dt', 'id_detailid', '=', 'rsd_itemdt')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->join('d_size', 's_id', '=', 'id_size')
            ->where('rs_id', $request->id)
            ->where('rsd_action', 'uang')
            ->groupBy('rs_id')
            ->get();

      $barang = DB::table('d_return_seragam')
            ->join('d_return_seragam_dt', 'rsd_return', '=', 'rs_id')
            ->join('d_return_seragam_ganti', 'rsg_return_seragam', '=', 'rs_id')
            ->join('d_item', 'i_id', '=', 'rsd_item')
            ->join('d_item_dt', 'id_detailid', '=', 'rsd_itemdt')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->join('d_size', 's_id', '=', 'id_size')
            ->where('rs_id', $request->id)
            ->where('rsd_action', 'barang')
            ->groupBy('rsd_detailid')
            ->get();

      $barangbaru = DB::table('d_return_seragam_ganti')
                  ->leftjoin('d_item', 'i_id', '=', 'rsg_item')
                  ->leftjoin('d_item_dt', 'id_detailid', '=', 'rsg_item_dt')
                  ->leftjoin('d_kategori', 'k_id', '=', 'i_kategori')
                  ->leftjoin('d_size', 's_id', '=', 'id_size')
                  ->where('rsg_return_seragam', $request->id)
                  ->groupBy('rsg_detailid')
                  ->get();

     return view('return-pembelian.print', compact('uang', 'barang', 'barangbaru'));

    }

    public function getnota(Request $request){
      $cari = $request->term;

      $data = DB::select("select p_id, s_company, p_nota, pd_receivetime from d_purchase inner join d_supplier on s_id = p_supplier inner join d_purchase_dt on pd_purchase = p_id where (s_company like '%".$cari."%' or p_nota like '%".$cari."%') and pd_receivetime is not null and p_id not in (select pd_purchase from d_purchase_dt where pd_receivetime is null) group by p_id limit 20");
      if ($data == null) {
          $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
      } else {
        foreach ($data as $query) {
            $results[] = ['id' => $query->p_id, 'label' => $query->p_nota . ' (' . $query->s_company . ')'];
        }
      }

      return response()->json($results);
    }

}
