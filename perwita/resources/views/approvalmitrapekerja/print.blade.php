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
                                    <h5>{{$data[0]->mc_no}}</h5>
                                    <address>
                                        <strong>{{$data[0]->m_name}}</strong><br>
                                        {{$data[0]->md_name}} <br>
                                        {{$data[0]->m_address}}<br>
                                        <abbr title="Phone">P:&nbsp;</abbr> {{$data[0]->m_phone}} <br>
                                        <br>
                                        {{$data[0]->mc_date}} - {{$data[0]->mc_expired}}
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">
                                </div>
                            </div>

                            <div>
                                <table class="table invoice-table">
                                  <thead>
                                  <tr>
                                    <th>Nama Pekerja</th>
                                    <th>NIK</th>
                                    <th>NIK Mitra</th>
                                    <th>Nama Mitra</th>
                                    <th>Nama Divisi</th>
                                    <th>Tanggal Seleksi</th>
                                    <th>Tanggal Mulai Bekerja</th>
                                    <th>Status</th>
                                  </tr>
                                  </thead>
                                    </thead>
                                    <tbody>
                                      @foreach($data as $x)
                                        <tr>
                                          <td>{{$x->p_name}}</td>
                                          <td>{{$x->p_nip}}</td>
                                          <td>{{$x->p_nip_mitra}}</td>
                                          <td>{{$x->m_name}}</td>
                                          <td>{{$x->md_name}}</td>
                                          <td>{{$x->mp_selection_date}}</td>
                                          <td>{{$x->mp_workin_date}}</td>
                                          <td>{{$x->mp_status}}</td>
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
