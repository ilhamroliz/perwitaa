@extends('main')

@section('title', 'Data Pegawai')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

  <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
          <h2>Data Pegawai</h2>
          <ol class="breadcrumb">
              <li>
                  <a href="{{ url('/') }}">Home</a>
              </li>
              <li class="active">
                  <strong>Daftar Pegawai</strong>
              </li>
          </ol>
      </div>
  </div>
  <div class="wrapper wrapper-content animated fadeInRight">
      <div class="ibox-title ibox-info">
          <h5>Daftar Data Pegawai</h5>
          <button style="float: right; margin-top: -7px;" class="btn btn-primary btn-outline btn-flat btn-sm" type="button"
                    aria-hidden="true" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;Tambah
          </button>
          <button style="float: right; margin-top: -7px; margin-right:10px;" class="btn btn-info btn-flat btn-sm" type="button"
                    aria-hidden="true" onclick="cari()"><i class="fa fa-search"></i>&nbsp;Cari
          </button>
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

    function cari(){
      window.location.href = baseUrl + '/manajemen-pegawai/data-pegawai/cari';
    }

</script>
@endsection
