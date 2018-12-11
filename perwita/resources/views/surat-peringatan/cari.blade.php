@extends('main')

@section('title', 'SP Pekerja')

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
        <h2>Surat Peringatan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Surat Peringatan</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Surat Peringatan</h5>
      <a href="{{url('/manajemen-pekerja/surat-peringatan')}}" style="float: right; margin-top: -7px;" class="btn btn-outline btn-primary btn-flat"><i class="fa fa-plus">&nbsp;</i>Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
              <div class="col-md-5" style="float:left;">
                <label for="pencarian">Cari Berdasarkan Nama/NIK Pekerja/NIK Mitra</label>
                <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="Masukkan Nama/NIK Pekerja/NIK Mitra">
              </div>
              <label for="startsp">&nbsp;&nbsp;&nbsp;&nbsp;Cari Berdasarkan Tanggal</label>
              <div class="form-group row">
                    <div class="col-sm-2">
                      <input type="text" id="startsp" style="float:right;" class="form-control startsp date-sp" name="startsp" style="text-transform:uppercase" title="Start"  placeholder="Start">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control endsp date-sp" name="endsp" style="text-transform:uppercase" title="End"  placeholder="End">
                    </div>
                    <button type="button" class="btn btn-primary" name="button" style="font-family:sans-serif;" onclick="filter()"><em class="fa fa-search">&nbsp;</em>Filter</button>
              </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                              <th>No. Sp</th>
                              <th>Nama Tenaga Kerja</th>
                              <th>Jabatan</th>
                              <th>Divisi</th>
                              <th>Tanggal Mulai - Tanggal Berakhir</th>
                              <th>Keterangan</th>
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

<div class="modal inmodal" id="modal-detail" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                  <div class="modal-content animated fadeIn">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <i class="fa fa-folder modal-icon"></i>
                      <h4 class="modal-title">Detail SP</h4>
                  <small>Detail SP</small>
              </div>
            <div class="modal-body">
              <center>
                <div class="spiner-sp">
                    <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                        <div class="sk-rect1 tampilkan" ></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                    <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Data SP</span>
                </div>
            </center>
            <div id="showdetail">
              <div class="row">
                <div class="col-lg-12">
                    <h3>Jenis SP : <span style="font-weight:normal;" id="sp_jenis">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>No SP : <span style="font-weight:normal;" id="sp_no">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Nama Tenaga Kerja : <span style="font-weight:normal;" id="namapekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Jabatan : <span style="font-weight:normal;" id="jabatanpekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Divisi : <span style="font-weight:normal;" id="divisipekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Keterangan : <span style="font-weight:normal;" id="keteranganpekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Status Approval : <span style="font-weight:normal;" id="approve">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Tanggal Mulai - Tanggal Berakhir : <span style="font-weight:normal;" id="tanggalmulaiberakhir">-</span></h3>
                </div>
                <div class="col-lg-12" id="daftarpelanggaran">
                  <br>
                    <h3>Pelanggaran : </h3>
                </div>
              </div>
            </div>
            </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="printbtn" name="button"><i class="fa fa-print">&nbsp;</i>Print</button>
                  <div class="btn-group">
                      <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="modal inmodal" id="modal-edit" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                  <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-folder modal-icon"></i>
                        <h4 class="modal-title">Edit SP</h4>
                    <small>Edit SP</small>
                </div>
              <div class="modal-body">
              <form class="form-edit">
                <div id="showdetail">
                  <div class="row">
                    <div class="col-lg-12">
                        <h3>Keterangan : <input type="text" class="form-control" name="keterangan" id="editketerangan" placeholder="Keterangan"></h3>
                    </div>
                    <div class="col-lg-12">
                        <h3>Tanggal Mulai - Tanggal Berakhir : </h3>
                    </div>
                    <div class="col-lg-4">
                        <h3> <input type="text" class="form-control date" id="datestart" name="start" placeholder="Start"> </h3>
                    </div>
                    <div class="col-lg-4">
                        <h3> <input type="text" class="form-control date" id="dateend" name="end" placeholder="End"> </h3>
                    </div>
                  </div>
                </div>
              </form>
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="updatebtn" onclick="update()" name="button">Simpan</button>
                    <div class="btn-group">
                        <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
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
    url: baseUrl + '/manajemen-pekerja/surat-peringatan/data',
    dataType: 'json',
    success : function(result){
      for (var i = 0; i < result.length; i++) {
        html += '<tr>'+
                '<td>'+result[i].sp_no+'</td>'+
                '<td>'+result[i].p_name+'</td>'+
                '<td>'+result[i].p_jabatan+'</td>'+
                '<td>'+result[i].md_name+'</td>'+
                '<td>'+result[i].sp_date_start+ ' - ' +result[i].sp_date_end+'</td>'+
                '<td>'+result[i].sp_note+'</td>'+
                '<td>'+
                '<div class="text-center">'+
                  '<a style="margin-left:5px;" title="Detail" type="button" onclick="detail('+result[i].sp_id+')"  class="btn btn-info btn-xs"><i class="glyphicon glyphicon-folder-open"></i></a>'+
                  '<a style="margin-left:5px;" title="Edit" type="button" onclick="edit('+result[i].sp_id+')"  class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'+
                  '<a style="margin-left:5px;" title="Hapus" type="button" onclick="hapus('+result[i].sp_id+')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>'+
                '</div>'+
                '</tr>';
      }

    $('#showdata').html(html);
    }
  });

    $('#pencarian').autocomplete({
        source: baseUrl + '/manajemen-pekerja/surat-peringatan/getsp',
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

    $('.date-sp').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

});

  function getdata(id){
    waitingDialog.show();
    var html = '';
    $('#showdata').html('');
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/manajemen-pekerja/surat-peringatan/getcari',
      dataType: 'json',
      success : function(result){
        if (result.status == 'kosong') {
          html = '<tr><td colspan="7"><center>Tidak ada data</center></td></tr>';
        } else {
          for (var i = 0; i < result.length; i++) {
            html += '<tr>'+
                    '<td>'+result[i].sp_no+'</td>'+
                    '<td>'+result[i].p_name+'</td>'+
                    '<td>'+result[i].p_jabatan+'</td>'+
                    '<td>'+result[i].md_name+'</td>'+
                    '<td>'+result[i].sp_date_start+ ' - ' +result[i].sp_date_end+'</td>'+
                    '<td>'+result[i].sp_note+'</td>'+
                    '<td>'+
                    '<div class="text-center">'+
                      '<a style="margin-left:5px;" title="Detail" type="button" onclick="detail('+result[i].sp_id+')"  class="btn btn-info btn-xs"><i class="glyphicon glyphicon-folder-open"></i></a>'+
                      '<a style="margin-left:5px;" title="Edit" type="button" onclick="edit('+result[i].sp_id+')"  class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'+
                      '<a style="margin-left:5px;" title="Hapus" type="button" onclick="hapus('+result[i].sp_id+')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>'+
                    '</div>'+
                    '</tr>';
          }
        }

      $('#showdata').html(html);
      waitingDialog.hide()
      }
    });
  }

  function detail(id){
    $('#daftarpelanggaran').html('<br><h3>Pelanggaran : </h3>');
    $('#modal-detail').modal('show');
    $('#showdetail').hide();
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/manajemen-pekerja/surat-peringatan/detail',
      dataType: 'json',
      success : function(result){

        $('#sp_jenis').text(result[0].sp_jenis);
        $('#sp_no').text(result[0].sp_no);
        $('#namapekerja').text(result[0].p_name);
        $('#jabatanpekerja').text(result[0].jp_name);
        $('#divisipekerja').text(result[0].md_name);
        $('#keteranganpekerja').text(result[0].sp_note);
        $('#tanggalmulaiberakhir').text(result[0].sp_date_start + ' - ' + result[0].sp_date_end);

        if (result[0].sp_isapproved == 'P') {
          $('#printbtn').hide();
          $('#approve').html('<span class="label label-warning">Pending</span>');
        } else if (result[0].sp_isapproved == 'Y') {
          $('#approve').html('<span class="label label-success">Disetujui</span>');
        } else if (result[0].sp_isapproved == 'N') {
          $('#approve').html('<span class="label label-danger">Ditolak</span>');
        }

        for (var i = 0; i < result.length; i++) {
          $('#daftarpelanggaran').append('<h3><span style="font-weight:normal;" >- '+result[i].spd_pelanggaran+'</span</h3><br>');
        }

        //Button
        $('#printbtn').attr('onclick', 'print('+id+')');

        $('.spiner-sp').hide();
        $('#showdetail').show();

      }
    });
  }

  function hapus(id){
      swal({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin menghapus data SP?",
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
            url: baseUrl + '/manajemen-pekerja/surat-peringatan/hapus',
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
              setTimeout(function(){
                    window.location.reload();
            }, 850);
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

  function edit(id){
    $('#modal-edit').modal('show');
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/manajemen-pekerja/surat-peringatan/edit',
      dataType: 'json',
      success : function(result){
        $('#editpekerja').val(result[0].p_name);
        $('#editjabatan').val(result[0].jp_name);
        $('#editdivisi').val(result[0].md_name);
        $('#editketerangan').val(result[0].sp_note);
        $('#datestart').val(result[0].sp_date_start);
        $('#dateend').val(result[0].sp_date_end);
        // button
        $('#updatebtn').attr('onclick','update('+id+')');

      }
    });
  }

  function update(id){
    setTimeout(function(){
      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
      $.ajax({
        type: 'post',
        data: $('.form-edit').serialize(),
        url: baseUrl + '/manajemen-pekerja/surat-peringatan/update/'+id,
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          if (result.status == 'berhasil') {
               swal({
                 title:"Berhasil",
                 text: "Data berhasil diupdate",
                 type: "success",
                 showConfirmButton: false,
                 timer: 900
             });
             setTimeout(function(){
                   window.location.reload();
           }, 850);
          }
        } ,error:function(x,e) {
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
      });
    }, 800);
  }

  function filter(){
    waitingDialog.show();
    var html = '';
    var start = $('.startsp').val();
    var end = $('.endsp').val();
    $.ajax({
      type: 'get',
      data: {start:start, end:end},
      dataType: 'json',
      url: baseUrl + '/manajemen-pekerja/surat-peringatan/filter',
      success : function(result){
        if (result.status == 'kosong') {
          html = '<tr><td colspan="7"><center>Tidak ada data</center></td></tr>';
        } else {
          for (var i = 0; i < result.length; i++) {
            html += '<tr>'+
                    '<td>'+result[i].sp_no+'</td>'+
                    '<td>'+result[i].p_name+'</td>'+
                    '<td>'+result[i].p_jabatan+'</td>'+
                    '<td>'+result[i].md_name+'</td>'+
                    '<td>'+result[i].sp_date_start+ ' - ' +result[i].sp_date_end+'</td>'+
                    '<td>'+result[i].sp_note+'</td>'+
                    '<td>'+
                    '<div class="text-center">'+
                      '<a style="margin-left:5px;" title="Detail" type="button" onclick="detail('+result[i].sp_id+')"  class="btn btn-info btn-xs"><i class="glyphicon glyphicon-folder-open"></i></a>'+
                      '<a style="margin-left:5px;" title="Edit" type="button" onclick="edit('+result[i].sp_id+')"  class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'+
                      '<a style="margin-left:5px;" title="Hapus" type="button" onclick="hapus('+result[i].sp_id+')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>'+
                    '</div>'+
                    '</tr>';
          }
        }

      $('#showdata').html(html);
      waitingDialog.hide();
      }
    });
  }

  function print(id){
    window.location.href = baseUrl + '/manajemen-pekerja/surat-peringatan/print?id='+id;
  }

</script>
@endsection
