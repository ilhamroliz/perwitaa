@extends('main')

@section('title', 'Dashboard')

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
        <h2>Edit data Pengeluaran Barang</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Pengeluaran
            </li>
            <li>
                Pengeluaran Barang
            </li>
            <li class="active">
                <strong>Edit data</strong>
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
                        <h5>Pengeluaran Barang ke Mitra</h5>
                    </div>

                    <div class="ibox-content">
                        <form role="form" class="form-inline row">
                            <div class="form-group col-md-4">
                                <select class="form-control chosen-select-width" name="mitra" style="width:100%" id="mitra" readonly>
                                <option value="{{$data[0]->sp_mitra}}" selected>{{$data[0]->m_name}}</option>
                            </select>
                            </div>
                            <div class="form-group col-md-4 divisi">
                                <select class="form-control chosen-select-width" name="divisi" style="width:100%" id="divisi" readonly>
                                    <option value="{{$data[0]->sp_divisi}}" selected>{{$data[0]->md_name}}</option>
                            </select>
                            </div>
                            <div class="form-group col-md-4 pilihseragam">
                                <select class="form-control chosen-select-width" name="seragam" style="width:100%" id="seragam" readonly>
                                    <option value="{{$data[0]->s_id}}">{{$data[0]->i_nama}} ({{$data[0]->i_warna}})</option>
                            </select>
                            </div>
                            <div class="table-responsive col-md-12" style="margin-top: 30px;">
                                <table class="table table-striped table-bordered table-hover" id="tabelitem">
                                    <thead>
                                        <tr>
                                            <th style="width: 60%;">Nama Pekerja</th>
                                            <th style="width: 20%;">NIK Mitra</th>
                                            <th style="width: 20%;">Ukuran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($pekerja as $x)
                                      <tr>
                                        <td>{{$x->p_name}} ({{$x->p_hp}})</td>
                                        <td>{{$x->p_nip}}</td>
                                        <td>
                                          <select class="form-control pilihukuran chosen-select-width index" name="ukuran[]" style="width:100%" id="ukuran" onchange="ambil()">
                                          @if($x->s_id == null)
                                          <option value="Tidak" selected> -- Tidak -- </option>
                                          @foreach ($seragam as $value)
                                          <option value="{{ $value->s_id }}"
                                          @if ($value->s_id == old('ukuran', $x->s_id))
                                              selected="selected"
                                          @endif
                                          >{{ $value->s_nama }}</option>
                                          @endforeach
                                          @else
                                          <option value="Tidak"> -- Tidak -- </option>
                                          @foreach ($seragam as $value)
                                          <option value="{{ $value->s_id }}"
                                          @if ($value->s_id == old('ukuran', $x->s_id))
                                              selected="selected"
                                          @endif
                                          >{{ $value->s_nama }}</option>
                                          @endforeach
                                          @endif
                                        </td>
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
                            <h5>Info Pengeluaran</h5>
                        </div>
                        <div class="ibox-content">
                            <span>
                                Total
                            </span>
                            <h2 class="font-bold totalpembelian" align="center">
                                Rp. {{number_format($data[0]->sd_total_net, 0, ',', '.')}}
                                <input type="hidden" name="total" id="total" value="{{$data[0]->sd_total_net}}">
                                <input type="hidden" name="harga" id="harga" value="{{$data[0]->sd_value}}">
                            </h2>

                            <hr>

                            <span class="text-muted small">

                            </span>
                            <div class="m-t-sm">
                                <div class="btn-group">
                                <button onclick="simpan({{$id}})" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Simpan</button>
                                <a href="{{ url('manajemen-seragam/pengeluaran') }}" class="btn btn-white btn-sm"> Batal</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="infosupp">Info Mitra</h5>
                        </div>
                        <div class="ibox-content text-center">
                            <h3 class="telpmitra"><i class="fa fa-phone"></i> {{$data[0]->m_phone}}</h3>
                            <span class="small">
                                Hubungi Mitra jika diperlukan
                            </span>
                        </div>
                    </div>
                    <div class="ibox info-stock" style="display: block;">
                        <div class="ibox-title">
                            <h5 class="infosupp">Info Stock Seragam</h5>
                        </div>
                        <div class="ibox-content">
                        <ul class="list-group clear-list m-t" id='showinfo'>
                          @foreach($seragam as $s)
                            <li class="list-group-item fist-item"><span class="pull-right">{{$s->qty}}</span><span></span>{{$s->i_nama}} {{$s->i_warna}} {{$s->s_nama}}</li>
                          @endforeach
                        </ul>
                        </div>
                    </div>
                </div>
        </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
var stock = [];
var tabelpekerja;
var jumlahceklist = 0;
var counter = 0;
var total = $('#total').val();
var harga = $('#harga').val();
var countpembelian = 0;

    $( document ).ready(function() {
        tabelpekerja = $("#tabelitem").DataTable({
            responsive: true,
            paging: false,
            "language": dataTableLanguage
        });

        getData();
    });

function simpan(id){
  var mitra = $('#mitra').val();
  var seragam = $('#seragam').val();
  var divisi = $('#divisi').val();
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $.ajax({
    type: 'get',
    data: $('.form-inline').serialize()+'&id='+id,
    dataType: 'json',
    url: baseUrl + '/manajemen-penjualan/update',
    success : function(result){
      console.log(result);
    }
  })
}

function ambil(){
  var values = [];
  var selectedVal;
  $(".pilihukuran").each(function(i, sel){
      selectedVal = $(sel).val();
      values.push(selectedVal);
  });
  var pilih = compressArray(values);
  var hasil = [];
  for (var i = 0; i < pilih.length; i++) {
    for (var j = 0; j < stock.length; j++) {
      if (pilih[i].value != 'Tidak') {
        if (stock[j].s_id == pilih[i].value) {
          if (stock[j].qty < pilih[i].count) {
            $('select.index'+id).val('Tidak');
            swal({
              title: "Stock Kurang!",
              type: "warning",
              showConfirmButton: true
            })
          } else {
            temp = stock[j].id_price * pilih[i].count;
            hasil.push(temp);

            $('.totalpembelian').text('Rp. '+ accounting.formatMoney(hasil.reduce(getSum), "", 0, ".", ","));
          }
        }
    } else {
      $('.totalpembelian').text('Rp. '+ accounting.formatMoney(0, "", 0, ".", ","));
    }
  }
  }
}

function compressArray(original) {

var compressed = [];
// make a copy of the input array
var copy = original.slice(0);

// first loop goes over every element
for (var i = 0; i < original.length; i++) {

var myCount = 0;
// loop over every element in the copy and see if it's the same
for (var w = 0; w < copy.length; w++) {
  if (original[i] == copy[w]) {
    // increase amount of times duplicate is found
    myCount++;
    // sets item to undefined
    delete copy[w];
  }
}

if (myCount > 0) {
  var a = new Object();
  a.value = original[i];
  a.count = myCount;
  compressed.push(a);
}
}

return compressed;
};

function getData(){
    var mitra = $('#mitra').val();
    var item = $('#seragam').val();
    var divisi = $('#divisi').val();
    $.ajax({
      url: baseUrl + '/manajemen-penjualan/getPekerja',
      type: 'get',
      data: {mitra: mitra, item: item, divisi:divisi},
      success: function(response){
        var seragam = response.seragam;
        stock = seragam;
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

function getSum(total, num) {
    return total + num;
}

</script>
@endsection
