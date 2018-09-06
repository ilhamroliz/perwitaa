@extends('main')
@section('title', 'Akses User')
@section('extra_styles')
<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    .huruf{
        text-transform: capitalize;
    }
    .spacing-top{
        margin-top:15px;
    }
    #upload-file-selector {
        display:none;   
    }
    .margin-correction {
        margin-right: 10px;   
    }
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Rekening Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Rekening Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox">
    <div class="ibox-title">
      <h5>Rekening Pekerja</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                    <input type="text" name="cari" class="form-control" id="caripekerja" placeholder="Nama Pekerja/NIK Pekerja/NIK Mitra">
                </div>
                <button type="button" class="btn btn-info col-md-1"><i class="fa fa-search"></i> Cari</button>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <table class="table table-stripped table-bordered table-responsive" id="table-rekening">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Nama</th>
                            <th style="width: 20%;">NIK</th>
                            <th style="width: 20%;">NIK Mitra</th>
                            <th style="width: 30%;">No Rekening</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>
           

@endsection
@section("extra_scripts")
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $('#table-rekening').DataTable({
            "language": dataTableLanguage,
            'paging': false,
            'searching': false
        });
    });

    $('#caripekerja').autocomplete({
        source: baseUrl + '/manajemen-pekerja/rekening/getdata',
        select: function(event, ui) {
            getdata(ui.item);
        }
    });

    function getdata(data){
        console.log(data.data);
    }
</script>
@endsection()