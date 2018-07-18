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
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Pekerja</label>
                            <div class="col-lg-9">
                                <input type="text" id="spno" placeholder="Masukkan Nama/NIK Pekerja/NIK Mitra" class="form-control" name="spno" value="">
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
                            <label class="col-lg-2 control-label">Tanggal Mulai - Tanggal Berakhir</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control start-date date" name="start" style="text-transform:uppercase" title="Start" placeholder="Start">
                            </div>
                            <div class="col-lg-2">
                                <input type="text" class="form-control end-date date" name="end" style="text-transform:uppercase" title="End" placeholder="End">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Keterangan</label>
                            <div class="col-lg-9">
                                <input type="text" placeholder="Keterangan" class="form-control" name="keterangan" value="">
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="pull-right">
                      <button type="button" id="simpanbtn" onclick="simpan()" class="btn btn-primary" name="button"><i class="fa fa-save">&nbsp;</i>Simpan</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-truck modal-icon"></i>
                <h4 class="modal-title">Tambah Data Supplier</h4>
                <small class="font-bold">Data supplier ini digunakan untuk pembelian barang di fitur Pembelian</small>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" class="btn btn-primary" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div> -->

@endsection

@section('extra_scripts')
<script type="text/javascript">
    $(document).ready(function(){
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
      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
      $.ajax({
        type: 'post',
        data: $('#formtambah').serialize(),
        url: baseUrl + '/manajemen-pekerja/surat-peringatan/simpan/'+id,
        dataType: 'json',
        success : function(result){
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
          $('#namapekerja').val(result[0].p_name);
          $('#jabatanpekerja').val(result[0].p_jabatan);
          $('#divisipekerja').val(result[0].md_name);
          $('#simpanbtn').attr('onclick', 'simpan('+id+')');
        }
      });
    }
</script>
@endsection
