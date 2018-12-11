@extends('main')

@section('title', 'Stock Opname')

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
            <li>
                Opname Stock
            </li>
            <li class="active">
                <strong>Tambah Opname Stock</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Tambah Opname Stock</h5>
        <a href="{{ url('manajemen-stock/stock-opname/history') }}" style="float: right; margin-top: -7px;" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-history"></i>&nbsp;History</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <form class="form-horizontal" id="formopname">
                        <div class="form-group col-lg-12">
                            <div class="col-lg-8">
                                <input type="text" placeholder="Masukan Nama Barang" class="form-control" id="namabarang">
                            </div>
                        </div>
                        <div class="col-lg-12" style="margin-top: 20px;">
                            <table class="table table-striped table-bordered table-opname">
                                <thead>
                                    <tr>
                                        <th style="width: 25%">Nama Barang</th>
                                        <th style="width: 15%">Qty Sistem</th>
                                        <th style="width: 15%">Qty Real</th>
                                        <th style="width: 15%">Aksi</th>
                                        <th style="width: 30">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="nama"></td>
                                        <td><input type="text" name="qtysistem" class="form-control qty-stock" value="0" style="width: 100%; text-align: right;" readonly></td>
                                        <td><input type="text" name="qtyreal" class="form-control qty-real" value="0" style="width: 100%; text-align: right;"></td>
                                        <td>
                                            <select class="form-control" name="aksi">
                                                <option value="pilih" selected disabled>-- Pilih Aksi --</option>
                                                <option value="real">Gunakan Qty Real</option>
                                                <option value="sistem">Gunakan Qty Sistem</option>
                                            </select>
                                        </td>
                                        <td class="pemilik"><input type="text" name="keterangan" class="form-control note" value="" style="width: 100%;" placeholder="Keterangan"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary btn-outline pull-right" onclick="simpan()">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;
    var simpanCat = 0;
    $(document).ready(function(){
        table = $(".table-opname").DataTable({
            responsive: true,
            paging: false,
            searching: false,
            "language": dataTableLanguage,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
        $( "#namabarang" ).autocomplete({
            source: baseUrl+'/manajemen-pembelian/getItem',
            minLength: 2,
            select: function(event, ui) {
                $('#namabarang').val(ui.item.label);
                tanam(ui.item);
            }
        });

        $('#namabarang').focus();
    });

    function tanam(item){
        waitingDialog.show();
        simpanCat = 1;
        $.ajax({
            url: baseUrl + '/manajemen-stock/stock-opname/getStock',
            type: 'get',
            data: {id: item.id, detailid: item.detailid},
            dataType: 'json',
            success: function (response) {
                table.clear();
                waitingDialog.hide();
                var data = response[0];
                $('.nama').html(item.label+'<input type="hidden" class="s_id" name="s_id" value="'+data.s_id+'">');
                $('.qty-stock').val(data.s_qty);
                $('.qty-real').focus();
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
        waitingDialog.hide();
    }

    function simpan(){
        if (simpanCat == 0) {
            Command: toastr["warning"]("Data Kosong!!", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        } else {
            waitingDialog.show();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });

            $.ajax({
                url: baseUrl + '/manajemen-stock/stock-opname/simpan',
                type: 'get',
                data: $('#formopname').serialize(),
                success: function (response) {
                    waitingDialog.hide();
                    if (response.status == 'sukses') {
                        swal({
                            title: "Sukses",
                            text: "Data sudah tersimpan",
                            type: "success"
                        }, function () {
                                window.location.reload();
                        });
                    } else {
                        alert('gagal');
                    }
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
    }

</script>
@endsection
