@extends('main')

@section('title', 'Rencana Pembelian')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Rencana Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pembelian
            </li>
            <li>
                Rencana Pembelian
            </li>
            <li class="active">
                <strong>Tambah Rencana Pembelian</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Tambah Rencana Pembelian</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <div class="form-group col-md-7" style="margin-left: -15px;">
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
                                    <th style="width: 20%;">Harga @</th>
                                    <th style="width: 20%;">Total</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($info))
                                    @foreach ($info as $index=>$data)
                                        <tr>
                                            <td>{{ $data->nama }}<input type="hidden" name="id[]" value="{{ $data->i_id }}" class="form-control iditem iditem{{ $index }}"><input type="hidden" name="iddt[]" value="{{ $data->id_detailid }}" class="form-control iddt iddt{{ $index }}"></td>
                                            <td><input type="text" name="qty[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $data->ppd_qty }}" class="form-control qty qty{{ $index }}" style="width: 100%;" onkeyup="hitungtotal(this, event, 'qty')" onblur="onBlurQty(this, event)"></td>
                                            <td><input type="text" name="harga[]" value="{{ number_format($data->id_price, 0, ',', '.') }}" class="form-control harga harga{{ $index }}" style="width: 100%;" onkeyup="hitungtotal(this, event, 'harga')" onblur="hitungtotal(this, event, 'harga')"></td>
                                            <td><input type="text" name="total[]" value="{{ number_format($data->id_price * $data->ppd_qty, 0, ',', '.') }}" class="form-control total total{{ $index }}" style="width: 100%;" readonly></td>
                                            <td><div class="text-center"><button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs btnhapus btnhapus{{ $index }}" ><i class="glyphicon glyphicon-trash"></i></button></div></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <button onclick="simpan()" class="btn btn-primary btn-outline btn-sm pull-right">Update</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var tableplan;
    var dataitem;
    var hitung = 0;
    var notaPublic = "{{ $nota }}";
    $(document).ready(function(){
        tableplan = $("#tabelitem").DataTable({
            responsive: true,
            paging: false,
            searching: false,
            "ordering": false,
            "language": dataTableLanguage,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
              ]
        });

        $( "#namabarang" ).autocomplete({
            source: baseUrl+'/manajemen-pembelian/getItem',
            minLength: 2,
            select: function(event, ui) {
                $('#namabarang').val(ui.item.label);
                tanam(ui.item);
                $('#qty').focus();
            }
        });

        @if (isset($info))
            @foreach ($info as $i=>$info)
                $(".btnhapus{{ $i }}").click(function(){
                    tableplan
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
                var harga = $('input.harga:text:eq('+i+')').val();
                harga = convertToAngka(harga);
                $('input.total:text:eq('+i+')').val(accounting.formatMoney(harga * qty, "", 0, ".", ","));
                $('#namabarang').val('');
                $('#qty').val('');
                hitungtotal();
                return false;
            }
        }

        tableplan.row.add([
               data.label+'<input type="hidden" name="id[]" value="'+data.id+'" class="form-control iditem iditem'+hitung+'"><input type="hidden" name="iddt[]" value="'+data.detailid+'" class="form-control iddt iddt'+hitung+'">',
               '<input type="text" name="qty[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="'+qty+'" class="form-control qty qty'+hitung+'" style="width: 100%;" onkeyup="hitungtotal(this, event, \'qty\')" onblur="onBlurQty(this, event)">',
               '<input type="text" name="harga[]" value="'+harga+'" class="form-control harga harga'+hitung+'" style="width: 100%;" onkeyup="hitungtotal(this, event, \'harga\')" onblur="hitungtotal(this, event, \'harga\')">',
               '<input type="text" name="total[]" value="'+total+'" class="form-control total total'+hitung+'" style="width: 100%;" readonly>',
               buttonGen()
            ]).draw( false );
        $('#namabarang').val('');
        $('#qty').val('');

        $(".btnhapus").click(function(){
            tableplan
                .row( $(this).parents('tr') )
                .remove()
                .draw();

            hapus();
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
    }

    function buttonGen(){
        var buton = '<div class="text-center"><button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs btnhapus btnhapus" ><i class="glyphicon glyphicon-trash"></i></button></div>'
        return buton;
    }

    function hapus(){
        hitung = hitung - 1;
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
        waitingDialog.show();
        var ar = $();
        for (var i = 0; i < tableplan.rows()[0].length; i++) {
            ar = ar.add(tableplan.row(i).node());
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: baseUrl + '/manajemen-seragam/rencana-pembelian/update',
            type: 'post',
            data: ar.find('input').serialize()+'&nota='+notaPublic,
            success: function(response){
                if (response.status == 'sukses') {
                    waitingDialog.hide();
                    swal({
                        title: "Sukses",
                        text: "Data sudah tersimpan",
                        type: "success"
                    }, function () {
                      window.location.reload();
                      var myWindow = window.open(''+baseUrl+'/manajemen-seragam/rencana-pembelian/printwithnota?nota='+response.nota,'','width=700,height=500');
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
