@extends('main')

@section('title', 'Rencana Pembelian')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Rencana Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pembelian
            </li>
            <li class="active">
                <strong>Rencana Pembelian</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Rencana Pembelian</h5>
        <a style="float: right; margin-top: -7px;" class="btn btn-primary btn-outline btn-flat btn-sm" type="button" aria-hidden="true" href="{{ url('manajemen-seragam/rencana-pembelian/tambah') }}"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <table id="tabel-pembelian" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>Nota</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Pembuat</th>
                                <th>Status</th>
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
                  <i class="fa fa-folder-open modal-icon"></i>
                  <h4 class="modal-title">Detail</h4>
                  <small class="font-bold">Detail rencana pembelian Perwita Nusaraya</small>
              </div>
              <div class="modal-body">
                  <table class="table table-striped table-bordered" id="tablemodal">
                    <thead>
                      <tr>
                          <th>Nama Barang</th>
                          <th>Qty</th>
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
    var table;
    var tablemodal;
    $(document).ready(function(){
        tablemodal = $("#tablemodal").DataTable({
            responsive: true,
            paging: false,
            "language": dataTableLanguage
        });
        setTimeout(function () {
            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            table = $("#tabel-pembelian").DataTable({
                "search": {
                    "caseInsensitive": true
                },
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ url('manajemen-seragam/rencana-pembelian/getData') }}",
                    "type": "post"
                },
                columns: [
                    {data: 'pp_nota', name: 'pp_nota'},
                    {data: 'pp_date', name: 'pp_date'},
                    {data: 'jumlah', name: 'jumlah'},
                    {data: 'm_name', name: 'm_name'},
                    {data: 'pp_isapproved', name: 'pp_isapproved'},
                    {data: 'aksi', name: 'aksi'}
                ],
                responsive: true,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                //"scrollY": '50vh',
                //"scrollCollapse": true,
                "language": dataTableLanguage,
            });

        }, 1500);
    });

    function detail(id){
        $.ajax({
            url: baseUrl + '/manajemen-seragam/rencana-pembelian/getDetail',
            type: 'post',
            data: {id: id},
            success: function (response) {
                if (response.status == 'berhasil') {
                   var data = response.data;
                   tablemodal.clear();
                   for (var i = 0; i < data.length; i++) {
                       tablemodal.row.add([
                            data[i].nama,
                            data[i].ppd_qty
                        ]).draw(false);
                   }
                }
            },
            error: function (xhr, status) {
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
        })

        $('#myModal').modal('show');
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
                url: baseUrl + '/manajemen-seragam/rencana-pembelian/hapus',
                type: 'get',
                data: {nota: nota},
                success: function (response) {
                    waitingDialog.hide();
                    if (response.status == 'berhasil') {
                       swal("Terhapus!", "Data sudah terhapus.", "success");
                       table.ajax.reload();
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
        location.href = '{{ url('manajemen-seragam/rencana-pembelian/edit') }}'+'?nota='+nota;
    }
</script>
@endsection
