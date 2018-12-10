<?php

namespace App\Http\Controllers;

use App\d_mitra_mou;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\AksesUser;
use Yajra\Datatables\Datatables;

class MouController extends Controller
{
    public function index()
    {
      if (!AksesUser::checkAkses(23, 'read')) {
          return redirect('not-authorized');
      }
        return view('mou-mitra.index');
    }

    public function tambah()
    {
      if (!AksesUser::checkAkses(23, 'insert')) {
          return redirect('not-authorized');
      }
        return view('mou-mitra.add');
    }

    public function table()
    {
        $data = DB::table('d_mitra')
            ->leftJoin('d_mitra_mou', 'mm_mitra', '=', 'm_id')
            ->select('m_id', 'm_name', 'm_note', 'mm_detailid', 'mm_mou', DB::raw('DATE_FORMAT(mm_mou_start, "%d/%m/%Y") as mm_mou_start'), DB::raw('DATE_FORMAT(mm_mou_end, "%d/%m/%Y") as mm_mou_end'))
            ->where('mm_status', '=', 'Aktif')
            ->get();

        $mou = collect($data);
        return Datatables::of($mou)
            ->addColumn('sisa', function ($mou) {
                Carbon::setLocale('id');
                $akhir = null;
                if (Carbon::createFromFormat('d/m/Y', $mou->mm_mou_end)->lessThan(Carbon::now('Asia/Jakarta'))) {
                    $akhir = 'Expired';
                } else {
                    $akhir = Carbon::createFromFormat('d/m/Y', $mou->mm_mou_end)->diffForHumans(null, true);
                }
                return $akhir;
            })
            ->addColumn('action', function ($mou) {
                return '<div class="text-center">
                    <button style="margin-left:5px;" title="Perpanjang" data-toggle="modal" data-target="#myModal"  type="button" class="btn btn-info btn-xs" onclick="perpanjang(' . $mou->m_id . ',' . $mou->mm_detailid . ', \'' . $mou->mm_mou . '\')"><i class="glyphicon glyphicon-export"></i></button>
                    <a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" data-target="modal-edit" onclick="edit(' . $mou->m_id . ')"><i class="glyphicon glyphicon-edit"></i></a>
                    <button style="margin-left:5px;" title="History" data-toggle="modal" data-target="#myModalHistory"  type="button" class="btn btn-success btn-xs" onclick="history(' . $mou->m_id . ',' . $mou->mm_detailid . ')"><i class="fa fa-history"></i></button>
                    <button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Non Aktif" onclick="hapus(' . $mou->m_id . ')"><i class="glyphicon glyphicon-remove"></i></button>
                  </div>';
            })
            ->make(true);
    }

    public function tglMou(Request $request)
    {
        $idMou = $request->id;
        $detailMou = $request->detail;
        $info = DB::table('d_mitra_mou')
            ->select(DB::raw('DATE_FORMAT(mm_mou_start, "%d/%m/%Y") as mm_mou_start'), DB::raw('DATE_FORMAT(mm_mou_end, "%d/%m/%Y") as mm_mou_end'))
            ->where('mm_mitra', '=', $idMou)
            ->where('mm_detailid', '=', $detailMou)
            ->get();

        return $info;
    }

    public function UpdateMou(Request $request)
    {
      if (!AksesUser::checkAkses(23, 'update')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try {
            $idMou = $request->id;
            $noMou = strtoupper($request->mou);
            $detailMou = $request->detail;
            $awal = Carbon::createFromFormat('d/m/Y', $request->awal)->format('Y-m-d');
            $akhir = Carbon::createFromFormat('d/m/Y', $request->akhir)->format('Y-m-d');

            DB::table('d_mitra_mou')
                ->where('mm_mitra', '=', $idMou)
                ->where('mm_detailid', '=', $detailMou)
                ->update([
                    'mm_status' => 'Tidak'
                ]);

            $detailId = DB::table('d_mitra_mou')
                ->where('mm_mitra', '=', $idMou)
                ->max('mm_detailid');

            ++$detailId;

            DB::table('d_mitra_mou')
                ->insert([
                    'mm_mitra' => $idMou,
                    'mm_detailid' => $detailId,
                    'mm_mou' => $noMou,
                    'mm_mou_start' => $awal,
                    'mm_mou_end' => $akhir,
                    'mm_aktif' => Carbon::now('Asia/Jakarta'),
                    'mm_status' => 'Aktif'
                ]);

            DB::commit();
            return response()->json([
                'status' => 'berhasil'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function edit(Request $request)
    {
      if (!AksesUser::checkAkses(23, 'update')) {
          return redirect('not-authorized');
      }
        $id = $request->id;

        $data = DB::table('d_mitra_mou')->where('mm_mitra', $id)->get();

        if (!empty($data[0]->mm_mou_start)) {
            $moustart = Carbon::parse($data[0]->mm_mou_start)->format('d/m/Y');
        }

        if (!empty($data[0]->mm_mou_end)) {
            $mouend = Carbon::parse($data[0]->mm_mou_end)->format('d/m/Y');
        }

        return response()->json([
            'mm_mitra' => $data[0]->mm_mitra,
            'mm_detailid' => $data[0]->mm_detailid,
            'mm_mou' => $data[0]->mm_mou,
            'mm_mou_start' => $moustart,
            'mm_mou_end' => $mouend
        ]);
    }

    public function updateedit(Request $request)
    {
      if (!AksesUser::checkAkses(23, 'update')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try {
            $idmitra = $request->mitra;
            $detailid = $request->detail;
            $nomou = $request->nomou;
            $awal = Carbon::createFromFormat('d/m/Y', $request->startmou);
            $akhir = Carbon::createFromFormat('d/m/Y', $request->endmou);

            d_mitra_mou::where('mm_mitra', $idmitra)
                ->where('mm_detailid', $detailid)
                ->update([
                    'mm_mou' => $nomou,
                    'mm_mou_start' => $awal,
                    'mm_mou_end' => $akhir
                ]);

            DB::commit();
            return response()->json([
                'status' => 'berhasil'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function hapus(Request $request)
    {
      if (!AksesUser::checkAkses(23, 'delete')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try {
            $idmitra = $request->id;
            d_mitra_mou::where('mm_mitra', $idmitra)
                ->update([
                    'mm_aktif' => Carbon::now(),
                    'mm_status' => 'Tidak'
                ]);
            DB::commit();
            return response()->json([
                'status' => 'berhasil'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function cari()
    {
        return view('mou-mitra.cari');
    }

    public function pencarian(Request $request)
    {
        $keyword = $request->term;

        $data = DB::table('d_mitra_mou')
            ->join('d_mitra', 'm_id', '=', 'mm_mitra')
            ->select('m_name', 'mm_mou', 'mm_mou_start', 'mm_mou_end', 'mm_mitra', 'mm_detailid')
            ->where('mm_mou', 'LIKE', '%' . $keyword . '%')
            ->ORwhere('m_name', 'LIKE', '%' . $keyword . '%')
            ->LIMIT(20)
            ->get();

        if ($data == null) {
            $results[] = ['mitraid' => null, 'detailid' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {

            foreach ($data as $query) {
                $results[] = ['mitraid' => $query->mm_mitra, 'detailid' => $query->mm_detailid, 'label' => $query->mm_mou . ' (' . $query->m_name . ')'];
            }
        }

        return response()->json($results);

    }

    public function getdata(Request $request)
    {
        Carbon::setLocale('id');
        $data = DB::table('d_mitra_mou')
            ->join('d_mitra', 'm_id', '=', 'mm_mitra')
            ->select('m_name', 'mm_mou', 'mm_mou_start', 'mm_mou_end', 'mm_mitra', 'mm_detailid', 'mm_mou_end as sisa', 'mm_status')
            ->where('mm_mitra', $request->mitraid)
            ->where('mm_detailid', $request->detailid)
            ->get();

        if (!empty($data)) {
            $data[0]->mm_mou_start = Carbon::parse($data[0]->mm_mou_start)->format('d/m/Y');
            $data[0]->mm_mou_end = Carbon::parse($data[0]->mm_mou_end)->format('d/m/Y');
            $data[0]->sisa = Carbon::createFromFormat('d/m/Y', $data[0]->mm_mou_end, 'Asia/Jakarta')->diffForHumans(null, true);
        }

        return response()->json($data);

    }

    public function aktif(Request $request)
    {
        DB::beginTransaction();
        try {

            $cek = DB::table('d_mitra_mou')
                ->where('mm_status', 'Aktif')
                ->where('mm_mitra', $request->id)
                ->get();

            if (count($cek) > 0) {
                return response()->json([
                    'status' => 'gagal',
                    'content' => 'Mitra MOU ini sudah ada yang aktif!'
                ]);
            } else {
                $idmitra = $request->id;
                d_mitra_mou::where('mm_mitra', $idmitra)
                    ->update([
                        'mm_aktif' => Carbon::now(),
                        'mm_status' => 'Aktif'
                    ]);
                DB::commit();
                return response()->json([
                    'status' => 'berhasil'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function getMou(Request $request)
    {

        $id = $request->id;
        $data = DB::table('d_mitra_mou')
            ->where('mm_mitra', '=', $id)
            ->get();

        $data = collect($data);
        return Datatables::of($data)
            ->editColumn('mm_mou_start', function ($data){
                return Carbon::createFromFormat('Y-m-d', $data->mm_mou_start)->format('d/m/Y');
            })
            ->editColumn('mm_mou_end', function ($data){
                return Carbon::createFromFormat('Y-m-d', $data->mm_mou_end)->format('d/m/Y');
            })
            ->make('true');
    }

}
