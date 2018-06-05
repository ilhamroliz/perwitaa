@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    .huruf{
         text-transform: capitalize;
    }
</style>

@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Form Edit Data Akses Group</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>                                                                                            
                            </div>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-striped table-borderred formProfil">
                                <tr>                                                                    
                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <th style="width:15%">Nama Group</th>
                                    <td><input value="{{$aksesGroup[0]->g_name}}" type="text" class="form-control huruf" name="Nama Group" placeholder="Nama Group"></td>
                                    <td><input value="{{$aksesGroup[0]->g_id}}" type="text" class="form-control huruf" name="Id Group" placeholder="Id Group"></td>
                                </tr>                                                             
                            </table>
                            <h3>Detail Akses Group</h3>
                            <table class="table table-striped table-borderred formProfil">
                                <thead>
                                    <tr> 
                                        <th style="width:15%">No</th>
                                        <th style="width:15%">Nama Menu</th>
                                        <th style="width:15%">Level 1</th>
                                        <th style="width:15%">Level 2</th>
                                        <th style="width:15%">Level 3</th>                                    
                                    </tr>                                                             
                                </thead>
                                <tbody>
                                    @foreach($aksesGroup as $index => $data)
                                    <tr>
                                        <input type="hidden" name="jumlah[]" value="1">
                                        <td>{{$index+1}}</td>
                                        <td>
                                            <input type="hidden" name="menu{{$index}}" value="{{$data->a_id}}" class="form-control">
                                            {{$data->a_type}}</td>                                                                                
                                        <td>
                                            <label><input  id="radio1" type="checkbox" name="level{{$index}}" value="1" @if($data->ga_level=='1') checked="" @endif> &nbsp;Lihat</label>
                                        </td>
                                        <td>
<label><input  id="radio1" type="checkbox" name="level{{$index}}" value="2" @if($data->ga_level=='2') checked="" @endif>&nbsp; Lihat, Edit</label>
                                        </td>
                                        <td>
<label><input  id="radio1" type="checkbox" name="level{{$index}}" value="3" @if($data->ga_level=='3') checked="" @endif>&nbsp; Lihat, Tambah, Edit, Hapus</label>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                            
                             <button type="button" class="ladda-button  perbarui  btn btn-primary  m-b btn-flat" data-style="zoom-in" onclick="tambah()">
                                    <span class="ladda-label">Perbarui</span><span class="ladda-spinner"></span>
                                </button>
                                <a href="{{URL::to('/')}}/profil" class="ladda-button  batalkan  btn btn-primary  m-b btn-flat" data-style="zoom-in">
                                    <span class="ladda-label">Batalkan</span><span class="ladda-spinner"></span>
                                </a>
                             
                        </div>
                    </div>
                </div>
            </div>
</div>      



@endsection

@section('extra_scripts')
<script type="text/javascript">
    
$('input[type="checkbox"]').on('change', function() {
    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
});
    
    
function tambah(){
             var buttonLadda = $('.perbarui').ladda();
                buttonLadda.ladda('start');
                $.ajax({
                    url         : baseUrl+'/manajemen-hak-akses/group/simpan',
                    //type        : 'post',
                    type        : 'get',
                    timeout     : 10000,
                    data        : $('.formProfil :input').serialize(),
                    dataType    : 'json',
                    success     : function(response){                                                
                       if(response.status=='berhasil'){
                           window.location = baseUrl+'/profil';
                       }
                    },
                    error       : function(xhr, status){
                        if(status == 'timeout'){
                            $('.error-load').css('visibility', 'visible');
                            $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                        }
                        else if(xhr.status == 0){
                            $('.error-load').css('visibility', 'visible');
                            $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                        }
                        else if(xhr.status == 500){
                            $('.error-load').css('visibility', 'visible');
                            $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                        }

                        buttonLadda.ladda('stop');
                    }
                });

            
        
    
    
}
</script>
@endsection