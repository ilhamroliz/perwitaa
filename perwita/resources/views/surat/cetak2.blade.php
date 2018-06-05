<!DOCTYPE html>
<html>
<head>
<title>Cetak Surat</title>
<style type="text/css">
body{
    font-family:Times New Roman;
    background-color: black;
    cursor:not-allowed;
}


.ket {
    color: black;
    text-align: center;
    text-decoration: underline;
}
.no_kartu  {
    text-align: center;
    margin-top: -24px;
}
.p1{
    font-size: 20px;
    margin-top: 95px;
    
    margin-bottom: 20px;

}
.p2{
    font-size: 20px;
    margin-top: 40px;
   
    margin-bottom: 20px;
}
.int {
    margin-left: 60px;
    font-size: 20px;
}

.mks {
    font-size: 20px;
    text-align: justify;
    text-justify: inter-word;
}
.mng {
    margin-top: -20px;
    font-size: 20px;
}

</style>
</head>
@foreach($surat as $surat)
<body>
   <h1 class="ket">SURAT KETERANGAN</h1>
   <h2 class="no_kartu">Nomor : {{ $no_surat }}</h2>
<p class="p1">Saya yang bertandatangan di bawah ini :</p>
<table class="int">
        <tr>
            <td >Nama</td>
            <td>:</td>
            <td>{{ $n_pj}}</td>
        </tr>
        <tr>
            <td width="100">Jabatan</td><td width="30">:</td>
            <td >{{ $j_pj}}</td>
        </tr>
        <tr>
            <td >Alamat</td><td >:</td>
            <td >{{ $a_pj}}</td>
        </tr>
    </table>
<p class="p2">Menerangkan bahwa :</p>
<table class="int">
        <tr>
            <td >Nama</td><td>:</td>
            <td >{{ $nama}}</td>
        </tr>
        <tr>
            <td width="100">Jabatan</td><td width="30">:</td>
            <td >{{ $jabatan}}</td>
        </tr>
        <tr>
            <td>Alamat</td><td>:</td>
            <td >{{ $alamat}}</td>

        </tr>
    </table>
<br>

<p class="mks">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah Pekerja {{ $i }} yang dipekerjakan di {{ $m }} terhitung mulai bekerja pada tanggal {{ \Carbon\Carbon::parse($tgl_m)->format('d F Y')}} sampai dengan 
    {{ \Carbon\Carbon::parse($tgl_b)->format('d F Y')}}, yang mana Pekerja tersebut di atas sudah non aktif dan tidak terdaftar sebagai peserta BPJS Kesehatan di perusahaan kami.
</p>

<p class="mks">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Surat Keterangan ini diberikan untuk dapat dipergunakan sebagaimana mestinya.
</p>
<br>
<p class="mks">Sidoarjo, {{ date("d F Y") }}
<p/>
<p class="mng">{{ $j_pj}},
</p>
<br><br><br><br><br>
<p class="mng">{{ $n_pj }}
</p>

@endforeach


</body>
<script type="text/javascript">
      window.print();


function disableselect(e){
return false
}
function reEnable(){
return true
}
document.onselectstart=new Function ("return false")
if (window.sidebar){
document.onmousedown=disableselect
document.onclick=reEnable
}




</script>
</html>