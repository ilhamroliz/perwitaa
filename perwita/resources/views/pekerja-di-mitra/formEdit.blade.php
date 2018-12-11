@extends('main')

@section('title', 'Pekerja di Mitra')

@section('extra_styles')

<style>


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
                    <h5>Form Tambah Data Bpjs</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

          <form id="form-pekerja" method="get" action="/pwt/pekerja-di-mitra/update&{{$dpm1->mp_id}}">
                        <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-10">
                                <input value="{{$dpm1->mp_comp}} ({{$c}})"  type="text" readonly="" class="form-control" name="p_n" id="p_n" placeholder="Masukkan No p_nik" >

                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">Nama Pekerja</label>
                            <div class="col-sm-10">

                                <input value="{{$dpm1->mp_pekerja}} ({{$p}})"  type="text" readonly="" class="form-control" name="n_p" id="n_p" placeholder="Masukkan No p_nik" >
                            </div>
                        </div>
                        <div hidden="">
                         <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">Nama Mitra</label>
                            <div class="col-sm-10">
                                <input value="{{$dpm1->mp_mitra}}"  type="text" readonly="" class="form-control" name="mitra" id="mitra" placeholder="Masukkan No p_nik" >

                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">Nama Divisi</label>
                            <div class="col-sm-10">
                                <input value="{{$dpm1->mp_divisi}}"  type="text" readonly="" class="form-control" name="divisi" id="divisi" placeholder="Masukkan No p_nik" >

                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">Mitra Nik</label>
                            <div class="col-sm-10">
                                <input value="{{$dpm1->mp_mitra_nik}}"  type="text" readonly="" class="form-control" name="m_n" id="m_n" placeholder="Masukkan No p_nik" >

                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <input value="{{$dpm1->mp_state}}"  type="text" readonly="" class="form-control" name="st" id="st" placeholder="Masukkan No p_nik" >

                            </div>
                        </div>
                           <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">Tgl Seleksi</label>
                            <div class="col-sm-10">
                                <input value="{{$dpm1->mp_selection_date}}"  type="text" readonly="" class="form-control" name="tgl_s" id="tgl_s" placeholder="Masukkan No p_nik" >

                            </div>
                        </div>
                           <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">Tgl Kerja</label>
                            <div class="col-sm-10">
                                <input value="{{$dpm1->mp_workin_date}}"  type="text" readonly="" class="form-control" name="tgl_k" id="tgl_k" placeholder="Masukkan No p_nik" >

                            </div>
                        </div>
                        </div>
                           <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">Tgl Terima Seragam</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" class="form-control" name="a_s" id="a_s" placeholder="Masukkan No p_nik" >

                            </div>
                        </div>
                           <div class="form-group row">
                            <label for="p_nik" class="col-sm-2 col-form-label">Tgl Bayar Seragam</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" class="form-control" name="b_s" id="b_s" placeholder="Masukkan No p_nik" >

                            </div>
                        </div>
                         <div class="hr-line-dashed">
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                               <a href="{{url('pekerja-di-mitra/pekerja-mitra')}}" class="btn btn-danger btn-flat" type="button">Kembali</a>
                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                        <button class="ladda-button ladda-button-demo btn btn-primary btn-outline btn-flat simpan" type="submit" name="Insert" value="Insert">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                                </div>
             </form>
         </div>
     </div>
 </div>
</div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
$('#a_s').datepicker({
        dateFormat: 'dd-mm-yy',
        language: "id"
    });
$('#b_s').datepicker({
        dateFormat: 'dd-mm-yy',
        language: "id"
    });
</script>
@endsection
