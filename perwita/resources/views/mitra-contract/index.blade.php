@extends('main')

@section('title', 'Permintaan Pekerja')

@section('extra_styles')

<style>
.popover-navigation [data-role="next"] { display: none; }
.popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Permintaan Tenaga Kerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Permintaan Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Data Permintaan</h5>
        <button style="float: right; margin-top: -7px;" onclick="tambah()" class="btn btn-primary btn-outline btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
        <a href="{{url('manajemen-kontrak-mitra/data-kontrak-mitra/cari')}}" style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-search"></i>&nbsp;Cari</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">

                </div>
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">
                </div>
                <center>
                    <div class="spiner-example">
                        <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                            <div class="sk-rect1 tampilkan" ></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                        <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Data Mitra</span>
                    </div>
                </center>
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">
                 <table id="mitra" class="table table-bordered" cellspacing="0" width="100%" style="display:none">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Kotrak</th>
                            <th>Jabatan</th>
                            <th>Nama Mitra</th>
                            <th>Nama divisi</th>
                            <th>Dibutuhkan</th>
                            <th>Terpenuhi</th>
                            <th style="width:140px;">Aksi</th>
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

@include('mitra-contract.detail')

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

var table;
setTimeout(function () {
    $('#mitra').css('display', '');
    $('.spiner-example').css('display', 'none');
    $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
            });
    table = $("#mitra").DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
          "url": "{{ url('manajemen-kontrak-mitra/data-kontrak-mitra/table') }}",
          "type": "POST"
        },
        dataType: 'json',
        columns: [

        {data: 'number', name: 'number'},
        {data: 'mc_no', name: 'mc_no'},
        {data: 'jp_name', name: 'jp_name'},
        {data: 'm_name', name: 'm_name'},
        {data: 'md_name', name: 'md_name'},
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
    }, 2000);



   function detail(idmitra, iddetail){
      $.ajax({
        type : 'get',
        url : baseUrl + "/manajemen-kontrak-mitra/data-kontrak-mitra/"+idmitra+"/"+iddetail+"/detail",
        dataType : 'json',
        success : function(result){
          $('#mc_no').html(': '+result.data[0].mc_no);
          $('#mc_mitra').html(': '+result.data[0].m_name);
          $('#mc_divisi').html(': '+result.data[0].md_name);
          $('#mc_comp').html(': '+result.data[0].c_name);
          $('#mc_jabatan').html(': '+result.data[0].jp_name);
          $('#mc_jobdesk').html(': '+result.data[0].mc_jobdesk);
          $('#mc_note').html(': '+result.data[0].mc_note);

          var html = '';
          var i;
          //alert(data.length);
          for(i=0; i<result.pekerja.length; i++){
            html +='<tr>'+
                  '<td>'+(i + 1)+'</td>'+
                  '<td>'+result.pekerja[i].p_name+'</td>'+
                  '<td style="text-transform: uppercase;">'+result.pekerja[i].mp_mitra_nik+'</td>'+
                  '<td>'+result.pekerja[i].p_hp+'</td>'+
                  '</tr>';
          }
          $('#showdata').html(html);

          $('#detail').modal('show');
        }
      });
    }
</script>
@endsection
