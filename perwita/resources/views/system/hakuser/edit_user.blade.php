@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Form Manajemen User</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;System&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Manajemen User</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Manajemen User&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Manajemen User</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                          <div id="alert-tab" class="tab-pane fade in active">
                          <div class="row">
                          
                         <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
                           <div class="col-md-5 col-sm-6 col-xs-8" >
                             <h4>Form Manajemen User</h4>
                           </div>
                           <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                             <a href="{{ url('system/hakuser/user') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                           </div>
                         

                            <form id="data-user">

                                <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                    
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Username</label>
                                    </div>

                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input id="m_id" type="hidden" class="form-control input-sm disable" name="m_id" value="{{$mem->m_id}}">
                                            <input type="text" class="form-control input-sm disable" name="Username"
                                            value="{{$mem->m_username}}">
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Password</label>
                                    </div>

                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="Password" class="form-control input-sm disable" name="Password">
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Nama Lengkap</label>
                                    </div>

                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-sm disable" name="NamaLengkap"
                                            value="{{$mem->m_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        
                                            <label class="tebal">Tanggal Lahir</label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input class="form-control datepicker2 input-sm disable"  type="text" name="TanggalLahir" value="{{$mem->m_birth_tgl}}">
                                        </div>
                                        
                                    </div>

                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Alamat</label>
                                    </div>

                                    <div class="col-md-9 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <textarea name="alamat" class="form-control disable" value="{{$mem->m_addr}}"></textarea>
                                        </div>
                                    </div>

                                    

                                    

                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        
                                            <label class="tebal">Pilih Akses Grub</label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <select class="form-control input-sm disable" name="groupAkses">
                                                <option value="">-- Pilih Akses Group --</option>
                                                @foreach($group as $data)
                                                    <option 
                                                    @if(count($mem_group)!=0)
                                                        @if ($data->g_id==$mem_group->ma_group)
                                                        selected=""    
                                                        @endif 
                                                    @endif 
                                                    value="{{$data->g_id}}">{{$data->g_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                     <div align="right" style="padding-top:10px;">
                                    <div id="div_button_save" class="form-group">
                                        <button type="button" id="button_save" class="btn btn-primary" onclick="perbaruiDataUser()">Simpan Data</button> 
                                    </div>
                                </div>

                                </div>
                             </form>
<div class="col-md-12"  id="detail"  style="display: ;">
     <label class="tebal">- Hak Akses User</label>

                                
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
                                        
                                        @foreach($mem_access as $index => $data)
                                        
                                        @if($data->a_parrent==0)                                        
                                            <tr style="background: #f7e8e8">    
                                                <td>   
                                                    <input type="hidden" name="id_access[]" value="{{$data->a_id}}">                                            
                                                    {{$nomor}}. &nbsp; <strong>{{$data->a_name}}</strong>
                                                </td>                
                                                <td>  
                                                 <input type="hidden" @if($data->ma_read=='Y')  value="Y" @else 
                                                 value="N" @endif class="checkbox" name="view[]"  id="view-{{$data->a_id}}">
                                                <input type="checkbox" class="checkbox" onchange="simpanView('{{$data->a_id}}')"  id="view1-{{$data->a_id}}">                                              
                                                </td>    
                                                 <td> 
                                                    <input type="hidden" value="N" class="checkbox" name="insert[]" id="insert-{{$data->a_id}}">                                               
                                                </td>
                                                <td>  
                                                    <input type="hidden" value="N" class="checkbox" name="update[]" id="update-{{$data->a_id}}">                                              
                                                </td>
                                                <td> 
                                                     <input type="hidden" value="N" class="checkbox" name="delete[]" id="delete-{{$data->a_id}}">                                               
                                                </td>
                                                <td> 
                                                     <input type="hidden" value="N" class="checkbox" name="laporan[]" id="laporan-{{$data->a_id}}">                                               
                                                </td>
                                                <td>                                                

                                                     <input type="hidden" value="N" class="checkbox" name="unlock[]" id="unlock-{{$data->a_id}}">
                                                      <input type="hidden" name="status[]" id="status-{{$data->a_id}}" value="0"> 

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
                                                <input type="checkbox" class="checkbox" onchange="simpanView('{{$data->a_id}}')"  id="view1-{{$data->a_id}}"  @if($data->ma_read=='Y') checked="" @endif>
                                                 <input type="hidden" @if($data->ma_read=='Y')  value="Y" @else 
                                                 value="N" @endif  name="view[]"  id="view-{{$data->a_id}}"> 
                                                </td>
                                                <td class="text-center">
                                                <input type="checkbox" class="checkbox"  onchange="simpanInsert('{{$data->a_id}}')" id="insert1-{{$data->a_id}}"
                                                    @if($data->ma_insert=='Y') checked="" @endif>

                                            <input type="hidden" @if($data->ma_insert=='Y')  value="Y" @else 
                                                 value="N" @endif  name="insert[]"  id="insert-{{$data->a_id}}"> 
                                                </td>
                                                <td class="text-center">
                                                <input type="checkbox" class="checkbox" onchange="simpanUpdate('{{$data->a_id}}')" id="update1-{{$data->a_id}}"
                                                    @if($data->ma_update=='Y') checked="" @endif>

                                                <input type="hidden" @if($data->ma_update=='Y')  value="Y" @else 
                                                 value="N" @endif  name="update[]"  id="update-{{$data->a_id}}">
                                                </td>
                                                <td class="text-center">
                                                <input type="checkbox" class="checkbox" onchange="simpanDelete('{{$data->a_id}}')" id="delete1-{{$data->a_id}}"
                                                    @if($data->ma_delete=='Y') checked="" @endif>

                                                <input type="hidden" @if($data->ma_delete=='Y')  value="Y" @else value="N" @endif  name="delete[]"  id="delete-{{$data->a_id}}">

                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="checkbox" name="laporan[]" onchange="simpanLaporan('{{$data->a_id}}')" id="laporan-{{$data->a_id}}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="checkbox" name="Unlock[]" onchange="simpanUnlock('{{$data->a_id}}')" value="1" id="Unlock-{{$data->a_id}}">
                                                     <input type="hidden" name="status[]" id="status-{{$data->a_id}}" value="0"> 
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
@section("extra_scripts")
<script type="text/javascript"> 
      function perbaruiDataUser(){
        var m_id=$('#m_id').val();        
        var dataUser=$('#data-user :input').serialize();
        var dataDetail=$('#data-detail :input').serialize();
         $.ajax({
                    url         : baseUrl+'/system/hakuser/perbarui-user/perbarui-user/'+m_id,
                    type        : 'get',
                    timeout     : 10000,  
                    data        : dataUser+'&'+dataDetail,
                    dataType    :'json',
                    success     : function(response){
                            if(response.status=='sukses'){
                                 window.location = baseUrl+'/system/hakuser/user';
                            }
                        }
                    });
      }
          function simpanView(id){                            
        $('#status-'+id).val(1);

        if ($('#view1-'+id).prop('checked')) {            
            $('#view-'+id).val('Y')
        } else {
            $('#view-'+id).val('N')            
        }
     }

  function simpanInsert(id){    
  $('#status-'+id).val(1);                    
        if ($('#insert1-'+id).prop('checked')) {
               $('#insert-'+id).val('Y')
        } else {
            $('#insert-'+id).val('N')            
        }
     }
       

function simpanUpdate(id){           
    $('#status-'+id).val(1);
        if ($('#update1-'+id).prop('checked')) {
            $('#update-'+id).val('Y')
        } else {
            $('#update-'+id).val('N')            
        }
     }

     function simpanDelete(id){    

     $('#status-'+id).val(1);                          
        if ($('#delete1-'+id).prop('checked')) {
          $('#delete-'+id).val('Y')
        } else {
            $('#delete-'+id).val('N')            
        }
     }
       
       

$(document).ready(function() {
    var extensions = {
         "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    $('#data').dataTable({
          "responsive":true,
          
          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                 }
          }

        });
    $('#data2').dataTable({
          "responsive":true,

          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                 }
          }

        });
    $('#data3').dataTable({
          "responsive":true,

          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                 }
          }

        });
});

      $("#perusahaan").load("/master/datasuplier/tambah_suplier", function(){
      $("#perusahaan").focus();
      });
      $('.datepicker2').datepicker({
        format:"dd-mm-yyyy",
        endDate:'0d'
      });
</script>
@endsection                            
