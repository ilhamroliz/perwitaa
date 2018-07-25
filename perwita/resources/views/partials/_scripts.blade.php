<!-- Mainly scripts -->
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/vendors/jquery-ui/jquery-ui.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('assets/vendors/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/peity/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('assets/js/inspinia.js') }}"></script>
    <script src="{{ asset('assets/vendors/pace/pace.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>

    <!-- Ladda -->
    <script src="{{ asset('assets/vendors/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/ladda/ladda.jquery.min.js') }}"></script>

    <!-- sweetalert -->
    <script src="{{ asset('assets/vendors/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Datatable -->
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>

	  <!-- bootbox  -->
    <script src="{{ asset('assets/vendors/bootbox/bootbox.js') }}"></script>


    <script src="{{ asset('assets/vendors/bootstrapTour/bootstrap-tour.min.js') }}"></script>

    <!-- Money  -->
    <script src="{{ asset('assets/vendors/money/dist/jquery.maskMoney.js') }}"></script>

    <!--confirm -->
    <script src="{{ asset('assets/vendors/confirm/bootstrap-confirmation.js') }}"></script>


    <script src="{{ asset('assets/vendors/idle-timer/idle-timer.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/select2/dist/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/app.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/chosen/chosen.jquery.js') }}"></script>

    <script src="{{ asset('assets/vendors/iCheck/icheck.min.js') }}"></script>

    <script src="{{ asset('assets/autocomplete/autocomplete.js') }}"></script>
    <script src="{{ asset('assets/date-live/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/accounting/accounting.js') }}"></script>
    <!-- datepicker  -->
    <script src="{{ asset('assets/vendors/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendors/waitingfor/waitingfor.js') }}"></script>
    <script src="{{ asset('assets/vendors//metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('assets/vendors/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Jquery Print Page -->
    <script type="text/javascript" src="{{asset('assets/jqueryprintpage/jquery.printPage.js')}}"></script>

    {{-- <script type="text/javascript" src="{{asset('assets/cropper/js/common.js')}}"></script> --}}
    <script type="text/javascript" src="{{asset('assets/cropper/js/cropper.min.js')}}"></script>
 {{--    <script type="text/javascript" src="{{asset('assets/cropper/js/main.js')}}"></script> --}}



    <!--<script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>-->



    <script>
          $('[data-toggle="tooltip"]').tooltip({container : 'body'});
//          if(screen.width > 768){
//              alert('besar');
//              $('body').addClass('fixed-sidebar');
//          }else if(screen.width <= 768){
//              alert('kecil');
//              $('body').removeClass('fixed-sidebar');
//            $("body").toggleClass("mini-navbar");
//            SmoothlyMenu();
//          }

          if(screen.width <= 768){
            $('body').removeClass('fixed-sidebar');
            $("body").toggleClass("mini-navbar");
            SmoothlyMenu();
          }


          var windowsize = $(window).width();

//$(window).resize(function() {
//  windowsize = $(window).width();
//  if (windowsize > 768) {
//     $('body').addClass('fixed-sidebar');
//     $('#side-menu').hide();
//        setTimeout(
//            function () {
//                $('#side-menu').fadeIn(400);
//            }, 100);
//  }
//  else if (windowsize <=  768) {
//            $('body').removeClass('fixed-sidebar');
//            $("body").toggleClass("mini-navbar");
//            SmoothlyMenu();
//  }
//});



        var dataTableLanguage = {
           "emptyTable": "Tidak ada data",
           "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
           "sSearch": 'Pencarian',
           "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
           "infoEmpty": "",
           "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
             },
             "processing":"<img src='{{ asset('assets/vendors/jQuery-Smart-Wizard/images/loader.gif') }}' width='30px'>"
          }

        var baseUrl = '{{ url('/') }}';
        //alert(baseUrl);

        $(document).ready(function() {
            //console.log(tour._options.steps[tour.getCurrentStep()]);
            // setTimeout(function() {
            //     toastr.options = {
            //         closeButton: true,
            //         progressBar: true,
            //         showMethod: 'slideDown',
            //         timeOut: 4000
            //     };
            //     toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

            // }, 1300);
        });

        function alertSuccess(message){
            swal({
                title: "Berhasil",
                text: message+"!",
                type: "success"
            });
        }

        function alertDelete(message, data, id){
            swal({
                title: "Apa Anda Yakin?",
                text: message+"!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Saya Yakin!",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    url         : baseUrl+'/master/'+data+'/delete/'+id,
                    type        : 'get',
                    success     :function(response){
                        //console.log(response);
                        swal("Deleted!", "Data "+data+" Berhasil Dihapus.", "success");
                        loadTable('update');
                    },
                    error       : function(){
                        swal("Error", "Server Sedang Mengalami Masalah", "error");
                    }
                })
            });
        }

        function loadTableError(message, withCenterClass = false){
            if(withCenterClass){
                var html = '<center><i style="margin-bottom:8px; color:#999" class="fa fa-ambulance fa-5x" aria-hidden="true" style="color:"></i><br/>'+
                            '<span style="color:#999">"ups ..'+message+'"</span><br/>'+
                            '<a href="{{ Request::url() }}">muat ulang</a></center>';
            }else{
                var html = '<i style="margin-bottom:8px; color:#999" class="fa fa-ambulance fa-5x" aria-hidden="true" style="color:"></i><br/>'+
                            '<span style="color:#999">"ups ..'+message+'"</span><br/>'+
                            '<a href="{{ Request::url() }}">muat ulang</a>';
            }

            return html;
        }

		$(document).ready(function () {
            $(document).idleTimer(2000000);
            });
            $(document).on("idle.idleTimer", function(event, elem, obj){    //            alert('klose');
               // window.location = baseUrl+"/logout";
            });
            $(document).on("active.idleTimer", function(event, elem, obj, triggerevent){

        });

          // Menghilangkan error datatable
          $.fn.dataTable.ext.errMode = 'throw';

          // Plugin Format Number
          $.fn.digits = function(){
          return this.each(function(){
              $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
          })
      }

   // setTimeout(function(){ alert("Hello"); }, 3000);
  @if(Session::get('jabatan') == 1 || Session::get('jabatan') == 6)
              getApproval();

                     function getApproval(){
                       var pelamar = '';
                       var mitra = '';
                       var pembelian = '';
                       var sp = '';
                       var mitrapekerja = '';
                       var promosi = '';
                       var countpelamar = 0;
                       var countmitra = 0;
                       var countpembelian = 0;
                       var countsp = 0;
                       var countnotif = 0;
                       var countmitrapekerja = 0;
                       var countpromosi = 0;
                       $.ajax({
                         type : 'get',
                         url : '{{url("/approval/cekapproval")}}',
                         success : function(data){
                           //console.log(data);
                           //console.log(notifOBJ);
                           mitra += '<li">'+
                               '<div class="dropdown-messages-box">'+
                                 '<a href="{{url('/approvalmitra')}}" class="pull-left a-img" title="Lihat Daftar Approval Mitra">'+
                                     '<img alt="image" class="img-circle" src="{{ asset('assets/img/attention-sign-outline.png') }}" />'+
                                  '</a>'+
                                 '<div class="media-body">'+
                                 '<a href="{{url('/approvalmitra')}}" class="pull-left a-body" id="#mitra-body" title="Lihat Daftar Approval Mitra" style="text-decoration:none; color:black;">'+
                                     '<small class="pull-right" id="menitmitra"></small>'+
                                     '<strong id="catatanapprovalmitra"></strong><small id="isiapprovalmitra"></small><br>'+
                                  '</a>'+
                                 '</div>'+
                             '</div>'+
                             '</li>';

                             pelamar += '<li">'+
                                 '<div class="dropdown-messages-box">'+
                                   '<a href="{{url('/approvalpelamar')}}" class="pull-left a-img" title="Lihat Daftar Approval Pelamar">'+
                                       '<img alt="image" class="img-circle" src="{{ asset('assets/img/attention-sign-outline.png') }}" />'+
                                    '</a>'+
                                   '<div class="media-body">'+
                                   '<a href="{{url('/approvalpelamar')}}" class="pull-left a-body" id="#pelamar-body" title="Lihat Daftar Approval Pelamar" style="text-decoration:none; color:black;">'+
                                       '<small class="pull-right" id="menitpelamar"></small>'+
                                       '<strong id="catatanapprovalpelamar"></strong><small id="isiapprovalpelamar"></small><br>'+
                                    '</a>'+
                                   '</div>'+
                               '</div>'+
                               '</li>';

                               pembelian += '<li">'+
                                   '<div class="dropdown-messages-box">'+
                                     '<a href="{{url('/approvalpembelian')}}" class="pull-left a-img" title="Lihat Daftar Approval Pembelian Seragam">'+
                                         '<img alt="image" class="img-circle" src="{{ asset('assets/img/attention-sign-outline.png') }}" />'+
                                      '</a>'+
                                     '<div class="media-body">'+
                                     '<a href="{{url('/approvalpembelian')}}" class="pull-left a-body" id="#pembelian-body" title="Lihat Daftar Approval Pembelian Seragam" style="text-decoration:none; color:black;">'+
                                         '<small class="pull-right" id="menitpembelian"></small>'+
                                         '<strong id="catatanapprovalpembelian"></strong><small id="isiapprovalpembelian"></small><br>'+
                                      '</a>'+
                                     '</div>'+
                                 '</div>'+
                                 '</li>';

                                 sp += '<li">'+
                                     '<div class="dropdown-messages-box">'+
                                       '<a href="{{url('/approvalsp')}}" class="pull-left a-img" title="Lihat Daftar Approval SP">'+
                                           '<img alt="image" class="img-circle" src="{{ asset('assets/img/attention-sign-outline.png') }}" />'+
                                        '</a>'+
                                       '<div class="media-body">'+
                                       '<a href="{{url('/approvalsp')}}" class="pull-left a-body" id="#sp-body" title="Lihat Daftar Approval SP" style="text-decoration:none; color:black;">'+
                                           '<small class="pull-right" id="menitsp"></small>'+
                                           '<strong id="catatanapprovalsp"></strong><small id="isiapprovalsp"></small><br>'+
                                        '</a>'+
                                       '</div>'+
                                   '</div>'+
                                   '</li>';

                                   mitrapekerja += '<li">'+
                                       '<div class="dropdown-messages-box">'+
                                         '<a href="{{url('/approvalmitrapekerja')}}" class="pull-left a-img" title="Lihat Daftar Approval Mitra Pekerja">'+
                                             '<img alt="image" class="img-circle" src="{{ asset('assets/img/attention-sign-outline.png') }}" />'+
                                          '</a>'+
                                         '<div class="media-body">'+
                                         '<a href="{{url('/approvalmitrapekerja')}}" class="pull-left a-body" id="#mitrapekerja-body" title="Lihat Daftar Approval Mitra Pekerja" style="text-decoration:none; color:black;">'+
                                             '<small class="pull-right" id="menitmitrapekerja"></small>'+
                                             '<strong id="catatanapprovalmitrapekerja"></strong><small id="isiapprovalmitrapekerja"></small><br>'+
                                          '</a>'+
                                         '</div>'+
                                     '</div>'+
                                     '</li>';

                                     promosi += '<li">'+
                                         '<div class="dropdown-messages-box">'+
                                           '<a href="{{url('/approvalpromosi')}}" class="pull-left a-img" title="Lihat Daftar Approval Promosi">'+
                                               '<img alt="image" class="img-circle" src="{{ asset('assets/img/attention-sign-outline.png') }}" />'+
                                            '</a>'+
                                           '<div class="media-body">'+
                                           '<a href="{{url('/approvalpromosi')}}" class="pull-left a-body" id="#promosi-body" title="Lihat Daftar Approval Promosi" style="text-decoration:none; color:black;">'+
                                               '<small class="pull-right" id="menitpromosi"></small>'+
                                               '<strong id="catatanapprovalpromosi"></strong><small id="isiapprovalpromosi"></small><br>'+
                                            '</a>'+
                                           '</div>'+
                                       '</div>'+
                                       '</li>';

                               if (data.data[0].jumlah > 0) {
                                  countnotif += 1;
                                  countpelamar += 1;
                                  $("#showpelamar").html(pelamar);
                                  $("#countnotif").text(countnotif);
                                  $("#menitpelamar").html(data.data[0].p_insert);
                                  $("#catatanapprovalpelamar").text(data.data[0].catatan);
                                  $("#isiapprovalpelamar").html(" Anda Memiliki "+data.data[0].jumlah+" Persetujuan");
                               }
                               if (data.data[1].jumlah > 0) {
                                  countnotif += 1;
                                  countmitra += 1;
                                  $("#showmitra").html(mitra);
                                  $("#countnotif").text(countnotif);
                                  $("#menitmitra").html(data.data[1].m_insert);
                                  $("#catatanapprovalmitra").text(data.data[1].catatan);
                                  $("#isiapprovalmitra").html(" Anda Memiliki "+data.data[1].jumlah+" Persetujuan");
                               }
                               if (data.data[2].jumlah > 0) {
                                  countnotif += 1;
                                  countpembelian += 1;
                                  $("#showpembelian").html(pembelian);
                                  $("#countnotif").text(countnotif);
                                  $("#menitpembelian").html(data.data[2].p_date);
                                  $("#catatanapprovalpembelian").text(data.data[2].catatan);
                                  $("#isiapprovalpembelian").html(" Anda Memiliki "+data.data[2].jumlah+" Persetujuan");
                               }
                               if (data.data[3].jumlah > 0) {
                                  countnotif += 1;
                                  countsp += 1;
                                  $("#showsp").html(sp);
                                  $("#countnotif").text(countnotif);
                                  $("#menitsp").html(data.data[3].sp_insert);
                                  $("#catatanapprovalsp").text(data.data[3].catatan);
                                  $("#isiapprovalsp").html(" Anda Memiliki "+data.data[3].jumlah+" Persetujuan");
                               }
                               if (data.data[4].jumlah > 0) {
                                  countnotif += 1;
                                  countmitrapekerja += 1;
                                  $("#showmitrapekerja").html(mitrapekerja);
                                  $("#countnotif").text(countnotif);
                                  $("#menitmitrapekerja").html(data.data[4].mp_insert);
                                  $("#catatanapprovalmitrapekerja").text(data.data[4].catatan);
                                  $("#isiapprovalmitrapekerja").html(" Anda Memiliki "+data.data[4].jumlah+" Persetujuan");
                               }
                               if (data.data[5].jumlah > 0) {
                                  countnotif += 1;
                                  countpromosi += 1;
                                  $("#showpromosi").html(promosi);
                                  $("#countnotif").text(countnotif);
                                  $("#menitpromosi").html(data.data[5].pd_insert);
                                  $("#catatanapprovalpromosi").text(data.data[5].catatan);
                                  $("#isiapprovalpromosi").html(" Anda Memiliki "+data.data[5].jumlah+" Persetujuan");
                               }
                               if (countpelamar == 0) {
                                 $("#showpelamar").html('<center> Tidak ada permintaan Approval Pelamar </center>');
                               }
                               if (countmitra == 0) {
                                 $("#showmitra").html('<center> Tidak ada permintaan Approval Mitra </center>');
                               }
                               if (countpembelian == 0) {
                                 $("#showpembelian").html('<center> Tidak ada permintaan Approval Pembelian Seragam </center>');
                               }
                               if (countsp == 0) {
                                 $("#showsp").html('<center> Tidak ada permintaan Approval SP </center>');
                               }
                               if (countmitrapekerja == 0) {
                                 $("#showmitrapekerja").html('<center> Tidak ada permintaan Approval Mitra Pekerja </center>');
                               }
                               if (countpromosi == 0) {
                                 $("#showmitrapekerja").html('<center> Tidak ada permintaan Approval Promosi </center>');
                               }
                               if (countnotif == 0) {
                                 // $("#showpelamar").html(pelamar);
                                 // $("#showmitra").html(mitra);
                                 // $("#showpembelian").html(pembelian);
                               }
                         }
                       });
                        setTimeout(function(){getApproval();}, 5000);
                     }
      @endif

    </script>
