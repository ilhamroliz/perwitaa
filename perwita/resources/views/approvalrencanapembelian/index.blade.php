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
        <h2>Approval Rencana Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Rencana Pembelian</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Daftar Approval Rencana Pembelian</h5>
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
                <form class="formapprovalpembelian" id="formapprovalpembelian">
                    <table id="tabel-pembelian" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>
                                  <input type="checkbox" class="setCek" onclick="selectall()">
                                </th>
                                <th>Nota</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Pembuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $index => $x)
                            <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                                <td>
                                    <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$x->pp_id}}">
                                </td>
                                  <td>{{ $x->pp_nota }}</td>
                                  <td>{{ Carbon\Carbon::parse($x->pp_date)->format('d/m/Y') }}</td>
                                  <td>{{ $x->jumlah }}</td>
                                  <td>{{ $x->m_name }}</td>
                                  <td align="center">
                                  <button type="button" title="Detail" onclick="detail('{{$x->pp_nota}}')" id="detailbtn" class="btn btn-info btn-sm" name="button"> <i class="glyphicon glyphicon-folder-open"></i> </button>
                                  <button type="button" title="Setujui" onclick="setujui({{$x->pp_id}})" class="btn btn-primary btn-sm" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                                  <button type="button" title="Tolak" onclick="tolak({{$x->pp_id}})"  class="btn btn-danger btn-sm" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
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
      <div class="modal-dialog">
          <div class="modal-content animated fadeIn">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <i class="fa fa-folder-open modal-icon"></i>
                  <h4 class="modal-title">Detail</h4>
                  <small class="font-bold">Detail rencana pembelian Perwita Nusaraya</small>
              </div>
              <div class="modal-body">
                  <table class="table table-striped table-bordered" id="tablemodal">
                    <thead>
                      <tr>
                          <th>Nama Barang</th>
                          <th>Qty</th>
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

    $( document ).ready(function() {

    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#tabel-pembelian').hide();
    myFunction();

    function myFunction() {
    setTimeout(function(){
      $(".spiner-example").css('display', 'none');
      table = $("#tabel-pembelian").DataTable({
        "processing": true,
        "paging": false,
        "searching": false,
        "deferLoading": 57,
        responsive: true,
        "language": dataTableLanguage
      });
      $('#tabel-pembelian').show();
    },1500);
      }

      tablemodal = $("#tablemodal").DataTable({
          responsive: true,
          paging: false,
          "language": dataTableLanguage
      });

    });

    function setujui(id){
      swal({
              title: "Konfirmasi",
              text: "Apakah anda yakin ingin menyetujui Rencana Pembelian ini?",
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
                    url: baseUrl + '/approvalrencanapembelian/setujui',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Rencana Pembelian Disetujui",
                                  text: "Rencana Pembelian Berhasil Disetujui",
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
              text: "Apakah anda yakin ingin menolak Rencana Pembelian ini?",
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
                    url: baseUrl + '/approvalrencanapembelian/tolak',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Rencana Pembelian Ditolak",
                                  text: "Rencana Pembelian Berhasil Ditolak",
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

    function detail(id){
        $.ajax({
            url: baseUrl + '/manajemen-seragam/rencana-pembelian/getDetail',
            type: 'post',
            data: {id: id},
            success: function (response) {
                if (response.status == 'berhasil') {
                   var data = response.data;
                   tablemodal.clear();
                   for (var i = 0; i < data.length; i++) {
                       tablemodal.row.add([
                            data[i].nama,
                            data[i].ppd_qty
                        ]).draw(false);
                   }
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
            }
        })

        $('#myModal').modal('show');
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
        data: $('#formapprovalpembelian').serialize(),
        url: baseUrl + '/approvalrencanapembelian/setujuilist',
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
              swal({
                  title: "Rencana Pembelian Disetujui",
                  text: "Rencana Pembelian Berhasil Disetujui",
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
        data: $('#formapprovalpembelian').serialize(),
        url: baseUrl + '/approvalrencanapembelian/tolaklist',
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
            swal({
                title: "Rencana Pembelian Ditolak",
                text: "Rencana Pembelian Berhasil Ditolak",
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

    // function print(id){
    //   window.location.href = baseUrl + '/approvalpembelian/print?id='+id;
    // }

</script>
@endsection
