<div class="modal snooze" id="create-lead"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" >
        <div class="modal-content">
            <form method="POST" name="addLead" role="form" ng-submit="saveLead()" id="addLeadForm" novalidate="">
                <div class="modal-header">

                    <h4 ng-if="editContact === undefined" class="modal-title" id="myModalLabel"><i class="fa fa-user-circle"></i> Add Contact</h4>
                    <h4 ng-if="editContact == 'edit'" class="modal-title" id="myModalLabel"><i class="fa fa-user-circle"></i> Edit Contact</h4>

                    <div ng-if="editContact == 'edit'">
                        <input ng-if="editContact == 'edit'" type="hidden" ng-model="form.leadId" value="{{form.leadId}}" required   ng-value ="{{form.leadId}}" type="hidden" name="leadId" id="leadId" />
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-12 lead-detail-left text-center">
                                <div class="add-lead-img">
                                    <img  src="<?php echo base_url() ?>assets/global/images/Blank_Club_Website_Avatar_Gray.jpg" class="leadImgCircle" alt="avatar">
                                    <div class="chng-img"><i class="fa fa-camera"></i> </div>
                                    <input  ng-model="form.leadImage" onchange="angular.element(this).scope().leadUploadImage(this.files)"  type="file" id="leadImage" name="leadImage" accept="image/x-png,image/gif,image/jpeg" ngf-pattern=".jpg,.png" ngf-accept="image/*" class="form-control Profile-input-file" />
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Lead Status<!--<span class="required_span_error">*</span>--></strong>
                                    <div class="form-group leadStatusdd">
                                        <!--  ng-init="editContact=='edit' ? form.leadStatusSelection=form.leadStatusSelection : '1'"-->
                                        <select ng-init="form.leadStatusSelection = '1'"  class="custom-select form-control" name="leadStatusSelection"  id= "leadStatus" ng-model="form.leadStatusSelection" >
                                            <option ng-repeat="status in leadStatus" value={{status.Id}}>
                                            <span class="{{status.LeadStatus| lowercase}}"></span>{{status.LeadStatus}}

                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Lead Source<!--<span class="required_span_error">*</span>--></strong>
                                    <div class="form-group leadSourcedd">
                                        <!-- ng-init="editContact=='edit' ? form.leadSource=form.leadSource : '1'"-->
                                        <select class="custom-select form-control" ng-init="form.leadSourceSelection = '1'"   name="leadSourceSelection"  id= "leadSource" ng-model="form.leadSourceSelection" >
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
                                                <strong>Phone Number<!--<span class="required_span_error">*</span>--></strong>
                                                <div class="form-group">
                                                    <input ng-model="form.phoneNumber" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" type="tel" name="phoneNumber" class="form-control"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <strong>Birthdate<!--<span class="required_span_error">*</span>--></strong>
                                                <div class="form-group">
                                                    <div class='input-group date' id='birthdatePicker'> 
                                                        <input  ng-model="form.birthdate" type='text' class="form-control date-mask" name="birthdate" placeholder="mm-dd-yyyy" id="birthdate" />
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
                                                        <input  ng-model="form.aniversaryDate" type='text' class="form-control date-mask" name="aniversaryDate" placeholder="mm-dd-yyyy" id="aniversaryDate" />
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
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-4">
                                                <div class="form-group">
                                                    <strong>Zipcode</strong>
                                                    <input ng-model="form.zipcode" type="text" id="zipcode" name="zipcode" class="form-control"  />
                                                </div>
                                            </div>
                                        </div>
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
                                                    <input ng-model="form.leadWebSite" type="text" id="leadWebSite"  name="leadWebSite" class="form-control"/>
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
												<div class="col-xs-12 col-sm-12 col-md-12" ng-show="showItem">
												   <strong ng-show="showItem">Tags</strong>
												   <div class="form-group leadTagsDiv">
														<textarea rows="5" cols="60" ng-model="form.tagsList" name= "tagsList" id = "tagsList"></textarea>
													</div>
												</div>
											
											
											<!--<div class="col-xs-12 col-sm-12 col-md-12" ng-if="editContact == 'edit'">
											
													<input  type="hidden" name="leadId"  id="editLeadId" ng-model="form.leadId" />
													<div class="form-group" >
														<select  type="hidden" ng-required="true" ui-select2 ="select2Options" multiple="multiple" class="custom-select form-control select2-option" name="leadTags" id= "leadTags" ng-model="form.addleadtag">
															<option  ng-repeat="tag in tags" value="{{tag.TagTitle}}">{{tag.TagTitle}}</option>	
														</select> 
													</div>

													<button type="button" ng-click="addLeadTag()" class="btn btn-outline-secondary button-sm text-uppercase pull-right">Add Tags</button> 
													<div class="list-of-tags">
														<span class=""> 
															<a ng-repeat="leadTag in leadTags" class="tag-text" href="javascript:;">{{leadTag.TagTitle}}  
																<span ng-click="deleteTags($event)" tagId="{{leadTag.Id}}">X</span>	
															</a>
														</span>
													</div>
												</div>-->	
											
                                        </div>
                                        <div class="row"><div class="col-xs-12 col-sm-12 col-md-12"><strong>Social Profiles</strong></div></div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group date">
                                                        <input ng-model="form.leadFacebook" type="text" id="leadFacebook"  name="leadFacebook" class="form-control"  />
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-facebook"></span>
                                                        </span>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group date ">
                                                        <input ng-model="form.leadInstagram" type="text" id="leadInstagram"  name="leadInstagram" class="form-control"  />
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
                                                        <input ng-model="form.leadTwitter" type="text" id="leadTwitter"  name="leadTwitter" class="form-control"  />
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-twitter"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group date ">
                                                        <input ng-model="form.leadLinkedin" type="text" id="leadLinkedin"  name="leadLinkedin" class="form-control"  />
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
                                        <button ng-if="editContact === undefined" type="submit" ng-disabled="addLead.$invalid" class="btn btn-yellow">Add Contact</button>
                                        <button ng-if="editContact == 'edit'" type="submit" ng-disabled="addLead.$invalid" class="btn btn-yellow btnEditLead">Edit Contact</button>

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
</div>
<style>
#addLeadForm span.select2.select2-container.select2-container--default.select2-container--below {
    width: 100% !important;
    display: inline-block;
}
#addLeadForm span.select2.select2-container.select2-container--default{
	width: 100% !important;
    display: inline-block;
}
#addLeadForm span.select2.select2-container.select2-container--default{
    width: 100% !important;
    //display: none;
}
</style>