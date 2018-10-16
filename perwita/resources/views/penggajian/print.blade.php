<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>

	<title>Perwita | Print</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<meta name="keywords" content="" />
	<meta name="description" content="" />

	<link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/dboard/logo/faveicon.png') }}"/>
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" media="all" />
  <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap/css/bootstrap.min.css')}}">
  <style media="screen">

.footer {
      display: none;
    }

  </style>

</head>
<body style="font-family:Helvetica; text-align:left;">
			<b style="font-size:15px;">PT. PERWITA NUSARAYA MJI</b>
			<br>
			<b style="font-size:15px;">Periode : {{Carbon\Carbon::parse($data[0]->p_start_periode)->format('d/m/Y')}} - {{Carbon\Carbon::parse($data[0]->p_end_periode)->format('d/m/Y')}}</b>

			<div style="margin-top:20px;">
				<b style="font-size:17px;">NAMA</b> <span style="margin-left:150px;"><b>: <u>{{$data[0]->p_name}}</u></b></span>
				<br>
				NIK <span style="margin-left:178px">: {{$data[0]->p_nip}}</span>
				<br>
				NIK MITRA <span style="margin-left:130px">: {{$data[0]->p_nip_mitra}}</span>
				<br>
				Jabatan <span style="margin-left:151px">: {{$data[0]->jp_name}}</span>
			</div>

			<div style="margin-top:20px;">
				<b style="font-size:17px;">PENDAPATAN</b> <span style="margin-left:87px;"><b>:</b></span>
				<br>
				Gaji <span style="margin-left:178px">: Rp. {{number_format($data[0]->p_gaji_pokok,0,',','.')}}</span>
				<br>
				Tunjangan Jabatan <span style="margin-left:84px">: Rp. {{number_format($data[0]->p_tjg_jabatan,0,',','.')}}</span>
				<br>
				Tunjangan Makan <span style="margin-left:92px">: Rp. {{number_format($data[0]->p_tjg_makan,0,',','.')}}</span>
				<br>
				Tunjangan Transport <span style="margin-left:75px">: Rp. {{number_format($data[0]->p_tjg_transport,0,',','.')}}</span>
				<br>
				Total Gaji Kotor <span style="margin-left:109px">: Rp. {{number_format($data[0]->totalgajikotor,0,',','.')}}</span>
			</div>

			<div style="margin-top:20px;">
				<b style="font-size:17px;">POTONGAN</b> <span style="margin-left:105px;"><b>:</b></span>
				<br>
				BPJS Ketenagakerjaan ( 2% x UMK ) JHT <span style="margin-left:178px">: Rp. {{number_format($data[0]->b_value_jht,0,',','.')}}</span>
				<br>
				BPJS Ketenagakerjaan ( 1% x UMK ) J-Pensiun <span style="margin-left:141px">: Rp. {{number_format($data[0]->b_value_pensiun,0,',','.')}}</span>
				<br>
				BPJS Kesehatan ( 1% x UMK ) JPK <span style="margin-left:216px">: Rp. {{number_format($data[0]->bikes_value,0,',','.')}}</span>
				<br>
				Lain - Lain <span style="margin-left:373px">: Rp. {{number_format($data[0]->p_value,0,',','.')}}</span>
			</div>

			<div style="margin-top:20px;">
				<b style="font-size:17px;">GAJI DITERIMA</b> <span style="margin-left:200PX;"><b>: Rp. {{number_format($data[0]->gajiditerima,0,',','.')}}</b></span>
			</div>

			<div style="margin-top:20px;">
				<i>#{{$data[0]->terbilang}}#</i>
			</div>

</body>
<script type="text/javascript" src="{{asset('assets/vendors/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/vendors/jquery/dist/jquery.min.js')}}"></script>
<script type="text/javascript">
	window.print();
</script>
</body>
</html>
