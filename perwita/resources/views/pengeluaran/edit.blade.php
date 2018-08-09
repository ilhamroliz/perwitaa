@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    table.dataTable tbody td {
      vertical-align: middle;
    }

</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Edit data Pengeluaran Barang</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Pengeluaran
            </li>
            <li>
                Pengeluaran Barang
            </li>
            <li class="active">
                <strong>Edit data</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <span class="pull-right">(<strong class="jumlahitem">0</strong>) items</span>
                        <h5>Pengeluaran Barang ke Mitra</h5>
                    </div>

                    <div class="ibox-content">
                        <form role="form" class="form-inline row">
                            <div class="form-group col-md-4">
                                <select class="form-control chosen-select-width" name="mitra" style="width:100%" id="mitra" readonly>
                                <option value="{{$data[0]->sp_mitra}}" selected>{{$data[0]->m_name}}</option>
                            </select>
                            </div>
                            <div class="form-group col-md-4 divisi">
                                <select class="form-control chosen-select-width" name="divisi" style="width:100%" id="divisi" readonly>
                                    <option value="{{$data[0]->sp_divisi}}" selected>{{$data[0]->md_name}}</option>
                            </select>
                            </div>
                            <div class="form-group col-md-4 pilihseragam">
                                <select class="form-control chosen-select-width" name="seragam" style="width:100%" id="seragam" readonly>
                                    <option value="{{$data[0]->s_id}}">{{$data[0]->i_nama}} ({{$data[0]->i_warna}})</option>
                            </select>
                            </div>
                            <div class="table-responsive col-md-12" style="margin-top: 30px;">
                                <table class="table table-striped table-bordered table-hover" id="tabelitem">
                                    <thead>
                                        <tr>
                                            <th style="width: 60%;">Nama Pekerja</th>
                                            <th style="width: 20%;">NIK Mitra</th>
                                            <th style="width: 20%;">Ukuran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($pekerja as $x)
                                      <tr>
                                        <td>{{$x->p_name}} ({{$x->p_hp}})</td>
                                        <td>{{$x->p_nip}}</td>
                                        <td>
                                          <select class="form-control pilihukuran chosen-select-width index" name="ukuran[]" style="width:100%" id="ukuran" onchange="ambil()">
                                          @foreach($data as $z)
                                          @if($x->s_id == null)
                                            <option value="Tidak" selected>-- Tidak --</option>
                                            <option value="{{ $z->s_id }}">{{ $z->s_nama }}</option>
                                          @elseif($x->s_id != null && $x->s_id == $z->s_id)
                                            <option value="Tidak">-- Tidak --</option>
                                            <option value="{{ $z->s_id }}" selected>{{ $z->s_nama }}</option>
                                          @endif

                                          @endforeach
                                        </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Info Pengeluaran</h5>
                        </div>
                        <div class="ibox-content">
                            <span>
                                Total
                            </span>
                            <h2 class="font-bold totalpembelian" align="center">
                                Rp. {{number_format($data[0]->sd_total_net, 0, ',', '.')}}
                            </h2>

                            <hr>

                            <span class="text-muted small">

                            </span>
                            <div class="m-t-sm">
                                <div class="btn-group">
                                <button onclick="simpan()" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Simpan</button>
                                <a href="{{ url('manajemen-seragam/pengeluaran') }}" class="btn btn-white btn-sm"> Batal</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="infosupp">Info Mitra</h5>
                        </div>
                        <div class="ibox-content text-center">
                            <h3 class="telpmitra"><i class="fa fa-phone"></i> {{$data[0]->m_phone}}</h3>
                            <span class="small">
                                Hubungi Mitra jika diperlukan
                            </span>
                        </div>
                    </div>
                    <div class="ibox info-stock" style="display: block;">
                        <div class="ibox-title">
                            <h5 class="infosupp">Info Stock Seragam</h5>
                        </div>
                        <div class="ibox-content">
                        <ul class="list-group clear-list m-t" id='showinfo'>
                            <li class="list-group-item fist-item"><span class="pull-right">{{$stock[0]->s_qty}}</span><span></span>{{$data[0]->i_nama}} {{$data[0]->i_warna}} {{$data[0]->s_nama}}</li>
                        </ul>
                        </div>
                    </div>
                </div>
        </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">

    $( document ).ready(function() {
        tabelpekerja = $("#tabelitem").DataTable({
            responsive: true,
            paging: false,
            "language": dataTableLanguage
        });
    });

function simpan(){
  var mitra = $('#mitra').val();
  var seragam = $('#seragam').val();
  var divisi = $('#divisi').val();
  $.ajax({
    type: 'get',
    data: ar.find('input').serialize()+'&'+ar.find('select').serialize()+'&mitra='+mitra+'&seragam='+seragam+'&nota='+nota+'&total='+total+'&divisi='+divisi,
    dataType: 'json',
    url: baseUrl + '/manajemen-penjualan/update',
    success : function(result){
      console.log(result);
    }
  })
}

</script>
@endsection
