@extends('main')
@section('title', 'Rekening Pekerja')
@section('extra_styles')
<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    .huruf{
        text-transform: capitalize;
    }
    .spacing-top{
        margin-top:15px;
    }
    #upload-file-selector {
        display:none;
    }
    .margin-correction {
        margin-right: 10px;
    }
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Rekening Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Rekening Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox">
    <div class="ibox-title">
      <h5>Rekening Pekerja</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <input type="text" name="cari" class="form-control" id="caripekerja" placeholder="Nama Pekerja/NIK Pekerja/NIK Mitra">
                </div>
                <button type="button" class="btn btn-info col-md-1"><i class="fa fa-search"></i> Cari</button>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <table class="table table-stripped table-bordered table-responsive" id="table-rekening">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Nama</th>
                            <th style="width: 20%;">NIK</th>
                            <th style="width: 20%;">NIK Mitra</th>
                            <th style="width: 25%;">No Rekening</th>
                            <th style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>


@endsection
@section("extra_scripts")
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $('#table-rekening').DataTable({
            "language": dataTableLanguage,
            'paging': false,
            'searching': false
        });
    });

    $('#caripekerja').autocomplete({
        source: baseUrl + '/manajemen-pekerja/rekening/getdata',
        select: function(event, ui) {
            getdata(ui.item);
        }
    });

    function getdata(data){
        var info = data.data;
        table.clear();
        table.row.add([
            info.p_name,
            info.p_nip,
            info.p_nip_mitra,
            '<input type="text" name="norek" value="'+info.p_norek+'" class="form-control norek" style="width: 100%;" placeholder="Masukkan Nomor Rekening">',
            '<div class="text-center"><button type="button" onclick="simpan('+info.p_id+')" class="btn btn-primary">Simpan</button></div>'
            ]).draw();
    }

    function simpan(id){
        waitingDialog.show();
        var no = $('.norek').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ url('manajemen-pekerja/rekening/simpan') }}',
            type: 'post',
            data: {norek: no, id: id},
            success: function(response){
                if (response.status == 'sukses') {
                    waitingDialog.hide();
                    swal({
                        title: "Sukses",
                        text: "Data sudah tersimpan",
                        type: "success"
                    }, function () {
                        $('.norek').val(no);
                    });
                } else {
                    waitingDialog.hide();
                    swal({
                        title: "Gagal!!",
                        text: "Data gagal tersimpan",
                        type: "danger"
                    }, function () {
                        $('.norek').focus();
                    });
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
@endsection()
