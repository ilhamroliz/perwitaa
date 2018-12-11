@extends('main')

@section('title', 'Perusahaan')

@section('extra_styles')

<style>
.popover-navigation [data-role="next"] { display: none; }
.popover-navigation [data-role="end"] { display: none; }
.checkbox.checkbox-single {
    label {
        width: 0;
        height: 16px;
        visibility: hidden;
        &:before, &:after {
            visibility: visible;
        }
    }
}
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Master Perusahaan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Setting Aplikasi
            </li>
            <li class="active">
                <strong>Master Perusahaan</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-7">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Pengaturan Perusahaan</h5>
                    <button style="float: right; margin-top: -7px;" onclick="tambah()" class="btn btn-outline btn-success btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
                </div>
                <div class="ibox-content">
                    <div class="row" style="padding-left: 10px; padding-right: 10px;">
                        <form class="form-pengaturan">
                            <table class="table table-striped col-md-12" id="table-pengaturan">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Perusahaan</th>
                                        <th class="text-center">Aksi</th>
                                        <th class="text-center">Aktif</th>
                                    </tr>
                                </thead>
                            </table>
                        </form>
                        <div class="col-md-12">
                            <button style="float: right;" class="btn btn-primary" onclick="update()" type="button">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Perusahaan Aktif</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped " id="table-perusahaan">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-edit modal-icon"></i>
                <h4 class="modal-title">Edit Jabatan</h4>
                <small class="font-bold">Mengubah nama jabatan yang akan ditampilkan.</small>
            </div>
            <div class="modal-body">
                <form class="form-modal form-horizontal">
                    <div class="form-group"><label class="col-lg-2 control-label">Nama</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Nama Jabatan" class="form-control namajabatan" name="namajabatan">
                            <input type="hidden" class="idjabatan" name="idjabatan">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpanEdit()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-plus modal-icon"></i>
                <h4 class="modal-title">Tambah Jabatan</h4>
                <small class="font-bold">Menambah list jabatan yang akan digunakan.</small>
            </div>
            <div class="modal-body">
                <form class="form-tambah form-horizontal">
                    <div class="form-group"><label class="col-lg-2 control-label">Nama</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Nama Jabatan" class="form-control namatambah" name="namatambah">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpanAdd()">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;
    var pengaturan;
    $(document).ready(function(){

        setTimeout(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            pengaturan = $("#table-pengaturan").DataTable({
                processing: true,
                searching: false,
                paging: false,
                serverSide: true,
                "ajax": {
                    "url": "{{ url('master-perusahaan/table') }}",
                    "type": "post"
                },
                columns: [
                    {data: 'c_name', name: 'c_name'},
                    {data: 'edit', name: 'edit'},
                    {data: 'aksi', name: 'aksi'}
                ],
                aaSorting:[],
                responsive: true,
                "language": dataTableLanguage,
            });
        }, 500);

        setTimeout(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            table = $("#table-perusahaan").DataTable({
                processing: true,
                searching: false,
                paging: false,
                serverSide: true,
                "ajax": {
                    "url": "{{ url('master-perusahaan/data') }}",
                    "type": "POST"
                },
                columns: [
                    {data: 'c_name', name: 'c_name'},
                ],
                responsive: true,
                "language": dataTableLanguage,
            });
        }, 1000);
    });

    function edit(id, nama){
        $('.namajabatan').val(nama);
        $('.idjabatan').val(id);
    }

    function simpanEdit(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ url('master-jabatan/rename') }}',
            type: 'post',
            data: $('.form-modal').serialize(),
            success: function(response){
                if (response.status == 'sukses') {
                    $('#myModal').modal('hide');
                    table.ajax.reload();
                    pengaturan.ajax.reload();
                }
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

    function update(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ url('master-perusahaan/update') }}',
            type: 'post',
            data: $('.form-pengaturan').serialize(),
            success: function(response){
                if (response.status == 'sukses') {
                    table.ajax.reload();
                    pengaturan.ajax.reload();
                }
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

    function hapus(id){
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin ingin menghapus data Jabatan?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ url('master-perusahaan/hapus') }}',
                    type: 'post',
                    data: { id: id },
                    success: function(response){
                        if (response.status == 'sukses') {
                            swal({
                                title: "Data Dihapus",
                                text: "Data berhasil dihapus",
                                type: "success",
                                showConfirmButton: true,
                                timer: 900
                            });
                            table.ajax.reload();
                            pengaturan.ajax.reload();
                        }
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
            });
    }

    function tambah(){
        window.location.href = '{{ url('master-perusahaan/tambah') }}';
    }
</script>
@endsection
