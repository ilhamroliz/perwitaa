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
                Manajemen Pembelian
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
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('extra_scripts')
<script type="text/javascript">
  $(document).ready(function(){
    $( ".cari" ).autocomplete({
        source: baseUrl+'/manajemen-seragam/penerimaan/cariHistory',
        minLength: 2,
        select: function(event, data) {
            getData(data.item);
        }
    });
  });

  function getData(data){
    var nota = data.id;
    $.ajax({
      url: "{{ url('manajemen-seragam/penerimaan/detailHistory') }}",
      type: 'get',
      data: {nota: nota},
      success: function(response){
        console.log(response);
      }
    });
  }
</script>
@endsection
