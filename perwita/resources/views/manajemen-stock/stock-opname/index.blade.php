@extends('main')

@section('title', 'Stock Opname')

@section('extra_styles')

<style>
.popover-navigation [data-role="next"] { display: none; }
.popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Manajemen Stock</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Stock
            </li>
            <li class="active">
                <strong>Opname Stock</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Opname Stock</h5>
        <a href="{{ url('manajemen-stock/stock-opname/tambah') }}" style="float: right; margin-top: -7px; margin-left: 5px;" class="btn btn-primary btn-outline btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
        <a href="{{ url('manajemen-stock/stock-opname/history') }}" style="float: right; margin-top: -7px;" class="btn btn-info btn-flat btn-sm" type="button"><i class="fa fa-history"></i>&nbsp;History</a>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-opname">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index=>$row)
                            <tr>
                                <td>{{ $row->so_nota }}</td>
                                <td>{{ $row->so_date }}</td>
                                <td>{{ $row->nama }}</td>
                                <td><span class="label label-warning">Belum disetujui</span></td>
                                <td class="text-center">
                                    <button style="margin-left:5px;" title="Detail" type="button" class="btn btn-info btn-xs" onclick="detail('{{ $row->so_nota }}')"><i class="glyphicon glyphicon-folder-open"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Detail Return Pembelian</h4>
                        <small class="font-bold">Daftar Detail Return Pembelian</small>
                    </div>
                    <div class="modal-body">

                      <table id="tableuang" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                            <th>QTY Sistem</th>
                            <th>QTY Real</th>
                            <th>Aksi</th>
                            <th>Keterangan</th>
                          </tr>
                        </thead>
                        <tbody id="showuang">

                        </tbody>
                      </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $(".table-opname").DataTable({
            responsive: true,
            paging: true,
            "language": dataTableLanguage,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
    });

    function detail(id){
      var html = '';
        $.ajax({
          type: 'get',
          data: {id:id},
          dataType: 'json',
          url: baseUrl + '/approvalopname/detail',
          success : function(result){

            for (var i = 0; i < result.length; i++) {
              html += '<tr>'
                      +'<td>'+result[i].so_nota+'</td>'
                      +'<td>'+result[i].so_date+'</td>'
                      +'<td>'+result[i].nama+'</td>'
                      +'<td>'+result[i].sod_qty_sistem+'</td>'
                      +'<td>'+result[i].sod_qty_real+'</td>'
                      +'<td>'+result[i].sod_aksi+'</td>'
                      +'<td>'+result[i].sod_keterangan+'</td>'
                      '</tr>';
            }

            $('#showuang').html(html);

            $('#myModal5').modal('show');

          }
        });
    }
</script>
@endsection
