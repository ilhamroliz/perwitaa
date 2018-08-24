<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="POST" action="{{ url('pekerja-pjtki/data-pekerja/simpan') }}" accept-charset="UTF-8" id="createItempjtki" enctype="multipart/form-data">
		<input type="file" name="image">
		<input type="file" name="file" id="inputImagepjtki" class="">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input id="upload-file-selectorpjtki" name="imageUpload" class="uploadGambar" type="file" >
		<button type="submit">Simpan</button>
	</form>
</body>
</html>
