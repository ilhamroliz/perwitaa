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
        return view('manajemen-stock/stock-opname/index');
    }
}


