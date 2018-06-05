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

 <form id="form-pekerja" method="get" action="store4">
  <h5>Jenis Surat</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
                </div>   
<div class="ibox-content">
 
    <div class="row">
        <label for="nik"  class="col-sm-2 col-form-label">Jenis Surat</label>
        <div class="col-sm-10">
        <select class="form-control" onchange="location = this.value;">
            <option value=""  style="color: grey;" disabled="">-Pilih Jenis Surat-</option>
            <option value="create" style="color: black;">Surat Keterangan Pengalaman Kerja</option>
            <option value="create-tkerja" style="color: black;">Surat Keterangan Tidak lagi Bekerja</option>
            <option value="create-daupa" style="color: black;">Surat Permohonan Legalisir Data Upah</option>
            <option value="create-tibpjs" style="color: black;">Surat Keterangan Tidak Aktif BPJS</option>
            <option value="create-resign" style="color: black;">Surat Laporan Pekerja Resign</option>
            <option value="create-pibank" style="color: black;">Surat Pengajuan Pinjaman Bank</option>
            <option value="create-pebpjs" style="color: grey;" selected="true" disabled="">Surat Pengantar Pendaftaran BPJS kesehatan</option>
            <option value="create-pekpr" style="color: black;">Surat Keterangan Kerja Pengajuan KPR</option>
        </select>
    </div>
    </div>
     <div class="form-group row">
                            <label for="nik"  class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" value="{{$k}}" name="id" id="id" placeholder="Masukkan No kartu" >
                           
                           


                            </div>
                        </div>
                    
            
                        <div class="form-group row">
                            <label for="nik"  class="col-sm-2 col-form-label">No Surat</label>
                            <div class="col-sm-10">
<input type="text" class="form-control"  name="no_surat" id="no_surat" value="{{$itung}}/{{$bulan}}{{$year}}" 
readonly="true" placeholder="Masukkan No kartu" >
                          


                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" class="form-control" name="tgl" id="tgl" placeholder="Masukkan Tanggal" readonly="true">
                               
                                 @if($errors->has('tgl'))
                                <small style="color: #ed5565">{{ $errors->first('tgl')}}</small>
                            @endif
                            </div>
                        </div>
                         
                        <div class="form-group row">
                            <label for="nik"  class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" value="Pendaftaran BPJS" name="kop_surat" id="kop_surat" placeholder="Masukkan No kartu" >
                            </div>
                        </div>


</div>
       <div class="ibox-title">              
                    <h5>Penanggung jawab</h5>
                  
                </div>   
               
                <div class="ibox-content">

                        <div class="form-group row">
                            <label for="tmt" class="col-sm-2 col-form-label">Penanggung jawab nama</label>
                            <div class="col-sm-10">
                                <input type="hidden" id="n_pj" name="n_pj" class="form-control tujuan"/>
                                <input type="text" class="form-control" name="n_pj" value="{{old('n_pj')}}" id="npj" placeholder="Masukkan Nama" >
                                     @if($errors->has('n_pj'))
                                <small style="color: #ed5565">{{ $errors->first('n_pj')}}</small>
                            @endif
                                
                            </div>
                        </div>  
                         <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Penanggung jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="j_pj" value="{{old('j_pj')}}" id="j_pj" placeholder="Masukkan Jabatan" >
                                
                                     @if($errors->has('j_pj'))
                                <small style="color: #ed5565">{{ $errors->first('j_pj')}}</small>
                            @endif
                                
                            </div>
                        </div>   
                        
                        
                        <div class="form-group row">
                            <label for="pendidikan" class="col-sm-2 col-form-label">Penanggung jawab Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="a_pj" id="a_pj" value="{{old('a_pj')}}" placeholder="Masukkan Alamat" >
                                
                                 @if($errors->has('a_pj'))
                                <small style="color: #ed5565">{{ $errors->first('a_pj')}}</small>
                            @endif
                            </div>
                        </div>
                         <div class="form-group row">   
                         <label for="ibu" class="col-sm-2 col-form-label">Nama instansi</label>
                            <div class="col-sm-10">
                             <SELECT name="instansi" id="instansi" class="form-control" value="{{old('instansi')}}">
                                <option value="" selected="true" disabled="true">-Pilih instansi-</option>
                                <option value="PT-PN/MJI" >PT PERWITA NUSANTARA MJI</option>
                                <option value="PT-AWKB" >PT AMERTA WIDIYA KARYA BHAKTI</option>
                             </SELECT>
                              @if($errors->has('instansi'))
                                <small style="color: #ed5565">{{ $errors->first('instansi')}}</small>
                            @endif
                            </div>
                        </div>
                            

    </div>
                <div class="ibox-title">
                    <h5>Menerangkan</h5>
                </div>                                                         
               
  <div class="ibox-content">
                         
                         <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                             <input type="hidden" id="nama" name="nama" class="form-control tujuan"/>
                                <input type="text" class="form-control" name="nama" id="nama1" value="{{old('nama')}}" placeholder="Masukkan Nama" >
                                 @if($errors->has('nama'))
                                <small style="color: #ed5565">{{ $errors->first('nama')}}</small>
                            @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Nomor KPK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="kpk" value="{{old('kpk')}}" id="kpk" placeholder="Masukkan Nomor KPK">
                            @if($errors->has('kpk'))
                                <small style="color: #ed5565">{{ $errors->first('kpk')}}</small>
                            @endif
                                 
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Nomor KPJ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="kpj" value="{{old('kpj')}}" id="kpj" placeholder="Masukkan Nomor KPJ">
                            @if($errors->has('kpj'))
                                <small style="color: #ed5565">{{ $errors->first('kpj')}}</small>
                            @endif
                                 
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Nomor BU</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="bu" value="{{old('bu')}}" id="bu" placeholder="Masukkan Nomor BU">
                            @if($errors->has('bu'))
                                <small style="color: #ed5565">{{ $errors->first('bu')}}</small>
                            @endif
                            </div>
                        </div>
                          <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{old('jabatan')}}" placeholder="Masukkan Jabatan" >
        
                                 @if($errors->has('jabatan'))
                                <small style="color: #ed5565">{{ $errors->first('jabatan')}}</small>
                            @endif
                            </div>
                        </div>

                          <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="alamat" value="{{old('alamat')}}" id="alamat" placeholder="Masukkan Alamat">
        
                                 @if($errors->has('alamat'))
                                <small style="color: #ed5565">{{ $errors->first('alamat')}}</small>
                            @endif
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="ibu" class="col-sm-2 col-form-label">Nama sub instansi</label>
                            <div class="col-sm-10">
                             <SELECT name="mitra" id="mitra" class="form-control" value="{{old('mitra')}}">
                                <option value="" selected="true">-Pilih Subinstansi-</option>
                                  @foreach ($mitra as $a)
                                            <option value="{{ $a -> m_id }}">{{$a -> m_name}}</option>
                                    @endforeach
                             </SELECT>
                              @if($errors->has('mitra'))
                                <small style="color: #ed5565">{{ $errors->first('mitra')}}</small>
                            @endif
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label for="tglLahir" class="col-sm-2 col-form-label">Tanggal mulai</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" class="form-control" name="tgl_m" value="{{old('tgl_m')}}" id="tgl_m" placeholder="Masukkan Tanggal Mulai Bekerja" >
                               
                         @if($errors->has('tgl_m'))
                                <small style="color: #ed5565">{{ $errors->first('tgl_m')}}</small>
                            @endif
                                
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="tglLahir" class="col-sm-2 col-form-label">Tanggal berhenti</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" class="form-control" name="tgl_b" id="tgl_b" value="{{old('tgl_b')}}" placeholder="Masukkan Tanggal Berhenti Bekerja" >
                               
                         @if($errors->has('tgl_b'))
                                <small style="color: #ed5565">{{ $errors->first('tgl_b')}}</small>
                            @endif
                                
                            </div>
                        </div>

                                                                 
               

                         <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                               <a href="{{url('surat')}}" class="btn btn-danger btn-flat" type="button">Kembali</a>
                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                        <button class="ladda-button ladda-button-demo btn btn-primary btn-flat simpan" type="submit" name="Insert" value="Insert">
                                            Simpan
                                        </button>
                                    </div>
                                </div>  
                                </div>
                            </form>
                                </div>
                                </div>

                </div>
   
   





@endsection



@section('extra_scripts')

<script type="text/javascript">
     
      $('#tgl').datepicker({
            
        dateFormat: 'dd-mm-yy',
       
        language: "id"
    }).datepicker("setDate","0");
        $('#tgl_b').datepicker({
            
        dateFormat: 'dd-mm-yy',
       
        language: "id"
    }).datepicker("setDate","0");
          $('#tgl_m').datepicker({
            
        dateFormat: 'dd-mm-yy',
       
        language: "id"
    }).datepicker("setDate","0");
      

     
 
        $("#npj").autocomplete({
        source: baseUrl+'/surat/create/autocomplete',
        minLength: 2,
        select: function(event, ui) {
        $('#n_pj').val(ui.item.id);
        $('#npj').val(ui.item.label);

        getData(ui.item.id);

    }
});
        function getData(){
        var npj=$('#n_pj').val();    
        $.ajax({        
            url: baseUrl+'/getData/'+npj,
            type:'get',
            success:function(response){
                
                $('#a_pj').val(response.alamat);
            }
        })

}

        $("#nama1").autocomplete({
        source: baseUrl+'/surat/create/auto',
        minLength: 2,
        select: function(event, ui) {
        $('#nama').val(ui.item.id);
        $('#nama1').val(ui.item.label);

        getDatanama(ui.item.id);
        
    }
});
         function getDatanama(){
        var a=$('#nama').val();    
        $.ajax({        
            url: baseUrl+'/getDatanama/'+a,
            type:'get',
            success:function(response){
                $('#alamat').val(response.address);
                $('#kpk').val(response.kpk);
                $('#kpj').val(response.kpj);
                $('#bu').val(response.bu);

            }
        })

}
$('#instansi').change(function(){
$('#no_surat').val(( {{$itung}} + "/" + this.value + "/" + "{{$bulan}}" + "{{$year}}"));
   
});

</script>

@endsection
