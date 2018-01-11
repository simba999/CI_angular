<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/css/contact/style.css"/>
<div ng-controller="ContactController" class="contact-page" ng-cloak>
 <div class="row">
					<div class="col-md-9 col-sm-12 col-xs-12">
						<div class="page-name">
							<div class="circle-head-lt">
								<h1>Leads</h1>
							</div>
							
							<div class="circle-head-rt">
								<div class="row contacts-filter">
									<!-- <div class="col-auto">
										<div class="custom-select-daily">
											<select class="form-control">
												<option>Assigned</option>
												<option>Assigned 1</option>
												<option>Assigned 2</option>
												<option>Assigned 3</option>
											</select>
										</div>
									</div> -->
									
									<div class="col-auto">
									<!--<button class="btn btn-skyblue text-uppercase" data-toggle="modal" data-target="#create-lead"></i>Create Contact</button>-->
									<button class="btn btn-skyblue text-uppercase" ng-click="callAddLeadModal()" data-toggle="modal" data-target="#create-lead"></i>Create Contact</button>
									</div>
									
									<div class="col-auto">
										<a href="<?php echo base_url() ?>contact/import" class="btn btn-yellow text-uppercase" data-toggle="modal" data-target="#import-csv-lead">Import</a>
										
									</div>
									
									
									<div class="col-auto">
									<a href="#" class="btn btn-yellow text-uppercase" data-toggle="modal" data-target="#export-csv-lead">Export</a>
										<!-- <button id="exportPDFBtn" class="btn btn-yellow text-uppercase" data-toggle="modal" data-target="#export-csv-lead">Export</button> -->
									</div>
								</div>
							</div>
							
							<hr/>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<table id="exampleForContactTbl" class="table table-bordered contact-list-table">
										<thead>
											<tr>
												<th>
													<div class="checkbox">
														<input type="checkbox" id="cb1">
														<label for="cb1"></label>
													</div>
												</th>
												<th>Name</th>
												<th>Circle</th>
												<th>Assigned</th>
												<th>Last Contact</th>
												<!-- <th>Tags</th> -->
												<th></th>
											</tr>
										</thead>
										
										<tbody>
										<tr dir-paginate="user in overDueTaskData.data|itemsPerPage:overDueTaskData.itemsPerPage" total-items="overDueTaskData.total_count">
											<td>
												<div class="checkbox">
													<input type="checkbox" class="cb2">
													<label for="cb2"></label>
												</div>
											</td>
											<td width="25%">
												<div class="media">
													<div class="avatar avatar-circle">
														<a href="<?php echo base_url(); ?>leads/viewDetails/{{user.contactId}}" class="image-parent"><img src="{{user.ProfileImage?user.ProfileImage:profileImage}}" alt="image not avail"  class="contactListLeadProfileImage"/></a>												
													</div>
													<div class="media-body">
														<h5 class="media-heading">
															<a href="<?php echo base_url(); ?>leads/viewDetails/{{user.contactId}}">{{user.contactName}}</a>
															<a  ng-click="editContactData($event)" leadId= "{{user.contactId}}" href="javascript:void(0)"><i class="fa fa-pencil"></i></a>
														</h5>														
													</div>
												</div>
											</td>

											<td>
												<span ng-bind="user.circlesAll">
												</span>
											</td>
											<td>

												<!--<div class="custom-select-daily">
													<select class="form-control"> -->
												<!-- <select class="form-control BoxSizeForAssign AssignForWidth" ng-change="updateAssignee(user, AssignedUsers)" ng-model="AssignedUsers">
															<option value="{{Assigned.Id}}"  ng-repeat="Assigned in FilterData.AssignedUsers">{{Assigned.UserName}}</option> -->

												<select class="form-control BoxSizeForAssign AssignForWidth" 
												ng-change="updateAssignee(user, user.AssignedUserId)" ng-model="user.AssignedUserId" ng-options="Assigned.Id as Assigned.UserName for Assigned in FilterData.AssignedUsers">
        						                	<option value="">Please Select</option>
												</select>
											</td>
											<td>
													<span>{{user.CreatedAt | date : "MMM dd"}}</span>

											</td>
											
											<td width="10%">
												<a ng-click="createLeadInteractionEmail('',user.contactId,'<?php echo INTERACTION_TYPE_EMAIL; ?>',$event)"><i class="fa fa-envelope"></i></a>
												<a ng-click="createLeadInteraction('',user.contactId,'<?php echo INTERACTION_TYPE_TEXT; ?>')"><i class="fa fa-comment"></i></a>
												<a ng-click="createLeadInteraction('',user.contactId,'<?php echo INTERACTION_TYPE_CALL; ?>')"><i class="fa fa-phone"></i></a> 
											</td>	
										</tr>
										</tbody>
									</table>

									<dir-pagination-controls
										max-size="8"
										direction-links="true"
										boundary-links="true" 
										on-page-change="getOverDueTaskData(newPageNumber)" >
									</dir-pagination-controls>
								</div>
							</div>
							
						</div>
					</div>

					
					
					<div class="col-md-3 col-sm-12 col-xs-12 contactListFiltersMainDiv">
						<div class="sidebar-main filters contactListFilters">
							<div class="widget contactListFilterWidget">
								<div class="widget-body">
									<div class="">
										<h2 class="text-uppercase filter-title">filters</h2>
									</div>
									
									<div class="baskets">
										<div class="row">
											<div class="col-sm-12">
												<h3 class="">Circle</h3>
												<a class="pull-right" data-toggle="collapse" href="#basket-list" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down"></i></a>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-12">
												<div class="collapse" id="basket-list">
													<div class="input-group mb-2">
														<div class="input-group-addon"><i class="fa fa-search"></i></div>
														<input type="text" ng-model="searchcircle" class="form-control" id="inlineFormInputGroup" placeholder="Search in Circle">
													</div>
												
													<div class="select-basket">
														<div class="checkbox" ng-repeat="circle in FilterData.circles | filter:searchcircle">
															<input ng-change="changeCircle(circleindex, circle)" ng-true-value="{{circle.Id}}" type="checkbox" ng-model="circleindex" id="circle-{{circle.Id}}">
															<label for="circle-{{circle.Id}}"><span class="custom-color" style="background-color:{{circle.Color}}"></span> {{circle.Name}}</label>
														</div>
														
														
														<a href="javascript:;">Manage Circle</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="deals status-sidebar">
										<div class="row">
											<div class="col-sm-12">
												<h3 class="">Status</h3>
												<a class="pull-right" data-toggle="collapse" href="#status-list" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down"></i></a>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-12">
												<div class="collapse" id="status-list">
													
													<div class="checkbox" ng-repeat="status in FilterData.statuses">
														<input ng-change="changeStatus(statusindex, status)" ng-true-value="{{status.Id}}" type="checkbox" ng-model="statusindex" id="status-{{status.Id}}" > 
														<label class="{{status.LeadStatus |  lowercase}}" for="status-{{status.Id}}"><img src="assets/global/images/{{status.LeadStatus |  lowercase}}.png"/> &nbsp;{{status.LeadStatus}}</label>
													</div>
												
													
												</div>												
											</div>
										</div>
									</div>

									<div class="deals status-sidebar">
										<div class="row">
											<div class="col-sm-12">
												<h3 class="">Tags</h3>
												<a class="pull-right" data-toggle="collapse" href="#tags-search" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down"></i></a>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-12">										
												<div class="collapse" id="tags-search">
													<div class="input-group mb-2">
														<div class="input-group-addon"><i class="fa fa-search"></i></div>
														<input type="text" class="form-control" id="inlineFormInputGroup" ng-model="searchtags" placeholder="Search in Tags">
													</div>
													
													<div ng-if="FilterData.tags.length > 0" class="checkbox" ng-repeat="tag in FilterData.tags | filter:searchtags">
														<input ng-change="changeTags(tagindex, tag)" type="checkbox" ng-model="tagindex" id="tag-{{tag.TagTitle}}" > 
														<label  for="tag-{{tag.TagTitle}}">{{tag.TagTitle}}</label>
													</div>
													
													<span  ng-if="FilterData.tags.length == 0">You do not have any tags yet</span> <br/>	
													
												</div>
											</div>
										</div>
									</div>
									
									<!-- <div class="deals status-sidebar">
										<div class="row">
											<div class="col-sm-12">
												<h3 class="">Companies</h3>
												<a class="pull-right" data-toggle="collapse" href="#companies" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down"></i></a>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-12">										
												<div class="collapse" id="companies">
													<div class="input-group mb-2">
														<div class="input-group-addon"><i class="fa fa-search"></i></div>
														<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search Companies">
													</div>
													
													<a href="javascript:;">Manage Companies</a>		
												</div>
											</div>
										</div>
									</div>
									
									<div class="deals status-sidebar">
										<div class="row">
											<div class="col-sm-12">
												<h3 class="">Locations</h3>
												<a class="pull-right" data-toggle="collapse" href="#locations" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down"></i></a>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-12">										
												<div class="collapse" id="locations">
													<div class="input-group mb-2">
														<div class="input-group-addon"><i class="fa fa-search"></i></div>
														<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search Locations">
													</div>
													
													<a href="javascript:;">Manage Location</a>		
												</div>
											</div>
										</div>
									</div> -->
									
									<div class="deals status-sidebar">
										<div class="row">
											<div class="col-sm-12">
												<h3 class="">Assigned to</h3>
												<a class="pull-right" data-toggle="collapse" href="#assigned" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down"></i></a>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-12">										
												<div class="collapse" id="assigned">
													<div class="input-group mb-2">
														<div class="input-group-addon"><i class="fa fa-search"></i></div>
														<input type="text" ng-model="searchassignedto" class="form-control" id="inlineFormInputGroup" placeholder="Search Teammates">
													</div>
													<div class="checkbox" ng-repeat="user in FilterData.AssignedUsers | filter:searchassignedto">
														<input ng-change="changeAssignedUsers(userindex, user)" ng-true-value="{{user.Id}}" type="checkbox" ng-model="userindex" id="user-{{user.Id}}">
														<label for="user-{{user.Id}}">{{user.UserName}}</label>
													</div>


													
												</div>
											</div>
										</div>
									</div>
									
									<!-- <div class="deals status-sidebar">
										<div class="row">
											<div class="col-sm-12">
												<h3 class="">Connected to</h3>
												<a class="pull-right" data-toggle="collapse" href="#connected" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down"></i></a>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-12">										
												<div class="collapse" id="connected">
													<div class="input-group mb-2">
														<div class="input-group-addon"><i class="fa fa-search"></i></div>
														<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search Teammates">
													</div>
													
													<div class="checkbox">
														<input type="checkbox" id="cb-15">
														<label for="cb-15">Includes team’s contacts</label>
													</div>
													
													<div class="checkbox">
														<input type="checkbox" id="cb-16">
														<label for="cb-16">Pam Williams</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									
									<div class="deals status-sidebar">
										<div class="row">
											<div class="col-sm-12">
												<h3 class="">Frequency</h3>
												<a class="pull-right" data-toggle="collapse" href="#frequency" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down"></i></a>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-12">										
												<div class="collapse" id="frequency">
													<h6>Last Contacted:</h6>
													<div class="row">
														<div class="col-sm-6">
															 <div class="form-group">
																<label for="">After</label>
																<input type="email" class="form-control" id="" aria-describedby="" placeholder="">
															  </div>
														</div>
														
														<div class="col-sm-6">
															 <div class="form-group">
																<label for="">Before</label>
																<input type="email" class="form-control" id="" aria-describedby="" placeholder="">
															  </div>
														</div>
													</div>
													
													<h6>Added:</h6>
													<div class="row">
														<div class="col-sm-6">
															 <div class="form-group">
																<label for="">After</label>
																<input type="email" class="form-control" id="" aria-describedby="" placeholder="">
															  </div>
														</div>
														
														<div class="col-sm-6">
															 <div class="form-group">
																<label for="">Before</label>
																<input type="email" class="form-control" id="" aria-describedby="" placeholder="">
															  </div>
														</div>
													</div>
													
													<h6>Times Contacted:</h6>
													<div class="row">
														<div class="col-sm-6">
															 <div class="form-group">
																<label for="">After</label>
																<input type="email" class="form-control" id="" aria-describedby="" placeholder="">
															  </div>
														</div>
														
														<div class="col-sm-6">
															 <div class="form-group">
																<label for="">Before</label>
																<input type="email" class="form-control" id="" aria-describedby="" placeholder="">
															  </div>
														</div>
													</div>
													
												</div>
											</div>
										</div>
									</div>
									
									<div class="deals status-sidebar">
											<div class="row">
												<div class="col-sm-12">
													<h3 class="">Accounts</h3>
													<a class="pull-right" data-toggle="collapse" href="#accounts" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down"></i></a>
												</div>
											</div>
											
											<div class="row">
												<div class="col-sm-12">										
													<div class="collapse" id="accounts">
														<div class="checkbox">
															<input type="checkbox" id="cb-17">
															<label for="cb-17">john_smith@gmail.com</label>
														</div>														
													</div>
												</div>
											</div>
										</div> -->
									
									
								</div>
							</div>
						</div>
					</div>
</div>

<div class="modal snooze" id="create-interaction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog createInteraction" role="document">
        <div class="modal-content">
            <form method="POST" name="addInteractionType" role="form" ng-submit="saveLeadInteraction()" class="frmAddInteractionType">
                <!--<div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></h4>
                    <button type="button" ng-click="resetFormWithModalClose(this.form)" class="close text-right" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>-->
                <div class="modal-body">
                    <div id="formHidden">
                    </div>
                    <div>
                        <div class="searchArea">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group interactionDropdownControlSection">
                                        <div class="col-md-12">
                                            <label class="lblInteractionType">Interaction Type</label>
                                            <select ng-model="form.selectInteractionType" ng-init="form.selectInteractionType = '1'" class="form-control" id="selectInteractionType" name="selectInteractionType" required>
                                                    <option ng-repeat ="interactionTypes in interactionTypesDropdown" value="{{interactionTypes.interactionTypeId}}">{{interactionTypes.interactionTypeTitle}}</option>	
                                                </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group interactionDropdownControlSection">
                                        <div class="col-md-12 interactionDate">
                                            <label class="lblInteractionType">Interaction Date</label>
                                            <div class="input-group date" id="interactionDatePicker">
                                                <input ng-model="form.interactionDate" type="text" class="form-control" name="interactionDate" placeholder="mm-dd-yyyy" id="interactionDate" required>
                                                <span class="input-group-addon">
                                                        <span class="fa fa-calendar-check-o"></span>
                                                </span>
                                            </div>
                                            <p ng-show="addInteractionType.interactionDate.$invalid && !addInteractionType.interactionDate.$pristine" class="help-block">Date is required.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-12 interactionTitle">
                                            <label class="lblInteractionType">Interaction Details</label>
                                            <textarea ng-model="form.interactionTitle" name="interactionTitle" rows="7" cols="7" class="form-control" id="interactionTitle" required></textarea>
                                            <p ng-show="addInteractionType.interactionTitle.$invalid && !addInteractionType.interactionTitle.$pristine" class="help-block">Interaction Title is required.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-12 interactionFormControls">
                                            <button ng-disabled="addInteractionType.$invalid" type="submit" class="btn btn-yellow CLeadIntSubmitBtn">Submit</button>

                                            <button type="reset" ng-click="resetForm(this.form)" class="btn btn-yellow-outline btn-block cancelLeadInteraction">Cancel</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>

    </div>
</div>


<!-- Modal for Message -->
<div class="modal fade sending-mail" id="create-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">		  
            <div class="modal-body">
                <div class="media-body">
                    <form method="POST" id="createmessage" name="createMessage" role="form" ng-submit="sentMessage()">
						<div id="emailFormHidden">
						</div>
                        <input type="hidden" ng-model="form.parentId" name="parentId" id="parentId" ng-init='form.parentId = 0'>
                        <input type="hidden" ng-model="form.replyMsg" name="replyMsg" id="replyMsg" ng-init='form.replyMsg = 0'>
                        <div class="form-group sent-mail-to" ng-class="{'has-error':createMessage.toUser.$invalid && !createMessage.toUser.$pristine }">
                           <div class="form-row align-items-center">
                                <div class="col-auto padding-0 text-center to-name-label">
                                    <span class="to-name">&nbsp;</span>
                                </div>
                                <div class="col-sm-11">
                                    <select style="width : 100%"  type="hidden" ng-required="true" ui-select2 ="select2Options" multiple="multiple" class="custom-select form-control select2-option" name="toUser" id= "toUser" ng-model="form.toUser" required />
                                        <option   ng-repeat="assignUser in leads" value="{{assignUser.Id}}">{{assignUser.FirstName}} {{assignUser.LastName}}</option>	
                                    </select>
                                </div>
                                <div class="col-auto padding-0 text-center">
                                    <a class="add-cc" href="javascript:;">CC</a>
                                </div>
                                <div class="col-auto padding-0 text-center">
                                    <a class="add-bcc" href="javascript:;">BCC</a>
                                </div>
                            </div>
                        </div>
                        <div class="to-mail subject" ng-class="{'has-error':createMessage.subject.$invalid && !createMessage.subject.$pristine }">
                            <span>Subject:</span>
                            <input ng-model="form.subject" type="text" name="subject" class="form-control" required />
                            <p ng-show="createMessage.subject.$invalid && !createMessage.subject.$pristine" class="help-block">Subject is required.</p>
                        </div>
                        <div class="form-group"  ng-class="{'has-error':createMessage.content.$invalid && !createMessage.content.$pristine }">
                            <summernote  ng-model="form.content" class="messageContent widthOfMessageBody" config="options" on-media-delete="mediaDelete(target)" required></summernote>
                            <p ng-show="createMessage.content.$invalid && !createMessage.content.$pristine" class="help-block">Message Content is required.</p>
                        </div>
                       <div class="row send-mail">
                            <div class="col-sm-7">
                                <input type="hidden" value="" ng-model="form.messagetype">
                                <a class="save-draft" href="javascript:;">
                                    <button ng-click="savedraft()"  name="savedraft" value="savedraft"  type="submit" class="btn btn-yellow">
                                        <i class="fa fa-floppy-o"></i>
                                    </button>
                                </a>

                                <a class="reply-chain" href="javascript:;">
                                    <i class="fa fa-reply"></i>
                                </a>

                                <div class="checkbox">
                                    <input type="checkbox" id="cb-13" ng-model="form.checkboxnotifyopened" value="yes">
                                    <label for="cb-13">Notify me if opened</label>
                                </div>

                                <div class="checkbox">
                                    <input type="checkbox" id="cb-14"  ng-model="form.checkboxnotifyday"  name="checkboxnotifyday" value="yes">
                                    <label for="cb-14">Notify me if no reply: <span>__</span> days</label>
                                </div>

                            </div>

                           <div class="col-sm-2">
                               <div  ng-show="form.checkboxnotifyday">
                                   <input  ng-model="form.notifyday" type='number' placeholder="days" class="form-control" name="notifyday"  id="notifyDays" />
                               </div>
                           </div>
                            <div class="col-sm-3">
                                <button type="submit" ng-disabled="createMessage.$invalid" class="btn btn-yellow btn-block">Send</button>

                            </div>
                        </div>
                    </form>
                </div>			
            </div>		  
        </div>
    </div>
</div>
<!-- Modal for Message -->
<?php $this->load->view('contact/partial/contactCreate'); ?>
<?php $this->load->view('contact/partial/importCsv'); ?>
<?php $this->load->view('contact/partial/exportCsv'); ?>
</div>
<?php $this->load->view('components/footer'); ?>
<script src="<?php echo base_url() ?>app/controllers/ContactController.js"></script>
<script src="<?php echo base_url() ?>app/controllers/DashboardController.js"></script>
<script src="<?php echo base_url() ?>assets/global/js/contact/custom.js"></script>
<script>
	$(document).ready(function(){
	    $("select.AssignForWidth").change(function(){
	        var selectedCountry = $(".AssignForWidth option:selected").val();
            document.getElementById('hhh').textHtml = selectedCountry;
	        /*alert("You have selected the country - " + selectedCountry);*/
	        
	    });

		$("#cb1").click(function() {
			if ($("#cb1").prop("checked")) {
				$(".cb2").prop("checked", true);
			} else {
				$(".cb2").prop("checked", false);
			}
		}) 
 		
  });

  $(window).load(function(){
		var height1=jQuery('.contact-page .page-name').height();
		var height2=jQuery('.contact-page .sidebar-main').height();
		if(height1 > height2){
			jQuery('.contact-page .sidebar-main .widget').css('min-height',height1 + 58);
		}else{
			jQuery('.contact-page .page-name').css('min-height',height2 - 25);
		}
  });
var input = document.getElementById('addressLine1');
autocomplete = new google.maps.places.Autocomplete(input);
google.maps.event.addListener(autocomplete, 'place_changed', function () {
var times_Stamp = (Math.round((new Date().getTime()) / 1000)).toString();
var place = autocomplete.getPlace();
 $("#zipcode").val('');
 $("#addressLine2").val('');
 $("#leadCity").val('');
 $("#leadState").val('');
for (var i = 0; i < place.address_components.length; i++) {
	for (var j = 0; j < place.address_components[i].types.length; j++) {
		if (place.address_components[i].types[j] == "postal_code") {
		 $("#zipcode").val(place.address_components[i].long_name);
		 angular.element($('#zipcode')).triggerHandler('input');
		}if (place.address_components[i].types[j] == "sublocality_level_1") {
		 $("#addressLine2").val(place.address_components[i].long_name);
		 angular.element($('#addressLine2')).triggerHandler('input');
		}
		if (place.address_components[i].types[j] == "administrative_area_level_2") {
		 $("#leadCity").val(place.address_components[i].long_name);
		 angular.element($('#leadCity')).triggerHandler('input');

		}
		if (place.address_components[i].types[j] == "administrative_area_level_1") {
		 $("#leadState").val(place.address_components[i].long_name);
		 angular.element($('#leadState')).triggerHandler('input');

		}
	}
}
angular.element($('#addressLine1')).triggerHandler('input');
});
$(function(){
	$('#tagsList').tagsInput({width:'auto'});
});
</script>

