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
        <h2>Approval Pegawai</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Pegawai</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Daftar Approval Pegawai</h5>
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
                <form class="formapprovalremunerasi" id="formapprovalremunerasi">
                  @foreach($data as $z)
                  <input type="hidden" name="pd_no" id="pd_no" value="{{$z->p_id}}">
                  @endforeach
                    <table id="remunerasitabel" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>
                                  <input type="checkbox" class="setCek" onclick="selectall()">
                                </th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Jk</th>
                                <th>No Telp.</th>
                                <th>Alamat</th>
                                <th style="width: 120%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $index => $x)
                          <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                              <td>
                                  <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$x->p_id}}">
                              </td>
                                <td>{{$x->p_name}}</td>
                                <td>{{$x->p_nip}}</td>
                                <td>{{$x->p_sex}}</td>
                                <td>{{$x->p_telp}}</td>
                                <td>{{$x->p_address}}</td>
                                <td align="center">
                                <button type="button" title="Detail" onclick="detail({{$x->p_id}})" id="detailbtn" class="btn btn-info btn-sm" name="button"> <i class="glyphicon glyphicon-folder-open"></i> </button>
                                <button type="button" title="Setujui" onclick="setujui({{$x->p_id}})" class="btn btn-primary btn-sm" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                                <button type="button" title="Tolak" onclick="tolak({{$x->p_id}})"  class="btn btn-danger btn-sm" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
                               </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                  </form>
                  <div class="pull-right">
                    <button type="button" class="btn btn-danger btn-outline" name="button" onclick="tolaklist()"> <i class="glyphicon glyphicon-remove"></i> Tolak Checklist</button>
                    <button type="button" class="btn btn-primary btn-outline" name="button" onclick="setujuilist()"> <i class="glyphicon glyphicon-ok"></i> Setujui Checklist</button>
                  </div>
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
                <i class="fa fa-user modal-icon"></i>
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
                        <h3>Nama Ibu </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_momname">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No NIK </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_nik">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No KPJ </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_kpj_no">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Jenis Kelamin </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_sex">: -</h3>
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
                        <h3>Alamat </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_address">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tanggal Masuk Kerja </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_workdate">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No Hp </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_hp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No KTP </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_ktp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tanggal Berlaku KTP </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="b_ktp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Pendidikan </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_education">: -</h3>
                    </div>


                </div>
                <div class="col-lg-12">
                    <h3>&nbsp</h3>
                </div>
                <div class="col-lg-12">
                    <h3 style="font-style: italic; color: blue">History Pekerja</h3>
                </div>
                <form class="form-horizontal">
                    <table id="tabel_detail"
                           class="table table-bordered table-striped tabel_detail">

                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                </div>
                <button type="button" id="printbtn" class="btn btn-primary" onclick="print()" name="button"><i class="fa fa-print">&nbsp;</i>Print</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;
var countmitra;
var totalmitra;
$( document ).ready(function() {

$('#remunerasitabel').hide();
myFunction();

function myFunction() {
setTimeout(function(){
  $(".spiner-example").css('display', 'none');
  table = $("#remunerasitabel").DataTable({
    "processing": true,
    "paging": false,
    "searching": false,
    "deferLoading": 57,
    responsive: true,
    "language": dataTableLanguage
  });
  $('#remunerasitabel').show();
},1500);
  }

});



function selectall() {

    if ($('.setCek').is(":checked")) {
        table.$('input[name="pilih[]"]').prop("checked", true);
        //table.$('input[name="pilih[]"]').css('background','red');
        table.$('.chek-all').val('1');
    } else {
        table.$('input[name="pilih[]"]').prop("checked", false);
        table.$('.chek-all').val('');
    }
    hitung();
    //hitungSelect();
}

function selectBox(id) {
    if (table.$('.pilih-' + id).is(":checked")) {
        table.$('.pilih-' + id).prop("checked", false);
        table.$('.chek-' + id).val('1');
    } else {
        table.$('.pilih-' + id).prop("checked", true);
        table.$('.chek-' + id).val('');
    }
    //hitungSelect();
    hitung();
}

function hitung() {
    countmitra = table.$("input[name='pilih[]']:checked").length;
    $('#totalPekerja').val(countmitra + totalmitra);
}

function hitungSelect() {
    for (i = 0; i <= table.$('tr').length; i++)
        if (table.$('.pilih-' + i).is(":checked")) {
            table.$('.select-' + i).css('background', '#bbc4d6')
            //table.$('.select-'+i).css('color','white')
        } else {
            table.$('.select-' + i).css('background', '')
        }
}

function select(id) {
    if (table.$('.pilih-' + id).is(":checked")) {
        table.$('.pilih-' + id).prop("checked", false);
        table.$('.chek-' + id).val('');
    } else {
        table.$('.pilih-' + id).prop("checked", true);
        table.$('.chek-' + id).val('1');
    }
    //hitungSelect();
    hitung();
}

function setujui(id){
  swal({
          title: "Konfirmasi",
          text: "Apakah anda yakin ingin menyetujui Pegawai ini?",
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
                url: baseUrl + '/approvalpegawai/setujui',
                dataType: 'json',
                timeout: 10000,
                  success: function (response) {
                      waitingDialog.hide();
                      if (response.status == 'berhasil') {
                          swal({
                              title: "Pegawai Disetujui",
                              text: "Pegawai Berhasil Disetujui",
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
          text: "Apakah anda yakin ingin menolak Pegawai ini?",
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
                url: baseUrl + '/approvalpegawai/tolak',
                dataType: 'json',
                timeout: 10000,
                  success: function (response) {
                      waitingDialog.hide();
                      if (response.status == 'berhasil') {
                          swal({
                              title: "Pegawai Ditolak",
                              text: "Pegawai Berhasil Ditolak",
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

function setujuilist(){
  waitingDialog.show();
  setTimeout(function () {
  $.ajax({
    type: 'get',
    data: $('#formapprovalremunerasi').serialize(),
    url: baseUrl + '/approvalpegawai/setujuilist',
    dataType: 'json',
    timeout: 10000,
    success : function(result){
      waitingDialog.hide();
      if (result.status == 'berhasil') {
          swal({
              title: "Pegawai Disetujui",
              text: "Pegawai Berhasil Disetujui",
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
  });
}, 2000);
}

function tolaklist(){
  waitingDialog.show();
  setTimeout(function () {
  $.ajax({
    type: 'get',
    data: $('#formapprovalremunerasi').serialize(),
    url: baseUrl + '/approvalpegawai/tolaklist',
    dataType: 'json',
    timeout: 10000,
    success : function(result){
      waitingDialog.hide();
      if (result.status == 'berhasil') {
        swal({
            title: "Pegawai Ditolak",
            text: "Pegawai Berhasil Ditolak",
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
  });
}, 2000);
}

function detail(id) {
    var id = id;
    $('#printbtn').attr('onclick','print('+id+')')
    $.ajax({
        data: {id: id},
        type: "GET",
        url: baseUrl + "/manajemen-pegawai/data-pegawai/detail",
        dataType: 'json',
        success: function (data) {

            var p_nik, p_nip, p_nip_mitra, p_name, p_sex, p_birthplace, p_birthdate, p_address, p_hp;
            var p_ktp, b_ktp, p_education, p_momname, p_kpj_no;

            $.each(data, function (i, n) {

                p_nip = n.p_nip;
                p_nip_mitra = n.p_nip_mitra;
                p_nik = n.p_nik;
                p_name = n.p_name;
                p_sex = n.p_sex;
                p_birthplace = n.p_birthplace;
                p_birthdate = n.p_birthdate;
                p_address = n.p_address;
                p_hp = n.p_hp;
                p_ktp = n.p_ktp;

                if (n.p_ktp_seumurhidup == "Y") {
                    b_ktp = "Seumur Hidup";
                } else {
                    b_ktp = n.p_ktp_expired;
                }

                p_education = n.p_education;
                p_momname = n.p_momname;
                p_kpj_no = n.p_kpj_no;
                p_workdate = n.p_workdate;
            });

            if (typeof sisa_kontrak == 'undefined' || sisa_kontrak == undefined || sisa_kontrak == '' || sisa_kontrak == null) {
                sisa_kontrak = "-";
            }
            if (p_nip == undefined) {
                p_nip = "-";
            }
            if (p_nip_mitra == undefined) {
                p_nip_mitra = "-";
            }
            if (p_nik == undefined) {
                p_nik = "-";
            }
            if (p_name == undefined) {
                p_name = "-";
            }
            if (p_sex == undefined) {
                p_sex = "-";
            }
            if (p_birthplace == undefined) {
                p_birthplace = "-";
            }
            if (p_birthdate == undefined) {
                p_birthdate = "-";
            }
            if (p_address == undefined) {
                p_address = "-";
            }
            if (p_hp == undefined) {
                p_hp = "-";
            }
            if (p_ktp == undefined) {
                p_ktp = "-";
            }
            if (b_ktp == undefined) {
                b_ktp = "-";
            }
            if (p_education == undefined) {
                p_education = "-";
            }
            if (p_momname == undefined) {
                p_momname = "-";
            }
            if (p_kpj_no == undefined) {
                p_kpj_no = "-";
            }

            // console.log(sisa_kontrak);
            // console.log(mc_date);
            $('#p_nik_mitra').html(": " + p_nip_mitra);
            $('#p_nik').html(": " + p_nip);
            $('#p_name').html(": " + p_name);
            $('#p_sex').html(": " + p_sex);
            $('#p_birthplace').html(": " + p_birthplace);
            $('#p_birthdate').html(": " + p_birthdate);
            $('#p_address').html(": " + p_address);
            $('#p_hp').html(": " + p_hp);
            $('#p_ktp').html(": " + p_ktp);
            $('#b_ktp').html(": " + b_ktp);
            $('#p_education').html(": " + p_education);
            $('#p_momname').html(": " + p_momname);
            $('#p_kpj_no').html(": " + p_kpj_no);
            $('#p_workdate').html(": " + p_workdate);

        }
    })

    $.ajax({
        data: {id: id},
        type: "GET",
        url: baseUrl + "/manajemen-pegawai/data-pegawai/detail_mutasi",
        dataType: 'json',
        success: function (data) {
            var pekerja_mutasi = '<thead>'
                + '<tr>'
                + '<th style="text-align : center;"> TANGGAL </th>'
                + '<th style="text-align : center;"> KET</th>'
                + '<th style="text-align : center;"> STATUS</th>'
                + '</tr>'
                + '</thead>'
                + '<tbody>';

            $.each(data, function (i, n) {

              if (n.pm_reff == null) {
                var pm_reff = '-';
              } else {
                pm_reff = n.pm_reff;
              }

              if (n.pm_note == null) {
                var pm_note = '-';
              } else {
                pm_note = n.pm_note;
              }

              if (n.pm_detail == 'Resign') {
                pekerja_mutasi = pekerja_mutasi + '<tr>'
                    + '<td>' + n.pm_date + '</td>'
                    + '<td>' + n.pm_note + '</td>'
                    + '<td>' + pm_note + '</td>'
                    + '</tr>';
              } else {
                pekerja_mutasi = pekerja_mutasi + '<tr>'
                    + '<td>' + n.pm_date + '</td>'
                    + '<td>' + n.pm_detail + '</td>'
                    + '<td>' + pm_note + '</td>'
                    + '</tr>';
              }
            });
            pekerja_mutasi = pekerja_mutasi + '</tbody';
            $('#tabel_detail').html(pekerja_mutasi);
        }

    })

    $("#modal-detail").modal("show");
}
</script>
@endsection
