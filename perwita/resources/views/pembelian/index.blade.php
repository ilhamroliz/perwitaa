@extends('main')

@section('title', 'Pembelian Seragam')

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
        <a style="float: right; margin-top: -7px; " class="btn btn-primary btn-flat btn-sm" type="button" aria-hidden="true" href="{{ url('manajemen-seragam/gunakan-rencana-pembelian') }}"><i class="fa fa-plus"></i>&nbsp;Gunakan Rencana Pembelian</a>
        <a style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-primary btn-outline btn-flat btn-sm" type="button" aria-hidden="true" href="{{ url('manajemen-seragam/tambah') }}"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
        <a href="{{ url('manajemen-seragam/pembelian/cari') }}" style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-search"></i>&nbsp;Cari</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <table id="tabel-pembelian" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>Nota</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index=>$row)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($row->p_date)->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $row->s_company }}</td>
                                <td>{{ $row->p_nota }}</td>
                                <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format($row->p_total_net, 0, ',', '.') }}</span></td>

                                @if($row->pd_receivetime == null)
                                <td class="text-center"><span class="label label-warning">Belum diterima</span></td>
                                @else
                                <td class="text-center"><span class="label label-success">Sudah diterima</span></td>
                                @endif

                                @if($row->p_isapproved == 'P')
                                <td class="text-center">
                                    <span class="label label-warning">Belum disetujui</span>
                                </td>
                                @elseif($row->p_isapproved == 'Y')
                                <td class="text-center">
                                    <span class="label label-primary">Sudah disetujui</span>
                                </td>
                                @endif

                                @if($row->p_isapproved == 'P')
                                <td class="text-center">
                                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail('{{ $row->p_nota }}')"><i class="glyphicon glyphicon-folder-open"></i></button>
                                    <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" onclick="edit('{{ $row->p_nota }}')"><i class="glyphicon glyphicon-edit"></i></button>
                                    <button style="margin-left:5px;" title="Hapus" type="button" class="btn btn-danger btn-xs" onclick="hapus('{{ $row->p_nota }}')"><i class="glyphicon glyphicon-trash"></i></button>
                                </td>
                                @elseif($row->p_isapproved == 'Y')
                                <td class="text-center">
                                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail('{{ $row->p_nota }}')"><i class="glyphicon glyphicon-folder-open"></i></button>
                                </td>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-folder-open modal-icon"></i>
                <h4 class="modal-title">Detail Pembelian</h4>
                <small class="font-bold">Detail barang pembelian ke supplier</small>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="table-modal">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var tablepembelian;
    var tablemodal;
    $( document ).ready(function() {
        tablepembelian = $("#tabel-pembelian").DataTable({
            responsive: true,
            "language": dataTableLanguage,
            "columnDefs": [
                { "orderable": false, "targets": 6 }
            ]
        });
        tablemodal = $("#table-modal").DataTable({
            responsive: true,
            paging: false,
            "language": dataTableLanguage
        });
    });

    function detail(nota){
        $.ajax({
          url: baseUrl + '/manajemen-pembelian/getDetail',
          type: 'get',
          data: {nota: nota},
          success: function(response){
            if (response.status == 'sukses') {
                var data = response.data;
                tablemodal.clear();
                for (var i = 0; i < data.length; i++) {
                    var harga = accounting.formatMoney(data[i].pd_value, "", 0, ".", ",");
                    var diskon = accounting.formatMoney(data[i].pd_disc_value, "", 0, ".", ",");
                    tablemodal.row.add([
                        data[i].nama,
                        data[i].pd_qty,
                        harga,
                        diskon,
                        accounting.formatMoney(data[i].pd_qty * data[i].pd_value, "", 0, ".", ",")
                    ]).draw(false);
                }
            }
            $('#myModal').modal('show');
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
            }
        })
    }

    function hapus(nota){
        swal({
            title: "Apakah anda yakin?",
            text: "Data yang dihapus tidak bisa dikembalikan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Lanjutkan!",
            cancelButtonText: "Batalkan",
            closeOnConfirm: false
        }, function () {
            waitingDialog.show();
            $.ajax({
                url: baseUrl + '/manajemen-pembelian/hapus',
                type: 'get',
                data: {nota: nota},
                success: function (response) {
                    waitingDialog.hide();
                    if (response.status == 'sukses') {
                       swal("Terhapus!", "Data sudah terhapus.", "success");
                       location.reload();
                    }
                },
                error: function (xhr, status) {
                    waitingDialog.hide();
                    if (status == 'timeout') {
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
                }
            });
        })
    }

    function edit(nota){
        location.href = '{{ url('manajemen-seragam/edit') }}'+'?nota='+nota;
    }
</script>
@endsection
