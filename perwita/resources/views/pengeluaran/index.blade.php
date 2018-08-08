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
        <h2>Pengeluaran Seragam ke Pekerja Mitra</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Pengeluaran
            </li>
            <li class="active">
                <strong>Pengeluaran Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Pengeluaran Barang</h5>
        <a style="float: right; margin-top: -7px;" class="btn btn-primary btn-flat btn-sm" type="button" aria-hidden="true" href="{{ url('manajemen-seragam/tambah-pengeluaran') }}"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <table id="tabel-pembelian" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Mitra</th>
                                <th>Nota</th>
                                <th>Total</th>
                                <th>Status</th>
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

<div class="modal inmodal" id="modaldet" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-shopping-cart modal-icon"></i>
                <h4 class="modal-title">Pengeluaran Seragam</h4>
                <small class="font-bold">Detail Pengeluaran Seragam</small>
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
                <button type="button" class="btn btn-primary" id="printbtn" name="button" onclick="print()"><i class="fa fa-print">&nbsp;</i>Print</button>
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
$(document).ready(function(){
  setTimeout(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      table = $("#tabel-pembelian").DataTable({
          "search": {
              "caseInsensitive": true
          },
          processing: true,
          serverSide: true,
          "ajax": {
              "url": "{{ url('manajemen-seragam/data') }}",
              "type": "POST"
          },
          columns: [
              {data: 'number', name: 'number'},
              {data: 's_date', name: 's_date'},
              {data: 'm_name', name: 'm_name'},
              {data: 's_nota', name: 's_nota'},
              {data: 's_total_net', name: 's_total_net'},
              {data: 'status', name: 'status', orderable: false, searchable: false},
              {data: 'action', name: 'action', orderable: false, searchable: false}
          ],
          responsive: true,
          "pageLength": 10,
          "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
          //"scrollY": '50vh',
          //"scrollCollapse": true,
          "language": dataTableLanguage,
      });
      $('#tabel-pembelian').css('width', '100%').dataTable().fnAdjustColumnSizing();
  }, 1500);
});

function hapus(id){
  $.ajax({
    type: 'get',
    data: {id:id},
    dataType: 'json',
    url: baseUrl + '/manajemen-penjualan/hapus',
    success : function(result){
      console.log(result);
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
    url: baseUrl + '/manajemen-penjualan/detail',
    dataType: 'json',
    success : function(result){
      if (result.length == 1) {
        atas += '<tr>'+
            '<td><div><strong>'+result[0].k_nama+'</strong></div>'+
            '<small>'+result[0].i_nama+' Warna '+result[0].i_warna+ ' Ukuran '+result[0].s_nama+'</small></td>'+
            '<td>'+result[0].sd_qty+'</td>'+
            '<td class="rp">Rp. '+result[0].sd_value+'</td>'+
            '<td class="rp">Rp. '+result[0].sd_disc_value+'</td>'+
            '<td class="rp">Rp. '+result[0].sd_total_net+'</td>'+
        '</tr>';
      } else {
        for (var i = 0; i < result.length; i++) {
          atas += '<tr>'+
              '<td><div><strong>'+result[i].k_nama+'</strong></div>'+
              '<small>'+result[i].i_nama+' Warna '+result[i].i_warna+ ' Ukuran '+result[i].s_nama+'</small></td>'+
              '<td>'+result[i].sd_qty+'</td>'+
              '<td class="rp">Rp. '+result[i].sd_value+'</td>'+
              '<td class="rp">Rp. '+result[i].sd_disc_value+'</td>'+
              '<td class="rp">Rp. '+result[i].sd_total_net+'</td>'+
          '</tr>';
        }
      }
      $('.spin').css('display', 'none');
      $(".bagian").show();
      $('#isi').html(atas);
      $("#subtotal").text('Rp. '+result[0].s_total_gross);
      $("#pajak").text('Rp. '+result[0].s_pajak);
      $("#total").text('Rp. '+result[0].s_total_net);
      $(".rp").digits();

      //Button
      $('#printbtn').attr('onclick','print('+id+')');

    }
  });
}

</script>
@endsection
