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
                    <h5>Form Tambah Data Pegawai</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
                </div>                    	
                <div class="ibox-content">
                    <table class="table table-striped table-bordered" id="form-pegawai">                                           
                         <tr>
                            <th>No KTP</th>
                            <td><input onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="ktp" class="form-control huruf" name="No KTP" placeholder="No KTP" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="ktp-error">
                                    <small>No KTP harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td><input id="nama" class="form-control huruf" name="Nama Lengkap" placeholder="Nama Lengkap" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="nama-error">
                                    <small>Nama Lengkap harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>
                                <div class="radio-inline"> <input type="radio" name="Jenis Kelamin" id="jk" value="L" required="">Laki-Laki</div>
                                <div class="radio-inline"> <input type="radio" name="Jenis Kelamin" id="jk2" value="P"  required="">Perempuan</div>                                    
                                
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="jk-error">
                                    <small>Jenis Kelamin harus diisi...!</small>
                                </span>                                    
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td><input readonly="" id="tanggal" class="form-control huruf" name="Tanggal Lahir" placeholder="Tanggal Lahir" required="">
                                <span style="color:#ed5565; display: none " class="help-block m-b-none reset" id="tanggal-error">
                                    <small>Tanggal Lahir harus diisi...!</small>
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
                            <td><input id="telp" class="form-control huruf" name="No Telp" placeholder="No Telp." required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="telp-error">
                                    <small>No Telp harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Expired KTP</th>
                            <td><input readonly="" id="exp" class="form-control huruf" name="Expired KTP" placeholder="Expired KTP" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="exp-error">
                                    <small>Expired KTP harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Ibu</th>
                            <td><input id="ibu" class="form-control huruf" name="Nama Ibu" placeholder="Nama Ibu" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="ibu-error">
                                    <small>Nama Ibu harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Pendidikan</th>
                            <td><input id="pendidikan" class="form-control huruf" name="Pendidikan" placeholder="Pendidikan" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="pendidikan-error">
                                    <small>Pendidikan harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <th style="width:20%">NIK</th>
                            <td><input id="nik" class="form-control huruf" name="NIK" placeholder="NIK" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="nik-error">
                                    <small>NIK harus diisi...!</small>
                                </span>
                            </td>
                        </tr>                        
                        <tr>
                            <th>No KPJ</th>
                            <td><input id="kpj" class="form-control huruf" name="No KPJ" placeholder="kpj" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="kpj-error">
                                    <small>No KPJ harus diisi...!</small>
                                </span>
                            </td>
                        </tr>                   
                        <tr>
                            <th></th>
                            <td>
                                <button onclick="simpan()" type="submit" class="ladda-button  simpan  btn btn-primary btn-sm  m-b btn-flat" data-style="zoom-in">
                                        <span class="ladda-label">Simpan</span><span class="ladda-spinner"></span>
                                </button>
                                <a href="{{URL::to('/')}}/manajemen-pegawai/data-pegawai" class="ladda-button btn-sm batalkan  btn btn-danger  m-b btn-flat" data-style="zoom-in">
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
    $('#tanggal').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
        endDate: 'today'
    }).datepicker("setDate", "0");
    $('#exp').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
        endDate: 'today'
    }).datepicker("setDate", "0");
    function simpan() {
        var buttonLadda = $('.simpan').ladda();
        buttonLadda.ladda('start');
         if(validateForm()){
        $.ajax({
            url: baseUrl + '/manajemen-calon-pekerja/data-calon-pekerja/simpan',
            // type        : 'post',            
            type: 'get',
            timeout: 10000,
            data: $('#form-pegawai :input').serialize(),
            dataType: 'json',
            enctype: 'multipart/form-data',
            processData: false,  // tell jQuery not to process the data
            contentType: false,          
            success: function (response) {
                if (response.status == 'berhasil') {
                    window.location = baseUrl + '/manajemen-pekerja/data-pekerja';
                } else if(response.status=='gagal'){
                    info.css('display','');
                    $.each(response.data, function(index, error) {
                           info.find('ul').append('<li>' + error + '</li>');                      
                    });                    
                    buttonLadda.ladda('stop');                     
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
                          
            var exp = document.getElementById('exp');
            var nik = document.getElementById('nik');
            var nama = document.getElementById('nama');
            var jk = document.getElementById('jk');
            var jk = document.getElementById('jk2');
            var tempat = document.getElementById('tempat');
            var tanggal = document.getElementById('tanggal');
            var alamat = document.getElementById('alamat');
            var telp = document.getElementById('telp');
            var ibu = document.getElementById('ibu');
            var pendidikan = document.getElementById('pendidikan');            
            var ktp = document.getElementById('ktp');
            var kpj = document.getElementById('kpj');            
            if(ktp.validity.valueMissing){
                $('#ktp-error').css('display', '');
                return false;
            }
            else if(nama.validity.valueMissing){
                $('#nama-error').css('display', '');
                return false;
            }
             else if(jk.validity.valueMissing || jk2.validity.valueMissing){
                $('#jk-error').css('display', '');
                return false;
            }
            else if(tanggal.validity.valueMissing){
                $('#tanggal-error').css('display', '');
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
            else if(exp.validity.valueMissing){
                $('#exp-error').css('display', '');
                return false;
            }
             else if(ibu.validity.valueMissing){
                $('#ibu-error').css('display', '');
                return false;
            }
            else if(pendidikan.validity.valueMissing){
                $('#pendidikan-error').css('display', '');
                return false;
            }
            else  if(nik.validity.valueMissing){
                $('#nik-error').css('display', '');                
                return false;
            } 
                     
            else if(kpj.validity.valueMissing){
                $('#kpj-error').css('display', '');
                return false;
            }

            return true;
        }


</script>
@endsection