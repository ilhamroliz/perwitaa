<?php

namespace App\Http\Controllers;

use App\d_notifikasi;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\d_mitra;

use App\d_mitra_mou;

use Yajra\Datatables\Datatables;

use Validator;

use DB;

use Carbon\carbon;
use App\Http\Controllers\AksesUser;

class mitraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      if (!AksesUser::checkAkses(21, 'read')) {
          return redirect('not-authorized');
      }

        return view('mitra.index');
    }

    public function data()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $mitra = d_mitra::select(DB::raw('@rownum  := @rownum  + 1 AS number'), 'm_id', 'm_name', 'm_address', 'm_phone'
            , 'm_note')->where('m_status', '=', 'Aktif')->ORwhere('m_status', '=', null)->orderBy('m_name')->get();
        return Datatables::of($mitra)
            ->addColumn('action', function ($mitra) {
                return '<div class="text-center">
                            <button style="margin-left:5px;" type="button" class="btn btn-info btn-xs" title="Detail" onclick="detail(' . $mitra->m_id . ')"><i class="fa fa-folder"></i></button>
                            <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="data-mitra/' . $mitra->m_id . '/edit" ><i class="glyphicon glyphicon-edit"></i></a>
                    <button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus(' . $mitra->m_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
            })
            ->make(true);
    }

    public function tambah()
    {
      if (!AksesUser::checkAkses(21, 'insert')) {
          return redirect('not-authorized');
      }

        return view('mitra.formTambah');
    }
    public function simpan(Request $request)
    {
      if (!AksesUser::checkAkses(21, 'insert')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try{
            $idmitra = d_mitra::max('m_id') + 1;

            $idmou = DB::table('d_mitra_mou')->where('mm_mitra', '=', $idmitra)->max('mm_detailid');


            if ($idmou < 1 || $idmou == null) {
                $idmou = 1;
            } else {
                $idmou = $idmou + 1;
            }

            d_mitra::insert(array(
                      'm_id' => $idmitra,
                      'm_name' => $request->namamitra,
                      'm_address' => $request->alamatmitra,
                      'm_cp' => $request->nama_cp,
                      'm_cp_phone' => $request->no_cp,
                      'm_phone' => $request->notelp,
                      'm_note' => $request->ket,
                      'm_status' => 'Aktif',
                      'm_insert' => Carbon::now('Asia/Jakarta')
                  ));
                  d_mitra_mou::insert(array(
                      'mm_mitra' => $idmitra,
                      'mm_detailid' => $idmou,
                      'mm_mou' => $request->nomou,
                      'mm_mou_start' => Carbon::createFromFormat('d/m/Y', $request->startmou, 'Asia/Jakarta'),
                      'mm_mou_end' => Carbon::createFromFormat('d/m/Y', $request->endmou, 'Asia/Jakarta'),
                      'mm_aktif' => null,
                      'mm_status' => null,
                  ));

                  $jumlah = DB::table('d_mitra')
                          ->where('m_status_approval', null)
                          ->where('m_date_approval', null)
                          ->where('m_status', '!=', 'Tidak')
                          ->get();

                  d_notifikasi::where('n_fitur', '=', 'Mitra')
                      ->where('n_detail', '=', 'Create')
                      ->update([
                          'n_qty' => count($jumlah),
                          'n_insert' => Carbon::now('Asia/Jakarta')
                      ]);

            DB::commit();
            return response()->json([
                'status' => 'berhasil',
            ]);
        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'eror' => $e
            ]);
        }
    }

    public function edit($id)
    {
      if (!AksesUser::checkAkses(21, 'update')) {
        return redirect('not-authorized');
      }
        $mitra = d_mitra::where('m_id', $id)->first();

        $mou = DB::table('d_mitra_mou')
            ->where('mm_mitra', '=', $id)
            ->get();
        // dd($mitra);
        // dd($mou);
        return view('mitra.formEdit', compact('mitra', 'mou'));
    }

    public function hapus($id)
    {
      if (!AksesUser::checkAkses(21, 'delete')) {
          return redirect('not-authorized');
      }
        return DB::transaction(function () use ($id) {
            try {
                DB::table('d_mitra')->where('m_id', '=', $id)->update(['m_status' => 'Tidak']);
                DB::table('d_mitra_mou')->where('mm_mitra', '=', $id)->update(['mm_status' => 'Tidak']);
                return response()->json([
                    'status' => 'berhasil',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'gagal',
                ]);
            }

        });
    }

    public function perbarui(Request $request, $id)
    {
      if (!AksesUser::checkAkses(21, 'update')) {
          return redirect('not-authorized');
      }
        //return $request->all();
        return DB::transaction(function () use ($request, $id) {
            try {
                $datamitra = array(
                    'm_name' => $request->namamitra,
                    'm_address' => $request->alamatmitra,
                    'm_cp' => $request->nama_cp,
                    'm_cp_phone' => $request->no_cp,
                    'm_phone' => $request->notelp,
                    'm_note' => $request->ket
                );

                $datamou = array(
                    'mm_mou' => $request->nomou,
                    'mm_mou_start' => Carbon::createFromFormat('d/m/Y', $request->startmou, 'Asia/Jakarta'),
                    'mm_mou_end' => Carbon::createFromFormat('d/m/Y', $request->endmou, 'Asia/Jakarta')
                );

                d_mitra::where('m_id', '=', $id)->update($datamitra);
                d_mitra_mou::where('mm_mitra', '=', $id)->update($datamou);

                return response()->json([
                    'status' => 'berhasil',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'gagal',
                ]);
            }


        });
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $data = DB::table('d_mitra')
            ->select('m_name',
                'm_phone',
                'm_cp_phone',
                'm_address',
                'm_fax',
                'm_note',
                'm_cp', DB::Raw("coalesce(m_fax, '-') as m_fax"))
            ->where('m_id', $id)
            ->get();

        return response()->json($data);
    }

}
