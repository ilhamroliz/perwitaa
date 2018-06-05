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
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>

    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
        <div id="filter">
            {{-- @if ($apk)
            <div class="row-fluid">
                <div  class="col-md-4 pull-right">
                    <select  style="width: 100%; margin-top: 20px;" id="select-picker" class="select-picker form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn()">
                    <option value="" selected="true" >-Cari Mitra-</option>
                    @foreach ($apk as $index => $asw)
                        <option value="{{ $asw ->m_name }}">{{$asw ->m_name}}</option>
                    @endforeach
                    </select>  
                    @else
                    <p>Data tidak Ketemu</p>
                    @endif
                </div>
            </div> --}}
        </div>   

            <div class="col-md-12" style="margin: 10px 0px 20px 0px;">                    
            </div>
        
            <div class="col-md-12 table-responsive "  style="margin: 10px 0px 20px 0px;">                   
               <table id="pekerja" class="table table-bordered table-striped display" >             
                    <thead>
                        <tr>       
                            {{-- <th>No</th> --}}
                            {{-- <th hidden="">perusahaan</th> --}}             
                            <th>Nama</th>
                            <th>Mitra NIK</th>          
                            <th>Mitra</th>           
                            {{-- <th>divisi</th> --}}
                            {{-- <th>tgl seleksi</th> --}}
                            <th>Mulai Bekerja</th>
                            <th style="width : 10%;">aksi</th>
                        </tr>
                    </thead>     
                    <tbody>   
                    {{-- @foreach ($dpm as $index => $d)
                  
                    <tr>
                        <td>{{$index+1}}</td>
                        <td hidden="">{{$d->c_name}}</td>
                        <td><a href="/pwt/manajemen-pekerja/data-pekerja/{{$d->p_id}}/edit">{{$d->p_name}}</a></td>
                        <td>{{$d->m_name}}</td>
                        <td>{{$d->mc_no}}</td>
                        <td>{{$d->md_name}}</td>
                        <td>{{$d->mp_mitra_nik}}</td>
                        <td>{{ \Carbon\Carbon::parse($d->mp_selection_date)->format('d-m-Y')}}</td>
                        <td>{{ \Carbon\Carbon::parse($d->mp_workin_date)->format('d-m-Y')}}</td>
                        <td class="text-center" style="vertical-align:middle;">
                            <div class="btn-group">
                            <a href="edit/{{$d->mp_id}}/{{$d->p_id}}"><button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></button></a>
                            <a href="hapus/{{$d->p_id}}"><button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach --}}

                    </tbody>
                </table>
            </div>  
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
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
                "type": "get"
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

function filterColumn ( ) {
    var nmitra = $('.select-picker').val();
    $('#table').DataTable().column(2).search(nmitra).draw(); 
}
</script>
@endsection     