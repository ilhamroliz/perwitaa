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
                              <li class="dropdown">
                                  <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                      <i class="fa fa-bell"></i>  <span class="label label-primary" id="countnotif">0</span>
                                  </a>
                                  <ul class="dropdown-menu dropdown-alerts">
                                    <li id="pekerjaapproval">
                                      
                                    </li>

                                        <div class="text-center link-block">
                                            <a href="mailbox.html">
                                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                            </a>
                                        </div>
                                    </li>
                                  </ul>
                              </li>


                              <li>
                                  <a href="{{url('logout')}}">
                                      <i class="fa fa-sign-out"></i> Log out
                                  </a>
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
