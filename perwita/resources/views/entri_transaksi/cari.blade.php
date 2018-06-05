@extends('main')
@section('title', 'dashboard')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Transaksi</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>            
            <li class="active">
                <strong>Data Transaksi</strong>
            </li>
        </ol>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Transaksi</h5> 
                    <div class="ibox-tools">
                        <button class="btn btn-primary btn-xs" type="button" onclick="tambahdata()"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Tambah</span></button>
                    </div>
                </div>
                <div class="ibox-content">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                   {!! Form::open(['url' => 'entri-transaksi/data-transaksi/cari_tanggal/get', 'method' => 'GET', 'id' => 'form-pencarian']) !!}      
                    <div class="row">                       
                        <div class="col-sm-3 m-b-xs">
                            <select style="padding:1px 10px" onchange="cari()" class="input-sm form-control input-s-sm inline cari">                                
                                <option value="" disabled="" selected="">Pilih Pencarian</option>
                                <option @if($pilihan=='1') selected @endif value="1">Tanggal</option>
                                <option @if($pilihan==0) selected @endif value="0">Nominal</option>                                    
                            </select>
                        </div>                       
                        <div class="col-sm-1">                        
                        </div>
                        <div class="col-sm-6">                        
                            <div class="form-group cari_tgl" id="data_5" style="display: none">                                
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start_tgl" />
                                    <span class="input-group-addon"> - </span>
                                    <input type="text" class="input-sm form-control" name="end_tgl" />
                                </div>
                            </div>
                            <div class="form-group cari_nominal col-sm-10"  style="display: none">                                
                                <div class=" input-group">
                                    <input type="text" class="input-sm form-control nominal" name="start_nominal" value="{{$start_nominal}}"/>
                                    <span class="input-group-addon"> - </span>
                                    <input type="text" class="input-sm form-control nominal" name="end_nominal" value="{{$end_nominal}}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 pull-right btn-reload" style="display: none">  
                            <button class="btn btn-primary btn-sm"><span class="fa fa-search"></span></button>    
                            <a href="{{url('entri-transaksi/data-transaksi')}}" class="btn btn-primary btn-sm"><span class="fa fa-refresh"></span></a>   
                        </div>
                    </div>
                    {!! Form::close() !!}
                     <div class="col-md-12" style="margin:10px; border-bottom: 2px solid #efefef; padding:0px;">
                            <div class="col-md-3" style="padding:0px;">

                            </div>
                            <div class="col-md-5 image-holder" style="padding:0px; padding-bottom: 20px;">

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
						 <tfoot>
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
                        </tfoot> 
                        <tbody>
                            @foreach($jurnal as $jurnal)
                            <tr>
                                <td>{{$jurnal->rownum}}</td>
                                <td>{{$jurnal->jr_trans}}</td>
                                <td>{{$jurnal->jr_cashtype}}</td>
                                <td>{{$jurnal->jr_tgl}}</td>
                                <td>{{$jurnal->jr_detail}}</td>
                                <td>{{$jurnal->jr_value}}</td>
                                <td>{{$jurnal->jr_note}}</td>  
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
    $('.nominal').maskMoney({prefix: 'Rp. ', thousands: '.', decimal: ',', precision: 0, allowZero: true});
    $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: 'dd-M-yyyy',
            });

    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd-M-yyyy',
    }).datepicker("setDate", "0");
    cari();
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
           "pageLength": 10,
       "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
       //"scrollY": '50vh',
       //"scrollCollapse": true,
       "language": dataTableLanguage,
   });
//        processing: true,
//        serverSide: true,
//         ajax: {
//        url:  baseUrl + '/entri-transaksi/data-transaksi/get',
//        type: 'get',
//        data:{data:'data'},
//        dataType: 'json'
//    },
////    ajax: '{{ url('entri-transaksi/data-transaksi/get') }}',  
////        dataType: 'json',
////        data:{data:'data'},
//        
//        
//        columns: [
//            {data: 'rownum', name: 'rownum'},
//            {data: 'jr_trans', name: 'jr_trans'},
//            {data: 'jr_cashtype', name: 'jr_cashtype'},
//            {data: 'jr_tgl', name: 'jr_tgl'},
//            {data: 'jr_detail', name: 'jr_detail'},
//            {data: 'jr_value', name: 'jr_value', 'class': 'text-right'},
//            {data: 'jr_note', name: 'jr_note'},
//            {data: 'action', name: 'action',orderable:false,searchable:false}
//        ],
//        responsive: true,
//
//        "pageLength": 10,
//        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
//        //"scrollY": '50vh',
//        //"scrollCollapse": true,
//        "language": {
//            "lengthMenu": "Tampilkan _MENU_ hasil ",
//            "zeroRecords": "Maaf - Tidak ada yang di temukan",
//            "info": "Tampilan Halaman _PAGE_ Dari _PAGES_",
//            "infoEmpty": "Tidak Ada Hasil Yang Sesuai",
//            "infoFiltered": "(Mencari Dari _MAX_ total Hasil)",
//            "search": "Pencarian"
//
//        }
//    });

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
