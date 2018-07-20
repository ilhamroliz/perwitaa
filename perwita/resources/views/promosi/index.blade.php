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
        <h2>Promosi & Demosi</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Promosi & Demosi</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Promosi & Demosi</h5>
        <a href="{{ url('manajemen-seragam/cari') }}" style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-search"></i>&nbsp;Cari</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <table id="tabel-pekerja" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>NIK</th>
                                <th>NIK Mitra</th>
                                <th>Mitra</th>
                                <th>Divisi</th>
                                <th>Aksi</th>
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
    var table;
    $(document).ready(function () {
        setTimeout(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            table = $("#tabel-pekerja").DataTable({
                "search": {
                    "caseInsensitive": true
                },
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ url('manajemen-pekerja/promosi-demosi/getData') }}",
                    "type": "POST"
                },
                columns: [
                    {data: 'p_name', name: 'p_name'},
                    {data: 'p_nip', name: 'p_nip'},
                    {data: 'p_sex', name: 'p_sex'},
                    {data: 'p_hp', name: 'p_hp'},
                    {data: 'p_address', name: 'p_address'},
                    {data: 'pm_status', name: 'pm_status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                responsive: true,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                //"scrollY": '50vh',
                //"scrollCollapse": true,
                "language": dataTableLanguage,
            });
            $('#pekerja').css('width', '100%').dataTable().fnAdjustColumnSizing();
        }, 1500);
    });
</script>
@endsection

