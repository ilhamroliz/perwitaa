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
                <div class="ibox-content">
                    <form class="form-horizontal" id="form-parent">
                        <div class="form-group">
                            <label class="col-lg-1 control-label">No Nota</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="nota" value="{{ $data[0]->p_nota }}" readonly>
                            </div>
                            <label class="col-lg-1 control-label">Supplier</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="supplier" value="{{ $data[0]->supplier }}" readonly>
                            </div>                            
                            <label class="col-lg-1 control-label">Tanggal</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="tangal" value="{{ $data[0]->p_date }}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                    </form>


                    <div class="table-responsive" style="margin-top: 20px;">
                        <table class="table table-striped table-bordered table-hover" id="table-return">
                            <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Harga @</th>
                                <th>Diskon</th>
                                <th>Total</th>
                                <th width="10%">Return</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $data)
                                <tr>
                                    <td>
                                        {{ $data->nama }}
                                        <input type="hidden" name="id_item[]" value="{{ $data->i_id }}">
                                        <input type="hidden" name="item_detail[]" value="{{ $data->id_detailid }}">
                                    </td>
                                    <td>{{ $data->pd_qty }}</td>
                                    <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format($data->pd_value, 0, ',', '.') }}</span></td>
                                    <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format($data->pd_disc_value, 0, ',', '.') }}</span></td>
                                    <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format(($data->pd_value * $data->pd_qty) - $data->pd_disc_value, 0, ',', '.') }}</span></td>
                                    <td><input type="text" name="return[]" value="0" class="form-control" style="width: 100%"></td>
                                    <td>
                                        <select name="aksi[]" class="form-control" id="aksi-return" style="width: 100%;">
                                            <option disabled selected>-- Pilih Aksi --</option>
                                            <option value="uang">Ganti Uang</option>
                                            <option value="barang">Ganti Barang</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary pull-right m-t-n-xs" onclick="lanjutkan()" type="button">Lanjutkan</button>
                    </div>
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
                <i class="fa fa-truck modal-icon"></i>
                <h4 class="modal-title">Tambah Data Supplier</h4>
                <small class="font-bold">Data supplier ini digunakan untuk pembelian barang di fitur Pembelian</small>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button onclick="simpan()" class="btn btn-primary" type="button">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
    var table;
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $(document).ready(function(){
        table = $("#table-return").DataTable({
            responsive: true,
            paging: false,
            searching: false,
            "language": dataTableLanguage
        });

        $('#aksi-return').select2();
    });
    
    $('#form-parent').on('submit', function(e){
        var form = this;

          // Encode a set of form elements from all pages as an array of names and values
        var params = table.$('input,select,textarea').serializeArray();

          // Iterate over all form elements
        $.each(params, function(){
             // If element doesn't exist in DOM
             if(!$.contains(document, form[this.name])){
                // Create a hidden element
                $(form).append(
                   $('<input>')
                      .attr('type', 'hidden')
                      .attr('name', this.name)
                      .val(this.value)
                );
            }
        });
    });
</script>
@endsection
