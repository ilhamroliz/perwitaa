@extends('main')

@section('title', 'RBH')

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

    .headerDivider {
     border-left:1px solid #38546d;
     border-right:1px solid #16222c;
     height:80px;
     position:absolute;
     right:249px;
     top:10px;
}

</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Cari RBH</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Ansuransi
            </li>
            <li class="active">
                <strong>Cari RBH</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Cari RBH</h5>
      <a href="{{url('/manajemen-bpjs/ansuransi/rbh')}}" style="float: right; margin-top: -7px;" class="btn btn-primary btn-flat"><i class="fa fa-plus">&nbsp;</i>Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
              <div class="col-md-12" style="float:left;">
                <label for="pencarian">Cari Berdasarkan NIK Pekerja / Nama Pekerja</label>
                <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="NIK Pekerja / Nama Pekerja">
              </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                              <th>No. BPJS Kesehatan</th>
                              <th>Nama Tenaga Kerja</th>
                              <th>Fasilitas Kesehatan</th>
                              <th>Kelas</th>
                              <th>Mitra</th>
                              <th>Divisi</th>
                              <th>Tanggal Mulai</th>
                              <th>Status</th>
                              <th width="120px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="showdata">

                        </tbody>
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

  var html = '';
  $('#showdata').html('');
  $.ajax({
    type: 'get',
    url: baseUrl + '/manajemen-bpjs/ansuransi/rbh/data',
    dataType: 'json',
    success : function(result){
      for (var i = 0; i < result.length; i++) {
        if (result[i].r_status == 'Y') {
          var status = '<center><span class="badge badge-primary">Aktif</span></center>';
        } else {
          var status = '<center><span class="badge badge-danger">Non Aktif</span></center>';
        }

        html += '<tr>'+
                '<td>'+result[i].r_no+'</td>'+
                '<td>'+result[i].p_name+'</td>'+
                '<td>'+result[i].r_faskes+'</td>'+
                '<td>'+result[i].r_kelas+'</td>'+
                '<td>'+result[i].m_name+'</td>'+
                '<td>'+result[i].md_name+'</td>'+
                '<td>'+result[i].r_date+'</td>'+
                '<td>'+status+'</td>'+
                '<td>'+
                '<div class="text-center">'+
                  '<a style="margin-left:5px;" title="Non Aktifkan" type="button" onclick="nonaktif('+result[i].r_no+')"  class="btn btn-warning btn-xs"><i class="fa fa-ban"></i></a>'+
                  '<a style="margin-left:5px;" title="Hapus" type="button" onclick="hapus('+result[i].r_no+')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>'+
                '</div>'+
                '</tr>';
      }

    $('#showdata').html(html);
    }
  });

    $('#pencarian').autocomplete({
        source: baseUrl + '/manajemen-pekerja/phk/carino',
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

});

  function loaddata(){
    var html = '';
    $('#showdata').html('');
    $.ajax({
      type: 'get',
      url: baseUrl + '/manajemen-bpjs/ansuransi/rbh/data',
      dataType: 'json',
      success : function(result){
        for (var i = 0; i < result.length; i++) {
          if (result[i].r_status == 'Y') {
            var status = '<center><span class="badge badge-primary">Aktif</span></center>';
          } else {
            var status = '<center><span class="badge badge-danger">Non Aktif</span></center>';
          }

          html += '<tr>'+
                  '<td>'+result[i].r_no+'</td>'+
                  '<td>'+result[i].p_name+'</td>'+
                  '<td>'+result[i].r_faskes+'</td>'+
                  '<td>'+result[i].r_kelas+'</td>'+
                  '<td>'+result[i].m_name+'</td>'+
                  '<td>'+result[i].md_name+'</td>'+
                  '<td>'+result[i].r_date+'</td>'+
                  '<td>'+status+'</td>'+
                  '<td>'+
                  '<div class="text-center">'+
                    '<a style="margin-left:5px;" title="Non Aktifkan" type="button" onclick="nonaktif('+result[i].r_no+')"  class="btn btn-warning btn-xs"><i class="fa fa-ban"></i></a>'+
                    '<a style="margin-left:5px;" title="Hapus" type="button" onclick="hapus('+result[i].r_no+')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>'+
                  '</div>'+
                  '</tr>';
        }

      $('#showdata').html(html);
      }
    });
  }

  function getdata(id){
    waitingDialog.show();
    var html = '';
    $('#showdata').html('');
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/manajemen-bpjs/ansuransi/rbh/getdata',
      dataType: 'json',
      success : function(result){
        if (result.status == 'kosong') {
          html = '<tr><td colspan="7"><center>Tidak ada data</center></td></tr>';
        } else {
          for (var i = 0; i < result.length; i++) {
            if (result[i].r_status == 'Y') {
              var status = '<center><span class="badge badge-primary">Aktif</span></center>';
            } else {
              var status = '<center><span class="badge badge-danger">Non Aktif</span></center>';
            }

            html += '<tr>'+
                    '<td>'+result[i].r_no+'</td>'+
                    '<td>'+result[i].p_name+'</td>'+
                    '<td>'+result[i].r_faskes+'</td>'+
                    '<td>'+result[i].r_kelas+'</td>'+
                    '<td>'+result[i].m_name+'</td>'+
                    '<td>'+result[i].md_name+'</td>'+
                    '<td>'+result[i].r_date+'</td>'+
                    '<td>'+status+'</td>'+
                    '<td>'+
                    '<div class="text-center">'+
                      '<a style="margin-left:5px;" title="Non Aktifkan" type="button" onclick="nonaktif('+result[i].r_no+')"  class="btn btn-warning btn-xs"><i class="fa fa-ban"></i></a>'+
                      '<a style="margin-left:5px;" title="Hapus" type="button" onclick="hapus('+result[i].r_no+')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>'+
                    '</div>'+
                    '</tr>';
          }
        }

      $('#showdata').html(html);
      waitingDialog.hide()
      }
    });
  }



  function hapus(id){
      swal({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin menghapus data RBH?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
    function(){
      swal.close();
      waitingDialog.show();
        setTimeout(function(){
          $.ajax({
            data: {id:id},
            url: baseUrl + '/manajemen-bpjs/ansuransi/rbh/hapus',
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
              loaddata();
            } else {
              swal({
                  title:"Perhatian",
                  text: "Data tidak bisa dihapus, terdapat data penting!!",
                  type: "warning",
                  showConfirmButton: true,
                  timer: 2500
              });
            }
            waitingDialog.hide();
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
          waitingDialog.hide();
      }
  })
      }, 2000);

    });
  }

  function nonaktif(id){
      swal({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin non aktifkan data RBH?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
    function(){
      swal.close();
      waitingDialog.show();
        setTimeout(function(){
          $.ajax({
            data: {id:id},
            url: baseUrl + '/manajemen-bpjs/ansuransi/rbh/nonaktif',
            type: 'get',
            timeout: 10000,
            success: function(response){
             if(response.status=='berhasil'){
                swal({
                  title:"Berhasil",
                  text: "Data berhasil dinonaktifkan",
                  type: "success",
                  showConfirmButton: false,
                  timer: 900
              });
              loaddata();
            } else {
              swal({
                  title:"Perhatian",
                  text: "Data tidak bisa dihapus, terdapat data penting!!",
                  type: "warning",
                  showConfirmButton: true,
                  timer: 2500
              });
            }
            waitingDialog.hide();
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
          waitingDialog.hide();
      }
  })
      }, 2000);

    });
  }



</script>
@endsection
