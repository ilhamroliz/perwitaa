<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes front acccounting
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

 Route::group(['middleware' => 'guest'], function () {
   Route::get('/', 'loginController@index');
   Route::post('login', 'loginController@authenticate');
   Route::get('login', 'loginController@authenticate');
   Route::get('maintenance', 'loginController@maintenance');
 });

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', 'loginController@logout');
    Route::get('dashboard', 'dashboardController@index');
    Route::get('profil', 'profilController@index');
    Route::get('profil/ubah-profil/{id}', 'profilController@ubahProfil');
    Route::post('profil/perbarui-profil', 'profilController@perbaruiProfil');
    Route::get('profil/perbarui-profil', 'profilController@perbaruiProfil');
    Route::get('profil/ubah-password/{id}', 'profilController@ubahPassword');
    Route::post('profil/perbarui-password', 'profilController@perbaruiPassword');
    Route::get('profil/perbarui-password', 'profilController@perbaruiPassword');

    Route::get('manajemen-pengguna/pengguna', 'manajemenPenggunaController@index');
    Route::get('manajemen-pengguna/tambah', 'manajemenPenggunaController@add');
    Route::post('manajemen-pengguna/simpan', 'manajemenPenggunaController@save');
    Route::post('manajemen-pengguna/update', 'manajemenPenggunaController@update');
    Route::get('manajemen-pengguna/edit/{id}', 'manajemenPenggunaController@edit');
    Route::get('manajemen-pengguna/hapus/{id}', 'manajemenPenggunaController@hapus');
    Route::get('manajemen-pengguna/cekUsername', 'manajemenPenggunaController@cekUsername');

    Route::get('master-jabatan', 'JabatanController@index');
    Route::post('master-jabatan/data', 'JabatanController@data');
    Route::post('master-jabatan/table', 'JabatanController@table');
    Route::post('master-jabatan/rename', 'JabatanController@rename');
    Route::post('master-jabatan/update', 'JabatanController@update');
    Route::post('master-jabatan/simpan', 'JabatanController@simpan');
    Route::post('master-jabatan/hapus', 'JabatanController@hapus');

    Route::get('master-perusahaan', 'PerusahaanController@index');
    Route::get('master-perusahaan/tambah', 'PerusahaanController@add');
    Route::post('master-perusahaan/data', 'PerusahaanController@data');
    Route::post('master-perusahaan/table', 'PerusahaanController@table');
    Route::post('master-perusahaan/table', 'PerusahaanController@table');
    Route::post('master-perusahaan/simpan', 'PerusahaanController@save');
    Route::post('master-perusahaan/update', 'PerusahaanController@update');
    Route::post('master-perusahaan/hapus', 'PerusahaanController@delete');
    Route::get('master-perusahaan/edit/{id}', 'PerusahaanController@edit');

    Route::get('manajemen-hak-akses/group', 'aksesGroupController@index');
    Route::get('manajemen-hak-akses/group/tambah', 'aksesGroupController@tambah');
    Route::get('manajemen-hak-akses/group-detail', 'aksesGroupController@detailGroup');
    Route::get('manajemen-hak-akses/group/simpan', 'aksesGroupController@simpan');
    Route::get('manajemen-hak-akses/group/{id}/edit', 'aksesGroupController@edit');


    //mitra yajra
    Route::get('manajemen-mitra/data-mitra','mitraController@index');
    Route::get('manajemen-mitra/data-mitra/table','mitraController@data');
    Route::get('manajemen-mitra/data-mitra/tambah','mitraController@tambah');
    Route::get('manajemen-mitra/data-mitra/simpan','mitraController@simpan');
    Route::get('manajemen-mitra/data-mitra/detail','mitraController@detail');
    Route::POST('manajemen-mitra/data-mitra/simpan','mitraController@simpan');
    Route::get('manajemen-mitra/data-mitra/{id}/edit','mitraController@edit');
    Route::get('manajemen-mitra/data-mitra/perbarui/{id}','mitraController@perbarui');
    Route::get('manajemen-mitra/data-mitra/hapus/{id}','mitraController@hapus');

    //mitra Contract
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra','mitraContractController@index');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/table','mitraContractController@data');
    Route::post('manajemen-kontrak-mitra/data-kontrak-mitra/table','mitraContractController@data');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/tambah','mitraContractController@tambah');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/simpan','mitraContractController@simpan');
    Route::post('manajemen-kontrak-mitra/data-kontrak-mitra/simpan','mitraContractController@simpan');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/cari','mitraContractController@cari');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/nomou','mitraContractController@nomou');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/searchresult','mitraContractController@searchresult');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/searchresult/getdata', 'mitraContractController@getdata');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/{idmitra}/{iddetail}/detail','mitraContractController@detail');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/{mitra}/{mc_contractid}/edit','mitraContractController@edit');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/perbarui/{mitra}/{mc_contractid}','mitraContractController@perbarui');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/update/{mitra}/{mc_contractid}','mitraContractController@update');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/hapus/{mitra}/{mc_contractid}','mitraContractController@hapus');
    Route::get('manajemen-kontrak-mitra/data-kontrak-mitra/getdivisi','mitraContractController@GetDivisi');

    //pegawai yajra
    Route::get('manajemen-pegawai/data-pegawai','pegawaiController@index');
    Route::get('manajemen-pegawai/data-pegawai/table','pegawaiController@data');
    Route::get('manajemen-pegawai/data-pegawai/tablecari','pegawaiController@tablecari');
    Route::get('manajemen-pegawai/data-pegawai/tambah','pegawaiController@tambah');
    Route::get('manajemen-pegawai/data-pegawai/simpan','pegawaiController@simpan');
    Route::post('manajemen-pegawai/data-pegawai/simpan','pegawaiController@simpan');
    Route::get('manajemen-pegawai/data-pegawai/{id}/edit','pegawaiController@edit');
    Route::get('manajemen-pegawai/data-pegawai/perbarui','pegawaiController@perbarui');
    Route::post('manajemen-pegawai/data-pegawai/perbarui','pegawaiController@perbarui');
    Route::get('manajemen-pegawai/data-pegawai/detail','pegawaiController@detail');
    Route::get('manajemen-pegawai/data-pegawai/detail_mutasi','pegawaiController@detail_mutasi');
    Route::get('manajemen-pegawai/data-pegawai/cari','pegawaiController@cari');
    Route::get('manajemen-pegawai/data-pegawai/getno','pegawaiController@getno');
    Route::get('manajemen-pegawai/data-pegawai/getdata','pegawaiController@getdata');

    //Pegawai Promosi & Demosi
    Route::get('manajemen-pegawai/promosidemosi','pegawaipromosiController@index');
    Route::get('manajemen-pegawai/promosidemosi/data','pegawaipromosiController@data');
    Route::post('manajemen-pegawai/promosidemosi/data','pegawaipromosiController@data');
    Route::get('manajemen-pegawai/promosidemosi/getdetail','pegawaipromosiController@getdetail');
    Route::get('manajemen-pegawai/promosidemosi/simpan','pegawaipromosiController@simpan');
    Route::post('manajemen-pegawai/promosidemosi/simpan','pegawaipromosiController@simpan');
    Route::get('manajemen-pegawai/promosidemosi/cari','pegawaipromosiController@cari');
    Route::get('manajemen-pegawai/promosidemosi/tabelcari','pegawaipromosiController@tabelcari');
    Route::get('manajemen-pegawai/promosidemosi/detail','pegawaipromosiController@detail');
    Route::get('manajemen-pegawai/promosidemosi/getno','pegawaipromosiController@getno');
    Route::get('manajemen-pegawai/promosidemosi/getdata','pegawaipromosiController@getdata');
    Route::get('manajemen-pegawai/promosidemosi/hapus','pegawaipromosiController@hapus');
    Route::get('manajemen-pegawai/promosidemosi/edit','pegawaipromosiController@edit');
    Route::get('manajemen-pegawai/promosidemosi/update/{id}','pegawaipromosiController@update');

    //Pegawai Remunerasi
    Route::get('manajemen-pegawai/pegawairemunerasi','pegawairemunerasiController@index');
    Route::get('manajemen-pegawai/pegawairemunerasi/cari','pegawairemunerasiController@cari');
    Route::get('manajemen-pegawai/pegawairemunerasi/simpan/{id}','pegawairemunerasiController@simpan');
    Route::post('manajemen-pegawai/pegawairemunerasi/simpan/{id}','pegawairemunerasiController@simpan');
    Route::get('manajemen-pegawai/pegawairemunerasi/getdata','pegawairemunerasiController@getdata');
    Route::get('manajemen-pegawai/pegawairemunerasi/carino','pegawairemunerasiController@carino');
    Route::get('manajemen-pegawai/pegawairemunerasi/data','pegawairemunerasiController@data');
    Route::get('manajemen-pegawai/pegawairemunerasi/update/{id}','pegawairemunerasiController@update');
    Route::get('manajemen-pegawai/pegawairemunerasi/getcari','pegawairemunerasiController@getcari');
    Route::get('manajemen-pegawai/pegawairemunerasi/detail','pegawairemunerasiController@detail');
    Route::get('manajemen-pegawai/pegawairemunerasi/hapus','pegawairemunerasiController@hapus');

    //Pegawai PHK
    Route::get('manajemen-pegawai/pegawaiphk','pegawaiphkController@index');
    Route::get('manajemen-pegawai/pegawaiphk/carino','pegawaiphkController@carino');
    Route::get('manajemen-pegawai/pegawaiphk/getdata','pegawaiphkController@getdata');
    Route::get('manajemen-pegawai/pegawaiphk/simpan/{id}','pegawaiphkController@simpan');
    Route::post('manajemen-pegawai/pegawaiphk/simpan/{id}','pegawaiphkController@simpan');
    Route::get('manajemen-pegawai/pegawaiphk/cari','pegawaiphkController@cari');
    Route::get('manajemen-pegawai/pegawaiphk/data','pegawaiphkController@data');
    Route::get('manajemen-pegawai/pegawaiphk/getcari','pegawaiphkController@getcari');
    Route::get('manajemen-pegawai/pegawaiphk/detail','pegawaiphkController@detail');
    Route::get('manajemen-pegawai/pegawaiphk/hapus','pegawaiphkController@hapus');

    //BPJS
    Route::get('manajemen-pegawai/data-pegawai','pegawaiController@index');
    Route::get('manajemen-pegawai/data-pegawai/table','pegawaiController@data');
    Route::get('manajemen-pegawai/data-pegawai/tambah','pegawaiController@tambah');
    Route::get('manajemen-pegawai/data-pegawai/simpan','pegawaiController@simpan');
    Route::get('manajemen-pegawai/data-pegawai/{id}/edit','pegawaiController@edit');
    Route::get('manajemen-pegawai/data-pegawai/perbarui/{id}','pegawaiController@perbarui');
    Route::get('manajemen-pegawai/data-pegawai/hapus/{id}','pegawaiController@hapus');

    //======== Faskes
    Route::get('manajemen-faskes','faskesController@index');
    Route::get('manajemen-faskes/simpan','faskesController@save');

    //pekerja yajra
    Route::get('manajemen-pekerja/data-pekerja','pekerjaController@index');
    Route::POST('manajemen-pekerja/data-pekerja/table','pekerjaController@data');
    Route::get('manajemen-pekerja/data-pekerja/table','pekerjaController@data');
    Route::POST('manajemen-pekerja/data-pekerja/tablenon','pekerjaController@dataEx');
    Route::get('manajemen-pekerja/data-pekerja/tablenon','pekerjaController@dataEx');
    Route::POST('manajemen-pekerja/data-pekerja/tablecalon','pekerjaController@dataCalon');
    Route::get('manajemen-pekerja/data-pekerja/tablecalon','pekerjaController@dataCalon');
    Route::get('manajemen-pekerja/data-pekerja/tambah','pekerjaController@tambah');
    Route::get('manajemen-pekerja/data-pekerja/simpan','pekerjaController@simpan');
    Route::POST('manajemen-pekerja/data-pekerja/simpan','pekerjaController@simpan');
    Route::get('manajemen-pekerja/data-pekerja/{id}/edit','pekerjaController@edit');
    Route::get('manajemen-pekerja/data-pekerja/perbarui/','pekerjaController@perbarui');
    Route::POST('manajemen-pekerja/data-pekerja/perbarui/','pekerjaController@perbarui');
    Route::get('manajemen-pekerja/data-pekerja/hapus/{id}','pekerjaController@hapus');
    Route::get('manajemen-pekerja/data-pekerja/detail','pekerjaController@detail');
    Route::get('manajemen-pekerja/data-pekerja/resign','pekerjaController@resign');
    Route::get('manajemen-pekerja/data-pekerja/detail-mutasi','pekerjaController@detail_mutasi');

    Route::get('manajemen-pekerja/rekening','rekeningController@index');
    Route::get('manajemen-pekerja/rekening/getdata','rekeningController@getData');
    Route::post('manajemen-pekerja/rekening/simpan','rekeningController@save');


    //mitra-pekerja
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra','mitraPekerjaController@index');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/table','mitraPekerjaController@data');
    Route::post('manajemen-pekerja-mitra/data-pekerja-mitra/table','mitraPekerjaController@data');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/tambah','mitraPekerjaController@tambah');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/lanjut','mitraPekerjaController@lanjutkan');
    Route::post('manajemen-pekerja-mitra/data-pekerja-mitra/lanjut','mitraPekerjaController@lanjutkan');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/lanjutkan', [
            'uses' => 'mitraPekerjaController@lanjutkan',
            'as' => 'mitraPekerjaController.lanjutkan'
    ]);
    Route::post('manajemen-pekerja-mitra/data-pekerja-mitra/lanjutkan','mitraPekerjaController@lanjutkan');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/simpan','mitraPekerjaController@simpan');
    Route::post('manajemen-pekerja-mitra/data-pekerja-mitra/simpan','mitraPekerjaController@simpan');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/{mitra}/{id_detail}/edit','mitraPekerjaController@edit');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/perbarui/{mitra}/{mc_contractid}','mitraPekerjaController@perbarui');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/update','mitraPekerjaController@update');
    Route::post('manajemen-pekerja-mitra/data-pekerja-mitra/update','mitraPekerjaController@update');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/hapus/{mitra}/{iddetail}','mitraPekerjaController@hapus');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/delete/{mp_pekerja}/{mp_contract}','suratController@delete');
    Route::get('get-data-mitra-kontrak/{mitra}/{kontrak}','mitraPekerjaController@mitraContrak');
    Route::post('get-data-mitra-kontrak/{mitra}/{kontrak}','mitraPekerjaController@mitraContrak');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/cari','mitraPekerjaController@cari');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/cari/pencarian','mitraPekerjaController@pencarian');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/cari/getData','mitraPekerjaController@getDataPencarian');
    Route::get('manajemen-pekerja-mitra/data-pekerja-mitra/selesai','mitraPekerjaController@selesai');

    //penerimaan-pekerja
    Route::get('manajemen-pekerja-mitra/penerimaan-pekerja-mitra','PenerimaanPekerjaController@index');
    Route::get('manajemen-pekerja-mitra/penerimaan-pekerja-mitra/getNomor','PenerimaanPekerjaController@getNomor');
    Route::get('manajemen-pekerja-mitra/penerimaan-pekerja-mitra/simpan','PenerimaanPekerjaController@save');

    //======= SP Pekerja
    Route::get('manajemen-pekerja/surat-peringatan','SuratPeringatanController@index');
    Route::get('manajemen-pekerja/surat-peringatan/data','SuratPeringatanController@data');
    Route::get('manajemen-pekerja/surat-peringatan/filter','SuratPeringatanController@filter');
    Route::get('manajemen-pekerja/surat-peringatan/getpelanggaran','SuratPeringatanController@getpelanggaran');
    Route::get('manajemen-pekerja/surat-peringatan/simpan/{id}','SuratPeringatanController@simpan');
    Route::post('manajemen-pekerja/surat-peringatan/simpan/{id}','SuratPeringatanController@simpan');
    Route::get('manajemen-pekerja/surat-peringatan/getsp','SuratPeringatanController@getsp');
    Route::get('manajemen-pekerja/surat-peringatan/getdata','SuratPeringatanController@getdata');
    Route::get('manajemen-pekerja/surat-peringatan/cari','SuratPeringatanController@cari');
    Route::get('manajemen-pekerja/surat-peringatan/hapus','SuratPeringatanController@hapus');
    Route::get('manajemen-pekerja/surat-peringatan/getcari','SuratPeringatanController@getcari');
    Route::get('manajemen-pekerja/surat-peringatan/detail','SuratPeringatanController@detail');
    Route::get('manajemen-pekerja/surat-peringatan/edit','SuratPeringatanController@edit');
    Route::get('manajemen-pekerja/surat-peringatan/print','SuratPeringatanController@print');
    Route::get('manajemen-pekerja/surat-peringatan/update/{id}','SuratPeringatanController@update');
    Route::post('manajemen-pekerja/surat-peringatan/update/{id}','SuratPeringatanController@update');

    //======= Promosi & Demosi
    Route::get('manajemen-pekerja/promosi-demosi','promosiController@index');
    Route::get('manajemen-pekerja/promosi-demosi/getData','promosiController@getData');
    Route::post('manajemen-pekerja/promosi-demosi/getData','promosiController@getData');
    Route::get('manajemen-pekerja/promosi-demosi/getdetail','promosiController@getdetail');
    Route::get('manajemen-pekerja/promosi-demosi/simpan','promosiController@save');
    Route::post('manajemen-pekerja/promosi-demosi/simpan','promosiController@save');
    Route::get('manajemen-pekerja/promosi-demosi/cari','promosiController@cari');
    Route::get('manajemen-pekerja/promosi-demosi/data','promosiController@data');
    Route::get('manajemen-pekerja/promosi-demosi/getno','promosiController@getno');
    Route::get('manajemen-pekerja/promosi-demosi/getcari','promosiController@getcari');
    Route::get('manajemen-pekerja/promosi-demosi/detail','promosiController@detail');
    Route::get('manajemen-pekerja/promosi-demosi/hapus','promosiController@hapus');
    Route::get('manajemen-pekerja/promosi-demosi/edit','promosiController@edit');
    Route::get('manajemen-pekerja/promosi-demosi/print','promosiController@print');
    Route::get('manajemen-pekerja/promosi-demosi/update/{id}','promosiController@update');
    Route::post('manajemen-pekerja/promosi-demosi/update/{id}','promosiController@update');

    //seragam
    Route::get('manajemen-seragam/data-seragam','seragamController@index');
    Route::get('manajemen-seragam/data-seragam/data','seragamController@data');
    Route::get('manajemen-seragam/data-seragam/{id}/edit','seragamController@edit');
    Route::get('manajemen-seragam/data-seragam/tambah','seragamController@tambah');
    Route::get('manajemen-seragam/data-seragam/simpan','seragamController@simpan');
    Route::get('manajemen-seragam/data-seragam/perbarui/{id}','seragamController@perbarui');
    Route::get('manajemen-seragam/data-seragam/hapus/{id}','seragamController@hapus');

    Route::get('ambil-data-supplier/autocomplete','supplierController@ambilSupplier');

    // Penerimaan pengeluaran barang

    Route::get('manajemen-seragam/penerimaan-pengeluaran/','penerimaanPengeluaran@index');
    // ================================================

    //red

    Route::get('manajemen-akun/auto-generate-akun','d_comp_coaController@generate_akun');
    Route::get('manajemen-akun/data-akun','d_comp_coaController@index');
    Route::get('manajemen-akun/data-akun/delete/{id}','d_comp_coaController@delete');
    Route::get('manajemen-akun/data-akun/{id}/edit','d_comp_coaController@edit');
    Route::get('manajemen-akun/data-akun/update/{id}','d_comp_coaController@update');
    Route::get('manajemen-akun/data-akun/sub_akun/{id}','d_comp_coaController@create_sub_akun');
    Route::get('manajemen-akun/data-akun/simpan','d_comp_coaController@store');

    //neraca
    Route::get('laporan-keuangan/neraca', [
            'uses' => 'neracaController@neracaindex',
            'as' => 'neracaController.neracaindex'
    ]);
    Route::get('laporan-keuangan/neraca/table', [
            'uses' => 'neracaController@neraca',
            'as' => 'neracaController.neraca'
    ]);
    Route::get('laporan-keuangan/neraca/cari-neraca/{bulan}', [
            'uses' => 'neracaController@cari_neraca',
            'as' => 'neracaController.cari_neraca'
    ]);
    Route::get('laporan-keuangan/neraca/cari-neraca-final/{bulan}', [
            'uses' => 'neracaController@cari_neraca_final',
            'as' => 'neracaController.cari_neraca_final'
    ]);
    Route::get('laporan-keuangan/neraca-per', [
            'uses' => 'laporan_keuanganController@neracaper',
            'as' => 'laporan_keuanganController.neracaper'
    ]);
    //neraca

    //laba rugi
    Route::get('laporan-keuangan/laba-rugi', [
            'uses' => 'labaRugiController@labarugiIndex',
            'as' => 'laporan_keuanganController.labarugi'
    ]);
    Route::get('laporan-keuangan/laba-rugi/table', [
            'uses' => 'labaRugiController@labarugi',
            'as' => 'laporan_keuanganController.labarugi'
    ]);
    Route::get('laporan-keuangan/laba-rugi-percobaan/per/{bulan}', [
            'uses' => 'labaRugiController@labarugiPercobaanPer',
            'as' => 'labaRugiController.labarugiPercobaanPer'
    ]);
    Route::get('laporan-keuangan/laba-rugi-percobaan/periode/{bulan}', [
            'uses' => 'labaRugiController@labarugiPercobaanPeriode',
            'as' => 'labaRugiController.labarugiPercobaanPeriode'
    ]);
    Route::get('laporan-keuangan/laba-rugi-final/per/{bulan}', [
            'uses' => 'labaRugiController@labarugiFinalPer',
            'as' => 'labaRugiController.labarugiFinalPer'
    ]);
    Route::get('laporan-keuangan/laba-rugi-final/periode/{bulan}', [
            'uses' => 'labaRugiController@labarugiFinalPeriode',
            'as' => 'labaRugiController.labarugiFinalPeriode'
    ]);
    //laba rugi


    //arus khas
    Route::get('laporan-keuangan/arus-kas', [
            'uses' => 'arusKasController@aruskasIndex',
            'as' => 'arusKasController.aruskasindex'
    ]);
    Route::get('laporan-keuangan/arus-kas/table', [
            'uses' => 'arusKasController@aruskas',
            'as' => 'arusKasController.aruskas'
    ]);
    Route::get('laporan-keuangan/arus-kas-percobaan/per/{bulan}', [
            'uses' => 'arusKasController@aruskasPercobaanPer',
            'as' => 'arusKasController.aruskasPercobaanPer'
    ]);
    Route::get('laporan-keuangan/arus-kas-percobaan/periode/{bulan}', [
            'uses' => 'arusKasController@aruskasPercobaanPeriode',
            'as' => 'arusKasController.aruskasPercobaanPeriode'
    ]);
    Route::get('laporan-keuangan/arus-kas-final/per/{bulan}', [
            'uses' => 'arusKasController@aruskasFinalPer',
            'as' => 'arusKasController.aruskasPercobaanPer'
    ]);
    Route::get('laporan-keuangan/arus-kas-final/periode/{bulan}', [
            'uses' => 'arusKasController@aruskasFinalPeriode',
            'as' => 'arusKasController.aruskasPercobaanPeriode'
    ]);

    Route::get('laporan-keuangan/arus-kas/periode/tahun', [
            'uses' => 'laporan_keuanganController@arus_khas_periode_tahun',
            'as' => 'laporan_keuanganController.arus_khas_periode'
    ]);
    Route::get('laporan-keuangan/arus-kas/periode/bulan', [
            'uses' => 'laporan_keuanganController@arus_khas_periode_bulan',
            'as' => 'laporan_keuanganController.arus_khas_periode_bulan'
    ]);
        //---------arus khas selesai

    //entri transaksi
    Route::get('entri-transaksi/data-transaksi', [
            'uses' => 'entri_transaksiController@index',
            'as' => 'entri_transaksiController.index'
    ]);
    Route::get('entri-transaksi/data-transaksi/get', [
            'uses' => 'entri_transaksiController@index_data',
            'as' => 'entri_transaksiController.index_data'
    ]);
    Route::get('entri-transaksi/data-transaksi/cari_tanggal/get', [
            'uses' => 'entri_transaksiController@cari_tanggal_get',
            'as' => 'entri_transaksiController.cari_tanggal_get'
    ]);
        //entri transaksi_tanggal


    Route::get('entri-transaksi/data-transaksi/create', [
            'uses' => 'entri_transaksiController@create',
            'as' => 'entri_transaksiController.create'
    ]);
    Route::get('entri-transaksi/data-transaksi/store', [
            'uses' => 'entri_transaksiController@store',
            'as' => 'entri_transaksiController.store'
    ]);
    Route::get('entri-transaksi/data-transaksi/edit/{id}', [
            'uses' => 'entri_transaksiController@edit',
            'as' => 'entri_transaksiController.edit'
    ]);
    Route::get('entri-transaksi/data-transaksi/duplikasi/{id}', [
            'uses' => 'entri_transaksiController@duplikasi_transaksi',
            'as' => 'entri_transaksiController.duplikasi_transaksi'
    ]);
    Route::get('entri-transaksi/data-transaksi/simpan-duplikasi/{id}', [
            'uses' => 'entri_transaksiController@simpanduplikasi',
            'as' => 'entri_transaksiController.edit'
    ]);
    Route::get('entri-transaksi/data-transaksi/update/{id}', [
            'uses' => 'entri_transaksiController@update',
            'as' => 'entri_transaksiController.update'
    ]);
    Route::DELETE('entri-transaksi/data-transaksi/destroy/{id}', [
            'uses' => 'entri_transaksiController@destroy',
            'as' => 'entri_transaksiController.destroy'
    ]);
    			//----------entri transaksi selesai--------

    //d_comp_trans
    Route::get('data-master/master-transaksi-akun', [
            'uses' => 'd_comp_transController@index_view',
            'as' => 'd_comp_trans.index_view'
    ]);
    Route::get('data-master/master-transaksi-akun/index_view', [
            'uses' => 'd_comp_transController@index_view',
            'as' => 'd_comp_trans.index'
    ]);
    Route::get('data-master/master-transaksi-akun/data', [
            'uses' => 'd_comp_transController@index_data',
            'as' => 'd_comp_trans.index'
    ]);
    Route::get('data-master/master-transaksi-akun/create', [
            'uses' => 'd_comp_transController@create',
            'as' => 'd_comp_trans.create'
    ]);
    Route::get('data-master/master-transaksi-akun/store', [
            'uses' => 'd_comp_transController@store',
            'as' => 'd_comp_trans.store'
    ]);
    Route::get('data-master/master-transaksi-akun/edit/{tr_code}/{tr_codesub}', [
            'uses' => 'd_comp_transController@edit',
            'as' => 'd_comp_trans.edit'
    ]);
    Route::get('data-master/master-transaksi-akun/update/{id}/{tr_codesub}', [
            'uses' => 'd_comp_transController@update',
            'as' => 'd_comp_trans.update'
    ]);
    Route::Delete('data-master/master-transaksi-akun/delete/{id}/{tr_code}', [
            'uses' => 'd_comp_transController@destroy',
            'as' => 'd_comp_trans.destroy'
    ]);
    Route::get('data-master/master-transaksi-akun/kode/{id}', [
            'uses' => 'd_comp_transController@kode',
            'as' => 'd_comp_trans.kode'
    ]);
    Route::get('data-master/master-transaksi-akun/cheknama/{nama}/{kode}', [

         'uses' => 'd_comp_transController@chekNamaTransaksi',
            'as' => 'd_comp_trans.chekNamaTransaksi'

    ]);
    Route::get('data-master/master-transaksi-akun/set-akun/{code}/{cashtype}', [
            'uses' => 'd_comp_transController@setAkun',
            'as' => 'd_comp_trans.setAkun'
    ]);

                //---selesai d_comp_trans

    //d_comp_trans
    Route::get('bpjs','bpjsController@index');
    Route::get('select','bpjsController@select');
    Route::get('bpjs/create','bpjsController@create');
    Route::post('bpjs/update&{p_nik}','bpjsController@update');
    Route::get('bpjs/delete/{no_kartu}','bpjsController@delete');
    Route::post('bpjs','bpjsController@tambahdata');
    Route::post('bpjs/store','bpjsController@store');
    Route::get('bpjs/create/autocomplete','bpjsController@autocomplete');
    Route::get('bpjs/edit/autocomplete','bpjsController@autocomplete');
    Route::get('set-nama/{p_nik}','bpjsController@setnama');
    Route::get('bpjs/edit&{p_nik}','bpjsController@edit');

    //HALAMAN FORM SURAT
    Route::get('surat/create','suratController@create'); //surat pengalaman
    Route::get('surat/create-tkerja','suratController@create1'); //surat tidak lagi bekerja
    Route::get('surat/create-daupa','suratController@create2'); //surat data upah
    Route::get('surat/create-tibpjs','suratController@create3'); //surat tidak aktif bpjs
    Route::get('surat/create-resign','suratController@create4'); //surat pekerja resign
    Route::get('surat/create-pibank','suratController@create5'); //surat pinjam bank
    Route::get('surat/create-pebpjs','suratController@create6'); //surat pendaftaran bpjs kesehatan
    Route::get('surat/create-pekpr','suratController@create7'); //surat pengajuan kpr
    //CETAK DATA DI LINK TAMBAH
    Route::get('surat/laporan-legalisir-data-upah','suratController@gege'); //CETAK UPAH
    Route::get('surat/laporan-pengalaman-kerja','suratController@gege1'); //CETAK PENGALAMAN KERJA
    Route::get('surat/laporan-pekerja-resign','suratController@gege2'); //CETAK RESIGN KERJA
    Route::get('surat/laporan-pinjam-bank','suratController@gege3'); //CETAK PINJAM BANK
    Route::get('surat/laporan-pengajuan-kpr','suratController@gege4'); //CETAK PENGAJUAN KPR
    Route::get('surat/laporan-pendaftaran-bpjs','suratController@gege5'); //CETAK PENDAFTARAN BPJS
    Route::get('surat/laporan-tidak-aktif-bpjs','suratController@gege6'); //CETAK TIDAK AKTIF BPJS
    Route::get('surat/laporan-tidak-lagi-bekerja','suratController@gege7'); //CETAK TIDAK BEKERJA
    //FUNCTION SIMPAN
    Route::get('surat/store','suratController@store'); //SIMPAN DATA MAINDATA
    Route::get('surat/store1','suratController@store1'); //SIMPAN DATA PENGALAMAN KERJA
    Route::get('surat/store2','suratController@store2'); //DATA UPAH
    Route::get('surat/store3','suratController@store3'); //PINJAM BANK
    Route::get('surat/store4','suratController@store4'); //PENDAFTARAN BPJS
    Route::get('surat/store5','suratController@store5'); //PE KPR
    //EDIT
    Route::get('surat/edit-utama/{id_surat}','suratController@edit0');
    Route::get('surat/edit/{id_surat}','suratController@edit');
    Route::get('surat/edit/edit-tkerja/{id_surat}','suratController@edit1');
    Route::get('surat/edit/edit-daupa/{id_surat}','suratController@edit2');
    Route::get('surat/edit/edit-tibpjs/{id_surat}','suratController@edit3');
    Route::get('surat/edit/edit-resign/{id_surat}','suratController@edit4');
    Route::get('surat/edit/edit-pibank/{id_surat}','suratController@edit5');
    Route::get('surat/edit/edit-pebpjs/{id_surat}','suratController@edit6');
    Route::get('surat/edit/edit-pekpr/{id_surat}','suratController@edit7');


    //UPDATE

    Route::post('surat/update1&{id_surat}','suratController@update1');

    //INDEX
    Route::get('surat','suratController@index');
    //DELETE
    Route::get('surat/delete/{id_surat}','suratController@delete');
    //CETAK
    Route::get('surat/cetak/{id_surat}','suratController@cetak');
    Route::get('surat/cetak2/{id_surat}','suratController@cetak2');
    Route::get('surat/cetak3/{id_surat}','suratController@cetak3');
    Route::get('surat/cetak4/{id_surat}','suratController@cetak4');
    Route::get('surat/cetak5/{id_surat}','suratController@cetak5');
    Route::get('surat/cetak6/{id_surat}','suratController@cetak6');
    Route::get('surat/cetak7/{id_surat}','suratController@cetak7');
    Route::get('surat/laporan/{id_surat}','suratController@laporan');
    //Autocomplete
    Route::get('surat/create/autocomplete','suratController@autocomplete');
    Route::get('surat/create/auto','suratController@auto');
    Route::get('getData/{p_id}','suratController@getData');
    Route::get('getDatanama/{p_id}','suratController@getDatanama');

    //PEKERJA-DI-MITRA
    Route::get('pekerja-di-mitra/pekerja-mitra','pdmController@index');
    Route::get('pekerja-di-mitra/pekerja-mitra/table','pdmController@data');
    Route::get('pekerja-di-mitra/edit/{mp_id}/{p_id}','pdmController@edit');
    Route::get('pekerja-di-mitra/hapus','pdmController@destroy');
    Route::get('pekerja-di-mitra/hapus/{mp_pekerja}','pdmController@hapus');
    Route::get('pekerja-di-mitra/update&{mp_id}','pdmController@update');
    Route::get('pekerja-di-mitra/getdivisi', 'pdmController@getdivisi');
    Route::get('pekerja-di-mitra/getpekerja', 'pdmController@getpekerja');
    Route::post('pekerja-di-mitra/getpekerja', 'pdmController@getpekerja');
    Route::get('pekerja-di-mitra/getnomor', 'pdmController@getnomor');
    Route::get('pekerja-di-mitra/getdata', 'pdmController@getdata');
    Route::get('pekerja-di-mitra/getnik', 'pdmController@getnik');
    Route::get('pekerja-di-mitra/simpannik', 'pdmController@simpannik');

    //================= master item ilham ========================
    Route::get('master-item', [
                    'uses' => 'ItemController@index',
                    'as' => 'master-item'
                ]);
    Route::get('master-item/create', [
                    'uses' => 'ItemController@create',
                    'as' => 'master-item.create'
                ]);
    Route::get('manajemen-seragam/master-seragam','ItemController@index');
    Route::post('master-item/save','ItemController@save');
    Route::get('master-item/save','ItemController@save');
    Route::get('master-item/edit/{id}','ItemController@edit');
    Route::get('master-item/get-data-y','ItemController@GetDataY');
    Route::get('master-item/get-data-n','ItemController@GetDataN');
    Route::get('master-item/get-data-a','ItemController@GetDataA');
    Route::post('master-item/get-data-y','ItemController@GetDataY');
    Route::post('master-item/get-data-n','ItemController@GetDataN');
    Route::post('master-item/get-data-a','ItemController@GetDataA');
    Route::get('autoitem','ItemController@autoitem');
    Route::get('master-item/tambah-supplier/{id}','ItemController@AddSupp');
    Route::get('master-item/update','ItemController@update');
    Route::post('master-item/update','ItemController@update');
    Route::get('master-item/delete','ItemController@delete');
    Route::get('master-item/getInfo','ItemController@getInfo');
    Route::get('master-item/addmitra', 'ItemController@addmitra');

    //================= master supplier ilham ========================
    Route::get('master-supplier', [
                    'uses' => 'SupplierController@index',
                    'as' => 'master-supplier'
                ]);
    Route::get('manajemen-seragam/master-supplier','supplierController@index');
    Route::get('master-supplier/get-data-y','supplierController@GetDataY');
    Route::get('master-supplier/get-data-n','supplierController@GetDataN');
    Route::get('master-supplier/get-data-a','supplierController@GetDataA');
    Route::get('autosupp','supplierController@autosupp');
    Route::get('master-supplier/simpan','supplierController@save');
    Route::post('master-supplier/simpan','supplierController@save');
    Route::get('master-supplier/edit','supplierController@edit');
    Route::get('master-supplier/hapus','supplierController@delete');
    Route::get('master-supplier/getSupplier','supplierController@getSupplier');
    //=============== manajemen pembelian =====================
    Route::get('manajemen-seragam/pembelian','PembelianController@index');
    Route::get('manajemen-seragam/tambah','PembelianController@create');
    Route::get('manajemen-seragam/gunakan-rencana-pembelian','PembelianController@createKhusus');
    Route::get('manajemen-seragam/getnotarencana','PembelianController@getNotaRencana');
    Route::get('manajemen-seragam/getnotarencana/detail','PembelianController@detailRencana');
    Route::get('manajemen-seragam/pembelian/cari','PembelianController@cari');
    Route::get('manajemen-seragam/getnota','PembelianController@getnota');
    Route::get('manajemen-seragam/getdata','PembelianController@getdata');
    Route::get('manajemen-seragam/filter','PembelianController@filter');
    Route::get('manajemen-seragam/detail','PembelianController@detail');
    Route::get('manajemen-seragam/print/{id}','PembelianController@cetak');
    Route::get('manajemen-pembelian/getItem','PembelianController@getItem');
    Route::get('manajemen-pembelian/simpan','PembelianController@save');
    Route::post('manajemen-pembelian/simpan','PembelianController@save');
    Route::post('manajemen-pembelian/update','PembelianController@update');
    Route::get('manajemen-pembelian/update','PembelianController@update');
    Route::get('manajemen-pembelian/getDetail','PembelianController@getDetail');
    Route::get('manajemen-pembelian/hapus','PembelianController@getDetail');
    Route::get('manajemen-seragam/edit','PembelianController@edit');
    Route::get('manajemen-seragam/printnota','PembelianController@printnota');

    //============== rencana pembelian ==============
    Route::get('manajemen-seragam/rencana-pembelian','RencanaPembelian@index');
    Route::get('manajemen-seragam/rencana-pembelian/tambah','RencanaPembelian@add');
    Route::get('manajemen-seragam/rencana-pembelian/simpan','RencanaPembelian@save');
    Route::post('manajemen-seragam/rencana-pembelian/simpan','RencanaPembelian@save');
    Route::post('manajemen-seragam/rencana-pembelian/getData','RencanaPembelian@data');
    Route::get('manajemen-seragam/rencana-pembelian/getData','RencanaPembelian@data');
    Route::get('manajemen-seragam/rencana-pembelian/getDetail','RencanaPembelian@detail');
    Route::post('manajemen-seragam/rencana-pembelian/getDetail','RencanaPembelian@detail');
    Route::post('manajemen-seragam/rencana-pembelian/hapus','RencanaPembelian@hapus');
    Route::get('manajemen-seragam/rencana-pembelian/hapus','RencanaPembelian@hapus');
    Route::get('manajemen-seragam/rencana-pembelian/edit','RencanaPembelian@edit');
    Route::post('manajemen-seragam/rencana-pembelian/update','RencanaPembelian@update');
    Route::get('manajemen-seragam/rencana-pembelian/update','RencanaPembelian@update');
    Route::get('manajemen-seragam/rencana-pembelian/print','RencanaPembelian@print');
    Route::get('manajemen-seragam/rencana-pembelian/printwithnota','RencanaPembelian@printwithnota');

    //============== penerimaan ===============
    Route::get('manajemen-seragam/penerimaan','PenerimaanController@index');

    Route::get('manajemen-seragam/penerimaan/cari','PenerimaanController@history');
    Route::get('manajemen-seragam/penerimaan/find-history','PenerimaanController@findHistory');

    Route::get('manajemen-seragam/penerimaan/cariHistory','PenerimaanController@cariHistory');
    Route::get('manajemen-seragam/penerimaan/detailHistory','PenerimaanController@detailHistory');
    Route::get('manajemen-pembelian/carinota','PenerimaanController@cari');
    Route::get('manajemen-pembelian/penerimaan/update','PenerimaanController@update');
    Route::post('manajemen-pembelian/penerimaan/update','PenerimaanController@update');
    Route::get('manajemen-pembelian/print','PenerimaanController@print');

    //============== manajemen penjualan =========
    Route::get('manajemen-seragam/pengeluaran','PenjualanController@index');
    Route::get('manajemen-seragam/data','PenjualanController@data');
    Route::post('manajemen-seragam/data','PenjualanController@data');
    Route::get('manajemen-seragam/tambah-pengeluaran','PenjualanController@create');
    Route::get('manajemen-seragam/countpekerja','PenjualanController@countpekerja');
    Route::get('manajemen-seragam/history','PenjualanController@history');
    Route::get('manajemen-seragam/cariHistory','PenjualanController@cariHistory');
    Route::get('manajemen-seragam/findHistory','PenjualanController@findHistory');
    Route::get('manajemen-penjualan/getItem','PenjualanController@getItem');
    Route::get('manajemen-penjualan/getPekerja','PenjualanController@getPekerja');
    Route::get('manajemen-penjualan/save','PenjualanController@save');
    Route::post('manajemen-penjualan/save','PenjualanController@save');
    Route::get('manajemen-penjualan/hapus', 'PenjualanController@hapus');
    Route::get('manajemen-penjualan/detail', 'PenjualanController@detail');
    Route::get('manajemen-penjualan/edit', 'PenjualanController@edit');
    Route::get('manajemen-penjualan/update', 'PenjualanController@update');
    Route::get('manajemen-penjualan/search/{mitra}', 'PenjualanController@search');

    //============= mutasi stock
    Route::get('manajemen-stock/mutasi-stock/tabel', 'StockMutController@tabel');
    Route::get('manajemen-stock/mutasi-stock/tabel2', 'StockMutController@tabel2');
    Route::get('manajemen-stock/mutasi-stock', 'StockMutController@index');
    Route::get('manajemen-stock/mutasi-stock/get_gudang', 'StockMutController@get_gudang');
    Route::get('manajemen-stock/mutasi-stock/get_barang', 'StockMutController@get_barang');

    //============== data stock
    Route::get('manajemen-stock/data-stock/tabel', 'StockDataController@tabel');
    Route::get('manajemen-stock/data-stock/tabel2', 'StockDataController@tabel2');
    Route::get('manajemen-stock/data-stock', 'StockDataController@index');
    Route::get('manajemen-stock/data-stock/printall', 'StockDataController@printall');
    Route::get('manajemen-stock/data-stock/print', 'StockDataController@print');
    Route::get('manajemen-stock/data-stock/getpilih', 'StockDataController@getpilih');
    Route::get('manajemen-stock/data-stock/getprint', 'StockDataController@getprint');
    Route::get('manajemen-stock/data-stock/get_gudang', 'StockDataController@get_gudang');
    Route::get('manajemen-stock/data-stock/get_barang', 'StockDataController@get_barang');

    //============= pembayaran seragam
    Route::get('manajemen-seragam/pembayaran-seragam', 'PembayaranController@index');
    Route::get('manajemen-seragam/pembayaran-pekerja', 'PembayaranController@bayar');
    Route::get('manajemen-seragam/getPekerja', 'PembayaranController@getPekerja');
    Route::post('manajemen-seragam/simpan', 'PembayaranController@save');
    Route::get('manajemen-seragam/simpan', 'PembayaranController@save');
    Route::get('manajemen-seragam/getInfoPembayaran', 'PembayaranController@getInfoPembayaran');
    Route::get('manajemen-seragam/pembayaran-seragam/history', 'PembayaranController@history');
    Route::get('manajemen-seragam/pembayaran-seragam/findHistory', 'PembayaranController@findHistory');
    Route::get('manajemen-seragam/pembayaran-seragam/cariHistory', 'PembayaranController@cariHistory');
    Route::get('manajemen-seragam/pembayaran-seragam/update', 'PembayaranController@update');

    //============= return seragam (pembelian)
    Route::get('manajemen-seragam/return', 'ReturnPembelianController@index');
    Route::get('manajemen-seragam/return/tambah', 'ReturnPembelianController@tambah');
    Route::get('manajemen-seragam/return/detail', 'ReturnPembelianController@detail');
    Route::get('manajemen-seragam/return/hapus', 'ReturnPembelianController@hapus');
    Route::get('manajemen-seragam/return/edit', 'ReturnPembelianController@edit');
    Route::get('manajemen-seragam/return/getdata', 'ReturnPembelianController@getData');
    Route::get('manajemen-seragam/return/add', 'ReturnPembelianController@add');
    Route::get('manajemen-seragam/return/caribarang', 'ReturnPembelianController@caribarang');
    Route::get('manajemen-seragam/return/getbarang', 'ReturnPembelianController@getbarang');
    Route::post('manajemen-seragam/return/lanjut', 'ReturnPembelianController@lanjut');
    Route::get('manajemen-seragam/return/simpan', 'ReturnPembelianController@save');
    Route::get('manajemen-seragam/return/simpanlanjut', 'ReturnPembelianController@simpanlanjut');
    Route::post('manajemen-seragam/return/simpanlanjut', 'ReturnPembelianController@simpanlanjut');
    Route::get('manajemen-seragam/return/update', 'ReturnPembelianController@update');
    Route::post('manajemen-seragam/return/simpan', 'ReturnPembelianController@save');
    Route::get('manajemen-seragam/return/history', 'ReturnPembelianController@history');
    Route::get('manajemen-seragam/return/datatable_history', 'ReturnPembelianController@datatable_history');
    Route::get('manajemen-seragam/return/achistory', 'ReturnPembelianController@achistory');
    Route::get('manajemen-seragam/return/cetak', 'ReturnPembelianController@cetak');
    Route::get('manajemen-seragam/return/getnota', 'ReturnPembelianController@getnota');

    //Penerimaan RETURN
    Route::get('manajemen-seragam/return/penerimaanreturn', 'penerimaanreturnController@index');
    Route::get('manajemen-seragam/return/penerimaanreturn/getnota', 'penerimaanreturnController@getnota');
    Route::get('manajemen-seragam/return/penerimaanreturn/simpan', 'penerimaanreturnController@simpan');

    //============ Stock Opname
    Route::get('manajemen-stock/stock-opname', 'StockOpnameController@index');
    Route::get('manajemen-stock/stock-opname/tambah', 'StockOpnameController@add');
    Route::get('manajemen-stock/stock-opname/getStock', 'StockOpnameController@getStock');
    Route::get('manajemen-stock/stock-opname/history', 'StockOpnameController@history');
    Route::get('manajemen-stock/stock-opname/simpan', 'StockOpnameController@save');
    Route::post('manajemen-stock/stock-opname/simpan', 'StockOpnameController@save');

    //thoriq

    /*System*/
    Route::get('system/hakuser/user', 'aksesUserController@indexAksesUser');
    Route::get('system/hakuser/tambah_user', 'aksesUserController@tambah_user');
    Route::get('system/hakuser/tambah_user/simpan-user', 'aksesUserController@simpanUser');
    Route::get('system/hakakses/edit-user-akses/edit/{id}', 'aksesUserController@editUserAkses');
    Route::get('system/hakuser/perbarui-user/perbarui-user/{id}', 'aksesUserController@perbaruiUser');
    Route::post('system/hakakses/simpan', 'aksesUserController@save');
    Route::post('system/hakakses/dataUser', 'aksesUserController@dataUser');

    //mitra divisi
    Route::get('manajemen-mitra/mitra-divisi','mitraDivisiController@index');
    Route::get('manajemen-mitra/mitra-divisi/tabel','mitraDivisiController@tabel');
    Route::post('manajemen-mitra/mitra-divisi/tabel','mitraDivisiController@tabel');
    Route::get('manajemen-mitra/mitra-divisi/get_mitra','mitraDivisiController@get_mitra');
    Route::get('manajemen-mitra/mitra-divisi/get_data_edit','mitraDivisiController@get_data_edit');
    Route::get('manajemen-mitra/mitra-divisi/tambah','mitraDivisiController@tambah');
    Route::get('manajemen-mitra/mitra-divisi/detail','mitraDivisiController@detail');
    Route::get('manajemen-mitra/mitra-divisi/edit','mitraDivisiController@edit');

    //mou mitra
    Route::get('manajemen-mitra/mitra-mou','MouController@index');
    Route::post('manajemen-mitra/mitra-mou/table','MouController@table');
    Route::get('manajemen-mitra/mitra-mou/table','MouController@table');
    Route::get('manajemen-mitra/mitra-mou/cari','MouController@cari');
    Route::get('manajemen-mitra/mitra-mou/pencarian','MouController@pencarian');
    Route::get('manajemen-mitra/mitra-mou/getdata','MouController@getdata');
    Route::get('manajemen-mitra/mitra-mou/edit','MouController@edit');
    Route::get('manajemen-mitra/mitra-mou/updateedit','MouController@updateedit');
    Route::post('manajemen-mitra/mitra-mou/updateedit','MouController@updateedit');
    Route::get('manajemen-mitra/mitra-mou/hapus','MouController@hapus');
    Route::get('manajemen-mitra/mitra-mou/aktif','MouController@aktif');
    Route::get('manajemen-mitra/mitra-mou/get-tgl-mou','MouController@tglMou');
    Route::get('manajemen-mitra/mitra-mou/get-mou','MouController@getMou');
    Route::get('manajemen-mitra/mitra-mou/update-mou','MouController@UpdateMou');
    Route::post('manajemen-mitra/mitra-mou/update-mou','MouController@UpdateMou');
    Route::get('manajemen-mitra/mitra-mou/tambah','MouController@tambah');

    //Cek Approval
    Route::get('approval/cekapproval', 'approvalController@cekapproval');

    //Approval pelamar
    Route::get('approvalpelamar', 'approvalpelamarController@index');
    Route::get('approvalpelamar/datatablepekerja', 'approvalpelamarController@datatablepekerja');
    Route::post('approvalpelamar/datatablepekerja', 'approvalpelamarController@datatablepekerja');
    Route::get('approvalpelamar/detail', 'approvalpelamarController@detail');
    Route::get('approvalpelamar/setujui', 'approvalpelamarController@setujui');
    Route::post('approvalpelamar/setujuilist', 'approvalpelamarController@setujuilist');
    Route::get('approvalpelamar/setujuilist', 'approvalpelamarController@setujuilist');
    Route::get('approvalpelamar/tolak', 'approvalpelamarController@tolak');
    Route::post('approvalpelamar/tolaklist', 'approvalpelamarController@tolaklist');
    Route::get('approvalpelamar/tolaklist', 'approvalpelamarController@tolaklist');
    Route::get('approvalpelamar/print', 'approvalpelamarController@print');

    //Approval Mitra
    Route::get('approvalmitra', 'approvalmitraController@index');
    Route::get('approvalmitra/detail', 'approvalmitraController@detail');
    Route::get('approvalmitra/setujui', 'approvalmitraController@setujui');
    Route::get('approvalmitra/setujuilist', 'approvalmitraController@setujuilist');
    Route::get('approvalmitra/tolak', 'approvalmitraController@tolak');
    Route::get('approvalmitra/tolaklist', 'approvalmitraController@tolaklist');
    Route::get('approvalmitra/print', 'approvalmitraController@print');

    //Approval Pembelian
    Route::get('approvalpembelian', 'approvalpembelianController@index');
    Route::get('approvalpembelian/setujui', 'approvalpembelianController@setujui');
    Route::get('approvalpembelian/tolak', 'approvalpembelianController@tolak');
    Route::get('approvalpembelian/setujuilist', 'approvalpembelianController@setujuilist');
    Route::get('approvalpembelian/tolaklist', 'approvalpembelianController@tolaklist');
    Route::get('approvalpembelian/detail', 'approvalpembelianController@detail');
    Route::get('approvalpembelian/print', 'approvalpembelianController@cetak');

    //Approval SP
    Route::get('approvalsp', 'approvalspController@index');
    Route::get('approvalsp/setujui', 'approvalspController@setujui');
    Route::get('approvalsp/tolak', 'approvalspController@tolak');
    Route::get('approvalsp/setujuilist', 'approvalspController@setujuilist');
    Route::get('approvalsp/tolaklist', 'approvalspController@tolaklist');
    Route::get('approvalsp/detail', 'approvalspController@detail');
    Route::get('approvalsp/print', 'approvalspController@print');

    //Approval Mitra Pekerja
    Route::get('approvalmitrapekerja', 'approvalmitrapekerjaController@index');
    Route::get('approvalmitrapekerja/daftarpekerja/{mitra}/{divisi}', 'approvalmitrapekerjaController@daftarpekerja');
    Route::get('approvalmitrapekerja/setujui', 'approvalmitrapekerjaController@setujui');
    Route::get('approvalmitrapekerja/tolak', 'approvalmitrapekerjaController@tolak');
    Route::get('approvalmitrapekerja/setujuilist', 'approvalmitrapekerjaController@setujuilist');
    Route::post('approvalmitrapekerja/setujuilist', 'approvalmitrapekerjaController@setujuilist');
    Route::get('approvalmitrapekerja/tolaklist', 'approvalmitrapekerjaController@tolaklist');
    Route::get('approvalmitrapekerja/print', 'approvalmitrapekerjaController@print');

    //Approval Promosi
    Route::get('approvalpromosi', 'approvalpromosiController@index');
    Route::get('approvalpromosi/setujui', 'approvalpromosiController@setujui');
    Route::get('approvalpromosi/tolak', 'approvalpromosiController@tolak');
    Route::get('approvalpromosi/setujuilist', 'approvalpromosiController@setujuilist');
    Route::get('approvalpromosi/tolaklist', 'approvalpromosiController@tolaklist');
    Route::get('approvalpromosi/detail', 'approvalpromosiController@detail');

    //Remunerasi
    Route::get('manajemen-pekerja/remunerasi', 'remunerasiController@index');
    Route::get('manajemen-pekerja/remunerasi/simpan/{idpekerja}', 'remunerasiController@simpan');
    Route::post('manajemen-pekerja/remunerasi/simpan/{idpekerja}', 'remunerasiController@simpan');
    Route::get('manajemen-pekerja/remunerasi/carino', 'remunerasiController@carino');
    Route::get('manajemen-pekerja/remunerasi/getdata', 'remunerasiController@getdata');
    Route::get('manajemen-pekerja/remunerasi/cari', 'remunerasiController@cari');
    Route::get('manajemen-pekerja/remunerasi/data', 'remunerasiController@data');
    Route::get('manajemen-pekerja/remunerasi/getcari', 'remunerasiController@getcari');
    Route::get('manajemen-pekerja/remunerasi/detail', 'remunerasiController@detail');
    Route::get('manajemen-pekerja/remunerasi/hapus', 'remunerasiController@hapus');
    Route::get('manajemen-pekerja/remunerasi/update/{id}', 'remunerasiController@update');
    Route::post('manajemen-pekerja/remunerasi/update/{id}', 'remunerasiController@update');

    //Approval Remunerasi
    Route::get('approvalremunerasi', 'approvalremunerasiController@index');
    Route::get('approvalremunerasi/setujui', 'approvalremunerasiController@setujui');
    Route::get('approvalremunerasi/tolak', 'approvalremunerasiController@tolak');
    Route::get('approvalremunerasi/setujuilist', 'approvalremunerasiController@setujuilist');
    Route::get('approvalremunerasi/tolaklist', 'approvalremunerasiController@tolaklist');

    //Approval Permintaan
    Route::get('approvalpermintaan', 'approvalpenerimaanController@index');
    Route::get('approvalpermintaan/tolak', 'approvalpenerimaanController@tolak');
    Route::get('approvalpermintaan/setujui', 'approvalpenerimaanController@setujui');
    Route::get('approvalpermintaan/tolaklist', 'approvalpenerimaanController@tolaklist');
    Route::get('approvalpermintaan/setujuilist', 'approvalpenerimaanController@setujuilist');

    //Approval Penjualan
    Route::get('approvalpengeluaran', 'approvalpenjualanController@index');
    Route::get('approvalpengeluaran/detail', 'approvalpenjualanController@detail');
    Route::get('approvalpengeluaran/setujui', 'approvalpenjualanController@setujui');
    Route::get('approvalpengeluaran/setujuilist', 'approvalpenjualanController@approve');
    Route::get('approvalpengeluaran/tolak', 'approvalpenjualanController@tolak');
    Route::get('approvalpengeluaran/tolaklist', 'approvalpenjualanController@tolaklist');
    Route::get('approvalpengeluaran/cetak', 'approvalpenjualanController@cetak');

    //Approval Rencana Pembelian
    Route::get('approvalrencanapembelian', 'approvalrencanapembelianController@index');
    Route::get('approvalrencanapembelian/setujui', 'approvalrencanapembelianController@setujui');
    Route::get('approvalrencanapembelian/tolak', 'approvalrencanapembelianController@tolak');
    Route::get('approvalrencanapembelian/setujuilist', 'approvalrencanapembelianController@setujuilist');
    Route::get('approvalrencanapembelian/tolaklist', 'approvalrencanapembelianController@tolaklist');

    //Approval Return Pembelian
    Route::get('approvalreturnpembelian', 'approvalreturnpembelianController@index');
    Route::get('approvalreturnpembelian/setujui', 'approvalreturnpembelianController@setujui');
    Route::get('approvalreturnpembelian/tolak', 'approvalreturnpembelianController@tolak');
    Route::get('approvalreturnpembelian/setujuilist', 'approvalreturnpembelianController@setujuilist');
    Route::get('approvalreturnpembelian/tolaklist', 'approvalreturnpembelianController@tolaklist');

    //Approval Opname
    Route::get('approvalopname', 'approvalopnameController@index');
    Route::get('approvalopname/detail', 'approvalopnameController@detail');
    Route::get('approvalopname/setujui', 'approvalopnameController@setujui');
    Route::get('approvalopname/setujuilist', 'approvalopnameController@setujuilist');
    Route::get('approvalopname/tolak', 'approvalopnameController@tolak');
    Route::get('approvalopname/tolaklist', 'approvalopnameController@tolaklist');

    //pekerja PJTKI
    Route::get('pekerja-pjtki/data-pekerja','pekerjapjtkiController@index');
    Route::POST('pekerja-pjtki/data-pekerja/table','pekerjapjtkiController@data');
    Route::get('pekerja-pjtki/data-pekerja/table','pekerjapjtkiController@data');
    Route::POST('pekerja-pjtki/data-pekerja/tablenon','pekerjapjtkiController@dataEx');
    Route::get('pekerja-pjtki/data-pekerja/tablenon','pekerjapjtkiController@dataEx');
    Route::POST('pekerja-pjtki/data-pekerja/tablecalon','pekerjapjtkiController@dataCalon');
    Route::get('pekerja-pjtki/data-pekerja/tablecalon','pekerjapjtkiController@dataCalon');
    Route::get('pekerja-pjtki/data-pekerja/tambah','pekerjapjtkiController@tambah');
    Route::get('pekerja-pjtki/data-pekerja/simpan','pekerjapjtkiController@simpan');
    Route::POST('pekerja-pjtki/data-pekerja/simpan','pekerjapjtkiController@simpan');
    Route::get('pekerja-pjtki/data-pekerja/{id}/edit','pekerjapjtkiController@edit');
    Route::get('pekerja-pjtki/data-pekerja/perbarui/','pekerjapjtkiController@perbarui');
    Route::POST('pekerja-pjtki/data-pekerja/perbarui/','pekerjapjtkiController@perbarui');
    Route::get('pekerja-pjtki/data-pekerja/hapus/{id}','pekerjapjtkiController@hapus');
    Route::get('pekerja-pjtki/data-pekerja/detail','pekerjapjtkiController@detail');
    Route::get('pekerja-pjtki/data-pekerja/resign','pekerjapjtkiController@resign');
    Route::get('pekerja-pjtki/data-pekerja/detail-mutasi','pekerjapjtkiController@detail_mutasi');

    //PHK
    Route::get('manajemen-pekerja/phk', 'phkController@index');
    Route::get('manajemen-pekerja/phk/carino', 'phkController@carino');
    Route::get('manajemen-pekerja/phk/getdata', 'phkController@getdata');
    Route::get('manajemen-pekerja/phk/simpan/{id}', 'phkController@simpan');
    Route::post('manajemen-pekerja/phk/simpan/{id}', 'phkController@simpan');
    Route::get('manajemen-pekerja/phk/cari', 'phkController@cari');
    Route::get('manajemen-pekerja/phk/data', 'phkController@data');
    Route::get('manajemen-pekerja/phk/getcari', 'phkController@getcari');
    Route::get('manajemen-pekerja/phk/detail', 'phkController@detail');
    Route::get('manajemen-pekerja/phk/hapus', 'phkController@hapus');
    Route::get('manajemen-pekerja/phk/print', 'phkController@print');

    //Approval phk
    Route::get('approvalphk', 'approvallphkController@index');
    Route::get('approvalphk/setujui', 'approvallphkController@setujui');
    Route::get('approvalphk/tolak', 'approvallphkController@tolak');
    Route::get('approvalphk/setujuilist', 'approvallphkController@setujuilist');
    Route::get('approvalphk/tolaklist', 'approvallphkController@tolaklist');

    //Approval Pegawai
    Route::get('approvalpegawai', 'approvalpegawaiController@index');
    Route::get('approvalpegawai/setujui', 'approvalpegawaiController@setujui');
    Route::get('approvalpegawai/tolak', 'approvalpegawaiController@tolak');
    Route::get('approvalpegawai/setujuilist', 'approvalpegawaiController@setujuilist');
    Route::get('approvalpegawai/tolaklist', 'approvalpegawaiController@tolaklist');

    //Approval Promosi pegawai
    Route::get('approvalpegawaipromosi', 'approvalpegawaipromosiController@index');
    Route::get('approvalpegawaipromosi/setujui', 'approvalpegawaipromosiController@setujui');
    Route::get('approvalpegawaipromosi/tolak', 'approvalpegawaipromosiController@tolak');
    Route::get('approvalpegawaipromosi/setujuilist', 'approvalpegawaipromosiController@setujuilist');
    Route::get('approvalpegawaipromosi/tolaklist', 'approvalpegawaipromosiController@tolaklist');
    Route::get('approvalpegawaipromosi/detail', 'approvalpegawaipromosiController@detail');

    //Approval Remunerasi Pegawai
    Route::get('approvalpegawairemunerasi', 'approvalpegawairemunerasiController@index');
    Route::get('approvalpegawairemunerasi/setujui', 'approvalpegawairemunerasiController@setujui');
    Route::get('approvalpegawairemunerasi/tolak', 'approvalpegawairemunerasiController@tolak');
    Route::get('approvalpegawairemunerasi/setujuilist', 'approvalpegawairemunerasiController@setujuilist');
    Route::get('approvalpegawairemunerasi/tolaklist', 'approvalpegawairemunerasiController@tolaklist');

    //Approval Penerimaan Seragam
    Route::get('approvalpenerimaan', 'approvalpenerimaanseragamController@index');
    Route::get('approvalpenerimaan/detail', 'approvalpenerimaanseragamController@detail');
    Route::get('approvalpenerimaan/setujui', 'approvalpenerimaanseragamController@setujui');
    Route::get('approvalpenerimaan/tolak', 'approvalpenerimaanseragamController@tolak');
    Route::get('approvalpenerimaan/setujuilist', 'approvalpenerimaanseragamController@setujuilist');
    Route::get('approvalpenerimaan/tolaklist', 'approvalpenerimaanseragamController@tolaklist');

    Route::get('not-authorized', function(){
        return view('system/index');
    });

    //Penggajian
    Route::get('manajemen-payroll/payroll/penggajian', 'penggajianController@index');
    Route::get('manajemen-payroll/payroll/penggajian/tambah', 'penggajianController@tambah');
    Route::get('manajemen-payroll/payroll/penggajian/cari', 'penggajianController@cari');
    Route::get('manajemen-payroll/payroll/penggajian/simpan', 'penggajianController@simpan');
    Route::get('manajemen-payroll/payroll/penggajian/proses', 'penggajianController@proses');
    Route::get('manajemen-payroll/payroll/penggajian/hapus', 'penggajianController@hapus');
    Route::get('manajemen-payroll/payroll/penggajian/edit', 'penggajianController@edit');
    Route::get('manajemen-payroll/payroll/penggajian/editval', 'penggajianController@editval');
    Route::get('manajemen-payroll/payroll/penggajian/printbank', 'penggajianController@printbank');
    Route::get('manajemen-payroll/payroll/penggajian/printpekerja', 'penggajianController@printpekerja');
    Route::get('manajemen-payroll/payroll/penggajian/simpanedit', 'penggajianController@simpanedit');
    Route::get('manajemen-payroll/payroll/penggajian/prosesedit', 'penggajianController@prosesedit');
    Route::get('manajemen-payroll/payroll/penggajian/ambildata', 'penggajianController@ambildata');
    Route::get('manajemen-payroll/payroll/penggajian/cetak', 'penggajianController@cetak');

    //Approval PHK
    Route::get('approvalpegawaiphk', 'approvalpegawaiphkController@index');
    Route::get('approvalpegawaiphk/setujui', 'approvalpegawaiphkController@setujui');
    Route::get('approvalpegawaiphk/tolak', 'approvalpegawaiphkController@tolak');
    Route::get('approvalpegawaiphk/setujuilist', 'approvalpegawaiphkController@setujuilist');
    Route::get('approvalpegawaiphk/tolaklist', 'approvalpegawaiphkController@tolaklist');

    //BPJS Kesehatan
    Route::get('manajemen-bpjs/ansuransi/kesehatan', 'bpjskesehatanController@index');
    Route::get('manajemen-bpjs/ansuransi/getfaskes', 'bpjskesehatanController@getfaskes');
    Route::get('manajemen-bpjs/ansuransi/simpan/{id}', 'bpjskesehatanController@simpan');
    Route::post('manajemen-bpjs/ansuransi/simpan/{id}', 'bpjskesehatanController@simpan');
    Route::get('manajemen-bpjs/ansuransi/cari', 'bpjskesehatanController@cari');
    Route::get('manajemen-bpjs/ansuransi/data', 'bpjskesehatanController@data');
    Route::get('manajemen-bpjs/ansuransi/getdata', 'bpjskesehatanController@getdata');
    Route::get('manajemen-bpjs/ansuransi/hapus', 'bpjskesehatanController@hapus');
    Route::get('manajemen-bpjs/ansuransi/nonaktif', 'bpjskesehatanController@nonaktif');

    //BPJS Ketenagakerjaan
    Route::get('manajemen-bpjs/ansuransi/ketenagakerjaan', 'bpjsketenagakerjaanController@index');
    Route::get('manajemen-bpjs/ansuransi/ketenagakerjaan/getfaskes', 'bpjsketenagakerjaanController@getfasket');
    Route::get('manajemen-bpjs/ansuransi/ketenagakerjaan/simpan/{id}', 'bpjsketenagakerjaanController@simpan');
    Route::post('manajemen-bpjs/ansuransi/ketenagakerjaan/simpan/{id}', 'bpjsketenagakerjaanController@simpan');
    Route::get('manajemen-bpjs/ansuransi/ketenagakerjaan/cari', 'bpjsketenagakerjaanController@cari');
    Route::get('manajemen-bpjs/ansuransi/ketenagakerjaan/data', 'bpjsketenagakerjaanController@data');
    Route::get('manajemen-bpjs/ansuransi/ketenagakerjaan/getdata', 'bpjsketenagakerjaanController@getdata');
    Route::get('manajemen-bpjs/ansuransi/ketenagakerjaan/hapus', 'bpjsketenagakerjaanController@hapus');
    Route::get('manajemen-bpjs/ansuransi/ketenagakerjaan/nonaktif', 'bpjsketenagakerjaanController@nonaktif');

    //RBH
    Route::get('manajemen-bpjs/ansuransi/rbh', 'rbhController@index');
    Route::get('manajemen-bpjs/ansuransi/rbh/getfaskes', 'rbhController@getfasket');
    Route::get('manajemen-bpjs/ansuransi/rbh/simpan/{id}', 'rbhController@simpan');
    Route::post('manajemen-bpjs/ansuransi/rbh/simpan/{id}', 'rbhController@simpan');
    Route::get('manajemen-bpjs/ansuransi/rbh/cari', 'rbhController@cari');
    Route::get('manajemen-bpjs/ansuransi/rbh/data', 'rbhController@data');
    Route::get('manajemen-bpjs/ansuransi/rbh/getdata', 'rbhController@getdata');
    Route::get('manajemen-bpjs/ansuransi/rbh/hapus', 'rbhController@hapus');
    Route::get('manajemen-bpjs/ansuransi/rbh/nonaktif', 'rbhController@nonaktif');

    //Dapan
    Route::get('manajemen-bpjs/ansuransi/dapan', 'dapanController@index');
    Route::get('manajemen-bpjs/ansuransi/dapan/getfaskes', 'dapanController@getfasket');
    Route::get('manajemen-bpjs/ansuransi/dapan/simpan/{id}', 'dapanController@simpan');
    Route::post('manajemen-bpjs/ansuransi/dapan/simpan/{id}', 'dapanController@simpan');
    Route::get('manajemen-bpjs/ansuransi/dapan/cari', 'dapanController@cari');
    Route::get('manajemen-bpjs/ansuransi/dapan/data', 'dapanController@data');
    Route::get('manajemen-bpjs/ansuransi/dapan/getdata', 'dapanController@getdata');
    Route::get('manajemen-bpjs/ansuransi/dapan/hapus', 'dapanController@hapus');
    Route::get('manajemen-bpjs/ansuransi/dapan/nonaktif', 'dapanController@nonaktif');

    //Gaji Pokok
    Route::get('manajemen-payroll/payroll/gaji', 'gajipokokController@index');
    Route::get('manajemen-payroll/payroll/gaji/simpan', 'gajipokokController@simpan');
    Route::post('manajemen-payroll/payroll/gaji/simpan', 'gajipokokController@simpan');
    Route::get('manajemen-payroll/payroll/gaji/cari', 'gajipokokController@cari');
    Route::get('manajemen-payroll/payroll/gaji/getdata', 'gajipokokController@getdata');

    //Tunjangan
    Route::get('manajemen-payroll/payroll/tunjangan', 'tunjanganController@index');
    Route::get('manajemen-payroll/payroll/tunjangan/simpan', 'tunjanganController@simpan');
    Route::get('manajemen-payroll/payroll/tunjangan/cari', 'tunjanganController@cari');
    Route::get('manajemen-payroll/payroll/tunjangan/getdata', 'tunjanganController@getdata');

    //Potongan
    Route::get('manajemen-payroll/payroll/potongan', 'potonganController@index');
    Route::get('manajemen-payroll/payroll/potongan/simpan', 'potonganController@simpan');
    Route::get('manajemen-payroll/payroll/potongan/cari', 'potonganController@cari');
    Route::get('manajemen-payroll/payroll/potongan/getdata', 'potonganController@getdata');

    //Approval Penerimaan Return
    Route::get('approvalpenerimaanreturn', 'approvalpenerimaanreturnController@index');
    Route::get('approvalpenerimaanreturn/setujui', 'approvalpenerimaanreturnController@setujui');
    Route::get('approvalpenerimaanreturn/tolak', 'approvalpenerimaanreturnController@tolak');
    Route::get('approvalpenerimaanreturn/tolaklist', 'approvalpenerimaanreturnController@tolaklist');
    Route::get('approvalpenerimaanreturn/setujuilist', 'approvalpenerimaanreturnController@setujuilist');

    //Penerimaan Pengeluaran seragam
    Route::get('manajemen-seragam/penerimaanpengeluaranseragam', 'penerimaanpengeluaranseragamController@index');
    Route::get('manajemen-seragam/penerimaanpengeluaranseragam/cari', 'penerimaanpengeluaranseragamController@cari');
    Route::get('manajemen-seragam/penerimaanpengeluaranseragam/history', 'penerimaanpengeluaranseragamController@history');
    Route::get('manajemen-seragam/penerimaanpengeluaranseragam/simpan', 'penerimaanpengeluaranseragamController@simpan');
    Route::get('manajemen-seragam/penerimaanpengeluaranseragam/cariHistory', 'penerimaanpengeluaranseragamController@cariHistory');
    Route::get('manajemen-seragam/penerimaanpengeluaranseragam/findHistory', 'penerimaanpengeluaranseragamController@findHistory');
    Route::get('manajemen-seragam/penerimaanpengeluaranseragam/detail', 'penerimaanpengeluaranseragamController@detail');

    //Approval penerimaan pengeluaran seragam
    Route::get('approvalpenerimaanpengeluaranseragam', 'approvalpenerimaanpengeluaranseragamController@index');
    Route::get('approvalpenerimaanpengeluaranseragam/setujui', 'approvalpenerimaanpengeluaranseragamController@setujui');
    Route::get('approvalpenerimaanpengeluaranseragam/tolak', 'approvalpenerimaanpengeluaranseragamController@tolak');
    Route::get('approvalpenerimaanpengeluaranseragam/setujuilist', 'approvalpenerimaanpengeluaranseragamController@setujuilist');
    Route::get('approvalpenerimaanpengeluaranseragam/tolaklist', 'approvalpenerimaanpengeluaranseragamController@tolaklist');

    //Pembagian Seragam
    Route::get('manajemen-seragam/pembagianseragam', 'pembagianseragamController@index');
    Route::get('manajemen-seragam/pembagianseragam/tambah', 'pembagianseragamController@tambah');
    Route::get('manajemen-seragam/pembagianseragam/getdivisi', 'pembagianseragamController@getdivisi');
    Route::get('manajemen-seragam/pembagianseragam/getnota', 'pembagianseragamController@getnota');
    Route::get('manajemen-seragam/pembagianseragam/getseragam', 'pembagianseragamController@getseragam');
    Route::get('manajemen-seragam/pembagianseragam/showdata', 'pembagianseragamController@showdata');
    Route::get('manajemen-seragam/pembagianseragam/simpan', 'pembagianseragamController@simpan');
    Route::get('manajemen-seragam/pembagianseragam/datatable_data', 'pembagianseragamController@datatable_data');
    Route::get('manajemen-seragam/pembagianseragam/lanjutkan', 'pembagianseragamController@lanjutkan');
    Route::get('manajemen-seragam/pembagianseragam/detail', 'pembagianseragamController@detail');
});
