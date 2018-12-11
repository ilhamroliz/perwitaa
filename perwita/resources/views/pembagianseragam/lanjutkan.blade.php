@extends('main')

@section('title', 'Pembagian Seragam')

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
        <h2>Tambah Pembagian Seragam</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li>
                Pembagian Seragam
            </li>
            <li class="active">
                <strong>Tambah Pembagian Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Tambah Pembagian Seragam</h5>
                    </div>

                    <div class="ibox-content">
                        <form role="form" class="form-inline" id="formdata">
                          <div class="row">
                            <div class="form-group col-md-4">
                                <label for="mitra" class="sr-only">Mitra</label>
                                <select class="form-control select2" name="mitra" style="width: 100%;" disabled id="mitra">
                                  @foreach ($mitra as $key => $value)
                                    <option value="{{$value->m_id}}" @if ($value->m_id == $mitraselected)
                                      selected
                                    @endif> {{$value->m_name}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="divisi" class="sr-only">Divisi</label>
                                <select class="form-control select2" name="divisi" style="width: 100%;" disabled id="divisi">
                                  <option value="{{$divisi->md_id}}" selected>{{$divisi->md_name}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                              <label for="nota" class="sr-only">Nota</label>
                              <select class="form-control select2" name="nota" style="width: 80%;" disabled id="nota">
                                <option value="{{$notasales->s_id}}" selected>{{$notasales->s_nota}}</option>
                              </select>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="form-group col-md-8">
                              <select class="form-control select2" name="jenis" style="width: 80%;" disabled id="jenis">
                                @foreach ($jenis as $key => $value)
                                  <option value="{{$value->i_id}}" selected>{{$value->i_nama}} {{$value->i_warna}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group col-md-3">
                              <button class="btn btn-info" type="button" onclick="cari()"> <i class="fa fa-search"></i> </button>
                            </div>
                          </div>
                            <div class="table-responsive" style="margin-top: 30px;">
                                <table class="table table-striped table-bordered table-hover" id="tabelitem">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Pekerja</th>
                                            <th style="width: 30%;">Ukuran</th>
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
                            <h5>Info Seragam</h5>
                        </div>
                        <div class="ibox-content">
                          <table class="table table-responsive table-hover">
                              <thead>
                                  <tr>
                                      <th>Nama Seragam</th>
                                      <th>QTY</th>
                                  </tr>
                              </thead>
                              <tbody id="showinfo">
                                @foreach ($salesreceived as $key => $value)
                                  <tr>
                                      <td><strong>{{$value->k_nama}}</strong> <br> <span>{{$value->i_nama}} {{$value->i_warna}} {{$value->s_nama}}</span></td>
                                      <td>{{$value->sr_qty}}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                            <br>
                            <br>
                            <div class="m-t-sm">
                                <div class="btn-group">
                                <button onclick="simpan()" class="btn btn-primary btn-outline btn-sm"><i class="fa fa-shopping-cart"></i> Simpan</button>
                                <a href="{{ url('/manajemen-seragam/pembagianseragam') }}" class="btn btn-white btn-sm"> Batal</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;
var mitra;
var seragam = [];
var item = [];
var itemdt = [];
var ukuran = [];
var qty = [];
var status = 'unlock';

  $(document).ready(function(){

    $('.select2').select2();

    table = $('#tabelitem').DataTable({
      language: dataTableLanguage
    });

            nota();
            cari();
  });

  function nota(){
    var s_id = $('#nota').val();
    $.ajax({
      type: 'get',
      data: {s_id:s_id},
      dataType: 'json',
      url: baseUrl + '/manajemen-seragam/pembagianseragam/getseragam',
      success : function(response){
        for (var i = 0; i < response.data.length; i++) {
          item[i] = response.data[i].sr_item;
          itemdt[i] = response.data[i].sr_item_dt;
          seragam[i] = response.data[i].i_nama;
          ukuran[i] = response.data[i].s_nama;
          qty[i] = response.data[i].sr_qty;
        }
      }
    });
  }

  // $('#nota').on('change', function(){
  //   waitingDialog.show();
  //   var s_id = $(this).val();
  //   var html = '';
  //   $.ajax({
  //     type: 'get',
  //     data: {s_id:s_id},
  //     dataType: 'json',
  //     url: baseUrl + '/manajemen-seragam/pembagianseragam/getseragam',
  //     success : function(response){
  //       for (var i = 0; i < response.data.length; i++) {
  //         if (response.data[i].flag != 0) {
  //           html += '<tr>'+
  //                   '<td><strong>'+response.data[i].k_nama+'</strong> <br> <span>'+response.data[i].i_nama + ' ' +response.data[i].i_warna+ ' ' + response.data[i].s_nama+'</span></td>'+
  //                   '<td>'+response.data[i].sr_qty+'</td>'+
  //                   '</tr>';
  //
  //           item[i] = response.data[i].sr_item;
  //           itemdt[i] = response.data[i].sr_item_dt;
  //           seragam[i] = response.data[i].i_nama;
  //           ukuran[i] = response.data[i].s_nama;
  //           qty[i] = response.data[i].sr_qty;
  //         }
  //       }
  //       $('#showinfo').html(html);
  //       for (var i = 0; i < response.jenis.length; i++) {
  //         html = '<option value="" disabled selected> - Pilih Jenis Seragam - </option>'
  //         html += '<option value="'+response.jenis[i].i_id+'">'+response.jenis[i].i_nama+' '+response.jenis[i].i_warna+'</option>';
  //       }
  //       $('#jenis').html(html);
  //       waitingDialog.hide();
  //       }
  //   });
  // });
  //
  // $('#mitra').on('change', function(){
  //   mitra = $(this).val();
  //   if (mitra == '') {
  //     $('#divisi').attr('disabled', true);
  //   } else {
  //     var html = '<option value="" disabled selected> - Pilih Divisi - </option>';
  //     $.ajax({
  //       type: 'get',
  //       data: {mitra:mitra},
  //       dataType: 'json',
  //       url: baseUrl + '/manajemen-seragam/pembagianseragam/getdivisi',
  //       success : function(response){
  //         for (var i = 0; i < response.length; i++) {
  //           html += '<option value="'+response[i].md_id+'">'+response[i].md_name+'</option>';
  //         }
  //         $('#divisi').html(html);
  //       }
  //     });
  //   }
  // });
  //
  // $('#divisi').on('change', function(){
  //   var html = '<option value="" disabled selected> - Pilih Nota - </option>';
  //   $.ajax({
  //     type: 'get',
  //     data: {mitra:mitra},
  //     dataType: 'json',
  //     url: baseUrl + '/manajemen-seragam/pembagianseragam/getnota',
  //     success : function(response){
  //       for (var i = 0; i < response.length; i++) {
  //         html += '<option value="'+response[i].s_id+'">'+response[i].s_nota+'</option>';
  //       }
  //       $('#nota').html(html);
  //     }
  //   })
  // });

  function cari(){
    nota();
    var notain = $('#nota').val();
    var mitra = $('#mitra').val();
    var divisi = $('#divisi').val();
    var jenis = $('#jenis').val();

    if (mitra == null) {
      Command: toastr["warning"]("Mitra tidak boleh kosong!", "Peringatan !")

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
    } else if (divisi == null) {
      Command: toastr["warning"]("Divisi tidak boleh kosong!", "Peringatan !")

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
    } else if (notain == null) {
      Command: toastr["warning"]("Nota tidak boleh kosong!", "Peringatan !")

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
    } else if (jenis == null) {
      Command: toastr["warning"]("Jenis tidak boleh kosong!", "Peringatan !")

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
      waitingDialog.show();
      var sales = $('#nota').val();
      $.ajax({
        type: 'get',
        data: {mitra:mitra, divisi:divisi, sales:sales},
        dataType: 'json',
        url: baseUrl + '/manajemen-seragam/pembagianseragam/showdata',
        success : function(response){
          table.clear();
          for (var i = 0; i < response.data.length; i++) {
            if (response.sales[i].length == 0) {
              table.row.add([
                getpekerja(response.data[i].p_name, response.data[i].p_id),
                getukuran(itemdt,ukuran, response.data[i].p_id),
              ]).draw(false);
            } else {
              table.row.add([
                getpekerja(response.data[i].p_name, response.data[i].p_id),
                getukuran(itemdt,ukuran, response.data[i].p_id, response.sales[i][0].sp_item_dt),
              ]).draw(false);
            }
          }
          waitingDialog.hide();
        }
      })
    }
  }

  function getpekerja(p_name, p_id){
    var html = '';
    html = '<span>'+p_name+'</span> <input type="hidden" name="pekerja[]" value="'+p_id+'">';

    return html;
  }

  function getukuran(itemdt, ukuran, idpekerja, selected){
    var option = '';
    var html = '';
    for (var i = 0; i < ukuran.length; i++) {
      if (itemdt[i] == selected) {
            option += '<option value="'+itemdt[i]+'" selected>'+ukuran[i]+'</option>';
      } else {
            option += '<option value="'+itemdt[i]+'">'+ukuran[i]+'</option>';
      }
    }

    html = '<select class="form-control select2 ukuran" name="ukuran[]" style="width: 80%;" id="ukuran'+idpekerja+'" onclick="filter('+idpekerja+')">'+
            '<option value=""> - Pilih Ukuran - </option>'+
            option+
            '</select>';

  return html;
  }

  function filter(id){
    var values = [];
    var selectedVal;
    $(".ukuran").each(function(i, sel){
        selectedVal = $(sel).val();
        values.push(selectedVal);
    });
    var pilih = compressArray(values);

    for (var i = 0; i < pilih.length; i++) {
      for (var j = 0; j < itemdt.length; j++) {
        if (pilih[i].value != '') {
          if (parseInt(itemdt[j]) === parseInt(pilih[i].value)) {
            if (parseInt(qty[j]) < parseInt(pilih[i].count)) {
              $('#ukuran'+id).val('');
              Command: toastr["warning"]("Tidak boleh melebihi qty seragam!", "Peringatan !")

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

  function simpan(){
    waitingDialog.show();
    var mitra = $('#mitra').val();
    var divisi = $('#divisi').val();
    var jenis = $('#jenis').val();
    var nota = $('#nota').val();
    $.ajax({
      type: 'get',
      data: $('#formdata').serialize()+'&nota='+nota+'&jenis='+jenis+'&divisi='+divisi+'&mitra='+mitra,
      dataType: 'json',
      url: baseUrl + '/manajemen-seragam/pembagianseragam/simpan',
      success : function (response){
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
          waitingDialog.hide();
          setTimeout(function () {
            window.location.href = baseUrl + '/manajemen-seragam/pembagianseragam';
          }, 500);
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
            waitingDialog.hide();
          }
        }
    });
  }

  // function unlock(){
  //   $('#mitra').attr('disabled', false);
  //   $('#jenis').attr('disabled', false);
  //   $('#divisi').attr('disabled', false);
  //   $('#nota').attr('disabled', false);
  //
  //   $('#lockdinamis').attr('onclick', 'lock()');
  //   $('#lockdinamis').attr('class', 'btn btn-info unlock');
  //   $('#lockdinamis').html('<i class="fa fa-unlock"></i>');
  //
  //   status = 'unlock';
  // }
  //
  // function lock(){
  //   $('#mitra').attr('disabled', true);
  //   $('#jenis').attr('disabled', true);
  //   $('#divisi').attr('disabled', true);
  //   $('#nota').attr('disabled', true);
  //
  //   $('#lockdinamis').attr('onclick', 'unlock()');
  //   $('#lockdinamis').attr('class', 'btn btn-info lock');
  //   $('#lockdinamis').html('<i class="fa fa-lock"></i>');
  //
  //   status = 'lock';
  // }

</script>
@endsection
