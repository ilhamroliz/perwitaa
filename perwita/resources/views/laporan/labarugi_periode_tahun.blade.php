@extends('main')

@section('title', 'dashboard')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-7">
        <h2>Laporan Periode Laba Rugi</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                <a>Data Master</a>
            </li>
            <li class="active">
                <strong>Laporan Periode Laba Rugi</strong>
            </li>
        </ol>
    </div>
     
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Laporan Periode Laba Rugi</h5> 

                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="labarugi" class="table table-bordered table-striped">                                    
                            <thead>
                                <tr>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">Periode / Jenis</th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">Januari </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">Februari </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">Maret </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">April </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">Mei </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">Juni </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">Juli </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">Agustus </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">September </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">Oktober </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">November </th>
                                    <th style="background-color:#000000; color: #ffffff;font-size:12px;">Desember </th>                                                                                  
                                </tr>   
                            <thead>
                            <tbody class="hasil">
                                <tr>
                                    <th style="">PENDAPATAN/ REVENUE</th>
                                    <th style=""></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                </tr> 
                                @foreach($pendapatan as $pendapatan)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$pendapatan->tr_name}}</td>
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan1,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan2,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan3,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan4,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan5,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan6,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan7,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan8,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan9,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan10,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan11,2,',','.') }}</td>                                                                                    
                                    <td style="text-align: right;">{{ number_format($pendapatan->bulan12,2,',','.') }}</td>                                                                                                                        
                                </tr>                                        
                                @endforeach
                                <tr>
                                    <th style="padding-left: 50px;">Total Pendapatan</th>                                                        
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan1,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan2,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan3,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan4,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan5,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan6,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan7,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan8,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan9,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan10,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan11,2,',','.') }}</td>                                                                  
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan12,2,',','.') }}</td>                                                                                                      
                                </tr>
                                <tr>
                                    <th style="">HPP/COGS</th>
                                    <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                  
                                </tr>
                                @foreach($hpp as $hpp)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$hpp->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan1,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan2,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan3,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan4,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan5,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan6,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan7,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan8,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan9,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan10,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan11,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($hpp->bulan12,2,',','.') }}</td>                                                                                                           
                                </tr>
                                @endforeach
                                <tr>
                                    <th style="padding-left: 50px;">Total HPP</th>                                    
                                    <td style=" text-align:right;">{{ number_format($total_hpp1,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp2,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp3,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp4,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp5,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp6,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp7,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp8,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp9,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp10,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp11,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_hpp12,2,',','.') }}</td>                                   
                                    
                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>    
                                </tr>
                                <tr>
                                    <th style="padding-left: 50px;">Laba Kotor</th>                                    
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan1+$total_hpp1,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan2+$total_hpp2,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan3+$total_hpp3,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan4+$total_hpp4,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan5+$total_hpp5,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan6+$total_hpp6,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan7+$total_hpp7,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan8+$total_hpp8,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan9+$total_hpp9,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan10+$total_hpp10,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan11+$total_hpp11,2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan12+$total_hpp12,2,',','.') }}</th> 
                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>    
                                </tr>
                                <tr>
                                    <th style=""> BIAYA / EXPENSES</th>
                                   <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>     
                                </tr>
                                @foreach($expenses as $expenses)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$expenses->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan1,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan2,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan3,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan4,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan5,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan6,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan7,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan8,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan9,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan10,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan11,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($expenses->bulan12,2,',','.') }}</td>                                   
                                </tr>
                                @endforeach
                                <tr>
                                    <th style="padding-left: 50px;">Total Biaya</th>                                    
                                    <td style=" text-align:right;">{{ number_format($total_expenses1,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses2,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses3,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses4,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses5,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses6,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses7,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses8,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses9,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses10,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses11,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($total_expenses12,2,',','.') }}</td>                                                                       
                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>    
                                </tr>
                                <tr>
                                    <th style=""> DEPRESIASI / DEPRECIACION </th>
                                    <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>     
                                </tr>                                        
                                @foreach($depresiasi as $depresiasi)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$depresiasi->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan1,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan2,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan3,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan4,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan5,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan6,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan7,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan8,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan9,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan10,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan11,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($depresiasi->bulan12,2,',','.') }}</td>                                                                                                           
                                </tr>
                                @endforeach
                                <tr>
                                    <th style="">  AMORTISASI / AMORTIZATION</th>
                                   <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>    
                                </tr>
                                @foreach($amortisasi as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$amortisasia->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan1,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan2,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan3,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan4,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan5,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan6,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan7,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan8,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan9,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan10,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan11,2,',','.') }}</td>                                   
                                    <td style=" text-align:right;">{{ number_format($amortisasi->bulan12,2,',','.') }}</td>                                   
                                </tr>
                                @endforeach
                                <tr>                                                                                        
                                    <th style="">LABA OPERASIONAL / OPERATIONAL PROFIT</th>                                                                           
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan1+$total_hpp1+$total_expenses1,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan2+$total_hpp2+$total_expenses2,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan3+$total_hpp3+$total_expenses3,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan4+$total_hpp4+$total_expenses4,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan5+$total_hpp5+$total_expenses5,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan6+$total_hpp6+$total_expenses6,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan7+$total_hpp7+$total_expenses7,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan8+$total_hpp8+$total_expenses8,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan9+$total_hpp9+$total_expenses9,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan10+$total_hpp10+$total_expenses10,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan11+$total_hpp11+$total_expenses11,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan12+$total_hpp12+$total_expenses12,2,',','.') }}</td> 
                                    
                                </tr>
                                </tr>
                                <tr>                                            
                                    <th style=""> PENDAPATAN LAIN-LAIN</th>
                                   <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>    
                                </tr>
                                @foreach($pendapatanlain as $pendapatanlain)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$pendapatanlain->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan1,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan2,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan3,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan4,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan5,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan6,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan7,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan8,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan9,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan10,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan11,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pendapatanlain->bulan12,2,',','.') }}</td>                                                                       
                                </tr>
                                @endforeach
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>    
                                </tr>
                                <tr>                                            
                                    <th style=""> PENGELUARAN LAIN-LAIN</th>
                                   <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>    
                                </tr>
                                @foreach($pengeluaranlain as $pengeluaranlain)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$pengeluaranlain->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan1,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan2,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan3,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan4,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan5,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan6,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan7,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan8,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan9,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan10,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan11,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pengeluaranlain->bulan12,2,',','.') }}</td>                                                                       
                                </tr>
                                @endforeach
                                <!--rumus!-->
                                <tr>
                                    <th style="padding-left: 50px;"> LABA/RUGI LAIN-LAIN</th>                                    
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain1-$total_pengeluaranlain1),2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain2-$total_pengeluaranlain2),2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain3-$total_pengeluaranlain3),2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain4-$total_pengeluaranlain4),2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain5-$total_pengeluaranlain5),2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain6-$total_pengeluaranlain6),2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain7-$total_pengeluaranlain7),2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain8-$total_pengeluaranlain8),2,',','.') }}</th> 
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain9-$total_pengeluaranlain9),2,',','.') }}</th>                                     
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain10-$total_pengeluaranlain10),2,',','.') }}</th>                                     
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain11-$total_pengeluaranlain11),2,',','.') }}</th>                                     
                                    <td style=" text-align:right;">{{ number_format(($total_pendapatanlain12-$total_pengeluaranlain12),2,',','.') }}</th>                                     
                                </tr>
                                <tr>
                                    <th style=""> BUNGA / INTEREST</th>
                                    <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>    
                                </tr>
                                @foreach($bunggainvesi as $bunggainvesi)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$bunggainvesi->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan1,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan2,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan3,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan4,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan5,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan6,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan7,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan8,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan9,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan10,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan11,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($bunggainvesi->bulan12,2,',','.') }}</td>                                                                       
                                </tr>
                                @endforeach
                                <tr>
                                    <th style=""> PAJAK / TAX </th>
                                    <th></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                    <th></th>    
                                </tr>
                                @foreach($pajak as $pajak)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$pajak->tr_name}}</td>
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan1,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan2,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan3,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan4,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan5,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan6,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan7,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan8,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan9,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan10,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan11,2,',','.') }}</td>                                                                       
                                    <td style=" text-align:right;">{{ number_format($pajak->bulan12,2,',','.') }}</td>                                                                                                           
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
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan1+$total_pendapatanlain1+$total_hpp1+$total_expenses1,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan2+$total_pendapatanlain2+$total_hpp2+$total_expenses2,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan3+$total_pendapatanlain3+$total_hpp3+$total_expenses3,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan4+$total_pendapatanlain4+$total_hpp4+$total_expenses4,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan5+$total_pendapatanlain5+$total_hpp5+$total_expenses5,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan6+$total_pendapatanlain6+$total_hpp6+$total_expenses6,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan7+$total_pendapatanlain7+$total_hpp7+$total_expenses7,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan8+$total_pendapatanlain8+$total_hpp8+$total_expenses8,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan9+$total_pendapatanlain9+$total_hpp9+$total_expenses9,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan10+$total_pendapatanlain10+$total_hpp10+$total_expenses10,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan11+$total_pendapatanlain11+$total_hpp11+$total_expenses11,2,',','.') }}</td> 
                                    <td style=" text-align:right;">{{ number_format($total_pendapatan12+$total_pendapatanlain12+$total_hpp12+$total_expenses12,2,',','.') }}</td> 
                                    
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
