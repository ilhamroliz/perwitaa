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
      <h2>History Pengeluaran</h2>
      <ol class="breadcrumb">
         <li>
            <a href="{{ url('/') }}">Home</a>
         </li>
         <li>
            Manajemen Seragam
         </li>
         <li>
             Pengeluaran Seragam
         </li>
         <li class="active">
            <strong>History Pengeluaran</strong>
         </li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
   <div class="ibox-title ibox-info">
      <h5>History Pengeluaran</h5>
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
                    <input type="text" id="search" class="form-control" name="search" placeholder="Cari Berdasarkan Nota">
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
                           <th>Tanggal</th>
                           <th>Mitra</th>
                           <th>Nota</th>
                           <th>Total</th>
                           <th>Status</th>
                           <th>Action</th>
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

@endsection
@section('extra_scripts')

@include('penerimaan-pembelian/js/history_commander')
<script type="text/javascript">
   var table;
   $(document).ready(function(){
     $( "#search" ).autocomplete({
         source: baseUrl+'/manajemen-seragam/cariHistory',
         minLength: 2,
         select: function(event, data) {
             getData(data.item);
         }
     });

     table = $('#history').DataTable({
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

     $('#showdata').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');
     var tgl_awal = $('#tgl_awal').val();
     var tgl_akhir = $('#tgl_akhir').val();
     var nota = $('#searchhidden').val();

     $.ajax({
       url: "{{ url('manajemen-seragam/findHistory') }}",
       type: 'get',
       data: {tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, nota:nota},
       success: function(response){
         $('#searchhidden').val('');
         table.clear();
         for (var i = 0; i < response.length; i++) {
             table.row.add([
                 response[i].s_date,
                 response[i].m_name,
                 response[i].s_nota,
                 'Rp. '+accounting.formatMoney(response[i].s_total_net, "", 0, ".", ","),
                 '<div class="text-center"><span class="label label-success ">Disetujui</span></div>',
                 buttondetail(response[i].s_id)
             ]).draw( false );
         }
       }
     });
     waitingDialog.hide();
   });

   function buttondetail(id){
     var html = '<div align="center"><button type="button" class="btn btn-info btn-xs" onclick="detail('+id+')" name="button"> <i class="fa fa-folder"></i> </button></div>';

     return html;
   }
</script>
@endsection
