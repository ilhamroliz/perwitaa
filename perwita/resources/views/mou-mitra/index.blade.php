@extends('main')

@section('title', 'Mitra MOU')

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
            <h2>Mitra MOU</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li>
                    Manajemen Mitra
                </li>
                <li class="active">
                    <strong>Mitra MOU</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox-title">
            <h5>Data MOU Mitra</h5>
            {{-- <button style="float: right; margin-top: -7px;" onclick="tambah()" class="btn btn-primary btn-outline btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button> --}}
            <a href="{{ url('manajemen-mitra/mitra-mou/cari') }}"
               style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-info btn-flat btn-sm"
               type="button"><i class="fa fa-search"></i>&nbsp;Cari</a>
        </div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="row m-b-lg">
                    <div class="col-md-12">

                    </div>
                    <div class="col-md-12" style="margin: 10px 0px 20px 0px;">
                    </div>
                    <div class="col-md-12" style="margin: 10px 0px 20px 0px;">
                        <table id="mou" class="table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nama Mitra</th>
                                <th>No MOU</th>
                                <th>Mulai</th>
                                <th>Berakhir</th>
                                <th>Sisa</th>
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
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-calendar modal-icon"></i>
                    <h4 class="modal-title">Perpanjang MOU</h4>
                    <small class="font-bold">Memperpanjang MOU mitra perusahaan</small>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>No MOU</label>
                        <input type="text" style="text-transform: uppercase;" placeholder="Masukan Nomor MOU Baru"
                               name="mou" value="" class="form-control mou">
                    </div>
                    <div class="input-daterange input-group col-md-12 isimodal" id="datepicker" style="display: none">
                        <input type="text" class="input-sm form-control awal" name="start" value="05/06/2014"/>
                        <span class="input-group-addon">sampai</span>
                        <input type="text" class="input-sm form-control akhir" name="end" value="05/09/2014"/>
                    </div>
                    <div class="spiner-example spin">
                        <div class="sk-spinner sk-spinner-wave">
                            <div class="sk-rect1"></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="update()">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-folder modal-icon"></i>
                    <h4 class="modal-title">Edit MOU</h4>
                    <small class="font-bold">Mengedit MOU mitra perusahaan</small>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label>No MOU</label>
                        </div>
                        <div class="col">
                            <input type="text" style="text-transform: uppercase;" class="input-sm form-control nomou"
                                   name="nomou" value="">
                        </div>
                        <br>
                        <div class="input-daterange input-group col-md-12" id="datepicker">
                            <input type="text" class="input-sm form-control startedit" name="startedit"
                                   value="05/06/2014"/>
                            <span class="input-group-addon">sampai</span>
                            <input type="text" class="input-sm form-control endedit" name="endedit" value="05/09/2014"/>
                        </div>
                        <div class="spiner-edit spin">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="update" idmitra="" detailid=""
                            onclick="updateedit()">Update
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="myModalHistory" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-folder modal-icon"></i>
                    <h4 class="modal-title">History MOU</h4>
                    <small class="font-bold">History MOU yang pernah dilakukan</small>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <table class="table table-bordered" id="table-history">
                          <thead>
                            <tr>
                              <th>No MOU</th>
                              <th>Mulai</th>
                              <th>Selesai</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                        </table>
                    </div>
                </div>
                <br>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var table;
        var idPublic;
        var detailPublic;
        var mouPublic;
        var tableHistory;
        $(document).ready(function () {
            setTimeout(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                table = $("#mou").DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": "{{ url('manajemen-mitra/mitra-mou/table') }}",
                        "type": "get"
                    },
                    dataType: 'json',
                    columns: [
                        {data: 'm_name', name: 'm_name'},
                        {data: 'mm_mou', name: 'mm_mou'},
                        {data: 'mm_mou_start', name: 'mm_mou_start'},
                        {data: 'mm_mou_end', name: 'mm_mou_end'},
                        {data: 'sisa', name: 'sisa'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage,
                });
            }, 1500);
        });

        function perpanjang(id, detail, mou) {
            idPublic = id;
            detailPublic = detail;
            mouPublic = mou;
            $.ajax({
                url: baseUrl + '/manajemen-mitra/mitra-mou/get-tgl-mou',
                type: 'get',
                data: {id: id, detail: detail},
                success: function (response) {
                    var awal = response[0].mm_mou_start;
                    var akhir = response[0].mm_mou_end;
                    $('.awal').val(awal);
                    $('.akhir').val(akhir);
                    $('.mou').val(mouPublic);
                    $('.spin').css('display', 'none');
                    $('.isimodal').show();
                    $('.input-daterange').datepicker({
                        keyboardNavigation: false,
                        forceParse: false,
                        autoclose: true,
                        format: 'dd/mm/yyyy'
                    });
                }, error: function (x, e) {
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
            });
        }

        function update() {
            waitingDialog.show();
            var awal = $('.awal').val();
            var akhir = $('.akhir').val();
            var mouUpdate = $('.mou').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/manajemen-mitra/mitra-mou/update-mou',
                type: 'get',
                data: {id: idPublic, detail: detailPublic, awal: awal, akhir: akhir, mou: mouUpdate},
                success: function (response) {
                    waitingDialog.hide();
                    if (response.status == 'berhasil') {
                        swal({
                            title: "Sukses",
                            text: "Data sudah tersimpan",
                            type: "success"
                        }, function () {
                            table.ajax.reload();
                            $('#myModal').modal('hide');
                        });
                    }
                    waitingDialog.hide();
                }, error: function (x, e) {
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
            });
        }

        function edit(id) {
            $("#modal-edit").modal('show');
            $('.input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: 'dd/mm/yyyy'
            });
            $("#dataedit").hide();

            $.ajax({
                type: 'get',
                data: {id: id},
                url: baseUrl + '/manajemen-mitra/mitra-mou/edit',
                dataType: 'json',
                success: function (result) {

                    $('.nomou').val(result.mm_mou);
                    $('.startedit').val(result.mm_mou_start);
                    $('.endedit').val(result.mm_mou_end);
                    $('#update').attr('idmitra', result.mm_mitra);
                    $('#update').attr('detailid', result.mm_detailid);

                    $(".spin").css('display', 'none');
                    $("#dataedit").show();
                    $('.input-daterange').datepicker({
                        keyboardNavigation: false,
                        forceParse: false,
                        autoclose: true,
                        format: 'dd/mm/yyyy'
                    });
                }, error: function (x, e) {
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
            });
        }

        function updateedit() {
            waitingDialog.show();
            var mitra = $('#update').attr('idmitra');
            var detail = $('#update').attr('detailid');
            var nomou = $('.nomou').val();
            var startmou = $('.startedit').val();
            var endmou = $('.endedit').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                data: {mitra: mitra, detail: detail, nomou: nomou, startmou: startmou, endmou: endmou},
                url: baseUrl + '/manajemen-mitra/mitra-mou/updateedit',
                dataType: 'json',
                success: function (result) {
                    waitingDialog.hide();
                    if (result.status == 'berhasil') {
                        swal({
                            title: "Sukses",
                            text: "Data sudah tersimpan",
                            type: "success"
                        }, function () {
                            $('#modal-edit').modal('hide');
                            table.ajax.reload();
                        });
                    }
                }, error: function (x, e) {
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
            });
        }

        function hapus(id) {
            swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin ingin menghapus data MOU?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                swal.close();
                waitingDialog.show();
                $.ajax({
                    type: 'get',
                    data: {id: id},
                    url: baseUrl + '/manajemen-mitra/mitra-mou/hapus',
                    dataType: 'json',
                    success: function (result) {
                        waitingDialog.hide();
                        if (result.status == 'berhasil') {
                            swal({
                                title: "Sukses",
                                text: "Data berhasil dihapus",
                                type: "success"
                            }, function () {
                                table.ajax.reload();
                            });
                        }
                        else if (resul.status == 'gagal') {
                            swal({
                                title: "Gagal",
                                text: "Data gagal dihapus",
                                type: "success"
                            });
                        }
                    }
                });
            });
        }

        function tambah() {
            location.href = "{{ url('manajemen-mitra/mitra-mou/tambah') }}";
        }

        function history(id, detailid){
          var id = id;
          var detailid = detailid;
          if ( $.fn.DataTable.isDataTable( '#table-history' ) ) {
            tableHistory.destroy();
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          tableHistory = $("#table-history").DataTable({
              processing: true,
              serverSide: true,
              "ajax": {
                  "url": "{{ url('manajemen-mitra/mitra-mou/get-mou') }}",
                  "type": "get",
                  "data": {id: id, detail: detailid}
              },
              dataType: 'json',
              columns: [
                  {data: 'mm_mou', name: 'mm_mou'},
                  {data: 'mm_mou_start', name: 'mm_mou_start'},
                  {data: 'mm_mou_end', name: 'mm_mou_end'},
                  {data: 'mm_status', name: 'mm_status'}
              ],
              responsive: true,
              "pageLength": 10,
              "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
              "language": dataTableLanguage,
          });
        }

    </script>
@endsection
