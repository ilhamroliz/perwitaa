@extends('main')

@section('title', 'Penerimaan Pembelian')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }

    .footer {
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
                                      <th>No Nota</th>
                                      <th>No Delivery Order</th>
                                      <th>Quantity</th>
                                      <th>Item List</th>
                                      <th>Tanggal Penerimaan</th>
                                  </tr>
                                  </thead>
                                    </thead>
                                    <tbody id="isi">
                                      @foreach($data as $x)
                                      <tr>
                                        <td>{{$x->sm_nota}}</td>
                                        <td>{{$x->sm_delivery_order}}</td>
                                        <td>{{$x->sm_qty}}</td>
                                        <td>
                                        <div><strong>{{$x->k_nama}}</strong></div>
                                        <small>{{$x->i_nama}} Warna {{$x->i_warna}} Ukuran {{$x->s_nama}}</small>
                                        </td>
                                        <td>{{Carbon\Carbon::parse($x->sm_date)->format('d/m/Y')}}</td>
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
