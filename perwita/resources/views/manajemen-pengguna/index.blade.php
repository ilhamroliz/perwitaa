@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
    .tambah{
        font-size: 100px;
    }
    
</style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Manajemen Pengguna</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
                Setting Aplikasi
            </li>
            <li class="active">
                <strong>Manajemen Pengguna</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="">
        <table>
            <?php $counter = 1; ?>
            <tr class="row">
                <td class="col-lg-4">
                    <div onclick="tambah()" style="cursor: pointer;" title="Tambah User">
                        <div class="contact-box text-center">
                            <span class="fa fa-user-plus tambah"></span>
                        </div>
                    </div>
                </td>
        @foreach($member as $index=>$data)
            @if($counter%3 == 0)
                <tr class="row">
            @endif
                <td class="col-lg-4 {{ $counter }}">
                    <div>
                        <div class="contact-box">
                            <a href="{{ url('manajemen-pengguna/edit/' . Crypt::encrypt($data->m_id) ) }}">
                            <div class="col-sm-4">
                                <div class="text-center">
                                    <img alt="image" class="img-circle m-t-xs img-responsive" src="
                                    @if (file_exists('{{ asset("'.$data->m_image.'") }}'))
                                        {{ asset("'.$data->m_image.'") }}
                                    @else
                                        {{ asset("assets/img/user/default.jpg") }}
                                    @endif
                                    ">
                                    <div class="m-t-xs font-bold">{{ $data->j_name }}</div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h3><strong>{{ $data->m_name }}</strong></h3>
                                <p><i class="fa fa-user-circle"></i> {{ $data->m_username }}</p>
                                <address>
                                    <strong>{{ $data->c_name }}</strong><br>
                                    {{ $data->m_addr }}<br>
                                </address>
                            </div>
                            <div class="clearfix"></div>
                            </a>
                        </div>
                    </div>

                </td>
                <?php ++$counter ?>
            @if($counter%3 == 0)
                </tr>
            @endif
        @endforeach
        </table>
    </div>
</div>


@endsection

@section('extra_scripts')
<script type="text/javascript">
    function tambah(){
        location.href = ('{{ url('manajemen-pengguna/tambah') }}');
    }
</script>
@endsection