@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
.popover-navigation [data-role="next"] { display: none; }
.popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Approval Mitra Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Mitra Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Daftar Approval Mitra Pekerja</h5>
      </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">

                  <center>
                    <div class="spiner-example">
                        <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                            <div class="sk-rect1 tampilkan" ></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                        <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Daftar Approval</span>
                    </div>
                </center>

                <form class="formapprovalpekerja" id="formapprovalpekerja">
                  @foreach($data as $z)
                  <input type="hidden" name="kontrak" id="mp_contract" value="{{$z->mp_contract}}">
                  @endforeach
                <table id="approvalpekerja" class="table table-bordered" cellspacing="0" width="100%" style="display:none">
                    <thead>
                        <tr>
                            <th>
                              <input type="checkbox" class="setCek" onclick="selectall()">
                            </th>
                            <th>Nama</th>
                            <th>Mitra</th>
                            <th>Divisi</th>
                            <th>Pendidikan</th>
                            <th>Alamat</th>
                            <th>No Hp</th>
                            <th width="120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $index => $x)
                        <tr class="select-{{$index}}" onclick="select({{$index}})" style="cursor: pointer;">
                          <td>
                          <input class="pilih-{{$index}}" type="checkbox" name="pilih[]" onclick="selectBox({{$index}})" value="{{$x->mp_pekerja}}">
                          </td>
                          <td>{{$x->p_name}}</td>
                          <td>{{$x->m_name}}</td>
                          <td>{{$x->md_name}}</td>
                          <td>{{$x->p_education}}</td>
                          <td>{{$x->p_address}}</td>
                          <td>{{$x->p_hp}}</td>
                          <td align="center">
                            <div class="action">
                                <button type="button" id="{{$x->mp_id}}" title="Detail" onclick="detail({{$x->mp_id}},{{$x->mp_contract}},{{$x->mp_pekerja}})" class="btn btn-info btn-xs btndetail" name="button"> <i class="glyphicon glyphicon-folder-open"></i> </button>
                                <button type="button" id="{{$x->mp_id}}" title="Setujui" onclick="setujui({{$x->mp_id}},{{$x->mp_contract}},{{$x->mp_pekerja}})" class="btn btn-primary btn-xs btnsetujui" name="button"> <i class="glyphicon glyphicon-ok"></i> </button>
                                <button type="button" id="{{$x->mp_id}}" title="Tolak" onclick="tolak({{$x->mp_id}},{{$x->mp_contract}},{{$x->mp_pekerja}})"  class="btn btn-danger btn-xs btntolak" name="button"> <i class="glyphicon glyphicon-remove"></i> </button>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
                </form>
                <div class="pull-right">
                  <button type="button" class="btn btn-danger btn-outline" name="button" onclick="tolaklist()"> <i class="glyphicon glyphicon-remove"></i> Tolak Checklist</button>
                  <button type="button" class="btn btn-primary btn-outline" name="button" onclick="setujuilist()"> <i class="glyphicon glyphicon-ok"></i> Setujui Checklist</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal inmodal" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
  <!-- <div id="print-area" class="print-area"> -->
    <div class="modal-dialog" style="width : 1000px">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                            <div class="image" id="showimage">
                                  <i class="fa fa-user modal-icon"></i>
                            </div>
                <h4 class="modal-title">Detail Pekerja</h4>
            </div>
            <div class="modal-body">
              <center>
                <div class="spiner-modal">
                    <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                        <div class="sk-rect1 tampilkan" ></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                    <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Data Pelamar</span>
                </div>
            </center>
            <div id="showdata">
                <div class="form-group">
                    <div class="col-lg-3">
                        <h3>Nama Pelamar </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_name">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Alamat </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_address">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Jabatan Lamaran </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_jabatan_lamaran">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Jenis Kelamin </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_sex">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No NIP </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_nip">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No NIP Mitra</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_nip_mitra">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No KTP </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_ktp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tempat Lahir </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_birthplace">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tanggal Lahir </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_birthdate">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No Hp </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_hp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>No Telepon </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_telp">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Status </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_status">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Jumlah Anak </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_many_kids">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Agama </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_religion">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>RT/RW </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_rt_rw">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Kelurahan </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_kel">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Kecamatan </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_kecamatan">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Kota </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_city">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Alamat Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_address_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>RT/RW Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_rt_rw_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Keluarahan Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_kel_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Kecamatan Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_kecamatan_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Kota Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_city_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Nama Istri </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_wife_name">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tanggal Lahir Istri </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_wife_birth">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tempat Lahir Istri </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_wife_birthplace">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Nama Ayah </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_dad_name">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Pekerjaan Ayah </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_dad_job">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Nama Ibu </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_mom_name">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Pekerjaan Ibu </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_mom_job">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Pekerjaan Sekarang </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_job_now">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Berat </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_weight">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Tinggi </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_height">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Ukuran Baju </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_seragam_size">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Ukuran Celana  </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_celana_size">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Ukuran Sepatu  </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_sepatu_size">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Pendidikan  </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_education">: -</h3>
                    </div>
                    <div class="col-lg-3">
                        <h3>Warga Negara  </h3>
                    </div>
                    <div class="col-lg-3">
                        <h3 style="font-weight:normal;" id="p_state">: -</h3>
                    </div>
                  </div>
                  <div class="col-lg-12">
                      <h3>&nbsp</h3>
                  </div>
                  <div class="col-lg-12">
                      <h3>Keluarga Yang Dapat Dihubungi</h3>
                  </div>
                      <table id="tabel_detail" class="table table-bordered table-striped tabel_detail">
                        <div class="col-lg-3">
                            <h3>Nama </h3>
                        </div>
                        <div class="col-lg-3">
                            <h3 style="font-weight:normal;" id="p_name_family">: -</h3>
                        </div>
                        <div class="col-lg-3">
                            <h3>Alamat </h3>
                        </div>
                        <div class="col-lg-3">
                            <h3 style="font-weight:normal;" id="p_address_family">: -</h3>
                        </div>
                        <div class="col-lg-3">
                            <h3>Telepon </h3>
                        </div>
                        <div class="col-lg-3">
                            <h3 style="font-weight:normal;" id="p_telp_family">: -</h3>
                        </div>
                        <div class="col-lg-3">
                            <h3>No Hp </h3>
                        </div>
                        <div class="col-lg-3">
                            <h3 style="font-weight:normal;" id="p_hp_family">: -</h3>
                        </div>
                        <div class="col-lg-3">
                            <h3>Hubungan </h3>
                        </div>
                        <div class="col-lg-3">
                            <h3 style="font-weight:normal;" id="p_hubungan_family">: -</h3>
                        </div>
                      </table>
              </div>
              </div>
              <div class="modal-footer">
                <button type="button" name="button" class="btn btn-primary" id="setujui" onclick="setujui()">Setujui</button>
                <button type="button" name="button" class="btn btn-danger" id="tolak" onclick="tolak()">Tolak</button>
                  <div class="btn-group">
                      <a href="#" class="btn btn-white btn-md" data-dismiss="modal">Close</a>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- </div> -->

  <!-- <textarea id="printing-css" style="display:none;">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}table{border-collapse:collapse;border-spacing:0}body{font:normal normal .8125em/1.4 Arial,Sans-Serif;background-color:white;color:#333}strong,b{font-weight:bold}cite,em,i{font-style:italic}a{text-decoration:none}a:hover{text-decoration:underline}a img{border:none}abbr,acronym{border-bottom:1px dotted;cursor:help}sup,sub{vertical-align:baseline;position:relative;top:-.4em;font-size:86%}sub{top:.4em}small{font-size:86%}kbd{font-size:80%;border:1px solid #999;padding:2px 5px;border-bottom-width:2px;border-radius:3px}mark{background-color:#ffce00;color:black}p,blockquote,pre,table,figure,hr,form,ol,ul,dl{margin:1.5em 0}hr{height:1px;border:none;background-color:#666}h1,h2,h3,h4,h5,h6{font-weight:bold;line-height:normal;margin:1.5em 0 0}h1{font-size:200%}h2{font-size:180%}h3{font-size:160%}h4{font-size:140%}h5{font-size:120%}h6{font-size:100%}ol,ul,dl{margin-left:3em}ol{list-style:decimal outside}ul{list-style:disc outside}li{margin:.5em 0}dt{font-weight:bold}dd{margin:0 0 .5em 2em}input,button,select,textarea{font:inherit;font-size:100%;line-height:normal;vertical-align:baseline}textarea{display:block;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}pre,code{font-family:"Courier New",Courier,Monospace;color:inherit}pre{white-space:pre;word-wrap:normal;overflow:auto}blockquote{margin-left:2em;margin-right:2em;border-left:4px solid #ccc;padding-left:1em;font-style:italic}table[border="1"] th,table[border="1"] td,table[border="1"] caption{border:1px solid;padding:.5em 1em;text-align:left;vertical-align:top}th{font-weight:bold}table[border="1"] caption{border:none;font-style:italic}.no-print{display:none}</textarea>
  <!-- <iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe> --> -->

@endsection

@section('extra_scripts')
<script type="text/javascript">
var table;
var countmitra = 0;
var totalmitra = 0;
$( document ).ready(function() {

$('#approvalpekerja').hide();
myFunction();

function myFunction() {
setTimeout(function(){
  $(".spiner-example").css('display', 'none');
  table = $("#approvalpekerja").DataTable({
    "processing": true,
    "paging": false,
    "searching": false,
    "deferLoading": 57,
    responsive: true,
    "language": dataTableLanguage
  });
  $('#approvalpekerja').show();
},1500);
  }

});


function detail(id, mp_contract, mp_pekerja){
  $("#modal-detail").modal('show');
  $("#showdata").hide();
  $.ajax({
    type: 'get',
    data: {id:id},
    url: baseUrl + '/approvalpelamar/detail',
    dataType: 'json',
    success : function(result){
      // console.log(result);
      $("#p_name").text(": "+result.p_name);
      $("#p_address").text(": "+result.p_address);
      if (result.p_jabatan_lamaran == 1) {
        $("#p_jabatan_lamaran").text(": Manager");
      } else if (result.p_jabatan_lamaran == 2) {
          $("#p_jabatan_lamaran").text(": Supervisor");
      } else if (result.p_jabatan_lamaran == 3) {
          $("#p_jabatan_lamaran").text(": Staff");
      } else if (result.p_jabatan_lamaran == 4) {
          $("#p_jabatan_lamaran").text(": Operator");
      }
       else {
        $("#p_jabatan_lamaran").text(": "+result.p_jabatan_lamaran);
      }

      $("#p_nip").text(": "+result.p_nip);
      $("#p_sex").text(": "+result.p_sex);
      $("#p_nip_mitra").text(": "+result.p_nip_mitra);
      $("#p_ktp").text(": "+result.p_ktp);
      $("#p_birthplace").text(": "+result.p_birthplace);
      $("#p_birthdate").text(": "+result.p_birthdate);
      $("#p_hp").text(": "+result.p_hp);
      $("#p_telp").text(": "+result.p_telp);
      $("#p_status").text(": "+result.p_status);
      $("#p_religion").text(": "+result.p_religion);
      $("#p_rt_rw").text(": "+result.p_rt_rw);
      $("#p_rt_rw_now").text(": "+result.p_rt_rw_now);
      $("#p_kel_now").text(": "+result.p_kel_now);
      $("#p_kel").text(": "+result.p_kel);
      $("#p_kecamatan").text(": "+result.p_kecamatan);
      $("#p_kecamatan_now").text(": "+result.p_kecamatan_now);
      $("#p_city").text(": "+result.p_city_now);
      $("#p_city_now").text(": "+result.p_city_now);
      $("#p_address_now").text(": "+result.p_address_now);
      $("#p_wife_name").text(": "+result.p_wife_name);
      $("#p_wife_birth").text(": "+result.p_wife_birth);
      $("#p_wife_birthplace").text(": "+result.p_wife_birthplace);
      $("#p_dad_name").text(": "+result.p_dad_name);
      $("#p_dad_job").text(": "+result.p_dad_job);
      $("#p_mom_name").text(": "+result.p_mom_name);
      $("#p_mom_job").text(": "+result.p_mom_job);
      $("#p_job_now").text(": "+result.p_job_now);
      $("#p_weight").text(": "+result.p_weight);
      $("#p_height").text(": "+result.p_height);
      $("#p_seragam_size").text(": "+result.p_seragam_size);
      $("#p_sepatu_size").text(": "+result.p_sepatu_size);
      $("#p_celana_size").text(": "+result.p_celana_size);
      $("#p_education").text(": "+result.p_education);
      $("#p_state").text(": "+result.p_state);
      //Keluarga yang dapat dihubungi
      $("#p_name_family").text(": "+result.p_name_family);
      $("#p_telp_family").text(": "+result.p_telp_family);
      $("#p_hubungan_family").text(": "+result.p_hubungan_family);
      $("#p_address_family").text(": "+result.p_address_family);
      $("#p_hp_family").text(": "+result.p_hp_family);
      //Button
      $("#setujui").attr('onclick', 'setujui('+id+','+mp_contract+','+mp_pekerja+')');
      $("#tolak").attr('onclick', 'tolak('+id+','+mp_contract+','+mp_pekerja+')');
      if (result.p_many_kids == 'LEBIH') {
        $("#p_many_kids").text(": 3 Anak Lebih");
      }
      else {

      }
      if (result.p_img != null) {
        $("#showimage").html("<center><img src='"+baseUrl+'/'+result.p_img+"' width='150' class='thumb-image img-responsive'></center>");
      }
      else {
        $("#showimage").html('<i class="fa fa-user modal-icon"></i>');
      }

      $('.spiner-modal').css('display', 'none');
      $("#showdata").show();
    }
  });
}

  function setujui(mp_id, mp_contract, mp_pekerja){
    swal({
            title: "Konfirmasi",
            text: "Apakah anda yakin ingin menyetujui Mitra Pekerja ini?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            swal.close();
            $("#modal-detail").modal('hide');
            waitingDialog.show();
            setTimeout(function () {
                $.ajax({
                  type: 'get',
                  data: {mp_id:mp_id, mp_contract:mp_contract, mp_pekerja:mp_pekerja},
                  url: baseUrl + '/approvalmitrapekerja/setujui',
                  dataType: 'json',
                  timeout: 10000,
                    success: function (response) {
                        waitingDialog.hide();
                        if (response.status == 'berhasil') {
                            swal({
                                title: "Mitra Pekerja Disetujui",
                                text: "Ingin Print Mitra Pekerja Sekarang?",
                                type: "info",
                                showCancelButton: true,
                                confirmButtonClass: "btn-info",
                                confirmButtonText: "Iya",
                                cancelButtonText: "Tidak!",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },
                              function(isConfirm) {
                                if (isConfirm) {
                                  window.location.href = baseUrl + '/approvalmitrapekerja/print?mp_id='+mp_id+'&mp_contract='+mp_contract+'&mp_pekerja='+mp_pekerja;
                                } else {
                                  swal.close();
                                  setTimeout(function(){
                                        window.location.reload();
                                }, 850);
                                }
                              });
                        }
                    }, error: function (x, e) {
                        waitingDialog.hide();
                        var message;
                        if (x.status == 0) {
                            message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                        } else if (x.status == 404) {
                            message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                        } else if (x.status == 500) {
                            message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                        } else if (e == 'parsererror') {
                            message = 'Error.\nParsing JSON Request failed.';
                        } else if (e == 'timeout') {
                            message = 'Request Time out. Harap coba lagi nanti';
                        } else {
                            message = 'Unknow Error.\n' + x.responseText;
                        }
                        waitingDialog.hide();
                        throwLoadError(message);
                        //formReset("store");
                    }
                })
            }, 2000);

        });
  }

  function tolak(mp_id, mp_contract, mp_pekerja){
    swal({
            title: "Konfirmasi",
            text: "Apakah anda yakin ingin menolak Mitra Pekerja ini?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            swal.close();
            $("#modal-detail").modal('hide');
            waitingDialog.show();
            setTimeout(function () {
                $.ajax({
                  type: 'get',
                  data: {mp_id:mp_id, mp_contract:mp_contract, mp_pekerja},
                  url: baseUrl + '/approvalmitrapekerja/tolak',
                  dataType: 'json',
                  timeout: 10000,
                    success: function (response) {
                        waitingDialog.hide();
                        if (response.status == 'berhasil') {
                            swal({
                                title: "Mitra Pekerja Ditolak",
                                text: "Mitra Pekerja Berhasil Ditolak",
                                type: "success",
                                showConfirmButton: false,
                                timer: 900
                            });
                            setTimeout(function(){
                                  window.location.reload();
                          }, 850);
                        }
                    }, error: function (x, e) {
                        waitingDialog.hide();
                        var message;
                        if (x.status == 0) {
                            message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                        } else if (x.status == 404) {
                            message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                        } else if (x.status == 500) {
                            message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                        } else if (e == 'parsererror') {
                            message = 'Error.\nParsing JSON Request failed.';
                        } else if (e == 'timeout') {
                            message = 'Request Time out. Harap coba lagi nanti';
                        } else {
                            message = 'Unknow Error.\n' + x.responseText;
                        }
                        waitingDialog.hide();
                        throwLoadError(message);
                        //formReset("store");
                    }
                })
            }, 2000);

        });
  }

  function print(id){
    $.ajax({
      type: 'get',
      data: {id:id},
      url: baseUrl + '/approvalmitrapekerja/print',
      dataType: 'json',
      success : function(result){

      }
    });
  }

  function selectall() {

      if ($('.setCek').is(":checked")) {
          table.$('input[name="pilih[]"]').prop("checked", true);
          //table.$('input[name="pilih[]"]').css('background','red');
          table.$('.chek-all').val('1');
      } else {
          table.$('input[name="pilih[]"]').prop("checked", false);
          table.$('.chek-all').val('');
      }
      hitung();
      //hitungSelect();
  }

  function selectBox(id) {
      if (table.$('.pilih-' + id).is(":checked")) {
          table.$('.pilih-' + id).prop("checked", false);
          table.$('.chek-' + id).val('1');
      } else {
          table.$('.pilih-' + id).prop("checked", true);
          table.$('.chek-' + id).val('');
      }
      //hitungSelect();
      hitung();
  }

  function hitung() {
      countmitra = table.$("input[name='pilih[]']:checked").length;
      $('#totalPekerja').val(countmitra + totalmitra);
  }

  function hitungSelect() {
      for (i = 0; i <= table.$('tr').length; i++)
          if (table.$('.pilih-' + i).is(":checked")) {
              table.$('.select-' + i).css('background', '#bbc4d6')
              //table.$('.select-'+i).css('color','white')
          } else {
              table.$('.select-' + i).css('background', '')
          }
  }

  function select(id) {
      if (table.$('.pilih-' + id).is(":checked")) {
          table.$('.pilih-' + id).prop("checked", false);
          table.$('.chek-' + id).val('');
      } else {
          table.$('.pilih-' + id).prop("checked", true);
          table.$('.chek-' + id).val('1');
      }
      //hitungSelect();
      hitung();
  }

  function setujuilist(){
    var mp_contract = $('#mp_contract').val();
    waitingDialog.show();
    setTimeout(function () {
    $.ajax({
      type: 'get',
      data: $('#formapprovalpekerja').serialize(),
      url: baseUrl + '/approvalmitrapekerja/setujuilist',
      dataType: 'json',
      success : function(result){
        waitingDialog.hide();
        if (result.status == 'berhasil') {
          swal({
              title: "Mitra Pekerja Disetujui",
              text: "Ingin Print Mitra Pekerja Sekarang?",
              type: "info",
              showCancelButton: true,
              confirmButtonClass: "btn-info",
              confirmButtonText: "Iya",
              cancelButtonText: "Tidak!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm) {
              if (isConfirm) {
                window.location.href = baseUrl + '/approvalmitrapekerja/print?mp_contract='+mp_contract;
              } else {
                swal.close();
                setTimeout(function(){
                      window.location.reload();
              }, 850);
              }
            });
        }
      }, error: function (x, e) {
          waitingDialog.hide();
          var message;
          if (x.status == 0) {
              message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
          } else if (x.status == 404) {
              message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
          } else if (x.status == 500) {
              message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
          } else if (e == 'parsererror') {
              message = 'Error.\nParsing JSON Request failed.';
          } else if (e == 'timeout') {
              message = 'Request Time out. Harap coba lagi nanti';
          } else {
              message = 'Unknow Error.\n' + x.responseText;
          }
          waitingDialog.hide();
          throwLoadError(message);
          //formReset("store");
      }
    });
  }, 2000);
  }

  function tolaklist(){
    waitingDialog.show();
    setTimeout(function () {
    $.ajax({
      type: 'get',
      data: $('#formapprovalpekerja').serialize(),
      url: baseUrl + '/approvalmitrapekerja/tolaklist',
      dataType: 'json',
      timeout: 10000,
      success : function(result){
        waitingDialog.hide();
        if (result.status == 'berhasil') {
          swal({
              title: "Mitra Pekerja Ditolak",
              text: "Mitra Pekerja Berhasil Ditolak",
              type: "success",
              showConfirmButton: false,
              timer: 900
          });
            setTimeout(function(){
                  window.location.reload();
          }, 850);
        }
      }, error: function (x, e) {
          waitingDialog.hide();
          var message;
          if (x.status == 0) {
              message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
          } else if (x.status == 404) {
              message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
          } else if (x.status == 500) {
              message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
          } else if (e == 'parsererror') {
              message = 'Error.\nParsing JSON Request failed.';
          } else if (e == 'timeout') {
              message = 'Request Time out. Harap coba lagi nanti';
          } else {
              message = 'Unknow Error.\n' + x.responseText;
          }
          waitingDialog.hide();
          throwLoadError(message);
          //formReset("store");
      }
    });
  }, 2000);
  }

</script>
@endsection
