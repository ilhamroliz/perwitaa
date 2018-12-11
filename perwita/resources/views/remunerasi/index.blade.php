@extends('main')

@section('title', 'Remunerasi')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Remunerasi</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Remunerasi</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Remunerasi</h5>
        <a href="{{ url('manajemen-pekerja/remunerasi/cari') }}" style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-info btn-flat" type="button"><i class="fa fa-search"></i>&nbsp;Cari</a>
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
                        <!-- <div class="alert alert-info alert-dismissable" style="display:none;" id="pemberitahuan">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <a class="alert-link">Pemberitahuan</a><span id="isipemberitahuan">Pekerja ini dalam masa ... sampai ... </span>.
                        </div> -->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No NIK</label>
                            <div class="col-lg-9">
                                <input type="text" id='nonik' placeholder="No NIK Pekerja" style="text-transform:uppercase" class="form-control" name="nonik" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama Pekerja</label>
                            <div class="col-lg-9">
                                <input type="text" readonly id="namapekerja" placeholder="Nama Pekerja" style="text-transform:uppercase" class="form-control" name="namapekerja" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jabatan</label>
                            <div class="col-lg-9">
                                <input type="text" readonly id="jabatanpekerja" class="form-control" name="jabatanawal" style="text-transform:uppercase" title="Jabatan" placeholder="Jabatan">
                            </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Gaji Awal</label>
                          <div class="col-lg-3">
                              <input type="text" class="form-control" name="gajiawal" style="text-transform:uppercase" id="gajiawal" placeholder="Gaji Awal">
                          </div>
                          <label class="col-lg-2 control-label">Gaji Terbaru</label>
                          <div class="col-lg-3">
                              <input type="text" class="form-control" name="gajiterbaru" style="text-transform:uppercase" id="gajiterbaru" placeholder="Gaji Terbaru">
                          </div>
                        </div>
                        <div class="dinamis div" id="showdinamis">
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Keterangan</label>
                            <div class="col-lg-9">
                                <input type="text" placeholder="Keterangan" class="form-control" style="text-transform:uppercase" name="keterangan" value="">
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="pull-right" style="margin-right:20px;">
                      <button type="button" id="simpanbtn" disabled onclick="simpan()" class="btn btn-primary btn-outline" name="button"><i class="fa fa-save">&nbsp;</i>Simpan</button>
                    </div>
                </div>
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
      $("#nonik").autocomplete({
        source: baseUrl + '/manajemen-pekerja/remunerasi/carino',
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
        type: 'post',
        data: $('#formtambah').serialize(),
        url: baseUrl + '/manajemen-pekerja/remunerasi/simpan/'+id,
        dataType: 'json',
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
            Command: toastr["success"]("Berhasil Disimpan, Menunggu approval manager!", "Info !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
          }
          $('input[type=text]').val('');
          $('#simpanbtn').prop('disabled', true);
        }
      });
    }

    function getdata(id){
      waitingDialog.show();
      $.ajax({
        type: 'get',
        url: baseUrl + '/manajemen-pekerja/remunerasi/getdata',
        data: {id:id},
        dataType: 'json',
        success : function(result){
          if (result.status == 'kosong') {
            waitingDialog.hide();
          }
          $('#namapekerja').val(result[0].p_name);
          $('#jabatanpekerja').val(result[0].p_jabatan);

          //Button
          $('#simpanbtn').attr('onclick', 'simpan('+id+')');
          $('#simpanbtn').prop('disabled', false);

          waitingDialog.hide();
        }
      });
    }

    $('#gajiawal').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
    $('#gajiterbaru').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

</script>
@endsection
