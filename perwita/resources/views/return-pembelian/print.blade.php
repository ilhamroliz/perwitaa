@extends('main')

@section('title', 'Return Pembelian')

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
                      <div id="divuang">
                      <h2>Ganti Uang</h2>
                      <table id="tableuang" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>No Return</th>
                            <th>Item Detail</th>
                            <th>Harga Awal</th>
                            <th>Harga Akhir</th>
                            <th>Qty</th>
                            <th>Keterangan</th>
                          </tr>
                        </thead>
                        <tbody id="showuang">
                          @foreach ($uang as $key => $value)
                            <tr>
                               <td>{{$value->rs_nota}}</td>
                               <td>
                               <div><strong>{{$value->k_nama}}</strong></div>
                               <small>{{$value->i_nama}}  {{$value->i_warna}} ( {{$value->s_nama}} )</small>
                               </td>
                               <td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> {{$value->rsd_hpp}}</span></td>
                               <td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> {{$value->rsd_value}}</span></td>
                               <td>{{$value->rsd_qty}}</td>
                               <td>{{$value->rsd_note}}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      </div>

                      <div id="divbarang">
                        <h2>Ganti Barang</h2>
                        <table id="tablebarang" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>No Return</th>
                              <th>Item Detail</th>
                              <th>Harga Awal</th>
                              <th>Harga Akhir</th>
                              <th>Qty</th>
                              <th>Keterangan</th>
                            </tr>
                          </thead>
                          <tbody id="showbarang">
                            @foreach ($barang as $key => $value)
                              <tr>
                                 <td>{{$value->rs_nota}}</td>
                                 <td>
                                 <div><strong>{{$value->k_nama}}</strong></div>
                                 <small>{{$value->i_nama}}  {{$value->i_warna}} ( {{$value->s_nama}} )</small>
                                 </td>
                                 <td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> {{$value->rsd_hpp}}</span></td>
                                 <td class="rp"><span style="float:left;">Rp.</span><span style="float:right;"> {{$value->rsd_value}}</span></td>
                                 <td>{{$value->rsd_qty}}</td>
                                 <td>{{$value->rsd_note}}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>

                      <div id="divganti">
                        <h2>Barang Pengganti</h2>
                        <table id="tableganti" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>No Ganti Barang</th>
                              <th>Item Detail</th>
                              <th>Qty</th>
                            </tr>
                          </thead>
                          <tbody id="showganti">
                            @foreach ($barangbaru as $key => $value)
                              <tr>
                                 <td>{{$value->rsg_no}}</td>
                                 <td>
                                 <div><strong>{{$value->k_nama}}</strong></div>
                                 <small>{{$value->i_nama}}  {{$value->i_warna}} ( {{$value->s_nama}} )</small>
                                 </td>
                                 <td>{{$value->rsg_qty}}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>

                        </div>

    </div>

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        window.document.close();
        window.focus();
        window.print();
        window.close();

        $('.rp').digits();
    </script>
@endsection
