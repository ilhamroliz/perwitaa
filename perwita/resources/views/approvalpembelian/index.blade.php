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
        <h2>Approval Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Pembelian</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Daftar Approval Pembelian Seragam</h5>
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
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>Nota</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $index => $x)
                          <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                              <td>
                                  <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$x->p_id}}">
                              </td>
                                <td>{{ Carbon\Carbon::parse($x->p_date)->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $x->s_company }}</td>
                                <td>{{ $x->p_nota }}</td>
                                <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format($x->p_total_net, 0, ',', '.') }}</span></td>                              
                                <td align="center">
                                <button type="button" title="Detail" onclick="detail({{$x->p_id}})" id="detailbtn" class="btn btn-info btn-sm" name="button"> <i class="glyphicon glyphicon-folder-open"></i> </button>
                                <button type="button" title="Setujui" onclick="setujui({{$x->p_id}})" class="btn btn-primary btn-sm" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                                <button type="button" title="Tolak" onclick="tolak({{$x->p_id}})"  class="btn btn-danger btn-sm" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
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

<div class="modal inmodal" id="modaldet" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-shopping-cart modal-icon"></i>
                <h4 class="modal-title">Pembelian Seragam</h4>
                <small class="font-bold">Detail Pembelian Seragam</small>
            </div>
            <div class="modal-body">
                <div class="spiner-example spin">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
                <div class="bagian">
                <div class="table-responsive m-t">
                            <table class="table invoice-table">
                                <thead>
                                <tr>
                                    <th>Item List</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Discount</th>
                                    <th>Total Price</th>
                                </tr>
                                </thead>
                                <tbody id="isi">

                                </tbody>
                            </table>
                        </div>
                        <table class="table invoice-total">
                            <tbody id="foo">
                              <tr>
                                  <td><strong>Sub Total :</strong></td>
                                  <td class="rp" id="subtotal"></td>
                              </tr>
                              <tr>
                                  <td><strong>TAX :</strong></td>
                                  <td class="rp" id="pajak"></td>
                              </tr>
                              <tr>
                                  <td><strong>TOTAL :</strong></td>
                                  <td class="rp" id="total"></td>
                              </tr>
                            </tbody>
                        </table>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="printbtn" name="button" onclick="cetak()"><i class="fa fa-print">&nbsp;</i>Print</button>
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;
    $( document ).ready(function() {

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

    });

    function setujui(id){
      swal({
              title: "Konfirmasi",
              text: "Apakah anda yakin ingin menyetujui Pembelian ini?",
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
                    url: baseUrl + '/approvalpembelian/setujui',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Pembelian Disetujui",
                                  text: "Pembelian Berhasil Disetujui",
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
              text: "Apakah anda yakin ingin menolak Pembelian ini?",
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
                    url: baseUrl + '/approvalpembelian/tolak',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Pembelian Ditolak",
                                  text: "Pembelian Berhasil Ditolak",
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
      $("#modaldet").modal('show');
      $(".bagian").hide();
      var atas = '';
      $.ajax({
        type: 'get',
        data: {id:id},
        url: baseUrl + '/approvalpembelian/detail',
        dataType: 'json',
        success : function(result){
          if (result.count == 1) {
            atas += '<tr>'+
                '<td><div><strong>'+result[0][0].k_nama+'</strong></div>'+
                '<small>'+result[0][0].i_nama+' Warna '+result[0][0].i_warna+ ' Ukuran '+result[0][0].s_nama+'</small></td>'+
                '<td>'+result[0][0].pd_qty+'</td>'+
                '<td class="rp">Rp. '+result[0][0].pd_value+'</td>'+
                '<td class="rp">Rp. '+result[0][0].pd_disc_value+'</td>'+
                '<td class="rp">Rp. '+result[0][0].pd_total_net+'</td>'+
            '</tr>';
          } else {
            for (var i = 0; i < result.count; i++) {
              atas += '<tr>'+
                  '<td><div><strong>'+result[0][i].k_nama+'</strong></div>'+
                  '<small>'+result[0][i].i_nama+' Warna '+result[0][i].i_warna+ ' Ukuran '+result[0][i].s_nama+'</small></td>'+
                  '<td>'+result[0][i].pd_qty+'</td>'+
                  '<td class="rp">Rp. '+result[0][i].pd_value+'</td>'+
                  '<td class="rp">Rp. '+result[0][i].pd_disc_value+'</td>'+
                  '<td class="rp">Rp. '+result[0][i].pd_total_net+'</td>'+
              '</tr>';
            }
          }
          $('.spin').css('display', 'none');
          $(".bagian").show();
          $('#isi').html(atas);
          $("#subtotal").text('Rp. '+result[0][0].p_total_gross);
          $("#pajak").text('Rp. '+result[0][0].p_pajak);
          $("#total").text('Rp. '+result[0][0].p_total_net);
          $(".rp").digits();

          //Button
          $('#printbtn').attr('onclick','cetak('+id+')');

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
        data: $('#formapprovalpembelian').serialize(),
        url: baseUrl + '/approvalpembelian/setujuilist',
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
              swal({
                  title: "Pembelian Disetujui",
                  text: "Pembelian Berhasil Disetujui",
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
        url: baseUrl + '/approvalpembelian/tolaklist',
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
            swal({
                title: "Pembelian Ditolak",
                text: "Pembelian Berhasil Ditolak",
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

    function cetak(id){
      window.location.href = baseUrl + '/approvalpembelian/print?id='+id;
    }

</script>
@endsection
