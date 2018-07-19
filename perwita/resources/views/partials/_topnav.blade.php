<style media="screen">
  #approvaldown{
    background-color: #f6f6f6;
  }

  .dropdown-messages-box:hover{
    background-color: rgba(0, 0, 0, 0.06);
  }
</style>

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

                    <!-- <strong>{{ Session::get('sukses') }}</strong> -->

            <ul class="nav navbar-top-links navbar-right">
                              <li class="dropdown">
                                @if(Session::has('jabatan'))
                                  @if(Session::get('jabatan') == 1 || Session::get('jabatan') == 6)
                                  <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                      <input type="hidden" name="operatornotif" value="" id="operatornotif">
                                      <i class="fa fa-bell"></i>  <span class="label label-warning" id="countnotif"></span>
                                  </a>
                                  <ul class="dropdown-menu dropdown-alerts approvaldown"  id="approvaldown">
                                    <div class="media-body" id="showpelamar">
                                      <li>
                                          <div class="dropdown-messages-box">

                                            <div class="media-body">
                                            <a href="{{url('/approvalpelamar')}}" class="pull-left a-body" id="#pelamar-body" title="Lihat Daftar Approval Pelamar" style="text-decoration:none; color:black;">
                                                <small class="pull-right" id="menitpelamar"></small>
                                                <strong id="catatanapprovalpelamar"></strong><small id="isiapprovalpelamar"></small><br>
                                             </a>
                                            </div>
                                        </div>
                                        </li>
                                    </div>
                                    <li class="divider" style="background-color:rgb(179, 179, 179);"></li>
                                    <div class="media-body" id="showmitra">
                                      <li>
                                          <div class="dropdown-messages-box">

                                            <div class="media-body">
                                            <a href="{{url('/approvalmitra')}}" class="pull-left a-body" id="#mitra-body" title="Lihat Daftar Approval Mitra" style="text-decoration:none; color:black;">
                                                <small class="pull-right" id="menitmitra"></small>
                                                <strong id="catatanapprovalmitra"></strong><small id="isiapprovalmitra"></small><br>
                                             </a>
                                            </div>
                                        </div>
                                        </li>
                                    </div>
                                    <li class="divider" style="background-color:rgb(179, 179, 179);"></li>
                                    <div class="media-body" id="showpembelian">
                                      <li>
                                          <div class="dropdown-messages-box">

                                            <div class="media-body">
                                            <a href="{{url('/approvalpembelian')}}" class="pull-left a-body" id="#pembelian-body" title="Lihat Daftar Approval Pembelian Seragam" style="text-decoration:none; color:black;">
                                                <small class="pull-right" id="menitpembelian"></small>
                                                <strong id="catatanapprovalpembelian"></strong><small id="isiapprovalpembelian"></small><br>
                                             </a>
                                            </div>
                                        </div>
                                        </li>
                                    </div>
                                    <li class="divider" style="background-color:rgb(179, 179, 179);"></li>
                                    <div class="media-body" id="showsp">
                                      <li>
                                          <div class="dropdown-messages-box">

                                            <div class="media-body">
                                            <a href="{{url('/approvalsp')}}" class="pull-left a-body" id="#sp-body" title="Lihat Daftar Approval SP" style="text-decoration:none; color:black;">
                                                <small class="pull-right" id="menitsp"></small>
                                                <strong id="catatanapprovalsp"></strong><small id="isiapprovalsp"></small><br>
                                             </a>
                                            </div>
                                        </div>
                                        </li>
                                    </div>
                                    </li>
                                  </ul>
                                  @endif
                                  @endif
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
