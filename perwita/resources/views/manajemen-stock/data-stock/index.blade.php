@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')



@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Mutasi Stock </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Manajemen Stock</a>
                        </li>
                        <li class="active">
                            <strong>Data Stock</strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
                    <h5>Data Seragam</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
  </div>
    <div class="ibox">
        <div class="ibox-content">
          <div class="row">
                  <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
               
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                <div style="margin-left:-30px;">
                  <div class="col-md-1 col-sm-2 col-xs-12">
                    <label class="tebal">Filter : </label>
                  </div>

                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <select class="form-control chosen-select-width pull-right" name="barang" style="width:50%; cursor: pointer;" id="barang">
                            <option value="null" selected>--Semua Seragam--</option>
                        @foreach($databarang as $seragam)
                            <option value="{{ $seragam->i_id }}">  {{ $seragam->i_nama }}</option>
                        @endforeach
                      </select>
                      <select class="form-control chosen-select-width" name="gudang" style="width:45%; cursor: pointer;" id="gudang">
                            <option value="null" selected>--Semua Pemilik--</option>
                        @foreach($datagudang as $pemilik)
                            <option value="{{ $pemilik->c_id }}">  {{ $pemilik->c_name }}</option>
                        @endforeach
                      </select>
                  </div>
                    <button class="btn btn-info btn-md btn-flat " type="button" id="filter">Filter Cari</button> 
                 </div>
                </div>
                   
              </div>
             
                <div class="box-body">
                  <table id="data" class="table table-bordered table-striped data" style="width:100%">
                    <thead>
                     <tr>
                          <th style="text-align: center;" >NAMA SERAGAM</th>
                          <th style="text-align: center;" >UKURAN</th>
                          <th style="text-align: center;" >POSISI</th>
                          <th style="text-align: center;" >MITRA</th>
                          <th style="text-align: center;" >QTY</th>
                      </tr>
                    </thead>
                    <tbody>          
                    </tbody>           
                  </table>
                </div><!-- /.box-body -->
                <div class="footer">
                  <div class="pull-right">

                    </div>
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
        </div>
    </div>
</div>


@endsection

@section('extra_scripts')
<script type="text/javascript">

$(document).ready(function() {


         var myTable = $('#data').dataTable({

          "ordering": true,
          "searching": true,
          "responsive":true,
          "pageLength": 10,
          "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
          "language": {
              "searchPlaceholder": "Cari Data",
              "emptyTable": "Tidak ada data",
              "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
              "infoFiltered" : "",
              "sSearch": '<i class="fa fa-search"></i>',
              "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
              "infoEmpty": "",
              "zeroRecords": "Data tidak ditemukan",
              "paginate": {
                      "previous": "Sebelumnya",
                      "next": "Selanjutnya",
                  }
            },

          "ajax":{
                "url" : baseUrl + "/manajemen-stock/data-stock/tabel",
                "type": "GET",
                
          },
           "columns": [
              { "data": "i_nama" },
              { "data": "s_nama" },
              { "data": "c_name" },
              { "data": "m_name" },
              { "data": "s_qty" },
              ]


      });


    $(document).on('click','#filter',function(){
      var kodegudang = $('#gudang').val();
      var kodebarang = $('#barang').val();

      $('#data').dataTable().fnDestroy();
      waitingDialog.show();
      myTable = $('#data').dataTable({

          "ordering": true,
          "searching": true,
          "responsive":true,
          "pageLength": 10,
          "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
          "language": {
              "searchPlaceholder": "Cari Data",
              "emptyTable": "Tidak ada data",
              "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
              "infoFiltered" : "",
              "sSearch": '<i class="fa fa-search"></i>',
              "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
              "infoEmpty": "",
              "zeroRecords": "Data tidak ditemukan",
              "paginate": {
                      "previous": "Sebelumnya",
                      "next": "Selanjutnya",
                  }
            },

          "ajax":{
                "data": {gudang: kodegudang, barang: kodebarang},
                "url" : baseUrl + "/manajemen-stock/data-stock/tabel2",
                "type": "GET",
                
          },
           "columns": [
              { "data": "i_nama" },
              { "data": "s_nama" },
              { "data": "c_name" },
              { "data": "m_name" },
              { "data": "s_qty" },
              ]


      });
    waitingDialog.hide();

    }); 

   
    
  
    $("#barang").chosen();
    $("#gudang").chosen();
});

</script>
@endsection