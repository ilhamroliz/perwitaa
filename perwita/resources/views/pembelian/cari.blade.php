@extends('main')

@section('title', 'Pembelian Seragam')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }

    ul .list-unstyled{
      background-color: rgb(255, 255, 255);
    }

    li .daftar{
      padding: 4px;
      cursor: pointer;
    }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Cari Pembelian Ke Supplier</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Cari Pembelian Ke Supplier</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Pencarian Pembelian Ke Supplier</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-4">
                    <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="Masukan No Nota" title="Masukkan No Nota">
                </div>
                <div class="form-group row">
                      <div class="col-sm-2">
                        <input type="text" class="form-control startmou date-mou" name="startmou" style="text-transform:uppercase" title="Start"  placeholder="Start">
                      </div>
                      <div class="col-sm-2">
                          <input type="text" class="form-control endmou date-mou" name="endmou" style="text-transform:uppercase" title="End"  placeholder="End">
                      </div>
                      <button type="button" class="btn btn-primary" name="button" style="font-family:sans-serif;" onclick="filter()"><em class="fa fa-search">&nbsp;</em>Cari</button>
                </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Supplier</th>
                              <th>Nota</th>
                              <th>Total</th>
                              <th>Status</th>
                              <th>Keterangan</th>
                              <th style="width:10px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
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
                    <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_scripts')
<script type="text/javascript">

$(document).ready(function(){

    $('#pencarian').autocomplete({
        source: baseUrl + '/manajemen-seragam/getnota',
        select: function(event, ui) {
            getdata(ui.item.id);
            $('[name="startmou"]').val('');
            $('[name="endmou"]').val('');
        }
    });

    table = $("#tabelcari").DataTable({
        "language": dataTableLanguage,
        "columnDefs": [{
            "targets": 0,
            "orderable": false
        }]

    });

    $('.startmou').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
    $('.endmou').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

  });

 function getdata(id){
   waitingDialog.show();
   var html = '<tr><td colspan="7"><center>Tidak ada data</center></td></tr>';
   var status = '';
   var keterangan = '';
   $.ajax({
     type: 'get',
     dataType: 'json',
     data: {id:id},
     url: baseUrl + '/manajemen-seragam/getdata',
     success : function(result){
       if (result.status == 'kosong') {
         html = '<tr><td colspan="7"><center>Tidak ada data</center></td></tr>';
       }
       else {
         if (result.pd_receivetime == null) {
           status += '<td class="text-center"><span class="label label-warning">Belum diterima</span></td>';
         } else {
           status += '<td class="text-center"><span class="label label-success">Sudah diterima</span></td>';
         }

         if (result.p_isapproved == 'P') {
           keterangan += '<td class="text-center"><span class="label label-warning">Belum disetujui</span></td>';
         } else if (result.p_isapproved == 'Y') {
           keterangan += '<td class="text-center"><span class="label label-success">Sudah disetujui</span></td>';
         }

           html = '<tr>'+
                   '<td>'+(1)+'</td>'+
                   '<td>'+result.p_date+'</td>'+
                   '<td>'+result.s_company+'</td>'+
                   '<td>'+result.p_nota+'</td>'+
                   '<td><span style="float: left;">Rp. </span><span style="float: right" id="total_net">'+result.p_total_net+'</span></td>'+
                   status+
                   keterangan+
                   '<td>'+
                   '<button type="button" class="btn btn-info btn-sm" name="button" onclick="detail('+result.p_id+')"> <i class="fa fa-folder"></i> </button>'+
                   '</td>'+
                   '</tr>';
       }
        $("#tbody").html(html);
        $("#total_net").digits();
        waitingDialog.hide();
     }
   });
 }

  function filter(){
    $('#pencarian').val('');
    waitingDialog.show();
    var moustart = $(".startmou").val();
    var mouend = $(".endmou").val();
    var html = '<tr><td colspan="7"><center>Tidak ada data</center></td></tr>';
    var keterangan = [];
    var status = [];

    $.ajax({
      type: 'get',
      data: {moustart:moustart, mouend:mouend},
      url: baseUrl + '/manajemen-seragam/filter',
      dataType: 'json',
      success : function(result){
        var html = '';
        if (result.status == 'kosong') {
          html = '<tr><td colspan="7"><center>Tidak ada data</center></td></tr>';
        } else {
          for (var i = 0; i < result.length; i++) {

            if (result[i].pd_receivetime == null) {
              status[i] += '<td class="text-center"><span class="label label-warning">Belum diterima</span></td>';
            } else {
              status[i] += '<td class="text-center"><span class="label label-success">Sudah diterima</span></td>';
            }

            if (result[i].p_isapproved == 'P') {
              keterangan[i] += '<td class="text-center"><span class="label label-warning">Belum disetujui</span></td>';
            } else if (result[i].p_isapproved == 'Y') {
              keterangan[i] += '<td class="text-center"><span class="label label-success">Sudah disetujui</span></td>';
            }

              html += '<tr>'+
                      '<td>'+(i+1)+'</td>'+
                      '<td>'+result[i].p_date+'</td>'+
                      '<td>'+result[i].s_company+'</td>'+
                      '<td>'+result[i].p_nota+'</td>'+
                      '<td><span style="float: left;">Rp. </span><span style="float: right" class="digits">'+result[i].p_total_net+'</span></td>'+
                      status[i]+
                      keterangan[i]+
                      '<td>'+
                      '<button type="button" class="btn btn-info btn-sm" name="button" onclick="detail('+result[i].p_id+')"> <i class="fa fa-folder"></i> </button>'+
                      '</td>'+
                      '</tr>';
          }
        }

        $("#tbody").html(html);
        $(".digits").digits();
        waitingDialog.hide();
      }
    });
  }

  function detail(id){
    $("#modaldet").modal('show');
    $(".bagian").hide();
    var atas = '';
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/manajemen-seragam/detail',
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
      }
    });
  }
</script>
@endsection
