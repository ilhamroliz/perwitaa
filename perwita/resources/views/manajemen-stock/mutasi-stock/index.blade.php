@extends('main')

@section('title', 'Mutasi Stock')

@section('extra_styles')


<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Mutasi Stock </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Manajemen Stock</a>
                        </li>
                        <li class="active">
                            <strong>Mutasi Stock</strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
                    <h5>Data Seragam</h5>
  </div>
    <div class="ibox">
        <div class="ibox-content">
          <div class="row">
                  <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->

                <div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                <div style="margin-left:-30px;">
                  <div class="col-md-1 col-sm-2 col-xs-12">
                    <label class="tebal">Filter : </label>
                  </div>

                  <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group" style="display: ">
                      <div class="input-daterange input-group">
                        <input class="form-control input-md" id="tanggal1" name="date"  type="text">
                        <span class="input-group-addon">-</span>
                        <input class="form-control input-md" id="tanggal2" name="date"  type="text">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5 col-sm-5 col-xs-5">
                      <select class="form-control chosen-select-width pull-right" name="barang" style="width:50%; cursor: pointer;" id="barang">
                            <option value="null" selected>--Semua Seragam--</option>
                        @foreach($databarang as $seragam)
                            <option value="{{ $seragam->i_id }}">  {{ $seragam->i_nama }}</option>
                        @endforeach
                      </select>
                      <select class="form-control chosen-select-width" name="gudang" style="width:45%; cursor: pointer;" id="gudang">
                            <option value="null" selected>--Semua Pemilik--</option>
                        @foreach($datagudang as $pemilik)
                            <option value="{{ $pemilik->c_id }}">  {{ $pemilik->c_name }}</option>
                        @endforeach
                      </select>
                  </div>
                  <button class="btn btn-info btn-md btn-flat" style="float:right;" type="button" id="filter">Filter Cari</button>
                 </div>
                </div>

              </div>

                <div class="box-body">
                  <table id="data" class="table table-bordered table-striped data" style="width:100%">
                    <thead>
                     <tr>
                          <th style="text-align: center;" >PEMILIK</th>
                          <th style="text-align: center;" >NAMA BARANG</th>
                          <th style="text-align: center;" >UKURAN</th>
                          <th style="text-align: center;" >TANGGAL</th>
                          <th style="text-align: center;" >JENIS</th>
                          <th style="text-align: center;" >QTY</th>
                          <th style="text-align: center;" >STOCK</th>
                          <th style="text-align: center;" >NOTA</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="footer">
                  <div class="pull-right">

                    </div>
                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
        </div>
    </div>
</div>


@endsection

@section('extra_scripts')
<script type="text/javascript">

$(document).ready(function() {


         var myTable = $('#data').dataTable({

          "ordering": true,
          "searching": true,
          "responsive":true,
          "pageLength": 10,
          "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
          "language": {
              "searchPlaceholder": "Cari Data",
              "emptyTable": "Tidak ada data",
              "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
              "infoFiltered" : "",
              "sSearch": '<i class="fa fa-search"></i>',
              "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
              "infoEmpty": "",
              "zeroRecords": "Data tidak ditemukan",
              "paginate": {
                      "previous": "Sebelumnya",
                      "next": "Selanjutnya",
                  }
            },

          "ajax":{
                "url" : baseUrl + "/manajemen-stock/mutasi-stock/tabel",
                "type": "GET",

          },
           "columns": [
              { "data": "c_name" },
              { "data": "i_nama" },
              { "data": "s_nama" },
              { "data": "sm_date" },
              { "data": "sm_detail" },
              { "data": "sm_qty" },
              { "data": "sisa_stok_gudang","defaultContent": "-"},
              { "data": "sm_nota" ,"defaultContent": "-"},
              ]


      });


    $(document).on('click','#filter',function(){
      var kodegudang = $('#gudang').val();
      var min = $('#tanggal1').val();
      var max = $('#tanggal2').val();
      var kodebarang = $('#barang').val();
      //$('#data').dataTable().fnClearTable();
      //alert(kodegudang);

      var tanggalawal1 = min;
      var pisah=tanggalawal1.split('/');
      var tanggaljadi1 = pisah[1] +'-'+pisah[0]+'-'+pisah[2];

      var tanggalawal2 = max;
      var pisah2=tanggalawal2.split('/');
      var tanggaljadi2 = pisah2[1] +'-'+pisah2[0]+'-'+pisah2[2];
      waitingDialog.show();
      $('#data').dataTable().fnDestroy();
      myTable = $('#data').dataTable({

          "ordering": true,
          "searching": true,
          "responsive":true,
          "pageLength": 10,
          "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
          "language": {
              "searchPlaceholder": "Cari Data",
              "emptyTable": "Tidak ada data",
              "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
              "infoFiltered" : "",
              "sSearch": '<i class="fa fa-search"></i>',
              "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
              "infoEmpty": "",
              "zeroRecords": "Data tidak ditemukan",
              "paginate": {
                      "previous": "Sebelumnya",
                      "next": "Selanjutnya",
                  }
            },



          "ajax":{
                "data": {gudang: kodegudang, tanggal1: tanggaljadi1, tanggal2: tanggaljadi2, barang: kodebarang},
                "url" : baseUrl + "/manajemen-stock/mutasi-stock/tabel2",
                "type": "GET",

          },
           "columns": [
              { "data": "c_name" },
              { "data": "i_nama" },
              { "data": "s_nama" },
              { "data": "sm_date" },
              { "data": "sm_detail" },
              { "data": "sm_qty" },
              { "data": "sisa_stok_gudang","defaultContent": "-"},
              { "data": "sm_nota" ,"defaultContent": "-"},
              ]


      });
      waitingDialog.hide();
    });


    // ====select range date picker =====//
      var date_input=$('input[name="date"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'dd-mm-yyyy',
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

    $("#barang").chosen();
    $("#gudang").chosen();
});

</script>
@endsection
