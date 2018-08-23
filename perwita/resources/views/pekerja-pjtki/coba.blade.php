<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="POST" action="{{ url('manajemen-pekerja/data-pekerja/simpan') }}" accept-charset="UTF-8" id="createItem" enctype="multipart/form-data">
		<input type="file" name="image">
		<input type="file" name="file" id="inputImage" class="">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input id="upload-file-selector" name="imageUpload" class="uploadGambar" type="file" >
		<button type="submit">Simpan</button>
	</form>
</body>
</html>