@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>List Payroll</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
              Payroll
            </li>
            <li class="active">
                <strong>List Payroll</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>List Payroll Yang Belum Di Proses</h5>
        <a href="{{ url('manajemen-payroll/payroll/tambah') }}" style="float: right; margin-top: -7px; margin-right: 10px;" class="btn btn-primary btn-flat" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                  <center>
                    <div class="spiner-example">
                        <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                            <div class="sk-rect1 tampilkan" ></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                        <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Daftar Approval</span>
                    </div>
                </center>
                <form class="formapprovalremunerasi" id="formapprovalremunerasi">
                    <table id="remunerasitabel" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>No Payroll</th>
                                <th>Start Periode</th>
                                <th>End Periode</th>
                                <th style="width: 120%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $index => $x)
                          <tr>
                                <td>{{$x->p_name}}</td>
                                <td>{{$x->p_nip}}</td>
                                <td>{{$x->p_no}}</td>
                                <td>{{Carbon\Carbon::parse($x->p_start_periode)->format('d/m/Y')}}</td>
                                <td>{{Carbon\Carbon::parse($x->p_end_periode)->format('d/m/Y')}}</td>
                                <td align="center">
                                <button type="button" title="Lanjutkan" onclick="Lanjutkan({{$x->p_no}})"  class="btn btn-info btn-sm" name="button"> <i class="fa fa-chevron-circle-right"></i> </button>
                                <button type="button" title="Hapus" onclick="hapus({{$x->p_no}})"  class="btn btn-danger btn-sm" name="button"> <i class="glyphicon glyphicon-trash"></i> </button>
                               </td>
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
var table;
var countmitra;
var totalmitra;
$( document ).ready(function() {

$('#remunerasitabel').hide();
myFunction();

function myFunction() {
setTimeout(function(){
  $(".spiner-example").css('display', 'none');
  table = $("#remunerasitabel").DataTable({
    "processing": true,
    "paging": false,
    "searching": false,
    "deferLoading": 57,
    responsive: true,
    "language": dataTableLanguage
  });
  $('#remunerasitabel').show();
},1500);
  }

});

</script>
@endsection
