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
        <h2>Manajemen Stock</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Stock
            </li>
            <li class="active">
                <strong>Opname Stock</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Opname Stock</h5>
        <a href="{{ url('manajemen-stock/stock-opname/tambah') }}" style="float: right; margin-top: -7px; margin-left: 5px;" class="btn btn-primary btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
        <a href="{{ url('manajemen-stock/stock-opname/history') }}" style="float: right; margin-top: -7px;" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-history"></i>&nbsp;History</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-opname">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index=>$row)
                            <tr>
                                <td>{{ $row->so_nota }}</td>
                                <td>{{ $row->so_date }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>Belum disetujui</td>
                                <td class="text-center">
                                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail('{{ $row->so_nota }}')"><i class="glyphicon glyphicon-folder-open"></i></button>
                                    <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" onclick="edit('{{ $row->so_nota }}')"><i class="glyphicon glyphicon-edit"></i></button>
                                    <button style="margin-left:5px;" title="Hapus" type="button" class="btn btn-danger btn-xs" onclick="hapus('{{ $row->so_nota }}')"><i class="glyphicon glyphicon-trash"></i></button>
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

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $(".table-opname").DataTable({
            responsive: true,
            paging: true,
            "language": dataTableLanguage,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
    });
</script>
@endsection
