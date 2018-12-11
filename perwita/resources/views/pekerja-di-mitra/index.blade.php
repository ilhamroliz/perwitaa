@extends ('main')

    @section('title', 'Pekerja di Mitra')



    @section ('extra_styles')

    <style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    </style>

    @endsection

@section ('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Pekerja di Mitra</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Pekerja di Mitra</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
                    <h5>Daftar Pekerja di Mitra</h5><br>
                    <div class="ibox-tools">
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
        <div id="filter">
              <div class="row">
                <div class="col-6 col-md-3">
                  @if(empty($data))
                  <p>Data tidak Ketemu</p>
                    @else
                    <select id="selectmitra" class="select-picker form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumnmitra()">
                    <option value="" selected="true" >- Cari Mitra -</option>
                    <option value="all">Select All</option>
                    @foreach ($data as $key => $value)
                        <option value="{{ $value ->md_mitra }}" id="optionvalue">{{$value ->m_name}}</option>
                    @endforeach
                    </select>
                    @endif
                </div>
                <div class="col-6 col-md-3">
                  <select class="select-picker form-control" name="selectdivisi" id="selectdivisi" onchange="filterColumndivisi()">
                    <option value="all">Select All</option>
                  </select>
                </div>
                <div class="col-6 col-sm-2">
                <button  style="margin-left: 40px;" type="button" name="button" id="cari" class="btn btn-primary" mitra="" divisi="" onclick="cari()">Filter Cari</button>
                </div>
                <div class="col-6 col-sm-2 pull-right">
                      <button type="button" style="float:right;" onclick="printDiv()" class="btn btn-info" name="button"><i class="fa fa-print">&nbsp;</i>Print</button>
                </div>
            </div>
            <br>
            <div class="col-md-8" style="margin-left: -15px;">
              <label for="carino">Cari Berdasarkan No Mitra / No Mitra Contract</label>
              <input type="text" name="carino" value="" class="form-control" id="carino" placeholder="Nomer Mitra/Contract" >
            </div>
            <br>
            <div class="col-md-12 table-responsive " id="tabledinamis"  style="margin: 10px 0px 20px 0px;">
               <table id="pekerja" class="table table-bordered table-striped display" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Mitra NIK</th>
                            <th>Mitra</th>
                            <th>Divisi</th>
                            <th>Mulai Bekerja</th>
                            <th style="width:5px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="showdata">
                    </tbody>
                </table>
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
                <i class="fa fa-newspaper-o modal-icon"></i>
                <h4 class="modal-title">Edit Mitra NIK</h4>
                <small class="font-bold">Edit Mitra NIK</small>
            </div>
            <div class="modal-body">
                <h3 class="namabarang"></h3>
                <form class="form-horizontal">
                    <div class="form-dinamis">
                        <div class="form-group getkonten0">
                            <label class="col-sm-2 control-label" for="ukuranbarang">Mitra NIK</label>
                            <div class="col-sm-9 selectukuran0">
                                <input type="text" name="nik" id="nik" class="form-control" placeholder="Mitra NIK" title="Mitra NIK">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpannik()" id="simpanbtn" class="btn btn-primary btn-outline" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;
$(document).ready(function(){
  table = $('#pekerja').DataTable({
    responsive: true,
    "pageLength": 10,
    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
    // "scrollY": '50vh',
    // "scrollCollapse": true,
        "language": dataTableLanguage,
  });
  $("#carino").autocomplete({
    source: baseUrl + '/pekerja-di-mitra/getnomor',
    select: function(event, ui) {
      getdata(ui.item.id);
    }
  });
});

function printDiv() {
    var divToPrint = document.getElementById('pekerja');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding;0.5em;' +
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
}

// var table;
// $(document).ready(function() {
//     $('#select-picker').select2();
//
//     setTimeout(function () {
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });
//         table = $("#pekerja").DataTable({
//             "search": {
//                 "caseInsensitive": true
//             },
//             processing: true,
//             serverSide: true,
//             "ajax": {
//                 "url": "{{ url('pekerja-di-mitra/pekerja-mitra/table') }}",
//                 "type": "get",
//                 "data": {mitra: idmitra, divisi: id_divisi}
//             },
//             columns: [
//                 {data: 'p_name', name: 'p_name'},
//                 {data: 'mp_mitra_nik', name: 'mp_mitra_nik'},
//                 {data: 'm_name', name: 'm_name'},
//                 {data: 'mp_workin_date', name: 'mp_workin_date'},
//                 {data: 'action', name: 'action', orderable: false, searchable: false}
//             ],
//             responsive: true,
//             "pageLength": 10,
//             "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
//             "language": dataTableLanguage,
//         });
//     }, 1500);
// });

function filterColumnmitra () {
    $("#selectdivisi").html('<option value="all">Select All</option>');
    var nmitra = $('#selectmitra').val();
    $('#table').DataTable().column(2).search(nmitra).draw();
    id =  $('#selectmitra').val();
    var html = "";
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/pekerja-di-mitra/getdivisi',
      dataType: 'json',
      success : function(result){
        // console.log(result);
        for (var i = 0; i < result.length; i++) {
          html += '<option value="'+result[i].md_id+'">'+result[i].md_name+'</option>';
        }
        $("#selectdivisi").append(html);
        $("#cari").attr('mitra',id);
      }
    });
}

function filterColumndivisi(){
  var id = $('#selectdivisi').val();
  $("#cari").attr('divisi',id);
}

function cari(){
  waitingDialog.show();
  $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
  var mitra = $('#selectmitra').val();
  var divisi = $('#selectdivisi').val();
  $.ajax({
    type: 'post',
    data: 'mitra='+mitra+"&divisi="+divisi,
    url: baseUrl + '/pekerja-di-mitra/getpekerja',
    dataType: 'json',
    success : function(result){
      table.clear();
      for (var i = 0; i < result.length; i++) {
        table.row.add([
          result[i].p_name,
          result[i].mp_mitra_nik,
          result[i].m_name,
          result[i].md_name,
          result[i].mp_workin_date,
          generatebutton(result[i].mp_id)
        ]).draw(false);
      }
      waitingDialog.hide();
    }, error:function(x, e) {
        waitingDialog.hide();
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
        waitingDialog.hide();
    }
  })
}

 function generatebutton(id){
   var html = '<a style="margin-left:5px;" title="Edit NIK" type="button" onclick="editnik('+id+')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'+
              ' '+
              '<button type="button" class="btn btn-danger btn-xs" onclick="hapus('+id+')" name="button"> <i class="fa fa-trash"></i> </button>';

  return html;
 }

  function getdata(id){
    waitingDialog.show();
    $.ajax({
      type: 'get',
      url: baseUrl + '/pekerja-di-mitra/getdata',
      data: {id:id},
      dataType: 'json',
      success : function(result){
        table.clear();
          table.row.add([
            result[0].p_name,
            result[0].mp_mitra_nik,
            result[0].m_name,
            result[0].md_name,
            result[0].mp_workin_date,
            generatebutton(result[0].mp_id)
          ]).draw(false);
      waitingDialog.hide();
      }, error:function(x, e) {
          waitingDialog.hide();
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
          waitingDialog.hide();
      }
    });
  }

  function editnik(id){
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/pekerja-di-mitra/getnik',
      dataType: 'json',
      success : function(result){
        $('#nik').val(result[0].mp_mitra_nik);
        $('#simpanbtn').attr('onclick', 'simpannik('+id+')');
        $('#myModal').modal('show');
      }
    });
  }

  function simpannik(id){
    $.ajax({
      type: 'get',
      data: {id:id, nik:$('#nik').val()},
      url: baseUrl + '/pekerja-di-mitra/simpannik',
      dataType: 'json',
      success : function(result){
        if (result.status == 'berhasil') {
          swal({
              title: "Data NIK Disimpan",
              text: "Data NIK berhasil Disimpan",
              type: "success",
              showConfirmButton: false,
              timer: 900
          });
          setTimeout(function(){
                window.location.reload();
        }, 850);
        }
      }
    });
  }

  function hapus(id){
      swal({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin menghapus data?",
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
            type: 'get',
            data: {id:id},
            dataType: 'json',
            url: baseUrl + '/pekerja-di-mitra/hapus',
            success : function(result){
             if(result.status=='berhasil'){
                swal({
                  title:"Berhasil",
                  text: "Data berhasil dihapus",
                  type: "success",
                  showConfirmButton: false,
                  timer: 900
              });
              setTimeout(function(){
                    window.location.reload();
            }, 850);
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
    });
      }, 2000);

    });
  }

</script>
@endsection
