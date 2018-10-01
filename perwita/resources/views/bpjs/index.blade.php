@extends ('main')

    @section('title', 'Dashboard')



    @section ('extra_styles')
    <style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>


    @endsection



    @section ('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
                    <h5>Daftar Peserta Bpjs</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>



    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">

                        <div class="text-right">
                            <button onclick="tambah()" class="btn btn-primary btn-outline btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
                            <button onclick="javascript: $('#filter').slideToggle(200);" class="btn btn-primary btn-flat btn-sm" type="button"><i class=" glyphicon glyphicon-search"></i>&nbsp;Filter </button>

                            <!-- {{--<button onclick="edit()" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-edit"></i> Ubah</button>
                            <button class="btn btn-danger btn-flat btn-sm" type="button"><i class="fa fa-trash"></i> Hapus</button>--}} -->
                        </div>

                </div>
<div id="filter" style="display: none;">
@if ($mitra || $d_mitra_divisi)
<dir class="row-fluid">
    <div  class="col-md-3 pull-right">
        <select  style="width: 200px; margin-top: 20px;" class="select-picker form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn()">
        <option value="" selected="true">-Pilih Subinstansi-</option>
        @foreach ($mitra as $index => $mitra)
            <option value="{{ $mitra -> m_name }}">{{$mitra -> m_name}}</option>
        @endforeach
    </select>

    <select  style="width: 200px; margin-top: 20px;" class="red select-picker form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn1()">
        <option value="" selected="true">-Pilih Divisi-</option>
        @foreach ($d_mitra_divisi as $m)
            <option value="{{ $m->md_name }}">{{$m->md_name}}</option>
        @endforeach
    </select>
    </div>
    @else
    <p>Data tidak Ketemu</p>
    @endif
    </div>
</dir>

                  <div class="col-md-12 zero-pad-left zero-pad-right">
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">
                </div>
                @if ($bpjs || $mitra || $d_mitra_divisi)
                <div class="col-md-12 table-responsive "  style="margin: 10px 0px 20px 0px;">
                   <table id="mitra" class="table table-bordered table-striped display" >

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Kartu</th>
                                <th>p_nik</th>
                                <th>NPP</th>
                                <th>Nama</th>
                                <th>Tgl Lahir</th>
                                <th>Hub.keluarga</th>
                                <th>TMT</th>
                                <th>Nama Fakses tingkat 1</th>
                                <th>status</th>
                                <th>kelas</th>
                                <th>Nama sub instansi</th>
                                <th>divisi</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($bpjs as $index => $bpjs)

                        <tr>
                        <td>{{ $index+1 }}</td>
                            <td>{{ $bpjs->no_kartu }}</td>
                            <td>{{ $bpjs->p_nik }}</td>
                            <td>{{ $bpjs->npp }}</td>
                            <td>{{ $bpjs->p_name }}</td>
                            <td>{{ $bpjs->p_birthdate }}</td>
                            <td>{{ $bpjs->h_keluarga }}</td>
                            <td>{{ $bpjs->TMT }}</td>
                            <td>{{  $bpjs->nf_1 }}</td>
                        @if($bpjs->p_state==0||Null)
                            <td><span class="label label-warning ">calon</span></td>
                        @elseif($bpjs->p_state==1)
                            <td><span class="label label-success ">Aktif</span></td>
                        @else($bpjs->p_state==2)
                            <td><span class="label label-danger ">Tidak Aktif</span></td>
                        @endif
                            <td>{{ $bpjs->kelas }}</td>
                            <td>{{$bpjs->m_name}}</td>
                            <td>{{$bpjs->md_name}}</td>

                             <td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary btn-flat btn-xs dropdown-toggle tampilkan" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                Kelola
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

                                                                <li role="separator" class="divider"></li>
                                                                <li><a href="bpjs/edit&{{ $bpjs->p_nik }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                                                                <li role="separator" class="divider"></li>
                                                                <li>

                                                                <li><a href="bpjs/delete/{{ $bpjs->no_kartu}}"><i class="fa fa-trash" aria-hidden="true"></i>Hapus</a></li>


                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                @else
                <p>tak ada data</p>
                @endif
            </div>

        </div>
    </div>
</div>






    @endsection

@section('extra_scripts')
<script type="text/javascript">
$('#mitra').DataTable({

});
  function tambah(){
    window.location = baseUrl+'/bpjs/create';
}

function filterColumn ( ) {
    $('#mitra').DataTable().column(11).search(
        $('.select-picker').val()
    ).draw();
}
function filterColumn1 ( ) {
    $('#mitra').DataTable().column(12).search(
        $('.red').val()
    ).draw();
}

/*
$(document).ready(function() {
    $('#bpjs').DataTable();
    function coba(){
        filterColumn( $(this).attr('data-column') );

} );*/



/*$(document).ready(function() {
    $('#bpjs').DataTable();
    $('input.column_filter').on( 'keyup click', function () {
        filterColumn( $(this).attr('data-column') );
    } );
} );*/
/*
future use for a text input filter
$('#search').on('click', function() {
    $('.box').hide().filter(function() {
        return $(this).data('order-number') == $('#search-criteria').val().trim();
    }).show();
});*/

</script>
@endsection
