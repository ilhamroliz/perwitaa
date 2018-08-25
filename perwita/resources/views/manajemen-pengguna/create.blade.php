@extends('main')

@section('title', 'Tambah User')

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
        <h2>Manajemen Pengguna</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pengguna
            </li>
            <li class="active">
                <strong>Tambah Data Pengguna</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Form Tambah Data Pengguna</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal">
                      <div class="form-group row">
                          <label for="nama" class="col-sm-2 control-label">Nama</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pengguna" style="text-transform:capitalize">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="perusahaan" class="col-sm-2 control-label">Perusahaan</label>
                          <div class="col-sm-10">
                              <select name="perusahaan" class="form-control perusahaan" id="perusahaan">
                                <option selected disabled>-- Pilih Perusahaan --</option>
                                @foreach($comp as $data)
                                  <option value="{{ $data->c_id }}">{{ $data->c_name }}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="username" class="col-sm-2 control-label">Username</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="password" class="col-sm-2 control-label">Password</label>
                          <div class="col-sm-10">
                              <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="passwordagain" class="col-sm-2 control-label">Validasi Password</label>
                          <div class="col-sm-10">
                              <input type="password" class="form-control" name="passwordagain" id="passwordagain" placeholder="Masukan Password Lagi">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="jabatan" class="col-sm-2 control-label">Jabatan</label>
                          <div class="col-sm-10">
                              <select name="jabatan" class="form-control jabatan" id="jabatan">
                                <option selected disabled>-- Pilih Jabatan --</option>
                                @foreach($jabatan as $data)
                                  <option value="{{ $data->j_id }}">{{ $data->j_name }}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label for="tanggal" class="col-sm-2 control-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                          <select id="dobday" class="form-control col-sm-2" style="width: 13%;" name="tanggal" id="tanggal"></select>
                          <select id="dobmonth" class="form-control col-sm-4" style="width: 20%; margin-left: 10px" name="bulan" id="bulan"></select>
                          <select id="dobyear" class="form-control col-sm-3" style="width: 15%; margin-left: 10px" name="tahun" id="tahun"></select>
                        </div>
                      </div>
                      <div class="form-group row">
                          <label for="alamat" class="col-sm-2 control-label">Alamat</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat">
                          </div>
                      </div>
                      <div class="hr-line-dashed"></div>
                      <div class="form-group row">
                          <div class="col-sm-4 col-sm-offset-9">
                            <a href="{{url('/manajemen-mitra/data-mitra')}}" class="btn btn-danger btn-flat">Kembali</a>
                              <button class="ladda-button ladda-button-demo btn btn-primary btn-flat simpan" type="button" onclick="simpan()">
                                  Simpan
                              </button>
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
    $.dobPicker({
      // Selectopr IDs
      daySelector: '#dobday',
      monthSelector: '#dobmonth',
      yearSelector: '#dobyear',

      // Default option values
      dayDefault: 'Tangal',
      monthDefault: 'Bulan',
      yearDefault: 'Tahun',

      // Minimum age
      minimumAge: 10,

      // Maximum age
      maximumAge: 80
    });

  });

</script>
@endsection
