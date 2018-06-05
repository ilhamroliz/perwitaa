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
                    <h5>Laporan Arus Kas</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
               <div class="col-md-12 no-padding">
                    <div class="load-neraca">
                        <img src="{{ asset('image/loading.gif') }}" class="img-responsive" width="40px">
                    </div>
                </div>
                <div class="table-aruskas">
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('extra_scripts')
<script>
    {{--$panjangBulan={{count($bulan)}};--}}
//    for(m=1;m<=$panjangBulan;m++){        
//        $('.m-'+m).css('display','none');
//    }
    $('.judul').html($('.coba  :selected').text());
    function pilih(){
        
        if($('.jenis').val()=='1'){
           
           
           
            $('.coba').css('display','');
           $('.final').css('display','none'); 
        }
        if($('.jenis').val()=='2'){
            
           $('.coba').css('display','none');
           $('.final').css('display',''); 
                     
        }
    }
    table();
    function table(){
    $.ajax({    
    url: baseUrl + '/laporan-keuangan/arus-kas/table',
            type: 'get',
            //dataType: 'json',
            timeout: 10000,            
            success: function(response){
                $('.table-aruskas').html(response);
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
        $('.table-aruskas').html('');
        if($('.jenis').val()=='1' && $('.laporan').val()=='1'){
            $('.table-aruskas').html('');
            $('.load-neraca').css('display','');
    $.ajax({    
    url: baseUrl + '/laporan-keuangan/arus-kas-percobaan/per/'+$('.coba :selected').text(),
            type: 'get',
            //dataType: 'json',
            timeout: 10000,            
            success: function(response){
                $('.table-aruskas').html(response);
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
        else if($('.jenis').val()=='1' && $('.laporan').val()=='2'){
            
            $('.table-aruskas').html('');
            $('.load-neraca').css('display','');
    $.ajax({    
    url: baseUrl + '/laporan-keuangan/arus-kas-percobaan/periode/'+$('.coba :selected').text(),
            type: 'get',
            //dataType: 'json',
            timeout: 10000,            
            success: function(response){
                $('.table-aruskas').html(response);
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
        if($('.jenis').val()=='2' && $('.laporan').val()=='1'){    
            $('.table-aruskas').html('');
            $('.load-neraca').css('display','');
    $.ajax({    
    url: baseUrl + '/laporan-keuangan/arus-kas-final/per/'+$('.final :selected').text(),
            type: 'get',
            //dataType: 'json',
            timeout: 10000,            
            success: function(response){
                $('.table-aruskas').html(response);
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
        if($('.jenis').val()=='2' && $('.laporan').val()=='2'){
            $('.table-aruskas').html('');
            $('.load-neraca').css('display','');
            $.ajax({                  
    url: baseUrl + '/laporan-keuangan/arus-kas-final/periode/'+$('.final').val(),
            type: 'get',
            //dataType: 'json',
            timeout: 10000,            
            success: function(response){
                $('.table-aruskas').html(response);
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
