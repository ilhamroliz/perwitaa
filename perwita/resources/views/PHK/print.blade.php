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
    <b><u>SURAT Keterangan Kerja</u></b> <br>
          {{$data[0]->p_no}}
    </div>
    <br />
    <div style="text-align: justify;">
    Menerangkan dengan sebenarnya bahwa :
    </div>
    <div style="text-align: justify;">
    <br /></div>
    <div style="text-align: justify;">
      Nama		:   {{$data[0]->p_name}}
    </div>
    <div style="text-align: justify;">
      N.I.K		:   {{$data[0]->p_nip}}
    </div>
    <div style="text-align: justify;">
      N.I.K Mitra		:   {{$data[0]->p_nip_mitra}}
    </div>
    <div style="text-align: justify;">
      Alamat	:   {{$data[0]->p_address}}
    </div>
    <div style="text-align: justify;">
      Jabatan / Bagian	:    {{$data[0]->p_jabatan}}
    </div>
    <div style="text-align: justify;">
      Mitra	:   {{$data[0]->m_name}}
    </div>
    <div style="text-align: justify;">
      Divisi	:  {{$data[0]->md_name}}
    </div>
    <div style="text-align: justify;">
    <br /></div>
    <div style="text-align: justify;">
    </div>
    <div style="text-align: justify;">
    </div>
    <div style="text-align: justify;">
    Adalah benar karyawan PT. Perwita Nusaraya Sdr/Sdri {{$data[0]->p_name}} bekerja sejak {{Carbon\Carbon::parse($data[0]->mp_workin_date)->format('d/m/Y')}} dan terhitung mulai tanggal {{Carbon\Carbon::parse($data[0]->p_date)->format('d/m/Y')}} yang bersangkutan bukan lagi sebagai karyawan PT. Perwita Nusaraya, Atas Pengabdian, dedikasi dan loyalitas yang tinggi selama ini, Pimpinan PT. Perwita Nusaraya, menucapkan terima kasih.
    </div>
    <div style="text-align: justify;">
    <br /></div>
    <div style="text-align: justify;">
    Demikian surat keterangan ini. dibuat untuk dipergunakan sebagaimana mestinya
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
