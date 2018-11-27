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
        <h2>Pembagian Seragam</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Pembagian Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Pembagian Seragam</h5>
        <a style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-primary btn-outline btn-flat btn-sm" type="button" aria-hidden="true" href="{{url('/manajemen-seragam/pembagianseragam/tambah')}}"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <table id="tabel-index" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nota</th>
                                <th>Mitra</th>
                                <th>Divisi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
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


@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;

    $( document ).ready(function() {
      table = $("#tabel-index").DataTable({
          "search": {
              "caseInsensitive": true
          },
          processing: true,
          serverSide: true,
          "ajax": {
              "url": "{{ url('manajemen-seragam/pembagianseragam/datatable_data') }}",
              "type": "get"
          },
          columns: [
              {data: 'number', name: 'number'},
              {data: 'sp_no', name: 'sp_no'},
              {data: 'm_name', name: 'm_name'},
              {data: 'md_name', name: 'md_name'},
              {data: 'status', name: 'status'},
              {data: 'sp_date', name: 'sp_date'},
          ],
          responsive: true,
          "pageLength": 10,
          "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
          //"scrollY": '50vh',
          //"scrollCollapse": true,
          "language": dataTableLanguage,
      });
    });

    // function detail(nota){
    //     $.ajax({
    //       url: baseUrl + '/manajemen-pembelian/getDetail',
    //       type: 'get',
    //       data: {nota: nota},
    //       success: function(response){
    //         if (response.status == 'sukses') {
    //             var data = response.data;
    //             tablemodal.clear();
    //             for (var i = 0; i < data.length; i++) {
    //                 var harga = accounting.formatMoney(data[i].pd_value, "", 0, ".", ",");
    //                 var diskon = accounting.formatMoney(data[i].pd_disc_value, "", 0, ".", ",");
    //                 tablemodal.row.add([
    //                     data[i].nama,
    //                     data[i].pd_qty,
    //                     harga,
    //                     diskon,
    //                     accounting.formatMoney(data[i].pd_qty * data[i].pd_value, "", 0, ".", ",")
    //                 ]).draw(false);
    //             }
    //         }
    //         $('#myModal').modal('show');
    //       }, error:function(x, e) {
    //           if (x.status == 0) {
    //               alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
    //           } else if (x.status == 404) {
    //               alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
    //           } else if (x.status == 500) {
    //               alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
    //           } else if (e == 'parsererror') {
    //               alert('Error.\nParsing JSON Request failed.');
    //           } else if (e == 'timeout'){
    //               alert('Request Time out. Harap coba lagi nanti');
    //           } else {
    //               alert('Unknow Error.\n' + x.responseText);
    //           }
    //         }
    //     })
    // }
    //
    // function hapus(nota){
    //     swal({
    //         title: "Apakah anda yakin?",
    //         text: "Data yang dihapus tidak bisa dikembalikan",
    //         type: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#DD6B55",
    //         confirmButtonText: "Ya, Lanjutkan!",
    //         cancelButtonText: "Batalkan",
    //         closeOnConfirm: false
    //     }, function () {
    //         waitingDialog.show();
    //         $.ajax({
    //             url: baseUrl + '/manajemen-pembelian/hapus',
    //             type: 'get',
    //             data: {nota: nota},
    //             success: function (response) {
    //                 waitingDialog.hide();
    //                 if (response.status == 'sukses') {
    //                    swal("Terhapus!", "Data sudah terhapus.", "success");
    //                    location.reload();
    //                 }
    //             },
    //             error: function (xhr, status) {
    //                 waitingDialog.hide();
    //                 if (status == 'timeout') {
    //                     $('.error-load').css('visibility', 'visible');
    //                     $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
    //                 }
    //                 else if (xhr.status == 0) {
    //                     $('.error-load').css('visibility', 'visible');
    //                     $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
    //                 }
    //                 else if (xhr.status == 500) {
    //                     $('.error-load').css('visibility', 'visible');
    //                     $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
    //                 }
    //             }
    //         });
    //     })
    // }
    //
    // function edit(nota){
    //     location.href = '{{ url('manajemen-seragam/edit') }}'+'?nota='+nota;
    // }
</script>
@endsection
