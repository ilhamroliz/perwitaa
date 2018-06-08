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
                    <form method="POST" class="form-horizontal form-pendaftaran" action="{{ url('manajemen-pekerja/data-pekerja/simpan') }}" accept-charset="UTF-8" id="tambahpekerja" enctype="multipart/form-data">
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
                              @if($pekerja[0]->p_state == "WNI")
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="wargawni" class="warga-negara" value="WNI" name="wn" <?php echo "checked" ?>>
                                    <label for="wargawni"> WNI </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="wargawna" class="warga-negara" value="WNA" name="wn">
                                    <label for="wargawna"> WNA </label>
                                </div>
                              @elseif($pekerja[0]->p_state == "WNA")
                              <div class="radio radio-primary radio-inline col-sm-2">
                                  <input type="radio" id="wargawni" class="warga-negara" value="WNI" name="wn">
                                  <label for="wargawni"> WNI </label>
                              </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="wargawna" class="warga-negara" value="WNA" name="wn" <?php echo "checked" ?>>
                                    <label for="wargawna"> WNA </label>
                                </div>
                              @else
                              <div class="radio radio-primary radio-inline col-sm-2">
                                  <input type="radio" id="wargawni" class="warga-negara" value="WNI" name="wn">
                                  <label for="wargawni"> WNI </label>
                              </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="wargawna" class="warga-negara" value="WNA" name="wn">
                                    <label for="wargawna"> WNA </label>
                                </div>
                              @endif
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                              @if($pekerja[0]->p_status == "Single")
                                <div class="radio radio-primary radio-inline col-sm-2">
                                    <input type="radio" id="single" value="Single" name="status" checked="">
                                    <label for="single"> Single </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-2">
                                    <input type="radio" id="kawin" value="Kawin" name="status">
                                    <label for="kawin"> Kawin </label>
                                </div>
                              @elseif($pekerja[0]->p_status == "Kawin")
                              <div class="radio radio-primary radio-inline col-sm-2">
                                  <input type="radio" id="single" value="Single" name="status">
                                  <label for="single"> Single </label>
                              </div>
                              <div class="radio radio-warning radio-inline col-sm-2">
                                  <input type="radio" id="kawin" value="Kawin" name="status" checked="">
                                  <label for="kawin"> Kawin </label>
                              </div>
                              @else
                              <div class="radio radio-primary radio-inline col-sm-2">
                                  <input type="radio" id="single" value="Single" name="status">
                                  <label for="single"> Single </label>
                              </div>
                              <div class="radio radio-warning radio-inline col-sm-2">
                                  <input type="radio" id="kawin" value="Kawin" name="status">
                                  <label for="kawin"> Kawin </label>
                              </div>
                              @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jumlah Anak</label>
                            <div class="col-sm-10">
                              @if($pekerja[0]->p_many_kids == "0" || $pekerja[0]->p_many_kids == "")
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
                                @elseif($pekerja[0]->p_many_kids == "1")
                                  <div class="radio radio-primary radio-inline col-sm-2">
                                      <input type="radio" id="tidak" value="0" name="jml_anak">
                                      <label for="tidak"> Belum </label>
                                  </div>
                                  <div class="radio radio-danger radio-inline col-sm-2">
                                      <input type="radio" id="satu" value="1" name="jml_anak" checked="">
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
                                  @elseif($pekerja[0]->p_many_kids == "2")
                                    <div class="radio radio-primary radio-inline col-sm-2">
                                        <input type="radio" id="tidak" value="0" name="jml_anak">
                                        <label for="tidak"> Belum </label>
                                    </div>
                                    <div class="radio radio-danger radio-inline col-sm-2">
                                        <input type="radio" id="satu" value="1" name="jml_anak" >
                                        <label for="satu"> 1 Anak </label>
                                    </div>
                                    <div class="radio radio-warning radio-inline col-sm-2">
                                        <input type="radio" id="dua" value="2" name="jml_anak" checked="">
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
                                    @elseif($pekerja[0]->p_many_kids == "3")
                                      <div class="radio radio-primary radio-inline col-sm-2">
                                          <input type="radio" id="tidak" value="0" name="jml_anak">
                                          <label for="tidak"> Belum </label>
                                      </div>
                                      <div class="radio radio-danger radio-inline col-sm-2">
                                          <input type="radio" id="satu" value="1" name="jml_anak" >
                                          <label for="satu"> 1 Anak </label>
                                      </div>
                                      <div class="radio radio-warning radio-inline col-sm-2">
                                          <input type="radio" id="dua" value="2" name="jml_anak" >
                                          <label for="dua"> 2 Anak </label>
                                      </div>
                                      <div class="radio radio-info radio-inline col-sm-2">
                                          <input type="radio" id="tiga" value="3" name="jml_anak" checked="">
                                          <label for="tiga"> 3 Anak </label>
                                      </div>
                                      <div class="radio radio-success radio-inline col-sm-2">
                                          <input type="radio" id="lebih" value="Lebih" name="jml_anak">
                                          <label for="lebih"> 3 Anak Lebih </label>
                                      </div>
                                      @else
                                        <div class="radio radio-primary radio-inline col-sm-2">
                                            <input type="radio" id="tidak" value="0" name="jml_anak">
                                            <label for="tidak"> Belum </label>
                                        </div>
                                        <div class="radio radio-danger radio-inline col-sm-2">
                                            <input type="radio" id="satu" value="1" name="jml_anak" >
                                            <label for="satu"> 1 Anak </label>
                                        </div>
                                        <div class="radio radio-warning radio-inline col-sm-2">
                                            <input type="radio" id="dua" value="2" name="jml_anak" >
                                            <label for="dua"> 2 Anak </label>
                                        </div>
                                        <div class="radio radio-info radio-inline col-sm-2">
                                            <input type="radio" id="tiga" value="3" name="jml_anak" >
                                            <label for="tiga"> 3 Anak </label>
                                        </div>
                                        <div class="radio radio-success radio-inline col-sm-2">
                                            <input type="radio" id="lebih" value="Lebih" name="jml_anak" checked="">
                                            <label for="lebih"> 3 Anak Lebih </label>
                                        </div>
                              @endif
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Agama</label>
                            <div class="col-sm-10">
                              @if($pekerja[0]->p_religion == "Islam" || $pekerja[0]->p_religion == "ISLAM")
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
                                @elseif($pekerja[0]->p_religion == "Kristen" || $pekerja[0]->p_religion == "KRISTEN")
                                <div class="radio radio-primary radio-inline col-sm-1">
                                    <input type="radio" id="islam" value="Islam" name="agama" >
                                    <label for="islam"> Islam </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-1">
                                    <input type="radio" id="kristen" value="Kristen" name="agama" checked="">
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
                                @elseif($pekerja[0]->p_religion == "Hindu" || $pekerja[0]->p_religion == "HINDU")
                                <div class="radio radio-primary radio-inline col-sm-1">
                                    <input type="radio" id="islam" value="Islam" name="agama" >
                                    <label for="islam"> Islam </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-1">
                                    <input type="radio" id="kristen" value="Kristen" name="agama" >
                                    <label for="kristen"> Kristen </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-1">
                                    <input type="radio" id="hindu" value="Hindu" name="agama" checked="">
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
                                @elseif($pekerja[0]->p_religion == "Budha" || $pekerja[0]->p_religion == "BUDHA")
                                <div class="radio radio-primary radio-inline col-sm-1">
                                    <input type="radio" id="islam" value="Islam" name="agama" >
                                    <label for="islam"> Islam </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-1">
                                    <input type="radio" id="kristen" value="Kristen" name="agama" >
                                    <label for="kristen"> Kristen </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-1">
                                    <input type="radio" id="hindu" value="Hindu" name="agama" >
                                    <label for="hindu"> Hindu </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-1">
                                    <input type="radio" id="budha" value="Budha" name="agama" checked="">
                                    <label for="budha"> Budha </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-1">
                                    <input type="radio" id="agamalain" value="Lain" name="agama">
                                    <label for="agamalain"> Lainnya </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" onclick="setAgamaLain()" onblur="blurAgamaLain()" class="form-control input-agama" id="agamalain" value="" name="agamalain" placeholder="Lainnya">
                                </div>
                                @else
                                <div class="radio radio-primary radio-inline col-sm-1">
                                    <input type="radio" id="islam" value="Islam" name="agama" >
                                    <label for="islam"> Islam </label>
                                </div>
                                <div class="radio radio-danger radio-inline col-sm-1">
                                    <input type="radio" id="kristen" value="Kristen" name="agama" >
                                    <label for="kristen"> Kristen </label>
                                </div>
                                <div class="radio radio-warning radio-inline col-sm-1">
                                    <input type="radio" id="hindu" value="Hindu" name="agama" >
                                    <label for="hindu"> Hindu </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-1">
                                    <input type="radio" id="budha" value="Budha" name="agama">
                                    <label for="budha"> Budha </label>
                                </div>
                                <div class="radio radio-info radio-inline col-sm-1">
                                    <input type="radio" id="agamalain" value="Lain" name="agama" checked="">
                                    <label for="agamalain"> Lainnya </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" onclick="setAgamaLain()" onblur="blurAgamaLain()" class="form-control input-agama" id="agamalain" value="{{$pekerja[0]->p_religion}}" name="agamalain" placeholder="Lainnya">
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Pendidikan</label>
                            <div class="col-sm-10">
                              @if($pekerja[0]->p_education == "SD")
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
                                @elseif($pekerja[0]->p_education == "SLTP")
                                  <div class="radio radio-primary radio-inline col-sm-2">
                                      <input type="radio" id="sd" value="SD" name="pendidikan" >
                                      <label for="sd"> SD </label>
                                  </div>
                                  <div class="radio radio-danger radio-inline col-sm-2">
                                      <input type="radio" id="sltp" value="SLTP" name="pendidikan" checked="">
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
                                  @elseif($pekerja[0]->p_education == "SLTA")
                                    <div class="radio radio-primary radio-inline col-sm-2">
                                        <input type="radio" id="sd" value="SD" name="pendidikan" >
                                        <label for="sd"> SD </label>
                                    </div>
                                    <div class="radio radio-danger radio-inline col-sm-2">
                                        <input type="radio" id="sltp" value="SLTP" name="pendidikan" >
                                        <label for="sltp"> SLTP </label>
                                    </div>
                                    <div class="radio radio-warning radio-inline col-sm-2">
                                        <input type="radio" id="slta" value="SLTA" name="pendidikan" checked="">
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
                                    @elseif($pekerja[0]->p_education == "DIPLOMA")
                                      <div class="radio radio-primary radio-inline col-sm-2">
                                          <input type="radio" id="sd" value="SD" name="pendidikan" >
                                          <label for="sd"> SD </label>
                                      </div>
                                      <div class="radio radio-danger radio-inline col-sm-2">
                                          <input type="radio" id="sltp" value="SLTP" name="pendidikan" >
                                          <label for="sltp"> SLTP </label>
                                      </div>
                                      <div class="radio radio-warning radio-inline col-sm-2">
                                          <input type="radio" id="slta" value="SLTA" name="pendidikan" >
                                          <label for="slta"> SLTA </label>
                                      </div>
                                      <div class="radio radio-info radio-inline col-sm-2">
                                          <input type="radio" id="diploma" value="DIPLOMA" name="pendidikan" checked="">
                                          <label for="diploma"> DIPLOMA </label>
                                      </div>
                                      <div class="radio radio-success radio-inline col-sm-2">
                                          <input type="radio" id="universitas" value="UNIVERSITAS" name="pendidikan">
                                          <label for="universitas"> UNIVERSITAS </label>
                                      </div>
                                      @elseif($pekerja[0]->p_education == "UNIVERSITAS")
                                        <div class="radio radio-primary radio-inline col-sm-2">
                                            <input type="radio" id="sd" value="SD" name="pendidikan" >
                                            <label for="sd"> SD </label>
                                        </div>
                                        <div class="radio radio-danger radio-inline col-sm-2">
                                            <input type="radio" id="sltp" value="SLTP" name="pendidikan" >
                                            <label for="sltp"> SLTP </label>
                                        </div>
                                        <div class="radio radio-warning radio-inline col-sm-2">
                                            <input type="radio" id="slta" value="SLTA" name="pendidikan" >
                                            <label for="slta"> SLTA </label>
                                        </div>
                                        <div class="radio radio-info radio-inline col-sm-2">
                                            <input type="radio" id="diploma" value="DIPLOMA" name="pendidikan" >
                                            <label for="diploma"> DIPLOMA </label>
                                        </div>
                                        <div class="radio radio-success radio-inline col-sm-2">
                                            <input type="radio" id="universitas" value="UNIVERSITAS" name="pendidikan" checked="">
                                            <label for="universitas"> UNIVERSITAS </label>
                                        </div>
                                @endif
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Bahasa</label>
                            <div class="col-sm-10">

                                <div class="checkbox checkbox-primary checkbox-inline col-sm-2">
                                  @if($bahasa[0]->pl_language == 'INDONESIA')
                                    <input type="checkbox" id="indonesia" value="INDONESIA" name="bahasa[]" checked>
                                  @else
                                    <input type="checkbox" id="indonesia" value="INDONESIA" name="bahasa[]">
                                  @endif
                                    <label for="indonesia"> Indonesia </label>
                                </div>
                                <div class="checkbox checkbox-danger checkbox-inline col-sm-2">
                                  @if($bahasa[1]->pl_language == 'INGGRIS')
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
                                  @if($bahasa[3]->pl_language != "")
                                    <input type="checkbox" id="bahasalain" value="LAINNYA" name="bahasa[]" checked>
                                    <label for="bahasalain"> Lainnya </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-bahasa" id="bahasalain" value="{{$bahasa[3]->pl_language}}" name="bahasalain" placeholder="Lainnya">
                                </div>
                                @else
                                <input type="checkbox" id="bahasalain" value="LAINNYA" name="bahasa[]">
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
                            <div class="col-sm-4">
                                <label class="btn btn-default" for="upload-file-selector">
                                    <input id="upload-file-selector" name="imageUpload" class="uploadGambar" type="file" >
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
                                <button class="btn btn-primary" {{-- onclick="perbarui()" --}} type="simpan" style="float: right">Simpan</button>
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
    var info       = $('.pesan');
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
         }
    }

</script>
@endsection
