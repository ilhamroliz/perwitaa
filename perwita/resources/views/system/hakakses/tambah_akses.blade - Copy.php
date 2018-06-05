@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Form Manajemen Hak Akses</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;System&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Manajemen Hak Akses</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Manajemen Hak Akses&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
                    </ol>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="page-content fadeInRight">
                    <div id="tab-general">
                        <div class="row mbl">
                            <div class="col-lg-12">
                                
                                            <div class="col-md-12">
                                                <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                                                </div>
                                            </div>
                                 
                            <ul id="generalTab" class="nav nav-tabs">
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Manajemen Hak Akses</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                          <div id="alert-tab" class="tab-pane fade in active">
                          <div class="row">
                          
                         <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
                           <div class="col-md-5 col-sm-6 col-xs-8" >
                             <h4>Form Manajemen Hak Akses</h4>
                           </div>
                           <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                             <a href="{{ url('system/hakakses/akses') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                           </div>
                         

                            <form method="POST">

                                <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 5px;padding-top: 20px;margin-bottom: 15px;">
                                    
                                    <div class="col-md-2 col-sm-4 col-xs-12">
                                        <label class="tebal">Nama Group</label>
                                    </div>

                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input id="id-group" type="hidden" class="form-control input-sm" name="id">
                                            <input id="nama-group" type="text" class="form-control input-sm" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                            <div class="form-group">
                                                <button type="button" id="button_save" class="btn btn-primary" onclick="simpanGroup()">Simpan Data</button> 
                                            </div>
                                    </div>

                                    

                                </div>

                                
                                <div class="table-responsive">
                                    <table class="table tabelan table-bordered table-hover" id="data-detail">
                                      <thead>
                                     <tr>                                        
                                        <th>Nama Menu</th>                                        
                                        <th>Lihat</th>                                                                 
                                        <th>Tambah</th>                                                               
                                        <th>Perbarui</th>                                                             
                                        <th>Hapus</th>
                                        <th>Laporan</th>
                                        <th>Unlock</th>
                                    </tr>
                                    </thead>
                                      <tbody>
                                        @php
                                            $nomor=1;
                                        @endphp    
                                        
                                        @foreach($access as $index => $data)
                                        
                                        @if($data->a_parrent==0)                                        
                                            <tr style="background: #f7e8e8">    
                                                <td>                                                
                                                    {{$nomor}}. &nbsp; <strong>{{$data->a_name}}</strong>
                                                </td>                
                                                <td class="text-center">
                                                <td> 
                                                <input type="checkbox" class="checkbox" name="view[]" onchange="simpanView('{{$data->a_id}}')"  id="view-{{$data->a_id}}">
                                                </td>   
                                                <td>                                                
                                                </td>
                                                <td>                                                
                                                </td>
                                                <td>                                                
                                                </td>
                                                <td>                                                
                                                </td>
                                                <td>                                                
                                                </td>                                                                       
                                                    @php
                                                        $nomor++;
                                                    @endphp    
                                                </tr>
                                            @else
                                            <tr>    
                                                <td>
                                                <input type="hidden" name="id_access[]" value="{{$data->a_id}}">  
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$data->a_name}}
                                                </td>                                                
                                                <td class="text-center">

                                                <input type="checkbox" class="checkbox" name="view[]" onchange="simpanView('{{$data->a_id}}')"  id="view1-{{$data->a_id}}">
                                                <input type="text" class="checkbox" name="view[]"  id="view-{{$data->a_id}}">

                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="checkbox" name="insert[]" onchange="simpanInsert('{{$data->a_id}}')" id="insert-{{$data->a_id}}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="checkbox" name="update[]" onchange="simpanUpdate('{{$data->a_id}}')" id="update-{{$data->a_id}}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="checkbox" name="delete[]" onchange="simpanDelete('{{$data->a_id}}')" id="delete-{{$data->a_id}}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="checkbox" name="laporan[]" onchange="simpanLaporan('{{$data->a_id}}')" id="laporan-{{$data->a_id}}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="checkbox" name="Unlock[]" onchange="simpanUnlock('{{$data->a_id}}')" value="1" id="Unlock-{{$data->a_id}}">
                                                </td>
                                            </tr>
                                            @endif
                                            
                                        
                                       @endforeach
                                      </tbody>
                                    </table>
                                </div>

                               
                                                         
                            </form>
                        </div>
                                                             
                    </div>
                        </div>
                                
                                    </div>
                                         </div>
                            </div>
                            
@endsection
@section("extra_scripts")
<script type="text/javascript">


   function simpanGroup(){
    var namaGroup=$('#nama-group').val();
         $.ajax({
                    url         : baseUrl+'/system/hakakses/tambah_akses-group/simpan-group',
                    type        : 'get',
                    timeout     : 10000,  
                    data        :{'namaGroup':namaGroup},
                    dataType    :'json',
                    success     : function(response){
                            if(response.status=='sukses'){
                                $('#id-group').val(response.g_id);
                                $('#id-group').attr('readonly','readonly');
                                $('#nama-group').attr('readonly','readonly');
                            }

                        }
                    });
     }

     function simpanView(id){                   
        var g_id =$('#id-group').val();
        var nilai = 0;        
        if ($('#view1-'+id).prop('checked')) {            
            $('#view-'+id).val('Y')
        } else {
            $('#view-'+id).val('N')            
        }
       /* var value = {
            g_id : g_id,
            id_access: id,
            keterangan: 'ga_read',
            nilai: nilai,            
        };*/

            
            
         
            /* $.ajax({
                    url         : baseUrl+'/system/hakakses/tambah_akses-group/simpan-group-detail',
                    type        : 'get',
                    timeout     : 10000,  
                    data        : value,
                    dataType    :'json',
                    success     : function(response){
                            if(response.status=='sukses'){
                                $('#id-group').val(response.g_id)
                            }
                        }
                    });*/
     }

  function simpanInsert(id){           
        var g_id =$('#id-group').val();
        var nilai = 0;        
        if ($('#insert-'+id).prop('checked')) {
            nilai = 'Y';
        } else {
            nilai = 'N';
        }
        var value = {
            g_id : g_id,
            id_access: id,
            keterangan: 'ga_insert',
            nilai: nilai,            
        };

            var data = $('#data-detail :input').serialize();   
            var g_id =$('#id-group').val();
         
             $.ajax({
                    url         : baseUrl+'/system/hakakses/tambah_akses-group/simpan-group-detail',
                    type        : 'get',
                    timeout     : 10000,  
                    data        : value,
                    dataType    :'json',
                    success     : function(response){
                            if(response.status=='sukses'){
                                $('#id-group').val(response.g_id)
                            }
                        }
                    });
     }
       

function simpanUpdate(id){           
        var g_id =$('#id-group').val();
        var nilai = 0;        
        if ($('#update-'+id).prop('checked')) {
            nilai = 'Y';
        } else {
            nilai = 'N';
        }
        var value = {
            g_id : g_id,
            id_access: id,
            keterangan: 'ga_update',
            nilai: nilai,            
        };

           
            var g_id =$('#id-group').val();
         
             $.ajax({
                    url         : baseUrl+'/system/hakakses/tambah_akses-group/simpan-group-detail',
                    type        : 'get',
                    timeout     : 10000,  
                    data        : value,
                    dataType    :'json',
                    success     : function(response){
                            if(response.status=='sukses'){
                                $('#id-group').val(response.g_id)
                            }
                        }
                    });
     }

     function simpanDelete(id){                   
        var g_id =$('#id-group').val();
        var nilai = 0;        
        if ($('#delete-'+id).prop('checked')) {
            nilai = 'Y';
        } else {
            nilai = 'N';
        }
        var value = {
            g_id : g_id,
            id_access: id,
            keterangan: 'ga_delete',
            nilai: nilai,            
        };

           
            var g_id =$('#id-group').val();
         
             $.ajax({
                    url         : baseUrl+'/system/hakakses/tambah_akses-group/simpan-group-detail',
                    type        : 'get',
                    timeout     : 10000,  
                    data        : value,
                    dataType    :'json',
                    success     : function(response){
                            if(response.status=='sukses'){
                                $('#id-group').val(response.g_id)
                            }
                        }
                    });
     }
</script>
@endsection                            
