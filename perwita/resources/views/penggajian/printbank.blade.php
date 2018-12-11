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
        <h2>Bank</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
              Payroll
            </li>
            <li class="active">
                <strong>Bank</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Bank</h5>
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
                                <th>Nomor Rekening</th>
                                <th>Total Gaji</th>
                                <th>No Reff</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $index => $x)
                          <tr>
                              <td>{{$x->p_name}}</td>
                              <td>{{$x->p_norek}}</td>
                              <td>Rp. {{number_format((int)$x->pd_total,2,',','.')}}</td>
                              <td>{{$x->pd_reff}}</td>
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
       buttons: [
           'copy', 'csv', 'excel', 'pdf', 'print'
       ]
   });
</script>
@endsection
