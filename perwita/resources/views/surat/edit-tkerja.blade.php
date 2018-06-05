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

 <form id="form-pekerja" method="post" action="/pwt/surat/update1&{{ $surat->id_surat}}">
  <h5>Jenis Surat</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
                </div>   
<div class="ibox-content">
 
   
     <div class="form-group row">
                            <label for="nik"  class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" value="
                                " name="id" id="id" placeholder="Masukkan No kartu" >
                           


                            </div>
                        </div>
                    
            
                        <div class="form-group row">
                            <label for="nik"  class="col-sm-2 col-form-label">No Surat</label>
                            <div class="col-sm-10">
<input type="text" class="form-control"  name="no_surat" id="no_surat" value="{{ $surat->no_surat }}" 
readonly="true" placeholder="Masukkan No kartu" >
                         


                            </div>
                        </div>
    <div class="form-group row">
                            <label for="tglLahir" class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="text" readonly=""  value="{{ \Carbon\Carbon::parse($surat->tgl)->format('d-m-Y')}}"  class="form-control" name="tgl" id="tgl" placeholder="Masukkan Tanggal Mulai Bekerja" >
                               
                         @if($errors->has('tgl'))
                                <small style="color: #ed5565">{{ $errors->first('tgl')}}</small>
                            @endif
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nik"  class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" value="Tidak Lagi Bekerja" name="kop_surat" id="kop_surat" placeholder="Masukkan No kartu" >
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
                                <input type="text" value="{{ $surat->n_pj }}"  class="form-control" name="n_pj" id="npj" placeholder="Masukkan Nama" >
                                     @if($errors->has('n_pj'))
                                <small style="color: #ed5565">{{ $errors->first('n_pj')}}</small>
                            @endif
                                
                            </div>
                        </div>  
                         <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Penanggung jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="j_pj" id="j_pj" value="{{ $surat->j_pj }}"  placeholder="Masukkan Jabatan" >
                                
                            @if($errors->has('j_pj'))
                                <small style="color: #ed5565">{{ $errors->first('j_pj')}}</small>
                            @endif
                                
                            </div>
                        </div>   
                        
                        
                        <div class="form-group row">
                            <label for="pendidikan" class="col-sm-2 col-form-label">Penanggung jawab Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $surat->a_pj }}"  name="a_pj" id="a_pj" placeholder="Masukkan Alamat" >
                                
                                 @if($errors->has('a_pj'))
                                <small style="color: #ed5565">{{ $errors->first('a_pj')}}</small>
                            @endif
                            </div>
                        </div>
                         <div class="form-group row">   
                         <label for="ibu" class="col-sm-2 col-form-label">Nama instansi</label>
                            <div class="col-sm-10">
                             <SELECT name="instansi" id="instansi" class="form-control">
                        @if($surat->instansi=="PT PERWITA NUSANTARA MJI")  {{-- CETAK2 --}}
                             <option value="PT-PN/MJI" selected="true">PT PERWITA NUSANTARA MJI</option>
                             <option value="PT-AWKB">PT AMERTA WIDIYA KARYA BHAKTI</option>
                        @elseif($surat->instansi=="PT AMERTA WIDIYA KARYA BHAKTI")   {{-- CETAK1 --}}
                             <option value="PT-AWKB" selected="true">PT AMERTA WIDIYA KARYA BHAKTI</option>
                             <option value="PT-PN/MJI" >PT PERWITA NUSANTARA MJI</option>
                        @endif
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
                                <input type="text" class="form-control" value="{{ $surat->nama }}"  name="nama" id="nama1" placeholder="Masukkan Nama" >
                                 @if($errors->has('nama'))
                                <small style="color: #ed5565">{{ $errors->first('nama')}}</small>
                            @endif
                            </div>
                        </div>

                          <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $surat->jabatan}}"  name="jabatan" id="jabatan" placeholder="Masukkan Jabatan" >
        
                                 @if($errors->has('jabatan'))
                                <small style="color: #ed5565">{{ $errors->first('jabatan')}}</small>
                            @endif
                            </div>
                        </div>

                       

                          <div class="form-group row">
                            <label for="tempat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="alamat" readonly="true" value="{{ $surat->alamat }}"  id="alamat" placeholder="Masukkan Alamat">
        
                                 @if($errors->has('alamat'))
                                <small style="color: #ed5565">{{ $errors->first('alamat')}}</small>
                            @endif
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="ibu" class="col-sm-2 col-form-label">Nama sub instansi</label>
                            <div class="col-sm-10">
                             <SELECT name="mitra" id="mitra" class="form-control">
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
                                <input type="text" readonly=""  value="{{ $surat->tgl_m }}"  class="form-control" name="tgl_m" id="tgl_m" placeholder="Masukkan Tanggal Mulai Bekerja" >
                               
                         @if($errors->has('tgl_m'))
                                <small style="color: #ed5565">{{ $errors->first('tgl_m')}}</small>
                            @endif
                                
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="tglLahir" class="col-sm-2 col-form-label">Tanggal berhenti</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" class="form-control" value="{{ $surat->tgl_b }}"  name="tgl_b" id="tgl_b" placeholder="Masukkan Tanggal Berhenti Bekerja" >
                               
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
                                </div>
                                </div>

                </div>
            </div>
   
  



@endsection



@section('extra_scripts')

<script type="text/javascript">
     
      $('#tgl').datepicker({
        dateFormat: 'dd-mm-yy',
        language: "id"
    });

      $('#ttl').datepicker({
        dateFormat: 'dd-mm-yy',
        language: "id"
    });
        $('#tgl_b').datepicker({     
        dateFormat: 'dd-mm-yy',
        language: "id"
    });
          $('#tgl_m').datepicker({
        dateFormat: 'dd-mm-yy',
        language: "id"
    });
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

            }
        })

}
$('#instansi').change(function(){
$('#no_surat').val(( "{{$itung}}"+"/" + this.value + "/" + "{{$bulan}}" + "{{$year}}"));
   
});
$("select[name='mitra']").val('{{ $surat->mitra or ''}}')

        
</script>

@endsection
