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



  </style>

</head>
<body style="font-family:Monospace;">
<div width="900">
<div id="doc2" class="yui-t7">
	<div id="inner">

		<div id="hd">
			<div class="yui-gc">
				<div class="yui-u first">
					<h1 id="p_name" style="font-size:100px;"><b></b></h1>
				</div>
			</div><!--// .yui-gc -->
		</div><!--// hd -->
		<br>
		<div id="bd">
			<div id="yui-main">
				<div class="yui-b">

					<div class="yui-gf">
						<div class="yui-u first">
							<h2></h2>
						</div>
					</div>
					<br>
					<table width="1000" height="200" border="1" cellspacing="0" style="font-size:25px">
						<tbody>
							<tr>
								<td align="left">
									<br>
									&nbsp; Nama Pekerja &nbsp; : &nbsp; {{$data[0]->p_name}}<br>
									<br>
									&nbsp; No SP &nbsp; : &nbsp; {{$data[0]->sp_no}}<br>
									<br>
									&nbsp; Jabatan &nbsp; : &nbsp; {{$data[0]->p_jabatan}}<br>
									<br>
									&nbsp; Divisi &nbsp; : &nbsp; {{$data[0]->md_name}}<br>
									<br>
									&nbsp; Tanggal Mulai &nbsp; : &nbsp; {{$data[0]->sp_date_start}} &nbsp; Tanggal Berakhir &nbsp; : &nbsp; {{$data[0]->sp_date_end}}<br>
									<br>
									&nbsp; Keterangan &nbsp; : &nbsp; {{$data[0]->sp_note}}<br>
									<br>
									&nbsp; Pelanggaran &nbsp; : &nbsp; <br>
									<br>
									@foreach($data as $x)
									&nbsp; - {{$x->spd_pelanggaran}} <br>
									<br>							
									@endforeach
								</td>
							</tr>
						</tbody>
					</table>

				</div><!--// .yui-h2 -->
			</div><!--// yui-main -->
		</div><!--// bd -->


	</div><!-- // inner -->


</div><!--// doc -->
</div>
<script type="text/javascript" src="{{asset('assets/vendors/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/vendors/jquery/dist/jquery.min.js')}}"></script>
<script type="text/javascript">
	window.print();
</script>
</body>
</html>
