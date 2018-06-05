@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
     @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
    <div class="row">
        <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
    
                        <div class="panel-heading">Daftar Transasi
                            <div class="pull-right"><button class="btn btn-primary btn-xs" type="button" onclick="tambahdata()"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Tambah</span></button></div>
                        </div>                        
                        <div class="panel-body">
                            <div class="ibox-content">
                             {!! Form::open(['url' => 'entri-transaksi/data-transaksi/cari_tanggal/get', 'method' => 'GET', 'id' => 'form-pencarian']) !!}      
                    <div class="row">
                        <div class="col-sm-3 m-b-xs">
                            <select style="padding:1px 10px" name="pilih" onchange="cari()" class="input-sm form-control input-s-sm inline cari">
                                <option value="" disabled="" selected="">Pilih Pencarian</option>
                                <option value="1">Tanggal</option>
                                <option value="0">Nominal</option>                                    
                            </select>
                        </div>                       
                        <div class="col-sm-1">                        
                        </div>
                        <div class="col-sm-6">                        
                            <div class="form-group cari_tgl" id="data_5" style="display: none">                                
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control date" name="start_tgl" />
                                    <span class="input-group-addon"> - </span>
                                    <input type="text" class="input-sm form-control date" name="end_tgl"/>
                                </div>
                            </div>
                            <div class="form-group cari_nominal col-sm-10"  style="display: none">                                
                                <div class=" input-group">
                                    <input type="text" class="input-sm form-control nominal" name="start_nominal"/>
                                    <span class="input-group-addon"> - </span>
                                    <input type="text" class="input-sm form-control nominal" name="end_nominal" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 pull-right btn-reload" style="display: none">  
                            <button type="button" class="btn btn-primary btn-sm"><span class="fa fa-search"></span></button>    
                            <a href="{{url('entri-transaksi/data-transaksi')}}" class="btn btn-primary btn-sm"><span class="fa fa-refresh"></span></a>    
                        </div>
                    </div>
                    {!! Form::close() !!}
                       <div class="col-md-12" style="margin:10px; border-bottom: 2px solid #efefef; padding:0px;">
                            <div class="col-md-3" style="padding:0px;">

                            </div>
                            <div class="col-md-5 " style="padding:0px; padding-bottom: 20px;">

                            </div>
                        </div>
                    
                    <table id="trans" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>               
                             <th style="width: 10px;">No</th>                  
                                <th>Kode Transaksi</th>            
                                <th> Cash Flow</th>
                                <th>Tanggal</th>
                                <th>Detail Jurnal</th>
                                <th class="text-right">Nominal</th>
                                <th>Catatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>            
					
                        <tbody>                       
                        </tbody>
                    </table>
                    
                    
                    
                        </div>
                        </div>
        </div>
        </div>
        </div>
        
        


    </div>
</div>







































@endsection



@section('extra_scripts')
<script type="text/javascript">
   $('.date').datepicker({
                autoclose: true,               
                 format: 'dd-M-yyyy',
      }).datepicker("setDate", "0");
    $('.nominal').maskMoney({prefix: 'Rp. ', thousands: '.', decimal: ',', precision: 0, allowZero: true});
    $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: 'dd-M-yyyy',
            });
            
    

/*
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
    }).datepicker("setDate", "0");*/
    function cari(){
        $cari_berdasar=$('.cari').val();
       // alert($cari_berdasar);
        if($cari_berdasar==1){
            $('.cari_tgl').css('display','');
            $('.cari_nominal').css('display','none');
            $('.btn-reload').css('display','');
        }
        else if($cari_berdasar==0){
            $('.cari_nominal').css('display','');
            $('.cari_tgl').css('display','none');
            $('.btn-reload').css('display','');
        }
    }
    function tambahdata() {
        window.location.href = baseUrl + '/entri-transaksi/data-transaksi/create'
    }
    function hapusData(id) {

        $.ajax({
            url: baseUrl + '/entri-transaksi/data-transaksi/destroy/' + id,
            url: url,
                    type: 'DELETE',
            dataType: 'text',
            // headers: {'X-XSRF-TOKEN': $_token},
            data: {method: '_DELETE', submit: true},
            success: function (response) {
                console.log(response);
                if (response == 'sukses') {

                    $('.alertBody').html('<div class="alert alert-success">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            'Data Berhasil Di Hapus' +
                            '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
                    $("#hapus" + id).remove();
                } else if (response == 'gagal') {
                    $('.alertBody').html('<div class="alert alert-danger">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            'Data Akun Sudah Digunakan' +
                            '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
                }

            }
        });
    }
     $('#trans tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" style="padding:0px" />');
            });

    var table = $("#trans").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('entri-transaksi/data-transaksi/get') }}',  
        dataType: 'json',
        columns: [
            {data: 'rownum', name: 'rownum'},
            {data: 'jr_trans', name: 'jr_trans'},
            {data: 'jr_cashtype', name: 'jr_cashtype'},
            {data: 'jr_tgl', name: 'jr_tgl'},
            {data: 'jr_detail', name: 'jr_detail'},
            {data: 'jr_value', name: 'jr_value', 'class': 'text-right'},
            {data: 'jr_note', name: 'jr_note'},
            {data: 'action', name: 'action',orderable:false,searchable:false}
        ],
        responsive: true,

        "pageLength": 10,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        //"scrollY": '50vh',
        //"scrollCollapse": true,
        "language": dataTableLanguage,
    });

  table.columns().every(function () {
                var that = this;

                $('input', table.column(3).footer()).disabled = true;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                                .search(this.value)
                                .draw();
                    }
                });
            });

    $('#trans').on('click', '.btn-delete[data-remote]', function (e) {
        if (confirm('Apakah anda yakin ingin meghapus?')) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');
            // confirm then
            $.ajax({
                url: url,
                type: 'DELETE',
                dataType: 'text',
                //headers: {'X-XSRF-TOKEN': $_token},
                data: {method: '_DELETE', submit: true},
                success: function (response) {
                    $('.alertBody').html('<div class="alert alert-success">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            response +
                            '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
                }

            }).always(function (data) {
                $('#trans').DataTable().draw(false);
            });
        }
    });
	
	


</script>
@endsection
