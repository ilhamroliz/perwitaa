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
                <h5>Manajemen Group</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>                                                                                            
                </div>
        </div>  
        <div class="ibox-content">
            <div class="row m-b-lg ">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button onclick="tambah()" class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>                            
                            {{--<button class="btn btn-info " type="button"><i class="fa fa-paste"></i> Ubah</button>
                            <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i> Hapus</button>--}}
                        </div>
                        <br>
                    </div>
                    
                    <div id="detail-group">

                    </div>

                </div>
            </div>
        </div>
    
</div>



@endsection

@section('extra_scripts')
<script type="text/javascript">
    //$('#example').dataTable();
    function tambah(){        
           window.location = baseUrl+'/manajemen-hak-akses/group/tambah';
        }
    
    detailGroup();
    function detailGroup() {
        var id_group = $('.id-group').val();
        var detail_group = $('#detail-group');
        
        $.ajax({
            url: baseUrl + '/manajemen-hak-akses/group-detail',
            type: 'get',
            timeout: 10000,            
            //dataType: 'json',
            success: function (response) {
                detail_group.html(response);
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
</script>
@endsection