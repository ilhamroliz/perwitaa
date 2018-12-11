@extends('main')

@section('title', 'Return Pembelian')

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
        <h2>Edit Return Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Edit Return Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                  @if(!empty($uang))
                    <h5 style="float: left;">Ganti Uang</h5><h5 style="float: right;">Return Pembelian dari {{$uang[0]->s_company}} ( {{$uang[0]->rs_nota}} )</h5>
                  @else
                    <h5 style="float: left;">Ganti Uang</h5><h5 style="float: right;"></h5>
                  @endif
                </div>
                <div class="ibox-content">
                    <div class="project-list">
                      <form class="" action="" id="form-data" method="post">
                        <input type="hidden" name="idpurchase" id="idpurchase" value="{{$uang[0]->p_id}}">
                        <table class="table table-hover">
                            <tbody>
                              @foreach($uang as $info)
                              @if($info->rsd_action == 'uang')
                              <tr>
                                  <td class="project-title col-sm-3">
                                      {{ $info->i_nama }} {{ $info->i_warna }} {{ $info->s_nama }}
                                      <br>
                                      <small> Harga: Rp. {{ number_format($info->rsd_value, 0, ',', '.') }}</small>
                                      <input type="hidden" name="valueharga[]" value="{{$info->rsd_value}}">
                                  </td>
                                  <td class="col-sm-2 form-horizontal" style="vertical-align: middle;">
                                      <div class="form-group" style="vertical-align: middle; margin-top: 15px;">
                                          <label class="col-sm-4 control-label">Jumlah: </label>
                                          <div class="col-sm-6">
                                              <input type="text" name="return[]" value="{{$info->rsd_qty}}" class="form-control col-sm-12 number" style="text-align: right; width: 100%;" readonly>
                                          </div><sup>*</sup>
                                      </div>
                                  </td>
                                  <td class="col-sm-3">
                                      <div class="form-group" style="vertical-align: middle;">
                                          <label class="col-sm-4 control-label" style="margin-top: 6px;">Harga@: </label>
                                          <div class="col-sm-8">
                                              <input type="text" name="hargo[]" value="Rp. {{ number_format($info->rsd_value, 0, ',', '.') }}" class="form-control harga" style="text-align: right;">
                                          </div>
                                      </div>
                                  </td>
                                  <td class="col-sm-4"><input type="text" placeholder="Keterangan" name="keterangan_sejenis[]" value="{{$info->rsd_note}}" class="form-control">
                                  </td>
                              </tr>
                              <input type="hidden" name="i_id[]" class="i_id" value="{{$info->i_id}}">
                              <input type="hidden" name="id_detailid[]" class="id_detailid" value="{{$info->id_detailid}}">
                              <input type="hidden" name="aksi[]" class="aksi" value="{{$info->rsd_action}}">
                              <input type="hidden" name="rsdreturn[]" class="rsdreturn" value="{{$info->rsd_return}}">
                              <input type="hidden" name="rsddetailid[]" class="rsddetailid" value="{{$info->rsd_detailid}}">
                              @endif
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="m-t" style="float: left; margin-top: -10px;">
                                <small><sup>*</sup>) Isi dengan '0' untuk membatalkan return</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                  @if(!empty($barang))
                    <h5 style="float: left;">Ganti Barang</h5><h5 style="float: right;">Return Pembelian dari {{$barang[0]->s_company}} ( {{$barang[0]->rs_nota}} )</h5>
                  @else
                    <h5 style="float: left;">Ganti Uang</h5><h5 style="float: right;"></h5>
                  @endif
                </div>
                <div class="ibox-content">
                    <div class="project-list">
                        <table class="table table-hover">
                            <tbody>
                              @foreach($barang as $info)
                              @if($info->rsd_action == 'barang')
                              <tr>
                                  <td class="project-title col-sm-4">
                                      {{ $info->i_nama }} {{ $info->i_warna }} {{ $info->s_nama }}
                                      <br>
                                      <small> Harga: Rp. {{ number_format($info->rsd_value, 0, ',', '.') }}</small>
                                      <input type="hidden" name="valueharga[]" value="{{$info->rsd_value}}">
                                  </td>
                                  <td class="col-sm-2 form-horizontal" style="vertical-align: middle;">
                                      <div class="form-group" style="vertical-align: middle; margin-top: 15px;">
                                          <label class="col-sm-4 control-label">Jumlah: </label>
                                          <div class="col-sm-6">
                                              <input type="text" name="return[]" value="{{$info->rsd_qty}}" class="form-control col-sm-12 number jumlahbarang" style="text-align: right; width: 100%;" readonly>
                                          </div><sup>*</sup>
                                      </div>
                                  </td>
                                  <td class="col-sm-4"><input type="text" placeholder="Keterangan" name="keterangan_sejenis[]" value="{{$info->rsd_note}}" class="form-control">
                                  </td>
                              </tr>
                              <input type="hidden" name="i_id[]" class="i_id" value="{{$info->i_id}}">
                              <input type="hidden" name="id_detailid[]" class="id_detailid" value="{{$info->id_detailid}}">
                              <input type="hidden" name="aksi[]" class="aksi" value="{{$info->rsd_action}}">
                              <input type="hidden" name="rsdreturn[]" class="rsdreturn" value="{{$info->rsd_return}}">
                              <input type="hidden" name="rsddetailid[]" class="rsddetailid" value="{{$info->rsd_detailid}}">
                              @endif
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="m-t" style="float: left; margin-top: -10px;">
                                <small><sup>*</sup>) Isi dengan '0' untuk membatalkan return</small>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="table-responsive">
                        <table class="table table-stripped table-bordered" id="barang-ganti">
                            <thead>
                                <tr>
                                    <th style="width: 45%">Nama Barang</th>
                                    <th style="width: 15%">Ukuran</th>
                                    <th style="width: 20%">Harga</th>
                                    <th style="width: 10%">Qty</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="showdata">
                              @foreach($barangbaru as $index => $x)
                              @if($index == 0)
                                <tr>
                                    <td><input type="text" placeholder="Masukan Nama Barang" id="searchbox" name="ganti[]" value="{{ $info->i_nama }} {{ $info->i_warna }}" class="form-control .searchbox" style="width: 100%"></td>
                                        <input type="hidden" name="gantibarang[]" value="{{$info->i_id}}">
                                    <td><select name="ukuran[]" class="form-control ukuran" id="ukuran" style="width: 100%;">
                                            <option disabled selected>-- Ukuran --</option>
                                            @foreach ($barangbaru as $value)
                                            <option value="{{ $value->s_id }}"
                                            @if ($value->s_id == old('ukuran', $x->rsg_item_dt))
                                                selected="selected"
                                            @endif
                                            >{{ $value->s_nama }}</option>
                                            @endforeach
                                        </select></td>
                                    <td><input type="text" name="harga[]" value="Rp. {{ number_format($x->rsd_value, 0, ',', '.') }}" class="form-control harga number" style="width: 100%"></td>
                                    <td><input type="text" name="qty[]" value="{{$x->rsg_qty}}" id="qty" class="form-control number tambahbarang" style="text-align: right; width: 100%" onkeyup="cek()"></td>
                                    <td>
                                      <button type="button" name="button" class="btn btn-primary" onclick="tambah()"> <i class="fa fa-plus"></i> </button>
                                    </td>
                                </tr>
                                @else
                                  <tr class="teer" id="dinamis{{$index + 1}}" index="{{$index + 1}}">
                                      <td><input type="text" placeholder="Masukan Nama Barang" id="searchbox" name="ganti[]" value="{{ $info->i_nama }} {{ $info->i_warna }}" class="form-control .searchbox" style="width: 100%"></td>
                                          <input type="hidden" name="gantibarang[]" value="{{$info->i_id}}">
                                      <td><select name="ukuran[]" class="form-control ukuran" id="ukuran" style="width: 100%;">
                                              <option disabled selected>-- Ukuran --</option>
                                              @foreach ($barangbaru as $value)
                                              <option value="{{ $value->s_id }}"
                                              @if ($value->s_id == old('ukuran', $x->rsg_item_dt))
                                                  selected="selected"
                                              @endif
                                              >{{ $value->s_nama }}</option>
                                              @endforeach
                                          </select></td>
                                      <td><input type="text" name="harga[]" value="Rp. {{ number_format($x->rsd_value, 0, ',', '.') }}" class="form-control harga number" style="width: 100%"></td>
                                      <td><input type="text" name="qty[]" value="{{$x->rsg_qty}}" id="qty" class="form-control number tambahbarang" style="text-align: right; width: 100%" onkeyup="cek()"></td>
                                      <td>
                                        <button type="button" name="button" class="btn btn-primary" onclick="tambah()"> <i class="fa fa-plus"></i> </button>
                                        <button type="button" name="button" class="btn btn-danger" onclick="kurang()"> <i class="fa fa-minus"></i> </button>
                                      </td>
                                  </tr>
                              @endif
                              @endforeach
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary btn-outline pull-right" name="button" onclick="simpan()"> <i class="fa fa-save"></i> Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">

    var table;
    var html;
    var dinamis = $('.teer').attr('index');
    var tmp = 0;
    var count = 1;
    var values = [];
    var jumlahbarang = 0;
    var info = [];
    var idtambahitem = [];
    var idtmp = 0;
    var idsize = [];
    var qty = [];

    $(document).ready(function(){

      idtambahitem = $("input[name='gantibarang[]']")
              .map(function(){return $(this).val();}).get();

      $(".jumlahbarang").each(function(i, sel){
          selectedVal = $(sel).val();
          values.push(selectedVal);
      });

      jumlahbarang = values.reduce(getSum);

      $(".number").keydown(function (e) {
  // Allow: backspace, delete, tab, escape, enter and .
  if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
       // Allow: Ctrl+A, Command+A
      (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
       // Allow: home, end, left, right, down, up
      (e.keyCode >= 35 && e.keyCode <= 40)) {
           // let it happen, don't do anything
           return;
  }
  // Ensure that it is a number and stop the keypress
  if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
  }
});

        $(".maskharga").maskMoney({
            allowNegative: false,
            thousands:'.',
            decimal:',',
            precision: 0,
            affixesStay: false
        });

        $('.harga').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

        $('#searchbox').autocomplete({
            source: baseUrl + '/manajemen-seragam/return/caribarang',
            select: function(event, ui) {
                getdata(ui.item.id);
            }
        });

        table = $("#barang-ganti").DataTable({
            "language": dataTableLanguage,
            "paging": false,
            "searching": false,
            "aaSorting": [],
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
    });

    function getdata(id){

      idtambahitem.push(id);

      idtmp = id;

        $.ajax({
          type: 'get',
          data: {id:id},
          url: baseUrl + '/manajemen-seragam/return/getbarang',
          dataType: 'json',
          success : function(result){
              for (var i = 0; i < result.length; i++) {
                $('#ukuran').append('<option value="'+result[i].s_id+'">'+result[i].s_nama+'</option>');
              }
          }
        });
    }

    function tambah(){

        dinamis = parseInt(dinamis) + 1;

        html = '<tr id="dinamis'+dinamis+'">'
                +'<td><input type="text" placeholder="Masukan Nama Barang" id="searchbox'+dinamis+'" name="ganti[]" value="" class="form-control .searchbox" style="width: 100%"></td>'
                +'<td><select name="ukuran[]" class="form-control ukuran" id="ukuran'+dinamis+'" style="width: 100%;">'
                      +'<option disabled selected>-- Ukuran --</option>'
                  +'</select></td>'
                +'<td><input type="text" name="harga[]" value="" class="form-control harga" style="width: 100%"></td>'
                +'<td><input type="text" name="qty[]" value="" id="qty'+dinamis+'" class="form-control number tambahbarang" style="text-align: right; width: 100%" onkeyup="cek('+dinamis+')"></td>'
                +'<td>'
                +'<button type="button" name="button" class="btn btn-primary" onclick="tambah()"> <i class="fa fa-plus"></i> </button> '
                +'<button type="button" name="button" class="btn btn-danger" onclick="kurang()"> <i class="fa fa-minus"></i> </button> '
                +'</td>'
                +'</tr>';

        $('#showdata').append(html);

        $('#searchbox'+dinamis).autocomplete({
            source: baseUrl + '/manajemen-seragam/return/caribarang',
            select: function(event, ui) {
                getdatadinamis(ui.item.id);
            }
        });

        $('.harga').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

    }

    function kurang(){

      tmp = dinamis - 1;

      $('#dinamis'+dinamis).remove();

      dinamis = dinamis - 1;
      console.log(idtambahitem);
      removeA(idtambahitem, idtmp);
      console.log(idtambahitem);
      $('#searchbox'+tmp).autocomplete({
          source: baseUrl + '/manajemen-seragam/return/caribarang',
          select: function(event, ui) {
              getdatakurang(ui.item.id);
          }
      });

      $('.harga').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

    }

    function getdatadinamis(id){

      idtambahitem.push(id);

      idtmp = id;

        $.ajax({
          type: 'get',
          data: {id:id},
          url: baseUrl + '/manajemen-seragam/return/getbarang',
          dataType: 'json',
          success : function(result){
              for (var i = 0; i < result.length; i++) {
                $('#ukuran'+dinamis).append('<option value="'+result[i].s_id+'">'+result[i].s_nama+'</option>');
              }
            }
        });
    }

    function getdatakurang(id){

      idtambahitem.push(id);

      idtmp = id;

        $.ajax({
          type: 'get',
          data: {id:id},
          url: baseUrl + '/manajemen-seragam/return/getbarang',
          dataType: 'json',
          success : function(result){
              for (var i = 0; i < result.length; i++) {
                $('#ukuran'+tmp).append('<option value="'+result[i].s_id+'">'+result[i].s_nama+'</option>');
              }
            }
        });
    }

    function getSum(total, num) {
        return parseInt(total) + parseInt(num);
    }

    function cek(id){

      var tambahbarang = [];
      var hasil = 0;

      $(".tambahbarang").each(function(i, sel){
          selectedVal = $(sel).val();
          tambahbarang.push(selectedVal);
      });

      hasil = tambahbarang.reduce(getSum);

      if (isNaN(hasil)) {
      } else {
        if (parseInt(hasil) <= parseInt(jumlahbarang)) {

        } else {
          swal({
            title: "Peringatan!",
            text: "Tidak boleh melebihi barang yang direturn",
            type: "warning",
            showConfirmButton: true,
            showLoaderOnConfirm: true,
          });

          if (dinamis == 0) {
            $('#qty').val('');
          } else {
            $('#qty'+id).val('');
          }
        }
      }
    }

    function simpan(){
      waitingDialog.show();

      $(".ukuran").each(function(i, sel){
          selectedVal = $(sel).val();
          idsize.push(selectedVal);
      });

      $(".tambahbarang").each(function(i, sel){
          selectedVal = $(sel).val();
          qty.push(selectedVal);
      });

      var aksi = $("input[name='aksi[]']")
              .map(function(){return $(this).val();}).get();

      var i_id = $("input[name='i_id[]']")
              .map(function(){return $(this).val();}).get();

      var harga = $("input[name='harga[]']")
              .map(function(){return $(this).val();}).get();

      var valueharga = $("input[name='valueharga[]']")
              .map(function(){return $(this).val();}).get();

      var rsdreturn = $("input[name='rsdreturn[]']")
              .map(function(){return $(this).val();}).get();

      var rsddetailid = $("input[name='rsddetailid[]']")
              .map(function(){return $(this).val();}).get();

      var id_detailid = $("input[name='id_detailid[]']")
              .map(function(){return $(this).val();}).get();

      var returnd = $("input[name='return[]']")
              .map(function(){return $(this).val();}).get();

      var keterangan_sejenis = $("input[name='keterangan_sejenis[]']")
              .map(function(){return $(this).val();}).get();

      var idpurchase = $('#idpurchase').val();

      var id = $('#idpurchase').val();

      $.ajax({
         type: 'get',
         data: {idtambahitem:idtambahitem, idsize:idsize, qty:qty, rsdreturn:rsdreturn, rsddetailid:rsddetailid, valueharga:valueharga, aksi:aksi, i_id:i_id, id_detailid:id_detailid, returnd:returnd, keterangan_sejenis:keterangan_sejenis, idpurchase:idpurchase, harga:harga},
         url: baseUrl + '/manajemen-seragam/return/update',
         dataType: 'json',
         success : function(result){
           if (result.status == 'berhasil') {
               swal({
                 title: "Berhasil Disimpan",
                 text: "Data berhasil Disimpan",
                 type: "success",
                 showConfirmButton: false,
                 timer: 900
               });
               location.reload();
           }
           waitingDialog.hide();
       },
       error: function (xhr, status) {
           if (status == 'timeout') {
               $('.error-load').css('visibility', 'visible');
               $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
           }
           else if (xhr.status == 0) {
               $('.error-load').css('visibility', 'visible');
               $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
           }
           else if (xhr.status == 500) {
               $('.error-load').css('visibility', 'visible');
               $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
           }
           waitingDialog.hide();
       }
   });
}

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

</script>
@endsection
