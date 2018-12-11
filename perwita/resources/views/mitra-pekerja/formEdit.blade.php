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

        table.dataTable tbody td {
            vertical-align: middle;
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
                        <h5>Form Perbarui Data Mitra Pekerja</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form id="form-edit" class="form-edit">
                            <div class="form-group row">
                                <label for="kontrak" class="col-sm-2 col-form-label">No Kontrak</label>
                                <div class="col-sm-10">
                                    {{--   @foreach($update_mitra_contract as $update_mitra_contract) --}}
                                    <input value="{{$update_mitra_contract->mc_no}}" class="form-control"
                                           name="kontrak" id="kontrak" required="">
                                    <input value="{{$update_mitra_contract->mc_contractid}}" type="hidden"
                                           class="form-control" name="mc_contractid" id="mc_contractid" required="">
                                    {{--        @endforeach --}}
                                    <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                          id="kontrak-error"><small>No Kontrak harus diisi...!</small>
                                    </span>
                                </div>
                            </div>

                            <div>
                                <input type="hidden" name="mitra" id="mitra"
                                       value="{{$update_mitra_contract->mc_mitra}}">
                                <div class="form-group row">
                                    <label for="Nama" class="col-sm-2 col-form-label">Tanggal Kontrak</label>
                                    <div class="col-sm-3">
                                        <input value="{{$update_mitra_contract->mc_date}} " readonly=""
                                               class="form-control" name="TanggalKontrak" id="tglKontrak"
                                               required="">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="tglKontrak-error">
                                            <small>Tanggal Kontrak harus diisi...!</small>
                                        </span>
                                    </div>
                                    <label for="tglBatas" class="col-sm-2 col-form-label">Batas Kontrak</label>
                                    <div class="col-sm-3">
                                        <input value="{{$update_mitra_contract->mc_expired}}" readonly
                                               class="form-control" name="BatasKontrak" id="tglBatas" required="">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="tglBatas-error">
                                            <small>Batas Kontrak harus diisi...!</small>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label for="perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                                    <div class="col-sm-10">
                                        <input value="{{$update_mitra_contract->c_name}}"
                                               readonly="" class="form-control" name="perusahaan" data-perusahaan
                                               id="perusahaan" required=""
                                               placeholder="Masukkan Nama Perusahaan"/>
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="perusahaan-error">
                                            <small>Nama Perusahaan harus diisi...!</small>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label for="mitra" class="col-sm-2 col-form-label">Nama Mitra</label>
                                    <div class="col-sm-10">
                                        <input value="{{$update_mitra_contract->m_name}}" readonly=""
                                               class="form-control" name="mitra" data-input-mitra id="mitra"
                                               required=""
                                               placeholder="Masukkan Nama Mitra">{{-- {{$update_mitra_contract->m_name}} --}}
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="mitra-error">
                                            <small>Nama Mitra harus diisi...!</small>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label for="mitra" class="col-sm-2 col-form-label">Nama Divisi</label>
                                    <div class="col-sm-10">
                                        <input readonly="" class="form-control"
                                               value="{{$update_mitra_contract->md_name}} {{-- ({{$update_mitra_contract->md_name}}) --}}"
                                               name="divisi" data-input-divisi id="divisi" required=""
                                               placeholder="Masukkan Nama Mitra">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="mitra-error">
                                            <small>Nama Mitra harus diisi...!</small>
                                        </span>
                                    </div>
                                </div>


                                <div class="form-group row">
                                </div>
                                <div class="form-group row">
                                    <label for="jumlahPekerja" class="col-sm-2 col-form-label">Jumlah
                                        Pekerja</label>
                                    <div class="col-sm-3">
                                        <input value="{{$update_mitra_contract->mc_need}}" readonly="" type="text"
                                               class="form-control" name="JumlahPekerja" id="jumlahPekerja"
                                               placeholder="Masukkan Jumlah Pekerja" required="">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="jumlahPekerja-error">
                                            <small>Jumlah Pekerja harus diisi...!</small>
                                        </span>
                                    </div>
                                    <label for="totalPekerja" class="col-sm-3 col-form-label" style="width:18%">Pekerja
                                        Terpenuhi</label>
                                    <div class="col-sm-3">
                                        <input value="{{$update_mitra_contract->mc_fulfilled}}" type="number"
                                               class="form-control" name="totalPekerja" readonly=""
                                               id="totalPekerja" required="">
                                    </div>
                                </div>
                            </div>

                        </form>

                        <div class="col-md-12" style="margin-top: 20px;">
                            <table class="table table-hover table-striped table-bordered" id="table-pekerja">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>NIK Mitra</th>
                                        <th>Seleksi</th>
                                        <th>Bekerja</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pekerja as $pekerja)
                                        <tr class="pekerja-{{ $pekerja->p_id }}">
                                            <td style="width: 20%;">{{ $pekerja->p_name }}<input type="hidden" name="p_id[]" value="{{ $pekerja->p_id }}"></td>
                                            <td>{{ $pekerja->p_nip }}</td>
                                            <td><input class="form-control" type="text" name="nip_mitra[]" value="{{ $pekerja->mp_mitra_nik }}" style="width: 100%; text-transform:uppercase"></td>
                                            <td style="width: 15%;"><input class="form-control seleksi-date" type="text" name="seleksi[]" value="{{ $pekerja->mp_selection_date }}" style="width: 100%;"></td>
                                            <td style="width: 15%;"><input class="form-control kerja-date" type="text" name="kerja[]" value="{{ $pekerja->mp_workin_date }}" style="width: 100%;"></td>
                                            <td class="text-center"><button id="{{ $pekerja->p_id }}" type="button" class="btn btn-danger btn-hapus"><i class="fa fa-minus"></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <div class="form-group row">
                                <div class="col-sm-6" style="float: left;">
                                    <a href="{{url('manajemen-pekerja-mitra/data-pekerja-mitra/tambah')}}"
                                       class="btn btn-primary btn-outline btn-flat" type="button" style="float: left;">Tambah Pekerja</a>
                                </div>
                                <div class="col-sm-6" style="float: right;">
                                    <button class="ladda-button ladda-button-demo btn btn-success btn-flat simpan"
                                            type="button" id="button" onclick="perbarui()" style="float: right; margin-left: 10px;">
                                        Perbarui
                                    </button>
                                    <a href="{{url('manajemen-pekerja-mitra/data-pekerja-mitra')}}"
                                       class="btn btn-danger btn-flat" type="button" style="float: right;">Batal</a>
                                </div>
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
        var table;
        var hapuspekerja = [];
        $(document).ready(function(){
            table = $("#table-pekerja").DataTable({
                responsive: true,
                "language": dataTableLanguage,
                "columnDefs": [
                    { "orderable": false, "targets": 5 }
                ]
            });

            $('.seleksi-date').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy'
            }).datepicker();

            $('.kerja-date').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy'
            }).datepicker();
        });

        $('#table-pekerja tbody').on( 'click', '.btn-hapus', function () {
            hapuspekerja.push(this.id);
            table
                .row( $(this).parents('tr') )
                .remove()
                .draw();

            var hitung = $('#totalPekerja').val();
            hitung = hitung - 1;
            $('#totalPekerja').val(hitung);
        } );

        function perbarui(){
            waitingDialog.show();
            var hapus = JSON.stringify(hapuspekerja);
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
                url: baseUrl+'/manajemen-pekerja-mitra/data-pekerja-mitra/update',
                data: $('#form-edit').serialize() + '&' + ar.find('input').serialize() + '&hapus=' + hapus,
                type: 'get',
                success: function(response){
                    if(response.status=='sukses'){
                        waitingDialog.hide();
                        swal({
                            title:"Berhasil",
                            text: "Data berhasil dihapus",
                            type: "success",
                            showConfirmButton: false,
                            timer: 900
                        });
                        window.location = baseUrl + '/manajemen-pekerja-mitra/data-pekerja-mitra';
                    } else {
                        waitingDialog.hide();
                        swal({
                            title: "Gagal",
                            text: "Sistem gagal menyimpan data",
                            type: "error",
                            showConfirmButton: false
                        });
                    }
                },error:function(x,e) {
                    waitingDialog.hide();
                    var message;
                    if (x.status==0) {
                        message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                    } else if(x.status==404) {
                        message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                    } else if(x.status==500) {
                        message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                    } else if(e =='parsererror') {
                        message = 'Error.\nParsing JSON Request failed.';
                    } else if(e =='timeout'){
                        message = 'Request Time out. Harap coba lagi nanti';
                    } else {
                        message = 'Unknow Error.\n'+x.responseText;
                    }
                    throwLoadError(message);
                }
            });
            waitingDialog.hide();
        }

    </script>
@endsection
