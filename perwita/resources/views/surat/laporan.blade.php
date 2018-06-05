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
    margin-top: -53px; 
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
@foreach($surat as $surat)
<body>
 <table >
        <tr>
            <td width="100">Nomor</td><td>:</td>
            <td >{{ $surat ->no_surat}}</td>
        </tr>
        <tr>
            <td >Lampiran</td><td>:</td>
            <td ><b>-</b></td>
        </tr>
        <tr>
            <td >Perihal</td><td >:</td>
            <td class="miring">Laporan Pekerja Resign</td>
        </tr>
    </table>
<br>
<p class="kepada">Kepada</p>
<p class="yth">Yth. kepada DISOSNAKER Kab.Sidoarjo</p>
<p class="yth">Jl. Raya Jati No.04</p>
<p class="yth">di Sidoarjo</p>
<br>
<p>Dengan hormat,</p>
<p class="se">Sehubungan dengan surat pengajuan pengunduran diri dari pemohon sebagai pekerja {{ $i }} Maka bersama ini kami beritahukan bahwa : </p>

    <table class="int">
        <tr>
            <td >Nama</td><td >:</td>
            <td >{{ $surat ->nama}}</td>
        </tr>
        <tr>
            <td width="180">Tgl Masa Kerja</td><td width="50">:</td>
            <td >{{ \Carbon\Carbon::parse($surat->tgl_m)->format('d F Y')}} &nbsp; S/d &nbsp; {{ \Carbon\Carbon::parse($surat->tgl_b)->format('d F Y')}}</td>
        </tr>
        <tr>
            <td >Alamat</td><td >:</td>
            <td >{{ $surat ->alamat}}</td>
        </tr>
    </table>
<p>Bahwa yang bersangkutan sudah tidak bekerja lagi sebagai pekerja {{ $m }}</p>

<p>Demikian surat pemberitahuan ini dibuat sebagai laporan sekaligus kelengkapan pengurusan Jaminan Hari Tua (JHT)                                          di BPJS Ketenagakerjaan</p>
<br>
<pre class="mks">Sidoarjo, {{ date("d F Y") }}<pre/><p class="re">Mengetahui</p>
<p class="s">{{ $surat->j_pj }},</p><p class="re">Dinas Tenaga Kerja</p>

<p class="mng">{{ $surat->n_pj }}</p><p class="d">................................</p>

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