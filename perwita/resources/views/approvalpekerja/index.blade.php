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
        <h2>Approval Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Daftar Approval Pekerja</h5>
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
                        <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Daftar Approval</span>
                    </div>
                </center>


                <table id="approval" class="table table-bordered" cellspacing="0" width="100%" style="display:none">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Pendidikan</th>
                            <th>Alamat</th>
                            <th>No Hp</th>
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

<div class="modal inmodal" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width : 1000px">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                            <div class="image" id="showimage">
                                  <i class="fa fa-user modal-icon"></i>
                            </div>
                <h4 class="modal-title">Detail Pekerja</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-lg-3">
                        <h3>Nama Pekerja </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_name">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Alamat </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_address">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Jabatan Lamaran </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_jabatan_lamaran">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Jenis Kelamin </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_sex">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No NIP </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_nip">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No NIP Mitra</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_nip_mitra">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No KTP </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_ktp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tempat Lahir </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_birthplace">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tanggal Lahir </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_birthdate">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No Hp </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_hp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No Telepon </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_telp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Status </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_status">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Jumlah Anak </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_many_kids">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Agama </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_religion">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>RT/RW </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_rt_rw">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Kelurahan </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_kel">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Kecamatan </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_kecamatan">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Kota </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_city">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Alamat Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_address_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>RT/RW Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_rt_rw_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Keluarahan Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_kel_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Kecamatan Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_kecamatan_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Kota Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_city_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Nama Istri </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_wife_name">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tanggal Lahir Istri </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_wife_birth">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tempat Lahir Istri </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_wife_birthplace">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Nama Ayah </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_dad_name">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Pekerjaan Ayah </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_dad_job">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Nama Ibu </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_mom_name">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Pekerjaan Ibu </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_mom_job">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Pekerjaan Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_job_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Berat </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_weight">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tinggi </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_height">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Ukuran Baju </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_seragam_size">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Ukuran Celana  </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_celana_size">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Ukuran Sepatu  </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_sepatu_size">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Pendidikan  </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_education">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Warga Negara  </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_state">: -</h3>
                    </div>
                  </div>
                  <div class="col-lg-12">
                      <h3>&nbsp</h3>
                  </div>
                  <div class="col-lg-12">
                      <h3>Keluarga Yang Dapat Dihubungi</h3>
                  </div>
                      <table id="tabel_detail" class="table table-bordered table-striped tabel_detail">
                        <div class="col-lg-3">
                            <h3>Nama </h3>
                        </div>
                        <div class="col-lg-3">
                            <h3 style="font-weight:normal;" id="p_name_family">: -</h3>
                        </div>
                        <div class="col-lg-3">
                            <h3>Alamat </h3>
                        </div>
                        <div class="col-lg-3">
                            <h3 style="font-weight:normal;" id="p_address_family">: -</h3>
                        </div>
                        <div class="col-lg-3">
                            <h3>Telepon </h3>
                        </div>
                        <div class="col-lg-3">
                            <h3 style="font-weight:normal;" id="p_telp_family">: -</h3>
                        </div>
                        <div class="col-lg-3">
                            <h3>No Hp </h3>
                        </div>
                        <div class="col-lg-3">
                            <h3 style="font-weight:normal;" id="p_hp_family">: -</h3>
                        </div>
                        <div class="col-lg-3">
                            <h3>Hubungan </h3>
                        </div>
                        <div class="col-lg-3">
                            <h3 style="font-weight:normal;" id="p_hubungan_family">: -</h3>
                        </div>
                      </table>
              </div>
              <div class="modal-footer">
                <button type="button" name="button" class="btn btn-primary" id="setujui" onclick="setujui()">Setujui</button>
                <button type="button" name="button" class="btn btn-danger" id="tolak" onclick="tolak()">Tolak</button>
                  <div class="btn-group">
                      <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                  </div>
              </div>
          </div>
      </div>
  </div>


@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;

setTimeout(function () {
    $('#approval').css('display', '')
    $('.spiner-example').css('display', 'none')
    table = $("#approval").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('/approvalpekerja/table') }}',
        dataType: 'json',
        columns: [
        {data: 'number', name: 'number'},
        {data: 'p_name', name: 'p_name'},
        {data: 'p_education', name: 'p_education'},
        {data: 'p_address', name: 'p_address'},
        {data: 'p_hp', name: 'p_hp'},
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

function detail(id){
  $.ajax({
    type: 'get',
    data: {id:id},
    url: baseUrl + '/approvalpekerja/detail',
    dataType: 'json',
    success : function(result){
      // console.log(result);
      $("#p_name").text(": "+result.p_name);
      $("#p_address").text(": "+result.p_address);
      $("#p_jabatan_lamaran").text(": "+result.p_jabatan_lamaran);
      $("#p_nip").text(": "+result.p_nip);
      $("#p_sex").text(": "+result.p_sex);
      $("#p_nip_mitra").text(": "+result.p_nip_mitra);
      $("#p_ktp").text(": "+result.p_ktp);
      $("#p_birthplace").text(": "+result.p_birthplace);
      $("#p_birthdate").text(": "+result.p_birthdate);
      $("#p_hp").text(": "+result.p_hp);
      $("#p_telp").text(": "+result.p_telp);
      $("#p_status").text(": "+result.p_status);
      $("#p_religion").text(": "+result.p_religion);
      $("#p_rt_rw").text(": "+result.p_rt_rw);
      $("#p_rt_rw_now").text(": "+result.p_rt_rw_now);
      $("#p_kel_now").text(": "+result.p_kel_now);
      $("#p_kel").text(": "+result.p_kel);
      $("#p_kecamatan").text(": "+result.p_kecamatan);
      $("#p_kecamatan_now").text(": "+result.p_kecamatan_now);
      $("#p_city").text(": "+result.p_city_now);
      $("#p_city_now").text(": "+result.p_city_now);
      $("#p_address_now").text(": "+result.p_address_now);
      $("#p_wife_name").text(": "+result.p_wife_name);
      $("#p_wife_birth").text(": "+result.p_wife_birth);
      $("#p_wife_birthplace").text(": "+result.p_wife_birthplace);
      $("#p_dad_name").text(": "+result.p_dad_name);
      $("#p_dad_job").text(": "+result.p_dad_job);
      $("#p_mom_name").text(": "+result.p_mom_name);
      $("#p_mom_job").text(": "+result.p_mom_job);
      $("#p_job_now").text(": "+result.p_job_now);
      $("#p_weight").text(": "+result.p_weight);
      $("#p_height").text(": "+result.p_height);
      $("#p_seragam_size").text(": "+result.p_seragam_size);
      $("#p_sepatu_size").text(": "+result.p_sepatu_size);
      $("#p_celana_size").text(": "+result.p_celana_size);
      $("#p_education").text(": "+result.p_education);
      $("#p_state").text(": "+result.p_state);
      //Keluarga yang dapat dihubungi
      $("#p_name_family").text(": "+result.p_name_family);
      $("#p_telp_family").text(": "+result.p_telp_family);
      $("#p_hubungan_family").text(": "+result.p_hubungan_family);
      $("#p_address_family").text(": "+result.p_address_family);
      $("#p_hp_family").text(": "+result.p_hp_family);
      //Button
      $("#setujui").attr('onclick', 'setujui('+id+')');
      $("#tolak").attr('onclick', 'tolak('+id+')');
      if (result.p_many_kids == 'LEBIH') {
        $("#p_many_kids").text(": 3 Anak Lebih");
      }
      if (result.p_img != null) {
        $("#showimage").html("<center><img src='"+baseUrl+'/'+result.p_img+"' width='150' class='thumb-image img-responsive'></center>");
      }

      else {
        $("#showimage").html('<i class="fa fa-user modal-icon"></i>');
      }

    }
  })
  $("#modal-detail").modal('show');
}

  function setujui(id){
    swal({
            title: "Konfirmasi",
            text: "Apakah anda yakin ingin menyetujui pekerja ini?",
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
                  url: baseUrl + '/approvalpekerja/setujui',
                  dataType: 'json',
                  timeout: 10000,
                    success: function (response) {
                        waitingDialog.hide();
                        if (response.status == 'berhasil') {
                            swal({
                                title: "Pekerja Disetujui",
                                text: "Pekerja Berhasil Disetujui",
                                type: "success",
                                showConfirmButton: false,
                                timer: 900
                            });
                            table.draw();
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
            text: "Apakah anda yakin ingin menolak pekerja ini?",
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
                  url: baseUrl + '/approvalpekerja/tolak',
                  dataType: 'json',
                  timeout: 10000,
                    success: function (response) {
                        waitingDialog.hide();
                        if (response.status == 'berhasil') {
                            swal({
                                title: "Pekerja Ditolak",
                                text: "Pekerja Berhasil Ditolak",
                                type: "success",
                                showConfirmButton: false,
                                timer: 900
                            });
                            table.draw();
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
