<div class="row">    
    <div class="col-md-12">        
   
        
    </div>
    <div class="col-lg-6">       
        <div class="ibox float-e-margins">            
            <div class="ibox-title">
                <h4>Aset</h4>                
            </div>
            <div class="ibox-content">                
                <table id="comp_trans" class="table table-bordered" >
                    <thead>
                        <tr>                  
                            <th style="background: #2962FF; color: white; width: 10%;">Kode</th>
                            <th style="background: #2962FF; color: white;">Nama Akun</th>
                            <th class="text-right" style="background: #2962FF; color: white;">Nilai</th>
                            <th class="text-right" style="background: #2962FF; color: white; width:40px">Presentase</th>
                        </tr>
                    </thead>                            
                    <tbody>
                        @foreach($final as $sisikiri)
                        @if(substr($sisikiri->coa_code,0,1)=='1')
                        <tr>
                            <td>{{ $sisikiri->coa_code }}</td>                        
                            <td>{{ $sisikiri->coa_name}}</td>                                        
                            <td class="text-right">{{ number_format($sisikiri->cjr_value,2,',','.') }}</td>    
                            @if($total_asset == 0)
                            <td class="text-right">0 %</td>
                            @else
                            <td class="text-right">{{ number_format(($sisikiri->cjr_value/$total_asset)*100,2,',','.')}} %</td>                                     
                            @endif
                            
                        </tr>
                        @endif
                        @endforeach                              
                    </tbody>                              
                </table>

            </div>
        </div>
    </div>
    <div class="col-lg-6" >        
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Kewajiban </h5>              
            </div>
            <div class="ibox-content">
                <table id="comp_trans" class="table table-bordered" >
                    <thead>
                        <tr>                  
                            <th style="background: #E53935; color: white;width: 10%;">Kode</th>
                            <th style="background: #E53935; color: white;">Nama Akun</th>
                            <th class="text-right" style="background: #E53935; color: white;">Nilai</th>
                            <th class="text-right" style="background: #E53935; color: white; width:40px">Presentase</th>
                        </tr>
                    </thead>  

                    <tbody>

                        @foreach($final as $kewajiban)                        
                        @if(substr($kewajiban->coa_code,0,1)=='2')                                          
                        <tr>
                            <td>{{ $kewajiban->coa_code }}</td>                        
                            <td>{{ $kewajiban->coa_name}}</td>
                            <td class="text-right">{{ number_format($kewajiban->cjr_value,2,',','.') }}</td>       
                           @if($total_kewajiban_modal == 0)
                            <td class="text-right">0 %</td>
                           @else
                            <td class="text-right">{{ number_format(($kewajiban->cjr_value/$total_kewajiban_modal)*100,2,',','.')}} %</td>                                     
                            @endif
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="ibox-title">
                    <h5>Modal</h5>                   
                </div>
                <table id="comp_trans" class="table table-bordered" >
                    <thead>
                        <tr>                  
                            <th style="background: #E64A19; color: white;width: 10;">Kode</th>
                            <th style="background: #E64A19; color: white;">Nama Akun</th>
                            <th class="text-right" style="background: #E64A19; color: white;">Nilai</th>
                            <th class="text-right" style="background: #E64A19; color: white; width:40px">Presentase</th>
                        </tr>
                    </thead>                                         
                    <tbody>

                       @foreach($final as $modal)
                        @if(substr($modal->coa_code,0,1)=='3')  
                        <tr>
                            <td>{{ $modal->coa_code }}</td>                        
                            <td>{{ $modal->coa_name}}</td>
                            <td class="text-right">{{ number_format($modal->cjr_value,2,',','.') }}</td>
                            @if($total_kewajiban_modal == 0)
                            <td class="text-right">0 %</td>
                            @else
                            <td class="text-right">{{ number_format(($modal->cjr_value/$total_kewajiban_modal)*100,2,',','.')}} %</td>                                     
                            @endif
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>

                <div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <table class="table table-ed table-hover text" >
                    <tr style="font-weight:bold; border-top: solid 2px #999999;">
                        <td>
                            Total
                        </td>                                    
                       <td class="text-right">{{ number_format($total_asset,2,',','.') }}</td> 
                    </tr>
                </table>  
            </div>            
        </div>
    </div>


    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <table class="table table-ed table-hover text" >
                    <tr style="font-weight:bold; border-top: solid 2px #999999;">
                        <td>
                            Total
                        </td>                                    
                        <td class="text-right">{{ number_format($total_kewajiban_modal,2,',','.') }}</td> 
                    </tr>
                </table>  
            </div>            
        </div>
    </div>
</div>
           
    