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
        <h2>Pembagian Seragam</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Pembagian Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Pembagian Seragam</h5>
        <a style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-primary btn-outline btn-flat btn-sm" type="button" aria-hidden="true" href="{{url('/manajemen-seragam/pembagianseragam/tambah')}}"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <table id="tabel-index" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nota</th>
                                <th>Mitra</th>
                                <th>Divisi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
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


@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;

    $( document ).ready(function() {
      table = $("#tabel-index").DataTable({
          "search": {
              "caseInsensitive": true
          },
          processing: true,
          serverSide: true,
          "ajax": {
              "url": "{{ url('manajemen-seragam/pembagianseragam/datatable_data') }}",
              "type": "get"
          },
          columns: [
              {data: 'number', name: 'number'},
              {data: 'sp_no', name: 'sp_no'},
              {data: 'm_name', name: 'm_name'},
              {data: 'md_name', name: 'md_name'},
              {data: 'status', name: 'status'},
              {data: 'sp_date', name: 'sp_date'},
              {data: 'action', name: 'action'},
          ],
          responsive: true,
          "pageLength": 10,
          "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
          //"scrollY": '50vh',
          //"scrollCollapse": true,
          "language": dataTableLanguage,
      });
    });

    function lanjutkan(sales, mitra, divisi){
      window.location.href = baseUrl + '/manajemen-seragam/pembagianseragam/lanjutkan?sales='+sales+'&mitra='+mitra+'&divisi='+divisi;
    }

</script>
@endsection
