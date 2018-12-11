@extends('main')

@section('title', 'Permintaan Pekerja')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    .huruf{
        text-transform: capitalize;
    }
    .spacing-top{
        margin-top:15px;
    }
    #upload-file-selector {
        display:none;
    }
    .margin-correction {
        margin-right: 10px;
    }

</style>

@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Permintaan Tenaga Kerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pekerja
            </li>
            <li class="active">
                <strong>Perbarui Data Kontrak Mitra</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="alert alert-danger pesan" style="display:none;">
          <ul></ul>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Form Perbarui Data Kontrak Mitra</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <form id="form-mitra-contract" >
                        <input value="{{$mitra_contract->mc_mitra}}" type="hidden" id="mitra" name="mitra">
                        <input value="{{$mitra_contract->mc_contractid}}" type="hidden" id="id_detail" name="id_detail">
                        <div class="form-group row">
                            <label for="Nama" class="col-sm-2 col-form-label">Tanggal Kontrak</label>
                            <div class="col-sm-3">
                                <input value="{{ Carbon\Carbon::parse($mitra_contract->mc_date)->format('d/m/Y') }}" readonly="" class="form-control" name="Tanggal Kontrak" id="tglKontrak"  required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglKontrak-error">
                                    <small>Tanggal Kontrak harus diisi...!</small>
                                </span>
                            </div>
                            <label for="tglBatas" class="col-sm-2 col-form-label">Batas Kontrak</label>
                            <div class="col-sm-3">
                                <input value="{{ Carbon\Carbon::parse($mitra_contract->mc_expired)->format('d/m/Y') }}" readonly class="form-control" name="Batas Kontrak" id="tglBatas" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="tglBatas-error">
                                    <small>Batas Kontrak harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kontrak" class="col-sm-2 col-form-label">No Kontrak</label>
                            <div class="col-sm-10">
                                <input value="{{$mitra_contract->mc_no}}" type="text" class="form-control" name="kontrak" id="kontrak" placeholder="No Kontrak" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="kontrak-error">
                                    <small>No Kontrak harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="perusahaan" id="perusahaan" required="">

                                    @foreach($comp as $data)
                                    <option @if($mitra_contract->mc_comp == $data->c_id) selected @endif value="{{$data->c_id}}">{{$data->c_name}}</option>
                                    @endforeach
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="perusahaan-error">
                                    <small>Nama Perusahaan harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Nama Mitra</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="mitra" id="mitraselect" required="" onchange="getDivisi()">
                                    @foreach($mitra as $data)
                                    <option @if($mitra_contract->mc_mitra==$data->m_id) selected @endif  value="{{$data->m_id}}">{{$data->m_name}}</option>
                                    @endforeach
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="mitra-error">
                                    <small>Nama Mitra harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Nama Divisi</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="divisi" id="divisiselect" required="">

                                    @foreach($d_mitra_divisi as $d)
                                    <option @if($mitra_contract->mc_divisi==$d->md_id) selected @endif value="{{$d->md_id}}">{{$d->md_name}}</option>
                                    @endforeach
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="mitra-error">
                                    <small>Nama Mitra harus diisi...!</small>
                                </span>
                            </div>
                        </div>

                       <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Jenis Jabatan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="jabatan" id="jabatanselect" required="">
                                    @foreach($jabatan as $jab)
                                    <option @if($mitra_contract->mc_jabatan == $jab->jp_id) selected @endif value="{{$jab->jp_id}}">{{$jab->jp_name}}</option>
                                    @endforeach
                                </select>
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="jabatan-error">
                                    <small>jabatan harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlahPekerja" class="col-sm-2 col-form-label">Jumlah Pekerja</label>
                            <div class="col-sm-3">
                                <input value="{{$mitra_contract->mc_need}}" type="text" class="form-control" name="Jumlah Pekerja" id="jumlahPekerja" placeholder="Masukkan Jumlah Pekerja" required="">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="jumlahPekerja-error">
                                    <small>Jumlah Pekerja harus diisi...!</small>
                                </span>
                            </div>
                            <label for="totalPekerja" class="col-sm-3 col-form-label" style="width:18%">Total Pekerja Terpenuhi</label>
                            <div class="col-sm-3">
                                <input value="{{$mitra_contract->mc_fulfilled}}" type="number" class="form-control" name="totalPekerja" readonly="" id="totalPekerja"  required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Jobdesk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  id="jobdesk" name="jobdesk" required="" value="{{$mitra_contract->mc_jobdesk}}">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="jobdesk-error">
                                    <small>Jobdesk harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mitra" class="col-sm-2 col-form-label">Note</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  id="note" name="note" required="" value="{{$mitra_contract->mc_note}}">
                                <span style="color:#ed5565;display:none" class="help-block m-b-none reset" id="note-error">
                                    <small>Note harus diisi...!</small>
                                </span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                        <a href="{{url('manajemen-kontrak-mitra/data-kontrak-mitra')}}" class="btn btn-danger btn-flat" type="button">Kembali</a>
                                        <button class="ladda-button ladda-button-demo btn btn-outline btn-success btn-flat simpan" type="button" onclick="perbarui()">
                                            Perbarui
                                        </button>
                                    </div>
                                </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('extra_scripts')
<script type="text/javascript">
    var info = $('.pesan');
    $('#tglKontrak').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
      //  endDate: 'today'
    });
    $('#tglBatas').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
        //endDate: 'today'
    });

    $('#perusahaan').chosen({search_contains:true});
    $('#divisiselect').chosen({search_contains:true});
    $('#jabatanselect').chosen({search_contains:true});
    $('#mitraselect').chosen({search_contains:true});

    function perbarui() {
        var mitra=$('#mitra').val();
        var id_detail=$('#id_detail').val();
        var buttonLadda = $('.simpan').ladda();
        buttonLadda.ladda('start');
         if(validateForm()){
        $.ajax({
            url: baseUrl + '/manajemen-kontrak-mitra/data-kontrak-mitra/perbarui/'+mitra+'/'+id_detail,
            // type        : 'post',
            type: 'get',
            timeout: 10000,
            data: $('#form-mitra-contract').serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status == 'berhasil') {
                    window.location = baseUrl + '/manajemen-kontrak-mitra/data-kontrak-mitra';
                } else if(response.status=='gagal'){
                    info.css('display','');
                    $.each(response.data, function(index, error) {
                           info.find('ul').append('<li>' + error + '</li>');
                    });
                    buttonLadda.ladda('stop');
                }



            },
            error: function (xhr, status) {
                if (status == 'timeout') {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                }
                else if (xhr.status == 0) {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                }
                else if (xhr.status == 500) {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                }

                buttonLadda.ladda('stop');
            }
        });
         }else{
              buttonLadda.ladda('stop');
         }
    }

        function validateForm() {
        $('.reset').css('display', 'none');

        var tglKontrak = document.getElementById('tglKontrak');
        var tglBatas = document.getElementById('tglBatas');
        var kontrak = document.getElementById('kontrak');
        var perusahaan = document.getElementById('perusahaan');
        var mitra = document.getElementById('mitra');
        var jumlahPekerja = document.getElementById('jumlahPekerja');
        var divisi = document.getElementById('divisiselect');
        var jabatan = document.getElementById('jabatan');
        var jobdesk = document.getElementById('jobdesk');
        var note = document.getElementById('note');

        //alert(username.value);

        if (tglKontrak.validity.valueMissing) {
            $('#tglKontrak-error').css('display', '');
            return false;
        }
        else if (tglBatas.validity.valueMissing) {
            $('#tglBatas-error').css('display', '');
            return false;
        }
        else if (kontrak.validity.valueMissing) {
            $('#kontrak-error').css('display', '');
            return false;
        }
        else if (perusahaan.validity.valueMissing) {
            $('#perusahaan-error').css('display', '');
            return false;
        }
        else if (mitraselect.validity.valueMissing) {
            $('#mitra-error').css('display', '');
            return false;
        }
        else if (jumlahPekerja.validity.valueMissing) {
            $('#jumlahPekerja-error').css('display', '');
            return false;
        }
        else if (divisiselect.validity.valueMissing) {
            $('#divisi-error').css('display', '');
            return false;
        }
        else if (jabatanselect.validity.valueMissing) {
            $('#jabatan-error').css('display', '');
            return false;
        }
        else if (jobdesk.validity.valueMissing) {
            $('#jobdesk-error').css('display', '');
            return false;
        }
        else if (note.validity.valueMissing) {
            $('#note-error').css('display', '');
            return false;
        }


        return true;
    }

    function getDivisi(){
        waitingDialog.show();
        var mitra = $('#mitra').val();
        $.ajax({
            url: baseUrl + '/manajemen-kontrak-mitra/data-kontrak-mitra/getdivisi',
            type: 'get',
            data: {mitra: mitra},
            success: function(response){
                var data = response.data;
                var tanam = '<option value="" selected="true" disabled="">--Pilih Divisi--</option>';
                for (var i = 0; i < data.length; i++) {
                    tanam = tanam + '<option value='+data[i].md_id+'>'+data[i].md_name+'</option>';
                }
                $('#divisi').html(tanam);
                waitingDialog.hide();
            }, error:function(x, e) {
                waitingDialog.hide();
                if (x.status == 0) {
                    alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                } else if (x.status == 404) {
                    alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                } else if (x.status == 500) {
                    alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                } else if (e == 'parsererror') {
                    alert('Error.\nParsing JSON Request failed.');
                } else if (e == 'timeout'){
                    alert('Request Time out. Harap coba lagi nanti');
                } else {
                    alert('Unknow Error.\n' + x.responseText);
                }
                waitingDialog.hide();
            }
        })
    }


</script>
@endsection
