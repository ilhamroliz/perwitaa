    <!-- Mainly scripts -->
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('assets/plugins/jquery-3.min.js') }}"></script> --}}

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
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/datatables_scroller.js')}}"></script>

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
    <script src="{{ asset('assets/vendors/chosen/chosen-readonly.js') }}"></script>

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
    {{-- dobpicker --}}
    <script src="{{ asset('assets/vendors/dobpicker/dobPicker.min.js') }}"></script>



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

        <?php $cekAksesApproval = App\Http\Controllers\AksesUser::checkAkses(55, 'read') ?>
          @if($cekAksesApproval)
          getApproval();
          setInterval(function () {
            getApproval();
          }, 5000);

            function getApproval(){
              var html = '';
              $.ajax({
                type: 'get',
                url : '{{url("/approval/cekapproval")}}',
                success : function(result){

                  if (result.status == 'kosong') {
                    $('.approvaldown').css('height', '40px');
                    $('#shownotif').html('<center>Tidak ada data approval</center>');
                  } else {
                    $('.approvaldown').css('height', '200px');
                    $('.approvaldown').css('width', '350px');

                    $('#countnotif').text(result[0].count);

                    for (var i = 0; i < result.length; i++) {
                      html += '<div class="media-body">'+
                                '<li>'+
                              '<div class="dropdown-messages-box">'+
                              '<div class="media-body">'+
                                      '<a href="' + baseUrl + result[i].n_url + '" class="pull-left a-body" title="Lihat Daftar Approval '+result[i].n_fitur+' " style="text-decoration:none; color:black;">'+
                                            '<small class="pull-right">'+result[i].n_insert+'</small>'+
                                            ' <strong> '+result[i].n_fitur+' </strong><small> Anda memiliki '+result[i].n_qty+' permintaan approval '+result[i].n_fitur+' </small><br>'+
                                      '</a>'+
                                '</div>'+
                              '</div>'+
                                '</li>'+
                              '</div>'+
                              '<li class="divider" style="background-color:rgb(179, 179, 179);"></li>';
                    }

                    $('#shownotif').html(html);
                  }

                }
              });
            }

        @endif


    </script>
