@extends('main')

@section('title', 'Return Pembelian')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    table.dataTable tbody td {
            vertical-align: middle;
        }
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
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Return Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-8">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Nota Pembelian</h2>
                    <p>
                        Lakukan pencarian nomor nota pembelian untuk melanjutkan ke proses return.
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Cari Nota Pembelian" class="input form-control carinota">
                        <span class="input-group-btn">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Cari</button>
                        </span>
                    </div>
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table class="table table-striped table-bordered table-hover" id="table-po">
                            <thead>
                            <tr>
                                <th>Supplier</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tab-content">
                        <div id="contact-1" class="tab-pane active">
                            <div class="pembelian-detail">
                                <strong>Detail Pembelian</strong>

                                <ul class="list-group clear-list detail-pembelian">
                                </ul>
                                <div class="lakukan">

                                </div>
                            </div>
                        </div>
                    </div>
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
                <button onclick="simpan()" class="btn btn-primary btn-outline" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $("#table-po").DataTable({
            responsive: true,
            paging: false,
            searching: false,
            "language": dataTableLanguage
        });
    });

    $( ".carinota" ).autocomplete({
        source: baseUrl+'/manajemen-seragam/return/getnota',
        minLength: 2,
        select: function(event, ui) {
            getData(ui.item.id);
        }
    });

    function getData(id){
        waitingDialog.show();
        $.ajax({
            url: baseUrl + '/manajemen-seragam/return/getdata',
            type: 'get',
            data: {id: id},
            success: function(response){
                var total = accounting.formatMoney(response[0].p_total_net, "", 0, ".", ",");
                table.clear();
                table.row.add([
                    response[0].s_company,
                    response[0].p_date,
                    '<span style="float: left;">Rp. </span><span style="float: right;">'+total+'</span>'
                    ]).draw( false );
                $('.namasupplier').html(response[0].s_company);
                var detail = '';
                for (var i = 0; i < response.length; i++) {
                    detail = detail + '<li class="list-group-item fist-item"><span class="pull-right">Rp. '+accounting.formatMoney(response[i].pd_value, "", 0, ".", ",")+'</span>'+response[i].nama+'</li>';
                }
                $('.detail-pembelian').html(detail);
                var tombol = '<button type="button" onclick="lakukan(\''+response[0].p_nota+'\')" class="btn btn-primary btn-sm btn-block"><i class="fa fa-share-square-o"></i> Lakukan Return</button>';
                $('.lakukan').html(tombol);
                waitingDialog.hide();
            }, error:function(x, e) {
                if (x.status == 0) {
                    alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                } else if (x.status == 404) {
                    alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                } else if (x.status == 500) {
                    alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                } else if (e == 'parsererror') {
                    alert('Error.\nParsing JSON Request failed.');
                } else if (e == 'timeout'){
                    alert('Request Time out. Harap coba lagi nanti');
                } else {
                    alert('Unknow Error.\n' + x.responseText);
                }
                waitingDialog.hide();
            }
        });
    }

    function lakukan(nota){
        window.location = baseUrl + '/manajemen-seragam/return/add?nota='+nota;
    }

</script>
@endsection
