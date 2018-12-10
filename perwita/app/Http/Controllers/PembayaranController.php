<?php

namespace App\Http\Controllers;

use App\d_seragam_pekerja;
use App\d_seragam_pekerja_dt;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use App\Http\Controllers\AksesUser;

class PembayaranController extends Controller
{
    public function index()
    {
      if (!AksesUser::checkAkses(32, 'read')) {
          return redirect('not-authorized');
      }

        $data = DB::table('d_sales')
            ->join('d_seragam_pekerja', 'sp_sales', '=', 'd_sales.s_id')
            ->join('d_mitra', 'm_id', '=', 's_member')
            ->join('d_item', 'i_id', '=', 'sp_item')
            ->select('s_nota', 'd_sales.s_id', 's_date', 'sp_item', 's_member', 'm_name', 'i_nama', DB::raw('count(sp_id) as jumlah'), DB::raw('s_total_net as tagihan'))
            ->groupBy('s_id')
            ->get();

        for ($i=0; $i < count($data); $i++) {
          $tagihan = DB::table('d_seragam_pekerja')
                        ->select(DB::Raw('sum(sp_value) as sp_value'), DB::Raw('sum(sp_pay_value) as sp_pay_value'), DB::raw('sum(sp_value) - sum(sp_pay_value) as tagihan'))
                        ->where('sp_sales', $data[$i]->s_id)
                        ->get();
        }

        for ($i=0; $i < count($data); $i++) {
          $data[$i]->tagihan = (int)$data[$i]->tagihan - (int)$tagihan[$i]->sp_pay_value;
        }


        return view('pembayaran.index', compact('data'));
    }

    public function bayar(Request $request)
    {
        $link = $request->link;
        $nota = $request->nota;
        $status = $request->status;
        $idSales = DB::table('d_sales')
            ->select('s_id')
            ->where('s_nota', '=', $nota)
            ->get();
        $pekerja = DB::table('d_seragam_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'sp_pekerja')
            ->join('d_item', 'i_id', '=', 'sp_item')
            ->join('d_item_dt', function ($q){
                $q->on('id_detailid', '=', 'sp_item_dt');
                $q->on('id_item', '=', 'i_id');
            })
            ->join('d_kategori', 'k_id', '=', 'i_kategori')
            ->join('d_size', 's_id', '=', 'id_size')
            ->select('p_name', 'p_hp', 'p_id', 's_nama', 'i_nama', 'k_nama', 'i_warna', DB::raw('round(sp_value - sp_pay_value) as tagihan'), 'sp_value', 'sp_pay_value', 'sp_sales')
            ->where('sp_sales', '=', $idSales[0]->s_id)
            ->get();

        return view('pembayaran.bayar', compact('pekerja', 'nota', 'link', 'status'));
    }

    public function getPekerja(Request $request)
    {
        $pekerja = DB::table('d_seragam_pekerja')
            ->join('d_pekerja', 'p_id', '=', 'sp_pekerja')
            ->join('d_size', 's_id', '=', 'sp_item_size')
            ->select('p_name', 'p_hp', 'p_id', 's_nama', DB::raw('(sp_value - sp_pay_value) as tagihan'))
            ->where('sp_sales', '=', $request->idSales)
            ->get();

        return response()->json([
            'data' => $pekerja
        ]);
    }

    public function save(Request $request)
    {
      if (!AksesUser::checkAkses(32, 'insert')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try {

            $bayar = $request->bayar;
            $pekerja = $request->pekerja;
            $nota = $request->nota;

            $idSales = DB::table('d_sales')
                ->select('s_id')
                ->where('s_nota', '=', $nota)
                ->first();

            $idSales = $idSales->s_id;
            $sekarang = Carbon::now('Asia/Jakarta');

            for ($i = 0; $i < count($bayar); $i++) {
                $bayar[$i] = str_replace("Rp. ", '', $bayar[$i]);
                $bayar[$i] = str_replace(".", '', $bayar[$i]);
            }

            for ($i = 0; $i < count($bayar); $i++){
                if ($bayar[$i] != null || $bayar[$i] != ''){
                    d_seragam_pekerja::where('sp_sales', '=', $idSales)
                        ->where('sp_pekerja', '=', $pekerja[$i])
                        ->update(array(
                            'sp_pay_value' => DB::raw('sp_pay_value +'. $bayar[$i])
                        ));

                    $getDetailid = DB::table('d_seragam_pekerja_dt')
                        ->where('spd_sales', '=', $idSales)
                        ->where('spd_pekerja', '=', $pekerja[$i])
                        ->max('spd_detailid');

                    $detailid = $getDetailid + 1;

                    d_seragam_pekerja_dt::insert(array(
                        'spd_sales' => $idSales,
                        'spd_detailid' => $detailid,
                        'spd_pekerja' => $pekerja[$i],
                        'spd_installments' => $bayar[$i],
                        'spd_date' => $sekarang,
                        'spd_pegawai' => Session::get('mem')
                    ));
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function getInfoPembayaran(Request $request)
    {
        $pekerja = $request->pekerja;
        $sales = $request->sales;

        $data = DB::table('d_seragam_pekerja_dt')
            ->join('d_pekerja', 'spd_pekerja', '=', 'p_id')
            ->join('d_mem', 'm_id', '=', 'spd_pegawai')
            ->select(DB::raw('round(spd_installments) as spd_installments'), 'p_name', 'spd_date', 'm_name', 'spd_sales', 'spd_detailid', 'spd_pekerja')
            ->where('spd_sales', '=', $sales)
            ->where('spd_pekerja', '=', $pekerja)
            ->get();

        for ($i = 0; $i < count($data); $i++){
            $data[$i]->spd_date = Carbon::parse($data[$i]->spd_date)->format('d/M/Y H:i:s');
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function history(Request $request){
      return view('pembayaran.history');
    }

    public function findHistory(Request $request){
      $cari = $request->term;

          $data = DB::table('d_sales')
              ->join('d_seragam_pekerja', 'sp_sales', '=', 'd_sales.s_id')
              ->join('d_mitra', 'm_id', '=', 's_member')
              ->join('d_item', 'i_id', '=', 'sp_item')
              ->select('s_nota', 'd_sales.s_id', 's_date', 'sp_item', 's_member', 'm_name', 'i_nama', DB::raw('count(sp_id) as jumlah'), DB::raw('s_total_net as tagihan'))
              ->groupBy('s_id')
              ->where('s_nota', 'Like', "%$cari%")
              ->get();

          for ($i=0; $i < count($data); $i++) {
            $tagihan = DB::table('d_seragam_pekerja')
                          ->select(DB::Raw('sum(sp_value) as sp_value'), DB::Raw('sum(sp_pay_value) as sp_pay_value'), DB::raw('sum(sp_value) - sum(sp_pay_value) as tagihan'))
                          ->where('sp_sales', $data[$i]->s_id)
                          ->get();
          }

          for ($i=0; $i < count($data); $i++) {
            $data[$i]->tagihan = (int)$data[$i]->tagihan - (int)$tagihan[$i]->sp_pay_value;
          }

          if ($data == null) {
              $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
          } else {

              foreach ($data as $query) {
                if ($query->tagihan == 0) {
                  $results[] = ['id' => $query->s_nota, 'label' => $query->s_nota ];
                }
              }
          }

      return response($results);
    }

    public function cariHistory(Request $request){
      if ($request->nota == "" && $request->tgl_awal != "" && $request->tgl_akhir != "") {
        $request->tgl_awal = str_replace('/','-',$request->tgl_awal);
        $request->tgl_akhir = str_replace('/','-',$request->tgl_akhir);

        $start = Carbon::parse($request->tgl_awal)->startOfDay();  //2016-09-29 00:00:00.000000
        $end = Carbon::parse($request->tgl_akhir)->endOfDay(); //2016-09-29 23:59:59.000000

        $data = DB::table('d_sales')
            ->join('d_seragam_pekerja', 'sp_sales', '=', 'd_sales.s_id')
            ->join('d_seragam_pekerja_dt', 'spd_sales', '=', 'd_sales.s_id')
            ->join('d_mitra', 'm_id', '=', 's_member')
            ->join('d_item', 'i_id', '=', 'sp_item')
            ->select('s_nota', 'd_sales.s_id', 's_date', 'sp_item', 's_member', 'm_name', 'i_nama', DB::raw('count(sp_id) as jumlah'), DB::raw('s_total_net as tagihan'))
            ->groupBy('s_id')
            ->where('spd_date', '>=', $start)
            ->where('spd_date', '<=', $end)
            ->get();

            for ($i=0; $i < count($data); $i++) {
              $count = DB::table('d_sales')
                  ->join('d_seragam_pekerja', 'sp_sales', '=', 'd_sales.s_id')
                  ->join('d_mitra', 'm_id', '=', 's_member')
                  ->join('d_item', 'i_id', '=', 'sp_item')
                  ->select(DB::raw('count(sp_id) as jumlah'))
                  ->where('s_id', $data[$i]->s_id)
                  ->where('s_nota', $data[$i]->s_nota)
                  ->where('s_member', $data[$i]->s_member)
                  ->groupBy('s_id')
                  ->get();
            }

            for ($i=0; $i < count($data); $i++) {
              $tagihan = DB::table('d_seragam_pekerja')
                            ->select(DB::Raw('sum(sp_value) as sp_value'), DB::Raw('sum(sp_pay_value) as sp_pay_value'), DB::raw('sum(sp_value) - sum(sp_pay_value) as tagihan'))
                            ->where('sp_sales', $data[$i]->s_id)
                            ->get();
            }

            for ($i=0; $i < count($data); $i++) {
              $data[$i]->tagihan = (int)$data[$i]->tagihan - (int)$tagihan[$i]->sp_pay_value;
            }

      } elseif ($request->nota != "" && $request->tgl_awal == "" && $request->tgl_akhir == "") {
        $data = DB::table('d_sales')
            ->join('d_seragam_pekerja', 'sp_sales', '=', 'd_sales.s_id')
            ->join('d_seragam_pekerja_dt', 'spd_sales', '=', 'd_sales.s_id')
            ->join('d_mitra', 'm_id', '=', 's_member')
            ->join('d_item', 'i_id', '=', 'sp_item')
            ->select('s_nota', 'd_sales.s_id', 's_date', 'sp_item', 's_member', 'm_name', 'i_nama', DB::raw('count(sp_id) as jumlah'), DB::raw('s_total_net as tagihan'))
            ->groupBy('s_id')
            ->where('s_nota', $request->nota)
            ->get();

            for ($i=0; $i < count($data); $i++) {
              $count = DB::table('d_sales')
                  ->join('d_seragam_pekerja', 'sp_sales', '=', 'd_sales.s_id')
                  ->join('d_mitra', 'm_id', '=', 's_member')
                  ->join('d_item', 'i_id', '=', 'sp_item')
                  ->select(DB::raw('count(sp_id) as jumlah'))
                  ->where('s_id', $data[$i]->s_id)
                  ->where('s_nota', $data[$i]->s_nota)
                  ->where('s_member', $data[$i]->s_member)
                  ->groupBy('s_id')
                  ->get();
            }

            for ($i=0; $i < count($data); $i++) {
              $tagihan = DB::table('d_seragam_pekerja')
                            ->select(DB::Raw('sum(sp_value) as sp_value'), DB::Raw('sum(sp_pay_value) as sp_pay_value'), DB::raw('sum(sp_value) - sum(sp_pay_value) as tagihan'))
                            ->where('sp_sales', $data[$i]->s_id)
                            ->get();
            }

            for ($i=0; $i < count($data); $i++) {
              $data[$i]->tagihan = (int)$data[$i]->tagihan - (int)$tagihan[$i]->sp_pay_value;
            }

      } elseif ($request->nota != "" && $request->tgl_awal != "" && $request->tgl_akhir != "") {
        $request->tgl_awal = str_replace('/','-',$request->tgl_awal);
        $request->tgl_akhir = str_replace('/','-',$request->tgl_akhir);

        $start = Carbon::parse($request->tgl_awal)->startOfDay();  //2016-09-29 00:00:00.000000
        $end = Carbon::parse($request->tgl_akhir)->endOfDay(); //2016-09-29 23:59:59.000000

        $data = DB::table('d_sales')
            ->join('d_seragam_pekerja', 'sp_sales', '=', 'd_sales.s_id')
            ->join('d_seragam_pekerja_dt', 'spd_sales', '=', 'd_sales.s_id')
            ->join('d_mitra', 'm_id', '=', 's_member')
            ->join('d_item', 'i_id', '=', 'sp_item')
            ->select('s_nota', 'd_sales.s_id', 's_date', 'sp_item', 's_member', 'm_name', 'i_nama', DB::raw('count(sp_id) as jumlah'), DB::raw('s_total_net as tagihan'))
            ->groupBy('s_id')
            ->where('s_nota', $request->nota)
            ->where('spd_date', '>=', $start)
            ->where('spd_date', '<=', $end)
            ->get();

          for ($i=0; $i < count($data); $i++) {
            $count = DB::table('d_sales')
                ->join('d_seragam_pekerja', 'sp_sales', '=', 'd_sales.s_id')
                ->join('d_mitra', 'm_id', '=', 's_member')
                ->join('d_item', 'i_id', '=', 'sp_item')
                ->select(DB::raw('count(sp_id) as jumlah'))
                ->where('s_id', $data[$i]->s_id)
                ->where('s_nota', $data[$i]->s_nota)
                ->where('s_member', $data[$i]->s_member)
                ->groupBy('s_id')
                ->get();
          }

          for ($i=0; $i < count($data); $i++) {
            $tagihan = DB::table('d_seragam_pekerja')
                          ->select(DB::Raw('sum(sp_value) as sp_value'), DB::Raw('sum(sp_pay_value) as sp_pay_value'), DB::raw('sum(sp_value) - sum(sp_pay_value) as tagihan'))
                          ->where('sp_sales', $data[$i]->s_id)
                          ->get();
          }

          for ($i=0; $i < count($data); $i++) {
            $data[$i]->tagihan = (int)$data[$i]->tagihan - (int)$tagihan[$i]->sp_pay_value;
          }

      }

      for ($i=0; $i < count($data); $i++) {
        $data[$i]->s_date = Carbon::parse($data[$i]->s_date)->format('d/m/Y G:i:s');
        $data[$i]->jumlah = $count[$i]->jumlah;
      }

      return response()->json($data);
    }

    public function update(Request $request){
      if (!AksesUser::checkAkses(32, 'update')) {
          return redirect('not-authorized');
      }
      DB::beginTransaction();
      try {
      $bayar = $request->harga;
      for ($i = 0; $i < count($bayar); $i++) {
        $bayar[$i] = str_replace('Rp. ', '', $bayar[$i]);
        $bayar[$i] = str_replace('.', '', $bayar[$i]);
      }

        for ($i=0; $i < count($request->spd_sales); $i++) {

          DB::table('d_seragam_pekerja_dt')
                ->where('spd_sales', $request->spd_sales[$i])
                ->where('spd_detailid', $request->spd_detailid[$i])
                ->where('spd_pekerja', $request->spd_pekerja[$i])
                ->update([
                  'spd_installments' => $bayar[$i]
                ]);

          DB::table('d_seragam_pekerja')
                ->where('sp_sales', $request->spd_sales[$i])
                ->where('sp_pekerja', $request->spd_pekerja[$i])
                ->update([
                  'sp_pay_value' => $request->jumlah
                ]);
        }

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }

    }
}
