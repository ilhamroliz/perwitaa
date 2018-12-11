@extends('main')
@section('title', 'Tunjangan')
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
        <h2>Tunjangan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Payroll
            </li>
            <li class="active">
                <strong>Tunjangan</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox">
    <div class="ibox-title">
      <h5>Tunjangan</h5>
    </div>
    <div class="ibox-content">
              <div class="row">
                <div class="col-6 col-md-3">
                  @if(empty($data))
                  <p>Data tidak Ketemu</p>
                    @else
                    <select id="selectmitra" class="select-picker form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumnmitra()">
                    <option value="" selected="true" >- Pilih Mitra -</option>
                    @foreach ($data as $key => $value)
                        <option value="{{ $value ->md_mitra }}" id="optionvalue">{{$value ->m_name}}</option>
                    @endforeach
                    </select>
                    @endif
                </div>
                <div class="col-6 col-md-3">
                  <select class="select-picker form-control" name="selectdivisi" id="selectdivisi" onchange="filterColumndivisi()">
                    <option value="all">Pilih Divisi</option>
                  </select>
                </div>
                <div class="col-6 col-md-1">
                  <button type="button" class="btn btn-primary" name="button" onclick="cari()"> <i class="fa fa-search"></i> Cari</button>
                </div>
                <div class="col-6 col-md-5">
                    <input type="text" name="cari" class="form-control" id="caripekerja" placeholder="Cari berdasarkan NIK Pekerja/Nama/Nik Mitra">
                </div>
            <div class="col-md-12" style="margin-top: 20px;">
              <form id='data'>
                <table class="table table-stripped table-bordered table-responsive" id="table-rekening">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Nama</th>
                            <th style="width: 17%;">NIK</th>
                            <th style="width: 18%;">NIK Mitra</th>
                            <th style="width: 15%;">TJG Jabatan</th>
                            <th style="width: 15%;">TJG Makan</th>
                            <th style="width: 15%;">TJG Transport</th>
                        </tr>
                    </thead>
                    <tbody id="showdata">

                    </tbody>
                </table>
              </form>
              <button type="button" class="btn btn-primary pull-right" onclick="simpan()" name="button">Simpan</button>
            </div>
            </div>
        </div>
    </div>
  </div>


@endsection
@section("extra_scripts")
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $('#table-rekening').DataTable({
            "language": dataTableLanguage,
            'paging': false,
            'searching': false
        });
    });

    $('#caripekerja').autocomplete({
        source: baseUrl + '/manajemen-payroll/payroll/tunjangan/getdata',
        select: function(event, ui) {
            getdata(ui.item);
        }
    });

    function getdata(data){
        var info = data.data;
        table.clear();
        table.row.add([
            info.p_name,
            info.p_nip,
            info.p_nip_mitra,
            '<input type="text" name="jabatan[]" value="Rp. '+accounting.formatMoney(info.p_tjg_jabatan, "", 0, ".", ",")+'" class="form-control rp" style="width: 100%;" placeholder="Masukkan Tunjangan Jabatan">',
            '<input type="text" name="makan[]" value="Rp. '+accounting.formatMoney(info.p_tjg_makan, "", 0, ".", ",")+'" class="form-control rp" style="width: 100%;" placeholder="Masukkan Tunjangan Makan">',
            '<input type="text" name="transport[]" value="Rp. '+accounting.formatMoney(info.p_tjg_transport, "", 0, ".", ",")+'" class="form-control rp" style="width: 100%;" placeholder="Masukkan Tunjangan Transport">',
            '<input type="hidden" name="pekerja[]" value="'+info.p_id+'" class="form-control">',
            ]).draw();

        $('.rp').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
    }

    function simpan(){
        waitingDialog.show();
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        $.ajax({
            url: '{{ url('manajemen-payroll/payroll/tunjangan/simpan') }}',
            type: 'get',
            data: $('#data').serialize(),
            success: function(response){
                if (response.status == 'berhasil') {
                    waitingDialog.hide();
                    swal({
                        title: "Sukses",
                        text: "Data sudah tersimpan",
                        type: "success"
                    }, function () {
                        location.reload();
                    });
                } else {
                    waitingDialog.hide();
                    swal({
                        title: "Gagal!!",
                        text: "Data gagal tersimpan",
                        type: "error"
                    }, function () {
                    });
                }
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
            }
        })
    }

    function filterColumnmitra () {
        $("#selectdivisi").html('<option value="">Pilih Divisi</option>');
        var nmitra = $('#selectmitra').val();
        $('#table').DataTable().column(2).search(nmitra).draw();
        id =  $('#selectmitra').val();
        var html = "";
        $.ajax({
          type: 'get',
          data: {id:id},
          url: baseUrl + '/pekerja-di-mitra/getdivisi',
          dataType: 'json',
          success : function(result){
            // console.log(result);
            for (var i = 0; i < result.length; i++) {
              html += '<option value="'+result[i].md_id+'">'+result[i].md_name+'</option>';
            }
            $("#selectdivisi").append(html);
            $("#cari").attr('mitra',id);
          }
        });
    }

    function filterColumndivisi(){
      var id = $('#selectdivisi').val();
      $("#cari").attr('divisi',id);
    }

    function cari(){
      waitingDialog.show();
      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
      var html = "";
      var mitra = $('#selectmitra').val();
      var divisi = $('#selectdivisi').val();
      var nokes = '';
      var noket = '';
      var r_no = '';
      var d_no = '';
      var clskes = '';
      var clsket = '';
      var clsr = '';
      var clsd = '';
      $.ajax({
        type: 'get',
        data: 'mitra='+mitra+"&divisi="+divisi,
        url: baseUrl + '/manajemen-payroll/payroll/tunjangan/cari',
        dataType: 'json',
        success : function(result){
          for (var i = 0; i < result.length; i++) {

            html += '<tr role="row" class="odd">'+
                  '<td>'+result[i].p_name+'</td>'+
                  '<td>'+result[i].p_nip+'</td>'+
                  '<td>'+result[i].p_nip_mitra+'</td>'+
                  '<td><input type="text" name="jabatan[]" value="Rp. '+accounting.formatMoney(result[i].p_tjg_jabatan, "", 0, ".", ",")+'" class="form-control rp" style="width: 100%;" placeholder="Masukkan Tunjangan Jabatan"></td>'+
                  '<td><input type="text" name="makan[]" value="Rp. '+accounting.formatMoney(result[i].p_tjg_makan, "", 0, ".", ",")+'" class="form-control rp" style="width: 100%;" placeholder="Masukkan Tunjangan Makan"></td>'+
                  '<td><input type="text" name="transport[]" value="Rp. '+accounting.formatMoney(result[i].p_tjg_transport, "", 0, ".", ",")+'" class="form-control rp" style="width: 100%;" placeholder="Masukkan Tunjangan Transport"></td>'+
                  '<input type="hidden" name="pekerja[]" value="'+result[i].p_id+'" class="form-control">'+
                  '</tr>';

          }
          $('#showdata').html(html);
          $('.rp').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
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
@endsection()
