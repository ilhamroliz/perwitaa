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
        <h2>Data Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Edit Data Pekerja</strong>
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
                    <h5>Form Edit Data Pekerja</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal form-pekerja" action="{{ url('manajemen-pegawai/data-pegawai/perbarui') }}" accept-charset="UTF-8" id="perbaruipekerja" enctype="multipart/form-data">
                      <input type="hidden" name="id" value="{{$id}}">
                      <input type="hidden" name="imglama" value="{{$pekerja[0]->p_img}}">
                      <input type="hidden" name="imgktplama" value="{{$pekerja[0]->p_img_ktp}}">
                      <input type="hidden" name="imgijazahlama" value="{{$pekerja[0]->p_img_ijazah}}">
                      <input type="hidden" name="imgskcklama" value="{{$pekerja[0]->p_img_skck}}">
                      <input type="hidden" name="imgmedicallama" value="{{$pekerja[0]->p_img_medical}}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama-pekerja" name="nama" style="text-transform:uppercase" value="{{$pekerja[0]->p_name}}">
                            </div>
                        </div>
                        @if(!empty($pekerja[0]->p_nip))
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No NIK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="no-nik" name="nonik" style="text-transform:uppercase" value="{{$pekerja[0]->p_nip}}">
                            </div>
                        </div>
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jabatan</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" id="jabatan-pelamar" name="jabatan_pelamar">
                                  @foreach($jabatan as $data)
                                      @if($pekerja[0]->p_jabatan_lamaran == $data->j_id)
                                      <option value="{{ $data->j_id }}" selected>{{$data->j_name}}</option>
                                      @else
                                      <option value="{{ $data->j_id }}">{{$data->j_name}}</option>
                                    @endif
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat KTP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat-pekerja" name="alamat" style="text-transform:uppercase" value="{{$pekerja[0]->p_address}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">RT/RW</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="rt-pekerja" name="rt" style="text-transform:uppercase" value="{{$pekerja[0]->p_rt_rw}}">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kel/Desa</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="desa-pekerja" name="desa" style="text-transform:uppercase" value="{{$pekerja[0]->p_kel}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">Kec</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kec-pekerja" name="kecamatan" style="text-transform:uppercase" value="{{$pekerja[0]->p_kecamatan}}">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kota/Kab</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kota-pekerja" name="kota" style="text-transform:uppercase" value="{{$pekerja[0]->p_city}}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat Sekarang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat-pekerja-now" name="alamat_now" style="text-transform:uppercase" value="{{$pekerja[0]->p_address_now}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">RT/RW</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="rt-pekerja-now" name="rt_now" style="text-transform:uppercase" value="{{$pekerja[0]->p_rt_rw_now}}">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kel/Desa</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="desa-pekerja-now" name="desa_now" style="text-transform:uppercase" value="{{$pekerja[0]->p_kel_now}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-1 control-label" style="text-align: left">Kec</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kec-pekerja-now" name="kecamatan_now" style="text-transform:uppercase" value="{{$pekerja[0]->p_kecamatan_now}}">
                            </div>
                            <label class="col-sm-1 control-label" style="text-align: left">Kota/Kab</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="kota-pekerja-now" name="kota_now" style="text-transform:uppercase" value="{{$pekerja[0]->p_city_now}}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tempat Lahir</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="tempat-lahir-pekerja" name="tempat_lahir" style="text-transform:uppercase" value="{{$pekerja[0]->p_birthplace}}">
                            </div>
                            <label class="col-sm-2 control-label">Tanggal Lahir</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="tanggal-lahir-pekerja" name="tanggal_lahir" value="{{$pekerja[0]->p_birthdate}}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nomor KTP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ktp-pekerja" name="no_ktp" style="text-transform:uppercase" value="{{$pekerja[0]->p_ktp}}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Tlp Rumah</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="tlp-pekerja" name="no_tlp" value="{{$pekerja[0]->p_telp}}">
                            </div>
                            <label class="col-sm-2 control-label">No Hp</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="hp-pekerja" name="no_hp" value="{{$pekerja[0]->p_hp}}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                              @if($pekerja[0]->p_sex == "L")
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="laki" class="jenis-kelamin" value="L" name="sex" <?php echo "checked" ?>>
                                    <label for="laki"> Pria </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="perempuan" class="jenis-kelamin" value="P" name="sex">
                                    <label for="perempuan"> Wanita </label>
                                </div>
                              @elseif($pekerja[0]->p_sex == "P")
                              <div class="radio radio-primary radio-inline col-sm-2">
                                  <input type="radio" id="laki" class="jenis-kelamin" value="L" name="sex">
                                  <label for="laki"> Pria </label>
                              </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="perempuan" class="jenis-kelamin" value="P" name="sex" <?php echo "checked" ?>>
                                    <label for="perempuan"> Wanita </label>
                                </div>
                              @else
                              <div class="radio radio-primary radio-inline col-sm-2">
                                  <input type="radio" id="laki" class="jenis-kelamin" value="L" name="sex">
                                  <label for="laki"> Pria </label>
                              </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="perempuan" class="jenis-kelamin" value="P" name="sex">
                                    <label for="perempuan"> Wanita </label>
                                </div>
                              @endif
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Warga Negara</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                  @if($pekerja[0]->p_state == "WNI")
                                    <input type="radio" id="wargawni" class="warga-negara" value="WNI" name="wn" checked="">
                                  @else
                                    <input type="radio" id="wargawni" class="warga-negara" value="WNI" name="wn">
                                    @endif
                                    <label for="wargawni"> WNI </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    @if($pekerja[0]->p_state == "WNA")
                                    <input type="radio" id="wargawna" class="warga-negara" value="WNA" name="wn" checked="">
                                    @else
                                    <input type="radio" id="wargawna" class="warga-negara" value="WNA" name="wn">
                                    @endif
                                    <label for="wargawna"> WNA </label>
                                </div>

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">

                                <div class="radio radio-primary radio-inline col-sm-2">
                                  @if($pekerja[0]->p_status == "Single")
                                    <input type="radio" id="single" value="Single" name="status" checked="">
                                  @else
                                  <input type="radio" id="single" value="Single" name="status">
                                  @endif
                                    <label for="single"> Single </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                  @if($pekerja[0]->p_status == "Kawin")
                                    <input type="radio" id="kawin" value="Kawin" name="status" checked="">
                                  @else
                                  <input type="radio" id="kawin" value="Kawin" name="status">
                                  @endif
                                    <label for="kawin"> Kawin </label>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jumlah Anak</label>
                            <div class="col-sm-10">

                                <div class="radio radio-primary radio-inline col-sm-2">
                                  @if($pekerja[0]->p_many_kids == "0")
                                    <input type="radio" id="tidak" value="0" name="jml_anak" checked="">
                                  @else
                                  <input type="radio" id="tidak" value="0" name="jml_anak">
                                  @endif
                                    <label for="tidak"> Belum </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-2">
                                  @if($pekerja[0]->p_many_kids == "1")
                                    <input type="radio" id="satu" value="1" name="jml_anak" checked="">
                                  @else
                                  <input type="radio" id="satu" value="1" name="jml_anak">
                                  @endif
                                    <label for="satu"> 1 Anak </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                  @if($pekerja[0]->p_many_kids == "2")
                                    <input type="radio" id="dua" value="2" name="jml_anak" checked="">
                                  @else
                                  <input type="radio" id="dua" value="2" name="jml_anak">
                                  @endif
                                    <label for="dua"> 2 Anak </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-2">
                                  @if($pekerja[0]->p_many_kids == "3")
                                    <input type="radio" id="tiga" value="3" name="jml_anak" checked="">
                                  @else
                                  <input type="radio" id="tiga" value="3" name="jml_anak">
                                  @endif
                                    <label for="tiga"> 3 Anak </label>
                                </div>
                                <div class="radio radio-success radio-inline col-sm-2">
                                  @if($pekerja[0]->p_many_kids != "0" && $pekerja[0]->p_many_kids != "1" && $pekerja[0]->p_many_kids != "2" && $pekerja[0]->p_many_kids != "3")
                                    <input type="radio" id="lebih" value="Lebih" name="jml_anak" checked="">
                                  @else
                                  <input type="radio" id="lebih" value="Lebih" name="jml_anak">
                                  @endif
                                    <label for="lebih"> 3 Anak Lebih </label>
                                </div>


                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Agama</label>
                            <div class="col-sm-10">

                                <div class="radio radio-primary radio-inline col-sm-1">
                                  @if($pekerja[0]->p_religion == "ISLAM")
                                    <input type="radio" id="islam" value="Islam" name="agama" checked="">
                                  @else
                                  <input type="radio" id="islam" value="Islam" name="agama">
                                  @endif
                                    <label for="islam"> Islam </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-1">
                                  @if($pekerja[0]->p_religion == "KRISTEN")
                                    <input type="radio" id="Kristen" value="Kristen" name="agama" checked="">
                                  @else
                                  <input type="radio" id="Kristen" value="Kristen" name="agama">
                                  @endif
                                    <label for="kristen"> Kristen </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-1">
                                  @if($pekerja[0]->p_religion == "HINDU")
                                    <input type="radio" id="Hindu" value="Hindu" name="agama" checked="">
                                  @else
                                  <input type="radio" id="Hindu" value="Hindu" name="agama">
                                  @endif
                                    <label for="hindu"> Hindu </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-1">
                                  @if($pekerja[0]->p_religion == "BUDHA")
                                    <input type="radio" id="Budha" value="Budha" name="agama" checked="">
                                  @else
                                  <input type="radio" id="Budha" value="Budha" name="agama">
                                  @endif
                                    <label for="budha"> Budha </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-1">
                                  @if($pekerja[0]->p_religion != "ISLAM" && $pekerja[0]->p_religion != "KRISTEN" && $pekerja[0]->p_religion != "HINDU" && $pekerja[0]->p_religion != "BUDHA" )
                                    <input type="radio" id="agamalain" value="Lain" name="agama" checked=""><label for="agamalain"> Lainnya </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" onclick="setAgamaLain()" onblur="blurAgamaLain()" class="form-control input-agama" id="agamalain" value="{{$pekerja[0]->p_religion}}" name="agamalain" placeholder="Lainnya">
                                </div>
                                  @else
                                  <input type="radio" id="agamalain" value="Lain" name="agama"><label for="agamalain"> Lainnya </label>
                              </div>
                              <div class="col-sm-4">
                                  <input type="text" onclick="setAgamaLain()" onblur="blurAgamaLain()" class="form-control input-agama" id="agamalain" value="" name="agamalain" placeholder="Lainnya">
                              </div>
                                  @endif
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Pendidikan</label>
                            <div class="col-sm-10">

                                <div class="radio radio-primary radio-inline col-sm-2">
                                  @if($pekerja[0]->p_education == "SD")
                                    <input type="radio" id="sd" value="SD" name="pendidikan" checked="">
                                  @else
                                  <input type="radio" id="sd" value="SD" name="pendidikan">
                                  @endif
                                    <label for="sd"> SD </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-2">
                                  @if($pekerja[0]->p_education == "SLTP")
                                    <input type="radio" id="sltp" value="SLTP" name="pendidikan" checked="">
                                  @else
                                  <input type="radio" id="sltp" value="SLTP" name="pendidikan">
                                  @endif
                                    <label for="sltp"> SLTP </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                  @if($pekerja[0]->p_education == "SLTA")
                                    <input type="radio" id="slta" value="SLTA" name="pendidikan" checked="">
                                  @else
                                  <input type="radio" id="slta" value="SLTA" name="pendidikan">
                                  @endif
                                    <label for="slta"> SLTA </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-2">
                                  @if($pekerja[0]->p_education == "DIPLOMA")
                                    <input type="radio" id="diploma" value="DIPLOMA" name="pendidikan" checked="">
                                  @else
                                  <input type="radio" id="diploma" value="DIPLOMA" name="pendidikan">
                                  @endif
                                    <label for="diploma"> DIPLOMA </label>
                                </div>
                                <div class="radio radio-success radio-inline col-sm-2">
                                  @if($pekerja[0]->p_education == "UNIVERSITAS")
                                    <input type="radio" id="universitas" value="UNIVERSITAS" name="pendidikan" checked="">
                                  @else
                                  <input type="radio" id="universitas" value="UNIVERSITAS" name="pendidikan">
                                  @endif
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
                                @if(empty($bahasa[0]->indonesia))
                                <input type="checkbox" id="indonesia" value="INDONESIA" name="bahasa[]">
                                @elseif($bahasa[0]->indonesia == "INDONESIA")
                                <input type="checkbox" id="indonesia" value="INDONESIA" name="bahasa[]" checked="">
                                @else
                                <input type="checkbox" id="indonesia" value="INDONESIA" name="bahasa[]">
                                @endif
                                <label for="indonesia"> Indonesia </label>
                            </div>
                            <div class="checkbox checkbox-danger checkbox-inline col-sm-2">
                              @if(empty($bahasa[0]->inggris))
                              <input type="checkbox" id="inggris" value="Inggris" name="bahasa[]">
                              @elseif($bahasa[0]->inggris == "INGGRIS")
                                <input type="checkbox" id="inggris" value="Inggris" name="bahasa[]" checked>
                              @else
                                <input type="checkbox" id="inggris" value="Inggris" name="bahasa[]">
                              @endif
                                <label for="inggris"> Inggris </label>
                            </div>
                            <div class="checkbox checkbox-warning checkbox-inline col-sm-2">
                              @if(empty($bahasa[0]->mandarin))
                              <input type="checkbox" id="mandarin" value="Mandarin" name="bahasa[]">
                              @elseif($bahasa[0]->mandarin == "MANDARIN")
                                <input type="checkbox" id="mandarin" value="Mandarin" name="bahasa[]" checked>
                              @else
                                <input type="checkbox" id="mandarin" value="Mandarin" name="bahasa[]">
                              @endif
                                <label for="mandarin"> Mandarin </label>
                            </div>
                            <div class="checkbox checkbox-info checkbox-inline col-sm-1">
                              @if(empty($bahasa[0]->lain))
                              <input type="checkbox" id="bahasalain" value="Lain" name="bahasa[]">
                              <label for="bahasalain"> Lainnya </label>
                          </div>
                          <div class="col-sm-4">
                              <input type="text" class="form-control input-bahasa" id="bahasalain" value="" name="bahasalain" placeholder="Lainnya">
                          </div>
                              @elseif($bahasa[0]->lain != "")
                                <input type="checkbox" id="bahasalain" value="Lain" name="bahasa[]" checked>
                                <label for="bahasalain"> Lainnya </label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control input-bahasa" id="bahasalain" value="{{$bahasa[0]->lain}}" name="bahasalain" placeholder="Lainnya">
                            </div>
                            @else
                            <input type="checkbox" id="bahasalain" value="Lain" name="bahasa[]">
                            <label for="bahasalain"> Lainnya </label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-bahasa" id="bahasalain" value="" name="bahasalain" placeholder="Lainnya">
                        </div>
                              @endif

                        </div>
                    </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">SIM Driver</label>
                            <div class="col-sm-10">
                                <div class="checkbox checkbox-primary checkbox-inline col-sm-2">
                                  @if(empty($sim[0]->simc))
                                  <input type="checkbox" id="simc" value="SIM C" name="sim[]">
                                  @elseif($sim[0]->simc == "SIM C")
                                  <input type="checkbox" id="simc" value="SIM C" name="sim[]" checked="">
                                  @else
                                  <input type="checkbox" id="simc" value="SIM C" name="sim[]">
                                  @endif
                                  <label for="simc"> SIM C </label>
                              </div>
                              <div class="checkbox checkbox-danger checkbox-inline col-sm-2">
                                @if(empty($sim[0]->sima))
                                <input type="checkbox" id="sima" value="SIM A" name="sim[]">
                                @elseif($sim[0]->sima == "SIM A")
                                  <input type="checkbox" id="sima" value="SIM A" name="sim[]" checked>
                                @else
                                  <input type="checkbox" id="sima" value="SIM A" name="sim[]">
                                @endif
                                  <label for="sima"> SIM A </label>
                              </div>
                              <div class="checkbox checkbox-warning checkbox-inline col-sm-2">
                                  @if(empty($sim[0]->simb))
                                  <input type="checkbox" id="simb" value="SIM B" name="sim[]">
                                  <label for="simb"> SIM B </label>
                              </div>
                              <div class="col-sm-5">
                                  <input type="text" class="form-control input-bahasa" id="bahasalain" value="" name="simket" placeholder="Keterangan">
                              </div>
                                  @elseif($sim[0]->simb == "SIM B")
                                  <input type="checkbox" id="simb" value="SIM B" name="sim[]" checked>
                                  <label for="simb"> SIM B </label>
                              </div>
                              <div class="col-sm-5">
                                  <input type="text" class="form-control input-bahasa" id="bahasalain" value="{{$sim[0]->note}}" name="simket" placeholder="Keterangan">
                              </div>
                                  @else
                                  <input type="checkbox" id="simb" value="SIM B" name="sim[]">
                                  <label for="simb"> SIM B </label>
                              </div>
                              <div class="col-sm-5">
                                  <input type="text" class="form-control input-bahasa" id="bahasalain" value="" name="simket" placeholder="Keterangan">
                              </div>
                                  @endif

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
                              <?php if(empty($pengalaman)) {?>
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
                          <?php } else { ?>
                                <?php $x = 0; ?>
                                @foreach($pengalaman as $data)
                                <div class="form-dinamis{{$x}}">
                                <div class="col-sm-4">
                                    <input type="text" class="form-control perusahaan-pengalaman" name="pengalamancorp[]" style="text-transform:uppercase" placeholder="Perusahaan" value="{{$data->pp_perusahaan}}">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control start-pengalaman{{$x}} date-pengalaman" name="startpengalaman[]" style="text-transform:uppercase" title="Start Pengalaman"  placeholder="Start" value="{{$data->pp_start}}">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control end-pengalaman{{$x}} date-pengalaman" name="endpengalaman[]" style="text-transform:uppercase" title="End Pengalaman"  placeholder="End" value="{{$data->pp_end}}">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control jabatan-pengalaman" name="jabatan[]" style="text-transform:uppercase" placeholder="Jabatan" value="{{$data->pp_jabatan}}">
                                </div>
                                <div>
                                  @if($x > 0)
                                  <button onclick="TambahPengalaman()" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                  <button type="button" class="btn btn-danger" onclick="HapusPengalaman({{$x}})"><i class="fa fa-minus"></i></button>
                                  @else
                                  <button onclick="TambahPengalaman()" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                @endif
                                </div>
                              </div>
                              <?php $x++; ?>
                                @endforeach
                              <?php } ?>
                            </div>
                        </div>
                        <div class="hr-line-solid"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" style="text-align: left">Keterampilan yang dimiliki</label>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="form-group form-keterampilan">
                          <?php if(empty($keterampilan)) {?>
                            <div class="form-dinamis-keterampilan">
                              <div class="col-sm-11">
                                  <input type="text" class="form-control keterampilan-pekerja" name="keterampilan[]" style="text-transform:uppercase">
                              </div>
                              <div class="">
                                  <button onclick="TambahKeterampilan()" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                              </div>
                          </div>
                        <?php } else { ?>
                          <?php $i = 0; ?>
                              @foreach($keterampilan as $data)
                              <div class="form-dinamis-keterampilan{{$i}}">
                                <div class="col-sm-11">
                                    <input type="text" class="form-control keterampilan-pekerja" name="keterampilan[]" style="text-transform:uppercase" value="{{$data->pk_keterampilan}}">
                                </div>
                                <div class="">
                                  @if($i > 0)
                                    <button onclick="TambahKeterampilan()" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-danger" onclick="HapusKeterampilan({{$i}})"><i class="fa fa-minus"></i></button>
                                  @else
                                  <button onclick="TambahKeterampilan()" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                  @endif
                                </div>
                            </div>
                            <?php $i++; ?>
                            @endforeach
                          <?php } ?>
                        </div>
                        <div class="hr-line-solid"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Referensi dari</label>
                            <div class="checkbox checkbox-primary checkbox-inline col-sm-1" style="margin-left: 15px;">
                              @if(empty($referensi[0]->teman))
                              <input type="checkbox" id="teman" value="Teman" name="ref[]">
                              @elseif($referensi[0]->teman == "TEMAN")
                                <input type="checkbox" id="teman" value="Teman" name="ref[]" checked="">
                              @else
                                <input type="checkbox" id="teman" value="Teman" name="ref[]">
                              @endif
                                <label for="teman"> Teman </label>
                            </div>
                            <div class="checkbox checkbox-danger checkbox-inline col-sm-1">
                              @if(empty($referensi[0]->keluarga))
                                <input type="checkbox" id="keluarga" value="Keluarga" name="ref[]">
                              @elseif($referensi[0]->keluarga == "KELUARGA")
                                <input type="checkbox" id="keluarga" value="Keluarga" name="ref[]" checked>
                              @else
                                  <input type="checkbox" id="keluarga" value="Keluarga" name="ref[]">
                              @endif
                                <label for="keluarga"> Keluarga </label>
                            </div>
                            <div class="checkbox checkbox-warning checkbox-inline col-sm-1">
                              @if(empty($referensi[0]->koran))
                                <input type="checkbox" id="koran" value="Koran" name="ref[]">
                              @elseif($referensi[0]->koran == "KORAN")
                                <input type="checkbox" id="koran" value="Koran" name="ref[]" checked>
                              @else
                                <input type="checkbox" id="koran" value="Koran" name="ref[]">
                              @endif
                                <label for="koran"> Koran </label>
                            </div>
                            <div class="checkbox checkbox-info checkbox-inline col-sm-1">
                              @if(empty($referensi[0]->internet))
                                <input type="checkbox" id="internet" value="Internet" name="ref[]">
                              @elseif($referensi[0]->internet == "INTERNET")
                                <input type="checkbox" id="internet" value="Internet" name="ref[]" checked>
                              @else
                                <input type="checkbox" id="internet" value="Internet" name="ref[]">
                              @endif
                                <label for="internet"> Internet </label>
                            </div>
                            <div class="checkbox checkbox-success checkbox-inline col-sm-1">
                              @if(empty($referensi[0]->lain))
                                <input type="checkbox" id="reflain" value="Lain" name="ref[]">
                                <label for="reflain"> Lainnya </label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control input-referensi" id="reflain" value="" name="reflain" placeholder="Referensi" style="width: 100%;">
                            </div>
                              @elseif($referensi[0]->lain != "")
                                <input type="checkbox" id="reflain" value="Lain" name="ref[]" checked>
                                <label for="reflain"> Lainnya </label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control input-referensi" id="reflain" value="{{$referensi[0]->lain}}" name="reflain" placeholder="Referensi" style="width: 100%;">
                            </div>
                              @endif

                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" style="text-align: left;">Keluarga yang bisa dihubungi</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="namakeluarga" name="namakeluarga" style="text-transform:uppercase" value="{{$pekerja[0]->p_name_family}}">
                            </div>
                            <label class="col-sm-2 control-label">Hub Keluarga</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="hubkeluarga" name="hubkeluarga" style="text-transform:uppercase" value="{{$pekerja[0]->p_hubungan_family}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Telp Rumah</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nokeluarga" name="nokeluarga" style="text-transform:uppercase" value="{{$pekerja[0]->p_telp_family}}">
                            </div>
                            <label class="col-sm-2 control-label">Hp</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="hpkeluarga" name="hpkeluarga" style="text-transform:uppercase" value="{{$pekerja[0]->p_hp_family}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamatkeluarga" name="alamatkeluarga" style="text-transform:uppercase" value="{{$pekerja[0]->p_address_family}}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="text-align: left;">Tentang Keluarga</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Suami/Istri</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="wifename" name="wifename" placeholder="Nama Suami/Istri" style="text-transform:uppercase" value="{{$pekerja[0]->p_wife_name}}">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="wifelahir" name="wifelahir" placeholder="Tempat Lahir" style="text-transform:uppercase" value="{{$pekerja[0]->p_wife_birthplace}}">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="wifettl" name="wifettl" placeholder="Tanggal" value="{{Carbon\Carbon::parse($pekerja[0]->p_wife_birth)->format('d/m/Y')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Anak 1</label>
                                @if(!empty($child[0]))
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 1" style="text-transform:uppercase" value="{{$child[0]->pc_child_name}}">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase" value="{{$child[0]->pc_birth_place}}">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal" value="{{Carbon\Carbon::parse($child[0]->pc_birth_date)->format('d/m/Y')}}">
                                </div>
                                @else
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 1" style="text-transform:uppercase">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal">
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                              @if(!empty($child[1]))
                                <label class="col-sm-2 control-label">Anak 2</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 2" style="text-transform:uppercase" value="{{$child[1]->pc_child_name}}">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase" value="{{$child[1]->pc_birth_place}}">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal" value="{{Carbon\Carbon::parse($child[1]->pc_birth_date)->format('d/m/Y')}}">
                                </div>
                              @else
                              <label class="col-sm-2 control-label">Anak 2</label>
                              <div class="col-sm-4">
                                  <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 2" style="text-transform:uppercase">
                              </div>
                              <div class="col-sm-4">
                                  <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase">
                              </div>
                              <div class="col-sm-2">
                                  <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal">
                              </div>
                              @endif
                            </div>
                            <div class="form-group">
                              @if(!empty($child[2]))
                                <label class="col-sm-2 control-label">Anak 3</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 3" style="text-transform:uppercase" value="{{$child[2]->pc_child_name}}">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase" value="{{$child[2]->pc_birth_place}}">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal" value="{{Carbon\Carbon::parse($child[2]->pc_birth_date)->format('d/m/Y')}}">
                                </div>
                                @else
                                <label class="col-sm-2 control-label">Anak 3</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 3" style="text-transform:uppercase">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal">
                                </div>
                                @endif
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nama Ayah</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control dadname" id="dadname" name="dadname" placeholder="Nama Ayah" style="text-transform:uppercase" value="{{$pekerja[0]->p_dad_name}}">
                                </div>
                                <label class="col-sm-2 control-label">Pekerjaan</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control dadjob" id="dadjob" name="dadjob" placeholder="Pekerjaan" style="text-transform:uppercase" value="{{$pekerja[0]->p_dad_job}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nama Ibu</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control momname" id="momname" name="momname" placeholder="Nama Ibu" style="text-transform:uppercase" value="{{$pekerja[0]->p_mom_name}}">
                                </div>
                                <label class="col-sm-2 control-label">Pekerjaan</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control momjob" id="momjob" name="momjob" placeholder="Pekerjaan" style="text-transform:uppercase" value="{{$pekerja[0]->p_mom_job}}">
                                </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Saya saat ini</label>
                            <div class="col-sm-10">
                                <div class="radio radio-primary radio-inline col-sm-2">
                                  <?php if(stristr($pekerja[0]->p_job_now, "TIDAK BEKERJA")) {?>
                                    <input type="radio" id="tidakbekerja" value="TIDAK BEKERJA" name="saatini" checked="">
                                  <?php } else { ?>
                                    <input type="radio" id="tidakbekerja" value="TIDAK BEKERJA" name="saatini" >
                                  <?php } ?>
                                    <label for="tidakbekerja"> Tidak Bekerja </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-2">
                                <?php if(stristr($pekerja[0]->p_job_now, "MASIH BEKERJA")) {?>
                                    <input type="radio" id="masihbekerja" value="MASIH BEKERJA" name="saatini" checked>
                                  <?php } else { ?>
                                    <input type="radio" id="masihbekerja" value="MASIH BEKERJA" name="saatini">
                                  <?php } ?>
                                    <label for="masihbekerja"> Masih Bekerja </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-1">
                                <?php if(stristr($pekerja[0]->p_job_now, "KULIAH")) {?>
                                    <input type="radio" id="kuliah" value="kuliah" name="saatini" checked>
                                    <label for="kuliah"> Kuliah </label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control kuliahnow" id="kuliahnow" name="kuliahnow" placeholder="Kuliah pada" style="text-transform:uppercase" value="<?php echo substr($pekerja[0]->p_job_now, 10); ?>">
                                </div>
                              <?php } else { ?>
                                    <input type="radio" id="kuliah" value="KULIAH" name="saatini">
                                    <label for="kuliah"> Kuliah </label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control kuliahnow" id="kuliahnow" name="kuliahnow" placeholder="Kuliah pada" style="text-transform:uppercase">
                                </div>
                              <?php } ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Berat Badan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control beratbadan" id="beratbadan" name="beratbadan" placeholder="Berat" style="text-transform:uppercase" value="{{$pekerja[0]->p_weight}}">
                            </div>
                            <label class="col-sm-2 control-label">Tinggi Badan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control tinggibadan" id="tinggibadan" name="tinggibadan" placeholder="Tinggi" style="text-transform:uppercase" value="{{$pekerja[0]->p_height}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ukuran Baju</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control ukuranbaju" id="ukuranbaju" name="ukuranbaju" placeholder="Ukuran Baju" style="text-transform:uppercase" value="{{$pekerja[0]->p_seragam_size}}">
                            </div>
                            <label class="col-sm-2 control-label">Ukuran Celana</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control ukurancelana" id="ukurancelana" name="ukurancelana" placeholder="Ukuran Celana" style="text-transform:uppercase" value="{{$pekerja[0]->p_celana_size}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ukuran Sepatu</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control ukuransepatu" id="ukuransepatu" name="ukuransepatu" placeholder="Ukuran Sepatu" style="text-transform:uppercase" value="{{$pekerja[0]->p_sepatu_size}}">
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
                              <img src="../../../{{$pekerja[0]->p_img}}" width="150" class="thumb-image img-responsive">
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
                          <img src="../../../{{$pekerja[0]->p_img_ktp}}" width="150" class="thumb-image img-responsive">
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
                          <img src="../../../{{$pekerja[0]->p_img_ijazah}}" width="150" class="thumb-image img-responsive">
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
                          <img src="../../../{{$pekerja[0]->p_img_skck}}" width="150" class="thumb-image img-responsive">
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
                          <img src="../../../{{$pekerja[0]->p_img_medical}}" width="150" class="thumb-image img-responsive">
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
                                <button class="btn btn-primary btn-outline"  {{-- onclick="perbarui({{$id}})" --}} type="perbarui" style="float: right">Simpan</button>
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
        <script type="text/javascript">
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

            var info = $('.pesan');
             $('#expired').datepicker({
                autoclose: true,
                dateFormat: 'dd-MM-yy',
                endDate: 'today'
            });
             $('#tglLahir').datepicker({
                autoclose: true,
                dateFormat: 'dd-MM-yy',
                endDate: 'today'
            });

            function TambahKeterampilan(){
                hitung = hitung + 1;
                var konten = '<div class="form-dinamis-keterampilan'+hitung+'"><div class="col-sm-11"><input type="text" class="form-control keterampilan-pekerja" name="keterampilan[]" style="text-transform:uppercase"></div><div class=""><button onclick="TambahKeterampilan()" type="button" class="btn btn-primary" style="margin-right: 5px;"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-danger" onclick="HapusKeterampilan('+hitung+')"><i class="fa fa-minus"></i></button></div></div>';
                $('.form-keterampilan').append(konten);
            }

            function HapusKeterampilan(hapus){
                $('.form-dinamis-keterampilan'+hapus).remove();
            }


              setTglBerlakuKtp();
              function setTglBerlakuKtp(){

                if($('#jenisKtp').is(":checked")){
                   $('#expired').val('');
                   $('#expired').attr('disabled','disabled');
                }else{
                    $('#expired').datepicker({
                        autoclose: true,
                        dateFormat: 'dd-MM-yy',
                        endDate: 'today'
                    }).datepicker("setDate", "0");
                   $('#expired').removeAttr('disabled',false);
                }
            }

            function Perbarui() {
                var p_id=$('#p_id').val();
                var buttonLadda = $('.simpan').ladda();
                buttonLadda.ladda('start');
                 if(validateForm()){
                $.ajax({
                    url: baseUrl + '/manajemen-pegawai/data-pegawai/perbarui/'+p_id,
                    // type        : 'post',
                    type: 'get',
                    timeout: 10000,
                    data: $('#form-pegawai :input').serialize(),
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,
                    success: function (response) {
                        if (response.status == 'berhasil') {
                            window.location = baseUrl + '/manajemen-pegawai/data-pegawai';
                        } else if(response.status=='gagal'){
                            info.css('display','');
                            $.each(response.data, function(index, error) {
                                   info.find('ul').append('<li>' + error + '</li>');
                            });
                            buttonLadda.ladda('stop');
                        }



                    },
                    error: function (xhr, status) {
                        if (status == 'timeout') {
                            $('.error-load').css('visibility', 'visible');
                            $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                        }
                        else if (xhr.status == 0) {
                            $('.error-load').css('visibility', 'visible');
                            $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                        }
                        else if (xhr.status == 500) {
                            $('.error-load').css('visibility', 'visible');
                            $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                        }

                        buttonLadda.ladda('stop');
                    }
                });
                 }else{
                      buttonLadda.ladda('stop');
                 }
            }

        </script>
@endsection
