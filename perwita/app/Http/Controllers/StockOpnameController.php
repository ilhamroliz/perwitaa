<?php  
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dompdf\Exception;
use Illuminate\Http\Request;
use PDF;
use DB;
use Response;
Use Carbon\Carbon;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;


class StockOpnameController extends Controller
{
    public function index()
    {
        $data = DB::table('d_stock_opname')
            ->join('d_stock_opname_dt', 'so_id', '=', 'sod_stock_opname')
            ->join('d_item', 'i_id', '=', 'sod_item')
            ->join('d_item_dt', function ($e) {
                $e->on('id_detailid', '=', 'sod_item_dt');
                $e->on('id_item', '=', 'sod_item');
                $e->on('id_item', '=', 'i_id');
            })
            ->join('d_size', 'd_size.s_id', '=', 'id_size')
            ->select(DB::raw('concat(i_nama, " ", i_warna, " ", coalesce(s_nama, ""), " ") as nama'), 'so_nota', 'so_date', 'so_isapproved', 'so_status')
            ->where('so_isapproved', '!=', 'N')
            ->where('so_status', '=', 'Pending')
            ->groupBy('so_id')
            ->get();

        return view('manajemen-stock/stock-opname/index', compact('data'));
    }

    public function add()
    {
        return view('manajemen-stock/stock-opname/create');
    }

    public function getStock(Request $request)
    {
        $idItem = $request->id;
        $detailid = $request->detailid;

        $data = DB::table('d_stock')
            ->join('d_comp', 'c_id', '=', 's_comp')
            ->select('s_qty', 'c_name', 's_id')
            ->where('s_item', '=', $idItem)
            ->where('s_item_dt', '=', $detailid)
            ->get();

        return response()->json($data);
    }

    public function getNewNota()
    {
        //OS-001/14/12/2018
        $sekarang = Carbon::now('Asia/Jakarta');
        $tanggal = $sekarang->format('d');
        $bulan = $sekarang->format('m');
        $tahun = $sekarang->format('Y');
        $counter = DB::select("select max(mid(so_nota,4,3)) as counter, (mid(so_nota,8,2)) as tanggal, MAX(MID(so_nota,10,2)) as bulan, (right(so_nota,4)) as tahun from d_stock_opname");
        $counter = $counter[0]->counter;

        $tmp = ((int)$counter) + 1;
        $kode = sprintf("%03s", $tmp);
        $finalkode = 'OS-' . $kode . '/' . $tanggal . '/' . $bulan . '/' . $tahun;
        return $finalkode;
    }

    public function getId()
    {
        $id = DB::table('d_stock_opname')
            ->select('so_id')
            ->max('so_id');

        return $id + 1;
    }

    public function save(Request $request)
    {
        //dd($request);
        DB::beginTransaction();
        try{
            $idStock = $request->s_id;
            $sistem = $request->qtysistem;
            $qtyreal = $request->qtyreal;
            $aksi = $request->aksi;
            $keterangan = $request->keterangan;
            $nota = $this->getNewNota();
            $id = $this->getId();

            $info = DB::table('d_stock')
                ->where('s_id', '=', $idStock)
                ->get();

            DB::table('d_stock_opname')
                ->insert([
                    'so_id' => $id,
                    'so_comp' => Session::get('mem_comp'),
                    'so_nota' => $nota,
                    'so_date' => Carbon::now('Asia/Jakarta'),
                    'so_status' => 'Pending',
                    'so_isapproved' => 'P',
                    'so_insert' => Carbon::now('Asia/Jakarta')
                ]);

            DB::table('d_stock_opname_dt')
                ->insert([
                    'sod_stock_opname' => $id,
                    'sod_detailid' => 1,
                    'sod_item' => $info[0]->s_item,
                    'sod_item_dt' => $info[0]->s_item_dt,
                    'sod_qty_sistem' => $sistem,
                    'sod_qty_real' => $qtyreal,
                    'sod_aksi' => $aksi,
                    'sod_keterangan' => $keterangan
                ]);

            DB::select("update d_notifikasi set n_qty = (select count('p_id') from d_stock_opname where p_isapproved = 'P' and n_fitur = 'Opname' and n_detail = 'Create')");

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


