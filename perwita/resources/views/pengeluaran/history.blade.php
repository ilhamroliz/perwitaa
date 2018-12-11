@extends('main')
@section('title', 'Pengeluaran Seragam')
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

<div class="modal inmodal" id="modaldet" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-shopping-cart modal-icon"></i>
                <h4 class="modal-title">Pengeluaran Seragam</h4>
                <small class="font-bold">Detail Pengeluaran Seragam</small>
            </div>
            <div class="modal-body">
                <div class="spiner-example spin">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
                <div class="bagian">
                <div class="table-responsive m-t">
                            <table class="table invoice-table">
                                <thead>
                                <tr>
                                    <th>Item List</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Discount</th>
                                    <th>Total Price</th>
                                </tr>
                                </thead>
                                <tbody id="isi">

                                </tbody>
                            </table>
                        </div>
                        <table class="table invoice-total">
                            <tbody id="foo">
                              <tr>
                                  <td><strong>Sub Total :</strong></td>
                                  <td class="rp" id="subtotal"></td>
                              </tr>
                              <tr>
                                  <td><strong>TAX :</strong></td>
                                  <td class="rp" id="pajak"></td>
                              </tr>
                              <tr>
                                  <td><strong>TOTAL :</strong></td>
                                  <td class="rp" id="total"></td>
                              </tr>
                            </tbody>
                        </table>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="printbtn" name="button" onclick="print()"><i class="fa fa-print">&nbsp;</i>Print</button>
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
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

   function detail(id){
     $("#modaldet").modal('show');
     $(".bagian").hide();
     var atas = '';
     $.ajax({
       type: 'get',
       data: {id:id},
       url: baseUrl + '/manajemen-penjualan/detail',
       dataType: 'json',
       success : function(result){
         if (result.length == 1) {
           atas += '<tr>'+
               '<td><div><strong>'+result[0].k_nama+'</strong></div>'+
               '<small>'+result[0].i_nama+' Warna '+result[0].i_warna+ ' Ukuran '+result[0].s_nama+'</small></td>'+
               '<td>'+result[0].sd_qty+'</td>'+
               '<td class="rp">Rp. '+result[0].sd_value+'</td>'+
               '<td class="rp">Rp. '+result[0].sd_disc_value+'</td>'+
               '<td class="rp">Rp. '+result[0].sd_total_net+'</td>'+
           '</tr>';
         } else {
           for (var i = 0; i < result.length; i++) {
             atas += '<tr>'+
                 '<td><div><strong>'+result[i].k_nama+'</strong></div>'+
                 '<small>'+result[i].i_nama+' Warna '+result[i].i_warna+ ' Ukuran '+result[i].s_nama+'</small></td>'+
                 '<td>'+result[i].sd_qty+'</td>'+
                 '<td class="rp">Rp. '+result[i].sd_value+'</td>'+
                 '<td class="rp">Rp. '+result[i].sd_disc_value+'</td>'+
                 '<td class="rp">Rp. '+result[i].sd_total_net+'</td>'+
             '</tr>';
           }
         }
         $('.spin').css('display', 'none');
         $(".bagian").show();
         $('#isi').html(atas);
         $("#subtotal").text('Rp. '+result[0].s_total_gross);
         $("#pajak").text('Rp. '+result[0].s_pajak);
         $("#total").text('Rp. '+result[0].s_total_net);
         $(".rp").digits();

         //Button
         $('#printbtn').attr('onclick','print('+id+')');

       }
     });
   }
</script>
@endsection
