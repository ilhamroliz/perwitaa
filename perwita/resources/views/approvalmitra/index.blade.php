@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
.popover-navigation [data-role="next"] { display: none; }
.popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Approval Mitra</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Mitra</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Daftar Approval Mitra</h5>
      </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">

                  <center>
                    <div class="spiner-example">
                        <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                            <div class="sk-rect1 tampilkan" ></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                        <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Daftar Approval</span>
                    </div>
                </center>


                <table id="approvalmitra" class="table table-bordered" cellspacing="0" width="100%" style="display:none">
                    <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Mitra</th>
                          <th>Alamat Mitra</th>
                          <th>Nomor Telepon</th>
                          <th>Keterangan</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
</div>

<div class="modal inmodal" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width : 1000px">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                            <div class="image" id="showimage">
                                  <i class="fa fa-folder-open modal-icon"></i>
                            </div>
                <h4 class="modal-title">Detail Mitra</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-lg-3">
                        <h3>Nama Mitra </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_name">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Alamat Mitra </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_address">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Nomor Telepon </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_phone">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Nama Contact Person </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_cp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No Contact Person </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_cp_phone">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Fax </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_fax">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Keterangan </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_note">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3> </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_note"></h3>
                    </div>
                    <table id="tabel_detail" class="table table-bordered table-striped tabel_detail">

                    </table>
              </div>
              <div class="modal-footer">
                <button type="button" name="button" class="btn btn-primary" id="setujui" onclick="setujui()">Setujui</button>
                <button type="button" name="button" class="btn btn-danger" id="tolak" onclick="tolak()">Tolak</button>
                  <div class="btn-group">
                      <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>



@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;

setTimeout(function () {
  $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    $('#approvalmitra').css('display', '');
    $('.spiner-example').css('display', 'none');
    table = $("#approvalmitra").DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            'url': '{{ url('/approvalmitra/table') }}',
            'type': 'POST',
          },
        dataType: 'json',
        columns: [
        {data: 'number', name: 'number'},
        {data: 'm_name', name: 'm_name'},
        {data: 'm_address', name: 'm_address'},
        {data: 'm_phone', name: 'm_phone'},
        {data: 'm_note', name: 'm_note'},
        {data: 'action', name: 'action',orderable:false,searchable:false}
        ],
        responsive: true,
        "pageLength": 10,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
    //"scrollY": '50vh',
    //"scrollCollapse": true,
    "language": dataTableLanguage,
});
}, 1000);

    function detail(id){
      $.ajax({
        type: 'get',
        data: {id:id},
        url: baseUrl + '/approvalmitra/detail',
        dataType: 'json',
        success : function(result){
          $("#m_name").text(": "+result.m_name);
          $("#m_address").text(": "+result.m_address);
          $("#m_cp").text(": "+result.m_cp);
          $("#m_cp_phone").text(": "+result.m_cp_phone);
          $("#m_fax").text(": "+result.m_fax);
          $("#m_note").text(": "+result.m_note);
          $("#m_phone").text(": "+result.m_phone);
        }
      })
      $("#modal-detail").modal('show');
    }

    function setujui(id){
      swal({
              title: "Konfirmasi",
              text: "Apakah anda yakin ingin menyetujui Mitra ini?",
              type: "warning",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true,
          },
          function () {
              swal.close();
              $("#modal-detail").modal('hide');
              waitingDialog.show();
              setTimeout(function () {
                  $.ajax({
                    type: 'get',
                    data: {id:id},
                    url: baseUrl + '/approvalmitra/setujui',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Mitra Disetujui",
                                  text: "Mitra Berhasil Disetujui",
                                  type: "success",
                                  showConfirmButton: false,
                                  timer: 900
                              });
                              table.draw();
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

    function tolak(id){
      swal({
              title: "Konfirmasi",
              text: "Apakah anda yakin ingin menolak Mitra ini?",
              type: "warning",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true,
          },
          function () {
              swal.close();
              $("#modal-detail").modal('hide');
              waitingDialog.show();
              setTimeout(function () {
                  $.ajax({
                    type: 'get',
                    data: {id:id},
                    url: baseUrl + '/approvalmitra/tolak',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Mitra Ditolak",
                                  text: "Pekerja Berhasil Ditolak",
                                  type: "success",
                                  showConfirmButton: false,
                                  timer: 900
                              });
                              table.draw();
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
</script>
@endsection
