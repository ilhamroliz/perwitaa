@extends('main')

@section('title', 'Jabatan')

@section('extra_styles')

<style>
.popover-navigation [data-role="next"] { display: none; }
.popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Mitra Perusahaan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pengguna
            </li>
            <li class="active">
                <strong>Master Jabatan</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Jabatan Aktif</h5>
            </div>
            <div class="ibox-content">
              <div class="table-responsive">
                  <table class="table table-striped" id="table-jabatan">
                      <thead>
                          <tr>
                              <th>Nama Jabatan</th>
                          </tr>
                      </thead>
                  </table>
              </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Pengaturan Jabatan</h5>
            </div>
            <div class="ibox-content">
              
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        setTimeout(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            table = $("#pekerja").DataTable({
                processing: true,
                searching: false,
                paging: false
                serverSide: true,
                "ajax": {
                    "url": "{{ url('master-jabatan/data') }}",
                    "type": "POST"
                },
                columns: [
                    {data: 'j_name', name: 'j_name'},
                ],
                responsive: true,
                //"scrollY": '50vh',
                //"scrollCollapse": true,
                "language": dataTableLanguage,
            });
        }, 1000);
    });
</script>
@endsection
