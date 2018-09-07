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
        <h2>History Penerimaan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li>
                Penerimaan Pembelian
            </li>
            <li class="active">
                <strong>History Penerimaan</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>History Penerimaan</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <div class="input-group col-md-8">
                        <input type="text" placeholder="Masukan Nama Supplier / Nomor Nota Pembelian" class="cari input col-md-8 form-control">
                        <span class="input-group-btn">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Cari</button>
                        </span>
                    </div>
                    <div class="table-responsive" style="margin-top: 25px;">
                      <table class="table table-responsive table-striped table-bordered" id="history">
                        <thead>
                          <tr>
                            <td>Tanggal</td>
                            <td>Seragam</td>
                            <td>Qty</td>
                            <td>No DO</td>
                            <td>Penerima</td>
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
    table = $("#history").DataTable({
            responsive: true,
            "language": dataTableLanguage
        });
  });

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
</script>
@endsection
