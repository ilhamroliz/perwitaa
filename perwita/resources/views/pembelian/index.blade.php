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
        <h2>Pembelian ke Supplier</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Pembelian Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Pembelian</h5>
        <a style="float: right; margin-top: -7px;" class="btn btn-primary btn-flat btn-sm" type="button" aria-hidden="true" href="{{ url('manajemen-seragam/tambah') }}"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
        <a href="{{ url('manajemen-seragam/cari') }}" style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-search"></i>&nbsp;Cari</a>
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
                                <th>Supplier</th>
                                <th>Nota</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index=>$row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ Carbon\Carbon::parse($row->p_date)->format('d/M/Y H:i:s') }}</td>
                                <td>{{ $row->s_company }}</td>
                                <td>{{ $row->p_nota }}</td>
                                <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format($row->p_total_net, 0, ',', '.') }}</span></td>
                                @if($row->pd_receivetime == null)
                                <td class="text-center"><span class="label label-warning">Belum diterima</span></td>
                                @else
                                <td class="text-center"><span class="label label-success">Sudah diterima</span></td>
                                @endif
                                @if($row->p_isapproved == 'P')
                                <td class="text-center"><span class="label label-warning">Belum disetujui</span></td>
                                @elseif($row->p_isapproved == 'Y')
                                <td class="text-center"><span class="label label-success">Sudah disetujui</span></td>
                                @endif
                            </tr>
                            @endforeach
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
    var tablepembelian;
    $( document ).ready(function() {
        tablepembelian = $("#tabel-pembelian").DataTable({
            responsive: true,
            "language": dataTableLanguage
        });
    });
</script>
@endsection
