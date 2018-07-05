@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }

    ul .list-unstyled{
      background-color: rgb(255, 255, 255);
    }

    li .daftar{
      padding: 4px;
      cursor: pointer;
    }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Cari Pembelian Ke Supplier</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Cari Pembelian Ke Supplier</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Pencarian Pembelian Ke Supplier</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-4">
                    <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="Masukan No Nota">
                </div>
                <div class="form-group row">
                      <div class="col-sm-2">
                        <input type="text" class="form-control startmou date-mou" name="startmou" style="text-transform:uppercase" title="Start"  placeholder="Start">
                      </div>
                      <div class="col-sm-2">
                          <input type="text" class="form-control endmou date-mou" name="endmou" style="text-transform:uppercase" title="End"  placeholder="End">
                      </div>
                      <button type="button" class="btn btn-primary btn-sm" name="button" style="font-size:13px; font-family:sans-serif;" onclick="filter()">Filter Cari</button>
                </div>
              </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Supplier</th>
                              <th>Nota</th>
                              <th>Total</th>
                              <th>Status</th>
                              <th>Keterangan</th>
                              <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('extra_scripts')
<script type="text/javascript">

$(document).ready(function(){

    $('#pencarian').autocomplete({
        source: baseUrl + '/manajemen-seragam/getnota',
        select: function(event, ui) {
            getdata(ui.item.id);
        }
    });

    table = $("#tabelcari").DataTable({
        "language": dataTableLanguage,
        "columnDefs": [{
            "targets": 0,
            "orderable": false
        }]

    });

    $('.startmou').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
    $('.endmou').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
  });

 function getdata(id){
   var html = '';
   var status = '';
   var keterangan = '';
   $.ajax({
     type: 'get',
     dataType: 'json',
     data: {id:id},
     url: baseUrl + '/manajemen-seragam/getdata',
     success : function(result){
       if (result.pd_receivetime == null) {
         status += '<td class="text-center"><span class="label label-warning">Belum diterima</span></td>';
       } else {
         status += '<td class="text-center"><span class="label label-success">Sudah diterima</span></td>';
       }

       if (result.p_isapproved == 'P') {
         keterangan += '<td class="text-center"><span class="label label-warning">Belum disetujui</span></td>';
       } else if (result.p_isapproved == 'Y') {
         keterangan += '<td class="text-center"><span class="label label-success">Sudah disetujui</span></td>';
       }
         html += '<tr>'+
                 '<td>'+(1)+'</td>'+
                 '<td>'+result.p_date+'</td>'+
                 '<td>'+result.s_company+'</td>'+
                 '<td>'+result.p_nota+'</td>'+
                 '<td>'+result.pd_total_net+'</td>'+
                 status+
                 keterangan+
                 '<td>'+
                 '<button type="button" class="btn btn-info btn-sm" name="button" onclick="detail('+result.p_id+')"> <i class="fa fa-folder"></i> </button>'+
                 '</td>'+
                 '</tr>';

        $("#tbody").html(html);
     }
   });
 }

  function filter(){
    var moustart = $(".startmou").val();
    var mouend = $(".endmou").val();
    $.ajax({
      type: 'get',
      data: {moustart:moustart, mouend:mouend},
      url: baseUrl + '/manajemen-seragam/filter',
      dataType: 'json',
      success : function(result){
        console.log(result);
      }
    })
  }
</script>
@endsection
