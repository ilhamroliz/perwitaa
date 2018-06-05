@extends('main')

@section('title', 'dashboard')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
         <div class="ibox-title">
                    <h5>Tambah Entri Tranaksi</h5>
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
                    {!! Form::open(['url' => 'entri-transaksi/data-transaksi/store', 'files' => true,'class'=>'form-horizontal','method'=>'get']) !!}  
                    <input type="hidden" id="jr_transsub" class="form-control pull-right" name="jr_transsub" value="{{old('jr_transsub')}}">
                    <input type="hidden" id="jrdt_acc1" class="form-control pull-right" name="jrdt_acc1" value="{{old('jrdt_acc1')}}">
                    <input type="hidden" id="jrdt_acc2" class="form-control pull-right" name="jrdt_acc2" value="{{old('jrdt_acc2')}}">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Date:</label>
                            <div class="col-sm-3">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <a data-toggle="modal" data-target="#modal_transaksi"><i class="fa fa-calendar"></i></a>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker" name="tanggal" value="{{old('tanggal')}}" readonly="" >
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
                                    <input type="text" class="form-control pull-right modalshow" id="kodetrans" name="KodeTransaksi" placeholder="Pilih Kode Transaksi" readonly value="{{old('KodeTransaksi')}}" >
                                </div>
                            </div>
                        </div>                                                      
                        <div class="form-group">
                            <label for="Nominal" class="col-sm-2 control-label">Transaksi</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="Transaksi" placeholder="Transaksi" id="transaksi" readonly value="{{old('Transaksi')}}">
                            </div>                                
                        </div>

                        <div class="form-group">
                            <label for="tipecashFlow" class="col-sm-2 control-label">Tipe CashFlow</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="Tipe" placeholder="Tipe CashFlow" id="tipe" readonly value="{{old('Tipe')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Nominal" class="col-sm-2 control-label"> Akun 01</label>
                            <div class="col-sm-1"><input type="text" class="form-control dk1" name="dk1" readonly value="{{old('dk1')}}"></div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  placeholder="Akun 01 " name="akun1" id="akun1" readonly value="{{old('akun1')}}">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="Nominal" class="col-sm-2 control-label"> Akun 02</label>
                            <div class="col-sm-1"><input type="text" class="form-control dk2" name="dk2" readonly value="{{old('dk2')}}"></div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="akun2" placeholder="Akun 02" id="akun2" readonly value="{{old('akun2')}}">
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="Nominal" class="col-sm-2 control-label">Nominal</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control saldo" name="Nominal" placeholder="Nominal" value="{{old('Nominal')}}">
                            </div>
                        </div>
                        {{--
                                <div class="form-group">
                                    <label for="Member" class="col-sm-2 control-label">Member</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('Member', $d_mem, null, ['class' => 'form-control', 'id' => 'id_kelas', 'placeholder' => '-- Pilih Member --']) !!}                                       
                                    </div>
                                </div>
                                --}}                                                              
                        <div class="form-group">
                            <label for="KodeSub" class="col-sm-2 control-label">Anak Perusahaan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="kodeSub" placeholder="Anak Perusahaan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Poject" class="col-sm-2 control-label">Poject</label>
                            <div class="col-sm-9">
                                <input type="text"  class="form-control sa" name="Poject" placeholder="Poject">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Poject" class="col-sm-2 control-label">Note</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="Note" placeholder="Note">
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
                             <a href="{{ url('entri-transaksi/data-transaksi') }}" class="btn btn-danger btn-outline btn-flat btn-sm save">Kembali</a>
                            <button type="submit" class="btn btn-primary btn-flat btn-sm">Simpan Data</button> 
                        </div>
                    </div>
                    </div>


                    <!-- /.box-footer -->                        
                    {!! Form::close() !!}

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
    }).datepicker("setDate", "0");

    $('#trans tbody').on('click', 'tr', function () {
        var a = table.row(this).data();
        $('#kodetrans').val(a[0]);
        $('#transaksi').val(a[1]);
        $('#jr_transsub').val(a[7]);        
        $('#jrdt_acc1').val(a[8]);        
        $('#jrdt_acc2').val(a[9]);        
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


<div class="modal fade" id="modal_transaksi" tabindex="-1" role="dialog" aria-labelledby="mTambahUserLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mTambahUserLabel">Pilih Transaksi</h4>
            </div>

            <div class="modal-body">

                <table id="trans" class="table table-striped" cellspacing="0" >
                    <thead>
                        <tr>
                            <th style="display: 10px">Kode</th>
                            <th>Nama Transaksi</th>                            
                            <th>Tipe Cashflow</th>                            
                            <th >Akun 01</th>                                                        
                            <th>Akun 02</th>
                            <th style="display: none" >Dk 01</th>
                            <th style="display: none">Dk 02</th>
                            <th style="display: none">tr_code_sub</th>
                            <th style="display: none">Kode Akun 1</th>
                            <th style="display: none">Kode Akun 2</th>
                            
                        </tr>
                    </thead>                    
                    <tbody>
                        @foreach($trans as $trans)
                        <tr>                            
                            <td>{{$trans->tr_code}}</td>
                            <td>{{$trans->tr_name}}</td>
                            @if($trans->tr_cashtype=='O')
                            <td>Operating Cash Flow</td>
                            @elseif($trans->tr_cashtype=='I')
                            <td>Investing Cash Flow</td>
                            @elseif($trans->tr_cashtype=='F')
                            <td>Financial Cash Flow</td>
                            @else
                            <td>-</td>
                            @endif                            
                            <td>{{$trans->coa1name}}</td>                                          
                            <td>{{$trans->coa2name}}</td>
                            <td style="display: none">{{$trans->tr_acc01dk}}</td>              
                            <td style="display: none">{{$trans->tr_acc02dk}}</td>
                            <td style="display: none">{{$trans->tr_codesub}}</td>
                            <td style="display: none">{{$trans->tr_acc01}}</td>
                            <td style="display: none">{{$trans->tr_acc02}}</td>
                        </tr>                       
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>



