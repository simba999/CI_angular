<div class="modal snooze" id="connect-emailaccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog stepOneEmailConnect" >
        <div class="modal-content stepOneEmailConnectLeftRightSpace">
            <!--<div class="modal-header">			  
			   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>-->
            <div class="modal-body">
                <div class="row">
					<div class="col-sm-12">
							<p class="step-text"><span class="text-uppercase">STEP</span> 1 of 4 </p>
						  <h4 class="modal-title text-uppercase" id="myModalLabel">Connect Email Account</h4>
						  <p class="subTitleGmail">Agent Cloud organizes your emails and meetings automatically, eliminating manual entry of data forever</p>
					</div>
				</div>
				<hr>
                    <div class="row">
						<div class="col-sm-12">
							<img class="google-icon" src="assets/global/images/icon_gmail.png" />
						</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong><span class="FontStyleBoldGmail">Email</span></strong>
                            <div class="form-group">
                                <input type="text" name="EmailName" class="form-control ng-pristine" ng-value="">
                            </div>
                        </div>
					</div>
					<div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong><span class="FontStyleBoldGmail">Password</span></strong>
                            <div class="form-group">
                                <input type="password" name="Password" class="form-control ng-pristine" ng-value="">
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<a  class="btn btn-yellow btnConnectAndSet" href="<?php echo base_url();?>Googleoauth/acoountconnect">Connect</a>
							<button type="button" class="btn btn-yellow-outline" data-dismiss="modal">Set this up later</button>
						</div>						
					</div>	
					<hr>
					<div class="row">
						<div class="col-sm-2">
							<img class="google-icon" src="assets/global/images/icon_gmail.png" />
						</div>
						<div class="col-sm-6">
							 <p>Connect to your Office365 Email Account</p>
						</div>
						<div class="col-sm-4">
							<a  class="btn btn-yellow btnConnectOffice365AndExcel" href="<?php echo base_url();?>Googleoauth/acoountconnect">Connect</a>
						</div>						
					</div>	
					<div class="row">
						<div class="col-sm-2">
							<img class="google-icon" src="assets/global/images/exchange-logo.png" />
						</div>
						<div class="col-sm-6">
							 <p>Connect to your Exchange Email Account</p>
						</div>
						<div class="col-sm-4">
							<a  class="btn btn-yellow btnConnectOffice365AndExcel" href="<?php echo base_url();?>Googleoauth/acoountconnect">Connect</a>
						</div>
					</div>	
					<!--<div class="row">
							<button ng-click="calendarPopup()" class="btn btn-info">Next</button>
					</div>-->
            </div>
			<hr class="horLineBottom">
			<div class="modal_n_footer">
				<div class="row">
					
					<div class="col-sm-12 text-right">
						<a href="javascript:;" ng-click="calendarPopup($event)">Next <i class="fa fa-chevron-right"></i></a>        					
					</div>
				</div>
			</div>
            
        </div>
    </div>
</div>