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
                    <h5>Data Pegawai</h5>
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
                  @if(Session::has('sukses'))
                      <div class="alert alert-success alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                      aria-hidden="true">&times;</span></button>
                          <strong>{{ Session::get('sukses') }}</strong>
                      </div>
                  @elseif(Session::has('gagal'))
                      <div class="alert alert-danger alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                      aria-hidden="true">&times;</span></button>
                          <strong>{{ Session::get('gagal') }}</strong>
                      </div>
                  @endif
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
                              <th style="width: 5%;">No</th>
                              <th style="width: 22%;">Nama</th>
                              <th style="width: 15%;">NIK</th>
                              <th style="width: 5%;">Jk</th>
                              <th style="width: 15%;">No Telp.</th>
                              <th style="width: 25%;">Alamat</th>
                              <th style="width: 120%;">Aksi</th>
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
window.location =
baseUrl+'/manajemen-pegawai/data-pegawai/tambah';
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
          url: baseUrl+'/manajemen-pegawai/data-pegawai/hapus/'+id,
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
        ajax: '{{ url('manajemen-pegawai/data-pegawai/table') }}',
        dataType: 'json',
        columns: [
            {data: 'number', name: 'number'},
            {data: 'p_name', name: 'p_name'},
            {data: 'p_nip', name: 'p_nip'},
            {data: 'p_sex', name: 'p_sex'},
            {data: 'p_telp', name: 'p_telp'},
            {data: 'p_address', name: 'p_address'},
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
