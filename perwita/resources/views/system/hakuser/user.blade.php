@extends('main')
@section('title', 'Akses User')
@section('extra_styles')
<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    .huruf{
        text-transform: capitalize;
    }
    .spacing-top{
        margin-top:15px;
    }
    #upload-file-selector {
        display:none;   
    }
    .margin-correction {
        margin-right: 10px;   
    }
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Akses Pengguna</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Setting Aplikasi
            </li>
            <li class="active">
                <strong>Akses Pengguna</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox">
    <div class="ibox-title">
      <h5>Akses Pengguna</h5>
    </div>
    <div class="ibox-content">
      <table class="table table-striped" id="table-user">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Username</th>
            <th>Jabatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
           

@endsection
@section("extra_scripts")
<script type="text/javascript">
  var user;
  $(document).ready(function(){
    setTimeout(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        user = $("#table-user").DataTable({
            processing: true,
            searching: true,
            paging: false,
            ordering: false,
            serverSide: true,
            "ajax": {
                "url": "{{ url('system/hakakses/dataUser') }}",
                "type": "POST"
            },
            columns: [
                {data: 'm_name', name: 'm_name'},
                {data: 'm_username', name: 'm_username'},
                {data: 'j_name', name: 'j_name'},
                {data: 'aksi', name: 'aksi'}
            ],
            responsive: false,
            "language": dataTableLanguage,
        });
    }, 500);
  });

  function akses(id){
    location.href = ('{{ url('system/hakakses/edit-user-akses/edit') }}/' + id);
  }
</script>
@endsection()