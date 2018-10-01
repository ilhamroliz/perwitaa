@extends('main')

@section('title', 'dashboard')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Master Perusahaan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                <a>Data Master</a>
            </li>
            <li class="active">
                <strong>Master Data Akun</strong>
            </li>
        </ol>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Tambah Sub Akun</h5>
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

                    {{ Form::open(['id'=>'createAkun', 'files' => true]) }}

                    <div >
                        <div class="form-group form-inline col-md-6">
                            <div class="col-md-4">
                                <label for="exampleInputName2" style="padding-top: 7px;">Tahun Akun</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                       <input   readonly="" value="" type="number" class="form-control " id="tahunakun" name="Tahun Akun" placeholder="Tahun Akun">
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-inline col-md-6">
                            <div class="col-md-4">
                                <label class="control-label col-sm-2" >Level COA</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input class="form-control "  id="level_coa" name="Level COA" value="{{$coa->coa_level+1}}" readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" >Parent COA</label>
                            <div class="col-sm-2 div_parentCoa">
                                <input type="hidden" id="Parent_COA" class="form-control"  name="Parent COA" value="{{$coa_level->coa_code}}" readonly="">
                                <input class="form-control" value="{{$coa_level->coa_name}}" readonly="">
                                {{--<select class="form-control"  id="Parent_COA" name="Parent COA" onchange="hapus()">
                            <option value="{{$coa_level->coa_code}}" @if($coa_level->coa_code==$coa->coa_code) selected='selected' @endif>{{$coa_level->coa_name}}</option>
                                </select>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="kodeinput">
                                <label class="control-label col-sm-2" >Masukkan Kode</label>
                                <div class="col-sm-2">
                                    <input title="Kode Maks. 2 Digit" data-toggle="tooltip" data-placement="bottom" type="number" class="form-control " id="kode" name="Kode" placeholder="Masukkan Kode" onchange="chekminus()"  maxlength="2">
                                </div>
                            </div>
                            <label class="control-label col-sm-2" >Kode Akun</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control " id="coa_code" name="Kode Akun" placeholder="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" >Nama Akun</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control " id="coa_code" name="Nama Akun" placeholder="Masukkan Nama Akun">
                            </div>
                        </div>
                        {{--<div class="form-group">
                    <label class="control-label col-sm-2" >Akun Induk</label>
                    <div class="col-sm-9">
                        <select class="form-control"  id="AkunInduk" name="Akun Induk">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>--}}
                        {{--<div class="form-group">
                    <label class="control-label col-sm-2" >Akun Memiliki Saldo</label>
                    <div class="col-sm-9">
                        <select class="form-control"  id="Akun Memiliki Saldo" name="Akun Memiliki Saldo">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>--}}
                        <div class="form-group">
                            <label class="control-label col-sm-2" >Tanggal Pembukaan Akun</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control " id="coa_opening_tgl" placeholder="Masukkan Tanggal Pembukaan Akun" name="Coa Opening Tgl">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" >Pembukaan Akun</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="pembukaan_akun" name="Pembukaan Akun" placeholder="Masukkan Pembukaan Akun">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12" style="margin:10px; border-bottom: 2px solid #efefef; padding:0px;">
                        <div class="col-md-3" style="padding:0px;">

                        </div>
                        <div class="col-md-5 image-holder" style="padding:0px; padding-bottom: 20px;">

                        </div>
                    </div>

                    <div class="col-md-offset-9" style="padding-top:10px;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-outline btn-flat btn-sm save">Simpan Data</button>
                        </div>
                    </div>

                    {{ Form::close() }}




                </div>
            </div>

        </div>


    </div>
</div>


















@endsection


@section('extra_scripts')
<script type="text/javascript">

    var info = $('.info');
    $('.save').click(function (e) {
        info.hide().find('ul').empty();
        e.preventDefault();
        $.ajax({
            type: "post",
            url: baseUrl + '/data-master/master-akun/store',
            data: $('#createAkun').serialize(),
            success: function (data) {
                console.log(data);
                if (data.success == false)
                {

                    $.each(data.errors, function (index, error) {
                        info.find('ul').append('<li>' + error + '</li>');
                    });
                    info.slideDown();
                } else {
                    window.location.href = baseUrl + '/data-master/master-akun'
                }
            }
        });
    });
    function chekminus() {
//        alert('s')

    }
    $('#kode').tooltip();
    $('#kode').unbind('keyup change input paste').bind('keyup change input paste', function (e) {

        var $this = $(this);
//        alert(parseInt($(this).val()));
//        alert($('#tahunakun').val());
        var val = $this.val();
        var valLength = val.length;
        var maxCount = $this.attr('maxlength');
        if (valLength > maxCount) {
            $this.val($this.val().substring(0, maxCount));
        }
    });
    function chek() {
        $('#kode').unbind('keyup change input paste').bind('keyup change input paste', function (e) {
//        alert(parseInt($(this).val()));
//        alert($('#tahunakun').val());
            if ($('#kode').val() < 0) {
                $('#kode').val('');
            }
            var $this = $(this);
            var val = $this.val();
            var valLength = val.length;
            var maxCount = $this.attr('maxlength');
            if (valLength > maxCount) {
                $this.val($this.val().substring(0, maxCount));
            }
        });
    }


    //$('.save').prop('disabled', true);
    $kode_level_23 = '<div class="kodeinput">\n' +
            '<label class="control-label col-sm-2" >Masukkan Kode</label>\n' +
            '<div class="col-sm-2">\n' +
            '<input title="Kode Maks. 2 Digit" data-toggle="tooltip" data-placement="bottom" type="number" class="form-control" id="kode" name="Kode" placeholder=""  maxlength="2" >\n' +
            '</div> \n' +
            '</div>';
    $kode_level_4 = '<div class="kodeinput">\n' +
            '<label class="control-label col-sm-2" >Masukkan Kode</label>\n' +
            '<div class="col-sm-2">\n' +
            '<input title="Kode Maks. 4 Digit" data-toggle="tooltip" data-placement="bottom" type="number" class="form-control" id="kode" name="Kode" placeholder=""  maxlength="4" >\n' +
            '</div> \n' +
            '</div>';
    var level = $('#level_coa').val();
    if (level == 4) {
        $('.kodeinput').html($kode_level_4);
        chek();
        coa_code();
        hapus();
    } else if (level == 2 || level == 3) {
        $('.kodeinput').html($kode_level_23);
        chek();
        coa_code();
        hapus();
    }
    $('#coa_opening_tgl').datepicker({
        format: 'dd-M-yyyy',
    });
    function level() {

        $.ajax({
            url: 'coa_level/' + $('#level_coa').val(),
            method: 'get',
            success: function (response) {
                $('.div_parentCoa').html(response);
            }
        });
        var level = $('#level_coa').val();
        if (level == 4) {
            $('.kodeinput').html($kode_level_4);
            chek();
            coa_code();
            hapus();
        } else if (level == 2 || level == 3) {
            $('.kodeinput').html($kode_level_23);
            chek();
            coa_code();
            hapus();
        }

    }

    function coa_code() {
        $('#kode').keyup(function () {
            var level = $('#level_coa').val();
            var parent_coa = $('#Parent_COA').val();
            var kode = $('#kode').val();
            if (level == 2) {
                coa_awal = parent_coa.substring(0, 1);
                //alert(coa_awal);
                if (kode.length == 0) {
                    $('#coa_code').val('');
                }
                else if (kode.length == 1) {
                    $('#coa_code').val(coa_awal + '0' + kode + '000000');
                }
                if (kode.length == 2) {
                    $('#coa_code').val(coa_awal + kode + '0000000');
                }
            }
            else if (level == 3) {
                coa_awal = parent_coa.substring(0, 3);
                // alert(coa_awal);
                if (kode.length == 0) {
                    $('#coa_code').val('');
                }
                else if (kode.length == 1) {
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
                else if (kode.length == 0) {
                    $('#coa_code').val('');
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

            if (kode.length == 1) {
                $('#coa_code').val(coa_awal + '0' + kode + '000000');
            }
            else if (kode.length == 2) {
                $('#coa_code').val(coa_awal + kode + '000000');
            }
            else if (kode.length == 0) {
                $('#coa_code').val('');
            }
        }
        else if (level == 3) {
            coa_awal = parent_coa.substring(0, 3);
            //alert(coa_awal);
            if (kode.length == 0) {
                $('#coa_code').val('');
            }
            else if (kode.length == 1) {
                $('#coa_code').val(coa_awal + '0' + kode + '0000');
            }
            else if (kode.length == 2) {
                $('#coa_code').val(coa_awal + kode + '0000');
            }
        }
        else if (level == 4) {
            coa_awal = parent_coa.substring(0, 5);
            if (kode.length == 0) {
                $('#coa_code').val('');
            }
            else if (kode.length == 1) {
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

</script>
@endsection
