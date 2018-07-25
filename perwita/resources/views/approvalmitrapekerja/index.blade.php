@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
.popover-navigation [data-role="next"] { display: none; }
.popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Approval Mitra Pekerja</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Approval Mitra Pekerja</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h5>Daftar Approval Mitra Pekerja</h5>
      </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg">
                <div class="col-md-12" style="margin: 10px 0px 20px 0px;">

                  <form method="get" action="index.html" class="pull-right mail-search">
                      <div class="input-group">
                          <div class="input-group-btn">
                          </div>
                      </div>
                  </form>
              </div>
                  <div class="mail-box">                  
                  <table class="table table-hover table-mail">
                  <tbody>
                    @if(!empty($data))
                    @foreach($data as $index => $x)
                  <tr class="read" onclick="ngelink({{$x->mp_mitra}},{{$x->mp_divisi}})" style="cursor:pointer;">
                    <td style="color:#009aa9;">{{$index + 1}}</td>
                    <td class="mail-ontact" style="color:#009aa9;">{{$x->m_name}}</td>
                    <td class="mail-subject" style="color:#009aa9;">{{$x->md_name}}</td>
                    <td class="text-right mail-date" style="color:#009aa9;">{{$x->mp_insert}}</td>
                  </tr>
                    @endforeach
                    @else
                    <center>
                    <p>Tidak Ada Data Approval Mitra Pekerja</p>
                    </center>
                    @endif
                  </tbody>
                  </table>
            </div>
            <p>Note: Klik salah satu mitra untuk lihat daftar approval mitra pekerja</p>
        </div>
    </div>
</div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript">
    function ngelink(mitra,divisi){
      window.location.href = baseUrl + '/approvalmitrapekerja/daftarpekerja/'+mitra+'/'+divisi;
    }
</script>
@endsection
