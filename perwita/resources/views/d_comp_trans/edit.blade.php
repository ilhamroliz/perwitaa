@extends('main')

@section('title', 'dashboard')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Edit Master Transaksi</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                <a href="{{ url('data-master/master-transaksi-akun') }}">Data Master Transaksi</a>
            </li>
            <li class="active">
                <strong>Edit Master Transaksi</strong>
            </li>
        </ol>
    </div>
</div>



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
    <div class="panel panel-primary">
        <div class="panel-heading">Edit Data Transaksi</div>
        <div class="panel-body">
            {{ Form::open([ 'id'=>'editCompTrans', 'files' => true,'method'=>'get','url'=>'/data-master/master-transaksi-akun/update/'.$comp_trans->tr_code]) }}
                    <div class="form-horizontal">                                                                                         
                        <input type="hidden" class="form-control" id="tr_codesub" name="tr_codesub" placeholder="" readonly value="{{$comp_trans->tr_codesub}}">
                        <div class="form-group">                            
                            <label class="control-label col-sm-2">Kode Transaksi</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="kode" name="Kategori" placeholder="" readonly value="{{$comp_trans->tr_code}}">
                            </div>
                        </div>
                        <div class="form-group">                            
                            <label class="control-label col-sm-2" >Nama Transaksi</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="nama_trans" name="Nama Transaksi" placeholder="Masukkan Nama Transaksi" value="{{$comp_trans->tr_name}}">
                            </div>
                        </div>  
                        <div class="form-group">                            
                            <label class="control-label col-sm-2" >Sub Nama</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="sub_nama" name="Sub Nama" placeholder="Masukkan Sub Nama Transaksi" value="{{$comp_trans->tr_namesub}}">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="control-label col-sm-2" >Cash Type</label>                            
                            <div class="col-sm-7 div_parentCoa">
                                <select class="form-control"  id="cashtype" name="Cash Type" onchange="setAkun();" >                                    
                                    <option @if($comp_trans->tr_cashtype=='O') selected='selected' @endif value="O">Operating Cash Flow</option>    
                                    <option @if($comp_trans->tr_cashtype=='F') selected='selected' @endif value="F">Financing Cash Flow</option>                                    
                                    <option @if($comp_trans->tr_cashtype=='I') selected='selected' @endif value="I">Investing Cash Flow</option>  
                                    <option @if($comp_trans->tr_cashtype=='-') selected='selected' @endif value="-">-</option>                                    
                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label class="control-label col-sm-3" >Cash Flow</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="cashflow" name="cashflow" placeholder="Masukkan Cash Flow" value="{{$comp_trans->tr_cashflow}}">
                    </div>
                </div>--}}
                <div class="form-group">
                    <label class="control-label col-sm-2" >Akun 1</label>
                    <div class="col-sm-7 div_parentCoa">
                        <select class="form-control"  id="Account01" name="Account01" onchange="account()">
                            @foreach($acc01 as $select)
                            <option value="{{$select->coa_code}}" @if($select->coa_code==$comp_trans->tr_acc01) selected='selected' @endif>{{$select->coa_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" >Debit/Kredit</label>
                    <div class="col-sm-7 div_parentCoa">
                        <select class="form-control"  id="tr_acc01dk" name="tr_acc01dk" onchange="account()">                                   
                            <option  @if($comp_trans->tr_acc01dk=='kredit') selected="selected" @endif>Kredit</option>                                   
                            <option  @if($comp_trans->tr_acc01dk=='debet') selected="selected" @endif>Debet</option>                                
                        </select>
                    </div>
                </div>   
                <div class="form-group">
                    <label class="control-label col-sm-2" >Akun 2</label>
                    <div class="col-sm-7 div_parentCoa">
                        <select class="form-control"  id="Account02" name="Account02" onchange="account()">
                            @foreach($acc01 as $select)
                            <option value="{{$select->coa_code}}" @if($select->coa_code==$comp_trans->tr_acc02) selected='selected' @endif>{{$select->coa_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>                           
                <div class="form-group">
                    <label class="control-label col-sm-2" >Debit/Kredit</label>
                    <div class="col-sm-7 div_parentCoa">
                        <input class="form-control"  id="tr_acc02dk" name="tr_acc02dk" readonly value="{{$comp_trans->tr_acc02dk}}">  
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
                    <a href="{{ url('data-master/master-transaksi-akun') }}" class="btn btn-danger  btn-flat btn-sm ">Batalkan</a>
                    <button type="button" class="btn btn-success btn-flat btn-sm save">Perbarui Data</button>
                </div>
            </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
  {{--  <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">                    
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


</div>--}}
</div>







@endsection



@section('extra_scripts')
<script type="text/javascript">
    setAkun();
    function setAkun() {
        $kode = ($('#kode').val()).substr(0, 2);
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

    account();
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
    var tr_codesub = $('#tr_codesub').val();
    $('.save').click(function (e) {
        //$('#editCompTrans').submit();
        //alert($('#editCompTrans').serialize());
        info.hide().find('ul').empty();
        e.preventDefault();
        $.ajax({
            type: "get",
            url: baseUrl + '/data-master/master-transaksi-akun/update/' + code_trans + '/' + tr_codesub,
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


