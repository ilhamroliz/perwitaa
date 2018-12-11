@extends('main')

@section('title', 'Mitra Divisi')

@section('extra_styles')

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Mitra Divisi </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                          <a>Manajemen Mitra</a>
                        </li>
                        <li class="active">
                            <strong> Mitra Divisi </strong>
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
                    <h5> Mitra Divisi
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="col-md-10 col-sm-10 col-xs-10" style="padding-bottom: 10px;">

                </div>
                <div class="box-body">

                  <table id="addColumn1" class="table table-bordered table-striped tabel_opname1">
                      <thead>
                           <tr>
                              <th style="text-align : center;"> NAMA MITRA </th>
                              <th style="text-align : center;"> ALAMAT MITRA </th>
                              <th style="text-align : center;"> AKSI </th>
                          </tr>
                          </thead>
                      <tbody>
                      </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="modal inmodal" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" onclick="cleartabel()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-pencil modal-icon"></i>
                                  <h4 class="modal-title">TAMBAH DIVISI MITRA</h4>
                                  <h3 id="nama_mitra"> - </h3>
                                <table id="tabel_mitra" class="tabel_mitra">
                                  <tr>
                                    <td> <input type="hidden" name="id_mitra" id="id_mitra" value="" /> </yd>
                                  </tr>
                                </table>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal">
                                   <table id="addColumn" class="table table-bordered table-striped tabel_tambah">

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
                    <div class="modal-dialog modal-md">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-pencil-square-o modal-icon"></i>
                                <h4 class="modal-title">Edit Data Divisi Mitra</h4>
                                <h3 id="nama_mitra_edit"> - </h3>
                            </div>
                            <div class="modal-body">
                                <h3 id="nota_edit"></h3>
                                <form class="form-horizontal">
                                   <table id="tabel_edit" class="table table-bordered table-striped tabel_edit">

                                   </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button onclick="edit()" class="btn btn-primary btn-outline" type="button">Save Change</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal inmodal" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true" >
                    <div class="modal-dialog modal-md">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-folder-open modal-icon"></i>
                                <h4 class="modal-title">Detail Divisi Mitra</h4>
                                <h3 id="nama_mitra_detail"> - </h3>
                            </div>
                            <div class="modal-body">

                                <form class="form-horizontal">
                                   <table id="tabel_detail" class="table table-bordered table-striped tabel_detail">

                                   </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                              <div class="btn-group">
                                <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
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
var table;
$(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();

      setTimeout(function(){
            $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
            });
            table = $("#addColumn1").DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                      "url": "{{ url('manajemen-mitra/mitra-divisi/tabel') }}",
                      "type": "get"
                  },
                dataType: 'json',
                columns: [
                    { "data": "m_name" },
                    { "data": "m_address" },
                    { "data": "button" }
                ],
                responsive: true,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                "language": dataTableLanguage,
            });
            /*table
                .column( '0:visible' )
                .order( 'desc' )
                .draw();*/
        },1500);


  });

$(document).on('click','.tambah',function(){

      var id=$(this).attr("id");
      var value = {
            id: id
        };

      $.ajax({
          data: {id : value},
          type: "GET",
          url : baseUrl + "/manajemen-mitra/mitra-divisi/get_mitra",
          dataType:'json',
          success: function(data)
          {
            var mydata = '<thead>'
                           +'<tr>'
                              +'<th style="text-align : center;"> NAMA DIVISI </th>'
                              +'<th style="text-align : center;"> AKSI </th>'
                          +'</tr>'
                          +'</thead>'
                          +'<tbody class="clone_mitra">';
            var nama_mitra, id_mitra;

            $.each(data, function(i,n){
                  nama_mitra = n.m_name;
                  id_mitra = n.m_id;
                  mydata = mydata + '<tr>'
                                      +'<td><input type="text" class="form-control" name="nama_divisi[]"></td>'
                                      +'<td align="center" class="clone_append" width="">'
                                          +'<button class="btn btn-default btn-sm append" onclick="append(this)"><a class="fa fa-plus"></a></button>'
                                        +'</td>'
                                  + '</tr>';

            });
                  mydata = mydata +'</tbody>';

            $('#addColumn').html(mydata);
            $('#nama_mitra').html(nama_mitra);
            $('#id_mitra').attr('value',id_mitra);
          }
      })

      $("#modal").modal("show");
      //console.log($('#id_mitra').val());
   });

$(document).on('click','.detail',function(){
      var id=$(this).attr("id");
        var value = {
            id: id
        };

      $.ajax({
          data: {id : value},
          type: "GET",
          url : baseUrl + "/manajemen-mitra/mitra-divisi/detail",
          dataType:'json',
          success: function(data)
          {
            var mydata = '<thead>'
                           +'<tr>'
                              +'<th style="text-align : center;"> NO </th>'
                              +'<th style="text-align : center;"> NAMA DIVISI </th>'
                          +'</tr>'
                          +'</thead>'
                          +'<tbody>';
            var nama_mitra_detail;

            $.each(data, function(i,n){
                  mydata = mydata + '<tr>'
                                      +'<td style="text-align : center;">'+n.nomer+'</td>'
                                      +'<td style="text-align : left;">'+n.md_name+'</td>'
                                  +'</tr>';
                  nama_mitra_detail = n.m_name;

            });
                  mydata = mydata +'</tbody>';

            $('#tabel_detail').html(mydata);
            $('#nama_mitra_detail').html(nama_mitra_detail);
          }
      })

            $("#modal-detail").modal("show");
   });


function append(p){
  var par = p.parentNode.parentNode;
  var count_append = 0;

  var append = '<button class="btn btn-default btn-sm append" onclick="remove_append(this)"><a class="fa fa-minus"></a></button>';
  var append_plus = '<button class="btn btn-default btn-sm append" onclick="append(this)"><a class="fa fa-plus"></a></button>';

  $(par).find('.clone_append').html(append);
    var html    ='<tr>'
                +'<td><input type="text" class="form-control" name="nama_divisi[]"></td>'
                +'<td align="center" class="clone_append">'
                +'<button class="btn btn-default btn-sm" onclick="append(this)"><a class="fa fa-plus"></a></button>&nbsp;'
                +'</td>'
                +'</tr>';

    $('.clone_mitra').append(html);
}

function remove_append(p){
  var par = p.parentNode.parentNode;

  $(par).remove();
}

function simpan(){
  swal({
        title: "Apakah anda yakin?",
        text: "Menambah Divisi Mitra!",
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
            url:baseUrl+'/manajemen-mitra/mitra-divisi/tambah',
            data: $('.tabel_mitra :input').serialize()
                +'&'+ $('.tabel_tambah :input').serialize(),
            type:'get',
          success:function(response){
            if (response.status == 1) {
                swal({
                title: "Berhasil!",
                        type: 'success',
                        text: "Data berhasil disimpan",
                        timer: 900
                        },function(){
                           $("#modal").modal('hide');
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

function cleartabel(){
  $('#addColumn').html();
}

$(document).on('click','.edit',function(){

      var id=$(this).attr("id");
      var value = {
            id: id
        };

      $.ajax({
          data: {id : value},
          type: "GET",
          url : baseUrl + "/manajemen-mitra/mitra-divisi/get_data_edit",
          dataType:'json',
          success: function(data)
          {
            var mydata = '<thead>'
                           +'<tr>'
                              +'<th style="text-align : center;"> NO </th>'
                              +'<th style="text-align : center;"> NAMA DIVISI </th>'
                          +'</tr>'
                          +'</thead>'
                          +'<tbody>';
            var nama_mitra_edit;

            $.each(data, function(i,n){
                  var nama_mitra = n.md_name;
                  mydata = mydata + '<tr>'
                                      +'<td style="text-align : center;">'+n.nomer+'</td>'
                                      +'<input type="hidden" name="id_mitra[]" value="'+n.md_mitra+'" />'
                                      +'<input type="hidden" name="id_divisi[]" value="'+n.md_id+'" />';

                                      if(nama_mitra != "data divisi kosong"){
                                        mydata = mydata +'<td style="text-align : left;"><input type="text"  class="form-control" name="nama_divisi[]" value="'+n.md_name+'"></td>'
                                        +'</tr>';} else if (nama_mitra == "data divisi kosong"){
                                          mydata = mydata +'<td style="text-align : left;"><input type="text" disabled="" class="form-control" name="nama_divisi[]" value="'+n.md_name+'"></td>'
                                          +'</tr>';
                                        }
                  nama_mitra_edit = n.m_name;

            });
                  mydata = mydata +'</tbody>';

            $('#tabel_edit').html(mydata);
            $('#nama_mitra_edit').html(nama_mitra_edit);
          }
      })
         $("#modal-edit").modal("show");

   });

function edit(){

    swal({
        title: "Apakah anda yakin?",
        text: "Edit Data Divisi Mitra!",
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
            url:baseUrl+'/manajemen-mitra/mitra-divisi/edit',
            data: $('.tabel_edit :input').serialize(),
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



</script>
@endsection
