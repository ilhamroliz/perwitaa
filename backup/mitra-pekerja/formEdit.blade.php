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
                    <h5>Form Perbarui Data Mitra Pekerja</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
                </div>
                <div class="ibox-content">
                    <form id="form-mitra-contract">                        
                        <div class="form-group row">
                            <label for="kontrak" class="col-sm-2 col-form-label">No Kontrak</label>
                            <div class="col-sm-10">
                                <input value="{{$update_mitra_contract->mc_no}}" class="form-control" name="kontrak" id="kontrak" required="">                                    
                                   
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="kontrak-error">
                                    <small>No Kontrak harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                         <div >                     
                        
                        <div class="form-group row" >
                            <label for="Nama" class="col-sm-2 col-form-label">Tanggal Kontrak</label>
                            <div class="col-sm-3">
                                <input value="{{$update_mitra_contract->mc_date}}" readonly="" class="form-control" name="Tanggal Kontrak" id="tglKontrak"  required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglKontrak-error">
                                    <small>Tanggal Kontrak harus diisi...!</small>
                                </span>
                            </div>
                            <label for="tglBatas" class="col-sm-2 col-form-label">Batas Kontrak</label>
                            <div class="col-sm-3">
                                <input value="{{$update_mitra_contract->mc_expired}}" readonly class="form-control" name="Batas Kontrak" id="tglBatas" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglBatas-error">
                                    <small>Batas Kontrak harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                       
                         <div class="form-group row ">
                            <label for="perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-10">
                                <input value="{{$update_mitra_contract->c_name}}" readonly="" class="form-control" name="perusahaan" data-perusahaan id="perusahaan" required="" placeholder="Masukkan Nama Perusahaan">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="perusahaan-error">
                                    <small>Nama Perusahaan harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label for="mitra" class="col-sm-2 col-form-label">Nama Mitra</label>
                            <div class="col-sm-10">
                                <input value="{{$update_mitra_contract->m_name}}" readonly="" class="form-control" name="mitra" data-input-mitra id="mitra" required="" placeholder="Masukkan Nama Mitra">                                                                       
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="mitra-error">
                                    <small>Nama Mitra harus diisi...!</small>
                                </span>
                            </div>
                        </div>
         
                        
                       
                       <div class="form-group row" >
                            <label for="jumlahPekerja" class="col-sm-2 col-form-label">Jumlah Pekerja</label>
                            <div class="col-sm-3">
                                <input value="{{$update_mitra_contract->mc_need}}" readonly="" type="text" class="form-control" name="Jumlah Pekerja" id="jumlahPekerja" placeholder="Masukkan Jumlah Pekerja" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="jumlahPekerja-error">
                                    <small>Jumlah Pekerja harus diisi...!</small>
                                </span>
                            </div>
                            <label for="totalPekerja" class="col-sm-3 col-form-label" style="width:18%">Total Pekerja Terpenuhi</label>
                            <div class="col-sm-3">
                                <input value="{{$update_mitra_contract->mc_fulfilled}}"  type="number" class="form-control" name="totalPekerja" readonly="" id="totalPekerja"  required="">                                
                            </div>
                        </div>
                        </div>
                            
                        </form>   
                   
                        <div class="hr-line-dashed"></div>
                        <div >
                        <table class="table table-bordered table-striped pilihMitraPekerja">
                            <thead>
                            <th>
                                <input type="checkbox" class="setCek" onclick="cekAll()">
                            </th>                                
                                <th>Nama Pekerja</th>
                                <th>Usia</th>
                                <th>Alamat</th>
                                <th>No Hp</th>
                                <th>Pendidikan</th>
                                <th style="display:  ;" style="width: 2px" class="text-center">a</th>                
                                <th style="display: ;" style="width: 2px" class="text-center">b</th>  
                            </thead>
                            <tbody>                            
                                @foreach($pekerja as $index => $data)                                
                                <tr @if($data->mp_pekerja!='') style="background: #bbc4d6;" @endif class="select-{{$index}}" onclick="select({{$index}})">                                    
                                    <td>
                                        <input name="chek[]" @if($data->mp_pekerja!='') value="1" @endif class="chek-all chek-{{$index}}">
                                        <input name="pekerja[]" value="{{$data->p_id}}">
                                        <input  @if($data->mp_pekerja!='') checked="checked" @endif class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}});cekAB({{$index}});">                                        
                                    </td>
                                    <td>{{$data->p_name}}</td>
                                    <td>{{$data->p_sex}}</td>
                                    <td>{{$data->p_address}}</td>
                                    <td>{{$data->p_hp}}</td>
                                    <td>{{$data->p_education}}</td>
        <td style="display: ;" style="width: 2px"><input style="width: 50px" class="a-{{$index}} form-control " name="a[]" value="@if($data->mp_pekerja!='')1 @elseif($data->mp_pekerja=='') 0 @endif"></td>    
        <td style="display:  ;" style="width: 2px"><input style="width: 50px"  class="b-{{$index}} form-control" name="b[]" value="0" ></td>    
                                </tr>
                                @endforeach
                                
                            <tbody>
                        </table>
                        
                        <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                        <a href="{{url('manajemen-pekerja-mitra/data-pekerja-mitra')}}" class="btn btn-danger btn-flat" type="button">Kembali</a>
                                        <button class="ladda-button ladda-button-demo btn btn-primary btn-flat simpan" type="button" onclick="simpan()">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>      



@endsection

@section('extra_scripts')
<script type="text/javascript">
    var info       = $('.pesan');
    
table=$(".pilihMitraPekerja").DataTable({
    "columnDefs": [ {
        "targets": 0,
        "orderable": false
        } ]
    
});

function cekAB(index){     
        $nilaiA=($('.a-'+index).val());
        $nilaiB=($('.b-'+index).val());
        kuantitas=($('.chek-'+index).val());
        
        if(kuantitas=='' && $nilaiA==0 && $nilaiB==0 ){            
            
        }
        else if(kuantitas=='' && $nilaiA==0 && $nilaiB==1 ){              
            alert('d');
            $('.b-'+index).val(0);
            
        }
        else if(kuantitas!='' && kuantitas!='0' && $nilaiA==0 && $nilaiB==0 ){            
            alert('b');
            $('.b-'+index).val(1);//insert
            
            
        }
        else if(kuantitas!='' && kuantitas!='0' && $nilaiA==1 && $nilaiB==0 ){       
            
            alert(kuantitas);
            $('.b-'+index).val(1);            //update            
        }
        else if(kuantitas!='' && kuantitas!='0' && $nilaiA==1 && $nilaiB==2 ){            
            $('.b-'+index).val(1);          //update
            alert('j');
            
        }
        else if( kuantitas=='0' && $nilaiA==1 && $nilaiB==0 || kuantitas=='' && $nilaiA==1 && $nilaiB==0 ){            
            $('.b-'+index).val(2);  //delete      
            alert('dj');
            
        }      
        else if(kuantitas=='' && $nilaiA==1 && $nilaiB==1 || kuantitas=='0' && $nilaiA==1 && $nilaiB==1 ){            
            $('.b-'+index).val(2);          //delete  //            
            alert('dp');
        }
        
              
    };

var countchecked=0;
 
    function cekAll(){  
        
        if($('.setCek').is(":checked")){
          table.$('input[name="pilih[]"]').prop("checked",true);          
          //table.$('input[name="pilih[]"]').css('background','red');
          table.$('.chek-all').val('1');  
        }else{
          table.$('input[name="pilih[]"]').prop("checked",false);
          table.$('.chek-all').val(''); 
        }        
        hitung();
        hitungSelect();
    }
    
    function hitung(){
         countchecked = table.$("input[name='pilih[]']:checked").length;    
         $('#totalPekerja').val(countchecked);
    }
    
    function hitungSelect(){          
        for(i=0;i<=table.$('tr').length;i++)
        if(table.$('.pilih-'+i).is(":checked")){
          table.$('.select-'+i).css('background','#bbc4d6')
          //table.$('.select-'+i).css('color','white')
        }else{
          table.$('.select-'+i).css('background','')  
        }
        
    }
    
      function selectBox(id){          
        if(table.$('.pilih-'+id).is(":checked")){
          table.$('.pilih-'+id).prop("checked",false); 
          table.$('.chek-'+id).val('1');          
        }else{
          table.$('.pilih-'+id).prop("checked",true);   
          table.$('.chek-'+id).val('');
        }
        hitungSelect();
        hitung();
        
    }
      function select(id){          
        if(table.$('.pilih-'+id).is(":checked")){
          table.$('.pilih-'+id).prop("checked",false);          
          table.$('.chek-'+id).val('');
        }else{
            
          table.$('.pilih-'+id).prop("checked",true);   
          table.$('.chek-'+id).val('1');  
        }
        hitungSelect();
        hitung();
        
    }

    
    
    
    
    
    
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