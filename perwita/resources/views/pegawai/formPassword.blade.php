@extends('main')

@section('title', 'Data Pegawai')

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
                            <h5>Form Ubah Kata Sandi</h5>
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
                                    <th style="width:15%">Kata Sandi Lama</th>
                                    <td><input type="password" class="form-control huruf" name="Kata Sandi Lama" placeholder="Kata Sandi Lama"></td>
                                </tr>
                                <tr>
                                    <th>Kata Sandi Baru</th>
                                    <td><input type="password" class="form-control huruf" name="Kata Sandi Baru" placeholder="Kata Sandi Baru"></td>
                                </tr>
                                <tr>
                                    <th>Konfirmasi Kata Sandi</th>
                                    <td><input type="password" class="form-control huruf " name="Konfirmasi Kata Sandi" placeholder="Konfirmasi Kata Sandi"></td>
                                </tr>
                                <tr style="border-top: 1px solid #ff0033">
                                    <th></th>
                                    <td>
                                <button type="button" class="ladda-button  perbarui  btn btn-primary  m-b btn-flat" data-style="zoom-in" onclick="perbarui()">
                                    <span class="ladda-label">Perbarui</span><span class="ladda-spinner"></span>
                                </button>
                                <a href="{{URL::to('/')}}/profil" class="ladda-button  batalkan  btn btn-primary  m-b btn-flat" data-style="zoom-in">
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
function perbarui(){
             var buttonLadda = $('.perbarui').ladda();
                buttonLadda.ladda('start');
                $.ajax({
                    url         : baseUrl+'/profil/perbarui-password',
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
