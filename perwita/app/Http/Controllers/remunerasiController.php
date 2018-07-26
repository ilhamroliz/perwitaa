<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class remunerasiController extends Controller
{
    public function index(){
      return view('remunerasi.index');
    }
}
