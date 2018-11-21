<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Response;

class PenerimaanController extends Controller
{
    public function index()
    {
        return view('penerimaan-pengeluaran.index');
    }

}
