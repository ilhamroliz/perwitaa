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
        <h2>Approval Return Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Return Pembelian</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Daftar Approval Return Pembelian</h5>
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
                                <th>No</th>
                                <th>Supplier</th>
                                <th>Nota Pembelian</th>
                                <th>No Return</th>
                                <th>Tanggal Return</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $index => $x)
                          <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                            <td>
                                <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$x->rs_id}}">
                            </td>
                            <td>{{$index + 1}}</td>
                            <td>{{$x->s_company}}</td>
                            <td>{{$x->p_nota}}</td>
                            <td>{{$x->rs_nota}}</td>
                            <td>{{Carbon\Carbon::parse($x->rs_date)->format('d/m/Y h:i:s')}}</td>
                            <td class="text-center">
                              <button type="button" title="Detail" onclick="detail('{{$x->rs_id}}')" id="detailbtn" class="btn btn-info btn-sm" name="button"> <i class="glyphicon glyphicon-folder-open"></i> </button>
                              <button type="button" title="Setujui" onclick="setujui({{$x->rs_id}})" class="btn btn-primary btn-sm" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                              <button type="button" title="Tolak" onclick="tolak({{$x->rs_id}})"  class="btn btn-danger btn-sm" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
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

                      <div id="divuang">
                      <h2>Ganti Uang</h2>
                      <table id="tableuang" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>No Return</th>
                            <th>Item Detail</th>
                            <th>Harga Awal</th>
                            <th>Harga Akhir</th>
                            <th>Qty</th>
                            <th>Keterangan</th>
                          </tr>
                        </thead>
                        <tbody id="showuang">

                        </tbody>
                      </table>
                      </div>

                      <div id="divbarang">
                        <h2>Ganti Barang</h2>
                        <table id="tablebarang" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>No Return</th>
                              <th>Item Detail</th>
                              <th>Harga Awal</th>
                              <th>Harga Akhir</th>
                              <th>Qty</th>
                              <th>Keterangan</th>
                            </tr>
                          </thead>
                          <tbody id="showbarang">

                          </tbody>
                        </table>
                      </div>

                      <div id="divganti">
                        <h2>Barang Pengganti</h2>
                        <table id="tableganti" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>No Ganti Barang</th>
                              <th>Item Detail</th>
                              <th>Qty</th>
                            </tr>
                          </thead>
                          <tbody id="showganti">

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
              text: "Apakah anda yakin ingin menyetujui Return Pembelian ini?",
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
                    url: baseUrl + '/approvalreturnpembelian/setujui',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Return Pembelian Disetujui",
                                  text: "Return Pembelian Berhasil Disetujui",
                                  type: "success",
                                  showConfirmButton: false,
                                  timer: 900
                              });
                              setTimeout(function(){
                                    window.location.reload();
                            }, 850);
                          } else if (response.status == 'tidaksedia') {
                            swal({
                                title: "Return Pembelian Gagal",
                                text: "Return Pembelian Gagal Disetujui",
                                type: "danger",
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
              text: "Apakah anda yakin ingin menolak Return Pembelian ini?",
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
                    url: baseUrl + '/approvalreturnpembelian/tolak',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Return Pembelian Ditolak",
                                  text: "Return Pembelian Berhasil Ditolak",
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
      var uang = '';
      var barang = '';
      var ganti = '';
        $.ajax({
          type: 'get',
          data: {id:id},
          dataType: 'json',
          url: baseUrl + '/manajemen-seragam/return/detail',
          success : function(result){

            if (result.uang.length > 0) {
              for (var i = 0; i < result.uang.length; i++) {
                 uang += '<tr>'
                            +'<td>'+result.uang[i].rs_nota+'</td>'
                            +'<td>'
                            +'<div><strong>'+result.uang[i].k_nama+'</strong></div>'
                            +'<small>'+result.uang[i].i_nama+ ' ' +result.uang[i].i_warna+' ( '+result.uang[i].s_nama+' ) '+'</small>'
                            +'</td>'
                            +'<td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> '+result.uang[i].rsd_hpp+'</span></td>'
                            +'<td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> '+result.uang[i].rsd_value+'</span></td>'
                            +'<td>'+result.uang[i].rsd_qty+'</td>'
                            +'<td>'+result.uang[i].rsd_note+'</td>'
                            +'</tr>';
              }
              $('#showuang').html(uang);
              $('#divuang').show();
            } else {
              $('#divuang').hide();
            }


            if (result.barang.length > 0) {
            for (var i = 0; i < result.barang.length; i++) {
               barang += '<tr>'
                          +'<td>'+result.barang[i].rs_nota+'</td>'
                          +'<td>'
                          +'<div><strong>'+result.barang[i].k_nama+'</strong></div>'
                          +'<small>'+result.barang[i].i_nama+ ' ' +result.barang[i].i_warna+' ( '+result.barang[i].s_nama+' ) '+'</small>'
                          +'</td>'
                          +'<td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> '+result.barang[i].rsd_hpp+'</span></td>'
                          +'<td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> '+result.barang[i].rsd_value+'</span></td>'
                          +'<td>'+result.barang[i].rsd_qty+'</td>'
                          +'<td>'+result.barang[i].rsd_note+'</td>'
                          +'</tr>';
            }
            $('#showbarang').html(barang);
            $('#divbarang').show();
          } else {
            $('#divbarang').hide();
          }

          if (result.barangbaru.length > 0) {
            for (var i = 0; i < result.barangbaru.length; i++) {
               ganti += '<tr>'
                          +'<td>'+result.barangbaru[i].rsg_no+'</td>'
                          +'<td>'
                          +'<div><strong>'+result.barangbaru[i].k_nama+'</strong></div>'
                          +'<small>'+result.barangbaru[i].i_nama+ ' ' +result.barangbaru[i].i_warna+' ( '+result.barangbaru[i].s_nama+' ) '+'</small>'
                          +'</td>'
                          +'<td>'+result.barangbaru[i].rsg_qty+'</td>'
                          +'</tr>';
            }
            $('#showganti').html(ganti);
            $('#divganti').show();
          } else {
            $('#divganti').hide();
          }

            $('.rp').digits();
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
        url: baseUrl + '/approvalreturnpembelian/setujuilist',
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
              swal({
                  title: "Return Pembelian Disetujui",
                  text: "Return Pembelian Berhasil Disetujui",
                  type: "success",
                  showConfirmButton: false,
                  timer: 900
              });
              setTimeout(function(){
                    window.location.reload();
            }, 850);
          } else if (response.status == 'tidaksedia') {
            swal({
                title: "Return Pembelian Gagal",
                text: "Return Pembelian Gagal Disetujui",
                type: "danger",
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
        url: baseUrl + '/approvalreturnpembelian/tolaklist',
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
            swal({
                title: "Return Pembelian Ditolak",
                text: "Return Pembelian Berhasil Ditolak",
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
