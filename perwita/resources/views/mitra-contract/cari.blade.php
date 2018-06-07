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
        <h2>Penerimaan Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Penerimaan Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Pencarian Penerimaan Pekerja</h5>
        <button style="float: right; margin-top: -7px;" onclick="tambah()" class="btn btn-primary btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <input type="text" name="pencarian" id="pencarian" class="form-control" onkeyup="search()" style="text-transform:uppercase" placeholder="Masukan No Pekerja">
                </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                              <th>No</th>
                              <th>No Kotrak</th>
                              <th>Jabatan</th>
                              <th>Nama Mitra</th>
                              <th>Nama divisi</th>
                              <th>Dibutuhkan</th>
                              <th>Terpenuhi</th>
                              <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('extra_scripts')
<script type="text/javascript">

$(document).ready(function(){

    $('#pencarian').autocomplete({
        source: baseUrl+'/manajemen-kontrak-mitra/data-kontrak-mitra/searchresult',
        select: function(event, ui) {
            getData(ul.label.id);
        }
    });

    table = $("#tabelcari").DataTable({
        "language": dataTableLanguage,
        "columnDefs": [{
            "targets": 0,
            "orderable": false
        }]

    });

});

    /*function search(){
    var keyword =  $('#pencarian').val();
      if (keyword != '') {
        $.ajax({
          type : 'get',
          data : {keyword},
          url : baseUrl+'/manajemen-kontrak-mitra/data-kontrak-mitra/searchresult',
          dataType : 'json',
          success : function(result){
            console.log(result);

            var html = '';
            var i;

            for(i=0; i<result.data.length; i++){
              html +='<ul class="list-unstyled">'+
                    '<li class="daftar">'+result.data[i].mc_no+'</li>'+
                    '</ul>';
            }
            $('#searchresult').fadeIn();
            $('#searchresult').html(html);
          }
        });
      }
    }*/
</script>
@endsection
