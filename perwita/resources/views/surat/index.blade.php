@extends ('main')
    
    @section('title', 'Dashboard')



    @section ('extra_styles')

    <style type="text/css">
        .red{
            color: #01818e;
            margin-left: 80px;
            margin-top: -20px; 
        }
    </style>

    @endsection
    @section ('content')

    <div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
                    <h5>Managemen Surat</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                                                                            
                    </div>


    
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12">
                
                        <div class="text-right">
                            <button onclick="tambah()" class="btn btn-primary btn-flat btn-sm" type="button"><i class="fa fa-plus"></i>&nbsp;Tambah</button>    
                        </div>
                        
                </div>
            

                  <div class="col-md-12 zero-pad-left zero-pad-right"> 
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">                    
                </div>
                
                <div class="col-md-12 table-responsive "  style="margin: 10px 0px 20px 0px;">                   
                   <table id="surat" class="table table-bordered table-striped display" >
                 
                        <thead>
                            <tr>       
                                <th>No</th>             
                                <th>No.Surat</th>            
                                <th>Tgl</th>                
                                <th>Nama</th>            
                                <th>Jabatan</th>
                                <th>Alamat</th>    
                                <th>Mitra</th>  
                                <th>Jenis Surat</th>      
                                <th>Tgl Masuk</th>
                                <th>Tgl Keluar</th> 
                                <th>Aksi</th>
                            </tr>
                        </thead>     
                        <tbody>   
                        @foreach ($surat as $index => $s)
                      
                        <tr>
                        <td>{{ $index+1 }}</td>
                            <td>{{ $s->no_surat }}</td>
                            <td>{{ \Carbon\Carbon::parse($s->tgl)->format('d/m/Y')}}</td>
                            <td>{{ $s->nama }}</td>
                            <td>{{ $s->jabatan }}</td>
                            <td>{{ $s->alamat }}</td>
                            <td>{{ $s->m_name }}</td>
                            <td>{{ $s->kop_surat }}</td>
                            <td>{{ \Carbon\Carbon::parse($s->tgl_m)->format('d/m/Y')}}</td>
                            <td>{{ \Carbon\Carbon::parse($s->tgl_b)->format('d/m/Y')}}</td>
            
                                                    
                             <td class="text-center">
                                                        <div class="dropdown">                                
                                                            <button class="btn btn-primary btn-flat btn-xs dropdown-toggle tampilkan" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                Kelola
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            
                                                                <li role="separator" class="divider"></li>               
                        @if($s->kop_surat=="Tidak Lagi Bekerja")  {{-- CETAK2 --}}
                             <li><a href="surat/edit/edit-tkerja/{{ $s->id_surat }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                        @elseif($s->kop_surat=="Tidak Aktif BPJS")   {{-- CETAK1 --}}
                            <li><a href="surat/edit/edit-tibpjs/{{ $s->id_surat }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                        @elseif($s->kop_surat=="Data Upah")     {{-- CETAK3 --}}
                            <li><a href="surat/edit/edit-daupa/{{ $s->id_surat }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                        @elseif($s->kop_surat=="Pengalaman Kerja")      {{-- CETAK4 --}}
                             <li><a href="surat/edit/{{ $s->id_surat }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                        @elseif($s->kop_surat=="Keterangan Resign")  {{-- LAPORAN --}}
                            <li><a href="surat/edit/edit-resign/{{ $s->id_surat }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                        @elseif($s->kop_surat=="Peminjaman Bank") {{-- CETAK5 --}}
                            <li><a href="surat/edit/edit-pibank/{{ $s->id_surat }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                        @elseif($s->kop_surat=="Pendaftaran BPJS") {{-- CETAK6 --}}
                            <li><a href="surat/edit/edit-pebpjs/{{ $s->id_surat }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                        @elseif($s->kop_surat=="Pengajuan KPR") {{-- CETAK7 --}}
                            <li><a href="surat/edit/edit-pekpr/{{ $s->id_surat }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                        @endif 
                                                                


                                                                <li role="separator" class="divider"></li>     
                                                                <li> 

                                                                <li><a href="surat/delete/{{ $s->id_surat}}"><i class="fa fa-trash" aria-hidden="true"></i>Hapus</a></li>
                                                                
                                                                <li role="separator" class="divider"></li>    

                                                                 

                                                                 

                                                                
                                                            
                                                        </ul>  
                        @if($s->kop_surat=="Tidak Lagi Bekerja")  {{-- CETAK2 --}}
                            <a href="surat/cetak2/{{ $s ->id_surat}}" class="pull-right red" target="_blank" ><i class="glyphicon glyphicon-print" aria-hidden="true"></i></a>
                        @elseif($s->kop_surat=="Tidak Aktif BPJS")   {{-- CETAK1 --}}
                            <a href="surat/cetak/{{ $s ->id_surat}}" class="pull-right red" target="_blank" ><i class="glyphicon glyphicon-print" aria-hidden="true"></i></a>
                        @elseif($s->kop_surat=="Data Upah")     {{-- CETAK3 --}}
                            <a href="surat/cetak3/{{ $s ->id_surat}}" class="pull-right red" target="_blank" ><i class="glyphicon glyphicon-print" aria-hidden="true"></i></a>
                        @elseif($s->kop_surat=="Pengalaman Kerja")      {{-- CETAK4 --}}
                            <a href="surat/cetak4/{{ $s ->id_surat}}" class="pull-right red" target="_blank" ><i class="glyphicon glyphicon-print" aria-hidden="true"></i></a>
                        @elseif($s->kop_surat=="Keterangan Resign")  {{-- LAPORAN --}}
                            <a href="surat/laporan/{{ $s ->id_surat}}" class="pull-right red" target="_blank" ><i class="glyphicon glyphicon-print" aria-hidden="true"></i></a>
                        @elseif($s->kop_surat=="Peminjaman Bank") {{-- CETAK5 --}}
                            <a href="surat/cetak5/{{ $s ->id_surat}}" class="pull-right red" target="_blank" ><i class="glyphicon glyphicon-print" aria-hidden="true"></i></a>
                        @elseif($s->kop_surat=="Pendaftaran BPJS") {{-- CETAK6 --}}
                            <a href="surat/cetak6/{{ $s ->id_surat}}" class="pull-right red" target="_blank" ><i class="glyphicon glyphicon-print" aria-hidden="true"></i></a>
                        @elseif($s->kop_surat=="Pengajuan KPR") {{-- CETAK7 --}}
                            <a href="surat/cetak7/{{ $s ->id_surat}}" class="pull-right red" target="_blank" ><i class="glyphicon glyphicon-print" aria-hidden="true"></i></a>
                        @endif   
                                                        
                                                        
                                                        </div>

                                                    </td>

                        </tr>                    
                        @endforeach
                    
                        </tbody>
                    </table>
                </div>  
                
            </div>

        </div>
    </div>
</div>




    @endsection

@section('extra_scripts')

<script type="text/javascript">
    
var red = $('#surat').DataTable({

});

function tambah(){
    window.location = baseUrl+'/surat/create';
}


</script>



@endsection 