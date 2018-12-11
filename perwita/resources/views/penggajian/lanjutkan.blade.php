@extends ('main')

    @section('title', 'Proses Gaji')

    @section ('extra_styles')

    <style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    </style>

    @endsection

@section ('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Lanjutkan Penggajian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Payroll
            </li>
            <li class="active">
                <strong>Lanjutkan Penggajian</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
      <h5>Lanjutkan Penggajian</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
        <div id="filter">
              <div class="row">
                <div class="input-daterange input-group col-md-5 isimodal" id="datepicker" style="margin-left:15px;">
                    <input type="text" class="input-sm form-control awal" id="start" name="start" value="05/06/2014"/>
                    <span class="input-group-addon">sampai</span>
                    <input type="text" class="input-sm form-control akhir" id="end" name="end" value="05/06/2014"/>
                </div>
            </div>
            <br>
            <input type="hidden" name="nota" value="{{$nota}}">
            <div class="col-md-12 table-responsive " id="tabledinamis"  style="margin: 10px 0px 20px 0px;">
              <form id="data">
               <table id="pekerja" class="table table-bordered table-striped display" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                          <th style="width:13%;">Nama</th>
                          <th style="width:13%;">NIK</th>
                          <th style="width:12%;">Gaji Pokok</th>
                          <th style="width:12%;">Tunjangan</th>
                          <th style="width:12%;">Ansuransi</th>
                          <th style="width:12%;">Potongan Lain</th>
                          <th style="width:13%;">Total</th>
                          <th style="width:13%;">No Reff</th>
                          <th style="width:13%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="showdata">
                    </tbody>
                </table>
                </form>
            </div>
        </div>
        <button type="button" name="button" class="btn btn-primary pull-right" onclick="simpan()">Simpan</button>
        <div class="pull-right" style="margin-right:10px;">
          <button type="button" name="button" class="btn btn-info" onclick="proses()">Proses</button>
        </div>
    </div>
</div>
</div>
</div>


@endsection

@section('extra_scripts')
<script type="text/javascript">
$(document).ready(function(){
  $('#pekerja').DataTable({
    responsive: true,
    "pageLength": 10,
    "pagging": false,
    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
    // "scrollY": '50vh',
    // "scrollCollapse": true,
        "language": dataTableLanguage,
  });

  // $('#pekerja').DataTable({
  //        dom: 'Bfrtip',
  //        buttons: [
  //            'copy', 'csv', 'excel', 'pdf', 'print'
  //        ]
  //    });

  $('.input-daterange').datepicker({
      keyboardNavigation: false,
      forceParse: false,
      autoclose: true,
      format: 'dd/mm/yyyy'
  });

  var nota = $('input[name=nota]').val();
  var html = '';
  $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
  $.ajax({
    type: 'get',
    data: {nota:nota},
    url: baseUrl + '/manajemen-payroll/payroll/penggajian/editval',
    dataType: 'json',
    success : function(result){
      for (var i = 0; i < result.length; i++) {
        html += '<tr role="row" class="odd">'+
              '<td>'+result[i].p_name+'</td>'+
              '<td>'+result[i].p_nip+'</td>'+
              '<td><input type="text" readonly name="gajipokok[]" class="form-control" style="width:100%;" value="Rp. '+accounting.formatMoney(result[i].p_gaji_pokok, "", 0, ".", ",")+'"></td>'+
              '<td><input type="text" readonly name="tunjangan[]" class="form-control" style="width:100%;" value="Rp. '+accounting.formatMoney(result[i].tunjangan, "", 0, ".", ",")+'"></td>'+
              '<td><input type="text" readonly name="ansuransi[]" class="form-control" style="width:100%;" value="Rp. '+accounting.formatMoney(result[i].ansuransi, "", 0, ".", ",")+'"></td>'+
              '<td><input type="text" name="potonganlain[]" id="potongan'+result[i].p_id+'" class="form-control rp" onkeyup="hitung('+result[i].p_id+','+result[i].p_gaji_pokok+','+result[i].tunjangan+','+result[i].ansuransi+')" style="width:100%;" value="Rp. '+accounting.formatMoney(result[i].pd_lain, "", 0, ".", ",")+'"></td>'+
              '<td id="td'+result[i].p_id+'"><input type="text" readonly name="totalgaji[]" class="form-control" style="width:100%;" value="Rp. '+accounting.formatMoney(result[i].pd_total, "", 0, ".", ",")+'"></td>'+
              '<td><input type="text" name="noreff[]" class="form-control" onkeypress="return isNumber(event)" style="width:100%;" value="'+result[i].pd_reff+'"></td>'+
              '<td><input type="text" name="Keterangan[]" class="form-control" style="width:100%;" value="'+result[i].pd_note+'"></td>'+
              '<td><input type="hidden" name="p_id[]" value="'+result[i].p_id+'" class="form-control" style="width:100%;"></td>'+
              '</tr>';
      }
      $('#showdata').html(html);
      $('.rp').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
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
  });
});


  function simpan(){
    var start = $('#start').val();
    var end = $('#end').val();
    var nota = $('input[name=nota]').val();
    waitingDialog.show();
    $.ajax({
      type: 'get',
      data: $('#data').serialize()+'&start='+start+'&end='+end+'&nota='+nota,
      url: baseUrl + '/manajemen-payroll/payroll/penggajian/simpanedit',
      dataType: 'json',
      success : function(result){
        waitingDialog.hide();
        if (result.status == 'berhasil') {
            swal({
                title: "Penggajian Disimpan",
                text: "Penggajian Berhasil Disimpan",
                type: "success",
                showConfirmButton: false,
                timer: 900
            });
            setTimeout(function(){
                  window.location.reload();
          }, 850);
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
    });
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
  }

  function proses(){
    var start = $('#start').val();
    var end = $('#end').val();
    var nota = $('input[name=nota]').val();
    waitingDialog.show();
    $.ajax({
      type: 'get',
      data: $('#data').serialize()+'&start='+start+'&end='+end+'&nota='+nota,
      url: baseUrl + '/manajemen-payroll/payroll/penggajian/prosesedit',
      dataType: 'json',
      success : function(result){
        waitingDialog.hide();
        if (result.status == 'berhasil') {
            swal({
                title: "Penggajian Diproses",
                text: "Penggajian Berhasil Diproses",
                type: "success",
                showConfirmButton: false,
                timer: 900
            });
            setTimeout(function(){
                  window.location.reload();
          }, 850);
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
    });
  }

</script>
@endsection
