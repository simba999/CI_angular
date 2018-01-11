<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</div>
      <!--</div> -->           
	</main>
	 <div class="modal fade video-modal" id="video-modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <iframe src="about:blank" width="760" height="440" allowfullscreen></iframe>
            </div>
        </div>
    </div>
	<script src="<?php echo base_url(). ASSETS_DIR . VENDOR_DIR;?>/js/tether.min.js"></script>
    
    <script src="<?php echo base_url(). ASSETS_DIR . VENDOR_DIR.BOWER_COMPNENT;?>/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- site-wide scripts -->
    <script src="<?php echo base_url(). ASSETS_DIR?>/global/js/main.js"></script>
    <!--<script src="<?php echo base_url(). ASSETS_DIR . VENDOR_DIR;?>/js/site.js"></script> -->
    <script src="<?php echo base_url(). ASSETS_DIR . VENDOR_DIR;?>/js/menubar.js"></script>
	<!-- current page scripts -->
	<!-- Date Picker -->
	<script src="<?php echo base_url() .ASSETS_DIR.PLUGINS_DIR; ?>/datepicker/moment.js"></script>
	<script src="<?php echo base_url() .ASSETS_DIR.PLUGINS_DIR; ?>/daterangepicker/daterangepicker.js"></script>
	<script src="<?php echo base_url() .ASSETS_DIR.PLUGINS_DIR; ?>/angular-daterangepicker/js/angular-daterangepicker.js"></script>
	<script src="<?php echo base_url().ASSETS_DIR.PLUGINS_DIR; ?>/datepicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url().ASSETS_DIR.PLUGINS_DIR; ?>/timepicker/bootstrap-timepicker.js"></script>
	<!-- End --->
	<!-- alertify Start -->
	<script src="<?php echo base_url().ASSETS_DIR.PLUGINS_DIR; ?>/alertifyjs/alertify.min.js"></script>
	<!-- alertify end -->
	<!-- Google Map Script -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo MAPKEY; ?>&libraries=places"></script>
	
	<!-- Google Map Script End -->
	<!-- Full  Calander  -->
	<script src="<?php echo base_url(). ASSETS_DIR . VENDOR_DIR.BOWER_COMPNENT;?>/fullcalendar/dist/fullcalendar.min.js"></script>  
	
	
	<script src="<?php echo base_url(). ASSETS_DIR.PLUGINS_DIR; ?>/summernote/summernote.min.js"></script>
	<script src="<?php echo base_url(). ASSETS_DIR.PLUGINS_DIR; ?>/summernote/angular-summernote.js"></script>
	<!--- Select 2 -->
	<script src="<?php echo base_url(). ASSETS_DIR . PLUGINS_DIR; ?>/select2/select2.min.js"></script>
	<script src="<?php echo base_url().ASSETS_DIR .PLUGINS_DIR?>/angular-ui-select2/select2.js"></script>
	<script src="<?php echo base_url(). ASSETS_DIR . VENDOR_DIR.BOWER_COMPNENT;?>/chart.js/dist/Chart.min.js"></script>
	
	<!--- Select 2 End -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/gcal.js"></script>
	<script src="<?php echo base_url(). ASSETS_DIR . PLUGINS_DIR; ?>/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo base_url(). ASSETS_DIR . PLUGINS_DIR; ?>/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?php echo base_url(). ASSETS_DIR . PLUGINS_DIR; ?>/input-mask/jquery.inputmask.extensions.js"></script>
	
    <script src="<?php echo base_url(). ASSETS_DIR . PLUGINS_DIR; ?>/malihu-custom-scrollbar/jquery.mCustomScrollbar.js"></script>    
    <script src="<?php echo base_url(). ASSETS_DIR . PLUGINS_DIR; ?>/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
	function format2(n, currency) {
    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
	}
	$('#fullcalendar').fullCalendar({
				header: {
				left: "prev",
				center: "title",
				right: "next"
				},
				views: {
				month: { // name of view
					titleFormat: 'MMMM'
				},
			}
	});
	$(".date-mask").inputmask("mm-dd-yyyy", {"placeholder": "mm-dd-yyyy"});
	$("[data-mask]").inputmask();
	
	/*  $('.modal').on('hidden.bs.modal', function(){
		$(this).find('form')[0].reset();
	 }); */
	  $('.select2-option').select2(
		{ 
		  width: '100%',
		  tags: true,
		  tokenSeparators: [',', ' '],
		  separator: ',',
		}
		).on("change", function (e){});
		(function($){
			$(window).on("load",function(){	
				$("#recentlyLead .lead-scroll").mCustomScrollbar({
					setHeight:366,
					theme:"dark-3"
				});
				$("#hotLeadData .lead-scroll").mCustomScrollbar({
					setHeight:366,
					theme:"dark-3"
				});
			
				
			});
		})(jQuery);
/*For Intercom msg box for instant massage*/
 window.intercomSettings = {
    app_id: "otmp61qv"
  };
(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/otmp61qv';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()

	</script>
        <!-- Tags JS -->
        <!--<script src="<?php echo base_url() . ASSETS_DIR . PLUGINS_DIR . TAGS_DIR; ?>/js/jquery2.1.3.min.js"></script>-->
        <script src="<?php echo base_url() . ASSETS_DIR . PLUGINS_DIR . TAGS_DIR; ?>/js/jquery.tagsinput.js"></script>
        <!--<script src="<?php echo base_url() . ASSETS_DIR . PLUGINS_DIR . TAGS_DIR; ?>/js/jquery1.8.13-ui.min.js"></script>-->
        <!-- End Tags JS -->
</body>
</html>