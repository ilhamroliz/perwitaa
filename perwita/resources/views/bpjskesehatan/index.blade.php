@extends('main')

@section('title', 'BPJS Kesehatan')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>BPJS Kesehatan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Ansuransi
            </li>
            <li class="active">
                <strong>BPJS Kesehatan</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>BPJS Kesehatan</h5>
        <a href="{{ url('manajemen-bpjs/ansuransi/cari') }}" style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-info btn-flat" type="button"><i class="fa fa-search"></i>&nbsp;Cari</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <form class="form-horizontal" id="formtambah">
                      <input type="hidden" name="b_faskes" id='b_faskes'>
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
                            <label class="col-lg-2 control-label">No BPJS</label>
                            <div class="col-lg-9">
                                <input type="text" id='nobpjs' placeholder="No NIK BPJS" style="text-transform:uppercase" class="form-control" name="nobpjs" value="">
                            </div>
                        </div>
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
                            <label class="col-lg-2 control-label">Fasilitas Kesehatan</label>
                            <div class="col-lg-9">
                                <input type="text" id="faskes" class="form-control" name="faskes" style="text-transform:uppercase"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Poli Umum</label>
                            <div class="col-lg-9">
                                <input type="text" id="polimum" class="form-control" name="polimum" style="text-transform:uppercase" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Poli Gigi</label>
                            <div class="col-lg-9">
                                <input type="text" id="poligi" class="form-control" name="poligi" style="text-transform:uppercase" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kelas</label>
                            <div class="col-lg-9">
                                <select class="form-control" id="kelas" name="kelas">
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Terhitung Mulai Tanggal (TMT)</label>
                            <div class="col-lg-9">
                                <input type="text" id="tmt" class="form-control" name="tmt" style="text-transform:uppercase" placeholder="dd/mm/YYYY">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Iuran</label>
                            <div class="col-lg-9">
                                <input type="text" id="iuran" class="form-control" name="iuran" readonly placeholder="">
                            </div>
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


@endsection

@section('extra_scripts')
<script type="text/javascript">
var num = 1;
var table;
    $(document).ready(function(){

      $("#nonik").autocomplete({
        source: baseUrl + '/manajemen-pekerja/phk/carino',
        select: function(event, ui) {
          getdata(ui.item.id);
        }
      });

      $('#kelas').select2();

      $('#tmt').datepicker({
          keyboardNavigation: false,
          forceParse: false,
          autoclose: true,
          format: 'dd/mm/yyyy'
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
        url: baseUrl + '/manajemen-bpjs/ansuransi/simpan/'+id,
        dataType: 'json',
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
            swal({
                title: "Berhasil",
                text: "Simpan Data BPJS Kesehatan Berhasil Disimpan",
                type: "success",
                showConfirmButton: false,
                timer: 900
            });
          } else if (result.status == 'ada') {
            swal({
                title: "Gagal",
                text: "Data BPJS kesehatan dengan pekerja yang sama sudah ada, jika ingin menginput data dengan pekerja ini, anda harus menonaktifkan data sebelumnya!",
                type: "warning",
                showConfirmButton: true,
            });
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
        url: baseUrl + '/manajemen-pekerja/phk/getdata',
        data: {id:id},
        dataType: 'json',
        success : function(result){
          if (result.status == 'kosong') {
            waitingDialog.hide();
          }
          $('#namapekerja').val(result[0].p_name);
          $('#jabatanpekerja').val(result[0].p_jabatan);
          $('#iuran').val('Rp. '+accounting.formatMoney(result[0].bpjskes, "", 0, ".", ","));

          //Button
          $('#simpanbtn').attr('onclick', 'simpan('+id+')');
          $('#simpanbtn').prop('disabled', false);

          waitingDialog.hide();
        }
      });
    }

</script>
@endsection
