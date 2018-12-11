@extends('main')
@section('title', 'Data Pekerja')
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
    #upload-file-selectorpjtki {
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
        <h2>Data Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Tambah Data Pekerja</strong>
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
                    <h5>Form Tambah Data Pekerja</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal form-pendaftaran" action="{{ url('pekerja-pjtki/data-pekerja/simpan') }}" accept-charset="UTF-8" id="tambahpekerja" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama-pekerjapjtki" name="nama" style="text-transform:uppercase">
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jabatan</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" id="jabatan-pelamarpjtki" name="jabatan_pelamar">
                                    <option disabled selected>-- Pilih Jenis Jabatan --</option>
                                    @foreach($jabPelamar as $data)
                                    <option value="{{ $data->jp_id }}"> {{ $data->jp_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat KTP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat-pekerjapjtki" name="alamat" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">RT/RW</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="rt-pekerjapjtki" name="rt" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kel/Desa</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="desa-pekerjapjtki" name="desa" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">Kec</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kec-pekerjapjtki" name="kecamatan" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kota/Kab</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kota-pekerjapjtki" name="kota" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat Sekarang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat-pekerja-nowpjtki" name="alamat_now" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">RT/RW</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="rt-pekerja-nowpjtki" name="rt_now" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kel/Desa</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="desa-pekerja-nowpjtki" name="desa_now" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">Kec</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kec-pekerja-nowpjtki" name="kecamatan_now" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kota/Kab</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kota-pekerja-nowpjtki" name="kota_now" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tempat Lahir</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="tempat-lahir-pekerjapjtki" name="tempat_lahir" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Tanggal Lahir</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="tanggal-lahir-pekerjapjtki" name="tanggal_lahir" >
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nomor KTP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ktp-pekerjapjtki" name="no_ktp" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Tlp Rumah</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="tlp-pekerjapjtki" name="no_tlp">
                            </div>
                            <label class="col-sm-2 control-label">No Hp</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="hp-pekerjapjtki" name="no_hp">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="lakipjtki" class="jenis-kelamin" value="L" name="jenkel" checked="">
                                    <label for="laki"> Pria </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="perempuanpjtki" class="jenis-kelamin" value="P" name="jenkel">
                                    <label for="perempuan"> Wanita </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Warga Negara</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="wargawnipjtki" class="warga-negara" value="WNI" name="wn" checked="">
                                    <label for="wargawni"> WNI </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="wargawnapjtki" class="warga-negara" value="WNA" name="wn">
                                    <label for="wargawna"> WNA </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="singlepjtki" value="Single" name="status" checked="">
                                    <label for="single"> Single </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="kawinpjtki" value="Kawin" name="status">
                                    <label for="kawin"> Kawin </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jumlah Anak</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="tidakpjtki" value="0" name="jml_anak" checked="">
                                    <label for="tidak"> Belum </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-2">
                                    <input type="radio" id="satupjtki" value="1" name="jml_anak">
                                    <label for="satu"> 1 Anak </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="duapjtki" value="2" name="jml_anak">
                                    <label for="dua"> 2 Anak </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-2">
                                    <input type="radio" id="tigapjtki" value="3" name="jml_anak">
                                    <label for="tiga"> 3 Anak </label>
                                </div>
                                <div class="radio radio-success radio-inline col-sm-2">
                                    <input type="radio" id="lebihpjtki" value="Lebih" name="jml_anak">
                                    <label for="lebih"> 3 Anak Lebih </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Agama</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-1">
                                    <input type="radio" id="islampjtki" value="Islam" name="agama" checked="">
                                    <label for="islam"> Islam </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-1">
                                    <input type="radio" id="kristenpjtki" value="Kristen" name="agama">
                                    <label for="kristen"> Kristen </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-1">
                                    <input type="radio" id="hindupjtki" value="Hindu" name="agama">
                                    <label for="hindu"> Hindu </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-1">
                                    <input type="radio" id="budhapjtki" value="Budha" name="agama">
                                    <label for="budha"> Budha </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-1">
                                    <input type="radio" id="agamalainpjtki" value="Lain" name="agama">
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
                                    <input type="radio" id="sdpjtki" value="SD" name="pendidikan" checked="">
                                    <label for="sd"> SD </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-2">
                                    <input type="radio" id="sltppjtki" value="SLTP" name="pendidikan">
                                    <label for="sltp"> SLTP </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="sltapjtki" value="SLTA" name="pendidikan">
                                    <label for="slta"> SLTA </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-2">
                                    <input type="radio" id="diplomapjtki" value="DIPLOMA" name="pendidikan">
                                    <label for="diploma"> DIPLOMA </label>
                                </div>
                                <div class="radio radio-success radio-inline col-sm-2">
                                    <input type="radio" id="universitaspjtki" value="UNIVERSITAS" name="pendidikan">
                                    <label for="universitas"> UNIVERSITAS </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Bahasa</label>
                            <div class="col-sm-10">
                                <div class="checkbox checkbox-primary checkbox-inline col-sm-2">
                                    <input type="checkbox" id="indonesiapjtki" value="INDONESIA" name="bahasa[]" checked="">
                                    <label for="indonesia"> Indonesia </label>
                                </div>
                                <div class="checkbox checkbox-danger checkbox-inline col-sm-2">
                                    <input type="checkbox" id="inggrispjtki" value="Inggris" name="bahasa[]">
                                    <label for="inggris"> Inggris </label>
                                </div>
                                <div class="checkbox checkbox-warning checkbox-inline col-sm-2">
                                    <input type="checkbox" id="mandarinpjtki" value="Mandarin" name="bahasa[]">
                                    <label for="mandarin"> Mandarin </label>
                                </div>
                                <div class="checkbox checkbox-info checkbox-inline col-sm-1">
                                    <input type="checkbox" id="bahasalainpjtki" value="Lain" name="bahasa[]">
                                    <label for="bahasalain"> Lainnya </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-bahasa" id="bahasalainpjtki" value="" name="bahasalain" placeholder="Lainnya">
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">SIM Driver</label>
                            <div class="col-sm-10">
                                <div class="checkbox checkbox-primary checkbox-inline col-sm-2">
                                    <input type="checkbox" id="simcpjtki" value="SIM C" name="sim[]" checked="">
                                    <label for="simc"> SIM C </label>
                                </div>
                                <div class="checkbox checkbox-danger checkbox-inline col-sm-2">
                                    <input type="checkbox" id="simapjtki" value="SIM A" name="sim[]">
                                    <label for="sima"> SIM A </label>
                                </div>
                                <div class="checkbox checkbox-warning checkbox-inline col-sm-2">
                                    <input type="checkbox" id="simbpjtki" value="SIM B" name="sim[]">
                                    <label for="simb"> SIM B </label>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control input-bahasa" id="bahasalainpjtki" value="" name="simket" placeholder="Keterangan">
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
                                <input type="checkbox" id="temanpjtki" value="Teman" name="ref[]" checked="">
                                <label for="teman"> Teman </label>
                            </div>
                            <div class="checkbox checkbox-danger checkbox-inline col-sm-1">
                                <input type="checkbox" id="keluargapjtki" value="Keluarga" name="ref[]">
                                <label for="keluarga"> Keluarga </label>
                            </div>
                            <div class="checkbox checkbox-warning checkbox-inline col-sm-1">
                                <input type="checkbox" id="koranpjtki" value="Koran" name="ref[]">
                                <label for="koran"> Koran </label>
                            </div>
                            <div class="checkbox checkbox-info checkbox-inline col-sm-1">
                                <input type="checkbox" id="internetpjtki" value="Internet" name="ref[]">
                                <label for="internet"> Internet </label>
                            </div>
                            <div class="checkbox checkbox-success checkbox-inline col-sm-1">
                                <input type="checkbox" id="reflainpjtki" value="Lain" name="ref[]">
                                <label for="reflain"> Lainnya </label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control input-referensi" id="reflainpjtki" value="" name="reflain" placeholder="Referensi" style="width: 100%;">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" style="text-align: left;">Keluarga yang bisa dihubungi</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="namakeluargapjtki" name="namakeluarga" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Hub Keluarga</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="hubkeluargapjtki" name="hubkeluarga" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Telp Rumah</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nokeluargapjtki" name="nokeluarga" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Hp</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="hpkeluargapjtki" name="hpkeluarga" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamatkeluargapjtki" name="alamatkeluarga" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="text-align: left;">Tentang Keluarga</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Suami/Istri</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="wifenamepjtki" name="wifename" placeholder="Nama Suami/Istri" style="text-transform:uppercase">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="wifelahirpjtki" name="wifelahir" placeholder="Tempat Lahir" style="text-transform:uppercase">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="wifettlpjtki" name="wifettl" placeholder="Tanggal" >
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
                                <input type="text" class="form-control dadname" id="dadnamepjtki" name="dadname" placeholder="Nama Ayah" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Pekerjaan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dadjob" id="dadjobpjtki" name="dadjob" placeholder="Pekerjaan" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Ibu</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control momname" id="momnamepjtki" name="momname" placeholder="Nama Ibu" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Pekerjaan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control momjob" id="momjobpjtki" name="momjob" placeholder="Pekerjaan" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Saya saat ini</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="tidakbekerjapjtki" value="Tidak Bekerja" name="saatini" checked="">
                                    <label for="tidakbekerja"> Tidak Bekerja </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-2">
                                    <input type="radio" id="masihbekerjapjtki" value="Masih Bekerja" name="saatini">
                                    <label for="masihbekerja"> Masih Bekerja </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-1">
                                    <input type="radio" id="kuliahpjtki" value="Kuliah" name="saatini">
                                    <label for="kuliah"> Kuliah </label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control kuliahnow" id="kuliahnowpjtki" name="kuliahnow" placeholder="Kuliah pada" style="text-transform:uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Berat Badan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control beratbadan" id="beratbadanpjtki" name="beratbadan" placeholder="Berat" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Tinggi Badan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control tinggibadan" id="tinggibadanpjtki" name="tinggibadan" placeholder="Tinggi" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ukuran Baju</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control ukuranbaju" id="ukuranbajupjtki" name="ukuranbaju" placeholder="Ukuran Baju" style="text-transform:uppercase">
                            </div>
                            <label class="col-sm-2 control-label">Ukuran Celana</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control ukurancelana" id="ukurancelanapjtki" name="ukurancelana" placeholder="Ukuran Celana" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ukuran Sepatu</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control ukuransepatu" id="ukuransepatupjtki" name="ukuransepatu" placeholder="Ukuran Sepatu" style="text-transform:uppercase">
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
                            <div class="col-sm-4">
                                <label class="btn btn-default" for="upload-file-selector">
                                    <input id="upload-file-selectorpjtki" name="imageUpload" class="uploadGambar" type="file" >
                                    <i class="fa fa-upload margin-correction"></i>upload gambar
                                </label>
                            </div>
                            <div class="col-sm-6 image-holder" style="padding:0px; ">

                            </div>
                        </div>
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
        $('#tanggal-lahir-pekerjapjtki').datepicker({
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

        $('#wifettlpjtki').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#jabatan-pelamarpjtki').select2();

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
                image_holder.html('<img src="{{ asset('image/loading1.gif') }}" class="img-responsive" width="60px">');
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
        var nama = $('#nama-pekerjapjtki');
        var jabatan = $('#jabatan-pelamarpjtki');
        var alamatpekerja = $('#alamat-pekerjapjtki');
        var alamatpekerjanow = $('#alamat-pekerja-nowpjtki');
        var ktppekerja = $('#ktp-pekerjapjtki');

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
            url: baseUrl + '/pekerja-pjtki/data-pekerja/simpan',
            type: 'POST',
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
