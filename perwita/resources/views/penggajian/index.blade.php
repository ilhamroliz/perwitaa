@extends('main')

@section('title', 'Proses Gaji')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }

    .scrollable {
    overflow-x: scroll;
}

.bodycontainer {
    height: 100px !important;
    width: 100%;
}
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Proses Gaji</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
              Payroll
            </li>
            <li class="active">
                <strong>Proses Gaji</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Proses Gaji</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
              <div class="col-md-4">
                @if(empty($data))
                <p>Data tidak Ketemu</p>
                  @else
                  <select id="selectmitra" class="select-picker form-control" data-show-subtext="true" data-live-search="true" onchange="ambildata()">
                  <option value="" selected="true" >- Pilih Mitra -</option>
                  @foreach ($data as $key => $value)
                      <option value="{{ $value ->md_mitra }}" id="optionvalue">{{$value ->m_name}}</option>
                  @endforeach
                  </select>
                  @endif
              </div>
              <div class="input-daterange input-group col-md-5 isimodal" id="datepicker" style="margin-left:15px;">
                  <input type="text" class="input-sm form-control awal" id="start" name="start" value="{{Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y')}}"/>
                  <span class="input-group-addon">sampai</span>
                  <input type="text" class="input-sm form-control akhir" id="end" name="end" value="{{Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y')}}"/>
              </div>
              <br>
                <div class="col-md-12">
                <form class="formapprovalremunerasi scrollable" id="formapprovalremunerasi">
                    <table id="remunerasitabel" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Gaji Pokok</th>
                                <th>Tunjangan</th>
                                <th>Ansuransi</th>
                                <th>Potongan Lain</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="showdata">

                        </tbody>
                    </table>
                  </form>
                </div>
                <button type="button" class="btn btn-primary pull-right" onclick="proses()" style="margin-top:20px; margin-right:20px;" name="button">Proses</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;
var countmitra;
var totalmitra;
$( document ).ready(function() {

  $('.input-daterange').datepicker({
      keyboardNavigation: false,
      forceParse: false,
      autoclose: true,
      format: 'dd/mm/yyyy'
  });

  table = $("#remunerasitabel").DataTable({
    "processing": true,
    "paging": false,
    "searching": true,
    "deferLoading": 57,
    responsive: true,
    "language": dataTableLanguage
  });

});

function hapus(nota){
  swal({
          title: "Konfirmasi",
          text: "Apakah anda yakin ingin menghapus Penggajian ini?",
          type: "warning",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
      },
      function () {
          swal.close();
          $("#modal-detail").modal('hide');
          waitingDialog.show();
          setTimeout(function () {
              $.ajax({
                type: 'get',
                data: {nota:nota},
                dataType: 'json',
                url: baseUrl + '/manajemen-payroll/payroll/penggajian/hapus',
                success : function(result){
                      waitingDialog.hide();
                      if (result.status == 'berhasil') {
                          swal({
                              title: "Penggajian Dihapus",
                              text: "Penggajian Berhasil Dihapus",
                              type: "success",
                              showConfirmButton: false,
                              timer: 900
                          });
                          setTimeout(function(){
                                window.location.reload();
                        }, 850);
                      }
                  }, error: function (x, e) {
                      waitingDialog.hide();
                      var message;
                      if (x.status == 0) {
                          message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                      } else if (x.status == 404) {
                          message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                      } else if (x.status == 500) {
                          message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                      } else if (e == 'parsererror') {
                          message = 'Error.\nParsing JSON Request failed.';
                      } else if (e == 'timeout') {
                          message = 'Request Time out. Harap coba lagi nanti';
                      } else {
                          message = 'Unknow Error.\n' + x.responseText;
                      }
                      waitingDialog.hide();
                      throwLoadError(message);
                      //formReset("store");
                  }
              })
          }, 2000);

      });
}

function lanjutkan(nota){
  window.location.href = baseUrl + '/manajemen-payroll/payroll/penggajian/edit?nota='+nota;
}

function ambildata(){
  waitingDialog.show();
  var mitra = $('#selectmitra').val();
  var html = '';
  $.ajax({
    type: 'get',
    data: {mitra:mitra},
    dataType: 'json',
    url: baseUrl + '/manajemen-payroll/payroll/penggajian/ambildata',
    success : function(result){
    for (var i = 0; i < result.length; i++) {
      html += '<tr>'+
      '<td>'+result[i].p_name+'</td>'+
      '<td>'+result[i].p_nip+'</td>'+
      '<td><input type="text" class="form-control" readonly name="gajipokok[]" value="Rp. '+accounting.formatMoney(result[i].p_gaji_pokok, "", 0, ".", ",")+'"></td>'+
      '<td><input type="text" class="form-control" readonly name="tunjangan[]" value="Rp. '+accounting.formatMoney(result[i].tunjangan, "", 0, ".", ",")+'"></td>'+
      '<td><input type="text" class="form-control" readonly name="ansuransi[]" value="Rp. '+accounting.formatMoney(result[i].ansuransi, "", 0, ".", ",")+'"></td>'+
      '<td><input type="text" class="form-control" readonly name="potonganlain[]" value="Rp. '+accounting.formatMoney(result[i].p_value, "", 0, ".", ",")+'"></td>'+
      '<td><input type="text" class="form-control" readonly name="total[]" value="Rp. '+accounting.formatMoney(result[i].total, "", 0, ".", ",")+'"></td>'+
      '<input type="hidden" name="p_id[]" value="'+result[i].p_id+'">'+
      '<td align="center"> <button type="button" class="btn btn-primary btn-sm" onclick="cetak('+result[i].p_id+')" name="button"> <i class="fa fa-print"></i> Cetak </button> </td>'+
      '<tr>';
    }

    $('#showdata').html(html);

    waitingDialog.hide();
    }
  });
}

  function proses(){
    var form = $('#formapprovalremunerasi').serialize();
    var start = $('#start').val();
    var end = $('#end').val();
    $.ajax({
      type: 'get',
      dataType: 'json',
      data: $('#formapprovalremunerasi').serialize()+'&start='+start+'&end='+end,
      url: baseUrl + '/manajemen-payroll/payroll/penggajian/proses',
      success : function(result){
        if (result.status == 'berhasil') {
            swal({
                title: "Berhasil Diproses",
                text: "Berhasil Diproses",
                type: "success",
                showConfirmButton: false,
                timer: 900
            });
            setTimeout(function(){
                  window.location.reload();
          }, 850);
        }
      else if (result.status == 'tidak lengkap') {
        swal({
            title: "Data tidak lengkap",
            text: "Data tidak lengkap",
            type: "info",
            showConfirmButton: true
        });
      }
      else if (result.status == 'gagal') {
        swal({
            title: "Data tidak lengkap",
            text: "Data tidak lengkap",
            type: "info",
            showConfirmButton: true
        });
      }
      }
    });
  }

  function cetak(id){
    window.location.href = baseUrl + '/manajemen-payroll/payroll/penggajian/cetak?id='+id;
  }

</script>
@endsection
