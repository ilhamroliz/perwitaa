@extends('main')

@section('title', 'Data Pekerja')

@section('extra_styles')

    <style>
        .popover-navigation [data-role="next"] {
            display: none;
        }

        .popover-navigation [data-role="end"] {
            display: none;
        }

        table.dataTable tbody td {
            vertical-align: middle;
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
                <strong>Data Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Data Pekerja</h5>
        <button style="float: right; margin-top: -7px;" class="btn btn-primary btn-flat btn-sm" type="button"
                aria-hidden="true" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;Tambah
        </button>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    @if(Session::has('sukses'))
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <strong>{{ Session::get('sukses') }}</strong>
                        </div>
                    @elseif(Session::has('gagal'))
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <strong>{{ Session::get('gagal') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">
                </div>
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1pjtki"> Pekerja Aktif</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2pjtki"> Calon Pekerja</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-3pjtki"> Pekerja non-Aktif</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1pjtki" class="tab-pane active">
                            <div class="panel-body">
                                <table id="pekerjapjtki" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 22%;">Nama</th>
                                        <th style="width: 15%;">NIK</th>
                                        <th style="width: 5%;">Jk</th>
                                        <th style="width: 15%;">No Telp.</th>
                                        <th style="width: 25%;">Alamat</th>
                                        <th style="width: 5%;">Status</th>
                                        <th style="width: 15%;">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tab-2pjtki" class="tab-pane">
                            <div class="panel-body">
                                <table id="calon-pekerjapjtki" class="table table-bordered table-striped"
                                       style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th style="width: 22%;">Nama</th>
                                        <th style="width: 5%;">Jk</th>
                                        <th style="width: 15%;">No Telp.</th>
                                        <th style="width: 25%;">Alamat</th>
                                        <th style="width: 5%;">Status</th>
                                        <th style="width: 15%;">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tab-3pjtki" class="tab-pane">
                            <div class="panel-body">
                                <table id="pekerja-nonpjtki" class="table table-bordered table-striped"
                                       style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th style="width: 22%;">Nama</th>
                                        <th style="width: 15%;">NIK</th>
                                        <th style="width: 5%;">Jk</th>
                                        <th style="width: 15%;">No Telp.</th>
                                        <th style="width: 25%;">Alamat</th>
                                        <th style="width: 5%;">Status</th>
                                        <th style="width: 15%;">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal inmodal" id="modal-detailpjtki" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" style="width : 1000px">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                            class="sr-only">Close</span></button>
                                <i class="fa fa-user modal-icon"></i>
                                <h4 class="modal-title">Detail Pekerja</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <h3>Nama Pekerja </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_namepjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Nama Ibu </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_momnamepjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>No NIK </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_nikpjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>No NIK Mitra </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_nik_mitrapjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>No KPJ </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_kpj_nopjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Jenis Kelamin </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_sexpjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Nama Mitra </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="m_namepjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Tempat Lahir </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_birthplacepjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Nama Divisi </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="md_namepjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Tanggal Lahir </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_birthdatepjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Tanggal Seleksi </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="mp_selection_datepjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Alamat </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_addresspjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Tanggal Masuk Kerja </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="mp_workin_datepjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>No Hp </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_hppjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Tanggal Awal Kontrak </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="mc_datepjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>No KTP </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_ktppjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>tanggal Kontrak Berakhir </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="mc_expiredpjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Tanggal Berlaku KTP </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="b_ktppjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Sisa Waktu Kontrak </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="sisa_kontrakpjtki">: -</h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3>Pendidikan </h3>
                                    </div>
                                    <div class="col-lg-3">
                                        <h3 style="font-weight:normal;" id="p_educationpjtki">: -</h3>
                                    </div>


                                </div>
                                <div class="col-lg-12">
                                    <h3>&nbsp</h3>
                                </div>
                                <div class="col-lg-12">
                                    <h3 style="font-style: italic; color: blue">History Pekerja</h3>
                                </div>
                                <form class="form-horizontal">
                                    <table id="tabel_detailpjtki"
                                           class="table table-bordered table-striped tabel_detail">

                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                                </div>
                                <button type="button" id="printbtnpjtki" class="btn btn-primary" onclick="print()" name="button"><i class="fa fa-print">&nbsp;</i>Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="modal inmodal" id="myModalpjtki" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content animated fadeIn">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <i class="fa fa-sign-out modal-icon"></i>
                  <h4 class="modal-title">Resign</h4>
                  <small class="font-bold">Pekerja mengajukan untuk resign</small>
              </div>
              <div class="modal-body">
                  <h3 class="namabarang"></h3>
                  <form class="form-horizontal">
                      <div class="form-dinamis">
                          <div class="form-group getkonten0">
                              <label class="col-sm-2 control-label" for="keteranganresign">Keterangan</label>
                              <div class="col-sm-10 selectukuran0">
                                  <input type="text" name="keterangan" id="keteranganresignpjtki" class="form-control" placeholder="Keterangan Resign" title="Keterangan Resign">
                              </div>
                          </div>
                          <div class="form-group getkonten1">
                              <label class="col-sm-2 control-label" for="tgl-resign">Tanggal</label>
                              <div class="col-sm-5">
                                  <input type="text" name="tanggal" id="tgl-resignpjtki" class="form-control" style="text-align: center;">
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                  <button onclick="simpanresign()" id="simpanbtnpjtki" class="btn btn-primary btn-outline" type="button">Simpan</button>
              </div>
          </div>
      </div>
  </div>


@endsection

@section('extra_scripts')
  <script type="text/javascript">
      var table;
      var tablenon;
      var tablecalon;

      $('#tgl-resignpjtki').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
      }).datepicker("setDate", "0");

      $(document).ready(function () {
          setTimeout(function () {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              table = $("#pekerjapjtki").DataTable({
                  "search": {
                      "caseInsensitive": true
                  },
                  processing: true,
                  serverSide: true,
                  "ajax": {
                      "url": "{{ url('pekerja-pjtki/data-pekerja/table') }}",
                      "type": "POST"
                  },
                  columns: [
                      {data: 'pp_name', name: 'pp_name'},
                      {data: 'pp_nip', name: 'pp_nip'},
                      {data: 'pp_sex', name: 'pp_sex'},
                      {data: 'pp_hp', name: 'pp_hp'},
                      {data: 'pp_address', name: 'pp_address'},
                      {data: 'ppm_status', name: 'ppm_status'},
                      {data: 'action', name: 'action', orderable: false, searchable: false}
                  ],
                  responsive: true,
                  "pageLength": 10,
                  "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                  //"scrollY": '50vh',
                  //"scrollCollapse": true,
                  "language": dataTableLanguage,
              });
              $('#pekerjapjtki').css('width', '100%').dataTable().fnAdjustColumnSizing();
          }, 1500);

          setTimeout(function () {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              tablenon = $("#pekerja-nonpjtki").DataTable({
                  "search": {
                      "caseInsensitive": true
                  },
                  processing: true,
                  serverSide: true,
                  "ajax": {
                      "url": "{{ url('pekerja-pjtki/data-pekerja/tablenon') }}",
                      "type": "POST"
                  },
                  columns: [
                      {data: 'pp_name', name: 'pp_name'},
                      {data: 'pp_nip', name: 'pp_nip'},
                      {data: 'pp_sex', name: 'pp_sex'},
                      {data: 'pp_hp', name: 'pp_hp'},
                      {data: 'pp_address', name: 'pp_address'},
                      {data: 'ppm_status', name: 'ppm_status'},
                      {data: 'action', name: 'action', orderable: false, searchable: false}
                  ],
                  responsive: true,
                  "pageLength": 10,
                  "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                  //"scrollY": '50vh',
                  //"scrollCollapse": true,
                  "language": dataTableLanguage,
              });
              $('#pekerja-nonpjtki').css('width', '100%').dataTable().fnAdjustColumnSizing();
          }, 3500);

          setTimeout(function () {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              tablecalon = $("#calon-pekerjapjtki").DataTable({
                  "search": {
                      "caseInsensitive": true
                  },
                  processing: true,
                  serverSide: true,
                  "ajax": {
                      "url": "{{ url('pekerja-pjtki/data-pekerja/tablecalon') }}",
                      "type": "POST"
                  },
                  columns: [
                      {data: 'pp_name', name: 'pp_name'},
                      {data: 'pp_sex', name: 'pp_sex'},
                      {data: 'pp_hp', name: 'pp_hp'},
                      {data: 'pp_address', name: 'pp_address'},
                      {data: 'ppm_status', name: 'ppm_status'},
                      {data: 'action', name: 'action', orderable: false, searchable: false}
                  ],
                  responsive: true,
                  "pageLength": 10,
                  "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                  //"scrollY": '50vh',
                  //"scrollCollapse": true,
                  "language": dataTableLanguage,
              });
              $('#calon-pekerjapjtki').css('width', '100%').dataTable().fnAdjustColumnSizing();
          }, 2500);
      });


      function tambah() {
          window.location.href = baseUrl + '/pekerja-pjtki/data-pekerja/tambah';
      }


      function hapus(id) {
          swal({
                  title: "Konfirmasi",
                  text: "Apakah anda yakin ingin menghapus data Pegawai?",
                  type: "warning",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true,
              },
              function () {
                  swal.close();
                  waitingDialog.show();
                  setTimeout(function () {
                      $.ajax({
                          url: baseUrl + '/pekerja-pjtki/data-pekerja/hapus/' + id,
                          type: 'get',
                          timeout: 10000,
                          success: function (response) {
                              waitingDialog.hide();
                              if (response.status == 'berhasil') {
                                  swal({
                                      title: "Data Dihapus",
                                      text: "Data berhasil dihapus",
                                      type: "success",
                                      showConfirmButton: false,
                                      timer: 900
                                  });
                                  table.draw();
                                  tablenon.draw();
                                  tablecalon.draw();
                              }
                          }, error: function (x, e) {
                              waitingDialog.hide();
                              var message;
                              if (x.status == 0) {
                                  message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                              } else if (x.status == 404) {
                                  message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                              } else if (x.status == 500) {
                                  message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                              } else if (e == 'parsererror') {
                                  message = 'Error.\nParsing JSON Request failed.';
                              } else if (e == 'timeout') {
                                  message = 'Request Time out. Harap coba lagi nanti';
                              } else {
                                  message = 'Unknow Error.\n' + x.responseText;
                              }
                              waitingDialog.hide();
                              throwLoadError(message);
                              //formReset("store");
                          }
                      })
                  }, 2000);

              });


      }

      function detail(id) {
          var id = id;
          $('#printbtnpjtki').attr('onclick','print('+id+')')
          $.ajax({
              data: {id: id},
              type: "GET",
              url: baseUrl + "/pekerja-pjtki/data-pekerja/detail",
              dataType: 'json',
              success: function (data) {

                  var p_nik, p_nip, p_nip_mitra, p_name, p_sex, p_birthplace, p_birthdate, p_address, p_hp;
                  var p_ktp, b_ktp, p_education, p_momname, p_kpj_no, m_name, md_name, mp_selection_date;
                  var mp_workin_date, mc_date, mc_expired, sisa_kontrak;

                  $.each(data, function (i, n) {

                      p_nip = n.pp_nip;
                      p_nip_mitra = n.pp_nip_mitra;
                      p_nik = n.pp_nik;
                      p_name = n.pp_name;
                      p_sex = n.pp_sex;
                      p_birthplace = n.pp_birthplace;
                      p_birthdate = n.pp_birthdate;
                      p_address = n.pp_address;
                      p_hp = n.pp_hp;
                      p_ktp = n.pp_ktp;

                      if (n.pp_ktp_seumurhidup == "Y") {
                          b_ktp = "Seumur Hidup";
                      } else {
                          b_ktp = n.pp_ktp_expired;
                      }

                      p_education = n.pp_education;
                      p_momname = n.pp_momname;
                      p_kpj_no = n.pp_kpj_no;
                      m_name = n.m_name;
                      md_name = n.md_name;
                      mp_selection_date = n.mp_selection_date;
                      mp_workin_date = n.mp_workin_date;
                      mc_date = n.mc_date;
                      mc_expired = n.mc_expired;
                      sisa_kontrak = n.sisa_kontrak;

                  });

                  if (typeof sisa_kontrak == 'undefined' || sisa_kontrak == undefined || sisa_kontrak == '' || sisa_kontrak == null) {
                      sisa_kontrak = "-";
                  }
                  if (p_nip == undefined) {
                      p_nip = "-";
                  }
                  if (p_nip_mitra == undefined) {
                      p_nip_mitra = "-";
                  }
                  if (p_nik == undefined) {
                      p_nik = "-";
                  }
                  if (p_name == undefined) {
                      p_name = "-";
                  }
                  if (p_sex == undefined) {
                      p_sex = "-";
                  }
                  if (p_birthplace == undefined) {
                      p_birthplace = "-";
                  }
                  if (p_birthdate == undefined) {
                      p_birthdate = "-";
                  }
                  if (p_address == undefined) {
                      p_address = "-";
                  }
                  if (p_hp == undefined) {
                      p_hp = "-";
                  }
                  if (p_ktp == undefined) {
                      p_ktp = "-";
                  }
                  if (b_ktp == undefined) {
                      b_ktp = "-";
                  }
                  if (p_education == undefined) {
                      p_education = "-";
                  }
                  if (p_momname == undefined) {
                      p_momname = "-";
                  }
                  if (p_kpj_no == undefined) {
                      p_kpj_no = "-";
                  }
                  if (m_name == undefined) {
                      m_name = "-";
                  }
                  if (md_name == undefined) {
                      md_name = "-";
                  }
                  if (mp_selection_date == undefined) {
                      mp_selection_date = "-";
                  }
                  if (mp_workin_date == undefined) {
                      mp_workin_date = "-";
                  }
                  if (mc_date == undefined) {
                      mc_date = "-";
                  }
                  if (mc_expired == undefined) {
                      mc_expired = "-";
                  }
                  if (mc_date == "-" || mc_expired == "-") {
                      sisa_kontrak = "-";
                  }

                  // console.log(sisa_kontrak);
                  // console.log(mc_date);
                  $('#p_nik_mitrapjtki').html(": " + p_nip_mitra);
                  $('#p_nikpjtki').html(": " + p_nip);
                  $('#p_namepjtki').html(": " + p_name);
                  $('#p_sexpjtki').html(": " + p_sex);
                  $('#p_birthplacepjtki').html(": " + p_birthplace);
                  $('#p_birthdatepjtki').html(": " + p_birthdate);
                  $('#p_addresspjtki').html(": " + p_address);
                  $('#p_hppjtki').html(": " + p_hp);
                  $('#p_ktppjtki').html(": " + p_ktp);
                  $('#b_ktppjtki').html(": " + b_ktp);
                  $('#p_educationpjtki').html(": " + p_education);
                  $('#p_momnamepjtki').html(": " + p_momname);
                  $('#p_kpj_nopjtki').html(": " + p_kpj_no);
                  $('#m_namepjtki').html(": " + m_name);
                  $('#md_namepjtki').html(": " + md_name);
                  $('#mp_selection_datepjtki').html(": " + mp_selection_date);
                  $('#mp_workin_datepjtki').html(": " + mp_workin_date);
                  $('#mc_datepjtki').html(": " + mc_date);
                  $('#mc_expiredpjtki').html(": " + mc_expired);
                  $('#sisa_kontrakpjtki').html(": " + sisa_kontrak);

              }
          })

          $.ajax({
              data: {id: id},
              type: "GET",
              url: baseUrl + "/pekerja-pjtki/data-pekerja/detail-mutasi",
              dataType: 'json',
              success: function (data) {
                  var pekerja_mutasi = '<thead>'
                      + '<tr>'
                      + '<th style="text-align : center;"> TANGGAL </th>'
                      + '<th style="text-align : center;"> MITRA</th>'
                      + '<th style="text-align : center;"> DIVISI</th>'
                      + '<th style="text-align : center;"> KET</th>'
                      + '<th style="text-align : center;"> NO REFF</th>'
                      + '<th style="text-align : center;"> STATUS</th>'
                      + '</tr>'
                      + '</thead>'
                      + '<tbody>';

                  $.each(data, function (i, n) {

                    if (n.ppm_reff == null) {
                      var pm_reff = '-';
                    } else {
                      pm_reff = n.ppm_reff;
                    }

                    if (n.ppm_note == null) {
                      var pm_note = '-';
                    } else {
                      pm_note = n.ppm_note;
                    }

                    if (n.ppm_detail == 'Resign') {
                      pekerja_mutasi = pekerja_mutasi + '<tr>'
                          + '<td>' + n.ppm_date + '</td>'
                          + '<td>' + n.m_name + '</td>'
                          + '<td>' + n.md_name + '</td>'
                          + '<td>' + n.ppm_note + '</td>'
                          + '<td>' + pm_reff + '</td>'
                          + '<td>' + pm_note + '</td>'
                          + '</tr>';
                    } else {
                      pekerja_mutasi = pekerja_mutasi + '<tr>'
                          + '<td>' + n.ppm_date + '</td>'
                          + '<td>' + n.m_name + '</td>'
                          + '<td>' + n.md_name + '</td>'
                          + '<td>' + n.ppm_detail + '</td>'
                          + '<td>' + pm_reff + '</td>'
                          + '<td>' + pm_note + '</td>'
                          + '</tr>';
                    }
                  });
                  pekerja_mutasi = pekerja_mutasi + '</tbody';
                  $('#tabel_detailpjtki').html(pekerja_mutasi);
              }

          })

          $("#modal-detailpjtki").modal("show");
      }

      function resign(id){
          $('#myModalpjtki').modal('show');
          $('#simpanbtnpjtki').attr('onclick', 'simpanresign('+id+')');
      }

      function simpanresign(id){
        var keterangan = $('#keteranganresignpjtki').val();
        var tanggal = $('#tgl-resignpjtki').val();
        $.ajax({
          type: 'get',
          data: {id:id, keterangan:keterangan, tanggal: tanggal},
          dataType: 'json',
          url: baseUrl + '/pekerja-pjtki/data-pekerja/resign',
          success : function(result){
            if (result.status == 'berhasil') {
              swal({
                  title: "Berhasil Disimpan",
                  text: "Data berhasil Disimpan",
                  type: "success",
                  showConfirmButton: false,
                  timer: 900
              });
              $('#myModalpjtki').modal('hide');
            } else {
                swal({
                  title: "Gagal",
                  text: "Data gagal disimpan",
                  type: "danger",
                  showConfirmButton: false,
                  timer: 900
              });
              $('#myModalpjtki').modal('hide');
            }
            location.reload();
          }
        })
      }

      function print(id){
            window.location.href = baseUrl + '/approvalpelamar/print?id='+id;
      }


  </script>
@endsection
