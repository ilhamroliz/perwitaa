<?php

namespace App\Http\Controllers;

use App\d_notifikasi;
use App\d_purchase;
use App\d_purchase_dt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Response;
use App\Http\Controllers\AksesUser;

class PembelianController extends Controller
{
    public function index()
    {
      if (!AksesUser::checkAkses(26, 'read')) {
          return redirect('not-authorized');
      }

        $data = DB::select("select * from d_purchase inner join d_purchase_dt on pd_purchase = p_id inner join d_supplier on s_id = p_supplier where p_id not in (select pd_purchase from d_purchase_dt where pd_receivetime is not null) and p_isapproved != 'N' group by p_nota limit 20");

        return view('pembelian.index', compact('data'));
    }

    public function create()
    {
      if (!AksesUser::checkAkses(26, 'insert')) {
          return redirect('not-authorized');
      }
        $supplier = DB::table('d_supplier')
            ->select('s_id', 's_company')
            ->where('s_isactive', '=', 'Y')
            ->get();

        $angka = rand(10, 99);
        $tanggal = date('y/m/d/His');
        $nota = 'PO-' . $tanggal . '/' . $angka;

        return view('pembelian.create', compact('supplier', 'nota'));
    }

    public function createKhusus()
    {
        $supplier = DB::table('d_supplier')
            ->select('s_id', 's_company')
            ->where('s_isactive', '=', 'Y')
            ->get();

        $nota = $this->getNotaRencana();

        return view('pembelian.createkhusus', compact('supplier', 'nota'));
    }

    public function getItem(Request $request)
    {
        $cari = $request->term;

        $data = DB::table('d_item')
            ->join('d_item_dt', 'id_item', '=', 'i_id')
            ->join('d_size', 's_id', '=', 'id_size')
            ->select('i_id', 'id_detailid', 'i_nama', 's_nama', 'id_price', 'i_warna', DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'))
            ->whereRaw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") like "%' . $cari . '%"')
            ->where('i_isactive', '=', 'Y')
            ->take(50)->get();

        if ($data == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($data as $query) {
                $results[] = ['id' => $query->i_id, 'label' => $query->nama, 'harga' => $query->id_price, 'warna' => $query->i_warna, 'i_nama' => $query->i_nama, 'ukuran' => $query->s_nama, 'detailid' => $query->id_detailid];
            }
        }

        return Response::json($results);
    }

    public function getNewNota()
    {
        //PO-001/14/12/2018
        $sekarang = Carbon::now('Asia/Jakarta');
        $tanggal = $sekarang->format('d');
        $bulan = $sekarang->format('m');
        $tahun = $sekarang->format('Y');
        $counter = DB::select("select max(mid(p_nota,4,3)) as counter, (mid(p_nota,8,2)) as tanggal, MAX(MID(p_nota,10,2)) as bulan, (right(p_nota,4)) as tahun from d_purchase");
        $counter = $counter[0]->counter;

        $tmp = ((int)$counter) + 1;
        $kode = sprintf("%03s", $tmp);
        $finalkode = 'PO-' . $kode . '/' . $tanggal . '/' . $bulan . '/' . $tahun;
        return $finalkode;
    }

    public function save(Request $request)
    {
      if (!AksesUser::checkAkses(26, 'insert')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try {
            $notarencana = $request->nota;
            $nota = $this->getNewNota();

            $id = DB::table('d_purchase')
                ->max('p_id');

            $id = $id + 1;
            $gross = 0;

            for ($i = 0; $i < count($request->qty); $i++) {
                $qty = $request->qty[$i];
                $harga = str_replace(".", '', $request->harga[$i]);
                $gross = ($qty * $harga) + $gross;
            }
            $comp = DB::table('d_mem_comp')
                ->where('mc_mem', '=', Session::get('mem'))
                ->get();

            $comp = $comp[0]->mc_comp;

            $data = array(
                'p_id' => $id,
                'p_comp' => $comp,
                'p_date' => Carbon::now('Asia/Jakarta'),
                'p_supplier' => $request->supplier,
                'p_nota' => $nota,
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

            for ($i = 0; $i < count($request->qty); $i++) {
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
                    'pd_disc_value' => str_replace(".", '', $request->disc[$i]),
                    'pd_total_net' => ((int)$request->qty[$i] * (int)str_replace(".", '', $request->harga[$i])) - (int)str_replace(".", '', $request->disc[$i]),
                    'pd_barang_masuk' => 0,
                    'pd_receivetime' => null
                );
                array_push($pd, $data_dt);
            }
            d_purchase_dt::insert($pd);
            if ($notarencana != null || $notarencana != '') {
                DB::table('d_purchase_planning')
                    ->where('pp_nota', '=', $notarencana)
                    ->update([
                        'pp_status' => 'Sudah'
                    ]);
            }

            $countpembelian = DB::table('d_purchase')
                ->where('p_isapproved', 'P')
                ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', '=', 'Pembelian')
                ->where('n_detail', '=', 'Create')
                ->update([
                    'n_qty' => count($countpembelian),
                    'n_insert' => Carbon::now('Asia/Jakarta')
                ]);

            $id = encrypt($id);

            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'id' => $id
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function update(Request $request)
    {
      if (!AksesUser::checkAkses(26, 'update')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try {
            $nota = $request->nota;

            $id = DB::table('d_purchase')
                ->where('p_nota', '=', $nota)
                ->max('p_id');

            $gross = 0;

            $comp = DB::table('d_mem_comp')
                ->where('mc_mem', '=', Session::get('mem'))
                ->get();

            $comp = $comp[0]->mc_comp;

            for ($i = 0; $i < count($request->qty); $i++) {
                $qty = $request->qty[$i];
                $harga = str_replace(".", '', $request->harga[$i]);
                $gross = ($qty * $harga) + $gross;
            }

            $data = array(
                'p_date' => Carbon::now('Asia/Jakarta'),
                'p_supplier' => $request->supplier,
                'p_total_gross' => $gross,
                'p_disc_percent' => 0,
                'p_disc_value' => 0,
                'p_pajak' => 0,
                'p_total_net' => $gross,
                'p_jurnal' => '1234'
            );

            d_purchase::where('p_nota', '=', $nota)
                ->update($data);

            $detailid = DB::table('d_purchase_dt')
                ->where('pd_purchase', '=', $id)
                ->max('pd_detailid');

            $detailid = $detailid + 1;
            $pd = [];

            d_purchase_dt::where('pd_purchase', '=', $id)
                ->delete();

            for ($i = 0; $i < count($request->qty); $i++) {
                $data_dt = array(
                    'pd_purchase' => $id,
                    'pd_detailid' => $detailid + $i,
                    'pd_qty' => $request->qty[$i],
                    'pd_comp' => $comp,
                    'pd_value' => str_replace(".", '', $request->harga[$i]),
                    'pd_item' => $request->id[$i],
                    'pd_item_dt' => $request->iddt[$i],
                    'pd_total_gross' => $request->qty[$i] * str_replace(".", '', $request->harga[$i]),
                    'pd_disc_percent' => 0,
                    'pd_disc_value' => str_replace(".", '', $request->disc[$i]),
                    'pd_total_net' => ((int)$request->qty[$i] * (int)str_replace(".", '', $request->harga[$i])) - (int)str_replace(".", '', $request->disc[$i]),
                    'pd_barang_masuk' => 0,
                    'pd_receivetime' => null
                );
                array_push($pd, $data_dt);
            }
            d_purchase_dt::insert($pd);

            $countpembelian = DB::table('d_purchase')
                ->where('p_isapproved', 'P')
                ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', '=', 'Pembelian')
                ->where('n_detail', '=', 'Create')
                ->update([
                    'n_qty' => count($countpembelian),
                    'n_insert' => Carbon::now('Asia/Jakarta')
                ]);

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

    public function cari()
    {
        return view('pembelian.cari');
    }

    public function getNotaRencana()
    {
        $data = DB::table('d_purchase_planning')
            ->join('d_purchase_planning_dt', 'ppd_purchase_planning', '=', 'pp_id')
            ->select(DB::raw('date_format(pp_date, "%d/%m/%Y") as pp_date'), 'pp_nota')
            ->where('pp_isapproved', '=', 'Y')
            ->where('pp_status', '=', 'Belum')
            ->groupBy('pp_id')
            ->get();

        return $data;
    }

    public function detailRencana(Request $request)
    {
        $nota = $request->nota;
        $data = DB::table('d_purchase_planning')
            ->join('d_purchase_planning_dt', 'ppd_purchase_planning', '=', 'pp_id')
            ->join('d_item', 'i_id', '=', 'ppd_item')
            ->join('d_item_dt', function ($e) {
                $e->on('id_detailid', '=', 'ppd_item_dt');
                $e->on('id_item', '=', 'i_id');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->select(DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'ppd_qty', 'id_price', 'i_id', 'id_detailid', DB::raw('(ppd_qty*id_price) as total'))
            ->where('pp_nota', '=', $nota)
            ->get();

        return response()->json($data);
    }

    public function getNota(Request $request)
    {
        $keyword = $request->term;

        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->select('*')
            ->where('p_nota', 'LIKE', '%' . $keyword . '%')
            ->take(20)
            ->groupBy('p_nota')
            ->get();

        // dd($data);
        if ($data == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($data as $query) {
                $results[] = ['id' => $query->p_id, 'label' => $query->p_nota . ' (' . $query->s_company . ')'];
            }
        }

        return response()->json($results);
    }

    public function getdata(Request $request)
    {
        if (empty($request->id)) {
            return response()->json([
                'status' => 'kosong'
            ]);
        } else {
            $id = $request->id;

            $data = DB::table('d_purchase')
                ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
                ->join('d_supplier', 's_id', '=', 'p_supplier')
                ->select('p_id', 's_company', 'p_nota', 'p_total_net', 'pd_receivetime', 'p_isapproved', DB::raw("DATE_FORMAT(p_date, '%d/%m/%Y %H:%i:%s') as p_date"))
                ->where('p_id', $id)
                ->groupBy('p_nota')
                ->get();


            return response()->json([
                'p_id' => $data[0]->p_id,
                'p_date' => $data[0]->p_date,
                's_company' => $data[0]->s_company,
                'p_nota' => $data[0]->p_nota,
                'p_total_net' => $data[0]->p_total_net,
                'pd_receivetime' => $data[0]->pd_receivetime,
                'p_isapproved' => $data[0]->p_isapproved
            ]);
        }
    }

    public function filter(Request $request)
    {
        if (empty($request->moustart) || empty($request->mouend)) {
            return response()->json([
                'status' => 'kosong'
            ]);
        } else {
            $moustart = date('Y-m-d', strtotime($request->moustart));
            $mouend = date('Y-m-d', strtotime($request->mouend));

            $data = DB::table('d_purchase')
                ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
                ->join('d_supplier', 's_id', '=', 'p_supplier')
                ->select('p_id', 's_company', 'p_nota', 'p_total_net', 'pd_receivetime', 'p_isapproved', DB::raw("DATE_FORMAT(p_date, '%d/%m/%Y %H:%i:%s') as p_date"))
                ->whereRaw("date(p_date) >= '" . $moustart . "' AND date(p_date) <= '" . $mouend . "'")
                ->where('pd_receivetime', null)
                ->whereRaw("p_isapproved = 'P' Or p_isapproved = 'Y'")
                ->groupBy('p_nota')
                ->get();

            return response()->json($data);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $count = 0;

        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->join('d_item_dt', function ($e) {
                $e->on('id_detailid', '=', 'pd_item_dt');
                $e->on('id_item', '=', 'i_id');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->select(
                'p_date',
                'p_total_net',
                'pd_value',
                'pd_qty',
                'i_nama',
                'pd_total_gross',
                'pd_disc_value',
                'pd_disc_percent',
                'pd_total_net',
                'i_nama',
                'p_total_gross',
                'k_nama',
                'i_warna',
                'p_pajak',
                's_company',
                's_nama'
            )
            ->where('p_id', $id)
            ->get();

        $count = count($data);

        return response()->json([
            $data,
            'count' => $count
        ]);
    }

    public function cetak($id)
    {
        $id = decrypt($id);

        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->join('d_item_dt', function ($e) {
                $e->on('id_detailid', '=', 'pd_item_dt');
                $e->on('id_item', '=', 'i_id');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->select(
                'p_date',
                'p_total_net',
                'pd_value',
                'pd_qty',
                'i_nama',
                'pd_total_gross',
                'pd_disc_value',
                'pd_disc_percent',
                'pd_total_net',
                'i_nama',
                'p_total_gross',
                'k_nama',
                'i_warna',
                'p_pajak',
                's_company',
                's_nama',
                'p_nota',
                's_address',
                's_phone'
            )
            ->where('p_id', $id)
            ->get();

        $count = count($data);

        return view('pembelian.print', compact('data', 'count'));
    }

    public function getDetail(Request $request)
    {
        $nota = $request->nota;
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
            ->where('p_nota', '=', $nota)
            ->get();

        return response()->json([
            'status' => 'sukses',
            'data' => $info
        ]);
    }

    public function hapus(Request $request)
    {
      if (!AksesUser::checkAkses(26, 'delete')) {
          return redirect('not-authorized');
      }
        $nota = $request->nota;
        $id = DB::table('d_purchase')
            ->where('p_nota', '=', $nota)
            ->where('p_isapproved', '!=', 'Y')
            ->max('p_id');

        if ($id == null || $id == '') {
            return response()->json([
                'status' => 'gagal'
            ]);
        }

        DB::table('d_purchase')
            ->where('p_id', '=', $id)
            ->delete();

        DB::table('d_purchase_dt')
            ->where('pd_purchase', '=', $id)
            ->delete();

        return response()->json([
            'status' => 'sukses'
        ]);
    }

    public function edit(Request $request)
    {
      if (!AksesUser::checkAkses(26, 'update')) {
          return redirect('not-authorized');
      }
        $nota = $request->nota;

        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->join('d_item_dt', function ($e) {
                $e->on('id_detailid', '=', 'pd_item_dt');
                $e->on('id_item', '=', 'i_id');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->select(
                'p_date',
                'p_supplier',
                'p_total_net',
                'pd_value',
                'pd_qty',
                'i_nama',
                'pd_total_gross',
                'pd_disc_value',
                'pd_disc_percent',
                'pd_total_net',
                'i_nama',
                'p_total_gross',
                'k_nama',
                'i_warna',
                'p_pajak',
                's_company',
                's_nama',
                'i_id',
                'id_detailid',
                DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama')
            )
            ->where('p_nota', $nota)
            ->get();

        $supplier = DB::table('d_supplier')
            ->select('s_id', 's_company')
            ->where('s_isactive', '=', 'Y')
            ->get();

        return view('pembelian/edit', compact('supplier', 'data', 'nota'));
    }
}
