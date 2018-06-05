@extends('main')

@section('title', 'dashboard')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-7">
        <h2>Master Data Akun</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                <a>Data Master</a>
            </li>
            <li class="active">
                <strong>Master Data Akun</strong>
            </li>
        </ol>
    </div>
     <div class="col-lg-5">
        <div class="title-action">
             {!! Form::open(['url' => 'laporan-keuangan/laba-rugi/periode/bulan', 'method' => 'GET', 'id' => 'form-pencarian']) !!}
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
               <a href="{{url('laporan-keuangan/laba-rugi/periode/bulan')}}"class="btn btn-flat btn-default">
                    <span class="fa fa-repeat"></span>
                </a> 
              </div>
             {!! Form::close() !!}

        </div>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Master Akun</h5> 

                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="labarugi" class="table table-bordered table-striped">                                    
                            <thead>
                                <tr>
                                    <th style="">Detail</th>
                                    <th style=" text-align:right;">Nilai</th>
                                    <th style=" text-align:right;">Total</th>                                                                                    
                                    <th style=" text-align:right;">Presentase</th>                                                                                    
                                </tr>   
                            <thead>
                            <tbody class="hasil">
                                <tr>
                                    <th style="">PENDAPATAN/ REVENUE</th>
                                    <th style=""></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                </tr> 

                                @foreach($pendapatan as $pendapatan)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$pendapatan->tr_name}}</td>
                                    <td style="text-align: right;">{{ number_format($pendapatan->jum,2,',','.') }}</td>                                                                                    
                                    <td style=" text-align:right;"></td>                                                                                                                                  
                                    <td style=" text-align:right;">{{ number_format(($pendapatan->jum/$total_pendapata)*100,2,',','.') }}%</td>                                                                                    

                                </tr>                                        
                                @endforeach

                                <tr>
                                    <th style="padding-left: 50px;">Total Pendapatan</th>
                                    <th style=""></th>                                            
                                    <td style=" text-align:right;">{{ number_format($total_pendapata,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;"></td> 
                                </tr>

                                <tr>
                                    <th style="">HPP/COGS</th>
                                    <th style=""></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                </tr>
                                @foreach($hpp as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($viabca->jum,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;"></td>        
                                    <td style=" text-align:right;">{{ number_format(($viabca->jum/$total_hpp)*100,2,',','.') }}%</td>    
                                </tr>
                                @endforeach
                                <tr>
                                    <th style="padding-left: 50px;">Total HPP</th>
                                    <th style=""></th>                    
                                    <td style=" text-align:right;">{{ number_format($total_hpp,2,',','.') }}</td>                                   
                                    <th style=" text-align:right;"></th> 
                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>
                                    <th style="padding-left: 50px;">Laba Kotor</th>
                                    <th style=""></th>                                            
                                    <td style=" text-align:right;">{{ number_format($total_pendapata+$total_hpp,2,',','.') }}</th> 
                                    <td style=" text-align:right;"></td> 


                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>
                                    <th style=""> BIAYA / EXPENSES</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                @foreach($expenses as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($viabca->jum,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;"></td>    
                                    <td style=" text-align:right;">{{ number_format(($viabca->jum/$total_expenses)*100,2,',','.') }}%</td>    

                                </tr>
                                @endforeach
                                <tr>
                                    <th style="padding-left: 50px;">Total Biaya</th>
                                    <th style=""></th> 
                                    <td style=" text-align:right;">{{ number_format($total_expenses,2,',','.') }}</td>                                   
                                    <th style=" text-align:right;"></th> 
                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>
                                    <th style=""> DEPRESIASI / DEPRECIACION </th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>                                        
                                @foreach($depresiasi as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($viabca->jum,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;"></td>    
                                    <td style=" text-align:right;"></td>    

                                </tr>
                                @endforeach
                                <tr>
                                    <th style="">  AMORTISASI / AMORTIZATION</th>
                                    <th style=""></th> 
                                    <th style="">-</th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>
                                @foreach($amortisasi as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($viabca->jum,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;"></td>    
                                    <td style=" text-align:right;"></td>    

                                </tr>
                                @endforeach
                                <tr>                                                                                        
                                    <th style="">LABA OPERASIONAL / OPERATIONAL PROFIT</th>
                                    <th style=""></th>                                            
                                    <td style=" text-align:right;">{{ number_format($total_pendapata+$total_hpp+$total_expenses,2,',','.') }}</th> 
                                    <td style=" text-align:right;"></td> 
                                </tr>
                                </tr>
                                <tr>                                            
                                    <th style=""> PENDAPATAN LAIN-LAIN</th>
                                    <th style=""></th> 
                                    <th style=" text-align:right;"></th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>
                                @foreach($pendapatanlain as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($viabca->jum,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;"></td>    
                                    <td style=" text-align:right;"></td>    

                                </tr>
                                @endforeach
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>                                            
                                    <th style=""> PENGELUARAN LAIN-LAIN</th>
                                    <th style=""></th>                                           
                                    <th style=" text-align:right;"></th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>
                                @foreach($pengeluaranlain as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($viabca->jum,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;"></td>    
                                    <td style=" text-align:right;"></td>    

                                </tr>
                                @endforeach
                                <tr>
                                    <th style="padding-left: 50px;"> LABA/RUGI LAIN-LAIN</th>
                                    <th style=""></th>                                            
                                    <td style=" text-align:right;">{{ number_format($total_pendapatanlain,2,',','.') }}</th> 
                                    <td style=" text-align:right;"></td> 
                                </tr>
                                <tr>
                                    <th style=""> BUNGA / INTEREST</th>
                                    <th style=""></th>                                             
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>
                                    <th style=""> PAJAK / TAX </th>
                                    <th style=""></th>                                             
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                @foreach($pajak as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($viabca->jum,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;"></td> 
                                    <td style=" text-align:right;"></td> 
                                </tr>
                                @endforeach
                                <tr>
                                    <th style=""></th>
                                    <th style=""></th>                                             
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr style=" border-top: 3px solid #cccccc">
                                    <th style="padding-left: 50px;"> NET PROFIT</th>
                                    <th style=""></th>                                             
                                    <td style=" text-align:right;">{{ number_format($total_pendapata+$total_pendapatanlain+$total_hpp+$total_expenses,2,',','.') }}</th> 
                                    <th style=""></th> 
                                </tr>
                            </tbody></table>                                        
                    </div>  
                </div>


            </div>
        </div>

    </div>
</div>








@endsection



@section('extra_scripts')
<script type="text/javascript">
        $('#tgl').datepicker({
        format: 'dd-M-yyyy',
        })

</script>
@endsection
