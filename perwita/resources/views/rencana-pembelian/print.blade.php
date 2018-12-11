@extends('main')

@section('title', 'Rencana Pembelian')

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
                    <div class="ibox-content p-xl row">
                            <div class="col-md-12">
                              <div class="col-sm-6" style="float: left;">
                                    <h5>From:</h5>
                                    <address>
                                        <strong>PT. Perwita Nusaraya</strong><br>
                                        Jalan Raya By Pass KM 31<br>
                                        Krian, Sidoarjo <br>
                                        <abbr title="Phone">P:&nbsp;</abbr> (031) 8988308
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right" style="float: right;">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy" id="nota">{{$data[0]->pp_nota}}</h4>
                                    <p>
                                        <span><strong>Invoice Date: </strong>{{Carbon\Carbon::parse($data[0]->pp_date)->format('d/m/Y')}}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive m-t" style="margin-top:150px;">
                                <table class="table invoice-table">
                                  <thead>
                                  <tr>
                                      <th>Item List</th>
                                      <th>Quantity</th>
                                      <th>Unit Price</th>
                                      <th>Discount</th>
                                      <th>Total Price</th>
                                  </tr>
                                  </thead>
                                    </thead>
                                    <tbody id="isi">
                                      @foreach($data as $x)
                                      <tr>
                                          <td>
                                          <div><strong>{{$x->k_nama}}</strong></div>
                                          <small>{{$x->i_nama}} Warna {{$x->i_warna}} Ukuran {{$x->s_nama}}</small>
                                          </td>
                                          <td>{{$x->ppd_qty}}</td>
                                          <td class="rp">Rp. {{number_format($x->id_price, 0, ',', '.')}}</td>
                                          <td class="rp">Rp. {{number_format(0, 0, ',', '.')}}</td>
                                          <td class="rp">Rp. {{number_format($x->id_price * $x->ppd_qty, 0, ',', '.')}}</td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->
                            </table>

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
