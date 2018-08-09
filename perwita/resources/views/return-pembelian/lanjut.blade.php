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
        <h2>Return Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Seragam
            </li>
            <li class="active">
                <strong>Return Seragam</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 style="float: left;">Ganti Uang</h5><h5 style="float: right;">Return Pembelian dari {{ $data[0]->supplier }} ( {{ $data[0]->p_nota }} )</h5>
                </div>
                <div class="ibox-content">
                    <div class="project-list">
                        <table class="table table-hover">
                            <tbody>
                            @foreach($data as $info)
                            @if($info->aksi == 'uang')
                            <tr>
                                <td class="project-title col-sm-3">
                                    {{ $info->nama }}
                                    <br>
                                    <small> Harga: Rp. {{ number_format($info->pd_value, 0, ',', '.') }}</small>
                                </td>
                                <td class="col-sm-2 form-horizontal" style="vertical-align: middle;">
                                    <div class="form-group" style="vertical-align: middle; margin-top: 15px;">
                                        <label class="col-sm-4 control-label">Jumlah: </label>
                                        <div class="col-sm-6">
                                            <input type="text" name="return[]" value="{{ $info->jumlah }}" class="form-control col-sm-12" style="text-align: right; width: 100%;">
                                        </div><sup>*</sup>
                                    </div>
                                </td>
                                <td class="col-sm-3">
                                    <div class="form-group" style="vertical-align: middle;">
                                        <label class="col-sm-4 control-label" style="margin-top: 6px;">Harga@: </label>
                                        <div class="col-sm-6">
                                            <input type="text" name="return[]" value="{{ number_format($info->pd_value, 0, ',', '.') }}" class="form-control maskharga" style="text-align: right;">
                                        </div>
                                    </div>
                                </td>
                                <td class="col-sm-4"><input type="text" placeholder="Keterangan" name="keterangan_sejenis[]" value="" class="form-control">
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="m-t" style="float: left; margin-top: -10px;">
                                <small><sup>*</sup>) Isi dengan '0' untuk membatalkan return</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 style="float: left;">Ganti Barang</h5><h5 style="float: right;">Return Pembelian dari {{ $data[0]->supplier }} ( {{ $data[0]->p_nota }} )</h5>
                </div>
                <div class="ibox-content">
                    <div class="project-list">
                        <table class="table table-hover">
                            <tbody>
                            @foreach($data as $info)
                            @if($info->aksi == 'barang')
                            <tr>
                                <td class="project-title col-sm-4">
                                    {{ $info->nama }}
                                    <br>
                                    <small> Harga: Rp. {{ number_format($info->pd_value, 0, ',', '.') }}</small>
                                </td>
                                <td class="col-sm-2 form-horizontal" style="vertical-align: middle;">
                                    <div class="form-group" style="vertical-align: middle; margin-top: 15px;">
                                        <label class="col-sm-4 control-label">Jumlah: </label>
                                        <div class="col-sm-6">
                                            <input type="text" name="return[]" value="{{ $info->jumlah }}" class="form-control" style="text-align: right;">
                                        </div><sup>*</sup>
                                    </div>
                                </td>
                                <td class="col-sm-6"><input type="text" placeholder="Keterangan" name="keterangan_sejenis[]" value="" class="form-control">
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="m-t" style="float: left; margin-top: -10px;">
                                <small><sup>*</sup>) Isi dengan '0' untuk membatalkan return</small>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="table-responsive">
                        <table class="table table-stripped table-bordered" id="barang-ganti">
                            <thead>
                                <tr>
                                    <th style="width: 45%">Nama Barang</th>
                                    <th style="width: 15%">Ukuran</th>
                                    <th style="width: 20%">Harga</th>
                                    <th style="width: 10%">Qty</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" placeholder="Masukan Nama Barang" name="ganti[]" value="" class="form-control" style="width: 100%"></td>
                                    <td><select name="ukuran[]" class="form-control" id="ukuran" style="width: 100%;">
                                            <option disabled selected>-- Ukuran --</option>
                                        </select></td>
                                    <td><input type="text" name="harga[]" value="" class="form-control" style="width: 100%"></td>
                                    <td><input type="text" name="qty[]" value="" class="form-control" style="text-align: right; width: 100%"></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
        $(".maskharga").maskMoney({
            allowNegative: false,
            thousands:'.',
            decimal:',',
            precision: 0,
            affixesStay: false
        });

        table = $("#barang-ganti").DataTable({
            "language": dataTableLanguage,
            "paging": false,
            "searching": false,
            "aaSorting": [],
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
    });
</script>
@endsection
