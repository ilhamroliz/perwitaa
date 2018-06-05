@extends('main')

@section('title', 'dashboard')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Edit Transaksi</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                 <a href="{{ url('entri-transaksi/data-transaksi') }}">Data Transaksi</a>
            </li>
            <li class="active">
                <strong>Edit Transaksi</strong>
            </li>
        </ol>
    </div>
</div>



<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">       
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit Entri Transaksi</h5>
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

                    <div class="alert alert-danger info" style="display:none;">
                        <ul></ul>
                    </div>
                    {!! Form::open(['url' => 'entri-transaksi/data-transaksi/update/'.$jurnal->jr_id, 'files' => true,'class'=>'form-horizontal','method'=>'get']) !!}  
                    <div class="box-body">
                        <div class="form-group">
                            <input type="hidden" id="jr_transsub" class="form-control pull-right" name="jr_transsub" value="{{$jurnal->jr_transsub}}">
                            <input type="hidden" id="jrdt_acc1" class="form-control pull-right" name="jrdt_acc1" value="{{$trans->tr_acc01}}">
                            <input type="hidden" id="jrdt_acc2" class="form-control pull-right" name="jrdt_acc2" value="{{$trans->tr_acc02}}">                   

                            <input type="hidden" class="form-control" name="jr_id" placeholder="Kode Transaksi" id="jr_id" value="{{$jurnal->jr_id}}" readonly>
                            <label class="col-sm-2 control-label">Date:</label>
                            <div class="col-sm-3">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker" name="tanggal" value="{{Carbon\Carbon::parse($jurnal->jr_tgl)->format('d-M-Y')}}" readonly>
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
                                <input type="text" class="form-control saldo" name="Nominal" placeholder="Nominal" value="{{$jurnal->jr_value}}" >
                            </div>
                        </div>
                        {{--
                        <div class="form-group">
                            <label for="Member" class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10">
                                {!! Form::select('Member', $d_mem, $jurnal->jr_memcode, ['class' => 'form-control', 'id' => 'id_kelas', 'placeholder' => '-- Pilih Member --']) !!}                                
                            </div>
                        </div>
                        --}}
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
                    <!-- /.box-body -->
                    <div class="col-md-offset-9" style="padding-top:10px;">
                        <div class="form-group">
                            <div class="col-sm-2"></div><button type="submit" class="btn btn-success flat btn-sm">Perbarui</button>
                            <div class="col-sm-2"></div><a href="{{url('entri-transaksi/data-transaksi/duplikasi/'.$jurnal->jr_id)}}" class="btn btn-warning flat btn-sm">Duplikasi</a>                            
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
    $('.saldo').maskMoney({prefix: 'Rp. ', thousands: '.', decimal: ',', precision: 0, allowZero: true});
    function account() {

        var tr01dk = $('#tr_acc01dk').val();
        var tr02dk = $('#tr_acc02dk').val();
        var tr01 = $('#Account01').val();
        var tr02 = $('#Account02').val();


        var tr01 = tr01.substring(0, 1);
        var tr02 = tr02.substring(0, 1);
        if (tr01 == 1 && tr02 == 1) {
            if (tr01dk == 'Kredit') {
                $("#tr_acc02dk").val("Debet");
            }
            else if (tr01dk == 'Debet') {
                $("#tr_acc02dk").val('Kredit');
            }
        }
        else if (tr01 == 1 && tr02 == 2 || tr01 == 1 && tr02 == 3) {
            if (tr01dk == 'Kredit') {
                $("#tr_acc02dk").val("Debet").change();
            }
            else if (tr01dk == 'Debet') {
                $("#tr_acc02dk").val('Kredit');
            }
        }
        else if (tr01 == 2 && tr02 == 1 || tr01 == 3 && tr02 == 1) {
            if (tr01dk == 'Kredit') {
                $("#tr_acc02dk").val("Debet").change();
            }
            else if (tr01dk == 'Debet') {
                $("#tr_acc02dk").val('Kredit');
            }
        }
        else if (tr01 == 2 && tr02 == 2) {
            if (tr01dk == 'Kredit') {
                $("#tr_acc02dk").val("Debet").change();
            }
            else if (tr01dk == 'Debet') {
                $("#tr_acc02dk").val('Kredit');
            }
        }
        else if (tr01 == 3 && tr02 == 3) {
            if (tr01dk == 'Kredit') {
                $("#tr_acc02dk").val("Debet").change();
            }
            else if (tr01dk == 'Debet') {
                $("#tr_acc02dk").val('Kredit');
            }
        }
        else if (tr01 == 2 && tr02 == 3 || tr01 == 3 && tr02 == 2) {
            if (tr01dk == 'Kredit') {
                $("#tr_acc02dk").val("Debet").change();
            }
            else if (tr01dk == 'Debet') {
                $("#tr_acc02dk").val('Kredit');
            }
        }


    }



    var info = $('.info');
    var code_trans = $('#code_trans').val();
    $('.save').click(function (e) {
        //$('#editCompTrans').submit();
        alert($('#editCompTrans').serialize());
        info.hide().find('ul').empty();
        e.preventDefault();
        $.ajax({
            type: "get",
            url: baseUrl + '/data-master/master-transaksi-akun/update/' + code_trans,
            data: $('#editCompTrans').serialize(),
            success: function (data) {
                console.log(data);
                if (data.success == false)
                {

                    $.each(data.errors, function (index, error) {
                        info.find('ul').append('<li>' + error + '</li>');
                    });
                    info.slideDown();
                }
                else {
                    window.location.href = baseUrl + '/data-master/master-transaksi-akun';
                }
            }
        });
    });
    $('#kode').tooltip();
    $('#kode').unbind('keyup change input paste').bind('keyup change input paste', function (e) {
        var $this = $(this);
        var val = $this.val();
        var valLength = val.length;
        var maxCount = $this.attr('maxlength');
        if (valLength > maxCount) {
            $this.val($this.val().substring(0, maxCount));
        }
    });





    function level() {
        alert($('#kode').val());
        $.ajax({
            url: 'kode/' + $('#kode').val(),
            method: 'get',
            success: function (response) {

                $('#code_trans').val(response);
            }
        });
    }

    function coa_code() {
        $('#kode').keyup(function () {
            var level = $('#level_coa').val();
            var parent_coa = $('#Parent_COA').val();
            var kode = $('#kode').val();
            if (level == 2) {
                coa_awal = parent_coa.substring(0, 1);
                //alert(coa_awal);
                if (kode.length == 1) {
                    $('#coa_code').val(coa_awal + '0' + kode + '000000');
                }
                if (kode.length == 2) {
                    $('#coa_code').val(coa_awal + kode + '0000000');
                }
            }
            else if (level == 3) {
                coa_awal = parent_coa.substring(0, 3);
                // alert(coa_awal);
                if (kode.length == 1) {
                    $('#coa_code').val(coa_awal + '0' + kode + '0000');
                }
                else if (kode.length == 2) {
                    $('#coa_code').val(coa_awal + kode + '0000');
                }
            }
            else if (level == 4) {
                coa_awal = parent_coa.substring(0, 5);
                if (kode.length == 1) {
                    $('#coa_code').val(coa_awal + '000' + kode);
                }
                else if (kode.length == 2) {
                    $('#coa_code').val(coa_awal + '00' + kode);
                }
                else if (kode.length == 3) {
                    $('#coa_code').val(coa_awal + '0' + kode);
                }
                else if (kode.length == 4) {
                    $('#coa_code').val(coa_awal + kode);
                }
            }
        });
    }
    $('#kode').keyup(function () {
        var level = $('#level_coa').val();
        var parent_coa = $('#Parent_COA').val();
        var kode = $('#kode').val();
        if (level == 2) {
            coa_awal = parent_coa.substring(0, 1);
            // alert(coa_awal);
            if (kode.length == 1) {
                $('#coa_code').val(coa_awal + '0' + kode + '000000');
            }
            if (kode.length == 2) {
                $('#coa_code').val(coa_awal + kode + '000000');
            }
        }
        else if (level == 3) {
            coa_awal = parent_coa.substring(0, 3);
            //alert(coa_awal);
            if (kode.length == 1) {
                $('#coa_code').val(coa_awal + '0' + kode + '0000');
            }
            else if (kode.length == 2) {
                $('#coa_code').val(coa_awal + kode + '0000');
            }
        }
        else if (level == 4) {
            coa_awal = parent_coa.substring(0, 5);
            if (kode.length == 1) {
                $('#coa_code').val(coa_awal + '000' + kode);
            }
            else if (kode.length == 2) {
                $('#coa_code').val(coa_awal + '00' + kode);
            }
            else if (kode.length == 3) {
                $('#coa_code').val(coa_awal + '0' + kode);
            }
            else if (kode.length == 4) {
                $('#coa_code').val(coa_awal + kode);
            }
        }
    });
    function hapus() {
        $('#coa_code').val('');
        $('#kode').val('');
    }
    ;
//        function cetakcode(){
//             
//            var level = $('#level_coa').val();
//            var parent_coa = $('#Parent_COA').val();
//            var kode = $('#kode').val();
//            if (level == 2) {
//                coa_awal = parent_coa.substring(0, 1);
//                alert(coa_awal);
//                if (kode.length == 1) {
//                    $('#coa_code').val(coa_awal + '0' + kode + '000000');
//                }
//                if (kode.length == 2) {
//                    $('#coa_code').val(coa_awal + kode + '0000000');
//                }
//            }
//            else if (level == 3) {
//                coa_awal = parent_coa.substring(0, 3);
//                alert(coa_awal);
//                if (kode.length == 1) {
//                    $('#coa_code').val(coa_awal + '0' + kode + '0000');
//                }
//                else if (kode.length == 2) {
//                    $('#coa_code').val(coa_awal + kode + '0000');
//                }
//            }
//            else if (level == 4) {
//                coa_awal = parent_coa.substring(0,5);
//                if (kode.length == 1) {
//                    $('#coa_code').val(coa_awal + '000'+kode);
//                }
//                else if (kode.length == 2) {
//                    $('#coa_code').val(coa_awal + '00'+kode);
//                }
//                else if (kode.length == 3) {
//                    $('#coa_code').val(coa_awal +'0'+kode);
//                }
//                else if (kode.length == 4) {
//                    $('#coa_code').val(coa_awal + kode);
//                }
//            }
//        
//        }

</script>
@endsection


