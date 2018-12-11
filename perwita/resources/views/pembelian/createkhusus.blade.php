@extends('main')

@section('title', 'Pembelian Seragam')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    table.dataTable tbody td {
      vertical-align: middle;
    }

</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Tambah data pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li>
                Pembelian Seragam
            </li>
            <li class="active">
                <strong>Tambah data pembelian</strong>
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
                        <input type="hidden" class="items" value="0">
                        <h5>Barang yang dibeli</h5>
                    </div>

                    <div class="ibox-content">
                        <form role="form" class="form-inline row">
                            <div class="form-group col-md-12">
                                <label for="namabarang" class="sr-only">Nama Barang</label>
                                <select class="form-control select2" style="width:100%;" name="nota" onchange="tanam()" id="nota">
                                  <option value=""> - Pilih Nota Rencana Pembelian - </option>
                                  @foreach ($nota as $key => $value)
                                    <option value="{{$value->pp_nota}}">{{$value->pp_nota}}</option>
                                  @endforeach
                                </select>
                            </div>

                            <div class="table-responsive col-md-12" style="margin-top: 30px;">
                                <table class="table table-striped table-bordered table-hover" id="tabelitem">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Nama Barang</th>
                                            <th style="width: 10%;">Qty</th>
                                            <th style="width: 15%;">Harga @</th>
                                            <th style="width: 15%;">Diskon (Rp)</th>
                                            <th style="width: 20%;">Total</th>
                                        </tr>
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
                            <h5>Info Pembelian</h5>
                        </div>
                        <div class="ibox-content">
                            <span>
                                Total
                            </span>
                            <h2 class="font-bold totalpembelian">
                                Rp. 0
                            </h2>

                            <hr>
                            <select class="form-control chosen-select-width" name="supplier" style="width:100%" id="supplier" onchange="getSupplier()">
                                <option value="" disabled selected>--Pilih Supplier--</option>
                                @foreach($supplier as $supplier)
                                <option value="{{ $supplier->s_id }}"> {{ $supplier->s_company }} </option>
                                @endforeach
                            </select>
                            <span class="text-muted small">
                                *Jika supplier tidak ditemukan, cobalah ganti supplier menjadi "Aktif"
                            </span>

                            <div class="m-t-sm">
                                <div class="btn-group">
                                <button onclick="simpan()" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Simpan</button>
                                <a href="{{ url('/manajemen-seragam/pembelian') }}" class="btn btn-white btn-sm"> Batal</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="infosupp">Info Supplier</h5>
                        </div>
                        <div class="ibox-content text-center">
                            <h3 class="telpsupp"><i class="fa fa-phone"></i> </h3>
                            <span class="small">
                                Hubungi supplier untuk mengetahui barang yang tersedia
                            </span>
                        </div>
                    </div>
                </div>
        </div>
</div>

{{-- <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-truck modal-icon"></i>
                <h4 class="modal-title">Tambah Data Supplier</h4>
                <small class="font-bold">Data supplier ini digunakan untuk pembelian barang di fitur Pembelian</small>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" class="btn btn-primary" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div> --}}

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var tablepembelian;
    var dataitem;
    var hitung = 0;

    $( document ).ready(function() {

        $('.select2').select2();

        tablepembelian = $("#tabelitem").DataTable({
            responsive: true,
            paging: false,
            searching: false,
            "ordering": false,
            "language": dataTableLanguage,
        });

        $("#supplier").chosen();

        // $( "#namabarang" ).autocomplete({
        //     source: baseUrl+'/manajemen-seragam/getnotarencana',
        //     minLength: 2,
        //     select: function(event, ui) {
        //         $('#namabarang').val(ui.item.label);
        //         tanam(ui.item);
        //         $('#namabarang').focus();
        //     }
        // });

        $('#namabarang').focus();

    });

    function saatEnter(inField, e) {
        var charCode;
        if (e && e.which) {
            charCode = e.which;
        } else if (window.event) {
            e = window.event;
            charCode = e.keyCode;
        }
        if (charCode == 13) {
            tambah();
            $('#namabarang').focus();
        }
    }

    function tanam(){
        waitingDialog.show();
        nota = $('#nota').val();
        $.ajax({
            url: baseUrl + '/manajemen-seragam/getnotarencana/detail',
            type: 'get',
            data: {nota: nota},
            success: function(response){
                tablepembelian.clear();
                var data = response;
                var akhir = 0;
                for (var i = 0; i < data.length; i++) {
                    data[i].total = Number(data[i].total);
                    akhir += data[i].total;
                    var harga = accounting.formatMoney(data[i].id_price, "", 0, ".", ",");
                    var total = accounting.formatMoney(data[i].total, "", 0, ".", ",");
                    tablepembelian.row.add([
                        data[i].nama+'<input type="hidden" name="id[]" value="'+data[i].i_id+'" class="form-control iditem"><input type="hidden" name="iddt[]" value="'+data[i].id_detailid+'" class="form-control iddt iddt">',
                        '<input type="text" name="qty[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="'+data[i].ppd_qty+'" class="form-control qty" style="width: 100%;" readonly>',
                        '<input type="text" name="harga[]" value="'+harga+'" class="form-control harga harga'+i+'" style="width: 100%;" onkeyup="hitungtotal(this, event, \'harga\')" onblur="hitungtotal(this, event, \'harga\')">',
                        '<input type="text" name="disc[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control disc disc'+i+'" style="width: 100%;" onkeyup="hitungtotal(this, event, \'diskon\')" onblur="hitungtotal(this, event, \'diskon\')">',
                        '<input type="text" name="total[]" value="'+total+'" class="form-control total" style="width: 100%;" readonly>'
                    ]).draw( false );

                    $(".harga"+i).maskMoney({
                        allowNegative: false,
                        thousands:'.',
                        decimal:',',
                        precision: 0,
                        affixesStay: false
                    });

                    $(".disc"+i).maskMoney({
                        allowNegative: false,
                        thousands:'.',
                        decimal:',',
                        precision: 0,
                        affixesStay: false
                    });

                    hitung = i + 1;
                    $('.jumlahitem').html(i + 1);
                }
                akhir = accounting.formatMoney(akhir, "", 0, ".", ",");
                $('.totalpembelian').html('Rp. '+akhir);
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
            }
        })
    }

    function hitungtotal(inField, e, jenis){
        var getIndex;
        if (jenis == 'harga') {
            getIndex = $('input.harga:text').index(inField);
        } else if (jenis == 'qty') {
            getIndex = $('input.qty:text').index(inField);
        } else if(jenis == 'diskon'){
            getIndex = $('input.disc:text').index(inField);
        }
        var permintaan = $('input.qty:text:eq('+getIndex+')').val();
        var harga = $('input.harga:text:eq('+getIndex+')').val();
        var disc = $('input.disc:text:eq('+getIndex+')').val();

        harga = convertToAngka(harga);
        disc = convertToAngka(disc);

        if (isNaN(disc) || disc < 1) {
            disc = 0;
            $('input.disc:text:eq('+getIndex+')').val(0);
        }
        if (isNaN(harga) || harga < 1) {
            harga = 0;
            $('input.harga:text:eq('+getIndex+')').val(0);
        }

        var total = (harga * permintaan) - disc;
        total = accounting.formatMoney(total, "", 0, ".", ",");
        $('input.total:text:eq('+getIndex+')').val(total);

        totalPembelian();
    }

    function totalPembelian(){
        var totalpembelian = document.getElementsByClassName( 'total' ),
          names  = [].map.call(totalpembelian, function( input ) {
              return input.value;
        });

        var temp = 0;
        for (var i = 0; i < names.length; i++) {
            temp = temp + convertToAngka(names[i]);
        }

        $('.totalpembelian').html('Rp. '+convertToRupiah(temp));

    }

    function getSupplier(){
        var supplier = $('#supplier').val();
        $.ajax({
          url: baseUrl + '/master-supplier/getSupplier',
          type: 'get',
          data: {id: supplier},
          success: function(response){
            $('.telpsupp').html('<i class="fa fa-phone"></i> '+response.data[0].s_phone);
            $('.infosupp').html('Info Supplier ('+response.data[0].s_company+')')
          }, error:function(x, e) {
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

    function tambah(){

    }

    function onBlurQty(inField, e){
        var getIndex = $('input.qty:text').index(inField);
        var permintaan = $('input.qty:text:eq('+getIndex+')').val();
        if (isNaN(permintaan) || permintaan < 1) {
            permintaan = 1;
            $('input.qty:text:eq('+getIndex+')').val(1);
        }
        hitungtotal();
    }

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        var hasil = rupiah.split('',rupiah.length-1).reverse().join('');
        return hasil;

    }

    function convertToAngka(rupiah)
    {
        if (rupiah == null || rupiah == '') {
            return false;
        } else {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        }
    }

    function simpan(){
        var supplier = $('#supplier').val();
        if (supplier == null || supplier == '') {
            Command: toastr["warning"]("Supplier harus diisi", "Peringatan !")

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
        if (hitung == 0) {
            Command: toastr["warning"]("Barang masih kosong", "Peringatan !")

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
        waitingDialog.show();
        var nota = $('#nota').val();
        var ar = $();
        for (var i = 0; i < tablepembelian.rows()[0].length; i++) {
            ar = ar.add(tablepembelian.row(i).node());
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: baseUrl + '/manajemen-pembelian/simpan',
            type: 'post',
            data: ar.find('input').serialize()+'&supplier='+supplier+'&nota='+nota,
            success: function(response){
                if (response.status == 'sukses') {
                    var id = response.id;
                    waitingDialog.hide();
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
                    waitingDialog.hide();
                    swal({
                        title: "Gagal",
                        text: "Sistem gagal menyimpan data",
                        type: "error",
                        showConfirmButton: true,
                        timer: 2000
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
