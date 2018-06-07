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
        <h2>Penerimaan Tenaga Kerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Penerimaan Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Pencarian Data Permintaan Pekerja</h5>
        <button style="float: right; margin-top: -7px;" onclick="tambah()" class="btn btn-primary btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="Masukan No Penerimaan Pekerja / Nama Mitra">
                </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Tanggal Kontrak</th>
                                <th>Kontrak Selesai</th>
                                <th>Nama Mitra</th>
                                <th>Nama Divisi</th>                                           
                                <th>Dibutuhkan</th>            
                                <th>Terpenuhi</th>            
                                <th style="width: 8%;">Aksi</th>            
                            </tr>
                        </thead>
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

        $('#pencarian').autocomplete({
            source: baseUrl+'/manajemen-pekerja-mitra/data-pekerja-mitra/cari/pencarian',
            minLength: 3,
            select: function(event, ui) {
                getData(ui.item.id);
            }
        });

        table = $("#tabelcari").DataTable({
            "language": dataTableLanguage,
            "columnDefs": [{
                "targets": 0,
                "orderable": false
            }]

        });

    });

    function getData(id){
        $.ajax({
            url: baseUrl + '/manajemen-pekerja-mitra/data-pekerja-mitra/cari/getData',
            type: 'get',
            data: {id: id},
            dataType: 'json',
            success: function (response) {
                console.log(response[0]);
                waitingDialog.hide();
                var rowNode = table
                    .row.add( [
                     'response',

                     ] )
                    .draw()
                    .node();
                 
                $( rowNode )
                    .css( 'color', 'red' )
                    .animate( { color: 'black' } );
            },
            error: function (xhr, status) {
                if (xhr.status == 'timeout') {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                }
                else if (xhr.status == 0) {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                }
                else if (xhr.status == 500) {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                }
                waitingDialog.hide();
            }
        });
    }

    function tambah(){
        window.location = baseUrl+'/manajemen-pekerja-mitra/data-pekerja-mitra/tambah';
    }
</script>
@endsection