<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class pegawaiphkController extends Controller
{
    public function index(){
      return view('pegawaiphk.index');
    }
}
