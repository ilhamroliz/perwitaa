@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    option selected {
        padding-left: 8px;
    }
</style>

@endsection

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Edit Seragam</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            @if(Session::has('sukses'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ Session::get('sukses') }}</strong>
                </div>
            @elseif(Session::has('gagal'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ Session::get('gagal') }}</strong>
                </div>
            @endif
            <form method="get" class="form-horizontal" action="{{ url('master-item/update') }}">
                {{ Form::token() }}
                <div class="form-group"><label class="col-sm-2 control-label" for="namabarang">Nama</label>
                    <div class="col-sm-10">
                        <input value="{{ $data[0]->nama }}" type="text" class="form-control" name="nama" id="namabarang" style="text-transform: uppercase" required>
                        <input value="{{ $data[0]->i_id }}" type="hidden" class="form-control" name="id" id="id" style="text-transform: uppercase" >
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="warnabarang">Warna</label>
                    <div class="col-sm-3">
                        <input type="text" value="{{ $data[0]->warna }}" class="form-control" name="warna" id="warnabarang" style="text-transform: uppercase" required>
                    </div>
                    <label class="col-sm-1 control-label" for="kategoribarang">Kategori</label>
                    <div class="col-sm-3">
                        <select class="form-control KategoriSelect select2" name="kategori">
                          @foreach($kategori as $item)
                            @if($item->k_id == $data[0]->k_id)
                                <option value="{{ $item->k_id }}" selected>{{ $item->k_nama }}</option>
                            @else
                                <option value="{{ $item->k_id }}">{{ $item->k_nama }}</option>
                            @endif
                          @endforeach
                        </select>
                    </div>
                    <label class="col-sm-1 control-label" for="satuanbarang">Satuan</label>
                    <div class="col-sm-2">
                        <select class="form-control SatuanSelect select2" name="satuan">
                          @foreach($satuan as $item)
                            @if($item->s_id == $data[0]->s_id)
                                <option value="{{ $item->s_id }}" selected>{{ $item->s_nama }}</option>
                            @else
                                <option value="{{ $item->s_id }}">{{ $item->s_nama }}</option>
                            @endif
                          @endforeach
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-dinamis">
                    @foreach($data as $index=>$data)
                    <div class="form-group getkonten{{ $index }}">
                        <label class="col-sm-2 control-label" for="ukuranbarang">Ukuran</label>
                        <div class="col-sm-3 selectukuran{{ $index }}">
                            <select onchange="validasi(this, event)" class="form-control UkuranSelect{{ $index }} select2 ukuransize" name="ukuran[]" style="display: block;">
                              @foreach($ukuran as $item)
                                @if($data->ukuran == $item->s_id)
                                    <option value="{{ $item->s_id }}" selected>{{ $item->s_nama }}</option>
                                @else
                                    <option value="{{ $item->s_id }}">{{ $item->s_nama }}</option>
                                @endif
                              @endforeach
                            </select>
                        </div>
                        <label class="col-sm-1 control-label" for="hargabarang">Harga</label>
                        <div class="col-sm-3">
                            <input value="Rp. {{ number_format($data->harga, 0, ',', '.') }}" type="text" class="form-control hargamask" name="harga[]" id="hargabarang" style="text-align: right;" required>
                        </div>
                        <span>
                            <a onclick="tambah()" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                            @if($index == 0)
                                <a onclick="minus('jangan')" type="button" class="btn btn-danger"><i class="fa fa-times"></i></a>
                            @else
                                <a onclick="minus('getkonten{{ $index }}')" type="button" class="btn btn-danger"><i class="fa fa-times"></i></a>
                            @endif
                        </span>
                    </div>
                    @endforeach
                </div>
                <div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for=""></label>
                        <div class="col-sm-3">
                            <p style="color: red; display: none;" class="peringatan">Terdapat ukuran barang yang sama</p>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed" style="margin-top: -10px;"></div>
                <div class="form-group">
                    <div class="col-sm-4" style="float: right;">
                        <button class="btn btn-primary btn-outline simpan" type="submit" style="float: right;">Update Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@section('extra_scripts')
<script type="text/javascript">
var count = {{ $hitung }};
$( document ).ready(function() {
    $('.KategoriSelect').select2();
    $('.SatuanSelect').select2();
    @for ($i = 0; $i < $hitung; $i++)
        $('.UkuranSelect'+{{ $i }}).select2();
    @endfor
    $('#hargabarang').maskMoney({
        prefix: 'Rp. ',
        decimal: ',',
        thousands: '.',
        precision: 0
    });
    $('.hargamask').maskMoney({
        prefix: 'Rp. ',
        decimal: ',',
        thousands: '.',
        precision: 0
    });
});

function setSelect2(klas){
    $('.'+klas).select2();
}

function setMaskMoney(id){
    $('#'+id).maskMoney({
        prefix: 'Rp. ',
        decimal: ',',
        thousands: '.',
        precision: 0
    });
}

function tambah(){
    count = count + 1;
    var konten = '<div class="form-group getkonten'+count+'">'+
                        '<label class="col-sm-2 control-label" for="ukuranbarang">Ukuran</label>'+
                        '<div class="col-sm-3 selectukuran'+count+'">'+
                            '<select onchange="validasi(this, event)" class="ukuransize form-control UkuranSelect'+count+' select2" name="ukuran[]" style="display: block;">'+
                              '@foreach($ukuran as $item)'+
                                '<option value="{{ $item->s_id }}">{{ $item->s_nama }}</option>'+
                              '@endforeach'+
                            '</select>'+
                            /*'<span class="input-group-btn">'+
                                '<button type="button" class="btn btn-primary" onclick="gantiI(\''+count+'\')" style="height: 34px;"><i class="fa fa-plus"></i></button>'+
                            '</span>'+*/
                        '</div>'+
                        '<label class="col-sm-1 control-label" for="hargabarang">Harga</label>'+
                        '<div class="col-sm-3">'+
                            '<input type="text" class="form-control hargamask" name="harga[]" id="hargabarang'+count+'"  style="text-align: right;" required>'+
                        '</div>'+
                        '<span>'+
                            '<a onclick="tambah()" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></a>'+
                            '<a onclick="minus(\'getkonten'+count+'\')" type="button" class="btn btn-danger" style="margin-left: 3px;"><i class="fa fa-times"></i></a>'+
                        '</span>'+
                    '</div>';
    $('.form-dinamis').append(konten);
    setSelect2('UkuranSelect'+count);
    setMaskMoney('hargabarang'+count);
    controlValidasi();
}

function minus(klas){
    if (klas == 'jangan') {
        alert('tidak boleh dihapus');
    } else {
        $('.'+klas).remove();
    }
    controlValidasi();
}

function gantiS(hitung){
    $('.konteninput'+hitung).remove();
    var select = drawSelect(hitung);
    $('.selectukuran'+hitung).append(select);
    setSelect2('UkuranSelect'+hitung);
}

function gantiI(hitung){
    $('.konteninput'+hitung).remove();
    var input = drawInput(hitung);
    $('.selectukuran'+hitung).append(input);
}

function drawInput(hitung){
    var input = '<div class="input-group konteninput'+hitung+'">'+
                '<input type="text" name="ukuran[]" class="form-control UkuranInput'+hitung+'" required>'+
                '<span class="input-group-btn">'+
                    '<button type="button" class="btn btn-primary" onclick="gantiS(\''+hitung+'\')" style=""><i class="fa fa-plus"></i></button>'+
                '</span>'+
                '</div>';
    return input;
}

function drawSelect(hitung){
    var select = '<div class="input-group konteninput'+hitung+'">'+
                                '<select class="form-control UkuranSelect'+hitung+' select2 ukuransize" name="ukuran[]" style="display: block;">'+
                                  '@foreach($ukuran as $item)'+
                                    '<option value="{{ $item->s_id }}">{{ $item->s_nama }}</option>'+
                                  '@endforeach'+
                                '</select>'+
                                '<span class="input-group-btn">'+
                                    '<button type="button" class="btn btn-primary" onclick="gantiI(\''+hitung+'\')" style="height: 34px;"><i class="fa fa-plus"></i></button>'+
                                '</span>'+
                            '</div>';
    return select;
}

$(document).keypress(
    function(event){
     if (event.which == '13') {
        event.preventDefault();
      }
});

function controlValidasi(){
    var getSize = null;
    var inputs = document.getElementsByClassName( 'ukuransize' ),
        names  = [].map.call(inputs, function( input ) {
            return input.value;
        });
    getSize = names;
    var hasil = 'hide';
    for (var i = 0; i < getSize.length; i++) {
        for (var j = 0; j < getSize.length; j++) {
            if (i != j && getSize[i] == getSize[j]) {
                hasil = 'show';
            }
        }
    }
    if (hasil == 'show') {
        $('.peringatan').show();
        $('.simpan').attr('disabled', true);
    } else if (hasil == 'hide'){
        $('.peringatan').hide();
        $('.simpan').prop('disabled', false);
    }
}

function validasi(inField, e){
    var getIndex = $('select.ukuransize').index(inField);
    var getSize = null;
    var inputs = document.getElementsByClassName( 'ukuransize' ),
        names  = [].map.call(inputs, function( input ) {
            return input.value;
        });
    getSize = names;
    var hasil = 'hide';
    for (var i = 0; i < getSize.length; i++) {
        if (getSize[i] == getSize[getIndex] && i != getIndex) {
            hasil = 'show';
        }
    }

    if (hasil == 'show') {
        $('.peringatan').show();
        $('.simpan').attr('disabled', true);
    } else if (hasil == 'hide'){
        $('.peringatan').hide();
        $('.simpan').prop('disabled', false);
    }
}

</script>
@endsection
