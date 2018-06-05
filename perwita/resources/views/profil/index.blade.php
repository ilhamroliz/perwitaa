@extends('main')

@section('title', 'Dashboard')

@section('extra_styles')

<style>
    .popover-navigation [data-role="next"] { display: none; }
    .popover-navigation [data-role="end"] { display: none; }
</style>

@endsection

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">

    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-b-lg m-t-lg">
                <div class="col-md-12">
                    <div class="profile-image">
                        <img src="{{URL::to('/')}}/{{$member->m_image}}"  class="img-circle circle-border m-b-md" alt="profile">
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h2 class="no-margins">
                                    {{$member->m_name}}
                                </h2>                               
                                <table class="table ">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Alamat
                                            </td>
                                            <td>
                                                {{$member->m_addr}}
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                Tanggal Lahir
                                            </td>
                                            <td>
                                                {{date('d-M-Y', strtotime($member->m_birth_tgl))}}
                                            </td>
                                        </tr>                       
                                    </tbody>
                                </table>
                                <a href="{{URL::to('/')}}/profil/ubah-profil/{{$member->m_id}}" type="button" class="ladda-button  ladda-button-demo  btn btn-primary  m-b btn-flat" data-style="zoom-in"><span class="ladda-label">Edit Profile</span><span class="ladda-spinner"></span></a>
                                <a href="{{URL::to('/')}}/profil/ubah-password/{{$member->m_id}}" class="ladda-button  ladda-button-demo  btn btn-primary  m-b btn-flat" data-style="zoom-in"><span class="ladda-label">Edit Kata Sandi</span><span class="ladda-spinner"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>





</div>



@endsection

@section('extra_scripts')
<script type="text/javascript">

</script>
@endsection