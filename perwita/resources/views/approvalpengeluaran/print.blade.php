@extends('main')

@section('title', 'Dashboard')

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
                              <div class="col-sm-6">
                                    <h5>From:</h5>
                                    <address>
                                        <strong>PT. Perwita Nusaraya</strong><br>
                                        Jalan Raya By Pass KM 31<br>
                                        Krian, Sidoarjo <br>
                                        <abbr title="Phone">P:&nbsp;</abbr> (031) 8988308
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy" id="nota">{{$data[0]->s_nota}}</h4>
                                    <span>To:</span>
                                    <address id="address">
                                      <strong>{{$data[0]->m_name}}</strong><br>
                                        {{$data[0]->m_address}}<br>
                                        <abbr title="Phone">P:&nbsp;</abbr> {{$data[0]->m_phone}}
                                    </address>
                                    <p>
                                        <span><strong>Invoice Date: </strong>{{Carbon\Carbon::parse($data[0]->s_date)->format('d/m/Y')}}</span>
                                    </p>
                                </div>
                            </div>

                            <div>
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
                                          <td>{{$x->sd_qty}}</td>
                                          <td class="rp">Rp. {{number_format($x->sd_value, 0, ',', '.')}}</td>
                                          <td class="rp">Rp. {{number_format($x->sd_disc_value, 0, ',', '.')}}</td>
                                          <td class="rp">Rp. {{number_format($x->sd_total_net, 0, ',', '.')}}</td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->
                            <br>
                            <table class="table invoice-total">
                              <tbody id="foo">
                                <tr>
                                    <td><strong>Sub Total :</strong></td>
                                    <td class="rp" id="subtotal">Rp. {{number_format($x->s_total_gross, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td><strong>TAX :</strong></td>
                                    <td class="rp" id="pajak">Rp. {{number_format($x->s_pajak, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td class="rp" id="total">Rp. {{number_format($x->s_total_net, 0, ',', '.')}}</td>
                                </tr>
                              </tbody>
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
