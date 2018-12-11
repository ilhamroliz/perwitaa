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

    </style>

@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Mitra Perusahaan</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li>
                    Manajemen Mitra
                </li>
                <li>
                    Mitra MOU
                </li>
                <li class="active">
                    <strong>Tambah MOU Mitra</strong>
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
                        <h5>Form Tambah MOU Mitra</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="error-load">

                    </div>
                    <div class="ibox-content">
                        <form id="form-mitra">
                            <div class="form-group row">
                                <label for="namamitra" class="col-sm-2 col-form-label">Nama Mitra</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="namamitra" id="namamitra"
                                           placeholder="Nama Mitra" required="">
                                    <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                          id="nama-error">
                                    <small>Nama Mitra harus diisi! ...</small>
                                </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nomou" class="col-sm-2 col-form-label">No MOU</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomou" id="nomou" placeholder="No MOU"
                                           required="" style="text-transform:uppercase;">
                                    <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                          id="no-error">
                                    <small>No Mou harus diisi! ...</small>
                                </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggalmou" class="col-sm-2 col-form-label">Tanggal MOU</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control start-mou date-mou" name="startmou"
                                           style="text-transform:uppercase" title="Start Mou" placeholder="Start">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control end-mou date-mou" name="endmou"
                                           style="text-transform:uppercase" title="End Mou" placeholder="End">
                                </div>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                      id="tanggal-error">
                                    <small>Tanggal Mou harus diisi! ...</small>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat Mitra</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="alamatmitra" id="alamatmitra"
                                           placeholder="Alamat Mitra" required="">
                                    <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                          id="alamat-error">
                                    <small>Alamat Mitra harus diisi! ...</small>
                                </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cperson" class="col-sm-2 col-form-label">Contact Person</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control nama-cp" name="nama_cp" id="cperson"
                                           title="Nama Contact Person" placeholder="Nama Contact Person">
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control no-cp" name="no_cp" title="No Contact Person"
                                           placeholder="No Contact Person" onkeypress="validate(event)">
                                </div>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                      id="cperson-error">
                                    <small>Contact Person harus diisi! ...</small>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="notelp" class="col-sm-2 col-form-label">Nomor Telepon</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="notelp" id="notelp"
                                           placeholder="Nomor Telepon" required="">
                                    <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                          id="notelp-error">
                                    <small>Nomor Telepon harus diisi! ...</small>
                                </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ket" class="col-sm-2 col-form-label">Keterangan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="ket" id="ket" placeholder="Keterangan"
                                           required="">
                                    <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                          id="ket-error">
                                    <small>Keterangan harus diisi! ...</small>
                                </span>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-9">
                                    <a href="{{url('/manajemen-mitra/data-mitra')}}" class="btn btn-danger btn-flat">Kembali</a>
                                    <button class="ladda-button ladda-button-demo btn btn-primary btn-outline btn-flat simpan"
                                            type="button" onclick="simpan()">
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
        $(document).ready(function () {
            $('.start-mou').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy'
            });
            $('.end-mou').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy'
            });
        });

        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }

        function simpan() {
            if (validateForm()) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: baseUrl + '/manajemen-mitra/data-mitra/simpan',
                    type: 'get',
                    data: $('#form-mitra').serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 'berhasil') {
                            swal({
                                title: "Sukses",
                                text: "Data sudah tersimpan",
                                type: "success"
                            }, function () {
                                window.location = baseUrl + '/manajemen-mitra/data-mitra';
                            });
                        } else if (response.status == 'gagal') {
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
                    }
                });
            }
        }

        function validateForm() {
            $('.reset').css('display', 'none');
            var no = document.getElementById('nomou');
            var nama = document.getElementById('namamitra');
            var alamat = document.getElementById('alamatmitra');
            var cperson = document.getElementById('cperson');
            var notelp = document.getElementById('notelp');
            var keterangan = document.getElementById('ket');

            //alert(username.value);

            if (no.validity.valueMissing) {
                $('#no-error').css('display', '');
                return false;
            }
            else if (nama.validity.valueMissing) {
                $('#nama-error').css('display', '');
                return false;
            }
            else if (alamat.validity.valueMissing) {
                $('#alamat-error').css('display', '');
                return false;
            }
            else if (cperson.validity.valueMissing) {
                $('#cperson-error').css('display', '');
                return false;
            }
            else if (notelp.validity.valueMissing) {
                $('#notelp-error').css('display', '');
                return false;
            }
            else if (keterangan.validity.valueMissing) {
                $('#ket-error').css('display', '');
                return false;
            }


            return true;
        }


    </script>
@endsection
