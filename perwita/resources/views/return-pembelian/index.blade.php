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
        <h2>Return Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Return Pembelian
            </li>
            <li class="active">
                <strong>Return Pembelian</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Return Pembelian</h5>
        <a style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-primary btn-flat btn-sm" type="button" aria-hidden="true" href="{{ url('manajemen-seragam/return/tambah') }}"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <table id="tabelreturn" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
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
                            <tr>
                              <td>{{$index + 1}}</td>
                              <td>{{$x->s_company}}</td>
                              <td>{{$x->p_nota}}</td>
                              <td>{{$x->rs_nota}}</td>
                              <td>{{Carbon\Carbon::parse($x->rs_date)->format('d/m/Y h:i:s')}}</td>
                              <td class="text-center">
                                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail({{$x->rs_id}})"><i class="glyphicon glyphicon-folder-open"></i></button>
                                    <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" onclick="edit({{$x->rs_id}})"><i class="glyphicon glyphicon-edit"></i></button>
                                    <button style="margin-left:5px;" title="Hapus" type="button" class="btn btn-danger btn-xs" onclick="hapus({{$x->rs_id}})"><i class="glyphicon glyphicon-trash"></i></button>
                              </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    var tableuang;
    var tablebarang;
    var gantibarang;
    $(document).ready(function() {
      table = $("#tabelreturn").DataTable({
        "processing": true,
        "deferLoading": 57,
        responsive: true,
        "language": dataTableLanguage
      });
      gantibarang = $("#tableganti").DataTable({
        "processing": true,
        "deferLoading": 57,
        responsive: true,
        "language": dataTableLanguage
      });
      tableuang = $("#tableuang").DataTable({
        "processing": true,
        "deferLoading": 57,
        responsive: true,
        "language": dataTableLanguage
      });
      tablebarang = $("#tablebarang").DataTable({
        "processing": true,
        "deferLoading": 57,
        responsive: true,
        "language": dataTableLanguage
      });
    });

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
                            +'<td>'+result.uang[i].rsd_hpp+'</td>'
                            +'<td>'+result.uang[i].rsd_value+'</td>'
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
                          +'<td>'+result.barang[i].rsd_hpp+'</td>'
                          +'<td>'+result.barang[i].rsd_value+'</td>'
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

            $('#myModal5').modal('show');

          }
        });
    }

</script>
@endsection
