<div class="table-responsive">
                        <table id="labarugi" class="table table-bordered">                                    
                            <thead>
                                <tr>
                                    <th style=" width: 30%">Detail</th>
                                    <th>Nilai</th>
                                    <th>Total</th>                                                                                    
                                    <th>Presentase</th>                                                                                    
                                </tr>   
                            </thead>
                            <tbody class="hasil">
                                <tr>
                                    <th style="padding-left: 30px;">PENDAPATAN/ REVENUE</th>
                                    <th ></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                </tr> 

                                @foreach($pendapatan as $pendapatan)
                                <tr>                                            
                                    <td style="padding-left: 120px;">{{$pendapatan->tr_name}}</td>
                                    <td style="text-align: right;">@if($pendapatan->jum<0)({{ number_format(abs($pendapatan->jum),2,',','.') }})@else {{ number_format($pendapatan->jum,2,',','.') }} @endif</td>
                                    <td style=" text-align:right;"></td>                                                                                                                                                                      
                                    <td style=" text-align:right;">@if($total_pendapata==0)-@else{{ number_format(($pendapatan->jum/$total_pendapata)*100,2,',','.') }}%@endif</td>    
                                </tr>                                        
                                @endforeach
                                <tr>
                                    <th style="padding-left: 50px;">Total Pendapatan</th>
                                    <th ></th>                                            
                                    <td style=" text-align:right;">
                                    @if($total_pendapata<0)({{ number_format(abs($total_pendapata),2,',','.') }})@else {{ number_format($total_pendapata,2,',','.') }} @endif</td>
                                    <td style=" text-align:right;"></td> 
                                </tr>
                                <tr>
                                    <th style="padding-left: 30px;">HPP/COGS</th>
                                    <th ></th>
                                    <th></th>                                                                                    
                                    <th></th>                                                                                    
                                </tr>
                                @foreach($hpp as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 120px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">@if($viabca->jum<0)( {{ number_format(abs($viabca->jum),2,',','.') }}) @else {{ number_format($viabca->jum,2,',','.') }}@endif</td>                                   
                                    <td style=" text-align:right;"></td>        
                                    <td style=" text-align:right;">@if($total_pendapata==0)-@else{{ number_format(($viabca->jum/$total_pendapata)*100,2,',','.') }}%@endif</td>    
                                </tr>
                                @endforeach
                                <tr>
                                    <th style="padding-left: 50px;">Total HPP</th>
                                    <th style=""></th>                    
                                    <td style=" text-align:right;">
                                        @if(@$total_hpp<0)({{ number_format(abs($total_hpp),2,',','.') }}) @else {{ number_format($total_hpp,2,',','.') }} @endif</td>                                   
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
                                    <td style=" text-align:right;">
                                        @if(($total_pendapata+$total_hpp)<0)({{ number_format(abs($total_pendapata+$total_hpp),2,',','.') }})@else {{ number_format($total_pendapata+$total_hpp,2,',','.') }} @endif</td>
                                    <td style=" text-align:right;"></td> 


                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>
                                    <th style="padding-left:30px;"> BIAYA / EXPENSES</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                 @if(count($expenses)==0)
                                <tr>
                                    <th style="padding-left: 120px">-</th>
                                    <th style="">-</th> 
                                    <th style="">-</th>
                                    <th style="">-</th>
                                </tr>
                                @else
                                @foreach($expenses as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 120px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">
                                    @if($viabca->jum<0)({{ number_format(abs($viabca->jum),2,',','.') }}) @else {{ number_format($viabca->jum,2,',','.') }} @endif</td>                                   
                                    
                                    
                                    <td style=" text-align:right;"></td>    
                                    <td style=" text-align:right;">@if($total_pendapata==0)-@else{{ number_format(($viabca->jum/$total_pendapata)*100,2,',','.') }}%@endif</td>    
                                    
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <th style="padding-left: 50px;">Total Biaya</th>
                                    <th style=""></th> 
                                    <td style=" text-align:right;">
                                    @if($total_expenses<0)({{ number_format(abs($total_expenses),2,',','.') }}) @else {{ number_format($total_expenses,2,',','.') }} @endif</td>
                                    <th style=" text-align:right;"></th>
                                </tr>
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>
                                    <th style="padding-left: 30px;"> DEPRESIASI / DEPRECIACION </th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>                                        
                                @if(count($depresiasi)==0)
                                <tr>
                                    <th style="padding-left: 120px">-</th>
                                    <th style="">-</th> 
                                    <th style="">-</th>
                                    <th style="">-</th>
                                </tr>
                                @else
                                @foreach($depresiasi as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 120px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">                                   
                                    @if($viabca->jum<0)({{ number_format(abs($viabca->jum),2,',','.') }}) @else {{ number_format($viabca->jum,2,',','.') }} @endif</td>
                                    <td style=" text-align:right;"></td>                                        
                                    <td style=" text-align:right;">@if($total_pendapata==0)-@else{{ number_format(($viabca->jum/$total_pendapata)*100,2,',','.') }}%@endif</td>    
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <th style="padding-left:30px ">  AMORTISASI / AMORTIZATION</th>
                                    <th style=""></th> 
                                    <th style="">-</th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>
                                @if(count($amortisasi)==0)
                                <tr>
                                    <th style="padding-left: 120px">-</th>
                                    <th style="">-</th> 
                                    <th style="">-</th>
                                    <th style="">-</th>
                                </tr>
                                @else
                                @foreach($amortisasi as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">
                                    @if($viabca->jum<0)({{ number_format(abs($viabca->jum),2,',','.') }}) @else {{ number_format($viabca->jum,2,',','.') }} @endif</td>
                                    <td style=" text-align:right;"></td>                                        
                                    <td style=" text-align:right;">@if($total_pendapata==0)-@else{{ number_format(($viabca->jum/$total_pendapata)*100,2,',','.') }}%@endif</td>    

                                </tr>
                                @endforeach
                                @endif
                                
                                <tr>                                                                                        
                                    <th style="padding-left: 50px">LABA OPERASIONAL / OPERATIONAL PROFIT</th>
                                    <th style=""></th>                                            
                                    <td style=" text-align:right;">
                                        @if($total_pendapata+$total_hpp+$total_expenses<0)({{ number_format(abs($total_pendapata+$total_hpp+$total_expenses),2,',','.') }}) @else {{ number_format($total_pendapata+$total_hpp+$total_expenses,2,',','.') }} @endif</td>
                                        
                                        
                                        
                                    <td style=" text-align:right;"></td> 
                                </tr>
                                
                                <tr>                                            
                                    <th style="padding-left: 30px"> PENDAPATAN LAIN-LAIN</th>
                                    <th style=""></th> 
                                    <th style=" text-align:right;"></th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>
                                @if(count($pendapatanlain)==0)
                                <tr>
                                    <th style="padding-left: 120px">-</th>
                                    <th style="">-</th> 
                                    <th style="">-</th>
                                    <th style="">-</th>
                                </tr>
                                @else
                                @foreach($pendapatanlain as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 120px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">@if($viabca->jum<0)({{ number_format(abs($viabca->jum),2,',','.') }}) @else {{ number_format($viabca->jum,2,',','.') }} @endif</td>
                                    <td style=" text-align:right;"></td>                                        
                                    <td style=" text-align:right;">@if($total_pendapata==0)-@else{{ number_format(($viabca->jum/$total_pendapata)*100,2,',','.') }}%@endif</td>    
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <th style=";color: white">-</th>
                                    <th style=""></th> 
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr>                                            
                                    <th style="padding-left: 30px"> PENGELUARAN LAIN-LAIN</th>
                                    <th style=""></th>                                           
                                    <th style=" text-align:right;"></th> 
                                    <th style=" text-align:right;"></th> 
                                </tr>
                                 @if(count($pengeluaranlain)==0)
                                <tr>
                                    <th style="padding-left: 120px">-</th>
                                    <th style="">-</th> 
                                    <th style="">-</th>
                                    <th style="">-</th>
                                </tr>
                                @else
                                @foreach($pengeluaranlain as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 120px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">@if($viabca->jum<0)({{ number_format(abs($viabca->jum),2,',','.') }}) @else {{ number_format($viabca->jum,2,',','.') }} @endif</td>
                                    <td style=" text-align:right;"></td>                                        
                                    <td style=" text-align:right;">@if($total_pendapata==0)-@else{{ number_format(($viabca->jum/$total_pendapata)*100,2,',','.') }}%@endif</td>    
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <th style="padding-left: 50px;"> LABA/RUGI LAIN-LAIN</th>
                                    <th style=""></th>                                            
                                    <td style=" text-align:right;">{{ number_format($total_pendapatanlain,2,',','.') }}</th> 
                                    <td style=" text-align:right;"></td> 
                                </tr>
                                <tr>
                                    <th style="padding-left: 30px;"> BUNGA / INTEREST</th>
                                    <th style=""></th>                                             
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                  @if(count($bunggainvesi)==0)
                                <tr>
                                    <th style="padding-left: 120px">-</th>
                                    <th style="">-</th> 
                                    <th style="">-</th>
                                    <th style="">-</th>
                                </tr>
                                @else
                                @foreach($bunggainvesi as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 120px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">@if($viabca->jum<0)({{ number_format(abs($viabca->jum),2,',','.') }}) @else {{ number_format($viabca->jum,2,',','.') }} @endif</td>
                                    <td style=" text-align:right;"></td>                                        
                                    <td style=" text-align:right;">@if($total_pendapata==0)-@else{{ number_format(($viabca->jum/$total_pendapata)*100,2,',','.') }}%@endif</td>    

                                </tr>
                                @endforeach
                                @endif
                                
                                <tr>
                                    <th style="padding-left: 30px;"> PAJAK / TAX </th>
                                    <th style=""></th>                                             
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                @if(count($pajak)==0)
                                <tr>
                                    <th style="padding-left: 120px">-</th>
                                    <th style="">-</th> 
                                    <th style="">-</th>
                                    <th style="">-</th>
                                </tr>
                                @else
                                @foreach($pajak as $viabca)
                                <tr>                                            
                                    <td style="padding-left: 30px;">{{$viabca->tr_name}}</td>
                                    <td style=" text-align:right;">@if($viabca->jum<0)({{ number_format(abs($viabca->jum),2,',','.') }}) @else {{ number_format($viabca->jum,2,',','.') }} @endif</td>
                                    <td style=" text-align:right;"></td>                                     
                                    <td style=" text-align:right;">@if($total_pendapata==0)-@else{{ number_format(($viabca->jum/$total_pendapata)*100,2,',','.') }}%@endif</td>    
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <th style=""></th>
                                    <th style=""></th>                                             
                                    <th style=""></th> 
                                    <th style=""></th> 
                                </tr>
                                <tr style=" border-top: 3px solid #cccccc">
                                    <th style="padding-left: 50px;"> NET PROFIT</th>
                                    <th style=""></th>                                             
                                    <td style=" text-align:right;">
@if(($total_pendapata+$total_pendapatanlain+$total_hpp+$total_expenses)<0)
({{ number_format(abs($total_pendapata+$total_pendapatanlain+$total_hpp+$total_expenses),2,',','.') }}) 
@else {{ number_format($total_pendapata+$total_pendapatanlain+$total_hpp+$total_expenses,2,',','.') }} @endif</td>                                        
                                        
                                    <th style=""></th> 
                                </tr>
                            </tbody></table>                                        
                    </div>  
            
            
   