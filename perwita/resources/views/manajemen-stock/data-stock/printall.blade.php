@extends('main')

@section('title', 'Stock Seragam')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }

    .footer{
      display: none;
    }
</style>

@endsection

@section('content')
                <div class="wrapper wrapper-content p-xl">
                    <div class="ibox-content p-xl">
                            <div class="row">


                            <div class="table-responsive m-t">
                                <table class="table invoice-table" id="tabelpenerimaan">
                                  <thead>
                                  <tr>
                                    <th style="text-align: center;" >NAMA SERAGAM</th>
                                    <th style="text-align: center;" >UKURAN</th>
                                    <th style="text-align: center;" >JUMLAH</th>
                                    <th style="text-align: center;" >HARGA</th>
                                    <th style="text-align: center;" >KETERANGAN</th>
                                  </tr>
                                  </thead>
                                    </thead>
                                    <tbody id="isi">
                                      @foreach($pp as $x)
                                      <tr>
                                        <td>{{$x->i_nama}}</td>
                                        <td>{{$x->s_nama}}</td>
                                        <td>{{$x->s_qty}}</td>
                                        <td>{{$x->i_nama}}</td>
                                        <td>{{$x->id_price}}</td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->
                        </div>
    </div>

@endsection

@section('extra_scripts')
    <script type="text/javascript">
    window.document.close();
    window.focus();
    window.print();
    window.close();
    </script>
@endsection
