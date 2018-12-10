<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\AksesUser;

class faskesController extends Controller
{
    public function index()
    {
        $data = DB::table('d_faskes')
            ->get();
        return view('faskes.index', compact('data'));
    }
}
