<?php  
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
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
}


