@extends('main')

@section('title', 'Return Pembelian')

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
                    <form class="form-horizontal" id="form-parent"  action="{{ url('manajemen-seragam/return/lanjut') }}" accept-charset="UTF-8" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
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
                                    </td>
                                    <td>{{ $data->pd_qty }}</td>
                                    <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format($data->pd_value, 0, ',', '.') }}</span></td>
                                    <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format($data->pd_disc_value, 0, ',', '.') }}</span></td>
                                    <td><span style="float: left;">Rp. </span><span style="float: right">{{ number_format(($data->pd_value * $data->pd_qty) - $data->pd_disc_value, 0, ',', '.') }}</span></td>
                                    <td><input type="text" onkeyup="cek({{ $data->pd_qty }}, this)" name="return[]" value="0" class="form-control input-return" style="width: 100%"></td>
                                    <td>
                                        <input type="hidden" name="id_item[]" value="{{ $data->i_id }}">
                                        <input type="hidden" name="item_detail[]" value="{{ $data->id_detailid }}">
                                        <select name="aksi[]" class="form-control select2" id="aksi-return" style="width: 100%;">
                                            <option value="tidak" selected>-- Pilih Aksi --</option>
                                            <option value="uang">Ganti Uang</option>
                                            <option value="barang">Ganti Barang</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary btn-outline pull-right m-t-n-xs" type="button" onclick="lanjut()">Lanjutkan</button>
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
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $(document).ready(function(){

      $(".input-return").keydown(function (e) {
  // Allow: backspace, delete, tab, escape, enter and .
  if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
       // Allow: Ctrl+A, Command+A
      (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
       // Allow: home, end, left, right, down, up
      (e.keyCode >= 35 && e.keyCode <= 40)) {
           // let it happen, don't do anything
           return;
  }
  // Ensure that it is a number and stop the keypress
  if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
  }
});

        table = $("#table-return").DataTable({
            responsive: true,
            paging: false,
            searching: false,
            "language": dataTableLanguage
        });

        $('.select2').select2();
    });

    $('#form-parent').on('submit', function(e){
        var form = this;
          // Encode a set of form elements from all pages as an array of names and values
        var params = table.$('input,select,textarea').serializeArray();
          // Iterate over all form elements
        $.each(params, function(){
             // If element doesn't exist in DOM
             $(form).append(
                   $('<input>')
                      .attr('type', 'hidden')
                      .attr('name', this.name)
                      .val(this.value)
                );
        });
    });

    function lanjut(){
        $('#form-parent').submit();
    }

    function cek(qty, field){
        var getIndex = $('input.input-return:text').index(field);
        var inputqty = $("input.input-return:text:eq("+getIndex+")").val();
        if (inputqty > qty) {
            Command: toastr["warning"]("Jumlah return terlalu banyak", "Peringatan !")
            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            $("input.input-return:text:eq("+getIndex+")").val(qty);
            return false;
        }
        // var inputs = document.getElementsByClassName( 'id' ),
        // names  = [].map.call(inputs, function( input ) {
        //     return input.value;
        // });
    }
</script>
@endsection
