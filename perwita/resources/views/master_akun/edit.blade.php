@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
                    <h5>Data Pegawai</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
    </div>
    <div class="ibox">
        <div class="ibox-content">
               
            
            {{ Form::open([ 'id'=>'createAkun', 'files' => true]) }}            
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-2" >Tahun Akun</label>
                            <div class="col-sm-8">
                                <input readonly="" type="number" class="form-control" id="tahunakun" name="Tahun Akun" placeholder="Tahun Akun" value="{{$comp_coas->coa_year}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Kode Akun</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="coa_code" name="Kode Akun" placeholder="Kode Akun" value="{{$comp_coas->coa_code}}" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Nama Akun</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="coa_code" name="Nama Akun" placeholder="Nama Akun" value="{{$comp_coas->coa_name}}">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Tanggal Pembukaan Akun</label>
                            <div class="col-sm-8">                                
                                <input type="text" class="form-control" id="coa_opening_tgl" placeholder="Masukkan Tanggal Pembukaan Akun" name="Coa_Opening_Tgl" value="{{Carbon\Carbon::parse($comp_coas->coa_opening_tgl)->format('d-M-Y')}}" readonly="">                                
                            </div>
                        </div> 
                        @if(count($chekCoaParrent)==0)
                        <div class="form-group">
                            <label class="control-label col-sm-2" >Pembukaan Akun</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control saldo" id="pembukaan_akun" name="Pembukaan Akun" placeholder="Masukkan Pembukaan Akun" value="{{$comp_coas->coa_opening}}">
                            </div>
                        </div>
                        @else
                        <div class="form-group">
                            <label class="control-label col-sm-2" >Pembukaan Akun</label>
                            <div class="col-sm-8">
                                <input readonly="" type="number" class="form-control" id="pembukaan_akun" name="Pembukaan Akun" placeholder="Masukkan Pembukaan Akun" value="{{$comp_coas->coa_opening}}">
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-12" style="margin:10px; border-bottom: 2px solid #efefef; padding:0px;">
                        <div class="col-md-3" style="padding:0px;">

                        </div>
                        <div class="col-md-5 image-holder" style="padding:0px; padding-bottom: 20px;">

                        </div>
                    </div>

                    <div class="col-md-offset-9" style="padding-top:10px;">
                        <div class="form-group">
                        <a href="{{ url('data-master/master-akun') }}" class="btn btn-danger btn-flat btn-sm">Kembali</a>
                        <button type="button" class="btn btn-success btn-flat btn-sm tampilkan" onclick="update()">Perbarui Data</button>
                        </div>
                    </div>            
            {{ Form::close() }}

                    
            
            
            
        
            
        </div>
    </div>
</div>



@endsection

@section('extra_scripts')
<script type="text/javascript">
    
    var info = $('.pesan');
    $('#coa_opening_tgl').datepicker({
        format: 'dd-M-yyyy',
    }).datepicker("setDate", "0");
    

    
    



  function update(){    
        info.hide().find('ul').empty();        
        $.ajax({
            type: "get",
            dataType: 'json',
            url: baseUrl + '/manajemen-akun/data-akun/update/'+$('#coa_code').val(),
            data: $('#createAkun').serialize(),
            success: function (response) {                                
                if (response.status == 'sukses') {
                    swal({
                        title: "Berhasil!",
                        type: 'success',
                        text: "Data berhasil diupdate",
                        timer: 800,
                        showConfirmButton: false
                    }, function () {
                       window.location.href = baseUrl + '/manajemen-akun/data-akun'
                    });
                    //setDetailData($('.p_id').val());  

                }
               else if (response.status == 'error') {
                    $.each(response.data, function (index, error) {
                        info.find('ul').append('<li>' + error + '</li>');
                    });
                    info.slideDown();
                    info.fadeTo(2000, 500).slideUp(500, function () {
                        info.hide().find('ul').empty();
                    });
                }
            }
        });  
  }
</script>
@endsection















