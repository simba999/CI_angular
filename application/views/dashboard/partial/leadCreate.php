<div class="modal snooze" id="create-lead"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" >
        <div class="modal-content">
            <form method="POST" name="addLead" role="form" ng-submit="saveLead()">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-circle"></i>  Add Lead</h4>
			   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-12 lead-detail-left text-center">
							<div class="inner-lead-detail-left">
                            <div class="add-lead-img">
								<img  src="<?php echo base_url()?>assets/global/images/Blank_Club_Website_Avatar_Gray.jpg" class="leadImgCircle" alt="avatar">
								<div class="chng-img"><i class="fa fa-camera"></i> </div>
								<input  ng-model="form.leadImage" onchange="angular.element(this).scope().leadUploadImage(this.files)"  type="file" id="leadImage" name="leadImage" accept="image/x-png,image/gif,image/jpeg" ngf-pattern=".jpg,.png" ngf-accept="image/*" class="form-control Profile-input-file" />
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12">
								<strong>Lead Status<!--<span class="required_span_error">*</span>--></strong>
								<div class="form-group leadStatusdd">
								<select class="custom-select form-control" name="leadStatusSelection"  ng-init="form.leadStatusSelection='1'" id= "leadStatus" ng-model="form.leadStatusSelection" >
										<option ng-repeat="status in leadStatus" value={{status.Id}}>
										<span class="{{status.LeadStatus | lowercase}}"></span>{{status.LeadStatus}}
										
										</option>
								  </select>
								</div>
                            </div>
						   <div class="col-xs-12 col-sm-12 col-md-12">
							 <strong>Lead Source<!--<span class="required_span_error">*</span>--></strong>
                            <div class="form-group leadSourcedd">
							  <select class="custom-select form-control" name="leadSource" ng-init="form.leadSourceSelection='1'" id= "leadSource" ng-model="form.leadSourceSelection" >
								    <option ng-repeat="source in leadSources" value="{{source.Id}}" class="left-move-5">{{source.LeadSource.trim()}}</option>
							  </select> 
                            </div>
                         </div>
						 </div>
                        </div>
						 <div class="col-md-10 col-sm-10 col-xs-12">
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6">
												<strong>First Name<span class="required_span_error">*</span></strong>
												<div class="form-group"  ng-class="{'has-error':addLead.firstName.$invalid && !addLead.firstName.$pristine }">
													<input ng-model="form.firstName" type="text"  name="firstName" class="form-control" required  />
													 <p ng-show="addLead.firstName.$invalid && !addLead.firstName.$pristine" class="help-block">First Name is required.</p>
													</div>
										</div>
										 <div class="col-xs-12 col-sm-6 col-md-6">
											<strong>Last Name<span class="required_span_error">*</span></strong>
											<div class="form-group"  ng-class="{'has-error':addLead.lastName.$invalid && !addLead.lastName.$pristine }">
												<input ng-model="form.lastName" type="text" name="lastName" class="form-control"  required />
												 <p ng-show="addLead.lastName.$invalid && !addLead.lastName.$pristine" class="help-block">Last Name is required.</p>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6">
											<strong>Email Address<span class="required_span_error">*</span></strong>
											<div class="form-group">
												<input ng-model="form.email" id="email" type="email"  name="email" class="form-control" required />
											</div>
										</div>
										<div class="col-xs-12 col-sm-6 col-md-6">
											<strong>Phone Number<!--<span class="required_span_error">*</span>--></strong>
											<div class="form-group">
												<input ng-model="form.phoneNumber" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" type="tel" name="phoneNumber" class="form-control" />
											</div>
										</div>
									</div>
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6">
								<strong>Birthdate<!--<span class="required_span_error">*</span>--></strong>
								<div class="form-group">
									 <div class='input-group date' id='birthdatePicker'> 
												<input  ng-model="form.birthdate" type='text' class="form-control date-mask" name="birthdate" placeholder="mm-dd-yyyy" id="birthdate" required />
												<span class="input-group-addon">
													<span class="fa fa-calendar-check-o"></span>
												</span>
									</div> 
								</div>
							 </div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<strong>Lead Anniversary<!--<span class="required_span_error">*</span>--></strong>
								<div class="form-group">
									 <div class='input-group date' id='aniversaryDatePicker'>
												<input  ng-model="form.aniversaryDate" type='text' class="form-control date-mask" name="aniversaryDate" placeholder="mm-dd-yyyy" id="aniversaryDate" required />
												<span class="input-group-addon">
													<span class="fa fa-calendar-check-o"></span>
												</span>
									 </div>
								</div>
							 </div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<strong>Address line 1</strong>
								<div class="form-group">
									 <input ng-model="form.addressLine1" type="text" name="addressLine1" id="addressLine1" class="form-control"/>
								</div>
							 </div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<strong>Address line 2</strong>
								<div class="form-group">
									<input ng-model="form.addressLine2" type="text" name="addressLine2" id="addressLine2" class="form-control"  />
								</div>
							 </div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="form-group">
								<strong>City</strong>
								<input ng-model="form.leadCity" type="text" name="leadCity" id="leadCity" class="form-control"  />
							</div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4">
								<div class="form-group">
								<strong>State</strong>
									<input ng-model="form.leadState" type="text" name="leadState" id="leadState" class="form-control"  />
							  <!--<select class="custom-select form-control" name="leadState" id= "leadState" ng-model="form.leadState" >
								    <option ng-repeat="status in leadStatus" value={{status.Id}}>
									<span class="{{status.LeadStatus | lowercase}}"></span>{{status.LeadStatus}}
									
									</option>
							  </select> -->
                            </div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4">
								<div class="form-group">
								<strong>Zipcode</strong>
								<input ng-model="form.zipcode" type="text" id="zipcode" name="zipcode" class="form-control"  />
                            </div>
							</div>
						</div>
						<!--<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                           <strong>Location<span class="required_span_error">*</span></strong>
                            <div class="form-group">
                                <input  ng-model="form.location" type="text" id="location" name="location" class="form-control" required/>
                            </div>
                        </div>
                       </div> -->
				</div>
								<div class="col-md-6">
									<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12">
										<strong>Title<!--<span class="required_span_error">*</span>--></strong>
										<div class="form-group">
											<input ng-model="form.leadTitle" type="text" id="leadTitle"  name="leadTitle" class="form-control" />
										</div>
									</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6">
											<strong>Website</strong>
											<div class="form-group">
												<input ng-model="form.leadWebSite" type="url" id="leadWebSite"  name="leadWebSite" class="form-control"/>
											</div>
										</div>
										<div class="col-xs-12 col-sm-6 col-md-6">
											<strong>Company<!--<span class="required_span_error">*</span>--></strong>
											<div class="form-group">
												<input ng-model="form.companyName" type="text" id = "companyName" name="companyName" class="form-control" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12">
											<strong>Tags</strong>
											<div class="form-group">
											<!--<textarea ng-list="&#10;" ng-trim="false" rows="5" cols="60" ng-model="form.tagsList" name= "tagsList" id = "tagsList"></textarea>-->
											<textarea rows="5" cols="60" ng-model="form.tagsList" name= "tagsList" id = "tagsList"></textarea>
											</div>
										</div>
									</div>
									<div class="row"><div class="col-xs-12 col-sm-12 col-md-12"><strong>Social Profiles</strong></div></div>
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6">
											<div class="form-group">
												<div class="input-group date">
													<input ng-model="form.leadFacebook" type="url" id="leadFacebook"  name="leadFacebook" class="form-control"  />
													<span class="input-group-addon">
														<span class="fa fa-facebook"></span>
													</span>
													
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-6 col-md-6">
											<div class="form-group">
												<div class="input-group date ">
												<input ng-model="form.leadInstagram" type="url" id="leadInstagram"  name="leadInstagram" class="form-control"  />
												<span class="input-group-addon">
														<span class="fa fa-instagram"></span>
												</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6">
											<div class="form-group">
												<div class="input-group date ">
													<input ng-model="form.leadTwitter" type="url" id="leadTwitter"  name="leadTwitter" class="form-control"  />
													<span class="input-group-addon">
														<span class="fa fa-twitter"></span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-6 col-md-6">
											<div class="form-group">
											<div class="input-group date ">
												<input ng-model="form.leadLinkedin" type="url" id="leadLinkedin"  name="leadLinkedin" class="form-control"  />
												<span class="input-group-addon">
														<span class="fa fa-linkedin"></span>
												</span>
											</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
							<div class="pull-right">
							<button type="submit" ng-disabled="addLead.$invalid" class="btn btn-yellow">Add Lead</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						 </div>
					</div>    
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
