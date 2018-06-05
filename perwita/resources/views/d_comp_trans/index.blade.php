@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="wrapper wrapper-content">

    <div class="alertBody" style="display: none;">
    </div>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
    
      <div class="panel-heading">Daftar Transaksi
            <div class="pull-right">
                <button class="btn btn-primary btn-xs" type="button" onclick="tambahdata()"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Tambah</span></button>
            </div>
        </div>
        <div class="panel-body">      
              <center>
                        <div class="spiner-example">
                            <div class="sk-spinner sk-spinner-wave" style="margin-bottom: 10px;">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                            <span class="infoLoad" style="color: #aaa; font-weight: 600;">Menyiapkan Data Perusahaan</span>
                        </div>
                    </center>
                    <table id="d_comp_trans" class="table table-bordered" style="display:none">
                        <thead>
                            <tr>                  
                                <th>Kode</th>                         
                                <th>Nama Transaksi</th>
                                <th>Nama Sub Transaksi</th>
                                <th>Cashtype Transaksi</th>                   
                                <th>Akun 1</th>                        
                                <th>Akun 2</th>                        
                                <th class="text-center">Action</th>
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





@endsection



@section('extra_scripts')
<script type="text/javascript">
    function tambahdata() {
        window.location.href = baseUrl + '/data-master/master-transaksi-akun/create'

    }
   


    setTimeout(function () {
        $('#d_comp_trans').css('display', '')
        $('.spiner-example').css('display', 'none')
        var table = $("#d_comp_trans").DataTable({
            responsive: true,
            "language": dataTableLanguage,
            processing: true,
            serverSide: true,
            ajax: '{{ url("data-master/master-transaksi-akun/data") }}',
            columns: [
                {data: 'tr_code', name: 'tr_code'},
                {data: 'tr_name', name: 'tr_name'},
                {data: 'tr_namesub', name: 'tr_namesub'},
                {data: 'tr_cashtype', name: 'tr_cashtype'},
                {data: 'coa1name', name: 'coa1name'},
                {data: 'coa2name', name: 'coa2name'},
                {data: 'action', name: 'action'},
            ],
            //responsive: true,

            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
            //"scrollY": '50vh',
            //"scrollCollapse": true,

        });
    }, 1000);









    $('#d_comp_trans').on('click', '.btn-delete[data-remote]', function (e) {
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
                type: 'delete',
                dataType: 'text',
                // headers: {'X-XSRF-TOKEN': $_token},
                data: {method: '_DELETE', submit: true},
                success: function (response) {
                    console.log(response);
                    $('.alertBody').html('<div class="alert alert-success">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            response +
                            '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
                }

            }).always(function (data) {
                $('#d_comp_trans').DataTable().draw(false);
            });
        }
    });


</script>
@endsection
