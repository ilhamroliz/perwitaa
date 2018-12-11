@extends('main')

@section('title', 'Promosi & Demosi')

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
        <a href="{{ url('manajemen-pekerja/promosi-demosi/cari') }}" style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-search"></i>&nbsp;Cari</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <table id="tabel-pekerja" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jabatan Lama</th>
                                <th>Jabatan Sekarang</th>
                                <th>NIK</th>
                                <th>NIK Mitra</th>
                                <th>Mitra</th>
                                <th>Divisi</th>
                                <th width="120px">Aksi</th>
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
                <div class="simbol-modal"><i class="fa fa-arrow-circle-down modal-icon"></i></div>
                <h4 class="modal-title">Resign</h4>
                <small class="font-bold sub-tittle"></small>
            </div>
            <div class="modal-body">
                <div class="spiner-example" style="display: none;">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
                <div class="text-center konten-nama" style="">
                    <h3 class="m-b-xs"><strong class="modal-nama">John Smith</strong></h3>
                    <div class="font-bold modal-jabatan">Graphics designer</div>
                </div>
                <form class="form-horizontal form-modal" style="margin-top: 10px;">
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Jabatan Sekarang</label>
                        <div class="col-lg-8">
                            <select class="form-control jabatan" name="jabatanBaru">
                                <option selected disabled>-- Pilih Jabatan --</option>
                                @foreach($jabatan as $jabatan)
                                <option value="{{ $jabatan->jp_id }}">{{ $jabatan->jp_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="jenis" class="jenis" value="">
                    <input type="hidden" name="pekerja" class="id_pekerja" value="">
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Keterangan</label>
                        <div class="col-lg-8">
                            <textarea class="form-control keterangan" name="note"></textarea>
                        </div>
                    </div>
                </form>
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
                    {data: 'pd_jabatan_awal', name: 'pd_jabatan_awal'},
                    {data: 'pd_jabatan_sekarang', name: 'pd_jabatan_sekarang'},
                    {data: 'p_nip', name: 'p_nip'},
                    {data: 'p_nip_mitra', name: 'p_nip_mitra'},
                    {data: 'm_name', name: 'm_name'},
                    {data: 'md_name', name: 'md_name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
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

    function promosi(id){
        $('.modal-title').html('Promosi');
        $('.sub-tittle').html('Promosi jabatan adalah hal yang di impikan oleh pekerja :)');
        $('.simbol-modal').html('<i class="fa fa-arrow-circle-up modal-icon"></i>');
        $('.jenis').val('Promosi');
        $('.id_pekerja').val(id);
        $.ajax({
            type: 'get',
            data: {id:id},
            url: baseUrl + '/manajemen-pekerja/promosi-demosi/getdetail',
            dataType: 'json',
            success : function(result){
                var data = result.data[0];
                $('.modal-nama').html(data.p_name);
                $('.modal-jabatan').html(data.jp_name);
            }
        });
        $('#myModal').modal('show');
    }

    function demosi(id){
        $('.modal-title').html('Demosi');
        $('.sub-tittle').html('Demosi jabatan akan menurunkan semangat pekerja :(');
        $('.simbol-modal').html('<i class="fa fa-arrow-circle-down modal-icon"></i>');
        $('.jenis').val('Demosi');
        $('.id_pekerja').val(id);
        $.ajax({
            type: 'get',
            data: {id:id},
            url: baseUrl + '/manajemen-pekerja/promosi-demosi/getdetail',
            dataType: 'json',
            success : function(result){
                var data = result.data[0];
                $('.modal-nama').html(data.p_name);
                $('.modal-jabatan').html(data.jp_name);
            }
        });
        $('#myModal').modal('show');
    }

    function simpan(){
        var note = $('textarea.keterangan').val();
        var jabatan = $('.jabatan').val();
        var jenis = $('.jenis').val();
        var pekerja = $('.id_pekerja').val();
        if (jabatan == '' || jabatan == null) {
            Command: toastr["warning"]("Jabatan tidak boleh kosong", "Peringatan !")

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
        }
        waitingDialog.show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: baseUrl + '/manajemen-pekerja/promosi-demosi/simpan',
            type: 'get',
            data: {note: note, jabatan: jabatan, jenis: jenis, pekerja: pekerja},
            dataType: 'json',
            success: function (response) {
                if (response.status == 'sukses') {
                    swal({
                      title: "Berhasil Disimpan",
                      text: "Data berhasil Disimpan",
                      type: "success",
                      showConfirmButton: false,
                      timer: 900
                    });
                    $('#myModal').modal('hide');
                    location.reload();
                }
                waitingDialog.hide();
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
                waitingDialog.hide();
            }
        });
    }
</script>
@endsection
