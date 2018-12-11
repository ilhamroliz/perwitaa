@extends('main')

@section('title', 'Stock Seragam')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Stock Seragam </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Manajemen Stock</a>
                        </li>
                        <li class="active">
                            <strong>Data Stock Seragam</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
                    <h5>Stock Seragam</h5>
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

                  <div class="col-md-6 col-sm-6 col-xs-6">
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
                    <button class="btn btn-primary btn-md btn-flat " type="button" id="filter"> <em class="fa fa-search">&nbsp;</em> Filter Cari</button>
                    <div class="dropdown pull-right" style="margin-right:200px;">
                        <button class="btn btn-info btn-md btn-flat dropdown-toggle tampilkan" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          <em class="fa fa-print">&nbsp;</em>  Print
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li role="separator" class="divider"></li>
                            <li><a href="{{url('manajemen-stock/data-stock/printall')}}"><i class="fa fa-print" aria-hidden="true">&nbsp;</i>Print All</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                            <li><a onclick="pilih()"><i class="fa fa-print" aria-hidden="true">&nbsp;</i>Print Sejenis</a></li>
                            </li>
                        </ul>
                    </div>
                  </div>
                </div>

              </div>

                <div class="box-body">
                  <table id="data" class="table table-bordered table-striped data" style="width:100%">
                    <thead>
                     <tr>
                          <th style="text-align: center;" >NAMA SERAGAM</th>
                          <th style="text-align: center;" >UKURAN</th>
                          <th style="text-align: center;" >JUMLAH</th>
                          <th style="text-align: center;" >HARGA</th>
                          <th style="text-align: center;" >KETERANGAN</th>
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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Print Sejenis</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Pilih Sejenis :</label>
            <select class="form-control" name="optionbarang" id="optionbarang" onchange="ngelink()">
              <option value="">- Pilih -</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="" class="btn btn-primary btn-outline" onclick="getprint()" id="printbtn"><em class="fa fa-print">&nbsp;</em>Print</a>
      </div>
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
                "url" : baseUrl + "/manajemen-stock/data-stock/tabel",
                "type": "GET",

          },
           "columns": [
              { "data": "i_nama" },
              { "data": "s_nama" },
              { "data": "s_qty" },
              { "data": "id_price" },
              { "data": "i_note" },
              ]


      });


    $(document).on('click','#filter',function(){
      var kodegudang = $('#gudang').val();
      var kodebarang = $('#barang').val();

      $('#data').dataTable().fnDestroy();
      waitingDialog.show();
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
                "data": {gudang: kodegudang, barang: kodebarang},
                "url" : baseUrl + "/manajemen-stock/data-stock/tabel2",
                "type": "GET",

          },
           "columns": [
               { "data": "i_nama" },
               { "data": "s_nama" },
               { "data": "s_qty" },
               { "data": "id_price" },
               { "data": "i_note" },
              ]


      });
    waitingDialog.hide();

    });




    $("#barang").chosen();
    $("#gudang").chosen();
});

function pilih(){
    $('#exampleModal').modal('show');
    $('#optionbarang').html('<option value="">- Pilih -</option>');
    $.ajax({
      url: baseUrl + '/manajemen-stock/data-stock/getpilih',
      dataType: 'json',
      type: 'get',
      success : function(result){
        for (var i = 0; i < result.length; i++) {
          $('#optionbarang').append('<option value="'+result[i].i_id+'">'+result[i].i_nama+'</option>');
        }
      }
 });
}

function getprint(){
  id = $('#optionbarang').val();
  $.ajax({
    type: 'get',
    data: {id:id},
    url: baseUrl + '/manajemen-stock/data-stock/getprint',
    dataType: 'json',
    success : function(result){

    }
  });
}

function ngelink(){
  id = $('#optionbarang').val();
  $("#printbtn").attr('href', baseUrl + '/manajemen-stock/data-stock/getprint?id='+id);
}

</script>
@endsection
