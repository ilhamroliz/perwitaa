@extends('main')

@section('title', 'Mitra MOU')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Cari MOU</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Mitra
            </li>
            <li class="active">
                <strong>Cari MOU</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Pencarian Data Mitra MOU</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="Masukan No MOU / Nama Mitra">
                </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                              <th>Nama Mitra</th>
                              <th>No MOU</th>
                              <th>Mulai</th>
                              <th>Berakhir</th>
                              <th>Sisa</th>
                              <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="showdata">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-calendar modal-icon"></i>
                <h4 class="modal-title">Perpanjang MOU</h4>
                <small class="font-bold">Memperpanjang MOU mitra perusahaan</small>
            </div>
            <div class="modal-body">
                <div class="input-daterange input-group col-md-12 isimodal" id="datepicker" style="display: none">
                    <input type="text" class="input-sm form-control awal" name="start" value="05/06/2014"/>
                    <span class="input-group-addon">sampai</span>
                    <input type="text" class="input-sm form-control akhir" name="end" value="05/09/2014" />
                </div>
                <div class="spiner-example spin">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="update()">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-calendar modal-icon"></i>
                <h4 class="modal-title">Perpanjang MOU</h4>
                <small class="font-bold">Memperpanjang MOU mitra perusahaan</small>
            </div>
            <div class="modal-body">
              <div class="dataedit" id="dataedit">
                <div class="input-daterange input-group col-md-12 isimodal" id="datepicker" style="display: none">
                    <input type="text" class="input-sm form-control awal" name="start" value="05/06/2014"/>
                    <span class="input-group-addon">sampai</span>
                    <input type="text" class="input-sm form-control akhir" name="end" value="05/09/2014" />
                </div>
                <div class="spiner-example spin">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="update()">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-folder modal-icon"></i>
                <h4 class="modal-title">Edit MOU</h4>
                <small class="font-bold">Mengedit MOU mitra perusahaan</small>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col">
                  <label>No MOU</label>
                </div>
                <div class="col">
                  <input type="text" class="input-sm form-control nomou" name="nomou" value="">
                </div>
                <br>
                <div class="input-daterange input-group col-md-12" id="datepicker">
                  <input type="text" class="input-sm form-control startedit" name="startedit"/>
                  <span class="input-group-addon">sampai</span>
                  <input type="text" class="input-sm form-control endedit" name="endedit"/>
                </div>
                <div class="spiner-edit spin">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
            </div>
          </div>
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="update" idmitra="" detailid="" onclick="updateedit()">Update</button>
            </div>
        </div>
    </div>
</div>




@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;
    $(document).ready(function(){

        $('#pencarian').autocomplete({
            source: baseUrl+'/manajemen-mitra/mitra-mou/pencarian',
            minLength: 3,
            select: function(event, ui) {
                getData(ui.item.mitraid,ui.item.detailid);
            }
        });

        table = $("#tabelcari").DataTable({
            "language": dataTableLanguage,
            "columnDefs": [{
                "targets": 0,
                "orderable": false
            }]
        });
    });

    function getData(mitraid, detailid){
      waitingDialog.show();
      var html = '';
      var btndinamis = '';
        $.ajax({
            url: baseUrl + '/manajemen-mitra/mitra-mou/getdata',
            type: 'get',
            data: {mitraid:mitraid, detailid:detailid},
            dataType: 'json',
            success: function (response) {

              if (response[0].mm_status == 'Aktif') {
                btndinamis = '<button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Non Aktifkan" onclick="hapus('+response[0].mm_mitra+')"><i class="glyphicon glyphicon-remove"></i></button>';
              } else if (response[0].mm_status == 'Tidak') {
                btndinamis = '<button style="margin-left:5px;" type="button" class="btn btn-primary btn-xs" title="Aktifkan" onclick="aktif('+response[0].mm_mitra+')"><i class="glyphicon glyphicon-ok"></i></button>';
              }

              html += '<tr>'+
                      '<td>'+response[0].m_name+'</td>'+
                      '<td>'+response[0].mm_mou+'</td>'+
                      '<td>'+response[0].mm_mou_start+'</td>'+
                      '<td>'+response[0].mm_mou_end+'</td>'+
                      '<td>'+response[0].sisa+'</td>'+
                      '<td><div class="text-center">'+
                          '<button style="margin-left:5px;" title="Perpanjang" data-toggle="modal" data-target="#myModal"  type="button" class="btn btn-info btn-xs" onclick="perpanjang('+response[0].mm_mitra+','+response[0].mm_detailid+')"><i class="glyphicon glyphicon-export"></i></button>'+
                          '<a style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs" data-target="modal-edit" onclick="edit('+response[0].mm_mitra+')"><i class="glyphicon glyphicon-edit"></i></a>'+
                          btndinamis+
                        '</div>'+
                      '</tr>';

            $('#showdata').html(html);
            waitingDialog.hide();

            },
            error: function (xhr, status) {
                if (xhr.status == 'timeout') {
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
                waitingDialog.hide();
            }
        });
    }

    function perpanjang(id, detail){
      idPublic = id;
      detailPublic = detail;
      $.ajax({
          url: baseUrl + '/manajemen-mitra/mitra-mou/get-tgl-mou',
          type: 'get',
          data: { id: id, detail: detail },
          success: function(response){
            var awal = response[0].mm_mou_start;
            var akhir = response[0].mm_mou_end;
            $('.awal').val(awal);
            $('.akhir').val(akhir);
            $('.spin').css('display', 'none');
            $('.isimodal').show();
            $('.input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: 'dd/mm/yyyy'
            });
        }, error:function(x, e) {
            if (x.status == 0) {
                alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
            } else if (x.status == 404) {
                alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
            } else if (x.status == 500) {
                alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
            } else if (e == 'parsererror') {
                alert('Error.\nParsing JSON Request failed.');
            } else if (e == 'timeout'){
                alert('Request Time out. Harap coba lagi nanti');
            } else {
                alert('Unknow Error.\n' + x.responseText);
            }
          }
      });
    }

    function edit(id){
      $("#modal-edit").modal('show');
      $('.input-daterange').datepicker({
          keyboardNavigation: false,
          forceParse: false,
          autoclose: true,
          format: 'dd/mm/yyyy'
      });
      $("#dataedit").hide();

      $.ajax({
          type: 'get',
          data: {id:id},
          url: baseUrl + '/manajemen-mitra/mitra-mou/edit',
          dataType: 'json',
          success : function(result){

            $('.nomou').val(result.mm_mou);
            $('.startedit').val(result.mm_mou_start);
            $('.endedit').val(result.mm_mou_end);
            $('#update').attr('idmitra', result.mm_mitra);
            $('#update').attr('detailid', result.mm_detailid);

            $(".spin").css('display', 'none');
            $("#dataedit").show();
            $('.input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: 'dd/mm/yyyy'
            });
          }, error:function(x, e) {
              if (x.status == 0) {
                  alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
              } else if (x.status == 404) {
                  alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
              } else if (x.status == 500) {
                  alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
              } else if (e == 'parsererror') {
                  alert('Error.\nParsing JSON Request failed.');
              } else if (e == 'timeout'){
                  alert('Request Time out. Harap coba lagi nanti');
              } else {
                  alert('Unknow Error.\n' + x.responseText);
              }
            }
      });
    }

    function updateedit(){
      waitingDialog.show();
     var mitra = $('#update').attr('idmitra');
     var detail = $('#update').attr('detailid');
     var nomou = $('.nomou').val();
     var startmou = $('.startedit').val();
     var endmou = $('.endedit').val();
     $.ajaxSetup({
         headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
     });
     $.ajax({
       type: 'post',
       data: {mitra:mitra, detail:detail, nomou:nomou, startmou:startmou, endmou:endmou},
       url: baseUrl + '/manajemen-mitra/mitra-mou/updateedit',
       dataType: 'json',
       success : function(result){
         waitingDialog.hide();
         if (result.status == 'berhasil') {
           swal({
             title: "Sukses",
             text: "Data sudah tersimpan",
             type: "success"
           },function () {
               $('#modal-edit').modal('hide');
               window.location.reload();
           });
         }
       }, error:function(x, e) {
           if (x.status == 0) {
               alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
           } else if (x.status == 404) {
               alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
           } else if (x.status == 500) {
               alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
           } else if (e == 'parsererror') {
               alert('Error.\nParsing JSON Request failed.');
           } else if (e == 'timeout'){
               alert('Request Time out. Harap coba lagi nanti');
           } else {
               alert('Unknow Error.\n' + x.responseText);
           }
         }
     });
    }

    function hapus(id){
      swal({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin menonaktifkan data MOU?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function(){
      swal.close();
      waitingDialog.show();
      $.ajax({
        type: 'get',
        data: {id:id},
        url: baseUrl + '/manajemen-mitra/mitra-mou/hapus',
        dataType: 'json',
        success : function(result){
          waitingDialog.hide();
          if (result.status == 'berhasil') {
            swal({
              title: "Sukses",
              text: "Data berhasil dinonaktifkan",
              type: "success"
            },function () {
                window.location.reload();
            });
          }
          else if (result.status == 'gagal') {
            swal({
              title: "Gagal",
              text: "Data gagal dihapus",
              type: "warning"
          });
        }
      }
    });
  });
}

function update(){
  waitingDialog.show();
  var awal = $('.awal').val();
  var akhir = $('.akhir').val();
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
  });
  $.ajax({
      url: baseUrl + '/manajemen-mitra/mitra-mou/update-mou',
      type: 'get',
      data: { id: idPublic, detail: detailPublic, awal: awal, akhir: akhir },
      success: function(response){
        waitingDialog.hide();
        if (response.status == 'berhasil') {
          swal({
            title: "Sukses",
            text: "Data sudah tersimpan",
            type: "success"
          },function () {
              window.location.reload();
              $('#myModal').modal('hide');
          });
        }
    }, error:function(x, e) {
        if (x.status == 0) {
            alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
        } else if (x.status == 404) {
            alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
        } else if (x.status == 500) {
            alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
        } else if (e == 'parsererror') {
            alert('Error.\nParsing JSON Request failed.');
        } else if (e == 'timeout'){
            alert('Request Time out. Harap coba lagi nanti');
        } else {
            alert('Unknow Error.\n' + x.responseText);
        }
      }
  });
}

function aktif(id){
  waitingDialog.show();
  swal({
    title: "Konfirmasi",
    text: "Apakah anda yakin ingin mengaktifkan data MOU?",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
}, function(){
  $.ajax({
    type: 'get',
    data: {id:id},
    url: baseUrl + '/manajemen-mitra/mitra-mou/aktif',
    dataType: 'json',
    success : function(result){
      waitingDialog.hide();
      if (result.status == 'berhasil') {
        swal({
          title: "Sukses",
          text: "Data berhasil diaktifkan",
          type: "success"
        },function () {
            window.location.reload();
        });
      }
      else if (result.status == 'gagal') {
        if (result.content == 'Mitra MOU ini sudah ada yang aktif!') {
          swal({
            title: "Gagal",
            text: result.content,
            type: "warning"
        });
      } else {
        swal({
          title: "Gagal",
          text: "Data gagal diaktifkan",
          type: "warning"
      });
      }
    }
  }
});
});
}

</script>
@endsection
