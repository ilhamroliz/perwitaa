@extends('main')
@section('title', 'Dashboard')
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
<!--BEGIN PAGE WRAPPER-->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="page-content fadeInRight">
        <div class="row mbl">
            <div class="middle-box text-center animated fadeInDown">
                <h1 style="margin-top: -150px;">403</h1>
                <h3 class="font-bold">Not Authorized!!!</h3>

                <div class="error-desc">
                    Anda tidak mendapatkan ijin untuk mengakses halaman ini<br>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section("extra_scripts")
<script type="text/javascript">

</script>
@endsection()