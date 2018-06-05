@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
                    <h5>Laporan Neraca</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                {{--
                <table class="table table-bordered table-striped">
                      <tbody><tr>
                              <td style="width: 20%;padding-top:15px" class="text-right"><span class="text-right" style="margin-top:15px">Laporan Neraca</span></td>
                        <td style="width: 20%">
                            <select type="text" class="form-control jenisNeraca" width="100%" onchange="jenisNeraca()">                              
                                <option value="1">Neraca Percobaan</option>
                                <option value="2">Neraca Final</option>                                
                            </select>
                        </td>
                        <td style="width: 20%">                             
                            <div class="input-group date percobaan">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control tgl" width="100%">
                           </div>                             
                            <select type="text" class="form-control final" width="100%" style="display: none">                              
                                @foreach($bulan as $index => $data)                                
                                <option value="{{$index+1}}">{{$data}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="width: 10%">
                            <button class="btn btn-flat btn-block tampilkan lihat" onclick="lihat()">Lihat</button>                            
                        </td>
                        <td style="width: 10%">
                            <button class="btn btn-flat btn-block btn-default">Cetak</button>                            
                        </td>
                        <td style="width: 10%">                            
                        </td>
                      </tr>
                    </tbody></table>
                    --}}
                
                    <div class="load-neraca">
                          <img src="{{ asset('image/loading.gif') }}" class="img-responsive" width="40px">
                    </div>
            
                    <div class="table-neraca">            
                    </div>  
                
            </div>
        </div>
    </div>
</div>



@endsection

@section('extra_scripts')
<script>
    
function jenisNeraca (){
    if($('.jenisNeraca').val()=='1'){//final
        $('.percobaan').css('display','');
        $('.final').css('display','none');
    }
    else if($('.jenisNeraca').val()=='2'){//percobaan        
        $('.percobaan').css('display','none');
        $('.final').css('display','');
    }
}
table();
 function table(){       
     $('.table-neraca').html('');
     $('.load-neraca').css('display','');
$.ajax({    
    url: baseUrl + '/laporan-keuangan/neraca/table',
            type: 'get',
            //dataType: 'json',
            timeout: 10000,            
            success: function(response){
                $('.table-neraca').html(response);
                $('.load-neraca').css('display','none');
            
            }, error:function(x, e) {
    //alert(e);
    var message;
            if (x.status == 0) {
    message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
    } else if (x.status == 404) {
    message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
    } else if (x.status == 500) {
    message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
    } else if (e == 'parsererror') {
    message = 'Error.\nParsing JSON Request failed.';
    } else if (e == 'timeout'){
    message = 'Request Time out. Harap coba lagi nanti';
    } else {
    message = 'Unknow Error.\n' + x.responseText;
    }
    throwLoadError(message);
            //formReset("store");
    }
    });        
    }
    
 function lihat(){    
     if($('.jenisNeraca').val()==1){
         
     $('.table-neraca').html('');
     $('.load-neraca').css('display','');
$.ajax({
    url: baseUrl + '/laporan-keuangan/neraca/cari-neraca/'+$('.tgl').val(),
            type: 'get',
            //dataType: 'json',
            timeout: 10000,            
            success: function(response){
                $('.table-neraca').html(response);
                $('.load-neraca').css('display','none');
            
            }, error:function(x, e) {
    //alert(e);
    var message;
            if (x.status == 0) {
    message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
    } else if (x.status == 404) {
    message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
    } else if (x.status == 500) {
    message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
    } else if (e == 'parsererror') {
    message = 'Error.\nParsing JSON Request failed.';
    } else if (e == 'timeout'){
    message = 'Request Time out. Harap coba lagi nanti';
    } else {
    message = 'Unknow Error.\n' + x.responseText;
    }
    throwLoadError(message);
            //formReset("store");
    }
    }); 
    }
    if($('.jenisNeraca').val()==2){
        //alert($('.final').val());
     $('.table-neraca').html('');
     $('.load-neraca').css('display','');
$.ajax({
    url: baseUrl + '/laporan-keuangan/neraca/cari-neraca-final/'+$('.final').val(),
            type: 'get',
            //dataType: 'json',
            timeout: 10000,            
            success: function(response){
                $('.table-neraca').html(response);
                $('.load-neraca').css('display','none');
            
            }, error:function(x, e) {
    //alert(e);
    var message;
            if (x.status == 0) {
    message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
    } else if (x.status == 404) {
    message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
    } else if (x.status == 500) {
    message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
    } else if (e == 'parsererror') {
    message = 'Error.\nParsing JSON Request failed.';
    } else if (e == 'timeout'){
    message = 'Request Time out. Harap coba lagi nanti';
    } else {
    message = 'Unknow Error.\n' + x.responseText;
    }
    throwLoadError(message);
            //formReset("store");
    }
    }); 
        
    }
    }
        
</script>
@endsection
