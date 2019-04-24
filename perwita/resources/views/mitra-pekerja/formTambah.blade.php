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

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="alert alert-danger pesan" style="display:none;">
            <ul></ul>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Form Tambah Data Mitra Pekerja</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="post" id="form-mitra-contract" action="{{ url('manajemen-pekerja-mitra/data-pekerja-mitra/lanjut') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                        {{-- <form id="form-mitra-contract" accept-charset="UTF-8" enctype="multipart/form-data"> --}}
                            <div class="form-group row">
                                <label for="kontrak" class="col-sm-2 col-form-label">No Kontrak</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="kontrak" id="kontrak" required=""
                                            onchange="cekMitraComp()">
                                        <option>-- Pilih Nomor Kotrak --</option>
                                        @foreach($mitra_contract as $data)
                                            <option data-mitra="{{$data->mc_mitra}}"
                                                    data-contractid="{{$data->mc_contractid}}"
                                                    value="{{$data->mc_no}}">{{$data->mc_no}} ({{$data->m_name}} - {{$data->md_name}})
                                            </option>
                                        @endforeach
                                    </select>

                                    <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                          id="kontrak-error">
                                    <small>No Kontrak harus diisi...!</small>
                                </span>
                                </div>
                            </div>
                            <div class="sembunyikan" style="display: none">
                                    <input type="hidden" name="mc_contractid" id="mc_contractid"
                                           value="{{$mitra_contract[0]->mc_contractid}}">

                                <div class="form-group row">
                                    <label for="Nama" class="col-sm-2 col-form-label">Tanggal Kontrak</label>
                                    <div class="col-sm-3">
                                        <input readonly="" class="form-control" name="Tanggal Kontrak" id="tglKontrak"
                                               required="">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="tglKontrak-error">
                                    <small>Tanggal Kontrak harus diisi...!</small>
                                </span>
                                    </div>
                                    <label for="tglBatas" class="col-sm-2 col-form-label">Batas Kontrak</label>
                                    <div class="col-sm-3">
                                        <input readonly class="form-control" name="Batas Kontrak" id="tglBatas"
                                               required="">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="tglBatas-error">
                                    <small>Batas Kontrak harus diisi...!</small>
                                </span>
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label for="perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                                    <div class="col-sm-10">
                                        <input readonly="" class="form-control" name="perusahaan" data-perusahaan
                                               id="perusahaan" required="" placeholder="Masukkan Nama Perusahaan">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="perusahaan-error">
                                    <small>Nama Perusahaan harus diisi...!</small>
                                </span>
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label for="mitra" class="col-sm-2 col-form-label">Nama Mitra</label>
                                    <div class="col-sm-10">
                                        <input readonly="" class="form-control" value="" name="mitra" data-input-mitra
                                               id="mitra" required="" placeholder="Masukkan Nama Mitra">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="mitra-error">
                                    <small>Nama Mitra harus diisi...!</small>
                                </span>
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label for="mitra" class="col-sm-2 col-form-label">Nama Divisi</label>
                                    <div class="col-sm-10">
                                        <input readonly="" class="form-control" name="divisi" data-input-divisi
                                               id="divisi" required="" placeholder="Masukkan Nama Mitra">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="mitra-error">
                                    <small>Nama Mitra harus diisi...!</small>
                                </span>
                                    </div>
                                </div>
                                <input type="hidden" name="statusmp1" value="1">


                                <div class="form-group row">
                                    <label for="jumlahPekerja" class="col-sm-2 col-form-label">Jumlah Pekerja</label>
                                    <div class="col-sm-3">
                                        <input readonly="" type="text" class="form-control" name="Jumlah Pekerja"
                                               id="jumlahPekerja" placeholder="Masukkan Jumlah Pekerja" required="">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="jumlahPekerja-error">
                                    <small>Jumlah Pekerja harus diisi...!</small>
                                </span>
                                    </div>


                                    <label for="totalPekerja" class="col-sm-3 col-form-label" style="width:18%">Pekerja Terpenuhi</label>
                                    <div class="col-sm-3">
                                        <input value="0" type="number" class="form-control" name="totalPekerja"
                                               readonly="" id="totalPekerja" required="">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="Nama" class="col-sm-2 col-form-label">Tanggal Seleksi</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" name="mp_selection_date"
                                               id="mp_selection_date" required="">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="tglKontrak-error">
                                    <small>Tanggal Kontrak harus diisi...!</small>
                                </span>
                                    </div>
                                    <label for="tglBatas" class="col-sm-2 col-form-label">Tanggal Masuk Kerja</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" name="mp_workin_date" id="mp_workin_date"
                                               required="">
                                        <span style="color:#ed5565;display:none" class="help-block m-b-none reset"
                                              id="tglBatas-error">
                                    <small>Batas Kontrak harus diisi...!</small>
                                </span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <div class="hr-line-dashed"></div>
                            <div class="sembunyikan" style="display: none">
                                <table class="table table-bordered table-striped pilihMitraPekerja table-hover" id="pilihMitraPekerja">
                                    <thead>
                                    <th>
                                        <input type="checkbox" class="setCek" onclick="cekAll()">
                                    </th>
                                    {{-- <th>NIK</th> --}}
                                    <th>Nama Pekerja</th>
                                    <th>Usia</th>
                                    <th>Alamat</th>
                                    <th>No Hp</th>
                                    <th>Pendidikan</th>

                                    </thead>
                                    <tbody>
                                    @foreach($pekerja as $index => $data)
                                        <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                                            <td>
                                                <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$data->p_id}}">
                                            </td>
                                            <td>{{$data->p_name}}</td>
                                            <td>{{$data->p_sex}}</td>
                                            <td>{{$data->p_address}}</td>
                                            <td>{{$data->p_hp}}</td>
                                            <td>{{$data->p_education}}</td>
                                        </tr>
                                    @endforeach

                                    <tbody>
                                </table>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                        <a href="{{url('manajemen-pekerja-mitra/data-pekerja-mitra')}}"
                                           class="btn btn-danger btn-flat" type="button">Kembali</a>
                                        <button class="ladda-button ladda-button-demo btn btn-primary btn-outline btn-flat simpan"
                                                type="submit" {{-- onclick="simpan()" --}}>
                                            Lanjutkan
                                        </button>
                                    </div>
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
        var totalpekerja = 0;
        $("select[name='divisi']").val('{{ $b->md_name or ''}}')

        $('#mp_selection_date').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        }).datepicker("setDate", "0");
        $('#mp_workin_date').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        }).datepicker("setDate", "0");

        table = $("#pilihMitraPekerja").DataTable({
    "processing": true,
    "paging": true,
    "searching": true,
    "deferLoading": 57,
    responsive: true,
    "language": dataTableLanguage
  });

        table
            .column( '1:visible' )
            .order( 'asc' )
            .draw();

        $('#kontrak').select2();

        var countchecked = 0;

        function cekAll() {

            if ($('.setCek').is(":checked")) {
                table.$('input[name="pilih[]"]').prop("checked", true);
                //table.$('input[name="pilih[]"]').css('background','red');
                table.$('.chek-all').val('1');
            } else {
                table.$('input[name="pilih[]"]').prop("checked", false);
                table.$('.chek-all').val('');
            }
            hitung();
            //hitungSelect();
        }

        function hitung() {
            countchecked = table.$("input[name='pilih[]']:checked").length;
            $('#totalPekerja').val(parseInt(countchecked) + parseInt(totalpekerja));
        }

        function hitungSelect() {
            for (i = 0; i <= table.$('tr').length; i++)
                if (table.$('.pilih-' + i).is(":checked")) {
                    table.$('.select-' + i).css('background', '#bbc4d6')
                    //table.$('.select-'+i).css('color','white')
                } else {
                    table.$('.select-' + i).css('background', '')
                }
        }

        function selectBox(id) {
            if (table.$('.pilih-' + id).is(":checked")) {
                table.$('.pilih-' + id).prop("checked", false);
                table.$('.chek-' + id).val('1');
            } else {
                table.$('.pilih-' + id).prop("checked", true);
                table.$('.chek-' + id).val('');
            }
            //hitungSelect();
            hitung();
        }

        function select(id) {
            if (table.$('.pilih-' + id).is(":checked")) {
                table.$('.pilih-' + id).prop("checked", false);
                table.$('.chek-' + id).val('');
            } else {
                table.$('.pilih-' + id).prop("checked", true);
                table.$('.chek-' + id).val('1');
            }
            //hitungSelect();
            hitung();
        }


        var info = $('.pesan');
        /*$('#tglKontrak').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        }).datepicker("setDate", "0");
        $('#tglBatas').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        }).datepicker("setDate", "0");*/

        var config = {
            '.chosen-select-deselect': {allow_single_deselect: true},
            //'.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text: 'Data Tidak Ditemukan'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

        function cekMitraComp() {
            waitingDialog.show();
            var mitra = $("#kontrak").find('option:selected').data('mitra');

            var contractid = $("#kontrak").find('option:selected').data('contractid');

            var token = "{{csrf_token()}}";
            $.ajax({
                url: baseUrl + '/get-data-mitra-kontrak/' + mitra + '/' + contractid,
                type: 'post',
                data: {_token:token},
                dataType: 'json',
                success: function (response) {
                    waitingDialog.hide();
                    if (response.status == 'berhasil') {
                        $('#tglKontrak').val(response.data.mc_date);
                        $('#tglBatas').val(response.data.mc_expired);
                        $('#perusahaan').val(response.data.c_name);
                        $('#mitra').val(response.data.m_name);
                        $('#divisi').val(response.data.md_name);
                        $('#jumlahPekerja').val(response.data.mc_need);
                        $('.sembunyikan').css('display', '');
                        $('#mc_contractid').val(response.data.mc_contractid);
                        $('#perusahaan').data('perusahaan', response.data.mc_comp);
                        $('#mitra').data('input-mitra', response.data.mc_mitra);
                        $('#divisi').data('input-divisi', response.data.mc_divisi);
                        $('#totalPekerja').val(response.data.mc_fulfilled);
                        totalpekerja = response.data.mc_fulfilled;
                    }
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
                    waitingDialog.hide();
                }
            });
        }

        function simpan() {
            waitingDialog.show();
            var kontrak = $('#kontrak').val();
            var totalPekerja = $('#totalPekerja').val();
            var buttonLadda = $('.simpan').ladda();
            buttonLadda.ladda('start');
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
                url: baseUrl + '/manajemen-pekerja-mitra/data-pekerja-mitra/lanjut',
                // type        : 'post',
                type: 'post',
                data: ar.find('input').serialize()
                + '&kontrak=' + kontrak
                + '&totalPekerja=' + totalPekerja
                + '&' + $('#form-mitra-contract').serialize(),
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    waitingDialog.hide();
                    if (response.status == 'berhasil') {
                        window.location = baseUrl + '/manajemen-pekerja-mitra/data-pekerja-mitra';
                    } else if (response.status == 'gagal') {
                        info.css('display', '');
                        $.each(response.data, function (index, error) {
                            info.find('ul').append('<li>' + error + '</li>');
                        });
                        buttonLadda.ladda('stop');
                    }

                    waitingDialog.hide();

                }
                ,
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
                    buttonLadda.ladda('stop');
                }
            });
//        } else {
//            buttonLadda.ladda('stop');
//        }
        }

        function validateForm() {
            $('.reset').css('display', 'none');

            var tglKontrak = document.getElementById('tglKontrak');
            var tglBatas = document.getElementById('tglBatas');
            var kontrak = document.getElementById('kontrak');
            var perusahaan = document.getElementById('perusahaan');
            var mitra = document.getElementById('mitra');
            var jumlahPekerja = document.getElementById('jumlahPekerja');

            //alert(username.value);

            if (tglKontrak.validity.valueMissing) {
                $('#tglKontrak-error').css('display', '');
                return false;
            }
            else if (tglBatas.validity.valueMissing) {
                $('#tglBatas-error').css('display', '');
                return false;
            }
            else if (kontrak.validity.valueMissing) {
                $('#kontrak-error').css('display', '');
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
            else if (jumlahPekerja.validity.valueMissing) {
                $('#jumlahPekerja-error').css('display', '');
                return false;
            }


            return true;
        }

        $('#form-mitra-contract').on('submit', function(e){
            table.search('');
            table.draw();
            var form = this;

              // Encode a set of form elements from all pages as an array of names and values
            var params = table.$('input,select,textarea').serializeArray();

              // Iterate over all form elements
            $.each(params, function(){
                 // If element doesn't exist in DOM
                 if(!$.contains(document, form[this.name])){
                    // Create a hidden element
                    $(form).append(
                       $('<input>')
                          .attr('type', 'hidden')
                          .attr('name', this.name)
                          .val(this.value)
                    );
                }
            });
        });


    </script>
@endsection
