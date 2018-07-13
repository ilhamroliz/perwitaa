<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SuratPeringatanController extends Controller
{
    public function index()
    {
        return view('surat-peringatan.index');
    }
}
