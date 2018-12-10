<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Response;

use App\Http\Controllers\AksesUser;

class PenerimaanController extends Controller
{
    public function index()
    {
      if (!AksesUser::checkAkses(30, 'read')) {
          return redirect('not-authorized');
      }
        return view('penerimaan-pengeluaran.index');
    }

}
