<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div style="font-family:courier;">
    </div>
    <br />
    <br />
    <div style="text-align: center; font-family:Trebuchet MS;">
      @if(stristr($data[0]->pd_no, 'DMS'))
      Surat Demosi
      @elseif(stristr($data[0]->pd_no, 'PMS'))
      Surat Promosi
      @endif
    </div>
    <br />
    <div style="text-align: justify;">
    </div>
    <div style="text-align: justify;">
    <br /></div>
    <div style="text-align: justify;">
      No NIK		: {{$data[0]->p_nip}}
    </div>
    <div style="text-align: justify;">
      N a m a	: {{$data[0]->p_name}}
    </div>
    <div style="text-align: justify;">
      Alamat	: {{$data[0]->p_address}}
    </div>
    <div style="text-align: justify;">
      Mitra	: {{$data[0]->m_name}}
    </div>
    <div style="text-align: justify;">
      Divisi/Dept	: {{$data[0]->md_name}}
    </div>
    <div style="text-align: justify;">
      Jabatan / Bagian	: {{$data[0]->pd_jabatan_sekarang}}
    </div>
    <div style="text-align: justify;">
    <br /></div>
    <div style="text-align: justify;">
    </div>
    <div style="text-align: justify;">
    </div>
    <div style="text-align: justify;">
    Pekerja dengan nama {{$data[0]->p_name}}, telah mendapat @if(stristr($data[0]->pd_no, 'DMS'))Demosi @elseif(stristr($data[0]->pd_no, 'PMS')) Promosi @endif, dari jabatan {{$data[0]->pd_jabatan_awal}}, menjadi jabatan {{$data[0]->pd_jabatan_sekarang}}.
    </div>
    <div style="text-align: justify;">
    <br /></div>
    Sidoarjo, {{Carbon\Carbon::now()->format('d/m/Y')}}<br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <b><u>NOVI KURNIAWAN</u></b><br>
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
