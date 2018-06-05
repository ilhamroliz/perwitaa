@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
                    <h5>Data Mitra</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                
                        <div class="text-right">
                            <button onclick="tambah()" class="btn btn-primary btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>                            
                            {{--<button onclick="edit()" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-edit"></i> Ubah</button>
                            <button class="btn btn-danger btn-flat btn-sm" type="button"><i class="fa fa-trash"></i> Hapus</button>--}}
                        </div>
                        
                </div>
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">                    
                </div>
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">                    
                   <table id="mitra" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>   
                                
     
                                
                                
                                
                                <th>No</th>            
                                <th>No Kotrak</th>            
                                <th>Tanggal Kontrak</th>            
                                <th>Kontrak Selesai</th>            
                                <th>Nama Perusahaan</th>            
                                <th>Nama Mitra</th>                                           
                                <th>Maksimal Pekerja</th>            
                                <th>Jumlah Pekerja</th>            
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



@endsection

@section('extra_scripts')
<script type="text/javascript">
function tambah(){
    window.location = baseUrl+'/manajemen-kontrak-mitra/data-kontrak-mitra/tambah';
}
function hapus(mitra,id_detail){    
    swal({
      title: "Konfirmasi",
      text: "Apakah anda yakin ingin menghapus data kontrak mitra?",
      type: "warning",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
    },
    function(){
      setTimeout(function(){
        $.ajax({
          url: baseUrl+'/manajemen-kontrak-mitra/data-kontrak-mitra/hapus/'+mitra+'/'+id_detail,
          type: 'get',
          timeout: 10000,
          success: function(response){
         if(response.status=='berhasil'){
          swal({
                    title:"Berhasil",
                            text: "Data berhasil dihapus",
                            type: "success",
                            showConfirmButton: false,
                            timer: 900
                    });
               table.draw();
         
        }
          },error:function(x,e) {
            //alert(e);
            var message;
            if (x.status==0) {
                message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
            } else if(x.status==404) {
                message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
            } else if(x.status==500) {
                message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
            } else if(e =='parsererror') {
                message = 'Error.\nParsing JSON Request failed.';
            } else if(e =='timeout'){
                message = 'Request Time out. Harap coba lagi nanti';
            } else {
                message = 'Unknow Error.\n'+x.responseText;
            }
            throwLoadError(message);
            //formReset("store");
          }
        })
      }, 2000);

    });
    
  

    
}
                           
                                //+"mc_mitra": 7
//      +"mc_contractid": 0
//      +"mc_no": "1"
//      +"mc_date": "0000-00-00"
//      +"mc_expired": "0000-00-00"
//      +"mc_need": 0
//      +"mc_fulfilled": 0
//      +"m_name": "PT ALAM JAYA PRIMA NUSA"
//      +"m_address": "Trosobo n"
//      +"c_name": "Soto Sedaap Boyolali"
//      +"number": 1


                                    
        var table = $("#mitra").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('manajemen-kontrak-mitra/data-kontrak-mitra/table') }}',  
        dataType: 'json',
        columns: [            
            
            {data: 'number', name: 'number'},
            {data: 'mc_no', name: 'mc_no'},
            {data: 'mc_date', name: 'mc_date'},
            {data: 'mc_expired', name: 'mc_expired'},
            {data: 'c_name', name: 'c_name'},
            {data: 'm_name', name: 'm_name'},
            //{data: 'm_address', name: 'm_address'},
            
            
            
            {data: 'mc_need', name: 'mc_need'},
            {data: 'mc_fulfilled', name: 'mc_fulfilled'},            
            {data: 'action', name: 'action',orderable:false,searchable:false}
        ],
        responsive: true,        
        "pageLength": 10,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        //"scrollY": '50vh',
        //"scrollCollapse": true,
        "language": dataTableLanguage,
    });
     ;
</script>
@endsection