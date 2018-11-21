<script>
	$(document).ready(function(){
		
    // Datatable Absensi manajemen
    var hist_search = $('#hist_search'); 
    var hist_refresh = $('#hist_refresh'); 
    var hist_tgl_awal = $('#tgl_awal'); 
    var hist_tgl_akhir = $('#tgl_akhir'); 
    var hist_url = "{{ url('/manajemen-seragam/penerimaan/find-history') }}";

    var tbl_hist = $('#tbl_history').DataTable( {
        ajax: hist_url,
        columns: [
            
            { 
                data: null,
                render : function(res) {
                    var new_date = new Date(res.pa_date);
                    var date = new_date.getDate();
                    var month = new_date.getMonth() + 1;
                    var year = new_date.getFullYear();

                    var result = date + '-' + month + '-' + year;
                    return result;
                } 
            },
            { data: "seragam" },
            { data: "pa_qty" },
            { data: "pa_do" },
            { data: "penerima" }
            
        ]
    } );

   

    hist_refresh.click(function(){
        // Merefresh tabel manajemen
        hist_tgl_awal.val('');
        hist_tgl_akhir.val('');
        tbl_hist.ajax.url(hist_url).load();
    });

    // Pencarian berdasarkan tanggal
    hist_search.click(function(){
        var date_param = '';
        var div_param = '';
        var tgl_awal = hist_tgl_awal.val() != '' ? hist_tgl_awal.val() : '' ;
        var tgl_akhir = hist_tgl_akhir.val() != '' ? hist_tgl_akhir.val() : '' ;


        if(tgl_awal != '' && tgl_akhir != '') {
            date_param = '&tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;
        }

        var tmp_url = hist_url + '?' + date_param;
        tbl_hist.ajax.url(tmp_url).load();
    });


    // ======================================================




		var date = new Date();
		date = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
		$('#tgl_awal, #tgl_akhir').val(date);
		$('#tgl_awal, #tgl_akhir').datepicker({
			format : 'dd-mm-yyyy'
		});
	});
</script>