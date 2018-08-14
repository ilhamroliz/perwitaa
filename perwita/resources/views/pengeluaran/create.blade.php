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
        <h2>Tambah data Pengeluaran Barang</h2>
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
                        <h5>Pengeluaran Barang ke Mitra</h5>
                    </div>

                    <div class="ibox-content">
                        <form role="form" class="form-inline">
                            <div class="form-group col-md-3">
                                <select class="form-control chosen-select-width" name="mitra" style="width:100%" id="mitra" onchange="getItem()">
                                <option value="" disabled selected>--Pilih Mitra--</option>
                                @foreach($mitra as $mitra)
                                <option value="{{ $mitra->m_id }}"> {{ $mitra->m_name }} </option>
                                @endforeach
                            </select>
                            </div>
                            <div class="form-group col-md-3 divisi">
                                <select class="form-control chosen-select-width" name="divisi" style="width:100%" id="divisi" readonly>
                                    <option value=" ">--Pilih Divisi--</option>
                            </select>
                            </div>
                            <div class="form-group col-md-4 pilihseragam">
                                <select class="form-control chosen-select-width" name="seragam" style="width:100%" id="seragam" readonly>
                                    <option value=" ">--Pilih Seragam--</option>
                            </select>
                            </div>
                            <input type="hidden" name="total" id="total">
                            <button class="btn btn-info" type="button" onclick="getData()"><i class="fa fa-search"></i></button>
                            <div class="table-responsive" style="margin-top: 30px;">
                                <table class="table table-striped table-bordered table-hover" id="tabelitem">
                                    <thead>
                                        <tr>
                                            <th style="width: 60%;">Nama Pekerja</th>
                                            <th style="width: 20%;">NIK Mitra</th>
                                            <th style="width: 20%;">Ukuran</th>
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
                                <button onclick="simpan()" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Simpan</button>
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
                            <h3 class="telpmitra"></h3>
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

                        </ul>
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
    var stock = [];
    var tabelpekerja;
    var jumlahceklist = 0;
    var counter = 0;
    var total = 0;
    var nota = '{{ $nota }}';
    $( document ).ready(function() {
        tabelpekerja = $("#tabelitem").DataTable({
            responsive: true,
            paging: false,
            "language": dataTableLanguage
        });

        $("#showinfo").hide();
        $("#mitra").chosen();

    });

    function getItem(){
        waitingDialog.show();
        var mitra = $('#mitra').val();
        $.ajax({
          url: baseUrl + '/manajemen-penjualan/getItem',
          type: 'get',
          data: {mitra: mitra},
          success: function(response){
            $('.telpmitra').html('<i class="fa fa-phone"></i> '+response.info.m_phone);
            var form ='<select class="form-control chosen-select-width" name="seragam" style="width:100%" id="seragam">';
            form = form + '<option value=" " selected>--Pilih Seragam--</option>';
            var divisi ='<select class="form-control chosen-select-width" name="divisi" style="width:100%" id="divisi">';
            divisi = divisi + '<option value=" " selected>--Pilih Divisi--</option>';
            var data = response.data;
            for (var i = 0; i < data.length; i++) {
                form = form + '<option value="'+data[i].i_id+'"> '+data[i].i_nama+ ' (' +data[i].i_warna+ ')'+ ' </option>';
            }
            for (var i = 0; i < response.divisi.length; i++) {
                divisi += '<option value="'+response.divisi[i].md_id+'">'+response.divisi[i].md_name+'</option>';
            }
            $('.divisi').html(divisi);
            $('.pilihseragam').html(form);
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
        waitingDialog.hide();
    }

    function selectSize(seragam, pekerja){
      ++counter;
        var form ='<select class="form-control pilihukuran chosen-select-width index'+counter+'" name="ukuran[]" style="width:100%" id="ukuran" onchange="ambil('+counter+')">';
        form = form + '<option value="Tidak" selected>-- Tidak --</option>';
        for (var i = 0; i < seragam.length; i++) {
                form = form + '<option value="'+seragam[i].s_id+'"> '+seragam[i].s_nama+' </option>';
            }

        for (var j = 0; j < pekerja.length; j++) {
                form = form + '<input type="hidden" name="pekerja[]" value="'+pekerja[j].p_id+'">';
        }

        return form;
    }

    function checkMasuk(id){
        var form = '<div class="text-center"><input onchange="hitungTambah(this, event)" class="iCheck pekerjaAktif pekerjaAktif'+id+'" id="cek'+id+'" type="checkbox" name="masuk[]" value="'+id+'" style="cursor: pointer;"></div>';
        return form;
    }

    var harga = [];

    function getData(){
        waitingDialog.show();
        var mitra = $('#mitra').val();
        var item = $('#seragam').val();
        var divisi = $('#divisi').val();
        $.ajax({
          url: baseUrl + '/manajemen-penjualan/getPekerja',
          type: 'get',
          data: {mitra: mitra, item: item, divisi:divisi},
          success: function(response){
            var seragam = response.seragam;
            var pekerja = response.pekerja;
            tabelpekerja.clear();
            stock = seragam;
            counter = 0;
            for (var i = 0; i < pekerja.length; i++) {
                tabelpekerja.row.add([
                    pekerja[i].p_name +' ('+pekerja[i].p_hp+')',
                    pekerja[i].p_nip,
                    selectSize(seragam, pekerja)
                ]).draw( false );
            }
            for (var i = 0; i < seragam.length; i++) {
                harga[seragam[i].s_id] = seragam[i].id_price;
            }
            infoStock(seragam);
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

    function infoStock(seragam){
      var html = '';
      for (var i = 0; i < seragam.length; i++) {
        html = html + '<li class="list-group-item fist-item"><span class="pull-right">'+seragam[i].qty+'</span><span></span>'+seragam[i].i_nama+ ' ' + seragam[i].i_warna + ' ' + seragam[i].s_nama +'</li>';
      }
      $('#showinfo').html(html);
      $('#showinfo').show();
    }

    function hitungTambah(inField, e){
        jumlahceklist = jumlahceklist + 1;
        $('.jumlahitem').html(jumlahceklist);

        var getIndex = $('input.pekerjaAktif:checkbox').index(inField);
        var ukuran = $('select.pilihukuran:eq('+getIndex+')').val();

        var id = document.getElementsByClassName( 'pekerjaAktif' ),
          idItem  = [].map.call(id, function( input ) {
              if (input.checked) {
                return input.value;
              } else {
                return false;
              }
        });
        var jumlah = 0;
        for (var i = 0; i < idItem.length; i++) {
            if (idItem[i]) {
                jumlah = jumlah + 1;
            }
        }
        jumlahceklist = jumlah;
        $('.jumlahitem').html(jumlahceklist);
    }

    function simpan(){
        waitingDialog.show();
        var ar = $();
        for (var i = 0; i < tabelpekerja.rows()[0].length; i++) {
            ar = ar.add(tabelpekerja.row(i).node());
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var mitra = $('#mitra').val();
        var seragam = $('#seragam').val();
        var divisi = $('#divisi').val();
        $.ajax({
          url: baseUrl + '/manajemen-penjualan/save',
          type: 'get',
          data: ar.find('input').serialize()+'&'+ar.find('select').serialize()+'&mitra='+mitra+'&seragam='+seragam+'&nota='+nota+'&total='+total+'&divisi='+divisi,
          success: function(response){
            waitingDialog.hide();
            if (response.status == 'sukses') {
                swal({
                        title: "Sukses",
                        text: "Data sudah tersimpan",
                        type: "success"

                    }, function () {
                      //cari();
                      location.reload();
                    });
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

    function ambil(id){
      var values = [];
      $(".pilihukuran").each(function(i, sel){
          var selectedVal = $(sel).val();
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
                total = hasil.reduce(getSum)
                $('.totalpembelian').text('Rp. '+ accounting.formatMoney(hasil.reduce(getSum), "", 0, ".", ","));
              }
            }
          } else {
            temp = 0;
            hasil.push(temp);
            total = hasil.reduce(getSum)
            $('.totalpembelian').text('Rp. '+ accounting.formatMoney(hasil.reduce(getSum), "", 0, ".", ","));
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

function getSum(total, num) {
    return total + num;
}

</script>
@endsection
