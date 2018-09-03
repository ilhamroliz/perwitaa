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
  /*
---------------------------------------------------------------------------------
STRIPPED DOWN RESUME TEMPLATE
  html resume

  v0.9: 5/28/09

  design and code by: thingsthatarebrown.com
                      (matt brown)
---------------------------------------------------------------------------------
*/


.msg { padding: 10px; background: #222; position: relative; }
.msg h1 { color: #fff;  }
.msg a { margin-left: 20px; background: #408814; color: white; padding: 4px 8px; text-decoration: none; }
.msg a:hover { background: #266400; }

/* //-- yui-grids style overrides -- */
body { font-family: Georgia; color: #444; }
#inner { padding: 10px 80px; margin: 80px auto; background: #f5f5f5; border: solid #666; border-width: 8px 0 2px 0; }
.yui-gf { margin-bottom: 2em; padding-bottom: 2em; border-bottom: 1px solid #ccc; }

/* //-- header, body, footer -- */
#hd { margin: 2.5em 0 3em 0; padding-bottom: 1.5em; border-bottom: 1px solid #ccc }
#hd h2 { text-transform: uppercase; letter-spacing: 2px; }
#bd, #ft { margin-bottom: 2em; }

/* //-- footer -- */
#ft { padding: 1em 0 5em 0; font-size: 92%; border-top: 1px solid #ccc; text-align: center; }
#ft p { margin-bottom: 0; text-align: center;   }

/* //-- core typography and style -- */
#hd h1 { font-size: 48px; text-transform: uppercase; letter-spacing: 3px; }
h2 { font-size: 152% }
h3, h4 { font-size: 122%; }
h1, h2, h3, h4 { color: #333; }
p { font-size: 100%; line-height: 18px; padding-right: 3em; }
a { color: #990003 }
a:hover { text-decoration: none; }
strong { font-weight: bold; }
li { line-height: 24px; border-bottom: 1px solid #ccc; }
p.enlarge { font-size: 144%; padding-right: 6.5em; line-height: 24px; }
p.enlarge span { color: #000 }
.contact-info { margin-top: 7px; }
.first h2 { font-style: italic; }
.last { border-bottom: 0 }


/* //-- section styles -- */

a#pdf { display: block; float: left; background: #666; color: white; padding: 6px 50px 6px 12px; margin-bottom: 6px; text-decoration: none;  }
a#pdf:hover { background: #222; }

.job { position: relative; margin-bottom: 1em; padding-bottom: 1em; border-bottom: 1px solid #ccc; }
.job h4 { position: absolute; top: 0.35em; right: 0 }
.job p { margin: 0.75em 0 3em 0; }

.last { border: none; }
.skills-list {  }
.skills-list ul { margin: 0; }
.skills-list li { margin: 3px 0; padding: 3px 0; }
.skills-list li span { font-size: 152%; display: block; margin-bottom: -2px; padding: 0 }
.talent { width: 32%; float: left }
.talent h2 { margin-bottom: 6px; }

#srt-ttab { margin-bottom: 100px; text-align: center;  }
#srt-ttab img.last { margin-top: 20px }

/* --// override to force 1/8th width grids -- */
.yui-gf .yui-u{width:80.2%;}
.yui-gf div.first{width:12.3%;}

.footer {
      display: none;
    }

		div.gallery {
    border: 1px solid #ccc;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    height: auto;
}

div.desc {
    padding: 15px;
    text-align: center;
}

* {
    box-sizing: border-box;
}

.responsive {
    padding: 0 6px;
    float: left;
    width: 24.99999%;
}

@media only screen and (max-width: 700px){
    .responsive {
        width: 49.99999%;
        margin: 6px 0;
    }
}

@media only screen and (max-width: 500px){
    .responsive {
        width: 100%;
    }
}

.clearfix:after {
    content: "";
    display: table;
    clear: both;
}

  </style>

</head>
<body>

<div id="doc2" class="yui-t7">
	<div id="inner">

		<div id="hd">
			<div class="yui-gc">
				<div class="yui-u first">
					@if(empty($lempar['p_img']))
							<img src="{{asset('assets/img/user/default.jpg')}}" class="img-rounded" alt="Cinque Terre" width="160" height="160" style="float:left;">
					@else
							<img src="{{url('/')}}/{{$lempar['p_img']}}" class="img-rounded" alt="Cinque Terre" width="160" height="160" style="float:left;">
					@endif
				</div>

				<div class="yui-u">
					<div class="contact-info">
            <div class="image" id="showimage">
							<img src="{{asset('assets/img/dboard/logo/sublogo.png')}}" class="img-rounded" alt="Cinque Terre" width="160" height="160" style="float:right;">
						</div>
					</div><!--// .contact-info -->
				</div>
			</div><!--// .yui-gc -->
		</div><!--// hd -->
		<br>
		<div id="bd">
			<div id="yui-main">
				<div class="yui-b" style="font-size:15px;">

					<div class="yui-gf">
						<div class="yui-u first">
							<b>Nama</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_address">{{$lempar['p_name']}}</b>
              </div>
						</div>
					</div><!--// .yui-gf -->

					<div class="yui-gf">
						<div class="yui-u first">
							<b>Alamat</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_address">{{$lempar['p_address']}}</b>
              </div>
						</div>
					</div><!--// .yui-gf -->

					<div class="yui-gf">
						<div class="yui-u first">
							<b>Kelurahan</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_kel">{{$lempar['p_kel']}}</b>
              </div>
						</div>
					</div><!--// .yui-gf -->

					<div class="yui-gf">
						<div class="yui-u first">
							<b>Kecamatan</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_kecamatan">{{$lempar['p_kecamatan']}}</b>
              </div>
						</div>
					</div><!--// .yui-gf -->

					<div class="yui-gf">
						<div class="yui-u first">
							<b>Jabatan Pelamar  </b>
						</div>
						<div class="yui-u">

								<div class="talent">
									@if($lempar['p_jabatan_lamaran'] == 1)
									<b id="p_jabatan_lamaran">Manager</b>
									@elseif($lempar['p_jabatan_lamaran'] == 2)
									<b id="p_jabatan_lamaran">Supervisor</b>
									@elseif($lempar['p_jabatan_lamaran'] == 3)
									<b id="p_jabatan_lamaran">Staff</b>
									@elseif($lempar['p_jabatan_lamaran'] == 4)
									<b id="p_jabatan_lamaran">Operator</b>
									@else
									<b id="p_jabatan_lamaran">-</b>
									@endif
								</div>

						</div>
					</div><!--// .yui-gf -->

					<div class="yui-gf">
						<div class="yui-u first">
							<b>Jenis Kelamin</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_kecamatan">{{$lempar['p_sex']}}</b>
              </div>
						</div>
					</div><!--// .yui-gf -->

					<div class="yui-gf">
						<div class="yui-u first">
							<b>No. NIP </b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_nip">{{$lempar['p_nip']}}</b>
              </div>
						</div>
					</div><!--// .yui-gf-->

					<div class="yui-gf">

						<div class="yui-u first">
							<b>No. KTP </b>
						</div><!--// .yui-u -->

						<div class="yui-u">

							<div class="talent">
                <b id="p_ktp">{{$lempar['p_ktp']}}</b>
              </div>

						</div><!--// .yui-u -->
					</div><!--// .yui-gf -->


					<div class="yui-gf last">
						<div class="yui-u first">
							<b>No. HP </b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_hp">{{$lempar['p_hp']}}</b>
              </div>
						</div>
					</div><!--// .yui-gf -->

          <div class="yui-gf last">
						<div class="yui-u first">
							<b>Status  </b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_status">{{$lempar['p_status']}}</b>
              </div>
						</div>
					</div>

          <div class="yui-gf last">
						<div class="yui-u first">
							<b>No. Telepon </b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_telp">{{$lempar['p_telp']}}</b>
              </div>
						</div>
					</div>

          <div class="yui-gf last">
						<div class="yui-u first">
							<b>Jumlah Anak  </b>
						</div>
						<div class="yui-u">
              <div class="talent">
								@if($lempar['p_many_kids'] == 'LEBIH')
                <b id="p_many_kids">3 Anak Lebih</b>
								@else
								<b id="p_many_kids">{{$lempar['p_many_kids']}}</b>
								@endif
              </div>
						</div>
					</div>

          <div class="yui-gf last">
						<div class="yui-u first">
							<b>Agama </b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_religion">{{$lempar['p_religion']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Kota</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_city">{{$lempar['p_city']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>RT/RW</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_rt_rw">{{$lempar['p_rt_rw']}}</b>
              </div>
						</div>
					</div>

          <div class="yui-gf last">
						<div class="yui-u first">
							<b>Alamat Sekarang</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_address_now">{{$lempar['p_address_now']}}</b>
              </div>
						</div>
					</div>


          <div class="yui-gf last">
						<div class="yui-u first">
							<b>Kelurahan Sekarang</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_kel_now">{{$lempar['p_kel_now']}}</b>
              </div>
						</div>
					</div>

          <div class="yui-gf last">
						<div class="yui-u first">
							<b>Kecamatan Sekarang</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_kecamatan_now">{{$lempar['p_kecamatan_now']}}</b>
              </div>
						</div>
					</div>

          <div class="yui-gf last">
						<div class="yui-u first">
							<b>Kota Sekarang</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_city_now">{{$lempar['p_city_now']}}</b>
              </div>
						</div>
					</div>

          <div class="yui-gf last">
						<div class="yui-u first">
							<b>RT/RW Sekarang</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_rt_rw_now">{{$lempar['p_rt_rw_now']}}</b>
              </div>
						</div>
					</div>

          <div class="yui-gf last">
						<div class="yui-u first">
							<b>Nama Istri</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_wife_name">{{$lempar['p_wife_name']}}</b>
              </div>
						</div>
					</div>

          <div class="yui-gf last">
						<div class="yui-u first">
							<b>Tanggal Lahir Istri</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_wife_birth">{{$lempar['p_wife_birth']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Tempat Lahir Istri</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_wife_birthplace">{{$lempar['p_wife_birthplace']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Nama Ayah</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_dad_name">{{$lempar['p_dad_name']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Pekerjaan Ayah</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_dad_job">{{$lempar['p_dad_job']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Nama Ibu</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_mom_name">{{$lempar['p_mom_name']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Pekerjaan Ibu</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_mom_job">{{$lempar['p_mom_job']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Pekerjaan Sekarang</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_job_now">{{$lempar['p_job_now']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Tinggi</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_height">{{$lempar['p_height']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Berat</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_weight">{{$lempar['p_weight']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Ukuran Baju</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_seragam_size">{{$lempar['p_seragam_size']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Ukuran Celana</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_celana_size">{{$lempar['p_celana_size']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Ukuran Sepatu</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_sepatu_size">{{$lempar['p_sepatu_size']}}</b>
              </div>
						</div>
					</div>
					<br>
					<div class="col-lg-12">
							<b>Keluarga Yang Dapat Dihubungi</b>
					</div>
					<br>
					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Nama</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_name_family">{{$lempar['p_name_family']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Telepon</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_telp_family">{{$lempar['p_telp_family']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Hubungan</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_hubungan_family">{{$lempar['p_hubungan_family']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>No. HP</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_hp_family">{{$lempar['p_hp_family']}}</b>
              </div>
						</div>
					</div>

					<div class="yui-gf last">
						<div class="yui-u first">
							<b>Alamat</b>
						</div>
						<div class="yui-u">
              <div class="talent">
                <b id="p_address_family">{{$lempar['p_address_family']}}</b>
              </div>
						</div>
					</div>

					@if(!empty($history))
					<div class="col-lg-12">
							<h3 style="font-style: italic; color: blue">History Pekerja</h3>
					</div>
					<form class="form-horizontal">
							<table id="tabel_detail" class="table table-bordered table-striped tabel_detail">
								<thead>
									<tr>
										<th style="text-align : center;"> TANGGAL </th>
										<th style="text-align : center;"> MITRA</th>
										<th style="text-align : center;"> DIVISI</th>
										<th style="text-align : center;"> KET</th>
										<th style="text-align : center;"> NO REFF</th>
										<th style="text-align : center;"> STATUS</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($history as $value)
										<tr>
											<td>{{$value['pm_date']}}</td>
											<td>{{$value['m_name']}}</td>
											<td>{{$value['md_name']}}</td>
											<td>{{$value['pm_detail']}}</td>
											<td>{{$value['pm_reff']}}</td>
											<td>{{$value['pm_note']}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
					</form>
				@endif

					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>

					<center>

					<div class="responsive">
					  <div class="gallery">
					      <img src="{{url('/')}}/{{$lempar['p_img_ktp']}}"  width="500" height="300" align='left'>
								<img src="{{url('/')}}/{{$lempar['p_img_skck']}}"  width="500" height="300" align='right'>
					  </div>
					</div>

					<div class="responsive">
					  <div class="gallery">
					      <img src="{{url('/')}}/{{$lempar['p_img_ijazah']}}"  width="500" height="300" align='left'>
								<img src="{{url('/')}}/{{$lempar['p_img_medical']}}"  width="500" height="300" align='right'>
					  </div>
					</div>

					<div class="responsive">
					  <div class="gallery">
					      <img src="{{url('/')}}/{{$lempar['p_img_kk']}}"  width="500" height="300" align='left'>
								<img src="{{url('/')}}/{{$lempar['p_img_rekening']}}"  width="500" height="300" align='right'>
					  </div>
					</div>

					<div class="clearfix"></div>

				</center>

				</div><!--// .yui-b -->
			</div><!--// yui-main -->
		</div><!--// bd -->


	</div><!-- // inner -->


</div><!--// doc -->

<script type="text/javascript" src="{{asset('assets/vendors/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/vendors/jquery/dist/jquery.min.js')}}"></script>
<script type="text/javascript">
	window.print();
</script>
</body>
</html>
