@extends ('main')

    @section('title', 'Dashboard')



    @section ('extra_styles')



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
                    <h5>Daftar Pekerja di Mitra</h5>
                    <div class="ibox-tools">
                    </div>

    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
        <div id="filter">
              <div class="row">
                <div class="col-6 col-md-4">
                  @if(empty($data))
                  <p>Data tidak Ketemu</p>
                    @else
                    <select id="select-picker" class="select-picker form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumnmitra()">
                    <option value="" selected="true" >- Cari Mitra -</option>
                    <option value="all">- Select All -</option>
                    @foreach ($data as $key => $value)
                        <option value="{{ $value ->md_mitra }}" id="optionvalue">{{$value ->m_name}}</option>
                    @endforeach
                    </select>
                    @endif
                </div>
                <div class="col-6 col-md-4">
                <select class="select-picker form-control" name="selectdivisi" id="selectdivisi" onchange="filterColumndivisi()">
                  <option value="">- Cari Divisi -</option>
                  <option value="all">- Select All -</option>
                </select>
                </div>
                <div class="col-3 col-md-4">
                <button type="button" name="button" id="cari" class="btn btn-primary" mitra="" divisi="" onclick="cari()">Filter Cari</button>
                <div class="pull-right">
                  <input type="text" name="carino" value="" class="form-control" placeholder="Nomer Mitra Contact">
                </div>
                </div>
            </div>

            <br>
            <div class="col-md-12 table-responsive " id="tabledinamis"  style="margin: 10px 0px 20px 0px;">
               <table id="pekerja" class="table table-bordered table-striped display">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Mitra NIK</th>
                            <th>Mitra</th>
                            <th>Divisi</th>
                            <th>Mulai Bekerja</th>
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
  $('#pekerja').DataTable();
})
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
    $("#selectdivisi").html('<option value="">- Cari Divisi -</option><option value="all">- Select All -</option>');
    var nmitra = $('.select-picker').val();
    $('#table').DataTable().column(2).search(nmitra).draw();
    id =  $('#select-picker').val();
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
  $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
  var html = "";
  var mitra = $('#cari').attr('mitra');
  var divisi = $('#cari').attr('divisi');
  $.ajax({
    type: 'post',
    data: 'mitra='+mitra+"&divisi="+divisi,
    url: baseUrl + '/pekerja-di-mitra/getpekerja',
    dataType: 'json',
    success : function(result){
      waitingDialog.show();
      for (var i = 0; i < result.length; i++) {
        html += '<tr>'+
              '<td>'+result[i].p_name+'</td>'+
              '<td>'+result[i].mp_mitra_nik+'</td>'+
              '<td>'+result[i].m_name+'</td>'+
              '<td>'+result[i].md_name+'</td>'+
              '<td>'+result[i].mp_workin_date+'</td>'+
              '</tr>';
      }
      $('#showdata').html(html);
      waitingDialog.hide();
    }
  })
}
</script>
@endsection
