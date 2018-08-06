<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RencanaPembelian extends Controller
{
    public function index()
    {
        return view('rencana-pembelian/index');
    }

    public function add()
    {
        return view('rencana-pembelian/create');
    }

}
