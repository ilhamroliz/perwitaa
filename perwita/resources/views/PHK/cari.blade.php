@extends('main')

@section('title', 'PHK')

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
        <h2>Cari PHK</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Cari PHK</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Cari PHK</h5>
      <a href="{{url('manajemen-pekerja/phk')}}" style="float: right; margin-top: -7px;" class="btn btn-primary btn-outline btn-flat"><i class="fa fa-plus">&nbsp;</i>Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
              <div class="col-md-12">
                <label for="pencarian">Cari Berdasarkan NIK Pekerja</label>
                <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="Masukkan NIK Pekerja">
              </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                              <th>No. PHK</th>
                              <th>Nama Tenaga Kerja</th>
                              <th>Jabatan</th>
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
                      <h4 class="modal-title">Detail PHK</h4>
                  <small>Detail PHK</small>
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
                    <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Data PHK</span>
                </div>
            </center>
            <div id="showdetail">
              <div class="row">
                <div class="col-lg-12">
                    <h3>No PHK : <span style="font-weight:normal;" id="r_no">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Nama Tenaga Kerja : <span style="font-weight:normal;" id="namapekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Jabatan : <span style="font-weight:normal;" id="jabatanpekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Keterangan : <span style="font-weight:normal;" id="keteranganpekerja">-</span></h3>
                </div>
                <div class="col-lg-12">
                    <h3>Status Approval : <span style="font-weight:normal;" id="approve">-</span></h3>
                </div>
              </div>
            </div>
            </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" name="button" id="printbtn" onclick="print()"><i class="fa fa-print">&nbsp;</i>Print</button>
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
                        <h4 class="modal-title">Edit Remunerasi</h4>
                    <small>Edit Remunerasi</small>
                </div>
              <div class="modal-body">
              <form class="form-edit">
                <div id="showdetail">
                  <div class="row">
                    <div class="col-lg-12">
                        <h3>Keterangan : <input type="text" class="form-control" name="keterangan" id="editketerangan" placeholder="Keterangan"></h3>
                    </div>
                    <div class="col-lg-5">
                        <h3>Gaji Awal : <input type="text" class="form-control" name="gajiawal" id="gajiawal" placeholder="Gaji Awal"></h3>
                    </div>
                    <div class="col-lg-5">
                        <h3>Gaji Terbaru : <input type="text" class="form-control" name="gajiterbaru" id="gajiterbaru" placeholder="Gaji Terbaru"></h3>
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
    url: baseUrl + '/manajemen-pekerja/phk/data',
    dataType: 'json',
    success : function(result){
      var jabatan;

      if (result.status == 'kosong') {
        html = '<tr><td colspan="7"><center>Tidak ada data</center></td></tr>';
      } else {
        for (var i = 0; i < result.length; i++) {
          if (result[i].p_jabatan == 1) {
            jabatan = 'Manager';
          }
          else if (result[i].p_jabatan == 2) {
            jabatan = 'Supervisor';
          }
          else if (result[i].p_jabatan == 3) {
            jabatan = 'Staff';
          }
          else if (result[i].p_jabatan == 4) {
            jabatan = 'Operator';
          } else {
            jabatan = '-';
          }

          html += '<tr>'+
                  '<td>'+result[i].p_no+'</td>'+
                  '<td>'+result[i].p_name+'</td>'+
                  '<td>'+jabatan+'</td>'+
                  '<td>'+result[i].p_keterangan+'</td>'+
                  '<td>'+
                  '<div class="text-center">'+
                    '<a style="margin-left:5px;" title="Detail" type="button" onclick="detail('+result[i].p_id+')"  class="btn btn-info btn-xs"><i class="glyphicon glyphicon-folder-open"></i></a>'+
                    '<a style="margin-left:5px;" title="Kembalikan" type="button" onclick="Kembalikan('+result[i].p_id+')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-repeat"></i></a>'+
                  '</div>'+
                  '</tr>';
        }
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

  function getdata(id){
    waitingDialog.show();
    var html = '';
    $('#showdata').html('');
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/manajemen-pekerja/phk/getcari',
      dataType: 'json',
      success : function(result){
        if (result.status == 'kosong') {
          html = '<tr><td colspan="7"><center>Tidak ada data</center></td></tr>';
        } else {
          for (var i = 0; i < result.length; i++) {
            html += '<tr>'+
                    '<td>'+result[i].p_no+'</td>'+
                    '<td>'+result[i].p_name+'</td>'+
                    '<td>'+result[i].p_jabatan+'</td>'+
                    '<td>'+result[i].p_keterangan+'</td>'+
                    '<td>'+
                    '<div class="text-center">'+
                      '<a style="margin-left:5px;" title="Detail" type="button" onclick="detail('+result[i].p_id+')"  class="btn btn-info btn-xs"><i class="glyphicon glyphicon-folder-open"></i></a>'+
                      '<a style="margin-left:5px;" title="Kembalikan" type="button" onclick="hapus('+result[i].p_id+')"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-repeat"></i></a>'+
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
      url: baseUrl + '/manajemen-pekerja/phk/detail',
      dataType: 'json',
      success : function(result){
        $('#r_no').text(result[0].p_no);
        $('#namapekerja').text(result[0].p_name);
        $('#jabatanpekerja').text(result[0].p_jabatan);
        $('#keteranganpekerja').text(result[0].p_keterangan);
        //
        if (result[0].p_isapproved == 'P') {
          $('#printbtn').hide();
          $('#approve').html('<span class="label label-warning">Pending</span>');
        } else if (result[0].p_isapproved == 'Y') {
          $('#approve').html('<span class="label label-success">Disetujui</span>');
        } else if (result[0].p_isapproved == 'N') {
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
        text: "Apakah anda yakin ingin menghapus data PHK?",
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
            url: baseUrl + '/manajemen-pekerja/phk/hapus',
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
    });
      }, 2000);

    });
  }

  function print(id){
    window.location.href = baseUrl + '/manajemen-pekerja/phk/print?id='+id;
  }

</script>
@endsection
