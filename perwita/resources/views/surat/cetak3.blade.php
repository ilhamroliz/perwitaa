<!DOCTYPE html>
<html>
<head>
<title>Cetak Laporan</title>
<style type="text/css">
body{
    font-family:Times New Roman;
    font-size: 20px;
     cursor:not-allowed;
    background-color: black;
}
pre {
    font-family:Times New Roman;
}
.no{
    text-indent: 4em;
}
.se {
    margin-top: -15px;
}
.yth {
    margin-top: -14px;
}
.jb {
    margin-top: -14px;
    
}
.alt {
    margin-top: -14px;
}
.inline {
    display: inline-block;
    vertical-align: top;
}
.re {
    margin-left: 75%;
    margin-top: -35px; 
}
.s {
    margin-top: -20px; 
}

.d {
    margin-left: 75%;
    margin-top: -33px;
    text-decoration: underline; 
}
.int {
    margin-left: 40px;
}
.miring {
     font-style: italic;
     font-weight:bold;
}
</style>
</head>

<body>
 <table >
        <tr>
            <td width="100">Nomor</td><td>:</td>
            <td >{{ $no_surat}}</td>
        </tr>
        <tr>
            <td >Lampiran</td><td>:</td>
            <td ><b>-</b></td>
        </tr>
        <tr>
            <td >Perihal</td><td >:</td>
            <td class="miring">Surat Keterangan</td>
        </tr>
    </table>
<br>
<p class="kepada">Kepada</p>
<p class="yth">Yth. PT BANK MASPION INDONESIA</p>
<p class="yth">u.p Bagian Data</p>
<p class="yth">Jl. Jenderal Ahmad Yani, No 41c</p>
<p class="yth">di Sidoarjo</p>
<br>
<p>Dengan hormat,</p>
<p class="se">Dengan ini menerangkan bahwa Pekerja kami : </p>

    <table class="int">
        <tr>
            <td >Nama</td><td >:</td>
            <td >{{ $nama}}</td>
        </tr>
        <tr>
            <td width="180">No. Rek. Tabungan</td><td width="50">:</td>
            <td >{{$no_rek}}</td>
        </tr>
        <tr>
            <td >Alamat</td><td >:</td>
            <td >{{ $alamat}}</td>
        </tr>
    </table>
<p>Menerangkan dengan sebenarnya bahwa alamat tersebut sudah benar sama dengan alamat di KTP yang lama pekerja {{$i}} yang dipekerjakan di {{$m}} yaitu {{$nama}} yang terkait dalam buku tabungan Dapan Maspion. </p>

<p> Demikian Surat Keterangan kami, atas perhatian dan bantuan  yang diberikan kami ucapkan terima kasih</p>
<br>
<pre class="mks">Sidoarjo, {{ $tgl }}<pre/>
<p class="s">{{ $j_pj }},</p>

<p class="mng">{{ $n_pj }}</p>


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