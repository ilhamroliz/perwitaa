<div class="row border-bottom">
    
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0; background: #F3F3F4;">
          <div class="navbar-header">
              <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
              <form role="search" class="navbar-form-custom" action="search_results.html">
                  
              </form>
          </div>              
            @if (Request::path() == 'dashboard')
            <ul class="nav navbar-top-links navbar-left">
                <li>
                    <a class="disabled">
                   <div style="color: #C9C9C9;font-size: 20px; position: absolute;" class="text-muted welcome-message  wadah-mengetik">
                       Selamat Datang di Halaman Dashboard
                    </div>                   
                    </a>
                </li>               
            </ul>
            @endif
            <ul class="nav navbar-top-links navbar-right">              
                {{-- <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="{{asset('assets/img/a7.jpg')}}">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="{{asset('assets/img/a4.jpg')}}">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="{{asset('assets/img/a7.jpg')}}">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li> --}}
                {{-- <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li> --}}
                <li>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                         <span class="text-muted text-xs block" style="color: #C9C9C9;"><i class="fa fa-user"></i>
                          {{ Auth::user()->m_name }} <b class="caret"></b></span> 
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">                       
                        <li><a href="{{url('profil')}}">Lihat Profile</a></li>                      
                        <li class="divider"></li>
                        <li><a href="{{ url('logout') }}">
                                <i class="fa fa-sign-out" ></i> Logout</a></li>
                    </ul>
                </li>
                
            </ul>
        </nav>
      </div>      
      <style>     
          a.disabled {
   pointer-events: none;
   cursor: default;
   
}


.wadah-mengetik
{
	font-size: 22px;
	width: 500px;
	white-space:nowrap;
	overflow:hidden;
	-webkit-animation: ketik 8s steps(50, end) infinite;
	animation: ketik 8s steps(50, end) infinite;
}

@keyframes ketik{
		from { width: 0; }
}

@-webkit-keyframes ketik{
		from { width: 0; }
}

      </style>