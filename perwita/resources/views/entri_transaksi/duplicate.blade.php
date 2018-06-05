@extends('main')

@section('title', 'dashboard')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tambah Transaksi</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                  <a href="{{ url('entri-transaksi/data-transaksi') }}">Data Transaksi</a>
            </li>
            <li class="active">
                <strong>Tambah Transaksi</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Tambah Entri Transaksi</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                              
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    {!! Form::open(['url' => 'entri-transaksi/data-transaksi/simpan-duplikasi/'.$jurnal->jr_id, 'files' => true,'class'=>'form-horizontal','method'=>'get']) !!}  
                    <input type="hidden" id="jr_transsub" class="form-control pull-right" name="jr_transsub" value="{{$jurnal->jr_transsub}}">
                    <input type="hidden" id="jrdt_acc1" class="form-control pull-right" name="jrdt_acc1" value="{{$akun1}}">
                    <input type="hidden" id="jrdt_acc2" class="form-control pull-right" name="jrdt_acc2" value="{{$akun2}}">                   
                    <div class="box-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="jr_id" placeholder="Kode Transaksi" id="jr_id" value="{{$jurnal->jr_id}}" readonly>
                            <label class="col-sm-2 control-label">Date:</label>
                            <div class="col-sm-3">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker" name="tanggal" value="{{Carbon\Carbon::parse($jurnal->jr_tgl)->format('d-M-Y')}}" readonly="" >
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="Kode Transaksi" class="col-sm-2 control-label">Kode Transaksi</label>
                            <div class="col-sm-5">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <a data-toggle="modal" data-target="#modal_transaksi"><i class="glyphicon glyphicon-search"></i></a>
                                    </div>
                                    <input type="text" class="form-control pull-right modalshow" id="kodetrans" name="KodeTransaksi" value="{{$jurnal->jr_trans}}" readonly>
                                </div>
                            </div>
                        </div>                                                       
                        <div class="form-group">
                            <label for="Nominal" class="col-sm-2 control-label">Transaksi</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="Transaksi" placeholder="Transaksi" id="transaksi" value="{{$trans->tr_name}}" readonly>
                            </div>                                
                        </div>

                        <div class="form-group">
                            <label for="tipecashFlow" class="col-sm-2 control-label">Tipe CashFlow</label>
                            <div class="col-sm-10">
                                @if($trans->tr_cashtype='O')
                                <input type="text" class="form-control" name="Tipe" placeholder="Tipe CashFlow" id="tipe" value="OCF" readonly="">
                                @elseif($trans->tr_cashtype='I')
                                <input type="text" class="form-control" name="Tipe" placeholder="Tipe CashFlow" id="tipe" value="ICF" readonly="">
                                @elseif($trans->tr_cashtype='F')
                                <input type="text" class="form-control" name="Tipe" placeholder="Tipe CashFlow" id="tipe" value="FCF" readonly="">
                                @else
                                <input type="text" class="form-control" name="Tipe" placeholder="Tipe CashFlow" id="tipe" value="-" readonly="">
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Nominal" class="col-sm-2 control-label"> Akun 01</label>
                            <div class="col-sm-1">
                                @if($trans->tr_acc01dk==1)
                                <input type="text" class="form-control simbol" name="dk1" value="+" readonly="">
                                @elseif($trans->tr_acc01dk==-1)
                                <input type="text" class="form-control simbol" name="dk1" value="-" readonly="">
                                @endif
                            </div >
                            <div class="col-sm-9">
                                <input type="text" class="form-control"  placeholder="Akun 01 " name="akun1" id="akun1" value="{{$trans->coa1name}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Nominal" class="col-sm-2 control-label"> Akun 02</label>
                            <div class="col-sm-1">
                                @if($trans->tr_acc02dk==1)
                                <input type="text" class="form-control simbol" name="dk2" value="+" readonly="">
                                @elseif($trans->tr_acc02dk==-1)
                                <input type="text" class="form-control simbol" name="dk2" value="-" readonly="">
                                @endif
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="akun2" placeholder="Akun 02" id="akun2" value="{{$trans->coa2name}}" readonly="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Nominal" class="col-sm-2 control-label">Nominal</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control saldo" name="Nominal" placeholder="Nominal" value="{{old('Nominal')}}" >
                            </div>
                        </div>
                       {{-- <div class="form-group">
                            <label for="Member" class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10">
                                <input readonly="" type="text" class="form-control" name="Member" placeholder="Member" value="{{$jurnal->jr_memcode}}">
                            </div>
                        </div>--}}
                        <div class="form-group">
                           <label for="KodeSub" class="col-sm-2 control-label">Anak Perusahaan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="kodeSub" placeholder="Member">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Poject" class="col-sm-2 control-label">Poject</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Poject" placeholder="Poject">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Poject" class="col-sm-2 control-label">Note</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Note" placeholder="Note">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin:10px; border-bottom: 2px solid #efefef; padding:0px;">
                        <div class="col-md-3" style="padding:0px;">

                        </div>
                        <div class="col-md-5 image-holder" style="padding:0px; padding-bottom: 20px;">

                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="col-sm-4 col-md-offset-9" style="padding-top:10px;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary flat btn-sm">Simpan Data</button>                                                                                
                        </div>
                    </div>

                    <!-- /.box-footer -->                        
                    {!! Form::close() !!}

                </div>
            </div>

        </div>


    </div>
</div>







@endsection



@section('extra_scripts')
<script type="text/javascript">
$('.saldo').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0,allowZero:true});
    $(".modalshow").click(function () {
        $("#modal_transaksi").modal("show");
    });


    $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
    });

    $('#trans tbody').on('click', 'tr', function () {
        var a = table.row(this).data();
        $('#kodetrans').val(a[0]);
        $('#transaksi').val(a[1]);
        $('#tipe').val(a[2]);
        if (a[5] == 1) {
            $('.dk1').val('+');
        } else if (a[5] == -1) {
            $('.dk1').val('-');
        }
        if (a[6] == 1) {
            $('.dk2').val('+');
        } else if (a[6] == -1) {
            $('.dk2').val('-');
        }
        $('#akun1').val(a[3]);
        $('#akun2').val(a[4]);

        $('#modal_transaksi').modal('hide');
    });
//        $('#trans tfoot th').each(function () {
//            var title = $(this).text();
//            $(this).html('<input class="input-sm" type="text" placeholder="' + title + '" />');
//        });

    var table = $("#trans").DataTable({
        //responsive: true,

        "pageLength": 10,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        //"scrollY": '50vh',
        //"scrollCollapse": true,
        "language": {
            "lengthMenu": "Tampilkan _MENU_ hasil ",
            "zeroRecords": "Maaf - Tidak ada yang di temukan",
            "info": "Tampilan Halaman _PAGE_ Dari _PAGES_",
            "infoEmpty": "Tidak Ada Hasil Yang Sesuai",
            "infoFiltered": "(Mencari Dari _MAX_ total Hasil)",
            "search": "Pencarian"

        },
    });





    //coa

    $('#coa tbody').on('click', 'tr', function () {
        var a = table_coa.row(this).data();
        $('#dataakun').val(a[0]);
        $('#modal_akun').modal('hide');
    });
    $('#coa tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input class="input-sm" type="text" placeholder="' + title + '" />');
    });

    var table_coa = $("#coa").DataTable({
        //"searching": false,
        //responsive: true,
        //"filter": false,
        "pageLength": 10,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        //"scrollY": '50vh',
        //"scrollCollapse": true,
        "language": {
            "lengthMenu": "Tampilkan _MENU_ hasil ",
            "zeroRecords": "Maaf - Tidak ada yang di temukan",
            "info": "Tampilan Halaman _PAGE_ Dari _PAGES_",
            "infoEmpty": "Tidak Ada Hasil Yang Sesuai",
            "infoFiltered": "(Mencari Dari _MAX_ total Hasil)",
            "search": "Pencarian"

        },
//            fnInitComplete: function (oSettings, json) {
//                $('#coa_length').detach().prependTo("#coa_length");
//
//            },
    });

    table_coa.columns().every(function () {
        var that = this;
        //  $('input', table.column(3).footer()).disabled = true;
        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that
                        .search(this.value)
                        .draw();
            }
        });
    });
    $('#coa_length').prependTo("#coa_length");






</script>
@endsection

