@extends ('main')

    @section('title', 'Dashboard')



    @section ('extra_styles')

    <style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    </style>

    @endsection

@section ('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Penggajian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Payroll
            </li>
            <li class="active">
                <strong>Penggajian</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
                    <h5>Penggajian</h5><br>
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
            </div>
            <br>
            <div class="col-md-12 table-responsive " id="tabledinamis"  style="margin: 10px 0px 20px 0px;">
               <table id="pekerja" class="table table-bordered table-striped display" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>BPJS Kesehatan</th>
                            <th>BPJS Ketenagakerjaan</th>
                            <th>Gaji</th>
                            <th>RBH</th>
                            <th>Dapan</th>
                            <th>Total</th>
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


@endsection

@section('extra_scripts')
<script type="text/javascript">
$(document).ready(function(){
  $('#pekerja').DataTable({
    responsive: true,
    "pageLength": 10,
    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
    // "scrollY": '50vh',
    // "scrollCollapse": true,
        "language": dataTableLanguage,
  });
});

var table;
$(document).ready(function() {
    $('#select-picker').select2();

    setTimeout(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        table = $("#pekerja").DataTable({
            "search": {
                "caseInsensitive": true
            },
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "{{ url('pekerja-di-mitra/pekerja-mitra/table') }}",
                "type": "get",
                "data": {mitra: idmitra, divisi: id_divisi}
            },
            columns: [
                {data: 'p_name', name: 'p_name'},
                {data: 'mp_mitra_nik', name: 'mp_mitra_nik'},
                {data: 'm_name', name: 'm_name'},
                {data: 'mp_workin_date', name: 'mp_workin_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true,
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
            "language": dataTableLanguage,
        });
    }, 1500);
});

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
  var html = "";
  var mitra = $('#selectmitra').val();
  var divisi = $('#selectdivisi').val();
  $.ajax({
    type: 'get',
    data: 'mitra='+mitra+"&divisi="+divisi,
    url: baseUrl + '/manajemen-payroll/payroll/cari',
    dataType: 'json',
    success : function(result){
      for (var i = 0; i < result.length; i++) {
        html += '<tr role="row" class="odd">'+
              '<td>'+result[i].p_name+'</td>'+
              '<td>'+result[i].p_nip+'</td>'+
              '<td>'+result[i].m_name+'</td>'+
              '<td>'+result[i].md_name+'</td>'+
              '<td>'+result[i].mp_workin_date+'</td>'+
              '<td align="center">'+
                  '<a style="margin-left:5px;" title="Gaji" type="button" onclick="gaji('+result[i].mp_id+')" class="btn btn-success btn-xs"><i class="fa fa-money"></i></a>'+
              '</td>'+
              '</tr>';
      }
      $('#showdata').html(html);
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

  function getdata(id){
    waitingDialog.show();
    var html = "";
    $.ajax({
      type: 'get',
      url: baseUrl + '/pekerja-di-mitra/getdata',
      data: {id:id},
      dataType: 'json',
      success : function(result){
        html += '<tr>'+
              '<td>'+result[0].p_name+'</td>'+
              '<td>'+result[0].mp_mitra_nik+'</td>'+
              '<td>'+result[0].m_name+'</td>'+
              '<td>'+result[0].md_name+'</td>'+
              '<td>'+result[0].mp_workin_date+'</td>'+
              '<td align="center">'+
                  '<a style="margin-left:5px;" title="Gaji" type="button" onclick="gaji('+result[0].mp_id+')" class="btn btn-success btn-xs"><i class="fa fa-money"></i></a>'+
              '</td>'+
              '</tr>';
      $('#showdata').html(html);
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

</script>
@endsection