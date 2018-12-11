@extends('main')
@section('title', 'Data Pegawai')
@section('extra_styles')
<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    .huruf{
        text-transform: capitalize;
    }
    .spacing-top{
        margin-top:15px;
    }
    #upload-file-selector {
        display:none;
    }
    .margin-correction {
        margin-right: 10px;
    }
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Data Pegawai</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pegawai
            </li>
            <li class="active">
                <strong>Tambah Data Pegawai</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="alert alert-danger pesan" style="display:none;">
          <ul></ul>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Form Tambah Data Pegawai</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal form-pendaftaran" action="{{ url('manajemen-pegawai/data-pegawai/simpan') }}" accept-charset="UTF-8" id="tambahpekerja" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama-pekerja" name="nama" style="text-transform:uppercase">
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jabatan</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" id="jabatan-pelamar" name="jabatan_pelamar">
                                    <option disabled selected>-- Pilih Jenis Jabatan --</option>
                                    @foreach($jabPelamar as $data)
                                    <option value="{{ $data->j_id }}"> {{ $data->j_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat KTP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat-pekerja" name="alamat" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">RT/RW</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="rt-pekerja" name="rt" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kel/Desa</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="desa-pekerja" name="desa" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">Kec</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kec-pekerja" name="kecamatan" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kota/Kab</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kota-pekerja" name="kota" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat Sekarang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat-pekerja-now" name="alamat_now" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">RT/RW</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="rt-pekerja-now" name="rt_now" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kel/Desa</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="desa-pekerja-now" name="desa_now" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">Kec</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kec-pekerja-now" name="kecamatan_now" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kota/Kab</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kota-pekerja-now" name="kota_now" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tempat Lahir</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="tempat-lahir-pekerja" name="tempat_lahir" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Tanggal Lahir</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="tanggal-lahir-pekerja" name="tanggal_lahir" >
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nomor KTP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ktp-pekerja" name="no_ktp" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Tlp Rumah</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="tlp-pekerja" name="no_tlp">
                            </div>
                            <label class="col-sm-2 control-label">No Hp</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="hp-pekerja" name="no_hp">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="laki" class="jenis-kelamin" value="L" name="jenkel" checked="">
                                    <label for="laki"> Pria </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="perempuan" class="jenis-kelamin" value="P" name="jenkel">
                                    <label for="perempuan"> Wanita </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Warga Negara</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="wargawni" class="warga-negara" value="WNI" name="wn" checked="">
                                    <label for="wargawni"> WNI </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="wargawna" class="warga-negara" value="WNA" name="wn">
                                    <label for="wargawna"> WNA </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="single" value="Single" name="status" checked="">
                                    <label for="single"> Single </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="kawin" value="Kawin" name="status">
                                    <label for="kawin"> Kawin </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jumlah Anak</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="tidak" value="0" name="jml_anak" checked="">
                                    <label for="tidak"> Belum </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-2">
                                    <input type="radio" id="satu" value="1" name="jml_anak">
                                    <label for="satu"> 1 Anak </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="dua" value="2" name="jml_anak">
                                    <label for="dua"> 2 Anak </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-2">
                                    <input type="radio" id="tiga" value="3" name="jml_anak">
                                    <label for="tiga"> 3 Anak </label>
                                </div>
                                <div class="radio radio-success radio-inline col-sm-2">
                                    <input type="radio" id="lebih" value="Lebih" name="jml_anak">
                                    <label for="lebih"> 3 Anak Lebih </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Agama</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-1">
                                    <input type="radio" id="islam" value="Islam" name="agama" checked="">
                                    <label for="islam"> Islam </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-1">
                                    <input type="radio" id="kristen" value="Kristen" name="agama">
                                    <label for="kristen"> Kristen </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-1">
                                    <input type="radio" id="hindu" value="Hindu" name="agama">
                                    <label for="hindu"> Hindu </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-1">
                                    <input type="radio" id="budha" value="Budha" name="agama">
                                    <label for="budha"> Budha </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-1">
                                    <input type="radio" id="agamalain" value="Lain" name="agama">
                                    <label for="agamalain"> Lainnya </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" onclick="setAgamaLain()" onblur="blurAgamaLain()" class="form-control input-agama" id="agamalain" value="" name="agamalain" placeholder="Lainnya">
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Pendidikan</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="sd" value="SD" name="pendidikan" checked="">
                                    <label for="sd"> SD </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-2">
                                    <input type="radio" id="sltp" value="SLTP" name="pendidikan">
                                    <label for="sltp"> SLTP </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="slta" value="SLTA" name="pendidikan">
                                    <label for="slta"> SLTA </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-2">
                                    <input type="radio" id="diploma" value="DIPLOMA" name="pendidikan">
                                    <label for="diploma"> DIPLOMA </label>
                                </div>
                                <div class="radio radio-success radio-inline col-sm-2">
                                    <input type="radio" id="universitas" value="UNIVERSITAS" name="pendidikan">
                                    <label for="universitas"> UNIVERSITAS </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Bahasa</label>
                            <div class="col-sm-10">
                                <div class="checkbox checkbox-primary checkbox-inline col-sm-2">
                                    <input type="checkbox" id="indonesia" value="INDONESIA" name="bahasa[]" checked="">
                                    <label for="indonesia"> Indonesia </label>
                                </div>
                                <div class="checkbox checkbox-danger checkbox-inline col-sm-2">
                                    <input type="checkbox" id="inggris" value="Inggris" name="bahasa[]">
                                    <label for="inggris"> Inggris </label>
                                </div>
                                <div class="checkbox checkbox-warning checkbox-inline col-sm-2">
                                    <input type="checkbox" id="mandarin" value="Mandarin" name="bahasa[]">
                                    <label for="mandarin"> Mandarin </label>
                                </div>
                                <div class="checkbox checkbox-info checkbox-inline col-sm-1">
                                    <input type="checkbox" id="bahasalain" value="Lain" name="bahasa[]">
                                    <label for="bahasalain"> Lainnya </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-bahasa" id="bahasalain" value="" name="bahasalain" placeholder="Lainnya">
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">SIM Driver</label>
                            <div class="col-sm-10">
                                <div class="checkbox checkbox-primary checkbox-inline col-sm-2">
                                    <input type="checkbox" id="simc" value="SIM C" name="sim[]" checked="">
                                    <label for="simc"> SIM C </label>
                                </div>
                                <div class="checkbox checkbox-danger checkbox-inline col-sm-2">
                                    <input type="checkbox" id="sima" value="SIM A" name="sim[]">
                                    <label for="sima"> SIM A </label>
                                </div>
                                <div class="checkbox checkbox-warning checkbox-inline col-sm-2">
                                    <input type="checkbox" id="simb" value="SIM B" name="sim[]">
                                    <label for="simb"> SIM B </label>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control input-bahasa" id="bahasalain" value="" name="simket" placeholder="Keterangan">
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-solid"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="text-align: left">Pengalaman Kerja</label>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="form-group form-pengalaman">
                            <div class="form-dinamis">
                                <div class="col-sm-4">
                                    <input type="text" class="form-control perusahaan-pengalaman" name="pengalamancorp[]" style="text-transform:uppercase" placeholder="Perusahaan">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control start-pengalaman date-pengalaman" name="startpengalaman[]" style="text-transform:uppercase" title="Start Pengalaman"  placeholder="Start">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control end-pengalaman date-pengalaman" name="endpengalaman[]" style="text-transform:uppercase" title="End Pengalaman"  placeholder="End">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control jabatan-pengalaman" name="jabatan[]" style="text-transform:uppercase" placeholder="Jabatan">
                                </div>
                                <div>
                                    <button onclick="TambahPengalaman()" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-solid"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" style="text-align: left">Keterampilan yang dimiliki</label>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="form-group form-keterampilan">
                            <div class="form-dinamis-keterampilan">
                                <div class="col-sm-11">
                                    <input type="text" class="form-control keterampilan-pekerja" name="keterampilan[]" style="text-transform:uppercase">
                                </div>
                                <div class="">
                                    <button onclick="TambahKeterampilan()" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-solid"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Referensi dari</label>
                            <div class="checkbox checkbox-primary checkbox-inline col-sm-1" style="margin-left: 15px;">
                                <input type="checkbox" id="teman" value="Teman" name="ref[]" checked="">
                                <label for="teman"> Teman </label>
                            </div>
                            <div class="checkbox checkbox-danger checkbox-inline col-sm-1">
                                <input type="checkbox" id="keluarga" value="Keluarga" name="ref[]">
                                <label for="keluarga"> Keluarga </label>
                            </div>
                            <div class="checkbox checkbox-warning checkbox-inline col-sm-1">
                                <input type="checkbox" id="koran" value="Koran" name="ref[]">
                                <label for="koran"> Koran </label>
                            </div>
                            <div class="checkbox checkbox-info checkbox-inline col-sm-1">
                                <input type="checkbox" id="internet" value="Internet" name="ref[]">
                                <label for="internet"> Internet </label>
                            </div>
                            <div class="checkbox checkbox-success checkbox-inline col-sm-1">
                                <input type="checkbox" id="reflain" value="Lain" name="ref[]">
                                <label for="reflain"> Lainnya </label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control input-referensi" id="reflain" value="" name="reflain" placeholder="Referensi" style="width: 100%;">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" style="text-align: left;">Keluarga yang bisa dihubungi</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="namakeluarga" name="namakeluarga" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Hub Keluarga</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="hubkeluarga" name="hubkeluarga" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Telp Rumah</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nokeluarga" name="nokeluarga" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Hp</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="hpkeluarga" name="hpkeluarga" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamatkeluarga" name="alamatkeluarga" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="text-align: left;">Tentang Keluarga</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Suami/Istri</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="wifename" name="wifename" placeholder="Nama Suami/Istri" style="text-transform:uppercase">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="wifelahir" name="wifelahir" placeholder="Tempat Lahir" style="text-transform:uppercase">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="wifettl" name="wifettl" placeholder="Tanggal" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Anak 1</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 1" style="text-transform:uppercase">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Anak 2</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 2" style="text-transform:uppercase">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Anak 3</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 3" style="text-transform:uppercase">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal" >
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Ayah</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dadname" id="dadname" name="dadname" placeholder="Nama Ayah" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Pekerjaan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dadjob" id="dadjob" name="dadjob" placeholder="Pekerjaan" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Ibu</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control momname" id="momname" name="momname" placeholder="Nama Ibu" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Pekerjaan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control momjob" id="momjob" name="momjob" placeholder="Pekerjaan" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Saya saat ini</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="tidakbekerja" value="Tidak Bekerja" name="saatini" checked="">
                                    <label for="tidakbekerja"> Tidak Bekerja </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-2">
                                    <input type="radio" id="masihbekerja" value="Masih Bekerja" name="saatini">
                                    <label for="masihbekerja"> Masih Bekerja </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-1">
                                    <input type="radio" id="kuliah" value="Kuliah" name="saatini">
                                    <label for="kuliah"> Kuliah </label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control kuliahnow" id="kuliahnow" name="kuliahnow" placeholder="Kuliah pada" style="text-transform:uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Berat Badan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control beratbadan" id="beratbadan" name="beratbadan" placeholder="Berat" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Tinggi Badan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control tinggibadan" id="tinggibadan" name="tinggibadan" placeholder="Tinggi" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ukuran Baju</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control ukuranbaju" id="ukuranbaju" name="ukuranbaju" placeholder="Ukuran Baju" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Ukuran Celana</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control ukurancelana" id="ukurancelana" name="ukurancelana" placeholder="Ukuran Celana" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ukuran Sepatu</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control ukuransepatu" id="ukuransepatu" name="ukuransepatu" placeholder="Ukuran Sepatu" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            {{-- <div class="col-md-6">
                                <div class="image-crop">
                                    <img src="{{ asset('assets/img/user.jpg') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Preview Image</h4>
                                <div class="img-preview img-preview-lg"  style="width: 128px; height: 192px;"></div>
                                <div class="btn-group" style="margin-top: 10px;">
                                    <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                        <input type="file" name="imageUpload" id="inputImage" class="hide">
                                        Upload Image
                                    </label>
                                </div>
                                <div class="btn-group" style="margin-top: 10px;">
                                    <button class="btn btn-white" id="zoomIn" type="button">Zoom In</button>
                                    <button class="btn btn-white" id="zoomOut" type="button">Zoom Out</button>
                                    <button class="btn btn-white" id="rotateLeft" type="button">Rotate Left</button>
                                    <button class="btn btn-white" id="rotateRight" type="button">Rotate Right</button>
                                </div>
                            </div> --}}
                            <label class="col-sm-2 control-label">Foto</label>
                            <div class="col-sm-3">
                                <label class="btn btn-default" for="upload-file-selector">
                                    <input id="upload-file-selector" name="imageUpload" class="uploadGambar" type="file">
                                    <i class="fa fa-upload margin-correction"></i>Upload Foto
                                </label>
                            </div>
                            <div class="col-sm-6 image-holder" style="padding:0px; ">

                            </div>
                        <br>
                        <br>
                        <div class="hr-line-dashed"></div>
                        <br>
                        <br>
                        <label class="col-sm-2 control-label">Foto KTP</label>
                        <div class="col-sm-3">
                            <label class="btn btn-default" for="uploadktp">
                                <input id="uploadktp" name="ktpUpload" class="uploadKtp" type="file" style="display:none;">
                                <i class="fa fa-upload margin-correction"></i>Upload Foto KTP
                            </label>
                        </div>
                        <div class="col-sm-6 ktp-holder" id="ktp-holder" tyle="padding:0px; ">

                        </div>
                        <br>
                        <br>
                        <div class="hr-line-dashed"></div>
                        <br>
                        <br>
                        <label class="col-sm-2 control-label">Foto Ijazah</label>
                        <div class="col-sm-3">
                            <label class="btn btn-default" for="uploadijazah">
                                <input id="uploadijazah" name="ijazahUpload" class="uploadijazah" type="file" style="display:none;">
                                <i class="fa fa-upload margin-correction"></i>Upload Foto Ijazah
                            </label>
                        </div>
                        <div class="col-sm-6 ijazah-holder" id="ijazah-holder" tyle="padding:0px; ">

                        </div>
                        <br>
                        <br>
                        <div class="hr-line-dashed"></div>
                        <br>
                        <br>
                        <label class="col-sm-2 control-label">Foto SKCK</label>
                        <div class="col-sm-3">
                            <label class="btn btn-default" for="uploadskck">
                                <input id="uploadskck" name="skckUpload" class="uploadskck" type="file" style="display:none;">
                                <i class="fa fa-upload margin-correction"></i>Upload Foto SKCK
                            </label>
                        </div>
                        <div class="col-sm-6 skck-holder" id="skck-holder" tyle="padding:0px; ">

                        </div>
                        <br>
                        <br>
                        <div class="hr-line-dashed"></div>
                        <br>
                        <br>
                        <label class="col-sm-2 control-label">Foto Hasil Medical</label>
                        <div class="col-sm-3">
                            <label class="btn btn-default" for="uploadmedical">
                                <input id="uploadmedical" name="medicalUpload" class="uploadmedical" type="file" style="display:none;">
                                <i class="fa fa-upload margin-correction"></i>Upload Foto Hasil Medical
                            </label>
                        </div>
                        <div class="col-sm-6 medical-holder" id="medical-holder" tyle="padding:0px; ">

                        </div>
                        </div>
                        <br>
                        <br>
                        <div class="hr-line-dashed"></div>
                        {{-- <div class="form-group">
                            <input type="file" name="abcd" id="abcd" onchange="ubah()">
                            <input type="file" name="abcdef" id="abcdef">
                        </div> --}}
                        <div class="form-group">
                            <div class="col-sm-2" style="float: right">
                                <button class="btn btn-primary btn-outline" {{-- onclick="simpan()" --}} type="simpan" style="float: right">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript" src="{{asset('assets/console_img/console.image.js')}}"></script>
<script type="text/javascript">
    /*var $inputImage = $("#inputImage");
    var $image;*/
    $(document).ready(function(){
        $('#tanggal-lahir-pekerja').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        }).datepicker("setDate", "0");

        $('.start-pengalaman').datepicker({
            autoclose: true,
            minViewMode: 'years',
            format: 'yyyy'
        });

        $('.end-pengalaman').datepicker({
            autoclose: true,
            minViewMode: 'years',
            format: 'yyyy'
        });

        $('.childdate').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#wifettl').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#jabatan-pelamar').select2();

        /*$image = $(".image-crop > img")
            $($image).cropper({
                aspectRatio: 4 / 6,
                autoCropArea: 0,
                strict: true,
                guides: true,
                highlight: true,
                dragCrop: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                preview: ".img-preview",
                done: function(data) {

                }
            });

        if (window.FileReader) {
            $inputImage.change(function() {
                var fileReader = new FileReader(),
                        files = this.files,
                        file;

                if (!files.length) {
                    return;
                }

                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function () {
                        $inputImage.val("");
                        $image.cropper("reset", true).cropper("replace", this.result);
                        console.image(this.result);
                    };
                } else {
                    showMessage("Please choose an image file.");
                }
            });

        } else {
            $inputImage.addClass("hide");
        }

        $("#download").click(function() {
            window.open($image.cropper("getDataURL"));
        });

        $("#zoomIn").click(function() {
            $image.cropper("zoom", 0.1);
        });

        $("#zoomOut").click(function() {
            $image.cropper("zoom", -0.1);
        });

        $("#rotateLeft").click(function() {
            $image.cropper("rotate", 45);
        });

        $("#rotateRight").click(function() {
            $image.cropper("rotate", -45);
        });

        $("#setDrag").click(function() {
            $image.cropper("setDragMode", "crop");
        });*/
    });

    $(".uploadGambar").on('change', function () {
        $('.save').attr('disabled', false);
        if (typeof (FileReader) != "undefined") {
            var image_holder = $(".image-holder");
            image_holder.empty();
            var reader = new FileReader();
            reader.onload = function (e) {
                image_holder.html('<img src="{{ asset('assets/img/loading1.gif') }}" class="img-responsive" width="60px">');
                $('.save').attr('disabled', true);
                setTimeout(function(){
                    image_holder.empty();
                    $("<img />", {
                        "src": e.target.result,
                        "class": "thumb-image img-responsive",
                        "height": "80px",
                    }).appendTo(image_holder);
                    $('.save').attr('disabled', false);
                }, 2000)
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    });

    $("#uploadktp").on('change', function () {
      $('.save').attr('disabled', false);
      if (typeof (FileReader) != "undefined") {
          var image_holder = $("#ktp-holder");
          image_holder.empty();
          var reader = new FileReader();
          reader.onload = function (e) {
              image_holder.html('<img src="{{ asset('assets/img/loading1.gif') }}" class="img-responsive" width="60px">');
              $('.save').attr('disabled', true);
              setTimeout(function(){
                  image_holder.empty();
                  $("<img />", {
                      "src": e.target.result,
                      "class": "thumb-image img-responsive",
                      "height": "80px",
                  }).appendTo(image_holder);
                  $('.save').attr('disabled', false);
              }, 2000)
          }
          image_holder.show();
          reader.readAsDataURL($(this)[0].files[0]);
      } else {
          alert("This browser does not support FileReader.");
      }
    });

    $("#uploadijazah").on('change', function () {
      $('.save').attr('disabled', false);
      if (typeof (FileReader) != "undefined") {
          var image_holder = $("#ijazah-holder");
          image_holder.empty();
          var reader = new FileReader();
          reader.onload = function (e) {
              image_holder.html('<img src="{{ asset('assets/img/loading1.gif') }}" class="img-responsive" width="60px">');
              $('.save').attr('disabled', true);
              setTimeout(function(){
                  image_holder.empty();
                  $("<img />", {
                      "src": e.target.result,
                      "class": "thumb-image img-responsive",
                      "height": "80px",
                  }).appendTo(image_holder);
                  $('.save').attr('disabled', false);
              }, 2000)
          }
          image_holder.show();
          reader.readAsDataURL($(this)[0].files[0]);
      } else {
          alert("This browser does not support FileReader.");
      }
    });

    $("#uploadskck").on('change', function () {
      $('.save').attr('disabled', false);
      if (typeof (FileReader) != "undefined") {
          var image_holder = $("#skck-holder");
          image_holder.empty();
          var reader = new FileReader();
          reader.onload = function (e) {
              image_holder.html('<img src="{{ asset('assets/img/loading1.gif') }}" class="img-responsive" width="60px">');
              $('.save').attr('disabled', true);
              setTimeout(function(){
                  image_holder.empty();
                  $("<img />", {
                      "src": e.target.result,
                      "class": "thumb-image img-responsive",
                      "height": "80px",
                  }).appendTo(image_holder);
                  $('.save').attr('disabled', false);
              }, 2000)
          }
          image_holder.show();
          reader.readAsDataURL($(this)[0].files[0]);
      } else {
          alert("This browser does not support FileReader.");
      }
    });

    $("#uploadmedical").on('change', function () {
      $('.save').attr('disabled', false);
      if (typeof (FileReader) != "undefined") {
          var image_holder = $("#medical-holder");
          image_holder.empty();
          var reader = new FileReader();
          reader.onload = function (e) {
              image_holder.html('<img src="{{ asset('assets/img/loading1.gif') }}" class="img-responsive" width="60px">');
              $('.save').attr('disabled', true);
              setTimeout(function(){
                  image_holder.empty();
                  $("<img />", {
                      "src": e.target.result,
                      "class": "thumb-image img-responsive",
                      "height": "80px",
                  }).appendTo(image_holder);
                  $('.save').attr('disabled', false);
              }, 2000)
          }
          image_holder.show();
          reader.readAsDataURL($(this)[0].files[0]);
      } else {
          alert("This browser does not support FileReader.");
      }
    });

    function setAgamaLain(){
        radiobtn = document.getElementById("agamalain");
        radiobtn.checked = true;
    }

    function blurAgamaLain(){
        var cek = $('.input-agama').val();
        if (cek == '' || cek == null) {
            radiobtn = document.getElementById("islam");
            radiobtn.checked = true;
        }
    }

    var count = 0;
    var hitung = 0;

    function TambahPengalaman(){
        count = count + 1;
        var konten = '<div class="form-dinamis'+count+'"><div class="col-sm-4"><input type="text" class="form-control perusahaan-pengalaman" name="pengalamancorp[]" style="text-transform:uppercase" placeholder="Perusahaan"></div><div class="col-sm-2"><input type="text" class="form-control start-pengalaman'+count+' date-pengalaman" name="startpengalaman[]" style="text-transform:uppercase"  placeholder="Start"></div><div class="col-sm-2"><input type="text" class="form-control end-pengalaman'+count+' date-pengalaman" name="endpengalaman[]" style="text-transform:uppercase"  placeholder="End"></div><div class="col-sm-3"><input type="text" class="form-control jabatan-pengalaman" name="jabatan[]" style="text-transform:uppercase" placeholder="Jabatan"></div><div><button onclick="TambahPengalaman()" type="button" class="btn btn-primary" style="margin-right: 5px;"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-danger" onclick="HapusPengalaman('+count+')"><i class="fa fa-minus"></i></button></div></div>';
        $('.form-pengalaman').append(konten);

        $('.start-pengalaman'+count).datepicker({
            autoclose: true,
            minViewMode: 'years',
            format: 'yyyy'
        });

        $('.end-pengalaman'+count).datepicker({
            autoclose: true,
            minViewMode: 'years',
            format: 'yyyy'
        });
    }

    function HapusPengalaman(hapus){
        $('.form-dinamis'+hapus).remove();
    }

    function TambahKeterampilan(){
        hitung = hitung + 1;
        var konten = '<div class="form-dinamis-keterampilan'+hitung+'"><div class="col-sm-11"><input type="text" class="form-control keterampilan-pekerja" name="keterampilan[]" style="text-transform:uppercase"></div><div class=""><button onclick="TambahKeterampilan()" type="button" class="btn btn-primary" style="margin-right: 5px;"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-danger" onclick="HapusKeterampilan('+hitung+')"><i class="fa fa-minus"></i></button></div></div>';
        $('.form-keterampilan').append(konten);
    }

    function HapusKeterampilan(hapus){
        $('.form-dinamis-keterampilan'+hapus).remove();
    }

    function simpan(){
        waitingDialog.show();
        var nama = $('#nama-pekerja');
        var jabatan = $('#jabatan-pelamar');
        var alamatpekerja = $('#alamat-pekerja');
        var alamatpekerjanow = $('#alamat-pekerja-now');
        var ktppekerja = $('#ktp-pekerja');

        if (nama == '' || nama == null || nama == ' ') {
            waitingDialog.hide();
            Command: toastr["warning"]("Nama pelamar harus diisi terlebih dahulu", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }

        if (jabatan == '' || jabatan == null || jabatan == ' ') {
            waitingDialog.hide();
            Command: toastr["warning"]("Jabatan pelamar harus diisi terlebih dahulu", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }

        if (alamatpekerja == '' || alamatpekerja == null || alamatpekerja == ' ' || alamatpekerjanow == '' || alamatpekerjanow == null || alamatpekerjanow == ' ') {
            waitingDialog.hide();
            Command: toastr["warning"]("Alamat pelamar harus diisi terlebih dahulu", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }

        if (ktppekerja == '' || ktppekerja == null || ktppekerja == ' ') {
            waitingDialog.hide();
            Command: toastr["warning"]("KTP pelamar harus diisi terlebih dahulu", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $.ajax({
            url: baseUrl + '/manajemen-pekerja/data-pekerja/simpan',
            type: 'post',
            data: $('.form-pendaftaran').serialize(),
            success: function(response){

                waitingDialog.hide();
          }, error:function(x, e) {
            waitingDialog.hide();
              if (x.status == 0) {
                  alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
              } else if (x.status == 404) {
                  alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
              } else if (x.status == 500) {
                  alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
              } else if (e == 'parsererror') {
                  alert('Error.\nParsing JSON Request failed.');
              } else if (e == 'timeout'){
                  alert('Request Time out. Harap coba lagi nanti');
              } else {
                  alert('Unknow Error.\n' + x.responseText);
              }
            }
        });

    }

</script>
@endsection
