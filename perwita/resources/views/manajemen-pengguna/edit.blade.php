@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    .huruf{
        text-transform: capitalize;
    }
    .spacing-top{
        margin-top:15px;
    }
    #upload-file-selector {
        display:none;   
    }
    .margin-correction {
        margin-right: 10px;   
    }

</style>

@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Form Ubah Profil</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
                </div>
                <div class="ibox-content">




                    <form enctype="multipart/form-data" class="kirim" id="uploadForm">
                        <div class="col-md-12" style="margin:10px; border-bottom: 2px solid #efefef; padding:0px;">
                            <div class="row image-holder" style="padding:0px; padding-bottom: 20px;">
                                <img style="border: 1px solid #00ffff;width: 100px;height: 100px" src="{{URL::to('/')}}/{{$member->m_image}}" class="img-responsive thumb-image" alt="">
                            </div>
                            <div class="row" style="padding:0px;">
                                <div class="col-md-12" style="padding:0px; padding-bottom: 20px;">
                                    <label class="btn btn-default" for="upload-file-selector">
                                        <input id="upload-file-selector" name="imageUpload" class="uploadGambar" type="file">
                                        <i class="fa fa-upload margin-correction"></i>upload gambar
                                    </label>
                                </div>

                            </div>

                        </div>









                        <table class="table table-striped table-borderred formProfil">

                            <tr>                                    
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <th style="width:15%">Nama Pengguna</th>
                            <td><input value="{{$member->m_name}}" class="form-control huruf" name="name"></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><input value="{{$member->m_addr}}" class="form-control huruf" name="alamat"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td><input readonly="" value="{{date('d-M-Y', strtotime($member->m_birth_tgl))}}" class="form-control huruf tanggal" name="tanggal_lahir"></td>                                    
                            </tr>
                            <tr>
                                <th>
                                    Pilih Akses Group
                                </th>
                                <td><select class="form-control">
                                        <option></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        
                        <div class="alert alert-info" style="background:#33ccff">
                            Pilih Hak Akses
                        </div>
                        
                            
                            <table class="table table-striped table-borderred">
                                    <thead>
                                    <tr>
                                        <th>
                                             No
                                        </th>
                                        <th>
                                             Nama Menu
                                        </th>
                                        <th>
                                             Level Akses
                                        </th>
                                    </tr>
                                    </thead>
                                <tbody>
                                @foreach($acces as $index=> $data)
                                <tr>
                                    <td>
                                         {{$index+1}}
                                    </td>
                                    <td>
                                         {{$data->a_type}}
                                    </td>                                   
                                    <td>
                                         <select class="form-control m-b" name="account">
                                        <option value="1">Lihat</option>
                                        <option value="2">Lihat, Edit</option>
                                        <option value="3">Lihat, Tambah, Edit, Hapus </option>                                        
                                    </select>
                                    </td>
                                </tr>                                
                                @endforeach                  
                                </tbody>
                            </table>
                        
                            <button type="submit" class="ladda-button  perbarui  btn btn-primary  m-b btn-flat" data-style="zoom-in">
                                        <span class="ladda-label">Perbarui</span><span class="ladda-spinner"></span>
                            </button>
                            <a href="{{URL::to('/')}}/profil" class="ladda-button  batalkan  btn btn-primary  m-b btn-flat" data-style="zoom-in">
                                <span class="ladda-label">Batalkan</span><span class="ladda-spinner"></span>
                            </a>
                        
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>      



@endsection

@section('extra_scripts')
<script type="text/javascript">
    $('.tanggal').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
        endDate: 'today'
    }).datepicker("setDate", "0");
//    function perbarui() {
//
//        var buttonLadda = $('.perbarui').ladda();
//        buttonLadda.ladda('start');
//        $.ajax({
//            url: baseUrl + '/profil/perbarui-profil',
//            // type        : 'post',            
//            type: 'get',
//            timeout: 10000,
//            data: $('.kirim').serialize(),
//            dataType: 'json',
//            enctype: 'multipart/form-data',
//            processData: false,  // tell jQuery not to process the data
//            contentType: false,          
//            success: function (response) {
//                if (response.status == 'berhasil') {
//                    window.location = baseUrl + '/profil';
//                }
//            },
//            error: function (xhr, status) {
//                if (status == 'timeout') {
//                    $('.error-load').css('visibility', 'visible');
//                    $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
//                }
//                else if (xhr.status == 0) {
//                    $('.error-load').css('visibility', 'visible');
//                    $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
//                }
//                else if (xhr.status == 500) {
//                    $('.error-load').css('visibility', 'visible');
//                    $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
//                }
//
//                buttonLadda.ladda('stop');
//            }
//        });
//    }

$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	 url: baseUrl + '/profil/perbarui-profil',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
                        enctype: 'multipart/form-data',
    	    cache: false,
                        dataType: 'json',
			processData:false,
			success: function(response)
		    {
			   if (response.status == 'berhasil') {
                    window.location = baseUrl + '/profil';
                }
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));

    $(".uploadGambar").on('change', function () {

        //alert($(".uploadGambar").val());

        if (typeof (FileReader) != "undefined") {

            var image_holder = $(".image-holder");
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                image_holder.html('<img src="{{ asset('image / loading1.gif') }}" class="img-responsive" width="40px">');

                $('.save').attr('disabled', true);

                setTimeout(function () {
                    image_holder.empty();
                    $("<img />", {
                        "src": e.target.result,
                        "class": "img-responsive thumb-image",
                        "height": "100px",
                        "width": "100px",
                    }).appendTo(image_holder);
                    $('.save').attr('disabled', false);
                }, 2000)
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }

    });

</script>
@endsection