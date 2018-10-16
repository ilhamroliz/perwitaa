@extends('main')
@section('title', 'Akses User')
@section('extra_styles')
    <style>
        .popover-navigation [data-role="next"] {
            display: none;
        }

        .popover-navigation [data-role="end"] {
            display: none;
        }

        .huruf {
            text-transform: capitalize;
        }

        .spacing-top {
            margin-top: 15px;
        }

        #upload-file-selector {
            display: none;
        }

        .margin-correction {
            margin-right: 10px;
        }

        .checkbox.checkbox-single {

        label {
            width: 0;
            height: 16px;
            visibility: hidden;

        &
        :before,

        &
        :after {
            visibility: visible;
        }

        }
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
                    Setting Aplikasi
                </li>
                <li class="active">
                    <strong>Akses Pengguna</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row m-b-lg m-t-lg">
            <div class="col-md-6">

                <div class="profile-image">
                    <img src="
                    @if (file_exists($user->m_image))
                    {{ asset("$user->m_image") }}
                    @else
                    {{ asset("assets/img/user/default.jpg") }}
                    @endif
                            " class="img-circle circle-border m-b-md" alt="profile">
                </div>
                <div class="profile-info">
                    <div class="">
                        <div>
                            <h2 class="no-margins">
                                {{ $user->m_name }}
                            </h2>
                            <h4>{{ $user->j_name }}</h4>
                            <small>
                                {{ $user->m_addr }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <table class="table small m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Perusahaan</strong>
                        </td>
                        <td>
                            {{ $user->c_name }}
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <strong>Last Login</strong>
                        </td>
                        <td>
                            {{ $user->m_lastlogin }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Last Logout</strong>
                        </td>
                        <td>
                            {{ $user->m_lastlogout }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-3">
                <small>Username</small>
                <h2 class="no-margins">{{ $user->m_username }}</h2>
                <div id="sparkline1"><canvas style="display: inline-block; width: 247px; height: 50px; vertical-align: top;" width="247" height="50"></canvas></div>
            </div>
        </div>
        <div class="ibox">
            <div class="ibox-title">
                <h5>Akses Pengguna</h5>
            </div>
            <div class="ibox-content">
                <form class="row form-akses" style="padding-right: 18px; padding-left: 18px;">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <table class="table table-bordered table-striped" id="table-akses">
                        <thead>
                        <tr>
                            <th>Nama Fitur</th>
                            <th class="text-center">Read</th>
                            <th class="text-center">Insert</th>
                            <th class="text-center">Update</th>
                            <th class="text-center">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($akses as $data)
                            <tr>
                                <td>@if($data->a_parrent == $data->a_id) <strong>{{ $data->a_name }}</strong> @else<span
                                            style="margin-left: 20px;">{{ $data->a_name }}</span> @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="checkbox checkbox-success checkbox-single checkbox-inline">
                                            <input type="checkbox" class="read{{ $data->a_parrent }}"
                                                   @if($data->a_parrent == $data->a_id) id="read{{ $data->a_parrent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'read{{ $data->a_parrent }}');"
                                                   @endif name="read[]" value="{{ $data->a_id }}" @if($data->ma_read == 'Y') checked @endif>
                                            <label class=""> </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="checkbox checkbox-primary checkbox-single checkbox-inline">
                                            <input type="checkbox" class="insert{{ $data->a_parrent }}"
                                                   @if($data->a_parrent == $data->a_id) id="insert{{ $data->a_parrent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'insert{{ $data->a_parrent }}');"
                                                   @endif name="insert[]" value="{{ $data->a_id }}" @if($data->ma_insert == 'Y') checked @endif>
                                            <label class=""> </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="checkbox checkbox-warning checkbox-single checkbox-inline">
                                            <input type="checkbox" class="update{{ $data->a_parrent }}"
                                                   @if($data->a_parrent == $data->a_id) id="update{{ $data->a_parrent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'update{{ $data->a_parrent }}');"
                                                   @endif name="update[]" value="{{ $data->a_id }}" @if($data->ma_update == 'Y') checked @endif>
                                            <label class=""> </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="checkbox checkbox-danger checkbox-single checkbox-inline">
                                            <input type="checkbox" class="delete{{ $data->a_parrent }}"
                                                   @if($data->a_parrent == $data->a_id) id="delete{{ $data->a_parrent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'delete{{ $data->a_parrent }}');"
                                                   @endif name="delete[]" value="{{ $data->a_id }}" @if($data->ma_delete == 'Y') checked @endif>
                                            <label class=""> </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button style="float: right;" class="btn btn-primary" onclick="simpan()" type="button">Simpan
                    </button>
                    <a style="float: right; margin-right: 10px;" type="button" class="btn btn-white" href="{{ url('system/hakuser/user') }}" >Kembali</a>
                </form>
            </div>
        </div>
    </div>


@endsection
@section("extra_scripts")
    <script type="text/javascript">
        function handleChange(checkbox) {
            if (checkbox.checked) {
                var klas = checkbox.className;
                $('input[class="'+klas+'"]').prop("checked", true);
            } else {
                var klas = checkbox.className;
                $('input[class="'+klas+'"]').prop("checked", false);
            }
        }

        function checkParent(checkbox, id){
            if (checkbox.checked) {
                $('input[id="'+id+'"]').prop("checked", true);
            }
        }

        function simpan(){
            waitingDialog.show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ url('system/hakakses/simpan') }}',
                type: 'post',
                data: $('.form-akses').serialize(),
                success: function(response){
                    if (response.status == 'sukses') {
                        waitingDialog.hide();
                        location.reload();
                    }
                }, error:function(x, e) {
                    waitingDialog.hide();
                    if (x.status == 0) {
                        alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                    } else if (x.status == 404) {
                        alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                    } else if (x.status == 500) {
                        alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                    } else if (e == 'parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if (e == 'timeout'){
                        alert('Request Time out. Harap coba lagi nanti');
                    } else {
                        alert('Unknow Error.\n' + x.responseText);
                    }
                }
            })
        }
    </script>
@endsection
