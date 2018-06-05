<!DOCTYPE html>
<html>
<head>
<title>Cetak Surat</title>
<style type="text/css">
body{
    font-family:Times New Roman;
    font-size: 16px;
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
     font-weight: bold;
    margin-bottom: 20px;

}
.p2{
        
    margin-top: 40px;
   
    margin-bottom: 20px;
}
.int {
    margin-left: 60px;
    padding-top: 20px;
    font-size: 20px;
    font-weight: bold;
}

.mks {
    font-size: 20px;
    text-align: justify;
    text-justify: inter-word;
}
.mng {
    margin-top: -20px;
    font-size: 20px;
    text-decoration: underline;
}
.tnda {
    font-size: 18px;
    margin-top:-20px;
    font-weight: lighter;
    font-style: italic; 
}
.she {
    margin-top: 25px;
    font-size: 20px;
      font-weight: bold;
}
.a {
    margin-top:-21px; 
    font-size: 20px;
}
.s{
    float: right;
  position: relative;
  left: -30%; /* or right 50% */
  text-align: left;
  font-weight: bold;
  font-size: 20px;
}
.as {
    margin-top: 90px;
}
</style>
</head>

<body>
   <h1 class="ket">To Whom It May Concern</h1>
   <h2 class="no_kartu">Nomor : {{ $surat->no_surat }}</h2>
<p class="p1">I the Undersigned below, declare :</p>
<p class="tnda">Saya yang bertandatangan di bawah ini, menyatakan :</p>
<table class="int">
        <tr>
            <td>Name</td>
            <td>:</td>
            <td>{{ $surat->nama}}</td>
        </tr>
        <tr>
            <td width="200">Place/Date of Birth</td><td width="50">:</td>
            <td >{{ $surat->tl}},{{ \Carbon\Carbon::parse($surat->ttl)->format('M d,Y')}}</td>
        </tr>
        <tr>
            <td >Address</td><td >:</td>
            <td >{{ $surat->alamat}}</td>
        </tr>
    </table>
<p class="she">She has employed by {{ $a}} as an {{$surat->jabatan}} from</p>
<p class="tnda">telah bekerja di {{ $a}}  sebagai {{$surat->jabatan}} sejak </p>

<p class="s">{{ \Carbon\Carbon::parse($surat->tgl_m)->format('F d,Y')}} - {{ \Carbon\Carbon::parse($surat->tgl_b)->format('F d,Y')}}</p>

<p class="she as">She has responsible and has excellent communication skills and can work independently</p>
<p class="tnda">Yang bersangkutan mempunyai tanggungjawab dan mampu berkomunikasi dengan baik serta dapat bekerja secara mandiri</p>

<p class="she">This letter is our reference and could be used as it should be</p>
<p class="tnda">Surat pengalaman kerja ini diberikan untuk dapat digunakan sebagaimana mestinya  </p>
<br>
<p class="mks">Sidoarjo, {{ date("d F Y") }}
<p/>
<p class="a">Sincerely,
</p>
<br><br><br><br><br>
<p class="mng">{{ $surat->n_pj }}</p>
<p class="a">{{$surat->j_pj}}</p>




</body>
<script type="text/javascript">
/*  */
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