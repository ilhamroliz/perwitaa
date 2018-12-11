@extends('main')

@section('title', 'Pembayaran Seragam')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }

    .modal-body{
        max-height: calc(100vh - 300px);
    overflow-y: auto;
    }

    .modal-dialog{
        overflow-y: initial !important
    }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Pembayaran Seragam Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Pembayaran Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
        <h5>Pembayaran Seragam</h5>
        <a style="float: right; margin-top: -7px;" class="btn btn-info btn-flat btn-sm" type="button" aria-hidden="true" href="{{url('manajemen-seragam/pembayaran-seragam/history')}}"><i class="fa fa-history"></i>&nbsp;History</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                  <table class="table table-responsive table-striped table-bordered table-hover" id="tabel-pembayaran">
                    <thead>
                      <tr>
                        <th>Nota</th>
                        <th>Tanggal</th>
                        <th>Seragam</th>
                        <th>Mitra</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $data)
                        @if ($data->tagihan != 0)
                          <tr>
                            <td>{{ $data->s_nota }}</td>
                            <td>{{ Carbon\Carbon::parse($data->s_date)->format('d/M/Y H:i:s') }}</td>
                            <td>{{ $data->i_nama }}</td>
                            <td>{{ $data->m_name }}</td>
                            <td>{{ $data->jumlah }} PCS</td>
                            <td>
                              <div class="text-center">
                                <button onclick="goBayar('{{ $data->s_nota }}')" style="margin-left:5px;" title="Bayar" type="button" class="btn btn-info btn-xs"><i class="fa fa-credit-card-alt"></i> Bayar</button>
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

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-money modal-icon"></i>
                <h4 class="modal-title">Pembayaran Seragam</h4>
                <small class="font-bold">Pekerja membayar tagihan seragam</small>
            </div>
            <div class="modal-body">
                <h3 class="namabarang"></h3>
                <form class="form-horizontal">
                    <div class="form-group">
                        <table class="table table-responsive table-striped table-bordered table-hover" id="tabel-pekerja">
                          <thead>
                            <tr>
                              <th>Nama</th>
                              <th>Tagihan</th>
                              <th>Bayar</th>
                            </tr>
                          </thead>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" class="btn btn-primary btn-outline" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
  var tabelpembayaran;
  var tabelpekerja;
  $( document ).ready(function() {
       tabelpembayaran  = $("#tabel-pembayaran").DataTable({
            responsive: true,
            paging: true,
            "language": dataTableLanguage,
            "columnDefs": [
                { "orderable": false, "targets": 0 }
              ]
        });
       tabelpekerja  = $("#tabel-pekerja").DataTable({
            responsive: true,
            paging: false,
            "language": dataTableLanguage
        });
    });

  function bayar(idSales){
    waitingDialog.show();
    $.ajax({
      url: baseUrl + '/manajemen-seragam/getPekerja',
      type: 'get',
      data: {idSales: idSales},
      success: function(response){
        var data = response.data;
        tabelpekerja.clear();
        for (var i = 0; i < data.length; i++) {
          var tagihan = accounting.formatMoney(data[i].tagihan, "", 0, ".", ","); // €4.999,99
          tabelpekerja.row.add([
                    data[i].p_name +' ('+data[i].p_hp+')',
                    '<span style="float: left">Rp. </span><span style="float:right" class="hargaitem">'+tagihan+'</span>',
                    '<input type="text" class="form-control bayar" name="bayar[]">'
                ]).draw( false );
        }

        $('#myModal').modal('show');
        waitingDialog.hide();
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
    })
    waitingDialog.hide();
  }

  function goBayar(nota){
    var link = baseUrl + '/manajemen-seragam/pembayaran-seragam';
    window.location.href = baseUrl+"/manajemen-seragam/pembayaran-pekerja?nota="+nota+'&link='+link;
  }
</script>
@endsection
