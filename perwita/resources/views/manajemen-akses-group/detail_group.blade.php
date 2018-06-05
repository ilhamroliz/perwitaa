<table class="table table-bordered table-striped" id="example">                        
                        <thead>
                        <th>No</th>
                        <th>Nama Group</th>
                        <th>Nama Menu</th>
                        <th>Aksi</th>
                        </thead>                        
                        @foreach($aksesGroup as $index=> $data)
                        <tr>
                        <th>{{$index+1}}</th>                        
                        <th>{{$data->g_name}}</th>        
                        <th>{!!$data->akses!!}</th>        
                        <th>
                            <div class="dropdown">                                
                                <button class="btn btn-primary btn-flat btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Kelola
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="group/{{$data->g_id}}/edit"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>
                                    <li role="separator" class="divider"></li>                                                                                                                                                                         
                                    <li><a class="btn-delete" onclick="hapus(8)">Hapus Data</a></li>                                                
                                </ul>
                            </div>
                        </th>        
                        
                        </tr>
                        @endforeach
                            
</table>

<script>

    var table = $('#example').DataTable();
     
// var no='';
//$('#example tbody').on( 'click', 'tr', function () {
//    no=table.row( this ).index();    
//    alert( 'Row index: '+table.row( this ).index() );
//} );
</script>