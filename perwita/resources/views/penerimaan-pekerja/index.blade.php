@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    .loader {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
    }
    /* Safari */
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
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
    <div class="ibox-title">
        <h5>Penerimaan Pekerja</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-5">
                    <select class="form-control" name="jenis" id="jenis" required="">
                        <option value="">-- Pilih Jenis Penerimaan --</option>
                        <option value="Seleksi">Seleksi</option>
                        <option value="Matang">Matang</option>
                        <option value="Take Over">Take Over</option>
                    </select>  
                </div>
                <div class="col-md-7" style="float: right">
                    <button class="btn btn-primary" type="button" style="float: right" onclick="cekValid()" > Lanjutkan</button>
                </div>
                <div class="col-md-2" style="float: right; margin-top: 10px;">
                    <p style="float: right">Jumlah Pekerja : <span class="jml-pekerja">0</span></p>
                </div>
                <div class="col-md-12 " style="margin: 10px 0px 20px 0px;">                    
                   <table id="tabel-pekerja" class="table table-bordered table-striped tabel-pekerja" >
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;"><input type="checkbox" class="all" name="all" id="all" onclick="cekAll()"></th>
                                <th style="width: 30%;">Nama</th>
                                <th style="width: 18%;">NIK</th>
                                <th style="width: 17%;">No Telp</th>
                                <th style="width: 30%;">Alamat</th>
                            </tr>
                        </thead>     
                        <tbody>
                            @foreach($pekerja as $data)
                                <tr>
                                    <td><div class="text-center" for="pekerja"><input type="checkbox" class="pekerja" id="pekerja" name="pekerja[]" value="{{ $data->p_id }}" onclick="hitung()"></div></td>
                                    <td>{{ $data->p_name }}</td>
                                    <td>{{ $data->p_nik }}</td>
                                    <td>{{ $data->p_hp }}</td>
                                    <td>{{ $data->p_address }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-users modal-icon"></i>
                <h4 class="modal-title">Penerimaan Pekerja</h4>
                <small class="font-bold">Penerimaan pekerja jenis seleksi, matang atau take over</small>
            </div>
            <div class="modal-body">
                {{-- <div class="loader" style="margin-left: 30%;"></div> --}}
                <form class="formdetail" style="">
                    <table class="table table-bordered table-striped table-hover" id="table-seleksi">
                        <tr>
                            <td>Jenis Penerimaan</td>
                            <td class="penerimaan">Seleksi<input type="hidden" name="penerimaan" class="penerimaanvalue"></td>
                        </tr>
                        <tr>
                            <td>Jumlah Pekerja</td>
                            <td class="jumlahpekerja">0</td>
                        </tr>
                        <tr class="takeover">
                            <td style="vertical-align: middle;">Take Over Dari</td>
                            <td><input type="text" name="from" class="form-control"></td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">Pilih Kontrak</td>
                            <td>
                                <select class="form-control" name="nomor" id="nomorkontrak" style="width: 100%;" onclick="validasidata()">
                                    <option>-- Pilih Nomor Kontrak --</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" class="btn btn-primary" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;
var jumlahceklist;
$(document).ready(function(){
    $('#jenis').select2();
    table = $('#tabel-pekerja').DataTable({
        "language": dataTableLanguage,
        "columnDefs": [
            { "orderable": false, "targets": 0 }
          ]

    });
    table
    .column( '1:visible' )
    .order( 'asc' )
    .draw();
});

function cekValid(){
    waitingDialog.show();
    var jenis = $('#jenis').val();
    if (jenis == null || jenis == '') {
        waitingDialog.hide();
        Command: toastr["warning"]("Jenis penerimaan harus diisi", "Peringatan !")

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

    if (jenis == 'Take Over') {
        $('.takeover').show();
    } else {
        $('.takeover').hide();
    }
    $('.penerimaan').html(jenis);
    $('.jumlahpekerja').html(jumlahceklist);
    $.ajax({
        url: baseUrl + '/manajemen-pekerja-mitra/penerimaan-pekerja-mitra/getNomor',
        type: 'get',
        data: {jenis: jenis},
        success: function(response){
            var data = response.data[0];        
            $('.penerimaan').html($('#jenis').val());
            var jenis = $('#jenis').val();
            $('.penerimaanvalue').val(jenis);
            $('.jumlahpekerja').html(jumlahceklist);
            var tanam = "<option>-- Pilih Nomor Kontrak --</option>";
            for (var i = 0; i < response.data.length; i++) {
                tanam = tanam + '<option value='+response.data[i].mc_no+'>'+response.data[i].mc_no+' -- '+response.data[i].m_name+' -- ('+response.data[i].kurang+' Pekerja)</option>';
            }
            $('#nomorkontrak').html(tanam);
            //$('#nomorkontrak').chosen();
            waitingDialog.hide();
            $('#myModal').modal('show');
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
            waitingDialog.hide();
        }
    })
}

function cekAll(){
    if ($('.all').is(":checked")) {
        table.$('input[name="pekerja[]"]').prop("checked", true);
    } else {
        table.$('input[name="pekerja[]"]').prop("checked", false);
    }
    hitung();
}

function hitung(){
    var id = document.getElementsByClassName( 'pekerja' ),
    pekerja  = [].map.call(id, function( input ) {
        if (input.checked) {
            return input.value;
        } else {
            return false;
        }
    });

    var jumlah = 0;
    for (var i = 0; i < pekerja.length; i++) {
        if (pekerja[i]) {
            jumlah = jumlah + 1;
        } else {
            $('.all').prop("checked", false);
        }
    }
    jumlahceklist = jumlah;
    $('.jml-pekerja').html(jumlahceklist);
}

function simpan(){
    waitingDialog.show();
    var jenis = $('#jenis').val();
    var ar = $();
    for (var i = 0; i < table.rows()[0].length; i++) { 
        ar = ar.add(table.row(i).node());
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var pekerja = ar.find('input').serialize();
    $.ajax({
        url: baseUrl + '/manajemen-pekerja-mitra/penerimaan-pekerja-mitra/simpan',
        type: 'get',
        data: pekerja+'&'+$('.formdetail').serialize()+'&penerimaan='+jenis,
        success: function(response){
            waitingDialog.hide();
            $('#myModal').modal('hide');
            if (response.status == 'sukses') {
                swal({
                        title: "Sukses",
                        text: "Data sudah tersimpan",
                        type: "success"
                    }, function () {
                      //cari();
                      location.reload();
                    });
            } else {
                swal({
                    title: "Gagal",
                    text: "Sistem gagal menyimpan data",
                    type: "error",
                    showConfirmButton: false
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
            waitingDialog.hide();
        }
    })
}
</script>
@endsection