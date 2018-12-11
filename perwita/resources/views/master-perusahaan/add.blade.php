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
    <div class="ibox">
        <div class="ibox-title">
            <h5>Tambah Perusahaan</h5>
        </div>
        <div class="ibox-content">
            <div class="row" style="padding-left: 10px; padding-right: 10px;">
                <form class="form-tambah form-horizontal">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Mitra Perusahaan</label>
                        <div class="col-lg-10">
                            <select class="form-control comp" name="comp" id="comp">
                                <option selected disabled>-- Pilih Mitra --</option>
                                @foreach($mitra as $data)
                                <option value="{{ $data->m_id }}">{{ $data->m_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Owner</label>
                        <div class="col-lg-10">
                            <select class="form-control owner" name="owner" id="owner">
                                <option selected disabled>-- Pilih Owner --</option>
                                @foreach($mem as $row)
                                <option value="{{ $row->m_id }}">{{ $row->m_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Alamat</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Alamat" class="form-control alamat" name="alamat" id="alamat">
                        </div>
                    </div>
                </form>
                <div class="col-md-12">
                    <button style="float: right;" class="btn btn-primary btn-outline" onclick="simpan()" type="button">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
    function simpan(){
        waitingDialog.show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ url('master-perusahaan/simpan') }}',
            type: 'post',
            data: $('.form-tambah').serialize(),
            success: function(response){
                waitingDialog.hide();
                if (response.status == 'sukses') {
                    swal({
                        title: "Sukses!!",
                        text: "Data berhasil disimpan",
                        type: "success",
                        showConfirmButton: true,
                        timer: 900
                    });
                    window.location.href = '{{ url('master-perusahaan') }}';
                }
            }, error:function(x, e) {
                waitingDialog.hide();
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
</script>
@endsection
