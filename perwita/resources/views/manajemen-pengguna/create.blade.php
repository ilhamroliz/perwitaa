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
    #password + .glyphicon {
       cursor: pointer;
       pointer-events: all;
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
                    <form class="form-horizontal form-user" action="{{ url('manajemen-pengguna/simpan') }}" accept-charset="UTF-8" id="formuser" enctype="multipart/form-data" method="POST">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="form-group row">
                          <label for="nama" class="col-sm-2 control-label">Nama</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pengguna" style="text-transform:capitalize" required>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="perusahaan" class="col-sm-2 control-label">Perusahaan</label>
                          <div class="col-sm-8">
                              <select name="perusahaan" class="form-control perusahaan" id="perusahaan">
                                <option value="-" selected disabled>-- Pilih Perusahaan --</option>
                                @foreach($comp as $data)
                                  <option value="{{ $data->c_id }}">{{ $data->c_name }}</option>
                                @endforeach
                              </select>
                          </div>
                          <div class="col-sm-2">
                            <button type="button" onclick="tambahPerusahaan()" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Tambah</button>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="username" class="col-sm-2 control-label">Username</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="username" id="username" placeholder="Username" onBlur="cekUsername()" required>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="password" class="col-sm-2 control-label">Password</label>
                          <div class="col-sm-10 has-feedback">
                              <input type="password" class="form-control" name="password" id="password" placeholder="Password" required><i class="glyphicon glyphicon-eye-open form-control-feedback"></i>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="passwordagain" class="col-sm-2 control-label">Validasi Password</label>
                          <div class="col-sm-10">
                              <input type="password" class="form-control" name="passwordagain" id="passwordagain" placeholder="Masukan Password Lagi" required>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="jabatan" class="col-sm-2 control-label">Jabatan</label>
                          <div class="col-sm-8">
                              <select name="jabatan" class="form-control jabatan" id="jabatan">
                                <option value="-" selected disabled>-- Pilih Jabatan --</option>
                                @foreach($jabatan as $data)
                                  <option value="{{ $data->j_id }}">{{ $data->j_name }}</option>
                                @endforeach
                              </select>
                          </div>
                          <div class="col-sm-2">
                            <button type="button" onclick="tambahJabatan()" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Tambah</button>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label for="tanggal" class="col-sm-2 control-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                          <select id="dobday" class="form-control col-sm-2" style="width: 13%;" name="tanggal" ></select>
                          <select id="dobmonth" class="form-control col-sm-4" style="width: 20%; margin-left: 10px" name="bulan"></select>
                          <select id="dobyear" class="form-control col-sm-3" style="width: 15%; margin-left: 10px" name="tahun"></select>
                        </div>
                      </div>
                      <div class="form-group row">
                          <label for="alamat" class="col-sm-2 control-label">Alamat</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" required>
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Foto</label>
                        <div class="col-sm-9">
                            <label class="btn btn-default" for="upload-file-selector">
                                <input id="upload-file-selector" name="imageUpload" class="uploadGambar" type="file" >
                                <i class="fa fa-upload margin-correction"></i>upload gambar
                            </label>
                        </div>
                        <div class="col-sm-6 image-holder col-sm-offset-3" style="padding:0px; margin-top: 20px;">

                        </div>
                      </div>
                      <div class="hr-line-dashed"></div>
                      <div class="form-group row">
                          <div class="col-sm-4 col-sm-offset-8 pull-right">
                              <button class="pull-right btn btn-primary btn-outlinebtn-flat simpan" type="submit" style="margin-left: 5px;">
                                  Simpan
                              </button>
                              <a href="{{url('/manajemen-pengguna/pengguna')}}" class="btn btn-danger btn-flat pull-right">Kembali</a>
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

  $(".uploadGambar").on('change', function () {
      $('.save').attr('disabled', false);
      if (typeof (FileReader) != "undefined") {
          var image_holder = $(".image-holder");
          image_holder.empty();
          var reader = new FileReader();
          reader.onload = function (e) {
              image_holder.html('<img src="{{ asset('image/loading1.gif') }}" class="img-responsive" width="120px">');
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

  $('#formuser').on('submit', function(e){
    var pass = $('#password').val();
    var again = $('#passwordagain').val();
    var jabatan = $('#jabatan').val();
    var perusahaan = $('#perusahaan').val();
    var tanggal = $('#dobday').val();
    var bulan = $('#dobmonth').val();
    var tahun = $('#dobyear').val();
    if (pass != again) {
      Command: toastr["warning"]("Password tidak sesuai", "Peringatan !")
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
      $('#password').val('');
      $('#passwordagain').val('');
      $('#password').focus();
      return false;
    }

    if (jabatan == null) {
      Command: toastr["warning"]("form jabatan tidak boleh kosong", "Peringatan !")
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
      $('#jabatan').focus();
      return false;
    }

    if (perusahaan == null) {
      Command: toastr["warning"]("form perusahaan tidak boleh kosong", "Peringatan !")
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
      $('#perusahaan').focus();
      return false;
    }

    if (tanggal == '') {
      Command: toastr["warning"]("form tanggal lahir tidak boleh kosong", "Peringatan !")
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
      $('#dobday').focus();
      return false;
    }

    if (bulan == '') {
      Command: toastr["warning"]("form bulan lahir tidak boleh kosong", "Peringatan !")
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
      $('#dobmonth').focus();
      return false;
    }

    if (tahun == '') {
      Command: toastr["warning"]("form tahun lahir tidak boleh kosong", "Peringatan !")
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
      $('#dobyear').focus();
      return false;
    }
  });

  function cekUsername(){
    var user = $('#username').val();
    if (user != null) {
      $.ajax({
        type: 'get',
        data: {username: user},
        url: baseUrl + '/manajemen-pengguna/cekUsername',
        dataType: 'json',
        success : function(response){
          if (response.status == 'gagal') {
            alert('username tidak tersedia');
            $('#username').val('');
            $('#username').focus();
            return false;
          }
        },
        error: function (xhr, status) {
          waitingDialog.hide();
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
        }
      });
    }
  }

  $("#username").keypress(function(event){
    var ew = event.which;
    if(ew == 32)
      return false;
    if(48 <= ew && ew <= 57)
      return true;
    if(65 <= ew && ew <= 90)
      return true;
    if(97 <= ew && ew <= 122)
      return true;
    return false;
  });

   // toggle password visibility
    $('#password + .glyphicon').on('click', function() {
      $(this).toggleClass('glyphicon-eye-close').toggleClass('glyphicon-eye-open'); // toggle our classes for the eye icon
      //$('#password').password('toggle'); // activate the hideShowPassword plugin
      if (document.getElementById('password').type == 'text') {
        document.getElementById('password').type = 'password';
      } else {
        document.getElementById('password').type = 'text';
      }
    });

  function tambahPerusahaan(){
    window.location.href = baseUrl + '/master-perusahaan';
  }

  function tambahJabatan(){
    window.location.href = baseUrl + '/master-jabatan';
  }

</script>
@endsection
