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
        <h2>Approval Penerimaan Return</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Penerimaan Return</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Daftar Penerimaan Return</h5>
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

                <form class="formapprovalmitra" id="formapprovalpermintaan">
                <table id="approvalpermintaan" class="table table-bordered" cellspacing="0" width="100%" style="display:none">
                    <thead>
                        <tr>
                          <th>
                              <input type="checkbox" class="setCek" onclick="selectall()">
                          </th>
                          <th>Nota Return</th>
                          <th>Nama Item</th>
                          <th>QTY</th>
                          <th>No Do</th>
                          <th style="width:140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $index => $x)
                      <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                          <td>
                              <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$x->rsa_id}}">
                          </td>
                        <td>{{$x->rs_nota}}</td>
                        <td> <strong>{{$x->k_nama}}</strong> </br> {{$x->i_nama}} {{$x->s_nama}} </td>
                        <td>{{$x->rsa_qty}}</td>
                        <td>{{$x->rsa_nodo}}</td>
                        <td align="center">
                          <div class="action">
                            <button type="button" title="Setujui" onclick="setujui({{$x->rsa_id}})" class="btn btn-primary btn-xs" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                            <button type="button" title="Tolak" onclick="tolak({{$x->rsa_id}})"  class="btn btn-danger btn-xs" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
                          </div>
                      </td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
                </form>
                <div class="pull-right">
                  <button type="button" class="btn btn-danger btn-outline" name="button" onclick="tolaklist()"> <i class="glyphicon glyphicon-remove"></i> Tolak Checklist</button>
                  <button type="button" class="btn btn-primary btn-outline" name="button" onclick="setujuilist()"> <i class="glyphicon glyphicon-ok"></i> Setujui Checklist</button>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

{{-- <div class="modal inmodal" id="detail" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style="width : 1000px">
        <div class="modal-content animated fadeIn">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-id-card-o modal-icon"></i>
                  <h4 class="modal-title">Penerimaan Return</h4>
                      </div>
                        <div class="modal-body">
                            <div class="form-group">
                              <div class="col-lg-3">
                                      <h3>No Kontrak </h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3 style="font-weight:normal;" id="mc_no">: -</h3>
                                  </div>
                              <div class="col-lg-3">
                                      <h3>Nama Mitra </h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3 style="font-weight:normal;" id="mc_mitra">: -</h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3>Nama Divisi </h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3 style="font-weight:normal;" id="mc_divisi">: -</h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3>Nama Perusahaan </h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3 style="font-weight:normal;" id="mc_comp">: -</h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3>Jabatan </h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3 style="font-weight:normal;" id="mc_jabatan">: -</h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3>Jobdesk </h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3 style="font-weight:normal;" id="mc_jobdesk">: -</h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3>Note </h3>
                                  </div>
                                  <div class="col-lg-3">
                                      <h3 style="font-weight:normal;" id="mc_note">: -</h3>
                                  </div>
                                  </div>

                                  <div class="col-lg-12">
                                        <h3>&nbsp</h3>
                                    </div>

                                  <div class="col-lg-12">
                                    <h3 style="font-style: italic;">List Pekerja : </h3>
                                </div>

                                <div>
                                  <table class="table table-striped table-bordered" id='table'>
                                      <thead>
                                        <tr>
                                          <th>No</th>
                                          <th>Nama Pekerja</th>
                                          <th>NIK</th>
                                          <th>No Hp</th>
                                        </tr>
                                      </thead>
                                      <tbody id='showdata'>

                                      </tbody>
                                  </table>
                                </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
 --}}



@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;
var countmitra = 0;
var totalmitra = 0;
$( document ).ready(function() {

$('#approvalpermintaan').hide();
myFunction();

function myFunction() {
setTimeout(function(){
  $(".spiner-example").css('display', 'none');
  table = $("#approvalpermintaan").DataTable({
    "processing": true,
    "paging": false,
    "searching": false,
    "deferLoading": 57,
    responsive: true,
    "language": dataTableLanguage
  });
  $('#approvalpermintaan').show();
},1500);
  }

});

 function setujui(id){
   swal({
           title: "Konfirmasi",
           text: "Apakah anda yakin ingin menyetujui ini?",
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
                 type: 'get',
                 data: {id:id},
                 url: baseUrl + '/approvalpenerimaanreturn/setujui',
                 dataType: 'json',
                   success: function (response) {
                       waitingDialog.hide();
                       if (response.status == 'berhasil') {
                           swal({
                               title: "Disetujui",
                               text: "Berhasil Disetujui",
                               type: "success",
                               showConfirmButton: false,
                               timer: 900
                           });
                           setTimeout(function(){
                                 window.location.reload();
                         }, 850);
                       } else if (response.status == 'tidak sesuai') {
                         swal({
                             title: "Info!",
                             text: "QTY tidak sesuai",
                             type: "success",
                             showConfirmButton: true
                         });
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
              text: "Apakah anda yakin ingin menolak ini?",
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
                    type: 'get',
                    data: {id:id},
                    url: baseUrl + '/approvalpenerimaanreturn/tolak',
                    dataType: 'json',
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Ditolak",
                                  text: "Berhasil Ditolak",
                                  type: "success",
                                  showConfirmButton: false,
                                  timer: 900
                              });
                              setTimeout(function(){
                                    window.location.reload();
                            }, 850);
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

    function selectall() {

        if ($('.setCek').is(":checked")) {
            table.$('input[name="pilih[]"]').prop("checked", true);
            //table.$('input[name="pilih[]"]').css('background','red');
            table.$('.chek-all').val('1');
        } else {
            table.$('input[name="pilih[]"]').prop("checked", false);
            table.$('.chek-all').val('');
        }
        hitung();
        //hitungSelect();
    }

    function selectBox(id) {
        if (table.$('.pilih-' + id).is(":checked")) {
            table.$('.pilih-' + id).prop("checked", false);
            table.$('.chek-' + id).val('1');
        } else {
            table.$('.pilih-' + id).prop("checked", true);
            table.$('.chek-' + id).val('');
        }
        //hitungSelect();
        hitung();
    }

    function hitung() {
        countmitra = table.$("input[name='pilih[]']:checked").length;
        $('#totalPekerja').val(countmitra + totalmitra);
    }

    function hitungSelect() {
        for (i = 0; i <= table.$('tr').length; i++)
            if (table.$('.pilih-' + i).is(":checked")) {
                table.$('.select-' + i).css('background', '#bbc4d6')
                //table.$('.select-'+i).css('color','white')
            } else {
                table.$('.select-' + i).css('background', '')
            }
    }

    function select(id) {
        if (table.$('.pilih-' + id).is(":checked")) {
            table.$('.pilih-' + id).prop("checked", false);
            table.$('.chek-' + id).val('');
        } else {
            table.$('.pilih-' + id).prop("checked", true);
            table.$('.chek-' + id).val('1');
        }
        //hitungSelect();
        hitung();
    }

    function setujuilist(){
      waitingDialog.show();
      setTimeout(function () {
      $.ajax({
        type: 'get',
        data: $('#formapprovalpermintaan').serialize(),
        url: baseUrl + '/approvalpenerimaanreturn/setujuilist',
        dataType: 'json',
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
              swal({
                  title: "Disetujui",
                  text: "Berhasil Disetujui",
                  type: "success",
                  showConfirmButton: false,
                  timer: 900
              });
              setTimeout(function(){
                    window.location.reload();
            }, 850);
          } else if (response.status == 'tidak sesuai') {
            swal({
                title: "Info!",
                text: "QTY tidak sesuai",
                type: "success",
                showConfirmButton: true
            });
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
      });
    }, 2000);
    }

    function tolaklist(){
      waitingDialog.show();
      setTimeout(function () {
      $.ajax({
        type: 'get',
        data: $('#formapprovalpermintaan').serialize(),
        url: baseUrl + '/approvalpenerimaanreturn/tolaklist',
        dataType: 'json',
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
            swal({
                title: "Ditolak",
                text: "Berhasil Ditolak",
                type: "success",
                showConfirmButton: false,
                timer: 900
            });
              setTimeout(function(){
                    window.location.reload();
            }, 850);
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
      });
    }, 2000);
    }

</script>
@endsection
