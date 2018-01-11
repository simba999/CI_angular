<div class="modal snooze" id="create-lead"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" >
        <div class="modal-content">
            <form method="POST" name="addLead" role="form" ng-submit="saveLead()" id="addLeadForm" novalidate="">
            <div class="modal-header">
			
			 <h4 ng-if="editContact===undefined" class="modal-title" id="myModalLabel"><i class="fa fa-user-circle"></i> Add Contact</h4>
			  <h4 ng-if="editContact=='edit'" class="modal-title" id="myModalLabel"><i class="fa fa-user-circle"></i> Edit Contact</h4>
			  
			  
			  <input type="hidden" ng-model="form.leadId" value="{{form.leadId}}" required   ng-value ="{{form.leadId}}" type="hidden" name="leadId" id="leadId" />
			  
			  
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container">
					<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-12 lead-detail-left text-center">
                            <div class="add-lead-img">
								<img  src="<?php echo base_url()?>assets/global/images/MichaelLucas.png" class="leadImgCircle" alt="avatar" ng-modal="form.leadImageURL">
								<div class="chng-img"><i class="fa fa-camera"></i> </div>
								<input  ng-model="form.leadImage" onchange="angular.element(this).scope().leadUploadImage(this.files)"  type="file" id="leadImage" name="leadImage" accept="image/x-png,image/gif,image/jpeg" ngf-pattern=".jpg,.png" ngf-accept="image/*" class="form-control Profile-input-file" />
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12">
								<strong>Lead Status<span class="required_span_error">*</span></strong>
								<div class="form-group leadStatusdd">
								<select class="custom-select form-control" name="leadStatusSelection"  ng-init="form.leadStatusSelection='1'" id= "leadStatus" ng-model="form.leadStatusSelection" >
										<option ng-repeat="status in leadStatus" value={{status.Id}}>
										<span class="{{status.LeadStatus | lowercase}}"></span>{{status.LeadStatus}}
										
										</option>
								  </select>
								</div>
                            </div>
						   <div class="col-xs-12 col-sm-12 col-md-12">
							 <strong>Lead Source<span class="required_span_error">*</span></strong>
                            <div class="form-group leadSourcedd">
							  <select class="custom-select form-control" name="leadSource" ng-init="form.leadSource='1'" id= "leadSource" ng-model="form.leadSource" >
								    <option ng-repeat="source in leadSources" value="{{source.Id}}">{{source.LeadSource}}</option>
							  </select> 
							  
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
											<strong>Phone Number<span class="required_span_error">*</span></strong>
											<div class="form-group">
												<input ng-model="form.phoneNumber" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" type="text" name="phoneNumber" class="form-control" required />
											</div>
										</div>
									</div>
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6">
								<strong>Birthdate<span class="required_span_error">*</span></strong>
								<div class="form-group">
									 <div class='input-group date' id='birthdatePicker'> 
												<input  ng-model="form.birthdate" type='text' class="form-control" name="birthdate" placeholder="yyyy-mm-dd" id="birthdate" />
												<span class="input-group-addon">
													<span class="fa fa-calendar-check-o"></span>
												</span>
									</div> 
								</div>
							 </div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<strong>Lead Anniversary<span class="required_span_error">*</span></strong>
								<div class="form-group">
									 <div class='input-group date' id='aniversaryDatePicker'>
												<input  ng-model="form.aniversaryDate" type='text' class="form-control " name="aniversaryDate" placeholder="yyyy-mm-dd" id="aniversaryDate" />
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
									 <input ng-model="form.addressLine1" type="text" name="addressLine1" class="form-control" id="addressLine1"/>
								</div>
							 </div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<strong>Address line 2</strong>
								<div class="form-group">
									<input ng-model="form.addressLine2" type="text" name="addressLine2" class="form-control"  id="addressLine2"/>
								</div>
							 </div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="form-group">
								<strong>City</strong>
								<input ng-model="form.leadCity" type="text" name="leadCity" id="leadCity" class="form-control"  />
							  <!--<select class="custom-select form-control" name="leadCity" id= "leadCity" ng-model="form.leadCity" >
								    <option ng-repeat="status in leadStatus" value={{status.Id}} ng-selected='{{status.Id}}==form.leadCity'">
									<span class="{{status.LeadStatus | lowercase}}"></span>{{status.LeadStatus}}
									
									</option>
							  </select>-->
                            </div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4">
								<div class="form-group">
								<strong>State</strong>
								<input ng-model="form.leadState" type="text" name="leadState" id="leadState" class="form-control"  />
							  <!--<select class="custom-select form-control" name="leadState" id= "leadState" ng-model="form.leadState" >
								    <option ng-repeat="status in leadStatus" value={{status.Id}} ng-selected='{{status.Id}}==form.leadState'">
									<span class="{{status.LeadStatus | lowercase}}"></span>{{status.LeadStatus}}
									
									</option>
							  </select>-->
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
                       </div>-->
				</div>
								<div class="col-md-6">
									<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12">
										<strong>Title<span class="required_span_error">*</span></strong>
										<div class="form-group">
											<input ng-model="form.leadTitle" type="text" id="leadTitle"  name="leadTitle" class="form-control" required />
										</div>
									</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6">
											<strong>Website</strong>
											<div class="form-group">
												<input ng-model="form.leadWebSite" type="text" id="leadWebSite"  name="leadWebSite" class="form-control" ng-pattern="/^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/"/>
											</div>
										</div>
										<div class="col-xs-12 col-sm-6 col-md-6">
											<strong>Company<span class="required_span_error">*</span></strong>
											<div class="form-group">
												<input ng-model="form.companyName" type="text" id = "companyName" name="companyName" class="form-control" required />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12">
											<strong>Tags</strong>
											<div class="form-group">
											<textarea rows="5" cols="60" ng-model="form.tagsList" name= "tagsList" id = "tagsList"></textarea>
											</div>
										</div>
									</div>
									<div class="row"><div class="col-xs-12 col-sm-12 col-md-12"><strong>Social Profiles</strong></div></div>
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6">
											<div class="form-group">
												<div class="input-group date">
													<input ng-model="form.leadFacebook" type="text" id="leadFacebook"  name="leadFacebook" class="form-control"  ng-pattern="/^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/"/>
													<span class="input-group-addon">
														<span class="fa fa-facebook"></span>
													</span>
													
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-6 col-md-6">
											<div class="form-group">
												<div class="input-group date ">
												<input ng-model="form.leadInstagram" type="text" id="leadInstagram"  name="leadInstagram" class="form-control"  ng-pattern="/^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/"/>
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
													<input ng-model="form.leadTwitter" type="text" id="leadTwitter"  name="leadTwitter" class="form-control"  ng-pattern="/^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/"/>
													<span class="input-group-addon">
														<span class="fa fa-twitter"></span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-6 col-md-6">
											<div class="form-group">
											<div class="input-group date ">
												<input ng-model="form.leadLinkedin" type="text" id="leadLinkedin"  name="leadLinkedin" class="form-control"  ng-pattern="/^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/"/>
												<span class="input-group-addon">
														<span class="fa fa-linkedin"></span>
												</span>
											</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
					<div class="row pull-right">
						
							<div class="pull-right addLeadFormControl">
							<button ng-if="editContact===undefined" type="submit" ng-disabled="addLead.$invalid" class="btn btn-yellow">Add Contact</button>
							<button ng-if="editContact=='edit'" type="submit" ng-disabled="addLead.$invalid" class="btn btn-yellow btnEditLead">Edit Contact</button>
							
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
					 </div>
					</div>
                    <!--<div class="row">
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
                            <strong>Phone Number<span class="required_span_error">*</span></strong>
                            <div class="form-group">
                                <input ng-model="form.phoneNumber" type="text" name="phoneNumber" class="form-control" required />
                            </div>
                        </div>
                    </div>
					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Birthdate<span class="required_span_error">*</span></strong>
							<div class="form-group">
								 <div class='input-group date' id='birthdatePicker'> 
											<input  ng-model="form.birthdate" type='text' class="form-control" name="birthdate" placeholder="yyyy-mm-dd" id="birthdate" />
											<span class="input-group-addon">
												<span class="fa fa-calendar-check-o"></span>
											</span>
								</div> 
                            </div>
					     </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Lead Anniversary<span class="required_span_error">*</span></strong>
							<div class="form-group">
								 <div class='input-group date' id='aniversaryDatePicker'>
											<input  ng-model="form.aniversaryDate" type='text' class="form-control " name="aniversaryDate" placeholder="yyyy-mm-dd" id="aniversaryDate" />
											<span class="input-group-addon">
												<span class="fa fa-calendar-check-o"></span>
											</span>
								 </div>
                            </div>
                         </div>
                    </div>
					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Title<span class="required_span_error">*</span></strong>
                            <div class="form-group">
                                <input ng-model="form.leadTitle" type="text" id="leadTitle"  name="leadTitle" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Company<span class="required_span_error">*</span></strong>
                            <div class="form-group">
                                <input ng-model="form.companyName" type="text" id = "companyName" name="companyName" class="form-control" required />
                            </div>
                        </div>
                    </div>
					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                           <strong>Location<span class="required_span_error">*</span></strong>
                            <div class="form-group">
                                <input  ng-model="form.location" type="text" id="location" name="location" class="form-control" required/>
                            </div>
                        </div>
                       <!-- <div class="col-xs-12 col-sm-6 col-md-6">
						    <strong>Time Zone<span class="required_span_error">*</span></strong>
                            <div class="form-group">
							  <input ng-model="form.timezone" type="text" id="timezone" name="timezone" class="form-control" required/>
                            </div>
                        </div>-
                    </div> 
					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
							 <strong>Lead Source<span class="required_span_error">*</span></strong>
                            <div class="form-group">
							  <select  class="custom-select form-control" name="leadSource" id= "leadSource" ng-model="form.leadSource" required>
								    <option ng-repeat="source in leadSources" value="{{source.Id}}">{{source.LeadSource}}</option>
							  </select> 
							  
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Lead Status<span class="required_span_error">*</span></strong>
                            <div class="form-group">
							  <select class="custom-select form-control" name="leadStatus" id= "leadStatus" ng-model="form.leadStatus" required>
								    <option ng-repeat="status in leadStatus" value={{status.Id}}>{{status.LeadStatus}}</option>
							  </select>
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong>Profile Image</strong>
                            <div class="form-group">
                                <input ng-model="form.leadImage" onchange="angular.element(this).scope().leadUploadImage(this.files)" type="file" id="leadImage" name="leadImage" class="ng-pristine ng-valid ng-empty ng-touched" accept="image/x-png,image/gif,image/jpeg" ngf-pattern=".jpg,.png" ngf-accept="image/*">
                                    <p ng-show="addUser.leadImage.$error.pattern" class="help-block ng-hide">
                                  Must contain one lower &amp; uppercase letter, and one non-alpha character (a number or a symbol.)</p>
                            </div>
                        </div>
                    </div> -->
					
                    
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
setTimeout(function(){
	$('#leadStatus,#leadSource').each(function(){
    var $this = $(this), numberOfOptions = $(this).children('option').length;
	$this.addClass('select-hidden'); 
    $this.wrap('<div class="select"></div>');
    $this.after('<div class="select-styled"></div>');
	var $styledSelect = $this.next('div.select-styled');
	if( $(this).attr('id') == 'leadStatus')
	{
		$styledSelect.addClass('hot');
	}
	$styledSelect.text($this.children('option').eq(0).text());
	if($(this).attr('id') == 'leadSource')
	{
		$styledSelect.addClass('email');
		$styledSelect.addClass('marketing');
		console.log($this.children('option').eq(1));
		console.log($this.children('option').eq(1).html());
		$styledSelect.html($this.children('option').eq(1).html());
		$styledSelect.text($this.children('option').eq(1).html());
	}
    var $list = $('<ul />', {
        'class': 'select-options'
    }).insertAfter($styledSelect);
  
    for (var i = 0; i < numberOfOptions; i++) {
		console.log(numberOfOptions);
		console.log($this.children('option').eq(i).text());
			$('<li />', {
				
					text: $this.children('option').eq(i).text(),
					class:$this.children('option').eq(i).text().toLowerCase(),
					rel: $this.children('option').eq(i).val()
				
			}).appendTo($list);
			
		
    }
   var $listItems = $list.children('li');
   $styledSelect.click(function(e) {
        e.stopPropagation();
        $('div.select-styled.active').not(this).each(function(){
            $(this).removeClass('active').next('ul.select-options').hide();
        });
        $(this).toggleClass('active').next('ul.select-options').toggle();
    });
    $listItems.click(function(e) {
        e.stopPropagation();
        $styledSelect.text($(this).text()).removeClass('active');
		
		$styledSelect.attr('class','');
		$styledSelect.addClass('select-styled  '+$(this).text().toLowerCase());
        $this.val($(this).attr('rel'));
        $list.hide();
    });
  
    $(document).click(function() {
        $styledSelect.removeClass('active');
        $list.hide();
    });

});
 },3000); 
 $("#create-lead").on('show.bs.modal', function(){
    setTimeout(function(){
		$('.hot').text('  Hot');
		$('.marketing').text('  Email Marketing');
	},1500);		
});



</script>