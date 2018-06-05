  <link href="{{ asset('assets/vendors/dataTables/datatables.min.css') }}" rel="stylesheet">
<table id="trans" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                {{--<th width="15px">Kode</th>--}}                                    
                                <th>No</th>                                    
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


<script src="{{ asset('assets/vendors/dataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>
@section('extra_scripts')
<script type="text/javascript">
  
    var table = $("#trans").DataTable({
    processing: true,
            serverSide: true,
            ajax: '{{ url("entri-transaksi/data-transaksi/get") }}',
            columns: [
            {data: 'jr_id', name: 'jr_id'},
            {data: 'jr_trans', name: 'jr_trans'},
            {data: 'jr_cashtype', name: 'jr_cashtype'},
            {data: 'jr_tgl', name: 'jr_tgl'},
            {data: 'jr_detail', name: 'jr_detail'},
            {data: 'jr_value', name: 'jr_value', 'class': 'text-right'},
            {data: 'jr_note', name: 'jr_note'},
            {data: 'action', name: 'action'}
            ],
            //responsive: true,

            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            //"scrollY": '50vh',
            //"scrollCollapse": true,
            "language": {
            "lengthMenu": "Tampilkan _MENU_ hasil ",
                    "zeroRecords": "Maaf - Tidak ada yang di temukan",
                    "info": "Tampilan Halaman _PAGE_ Dari _PAGES_",
                    "infoEmpty": "Tidak Ada Hasil Yang Sesuai",
                    "infoFiltered": "(Mencari Dari _MAX_ total Hasil)",
                    "search": "Pencarian"

            }
    });


</script>
@endsection
