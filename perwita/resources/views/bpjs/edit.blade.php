@extends('main')


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

          <form id="form-pekerja" method="post" action="update&{{ $bpjs->p_nik}}">
                        <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">No Kartu</label>
                            <div class="col-sm-10">
                                <input value="{{ $bpjs->no_kartu }}" type="text" readonly="" class="form-control" name="no_kartu" id="no_kartu" placeholder="Masukkan No p_nik" >

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">nik</label>
                            <div class="col-sm-10">
                                <input value="{{ $bpjs->p_nik }}" type="text" class="form-control" name="p_nik" id="nik" placeholder="Masukkan Nama Pekerja" onkeydown="setnama()" >
                               @if($errors->has('p_nik'))
                                <small style="color: #ed5565">{{ $errors->first('p_nik')}}</small>
                            @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Npp</label>
                            <div class="col-sm-10">
                                <input value="{{ $bpjs->npp }}" type="text" class="form-control" name="npp" id="npp" placeholder="Masukkan Npp" >
                                 @if($errors->has('npp'))
                                <small style="color: #ed5565">{{ $errors->first('npp')}}</small>
                            @endif
                            </div>
                        </div>
  <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input value="{{ $bpjs->p_name }}" type="text" readonly="" class="form-control" name="p_name" id="nama" placeholder="Masukkan Nama Pekerja" >

                            </div>
                        </div>

                          <div class="form-group row">
                            <label for="tglLahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input value="{{ $bpjs->p_birthdate}}" type="text" readonly="" class="form-control" name="p_birthdate" id="tgl_Lahir" placeholder="Masukkan Tanggal Lahir" >

                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">hub keluarga</label>
                            <div class="col-sm-10">
                                <input value="{{ $bpjs->h_keluarga }}" type="text" class="form-control" name="h_keluarga" id="h_keluarga" placeholder="Masukkan Hub keluarga" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Tmt</label>
                            <div class="col-sm-10">
                                <input  value="{{ $bpjs->TMT }}" type="text"  readonly="" class="form-control" name="TMT" id="tmt" placeholder="Masukkan TMT" >

                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Nama Fakses1</label>
                            <div class="col-sm-10">
                                <input value="{{ $bpjs->nf_1 }}" type="text" class="form-control" name="nf_1" id="nf_1" placeholder="Masukkan Fakses" >

                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="pendidikan" class="col-sm-2 col-form-label">Status peserta</label>
                            <div class="col-sm-10">
                                <input value="{{ $bpjs->p_state}}" readonly="" type="text" class="form-control" name="p_state" id="p_state" placeholder="0" >

                            </div>
                        </div>
                     <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">kelas</label>
                            <div class="col-sm-10">
                                <input value="{{ $bpjs->kelas }}" type="text" class="form-control" name="kelas" id="kelas" placeholder="Masukkan Alamat" >

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ibu" class="col-sm-2 col-form-label">Nama sub instansi</label>
                            <div class="col-sm-10">
                               <SELECT name="m_id_1" id="m_id" class="form-control">
                            <option selected="true"  value="" >--Pilih Sub instansi--</option>
                                  @foreach ($mitra as $a)
                                <option value="{{ $a -> m_id }}">{{$a -> m_name}}</option>

                                    @endforeach
                             </SELECT>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="ibu" class="col-sm-2 col-form-label">Nama Divisi</label>
                            <div class="col-sm-10">
                                <SELECT name="md_id_1" id="md_id" class="form-control">
                                <option value="" selected="true">--Pilih Divisi--</option>
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
                                        <button class="ladda-button ladda-button-demo btn-outline btn btn-primary btn-flat simpan" type="submit" name="Update" value="Update">
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
            autoclose : true,
            dateFormat: 'yy-mm-dd',
        });


  $("#nik").autocomplete({
        source: baseUrl+'/bpjs/create/autocomplete',
        minLength: 1,
        select: function(event, ui) {
        $('#p_nik').val(ui.item.id);
        $('#nik').val(ui.item.label);

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
                $('#p_state').val(data.p_state);
            }
        })

}
    </script>
    @endsection
