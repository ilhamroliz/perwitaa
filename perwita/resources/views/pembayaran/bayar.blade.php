@extends('main')

@section('title', 'Pembayaran Seragam')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }

    .modal-body{
        max-height: calc(100vh - 300px);
    overflow-y: auto;
    }

    .modal-dialog{
        overflow-y: initial !important
    }

    table.dataTable tbody td {
      vertical-align: middle;
    }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Pembayaran Seragam Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Pembayaran Seragam</strong>
                <input type="hidden" name="status" value="{{$status}}" id="status">
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Pembayaran Seragam ( {{ $nota }} )</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                  <table class="table table-responsive table-striped table-bordered table-hover" id="tabel-pembayaran">
                    <thead>
                      <tr>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 15%;">Seragam</th>
                        <th style="width: 15%;">Tagihan</th>
                        <th style="width: 15%;">Dibayarkan</th>
                        <th style="width: 15%;">Sisa</th>
                        <th style="width: 15%;">Bayar</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($pekerja as $index=>$data)
                      <tr>
                        <td>{{ $data->p_name }} ({{ $data->p_hp }})</td>
                        <td><strong>{{$data->k_nama}}</strong> <br> {{$data->i_nama}} {{$data->i_warna}} {{ $data->s_nama }}</td>
                        <td><span style="float: left">Rp. </span><span style="float:right" class="hargaitem">{{ number_format($data->sp_value, 0, ',', '.') }}</span></td>
                        <td><span style="float: left">Rp. </span><span style="float:right" class="hargaitem">{{ number_format($data->sp_pay_value, 0, ',', '.') }}</span></td>
                        <td><span style="float: left">Rp. </span><span style="float:right" class="hargaitem">{{ number_format($data->tagihan, 0, ',', '.') }}</span></td>
                        @if($data->tagihan == 0)
                        <td style="text-align: center;">
                          <button class="btn btn-primary btn-xs text-center">Lunas</button>
                        </td>
                        <td>
                          <button onclick="lihat({{ $data->p_id }}, {{ $data->sp_sales }}, {{ $data->sp_value }})" class="btn btn-info btn-xs text-center">Detail</button>
                        </td>
                        @else
                        <td>
                          <input type="text" class="form-control bayar" name="bayar[]" style="width: 100%; text-align: right;" onkeyup="validasi(this, event, {{ $data->tagihan }})">
                          <input type="hidden" class="idPekerja" name="pekerja[]" value="{{ $data->p_id }}">
                        </td>
                        <td>
                          <button onclick="lihat({{ $data->p_id }}, {{ $data->sp_sales }}, {{ $data->sp_value }})" class="btn btn-info btn-xs text-center">Detail</button>
                        </td>
                        @endif
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-12">
                  <div class="btn-group" style="float: right">
                    <a onclick="simpan()" class="btn btn-primary btn-outline btn-sm"> Simpan</a>
                    <a href="{{$link}}" class="btn btn-white btn-sm"> Batal</a>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <i class="fa fa-money modal-icon"></i>
                                          <h4 class="modal-title">Detail Pembayaran</h4>
                                          <small class="font-bold">Detail pembayaran pekerja</small>
                                      </div>
                                      <div class="modal-body">
                                          <h3 class="namabarang"></h3>
                                          <form class="form-horizontal" id="form-detail">
                                              <div class="form-group">
                                                  <table class="table table-responsive table-striped table-bordered table-hover" id="detilpembayaran">
                                                    <thead>
                                                      <tr>
                                                        <th style="width: 40%;" class="col-md-5">Nama</th>
                                                        <th style="width: 30%;" class="col-md-4">Tanggal</th>
                                                        <th style="width: 30%;" class="col-md-3">Jumlah Pembayaran</th>
                                                        <th style="width: 30%;" class="col-md-3">Pegawai</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody id="datamodal">

                                                    </tbody>
                                                  </table>
                                              </div>
                                          </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" style="display:none" id="modalsimpan" name="button">Simpan</button>
                                        <button type="button" class="btn" name="button" data-dismiss="modal">Batal</button>
                                      </div>
                                    </div>
                                </div>
                            </div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
  var tabelpembayaran;
  var tabelpekerja;
  var detil;
  var nota = '{{ $nota }}';
  var jumlah;

  $( document ).ready(function() {
       tabelpembayaran = $("#tabel-pembayaran").DataTable({
            responsive: true,
            "language": dataTableLanguage,
            "columnDefs": [
                { "orderable": false, "targets": 0 }
              ]
        });


       detil = $("#detilpembayaran").DataTable({
            responsive: true,
            "language": dataTableLanguage
        });

       $('.bayar').maskMoney({
          prefix: 'Rp. ',
          decimal: ',',
          thousands: '.',
          precision: 0
      });
    });

    function simpan(){
        waitingDialog.show();
        var ar = $();
        for (var i = 0; i < tabelpembayaran.rows()[0].length; i++) {
            ar = ar.add(tabelpembayaran.row(i).node());
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          url: baseUrl + '/manajemen-seragam/simpan',
          type: 'post',
          data: ar.find('input').serialize()+'&nota='+nota,
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
                    showConfirmButton: false
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

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        var hasil = rupiah.split('',rupiah.length-1).reverse().join('');
        return 'Rp. '+hasil;

    }

    function convertToAngka(rupiah)
    {
        if (rupiah == null || rupiah == '') {
            return false;
        } else {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        }
    }

    function validasi(inField, e, sisa){
      var getIndex = $('input.bayar:text').index(inField);
      var bayar = $('input.bayar:text:eq('+getIndex+')').val();
      bayar = convertToAngka(bayar);
      if (bayar > sisa) {
        Command: toastr["warning"]("Pembayaran tidak boleh melebihi sisa tagihan", "Peringatan !")

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
        sisa = convertToRupiah(sisa);
        $('input.bayar:text:eq('+getIndex+')').val(sisa);
      }

    }

    function lihat(pekerja, sales, value){
      waitingDialog.show();
      var status = $('#status').val();
      $.ajax({
          url: baseUrl + '/manajemen-seragam/getInfoPembayaran',
          type: 'get',
          data: {pekerja: pekerja, sales: sales},
          success: function(response){
            var data = response.data;
            $('#datamodal').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');
            detil.clear();
            if (status == 'history') {
              for (var i = 0; i < data.length; i++) {
                var tagihan = accounting.formatMoney(data[i].spd_installments, "", 0, ".", ","); // €4.999,99
                detil.row.add([
                      data[i].p_name,
                      data[i].spd_date,
                      '<input type="text" class="form-control rp harga" id="rp'+i+'" name="harga[]" onkeyup="filter('+value+','+tagihan.replace('.','')+', '+i+')" value="Rp. '+tagihan+'"><input type="hidden" class="form-control" name="spd_sales[]" value="'+data[i].spd_sales+'"><input type="hidden" class="form-control" name="spd_detailid[]" value="'+data[i].spd_detailid+'"><input type="hidden" class="form-control" name="spd_pekerja[]" value="'+data[i].spd_pekerja+'">',
                      data[i].m_name
                  ]).draw( false );
              }
              $('#modalsimpan').css('display', '');
            } else {
              for (var i = 0; i < data.length; i++) {
                var tagihan = accounting.formatMoney(data[i].spd_installments, "", 0, ".", ","); // €4.999,99
                detil.row.add([
                      data[i].p_name,
                      data[i].spd_date,
                      '<input type="text" class="form-control rp" id="rp" name="harga[]" value="Rp. '+tagihan+'" disabled><input type="hidden" class="form-control" name="spd_sales[]" value="'+data[i].spd_sales+'"><input type="hidden" class="form-control" name="spd_detailid[]" value="'+data[i].spd_detailid+'"><input type="hidden" class="form-control" name="spd_pekerja[]" value="'+data[i].spd_pekerja+'">',
                      data[i].m_name
                  ]).draw( false );
              }
            }

            $('.rp').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
            waitingDialog.hide();
            $('#myModal').modal('show');
            var values = [];
            var selectedVal;
            $(".harga").each(function(i, sel){
                selectedVal = $(sel).val();
                values.push(selectedVal);
            });

            for (var i = 0; i < values.length; i++) {
              values[i] = values[i].replace('Rp. ', '');
              values[i] = values[i].replace('.', '');
            }

            jumlah = values.reduce(getSum);
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
              waitingDialog.hide();
            }
        })
    }

    $('#modalsimpan').on('click', function(){
      $.ajax({
        type: 'get',
        data: $('#form-detail').serialize()+'&jumlah='+jumlah,
        dataType: 'json',
        url: baseUrl + '/manajemen-seragam/pembayaran-seragam/update',
        success : function(response){
          if (response.status == 'berhasil') {
            Command: toastr["success"]("Berhasil Disimpan!", "Peringatan !")

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
            }, 800);
          } else {
            Command: toastr["warning"]("Gagal Disimpan!", "Peringatan !")

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
    });

    function filter(batas, tagihan, id){
      var values = [];
      var selectedVal;
      $(".harga").each(function(i, sel){
          selectedVal = $(sel).val();
          values.push(selectedVal);
      });

      for (var i = 0; i < values.length; i++) {
        values[i] = values[i].replace('Rp. ', '');
        values[i] = values[i].replace('.', '');
      }

      jumlah = values.reduce(getSum);

      if (jumlah > batas) {
        Command: toastr["warning"]("Pembayaran tidak boleh melebihi sisa tagihan", "Peringatan !")

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
        $('#rp'+id).val('Rp. '+accounting.formatMoney(tagihan, "", 0, ".", ","));
      }

    }

    function getSum(total, num) {
      return parseInt(total) + parseInt(num);
    }

</script>
@endsection
