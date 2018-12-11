@extends('main')
@section('title', 'Penerimaan Pekerja')
@section('extra_styles')
    <style>
        .popover-navigation [data-role="next"] {
            display: none;
        }

        .popover-navigation [data-role="end"] {
            display: none;
        }

        .huruf {
            text-transform: capitalize;
        }

        .spacing-top {
            margin-top: 15px;
        }

        #upload-file-selector {
            display: none;
        }

        .margin-correction {
            margin-right: 10px;
        }

        input.transparent-input{
           background-color:transparent !important;
           border:none !important;
        }

        table.dataTable tbody td {
            vertical-align: middle;
        }

    </style>
@endsection
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Penerimaan Pekerja</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li>
                    Manajemen Pekerja
                </li>
                <li class="active">
                    <strong>Penerimaan Pekerja</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="alert alert-danger pesan" style="display:none;">
            <ul></ul>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Form Tambah Data Mitra Pekerja</h5>
                    </div>
                    <div class="ibox-content">
                        <p><strong>Mitra : </strong>{{ $info[0]->m_name }}</p>
                        <p><strong>Divisi : </strong>{{ $info[0]->md_name }}</p>
                        <p><strong>No Kontrak : </strong>{{ $info[0]->mc_no }}</p>
                        <p><strong>Tgl Seleksi : </strong>{{ $seleksi }}</p>
                        <p><strong>Tgl Kerja : </strong>{{ $kerja }}</p>
                        <p><strong>Kebutuhan : </strong>{{ $info[0]->mc_need }}</p>
                        <p><strong>Terpenuhi : </strong>{{ $info[0]->mc_fulfilled }}</p>

                        <div class="hr-line-dashed"></div>
                        <form style="display: none" class="form">
                            <input type="hidden" name="id_kontrak" value="{{ $info[0]->mc_contractid }}">
                            <input type="hidden" name="no_kontrak" value="{{ $info[0]->mc_no }}">
                            <input type="hidden" name="tgl_seleksi" value="{{ $seleksi }}">
                            <input type="hidden" name="tgl_kerja" value="{{ $kerja }}">
                        </form>
                        <table class="table table-bordered table-striped pilihMitraPekerja table-hover" id="pilihMitraPekerja">
                            <thead>
                                <th>Nama Pekerja</th>
                                <th>NIK Lama<sup>*</sup></th>
                                <th>NIK Mitra<sup>*</sup></th>
                                <th>JK</th>
                                <th>No Hp</th>
                                <th>NIK Baru</th>
                            </thead>
                            <tbody>
                            @foreach($pekerja as $index => $data)
                                <tr>
                                    <td>{{$data->p_name}}</td>
                                    <td>
                                        @if($data->p_nip == null || $data->p_nip == '')
                                        <input type="text" name="nik[]" class="form-control pekerja-{{ $data->p_id }}" placeholder="Masukan NIK" style="text-transform: uppercase; width: 100%" value="{{ $data->p_nip }}" readonly>
                                        @else
                                        <input type="text" name="nik[]" class="form-control pekerja-{{ $data->p_id }}" placeholder="Masukan NIK" style="text-transform: uppercase; width: 100%" value="{{ $data->p_nip }}">
                                        @endif
                                        <input type="hidden" class="niklama-{{ $data->p_id }}" value="{{ $data->p_nip }}">
                                        <input type="hidden" name="id_pekerja[]" value="{{ $data->p_id }}">
                                    </td>
                                    <td>
                                        <input type="text" name="nik_mitra[]" class="form-control" placeholder="Masukan NIK" style="text-transform: uppercase; width: 100%" value="{{ $data->p_nip_mitra }}">
                                    </td>
                                    <td>{{$data->p_sex}}</td>
                                    <td>{{$data->p_hp}}</td>
                                    <td class="text-center">
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            @if($data->p_nip == null || $data->p_nip == '')
                                            <input type="checkbox" id="nik-{{ $data->p_id }}" value="{{ $data->p_id }}" name="nikbaru[]" checked onchange="gantiForm('{{ $data->p_id }}')">
                                            @else
                                            <input type="checkbox" id="nik-{{ $data->p_id }}" value="{{ $data->p_id }}" name="nikbaru[]" onchange="gantiForm('{{ $data->p_id }}')">
                                            @endif
                                            <label for="nik-{{ $data->p_id }}">NIK Baru</label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <tbody>
                        </table>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="m-t" style="float: left; margin-top: -10px;">
                                    <small><sup>*</sup> Jika sudah terisi, mungkin itu data lama dan bisa diganti. Data ini akan disimpan</small>
                                    <br>
                                    <small><strong>NB:</strong> Jika pekerja tidak memiliki NIK lama, maka sistem akan otomatis menggunakan NIK baru</small>
                                </div>
                                <button class="btn btn-primary btn-outline simpan" type="button" onclick="simpan()" style="float: right">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('extra_scripts')
<script type="text/javascript">
var table = $(".pilihMitraPekerja").DataTable({
    "language": dataTableLanguage,
    "paging": false,
    "searching": false,
    "aaSorting": []
});
function simpan(){
    waitingDialog.show();

    var ar = $();
    for (var i = 0; i < table.rows()[0].length; i++) {
        ar = ar.add(table.row(i).node());
    }
    $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    $.ajax({
        url: baseUrl + '/manajemen-pekerja-mitra/data-pekerja-mitra/simpan',
        type: 'post',
        data: ar.find('input').serialize() + '&' + $('.form').serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status == 'sukses') {
                    waitingDialog.hide();
                    swal({
                        title: "Sukses",
                        text: "Data sudah tersimpan",
                        type: "success"
                    }, function () {
                        window.location.assign("{{ url('manajemen-pekerja-mitra/data-pekerja-mitra') }}");
                    });
                } else {
                    waitingDialog.hide();
                    swal({
                        title: "Gagal",
                        text: "Sistem gagal menyimpan data",
                        type: "error",
                        showConfirmButton: false
                    });
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
            waitingDialog.hide();
        }
    });
}

function gantiForm(id){
    if ($('#nik-'+id).is(':checked')) {
        $('.pekerja-'+id).val('');
        $('.pekerja-'+id).prop('readonly', true);
    } else {
        var nik = $('.niklama-'+id).val();
        $('.pekerja-'+id).val(nik);
        $('.pekerja-'+id).prop('readonly', false);
    }
}
</script>
@endsection
