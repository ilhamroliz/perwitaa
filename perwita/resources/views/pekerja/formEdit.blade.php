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
                    <h5>Form Perbarui data Pekerja</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
                </div>                    	
                <div class="ibox-content">
                    <form id="form-pekerja">
                        <div class="form-group row">
                         <label for="nik" class="col-sm-2 col-form-label">No id</label>
                            <div class="col-sm-10">
                                <input value="{{$pekerja->p_id}}" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" name="p_id" id="p_id" placeholder="Masukkan No NIK" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="nik-error">
                                    <small>No NIK harus diisi...!</small>
                                </span>
                            </div>
                        </div>

                        

                       
                         <div class="form-group row">
                            <label for="nik" class="col-sm-2 col-form-label">No NIK</label>
                            <div class="col-sm-10">
                                <input value="{{$pekerja->p_nik}}" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" name="No Nik" id="nik" placeholder="Masukkan No NIK" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="nik-error">
                                    <small>No NIK harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Pekerja</label>
                            <div class="col-sm-10">
                                <input value="{{$pekerja->p_name}}" type="text" class="form-control" name="Nama Pekerja" id="nama" placeholder="Masukkan Nama Pekerja" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="nama-error">
                                    <small>Alamat harus diisi...!</small>
                                </span>
                            </div>
                        </div>               
                        <div class="form-group row">
                            <label for="kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <div class="radio-inline"> <input @if($pekerja->p_sex=='L')  checked="checked" @endif type="radio" name="Jenis Kelamin" id="jk" value="L" required="">Laki-Laki</div>
                                <div class="radio-inline"> <input @if($pekerja->p_sex=='P')  checked="checked" @endif type="radio" name="Jenis Kelamin" id="jk2" value="P"  required="">Perempuan</div>                                                                    
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="kelamin-error">
                                    <small>Jenis Kelamin harus diisi...!</small>
                                </span> 
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Tempat Lahir</label>
                            <div class="col-sm-10">
                                <input value="{{$pekerja->p_birthplace}}" type="text" class="form-control" name="Tempat Lahir" id="tempat" placeholder="Masukkan Tempat Lahir" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tempat-error">
                                    <small>Tempat lahir harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tglLahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input value="{{ date('d-F-Y', strtotime($pekerja->p_birthdate)) }}" type="text" readonly="" class="form-control" name="Tanggal Lahir" id="tglLahir" placeholder="Masukkan Tanggal Lahir" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglLahir-error">
                                    <small>Tanggal Lahir harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input value="{{$pekerja->p_address}}" type="text" class="form-control" name="Alamat" id="alamat" placeholder="Masukkan Alamat" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="alamat-error">
                                    <small>Alamat harus diisi...!</small>
                                </span>
                            </div>
                        </div>                    
                        <div class="form-group row">
                            <label for="hp" class="col-sm-2 col-form-label">No Hp</label>
                            <div class="col-sm-10">
                                <input value="{{$pekerja->p_hp}}" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" name="No Hp" id="hp" placeholder="Masukkan No Hp" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="hp-error">
                                    <small>No Hp harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                 
                        <div class="form-group row">
                            <label for="ktp" class="col-sm-2 col-form-label">No KTP</label>
                            <div class="col-sm-10">
                                <input value="{{$pekerja->p_ktp}}" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" name="No KTP" id="ktp" placeholder="Masukkan No KTP" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="ktp-error">
                                    <small>No KTP harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                 
                        <div class="form-group row">
                            <label for="expired" class="col-sm-2 col-form-label">Tanggal Berlaku KTP</label>
                            <div class="col-sm-3">
                                <input value="{{ date('d-F-Y', strtotime($pekerja->p_ktp_expired))}}" type="text" readonly="" class="form-control" name="Tanggal Berlaku KTP" id="expired" placeholder="Masukkan Tanggal Berlaku" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="expired-error">
                                    <small>Tanggal Berlaku KTP harus diisi...!</small>
                                </span>
                            </div>                                                        
                            <div class="col-sm-3">
                                 <label style="padding-top: 5px"><input @if($pekerja->p_ktp_seumurhidup=='Y') checked @endif id="jenisKtp" onclick="setTglBerlakuKtp()" type="checkbox" name="KTP Seumur Hidup" value="Y">&nbsp; KTP Seumur Hidup</label>                                
                            </div>
                        </div>                 
                        
                        <div class="form-group row">
                            <label for="pendidikan" class="col-sm-2 col-form-label">Pendidikan</label>
                            <div class="col-sm-10">    
                                <input value="{{$pekerja->p_education}}" type="text" class="form-control" name="Pendidikan" id="pendidikan" placeholder="Masukkan Pendidikan" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="pendidikan-error">
                                    <small>Pendidikan harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                 
                        <div class="form-group row">
                            <label for="ibu" class="col-sm-2 col-form-label">Nama Ibu</label>
                            <div class="col-sm-10">
                                <input value="{{$pekerja->p_momname}}" type="text" class="form-control" name="Nama Ibu" id="ibu" placeholder="Masukkan Nama Ibu" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="keterangan-error">
                                    <small>Nama Ibu harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                 
                        <div class="form-group row">
                            <label for="kpj" class="col-sm-2 col-form-label">No KPJ</label>
                            <div class="col-sm-10">
                                <input value="{{$pekerja->p_kpj_no}}" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" name="No KPJ" id="kpj" placeholder="Masukkan No KPJ" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="kpj-error">
                                    <small>KPJ harus diisi...!</small>
                                </span>
                            </div>
                        </div>                       
                        <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                        <a href="{{url('manajemen-pekerja/data-pekerja')}}" class="btn btn-danger btn-flat" type="button">Kembali</a>
                                        <button class="ladda-button ladda-button-demo btn btn-primary btn-flat simpan" type="button" onclick="Perbarui()">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                    </form>   
                    
                </div>
            </div>
        </div>
    </div>
</div>      



@endsection

@section('extra_scripts')
<script type="text/javascript">
    var info       = $('.pesan');
     $('#expired').datepicker({
        autoclose: true,
        dateFormat: 'dd-MM-yy',
        endDate: 'today'
    });
     $('#tglLahir').datepicker({
        autoclose: true,
        dateFormat: 'dd-MM-yy',
        endDate: 'today'
    });
   
    
      setTglBerlakuKtp();
      function setTglBerlakuKtp(){        
        
        if($('#jenisKtp').is(":checked")){
           $('#expired').val(''); 
           $('#expired').attr('disabled','disabled'); 
        }else{
            $('#expired').datepicker({
                autoclose: true,
                dateFormat: 'dd-MM-yy',
                endDate: 'today'
            }).datepicker("setDate", "0");           
           $('#expired').removeAttr('disabled',false); 
        }
    }
    
    
    function Perbarui() {
        var p_id=$('#p_id').val();
        var buttonLadda = $('.simpan').ladda();
        buttonLadda.ladda('start');
         if(validateForm()){
        $.ajax({
            url: baseUrl + '/manajemen-pekerja/data-pekerja/perbarui/'+p_id,
            // type        : 'post',            
            type: 'get',
            timeout: 10000,
            data: $('#form-pekerja :input').serialize(),
            dataType: 'json',            
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
           
            
            
           pendidikan,ibu,kpj               
           var nik = document.getElementById('nik');
 
           var nama = document.getElementById('nama');
           var tempat = document.getElementById('tempat');
           var tglLahir = document.getElementById('tglLahir');           
           var hp = document.getElementById('hp');
           var ktp = document.getElementById('ktp');           
           var expired = document.getElementById('expired');
           var jenisKtp = document.getElementById('jenisKtp');
           var pendidikan = document.getElementById('pendidikan');
           var ibu = document.getElementById('ibu');
           var kpj = document.getElementById('kpj'); 
           var jk = document.getElementById('jk');
           var jk2 = document.getElementById('jk2');            

            if(nik.validity.valueMissing){
                $('#nik-error').css('display', '');
                return false;
            }
          
            else if(nama.validity.valueMissing){
                $('#nama-error').css('display', '');
                return false;
            }
            else if(jk.validity.valueMissing && jk2.validity.valueMissing){
                $('#kelamin-error').css('display', '');
                return false;
            }
            else if(tempat.validity.valueMissing){
                $('#tempat-error').css('display', '');
                return false;
            }
            else if(tglLahir.validity.valueMissing){
                $('#tglLahir-error').css('display', '');
                return false;
            }
            else if(hp.validity.valueMissing){
                $('#hp-error').css('display', '');
                return false;
            }
            else if(ktp.validity.valueMissing){
                $('#ktp-error').css('display', '');
                return false;
            }
            else if(expired.validity.valueMissing && jenisKtp.validity.valueMissing){
                $('#expired-error').css('display', '');
                return false;
            }
            else if(pendidikan.validity.valueMissing){
                $('#pendidikan-error').css('display', '');
                return false;
            }
            else if(ibu.validity.valueMissing){
                $('#ibu-error').css('display', '');
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