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
        <h2>Approval Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Pembelian</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Daftar Approval Pembelian Seragam</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                  <center>
                    <div class="spiner-example">
                        <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                            <div class="sk-rect1 tampilkan" ></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                        <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Daftar Approval</span>
                    </div>
                </center>
                    <table id="tabel-pembelian" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>Nota</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index=>$row)
                            <tr id="rowobject" dataid="{{$row->p_id}}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ Carbon\Carbon::parse($row->p_date)->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $row->s_company }}</td>
                                <td>{{ $row->p_nota }}</td>
                                <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format($row->p_total_net, 0, ',', '.') }}</span></td>
                                @if($row->pd_receivetime == null)
                                <td class="text-center"><span class="label label-warning">Belum diterima</span></td>
                                @else
                                <td class="text-center"><span class="label label-success">Sudah diterima</span></td>
                                @endif
                                @if($row->p_isapproved == 'P')
                                <td class="text-center"><span class="label label-warning">Belum disetujui</span></td>
                                @elseif($row->p_isapproved == 'Y')
                                <td class="text-center"><span class="label label-success">Sudah disetujui</span></td>
                                @endif
                                <td>
                                <button type="button" onclick="setujui({{$row->p_id}})" class="btn btn-primary btn-sm" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                                <button type="button" onclick="tolak({{$row->p_id}})"  class="btn btn-danger btn-sm" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
                               </td>
                            </tr>
                            @endforeach
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
    var tablepembelian;
    $( document ).ready(function() {

    $('#tabel-pembelian').hide();
    myFunction();

    function myFunction() {
    setTimeout(function(){
      $(".spiner-example").css('display', 'none');
      tablepembelian = $("#tabel-pembelian").DataTable({
        "processing": true,
        "searchable": true,
        "deferLoading": 57,
        responsive: true,
        "language": dataTableLanguage
      });
      $('#tabel-pembelian').show();
    },1500);
      }

    });

    function setujui(id){
      swal({
              title: "Konfirmasi",
              text: "Apakah anda yakin ingin menyetujui Pembelian ini?",
              type: "warning",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true,
          },
          function () {
              swal.close();
              waitingDialog.show();
              setTimeout(function () {
                  $.ajax({
                    type: 'get',
                    data: {id:id},
                    url: baseUrl + '/approvalpembelian/setujui',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Pelamar Disetujui",
                                  text: "Pelamar Berhasil Disetujui",
                                  type: "success",
                                  showConfirmButton: false,
                                  timer: 900
                              });
                              setTimeout(function(){
                                    window.location.reload();
                            }, 850);
                          }
                      }, error: function (x, e) {
                          waitingDialog.hide();
                          var message;
                          if (x.status == 0) {
                              message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                          } else if (x.status == 404) {
                              message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                          } else if (x.status == 500) {
                              message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                          } else if (e == 'parsererror') {
                              message = 'Error.\nParsing JSON Request failed.';
                          } else if (e == 'timeout') {
                              message = 'Request Time out. Harap coba lagi nanti';
                          } else {
                              message = 'Unknow Error.\n' + x.responseText;
                          }
                          waitingDialog.hide();
                          throwLoadError(message);
                          //formReset("store");
                      }
                  })
              }, 2000);

          });
    }

    function tolak(id){
      swal({
              title: "Konfirmasi",
              text: "Apakah anda yakin ingin menolak Pelamar ini?",
              type: "warning",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true,
          },
          function () {
              swal.close();
              $("#modal-detail").modal('hide');
              waitingDialog.show();
              setTimeout(function () {
                  $.ajax({
                    type: 'get',
                    data: {id:id},
                    url: baseUrl + '/approvalpembelian/tolak',
                    dataType: 'json',
                    timeout: 10000,
                      success: function (response) {
                          waitingDialog.hide();
                          if (response.status == 'berhasil') {
                              swal({
                                  title: "Pelamar Ditolak",
                                  text: "Pekerja Berhasil Ditolak",
                                  type: "success",
                                  showConfirmButton: false,
                                  timer: 900
                              });
                              setTimeout(function(){
                                    window.location.reload();
                            }, 850);
                          }
                      }, error: function (x, e) {
                          waitingDialog.hide();
                          var message;
                          if (x.status == 0) {
                              message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                          } else if (x.status == 404) {
                              message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                          } else if (x.status == 500) {
                              message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                          } else if (e == 'parsererror') {
                              message = 'Error.\nParsing JSON Request failed.';
                          } else if (e == 'timeout') {
                              message = 'Request Time out. Harap coba lagi nanti';
                          } else {
                              message = 'Unknow Error.\n' + x.responseText;
                          }
                          waitingDialog.hide();
                          throwLoadError(message);
                          //formReset("store");
                      }
                  })
              }, 2000);

          });
    }

</script>
@endsection
