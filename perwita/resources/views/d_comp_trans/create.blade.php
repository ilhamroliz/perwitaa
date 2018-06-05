@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content">
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
    
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
    
    
        <div class="panel-heading">Buat Master Transaksi           
        </div>
        <div class="panel-body">  
            {{ Form::open(['id'=>'formTrans', 'files' => true]) }}
            <div class="form-horizontal">                                                                 
                <div class="form-group">
                    <label class="control-label col-sm-2" >Kategori</label>
                    <div class="col-sm-7 div_parentCoa">
                        <select class="form-control"  id="kode" name="Kategori" onchange="chekTransaksi();
                                        setAkun();">
                            @foreach($trans_cat as $trans_cat)
                            <option value="{{$trans_cat->tt_code}}" @if(old('Kategori')==$trans_cat->tt_code) selected="selected" @endif>{{$trans_cat->tt_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">                            
                    <label class="control-label col-sm-2">Kode Transaksi</label>
                    <div class="col-sm-4">
                        <input  type="text" class="form-control" id="code_trans" name="Kode Transaksi" placeholder="" readonly value="{{old('Kode_Transaksi')}}">
                    </div>
                </div>

                <div class="form-group">                            
                    <label class="control-label col-sm-2" >Nama Transaksi</label>
                    <div class="col-sm-7">
                        <input type="text" onblur="chekTransaksi()" class="form-control" id="nama_trans" name="Nama Transaksi" placeholder="Masukkan Nama Transaksi" value="{{old('Nama_Transaksi')}}">
                    </div>
                </div>  

                <div class="form-group">                            
                    <label class="control-label col-sm-2" >Sub Nama</label>
                    <div class="col-sm-7">
                        <input  type="text" class="form-control" id="sub_nama" name="Sub Nama" placeholder="Masukkan Sub Nama Transaksi" value="{{old('Sub_Nama')}}">
                    </div>
                </div> 

                <div class="form-group">
                    <label class="control-label col-sm-2" >Cash Type</label>                            
                    <div class="col-sm-7 div_parentCoa">
                        <select class="form-control"  id="cashtype" name="Cash Type" onchange="setAkun()">                        
                            <option value="-">-</option>                                    
                            <option value="O" >Operating Cash Flow</option>                                    
                            <option value="F">Financing Cash Flow</option>                                    
                            <option value="I">Investing Cash Flow</option>                                                                        
                        </select>
                    </div>
                </div>                   

                <div class="form-group">
                    <label class="control-label col-sm-2" >Akun 1</label>
                    <div class="col-sm-7 gantiAkun1">
                        <select class="form-control"  id="Account01" name="Account01" onchange="account()">
                            @foreach($acc01 as $select)
                            <option value="{{$select->coa_code}}" @if(old('Account01')==$select->coa_code) selected="selected" @endif>{{$select->coa_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" >Debit/Kredit</label>
                    <div class="col-sm-7 gantiDk1">
                        <select class="form-control"  id="tr_acc01dk" name="tr_acc01dk" onchange="account()">                                   
                            <option  @if(old('tr_acc01dk')=='Kredit') selected="selected" @endif>Kredit</option>                                   
                            <option  @if(old('tr_acc01dk')=='Debet') selected="selected" @endif>Debet</option>                                   
                        </select>
                    </div>
                </div> 

                <div class="form-group">
                    <label class="control-label col-sm-2" >Akun 2</label>
                    <div class="col-sm-7 gantiAkun2">
                        <select class="form-control"  id="Account02" name="Account02" onchange="account()">
                            @foreach($acc01 as $select)
                            <option value="{{$select->coa_code}}" @if(old('Account02')==$select->coa_code) selected="selected" @endif>{{$select->coa_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  

                <div class="form-group">
                    <label class="control-label col-sm-2" >Debit/Kredit</label>
                    <div class="col-sm-7 gantiDk2">
                        <input class="form-control"  id="tr_acc02dk" name="tr_acc02dk" readonly>                                   
                    </div>
                </div> 
                <div class="col-md-12" style="margin:10px; border-bottom: 2px solid #efefef; padding:0px;">
                    <div class="col-md-3" style="padding:0px;">

                    </div>
                    <div class="col-md-5 image-holder" style="padding:0px; padding-bottom: 20px;">

                    </div>
                </div>
                <div class="col-sm-4 col-md-offset-10" style="padding-top:10px;">
                    <div class="form-group">
                        <a href="{{ url('data-master/master-transaksi-akun') }}" class="btn btn-danger btn-flat btn-sm">Batalkan</a>
                        <button type="button" class="btn btn-primary btn-flat btn-sm save">Simpan Data</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}

        </div>   
    </div>   
    </div>   
    </div>   
</div>   



{{--
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5></h5> 
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">



            </div>
        </div>

    </div>


</div>
--}}
@endsection



@section('extra_scripts')
<script type="text/javascript">
    setAkun();
    function setAkun() {
        $kode = $('#kode').val();
        $cashtype = $('#cashtype').val();

        $('html, body').css("cursor", "wait");
        $.ajax({
            url: baseUrl + '/data-master/master-transaksi-akun/set-akun/' + $kode + '/' + $cashtype,
            method: 'get',
            success: function (response) {
                console.log(response);
                if (response) {
                    $('.gantiAkun1').html(response.akun1);
                    $('.gantiAkun2').html(response.akun2);
                    $('.gantiDk1').html(response.dk1);
                    $('.gantiDk2').html(response.dk2);
                    $('html, body').css("cursor", "default");
                }
            }
        });


    }
    function chekTransaksi() {
        if ($('#nama_trans').val() != '') {
            $('html, body').css("cursor", "wait");
            $.ajax({
                url: baseUrl + '/data-master/master-transaksi-akun/cheknama/' + $('#nama_trans').val() + '/' + $('#kode').val(),
                method: 'get',
                success: function (response) {
                    if (response) {
                        $('#code_trans').val(response);
                        $('html, body').css("cursor", "default");
                    }
                }
            });
        }
    }
    account()
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

    var trdk = $('#tr_acc01dk').val();
    var tr01 = $('#Account01').val();
    var tr02 = $('#Account02').val();
    if (tr02) {
        var tr01 = tr01.substring(0, 1);
        var tr02 = tr01.substring(0, 1);
    }

    var info = $('.info');
    $('.save').click(function (e) {
        //$('#editCompTrans').submit();
        //alert($('#editCompTrans').serialize());
        info.hide().find('ul').empty();
        e.preventDefault();
        $.ajax({
            type: "get",
            url: baseUrl + '/data-master/master-transaksi-akun/store',
            data: $('#formTrans').serialize(),
            success: function (data) {
                console.log(data);
                if (data.success == false)
                {

                    $.each(data.errors, function (index, error) {
                        info.find('ul').append('<li>' + error + '</li>');
                    });
                    info.slideDown();
                }
                else if (data.success == 'edit') {
                    window.location.href = baseUrl + '/data-master/master-transaksi-akun/edit/' + data.tr_code + '/' + data.tr_codesub;
                }
                else {
                    window.location.href = baseUrl + '/data-master/master-transaksi-akun';
                }
            }
        });
    });






</script>
@endsection
