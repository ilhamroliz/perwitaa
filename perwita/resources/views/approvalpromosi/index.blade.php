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
                                <th>Jabatan</th>
                                <th>NIK</th>
                                <th>NIK Mitra</th>
                                <th>Mitra</th>
                                <th>Divisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $index => $x)
                          <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                              <td>
                                  <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$x->pd_id}}">
                              </td>
                                <td>{{$x->p_name}}</td>
                                <td>{{$x->jp_name}}</td>
                                <td>{{$x->p_nip}}</td>
                                <td>{{$x->p_nip_mitra}}</td>
                                <td>{{$x->m_name}}</td>
                                <td>{{$x->md_name}}</td>
                                <td align="center">
                                <button type="button" onclick="detail({{$x->pd_id}})" id="detailbtn" class="btn btn-info btn-sm" name="button"> <i class="glyphicon glyphicon-folder-open"></i> </button>
                                <button type="button" onclick="setujui({{$x->pd_id}})" class="btn btn-primary btn-sm" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                                <button type="button" onclick="tolak({{$x->pd_id}})"  class="btn btn-danger btn-sm" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
                               </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                  </form>
                  <div class="pull-right">
                    <button type="button" class="btn btn-danger" name="button" onclick="tolaklist()"> <i class="glyphicon glyphicon-remove"></i> Tolak Checklist</button>
                    <button type="button" class="btn btn-primary" name="button" onclick="setujuilist()"> <i class="glyphicon glyphicon-ok"></i> Setujui Checklist</button>
                  </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- <div class="modal inmodal" id="modal-detail" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                  <div class="modal-content animated fadeIn">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <i class="fa fa-folder modal-icon"></i>
                      <h4 class="modal-title">Detail SP</h4>
                  <small>Detail SP</small>
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
                    <h3>No SP : <span style="font-weight:normal;" id="sp_no">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Nama Tenaga Kerja : <span style="font-weight:normal;" id="namapekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Jabatan : <span style="font-weight:normal;" id="jabatanpekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Divisi : <span style="font-weight:normal;" id="divisipekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Keterangan : <span style="font-weight:normal;" id="keteranganpekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Status Approval : <span style="font-weight:normal;" id="approve">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Tanggal Mulai - Tanggal Berakhir : <span style="font-weight:normal;" id="tanggalmulaiberakhir">-</span></h3>
                </div>
              </div>
            </div>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="printbtn" name="button" onclick="print()"><i class="fa fa-print">&nbsp;</i>Print</button>
                  <div class="btn-group">
                      <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                  </div>
              </div>
          </div>
      </div>
  </div> -->

@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;
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
  swal({
          title: "Konfirmasi",
          text: "Apakah anda yakin ingin menyetujui Promosi ini?",
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
                              title: "Promosi Disetujui",
                              text: "Promosi Berhasil Disetujui",
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
  swal({
          title: "Konfirmasi",
          text: "Apakah anda yakin ingin menolak Promosi ini?",
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
                              title: "Promosi Ditolak",
                              text: "Promosi Berhasil Ditolak",
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
              title: "Promosi Disetujui",
              text: "Promosi Berhasil Disetujui",
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
            title: "Promosi Ditolak",
            text: "Promosi Berhasil Ditolak",
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

// function detail(id){
//   $('#modal-detail').modal('show');
//   $('#showdetail').hide();
//   $.ajax({
//     type: 'get',
//     data: {id:id},
//     url: baseUrl + '/approvalsp/detail',
//     dataType: 'json',
//     success : function(result){
//       $('#sp_no').text(result[0].sp_no);
//       $('#namapekerja').text(result[0].p_name);
//       $('#jabatanpekerja').text(result[0].p_jabatan);
//       $('#divisipekerja').text(result[0].md_name);
//       $('#keteranganpekerja').text(result[0].sp_note);
//       $('#tanggalmulaiberakhir').text(result[0].sp_date_start + ' - ' + result[0].sp_date_end);
//
//       if (result[0].sp_isapproved == 'P') {
//         $('#approve').html('<span class="label label-warning">Pending</span>');
//       } else if (result[0].sp_isapproved == 'Y') {
//         $('#approve').html('<span class="label label-success">Disetujui</span>');
//       } else if (result[0].sp_isapproved == 'N') {
//         $('#approve').text('<span class="label label-danger">Ditolak</span>');
//       }
//
//       //Button
//       $('#printbtn').attr('onclick','print('+id+')');
//
//       $('.spiner-sp').hide();
//       $('#showdetail').show();
//
//     }
//   });
// }
//
// function print(id){
//   window.location.href = baseUrl + '/approvalsp/print?id='+id;
// }

</script>
@endsection
