@extends ('main')

    @section('title', 'Dashboard')



    @section ('extra_styles')

    <style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    </style>

    @endsection

@section ('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Penggajian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Payroll
            </li>
            <li class="active">
                <strong>Penggajian</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
      <h5>Penggajian</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
        <div id="filter">
              <div class="row">
                <div class="col-6 col-md-3">
                  @if(empty($data))
                  <p>Data tidak Ketemu</p>
                    @else
                    <select id="selectmitra" class="select-picker form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumnmitra()">
                    <option value="" selected="true" >- Pilih Mitra -</option>
                    @foreach ($data as $key => $value)
                        <option value="{{ $value ->md_mitra }}" id="optionvalue">{{$value ->m_name}}</option>
                    @endforeach
                    </select>
                    @endif
                </div>
                <div class="col-6 col-md-3">
                  <select class="select-picker form-control" name="selectdivisi" id="selectdivisi" onchange="filterColumndivisi()">
                    <option value="all">Pilih Divisi</option>
                  </select>
                </div>
                <div class="col-6 col-sm-2">
                <button  style="margin-left: 40px;" type="button" name="button" id="cari" class="btn btn-primary" mitra="" divisi="" onclick="cari()">Filter Cari</button>
                </div>
                <br>
                <br>
                <br>
                <div class="input-daterange input-group col-md-5 isimodal" id="datepicker" style="margin-left:15px;">
                    <input type="text" class="input-sm form-control awal" id="start" name="start" value="05/06/2014"/>
                    <span class="input-group-addon">sampai</span>
                    <input type="text" class="input-sm form-control akhir" id="end" name="end" value="05/06/2014"/>
                </div>
            </div>
            <br>
            <div class="col-md-12 table-responsive " id="tabledinamis"  style="margin: 10px 0px 20px 0px;">
              <form id="data">
               <table id="pekerja" class="table table-bordered table-striped display" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="width:13%;">Nama</th>
                            <th style="width:13%;">NIK</th>
                            <th style="width:12%;">BPJS Kes</th>
                            <th style="width:12%;">BPJS Ket</th>
                            <th style="width:12%;">RBH</th>
                            <th style="width:12%;">Dapan</th>
                            <th style="width:13%;">Total</th>
                            <th style="width:13%;">No Reff</th>
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

});

function filterColumnmitra () {
    $("#selectdivisi").html('<option value="">Pilih Divisi</option>');
    var nmitra = $('#selectmitra').val();
    $('#table').DataTable().column(2).search(nmitra).draw();
    id =  $('#selectmitra').val();
    var html = "";
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/pekerja-di-mitra/getdivisi',
      dataType: 'json',
      success : function(result){
        // console.log(result);
        for (var i = 0; i < result.length; i++) {
          html += '<option value="'+result[i].md_id+'">'+result[i].md_name+'</option>';
        }
        $("#selectdivisi").append(html);
        $("#cari").attr('mitra',id);
      }
    });
}

function filterColumndivisi(){
  var id = $('#selectdivisi').val();
  $("#cari").attr('divisi',id);
}

function cari(){
  waitingDialog.show();
  $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
  var html = "";
  var mitra = $('#selectmitra').val();
  var divisi = $('#selectdivisi').val();
  var nokes = '';
  var noket = '';
  var r_no = '';
  var clskes = '';
  var clsket = '';
  var clsr = '';
  $.ajax({
    type: 'get',
    data: 'mitra='+mitra+"&divisi="+divisi,
    url: baseUrl + '/manajemen-payroll/payroll/cari',
    dataType: 'json',
    success : function(result){
      for (var i = 0; i < result.length; i++) {
        if (result[i].b_nokes == "-") {
           nokes = 'readonly';
           clskes = '';
        } else {
          clskes = 'rp';
        }
        if (result[i].b_noket == "-") {
           noket = 'readonly';
           clsket = '';
        } else {
          clsket = 'rp';
        }
        if (result[i].r_no == "-") {
           r_no = 'readonly';
           clsr = '';
        } else {
          clsr = 'rp';
        }

        var valbikes = '';
        var kes = '';
        if (result[i].bikes_value == '') {
          valbikes = '';
          kes = '';
        } else {
          valbikes = 'Rp. ';
          kes = accounting.formatMoney(result[i].bikes_value, "", 0, ".", ",");
        }

        var valbiket = '';
        var ket = '';
        if (result[i].biket_value == '') {
          valbiket = '';
          ket = '';
        } else {
          valbiket = 'Rp. ';
          ket = accounting.formatMoney(result[i].biket_value, "", 0, ".", ",");
        }

        var valrbh = '';
        var r = '';
        if (result[i].ri_value == '') {
          valrbh = '';
          r = '';
        } else {
          valrbh = 'Rp. ';
          r = accounting.formatMoney(result[i].ri_value, "", 0, ".", ",");
        }

        var p_value = '';
        var pval = '';
        if (result[i].p_value == '') {
          p_value = '';
          pval = '';
        } else {
          p_value = 'Rp. ';
          pval = accounting.formatMoney(result[i].p_value, "", 0, ".", ",");
        }

        html += '<tr role="row" class="odd">'+
              '<td>'+result[i].p_name+'</td>'+
              '<td>'+result[i].p_nip+'</td>'+
              '<td><input type="text" name="bpjskes[]" '+nokes+' class="form-control '+clskes+'" style="width:100%;"></td>'+
              '<td><input type="text" name="bpjsket[]" '+noket+' class="form-control '+clsket+'" style="width:100%;"></td>'+
              '<td><input type="text" name="rbh[]" '+r_no+' class="form-control '+clsr+'" style="width:100%;"></td>'+
              '<td><input type="text" name="dapan[]" class="form-control rp" style="width:100%;"></td>'+
              '<td><input type="text" name="totalgaji[]" class="form-control rp" style="width:100%;"></td>'+
              '<td><input type="text" name="noreff[]" class="form-control" onkeypress="return isNumber(event)" style="width:100%;"></td>'+
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
  })
}

  function simpan(){
    var start = $('#start').val();
    var end = $('#end').val();
    waitingDialog.show();
    $.ajax({
      type: 'get',
      data: $('#data').serialize()+'&start='+start+'&end='+end,
      url: baseUrl + '/manajemen-payroll/payroll/simpan',
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
    waitingDialog.show();
    $.ajax({
      type: 'get',
      data: $('#data').serialize()+'&start='+start+'&end='+end,
      url: baseUrl + '/manajemen-payroll/payroll/proses',
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
