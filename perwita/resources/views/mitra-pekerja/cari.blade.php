@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Penerimaan Tenaga Kerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Penerimaan Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Pencarian Data Permintaan Pekerja</h5>
        <button style="float: right; margin-top: -7px;" onclick="tambah()" class="btn btn-primary btn-outline btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="Masukan No Penerimaan Pekerja / Nama Mitra">
                </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Tanggal Kontrak</th>
                                <th>Kontrak Selesai</th>
                                <th>Nama Mitra</th>
                                <th>Nama Divisi</th>
                                <th>Dibutuhkan</th>
                                <th>Terpenuhi</th>
                                <th width="80px">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
            source: baseUrl+'/manajemen-pekerja-mitra/data-pekerja-mitra/cari/pencarian',
            minLength: 3,
            select: function(event, ui) {
                getData(ui.item.id);
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

    function getData(id){
        $.ajax({
            url: baseUrl + '/manajemen-pekerja-mitra/data-pekerja-mitra/cari/getData',
            type: 'get',
            data: {id: id},
            dataType: 'json',
            success: function (response) {
                var data = response[0];
                waitingDialog.hide();
                table.clear();
                var rowNode = table
                    .row.add( [
                     data.c_name,
                     data.mc_date,
                     data.mc_expired,
                     data.m_name,
                     data.md_name,
                     data.mc_need,
                     data.mc_fulfilled,
                     getAksi(data.mc_mitra, data.mc_contractid)
                     ] )
                    .draw()
                    .node();

                /*$( rowNode )
                    .css( 'color', 'red' )
                    .animate( { color: 'blue' } );*/
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

    function getAksi(mitra, kontrak){
        return '<div class="btn-group"></button></a><a class="btn-selesai" onclick="selesai('+mitra+','+kontrak+')"><button style="margin-left:5px;" type="button" class="btn btn-info btn-xs" title="Selesai"><i class="glyphicon glyphicon-ok"></i></button><a href="data-pekerja-mitra/'+mitra+'/'+kontrak+'/edit" ><button style="margin-left:5px;" title="Edit" type="button" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></button></a><a class="btn-delete" onclick="hapus('+mitra+'/'+kontrak+')"><button style="margin-left:5px;" type="button" class="btn btn-danger btn-xs" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button></a></div>';
    }

    function tambah(){
        window.location = baseUrl+'/manajemen-pekerja-mitra/data-pekerja-mitra/tambah';
    }


    function selesai(mitra, kontrak){
      $.ajax({
        type: 'get',
        data: {mitra:mitra, kontrak:kontrak},
        url: baseUrl + '/manajemen-pekerja-mitra/data-pekerja-mitra/selesai',
        dataType: 'json',
        success : function(result){
          console.log(result);
        }
      });
    }

    function selesai(mitra, kontrak){
        swal({
                title: "Selesai",
                text: "Semua data pekerja yang ada di kontrak ini akan diubah statusnya menjadi calon",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function () {
                swal.close();
                waitingDialog.show();
                setTimeout(function () {
                  $.ajax({
                    type: 'get',
                    data: {mitra:mitra, kontrak:kontrak},
                    url: baseUrl + '/manajemen-pekerja-mitra/data-pekerja-mitra/selesai',
                    dataType: 'json',
                    success : function(result){
                            waitingDialog.hide();
                            if (result.status == 'berhasil') {
                                swal({
                                    title: "Berhasil",
                                    text: "Selesai",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 900
                                });
                                setTimeout(function(){
                                      window.location.reload();
                              }, 850);
                            }
                        }, error: function (x, e) {
                            waitingDialog.hide();
                            var message;
                            if (x.status == 0) {
                                message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                            } else if (x.status == 404) {
                                message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                            } else if (x.status == 500) {
                                message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                            } else if (e == 'parsererror') {
                                message = 'Error.\nParsing JSON Request failed.';
                            } else if (e == 'timeout') {
                                message = 'Request Time out. Harap coba lagi nanti';
                            } else {
                                message = 'Unknow Error.\n' + x.responseText;
                            }
                            waitingDialog.hide();
                            throwLoadError(message);
                            //formReset("store");
                        }
                    })
                }, 2000);

            });


    }
</script>
@endsection
