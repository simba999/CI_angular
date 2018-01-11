<div class="modal snooze" id="connect-calender" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog stepOneEmailConnect" >
        <div class="modal-content stepOneEmailConnectLeftRightSpace">
            <form  enctype="multipart/form-data" method="POST" name="addUser" role="form" ng-submit="saveUser()">
            <!--<div class="modal-header">
			 	  
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <!--<div>
				<p>Agent Cloud organizes your calendar and syncing everything that is needed as you connect calendars</p> 		
			  </div>-
            </div>-->
            <div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
							<p class="step-text"><span class="text-uppercase">STEP</span> 2 of 4 </p>
						  <h4 class="modal-title text-uppercase" id="myModalLabel">Connect Calender</h4>
						  <p class="subTitleGmail">Agent Cloud organizes your calendar and syncing everything that is needed as you connect calendars </p>
						  <br>
					</div>
				</div>
				<div class="row">
					<a class="btn btn-yellow btnConnectAndSet marLeftForStepTwo" href="<?php echo base_url();?>Googleoauth/connectcalender">Connect To Calender</a>
					<button type="button" class="btn btn-yellow-outline" data-dismiss="modal">Cancel</button>
				</div>
			 </div>
			<div class="modal_n_footer">
				<div class="row">
				<?php if(!$this->session->userdata('emailConnect') &&   !$this->session->userdata('contactAdded')){ ?>
					<div class="col-sm-6 text-left">
						<a href="javascript:;" ng-click="connectEmailPopup($event)" class=""><i class="fa fa-chevron-left"></i> Prev</a>						
					</div>
					<div class="col-sm-6 text-right">
						<a href="javascript:;" ng-click="add25Contacts($event)" class="">Next <i class="fa fa-chevron-right"></i></a>        					
					</div>
					
				<?php }
				else if(!$this->session->userdata('emailConnect')) { ?>
					<div class="col-sm-12 text-left">
						<a href="javascript:;" ng-click="connectEmailPopup($event)" class=""><i class="fa fa-chevron-left"></i> Prev</a>						
					</div>
				<?php } else { 
				?>	
					<div class="col-sm-12 text-right">
						<a href="javascript:;" ng-click="add25Contacts($event)" class="">Next <i class="fa fa-chevron-right"></i></a>        					
					</div>
				 <?php } ?>
				</div>
			</div>
            </form>
        </div>
    </div>
</div>