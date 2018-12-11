<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\d_mem;
use Auth;
use App\d_access;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Session;
use Carbon\Carbon;
use File;
use App\Http\Controllers\AksesUser;

class manajemenPenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      if (!AksesUser::checkAkses(43, 'read')) {
          return redirect('not-authorized');
      }

        $member = DB::table('d_mem')
            ->join('d_jabatan', 'm_jabatan', '=', 'j_id')
            ->leftJoin('d_mem_comp', 'mc_mem', '=', 'm_id')
            ->leftJoin('d_comp', 'c_id', '=', 'mc_comp')
            ->select('d_mem.*', 'd_jabatan.j_name', 'c_name')
            ->orderBy('m_name')
            ->get();

        return view('manajemen-pengguna.index', compact('member'));
    }

    public function edit($id)
    {
      if (!AksesUser::checkAkses(43, 'update')) {
          return redirect('not-authorized');
      }
        $id = Crypt::decrypt($id);
        $mem = DB::table('d_mem')
            ->join('d_jabatan', 'j_id', '=', 'm_jabatan')
            ->join('d_mem_comp', 'mc_mem', '=', 'm_id')
            ->join('d_comp', 'c_id', '=', 'mc_comp')
            ->select('d_mem.*', 'd_jabatan.*', 'c_id', 'c_name', DB::raw("DATE_FORMAT(m_birth_tgl, '%d') as tanggal"), DB::raw("DATE_FORMAT(m_birth_tgl, '%m') as bulan"), DB::raw("DATE_FORMAT(m_birth_tgl, '%Y') as tahun"))
            ->where('m_id', '=', $id)
            ->first();

        $jabatan = DB::table('d_jabatan')
            ->where('j_isactive', '=', 'Y')
            ->get();
        $comp = DB::table('d_comp')
            ->select('c_id', 'c_name')
            ->get();
        return view('manajemen-pengguna.edit', compact('jabatan', 'mem', 'comp'));
    }

    public function add()
    {
      if (!AksesUser::checkAkses(43, 'insert')) {
          return redirect('not-authorized');
      }
        $jabatan = DB::table('d_jabatan')
            ->where('j_isactive', '=', 'Y')
            ->get();
        $comp = DB::table('d_comp')
            ->select('c_id', 'c_name')
            ->get();
        return view('manajemen-pengguna.create', compact('jabatan', 'comp'));
    }

    public function cekUsername(Request $request)
    {
        $user = $request->username;
        $cek = DB::table('d_mem')
            ->where('m_username', '=', $user)
            ->get();
        if (count($cek) > 0){
            return response()->json([
                'status' => 'gagal'
            ]);
        } else {
            return response()->json([
                'status' => 'berhasil'
            ]);
        }
    }

    public function getId()
    {
        $cek = DB::table('d_mem')
            ->select(DB::raw('max(right(m_id, 7)) as id'))
            ->get();

        foreach ($cek as $x) {
            $temp = ((int)$x->id + 1);
            $kode = sprintf("%07s",$temp);
        }

        $tempKode = 'MEM' . $kode;
        return $tempKode;
    }

    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            return false;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function save(Request $request)
    {
      if (!AksesUser::checkAkses(43, 'insert')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try{
            $nama = $request->nama;
            $comp = $request->perusahaan;
            $user = $request->username;
            $pass = $request->password;
            $passAgain = $request->passwordagain;
            $jabatan = $request->jabatan;
            $birth = $request->tahun . '-' . $request->bulan . '-' . $request->tanggal;
            $alamat = $request->alamat;
            $m_id = $this->getId();

            $cek = $this->cekUsername($request);
            $cek = $cek->getData('status')['status'];
            if ($cek == 'gagal'){
                return redirect('manajemen-pengguna/pengguna')->with(['gagal' => 'Username tidak tersedia']);
            }
            if ($pass != $passAgain){
                return redirect('manajemen-pengguna/pengguna')->with(['gagal' => 'Password tidak sesuai']);
            }

            $pass = sha1(md5('passwordAllah') . $request->password);
            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'assets/img/user/' . $m_id;
            $this->deleteDir($dir);
            $childPath = $dir . '/';
            $path = $childPath;
            $file = $request->file('imageUpload');
            $name = null;
            if ($file != null) {
                $name = $folder . '.' . $file->getClientOriginalExtension();
                if (!File::exists($path)) {
                    if (File::makeDirectory($path, 0777, true)) {
                        $file->move($path, $name);
                        $imgPath = $childPath . $name;
                    } else
                        $imgPath = null;
                } else {
                    return 'already exist';
                }
            }

            DB::table('d_mem')
                ->insert([
                    'm_id' => $m_id,
                    'm_username' => $user,
                    'm_image' => $imgPath,
                    'm_passwd' => $pass,
                    'm_name' => ucwords(strtolower($nama)),
                    'm_jabatan' => $jabatan,
                    'm_birth_tgl' => $birth,
                    'm_addr' => $alamat,
                    'm_insert' => $tgl
                ]);

            DB::table('d_mem_comp')
                ->insert([
                    'mc_mem' => $m_id,
                    'mc_comp' => $comp,
                    'mc_lvl' => 11,
                    'mc_active' => 1,
                    'mc_insert' => $tgl
                ]);

            DB::commit();
            Session::flash('sukses', 'Data berhasil disimpan');
            return redirect('manajemen-pengguna/pengguna');
        } catch (\Exception $e){
            DB::rollback();
            Session::flash('gagal', 'Data gagal disimpan, cobalah sesaat lagi');
            return redirect('manajemen-pengguna/pengguna');
        }
    }

    public function update(Request $request)
    {
      if (!AksesUser::checkAkses(43, 'update')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try{
            $nama = $request->nama;
            $comp = $request->perusahaan;
            $user = $request->username;
            $pass = $request->password;
            $passAgain = $request->passwordagain;
            $jabatan = $request->jabatan;
            $birth = $request->tahun . '-' . $request->bulan . '-' . $request->tanggal;
            $alamat = $request->alamat;
            $m_id = $request->m_id;

            if ($pass != $passAgain){
                return redirect('manajemen-pengguna/pengguna')->with(['gagal' => 'Password tidak sesuai']);
            }

            $pass = sha1(md5('passwordAllah') . $request->password);
            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'assets/img/user/' . $m_id;
            $this->deleteDir($dir);
            $childPath = $dir . '/';
            $path = $childPath;
            $file = $request->file('imageUpload');
            $name = null;
            if ($file != null) {
                $name = $folder . '.' . $file->getClientOriginalExtension();
                if (!File::exists($path)) {
                    if (File::makeDirectory($path, 0777, true)) {
                        $file->move($path, $name);
                        $imgPath = $childPath . $name;
                    } else
                        $imgPath = null;
                } else {
                    return 'already exist';
                }
            }

            DB::table('d_mem')
                ->where('m_id', '=', $m_id)
                ->where('m_username', '=', $user)
                ->update([
                    'm_image' => $imgPath,
                    'm_passwd' => $pass,
                    'm_name' => ucwords(strtolower($nama)),
                    'm_jabatan' => $jabatan,
                    'm_birth_tgl' => $birth,
                    'm_addr' => $alamat,
                    'm_insert' => $tgl
                ]);

            DB::table('d_mem_comp')
                ->where('mc_mem', '=', $m_id)
                ->update([
                    'mc_comp' => $comp,
                    'mc_lvl' => 11,
                    'mc_active' => 1,
                    'mc_insert' => $tgl
                ]);

            DB::commit();
            Session::flash('sukses', 'Data berhasil disimpan');
            return redirect('manajemen-pengguna/pengguna');
        } catch (\Exception $e){
            DB::rollback();
            Session::flash('gagal', 'Data gagal disimpan, cobalah sesaat lagi');
            return redirect('manajemen-pengguna/pengguna');
        }
    }

    public function hapus($id)
    {
      if (!AksesUser::checkAkses(43, 'delete')) {
          return redirect('not-authorized');
      }
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            DB::table('d_mem')
                ->where('m_id', '=', $id)
                ->delete();

            DB::table('d_mem_comp')
                ->where('mc_mem', '=', $id)
                ->delete();
            DB::commit();
            Session::flash('sukses', 'Data berhasil dihapus');
            return redirect('manajemen-pengguna/pengguna');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('gagal', 'Data tidak berhasil dihapus, cobalah sesaat lagi');
            return redirect('manajemen-pengguna/pengguna');
        }
    }
}
