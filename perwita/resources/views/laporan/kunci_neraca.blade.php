@extends('layouts.app')
@section('htmlheader_title')
Home
@endsection

@section('extraStyle')
<style>
    .spacing-top{
        margin-top:15px;
    }
</style>
@endsection

@section('main-content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       Kunci Laporan Neraca
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kunci Laporan Neraca</li>
        
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box custom box-custom" style="margin-bottom: 20px;">
        <div class="box-body">
           
            <div class="load-neraca" style="display: none">
                      <img src="{{ asset('image/loading.gif') }}" class="img-responsive" width="40px">
            </div>
            <div class="alert alert-warning">
            <h3>Kunci Neraca</h3>
            </div>
            <br>                        
            <table class="table">                
                <td>
                    <label>
                        <input  type="checkbox" class="flat-red bulan-01" value="01" onchange="kunci('bulan-01')">
                      Januari
                    </label>
                </td>
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-02" value="02" onchange="kunci('bulan-02')">
                      Februari
                    </label>
                </td>                
                
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-03" value="03" onchange="kunci('bulan-03')">
                      Maret
                    </label>
                </td>                
                
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-04" value="04" onchange="kunci('bulan-04')">
                        April
                    </label>
                </td>
                <tr>
                </tr>
                
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-05" value="05" onchange="kunci('bulan-05')">
                        Mei
                    </label>
                </td>
                
                
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-06" value="06" onchange="kunci('bulan-06')">
                        Juni
                    </label>
                </td>
                
                
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-07" value="07" onchange="kunci('bulan-07')">
                        Juli
                    </label>
                </td>
                
                
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-08" value="08" onchange="kunci('bulan-08')">
                        Agustus
                    </label>
                </td>
                
                <tr>
                </tr>
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-09" value="09" onchange="kunci('bulan-09')">
                        September
                    </label>
                </td>
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-10" value="10" onchange="kunci('bulan-10')">
                        Oktober
                    </label>
                </td>
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-11" value="11" onchange="kunci('bulan-011')">
                        November
                    </label>
                </td>                
                
                <td>
                    <label>
                      <input type="checkbox" class="flat-red bulan-12" value="12" onchange="kunci('bulan-012')">
                        Desember
                    </label>
                </td>
                <tr>
                </tr>
            </table>
           
        </div>
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->
@endsection

@section('extraScript')
<script>
 
 kunciBulan(); 
 function kunciBulan(){               
      $('.load-neraca').css('display','');
     $.ajax({
            url: baseUrl + '/laporan-keuangan/kunci-laporan-neraca/lihat-kunci-bulan',
                    type: 'get',
                    timeout: 15000,
                    //dataType: 'json',
                    success: function(response){  
                        $('.load-neraca').css('display','none');
                       bulan(response);                   
                       console.log(response);
                    }, error:function(x, e) {
            //alert(e);
            if (x.status == 0) {
            alert('Ups !! gagal menghubungi server, harap cek kembali koneksi internet Anda');
            } else if (x.status == 404) {
            alert('Ups !! Halaman yang diminta tidak dapat ditampilkan.');
            } else if (x.status == 500) {
            alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
            } else if (e == 'parsererror') {
            alert('Error.\nParsing JSON Request failed.');
            } else if (e == 'timeout'){
            alert('Request Time out. Harap coba lagi nanti');
            } else {
            alert('Unknow Error.\n' + x.responseText);
            }
            formReset("store");
            }
            })
 }

function bulan(data){     
    $('.load-neraca').css('display','');
    $set=data.length+1;    
    for (i = 0; i < data.length; ++i) {                       
        $('.bulan-'+data[i]).removeAttr('disabled', true);
        $('.bulan-'+data[i]).prop("checked", true);
       // alert(data.length-i);
        if((data.length-i)!=1){
            $('.bulan-'+data[i]).removeAttr('disabled', true);
            $('.bulan-'+data[i]).attr('disabled', true);
        }
    }    
    for (i = $set; i <=12; ++i) {
        $b=i;
        $b=$b.toString();
        if($b.length==1){
        $b='0'+$b;
        }
        
        
        if(i!=$set){            
         $('.bulan-'+$b).removeAttr('disabled', true);
         $('.bulan-'+$b).attr('disabled', true);
     }if(i==$set){                     
         $('.bulan-'+$b).removeAttr('disabled', true);
         
     }
     
    }
    $('.load-neraca').css('display','none');
    
       
//    bulanDisableCek();
//    bulanDisableUnchek();
}
function kunci(kuncibulan){
    if($('.'+kuncibulan).is(':checked')){
          swal({
    title: "Konfirmasi",
            text: "Apakah anda yakin ingin mengunci neraca?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
    },
            function(isConfirm){
                 if (isConfirm) {
        setTimeout(function(){
            $('.load-neraca').css('display','');
             $kunciBulan=$('.'+kuncibulan).val();
        $.ajax({
            url: baseUrl + '/laporan-keuangan/kunci-laporan-neraca/kunci/'+$kunciBulan,
                    type: 'get',
                    timeout: 15000,
                    //dataType: 'json',
                    success: function(response){                       
                          swal({
                    title:"Berhasil",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showConfirmButton: false,
                            timer: 900
                    });
            bulan(response);                 
            $('.load-neraca').css('display','none');
            
                       
                    }, error:function(x, e) {
            //alert(e);
            if (x.status == 0) {
            alert('Ups !! gagal menghubungi server, harap cek kembali koneksi internet Anda');
            } else if (x.status == 404) {
            alert('Ups !! Halaman yang diminta tidak dapat ditampilkan.');
            } else if (x.status == 500) {
            alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
            } else if (e == 'parsererror') {
            alert('Error.\nParsing JSON Request failed.');
            } else if (e == 'timeout'){
            alert('Request Time out. Harap coba lagi nanti');
            } else {
            alert('Unknow Error.\n' + x.responseText);
            }
            formReset("store");
            }
            })
            
            
            
            }, 2000);
    } else {
        
         $('.btn').removeAttr('disabled');
         $('.'+kuncibulan).prop("checked", false);
            
    }
                
                
            
            });
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
       
        }else{
             swal({
    title: "Konfirmasi",
            text: "Apakah anda yakin ingin membuka neraca?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
    },
            function(isConfirm){
                 if (isConfirm) {
        setTimeout(function(){        
        hapusKunci(kuncibulan);
            }, 2000);
    } else {        
         $('.btn').removeAttr('disabled');
         $('.load-neraca').css('display','none');
         $('.'+kuncibulan).prop("checked", false);
    }           
            
            });
        
        }
}
function hapusKunci(hapusKunci){
        $kunciBulan=$('.'+hapusKunci).val();
        $('.load-neraca').css('display','');
        $.ajax({
            url: baseUrl + '/laporan-keuangan/kunci-laporan-neraca/hapus-kunci/'+$kunciBulan,
                    type: 'get',
                    timeout: 15000,
                    //dataType: 'json',
                    success: function(response){                       
                        console.log(response);
                       swal({
                    title:"Berhasil",
                            text: "Data berhasil dihapus",
                            type: "success",
                            showConfirmButton: false,
                            timer: 900
                    });              
                    bulan(response);     
                    $('.load-neraca').css('display','none');
                    }, error:function(x, e) {
            //alert(e);
            if (x.status == 0) {
            alert('Ups !! gagal menghubungi server, harap cek kembali koneksi internet Anda');
            } else if (x.status == 404) {
            alert('Ups !! Halaman yang diminta tidak dapat ditampilkan.');
            } else if (x.status == 500) {
            alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
            } else if (e == 'parsererror') {
            alert('Error.\nParsing JSON Request failed.');
            } else if (e == 'timeout'){
            alert('Request Time out. Harap coba lagi nanti');
            } else {
            alert('Unknow Error.\n' + x.responseText);
            }
            formReset("store");
            }
            })
}
</script>
@endsection