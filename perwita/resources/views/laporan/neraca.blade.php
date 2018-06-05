<div class="row">    
    <div class="col-md-12">        
     @if($cekAsetMinus!=0 || $cekkewajibanMinus!=0)
                <div class="alert alert-danger alert-dismissable">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Nilai @if($cekAsetMinus!=0)<b>aset</b>@endif @if($cekAsetMinus!=0 && $cekkewajibanMinus!=0) dan @endif @if($cekkewajibanMinus!=0) <b>kewajiban</b> @endif pada neraca ada yang minus.</strong>
                </div>  
        @endif
        
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
                        @foreach($asset as $sisikiri)
                        <tr>
                            <td>{{ $sisikiri->coa_code }}</td>                        
                            <td>{{ $sisikiri->coa_name}}</td>                                        
                            <td class="text-right">@if($sisikiri->COAend<0)( {{ number_format(abs($sisikiri->COAend),2,',','.') }} )
                            @else {{ number_format($sisikiri->COAend,2,',','.') }} @endif</td>   
                            @if($total_asset == 0)
                            <td class="text-right">0 %</td>
                            @else
                            <td class="text-right">{{ number_format(($sisikiri->COAend/$total_asset)*100,2,',','.')}} %</td>                                     
                            @endif
                        </tr>                                
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

                        @foreach($kewajiban_modal as $sisikiri)
                        @if($sisikiri->coa_kategori==2)
                        <tr>
                            <td>{{ $sisikiri->coa_code }}</td>                        
                            <td>{{ $sisikiri->coa_name}}</td>                               
                             <td class="text-right">@if($sisikiri->COAend<0)( {{ number_format(abs($sisikiri->COAend),2,',','.') }} )
                            @else {{ number_format($sisikiri->COAend,2,',','.') }} @endif</td>  
                            
                            
                            @if($total_kewajiban_modal == 0)
                            <td class="text-right">0 %</td>
                            @else
                            <td class="text-right">{{ number_format(($sisikiri->COAend/$total_kewajiban_modal)*100,2,',','.')}} %</td>                                     
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

                        @foreach($kewajiban_modal as $sisikiri)
                        @if($sisikiri->coa_kategori==3)
                        <tr>
                            <td>{{ $sisikiri->coa_code }}</td>                        
                            <td>{{ $sisikiri->coa_name}}</td>                            
                             <td class="text-right">@if($sisikiri->COAend<0)( {{ number_format(abs($sisikiri->COAend),2,',','.') }} )
                            @else {{ number_format($sisikiri->COAend,2,',','.') }} @endif</td>  
                            @if($total_kewajiban_modal == 0)
                            <td class="text-right">0 %</td>
                            @else
                            <td class="text-right">{{ number_format(($sisikiri->COAend/$total_kewajiban_modal)*100,2,',','.')}} %</td>                                     
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
                         <td class="text-right">@if($total_asset<0)( {{ number_format(abs($total_asset),2,',','.') }} )
                            @else {{ number_format($total_asset,2,',','.') }} @endif</td>  
                        
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
                          <td class="text-right">@if($total_kewajiban_modal<0)( {{ number_format(abs($total_kewajiban_modal),2,',','.') }} )
                            @else {{ number_format($total_kewajiban_modal,2,',','.') }} @endif</td>  
                          
                    </tr>
                </table>  
            </div>            
        </div>
    </div>
</div>
           
    