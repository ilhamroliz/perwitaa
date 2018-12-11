@extends('main')

@section('title', 'Mitra Perusahaan')

@section('extra_styles')

<style>
.popover-navigation [data-role="next"] { display: none; }
.popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Mitra Perusahaan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Mitra
            </li>
            <li class="active">
                <strong>Mitra Perusahaan</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Mitra Perusahaan</h5>
        <a href="{{ url('manajemen-mitra/data-mitra/tambah') }}" style="float: right; margin-top: -7px;" class="btn btn-outline btn-primary btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">

                  <center>
                    <div class="spiner-example">
                        <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                            <div class="sk-rect1 tampilkan" ></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                        <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Mitra Perusahaan</span>
                    </div>
                </center>


                <table id="mitra" class="table table-bordered" cellspacing="0" width="100%" style="display:none">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mitra</th>
                            <th>Alamat Mitra</th>
                            <th>Nomor Telepon</th>
                            <th>Keterangan</th>
                            <th style="width:120px;">Action</th>
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

<div class="modal inmodal" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width : 1000px">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                            <div class="image" id="showimage">
                                  <i class="fa fa-folder-open modal-icon"></i>
                            </div>
                <h4 class="modal-title">Detail Mitra</h4>
            </div>
            <div class="modal-body">
              <center>
                <div class="spiner-mitra">
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
            <div id="showdetail">
                <div class="form-group">
                    <div class="col-lg-3">
                        <h3>Nama Mitra </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_name">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Alamat Mitra </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_address">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Nomor Telepon </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_phone">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Nama Contact Person </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_cp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No Contact Person </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_cp_phone">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Fax </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_fax">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Keterangan </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_note">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3> </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="m_note"></h3>
                    </div>
                    <table id="tabel_detail" class="table table-bordered table-striped tabel_detail">

                    </table>
              </div>
            </div>
              <div class="modal-footer">
                  <div class="btn-group">
                      <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>





@endsection

@section('extra_scripts')
<script type="text/javascript">
    function tambah(){
        window.location = baseUrl+'/manajemen-mitra/data-mitra/tambah';
    }

    var table;

    setTimeout(function () {
        $('#mitra').css('display', '')
        $('.spiner-example').css('display', 'none')
        table = $("#mitra").DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('manajemen-mitra/data-mitra/table') }}',
            dataType: 'json',
            columns: [
            {data: 'number', name: 'number'},
            {data: 'm_name', name: 'm_name'},
            {data: 'm_address', name: 'm_address'},
            {data: 'm_phone', name: 'm_phone'},
            {data: 'm_note', name: 'm_note'},
            {data: 'action', name: 'action',orderable:false,searchable:false}
            ],
            responsive: true,
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        //"scrollY": '50vh',
        //"scrollCollapse": true,
        "language": dataTableLanguage,
    });
    }, 1000);





    function hapus(id){
        swal({
          title: "Konfirmasi",
          text: "Apakah anda yakin ingin menghapus data mitra?",
          type: "warning",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
      },
      function(){
        swal.close();
        waitingDialog.show();
          setTimeout(function(){
            $.ajax({
              url: baseUrl+'/manajemen-mitra/data-mitra/hapus/'+id,
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
              } else {
                swal({
                    title:"Perhatian",
                    text: "Data tidak bisa dihapus, terdapat data penting!!",
                    type: "warning",
                    showConfirmButton: true,
                    timer: 2500
                });
              }
              waitingDialog.hide();
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
            waitingDialog.hide();
        }
    })
        }, 2000);

      });
    }

    function detail(id){
      $("#modal-detail").modal('show');
      $("#showdetail").hide();
      $.ajax({
        type: 'get',
        data: {id:id},
        url: baseUrl + '/manajemen-mitra/data-mitra/detail',
        dataType: 'json',
        success : function(result){
          $("#m_name").text(": "+result[0].m_name);
          $("#m_address").text(": "+result[0].m_address);
          $("#m_cp").text(": "+result[0].m_cp);
          $("#m_cp_phone").text(": "+result[0].m_cp_phone);
          $("#m_fax").text(": "+result[0].m_fax);
          $("#m_note").text(": "+result[0].m_note);
          $("#m_phone").text(": "+result[0].m_phone);

          $('.spiner-mitra').css('display', 'none');
          $("#showdetail").show();
        }
      });
    }

</script>
@endsection
