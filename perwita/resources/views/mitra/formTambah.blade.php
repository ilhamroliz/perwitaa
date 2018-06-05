@extends('main')

@section('title', 'Dashboard')

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

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="alert alert-danger pesan" style="display:none;">
        <ul></ul>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Form Tambah Data Mitra</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
                </div>
                <div class="ibox-content">
                    <form id="form-mitra">
                        <div class="form-group row">
                            <label for="Nama" class="col-sm-2 col-form-label">Nama Mitra</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Nama Mitra" id="Nama" placeholder="Nama Mitra" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="nama-error">
                                    <small>Nama Mitra harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Alamat" class="col-sm-2 col-form-label">Alamat Mitra</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Alamat" id="Alamat" placeholder="Alamat Mitra" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="alamat-error">
                                    <small>Alamat harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Telp" class="col-sm-2 col-form-label">No Telp.</label>
                            <div class="col-sm-10">
                                <input onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" name="No_Telp" id="Telp" placeholder="No Telp." required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="telp-error">
                                    <small>No Telp. harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Fax" class="col-sm-2 col-form-label">No Fax.</label>
                            <div class="col-sm-10">
                                <input onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" name="Fax" id="Fax" placeholder="No Fax" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="fax-error">
                                    <small>No Fax harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Keterangan" id="Keterangan" placeholder="Keterangan" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="keterangan-error">
                                    <small>Keterangan harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                        <button class="btn btn-danger btn-flat" type="button">Kembali</button>
                                        <button class="ladda-button ladda-button-demo btn btn-primary btn-flat simpan" type="button" onclick="simpan()">
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
    $('.tanggal').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
        endDate: 'today'
    }).datepicker("setDate", "0");
    function simpan() {
        var buttonLadda = $('.simpan').ladda();
        buttonLadda.ladda('start');                
        if (validateForm()) {
            $.ajax({
                url: baseUrl + '/manajemen-mitra/data-mitra/simpan',
                // type        : 'post',            
                type: 'get',
                timeout: 10000,
                data: $('#form-mitra').serialize(),
                dataType: 'json',
                enctype: 'multipart/form-data',
                processData: false, // tell jQuery not to process the data
                contentType: false,
                success: function (response) {
                    if (response.status == 'berhasil') {
                        window.location = baseUrl + '/manajemen-mitra/data-mitra';
                    } else if (response.status == 'gagal') {
                        info.css('display', '');
                        $.each(response.data, function (index, error) {
                            info.find('ul').append('<li>' + error + '</li>');
                        });
                        buttonLadda.ladda('stop');
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

                    buttonLadda.ladda('stop');
                }
            });
        } else {
            buttonLadda.ladda('stop');
        }
    }

    function validateForm() {
        $('.reset').css('display', 'none');
        var nama = document.getElementById('Nama');
        var alamat = document.getElementById('Alamat');
        var telp = document.getElementById('Telp');
        var fax = document.getElementById('Fax');
        var keterangan = document.getElementById('Keterangan');

        //alert(username.value);

        if (nama.validity.valueMissing) {
            $('#nama-error').css('display', '');
            return false;
        }
        else if (alamat.validity.valueMissing) {
            $('#alamat-error').css('display', '');
            return false;
        }
        else if (telp.validity.valueMissing) {
            $('#telp-error').css('display', '');
            return false;
        }
        else if (fax.validity.valueMissing) {
            $('#fax-error').css('display', '');
            return false;
        }
        else if (keterangan.validity.valueMissing) {
            $('#keterangan-error').css('display', '');
            return false;
        }


        return true;
    }



</script>
@endsection