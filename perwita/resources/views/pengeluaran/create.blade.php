@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

    <style>
        .popover-navigation [data-role="next"] {
            display: none;
        }

        .popover-navigation [data-role="end"] {
            display: none;
        }

        table.dataTable tbody td {
            vertical-align: middle;
        }

    </style>

@endsection

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Tambah data Pengeluaran Barang</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li>
                    Pengeluaran
                </li>
                <li>
                    Pengeluaran Barang
                </li>
                <li class="active">
                    <strong>Tambah data</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <span class="pull-right">(<strong class="jumlahitem">0</strong>) items</span>
                        <h5>Pengeluaran Barang ke Mitra</h5>
                    </div>

                    <div class="ibox-content">
                        <form role="form" class="row">
                            <div class="form-group col-md-6">
                                <select class="form-control chosen-select-width" name="mitra" style="width:100%"
                                        id="mitra" onchange="getItem()">
                                    <option value="" disabled selected>--Pilih Mitra--</option>
                                    @foreach($mitra as $mitra)
                                        <option value="{{ $mitra->m_id }}"> {{ $mitra->m_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-5 divisi">
                                <select class="form-control chosen-select-width" name="divisi" style="width:100%"
                                        id="divisi" readonly>
                                    <option value=" ">--Pilih Divisi--</option>
                                </select>
                            </div>
                            <div class="form-group col-md-1">
                                <button class="btn btn-info " type="button"><i class="fa fa-search"></i></button>
                            </div>
                            <input type="hidden" name="total" id="total">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Info Pengeluaran</h5>
                    </div>
                    <div class="ibox-content">
                            <span>
                                Total
                            </span>
                        <h2 class="font-bold totalpembelian" align="center">
                            Rp. 0
                        </h2>

                        <hr>

                        <span class="text-muted small">

                            </span>
                        <div class="m-t-sm">
                            <div class="btn-group">
                                <button onclick="simpan()" class="btn btn-primary btn-sm"> Simpan</button>
                                <a href="{{ url('manajemen-seragam/pengeluaran') }}" class="btn btn-white btn-sm">
                                    Batal</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5 class="infosupp">Info Mitra</h5>
                    </div>
                    <div class="ibox-content text-center">
                        <h3 class="telpmitra"></h3>
                        <span class="small">
                                Hubungi Mitra jika diperlukan
                            </span>
                    </div>
                </div>
                <div class="ibox info-stock" style="display: block;">
                    <div class="ibox-title">
                        <h5 class="infosupp">Info Stock Seragam</h5>
                    </div>
                    <div class="ibox-content">
                        <ul class="list-group clear-list m-t" id='showinfo'>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var stock = [];
        var tablepenjualan;
        var nota = '{{ $nota }}';
        $(document).ready(function () {
            tablepenjualan = $("#tabelitem").DataTable({
                responsive: true,
                paging: false,
                "language": dataTableLanguage
            });

            $("#showinfo").hide();
            $("#mitra").chosen();

        });

        function getItem() {
            waitingDialog.show();
            var mitra = $('#mitra').val();
            $.ajax({
                url: baseUrl + '/manajemen-penjualan/getItem',
                type: 'get',
                data: {mitra: mitra},
                success: function (response) {
                    $('.telpmitra').html('<i class="fa fa-phone"></i> ' + response.info.m_phone);
                    var form = '<select class="form-control chosen-select-width" name="seragam" style="width:100%" id="seragam">';
                    form = form + '<option value=" " selected>--Pilih Seragam--</option>';
                    var divisi = '<select class="form-control chosen-select-width" name="divisi" style="width:100%" id="divisi">';
                    divisi = divisi + '<option value=" " selected>--Pilih Divisi--</option>';
                    var data = response.data;
                    for (var i = 0; i < data.length; i++) {
                        form = form + '<option value="' + data[i].i_id + '"> ' + data[i].i_nama + ' (' + data[i].i_warna + ')' + ' </option>';
                    }
                    for (var i = 0; i < response.divisi.length; i++) {
                        divisi += '<option value="' + response.divisi[i].md_id + '">' + response.divisi[i].md_name + '</option>';
                    }
                    $('.divisi').html(divisi);
                    $('.pilihseragam').html(form);
                    waitingDialog.hide();
                }, error: function (x, e) {
                    waitingDialog.hide();
                    if (x.status == 0) {
                        alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                    } else if (x.status == 404) {
                        alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                    } else if (x.status == 500) {
                        alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                    } else if (e == 'parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if (e == 'timeout') {
                        alert('Request Time out. Harap coba lagi nanti');
                    } else {
                        alert('Unknow Error.\n' + x.responseText);
                    }
                }
            })
            waitingDialog.hide();
        }


    </script>
@endsection
