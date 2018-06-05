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
    margin-top: 50px;
}

.mks {
    font-size: 20px;
      margin-top: 40px;
    text-align: justify;
    text-justify: inter-word;
}
.mng {
    margin-top: -20px;
    font-size: 20px;
}
.ads{
    margin-top: 30px;
    font-size: 20px;
}
.add{
    margin-top: -20px;
    font-size: 20px;
    margin-left: 30px;
}
.gege{
    margin-top:-20px; 
    font-size: 20px;
}
.asas{
    text-decoration: underline;
}
</style>
</head>

<body>
   <h1 class="ket">SURAT KETERANGAN KERJA</h1>
   <h2 class="no_kartu">Nomor : {{ $surat->no_surat }}</h2>
<p class="p1">{{$surat->j_pj}} {{$a}} menerangkan dengan sebenarnya :</p>

<table class="int">
        <tr>
            <td >Nama</td><td>:</td>
            <td >{{ $surat->nama}}</td>
        </tr>
        <tr>
            <td width="100">TTL</td><td width="30">:</td>
            <td >{{ $surat->tl}},{{ \Carbon\Carbon::parse($surat->ttl)->format('d F Y')}}</td>
        </tr>
        <tr>
            <td>Alamat</td><td>:</td>
            <td >{{ $surat->alamat}}</td>

        </tr>
    </table>
<br>

<p class="mks">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah {{ $surat->jabatan }} {{$a}} yang ditempatkan di {{$surat->mitra}} terhitung mulai bekerja pada tanggal {{ \Carbon\Carbon::parse($surat->tgl_m)->format('d M Y')}} sampai dengan saat ini masih berstatus sebagai {{$surat->jabatan}} {{$surat->mitra}}.
</p>


<p class="gege">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Surat Keterangan Kerja ini diberikan untuk dapat dipergunakan sebagai pengajuan Kredit Kepemilikan Rumah (KPR) di Bank
</p>
<br>
<p class="mks">Sidoarjo, {{ \Carbon\Carbon::parse($surat->tgl)->format('d F Y')}}
<p/>
<p class="mng">{{ $surat->j_pj}},
</p>
<br><br><br><br><br>
<p class="asas">{{ $surat->n_pj }}
</p>



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