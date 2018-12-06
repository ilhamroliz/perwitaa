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
        <h2>Approval Penerimaan Seragam</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Penerimaan Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Daftar Penerimaan Seragam</h5>
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
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Seragam</th>
                          <th>QTY</th>
                          <th>Penerima</th>
                          <th style="width:140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $index => $x)
                      <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                          <td>
                              <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$x->pa_detailid}}">
                              <input class="pilih-{{$index}}" type="hidden" name="purchase[]" onclick="selectBox({{$index}})" value="{{$x->pa_purchase}}">
                          </td>
                        <td>{{$x->pa_do}}</td>
                        <td>{{Carbon\Carbon::parse($x->pa_date)->format('d/m/Y G:i:s')}}</td>
                        <td>{{$x->i_nama . ' ' . $x->s_nama}}</td>
                        <td>{{$x->pa_qty}}</td>
                        <td>{{$x->m_name}}</td>
                        <td align="center">
                          <div class="action">
                            <button type="button" title="Detail" onclick="detail({{$x->pa_detailid}},{{$x->pa_purchase}})" class="btn btn-info btn-xs" name="button"> <i class="glyphicon glyphicon-folder-open"></i> </button>
                            <button type="button" title="Setujui" onclick="setujui({{$x->pa_detailid}},{{$x->pa_purchase}})" class="btn btn-primary btn-xs" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                            <button type="button" title="Tolak" onclick="tolak({{$x->pa_detailid}},{{$x->pa_purchase}})"  class="btn btn-danger btn-xs" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
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

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-folder-open modal-icon"></i>
                <h4 class="modal-title">Detail Pembelian</h4>
                <small class="font-bold">Detail barang pembelian ke supplier</small>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="table-modal">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;
var countmitra = 0;
var totalmitra = 0;
var tablemodal;
$( document ).ready(function() {

  tablemodal = $("#table-modal").DataTable({
      responsive: true,
      paging: false,
      "language": dataTableLanguage
  });

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

function detail(id, purchase){
    $.ajax({
      url: baseUrl + '/approvalpenerimaan/detail',
      type: 'get',
      data: {id:id, purchase:purchase},
      success: function(response){
        if (response.status == 'sukses') {
            var data = response.data;
            tablemodal.clear();
            for (var i = 0; i < data.length; i++) {
                var harga = 'Rp. '+accounting.formatMoney(data[i].pd_value, "", 0, ".", ",");
                var diskon = accounting.formatMoney(data[i].pd_disc_value, "", 0, ".", ",");
                tablemodal.row.add([
                    data[i].nama,
                    data[i].pd_qty,
                    harga,
                    diskon,
                    'Rp. '+accounting.formatMoney(data[i].pd_qty * data[i].pd_value, "", 0, ".", ",")
                ]).draw(false);
            }
        }
        $('#myModal').modal('show');
      }, error:function(x, e) {
          if (x.status == 0) {
              alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
          } else if (x.status == 404) {
              alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
          } else if (x.status == 500) {
              alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
          } else if (e == 'parsererror') {
              alert('Error.\nParsing JSON Request failed.');
          } else if (e == 'timeout'){
              alert('Request Time out. Harap coba lagi nanti');
          } else {
              alert('Unknow Error.\n' + x.responseText);
          }
        }
    })
}

 function setujui(id, purchase){
   swal({
           title: "Konfirmasi",
           text: "Apakah anda yakin ingin menyetujui Penerimaan ini?",
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
                 data: {id:id, purchase:purchase},
                 url: baseUrl + '/approvalpenerimaan/setujui',
                 dataType: 'json',
                   success: function (response) {
                       waitingDialog.hide();
                       if (response.status == 'berhasil') {
                           swal({
                               title: "Penerimaan Disetujui",
                               text: "Penerimaan Berhasil Disetujui",
                               type: "success",
                               showConfirmButton: false,
                               timer: 900
                           });
                           setTimeout(function(){
                                 window.location.reload();
                         }, 850);
                       } else if (response.status == 'barang masuk tidak sesuai') {
                         swal({
                             title: "Info!",
                             text: "Barang masuk tidak sesuai!",
                             type: "warning",
                             showConfirmButton: true,
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

    function tolak(id, purchase){
      swal({
              title: "Konfirmasi",
              text: "Apakah anda yakin ingin menolak Penerimaan ini?",
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
                    data: {id:id, purchase:purchase},
                    url: baseUrl + '/approvalpenerimaan/tolak',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Penerimaan Ditolak",
                                  text: "Penerimaan Berhasil Ditolak",
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

        if ($('.setCek').is(":checked")) {
            table.$('input[name="purchase[]"]').prop("checked", true);
            //table.$('input[name="pilih[]"]').css('background','red');
            table.$('.chek-all').val('1');
        } else {
            table.$('input[name="purchase[]"]').prop("checked", false);
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
        countmitra = table.$("input[name='purchase[]']:checked").length;
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
        url: baseUrl + '/approvalpenerimaan/setujuilist',
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
              swal({
                  title: "Penerimaan Disetujui",
                  text: "Penerimaan Berhasil Disetujui",
                  type: "success",
                  showConfirmButton: false,
                  timer: 900
              });
              setTimeout(function(){
                    window.location.reload();
            }, 850);
          }
          else if (result.status == 'barang masuk tidak sesuai') {
            swal({
                title: "Info!",
                text: "Barang masuk tidak sesuai!",
                type: "warning",
                showConfirmButton: true,
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
        url: baseUrl + '/approvalpenerimaan/setujui',
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
            swal({
                title: "Penerimaan Ditolak",
                text: "Penerimaan Berhasil Ditolak",
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
