@extends('main')

@section('title', 'Permintaan Pekerja')

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
        <button style="float: right; margin-top: -7px;" onclick="tambah()" class="btn btn-primary btn-outline btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="Masukan No Penerimaan Pekerja / Nama Mitra">
                </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                              <th>No Kotrak</th>
                              <th>Jabatan</th>
                              <th>Nama Mitra</th>
                              <th>Nama divisi</th>
                              <th>Dibutuhkan</th>
                              <th>Terpenuhi</th>
                              <th width="70">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@include('mitra-contract.detail')

@endsection

@section('extra_scripts')
<script type="text/javascript">

$(document).ready(function(){

    $('#pencarian').autocomplete({
        source: baseUrl+'/manajemen-kontrak-mitra/data-kontrak-mitra/searchresult',
        select: function(event, ui) {
            getdata(ui.item.id);
            //console.log(ui);
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

  function tambah(){
      window.location = baseUrl+'/manajemen-kontrak-mitra/data-kontrak-mitra/tambah';
  }

  function getdata(id){
    $.ajax({
      type: 'get',
      data: {id},
      url: baseUrl+'/manajemen-kontrak-mitra/data-kontrak-mitra/searchresult/getdata',
      dataType: 'json',
      success : function(result){
        var mitra = result.data[0].mc_mitra;
        var kontrak = result.data[0].mc_contractid;
        table.clear();
        table.row.add( [
             result.data[0].mc_no,
             result.data[0].jp_name,
             result.data[0].m_name,
             result.data[0].md_name,
             result.data[0].mc_need,
             result.data[0].mc_fulfilled,
             '<div class="text-center">'+
             '<a style="margin-left:5px;" title="Detail" type="button" onclick="detail('+kontrak+')"  class="btn btn-info btn-xs"><i class="glyphicon glyphicon-folder-open"></i></a>'+
             '<a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" href="' + baseUrl + '/manajemen-kontrak-mitra/data-kontrak-mitra/' +mitra+ '/' +kontrak+ '/edit"><i class="glyphicon glyphicon-edit"></i></a>'+
             '<a style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus(' +mitra+ ',' +kontrak+ ')"><i class="glyphicon glyphicon-trash"></i></a>'+
             '</div>'
             ] )
            .draw()
            .node();
      }
    });
  }

  function detail(id){
     $.ajax({
       type : 'get',
       url : baseUrl + "/manajemen-kontrak-mitra/data-kontrak-mitra/"+id+"/detail",
       dataType : 'json',
       success : function(result){
         //console.log(result);
         $('#mc_no').html(': '+result.data[0].mc_no);
         $('#mc_mitra').html(': '+result.data[0].m_name);
         $('#mc_divisi').html(': '+result.data[0].md_name);
         $('#mc_comp').html(': '+result.data[0].c_name);
         $('#mc_jabatan').html(': '+result.data[0].jp_name);
         $('#mc_jobdesk').html(': '+result.data[0].mc_jobdesk);
         $('#mc_note').html(': '+result.data[0].mc_note);

         var html = '';
         var i;
         //alert(data.length);
         for(i=0; i<result.pekerja.length; i++){
           html +='<tr>'+
                 '<td>'+(i + 1)+'</td>'+
                 '<td>'+result.pekerja[i].p_name+'</td>'+
                 '<td>'+result.pekerja[i].mp_mitra_nik+'</td>'+
                 '<td>'+result.pekerja[i].p_hp+'</td>'+
                 '</tr>';
         }
         $('#showdata').html(html);

         $('#detail').modal('show');
       }
     });
   }

   function hapus(mitra,id_detail){
       swal({
         title: "Konfirmasi",
         text: "Apakah anda yakin ingin menghapus data kontrak mitra?",
         type: "warning",
         showCancelButton: true,
         closeOnConfirm: false,
         showLoaderOnConfirm: true,
     },
     function(){
         setTimeout(function(){
           $.ajax({
             url: baseUrl+'/manajemen-kontrak-mitra/data-kontrak-mitra/hapus/'+mitra+'/'+id_detail,
             type: 'get',
             timeout: 10000,
             success: function(response){
              if(response.status=='berhasil'){
                 swal({
                   title:"Berhasil",
                   text: "Data berhasil dihapus",
                   type: "success",
                   showConfirmButton: false,
                   timer: 900
               });
                 table.draw();

             }
         },error:function(x,e) {
           //alert(e);
           var message;
           if (x.status==0) {
               message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
           } else if(x.status==404) {
               message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
           } else if(x.status==500) {
               message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
           } else if(e =='parsererror') {
               message = 'Error.\nParsing JSON Request failed.';
           } else if(e =='timeout'){
               message = 'Request Time out. Harap coba lagi nanti';
           } else {
               message = 'Unknow Error.\n'+x.responseText;
           }
           throwLoadError(message);
           //formReset("store");
       }
   })
       }, 2000);

     });




   }


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
