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
        <div class="row">
            @foreach($member as $data)
            <div class="col-lg-3">
                <div class="contact-box center-version">
                    <a href="profile.html">
                        @if($data->m_image!='')                        
                        <img src="{{URL::to('/')}}/{{$data->m_image}}" class="img-circle circle-border m-b-md" alt="profile">
                        @else
                        <img src="{{URL::to('/')}}/assets/img/profile_small.jpg" class="img-circle circle-border m-b-md" alt="profile">
                        @endif
                        <h3 class="m-b-xs"><strong>{{$data->m_name}}</strong></h3>

                        <div class="font-bold">Tanggal Lahir</div>
                        <address>                            
                            @if($data->m_birth_tgl=='')-
                            @elseif($data->m_birth_tgl!='')
                            {{$data->m_birth_tgl}}
                            @endif
                            <br>                                                        
                        </address>
                        <div class="font-bold">Alamat</div>
                        <address>                            
                            @if($data->m_addr=='')-<br><br><br><span style="color:#ffffff ">-</span><br>
                            @elseif($data->m_addr!='')
                                @if(strlen($data->m_addr) >100)
                                    {!! substr($data->m_addr, 0, 100) !!}...                                    
                                @else
                                    {{$data->m_addr}}...
                                @endif                                                       
                            @endif                                                       
                        </address>
                        

                    </a>
                    <div class="contact-box-footer">
                        <div class="m-t-xs btn-group">
                            <a href="{{url('manajemen-pengguna/edit/'.$data->m_id)}}" class="btn btn-xs btn-white"><i class="fa fa-edit"></i> Edit </a>
                            <a class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> Email</a>                            
                        </div>
                    </div>

                </div>
            </div>
            
            
            @endforeach        
            <div class="col-md-12 text-right">@include('pagination', ['paginator' => $member])</div>
        </div>
        </div>



@endsection

@section('extra_scripts')
<script type="text/javascript">

</script>
@endsection