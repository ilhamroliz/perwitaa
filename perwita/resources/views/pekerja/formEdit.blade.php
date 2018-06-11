@extends('main')
@section('title', 'Dashboard')
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
                    <form method="POST" class="form-horizontal form-pekerja" action="{{ url('manajemen-pekerja/data-pekerja/perbarui') }}" accept-charset="UTF-8" id="perbaruipekerja" enctype="multipart/form-data">
                      <input type="hidden" name="id" value="{{$id}}">
                      <input type="hidden" name="imglama" value="{{$pekerja[0]->p_img}}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama-pekerja" name="nama" style="text-transform:uppercase" value="{{$pekerja[0]->p_name}}">
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jabatan</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" id="jabatan-pelamar" name="jabatan_pelamar">
                                  @foreach($jabatan as $data)
                                      @if($pekerja[0]->p_jabatan_lamaran == $data->jp_id)
                                      <option value="{{ $data->jp_id }}" selected>{{$data->jp_name}}</option>
                                      @else
                                      <option value="{{ $data->jp_id }}">{{$data->jp_name}}</option>
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
                                  @if($pekerja[0]->p_many_kids == "")
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
                                  @if($pekerja[0]->p_many_kids != "" && $pekerja[0]->p_many_kids != "1" && $pekerja[0]->p_many_kids != "2" && $pekerja[0]->p_many_kids != "3")
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
                                  @if(empty($bahasa[0]) || empty($bahasa[1]) || empty($bahasa[2]) || empty($bahasa[3]) )
                                      <input type="checkbox" id="indonesia" value="INDONESIA" name="bahasa[]">
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
                                  @else
                                    @if($bahasa[0]->pl_language == "INDONESIA")
                                    <input type="checkbox" id="indonesia" value="INDONESIA" name="bahasa[]" checked>
                                    @else
                                    <input type="checkbox" id="indonesia" value="INDONESIA" name="bahasa[]">
                                    @endif
                                    <label for="indonesia"> Indonesia </label>
                                </div>
                                <div class="checkbox checkbox-danger checkbox-inline col-sm-2">
                                  @if($bahasa[1]->pl_language == "INGGRIS")
                                  <input type="checkbox" id="inggris" value="INGGRIS" name="bahasa[]" checked>
                                  @else
                                  <input type="checkbox" id="inggris" value="INGGRIS" name="bahasa[]">
                                  @endif

                                    <label for="inggris"> Inggris </label>
                                </div>
                                <div class="checkbox checkbox-warning checkbox-inline col-sm-2">
                                  @if($bahasa[2]->pl_language == "MANDARIN")
                                  <input type="checkbox" id="mandarin" value="MANDARIN" name="bahasa[]" checked>
                                  @else
                                  <input type="checkbox" id="mandarin" value="MANDARIN" name="bahasa[]">
                                  @endif
                                    <label for="mandarin"> Mandarin </label>
                                </div>
                                <div class="checkbox checkbox-info checkbox-inline col-sm-1">
                                  @if($bahasa[3]->pl_language != "" || $bahasa[3]->pl_language != "LAINNYA" )
                                  <input type="checkbox" id="bahasalain" value="Lain" name="bahasa[]" checked>
                                  <label for="bahasalain"> Lainnya </label>
                              </div>
                              <div class="col-sm-4">
                                  <input type="text" class="form-control input-bahasa" id="bahasalain" value="{{$bahasa[3]->pl_language}}" name="bahasalain" placeholder="Lainnya">
                              </div>

                                  @else
                                  <input type="checkbox" id="bahasalain" value="LAINNYALAINNYA" name="bahasa[]">
                                  <label for="bahasalain"> Lainnya </label>
                              </div>
                              <div class="col-sm-4">
                                  <input type="text" class="form-control input-bahasa" id="bahasalain" value="" name="bahasalain" placeholder="Lainnya">
                              </div>

                                  @endif
                                @endif
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">SIM Driver</label>
                            <div class="col-sm-10">
                                <div class="checkbox checkbox-primary checkbox-inline col-sm-2">
                                  @if(empty($sim[0]) || empty($sim[1]) || empty($sim[2]))
                                  <input type="checkbox" id="simc" value="SIM C" name="sim[]">
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
                              @else
                                    @if($sim[0]->ps_sim == "SIM C")
                                    <input type="checkbox" id="simc" value="SIM C" name="sim[]" checked>
                                    @else
                                    <input type="checkbox" id="simc" value="SIM C" name="sim[]">
                                    @endif

                                    <label for="simc"> SIM C </label>
                                </div>
                                <div class="checkbox checkbox-danger checkbox-inline col-sm-2">
                                  @if($sim[1]->ps_sim == "SIM A")
                                  <input type="checkbox" id="sima" value="SIM A" name="sim[]" checked>
                                  @else
                                  <input type="checkbox" id="sima" value="SIM A" name="sim[]">
                                  @endif

                                    <label for="sima"> SIM A </label>
                                </div>
                                <div class="checkbox checkbox-warning checkbox-inline col-sm-2">
                                  @if($sim[2]->ps_sim == "SIM B")
                                  <input type="checkbox" id="simb" value="SIM B" name="sim[]" checked>
                                  @else
                                  <input type="checkbox" id="simb" value="SIM B" name="sim[]">
                                  @endif

                                    <label for="simb"> SIM B </label>
                                </div>
                                <div class="col-sm-5">
                                  @if(!empty($sim[0]->ps_note))
                                    <input type="text" class="form-control input-bahasa" id="bahasalain" value="{{$sim[0]->ps_note}}" name="simket" placeholder="Keterangan">
                                  @elseif(!empty($sim[1]->ps_note))
                                    <input type="text" class="form-control input-bahasa" id="bahasalain" value="{{$sim[1]->ps_note}}" name="simket" placeholder="Keterangan">
                                  @elseif(empty($sim[2]->ps_note))
                                  <input type="text" class="form-control input-bahasa" id="bahasalain" value="{{$sim[2]->ps_note}}" name="simket" placeholder="Keterangan">
                                  @endif
                                @endif
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
                            @if(empty($referensi[0]) || empty($referensi[1]) || empty($referensi[2]) || empty($referensi[3]) || empty($referensi[4]) )
                            <div class="checkbox checkbox-primary checkbox-inline col-sm-1" style="margin-left: 15px;">
                                <input type="checkbox" id="teman" value="Teman" name="ref[]">
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
                            @else
                            <div class="checkbox checkbox-primary checkbox-inline col-sm-1" style="margin-left: 15px;">
                              @if($referensi[0]->pr_referensi == "TEMAN")
                                <input type="checkbox" id="teman" value="TEMAN" name="ref[]" checked>
                              @else
                                <input type="checkbox" id="teman" value="TEMAN" name="ref[]">
                              @endif
                                <label for="teman"> Teman </label>
                            </div>
                            <div class="checkbox checkbox-danger checkbox-inline col-sm-1">
                              @if($referensi[1]->pr_referensi == "KELUARGA")
                                <input type="checkbox" id="keluarga" value="KELUARGA" name="ref[]" checked>
                              @else
                                  <input type="checkbox" id="keluarga" value="KELUARGA" name="ref[]">
                              @endif
                                <label for="keluarga"> Keluarga </label>
                            </div>
                            <div class="checkbox checkbox-warning checkbox-inline col-sm-1">
                              @if($referensi[2]->pr_referensi == "KORAN")
                                <input type="checkbox" id="koran" value="KORAN" name="ref[]" checked>
                              @else
                                  <input type="checkbox" id="koran" value="KORAN" name="ref[]">
                              @endif
                                <label for="koran"> Koran </label>
                            </div>
                            <div class="checkbox checkbox-info checkbox-inline col-sm-1">
                              @if($referensi[3]->pr_referensi == "INTERNET")
                                <input type="checkbox" id="internet" value="INTERNET" name="ref[]" checked>
                              @else
                                <input type="checkbox" id="internet" value="INTERNET" name="ref[]">
                              @endif
                                <label for="internet"> Internet </label>
                            </div>
                            <div class="checkbox checkbox-success checkbox-inline col-sm-1">
                              @if($referensi[4]->pr_referensi != "")
                                <input type="checkbox" id="reflain" value="Lain" name="ref[]" checked>
                                <label for="reflain"> Lainnya </label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control input-referensi" id="reflain" value="{{$referensi[4]->pr_referensi}}" name="reflain" placeholder="Referensi" style="width: 100%;">
                            </div>
                              @else
                                <input type="checkbox" id="reflain" value="Lain" name="ref[]">
                                <label for="reflain"> Lainnya </label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control input-referensi" id="reflain" value="" name="reflain" placeholder="Referensi" style="width: 100%;">
                            </div>
                              @endif
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
                                @if(!empty($child[0]) || !empty($child[1]) || !empty($child[2]))
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 1" style="text-transform:uppercase" value="{{$child[0]->pc_child_name}}">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase" value="{{$child[0]->pc_birth_place}}">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal" value="{{Carbon\Carbon::parse($child[0]->pc_birth_date)->format('d/m/Y')}}">
                                </div>
                            </div>
                            <div class="form-group">
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
                            </div>
                            <div class="form-group">
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
                                @else
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 1" style="text-transform:uppercase">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase" >
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Anak 2</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 2" style="text-transform:uppercase" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase" >
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Anak 3</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childname" name="childname[]" placeholder="Nama Anak 3" style="text-transform:uppercase" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control childplace" name="childplace[]" placeholder="Tempat Lahir" style="text-transform:uppercase" >
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control childdate" name="childdate[]" placeholder="Tanggal">
                                </div>
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
                              @endif
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
                                <input type="text" class="form-control tinggibadan" id="tinggibadan" name="tinggibadan" placeholder="Tinggi" style="text-transform:uppercase" value="{{$pekerja[0]->p_weight}}">
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
                            <div class="col-sm-4">
                                <label class="btn btn-default" for="upload-file-selector">
                                    <input id="upload-file-selector" name="imageUpload" class="uploadGambar" type="file" >
                                    <i class="fa fa-upload margin-correction"></i>upload gambar
                                </label>
                            </div>
                            <div class="col-sm-6 image-holder" style="padding:0px; ">
                                <img src="../../../{{$pekerja[0]->p_img}}" width="150" class="thumb-image img-responsive">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        {{-- <div class="form-group">
                            <input type="file" name="abcd" id="abcd" onchange="ubah()">
                            <input type="file" name="abcdef" id="abcdef">
                        </div> --}}
                        <div class="form-group">
                            <div class="col-sm-2" style="float: right">
                                <button class="btn btn-primary"  {{-- onclick="perbarui({{$id}})" --}} type="perbarui" style="float: right">Simpan</button>
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


    function perbarui(id) {
        $.ajax({
          type : 'get',
          timeout : 10000,
          url: baseUrl + '/manajemen-pekerja/data-pekerja/perbarui/',
          dataType: 'json',
          success : function(response){
            console.log(response);
          }
        });
        /*var p_id=$('#p_id').val();
        var buttonLadda = $('.simpan').ladda();
        buttonLadda.ladda('start');
         if(validateForm()){
        $.ajax({
            url: baseUrl + '/manajemen-pekerja/data-pekerja/perbarui/'+p_id,
            // type        : 'post',
            type: 'get',
            timeout: 10000,
            data: $('#form-pekerja :input').serialize(),
            dataType: 'json',
            processData: false,  // tell jQuery not to process the data
            contentType: false,
            success: function (response) {
                if (response.status == 'berhasil') {
                    window.location = baseUrl + '/manajemen-pekerja/data-pekerja';
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
         }*/
    }

</script>
@endsection
