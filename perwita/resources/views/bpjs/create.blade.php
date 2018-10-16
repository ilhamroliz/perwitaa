@extends('main')

@section('title', 'dashboard')

@section('content')




<div class="wrapper wrapper-content animated fadeInRight">
    <div class="alert alert-danger pesan" style="display:none;">
          <ul></ul>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Form Tambah Data Bpjs</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>



                <div class="ibox-content">


             <form id="form-pekerja" method="post" action="store">
                        <div class="form-group row">
                            <label for="nik"  class="col-sm-2 col-form-label">No Kartu</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  name="no_kartu" id="no_kartu" placeholder="Masukkan No kartu" value="{{old('no_kartu')}}" >
                            @if($errors->has('no_kartu'))
                                <small style="color: #ed5565">{{ $errors->first('no_kartu')}}</small>
                            @endif


                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Nik</label>
                            <div class="col-sm-10">
                                <span id="basic-addon1">
                                <input type="hidden" id="p_nik" name="p_nik" class="form-control tujuan"/>
                                <input type="text"  value="{{old('p_nik')}}" id="nik" name="p_nik"  class="form-control" placeholder="Masukkan no Nik" onkeydown="setnama()"/>
                            @if($errors->has('p_nik'))
                                <small style="color: #ed5565">{{ $errors->first('p_nik')}}</small>
                            @endif

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Npp</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="npp" id="npp" placeholder="Masukkan Npp" >

                                 @if($errors->has('npp'))
                                <small style="color: #ed5565">{{ $errors->first('npp')}}</small>
                            @endif
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="p_name" id="nama" placeholder="Masukkan Nama" readonly="">

                                 @if($errors->has('p_name'))
                                <small style="color: #ed5565">{{ $errors->first('p_name')}}</small>
                            @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="tglLahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" class="form-control" name="p_birthdate" id="tgl_Lahir" placeholder="Masukkan Tanggal Lahir" >

                         @if($errors->has('p_birthdate'))
                                <small style="color: #ed5565">{{ $errors->first('p_birthdate')}}</small>
                            @endif

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">hub keluarga</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="h_keluarga" id="h_keluarga" placeholder="Masukkan Hubungan keluarga" >

                                     @if($errors->has('h_keluarga'))
                                <small style="color: #ed5565">{{ $errors->first('h_keluarga')}}</small>
                            @endif

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tmt" class="col-sm-2 col-form-label">Tmt</label>
                            <div class="col-sm-10">
                                <input type="text" readonly=""  class="form-control" name="TMT" id="tmt" placeholder="Masukkan Tanggal" >
                                     @if($errors->has('TMT'))
                                <small style="color: #ed5565">{{ $errors->first('TMT')}}</small>
                            @endif

                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Nama Fakses1</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nf_1" id="nf_1" placeholder="Masukkan Nama Fakses" >

                                     @if($errors->has('nf_1'))
                                <small style="color: #ed5565">{{ $errors->first('nf_1')}}</small>
                            @endif

                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="pendidikan" class="col-sm-2 col-form-label">Kelas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="kelas" id="kelas" placeholder="Masukkan Kelas" >

                                 @if($errors->has('kelas'))
                                <small style="color: #ed5565">{{ $errors->first('kelas')}}</small>
                            @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="pendidikan" class="col-sm-2 col-form-label">Status peserta</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  name="p_state" id="s_peserta" placeholder="0" readonly="">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ibu" class="col-sm-2 col-form-label">Nama sub instansi</label>
                            <div class="col-sm-10">
                             <SELECT name="m_id_1" id="m_id" class="form-control">
                                <option value="" selected="true">-Pilih Subinstansi-</option>
                                  @foreach ($mitra as $a)
                                            <option value="{{ $a -> m_id }}">{{$a -> m_name}}</option>
                                    @endforeach
                             </SELECT>


                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="ibu" class="col-sm-2 col-form-label">Nama Divisi</label>
                            <div class="col-sm-10 ">
                             <SELECT name="md_id_1" id="md_id" class="form-control">
                                <option value="" selected="true">-Pilih Divisi-</option>
                                  @foreach ($d_mitra_divisi as $d)
                                            <option value="{{ $d -> md_id }}">{{$d -> md_name}}</option>
                                    @endforeach
                             </SELECT>

                            </div>
                        </div>

                         <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                               <a href="{{url('bpjs')}}" class="btn btn-danger btn-flat" type="button">Kembali</a>
                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                        <button class="ladda-button ladda-button-demo btn btn-primary btn-outline btn-flat simpan" type="submit" name="Insert" value="Insert">
                                            Simpan
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

      $('#tmt').datepicker({

        dateFormat: 'yy-mm-dd',

        language: "id"
    });


        $("#nik").autocomplete({
        source: baseUrl+'/bpjs/create/autocomplete',
        minLength: 1,
        select: function(event, ui) {
        $('#p_nik').val(ui.item.id);
        $('#nik').val(ui.item.label);

    }
});
        $("#nik").autocomplete({
    source: availableTags,
    messages: {
        noResults: '',
        results: function() {}
    }
});
function setnama(){

        var nik=$('#nik').val();
        $.ajax({
            url:baseUrl+'/set-nama/'+nik,
            type:'get',
            success:function(data){
                $('#nama').val(data.p_name);
                $('#tgl_Lahir').val(data.p_birthdate);
                $('#s_peserta').val(data.p_state);
            }
        })

}



</script>

@endsection
