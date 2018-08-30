@extends('main')
@section('title', 'Akses User')
@section('extra_styles')
<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    .huruf{
        text-transform: capitalize;
    }
    .spacing-top{
        margin-top:15px;
    }
    #upload-file-selector {
        display:none;   
    }
    .margin-correction {
        margin-right: 10px;   
    }
</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Akses Pengguna</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Manajemen Pengguna
            </li>
            <li class="active">
                <strong>Akses Pengguna</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox">
    <div class="ibox-title">
      <h5>Akses Pengguna</h5>
    </div>
    <div class="ibox-content">
      
    </div>
  </div>
</div>
           

@endsection
@section("extra_scripts")
<script type="text/javascript">

</script>
@endsection()