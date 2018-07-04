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
        <h2>Mitra MOU</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Mitra
            </li>
            <li class="active">
                <strong>Mitra MOU</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Data MOU Mitra</h5>
        <button style="float: right; margin-top: -7px;" onclick="tambah()" class="btn btn-primary btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
        <a href="{{ url('manajemen-pekerja-mitra/data-pekerja-mitra/cari') }}" style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-search"></i>&nbsp;Cari</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                        
                </div>
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">                    
                </div>
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">                    
                   <table id="mou" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nama Mitra</th>
                                <th>No MOU</th>
                                <th>Mulai</th>            
                                <th>Berakhir</th> 
                                <th>Sisa</th>          
                                <th>Aksi</th>            
                            </tr>
                        </thead>     
                        <tbody>                       
                        </tbody>
                    </table>
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
                <i class="fa fa-calendar modal-icon"></i>
                <h4 class="modal-title">Perpanjang MOU</h4>
                <small class="font-bold">Memperpanjang MOU mitra perusahaan</small>
            </div>
            <div class="modal-body">
                <div class="input-daterange input-group col-md-12 isimodal" id="datepicker" style="display: none">
                    <input type="text" class="input-sm form-control awal" name="start" value="05/06/2014"/>
                    <span class="input-group-addon">sampai</span>
                    <input type="text" class="input-sm form-control akhir" name="end" value="05/09/2014" />
                </div>
                <div class="spiner-example spin">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="update()">Update</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('extra_scripts')
<script type="text/javascript">
  var table;
  var idPublic;
  var detailPublic;
  $(document).ready(function(){
      setTimeout(function(){
          $.ajaxSetup({
              headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
          });
          table = $("#mou").DataTable({
              processing: true,
              serverSide: true,
              "ajax": {
                    "url": "{{ url('manajemen-mitra/mitra-mou/table') }}",
                    "type": "get"
                },
              dataType: 'json',
              columns: [
                  {data: 'm_name', name: 'm_name'},
                  {data: 'mm_mou', name: 'mm_mou'},
                  {data: 'mm_mou_start', name: 'mm_mou_start'},
                  {data: 'mm_mou_end', name: 'mm_mou_end'},
                  {data: 'sisa', name: 'sisa'},
                  {data: 'action', name: 'action',orderable:false,searchable:false}
              ],
              responsive: true,        
              "pageLength": 10,
              "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
              "language": dataTableLanguage,
          });
      },1500);
  });

  function perpanjang(id, detail){
    idPublic = id;
    detailPublic = detail;
    $.ajax({
        url: baseUrl + '/manajemen-mitra/mitra-mou/get-tgl-mou',
        type: 'get',
        data: { id: id, detail: detail },
        success: function(response){
          var awal = response[0].mm_mou_start;
          var akhir = response[0].mm_mou_end;
          $('.awal').val(awal);
          $('.akhir').val(akhir);
          $('.spin').css('display', 'none');
          $('.isimodal').show();
          $('.input-daterange').datepicker({
              keyboardNavigation: false,
              forceParse: false,
              autoclose: true,
              format: 'dd/mm/yyyy'
          });
      }, error:function(x, e) {
          if (x.status == 0) {
              alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
          } else if (x.status == 404) {
              alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
          } else if (x.status == 500) {
              alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
          } else if (e == 'parsererror') {
              alert('Error.\nParsing JSON Request failed.');
          } else if (e == 'timeout'){
              alert('Request Time out. Harap coba lagi nanti');
          } else {
              alert('Unknow Error.\n' + x.responseText);
          }
        }
    });
  }

  function update(){
    var awal = $('.awal').val();
    var akhir = $('.akhir').val();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    $.ajax({
        url: baseUrl + '/manajemen-mitra/mitra-mou/update-mou',
        type: 'get',
        data: { id: idPublic, detail: detailPublic, awal: awal, akhir: akhir },
        success: function(response){
          if (response.status == 'berhasil') {
            swal({
              title: "Sukses",
              text: "Data sudah tersimpan",
              type: "success"
            },function () {
                table.ajax.reload();
                $('#myModal').modal('hide');
            });
          }
      }, error:function(x, e) {
          if (x.status == 0) {
              alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
          } else if (x.status == 404) {
              alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
          } else if (x.status == 500) {
              alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
          } else if (e == 'parsererror') {
              alert('Error.\nParsing JSON Request failed.');
          } else if (e == 'timeout'){
              alert('Request Time out. Harap coba lagi nanti');
          } else {
              alert('Unknow Error.\n' + x.responseText);
          }
        }
    });
  }
</script>
@endsection