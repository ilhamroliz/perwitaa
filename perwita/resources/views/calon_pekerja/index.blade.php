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
                    <h5>Da Pekerja</h5>
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
                <div class="col-md-12 table-responsive" style="margin: 10px 0px 20px 0px;">                    
                   <table id="mitra" class="table table-bordered table-striped" >
                        <thead>
                            <tr>                                      
                                <th>No</th>                                
                                <th>No KTP</th>       
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>No Telp.</th>                                
                                <th>Action</th>
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
window.location = baseUrl+'/manajemen-calon-pekerja/data-calon-pekerja/tambah';
}
function hapus(id){
    
    swal({
      title: "Konfirmasi",
      text: "Apakah anda yakin ingin menghapus data Pegawai?",
      type: "warning",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
    },
    function(){
      setTimeout(function(){
        $.ajax({
          url: baseUrl+'/manajemen-pekerja/data-pekerja/hapus/'+id,
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
        var table = $("#mitra").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('manajemen-calon-pekerja/data-calon-pekerja/table') }}',  
        dataType: 'json',           
        columns: [  
            {data: 'number', name: 'number'},            
            {data: 'cp_no_ktp', name: 'cp_no_ktp'},
            {data: 'cp_nama', name: 'cp_nama'},
            {data: 'cp_jenis_kelamin', name: 'cp_jenis_kelamin'},            
            {data: 'cp_tgl_lahir', name: 'cp_tgl_lahir'},
            {data: 'cp_alamat', name: 'cp_alamat'},
            {data: 'cp_no_hp', name: 'cp_no_hp'},            
            {data: 'action', name: 'action',orderable:false,searchable:false}            
        ],
        //responsive: true,        
        "pageLength": 10,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        //"scrollY": '50vh',
        //"scrollCollapse": true,
        "language": dataTableLanguage,
    });
     ;
</script>
@endsection