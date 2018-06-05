@extends('main')

@section('title', 'dashboard')
@section ('extra_styles')
<style type="text/css">
.container-fluid {
    padding-top: 50px;
    min-height: 400px;
        color: red;
}

</style>
@endsection
@section('content')





<div class="wrapper wrapper-content animated fadeInRight">
    <div class="alert alert-danger pesan" style="display:none;">
          <ul></ul>
    </div>
   
    
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">

 <form id="form-pekerja" method="post" action="/pwt/surat/update&{{ $surat->id_surat}}">
  <h5>Jenis Surat</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>
                </div>   
<div class="ibox-content">
 
    <div class="row">
        <label for="nik "  class="col-sm-2 col-form-label red">Jenis Surat</label>
        <div class="col-sm-10">
        <select class="form-control" onchange="location = this.value;">
            <option value=""  style="color: grey;"  disabled selected="true">-Pilih Jenis Surat Terlebih Dahulu-</option>
            <option value="/pwt/surat/edit/{{$surat->id_surat}}" style="color: black;">Surat Keterangan Pengalaman Kerja</option>
            <option value="/pwt/surat/edit/edit-tkerja/{{$surat->id_surat}}" style="color: black;">Surat Keterangan Tidak lagi Bekerja</option>
            <option value="/pwt/surat/edit/edit-daupa/{{$surat->id_surat}}" style="color: black;">Surat Permohonan Legalisir Data Upah</option>
            <option value="/pwt/surat/edit/edit-tibpjs/{{$surat->id_surat}}" style="color: black;">Surat Keterangan Tidak Aktif BPJS</option>
            <option value="/pwt/surat/edit/edit-resign/{{$surat->id_surat}}" style="color: black;">Surat Laporan Pekerja Resign</option>
            <option value="/pwt/surat/edit/edit-pibank/{{$surat->id_surat}}" style="color: black;">Surat Pengajuan Pinjaman Bank</option>
            <option value="/pwt/surat/edit/edit-pebpjs/{{$surat->id_surat}}" style="color: black;">Surat Pengantar Pendaftaran BPJS kesehatan</option>
            <option value="/pwt/surat/edit/edit-pekpr/{{$surat->id_surat}}" style="color: black;">Surat Keterangan Kerja Pengajuan KPR</option>
        </select>
    </div>
    <div class="container-fluid">
           
</div>
</div>     
</div>
</form>
</div>
</div>
</div>
</div>   
  



@endsection



@section('extra_scripts')

<script type="text/javascript">
     
$("select[name='mitra']").val('{{ $surat->mitra or ''}}')
     
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

        
</script>

@endsection
