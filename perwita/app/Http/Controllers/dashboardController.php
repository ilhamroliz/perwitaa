<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;

class dashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        dd(Auth::check());
        return view('dashboard');
    }
}
