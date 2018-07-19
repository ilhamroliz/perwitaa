<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class promosiController extends Controller
{
    public function index()
    {
        return view('promosi.index');
    }
}
