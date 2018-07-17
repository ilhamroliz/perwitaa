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
                    <h5 style="float: left;">Ganti Barang Sejenis</h5><h5 style="float: right;">Return Pembelian dari {{ $data[0]->supplier }} ( {{ $data[0]->p_nota }} )</h5>
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
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 style="float: left;">Ganti Barang Lain</h5><h5 style="float: right;">Return Pembelian dari {{ $data[0]->supplier }} ( {{ $data[0]->p_nota }} )</h5>
                </div>
                <div class="ibox-content">
                    <div class="project-list">
                        <table class="table table-hover">
                            <tbody>
                            @foreach($data as $info)
                            @if($info->aksi == 'lain')
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

        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 style="float: left;">Ganti Uang</h5><h5 style="float: right;">Return Pembelian dari {{ $data[0]->supplier }} ( {{ $data[0]->p_nota }} )</h5>
                </div>
                <div class="ibox-content">
                    <div class="project-list">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary">Ganti Uang</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">Contract with Zender Company</a>
                                    <br>
                                    <small>Created 14.08.2014</small>
                                </td>
                                <td class="project-completion">
                                        <small>Completion with: 48%</small>
                                        <div class="progress progress-mini">
                                            <div style="width: 48%;" class="progress-bar"></div>
                                        </div>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
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
var table = $("#barang-ganti").DataTable({
    "language": dataTableLanguage,
    "paging": false,
    "searching": false,
    "aaSorting": [],
    "columnDefs": [
        { "orderable": false, "targets": 4 }
    ]
});
</script>
@endsection
