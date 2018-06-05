@extends('main')

@section('title', 'dashboard')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-7">
        <h2>Laporan Arus Kas</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                <a>Data Master</a>
            </li>
            <li class="active">
                <strong>Laporan Arus Kas</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-5">
        <div class="title-action">
             {!! Form::open(['url' => 'laporan-keuangan/arus-kas/periode/bulan', 'method' => 'GET', 'id' => 'form-pencarian']) !!}
            <div class="form-group">
                <label style="padding-top: 10px;" class="col-sm-4 control-label">Pilih Periode</label> 
                <div class="col-sm-5">
                    <select name="bulan" class="form-control" >
                        <option>---</option>
                        <option @if($bulan=='01')selected='selected' @endif>Januari</option>
                        <option @if($bulan=='02')selected='selected' @endif>Februari</option>
                        <option @if($bulan=='03')selected='selected' @endif>Maret</option>
                        <option @if($bulan=='04')selected='selected' @endif>April</option>
                        <option @if($bulan=='05')selected='selected' @endif>Mei</option>
                        <option @if($bulan=='06')selected='selected' @endif>Juni</option>
                        <option @if($bulan=='07')selected='selected' @endif>Juli</option>
                        <option @if($bulan=='08')selected='selected' @endif>Agustus</option>
                        <option @if($bulan=='09')selected='selected' @endif>September</option>
                        <option @if($bulan=='10')selected='selected' @endif>Oktober</option>
                        <option @if($bulan=='11')selected='selected' @endif>November</option>
                        <option @if($bulan=='12')selected='selected' @endif>Desember</option>
                    </select>
                </div>
            </div>
              <div class="col-sm-3">
                <button class="btn btn-flat btn-primary btn-sm">
                    <span class="fa fa-search"></span>
                </button>
               <a href="{{url('/laporan-keuangan/arus-kas/periode')}}"class="btn btn-flat btn-default">
                    <span class="fa fa-repeat"></span>
                </a> 
              </div>
             {!! Form::close() !!}

        </div>
    </div>
</div>

<div class="row" style="padding-top: 2%;">
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">                
                <h5>Operating Cash Flow</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ number_format($total_ocf,2,',','.') }}</h1>                
                <small>Total Operating Cash Flow</small>
            </div>
        </div>
    </div>
     <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">                
                <h5>Financial Cash Flow</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ number_format($total_fcf,2,',','.') }}</h1>                
                <small>Total Financial Cash Flow</small>
            </div>
        </div>
    </div>
     <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">                
                <h5>Investing Cash Flow</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ number_format($total_icf,2,',','.') }}</h1>                            
                <small>Total Investing Cash Flow</small>
            </div>
        </div>
    </div> 
</div>


<div class="wrapper wrapper-content animated fadeInRight no-padding">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">                            
                    <h5>Operating Cash Flow</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered " id="ocf">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Nama Transaksi</th>
                                <th>Jumlah</th>
                            </tr>                  
                        </thead>
                        <tbody>                            
                            @foreach($ocf as $ocf)
                            <tr>
                                <td>{{ $ocf->tr_code }}</td>
                                <td>{{ $ocf->tr_name }}</td>                                
                                <td>{{ number_format($ocf->jum,2,',','.') }}</td>
                            </tr>
                            @endforeach                            
                        </tbody>
                    </table>



                </div>
            </div>

        </div>


    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight no-padding">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">                            
                    <h5>Financial Cash Flow</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered" id="fcf">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Nama Transaksi</th>
                                <th>Jumlah</th>
                            </tr>                  
                        </thead>
                        <tbody>
                            @foreach($fcf as $fcf)
                            <tr>
                                <td>{{ $fcf->tr_code }}</td>
                                <td>{{ $fcf->tr_name }}</td>
                                <td>{{ number_format($fcf->jum,2,',','.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>



                </div>
            </div>

        </div>


    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight no-padding">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">                            
                    <h5>Investing Cash Flow</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered" id="icf">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Nama Transaksi</th>
                                <th>Jumlah</th>
                            </tr>                  
                        </thead>
                        <tbody>
                        <tbody>
                            @foreach($icf as $icf)
                            <tr>
                                <td>{{ $icf->tr_code }}</td>
                                <td>{{ $icf->tr_name }}</td>                                
                                <td>{{ number_format($icf->jum,2,',','.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        </tbody>
                    </table>



                </div>
            </div>

        </div>


    </div>
</div>
















@endsection


@section('extra_scripts')

<script type="text/javascript">
    $('#ocf').dataTable({
		responsive: true,
	    "language": dataTableLanguage,
	});
    
    $('#fcf').dataTable({
		responsive: true,
	    "language": dataTableLanguage,
	});
	$('#icf').dataTable({
		responsive: true,
	    "language": dataTableLanguage,
	});
        $('#tgl').datepicker({
        format: 'dd-M-yyyy',
        })
</script>
@endsection


