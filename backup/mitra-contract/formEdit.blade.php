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
                    <h5>Form Perbarui Data Kontrak Mitra</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
                </div>
                <div class="ibox-content">
                    
                    <form id="form-mitra-contract" >
                        <input value="{{$mitra_contract->mc_mitra}}" id="mitra" name="mitra">
                        <input value="{{$mitra_contract->mc_contractid}}" id="id_detail" name="id_detail">
                        <div class="form-group row">
                            <label for="Nama" class="col-sm-2 col-form-label">Tanggal Kontrak</label>
                            <div class="col-sm-3">
                                <input value="{{date('d-F-Y', strtotime($mitra_contract->mc_date))}}" readonly="" class="form-control" name="Tanggal Kontrak" id="tglKontrak"  required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglKontrak-error">
                                    <small>Tanggal Kontrak harus diisi...!</small>
                                </span>
                            </div>
                            <label for="tglBatas" class="col-sm-2 col-form-label">Batas Kontrak</label>
                            <div class="col-sm-3">
                                <input value="{{date('d-F-Y', strtotime($mitra_contract->mc_expired))}}" readonly class="form-control" name="Batas Kontrak" id="tglBatas" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglBatas-error">
                                    <small>Batas Kontrak harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kontrak" class="col-sm-2 col-form-label">No Kontrak</label>
                            <div class="col-sm-10">
                                <input value="{{$mitra_contract->mc_no}}" type="text" class="form-control" name="No Kontrak" id="kontrak" placeholder="No Kontrak" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="kontrak-error">
                                    <small>No Kontrak harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="perusahaan" id="perusahaan" required="">
                                    
                                    @foreach($comp as $data)
                                    <option @if($mitra_contract->mc_comp==$data->c_id) selected @endif value="{{$data->c_id}}">{{$data->c_name}}</option>
                                    @endforeach
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="perusahaan-error">
                                    <small>Nama Perusahaan harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Nama Mitra</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="mitra" id="mitra" required="">                                    
                                    @foreach($mitra as $data)
                                    <option @if($mitra_contract->mc_mitra==$data->m_id) selected @endif  value="{{$data->m_id}}">{{$data->m_name}}</option>
                                    @endforeach
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="mitra-error">
                                    <small>Nama Mitra harus diisi...!</small>
                                </span>
                            </div>
                        </div>
         
                        
                       
                        <div class="form-group row">
                            <label for="jumlahPekerja" class="col-sm-2 col-form-label">Jumlah Pekerja</label>
                            <div class="col-sm-3">
                                <input value="{{$mitra_contract->mc_need}}" type="text" class="form-control" name="Jumlah Pekerja" id="jumlahPekerja" placeholder="Masukkan Jumlah Pekerja" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="jumlahPekerja-error">
                                    <small>Jumlah Pekerja harus diisi...!</small>
                                </span>
                            </div>
                            <label for="totalPekerja" class="col-sm-3 col-form-label" style="width:18%">Total Pekerja Terpenuhi</label>
                            <div class="col-sm-3">
                                <input value="{{$mitra_contract->mc_fulfilled}}" type="number" class="form-control" name="totalPekerja" readonly="" id="totalPekerja"  required="">                                
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                        <button class="btn btn-danger btn-flat" type="button">Kembali</button>
                                        <button class="ladda-button ladda-button-demo btn btn-success btn-flat simpan" type="button" onclick="perbarui()">
                                            Perbarui
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
    $('#tglKontrak').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
      //  endDate: 'today'
    });
    $('#tglBatas').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        //endDate: 'today'
    });
    
    function perbarui() {
        var mitra=$('#mitra').val();
        var id_detail=$('#id_detail').val();
        var buttonLadda = $('.simpan').ladda();
        buttonLadda.ladda('start');
         if(validateForm()){
        $.ajax({
            url: baseUrl + '/manajemen-kontrak-mitra/data-kontrak-mitra/perbarui/'+mitra+'/'+id_detail,
            // type        : 'post',            
            type: 'get',
            timeout: 10000,
            data: $('#form-mitra-contract').serialize(),
            dataType: 'json',                    
            success: function (response) {
                if (response.status == 'berhasil') {
                    window.location = baseUrl + '/manajemen-kontrak-mitra/data-kontrak-mitra';
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
    
        function validateForm() {
        $('.reset').css('display', 'none');
        
        var tglKontrak = document.getElementById('tglKontrak');
        var tglBatas = document.getElementById('tglBatas');
        var kontrak = document.getElementById('kontrak');
        var perusahaan = document.getElementById('perusahaan');
        var mitra = document.getElementById('mitra');
        var jumlahPekerja = document.getElementById('jumlahPekerja');

        //alert(username.value);

        if (tglKontrak.validity.valueMissing) {
            $('#tglKontrak-error').css('display', '');
            return false;
        }
        else if (tglBatas.validity.valueMissing) {
            $('#tglBatas-error').css('display', '');
            return false;
        }
        else if (kontrak.validity.valueMissing) {
            $('#kontrak-error').css('display', '');
            return false;
        }
        else if (perusahaan.validity.valueMissing) {
            $('#perusahaan-error').css('display', '');
            return false;
        }
        else if (mitra.validity.valueMissing) {
            $('#mitra-error').css('display', '');
            return false;
        }
        else if (jumlahPekerja.validity.valueMissing) {
            $('#jumlahPekerja-error').css('display', '');
            return false;
        }


        return true;
    }


</script>
@endsection