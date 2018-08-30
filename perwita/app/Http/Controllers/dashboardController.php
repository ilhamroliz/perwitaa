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
        $akses = new aksesUserController();
        $cek = $akses->checkAkses(1, 'read');
        if (!$cek){
            return redirect('not-authorized');
        }
        return view('dashboard');
    }
}
