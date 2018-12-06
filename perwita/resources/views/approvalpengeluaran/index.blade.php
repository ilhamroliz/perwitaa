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
    </style>

@endsection

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Approval Pengeluaran</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="active">
                    <strong>Daftar Approval Pengeluaran</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox-title ibox-info">
            <h5>Daftar Approval Pengeluaran Seragam</h5>
        </div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="row m-b-lg">
                    <div class="col-md-12">
                        <center>
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                                    <div class="sk-rect1 tampilkan"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                                <span class="infoLoad"
                                      style="color: #aaa; font-weight: 600;">Menyiapkan Daftar Approval</span>
                            </div>
                        </center>
                        <form class="formapprovalpenjualan" id="formapprovalpenjualan">
                            <table id="tabel-penjualan" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="setCek" onclick="selectall()">
                                    </th>
                                    <th>Tanggal</th>
                                    <th>Mitra</th>
                                    <th>Divisi</th>
                                    <th>Nota</th>
                                    <th>Jumlah Barang</th>
                                    <th>Jumlah Pekerja</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $index => $x)
                                    <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                                        <td>
                                            <input class="pilih-{{$index}}" type="checkbox" name="pilih[]"
                                                   onclick="selectBox({{$index}})" value="{{$x->s_id}}">
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($x->s_date)->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $x->m_name }}</td>
                                        <td>{{ $x->md_name }}</td>
                                        <td>{{ $x->s_nota }}</td>
                                        <td id="barang{{$x->s_id}}">{{ $x->barang }}</td>
                                        <td id="pekerja{{$x->s_id}}">{{ $x->pekerja }}</td>
                                        <td align="center">
                                            <button type="button" title="Detail" onclick="detail({{$x->s_id}})"
                                                    id="detailbtn" class="btn btn-info btn-xs" name="button"><i
                                                        class="glyphicon glyphicon-folder-open"></i></button>
                                            <button type="button" title="Setujui" onclick="setujui({{$x->s_id}})"
                                                    class="btn btn-primary btn-xs" name="button"><i
                                                        class="glyphicon glyphicon-ok"></i></button>
                                            <button type="button" title="Tolak" onclick="tolak({{$x->s_id}})"
                                                    class="btn btn-danger btn-xs" name="button"><i
                                                        class="glyphicon glyphicon-remove"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                        <div class="pull-right">
                            <button type="button" class="btn btn-danger btn-outline" name="button"
                                    onclick="tolaklist()"><i class="glyphicon glyphicon-remove"></i> Tolak Checklist
                            </button>
                            <button type="button" class="btn btn-primary btn-outline" name="button"
                                    onclick="setujuilist()"><i class="glyphicon glyphicon-ok"></i> Setujui Checklist
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal inmodal" id="modaldet" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-shopping-cart modal-icon"></i>
                    <h4 class="modal-title">Penjualan Seragam</h4>
                    <small class="font-bold">Detail Penjualan Seragam</small>
                </div>
                <div class="modal-body">
                    <div class="spiner-example spin">
                        <div class="sk-spinner sk-spinner-wave">
                            <div class="sk-rect1"></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                    </div>
                    <div class="bagian">
                        <div class="table-responsive m-t">
                            <table class="table invoice-table">
                                <thead>
                                <tr>
                                    <th>Item List</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Discount</th>
                                    <th>Total Price</th>
                                </tr>
                                </thead>
                                <tbody id="isi">

                                </tbody>
                            </table>
                        </div>
                        <table class="table invoice-total">
                            <tbody id="foo">
                            <tr>
                                <td><strong>Sub Total :</strong></td>
                                <td class="rp" id="subtotal"></td>
                            </tr>
                            <tr>
                                <td><strong>TAX :</strong></td>
                                <td class="rp" id="pajak"></td>
                            </tr>
                            <tr>
                                <td><strong>TOTAL :</strong></td>
                                <td class="rp" id="total"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="printbtn" name="button" onclick="print()"><i
                                class="fa fa-print">&nbsp;</i>Print
                    </button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var table;
        var totalmitra;
        var countmitra;
        $(document).ready(function () {

            $('#tabel-penjualan').hide();
            myFunction();

            function myFunction() {
                setTimeout(function () {
                    $(".spiner-example").css('display', 'none');
                    table = $("#tabel-penjualan").DataTable({
                        "processing": true,
                        "paging": false,
                        "searching": false,
                        "deferLoading": 57,
                        responsive: true,
                        "language": dataTableLanguage
                    });
                    $('#tabel-penjualan').show();
                }, 1500);
            }

        });

        function setujui(id) {
          var barang = $('#barang'+id).text();
          var pekerja = $('#pekerja'+id).text();


          if (parseInt(barang) != parseInt(pekerja)) {
            swal({
                    title: "Peringatan!",
                    text: "Jumlah Barang Tidak Sama Dengan Jumlah Pekerja",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function () {
                    swal.close();
                    waitingDialog.show();
                    setTimeout(function () {
                        $.ajax({
                            type: 'get',
                            data: {id: id},
                            url: baseUrl + '/approvalpengeluaran/setujui',
                            dataType: 'json',
                            timeout: 10000,
                            success: function (response) {
                                waitingDialog.hide();
                                if (response.status == 'berhasil') {
                                    swal({
                                        title: "Pengeluaran Disetujui",
                                        text: "Pengeluaran Berhasil Disetujui",
                                        type: "success",
                                        showConfirmButton: true,
                                        timer: 900
                                    });
                                    setTimeout(function () {
                                        window.open('approvalpengeluaran/cetak?id='+response.nota);
                                    }, 850);
                                    window.locatin.reload();
                                }
                            }, error: function (x, e) {
                                waitingDialog.hide();
                                var message;
                                if (x.status == 0) {
                                    message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                                } else if (x.status == 404) {
                                    message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                                } else if (x.status == 500) {
                                    message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                                } else if (e == 'parsererror') {
                                    message = 'Error.\nParsing JSON Request failed.';
                                } else if (e == 'timeout') {
                                    message = 'Request Time out. Harap coba lagi nanti';
                                } else {
                                    message = 'Unknow Error.\n' + x.responseText;
                                }
                                waitingDialog.hide();
                                throwLoadError(message);
                                //formReset("store");
                            }
                        })
                    }, 500);

                });
          } else {
            swal({
                    title: "Konfirmasi",
                    text: "Apakah anda yakin ingin menyetujui Pengeluaran ini?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function () {
                    swal.close();
                    waitingDialog.show();
                    setTimeout(function () {
                        $.ajax({
                            type: 'get',
                            data: {id: id},
                            url: baseUrl + '/approvalpengeluaran/setujui',
                            dataType: 'json',
                            timeout: 10000,
                            success: function (response) {
                                waitingDialog.hide();
                                if (response.status == 'berhasil') {
                                    swal({
                                        title: "Pengeluaran Disetujui",
                                        text: "Pengeluaran Berhasil Disetujui",
                                        type: "success",
                                        showConfirmButton: true,
                                        timer: 900
                                    });
                                    setTimeout(function () {
                                        window.open('approvalpengeluaran/cetak?id='+response.nota);
                                    }, 850);
                                    window.location.reload();
                                }
                            }, error: function (x, e) {
                                waitingDialog.hide();
                                var message;
                                if (x.status == 0) {
                                    message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                                } else if (x.status == 404) {
                                    message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                                } else if (x.status == 500) {
                                    message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                                } else if (e == 'parsererror') {
                                    message = 'Error.\nParsing JSON Request failed.';
                                } else if (e == 'timeout') {
                                    message = 'Request Time out. Harap coba lagi nanti';
                                } else {
                                    message = 'Unknow Error.\n' + x.responseText;
                                }
                                waitingDialog.hide();
                                throwLoadError(message);
                                //formReset("store");
                            }
                        })
                    }, 500);

                });
          }
        }

        function tolak(id) {
            swal({
                    title: "Konfirmasi",
                    text: "Apakah anda yakin ingin menolak Pengeluaran ini?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function () {
                    swal.close();
                    $("#modal-detail").modal('hide');
                    waitingDialog.show();
                    setTimeout(function () {
                        $.ajax({
                            type: 'get',
                            data: {id: id},
                            url: baseUrl + '/approvalpengeluaran/tolak',
                            dataType: 'json',
                            timeout: 10000,
                            success: function (response) {
                                waitingDialog.hide();
                                if (response.status == 'berhasil') {
                                    swal({
                                        title: "Pengeluaran Ditolak",
                                        text: "Pengeluaran Berhasil Ditolak",
                                        type: "success",
                                        showConfirmButton: false,
                                        timer: 900
                                    });
                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 850);
                                }
                            }, error: function (x, e) {
                                waitingDialog.hide();
                                var message;
                                if (x.status == 0) {
                                    message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                                } else if (x.status == 404) {
                                    message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                                } else if (x.status == 500) {
                                    message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                                } else if (e == 'parsererror') {
                                    message = 'Error.\nParsing JSON Request failed.';
                                } else if (e == 'timeout') {
                                    message = 'Request Time out. Harap coba lagi nanti';
                                } else {
                                    message = 'Unknow Error.\n' + x.responseText;
                                }
                                waitingDialog.hide();
                                throwLoadError(message);
                                //formReset("store");
                            }
                        })
                    }, 500);

                });
        }

        function detail(id) {
            $("#modaldet").modal('show');
            $(".bagian").hide();
            var atas = '';
            $.ajax({
                type: 'get',
                data: {id: id},
                url: baseUrl + '/approvalpengeluaran/detail',
                dataType: 'json',
                success: function (result) {
                    if (result.length == 1) {
                        atas += '<tr>' +
                            '<td><div><strong>' + result[0].k_nama + '</strong></div>' +
                            '<small>' + result[0].i_nama + ' Warna ' + result[0].i_warna + ' Ukuran ' + result[0].s_nama + '</small></td>' +
                            '<td>' + result[0].sd_qty + '</td>' +
                            '<td class="rp">Rp. ' + result[0].sd_value + '</td>' +
                            '<td class="rp">Rp. ' + result[0].sd_disc_value + '</td>' +
                            '<td class="rp">Rp. ' + result[0].sd_total_net + '</td>' +
                            '</tr>';
                    } else {
                        for (var i = 0; i < result.length; i++) {
                            atas += '<tr>' +
                                '<td><div><strong>' + result[i].k_nama + '</strong></div>' +
                                '<small>' + result[i].i_nama + ' Warna ' + result[i].i_warna + ' Ukuran ' + result[i].s_nama + '</small></td>' +
                                '<td>' + result[i].sd_qty + '</td>' +
                                '<td class="rp">Rp. ' + result[i].sd_value + '</td>' +
                                '<td class="rp">Rp. ' + result[i].sd_disc_value + '</td>' +
                                '<td class="rp">Rp. ' + result[i].sd_total_net + '</td>' +
                                '</tr>';
                        }
                    }
                    $('.spin').css('display', 'none');
                    $(".bagian").show();
                    $('#isi').html(atas);
                    $("#subtotal").text('Rp. ' + result[0].s_total_gross);
                    $("#pajak").text('Rp. ' + result[0].s_pajak);
                    $("#total").text('Rp. ' + result[0].s_total_net);
                    $(".rp").digits();

                    //Button
                    $('#printbtn').attr('onclick', 'print(' + id + ')');

                }
            });
        }

        function selectall() {

            if ($('.setCek').is(":checked")) {
                table.$('input[name="pilih[]"]').prop("checked", true);
                //table.$('input[name="pilih[]"]').css('background','red');
                table.$('.chek-all').val('1');
            } else {
                table.$('input[name="pilih[]"]').prop("checked", false);
                table.$('.chek-all').val('');
            }
            hitung();
            //hitungSelect();
        }

        function selectBox(id) {
            if (table.$('.pilih-' + id).is(":checked")) {
                table.$('.pilih-' + id).prop("checked", false);
                table.$('.chek-' + id).val('1');
            } else {
                table.$('.pilih-' + id).prop("checked", true);
                table.$('.chek-' + id).val('');
            }
            //hitungSelect();
            hitung();
        }

        function hitung() {
            countmitra = table.$("input[name='pilih[]']:checked").length;
            $('#totalPekerja').val(countmitra + totalmitra);
        }

        function hitungSelect() {
            for (i = 0; i <= table.$('tr').length; i++)
                if (table.$('.pilih-' + i).is(":checked")) {
                    table.$('.select-' + i).css('background', '#bbc4d6')
                    //table.$('.select-'+i).css('color','white')
                } else {
                    table.$('.select-' + i).css('background', '')
                }
        }

        function select(id) {
            if (table.$('.pilih-' + id).is(":checked")) {
                table.$('.pilih-' + id).prop("checked", false);
                table.$('.chek-' + id).val('');
            } else {
                table.$('.pilih-' + id).prop("checked", true);
                table.$('.chek-' + id).val('1');
            }
            //hitungSelect();
            hitung();
        }

        function setujuilist() {
            waitingDialog.show();
            setTimeout(function () {
                $.ajax({
                    type: 'get',
                    data: $('#formapprovalpenjualan').serialize(),
                    url: baseUrl + '/approvalpengeluaran/setujuilist',
                    dataType: 'json',
                    success: function (result) {
                        waitingDialog.hide();
                        if (result.status == 'berhasil') {
                            swal({
                                title: "Pengeluaran Disetujui",
                                text: "Pengeluaran Berhasil Disetujui",
                                type: "success",
                                showConfirmButton: true,
                                timer: 900
                            });
                            for (var i = 0; i < result.nota.length; i++) {
                              var nota = result.nota[i].s_nota;
                              setTimeout(function () {
                                  window.open('approvalpengeluaran/cetak?id='+nota);
                              }, 850);
                            }
                            window.location.reload();
                        }
                    }, error: function (x, e) {
                        waitingDialog.hide();
                        var message;
                        if (x.status == 0) {
                            message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                        } else if (x.status == 404) {
                            message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                        } else if (x.status == 500) {
                            message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                        } else if (e == 'parsererror') {
                            message = 'Error.\nParsing JSON Request failed.';
                        } else if (e == 'timeout') {
                            message = 'Request Time out. Harap coba lagi nanti';
                        } else {
                            message = 'Unknow Error.\n' + x.responseText;
                        }
                        waitingDialog.hide();
                        throwLoadError(message);
                        //formReset("store");
                    }
                });
            }, 500);
        }

        function tolaklist() {
            waitingDialog.show();
            setTimeout(function () {
                $.ajax({
                    type: 'get',
                    data: $('#formapprovalpenjualan').serialize(),
                    url: baseUrl + '/approvalpengeluaran/tolaklist',
                    dataType: 'json',
                    success: function (result) {
                        waitingDialog.hide();
                        if (result.status == 'berhasil') {
                            swal({
                                title: "Pengeluaran Ditolak",
                                text: "Pengeluaran Berhasil Ditolak",
                                type: "success",
                                showConfirmButton: false,
                                timer: 900
                            });
                            setTimeout(function () {
                                window.location.reload();
                            }, 850);
                        }
                    }, error: function (x, e) {
                        waitingDialog.hide();
                        var message;
                        if (x.status == 0) {
                            message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                        } else if (x.status == 404) {
                            message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                        } else if (x.status == 500) {
                            message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                        } else if (e == 'parsererror') {
                            message = 'Error.\nParsing JSON Request failed.';
                        } else if (e == 'timeout') {
                            message = 'Request Time out. Harap coba lagi nanti';
                        } else {
                            message = 'Unknow Error.\n' + x.responseText;
                        }
                        waitingDialog.hide();
                        throwLoadError(message);
                        //formReset("store");
                    }
                });
            }, 500);
        }

    </script>
@endsection
