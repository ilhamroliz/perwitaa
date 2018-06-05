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
                <div id="reload">  
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Harta</a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse">
                                    <div class="panel-body no-padding">
                                        <table id="harta" class="table table-bordered">
                                            <thead>
                                                <tr>  
                                                    <th width="150px">Kode Akun</th>
                                                    <th> Nama Akun</th>         
                                                    <th> Pembukaan Akun</th>    
                                                    <th class="text-center"> Action</th>                                                                                                                                        
                                                </tr> 
                                            </thead > 
                                            <tbody>
                                                @foreach($harta as $modal)
                                                @if($modal->coa_level!=1)
                                                <tr id="hapus{{$modal->coa_code}}">                                    
                                                    <td @if($modal->coa_level==2)  @elseif($modal->coa_level==3)style="padding-left: 20px;" @elseif($modal->coa_level==4)style="padding-left: 40px;" @endif>{{$modal->coa_code}}</td>
                                                    <td data-indent="0">{{$modal->coa_name}}</td>
                                                    <td class="text-right"> {{ number_format($modal->coa_opening,2,',','.') }} </td>
                                                    <td class="text-center">
                                                        <div class="dropdown">                                
                                                            <button class="btn btn-primary btn-flat btn-xs dropdown-toggle tampilkan" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                Kelola
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                                <li><a href="{{url('manajemen-akun/data-akun/sub_akun/'.$modal->coa_code) }}"><i class="fa fa-plus" aria-hidden="true"></i>Buat Sub Akun</a></li>
                                                                <li role="separator" class="divider"></li>                                                                        
                                                                <li><a href="{{url('manajemen-akun/data-akun/'.$modal->coa_code.'/edit') }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                                                                <li role="separator" class="divider"></li>                                                                        
                                                                <li><a href="#" onclick="hapusData({{$modal->coa_code}})"><i class="fa fa-trash-o" aria-hidden="true"></i>Hapus Data</a></li>
                                                                {!! Form::open(['method' => 'DELETE', 'action' => ['d_comp_coaController@delete', $modal->coa_code], 'id'=>'delete']) !!}

                                                                {!! Form::close() !!}
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>    
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Kewajiban</a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body no-padding">
                                        <table id="kewajiban" class="table table-bordered">
                                            <thead>
                                                <tr>                  
                                                    <th width="150px">Kode Akun</th>
                                                    <th > Nama Akun</th>    
                                                    <th> Pembukaan Akun</th>    
                                                    <th class="text-center"> Action</th>                                                               
                                                </tr> 
                                            </thead> 
                                            <tbody>
                                                @foreach($kewajiban as $modal)
                                                @if($modal->coa_level!=1)
                                                <tr id="hapus{{$modal->coa_code}}">                                    
                                                    <td @if($modal->coa_level==2)  @elseif($modal->coa_level==3)style="padding-left: 20px;" @elseif($modal->coa_level==4)style="padding-left: 40px;" @endif>{{$modal->coa_code}}</td>
                                                    <td data-indent="0">{{$modal->coa_name}}</td>
                                                    <td class="text-right"> {{ number_format($modal->coa_opening,2,',','.') }} </td>
                                                    <td class="text-center">
                                                        <div class="dropdown">                                
                                                            <button class="btn btn-primary btn-flat btn-xs dropdown-toggle tampilkan" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                Kelola
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                                <li><a href="{{url('manajemen-akun/data-akun/sub_akun/'.$modal->coa_code) }}"><i class="fa fa-plus" aria-hidden="true"></i>Buat Sub Akun</a></li>
                                                                <li role="separator" class="divider"></li>                                                                        
                                                                <li><a href="{{url('manajemen-akun/data-akun/'.$modal->coa_code.'/edit') }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                                                                <li role="separator" class="divider"></li>                                                                        
                                                                <li><a href="#" onclick="hapusData({{$modal->coa_code}})"><i class="fa fa-trash-o" aria-hidden="true"></i>Hapus Data</a></li>
                                                                {!! Form::open(['method' => 'DELETE', 'action' => ['d_comp_coaController@delete', $modal->coa_code], 'id'=>'delete']) !!}

                                                                {!! Form::close() !!}
                                                            </ul>
                                                        </div>
                                                    </td>

                                                </tr>        
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Modal</a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="panel-body no-padding">
                                        <table id="modal" class="table table-bordered">
                                            <thead>
                                                <tr>                  

                                                    <th width="150px">Kode Akun</th>
                                                    <th> Nama Akun</th>                                   
                                                    <th> Pembukaan Akun</th>                                   
                                                    <th class="text-center"> Action</th>                                                                                                                                      
                                                </tr> 
                                            </thead> 
                                            <tbody>
                                                @foreach($modals as $modal)
                                                @if($modal->coa_level!=1)
                                                <tr id="hapus{{$modal->coa_code}}">                                   
                                                    <td @if($modal->coa_level==2)  @elseif($modal->coa_level==3)style="padding-left: 20px;" @elseif($modal->coa_level==4)style="padding-left: 40px;" @endif>{{$modal->coa_code}}</td>
                                                    <td data-indent="0">{{$modal->coa_name}}</td>
                                                    <td class="text-right"> {{ number_format($modal->coa_opening,2,',','.') }} </td>
                                                    <td class="text-center">
                                                        <div class="dropdown">                                
                                                            <button class="btn btn-primary btn-flat btn-xs dropdown-toggle tampilkan" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                Kelola
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                                <li><a href="{{url('manajemen-akun/data-akun/sub_akun/'.$modal->coa_code) }}"><i class="fa fa-plus" aria-hidden="true"></i>Buat Sub Akun</a></li>
                                                                <li role="separator" class="divider"></li>                                                                        
                                                                <li><a href="{{url('manajemen-akun/data-akun/'.$modal->coa_code.'/edit') }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                                                                <li role="separator" class="divider"></li>                                                                        
                                                                <li><a href="#" onclick="hapusData({{$modal->coa_code}})"><i class="fa fa-trash-o" aria-hidden="true"></i>Hapus Data</a></li>
                                                                {!! Form::open(['method' => 'DELETE', 'action' => ['d_comp_coaController@delete', $modal->coa_code], 'id'=>'delete']) !!}

                                                                {!! Form::close() !!}
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>            
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
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
     function edit_aset(id){         
                    var html = $(this).text()                     
                    $('.form-'+id).css('display','');
                    $('.text-'+id).css('display','none');
                    $('.form-'+id).focus();                
                    
                     $('.form-'+id).blur(function(){                    
                      $('.form-'+id).css('display','none');
                      $('.text-'+id).css('display','');
                      //alert($('.form-'+id).val());
    $.ajax({
            url: baseUrl + '/master-akun/update-saldo/' + id,
            type: 'get',
            data:{Pembukaan_Akun:$('.form-'+id).val()},
            //dataType: 'json',
            //headers: {'X-XSRF-TOKEN': $_token},
            success: function (response) {
                
            }
    });
                      
                      
                    })
     };
//    

       
            function tambahdata() {
            window.location.href = baseUrl + '/data-master/master-akun/create'
            }
    function hapusData(id) {
    if (confirm('Apakah anda yakin ingin meghapus?')) {
    $.ajax({
    url: baseUrl + '/manajemen-akun/data-akun/delete/' + id,
            type: 'get',
            dataType: 'json',            
            success: function (response) {
            console.log(response);
                

                    if (response.success == 'sukses') {
              swal({
                        title: "Berhasil!",
                        type: 'success',
                        text: "Data Berhasil Disimpan",
                        timer: 800,
                        showConfirmButton: false
                    });
                    $('#302010000').replaceWith('<td style="font-size:12px" class="text-right"><span>' + response.akumulasi + '<span></td>')
                    $('.alertBody').show()
                    $('.alertBody').delay(4000).slideUp(300);
                    $("#hapus" + id).remove();
            } else if (response == 'gagal') {
            $('.alertBody').html('<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                    'Data Akun Sudah Digunakan Pada Master Transaksi' +
                    '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
            }

            }



    });
    }
    }
</script>
@endsection




