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
        <h2>Approval Promosi</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Promosi</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Daftar Approval Promosi</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
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
                <form class="formapprovalpromosi" id="formapprovalpromosi">
                  @foreach($data as $z)
                  <input type="hidden" name="pd_no" id="pd_no" value="{{$z->pd_no}}">
                  @endforeach
                    <table id="promositabel" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>
                                  <input type="checkbox" class="setCek" onclick="selectall()">
                                </th>
                                <th>Nama</th>
                                <th>Jabatan Awal</th>
                                <th>Jabatan Sekarang</th>
                                <th>NIK</th>
                                <th>NIK Mitra</th>
                                <th>Mitra</th>
                                <th>Divisi</th>
                                <th>Status</th>
                                <th width="120px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $index => $x)
                          <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                              <td>
                                  <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$x->pd_id}}">
                              </td>
                                <td>{{$x->p_name}}</td>
                                <td>{{$x->pd_jabatan_awal}}</td>
                                <td>{{$x->pd_jabatan_sekarang}}</td>
                                <td>{{$x->p_nip}}</td>
                                <td>{{$x->p_nip_mitra}}</td>
                                <td>{{$x->m_name}}</td>
                                <td>{{$x->md_name}}</td>
                                @if(stristr($x->pd_no, 'PMS'))
                                <td class="sweetdinamis{{$x->pd_id}}">Promosi</td>
                                @elseif(stristr($x->pd_no, 'DMS'))
                                <td class="sweetdinamis{{$x->pd_id}}">Demosi</td>
                                @endif
                                <td align="center">
                                <button type="button" title="Detail" onclick="detail({{$x->pd_id}})" id="detailbtn" class="btn btn-info btn-sm" name="button"> <i class="glyphicon glyphicon-folder-open"></i> </button>
                                <button type="button" title="Setujui" onclick="setujui({{$x->pd_id}})" class="btn btn-primary btn-sm" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                                <button type="button" title="Tolak" onclick="tolak({{$x->pd_id}})"  class="btn btn-danger btn-sm" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
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

<div class="modal inmodal" id="modal-detail" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                  <div class="modal-content animated fadeIn">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <i class="fa fa-folder modal-icon"></i>
                      <h4 class="modal-title">Detail Promosi</h4>
                  <small>Detail Promosi</small>
              </div>
            <div class="modal-body">
              <center>
                <div class="spiner-sp">
                    <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                        <div class="sk-rect1 tampilkan" ></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                    <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Data SP</span>
                </div>
            </center>
            <div id="showdetail">
              <div class="row">
                <div class="col-lg-12">
                    <h3>No Promosi : <span style="font-weight:normal;" id="pdno">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Nama Pekerja : <span style="font-weight:normal;" id="namapekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Jabatan Awal : <span style="font-weight:normal;" id="jabatanawal">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Jabatan Sekarang : <span style="font-weight:normal;" id="jabatansekarang">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Keterangan : <span style="font-weight:normal;" id="keterangan">-</span></h3>
                </div>
              </div>
            </div>
            </div>
              <div class="modal-footer">
                  <div class="btn-group">
                      <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;
var countmitra;
var totalmitra;
$( document ).ready(function() {

$('#promositabel').hide();
myFunction();

function myFunction() {
setTimeout(function(){
  $(".spiner-example").css('display', 'none');
  table = $("#promositabel").DataTable({
    "processing": true,
    "paging": false,
    "searching": false,
    "deferLoading": 57,
    responsive: true,
    "language": dataTableLanguage
  });
  $('#promositabel').show();
},1500);
  }

});



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

function setujui(id){
  var pd_no = $('#pd_no').val();
  var dinamis = $('.sweetdinamis'+id).text();
  swal({
          title: "Konfirmasi",
          text: "Apakah anda yakin ingin menyetujui "+dinamis+" ini?",
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
                data: {id:id, pd_no:pd_no},
                url: baseUrl + '/approvalpromosi/setujui',
                dataType: 'json',
                timeout: 10000,
                  success: function (response) {
                      waitingDialog.hide();
                      if (response.status == 'berhasil') {
                          swal({
                              title: ""+dinamis+" Disetujui",
                              text: ""+dinamis+" Berhasil Disetujui",
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

function tolak(id){
  var dinamis = $('.sweetdinamis'+id).text();
  swal({
          title: "Konfirmasi",
          text: "Apakah anda yakin ingin menolak "+dinamis+" ini?",
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
                url: baseUrl + '/approvalpromosi/tolak',
                dataType: 'json',
                timeout: 10000,
                  success: function (response) {
                      waitingDialog.hide();
                      if (response.status == 'berhasil') {
                          swal({
                              title: ""+dinamis+" Ditolak",
                              text: ""+dinamis+" Berhasil Ditolak",
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

function setujuilist(){
  waitingDialog.show();
  setTimeout(function () {
  $.ajax({
    type: 'get',
    data: $('#formapprovalpromosi').serialize(),
    url: baseUrl + '/approvalpromosi/setujuilist',
    dataType: 'json',
    timeout: 10000,
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
    data: $('#formapprovalpromosi').serialize(),
    url: baseUrl + '/approvalpromosi/tolaklist',
    dataType: 'json',
    timeout: 10000,
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

function detail(id){
  $('#modal-detail').modal('show');
  $('#showdetail').hide();
  $.ajax({
    type: 'get',
    data: {id:id},
    url: baseUrl + '/approvalpromosi/detail',
    dataType: 'json',
    success : function(result){

      $('#jabatanawal').text(result.pd_jabatan_awal);
      $('#jabatansekarang').text(result.pd_jabatan_sekarang);
      $('#pdno').text(result.pd_no);
      $('#namapekerja').text(result.pd_pekerja);
      $('#keterangan').text(result.pd_note);

      $('.spiner-sp').hide();
      $('#showdetail').show();

    }
  });
}

</script>
@endsection
