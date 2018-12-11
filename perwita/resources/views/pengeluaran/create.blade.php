@extends('main')

@section('title', 'Pengeluaran Seragam')

@section('extra_styles')

    <style>
        .popover-navigation [data-role="next"] {
            display: none;
        }

        .popover-navigation [data-role="end"] {
            display: none;
        }

        table.dataTable tbody td {
            vertical-align: middle;
        }

    </style>

@endsection

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Tambah Data Pengeluaran Seragam</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li>
                    Pengeluaran
                </li>
                <li>
                    Pengeluaran Seragam
                </li>
                <li class="active">
                    <strong>Tambah data</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <span class="pull-right">(<strong class="jumlahitem">0</strong>) items</span>
                        <span class="pull-right" style="margin-right:15px">(<strong class="jumlahpekerja">0</strong>) Pekerja</span>
                        <h5>Pengeluaran Barang ke Mitra</h5>
                    </div>

                    <div class="ibox-content">
                        <form role="form" class="row">
                            <div class="form-group col-md-6">
                                <select class="form-control chosen-select-width" name="mitra" style="width:100%"
                                        id="mitra" onchange="getItem()">
                                    <option value="" disabled selected>--Pilih Mitra--</option>
                                    @foreach($mitra as $mitra)
                                        <option value="{{ $mitra->m_id }}"> {{ $mitra->m_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-5 divisi">
                                <select class="form-control chosen-select-width" name="divisi" style="width:100%"
                                        id="divisi" readonly>
                                    <option value=" ">--Pilih Divisi--</option>
                                </select>
                            </div>
                            <div class="form-group col-md-1">
                                <button class="btn btn-info lock" onclick="lock()" type="button"><i class="fa fa-lock"></i></button>
                                <button class="btn btn-info unlock" onclick="unlock()" type="button" style="display: none;"><i class="fa fa-unlock-alt"></i></button>
                            </div>
                            <input type="hidden" name="total" id="total">

                            <div class="hr-line-dashed col-md-12" style="margin-top: 20px;"></div>

                            <div class="form-group col-md-8" style="margin-top: 20px;">
                                <input type="text" name="cari" placeholder="Masukan Nama Barang" style="text-transform: uppercase;"  class="form-control" id="cariItem" onkeyup="setNull('s_id')" readonly>
                                <input type="hidden" class="s_id" name="s_id">
                            </div>
                            <div class="form-group col-md-3" style="margin-top: 20px;">
                                <input type="text" onkeyup="cekQty()" style="text-align: right;" name="setQty" class="form-control" id="setQty" placeholder="QTY" readonly>
                                <input type="hidden" class="s_qty" name="s_qty">
                            </div>
                            <div class="form-group col-md-1" style="margin-top: 20px;">
                                <button class="btn btn-primary tanam" onclick="tanam()" type="button" disabled><i class="fa fa-check"></i></button>
                            </div>

                            <div class="form-group col-md-12" style="">
                                <table class="table table-striped table-bordered table-hover" id="table-penjualan">
                                    <thead>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Harga @</th>
                                        <th></th>
                                    </thead>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Info Pengeluaran</h5>
                    </div>
                    <div class="ibox-content">
                            <span>
                                Total
                            </span>
                        <h2 class="font-bold totalpembelian" align="center">
                            Rp. 0
                        </h2>

                        <hr>

                        <span class="text-muted small">

                            </span>
                        <div class="m-t-sm">
                            <div class="btn-group">
                                <button onclick="simpan()" class="btn btn-primary btn-sm"> Simpan</button>
                                <a href="{{ url('manajemen-seragam/pengeluaran') }}" class="btn btn-white btn-sm">
                                    Batal</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5 class="infosupp">Info Mitra</h5>
                    </div>
                    <div class="ibox-content text-center">
                        <h3 class="telpmitra"></h3>
                        <span class="small">
                                Hubungi Mitra jika diperlukan
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var stock = [];
        var tablepenjualan;
        var data
        var nota = '{{ $nota }}';
        var publicHarga = 0;
        var totalPublic = 0;
        $(document).ready(function () {

            tablepenjualan = $("#table-penjualan").DataTable({
                paging: false,
                searching: false,
                "language": dataTableLanguage,
                "columnDefs": [
                    { "width": "50%", "targets": 0 },
                    { "width": "15%", "targets": 1 },
                    { "width": "25%", "targets": 2 },
                    { "width": "10%", "targets": 2 },
                ],
                ordering: false
            });

            $("#showinfo").hide();
            $("#mitra").chosen();

            if ($('#mitra').val() != null && $('#mitra').val() != '') {
                getItem();
            }

        });

        $("#setQty").keydown(function (e) {
        // Allow: backspace, delete, tab, escape
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 110]) !== -1 ||
         // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
             // let it happen, don't do anything
                return;
            }

            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }

            if (e.keyCode == 13) {
                if (parseInt($('#setQty').val()) == 0) {
                    Command: toastr["warning"]("Kuantitas tidak boleh 0", "Peringatan !")

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
                tanam();
            }
        });

        function cekQty(){
            var qty = parseInt($('.s_qty').val());
            var input = parseInt($('#setQty').val());

            if (input > qty) {
                $('#setQty').val(qty);
            }
        }

        function getItem() {
            waitingDialog.show();
            var mitra = $('#mitra').val();
            $.ajax({
                url: baseUrl + '/manajemen-penjualan/getItem',
                type: 'get',
                data: {mitra: mitra},
                success: function (response) {
                    $('.telpmitra').html('<i class="fa fa-phone"></i> ' + response.info.m_phone);
                    var divisi = '<select class="form-control chosen-select-width" name="divisi" style="width:100%" id="divisi">';
                    divisi = divisi + '<option value=" " selected>--Pilih Divisi--</option>';
                    var data = response.data;
                    for (var i = 0; i < response.divisi.length; i++) {
                        divisi += '<option value="' + response.divisi[i].md_id + '">' + response.divisi[i].md_name + '</option>';
                    }
                    $('.divisi').html(divisi);
                    waitingDialog.hide();
                }, error: function (x, e) {
                    waitingDialog.hide();
                    if (x.status == 0) {
                        alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                    } else if (x.status == 404) {
                        alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                    } else if (x.status == 500) {
                        alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                    } else if (e == 'parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if (e == 'timeout') {
                        alert('Request Time out. Harap coba lagi nanti');
                    } else {
                        alert('Unknow Error.\n' + x.responseText);
                    }
                }
            })
            waitingDialog.hide();
        }

        function lock(){
            var mitra = $('#mitra').val();
            var divisi = $('#divisi').val();

            $.ajax({
              type: 'get',
              data: {mitra:mitra, divisi:divisi},
              dataType: 'json',
              url: baseUrl + '/manajemen-seragam/countpekerja',
              success : function(response){
                $('.jumlahpekerja').text(response);
              }
            });
            if (mitra == null || divisi == null || mitra == ' ' || divisi == ' ') {
                Command: toastr["warning"]("Mitra dan Divisi tidak boleh kosong", "Peringatan !")

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
            } else {
                $('#mitra').chosen().chosenReadonly(true);
                $('.lock').hide();
                $('.unlock').show();
                $('#cariItem').prop('readonly', false);
                $('#setQty').prop('readonly', false);
                $('.tanam').prop('disabled', false);
                $('#divisi').prop('disabled', true);

                $( "#cariItem" ).autocomplete({
                    source: baseUrl+'/manajemen-penjualan/search/'+mitra,
                    minLength: 2,
                    select: function(event, data) {
                        setData(data);
                    }
                });
            }

        }

        function unlock(){
            $('#mitra').chosen().chosenReadonly(false);
            $('#divisi').prop('disabled', false);
            $('.unlock').hide();
            $('.lock').show();
            $('#cariItem').val('');
            $('#setQty').val('');
            $('.s_qty').val('');
            $('.s_id').val('');
            $('#cariItem').prop('readonly', true);
            $('#setQty').prop('readonly', true);
            $('.tanam').prop('disabled', true);
            tablepenjualan.clear().draw(false);
        }

        function setData(data){
            var idStock = data.item.id.s_id;
            var qty = data.item.id.s_qty;
            publicHarga = parseInt(data.item.id.id_price);
            $('.s_id').val(idStock);
            $('.s_qty').val(qty);
            $('#setQty').focus();
        }

        function setNull(klas){
            $('.'+klas).val('');
        }

        function tanam(){
            var idStock = $('.s_id').val();
            var qty = parseInt($('.s_qty').val());
            var setQty = parseInt($('#setQty').val());
            var nama = $('#cariItem').val();

            var myEle = document.getElementById("item-"+idStock);
            if(myEle){
                var qtyAwal = parseInt($('#setQty-'+idStock).val());
                var qtyAkhir = setQty + qtyAwal;
                if (qtyAkhir <= qty) {
                    $('#setQty-'+idStock).val(qtyAkhir);
                } else {
                    $('#setQty-'+idStock).val(qty);
                }
            } else {
                tablepenjualan.row.add( [
                    nama + '<input type="hidden" name="idStock[]" id="item-'+idStock+'" value="'+idStock+'">',
                    '<input type="text" style="width:100%;text-align:right;" class="form-control inqty" onblur="blurQty('+idStock+', '+qty+')" onkeyup="checkQty('+idStock+', '+qty+'), this.value=this.value.replace(/[^0-9]/g,\'\')" onkeypress="totoalHarga()" id="setQty-'+idStock+'" name="qty[]" value="'+setQty+'"><input type="hidden" id="qty-'+idStock+'" value="'+qty+'">',
                    '<div class="pull-right">Rp. '+ accounting.formatMoney(publicHarga, "", 0, ".", ",")+'</div><input type="hidden" id="harga-'+idStock+'" name="harga[]" value="'+publicHarga+'">',
                    '<div class="text-center"><button class="btn btn-danger btn-xs hapus-penjualan" id="hapus-penjualan" type="button" style=""><i class="fa fa-minus"></i></button></div>'
                ] ).draw( false );

                var values = [];
                var selectedVal;
                $(".inqty").each(function(i, sel){
                    selectedVal = $(sel).val();
                    values.push(selectedVal);
                });
                var jumlahitem = values.reduce(getSum);
                $('.jumlahitem').text(jumlahitem)
            }

            $('#cariItem').val('');
            $('#setQty').val('');
            $('#cariItem').focus();
            totoalHarga();
        }

        $('#table-penjualan').on( 'click', 'tbody tr .hapus-penjualan', function () {
            tablepenjualan.row( $(this).parents('tr') )
            .remove()
            .draw();
            totoalHarga();
        } );

        function checkQty(id, qty){
            var input = parseInt($('#setQty-'+id).val());
            id = parseInt(id);
            qty = parseInt(qty);
            if (input > qty) {
                Command: toastr["warning"]("Jumlah barang melebihi stock", "Peringatan!")

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
                $('#setQty-'+id).val(qty);
                totoalHarga();
                return false;
            }
            var values = [];
            var selectedVal;
            $(".inqty").each(function(i, sel){
                selectedVal = $(sel).val();
                values.push(selectedVal);
            });
            var jumlahitem = values.reduce(getSum);
            $('.jumlahitem').text(jumlahitem)
            totoalHarga();
        }

        function blurQty(id, qty){
            var input = parseInt($('#setQty-'+id).val());
            id = parseInt(id);
            qty = parseInt(qty);

            if (isNaN(input)) {
                $('#setQty-'+id).val(1);
                input = 1;
            }

            if (input == 0) {
                $('#setQty-'+id).val(1);
                input = 1;
            }
            var values = [];
            var selectedVal;
            $(".inqty").each(function(i, sel){
                selectedVal = $(sel).val();
                values.push(selectedVal);
            });
            var jumlahitem = values.reduce(getSum);
            $('.jumlahitem').text(jumlahitem)
            totoalHarga();
        }

        function totoalHarga(){
            var totalHarga = $("input[name='harga[]']").map(function(){return $(this).val();}).get();
            var totalQty = $("input[name='qty[]']").map(function(){return $(this).val();}).get();

            var total = 0;

            for(var j = 0; j < totalQty.length; j++){
                  var hasil = parseInt(totalHarga[j]) * parseInt(totalQty[j]);
                  total = hasil + total;
            }
            totalPublic = total;
            total = accounting.formatMoney(total, "", 0, ".", ",");
            $('.totalpembelian').html('Rp. ' + total);
        }

    function simpan(){
      var values = [];
      var selectedVal;
      $(".inqty").each(function(i, sel){
          selectedVal = $(sel).val();
          values.push(selectedVal);
      });
      var jumlahitem = values.reduce(getSum);
      var jumlahpekerja = $('.jumlahpekerja').text();

        if (parseInt(jumlahitem) != parseInt(jumlahpekerja)) {
          swal({
                  title: "Konfirmasi",
                  text: "Jumlah item tidak sama dengan jumlah pekerja, ingin melanjutkan?",
                  type: "warning",
                  // showCancelButton: true,
                  // closeOnConfirm: false,
                  showLoaderOnConfirm: true,
              });/*,
              function () {
                  swal.close();
                  waitingDialog.show();
        var ar = $();
        for (var i = 0; i < tablepenjualan.rows()[0].length; i++) {
            ar = ar.add(tablepenjualan.row(i).node());
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var mitra = $('#mitra').val();
        var divisi = $('#divisi').val();
        var total = totalPublic;
        $.ajax({
          url: baseUrl + '/manajemen-penjualan/save',
          type: 'get',
          data: ar.find('input').serialize()+'&'+ar.find('select').serialize()+'&mitra='+mitra+'&nota='+nota+'&total='+total+'&divisi='+divisi,
          success: function(response){
            waitingDialog.hide();
            if (response.status == 'sukses') {
              Command: toastr["success"]("Berhasil Disimpan, Menunggu approval manager!", "Info !")

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
              setTimeout(function () {
                window.location.reload();
              }, 3000);
            } else {
                swal({
                    title: "Gagal",
                    text: "Sistem gagal menyimpan data",
                    type: "error",
                    showConfirmButton: true
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
      });*/

        } else {
          waitingDialog.show();
        var ar = $();
        for (var i = 0; i < tablepenjualan.rows()[0].length; i++) {
            ar = ar.add(tablepenjualan.row(i).node());
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var mitra = $('#mitra').val();
        var divisi = $('#divisi').val();
        var total = totalPublic;
        $.ajax({
          url: baseUrl + '/manajemen-penjualan/save',
          type: 'get',
          data: ar.find('input').serialize()+'&'+ar.find('select').serialize()+'&mitra='+mitra+'&nota='+nota+'&total='+total+'&divisi='+divisi,
          success: function(response){
            waitingDialog.hide();
            if (response.status == 'sukses') {
              Command: toastr["success"]("Berhasil Disimpan, Menunggu approval manager!", "Info !")

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
              setTimeout(function () {
                location.reload();
              }, 1000);
            } else {
                swal({
                    title: "Gagal",
                    text: "Sistem gagal menyimpan data",
                    type: "error",
                    showConfirmButton: true
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
    }

    function getSum(total, num) {
    return parseInt(total) + parseInt(num);
    }

    </script>
@endsection
