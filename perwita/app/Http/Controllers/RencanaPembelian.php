<?php

namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Http\Requests;
use Session;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\AksesUser;

class RencanaPembelian extends Controller
{
    public function index()
    {
      if (!AksesUser::checkAkses(25, 'read')) {
          return redirect('not-authorized');
      }

        return view('rencana-pembelian/index');
    }

    public function data(Request $request)
    {
        /*        $data = DB::table('d_purchase_planning')
                    ->join('d_purchase_planning_dt', 'ppd_purchase_planning', '=', 'pp_id')
                    ->join('d_item', 'i_id', '=', 'ppd_item')
                    ->join('d_item_dt', function ($q){
                        $q->on('ppd_item', '=', 'id_item');
                        $q->on('ppd_item_dt', '=', 'id_detailid');
                    })
                    ->join('d_size', 's_id', '=', 'id_size')
                    ->select(DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'd_purchase_planning.*', 'd_purchase_planning_dt.*')
                    ->where('pp_status', '=', 'Belum')
                    ->where('pp_isapproved', '!=', 'N')
                    ->toSql();*/

        $data = DB::select('select m_name, d_purchase_planning.*, sum(ppd_qty) as jumlah from d_purchase_planning inner join d_purchase_planning_dt on ppd_purchase_planning = pp_id inner join d_item on i_id = ppd_item inner join d_item_dt on ppd_item = id_item and ppd_item_dt = id_detailid inner join d_size on s_id = id_size inner join d_mem on pp_mem = m_id where pp_status = "Belum" and pp_isapproved != "N" group by pp_id');
        $data = collect($data);
        return Datatables::of($data)
            ->editColumn('pp_isapproved', function ($data) {
                if ($data->pp_isapproved == 'P') {
                    return '<div class="text-center"><span class="label label-warning ">Pending</span></div>';
                } elseif ($data->pp_isapproved == 'Y') {
                    return '<div class="text-center"><span class="label label-success ">Disetujui</span></div>';
                }
            })
            ->editColumn('pp_date', function ($data) {
                return Carbon::createFromFormat('Y-m-d', $data->pp_date)->format('d/m/Y');
            })
            ->addColumn('aksi', function ($data) {
                return '<div class="text-center">
                        <button type="button" title="detail" onclick="detail(\'' . $data->pp_nota . '\')" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-folder-open"></i></button>
                        <button type="button" title="edit" onclick="edit(\'' . $data->pp_nota . '\')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></button>
                        <button type="button" title="hapus" onclick="hapus(\'' . $data->pp_nota . '\')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                        </div>';
            })
            ->make(true);
    }

    public function add()
    {
      if (!AksesUser::checkAkses(25, 'insert')) {
          return redirect('not-authorized');
      }
        return view('rencana-pembelian/create');
    }

    public function edit(Request $request)
    {
      if (!AksesUser::checkAkses(25, 'update')) {
          return redirect('not-authorized');
      }
        $nota = $request->nota;
        $info = DB::table('d_purchase_planning')
            ->join('d_purchase_planning_dt', 'pp_id', '=', 'ppd_purchase_planning')
            ->join('d_item', 'i_id', '=', 'ppd_item')
            ->join('d_item_dt', function ($q) {
                $q->on('id_item', '=', 'i_id');
                $q->on('id_detailid', '=', 'ppd_item_dt');
            })
            ->join('d_size', 's_id', '=', 'id_size')
            ->select('ppd_qty', 'i_id', 'id_detailid', 'i_nama', 's_nama', 'id_price', 'i_warna', DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'))
            ->where('pp_nota', '=', $nota)
            ->get();

        return view('rencana-pembelian/edit', compact('info', 'nota'));
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

        $tmp = ((int)$counter) + 1;
        $kode = sprintf("%03s", $tmp);
        $finalkode = 'PP-' . $kode . '/' . $tanggal . '/' . $bulan . '/' . $tahun;
        return $finalkode;
    }

    public function update(Request $request)
    {
      if (!AksesUser::checkAkses(25, 'update')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try {

            $nota = $request->nota;
            $id = DB::table('d_purchase_planning')
                ->where('pp_nota', '=', $nota)
                ->get();

            DB::table('d_purchase_planning')
                ->where('pp_nota', '=', $nota)
                ->delete();

            DB::table('d_purchase_planning_dt')
                ->where('ppd_purchase_planning', '=', $id[0]->pp_id)
                ->delete();

            $idItem = $request->id;
            $itemDt = $request->iddt;
            $qty = $request->qty;

            $id = DB::table('d_purchase_planning')
                ->max('pp_id');

            ++$id;

            DB::table('d_purchase_planning')
                ->insert([
                    'pp_id' => $id,
                    'pp_nota' => $nota,
                    'pp_date' => Carbon::now('Asia/Jakarta'),
                    'pp_status' => 'Belum',
                    'pp_isapproved' => 'Y',
                    'pp_mem' => Session::get('mem'),
                    'pp_insert' => Carbon::now('Asia/Jakarta')
                ]);
            $tempPlan = [];
            for ($i = 0; $i < count($idItem); $i++) {
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
                'status' => 'sukses',
                'nota' => $nota
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
      if (!AksesUser::checkAkses(25, 'insert')) {
          return redirect('not-authorized');
      }
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
                    'pp_mem' => Session::get('mem'),
                    'pp_insert' => Carbon::now('Asia/Jakarta')
                ]);

            $tempPlan = [];
            for ($i = 0; $i < count($idItem); $i++) {
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

            $count = DB::table('d_purchase_planning')
                ->where('pp_isapproved', 'P')
                ->get();

            DB::table('d_notifikasi')
                ->where('n_fitur', 'Rencana Pembelian')
                ->update([
                    'n_qty' => count($count),
                    'n_insert' => Carbon::now('Asia/Jakarta')
                ]);

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

    public function detail(Request $request)
    {
        $nota = $request->id;
        $data = DB::table('d_purchase_planning')
            ->join('d_purchase_planning_dt', 'ppd_purchase_planning', '=', 'pp_id')
            ->join('d_item', 'i_id', '=', 'ppd_item')
            ->join('d_item_dt', function ($q) {
                $q->on('id_item', '=', 'i_id');
                $q->on('id_detailid', '=', 'ppd_item_dt');
            })
            ->join('d_size', 'id_size', '=', 's_id')
            ->select(DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(d_size.s_nama, ""), " ") as nama'), 'ppd_qty')
            ->where('pp_nota', '=', $nota)
            ->get();

        return response()->json([
            'status' => 'berhasil',
            'data' => $data
        ]);
    }

    public function hapus(Request $request)
    {
      if (!AksesUser::checkAkses(25, 'delete')) {
          return redirect('not-authorized');
      }
        $nota = $request->nota;
        $id = DB::table('d_purchase_planning')
            ->where('pp_nota', '=', $nota)
            ->get();

        DB::table('d_purchase_planning')
            ->where('pp_nota', '=', $nota)
            ->delete();

        DB::table('d_purchase_planning_dt')
            ->where('ppd_purchase_planning', '=', $id[0]->pp_id)
            ->delete();

        $count = DB::table('d_purchase_planning')
            ->where('pp_isapproved', 'P')
            ->get();

        DB::table('d_notifikasi')
            ->where('n_fitur', 'Rencana Pembelian')
            ->update([
                'n_qty' => count($count),
                'n_insert' => Carbon::now('Asia/Jakarta')
            ]);

        return response()->json([
            'status' => 'berhasil'
        ]);
    }

    public function print(Request $request)
    {

        $data = DB::table('d_purchase_planning')
            ->join('d_purchase_planning_dt', 'ppd_purchase_planning', '=', 'pp_id')
            ->join('d_item', 'i_id', '=', 'ppd_item')
            ->join('d_item_dt', function ($e) {
                $e->on('id_item', '=', 'i_id')
                    ->on('id_detailid', '=', 'ppd_item_dt');
            })
            ->join('d_size', 's_id', '=', 'id_size')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->where('pp_id', $request->id)
            ->get();

        return view('rencana-pembelian.print', compact('data'));

    }

    public function printwithnota(Request $request)
    {

        $data = DB::table('d_purchase_planning')
            ->join('d_purchase_planning_dt', 'ppd_purchase_planning', '=', 'pp_id')
            ->join('d_item', 'i_id', '=', 'ppd_item')
            ->join('d_item_dt', function ($e) {
                $e->on('id_item', '=', 'i_id')
                    ->on('id_detailid', '=', 'ppd_item_dt');
            })
            ->join('d_size', 's_id', '=', 'id_size')
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->where('pp_nota', $request->nota)
            ->get();

        return view('rencana-pembelian.print', compact('data'));

    }

}
