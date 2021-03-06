@extends('main')

@section('title', 'Master Seragam')

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
    .spacing{
        margin-top:10px;
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
                    <h5>Form Tambah Data Seragam</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered form-pegawai">
                        <tr>
                            <th style="width: 15%"><div class="spacing">Mitra</div></th>
                            <td colspan="2">
                                    <select id="mitra" style="width: 100%" class="form-control chosen-select" name="Mitra" required="">
                                        <option value="" selected>Pilih Mitra</option>
                                        @foreach($mitra as $data)
                                        <option value="{{$data->m_id}}">{{$data->m_name}}</option>
                                        @endforeach
                                    </select>
                                     <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="mitra-error">
                                        <small>Mitra harus diisi...!</small>
                                    </span>
                            </td>
                         </tr>
                         <tr>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <th>Nama Seragam</th>
                            <td colspan="2"><input id="seragam" class="form-control huruf" name="Nama Seragam" placeholder="Nama Seragam" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="seragam-error">
                                    <small>Nama Seragam harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Warna Seragam</th>
                            <td colspan="2"><input id="warna" class="form-control huruf" name="Warna Seragam" placeholder="Warna Seragam" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="warna-error">
                                    <small>Warna Seragam harus diisi...!</small>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Jenis Seragam</th>
                            <td colspan="2"><input id="jenis" class="form-control huruf" name="Jenis Seragam" placeholder="Jenis Seragam" required="">
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="jenis-error">
                                    <small>Jenis Seragam harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Pilih Ukuran</th>
                            <td colspan="2">
                                <label class="checkbox-inline"><input class="cxs" name="ukuran[]" onclick="ukuranxs()" type="checkbox" value="XS" >XS</label>
                                <label class="checkbox-inline"><input class="cs" name="ukuran[]" onchange="ukurans()" type="checkbox" value="S">S</label>
                                <label class="checkbox-inline"><input class="cm" name="ukuran[]" onchange="ukuranm()" type="checkbox" value="M">M</label>
                                <label class="checkbox-inline"><input class="cl" name="ukuran[]" onchange="ukuranl()" type="checkbox" value="L">L</label>
                                <label class="checkbox-inline"><input class="cxl" name="ukuran[]" onchange="ukuranxl()" type="checkbox" value="XL">XL</label>
                                <label class="checkbox-inline"><input class="cxxl" name="ukuran[]" onchange="ukuranxxl()" type="checkbox" value="XXL">XXL</label>
                                <span style="color:#ed5565;display: none " class="help-block m-b-none reset" id="jenis-error">
                                    <small>Ukuran Seragam harus diisi...!</small>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Supplier</th>
                            <th colspan="1"><input style="margin-bottom:10px;" type="hidden" id="id_supplier" class="form-control" placeholder="Masukkan Supplier"/>
                                <input style="margin-bottom:10px; width: 100%" type="text" id="supplier" class="form-control" placeholder="Masukkan Supplier"/>
                            </th>
                            <th style="width: 10%">
                                <button id="tambah_supplier" type="button" class="btn btn-primary  btn-flat btn-sm">Tambah Supplier</button>
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <button onclick="simpan()" type="submit" class="ladda-button  simpan  btn btn-primary btn-sm  m-b btn-flat" data-style="zoom-in">
                                        <span class="ladda-label">Simpan</span><span class="ladda-spinner"></span>
                                </button>
                                <a href="{{URL::to('/')}}/manajemen-pegawai/data-pegawai" class="ladda-button btn-sm batalkan  btn btn-danger  m-b btn-flat" data-style="zoom-in">
                                    <span class="ladda-label">Batalkan</span><span class="ladda-spinner"></span>
                                </a>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered form-pegawai">
                        <thead>
                            <th>No</th>
                            <th>Nama Supplier</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody id="div_item">
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
    var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

    var x = 0;
       function ukuranxs(){
          if($('.cxs').is(':checked')){
              $('.hargaXs').css('display','')
              $('#inputXs').removeAttr('disabled');
          }

          else{
              $('.hargaXs').css('display','none')
              $('#inputXs').attr('disabled',true);
          }

        }
       function ukurans(){
          if($('.cs').is(':checked')){
             $('.hargaS').css('display','')
             $('#inputS').removeAttr('disabled');
          }
          else{
             $('.hargaS').css('display','none')
             $('#inputS').attr('disabled',true);
          }

        }
       function ukuranm(){
          if($('.cm').is(':checked')){
              $('.hargaM').css('display','')
          }
          else{
              $('.hargaM').css('display','none')
          }

        }
       function ukuranl(){
          if($('.cl').is(':checked')){
             $('.hargaL').css('display','')
          }
          else{
            $('.hargaL').css('display','none')
          }

        }
       function ukuranxl(){
          if($('.cxl').is(':checked')){
              $('.hargaXl').css('display','')
          }
          else{
              $('.hargaXl').css('display','none')
          }

        }
       function ukuranxxl(){
          if($('.cxxl').is(':checked')){
             $('.hargaXxl').css('display','')
          }
          else{
            $('.hargaXxl').css('display','none')
          }

        }
    $(document).ready(function() {
             $("#supplier").attr("placeholder", "Masukkan Supplier").blur();
//             $( "#supplier" ).focusin(function() {
//
//                    $('#id_supplier').val("");
//                    $('#supplier').val("");
//                    });
             $( "#supplier" ).autocomplete({
              source: baseUrl+'/ambil-data-supplier/autocomplete',
              minLength: 0,
              select: function(event, ui) {
                    $('#id_supplier').val(ui.item.id);
                    $('#supplier').val(ui.item.label);
              }, response: function(event, ui) {
            if (!ui.content.length) {
                var noResult = { value:"",label:"Data supplier tidak ada" };
                ui.content.push(noResult);
            }
    }
            });

        var wrapper         = $("#div_item");
        var add_button      = $("#tambah_supplier");


        $(add_button).click(function(e){
            e.preventDefault();
				var id_supplier			= $("#id_supplier").val();
				var supplier			= $("#supplier").val();
				var inputXs			= $("#inputXs").val();
				var inputS			= $("#inputS").val();
				var inputM			= $("#inputM").val();
				var inputL			= $("#inputL").val();
				var inputXl			= $("#inputXl").val();
				var inputXxl			= $("#inputXxl").val();

					x++;
var isiSupplier='<tr id="tr'+x+'" >\n\
<th width=3%;>'+x+'</th>\n\
<td width=40%;>\n\
<input name="id_supplier[]" readonly style="margin-bottom:10px;" type="hidden" id="id_supplier'+x+'" class="form-control" placeholder="Masukkan Supplier"/>\n\
<input name="supplier[]" readonly style="margin-bottom:10px;" type="text" id="supplier'+x+'" class="form-control" placeholder="Masukkan Supplier"/>\n\
<div class="hargaXs" style="display:none "><div class="col-md-2 spacing">Harga XS</div><div class=" col-md-4">\n\
<input name="inputXS[]"  style="margin-bottom:10px;" type="text" id="inputXs'+x+'" class="form-control" value="" placeholder="Masukkan Harga Ukuran XS" />\n\
</div></div><div class="hargaS" style="display: none"><div class="col-md-2 spacing">Harga S</div><div class=" col-md-4">\n\
<input name="inputS[]"  style="margin-bottom:10px;" type="text" id="inputS'+x+'" class="form-control" value="" placeholder="Masukkan Harga Ukuran S" />\n\
</div></div><div class="hargaM" style="display: none"><div class="col-md-2 spacing">Harga M</div><div class=" col-md-4">\n\
<input name="inputM[]"  style="margin-bottom:10px;" type="text" id="inputM'+x+'" class="form-control" value="" placeholder="Masukkan Harga Ukuran M" />\n\
</div></div><div class="hargaL" style="display: none"><div class="col-md-2 spacing">Harga L</div><div class=" col-md-4">\n\
<input name="inputL[]"  style="margin-bottom:10px;" type="text" id="inputL'+x+'" class="form-control" value="" placeholder="Masukkan Harga Ukuran L" /></div>\n\
</div><div class="hargaXl" style="display: none"><div class="col-md-2 spacing">Harga XL</div><div class=" col-md-4">\n\
<input name="inputXL[]"  style="margin-bottom:10px;" type="text" id="inputXl'+x+'" class="form-control" value="" placeholder="Masukkan Harga Ukuran XL" /></div></div>\n\
<div class="hargaXxl" style="display: none"><div class="col-md-2 spacing">Harga XXL</div><div class=" col-md-4">\n\
<input name="inputXXL[]"  style="margin-bottom:10px;" type="text" id="inputXxl'+x+'" class="form-control" value="" placeholder="Masukkan Harga Ukuran XXL" />\n\
</div></div></td><td width=10%;><button id="tambah_supplier" type="button" class="btn btn-danger btn-block btn-flat btn-sm" onclick="hapus('+x+')">Hapus</button></td></tr>';
				$(wrapper).append(isiSupplier); //add input box
ukuranxs();
ukurans();
ukuranm();
ukuranl();
ukuranxl();
ukuranxxl();



				$("#id_supplier"+x).val(id_supplier);
				$("#supplier"+x).val(supplier);
				$("#inputXs"+x).val(inputXs);
				$("#inputS"+x).val(inputS);
				$("#inputM"+x).val(inputM);
				$("#inputL"+x).val(inputL);
				$("#inputXl"+x).val(inputXl);
				$("#inputXxl"+x).val(inputXxl);









        });







	});


    var info       = $('.pesan');
    $(".select2").select2();

    $('#tanggal').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
        endDate: 'today'
    }).datepicker("setDate", "0");
    $('#tmk').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
        endDate: 'today'
    }).datepicker("setDate", "0");
    $('#exp').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
        endDate: 'today'
    }).datepicker("setDate", "0");
    function simpan() {
        var buttonLadda = $('.simpan').ladda();
        buttonLadda.ladda('start');
         if(validateForm()){
        $.ajax({
            url: baseUrl + '/manajemen-seragam/data-seragam/simpan',
            // type        : 'post',
            type: 'get',
            timeout: 10000,
            data: $('.form-pegawai :input').serialize(),
            dataType: 'json',
            enctype: 'multipart/form-data',
            processData: false,  // tell jQuery not to process the data
            contentType: false,
            success: function (response) {
                if (response.status == 'berhasil') {
                    window.location = baseUrl + '/manajemen-seragam/data-seragam';
                } else if(response.status=='gagal'){
                    info.css('display','');
                    $.each(response.data, function(index, error) {
                           info.find('ul').append('<li>' + error + '</li>');
                    });
                    buttonLadda.ladda('stop');
                }



            },
            error: function (xhr, status) {
                if (status == 'timeout') {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                }
                else if (xhr.status == 0) {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                }
                else if (xhr.status == 500) {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                }

                buttonLadda.ladda('stop');
            }
        });
         }else{
              buttonLadda.ladda('stop');
         }
    }

        function validateForm(){
            $('.reset').css('display', 'none');

            var mitra = document.getElementById('mitra');
            var seragam = document.getElementById('seragam');
            var warna = document.getElementById('warna');
            var jenis = document.getElementById('jenis');
            if(mitra.validity.valueMissing){
                $('#mitra-error').css('display', '');
                return false;
            }
            else if(seragam.validity.valueMissing){
                $('#seragam-error').css('display', '');
                return false;
            }
             else if(warna.validity.valueMissing){
                $('#warna-error').css('display', '');
                return false;
            }
            else if(jenis.validity.valueMissing){
                $('#jenis-error').css('display', '');
                return false;
            }


            return true;
        }


</script>
@endsection
