<?php

namespace App\Http\Controllers;

use App\d_sales;
use App\d_sales_dt;
use App\d_seragam_pekerja;
use Yajra\Datatables\Datatables;
use App\d_stock;
use App\d_stock_mutation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Response;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AksesUser;

class PenjualanController extends Controller
{
    public function index()
    {
      if (!AksesUser::checkAkses(29, 'read')) {
          return redirect('not-authorized');
      }

        return view('pengeluaran.index');
    }

    public function data()
    {
        DB::statement(DB::raw('set @rownum=0'));

        $pengeluaran = DB::table('d_sales')
            ->join('d_mitra', 'm_id', '=', 's_member')
            ->select(DB::raw('@rownum  := @rownum  + 1 AS number'), 's_date', 's_nota', 'm_name', 's_total_net', 's_isapproved', 's_id')
            ->where('s_isapproved', 'P')
            ->get();

        for ($i = 0; $i < count($pengeluaran); $i++) {
            $pengeluaran[$i]->s_total_net = 'Rp. ' . number_format($pengeluaran[$i]->s_total_net, 2, ',', '.');
        }

        $pengeluaran = collect($pengeluaran);

        return Datatables::of($pengeluaran)
            ->addColumn('status', function ($pengeluaran) {
                if ($pengeluaran->s_isapproved == 'P')
                    return '<div class="text-center"><span class="label label-warning ">Pending</span></div>';
                if ($pengeluaran->s_isapproved == 'Y')
                    return '<div class="text-center"><span class="label label-success ">Disetujui</span></div>';
                if ($pengeluaran->s_isapproved == 'N')
                    return '<div class="text-center"><span class="label label-danger ">Ditolak</span></div>';
            })
            ->addColumn('action', function ($pengeluaran) {
                return '<div class="text-center">
                  <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail(' . $pengeluaran->s_id . ')"><i class="glyphicon glyphicon-folder-open"></i></button>
                  <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" onclick="edit(' . $pengeluaran->s_id . ')"><i class="glyphicon glyphicon-edit"></i></button>
                  <button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus(' . $pengeluaran->s_id . ')"><i class="fa fa-trash"></i></button>
                </div>';
            })
            ->make(true);
    }

    public function create()
    {
      if (!AksesUser::checkAkses(29, 'insert')) {
          return redirect('not-authorized');
      }
        $mitra = DB::table('d_mitra')
            ->select('m_id', 'm_name')
            ->orderBy('m_name')
            ->get();

        $angka = rand(10, 99);
        $tanggal = date('y/m/d/His');
        $nota = 'PB-' . $tanggal . '/' . $angka;

        return view('pengeluaran.create', compact('nota', 'mitra'));
    }

    public function getItem(Request $request)
    {
        $mitra = $request->mitra;
        /*$item = DB::table('d_mitra_item')
            ->join('d_item', 'i_id', '=', 'mi_item')
            ->select('i_nama', 'i_id', 'i_warna')
            ->where('mi_mitra', '=', $mitra)
            ->get();*/

        $info = DB::table('d_mitra')
            ->select('m_phone', 'm_id', 'm_name')
            ->where('m_id', '=', $mitra)
            ->first();

        $divisi = DB::table('d_mitra_divisi')
            ->select('md_id', 'md_name')
            ->where('md_mitra', $mitra)
            ->orderBy('md_name')
            ->get();

        return response()->json([
            'info' => $info,
            'divisi' => $divisi
        ]);
    }

    public function getPekerja(Request $request)
    {
        $mitra = $request->mitra;
        $item = $request->item;
        $divisi = $request->divisi;

        $pekerja = DB::table('d_mitra_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'mp_pekerja')
            ->select('mp_pekerja', 'p_name', 'p_hp', 'p_nip', 'mp_mitra_nik', 'p_id')
            ->where('mp_mitra', '=', $mitra)
            ->where('mp_divisi', '=', $divisi)
            ->where('mp_isapproved', '=', 'Y')
            ->where('mp_status', '=', 'Aktif')
            ->get();

        $seragam = DB::table('d_item_dt')
            ->join('d_item', 'i_id', '=', 'id_item')
            ->join('d_size', 'id_size', '=', 's_id')
            ->join('d_stock', function ($q) {
                $q->on('d_stock.s_item', '=', 'id_item');
                $q->on('d_stock.s_item_dt', '=', 'id_detailid');
            })
            ->select('i_nama', 's_nama', 'd_size.s_id', 'id_price', 'i_warna', DB::raw('d_stock.s_qty as qty'))
            ->where('id_item', '=', $item)
            ->orderBy('d_size.s_id')
            ->get();

        return response()->json([
            'pekerja' => $pekerja,
            'seragam' => $seragam
        ]);
    }

    public function savelama(Request $request)
    {
        $divisi = $request->divisi;
        $seragam = $request->seragam;
        $mitra = $request->mitra;
        $ukuran = $request->ukuran;
        $total = $request->total;
        $pekerja = $request->pekerja;
        $temp = $request->pekerja;
        $comp = Session::get('mem_comp');
        $sekarang = Carbon::now('Asia/Jakarta');
        $nota = $this->getnewnota();
        $jumlahUkuran = array_count_values($ukuran);
        $jumlahSimpan = $jumlahUkuran;

        $countukuran = 0;
        for ($i = 0; $i < count($ukuran); $i++) {
            if ($ukuran[$i] != "Tidak") {
                $countukuran++;
            }
        }

        for ($i = 0; $i < count($ukuran); $i++) {
            if ($ukuran[$i] != 'Tidak' && $pekerja[$i] != null) {
                $temp[$i] = 'Iya';
            } else {
                $temp[$i] = 'Tidak';
            }
        }

        $getItem_dt = DB::table('d_item_dt')
            ->select('id_detailid')
            ->where('id_item', '=', $seragam)
            ->whereIn('id_size', $ukuran)
            ->get();

        $item_dt = [];
        for ($i = 0; $i < count($getItem_dt); $i++) {
            $item_dt[$i] = $getItem_dt[$i]->id_detailid;
        }

        $getStock = DB::table('d_stock_mutation')
            ->join('d_stock', 's_id', '=', 'sm_stock')
            ->join('d_item_dt', function ($q) {
                $q->on('s_item', '=', 'id_item')
                    ->on('s_item_dt', '=', 'id_detailid');
            })
            ->select('sm_stock', 'sm_detailid', 'sm_qty', 'sm_use', 'sm_item_dt', DB::raw('(sm_qty - sm_use) as sisa'), 'sm_hpp', 'sm_sell', 'id_size', 'id_price')
            ->where('s_item', '=', $seragam)
            ->whereIn('s_item_dt', $item_dt)
            ->where('s_comp', '=', $comp)
            ->where('s_position', '=', $comp)
            ->where(DB::raw('(sm_qty - sm_use)'), '!=', 0)
            ->orderBy('sm_stock', 'asc')
            ->orderBy('sm_detailid', 'asc')
            ->orderBy('sm_date', 'asc')
            ->get();

        $id = DB::table('d_sales')
            ->max('s_id');

        $idSales = DB::table('d_sales')
            ->max('s_id');
        $idSales = $idSales + 1;

        $detailSales = DB::table('d_sales_dt')
            ->where('sd_sales', '=', $idSales)
            ->max('sd_detailid');
        $detailSales = $detailSales + 1;

        DB::beginTransaction();
        try {

            for ($i = 0; $i < count($pekerja); $i++) {
                // Insert seragam pekerja //

                $detailid = DB::table('d_seragam_pekerja')
                    ->where('sp_sales', $idSales)
                    ->max('sp_id');

                if ($detailid == null) {
                    $detailid = 0;
                }

                if ($pekerja[$i] != '' && $temp[$i] == 'Iya' && $ukuran[$i] != 'Tidak') {
                    DB::table('d_seragam_pekerja')
                        ->insert([
                            'sp_sales' => $idSales,
                            'sp_id' => $detailid + 1,
                            'sp_pekerja' => $pekerja[$i],
                            'sp_item' => $seragam,
                            'sp_item_size' => $ukuran[$i],
                            'sp_qty' => 1,
                            'sp_value' => $getStock[0]->id_price,
                            'sp_pay_value' => 0,
                            'sp_status' => 'Belum',
                            'sp_date' => Carbon::now('Asia/Jakarta'),
                            'sp_mitra' => $mitra,
                            'sp_divisi' => $divisi,
                            'sp_no' => $this->getpenerimaan($idSales)
                        ]);
                }
            }

            DB::table('d_sales')->insert([
                's_id' => $id + 1,
                's_comp' => Session::get('mem_comp'),
                's_member' => $mitra,
                's_nota' => $nota,
                's_total_gross' => $total,
                's_disc_percent' => 0,
                's_disc_value' => 0,
                's_total_net' => $total,
                's_isapproved' => 'P'
            ]);


            $count = DB::table('d_sales')
                ->where('s_isapproved', 'P')
                ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', 'Pengeluaran')
                ->update([
                    'n_qty' => count($count),
                    'n_insert' => Carbon::now('Asia/Jakarta')
                ]);

            for ($j = 0; $j < count($countukuran); $j++) {
                $salesdt = array(
                    'sd_sales' => $idSales,
                    'sd_detailid' => $detailSales,
                    'sd_comp' => Session::get('mem_comp'),
                    'sd_item' => $seragam,
                    'sd_item_dt' => $getStock[$j]->sm_item_dt,
                    'sd_qty' => $jumlahSimpan[$getStock[$j]->id_size],
                    'sd_value' => $getStock[$j]->id_price,
                    'sd_total_gross' => $getStock[$j]->id_price * $jumlahSimpan[$getStock[$j]->id_size],
                    'sd_disc_percent' => 0,
                    'sd_disc_value' => 0,
                    'sd_total_net' => $getStock[$j]->id_price * $jumlahSimpan[$getStock[$j]->id_size],
                    'sd_sell' => $getStock[$j]->sm_sell,
                    'sd_hpp' => $getStock[$j]->sm_hpp
                );

                $detailSales = $detailSales + 1;

                d_sales_dt::insert($salesdt);
            }


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

    public function save(Request $request)
    {
      if (!AksesUser::checkAkses(29, 'insert')) {
          return redirect('not-authorized');
      }
        $nota = $this->getnewnota();
        $mitra = $request->mitra;
        $divisi = $request->divisi;
        $total = $request->total;
        $qty = $request->qty;
        $idStock = $request->idStock;

        DB::beginTransaction();
        try {

            $id = DB::table('d_sales')
                ->max('s_id');
            ++$id;

            DB::table('d_sales')->insert([
                's_id' => $id,
                's_comp' => 'PWT0000003',
                's_member' => $mitra,
                's_divisi' => $divisi,
                's_nota' => $nota,
                's_total_gross' => $total,
                's_disc_percent' => 0,
                's_disc_value' => 0,
                's_total_net' => $total,
                's_isapproved' => 'P'
            ]);


            $count = DB::table('d_sales')
                ->where('s_isapproved', 'P')
                ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', 'Pengeluaran')
                ->update([
                    'n_qty' => count($count),
                    'n_insert' => Carbon::now('Asia/Jakarta')
                ]);

            for ($j = 0; $j < count($idStock); $j++) {
                $item = DB::table('d_stock')
                    ->join('d_item', 's_item', '=', 'i_id')
                    ->join('d_item_dt', function ($q){
                        $q->on('id_item', '=', 'i_id');
                        $q->on('id_detailid', '=', 's_item_dt');
                        $q->on('id_item', '=', 's_item');
                    })
                    ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
                    ->select('s_item', 's_item_dt', 'id_price', 'sm_hpp')
                    ->where('s_id', '=', $idStock[$j])
                    ->where('sm_detail', '=', 'Pembelian')
                    ->orderBy('sm_detailid', 'desc')
                    ->first();

                $salesdt = array(
                    'sd_sales' => $id,
                    'sd_detailid' => $j + 1,
                    'sd_comp' => 'PWT0000003',
                    'sd_item' => $item->s_item,
                    'sd_item_dt' => $item->s_item_dt,
                    'sd_qty' => $qty[$j],
                    'sd_value' => $item->id_price,
                    'sd_total_gross' => ($item->id_price * $qty[$j]),
                    'sd_disc_percent' => 0,
                    'sd_disc_value' => 0,
                    'sd_total_net' => ($item->id_price * $qty[$j]),
                    'sd_sell' => $item->id_price,
                    'sd_hpp' => $item->sm_hpp
                );
                d_sales_dt::insert($salesdt);
            }

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

    public function getnewnota()
    {
        $querykode = DB::select(DB::raw("SELECT MAX(MID(s_nota,5,3)) as counter, MAX(MID(s_nota,9,2)) as tanggal, MAX(MID(s_nota,12,2)) as bulan, MAX(RIGHT(s_nota,4)) as tahun FROM d_sales"));

        if (count($querykode) > 0) {
            if ($querykode[0]->bulan != date('m') || $querykode[0]->tahun != date('Y') || $querykode[0]->tanggal != date('d')) {
                $kode = "001";
            } else {
                foreach ($querykode as $k) {
                    $tmp = ((int)$k->counter) + 1;
                    $kode = sprintf("%03s", $tmp);
                }
            }
        } else {
            $kode = "001";
        }

        $finalkode = 'POS-' . $kode . '/' . date('d') . '/' . date('m') . '/' . date('Y');

        return $finalkode;
    }

    public function getpenerimaan($kode)
    {
        //Kode penerimaan

        $kode1 = sprintf('%03s', $kode);

        $notapenerimaan = 'PS-' . $kode1 . '/' . date('d') . '/' . date('m') . '/' . date('Y');

        return $notapenerimaan;
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();
        try {

            $sales = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->select('d_sales.*', DB::raw('sum(sd_qty) as total'))
                ->where('s_id', $request->id)
                ->groupBy('s_id')
                ->get();

            $seragampekerja = DB::table('d_seragam_pekerja')
                ->where('sp_sales', $request->id)
                ->get();

            $nota = $sales[0]->s_nota;

            $stockpenjualan = DB::table('d_stock_mutation')
                ->where('sm_nota', '=', $nota)
                ->get();

            //Hapus ke mutasi stock
            // for ($a=0; $a < count($stockpenjualan); $a++) {
            //
            //     $stockpembelian = DB::table('d_stock_mutation')
            //           ->where('sm_item', '=', $stockpenjualan[$a]->sm_item)
            //           ->where('sm_item_dt', '=', $stockpenjualan[$a]->sm_item_dt)
            //           ->where('sm_detail', '=', 'Pembelian')
            //           ->where('sm_hpp', '=', $stockpenjualan[$a]->sm_hpp)
            //           ->get();
            //
            //     for ($i=0; $i < count($stockpembelian); $i++) {
            //
            //       if ($stockpembelian[$i]->sm_use >= $stockpenjualan[$a]->sm_qty) {
            //
            //           DB::table('d_stock_mutation')
            //               ->where('sm_stock', '=', $stockpembelian[$i]->sm_stock)
            //               ->where('sm_detailid', '=', $stockpembelian[$i]->sm_detailid)
            //               ->update([
            //                 'sm_use' => DB::raw('(sm_use - '.$stockpenjualan[$a]->sm_qty.')')
            //               ]);
            //
            //           $i = count($stockpembelian) + 1;
            //
            //       } elseif ($stockpembelian[$i]->sm_use < $stockpenjualan[$a]->sm_qty) {
            //
            //           DB::table('d_stock_mutation')
            //               ->where('sm_stock', '=', $stockpembelian[$i]->sm_stock)
            //               ->where('sm_detailid', '=', $stockpembelian[$i]->sm_detailid)
            //               ->update([
            //                 'sm_use' => 0
            //               ]);
            //
            //           $stockpenjualan[$a]->sm_qty = $stockpenjualan[$a]->sm_qty - $stockpembelian[$i]->sm_use;
            //
            //       }
            //     }
            //   }

            // DB::table('d_stock_mutation')
            //         ->where('sm_nota', '=', $nota)
            //         ->delete();

            // DB::table('d_stock')
            // ->where('s_id', '=', $stockpenjualan[0]->sm_stock)
            // ->update([
            //   's_qty' => DB::raw('(s_qty + '.$sales[0]->total.')')
            // ]);

            DB::table('d_seragam_pekerja')
                ->where('sp_sales', $request->id)
                ->delete();

            DB::table('d_sales_dt')
                ->where('sd_sales', $request->id)
                ->delete();

            DB::table('d_sales')
                ->where('s_id', $request->id)
                ->delete();

                $count = DB::table('d_sales')
                    ->where('s_isapproved', 'P')
                    ->get();

                DB::table('d_notifikasi')
                    ->where('n_fitur', 'Pengeluaran')
                    ->update([
                        'n_qty' => count($count),
                        'n_insert' => Carbon::now('Asia/Jakarta')
                    ]);

            // for ($x=0; $x < count($seragampekerja); $x++) {
            //   DB::table('d_pekerja_mutation')
            //       ->where('pm_pekerja', $seragampekerja[$x]->sp_pekerja)
            //       ->where('pm_detail', 'Pemberian Seragam')
            //       ->where('pm_reff', $seragampekerja[$x]->sp_no)
            //       ->delete();
            // }

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

    public function detail(Request $request)
    {
        $data = DB::table('d_sales')
            ->join('d_sales_dt', 'sd_sales', '=', 's_id')
            ->join('d_item', 'i_id', '=', 'sd_item')
            ->join('d_item_dt', function ($e) {
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

    public function edit(Request $request)
    {
      if (!AksesUser::checkAkses(29, 'update')) {
          return redirect('not-authorized');
      }
        $id = $request->id;

        $data = DB::table('d_sales')
                    ->select('s_member', 's_divisi', 's_nota')
                    ->where('s_id', $request->id)
                    ->first();

        $mitra = DB::table('d_mitra')
                    ->select('m_name', 'm_id')
                    ->where('m_id', $data->s_member)
                    ->first();

        $divisi = DB::table('d_mitra_divisi')
                    ->select('md_name', 'md_id', 'md_mitra')
                    ->where('md_mitra', $data->s_member)
                    ->where('md_id', $data->s_divisi)
                    ->first();

        $dataitem = DB::table('d_sales_dt')
                    ->join('d_item', 'i_id', '=', 'sd_item')
                    ->join('d_item_dt', function($e){
                      $e->on('id_item', '=', 'i_id')
                        ->on('id_detailid', '=', 'sd_item_dt');
                    })
                    ->join('d_size', 's_id', '=', 'id_size')
                    ->where('sd_sales', $request->id)
                    ->get();

      for ($i=0; $i < count($dataitem); $i++) {
        $stock[] = DB::table('d_stock')
                  ->where('s_item', $dataitem[$i]->sd_item)
                  ->where('s_item_dt', $dataitem[$i]->sd_item_dt)
                  ->get();
      }


        $nota = $data->s_nota;

        // $id = $request->id;
        //
        // $data = DB::table('d_sales')
        //     ->leftjoin('d_sales_dt', 'sd_sales', '=', 'd_sales.s_id')
        //     ->leftjoin('d_mitra', 'm_id', '=', 's_member')
        //     ->leftjoin('d_mitra_divisi', 'md_mitra', '=', 'm_id')
        //     ->leftjoin('d_item', 'i_id', '=', 'sd_item')
        //     ->leftjoin('d_item_dt', function ($e) {
        //         $e->on('id_item', '=', 'sd_item')
        //             ->on('id_detailid', '=', 'sd_item_dt');
        //     })
        //     ->leftjoin('d_size', 'd_size.s_id', '=', 'id_size')
        //     ->leftjoin('d_seragam_pekerja', function ($e) {
        //         $e->on('sp_sales', '=', 'd_sales.s_id')
        //             ->on('sp_sales', '=', 'sd_sales');
        //     })
        //     ->leftjoin('d_pekerja', 'p_id', '=', 'sp_pekerja')
        //     ->leftjoin('d_mitra_pekerja', 'mp_pekerja', '=', 'p_id')
        //     ->where('d_sales.s_id', $request->id)
        //     ->where('mp_status', 'Aktif')
        //     ->where('mp_isapproved', 'Y')
        //     ->get();
        //
        // $pekerja = DB::select("select p_name, sp_item, sp_item_size, s_id, p_nip, p_id, s_nama, p_hp, sp_item from d_pekerja
        //     join d_mitra_pekerja on p_id = mp_pekerja
        //     left join d_seragam_pekerja on mp_pekerja = sp_pekerja AND sp_sales = '" . $request->id . "'
        //     left join d_size on s_id = sp_item_size
        //     where mp_status = 'Aktif'
        //     AND mp_divisi = " . $data[0]->mp_divisi . " AND mp_mitra = " . $data[0]->mp_mitra . "");
        //
        // $countpekerja = count($pekerja);
        //
        // $stock = DB::table('d_stock')
        //     ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
        //     ->where('sm_item', $data[0]->sd_item)
        //     ->where('sm_item_dt', $data[0]->sd_item_dt)
        //     ->get();
        //
        // for ($i = 0; $i < count($data); $i++) {
        //     $seragam = DB::table('d_item_dt')
        //         ->join('d_item', 'i_id', '=', 'id_item')
        //         ->join('d_size', 'id_size', '=', 's_id')
        //         ->join('d_stock', function ($q) {
        //             $q->on('d_stock.s_item', '=', 'id_item');
        //             $q->on('d_stock.s_item_dt', '=', 'id_detailid');
        //         })
        //         ->select('i_nama', 's_nama', 'd_size.s_id', 'id_price', 'i_warna', DB::raw('d_stock.s_qty as qty'))
        //         ->where('id_item', '=', $data[$i]->i_id)
        //         ->orderBy('d_size.s_id')
        //         ->get();
        // }
        //
        //
        return view('pengeluaran.edit', compact('id', 'data', 'dataitem', 'mitra', 'divisi', 'nota', 'stock'));

    }

    public function update(Request $request)
    {
      if (!AksesUser::checkAkses(29, 'update')) {
          return redirect('not-authorized');
      }

      DB::table('d_sales_dt')
          ->where('sd_sales', $request->id)
          ->delete();

      DB::table('d_sales')
          ->where('s_id', $request->id)
          ->delete();

      $nota = $request->nota;
      $mitra = $request->mitra;
      $divisi = $request->divisi;
      $total = $request->total;
      $qty = $request->qty;
      $idStock = $request->idStock;

      DB::beginTransaction();
      try {

          $id = DB::table('d_sales')
              ->max('s_id');
          ++$id;

          DB::table('d_sales')->insert([
              's_id' => $id,
              's_comp' => 'PWT0000003',
              's_member' => $mitra,
              's_divisi' => $divisi,
              's_nota' => $nota,
              's_total_gross' => $total,
              's_disc_percent' => 0,
              's_disc_value' => 0,
              's_total_net' => $total,
              's_isapproved' => 'P'
          ]);


          $count = DB::table('d_sales')
              ->where('s_isapproved', 'P')
              ->get();

          DB::table('d_notifikasi')
              ->where('n_fitur', 'Pengeluaran')
              ->update([
                  'n_qty' => count($count),
                  'n_insert' => Carbon::now('Asia/Jakarta')
              ]);

          for ($j = 0; $j < count($idStock); $j++) {
              $item = DB::table('d_stock')
                  ->join('d_item', 's_item', '=', 'i_id')
                  ->join('d_item_dt', function ($q){
                      $q->on('id_item', '=', 'i_id');
                      $q->on('id_detailid', '=', 's_item_dt');
                      $q->on('id_item', '=', 's_item');
                  })
                  ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
                  ->select('s_item', 's_item_dt', 'id_price', 'sm_hpp')
                  ->where('s_id', '=', $idStock[$j])
                  ->where('sm_detail', '=', 'Pembelian')
                  ->orderBy('sm_detailid', 'desc')
                  ->first();

              $salesdt = array(
                  'sd_sales' => $id,
                  'sd_detailid' => $j + 1,
                  'sd_comp' => 'PWT0000003',
                  'sd_item' => $item->s_item,
                  'sd_item_dt' => $item->s_item_dt,
                  'sd_qty' => $qty[$j],
                  'sd_value' => $item->id_price,
                  'sd_total_gross' => ($item->id_price * $qty[$j]),
                  'sd_disc_percent' => 0,
                  'sd_disc_value' => 0,
                  'sd_total_net' => ($item->id_price * $qty[$j]),
                  'sd_sell' => $item->id_price,
                  'sd_hpp' => $item->sm_hpp
              );
              d_sales_dt::insert($salesdt);
          }

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

    public function search($mitra, Request $request)
    {
        $cari = $request->term;

        $data = DB::table('d_stock')
            ->join('d_item', 'i_id', '=', 'd_stock.s_item')
            ->join('d_item_dt', function ($q){
                $q->on('id_item', '=', 'i_id');
                $q->on('id_detailid', '=', 'd_stock.s_item_dt');
                $q->on('id_item', '=', 'd_stock.s_item');
            })
            ->join('d_mitra_item', 'mi_item', '=', 'd_item.i_id')
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->select(DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(d_size.s_nama, ""), " ") as nama'), 'd_stock.s_id', 'd_stock.s_qty', 'id_price')
            ->where('d_stock.s_qty', '>', 0)
            ->where(DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(d_size.s_nama, ""), " ")'), 'like', '%'.$cari.'%')
            ->where('mi_mitra', '=', $mitra)
            ->get();

        if ($data == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($data as $query) {
                $results[] = ['id' => $query, 'label' => $query->nama ];
            }
        }

        return Response::json($results);
    }

    public function countpekerja(Request $request){
      $count = DB::table('d_mitra_pekerja')
                    ->where('mp_mitra', $request->mitra)
                    ->where('mp_divisi', $request->divisi)
                    ->count();

      return response()->json($count);
    }

    public function history(){
      return view('pengeluaran.history');
    }

    public function cariHistory(Request $request){
      $cari = $request->term;

      $data = DB::table('d_sales')
                ->join('d_mitra', 'm_id', '=', 's_member')
                ->where('s_isapproved', 'Y')
                ->get();

      if ($data == null) {
          $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
      } else {

          foreach ($data as $query) {
              $results[] = ['id' => $query->s_nota, 'label' => $query->s_nota ];
          }
      }

      return response()->json($results);

    }

    public function findHistory(Request $request){
      if ($request->nota == "" && $request->tgl_awal != "" && $request->tgl_akhir != "") {
        $request->tgl_awal = str_replace('/','-',$request->tgl_awal);
        $request->tgl_akhir = str_replace('/','-',$request->tgl_akhir);

        $start = Carbon::parse($request->tgl_awal)->startOfDay();  //2016-09-29 00:00:00.000000
        $end = Carbon::parse($request->tgl_akhir)->endOfDay(); //2016-09-29 23:59:59.000000

        $data = DB::table('d_sales')
                  ->join('d_mitra', 'm_id', '=', 's_member')
                  ->where('s_isapproved', 'Y')
                  ->where('s_date', '>=', $start)
                  ->where('s_date', '<=', $end)
                  ->get();

      } elseif ($request->nota != "" && $request->tgl_awal == "" && $request->tgl_akhir == "") {
        $data = DB::table('d_sales')
                  ->join('d_mitra', 'm_id', '=', 's_member')
                  ->where('s_isapproved', 'Y')
                  ->where('s_nota', $request->nota)
                  ->get();

      } elseif ($request->nota != "" && $request->tgl_awal != "" && $request->tgl_akhir != "") {
        $request->tgl_awal = str_replace('/','-',$request->tgl_awal);
        $request->tgl_akhir = str_replace('/','-',$request->tgl_akhir);

        $start = Carbon::parse($request->tgl_awal)->startOfDay();  //2016-09-29 00:00:00.000000
        $end = Carbon::parse($request->tgl_akhir)->endOfDay(); //2016-09-29 23:59:59.000000

        $data = DB::table('d_sales')
                  ->join('d_mitra', 'm_id', '=', 's_member')
                  ->where('s_isapproved', 'Y')
                  ->where('s_date', '>=', $start)
                  ->where('s_date', '<=', $end)
                  ->where('s_nota', $request->nota)
                  ->get();
      }

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->s_date = Carbon::parse($data[$i]->s_date)->format('d/m/Y G:i:s');
      }

      return response()->json($data);

    }

}
