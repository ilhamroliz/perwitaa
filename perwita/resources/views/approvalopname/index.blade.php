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
        <h2>Approval Opname</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Opname</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Daftar Approval Opname</h5>
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
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $index => $row)
                          <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                            <td>
                                <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$row->so_nota}}">
                            </td>
                            <td>{{ $row->so_nota }}</td>
                            <td>{{ $row->so_date }}</td>
                            <td>{{ $row->nama }}</td>
                            <td class="text-center">
                              <button type="button" title="Detail" onclick="detail('{{$row->so_nota}}')" id="detailbtn" class="btn btn-info btn-sm" name="button"> <i class="glyphicon glyphicon-folder-open"></i> </button>
                              <button type="button" title="Setujui" onclick="setujui('{{$row->so_nota}}')" class="btn btn-primary btn-sm" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                              <button type="button" title="Tolak" onclick="tolak('{{$row->so_nota}}')"  class="btn btn-danger btn-sm" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
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

<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Detail Return Pembelian</h4>
                        <small class="font-bold">Daftar Detail Return Pembelian</small>
                    </div>
                    <div class="modal-body">

                      <table id="tableuang" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                            <th>QTY Sistem</th>
                            <th>QTY Real</th>
                            <th>Aksi</th>
                            <th>Keterangan</th>
                          </tr>
                        </thead>
                        <tbody id="showuang">

                        </tbody>
                      </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
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

      tablemodal = $("#tableuang").DataTable({
          responsive: true,
          paging: false,
          "language": dataTableLanguage
      });

    });

    function setujui(nota){
      swal({
              title: "Konfirmasi",
              text: "Apakah anda yakin ingin menyetujui Opname ini?",
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
                    data: {nota:nota},
                    url: baseUrl + '/approvalopname/setujui',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'sukses') {
                              swal({
                                  title: "Opname Disetujui",
                                  text: "Opname Berhasil Disetujui",
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
              text: "Apakah anda yakin ingin menolak Opname ini?",
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
                    url: baseUrl + '/approvalopname/tolak',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Opname Ditolak",
                                  text: "Opname Berhasil Ditolak",
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
      var html = '';
        $.ajax({
          type: 'get',
          data: {id:id},
          dataType: 'json',
          url: baseUrl + '/approvalopname/detail',
          success : function(result){

            for (var i = 0; i < result.length; i++) {
              html += '<tr>'
                      +'<td>'+result[i].so_nota+'</td>'
                      +'<td>'+result[i].so_date+'</td>'
                      +'<td>'+result[i].nama+'</td>'
                      +'<td>'+result[i].sod_qty_sistem+'</td>'
                      +'<td>'+result[i].sod_qty_real+'</td>'
                      +'<td>'+result[i].sod_aksi+'</td>'
                      +'<td>'+result[i].sod_keterangan+'</td>'
                      '</tr>';
            }

            $('#showuang').html(html);

            $('#myModal5').modal('show');

          }
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
        url: baseUrl + '/approvalopname/setujuilist',
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'sukses') {
              swal({
                  title: "Opname Disetujui",
                  text: "Opname Berhasil Disetujui",
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
        url: baseUrl + '/approvalopname/tolaklist',
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
            swal({
                title: "Opname Ditolak",
                text: "Opname Berhasil Ditolak",
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
