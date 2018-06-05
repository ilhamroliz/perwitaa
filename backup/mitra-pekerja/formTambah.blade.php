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
                    <h5>Form Tambah Data Mitra Pekerja</h5>
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
                                <select class="form-control" name="kontrak" id="kontrak" required="" onchange="cekMitraComp()">                                    
                                    @foreach($mitra_contract as $data)
                                    <option  data-mitra="{{$data->mc_mitra}}" data-contractid="{{$data->mc_contractid}}" value="{{$data->mc_contractid}}">{{$data->mc_no}}</option>                                    
                                    @endforeach
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="kontrak-error">
                                    <small>No Kontrak harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                         <div class="sembunyikan" style="display: none">                     
                        
                        <div class="form-group row" >
                            <label for="Nama" class="col-sm-2 col-form-label">Tanggal Kontrak</label>
                            <div class="col-sm-3">
                                <input readonly="" class="form-control" name="Tanggal Kontrak" id="tglKontrak"  required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglKontrak-error">
                                    <small>Tanggal Kontrak harus diisi...!</small>
                                </span>
                            </div>
                            <label for="tglBatas" class="col-sm-2 col-form-label">Batas Kontrak</label>
                            <div class="col-sm-3">
                                <input readonly class="form-control" name="Batas Kontrak" id="tglBatas" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglBatas-error">
                                    <small>Batas Kontrak harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                       
                         <div class="form-group row ">
                            <label for="perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-10">
                                <input readonly="" class="form-control" name="perusahaan" data-perusahaan id="perusahaan" required="" placeholder="Masukkan Nama Perusahaan">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="perusahaan-error">
                                    <small>Nama Perusahaan harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label for="mitra" class="col-sm-2 col-form-label">Nama Mitra</label>
                            <div class="col-sm-10">
                                <input readonly="" class="form-control" name="mitra" data-input-mitra id="mitra" required="" placeholder="Masukkan Nama Mitra">                                                                       
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="mitra-error">
                                    <small>Nama Mitra harus diisi...!</small>
                                </span>
                            </div>
                        </div>
         
                        
                       
                       <div class="form-group row" >
                            <label for="jumlahPekerja" class="col-sm-2 col-form-label">Jumlah Pekerja</label>
                            <div class="col-sm-3">
                                <input readonly="" type="text" class="form-control" name="Jumlah Pekerja" id="jumlahPekerja" placeholder="Masukkan Jumlah Pekerja" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="jumlahPekerja-error">
                                    <small>Jumlah Pekerja harus diisi...!</small>
                                </span>
                            </div>
                            <label for="totalPekerja" class="col-sm-3 col-form-label" style="width:18%">Total Pekerja Terpenuhi</label>
                            <div class="col-sm-3">
                                <input value="0" type="number" class="form-control" name="totalPekerja" readonly="" id="totalPekerja"  required="">                                
                            </div>
                        </div>
                        </div>
                            
                        </form>   
                   
                        <div class="hr-line-dashed"></div>
                        <div class="sembunyikan" style="display: none">
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
                            </thead>
                            <tbody>                            
                                @foreach($pekerja as $index => $data)
                                <tr class="select-{{$index}}" onclick="select({{$index}})">                                    
                                    <td>
                                        <input type="hidden" name="chek[]" class="chek-all chek-{{$index}}">
                                        <input type="hidden" name="pekerja[]" value="{{$data->p_id}}">
                                        <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})">                                        
                                    </td>
                                    <td>{{$data->p_name}}</td>
                                    <td>{{$data->p_sex}}</td>
                                    <td>{{$data->p_address}}</td>
                                    <td>{{$data->p_hp}}</td>
                                    <td>{{$data->p_education}}</td>
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


table=$(".pilihMitraPekerja").DataTable({
    "columnDefs": [ {
        "targets": 0,
        "orderable": false
        } ]
    
});
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

    
    
    var info = $('.pesan');
    $('#tglKontrak').datepicker({
        autoclose: true,
        format: 'dd-MM-yy',
        endDate: 'today'
    }).datepicker("setDate", "0");
    $('#tglBatas').datepicker({
        autoclose: true,
        format: 'dd-MM-yy',
        endDate: 'today'
    }).datepicker("setDate", "0");
    
      var config = {               
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                //'.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Data Tidak Ditemukan'},
                '.chosen-select-width'     : {width:"95%"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

    
    cekMitraComp();
    function cekMitraComp() {         
         var mitra=$("#kontrak").find('option:selected').data('mitra') 
         var contractid=$("#kontrak").find('option:selected').data('contractid') 
      
        $.ajax({
                url: baseUrl + '/get-data-mitra-kontrak/'+mitra+'/'+contractid,                           
                type: 'get',
                timeout: 10000,                
                dataType: 'json',                
                success: function (response) {                                        
                    if(response.status=='berhasil'){                        
                        $('#tglKontrak').val(response.data.mc_date);
                        $('#tglBatas').val(response.data.mc_expired);
                        $('#perusahaan').val(response.data.c_name);
                        $('#mitra').val(response.data.m_name);
                        $('#jumlahPekerja').val(response.data.mc_need);                        
                        $('.sembunyikan').css('display','');
                        $('#perusahaan').data('perusahaan',response.data.mc_comp); 
                        $('#mitra').data('input-mitra',response.data.mc_mitra); 
                        
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
                }
            });
    }
        
    function simpan() {        
        var perusahaan = $('#perusahaan').data('perusahaan');
        var inputmitra = $('#mitra').data('input-mitra');        
        var buttonLadda = $('.simpan').ladda();
        buttonLadda.ladda('start');                
//        if (validateForm()) {
            $.ajax({
                url: baseUrl + '/manajemen-pekerja-mitra/data-pekerja-mitra/simpan',
                // type        : 'post',            
                type: 'get',
                timeout: 10000,
                data: $('#form-mitra-contract').serialize()
                        +'&'+table.$(':input').serialize()
                        +'&mitra='+inputmitra
                        +'&perusahaan='+perusahaan,
                dataType: 'json',                
                success: function (response) {
                    if (response.status == 'berhasil') {
                        window.location = baseUrl + '/manajemen-pekerja-mitra/data-pekerja-mitra';
                    } else if (response.status == 'gagal') {
                        info.css('display', '');
                        $.each(response.data, function (index, error) {
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
//        } else {
//            buttonLadda.ladda('stop');
//        }
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