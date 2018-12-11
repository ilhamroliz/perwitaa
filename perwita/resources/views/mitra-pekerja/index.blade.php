@extends('main')

@section('title', 'Penerimaan Pekerja')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Penerimaan Tenaga Kerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Penerimaan Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Data Permintaan Pekerja</h5>
        <button style="float: right; margin-top: -7px;" onclick="tambah()" class="btn btn-primary btn-outline btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
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
                   <table id="mitra" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Tanggal Kontrak</th>
                                <th>No Kotrak</th>
                                <th>Kontrak Selesai</th>
                                <th>Nama Perusahaan</th>
                                <th>Nama Mitra</th>
                                <th>Nama Divisi</th>
                                <th>Maksimal Pekerja</th>
                                <th>Jumlah Pekerja</th>
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

    $(document).ready(function(){
        setTimeout(function(){
            $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
            });
            var table = $("#mitra").DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                      "url": "{{ url('manajemen-pekerja-mitra/data-pekerja-mitra/table') }}",
                      "type": "POST"
                  },
                dataType: 'json',
                columns: [
                    {data: 'mc_date', name: 'mc_date'},
                    {data: 'mc_no', name: 'mc_no'},
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


function tambah(){
    window.location = baseUrl+'/manajemen-pekerja-mitra/data-pekerja-mitra/tambah';
}
function hapus(mitra,mc_contractid){
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
          url: baseUrl+'/manajemen-kontrak-mitra/data-kontrak-mitra/hapus/'+mitra+'/'+mc_contractid,
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
</script>
@endsection
