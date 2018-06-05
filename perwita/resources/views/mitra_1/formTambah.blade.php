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
    <div class="alert alert-danger pesan" style="display:none;">
          <ul></ul>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Form Tambah Mitra</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered" id="form-mitra">
                        
                        <tr>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <th style="width:20%">Nama Mitra</th>
                            <td><input id="nama" class="form-control huruf" name="Nama Mitra" placeholder="Nama Mitra" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="nama-error">
                                    <small>Nama mitra harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><input id="alamat" class="form-control huruf" name="Alamat" placeholder="Alamat" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="alamat-error">
                                    <small>Alamat harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>No Telp.</th>
                            <td><input id="telp" class="form-control huruf" name="No Telp." placeholder="No Telp." required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="telp-error">
                                    <small>No telp. harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Divisi</th>
                            <td><input id="divisi" class="form-control huruf" name="Divisi" placeholder="Divisi" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="divisi-error">
                                    <small>Divisi harus diisi...!</small>
                                </span>
                            
                            </td>
                        </tr>
                        <tr>
                            <th>Pengawas Lapangan</th>
                            <td><input id="pengawas" class="form-control huruf" name="Pengawas Lapangan" placeholder="Pengawas Lapangan" required="">
                                <span style="color:#ed5565; display: none " class="help-block m-b-none reset" id="pengawas-error">
                                    <small>Pengawas lapangan harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Program Kerja</th>
                            <td><input id="program" class="form-control huruf" name="Program Kerja" placeholder="Program Kerja" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="program-error">
                                    <small>Pengawas lapangan harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <button onclick="simpan()" type="submit" class="ladda-button  simpan  btn btn-primary btn-sm  m-b btn-flat" data-style="zoom-in">
                                        <span class="ladda-label">Simpan</span><span class="ladda-spinner"></span>
                                </button>
                                <a href="{{URL::to('/')}}/manajemen-mitra/data-mitra" class="ladda-button btn-sm batalkan  btn btn-danger  m-b btn-flat" data-style="zoom-in">
                                    <span class="ladda-label">Batalkan</span><span class="ladda-spinner"></span>
                                </a>
                            </td>
                        </tr>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>      



@endsection

@section('extra_scripts')
<script type="text/javascript">
    var info       = $('.pesan');
    $('.tanggal').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
        endDate: 'today'
    }).datepicker("setDate", "0");
    function simpan() {
        var buttonLadda = $('.simpan').ladda();
        buttonLadda.ladda('start');
         if(validateForm()){
        $.ajax({
            url: baseUrl + '/manajemen-mitra/data-mitra/simpan',
            // type        : 'post',            
            type: 'get',
            timeout: 10000,
            data: $('#form-mitra :input').serialize(),
            dataType: 'json',
            enctype: 'multipart/form-data',
            processData: false,  // tell jQuery not to process the data
            contentType: false,          
            success: function (response) {
                if (response.status == 'berhasil') {
                    window.location = baseUrl + '/manajemen-mitra/data-mitra';
                } else if(response.status=='gagal'){
                    info.css('display','');
                    $.each(response.data, function(index, error) {
                           info.find('ul').append('<li>' + error + '</li>');                      
                    });                    
                    buttonLadda.ladda('stop'); 
                    alert('sa');
                }
                
                
                
            },
            error: function (xhr, status) {
                if (status == 'timeout') {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                }
                else if (xhr.status == 0) {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                }
                else if (xhr.status == 500) {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                }

                buttonLadda.ladda('stop');
            }
        });
         }else{
              buttonLadda.ladda('stop');              
         }
    }
    
        function validateForm(){
            $('.reset').css('display', 'none');
            var nama = document.getElementById('nama');
            var alamat = document.getElementById('alamat');
            var telp = document.getElementById('telp');
            var divisi = document.getElementById('divisi');
            var pengawas = document.getElementById('pengawas');
            var program = document.getElementById('program');

            //alert(username.value);

            if(nama.validity.valueMissing){
                $('#nama-error').css('display', '');                
                return false;
            }
            else if(alamat.validity.valueMissing){
                $('#alamat-error').css('display', '');
                return false;
            }
            else if(telp.validity.valueMissing){
                $('#telp-error').css('display', '');
                return false;
            }
            else if(divisi.validity.valueMissing){
                $('#divisi-error').css('display', '');
                return false;
            }
            else if(pengawas.validity.valueMissing){
                $('#pengawas-error').css('display', '');
                return false;
            }
            else if(program.validity.valueMissing){
                $('#program-error').css('display', '');
                return false;
            }

            return true;
        }


</script>
@endsection