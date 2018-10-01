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
        <h2>Fasilitas Kesehatan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Asuransi
            </li>
            <li class="active">
                <strong>Fasilitas Kesehatan</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="wrapper wrapper-content animated fadeInRight col-md-7">
        <div class="ibox-title">
            <h5>Data Fasilitas Kesehatan</h5>
        </div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="row m-b-lg">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index=>$row)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $row->f_name }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight col-md-5">
        <div class="ibox-title">
            <h5>Tambah Fasilitas Kesehatan</h5>
        </div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="row m-b-lg">
                    <input type="text" name="faskes" class="form-control" id="namefaskes" placeholder="Masukkan Fasilitas Kesehatan">
                    <div style="margin-top: 10px;">
                        <button style="float: right;" class="btn btn-primary btn-outline" type="button" onclick="simpan()"> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_scripts')
<script type="text/javascript">
    function simpan(){
        $.ajax({
            url: {{ url('manajemen-faskes/simpan') }},
            type: 'get',
            dataType: 'json',
            success: function (response) {

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
            }
        });
    }
</script>
@endsection
