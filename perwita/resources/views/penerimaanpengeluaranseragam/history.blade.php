@extends('main')
@section('title', 'Penerimaan Pengeluaran Seragam')
@section('extra_styles')
<style>
   .popover-navigation [data-role="next"] { display: none; }
   .popover-navigation [data-role="end"] { display: none; }
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>History Penerimaan Pengeluaran Seragam</h2>
      <ol class="breadcrumb">
         <li>
            <a href="{{ url('/') }}">Home</a>
         </li>
         <li>
            Manajemen Seragam
         </li>
         <li>
           Penerimaan Pengeluaran Seragam
         </li>
         <li class="active">
            <strong>History Penerimaan Pengeluaran Seragam</strong>
         </li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
   <div class="ibox-title ibox-info">
      <h5>History Penerimaan Pengeluaran Seragam</h5>
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
                           <td>Nota</td>
                           <td>Penerima</td>
                           <td width="10%">Action</td>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-folder-open modal-icon"></i>
                <h4 class="modal-title">Detail Penerimaan Pengeluaran Seragam</h4>
                <small class="font-bold">Detail penerimaan</small>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="table-modal">
                    <thead>
                        <tr>
                            <th>Nama Seragam</th>
                            <th>Qty</th>
                            <th>Penerima</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

@endsection
@section('extra_scripts')

@include('penerimaan-pembelian/js/history_commander')
<script type="text/javascript">
   var table;
   var tablemodal;
   $(document).ready(function(){
     $( "#search" ).autocomplete({
         source: baseUrl+'/manajemen-seragam/penerimaanpengeluaranseragam/cariHistory',
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

     $('#showdata').html('<tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">Tidak ada data</td></tr>');
     var tgl_awal = $('#tgl_awal').val();
     var tgl_akhir = $('#tgl_akhir').val();
     var nota = $('#searchhidden').val();

     $.ajax({
       url: "{{ url('manajemen-seragam/penerimaanpengeluaranseragam/findHistory') }}",
       type: 'get',
       data: {tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, nota:nota},
       success: function(response){
         table.clear();
         $('#searchhidden').val('');
         for (var i = 0; i < response.length; i++) {
           if (response[i].sisa == 0) {
             table.row.add([
                 response[i].s_nota,
                 response[i].m_name,
                 buttondetail(response[i].s_id)
             ]).draw( false );
           }
         }

       }
     });
     waitingDialog.hide();
   });

   function buttondetail(id){
     var html = '<div align="center"><button type="button" class="btn btn-info btn-xs" onclick="detail('+id+')" name="button"> <i class="fa fa-folder"></i> </button></div>';

     return html;
   }

   function detail(id){
     $.ajax({
       type: 'get',
       data: {id:id},
       dataType: 'json',
       url: baseUrl + '/manajemen-seragam/penerimaanpengeluaranseragam/detail',
       success : function(response){
         tablemodal.clear();
         for (var i = 0; i < response.length; i++) {
           tablemodal.row.add([
               namaseragam(response[i].i_nama, response[i].i_warna, response[i].k_nama, response[i].s_nama),
               response[i].sr_qty,
               response[i].m_name
           ]).draw( false );
         }
         $('#myModal').modal('show');
       }
     });
   }

   function namaseragam(nama, warna, kategori, size){
     var html = '<strong>'+kategori+'</strong> <br> <span>'+nama+' '+warna+' '+size+'</span>';

     return html;
   }
</script>
@endsection
