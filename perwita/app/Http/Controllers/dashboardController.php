<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\AksesUser;

class dashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        if (!AksesUser::checkAkses(1, 'read')){
            return redirect('not-authorized');
        }
        return view('dashboard');
    }
}
