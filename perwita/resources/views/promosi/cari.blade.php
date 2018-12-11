@extends('main')

@section('title', 'Promosi & Demosi')

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
        <h2>Cari Promosi & Demosi</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Cari Promosi & Demosi</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Cari Promosi & Demosi</h5>
      <a href="{{url('manajemen-pekerja/promosi-demosi')}}" style="float: right; margin-top: -7px;" class="btn btn-primary btn-outline btn-flat"><i class="fa fa-plus">&nbsp;</i>Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
              <div class="col-md-12">
                <label for="pencarian">Cari Berdasarkan No Promosi / Demosi Atau Nama Pekerja</label>
                <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="Masukkan No Promosi / Demosi Atau Nama Pekerja">
              </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                              <th>No. Promosi / Demosi</th>
                              <th>Nama</th>
                              <th>Jabatan Lama</th>
                              <th>Jabatan Sekarang</th>
                              <th>NIK</th>
                              <th>NIK Mitra</th>
                              <th>Mitra</th>
                              <th>Divisi</th>
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
                      <h4 class="modal-title">Detail Promosi & Demosi</h4>
                  <small>Detail Promosi & Demosi</small>
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
                    <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Data Promosi & Demosi</span>
                </div>
            </center>
            <div id="showdetail">
              <div class="row">
                <div class="col-lg-12">
                    <h3>No Promosi & Demosi : <span style="font-weight:normal;" id="pd_no">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Nama Tenaga Kerja : <span style="font-weight:normal;" id="namapekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Keterangan : <span style="font-weight:normal;" id="keteranganpekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Status Approval : <span style="font-weight:normal;" id="approve">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Jabatan Lama - Jabatan Baru : <span style="font-weight:normal;" id="jabatan">-</span></h3>
                </div>
              </div>
            </div>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" name="button" onclick="print()" id="printbtn"><i class="fa fa-print">&nbsp;</i>Print</button>
                  <div class="btn-group">
                      <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content animated fadeIn">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <div class="simbol-modal"><i class="fa fa-pencil modal-icon"></i></div>
                  <h4 class="modal-title">Edit Promosi & Demosi</h4>
                  <small class="font-bold sub-tittle"></small>
              </div>
              <div class="modal-body">
                  <div class="spiner-example" style="display: none;">
                      <div class="sk-spinner sk-spinner-wave">
                          <div class="sk-rect1"></div>
                          <div class="sk-rect2"></div>
                          <div class="sk-rect3"></div>
                          <div class="sk-rect4"></div>
                          <div class="sk-rect5"></div>
                      </div>
                  </div>
                  <form class="form-horizontal form-modal" style="margin-top: 10px;">
                      <div class="form-group">
                          <label class="col-lg-4 control-label">Jabatan Sekarang</label>
                          <div class="col-lg-8">
                              <select class="form-control jabatan" name="jabatanBaru" id="jabatanbaru">
                                  <option selected disabled>-- Pilih Jabatan --</option>
                                  @foreach($jabatan as $jabatan)
                                  <option value="{{ $jabatan->jp_id }}" id="{{ $jabatan->jp_id }}">{{ $jabatan->jp_name }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <input type="hidden" name="jenis" class="jenis" value="">
                      <input type="hidden" name="pekerja" class="id_pekerja" value="">
                      <div class="form-group">
                          <label class="col-lg-4 control-label">Keterangan</label>
                          <div class="col-lg-8">
                              <textarea class="form-control keterangan" name="note" id="note"></textarea>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                  <button onclick="update()" class="btn btn-primary" id="updatebtn" type="button">Update</button>
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
    url: baseUrl + '/manajemen-pekerja/promosi-demosi/data',
    dataType: 'json',
    success : function(result){
      if (result.status == 'kosong') {
        html = '<tr><td colspan="9"><center>Tidak ada data</center></td></tr>';
      } else {
        for (var i = 0; i < result.length; i++) {
          html += '<tr>'+
                  '<td>'+result[i].pd_no+'</td>'+
                  '<td>'+result[i].p_name+'</td>'+
                  '<td>'+result[i].pd_jabatan_awal+'</td>'+
                  '<td>'+result[i].pd_jabatan_sekarang+'</td>'+
                  '<td>'+result[i].p_nip+'</td>'+
                  '<td>'+result[i].p_nip_mitra+'</td>'+
                  '<td>'+result[i].m_name+'</td>'+
                  '<td>'+result[i].md_name+'</td>'+
                  '<td>'+
                  '<div class="text-center">'+
                    '<a style="margin-left:5px;" title="Detail" type="button" onclick="detail('+result[i].pd_id+')"  class="btn btn-info btn-xs"><i class="glyphicon glyphicon-folder-open"></i></a>'+
                    '<a style="margin-left:5px;" title="Edit" type="button" onclick="edit('+result[i].pd_id+')"  class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'+
                    '<a style="margin-left:5px;" title="Hapus" type="button" onclick="hapus('+result[i].pd_id+')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>'+
                  '</div>'+
                  '</tr>';
        }
      }
    $('#showdata').html(html);
    }
  });

    $('#pencarian').autocomplete({
        source: baseUrl + '/manajemen-pekerja/promosi-demosi/getno',
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

  function getdata(id){
    waitingDialog.show();
    var html = '';
    $('#showdata').html('');
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/manajemen-pekerja/promosi-demosi/getcari',
      dataType: 'json',
      success : function(result){
        if (result.status == 'kosong') {
          html = '<tr><td colspan="9"><center>Tidak ada data</center></td></tr>';
        } else {
          for (var i = 0; i < result.length; i++) {
            html += '<tr>'+
                    '<td>'+result[i].pd_no+'</td>'+
                    '<td>'+result[i].p_name+'</td>'+
                    '<td>'+result[i].pd_jabatan_awal+'</td>'+
                    '<td>'+result[i].pd_jabatan_sekarang+'</td>'+
                    '<td>'+result[i].p_nip+'</td>'+
                    '<td>'+result[i].p_nip_mitra+'</td>'+
                    '<td>'+result[i].m_name+'</td>'+
                    '<td>'+result[i].md_name+'</td>'+
                    '<td>'+
                    '<div class="text-center">'+
                      '<a style="margin-left:5px;" title="Detail" type="button" onclick="detail('+result[i].pd_id+')"  class="btn btn-info btn-xs"><i class="glyphicon glyphicon-folder-open"></i></a>'+
                      '<a style="margin-left:5px;" title="Edit" type="button" onclick="edit('+result[i].pd_id+')"  class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'+
                      '<a style="margin-left:5px;" title="Hapus" type="button" onclick="hapus('+result[i].pd_id+')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>'+
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
    $('#modal-detail').modal('show');
    $('#showdetail').hide();
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/manajemen-pekerja/promosi-demosi/detail',
      dataType: 'json',
      success : function(result){
        $('#pd_no').text(result[0][0].pd_no);
        $('#namapekerja').text(result[0][0].p_name);
        $('#keteranganpekerja').text(result[0][0].pd_note);
        $('#jabatan').text(result[1][0].jp_name + ' -> ' + result[2][0].jp_name);
        //
        if (result[0][0].pd_isapproved == 'P') {
          $('#printbtn').hide();
          $('#approve').html('<span class="label label-warning">Pending</span>');
        } else if (result[0][0].pd_isapproved == 'Y') {
          $('#approve').html('<span class="label label-success">Disetujui</span>');
        } else if (result[0][0].pd_isapproved == 'N') {
          $('#approve').html('<span class="label label-danger">Ditolak</span>');
        }

        //Button print
        $('#printbtn').attr('onclick', 'print('+id+')');

        $('.spiner-sp').hide();
        $('#showdetail').show();

      }
    });
  }

  function hapus(id){
      swal({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin menghapus data Promosi & Demosi?",
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
            url: baseUrl + '/manajemen-pekerja/promosi-demosi/hapus',
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
    $('#myModal').modal('show');
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/manajemen-pekerja/promosi-demosi/edit',
      dataType: 'json',
      success : function(result){
        $('div.col-lg-8 select').val(result[0].pd_jabatan_sekarang);
        $('#note').val(result[0].pd_note);
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
        type: 'get',
        data: $('.form-modal').serialize(),
        url: baseUrl + '/manajemen-pekerja/promosi-demosi/update/'+id,
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

    function print(id){
      window.location.href = baseUrl + '/manajemen-pekerja/promosi-demosi/print?id='+id;
    }


</script>
@endsection
