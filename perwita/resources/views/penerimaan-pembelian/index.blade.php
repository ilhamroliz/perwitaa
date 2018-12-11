@extends('main')

@section('title', 'Penerimaan Pembelian')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Penerimaan Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Penerimaan Pembelian</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Penerimaan Pembelian</h5>
        <a style="float: right; margin-top: -7px;" class="btn btn-info btn-flat btn-sm" type="button" aria-hidden="true" href="{{ url('manajemen-seragam/penerimaan/cari') }}"><i class="fa fa-history"></i>&nbsp;History</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <select class="form-control chosen-select-width" name="nota" style="width:100%; cursor: pointer;" id="nota">
                            <option value="" disabled selected>--Pilih Nota Pembelian--</option>
                        @foreach($data as $nota)
                            <option value="{{ $nota->p_nota }}"> {{ $nota->p_nota }} ({{ $nota->s_company }}) </option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="button" onclick="cari()"><i class="fa fa-search"></i>&nbsp;Cari</button>
                    </div>
                    <div class="col-md-12" style="margin-top: 30px;">
                        <table class="table table-striped table-bordered table-hover" id="tabelitem">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Supplier</th>
                                    <th style="width: 40%;">Nama Barang</th>
                                    <th style="width: 10%;">Qty</th>
                                    <th style="width: 10%;">Diterima</th>
                                    <th style="width: 10%;">Sisa</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-12">
                      {{-- <a id="printbtn" href="{{url('manajemen-pembelian/print')}}" class="btn btn-info pull-right"> <em class="fa fa-print">&nbsp;</em> Print</a> --}}
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
                <h4 class="modal-title">Terima Barang</h4>
                <small class="font-bold">Barang yang diterima akan langsung masuk di stock gudang</small>
            </div>
            <div class="modal-body">
                <h3 class="namabarang"></h3>
                <form class="form-horizontal">
                    <div class="form-group">
                      <label class="col-lg-3 control-label" style="text-align: left;">No DO</label>
                      <div class="col-lg-9" style="margin-bottom: 5px;">
                          <input type="text" class="form-control nodo" style='text-transform:uppercase'>
                      </div>
                      <label class="col-lg-3 control-label" style="text-align: left;">Sisa Barang</label>
                      <div class="col-lg-3">
                          <input type="text" class="form-control sisabarang" readonly>
                      </div>
                      <label class="col-lg-3 control-label" style="text-align: left;">Jumlah Barang</label>
                      <div class="col-lg-3">
                          <input type="text" class="form-control jumlahterima" onkeyup="cek()" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                      </div>
                      <input type="hidden" class="id_purchase">
                      <input type="hidden" class="purchase_dt">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" class="btn btn-primary" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var tabelitem;
    $( document ).ready(function() {
        tabelitem = $("#tabelitem").DataTable({
            responsive: true,
            "language": dataTableLanguage
        });

        $("#nota").chosen();

    });


    function cari(){
        var nota = $('#nota').val();
        if (nota == null || nota == '') {
            Command: toastr["warning"]("Pilih nota pembelian terlebih dahulu", "Peringatan !")

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
        $.ajax({
          url: baseUrl + '/manajemen-pembelian/carinota',
          type: 'get',
          data: {nota: nota},
          success: function(response){
            tabelitem.clear();
            for (var i = 0; i < response.length; i++) {
                tabelitem.row.add([
                    response[i].s_company,
                    response[i].nama,
                    response[i].pd_qty,
                    response[i].pd_barang_masuk,
                    response[i].sisa,
                    buttonGen(response[i])
                ]).draw( false );
            }
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
              waitingDialog.hide();
            }
        })
    }

    function buttonGen(status){
        var buton;

        if (status.sisa == 0) {
            buton = '<button type="button" class="btn btn-primary btn-xs" >Sudah Diterima</button>';
        } else {
            buton = '<button type="button" class="btn btn-warning btn-xs" onclick="TerimaBarang('+status.sisa+', '+status.p_id+', '+status.pd_detailid+', \''+status.nama+'\')">Terima Barang</button>';
        }
        return buton;
    }

    function TerimaBarang(sisa, id, dt, nama){
        $('.namabarang').html(nama);
        $('.sisabarang').val(sisa);
        $('.id_purchase').val(id);
        $('.purchase_dt').val(dt);
        $('#myModal').modal('show');
    }

    function cek(){
        var maks = $('.sisabarang').val();
        var jumlah = $('.jumlahterima').val();
        jumlah = parseInt(jumlah);
        maks = parseInt(maks);
        if (jumlah > maks) {
            $('.jumlahterima').val(maks);
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

    function simpan(){
        var sisa = $('.jumlahterima').val();
        var id = $('.id_purchase').val();
        var dt = $('.purchase_dt').val();
        var nodo = $('.nodo').val();

        if (sisa == 0 || sisa == undefined || sisa == null || sisa == '') {
          swal({
              title: "Gagal",
              text: "Tidak boleh 0!",
              type: "error",
              showConfirmButton: true
          });
        } else if (nodo == '' || nodo == undefined || nodo == null) {
          swal({
              title: "Gagal",
              text: "No Do tidak boleh kosong!",
              type: "error",
              showConfirmButton: true
          });
        } else {
          //waitingDialog.show();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            url: baseUrl + '/manajemen-pembelian/penerimaan/update',
            type: 'get',
            data: {sisa: sisa, id: id, dt: dt, nodo: nodo},
            success: function(response){
              //waitingDialog.hide();
              $('#myModal').modal('hide');
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
              } else {
                  swal({
                      title: "Gagal",
                      text: "Sistem gagal menyimpan data",
                      type: "error",
                      showConfirmButton: true
                  });
              }
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
    }

    // $(document).ready(function() {
    //    $("#printbtn").printPage();
    //  });

</script>
@endsection
