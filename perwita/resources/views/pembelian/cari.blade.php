@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }

    ul .list-unstyled{
      background-color: rgb(255, 255, 255);
    }

    li .daftar{
      padding: 4px;
      cursor: pointer;
    }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Cari Pembelian Ke Supplier</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Cari Pembelian Ke Supplier</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Pencarian Pembelian Ke Supplier</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-5">
                    <input type="text" name="pencarian" id="pencarian" class="form-control" style="text-transform:uppercase" placeholder="Masukan No Nota">
                </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <table class="table table-hover table-bordered table-striped" id="tabelcari">
                        <thead>
                            <tr>
                              <th>No</th>
                              <th>Tanggal</th>
                              <th>Supplier</th>
                              <th>Nota</th>
                              <th>Total</th>
                              <th>Status</th>
                              <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="datacari">
                          @if(empty($data))

                          @else
                          @foreach($data as $index=>$row)
                          <tr>
                              <td>{{ $index + 1 }}</td>
                              <td>{{ Carbon\Carbon::parse($row->p_date)->format('d/M/Y H:i:s') }}</td>
                              <td>{{ $row->s_company }}</td>
                              <td>{{ $row->p_nota }}</td>
                              <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format($row->p_total_net, 0, ',', '.') }}</span></td>
                              @if($row->pd_receivetime == null)
                              <td class="text-center"><span class="label label-warning">Belum diterima</span></td>
                              @else
                              <td class="text-center"><span class="label label-success">Sudah diterima</span></td>
                              @endif
                              @if($row->p_isapproved == 'P')
                              <td class="text-center"><span class="label label-warning">Belum disetujui</span></td>
                              @elseif($row->p_isapproved == 'Y')
                              <td class="text-center"><span class="label label-success">Sudah disetujui</span></td>
                              @endif
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">

$(document).ready(function(){

    $('#pencarian').autocomplete({
        source: baseUrl + '/manajemen-seragam/getnota',
        select: function(event, ui) {
            getdata(ui.item.id);
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

 function getdata(id){
   $.ajax({
     type: 'get',
     dataType: 'json',
     data: {id:id}
     url: baseUrl + '/manajemen-seragam/getdata',
     success : function(result){
       console.log(result);
     }
   })
 }
</script>
@endsection
