@extends('main')

@section('title', 'Proses Gaji')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
              Payroll
            </li>
            <li class="active">
                <strong>Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Pekerja</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                <form class="formapprovalremunerasi" id="formapprovalremunerasi">
                    <table id="remunerasitabel" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>NIK Mitra</th>
                                <th>Tunjangan Makan</th>
                                <th>Tunjangan Jabatan</th>
                                <th>Tunjangan Transport</th>
                                <th>BPJS Kesehatan</th>
                                <th>BPJS Ketenagakerjaan</th>
                                <th>RBH</th>
                                <th>Dapan</th>
                                <th>Total Gaji</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $index => $x)
                          <tr>
                              <td>{{$x->p_name}}</td>
                              <td>{{$x->p_nip}}</td>
                              <td>{{$x->p_nip_mitra}}</td>
                              <td>Rp. {{number_format((int)$x->p_tjg_makan,2,',','.')}}</td>
                              <td>Rp. {{number_format((int)$x->p_tjg_jabatan,2,',','.')}}</td>
                              <td>Rp. {{number_format((int)$x->p_tjg_transport,2,',','.')}}</td>
                              <td>Rp. {{number_format((int)$x->bikes_value,2,',','.')}}</td>
                              <td>Rp. {{number_format((int)$x->biket_value,2,',','.')}}</td>
                              <td>Rp. {{number_format((int)$x->biker_value,2,',','.')}}</td>
                              <td>Rp. {{number_format((int)$x->biked_value,2,',','.')}}</td>
                              <td>Rp. {{number_format((int)$x->pd_total,2,',','.')}}</td>
                              <td>{{$x->pd_note}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                  </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
$('#remunerasitabel').DataTable({
       dom: 'Bfrtip',
       title: '',
       scrollX: true,
       buttons: [
           'copy', 'csv', 'excel', 'pdf', 'print'
       ]
   });
</script>
@endsection
