@extends ('main')

    @section('title', 'Potongan')



    @section ('extra_styles')

    <style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    </style>

    @endsection

@section ('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Potongan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Payroll
            </li>
            <li class="active">
                <strong>Potongan</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title ibox-info">
      <h5>Potongan</h5>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
        <div id="filter">
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
                    <input type="text" name="cari" class="form-control" id="caripekerja" placeholder="Cari berdasarkan NIK Pekerja/Nama/NIK Mitra">
                </div>
            </div>
            <br>
            <div class="col-md-12 table-responsive " id="tabledinamis"  style="margin: 10px 0px 20px 0px;">
              <form id="data">
               <table id="pekerja" class="table table-bordered table-striped display" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="width:13%;">Nama</th>
                            <th style="width:13%;">NIK</th>
                            <th style="width:12%;">BPJS Kes</th>
                            <th style="width:12%;">BPJS Ket (JHT)</th>
                            <th style="width:12%;">BPJS Ket (Pensiun)</th>
                            <th style="width:12%;">RBH</th>
                            <th style="width:12%;">Dapan</th>
                            <th style="width:12%;">Potongan Lain Lain</th>
                        </tr>
                    </thead>
                    <tbody id="showdata">
                    </tbody>
                </table>
                </form>
            </div>
        </div>
        <button type="button" name="button" class="btn btn-primary btn-outline pull-right" onclick="simpan()">Simpan</button>
    </div>
</div>
</div>
</div>


@endsection

@section('extra_scripts')
<script type="text/javascript">
$(document).ready(function(){
  $('#pekerja').DataTable({
    responsive: true,
    "pageLength": 10,
    "pagging": false,
    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
    // "scrollY": '50vh',
    // "scrollCollapse": true,
        "language": dataTableLanguage,
  });

  // $('#pekerja').DataTable({
  //        dom: 'Bfrtip',
  //        buttons: [
  //            'copy', 'csv', 'excel', 'pdf', 'print'
  //        ]
  //    });

  $('.input-daterange').datepicker({
      keyboardNavigation: false,
      forceParse: false,
      autoclose: true,
      format: 'dd/mm/yyyy'
  });

});

$('#caripekerja').autocomplete({
    source: baseUrl + '/manajemen-payroll/payroll/potongan/getdata',
    select: function(event, ui) {
        getdata(ui.item);
    }
});

function getdata(data){
  waitingDialog.show();
  var result = data.data;
  var html = '';

        if (result.b_nokes == "-") {
           nokes = 'readonly';
           clskes = '';
           typekes = 'button';
           classkes = 'btn btn-default';
           valuekes = 'Register';
           onclickkes = 'linkkes';
           imbuhankes = '<input type="hidden" name="bpjskes[]">';
        } else {
          if (result.statuskes == 'N') {
            nokes = 'readonly';
            clskes = '';
            typekes = 'button';
            classkes = 'btn btn-default';
            valuekes = 'Register';
            onclickkes = 'linkkes';
            imbuhankes = '<input type="hidden" name="bpjskes[]">';
          } else {
            nokes = '';
            clskes = 'rp';
            typekes = 'text';
            classkes = 'form-control';
            valuekes = 'Rp. '+accounting.formatMoney(result.bikes_value, "", 0, ".", ",");
            onclickkes = '';
            imbuhankes = '';
          }
        }
        if (result.b_noket == "-") {
           noket = 'readonly';
           clsket = '';
           typeket = 'button';
           classket = 'btn btn-default';
           valueket = 'Register';
           onclickket = 'linkket';
           imbuhanket = '<input type="hidden" name="bpjsketjht[]">';
        } else {
          if (result.statusket == 'N') {
            noket = 'readonly';
            clsket = '';
            typeket = 'button';
            classket = 'btn btn-default';
            valueket = 'Register';
            onclickket = 'linkket';
            imbuhanket = '<input type="hidden" name="bpjsketjht[]">';
          } else {
            noket = '';
            clsket = 'rp';
            typeket = 'text';
            classket = 'form-control';
            valueket = 'Rp. '+accounting.formatMoney(result.b_value_jht, "", 0, ".", ",")
            onclickket = '';
            imbuhanket = '';
          }
        }
        if (result.b_noket == "-") {
           noketpens = 'readonly';
           clsketpens = '';
           typeketpens = 'button';
           classketpens = 'btn btn-default';
           valueketpens = 'Register';
           onclickketpens = 'linkket';
           imbuhanketpens = '<input type="hidden" name="bpjsketpens[]">';
        } else {
          if (result.statusket == 'N') {
            noketpens = 'readonly';
            clsketpens = '';
            typeketpens = 'button';
            classketpens = 'btn btn-default';
            valueketpens = 'Register';
            onclickketpens = 'linkket';
            imbuhanketpens = '<input type="hidden" name="bpjsketpens[]">';
          } else {
            noketpens = '';
            clsketpens = 'rp';
            typeketpens = 'text';
            classketpens = 'form-control';
            valueketpens = 'Rp. '+accounting.formatMoney(result.b_value_pensiun, "", 0, ".", ",")
            onclickketpens = '';
            imbuhanketpens = '';
          }
        }
        if (result.r_no == "-") {
           r_no = 'readonly';
           clsr = '';
           typeker = 'button';
           classker = 'btn btn-default';
           valueker = 'Register';
           onclickker = 'linkker';
           imbuhanker = '<input type="hidden" name="rbh[]">';
        } else {
          if (result.statusr == 'N') {
            r_no = 'readonly';
            clsr = '';
            typeket = 'button';
            classket = 'btn btn-default';
            valueket = 'Register';
            onclickket = 'linkker';
            imbuhanker = '<input type="hidden" name="rbh[]">';
          } else {
            r_no = '';
            clsr = 'rp';
            typeker = 'text';
            classker = 'form-control';
            valueker = 'Rp. '+accounting.formatMoney(result.biker_value, "", 0, ".", ",");
            onclickker = '';
            imbuhanker = '';
          }
        }

        if (result.d_no == "-") {
           d_no = 'readonly';
           clsd = '';
           typeked = 'button';
           classked = 'btn btn-default';
           valueked = 'Register';
           onclickked = 'linkked';
           imbuhanked = '<input type="hidden" name="dapan[]">';
        } else {
          if (result.statusd == 'N') {
            d_no = 'readonly';
            clsd = '';
            typeked = 'button';
            classked = 'btn btn-default';
            valueked = 'Register';
            onclickked = 'linkked';
            imbuhanked = '<input type="hidden" name="dapan[]">';
          } else {
            d_no = '';
            clsd = 'rp';
            typeked = 'text';
            classked = 'form-control';
            valueked = 'Rp. '+accounting.formatMoney(result.biked_value, "", 0, ".", ",");
            onclickked = '';
            imbuhanked = '';
           }
        }

        html += '<tr role="row" class="odd">'+
              '<td>'+result.p_name+'</td>'+
              '<td>'+result.p_nip+'</td>'+
              '<td><input type="'+typekes+'" name="bpjskes[]" class="'+classkes+' '+clskes+'" style="width:100%;" value="'+valuekes+'" onclick="'+onclickkes+'('+result.p_id+')">'+imbuhankes+'</td>'+
              '<td><input type="'+typeket+'" name="bpjsketjht[]" class="'+classket+' '+clsket+'" style="width:100%;" value="'+valueket+'" onclick="'+onclickket+'('+result.p_id+')">'+imbuhanket+'</td>'+
              '<td><input type="'+typeketpens+'" name="bpjsketpens[]" class="'+classketpens+' '+clsketpens+'" style="width:100%;" value="'+valueketpens+'" onclick="'+onclickketpens+'('+result.p_id+')">'+imbuhanketpens+'</td>'+
              '<td><input type="'+typeker+'" name="rbh[]" class="'+classker+' '+clsr+'" style="width:100%;" value="'+valueker+'" onclick="'+onclickker+'('+result.p_id+')">'+imbuhanker+'</td>'+
              '<td><input type="'+typeked+'" name="dapan[]" class="'+classked+' '+clsd+'" style="width:100%;" value="'+valueked+'" onclick="'+onclickked+'('+result.p_id+')">'+imbuhanked+'</td>'+
              '<td> <input type="text" class="form-control rp" name="potonganlain[]" value="Rp. '+accounting.formatMoney(result.p_value, "", 0, ".", ",")+'"> </td>'+
              '<td><input type="hidden" name="p_id[]" value="'+result.p_id+'" class="form-control" style="width:100%;"></td>'+
              '</tr>';

      $('#showdata').html(html);
      $('.rp').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
      waitingDialog.hide();
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
  var typekes = '';
  var classkes = '';
  var valuekes = '';
  var onclickkes = '';
  var typeket = '';
  var classket = '';
  var valueket = '';
  var onclickket = '';
  var typeker = '';
  var classker = '';
  var valueker = '';
  var onclickker = '';
  var typeked = '';
  var classked = '';
  var valueked = '';
  var onclickked = '';
  var imbuhankes = '';
  var imbuhanket = '';
  var imbuhanker = '';
  var imbuhanked = '';
  $.ajax({
    type: 'get',
    data: 'mitra='+mitra+"&divisi="+divisi,
    url: baseUrl + '/manajemen-payroll/payroll/potongan/cari',
    dataType: 'json',
    success : function(result){
      for (var i = 0; i < result.length; i++) {
        if (result[i].b_nokes == "-") {
           nokes = 'readonly';
           clskes = '';
           typekes = 'button';
           classkes = 'btn btn-default';
           valuekes = 'Register';
           onclickkes = 'linkkes';
           imbuhankes = '<input type="hidden" name="bpjskes[]">';
        } else {
          if (result[i].statuskes == 'N') {
            nokes = 'readonly';
            clskes = '';
            typekes = 'button';
            classkes = 'btn btn-default';
            valuekes = 'Register';
            onclickkes = 'linkkes';
            imbuhankes = '<input type="hidden" name="bpjskes[]">';
          } else {
            nokes = '';
            clskes = 'rp';
            typekes = 'text';
            classkes = 'form-control';
            valuekes = 'Rp. '+accounting.formatMoney(result[i].bikes_value, "", 0, ".", ",");
            onclickkes = '';
            imbuhankes = '';
          }
        }
        if (result[i].b_noket == "-") {
           noket = 'readonly';
           clsket = '';
           typeket = 'button';
           classket = 'btn btn-default';
           valueket = 'Register';
           onclickket = 'linkket';
           imbuhanket = '<input type="hidden" name="bpjsketjht[]">';
        } else {
          if (result[i].statusket == 'N') {
            noket = 'readonly';
            clsket = '';
            typeket = 'button';
            classket = 'btn btn-default';
            valueket = 'Register';
            onclickket = 'linkket';
            imbuhanket = '<input type="hidden" name="bpjsketjht[]">';
          } else {
            noket = '';
            clsket = 'rp';
            typeket = 'text';
            classket = 'form-control';
            valueket = 'Rp. '+accounting.formatMoney(result[i].b_value_jht, "", 0, ".", ",")
            onclickket = '';
            imbuhanket = '';
          }
        }
        if (result[i].b_noket == "-") {
           noketpens = 'readonly';
           clsketpens = '';
           typeketpens = 'button';
           classketpens = 'btn btn-default';
           valueketpens = 'Register';
           onclickketpens = 'linkket';
           imbuhanketpens = '<input type="hidden" name="bpjsketpens[]">';
        } else {
          if (result[i].statusket == 'N') {
            noketpens = 'readonly';
            clsketpens = '';
            typeketpens = 'button';
            classketpens = 'btn btn-default';
            valueketpens = 'Register';
            onclickketpens = 'linkket';
            imbuhanketpens = '<input type="hidden" name="bpjsketpens[]">';
          } else {
            noketpens = '';
            clsketpens = 'rp';
            typeketpens = 'text';
            classketpens = 'form-control';
            valueketpens = 'Rp. '+accounting.formatMoney(result[i].b_value_pensiun, "", 0, ".", ",")
            onclickketpens = '';
            imbuhanketpens = '';
          }
        }
        if (result[i].r_no == "-") {
           r_no = 'readonly';
           clsr = '';
           typeker = 'button';
           classker = 'btn btn-default';
           valueker = 'Register';
           onclickker = 'linkker';
           imbuhanker = '<input type="hidden" name="rbh[]">';
        } else {
          if (result[i].statusr == 'N') {
            r_no = 'readonly';
            clsr = '';
            typeket = 'button';
            classket = 'btn btn-default';
            valueket = 'Register';
            onclickket = 'linkker';
            imbuhanker = '<input type="hidden" name="rbh[]">';
          } else {
            r_no = '';
            clsr = 'rp';
            typeker = 'text';
            classker = 'form-control';
            valueker = 'Rp. '+accounting.formatMoney(result[i].biker_value, "", 0, ".", ",")
            onclickker = '';
            imbuhanker = '';
          }
        }

        if (result[i].d_no == "-") {
           d_no = 'readonly';
           clsd = '';
           typeked = 'button';
           classked = 'btn btn-default';
           valueked = 'Register';
           onclickked = 'linkked';
           imbuhanked = '<input type="hidden" name="dapan[]">';
        } else {
          if (result[i].statusd == 'N') {
            d_no = 'readonly';
            clsd = '';
            typeked = 'button';
            classked = 'btn btn-default';
            valueked = 'Register';
            onclickked = 'linkked';
            imbuhanked = '<input type="hidden" name="dapan[]">';
          } else {
            d_no = '';
            clsd = 'rp';
            typeked = 'text';
            classked = 'form-control';
            valueked = 'Rp. '+accounting.formatMoney(result[i].biked_value, "", 0, ".", ",")
            onclickked = '';
            imbuhanked = '';
           }
        }


        html += '<tr role="row" class="odd">'+
              '<td>'+result[i].p_name+'</td>'+
              '<td>'+result[i].p_nip+'</td>'+
              '<td><input type="'+typekes+'" name="bpjskes[]" class="'+classkes+' '+clskes+'" style="width:100%;" value="'+valuekes+'" onclick="'+onclickkes+'('+result[i].p_id+')">'+imbuhankes+'</td>'+
              '<td><input type="'+typeket+'" name="bpjsketjht[]" class="'+classket+' '+clsket+'" style="width:100%;" value="'+valueket+'" onclick="'+onclickket+'('+result[i].p_id+')">'+imbuhanket+'</td>'+
              '<td><input type="'+typeketpens+'" name="bpjsketpens[]" class="'+classketpens+' '+clsketpens+'" style="width:100%;" value="'+valueketpens+'" onclick="'+onclickketpens+'('+result[i].p_id+')">'+imbuhanketpens+'</td>'+
              '<td><input type="'+typeker+'" name="rbh[]" class="'+classker+' '+clsr+'" style="width:100%;" value="'+valueker+'" onclick="'+onclickker+'('+result[i].p_id+')">'+imbuhanker+'</td>'+
              '<td><input type="'+typeked+'" name="dapan[]" class="'+classked+' '+clsd+'" style="width:100%;" value="'+valueked+'" onclick="'+onclickked+'('+result[i].p_id+')">'+imbuhanked+'</td>'+
              '<td> <input type="text" class="form-control rp" name="potonganlain[]" value="Rp. '+accounting.formatMoney(result[i].p_value, "", 0, ".", ",")+'"> </td>'+
              '<td><input type="hidden" name="p_id[]" value="'+result[i].p_id+'" class="form-control" style="width:100%;"></td>'+
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
  });
}

  function simpan(){
    waitingDialog.show();
    $.ajax({
      type: 'get',
      data: $('#data').serialize(),
      url: baseUrl + '/manajemen-payroll/payroll/potongan/simpan',
      dataType: 'json',
      success : function(result){
        waitingDialog.hide();
        if (result.status == 'berhasil') {
            swal({
                title: "Potongan Disimpan",
                text: "Potongan Berhasil Disimpan",
                type: "success",
                showConfirmButton: false,
                timer: 900
            });
            setTimeout(function(){
                  window.location.reload();
          }, 850);
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
          waitingDialog.hide();
      }
    });
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
  }

  function linkkes(id){
    window.location.href = baseUrl + '/manajemen-bpjs/ansuransi/kesehatan?id='+id;
  }

  function linkket(id){
    window.location.href = baseUrl + '/manajemen-bpjs/ansuransi/ketenagakerjaan?id='+id;
  }

  function linkker(id){
    window.location.href = baseUrl + '/manajemen-bpjs/ansuransi/rbh?id='+id;
  }

  function linkked(id){
    window.location.href = baseUrl + '/manajemen-bpjs/ansuransi/dapan?id='+id;
  }

</script>
@endsection
