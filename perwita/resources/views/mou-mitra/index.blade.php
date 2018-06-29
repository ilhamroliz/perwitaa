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
                                <th style="width: 8%;">Aksi</th>            
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



@endsection

@section('extra_scripts')
<script type="text/javascript">
  var table;
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
                    "type": "POST"
                },
              dataType: 'json',
              columns: [
                  {data: 'mc_no', name: 'mc_no', orderable:false},
                  {data: 'mc_date', name: 'mc_date'},
                  {data: 'mc_expired', name: 'mc_expired'},
                  {data: 'c_name', name: 'c_name'},
                  {data: 'm_name', name: 'm_name'},
                  {data: 'md_name', name: 'md_name'},
                  //{data: 'm_address', name: 'm_address'},
                  {data: 'mc_need', name: 'mc_need'},
                  {data: 'mc_fulfilled', name: 'mc_fulfilled'},            
                  {data: 'action', name: 'action',orderable:false,searchable:false}
              ],
              responsive: true,        
              "pageLength": 10,
              "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
              "language": dataTableLanguage,
          });
          /*table
              .column( '0:visible' )
              .order( 'desc' )
              .draw();*/
      },1500);
  });
</script>
@endsection