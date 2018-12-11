@extends('main')

@section('title', 'Return Pembelian')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>History Return</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li>
                Return Pembelian
            </li>
            <li class="active">
                <strong>History Return</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>History Return</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
              <div class="col-md-12">
                    <div class="form-group" style="display: ">
                      <div class="input-daterange input-group col-md-8" style="margin-left:170px">
                        <input class="form-control input-md" id="tanggal1" name="date" type="text" value="{{Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y')}}">
                        <span class="input-group-addon">-</span>
                        <input class="form-control input-md" id="tanggal2" name="date" type="text" value="{{Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y')}}">
                        <span class="input-group-btn">
                                <button type="button" class="btn btn btn-primary" id="caritanggal"> <i class="fa fa-search"></i> Cari</button>
                        </span>
                      </div>
                    </div>
                  </div>
                <div class="col-md-12">
                    <div class="input-group col-md-8" style="margin-left:170px">
                        <center>
                        <input type="text" placeholder="Cari berdasarkan nota return" id="inputcari" class="cari input col-md-8 form-control">
                        </center>
                        <span class="input-group-btn">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Cari</button>
                        </span>
                    </div>
                    <br>
                    <br>
                    <div class="table-responsive">
                      <table class="table table-hover" cellspacing="0" id="history">
										  <thead class="bg-gradient-info">
										    <tr>
										      <th>No</th>
										      <th>Tanggal</th>
										      <th>Nota</th>
										      <th>Action</th>
										    </tr>
										  </thead>
										  <tbody class="center">

										  </tbody>
										</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Detail Return Pembelian</h4>
                        <small class="font-bold">Daftar Detail Return Pembelian</small>
                    </div>
                    <div class="modal-body">

                      <div id="divuang">
                      <h2>Ganti Uang</h2>
                      <table id="tableuang" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>No Return</th>
                            <th>Item Detail</th>
                            <th>Harga Awal</th>
                            <th>Harga Akhir</th>
                            <th>Qty</th>
                            <th>Keterangan</th>
                          </tr>
                        </thead>
                        <tbody id="showuang">

                        </tbody>
                      </table>
                      </div>

                      <div id="divbarang">
                        <h2>Ganti Barang</h2>
                        <table id="tablebarang" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>No Return</th>
                              <th>Item Detail</th>
                              <th>Harga Awal</th>
                              <th>Harga Akhir</th>
                              <th>Qty</th>
                              <th>Keterangan</th>
                            </tr>
                          </thead>
                          <tbody id="showbarang">

                          </tbody>
                        </table>
                      </div>

                      <div id="divganti">
                        <h2>Barang Pengganti</h2>
                        <table id="tableganti" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>No Ganti Barang</th>
                              <th>Item Detail</th>
                              <th>Qty</th>
                            </tr>
                          </thead>
                          <tbody id="showganti">

                          </tbody>
                        </table>
                      </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="cetak" onclick="cetak()" name="button"> <i class="fa fa-print"></i> Print</button>
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
  var table;
  var date_param = '';
  var div_param = '';
  var historyurl = "{{ url('/manajemen-seragam/return/datatable_history') }}";
  $(document).ready(function(){
    $( "#inputcari" ).autocomplete({
        source: baseUrl+'/manajemen-seragam/return/achistory',
        minLength: 2,
        select: function(event, data) {
            getData(data.item.id);
        }
    });


});

function getData(keyword){
  if(keyword != '' && keyword != '') {
      date_param = '&keyword=' + keyword;
  }
  var tmp_url = historyurl + '?' + div_param + date_param;
  table.ajax.url(tmp_url).load();
}

// Datatable Absensi manajemen
var valtgl_awal = $('#tanggal1');
var valtgl_akhir = $('#tanggal2');
var caritanggal = $('#caritanggal');


table = $('#history').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url: historyurl,
          },
  "columns": [
          { "data": "number" },
          { "data": "rs_date" },
          { "data": "rs_nota" },
					{ "data": "action" },
          ]
});


// Pencarian berdasarkan tanggal
caritanggal.click(function(){
  var tgl_awal = valtgl_awal.val() != '' ? valtgl_awal.val() : '' ;
  var tgl_akhir = valtgl_akhir.val() != '' ? valtgl_akhir.val() : '' ;

  if(tgl_awal != '' && tgl_akhir != '') {
      date_param = '&tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;
  }

  var tmp_url = historyurl + '?' + div_param + date_param;
  table.ajax.url(tmp_url).load();
});


// ======================================================

  // ====select range date picker =====//
    var date_input=$('input[name="date"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
      format: 'dd/mm/yyyy',
      container: container,
      todayHighlight: true,
      autoclose: true,
    };
    date_input.datepicker(options);

    var date = new Date();
    var day = date.getDate();
    var month1 = date.getMonth();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (month1 < 10) month1 = "0" + month1;
    if (day < 10) day = "0" + day;

    var bulanlalu = month1 + "/" + day + "/" + year;
    var today = month + "/" + day + "/" + year;
    $("#tanggal1").attr("value", bulanlalu);
    $("#tanggal2").attr("value", today);
  // ====select range date picker =====//

    function detail(id){
      var uang = '';
      var barang = '';
      var ganti = '';
        $.ajax({
          type: 'get',
          data: {id:id},
          dataType: 'json',
          url: baseUrl + '/manajemen-seragam/return/detail',
          success : function(result){

            if (result.uang.length > 0) {
              for (var i = 0; i < result.uang.length; i++) {
                 uang += '<tr>'
                            +'<td>'+result.uang[i].rs_nota+'</td>'
                            +'<td>'
                            +'<div><strong>'+result.uang[i].k_nama+'</strong></div>'
                            +'<small>'+result.uang[i].i_nama+ ' ' +result.uang[i].i_warna+' ( '+result.uang[i].s_nama+' ) '+'</small>'
                            +'</td>'
                            +'<td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> '+result.uang[i].rsd_hpp+'</span></td>'
                            +'<td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> '+result.uang[i].rsd_value+'</span></td>'
                            +'<td>'+result.uang[i].rsd_qty+'</td>'
                            +'<td>'+result.uang[i].rsd_note+'</td>'
                            +'</tr>';
              }
              $('#showuang').html(uang);
              $('#divuang').show();
            } else {
              $('#divuang').hide();
            }


            if (result.barang.length > 0) {
            for (var i = 0; i < result.barang.length; i++) {
               barang += '<tr>'
                          +'<td>'+result.barang[i].rs_nota+'</td>'
                          +'<td>'
                          +'<div><strong>'+result.barang[i].k_nama+'</strong></div>'
                          +'<small>'+result.barang[i].i_nama+ ' ' +result.barang[i].i_warna+' ( '+result.barang[i].s_nama+' ) '+'</small>'
                          +'</td>'
                          +'<td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> '+result.barang[i].rsd_hpp+'</span></td>'
                          +'<td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> '+result.barang[i].rsd_value+'</span></td>'
                          +'<td>'+result.barang[i].rsd_qty+'</td>'
                          +'<td>'+result.barang[i].rsd_note+'</td>'
                          +'</tr>';
            }
            $('#showbarang').html(barang);
            $('#divbarang').show();
          } else {
            $('#divbarang').hide();
          }

          if (result.barangbaru.length > 0) {
            for (var i = 0; i < result.barangbaru.length; i++) {
               ganti += '<tr>'
                          +'<td>'+result.barangbaru[i].rsg_no+'</td>'
                          +'<td>'
                          +'<div><strong>'+result.barangbaru[i].k_nama+'</strong></div>'
                          +'<small>'+result.barangbaru[i].i_nama+ ' ' +result.barangbaru[i].i_warna+' ( '+result.barangbaru[i].s_nama+' ) '+'</small>'
                          +'</td>'
                          +'<td>'+result.barangbaru[i].rsg_qty+'</td>'
                          +'</tr>';
            }
            $('#showganti').html(ganti);
            $('#divganti').show();
          } else {
            $('#divganti').hide();
          }
            $('#cetak').attr('onclick', 'cetak('+id+')');
            $('.rp').digits();
            $('#myModal5').modal('show');

          }
        });
    }

    function cetak(id){
      window.open(baseUrl + '/manajemen-seragam/return/cetak?id='+id);
    }
</script>
@endsection
