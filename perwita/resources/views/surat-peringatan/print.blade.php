<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div style="font-family:courier;">
      No   : {{$data[0]->sp_no}} <br>
      Date : {{Carbon\Carbon::now()->format('d/m/Y')}} <br>
      Pages: 1 of 1 <br>
    </div>
    <br />
    <br />
    <div style="text-align: center; font-family:Trebuchet MS;">
    @if($data[0]->sp_jenis == 'Surat Teguran')
    <b>SURAT TEGURAN</b>
    @elseif($data[0]->sp_jenis == 'SP1')
    <b>SURAT PERINGATAN 1</b>
    @elseif($data[0]->sp_jenis == 'SP2')
    <b>SURAT PERINGATAN 2</b>
    @elseif($data[0]->sp_jenis == 'SP3')
    <b>SURAT PERINGATAN 3</b>
    @endif
    </div>
    <br />
    <div style="text-align: justify;">
    PT PERWITA  NUSARAYA MJI memandang perlu mengeluarkan Surat Peringatan ini kepada:
    </div>
    <div style="text-align: justify;">
    <br /></div>
    <div style="text-align: justify;">
      No NIK		:   {{$data[0]->p_nip}}
    </div>
    <div style="text-align: justify;">
      No NIK Mitra		:   {{$data[0]->p_nip_mitra}}
    </div>
    <div style="text-align: justify;">
      N a m a	:  {{$data[0]->p_name}}
    </div>
    <div style="text-align: justify;">
      Mitra	:  {{$data[0]->m_name}}
    </div>
    <div style="text-align: justify;">
      Divisi/Dept	:   {{$data[0]->md_name}}
    </div>
    <div style="text-align: justify;">
      Tgl Masuk	:   {{$data[0]->p_workdate}}
    </div>
    <div style="text-align: justify;">
      No Telp	:   {{$data[0]->p_hp}}
    </div>
    <div style="text-align: justify;">
    <br /></div>
    <div style="text-align: justify;">
      Atas tindakan  /  pelanggaran berupa :
    </div>
    <div style="text-align: justify;">
      @foreach($data as $x)
      <p> - {{$x->spd_pelanggaran}} </p>
      @endforeach
    </div>
    <div style="text-align: justify;">
    Sesuai dengan peraturan dan tata tertib Perusahaan hal tersebut dianggap suatu kesalahan dengan unsur kesengajaan, mengingat tugas dan fungsi  yang bersangkutan sangat kompleks dan mempunyai tanggung jawab besar.
    </div>
    <div style="text-align: justify;">
    <br /></div>
    <div style="text-align: justify;">
    Kemudian  diharapkan dengan diterbitkannya Surat Peringatan ini yang bersangkutan akan lebih bertanggung jawab, mengerti dan menyadari apa yang telah dilakukannya.
    </div>
    <div style="text-align: justify;">
    <br /></div>
    <div style="text-align: justify;">
    Surat Peringatan ini berlaku untuk selama-lamanya 3 (Tiga) bulan berakhir sampai dengan {{$data[0]->sp_date_end}}  atau kurang dari <b>{{$data[0]->diff}} Lagi</b>  , dan apabila yang bersangkutan melakukan kesalahan yang  bobotnya sama atau lebih berat. Sebelum masa berlaku Surat Peringatan ini habis dapat dikenakan sanksi yang lebih berat lagi.
    </div>
    <div style="text-align: justify;">
    <br /></div>
    Sidoarjo, {{Carbon\Carbon::now()->format('d/m/Y')}}<br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <b><u>{{$data[0]->sp_approve_by}}</u></b><br>
    Supervisor/Pengawas <br>
    &nbsp; &nbsp; &nbsp; &nbsp; Lapangan
    </div>
    <br />
    <br /></div>
  </body>
  <script type="text/javascript">
    window.print();
  </script>
</html>
