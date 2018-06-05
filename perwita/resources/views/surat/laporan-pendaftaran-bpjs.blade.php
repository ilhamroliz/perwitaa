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
    margin-top: -1px; 
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
            <td >{{ $surat->no_surat}}</td>
        </tr>
        <tr>
            <td >Lampiran</td><td>:</td>
            <td ><b>-</b></td>
        </tr>
        <tr>
            <td >Perihal</td><td >:</td>
            <td class="miring">Surat Pengantar Pendaftaran BPJS Kesehatan</td>
        </tr>
    </table>
<br>
<p class="kepada">Kepada</p>
<p class="yth">Yth. BPJS Kesehatan KCP. Krian</p>
<p class="yth">Jl. Gubernur Sunandar, Sidomulyo </p>
<p class="yth">di Krian</p>
<br>
<p>Dengan hormat,</p>
<p class="se">Dengan ini menerangkan bahwa Pekerja kami  : </p>

    <table class="int">
        <tr>
            <td >Nama</td><td >:</td>
            <td >{{ $surat ->nama}}</td>
        </tr>
        <tr>
            <td width="180">Nomor KPK</td><td width="50">:</td>
            <td >{{ $surat->kpk}}</td>
        </tr>
        <tr>
            <td >Alamat</td><td >:</td>
            <td >{{ $surat ->alamat}}</td>
        </tr>
    </table>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah {{$surat->jabatan}} {{$surat->instansi}} yang ditempatkan di {{$surat->mitra}} kode BU ({{$surat->bu}}) yang mana pekerja tersebut di atas mendaftarkan istri sebagai peserta BPJS Kesehatan yang penanggung tambahannya ditanggung oleh pekerja.</p>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Untuk itu kami mohon bantuannya agar Pekerja kami tersebut bisa diproses penambahan anggota keluarga inti sebagai peserta BPJS Kesehatan</p>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Surat Pengantar dan permohonan kami, atas  perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
<br>
<pre class="mks">Sidoarjo, {{ $surat->tgl}}
<p class="s">{{ $surat->j_pj }}
<br>

<p class="mng">{{ $surat->n_pj }}</p>


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