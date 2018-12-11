@extends('main')

@section('title', 'Master Supplier')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

  <div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Master Supplier</h5>
        <a style="float: right; margin-top: -7px;" class="btn btn-primary btn-outline btn-flat btn-sm" type="button" aria-hidden="true" data-toggle="modal" data-target="#myModal" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            @if(Session::has('sukses'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ Session::get('sukses') }}</strong>
                </div>
            @elseif(Session::has('gagal'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ Session::get('gagal') }}</strong>
                </div>
            @endif
            <div class="row m-b-lg">
                <div class="col-md-12">
                </div>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#item-active">Supplier Aktif</a></li>
                    <li><a data-toggle="tab" href="#item-nonactive">Supplier Tidak Aktif</a></li>
                    <li><a data-toggle="tab" href="#item-all">Semua Supplier</a></li>
                    <li><a data-toggle="tab" href="#search-item"><i class="fa fa-search"></i> &nbsp;Pencarian Supplier</a></li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="item-active">
                        <div class="col-md-12 item-active" style="padding-top: 20px;">
                            <table id="itemY" class="table table-bordered table-striped" >
                                <thead>
                                    <tr>
                                        <th class="col-md-2">Nama Supplier</th>
                                        <th class="col-md-2">Nama Pemilik</th>
                                        <th class="col-md-5 text-center">Alamat Supplier</th>
                                        <th class="col-md-2 text-center">No Hp Supplier</th>
                                        <th class="col-md-1 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="item-nonactive">
                      <div class="col-md-12 item-nonactive" style="padding: 20px;">
                         <table id="itemN" class="table table-bordered table-hover text table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="col-md-3">Nama Supplier</th>
                                    <th class="col-md-2">Nama Pemilik</th>
                                    <th class="col-md-6 text-center">Alamat Supplier</th>
                                    <th class="col-md-2 text-center">No Hp Supplier</th>
                                    <th class="col-md-1 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                      </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="item-all">
                      <div class="col-md-12 item-all" style="padding: 20px;">
                         <table id="itemA" class="table table-bordered table-hover text table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="col-md-3">Nama Supplier</th>
                                    <th class="col-md-2">Nama Pemilik</th>
                                    <th class="col-md-6 text-center">Alamat Supplier</th>
                                    <th class="col-md-2 text-center">No Hp Supplier</th>
                                    <th class="col-md-1 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                      </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="search-item">
                      <div class="col-md-12 search-item" style="padding: 20px;">
                        <div class="col-md-6" style="margin-bottom: 20px; padding-left: 0px;">
                            <input type="text" name="cari" value="" id="cari" placeholder="Masukan Supplier" class="form-control cari-barang">
                            <input type="hidden" name="id_supplier" id="cari-supplier" value="">
                        </div>
                        <table id="searchi" class="table table-bordered table-hover text table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-3">Nama Supplier</th>
                                    <th class="col-md-2">Nama Pemilik</th>
                                    <th class="col-md-6 text-center">Alamat Supplier</th>
                                    <th class="col-md-2 text-center">No Hp Supplier</th>
                                    <th class="col-md-1 text-center">Action</th>
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
    </div>
</div>

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-truck modal-icon"></i>
                <h4 class="modal-title">Tambah Data Supplier</h4>
                <small class="font-bold">Data supplier ini digunakan untuk pembelian barang di fitur Pembelian</small>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-supplier">
                    <div class="form-group">
                        <label class="col-lg-2 control-label text-left" style="text-align: left">Perusahaan</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Nama Perusahaan" class="form-control" name="company" id="company">
                            <input type="hidden" name="id" id="id_supp" value="">
                            {{-- <span class="help-block m-b-none">Example block-level help text here.</span> --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label text-left" style="text-align: left">Pemilik</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Nama Pemilik" class="form-control" name="nama" id="nama">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label text-left" style="text-align: left">No Hp</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="No HP" class="form-control" name="nohp" id="nohp">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label text-left" style="text-align: left">Fax</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Fax" class="form-control" name="fax" id="fax">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label text-left" style="text-align: left">Alamat</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="alamat" id="alamat"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label text-left" style="text-align: left">Keterangan</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label text-left" style="text-align: left">Aktif</label>
                        <div class="input-group col-lg-10" style="margin-top: 8px;">
                            <label for="yes" style="margin-right: 10px; cursor: pointer; margin-left: 20px;">Aktif </label>
                            <input class="iCheck suppaktif" type="radio" id="yes" name="aktif" value="Y" style="cursor: pointer;" checked>

                            <label for="no" style="margin-right: 10px; margin-left: 40px; cursor: pointer;">Tidak </label>
                            <input class="iCheck suppaktif" type="radio" id="no" name="aktif" value="N" style="cursor: pointer;">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" class="btn btn-primary" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
var tableS;
var tableY;
var tableN;
var tableA;
$( document ).ready(function() {
    tableY = $("#itemY").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('master-supplier/get-data-y') }}',
        dataType: 'json',
        columns: [
            {data: 's_company', name: 's_company'},
            {data: 's_name', name: 's_name'},
            {data: 's_address', name: 's_address'},
            {data: 's_phone', name: 's_phone'},
            {data: 'action', name: 'action',orderable:false,searchable:false}
        ],

        responsive: true,
        "pageLength": 10,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        "language": dataTableLanguage,
        columnDefs: [
                {className: "dt-body-center", "targets": [ 4 ]}
              ]
    });
    tableN = $("#itemN").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('master-supplier/get-data-n') }}',
        dataType: 'json',
        columns: [
            {data: 's_company', name: 's_company'},
            {data: 's_name', name: 's_name'},
            {data: 's_address', name: 's_address'},
            {data: 's_phone', name: 's_phone'},
            {data: 'action', name: 'action',orderable:false,searchable:false}
        ],

        responsive: true,
        "pageLength": 10,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        "language": dataTableLanguage,
        columnDefs: [
                {className: "dt-body-center", "targets": [ 4 ]}
              ]
    });
    tableA = $("#itemA").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('master-supplier/get-data-a') }}',
        dataType: 'json',
        columns: [
            {data: 's_company', name: 's_company'},
            {data: 's_name', name: 's_name'},
            {data: 's_address', name: 's_address'},
            {data: 's_phone', name: 's_phone'},
            {data: 'action', name: 'action',orderable:false,searchable:false}
        ],

        responsive: true,
        "pageLength": 10,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        "language": dataTableLanguage,
        columnDefs: [
                {className: "dt-body-center", "targets": [ 4 ]}
              ]
    });

    tableS = $('#searchi').DataTable({
        'searching': false,
        'paging': false,
        "language": dataTableLanguage
    });

    $( "#cari" ).autocomplete({
            source: baseUrl+'/autosupp',
            minLength: 2,
            select: function(event, ui) {
            $('#id_supplier').val(ui.item.id);
            $('#cari').val(ui.item.label);
            tanam(ui.item);
        }
    });
    $('input').iCheck({
        checkboxClass: 'icheckbox_square',
        radioClass: 'iradio_square-purple',
        increaseArea: '20%' // optional
    });
});

function tanam(data){
    tableS.row.add([
               data.company,
               data.nama,
               data.alamat,
               data.phone,
               buttonGen(data.id)
            ]).draw( false );
}

function buttonGen(id){
    var buton = '<div class="text-center"><button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" onclick="edit('+id+')"><i class="glyphicon glyphicon-edit"></i></button><button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus('+id+')"><i class="glyphicon glyphicon-trash"></i></button></div>'
    return buton;
}

function tambah(){
    $('#nama').val('');
    $('#id_supp').val('');
    $('#company').val('');
    $('#nohp').val('');
    $('#fax').val('');
    $('#alamat').val('');
    $('#keterangan').val('');
    $('#yes').iCheck('check');
    $('#no').iCheck('uncheck');
    $('#yes').iCheck('update');
    $('#no').iCheck('update');
}

function simpan(){
    var nama = $('#nama').val();
    var company = $('#company').val();
    var nohp = $('#nohp').val();
    var fax = $('#fax').val();
    var alamat = $('#alamat').val();
    var id = $('#id_supp').val();
    var keterangan = $('#keterangan').val();
    var aktif = $('.suppaktif:checked').val();

    $.ajax({
      url: baseUrl + '/master-supplier/simpan',
      type: 'get',
      data: {id: id, nama: nama, company: company, nohp: nohp, fax: fax, alamat:alamat, keterangan:keterangan, aktif: aktif},
      success: function(response){
        if (response.status == 'sukses') {
            swal({
                title: "Sukses",
                text: "Data sudah tersimpan",
                type: "success"
            }, function () {
                location.reload();
            });
        } else {
            swal({
                title: "Gagal",
                text: "Sistem gagal menyimpan data",
                type: "error",
                showConfirmButton: false
            });
        }
      }, error:function(x, e) {
          if (x.status == 0) {
              alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
          } else if (x.status == 404) {
              alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
          } else if (x.status == 500) {
              alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
          } else if (e == 'parsererror') {
              alert('Error.\nParsing JSON Request failed.');
          } else if (e == 'timeout'){
              alert('Request Time out. Harap coba lagi nanti');
          } else {
              alert('Unknow Error.\n' + x.responseText);
          }
        }
    })
}

function edit(id){
    $.ajax({
      url: baseUrl + '/master-supplier/edit',
      type: 'get',
      data: { id: id },
      success: function(response){
        $('#nama').val(response.data.s_name);
        $('#company').val(response.data.s_company);
        $('#nohp').val(response.data.s_phone);
        $('#fax').val(response.data.s_fax);
        $('#alamat').val(response.data.s_address);
        $('#keterangan').val(response.data.s_note);
        $('#id_supp').val(response.data.s_id);
        if (response.data.s_isactive == 'Y') {
            $('#yes').iCheck('check');
            $('#no').iCheck('uncheck');
            $('#yes').iCheck('update');
            $('#no').iCheck('update');
        } else {
            $('#yes').iCheck('uncheck');
            $('#no').iCheck('check');
            $('#yes').iCheck('update');
            $('#no').iCheck('update');
        }
        $('#myModal').modal('show');
      }, error:function(x, e) {
          if (x.status == 0) {
              alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
          } else if (x.status == 404) {
              alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
          } else if (x.status == 500) {
              alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
          } else if (e == 'parsererror') {
              alert('Error.\nParsing JSON Request failed.');
          } else if (e == 'timeout'){
              alert('Request Time out. Harap coba lagi nanti');
          } else {
              alert('Unknow Error.\n' + x.responseText);
          }
        }
    })
}

function hapus(id){
    swal({
        title: "Apakah anda yakin?",
        text: "data yang dihapus tidak bisa dikembalikan!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "lanjutkan!",
        cancelButtonText: "Batalkan",
        closeOnConfirm: false,
        closeOnCancel: false },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                  url: baseUrl + '/master-supplier/hapus',
                  type: 'get',
                  data: {id: id},
                  success: function(response){
                    if (response.status == 'sukses') {
                      swal({
                        title: "Terhapus",
                        text: "Data telah dihapus",
                        type: "success"
                        }, function () {
                            location.reload();
                        });
                    } else {
                      swal({
                          title: "Gagal!!",
                          text: "Data tidak terhapus",
                          type: "error"
                      });
                    }
                  }, error:function(x, e) {
                      if (x.status == 0) {
                          alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                      } else if (x.status == 404) {
                          alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                      } else if (x.status == 500) {
                          alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                      } else if (e == 'parsererror') {
                          alert('Error.\nParsing JSON Request failed.');
                      } else if (e == 'timeout'){
                          alert('Request Time out. Harap coba lagi nanti');
                      } else {
                          alert('Unknow Error.\n' + x.responseText);
                      }
                    }
                })
            } else {
                swal("Dibatalkan", "Data tidak terhapus", "error");
            }
    });
}

</script>
@endsection
