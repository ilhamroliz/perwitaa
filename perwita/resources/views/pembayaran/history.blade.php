@extends('main')
@section('title', 'Pembayaran Seragam')
@section('extra_styles')
<style>
   .popover-navigation [data-role="next"] { display: none; }
   .popover-navigation [data-role="end"] { display: none; }
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>History Pembayaran Seragam</h2>
      <ol class="breadcrumb">
         <li>
            <a href="{{ url('/') }}">Home</a>
         </li>
         <li>
            Manajemen Seragam
         </li>
         <li>
           Penerimaan Pembayaran Seragam
         </li>
         <li class="active">
            <strong>History Pembayaran Seragam</strong>
         </li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
   <div class="ibox-title ibox-info">
      <h5>History Pembayaran Seragam</h5>
   </div>
   <div class="ibox">
      <div class="ibox-content">
         <div class="row form-group">
            <div class="col-lg-12 col-md-12 col-sm-12">
               <label class="col-lg-12 col-form-label alamraya-no-padding">Tanggal</label>
               <div class="form-group col-md-12">
                  <div class="col-md-4">
                    <div class="input-daterange input-group " id="date-range" style="">
                        <input type="text" class="form-control" id="tgl_awal" name="tgl_awal" value="">
                        <span class="input-group-addon bg-custom text-white b-0">to</span>
                        <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <input type="text" id="search" class="form-control" name="search" placeholder="Cari Nota">
                    <input type="hidden" name="searchhidden" id="searchhidden">
                  </div>
                   <div class="col-md-2">
                      <span class="input-group-append">
                      <button type="button" class="btn btn-primary btn-sm icon-btn ml-2" id="hist_search">
                      <i class="fa fa-search"></i>
                      </button>
                      </span>
                   </div>
                </div>
            </div>
         </div>
         <div class="row m-b-lg">
            <div class="col-md-12">
               <div class="input-group col-md-8">
               </div>
               <div class="table-responsive" style="margin-top: 25px;">
                  <table class="table table-responsive table-striped table-bordered" id="history">
                     <thead>
                       <tr>
                         <th>Nota</th>
                         <th>Tanggal</th>
                         <th>Seragam</th>
                         <th>Mitra</th>
                         <th>Jumlah</th>
                         <th>Aksi</th>
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
</div>

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-money modal-icon"></i>
                <h4 class="modal-title">Detail Pembayaran</h4>
                <small class="font-bold">Detail pembayaran pekerja</small>
            </div>
            <div class="modal-body">
                <h3 class="namabarang"></h3>
                <form class="form-horizontal">
                    <div class="form-group">
                        <table class="table table-responsive table-striped table-bordered table-hover" id="detilpembayaran">
                          <thead>
                            <tr>
                              <th style="width: 40%;" class="col-md-5">Nama</th>
                              <th style="width: 30%;" class="col-md-4">Tanggal</th>
                              <th style="width: 30%;" class="col-md-3">Jumlah Pembayaran</th>
                              <th style="width: 30%;" class="col-md-3">Pegawai</th>
                            </tr>
                          </thead>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

@endsection
@section('extra_scripts')
<script type="text/javascript">
   var table;
   var tablemodal;
   $(document).ready(function(){
     $( "#search" ).autocomplete({
         source: baseUrl+'/manajemen-seragam/pembayaran-seragam/findHistory',
         minLength: 2,
         select: function(event, data) {
             getData(data.item);
         }
     });

     table = $('#history').DataTable({
       language: dataTableLanguage
     });

     tablemodal = $('#table-modal').DataTable({
       language: dataTableLanguage
     });

     $('#date-range').datepicker({
                toggleActive: true,
                autoclose: true,
                todayHighlight: true,
                format: "dd/mm/yyyy"
            });

   });

   function getData(data){
     $('#searchhidden').val(data.id);
   }

   $('#hist_search').on('click', function(){
     waitingDialog.show();

     var tgl_awal = $('#tgl_awal').val();
     var tgl_akhir = $('#tgl_akhir').val();
     var nota = $('#searchhidden').val();

     $.ajax({
       url: "{{ url('manajemen-seragam/pembayaran-seragam/cariHistory') }}",
       type: 'get',
       data: {tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, nota:nota},
       success: function(response){
         $('#showdata').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');
         table.clear();
         for (var i = 0; i < response.length; i++) {
           if (response[i].tagihan == 0) {
             table.row.add([
                 response[i].s_nota,
                 response[i].s_date,
                 response[i].i_nama,
                 response[i].m_name,
                 response[i].jumlah,
                 buttondetail(response[i].s_nota)
             ]).draw( false );
           }
         }

       }
     });
     waitingDialog.hide();
   });

   function buttondetail(id){
     var html = '<div class="text-center">'+
                '<button onclick="goBayar(\''+id+'\')" style="margin-left:5px;" title="Bayar" type="button" class="btn btn-info btn-xs"><i class="fa fa-credit-card-alt"></i> Bayar</button>'+
                '</div>';

     return html;
   }

   function goBayar(nota){
     var link = baseUrl + '/manajemen-seragam/pembayaran-seragam/history';
     var status = 'history';
     window.location.href = baseUrl+"/manajemen-seragam/pembayaran-pekerja?nota="+nota+'&link='+link+'&status='+status;
   }
</script>
@endsection
