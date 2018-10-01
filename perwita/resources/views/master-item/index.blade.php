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
    <div class="ibox-title ibox-info">
        <h5>Master Seragam</h5>
        <a href="{{ url('master-item/create') }}" style="float: right; margin-top: -7px;" class="btn btn-primary btn-outline btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
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
                    <li class="active"><a data-toggle="tab" href="#item-active">Seragam Aktif</a></li>
                    <li><a data-toggle="tab" href="#item-nonactive">Seragam Tidak Aktif</a></li>
                    <li><a data-toggle="tab" href="#item-all">Semua Seragam</a></li>
                    <li><a data-toggle="tab" href="#search-item"><i class="fa fa-search"></i> &nbsp;Pencarian Seragam</a></li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="item-active">
                        <div class="col-md-12 item-active" style="padding-top: 20px;">
                            <table id="itemY" class="table table-bordered table-hover text table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                      <th>Nama Seragam</th>
                                      <th>Ukuran</th>
                                      <th>Warna</th>
                                      <th>Harga</th>
                                      <th>Keterangan</th>
                                      <th>Action</th>
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
                                  <th style="width: 50%">Nama Seragam</th>
                                  <th class="text-center" style="width: 10%">Ukuran</th>
                                  <th class="text-center" style="width: 20%">Warna</th>
                                  <th class="text-center" style="width: 20%">Harga</th>
                                  <th class="text-center" style="width: 20%">Keterangan</th>
                                  <th class="text-center" style="width: 20%">Action</th>
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
                                  <th style="width: 50%">Nama Seragam</th>
                                  <th class="text-center" style="width: 10%">Ukuran</th>
                                  <th class="text-center" style="width: 20%">Warna</th>
                                  <th class="text-center" style="width: 20%">Harga</th>
                                  <th class="text-center" style="width: 20%">Keterangan</th>
                                  <th class="text-center" style="width: 20%">Action</th>
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
                            <input type="text" name="cari" value="" id="cari" placeholder="Masukan Nama Seragam" class="form-control cari-barang">
                            <input type="hidden" name="id_barang" id="cari-barang" value="">
                        </div>
                        <table id="searchi" class="table table-bordered table-hover text table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 50%">Nama Seragam</th>
                                    <th class="text-center" style="width: 10%">Ukuran</th>
                                    <th class="text-center" style="width: 20%">Warna</th>
                                    <th class="text-center" style="width: 20%">Harga</th>
                                    <th class="text-center" style="width: 20%">Keterangan</th>
                                    <th class="text-center" style="width: 20%">Action</th>
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
                <i class="glyphicon glyphicon-plus modal-icon"></i>
                <h4 class="modal-title">Tambah Mitra</h4>
                <small class="font-bold">Penambahan Mitra untuk Seragam yang dipilih</small>
            </div>
            <div class="modal-body">
                <h3 class="namabarang"></h3>
                <form class="form-horizontal">
                    <div class="form-dinamis">
                        <div class="form-group getkonten0">
                            <label class="col-sm-2 control-label" for="ukuranbarang">Mitra</label>
                            <div class="col-sm-6 selectukuran0">
                                <select class="form-control mitraselect0 select2 addmitra" name="addmitra[]" id="addmitra">
                                    <option value="">--Pilih Mitra--</option>
                                </select>
                            </div>
                            <span>
                                <a type="button" class="btn btn-primary" id="tambahmitra" onclick="tambahmitra()"><i class="fa fa-plus"></i></a>
                                <a type="button" class="btn btn-danger" id="kurangmitra" onclick="alertmitra()"><i class="fa fa-times"></i></a>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" id="simpanbtn" class="btn btn-primary btn-outline" type="button">Simpan</button>
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
var hitung = 0;
$( document ).ready(function() {
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    tableY = $("#itemY").DataTable({
        "ajax": {
            "url": "{{ url('master-item/get-data-y') }}",
            "type": "POST"
        },
        dataType: 'json',
        processing: true,
        serverSide: true,
        columns: [
            {data: 'i_nama', name: 'i_nama'},
            {data: 's_nama', name: 's_nama'},
            {data: 'i_warna', name: 'i_warna'},
            {data: 'id_price', name: 'id_price'},
            {data: 'i_note', name: 'i_note'},
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
        "ajax": {
            "url": "{{ url('master-item/get-data-n') }}",
            "type": "POST"
        },
        dataType: 'json',
        processing: true,
        serverSide: true,
        columns: [
            {data: 'i_nama', name: 'i_nama'},
            {data: 's_nama', name: 's_nama'},
            {data: 'i_warna', name: 'i_warna'},
            {data: 'id_price', name: 'id_price'},
            {data: 'i_note', name: 'i_note'},
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
        "ajax": {
            "url": "{{ url('master-item/get-data-a') }}",
            "type": "POST"
        },
        dataType: 'json',
        processing: true,
        serverSide: true,
        columns: [
            {data: 'i_nama', name: 'i_nama'},
            {data: 's_nama', name: 's_nama'},
            {data: 'i_warna', name: 'i_warna'},
            {data: 'id_price', name: 'id_price'},
            {data: 'i_note', name: 'i_note'},
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
            source: baseUrl+'/autoitem',
            minLength: 3,
            select: function(event, ui) {
            $('#id_barang').val(ui.item.id);
            $('#cari').val(ui.item.label);
            tanam(ui.item.id, ui.item.i_nama, ui.item.harga, ui.item.warna, ui.item.ukuran, ui.item.detailid, ui.item.note);
        }
    });
});

function tanam(id, nama, harga, warna, ukuran, detailid, note){
    harga = accounting.formatMoney(harga, "", 0, ".", ","); // €4.999,99
    tableS.row.add([
               nama,
               ukuran,
               warna,
               '<span style="float: left">Rp. </span><span style="float:right" class="hargaitem">'+harga+'</span>',
               note,
               buttonGen(id, detailid)
            ]).draw( false );
}

function buttonGen(id, detailid){
    var buton = '<div class="text-center"><button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" onclick="edit('+id+','+detailid+')"><i class="glyphicon glyphicon-edit"></i></button><button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus" onclick="hapus('+id+','+detailid+')"><i class="glyphicon glyphicon-trash"></i></button></div>'
    return buton;
}

function addsupp(id, detailid){
    alert(detailid);
}

function edit(id, detail){
    window.location.assign("{{ url('master-item/edit') }}/"+id);
}

function hapus(id, id_dt){
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
                  url: baseUrl + '/master-item/delete',
                  type: 'get',
                  data: {id: id, dt: id_dt},
                  success: function(response){
                    if (response.status == 'sukses') {
                      swal({
                        title: "Terhapus",
                        text: "Data telah dihapus",
                        showConfirmButton: true,
                        type: "success"
                    });
                      location.reload();
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

function add(id, id_dt){
  var tanam = '<option value="">--Pilih Mitra--</option>';
    $.ajax({
      url: baseUrl + '/master-item/getInfo',
      type: 'get',
      data: {id: id, dt: id_dt},
      success: function(response){
        for (var i = 0; i < response.info.length; i++) {
          tanam += '<option value="'+response.info[i].m_id+'">'+response.info[i].m_name+'</option>';
        }
        $('.addmitra').html(tanam);
        $('#tambahmitra').attr('onclick', 'tambahmitra('+id+', '+id_dt+')');
        $('#simpanbtn').attr('onclick', 'simpan('+id+')');
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
    $('#myModal').modal('show');
}

function tambahmitra(id, id_dt){
 hitung += 1;

  $('.form-dinamis').append('<div class="form-group getkonten'+hitung+'">'+
      '<label class="col-sm-2 control-label" for="ukuranbarang">Mitra</label>'+
      '<div class="col-sm-6 selectukuran0">'+
          '<select class="form-control mitraselect'+hitung+' select2 addmitra" name="addmitra[]" id="addmitra">'+
              '<option value="">--Pilih Mitra--</option>'+
          '</select>'+
      '</div>'+
      '<span>'+
          '<a type="button" class="btn btn-primary" onclick="tambahmitra()"><i class="fa fa-plus"></i></a>'+
          ' '+
          '<a type="button" class="btn btn-danger" onclick="kurangmitra('+hitung+')"><i class="fa fa-times"></i></a>'+
      '</span>'+
  '</div>');

  add(id, id_dt);
}

function kurangmitra(hitung){
    $('.getkonten'+hitung).remove();
}

function alertmitra(){
  $('.form-dinamis').append('<span id="alertmitra" style="color:red;">Tidak Boleh Dihapus!</span>');
  setTimeout(function(){ $('#alertmitra').remove(); }, 3000);
}

function simpan(id){
  var data = [];
  for (var i = 0; i <= hitung; i++) {
    data[i] = $(".mitraselect"+i).val();
  }

  $.ajax({
    type: 'get',
    data: {data:data, id:id},
    url: baseUrl + '/master-item/addmitra',
    dataType: 'json',
    success : function(result){
      console.log(result);
    }
  });
}
</script>
@endsection
