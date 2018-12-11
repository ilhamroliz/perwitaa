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
                <strong>Edit data pembelian</strong>
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
                        <h5>Edit pembelian nota: {{ $nota }}</h5>
                    </div>

                    <div class="ibox-content">
                        <form role="form" class="form-inline">
                            <div class="form-group col-md-7">
                                <label for="namabarang" class="sr-only">Nama Barang</label>
                                <input type="text" placeholder="Masukan Nama Barang" id="namabarang" class="form-control" style="width: 100%;">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="qty" class="sr-only">Qty</label>
                                <input type="text" placeholder="Kuantitas" id="qty" class="form-control" style="width: 100%;" onkeypress="saatEnter(this, event)">
                            </div>
                            <button class="btn btn-info" type="button" onclick="tambah()">Tambahkan</button>
                            <div class="table-responsive" style="margin-top: 30px;">
                                <table class="table table-striped table-bordered table-hover" id="tabelitem">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Nama Barang</th>
                                            <th style="width: 10%;">Qty</th>
                                            <th style="width: 15%;">Harga @</th>
                                            <th style="width: 15%;">Diskon (Rp)</th>
                                            <th style="width: 15%;">Total</th>
                                            <th style="width: 5%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $index=>$row)
                                        <tr>
                                            <td>{{ $row->nama }}<input type="hidden" name="id[]" value="{{ $row->i_id }}" class="form-control iditem iditem{{ $index }}"><input type="hidden" name="iddt[]" value="{{ $row->id_detailid }}" class="form-control iddt iddt{{ $index }}"></td>
                                            <td><input type="text" name="qty[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $row->pd_qty }}" class="form-control qty qty{{ $index }}" style="width: 100%;" onkeyup="hitungtotal(this, event, 'qty')" onblur="onBlurQty(this, event)"></td>
                                            <td><input type="text" name="harga[]" value="{{ number_format($row->pd_value, 0, ',', '.') }}" class="form-control harga harga{{ $index }}" style="width: 100%;" onkeyup="hitungtotal(this, event, 'harga')" onblur="hitungtotal(this, event, 'harga')"></td>
                                            <td><input type="text" name="disc[]" value="{{ number_format($row->pd_disc_value, 0, ',', '.') }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control disc disc{{ $index }}" style="width: 100%;" onkeyup="hitungtotal(this, event, \'diskon\')" onblur="hitungtotal(this, event, 'diskon')"></td>
                                            <td><input type="text" name="total[]" value="{{ number_format($row->pd_value * $row->pd_qty, 0, ',', '.') }}" class="form-control total total{{ $index }}" style="width: 100%;" readonly></td>
                                            <td><div class="text-center"><button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs btnhapus btnhapus{{ $index }}" ><i class="glyphicon glyphicon-trash"></i></button></div></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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
                                Rp. {{ number_format($row->p_total_net, 0, ',', '.') }}
                            </h2>

                            <hr>
                            <select class="form-control chosen-select-width" name="supplier" style="width:100%" id="supplier" onchange="getSupplier()">
                                <option value="" disabled selected>--Pilih Supplier--</option>
                                @foreach($supplier as $supplier)
                                @if($supplier->s_id == $data[0]->p_supplier)
                                <option value="{{ $supplier->s_id }}" selected> {{ $supplier->s_company }} </option>
                                @else
                                <option value="{{ $supplier->s_id }}"> {{ $supplier->s_company }} </option>
                                @endif
                                @endforeach
                            </select>
                            <span class="text-muted small">
                                *Jika supplier tidak ditemukan, cobalah ganti supplier menjadi "Aktif"
                            </span>

                            <div class="m-t-sm">
                                <div class="btn-group">
                                <button onclick="simpan()" class="btn btn-primary btn-outline btn-sm"><i class="fa fa-shopping-cart"></i> Simpan</button>
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

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var tablepembelian;
    var dataitem;
    var hitung = 0;
    var notaPublic = "{{ $nota }}";
    $( document ).ready(function() {
        tablepembelian = $("#tabelitem").DataTable({
            responsive: true,
            paging: false,
            searching: false,
            "ordering": false,
            "language": dataTableLanguage,
            "columnDefs": [
                { "orderable": false, "targets": 5 }
              ]
        });

        $("#supplier").chosen();

        $( "#namabarang" ).autocomplete({
            source: baseUrl+'/manajemen-pembelian/getItem',
            minLength: 2,
            select: function(event, ui) {
                $('#namabarang').val(ui.item.label);
                tanam(ui.item);
                $('#qty').focus();
            }
        });

        @if (isset($data))
            @foreach ($data as $i=>$info)
                $(".btnhapus{{ $i }}").click(function(){
                    tablepembelian
                        .row( $(this).parents('tr') )
                        .remove()
                        .draw();

                    hapus();
                });

                $(".harga{{ $i }}").maskMoney({
                    allowNegative: false,
                    thousands:'.',
                    decimal:',',
                    precision: 0,
                    affixesStay: false
                });

                $(".disc{{ $i }}").maskMoney({
                    allowNegative: false,
                    thousands:'.',
                    decimal:',',
                    precision: 0,
                    affixesStay: false
                });

                hitung = {{ $i }};
            @endforeach
        @endif

        $('#namabarang').focus();

        getSupplier();

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

    function tanam(data){
        dataitem = data;
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

        var data = dataitem;
        var qty = $('#qty').val();
        var total = qty * data.harga;
        var harga = accounting.formatMoney(data.harga, "", 0, ".", ",");
        total = accounting.formatMoney(total, "", 0, ".", ",");

        var id = document.getElementsByClassName( 'iditem' ),
          idItem  = [].map.call(id, function( input ) {
              return input.value;
        });

        var dt = document.getElementsByClassName( 'iddt' ),
          iddt  = [].map.call(dt, function( input ) {
              return input.value;
        });

        for (var i = 0; i < idItem.length; i++) {
            if (idItem[i] == data.id && iddt[i] == data.detailid) {
                var kuantitas = $('input.qty:text:eq('+i+')').val();
                qty = parseInt(qty);
                kuantitas = parseInt(kuantitas);
                qty = qty + kuantitas;
                $('input.qty:text:eq('+i+')').val(qty);
                $('#namabarang').val('');
                $('#qty').val('');
                hitungtotal();
                return false;
            }
        }

        tablepembelian.row.add([
               data.label+'<input type="hidden" name="id[]" value="'+data.id+'" class="form-control iditem iditem'+hitung+'"><input type="hidden" name="iddt[]" value="'+data.detailid+'" class="form-control iddt iddt'+hitung+'">',
               '<input type="text" name="qty[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="'+qty+'" class="form-control qty qty'+hitung+'" style="width: 100%;" onkeyup="hitungtotal(this, event, \'qty\')" onblur="onBlurQty(this, event)">',
               '<input type="text" name="harga[]" value="'+harga+'" class="form-control harga harga'+hitung+'" style="width: 100%;" onkeyup="hitungtotal(this, event, \'harga\')" onblur="hitungtotal(this, event, \'harga\')">',
               '<input type="text" name="disc[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control disc disc'+hitung+'" style="width: 100%;" onkeyup="hitungtotal(this, event, \'diskon\')" onblur="hitungtotal(this, event, \'diskon\')">',
               '<input type="text" name="total[]" value="'+total+'" class="form-control total total'+hitung+'" style="width: 100%;" readonly>',
               buttonGen()
            ]).draw( false );
        $('#namabarang').val('');
        $('#qty').val('');

        $(".btnhapus").click(function(){
            tablepembelian
                .row( $(this).parents('tr') )
                .remove()
                .draw();

            hapus();
            hitungtotal();
        });

        $(".harga"+hitung).maskMoney({
            allowNegative: false,
            thousands:'.',
            decimal:',',
            precision: 0,
            affixesStay: false
        });

        $(".disc"+hitung).maskMoney({
            allowNegative: false,
            thousands:'.',
            decimal:',',
            precision: 0,
            affixesStay: false
        });
        hitungtotal();
        hitung = hitung + 1;
        updateItems();
    }

    function updateItems(){
        var qty = document.getElementsByClassName( 'qty' ),
            names  = [].map.call(qty, function( input ) {
                return input.value;
        });
        $('.items').val(names.length);
        $('.jumlahitem').html(names.length);
    }

    function hapus(){
        hitung = hitung - 1;
        updateItems();
    }

    function buttonGen(){
        var buton = '<div class="text-center"><button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs btnhapus btnhapus" ><i class="glyphicon glyphicon-trash"></i></button></div>'
        return buton;
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
            url: baseUrl + '/manajemen-pembelian/update',
            type: 'post',
            data: ar.find('input').serialize()+'&supplier='+supplier+'&nota='+notaPublic,
            success: function(response){
                if (response.status == 'sukses') {
                    waitingDialog.hide();
                    swal({
                        title: "Sukses",
                        text: "Data sudah tersimpan",
                        type: "success"
                    }, function () {
                      window.location.reload();
                      var myWindow = window.open(''+baseUrl+'/manajemen-seragam/printnota?nota='+response.nota,'','width=700,height=500');
                    });
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
