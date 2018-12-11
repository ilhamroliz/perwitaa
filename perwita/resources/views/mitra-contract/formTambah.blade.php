@extends('main')

@section('title', 'Permintaan Pekerja')

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
        <h2>Permintaan Tenaga Kerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Tambah Permintaan Tenaga Kerja</strong>
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
                    <h5>Form Tambah Permintaan Tenaga Kerja</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form id="form-mitra-contract">
                        <div class="form-group row">
                            <label for="Nama" class="col-sm-2 col-form-label">Tanggal Kontrak</label>
                            <div class="col-sm-3">
                                <input readonly="" class="form-control" name="Tanggal Kontrak" id="tglKontrak"  required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglKontrak-error">
                                    <small>Tanggal Kontrak harus diisi...!</small>
                                </span>
                            </div>
                            <label for="tglBatas" class="col-sm-2 col-form-label">Batas Kontrak</label>
                            <div class="col-sm-3">
                                <input readonly class="form-control" name="Batas Kontrak" id="tglBatas" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglBatas-error">
                                    <small>Batas Kontrak harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="perusahaan" id="perusahaan" required="" readonly>
                                    @foreach($comp as $data)
                                    @if($data->c_id == 'PWT0000003')
                                    <option value="{{$data->c_id}}" selected>{{$data->c_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="perusahaan-error">
                                    <small>Nama Perusahaan harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Nama Mitra</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="mitra" id="mitra" required="" onchange="getDivisi()">
                                    <option value="" selected="true" readonly="true" disabled="">--Pilih Mitra--</option>
                                    @foreach($mitra as $data)
                                    <option value="{{$data->m_id}}">{{$data->m_name}}</option>
                                    @endforeach
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="mitra-error">
                                    <small>Nama Mitra harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Nama Divisi</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="divisi" id="divisi" required="">
                                    <option value="" selected="true" disabled="">--Pilih Divisi--</option>
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="divisi-error">
                                    <small>Nama Mitra harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Jenis Jabatan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="jabatan" id="jabatan" required="">
                                    <option value="" selected="true" disabled="">--Pilih Jabatan--</option>
                                    @foreach($jabatan as $jab)
                                    <option value="{{$jab->jp_id}}">{{$jab->jp_name}}</option>
                                    @endforeach
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="jabatan-error">
                                    <small>jabatan harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlahPekerja" class="col-sm-2 col-form-label">Jumlah Pekerja</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Jumlah Pekerja" id="jumlahPekerja" placeholder="Masukkan Jumlah Pekerja" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="jumlahPekerja-error">
                                    <small>Jumlah Pekerja harus diisi...!</small>
                                </span>
                            </div>
                            <label for="totalPekerja" class="col-sm-3 col-form-label" style="width:18%">Total Pekerja Terpenuhi</label>
                            <div class="col-sm-3">
                                <input value="0" type="number" class="form-control" name="totalPekerja" readonly="" id="totalPekerja"  required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Jobdesk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  id="jobdesk" name="jobdesk" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="jobdesk-error">
                                    <small>Jobdesk harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Note</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  id="note" name="note" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="note-error">
                                    <small>Note harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                        <a href="{{url('manajemen-kontrak-mitra/data-kontrak-mitra')}}" class="btn btn-danger btn-flat" type="button">Kembali</a>
                                        <button class="ladda-button ladda-button-demo btn-outline btn btn-primary btn-flat simpan" type="button" onclick="simpan()">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('extra_scripts')
<script type="text/javascript">
    var info = $('.pesan');
    $('#tglKontrak').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    }).datepicker("setDate", "0");
    $('#tglBatas').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    }).datepicker("setDate", "0");

      var config = {
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                //'.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Data Tidak Ditemukan'},
                '.chosen-select-width'     : {width:"95%"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
$('#mitra').chosen({search_contains:true});
$('#perusahaan').chosen({search_contains:true});
$('#divisi').select2();
$('#jabatan').chosen({search_contains:true});


    function simpan() {
        var buttonLadda = $('.simpan').ladda();
        buttonLadda.ladda('start');
        waitingDialog.show();
        $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
        if (validateForm()) {
            $.ajax({
                url: baseUrl + '/manajemen-kontrak-mitra/data-kontrak-mitra/simpan',
                type: 'post',
                data: $('#form-mitra-contract').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'berhasil') {
                        waitingDialog.hide();
                        window.location = baseUrl + '/manajemen-kontrak-mitra/data-kontrak-mitra';
                        //alert('berhasil')
                    } else if (response.status == 'gagal') {
                        info.css('display', '');
                        $.each(response.data, function (index, error) {
                            info.find('ul').append('<li>' + error + '</li>');
                        });
                        buttonLadda.ladda('stop');
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

                    buttonLadda.ladda('stop');
                    waitingDialog.hide();
                }
            });
        } else {
            buttonLadda.ladda('stop');
        }
    }

    function validateForm() {
       waitingDialog.hide();
        $('.reset').css('display', 'none');

        var tglKontrak = document.getElementById('tglKontrak');
        var tglBatas = document.getElementById('tglBatas');
        var perusahaan = document.getElementById('perusahaan');
        var mitra = document.getElementById('mitra');
        var jumlahPekerja = document.getElementById('jumlahPekerja');
        var divisi = document.getElementById('divisi');
        var jabatan = document.getElementById('jabatan');
        var jobdesk = document.getElementById('jobdesk');
        var note = document.getElementById('note');

        //alert(username.value);

        if (tglKontrak.validity.valueMissing) {
            $('#tglKontrak-error').css('display', '');
            return false;
        }
        else if (tglBatas.validity.valueMissing) {
            $('#tglBatas-error').css('display', '');
            return false;
        }
        else if (perusahaan.validity.valueMissing) {
            $('#perusahaan-error').css('display', '');
            return false;
        }
        else if (mitra.validity.valueMissing) {
            $('#mitra-error').css('display', '');
            return false;
        }
        else if (divisi.validity.valueMissing) {
            $('#divisi-error').css('display', '');
            return false;
        }
        else if (jumlahPekerja.validity.valueMissing) {
            $('#jumlahPekerja-error').css('display', '');
            return false;
        }
        else if (jabatan.validity.valueMissing) {
            $('#jabatan-error').css('display', '');
            return false;
        }
        else if (jobdesk.validity.valueMissing) {
            $('#jobdesk-error').css('display', '');
            return false;
        }
        else if (note.validity.valueMissing) {
            $('#note-error').css('display', '');
            return false;
        }

        return true;
    }

    function getDivisi(){
        waitingDialog.show();
        var mitra = $('#mitra').val();
        $.ajax({
            url: baseUrl + '/manajemen-kontrak-mitra/data-kontrak-mitra/getdivisi',
            type: 'get',
            data: {mitra: mitra},
            success: function(response){
                var data = response.data;
                var tanam = '<option value="" selected="true" disabled="">--Pilih Divisi--</option>';
                for (var i = 0; i < data.length; i++) {
                    tanam = tanam + '<option value='+data[i].md_id+'>'+data[i].md_name+'</option>';
                }
                $('#divisi').html(tanam);
                waitingDialog.hide();
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
