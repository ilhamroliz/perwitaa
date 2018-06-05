    
<div class="box custom" style="margin-bottom: 20px; border-top: 3px solid #f57c00">
    <div class="box-header with-border">
        <h5>Operating Cash Flow</h5>
    </div>
    <div class="box-body">           
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
            <tfoot style="background: #ccccff">
            <th>Total</th>
            <td></td>
            <th>{{$total_ocf}}</th>
            </tfoot>
        </table>                
    </div>
</div>

<div class="box custom" style="margin-bottom: 20px; border-top: 3px solid #f57c00">
    <div class="box-header with-border">
        <h5>Financial Cash Flow</h5>
    </div>
    <div class="box-body">
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
            <tfoot style="background: #ccccff">
            <th>Total</th>
            <td></td>
            <th>{{$total_fcf}}</th>
            </tfoot>
        </table>
    </div>
</div>






<div class="box custom" style="margin-bottom: 20px; border-top: 3px solid #f57c00">
    <div class="box-header with-border">
        <h5>Investing Cash Flow</h5>
    </div>
    <div class="box-body">
        <table class="table table-bordered" id="icf">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Nama Transaksi</th>
                    <th>Jumlah</th>
                </tr>                  
            </thead>
            <tbody>
                @foreach($icf as $icf)
                <tr>
                    <td>{{ $icf->tr_code }}</td>
                    <td>{{ $icf->tr_name }}</td>                                
                    <td>{{ number_format($icf->jum,2,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot style="background: #ccccff">
            <th>Total</th>
            <td></td>
            <th>{{$total_icf}}</th>
            </tfoot>
        </table>
    </div>
</div>
<div class="box custom" style="margin-bottom: 20px; border-top: 3px solid #f57c00">

    <div class="box-body">
        <div class="box-header with-border">
            <h5>Hasil Arus Kas</h5>
        </div>
        <table class="table">
            <tr>
                <td>  
                    Operating Cash Flow
                </td>  
                <td>  
                    {{$total_ocf}}
                </td>  
            </tr>
            <tr>
                <td>  
                    Financial Cash Flow
                </td>  
                <td>
                    {{$total_fcf}}
                </td>  
            </tr>
            <tr>
                <td>
                    Investing Cash Flow
                </td> 
                <td>
                    {{$total_icf}}
                </td>  
            </tr>
            <tr>
                <td>
                    Saldo Kas Awal
                </td> 
                <td>
                    {{$nilaiKasAwal}}
                </td>  
            </tr>
            <tr style="background: #ccccff">
                <th>
                    Saldo Kas Akhir
                </th> 
                <th>                    
                    {{$total_ocf+$total_fcf+$total_icf+$nilaiKasAwal}}
                </th>  
            </tr>
        </table>

    </div>
</div>





<script>
    $('#ocf').DataTable({
    });
    $('#fcf').DataTable({
    });
    $('#icf').DataTable({
    });

</script>
