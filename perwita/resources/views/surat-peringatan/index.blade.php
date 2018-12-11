@extends('main')

@section('title', 'SP Pekerja')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
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
    <div class="ibox-title ibox-info">
        <h5>Surat Peringatan</h5>
        <a href="{{ url('manajemen-pekerja/surat-peringatan/cari') }}" style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-info btn-flat" type="button"><i class="fa fa-search"></i>&nbsp;Cari</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <form class="form-horizontal" id="formtambah">
                        <!-- <div class="form-group">
                            <label class="col-lg-2 control-label">Nomor SP</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Nomor SP" class="form-control" name="nosp" value="">
                            </div>
                        </div> -->
                        <div class="alert alert-info alert-dismissable" style="display:none;" id="pemberitahuan">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <a class="alert-link">Pemberitahuan</a><span id="isipemberitahuan">Pekerja ini dalam masa ... sampai ... </span>.
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Pekerja</label>
                            <div class="col-lg-9">
                                <input type="text" id="spno" style="text-transform:uppercase;" placeholder="Masukkan Nama/NIK Pekerja/NIK Mitra" class="form-control" name="spno" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama Tenaga Kerja</label>
                            <div class="col-lg-9">
                                <input type="text" id='namapekerja' placeholder="Nama Tenaga Kerja" class="form-control" name="namapekerja" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jabatan</label>
                            <div class="col-lg-9">
                                <input type="text" id="jabatanpekerja" placeholder="Jabatan" class="form-control" name="jabatanpekerja" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Divisi</label>
                            <div class="col-lg-9">
                                <input type="text" id="divisipekerja" placeholder="Divisi" class="form-control" name="divisipekerja" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tanggal Mulai</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control start-date date" name="start" style="text-transform:uppercase" title="Start" placeholder="Start">
                            </div>
                            <label class="col-lg-2 control-label">Tanggal Berakhir</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control end-date date" name="end" style="text-transform:uppercase" title="End" placeholder="End">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="sp">Jenis SP</label>
                            <div class="col-lg-9">
                                <select class="form-control sp" name="sp" id="sp">
                                  <option value="Surat Teguran">Surat Teguran</option>
                                  <option value="SP1">SP1</option>
                                  <option value="SP2">SP2</option>
                                  <option value="SP3">SP3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Pelanggaran</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="pelanggaran[]" id="pelanggarantext" onclick="daftarpelanggaran()" placeholder="Pelanggaran">
                            </div>
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-primary dinamis" name="button" onclick="plus()"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="dinamis div" id="showdinamis">
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Keterangan</label>
                            <div class="col-lg-9">
                                <input type="text" placeholder="Keterangan" class="form-control" name="keterangan" value="">
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="pull-right" style="margin-right:20px;">
                      <button type="button" id="simpanbtn" onclick="simpan()" class="btn btn-primary" name="button"><i class="fa fa-save">&nbsp;</i>Simpan</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


                            <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <i class="fa fa-user-times modal-icon"></i>
                                        <h4 class="modal-title">Daftar Pelanggaran</h4>
                                        <small>Daftar Pelanggaran</small>
                                        </div>
                                        <div class="modal-body">
                                          <table class="table table-hover table-bordered table-stripped" id="tabelpelanggaran">
                                              <thead>
                                                  <tr>
                                                    <th>Kategori</th>
                                                    <th>Nama Pelanggaran</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                @foreach($data as $x)
                                                <tr onclick="pilihpelanggaran({{$x->ms_id}})" class="num" num="0" style="cursor:pointer;">
                                                  <td>{{$x->ms_kategori}}</td>
                                                  <td>{{$x->ms_keterangan}}</td>
                                                </tr>
                                                @endforeach
                                              </tbody>
                                          </table>
                                        </div>
                                        <div class="modal-footer">
                                          <p style="float:left;">Note: Untuk memilih pelanggaran, klik salah satu daftar pelanggaran </p>
                                          <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


@endsection

@section('extra_scripts')
<script type="text/javascript">
var num = 1;
var table;
    $(document).ready(function(){

        table = $("#tabelpelanggaran").DataTable({
          "processing": true,
          "searching": true,
          "paging": false,
          "deferLoading": 57,
          responsive: true,
          "language": dataTableLanguage
        });

      $('.date').datepicker({
          autoclose: true,
          format: 'dd/mm/yyyy'
      });

      $("#spno").autocomplete({
        source: baseUrl + '/manajemen-pekerja/surat-peringatan/getsp',
        select: function(event, ui) {
          getdata(ui.item.id);
        }
      });
    });

    function simpan(id){
      waitingDialog.show();
      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
      $.ajax({
        type: 'get',
        data: $('#formtambah').serialize(),
        url: baseUrl + '/manajemen-pekerja/surat-peringatan/simpan/'+id,
        dataType: 'json',
        timeout: 10000,
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
            swal({
                title: "SP Disimpan",
                text: "SP Berhasil Disimpan",
                type: "success",
                showConfirmButton: false,
                timer: 900
            });
            setTimeout(function(){
                  window.location.reload();
          }, 850);
          }
        },  error: function (x, e) {
            waitingDialog.hide();
            var message;
            if (x.status == 0) {
                message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
            } else if (x.status == 404) {
                message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
            } else if (x.status == 500) {
                message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
            } else if (e == 'parsererror') {
                message = 'Error.\nParsing JSON Request failed.';
            } else if (e == 'timeout') {
                message = 'Request Time out. Harap coba lagi nanti';
            } else {
                message = 'Unknow Error.\n' + x.responseText;
            }
            waitingDialog.hide();
            throwLoadError(message);
            //formReset("store");
        }
      });
    }

    function getdata(id){
      $.ajax({
        type: 'get',
        data: {id:id},
        url: baseUrl + '/manajemen-pekerja/surat-peringatan/getdata',
        dataType: 'json',
        success : function(result){
          $('#namapekerja').val(result.data[0].p_name);
          $('#jabatanpekerja').val(result.data[0].p_jabatan);
          $('#divisipekerja').val(result.data[0].md_name);

          //Button
          $('#simpanbtn').attr('onclick', 'simpan('+id+')');

          if (result.sp[0] == null) {

          } else {
            $('#isipemberitahuan').text(' Pekerja ini dalam masa '+result.sp[0].sp_jenis+' sampai '+result.sp[0].sp_date_end+'');
            $('#pemberitahuan').css('display','');
            setTimeout(function(){
              $('#pemberitahuan').css('display','none');
            }, 10000)
          }
        }
      });
    }

    function plus(){

      $('#showdinamis').append('<div class="form-group dinamis'+num+'">'+
          '<label class="col-lg-2 control-label"></label>'+
          '<div class="dinamis div">'+
          '<div class="col-lg-8">'+
              '<input type="text" class="form-control" onclick="daftarpelanggaran('+num+')" id="pelanggarantext'+num+'" name="pelanggaran[]" placeholder="Pelanggaran">'+
          '</div>'+
          '<div class="col-lg-2">'+
              '<button type="button" class="btn btn-primary dinamis" name="button" onclick="plus()"><i class="fa fa-plus"></i></button>'+
              ' '+
              '<button type="button" class="btn btn-danger dinamis" name="button" onclick="minus('+num+')"><i class="fa fa-minus"></i></button>'+
          '</div>'+
          '</div>'+
      '</div>');

      num += 1;
    }

    function minus(num){
      $('.dinamis'+num).remove();
    }

    function daftarpelanggaran(num){
        $('#myModal5').modal('show');
        if(num == undefined){

        } else {
          $('.num').attr('num', ''+num+'');
        }
        $("input[type=search]").css('width', '350px');
    }

    function pilihpelanggaran(id){
      waitingDialog.show();
      var num = $('.num').attr('num');
        $.ajax({
          type: 'get',
          data: {id:id},
          url: baseUrl + '/manajemen-pekerja/surat-peringatan/getpelanggaran',
          dataType: 'json',
          success : function(result){
            if (num == 0) {
              $('#pelanggarantext').val(result[0].ms_keterangan);
              $('#myModal5').modal('hide');
            } else {
              $('#pelanggarantext'+num+'').val(result[0].ms_keterangan);
              $('#myModal5').modal('hide');
            }
            waitingDialog.hide();
          }
        });
    }


</script>
@endsection
