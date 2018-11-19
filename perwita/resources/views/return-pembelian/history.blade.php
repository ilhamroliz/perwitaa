@extends('main')

@section('title', 'Dashboard')

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
                      <div class="input-daterange input-group col-md-8">
                        <input class="form-control input-md" id="tanggal1" name="date" type="text" value="{{Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y')}}">
                        <span class="input-group-addon">-</span>
                        <input class="form-control input-md" id="tanggal2" name="date" type="text" value="{{Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y')}}">
                        <span class="input-group-btn">
                                <button type="button" class="btn btn btn-primary" onclick="tablehistory()"> <i class="fa fa-search"></i> Cari</button>
                        </span>
                      </div>
                    </div>
                  </div>
                <div class="col-md-12">
                    <div class="input-group col-md-8">
                        <input type="text" placeholder="Cari berdasarkan nota return" class="cari input col-md-8 form-control">
                        <span class="input-group-btn">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Cari</button>
                        </span>
                    </div>
                    <div class="table-responsive" style="margin-top: 25px;">
                      <table class="table table-responsive table-striped table-bordered" id="history">
                        <thead>
                          <tr>
                            <td>No</td>
                            <td>Tanggal</td>
                            <td>Nota</td>
                          </tr>
                        </thead>
                      </table>
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
  $(document).ready(function(){
    $( ".cari" ).autocomplete({
        source: baseUrl+'/manajemen-seragam/penerimaan/cariHistory',
        minLength: 2,
        select: function(event, data) {
            getData(data.item);
        }
    });

     table = $('#history').dataTable({

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
           "url" : baseUrl + "/manajemen-seragam/return/datatable_history",
           "type": "GET",

     },
      "columns": [
         { "data": "number" },
         { "data": "rs_date" },
         { "data": "rs_nota" },
         { "data": "action" }
         ]
 });
});

  function tablehistory(){

    var tanggal1 = $('#tanggal1').val();
    var tanggal2 = $('#tanggal2').val();

    $.ajax({
      type: 'get',
      data: {tanggal1:tanggal1, tanggal2:tanggal2},
      dataType: 'json',
      url: baseUrl + '/manajemen-seragam/return/datatable_history',
      success : function(result){
        table.ajax.reload();
      }
    });

  }

  function getData(data){
    waitingDialog.show();
    var nota = data.id;
    $.ajax({
      url: "{{ url('manajemen-seragam/penerimaan/detailHistory') }}",
      type: 'get',
      data: {nota: nota},
      success: function(response){
        table.clear();
        for (var i = 0; i < response.length; i++) {
          table.row.add([
              response[i].sm_date,
              response[i].nama,
              response[i].sm_qty,
              response[i].sm_delivery_order,
              response[i].m_name
          ]).draw( false );
        }
      }
    });
    waitingDialog.hide();
  }

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
</script>
@endsection
