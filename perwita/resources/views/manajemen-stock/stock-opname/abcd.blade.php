@extends('main')

@section('title', 'dashboard')

@section('extra_styles')

<style>th.dt-center, td.dt-center { text-align: center; }</style>


@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Stock Opname </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                          <a>Manajemen Stock</a>
                        </li>
                        <li class="active">
                            <strong> Stock Opname </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Stock Opname
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="col-md-10 col-sm-10 col-xs-10" style="padding-bottom: 10px;">
                  <div class="form-group">
                   <h3 class="col-lg-2">Pilih Item :</h3>
                    <div class="col-lg-4">
                       <select class="form-control chosen-select-width" name="barang" style="width:300px; cursor: pointer;" id="barang">
                            <option value="null" selected disabled>--Pilih Seragam--</option>
                        @foreach($databarang as $seragam)
                            <option value="{{ $seragam->i_id }}">  {{ $seragam->i_nama }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-lg-2">
                      <button class="btn btn-info btn-md btn-flat " type="button" id="opname">Lakukan Opname</button>
                    </div>
                  </div>
                </div>
                <div class="box-body">
                
                  <table id="addColumn1" class="table table-bordered table-striped tabel_opname1">
                      <thead>
                           <tr>
                              <th style="text-align : center;"> ID </th>
                              <th style="text-align : center;"> PEMILIK </th>
                              <th style="text-align : center;"> TANGGAL </th>
                              <th style="text-align : center;"> STATUS </th>
                              <th style="text-align : center;"> NOTA </th>
                              <th style="text-align : center;"> AKSI </th>
                          </tr>
                          </thead>
                      <tbody>
                      </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="modal inmodal" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-pencil modal-icon"></i>
                                <h4 class="modal-title">Insert Stock Opname</h4>
                            </div>
                            <div class="modal-body">
                                <h3 id="nota-insert"></h3>
                                <form class="form-horizontal">
                                   <table id="addColumn" class="table table-bordered table-striped tabel_opname">

                                   </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button onclick="simpan()" class="btn btn-primary" type="button">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal inmodal" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-pencil-square-o modal-icon"></i>
                                <h4 class="modal-title">Edit Stock Opname</h4>
                            </div>
                            <div class="modal-body">
                                <h3 id="nota_edit"></h3>
                                <form class="form-horizontal">
                                   <table id="tabel_edit" class="table table-bordered table-striped tabel_edit">

                                   </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button onclick="edit()" class="btn btn-primary" type="button">Save Change</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal inmodal" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-folder-open modal-icon"></i>
                                <h4 class="modal-title">Detail Stock Opname</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-lg-2">
                                      <h3>Pemilik  </h3>
                                    </div>
                                    <div class="col-lg-1">
                                      <h3>:</h3>
                                    </div>
                                    <div class="col-lg-9">
                                      <h3 id="pemilik_opname">-</h3>
                                    </div>
                                    <div class="col-lg-2">
                                      <h3>Tanggal  </h3>
                                    </div>
                                    <div class="col-lg-1">
                                      <h3>:</h3>
                                    </div>
                                    <div class="col-lg-9">
                                      <h3 id="tanggal_opname">-</h3>
                                    </div>
                                    <div class="col-lg-2">
                                      <h3>Status  </h3>
                                    </div>
                                    <div class="col-lg-1">
                                      <h3>:</h3>
                                    </div>
                                    <div class="col-lg-9">
                                      <h3 id="status_opname">-</h3>
                                    </div>
                                    <div class="col-lg-2">
                                      <h3>Nota  </h3>
                                    </div>
                                    <div class="col-lg-1">
                                      <h3>:</h3>
                                    </div>
                                    <div class="col-lg-9">
                                      <h3 id="nota_opname">-</h3>
                                    </div>
                                </div>
                                <form class="form-horizontal">
                                   <table id="tabel_detail" class="table table-bordered table-striped tabel_detail">

                                   </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                              <div class="btn-group">
                                <a href="#" class="btn btn-white btn-md">Batal</a>
                                <a href="#" class="btn btn-primary btn-md">Execute</a>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
$(document).ready(function() {

      $('[data-toggle="tooltip"]').tooltip();

      $('#addColumn1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "ajax": {
              "url" :  baseUrl + "/manajemen-stock/stock-opname/tabel",
              "type": "GET"
            },
            "columnDefs": [
              {"className": "dt-center", "targets": "_all"}
            ],
            "columns": [
            { "data": "so_id" },
            { "data": "c_name" },
            { "data": "so_date" },
            { "data": "so_status" },
            { "data": "so_nota" },
            { "data": "button" },
            ]
        });

      

      $(document).on('click','#opname',function(){

      $("#modal").modal("show");
      var kodebarang = $('#barang').val();

        $.ajax({
          data: {barang : kodebarang}, 
          type: "GET",
          url : baseUrl + "/manajemen-stock/stock-opname/opname",
          dataType:'json',
          success: function(data)
          {   
            var mydata = '<thead>'
                           +'<tr>'
                              +'<th style="text-align : center; padding: 15px"> NAMA BARANG</th>'
                              +'<th style="text-align : center; padding: 15px"> STOCK SISTEM </th>'
                              +'<th style="text-align : center; padding: 15px"> REAL STOCK </th>'
                              +'<th style="text-align : center;"> SESUAIKAN SISTEM</th>'
                              +'<th style="text-align : center;"> SESUAIKAN REAL</th>'
                          +'</tr>'
                          +'</thead>'
                          +'<tbody>';
            var nota;

            $.each(data, function(i,n){
                  mydata = mydata + '<tr>'
                                      +'<td>'+n.i_nama+'-'+'('+n.s_nama+')'
                                      +'<input type="hidden" name="item[]"   value="'+n.s_item+'" />'
                                      +'<input type="hidden" name="item_dt[]"  value="'+n.s_item_dt+'" />'
                                      +'<input type="hidden" name="s_comp[]"  value="'+n.s_comp+'" />'
                                      +'<input type="hidden" name="nota[]"  value="'+n.hidden+'" />'
                                      +'</td>'
                                      +'<td><input type="text" class="form-control" name="stocksistem[]"  readonly value="'+n.s_qty+'"></td>'
                                      +'<td><input type="number" min="0" placeholder="0" class="form-control stockreal" name="stockreal[]" minlength="1" data-parsley-type="integer"></td>'
                                      +'<td style="vertical-align: middle; text-align: center;"><input style="width : 20px; heigth : 20px; display: inline-block;" class="checkbox checkbox-primary" type="checkbox" name="sesuaikan['+i+']" id="id_sesuaikan1['+i+']" onClick="ckChange(this)" value="Sesuai Sistem"></td>'
                                      +'<td style="vertical-align: middle; text-align: center;"><input style="width : 20px; heigth : 20px; display: inline-block;" class="checkbox checkbox-primary" type="checkbox" name="sesuaikan['+i+']" id="id_sesuaikan2['+i+']" onClick="ckChange(this)" value="Sesuai Real"></td>'
                                  +'</tr>';
                  nota = n.hidden; 

            });
                  mydata = mydata +'</tbody>'; 

            $('#addColumn').html(mydata);
            $('#nota-insert').html("Nota : "+nota);
          }
      })

    }); 

  
  $(document).on('click','.edit',function(){
      $("#modal-edit").modal("show");

      var id=$(this).attr("id");
      var value = {
            id: id
        };

      $.ajax({
          data: {id : value}, 
          type: "GET",
          url : baseUrl + "/manajemen-stock/stock-opname/get_data",
          dataType:'json',
          success: function(data)
          {   
            var mydata = '<thead>'
                           +'<tr>'
                              +'<th style="text-align : center;"> NAMA BARANG </th>'
                              +'<th style="text-align : center;"> STOCK SISTEM </th>'
                              +'<th style="text-align : center;"> REAL STOCK </th>'
                              +'<th style="text-align : center;"> SESUAIKAN SISTEM </th>'
                              +'<th style="text-align : center;"> SESUAIKAN REAL </th>'
                          +'</tr>'
                          +'</thead>'
                          +'<tbody>';
            var id_opname, pemilik, tanggal, status, nota;

            $.each(data, function(i,n){
                  var keterangan = n.so_keterangan;
                  mydata = mydata + '<tr>'
                                      +'<td>'+n.i_nama+'-'+'('+n.s_nama+')'
                                      +'<input type="hidden" name="so_detailid[]" value="'+n.so_detailid+'" />'
                                      +'<input type="hidden" name="so_stock_opname[]" value="'+n.so_stock_opname+'" />'
                                      +'</td>'
                                      +'<td><input type="text" class="form-control" name="so_qty_sistem[]"  readonly value="'+n.so_qty_sistem+'"></td>'
                                      +'<td><input type="number" min="0" placeholder="0" class="form-control stockreal" name="so_qty_real[]" value="'+n.so_qty_real+'" minlength="1" data-parsley-type="integer"></td>'
                                      ;

                                      if(keterangan == "Sesuai Sistem"){
                                        mydata = mydata +'<td style="vertical-align: middle; text-align: center;"><input style="width : 20px; heigth : 20px; display: inline-block;" class="checkbox checkbox-primary" type="checkbox" checked="" name="sesuaikan_edit['+i+']" id="id_sesuaikan1_edit['+i+']" onClick="ckChange(this)" value="Sesuai Sistem"></td>'
                                                        +'<td style="vertical-align: middle; text-align: center;"><input style="width : 20px; heigth : 20px; display: inline-block;" class="checkbox checkbox-primary" type="checkbox" disabled = "true" name="sesuaikan_edit['+i+']" id="id_sesuaikan2_edit['+i+']" onClick="ckChange(this)" value="Sesuai Real"></td>'
                                                        +'</tr>';
                                      }
                                      else if(keterangan == "Sesuai Real"){
                                        mydata = mydata +'<td style="vertical-align: middle; text-align: center;"><input style="width : 20px; heigth : 20px; display: inline-block;" class="checkbox checkbox-primary" type="checkbox" disabled = "true" name="sesuaikan_edit['+i+']" id="id_sesuaikan1_edit['+i+']" onClick="ckChange(this)" value="Sesuai Sistem"></td>'
                                                        +'<td style="vertical-align: middle; text-align: center;"><input style="width : 20px; heigth : 20px; display: inline-block;" class="checkbox checkbox-primary" type="checkbox" checked="" name="sesuaikan_edit['+i+']" id="id_sesuaikan2_edit['+i+']" onClick="ckChange(this)" value="Sesuai Real"></td>'
                                                        +'</tr>';
                                      }

                  // id_opname = n.so_id;
                  // pemilik = n.c_name;
                  // tanggal = n.so_date;
                  // status = n.so_status;
                  nota = n.so_nota; 

            });
                  mydata = mydata +'</tbody>'; 

            $('#tabel_edit').html(mydata);
            //$('#id_opname').html(id_opname);
            // $('#tanggal_opname').html(tanggal);
            // $('#pemilik_opname').html(pemilik);
            // $('#status_opname').html(status);
            $('#nota_edit').html("NOTA : "+nota);
          }
      })
   });

  $("#barang").chosen();

});
    
   

   $(document).on('click','.detail',function(){
      var id=$(this).attr("id");
        var value = {
            id: id
        };
      $("#modal-detail").modal("show");

      $.ajax({
          data: {id : value}, 
          type: "GET",
          url : baseUrl + "/manajemen-stock/stock-opname/detail",
          dataType:'json',
          success: function(data)
          {   
            var mydata = '<thead>'
                           +'<tr>'
                              +'<th style="text-align : center;"> NAMA BARANG </th>'
                              +'<th style="text-align : center;"> STOCK SISTEM </th>'
                              +'<th style="text-align : center;"> REAL STOCK </th>'
                              +'<th style="text-align : center;"> KETERANGAN </th>'
                          +'</tr>'
                          +'</thead>'
                          +'<tbody>';
            var id_opname, pemilik, tanggal, status, nota;

            $.each(data, function(i,n){
                  mydata = mydata + '<tr>'
                                      +'<td style="text-align : left;">'+n.i_nama+'-'+'('+n.s_nama+')'
                                      +'</td>'
                                      +'<td style="text-align : center;">'+n.so_qty_sistem+'</td>'
                                      +'<td style="text-align : center;">'+n.so_qty_real+'</td>'
                                      +'<td style="text-align : center;">'+n.so_keterangan+'</td>'
                                  +'</tr>';
                  
                  id_opname = n.so_id;
                  pemilik = n.c_name;
                  tanggal = n.so_date;
                  status = n.so_status;
                  nota = n.so_nota; 

            });
                  mydata = mydata +'</tbody>'; 

            $('#tabel_detail').html(mydata);
            //$('#id_opname').html(id_opname);
            $('#tanggal_opname').html(tanggal);
            $('#pemilik_opname').html(pemilik);
            $('#status_opname').html(status);
            $('#nota_opname').html(nota);
          }
      })


   });

    function simpan(){

       swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data Stock Opname!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
      },
      function(){
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

          $.ajax({
            url:baseUrl+'/manajemen-stock/stock-opname/simpan',
            data: $('.tabel_opname :input').serialize(),
            type:'get',
          success:function(response){
            if (response.status == 1) {
                swal({
                title: "Berhasil!",
                        type: 'success',
                        text: "Data berhasil disimpan",
                        timer: 900
                        },function(){
                           // location.href='../buktikaskeluar/index';
                           //$('.id_sppb').val(response.id);
                           //$('.print_patty').removeClass('disabled'); 

                           var table = $('#addColumn1').DataTable();
                           table.ajax.reload( null, false );
                           $("#modal").modal('hide');
                           //window.location.reload();
                });



            }else if(response.status == 0){

                swal({
                title: "Harap Lengkapi Data",
                        type: 'warning',
                        timer: 900,
                        showConfirmButton: true

                });
            }

          },
          error:function(data){
            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 900,
                   showConfirmButton: true

            });
       }
      });  
     });
    }

  function edit(){
    // var so_stock_opname = $('#so_stock_opname').val();
    // var so_detailid = $('#so_detailid').val();

    swal({
        title: "Apakah anda yakin?",
        text: "Edit Data Stock Opname!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
      },
      function(){
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

          $.ajax({
            url:baseUrl+'/manajemen-stock/stock-opname/edit',
            data: $('.tabel_edit :input').serialize(),
            //data: $('.tabel_edit :input').serialize()+'&id='+so_stock_opname+'&detail='+so_detailid,
            type:'get',
          success:function(response){
            if (response.status == 1) {
                swal({
                title: "Berhasil!",
                        type: 'success',
                        text: "Data berhasil disimpan",
                        timer: 900
                        },function(){

                           // var table = $('#addColumn1').DataTable();
                           // table.ajax.reload( null, false );
                           $("#modal-edit").modal('hide');
                           //window.location.reload();
                });



            }else if(response.status == 0){

                swal({
                title: "Harap Lengkapi Data",
                        type: 'warning',
                        timer: 900,
                        showConfirmButton: true

                });
            }

          },
          error:function(data){
            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 900,
                   showConfirmButton: true

            });
       }
      });  
     });
  }

// disable another checkbox if one checked
  function ckChange(ckType){
    var ckName = document.getElementsByName(ckType.name);
    var checked = document.getElementById(ckType.id);

    if (checked.checked) {
      for(var i=0; i < ckName.length; i++){

          if(!ckName[i].checked){
              ckName[i].disabled = true;
          }else{
              ckName[i].disabled = false;
          }
      } 
    }
    else {
      for(var i=0; i < ckName.length; i++){
        ckName[i].disabled = false;
      } 
    }    
  }

//imh
</script>
@endsection

