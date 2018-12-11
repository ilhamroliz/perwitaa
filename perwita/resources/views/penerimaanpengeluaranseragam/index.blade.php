@extends('main')

@section('title', 'Penerimaan Pengeluaran Seragam')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Penerimaan Pengeluaran Seragam</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Penerimaan Pengeluaran Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Penerimaan Pengeluaran Seragam</h5>
        <a style="float: right; margin-top: -7px;" class="btn btn-info btn-flat btn-sm" type="button" aria-hidden="true" href="{{url('manajemen-seragam/penerimaanpengeluaranseragam/history')}}"><i class="fa fa-history"></i>&nbsp;History</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <select class="form-control chosen-select-width" name="nota" style="width:100%; cursor: pointer;" id="nota">
                            <option value="" disabled selected>--Pilih Nota Pengeluaran--</option>
                        @foreach($data as $nota)
                          @if ($nota->sisa != 0)
                            <option value="{{ $nota->s_nota }}"> {{ $nota->s_nota }} </option>
                          @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="button" id="cari"><i class="fa fa-search"></i>&nbsp;Cari</button>
                    </div>
                    <div class="col-md-12" style="margin-top: 30px;">
                        <table class="table table-striped table-bordered table-hover" id="tabelitem">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Nama Barang</th>
                                    <th style="width: 10%;">Qty</th>
                                    <th style="width: 10%;">Sisa</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-download modal-icon"></i>
                <h4 class="modal-title">Terima Seragam</h4>
                <small class="font-bold">Penerimaan barang pengeluaran</small>
            </div>
            <div class="modal-body">
                <h3 class="namabarang"></h3>
                <form class="form-horizontal">
                    <div class="form-group">
                      <label class="col-lg-3 control-label" style="text-align: left;">Sisa Barang</label>
                      <div class="col-lg-3">
                          <input type="text" class="form-control sisabarang" readonly>
                      </div>
                      <label class="col-lg-3 control-label" style="text-align: left;">Jumlah Barang</label>
                      <div class="col-lg-3">
                          <input type="text" class="form-control jumlahterima" id="jumlahterima" onkeyup="cek()" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                      </div>
                      <input type="hidden" class="id_purchase">
                      <input type="hidden" class="purchase_dt">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" id="simpanbtn" class="btn btn-primary" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
  var tableitem;
  $(document).ready(function(){

    $('#nota').select2();

    tableitem = $('#tabelitem').DataTable({
      language: dataTableLanguage
    });

  });

  $('#cari').on('click', function(){
    waitingDialog.show();
      var nota = $('#nota').val();
      $.ajax({
        type: 'get',
        data: {nota:nota},
        dataType: 'json',
        url: baseUrl + '/manajemen-seragam/penerimaanpengeluaranseragam/cari',
        success : function(response){
          tableitem.clear();
          for (var i = 0; i < response.length; i++) {
            tableitem.row.add([
              seragam(response[i].k_nama, response[i].s_nama, response[i].i_nama),
              response[i].sd_qty,
              response[i].sisa,
              buttonGen(response[i].s_id, response[i].sd_item, response[i].sd_item_dt, response[i].sisa)
            ]).draw(false);
          }
          waitingDialog.hide();
        }
      });
  });

  function seragam(kategori, size, item){
    var seragam = '<strong>'+kategori+'</strong> <br> '+item+' '+size+'';

    return seragam;
  }

  function buttonGen(s_id, sd_item, sd_item_dt, sisa){
      var buton;

      if (sisa == 0) {
          buton = '<button type="button" class="btn btn-primary btn-xs" >Sudah Diterima</button>';
      } else {
          buton = '<button type="button" class="btn btn-warning btn-xs" onclick="TerimaBarang('+s_id+', '+sd_item+', '+sd_item_dt+', '+sisa+')">Terima Barang</button>';
      }
      return buton;
  }

  function TerimaBarang(s_id, sd_item, sd_item_dt, sisa){
    $('.sisabarang').val(sisa);
    $('#simpanbtn').attr('onclick', 'simpan('+s_id+', '+sd_item+', '+sd_item_dt+', '+sisa+')');
    $('#myModal').modal('show');
  }

  function cek(){
    var input = $('#jumlahterima').val();
    var sisa = $('.sisabarang').val();
    sisa = parseInt(sisa);
    input = parseInt(input);

    if (input > sisa) {
        $('.jumlahterima').val(sisa);
        Command: toastr["warning"]("Jumlah yang dimasukan tidak boleh melebehi sisa", "Peringatan !")

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
  }

  function simpan(s_id, sd_item, sd_item_dt, sisa){
    var qty = $('#jumlahterima').val();
    $.ajax({
      type: 'get',
      data: {s_id:s_id, sd_item:sd_item, sd_item_dt:sd_item_dt, qty:qty},
      dataType: 'json',
      url: baseUrl + '/manajemen-seragam/penerimaanpengeluaranseragam/simpan',
      success : function(response){
        if (response.status == 'berhasil') {
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
          tablereload();
          $('#jumlahterima').val('');
          $('#myModal').modal('hide');
        } else if (response.status == 'gagal') {
          Command: toastr["warning"]("Gagal Disimpan", "Peringatan !")

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
        }
      }
    });
  }

  function tablereload(){
    var nota = $('#nota').val();
    $.ajax({
      type: 'get',
      data: {nota:nota},
      dataType: 'json',
      url: baseUrl + '/manajemen-seragam/penerimaanpengeluaranseragam/cari',
      success : function(response){
        tableitem.clear();
        for (var i = 0; i < response.length; i++) {
          tableitem.row.add([
            seragam(response[i].k_nama, response[i].s_nama, response[i].i_nama),
            response[i].sd_qty,
            response[i].sisa,
            buttonGen(response[i].s_id, response[i].sd_item, response[i].sd_item_dt, response[i].sisa)
          ]).draw(false);
        }
        waitingDialog.hide();
      }
    });
  }

</script>
@endsection
