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

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-truck modal-icon"></i>
                <h4 class="modal-title">Tambah Data Supplier</h4>
                <small class="font-bold">Data supplier ini digunakan untuk pembelian barang di fitur Pembelian</small>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" class="btn btn-primary" type="button">Simpan</button>
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
              {data: 'status', name: 'status', orderable: false, searchable: false}
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
})
</script>
@endsection
