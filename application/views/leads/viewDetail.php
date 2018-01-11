<?php ?>
<div ng-controller = "LeadController">
    <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-body lead-content">
                    <div class="row">
                        
                            <div class="col-md-2 col-sm-2 col-xs-12 lead-detail-left text-center">
                                <div class="avatar avatar-lg avatar-circle fix-image" >
                                    <a href="javascript:void(0)" class="image-parent">
                                        <?php if(!empty($leadDetails->userAvatar)) { ?>
                                            <img class="center-block leadUserImage" src="<?php echo (!empty($leadDetails->userAvatar)) ? base_url() . UPLOAD_DIR . '/' . IMAGE . '/' . LEAD_IMAGE . '/' . $leadDetails->userAvatar : base_url() . ASSETS_DIR . '/global/images/Blank_Club_Website_Avatar_Gray.jpg'; ?>" alt="avatar">
                                            <div class="chng-img"><i class="fa fa-camera"></i> </div>
                                            <input  ng-model="form.userImage" onchange="angular.element(this).scope().userUploadImage(this.files)"  type="file" id="userImage" name="userImage" accept="image/x-png,image/gif,image/jpeg" ngf-pattern=".jpg,.png" ngf-accept="image/*" class="form-control Profile-input-file" />
                                        <?php } else { ?>
                                            <img class="center-block leadUserImage" src="<?php echo (!empty($leadDetails->userAvatar)) ? base_url() . UPLOAD_DIR . '/' . IMAGE . '/' . LEAD_IMAGE . '/' . $leadDetails->userAvatar : base_url() . ASSETS_DIR . '/global/images/Blank_Club_Website_Avatar_Gray.jpg'; ?>" alt="avatar">
                                            <div class="chng-img"><i class="fa fa-camera"></i> </div>
                                            <input  ng-model="form.userImage" onchange="angular.element(this).scope().userUploadImage(this.files)"  type="file" id="userImage" name="userImage" accept="image/x-png,image/gif,image/jpeg" ngf-pattern=".jpg,.png" ngf-accept="image/*" class="form-control Profile-input-file" />
                                        <?php } ?>
                                    </a>
                                </div>

                            <h6 class="text-uppercase">status</h6>
                            <a class="lead-count  {{leadData.leadStatus| lowercase}}" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                {{leadData.leadStatus}}
                                <i class="fa fa-chevron-up"></i>
                            </a>

                            <div class="collapse lead-status show" id="collapseExample">
                                <h5>
                                    $2,300 <br/>
                                    <span>Current Deal</span>
                                </h5>

                                <h5>
                                    $2,200 <br/>
                                    <span>3 Total Deals</span>
                                </h5>

                                <h5>
                                    78 <br/>
                                    <span>Total Interactions</span>
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-10 col-sm-10 col-xs-12">

                            <div class="single-lead-detail">
                                <div class="col-md-6 col-sm-6 col-xs-12 single-lead-detail-rt padding-0">
                                    <h4>{{leadData.leadUserName}}
                                        <!--<a ng-click="leadEditMode = !leadEditMode"" href="javascript:;" id="editLeadBtn">
                                                <i class="fa fa-pencil"></i>
                                        </a> -->	
                                        <a ng-click="leadEditFlag()" href="javascript:;" id="editLeadBtn">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </h4>

                                    <span>{{leadData.leadTitle}}</span>

                                    <a class="email" href="mailto:{{leadData.email}">{{leadData.email}}</a>

                                       <div class="social-links">
                                       <div ng-if="form.facebook != ''"> 
                                            <a href="javascript:;">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </div>
                                        <div ng-if="form.instagram != ''"> 
                                            <a href="javascript:;">
                                                <i class="fa fa-instagram"></i>
                                            </a>
                                        </div>
                                        <div ng-if="form.twitter != ''"> 
                                            <a href="javascript:;">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </div>
                                        <div ng-if="form.linkedin != ''">
                                            <a href="javascript:;">
                                                <i class="fa fa-linkedin"></i>
                                            </a>
                                        </div>

                                </div>	
                                <!--<div class="houseHold">
                                        <a  href="javascript:;" class="" data-toggle="modal"  data-target="#household-contact"><i class="fa fa-plus"></i> Add Household Contacts</a>	
                                </div> -->
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 single-lead-detail-lt padding-0">
                                <a href="#interaction-content" class="btn btn-outline-secondary button-sm text-uppercase pull-right">follow up</a>
                                <a href="javascript:;"><i class="fa fa-plus-circle"></i></a>
                                <a href="javascript:;"><i class="fa fa-commenting"></i></a>
                                <a href="javascript:;"><i class="fa fa-envelope"></i></a>
                                <a href="javascript:;"><i class="fa fa-phone"></i></a>
                            </div>
                        </div>
                        <div ng-show="leadEditMode == 1">
                            <form method="POST" name="updateLeadData" role="form" ng-submit="updateLeadDetails()" class="leadEditForm">
                                <div class="row personal-details-edit">
                                    <div class="col-md-6 col-sm-6 col-xs-12">


                                        <div class="col-md-12 leadFormCols">
                                            <label for="" class="col-sm-5 col-form-label">Lead Status<!--<span class="required_span_error">*</span>--></label>
                                            <div class="form-group row leadStatusdd">
                                                <!--  ng-init="editContact=='edit' ? form.leadStatusSelection=form.leadStatusSelection : '1'"-->
                                                <select ng-init="form.leadStatusSelection = '1'"  class="custom-select form-control" name="leadStatusSelection"  id= "leadStatusLead" ng-model="form.leadStatusSelection" >
                                                    <option ng-repeat="status in leadStatus" value={{status.Id}}>
                                                    <span class="{{status.LeadStatus| lowercase}}"></span>{{status.LeadStatus}}

                                                    </option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">First Name<span class="required_span_error">*</span></label>
                                            <div class="col-sm-7">
                                                <input ng-model= "form.firstName" type="text" id="firstName" name="firstName" class="form-control" required/>
                                                <p ng-show="updateLeadData.firstName.$invalid && !updateLeadData.firstName.$pristine" class="help-block">First Name is required.</p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Title<!--<span class="required_span_error">*</span>--></label>
                                            <div class="col-sm-7">
                                                <input ng-model="form.leadTitle" type="text" id="leadTitle"  name="leadTitle" class="form-control" />
                                                <p ng-show="updateLeadData.leadTitle.$invalid && !updateLeadData.leadTitle.$pristine" class="help-block">First Name is required.</p>
                                            </div>
                                        </div>				
                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Phone Number<!--<span class="required_span_error">*</span>--></label>
                                            <div class="col-sm-7">
                                                <input ng-model= "form.phoneNumber" type="text" id="phoneNumber" name="phoneNumber" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask=""/>
                                                <!--<p ng-show="updateLeadData.phoneNumber.$invalid && !updateLeadData.phoneNumber.$pristine" class="help-block">Phone Number is required.</p>-->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Company<!--<span class="required_span_error">*</span>--></label>
                                            <div class="col-sm-7">
                                                <input type="text" ng-model= "form.companyName" name = "companyName" id="companyName" class="form-control" />
                                                <!---<p ng-show="updateLeadData.companyName.$invalid && !updateLeadData.companyName.$pristine" class="help-block">Company is required.</p>-->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Lead Anniversary<!--<span class="required_span_error">*</span>--></label>
                                            <div class="col-sm-7">
                                                <div class='input-group date' id='aniversaryDatePicker'> 
                                                    <input  ng-model="form.aniversaryDate" type='text' class="form-control date-mask" name="aniversaryDate" placeholder="mm-dd-yyyy" id="aniversaryDate" />
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar-check-o"></span>
                                                    </span>
                                                </div> 
                                                <!--<p ng-show="updateLeadData.aniversaryDate.$invalid && !updateLeadData.aniversaryDate.$pristine" class="help-block">Lead Anniversary is required.</p>-->
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Address line 2</label>
                                            <div class="col-sm-7">
                                                <input type="text" ng-model= "form.addressLine2" name = "addressLine2" id="addressLine2" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">State</label>
                                            <div class="col-sm-7">
                                                <input type="text" ng-model= "form.leadState" name = "leadState" id="leadState" class="form-control" />
                                            </div>
                                        </div>






                                        <!--<div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Source</label>
                                            <div class="col-sm-7">
                                                <div class="day-select">
                                                    <select class="custom-select form-control" name="leadSource" id= "leadSource" ng-model="form.leadSource">
                                                        <option ng-repeat="source in leadSources" value="{{source.Id}}">{{source.LeadSource}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>-->

                                        <!--<div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Lead Status</label>
                                            <div class="col-sm-7">
                                                <select class="custom-select form-control" name="leadStatus" id= "leadStatus" ng-model="form.leadStatus">
                                                    <option ng-repeat="status in leadStatus" value={{status.Id}}>{{status.LeadStatus}}</option>
                                                </select>
                                            </div>
                                        </div>-->
                                        <!--<div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Location</label>							
                                            <div class="col-sm-7">
                                                <input type="text" ng-model = "form.locationName" name="locationName" id = "locationName" class="form-control" required/>

                                            </div>
                                        </div>-->
                                    </div>









                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="col-md-12 leadFormCols">
                                            <label for="" class="col-sm-5 col-form-label">Lead Source<!--<span class="required_span_error">*</span>--></label>
                                            <div class="form-group row leadSourcedd">
                                                <select class="custom-select form-control" ng-init="form.leadSourceSelection = '1'"   name="leadSourceSelection"  id= "leadSourceLead" ng-model="form.leadSourceSelection">
                                                    <option ng-repeat="source in leadSources" value="{{source.Id}}">{{source.LeadSource}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Last Name<span class="required_span_error">*</span></label>
                                            <div class="col-sm-7">
                                                <input ng-model= "form.lastName" type="text" id="lastName" name="lastName" class="form-control" required/>
                                                <p ng-show="updateLeadData.lastName.$invalid && !updateLeadData.lastName.$pristine" class="help-block">Last Name is required.</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Email Address<span class="required_span_error">*</span></label>
                                            <div class="col-sm-7">
                                                <input ng-model="form.email" id="email" type="email"  name="email" class="form-control" required />
                                                <p ng-show="updateLeadData.email.$invalid && !updateLeadData.email.$pristine" class="help-block">Email is required.</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Website</label>
                                            <div class="col-sm-7">
                                                <input type="text" ng-model= "form.leadWebSite" name = "leadWebSite" id="leadWebSite" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Birthdate<!--<span class="required_span_error">*</span>--></label>
                                            <div class="col-sm-7">
                                                <div class='input-group date' id='birthdatePicker'> 
                                                    <input  ng-model="form.birthdate" type='text' class="form-control date-mask" name="birthdate" placeholder="mm-dd-yyyy" id="birthdate" required />
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar-check-o"></span>
                                                    </span>
                                                </div> 
                                                <!--<p ng-show="updateLeadData.birthdate.$invalid && !updateLeadData.birthdate.$pristine" class="help-block">Birthdate is required.</p>-->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Address line 1</label>
                                            <div class="col-sm-7">
                                                <input type="text" ng-model= "form.addressLine1" name = "addressLine1" id="addressLine1" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">City</label>
                                            <div class="col-sm-7">
                                                <input type="text" ng-model= "form.leadCity" name = "leadCity" id="leadCity" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-5 col-form-label">Zipcode</label>
                                            <div class="col-sm-7">
                                                <input type="text" ng-model= "form.zipcode" name = "zipcode" id="zipcode" class="form-control" />
                                            </div>
                                        </div>








                                    </div>	


                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" ng-disabled="updateLeadData.$invalid" class="btn btn-yellow">Update Lead Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row" ng-if="leadEditMode != 1">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="personal-details">
                                    <label>Phone Number</label>
                                    <span class="ph-number">{{leadData.phoneNo}}</span>	
                                </div>

                                <div class="personal-details">
                                    <label>Source</label>
                                    <span>{{leadData.leadSource}}<span>
                                            </div>

                                            <div class="personal-details">
                                                <label>Owner</label>
                                                <span class="">{{leadData.leadOwnerName}}</span>	
                                            </div>

                                            <div class="personal-details">
                                                <label>Current Transaction</label>
                                                <span class="">{{leadData.leadTranscation}}</span>	
                                            </div>

                                            <div class="personal-details">
                                                <label>Lead Status</label>
                                                <span class="">{{leadData.leadStatus}}</span>	
                                            </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="personal-details">
                                                    <label>Company</label>
                                                    <span>{{leadData.companyName}}<span>
                                                            </div>

                                                            <div class="personal-details">
                                                                <label>Email</label>
                                                                <span class="">
                                                                    <a class="ph-number" href="mailto:{{leadData.email}}">{{leadData.email}}</a>
                                                                </span>	
                                                            </div>

                                                            <div class="personal-details">
                                                                <label>Time Zone</label>
                                                                <span class="">{{leadData.timezone}}</span>	
                                                            </div>

                                                            <div class="personal-details">
                                                                <label>Location</label>
                                                                <span class="">{{leadData.location}}</span>	
                                                            </div>

                                                            <div class="personal-details">
                                                                <label>Household Contacts</label>
                                                                <span class="" > 
                                                                    <a   ng-repeat = "houseHoldContact in houseHoldContacts" class="ph-number text-underline houseHoldContactParent" href="javascript:;">{{houseHoldContact.leadUserName}}  {{$last ? '' : ($index==houseHoldContacts.length-2) ? ',' : ', '}} 
                                                                        <span  ng-click = "deleteHouseHold($event)" houseHoldId = {{houseHoldContact.houseHoldId}}><i class="fa fa-trash-o"></i></span>	
                                                                    </a>
                                                                    <br/>


                                                                    <div class="houseHold">
                                                                        <button class="btn btn-outline-secondary button-sm text-uppercase"  data-toggle="modal"  data-target="#household-contact"><i class="fa fa-plus"></i> Add </button>	
                                                                    </div>
                                                            </div>
                                                            </div>
                                                            </div>	
                                                            </div>
                                                            </div>									
                                                            </div>
                                                            </div>
                                                            <div class="interaction-tabs">
                                                                <ul id="single-ld-interaction" class="nav nav-tabs" role="tablist">
                                                                    <li role="presentation" class="nav-item col-sm-6 padding-0">
                                                                        <a href="#interaction-content" class="nav-link active" aria-controls="profile-stream" role="tab" data-toggle="tab" aria-expanded="false">
                                                                            interaction
                                                                        </a>
                                                                    </li>
                                                                    <li role="presentation" class="nav-item col-sm-6 padding-0">
                                                                        <a href="#properties-content" class="nav-link" aria-controls="profile-photos" role="tab" data-toggle="tab" aria-expanded="false">
                                                                            properties
                                                                        </a>
                                                                    </li>										
                                                                </ul>
                                                            </div>

                                                            <div class="widget">
                                                                <div class="widget-body">
                                                                    <div class="tab-content">
                                                                        <div role="tabpanel" class="tab-pane active" id="interaction-content" aria-expanded="false">
                                                                            <form method="POST" name="saveInteraction" role="form" >
                                                                                <div class="row">
                                                                                    <input ng-init="form.leadId =<?php echo $leadDetails->Id; ?>" required   ng-value ="{{<?php echo $leadDetails->Id; ?>}}" type="hidden" name="leadId" id="leadId" ng-model="form.leadId"  />
                                                                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                                                                        <input type="text" ng-model="form.interactionTitle" name="interactionTitle" required  class="form-control" placeholder="Interaction Title"/> 
                                                                                        <p ng-show="saveInteraction.interactionTitle.$invalid && !saveInteraction.interactionTitle.$pristine" class="help-block">Title is required.</p>
                                                                                    </div>
                                                                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                                                                        <div class="input-group date" id='interactionDatePicker'>
                                                                                            <input ng-model="form.interactionDate" type="text" name = "interactionDate" id="interactionDate" class="form-control datepicker" required placeholder="Interaction Date"/>
                                                                                            <span class="input-group-addon">
                                                                                                <span class="fa fa-calendar-check-o"></span>
                                                                                            </span>
                                                                                            <p ng-show="saveInteraction.interactionDate.$invalid && !saveInteraction.interactionDate.$pristine" class="help-block">Date is required.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xs-12 col-sm-4 col-md-4 add-interactions" >
                                                                                        <div class="input-group-btn">
                                                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  ng-disabled="saveInteraction.$invalid">
                                                                                                Add Interaction <i class="fa fa-angle-down"></i>
                                                                                            </button>
                                                                                            <ul class="dropdown-menu dropdown-menu-right">
                                                                                                <li ng-repeat="interactionType in leadInteractionType" >
                                                                                                    <a href="javascript:;" interactionTypeId = {{interactionType.Id}}  ng-disabled="saveInteraction.$invalid" ng-click="saveInteraction.$valid && addInteraction($event)">{{interactionType.Title}} <i class="fa fa-calendar-o"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div><!-- /btn-group -->
                                                                                    </div><!-- /btn-group -->
                                                                                    <!-- /input-group -->
                                                                                    <!-- </div> -->
                                                                                </div>
                                                                            </form>
                                                                            <hr/>
                                                                            <form method="POST" name="searchInteraction" role="form"  ng-submit="searchInteractions()">
                                                                                <div class="row">
                                                                                    <div class="col-sm-6">
                                                                                        <div class="input-group date" id='searchInteractionDatePicker'>
                                                                                            <input date-range-picker ng-model="form.searchInteractionDate" type="text" name = "searchInteractionDate" id="searchInteractionDate" class="form-control date-picker"  placeholder="Interaction Date" />

                                                                                            <span class="input-group-addon">
                                                                                                <span class="fa fa-calendar-check-o"></span>
                                                                                            </span>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-6">
                                                                                        <div class="input-group search-result">
                                                                                            <input type="text" class="form-control" ng-model="form.searchInteractionTitle" type="text" name = "searchInteractionTitle" id="searchInteractionTitle" >
                                                                                            <span class="input-group-btn">
                                                                                                <button type="submit"  class="btn btn-yellow">
                                                                                                    Search
                                                                                                </button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>		
                                                                            <hr/>

                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <ul id="interaction-filter" class="nav nav-tabs" role="tablist">

                                                                                        <li role="presentation" class="nav-item">
                                                                                            <a  ng-click = "getInteractions($event)" href="#All" class="nav-link" aria-controls="profile-stream" role="tab" data-toggle="tab" aria-expanded="false" interactionTypeId = "0" >
                                                                                                All
                                                                                            </a>
                                                                                        </li>
                                                                                        <li ng-repeat="interactionType in leadInteractionType" role="presentation" class="nav-item">
                                                                                            <a href="#{{interactionType.Title| spaceless}}" ng-click = "getInteractions($event)" class="nav-link" aria-controls="profile-photos" role="tab" data-toggle="tab" aria-expanded="false" interactionTypeId = {{interactionType.Id}}>
                                                                                                {{interactionType.Title}}
                                                                                            </a>
                                                                                        </li>

                                                                                    </ul>

                                                                                    <div class="tab-content">
                                                                                        <div role="tabpanel" class="tab-pane active" id="All" aria-expanded="true">
                                                                                            <div class="table-responsive">
                                                                                                <table class="table interaction-lead">
                                                                                                    <tbody>
                                                                                                        <tr ng-repeat ="allInteraction in interactionsData">
                                                                                                            <td width="5%">
                                                                                                               <i class="{{allInteraction.interactionTypeIcon}}"></i>
                                                                                                            </td>
                                                                                                            <td width="5%">
                                                                                                                <div class="avatar avatar-circle">
                                                                                                                    <a href="javascript:void(0)">
                                                                                                                        <img  src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{allInteraction.userImage}}" alt="avatar">
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <h6 class="from-to">Jessica Fox; >  {{allInteraction.leadUserName}}</h6>
                                                                                                                <h6 class="msg">Re: {{allInteraction.interactionTitle}}</h6>
                                                                                                            </td>																			
                                                                                                            <td>
                                                                                                                <span>{{allInteraction.interactionDate}}</span>
                                                                                                            </td>
                                                                                                        </tr>

                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div role="tabpanel" class="tab-pane" id="properties-content" aria-expanded="false">
                                                                            <div class="row">
                                                                                <div class="col-sm-6 padding-0">
                                                                                    <div class="represented">
                                                                                        <table class="table table-bordered">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th colspan="4" class="re-title">Represented</th>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <th>Property</th>
                                                                                                    <th>Address</th>
                                                                                                    <th>Status</th>
                                                                                                    <th>Role</th>
                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>
                                                                                                <?php
                                                                                                if (!empty($representedProperties)) {
                                                                                                    foreach ($representedProperties as $property) {
                                                                                                        ?>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <img src="<?php echo $property->ImageUrl; ?>" alt="" width="50px">
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <span><?php echo $property->AddressFull; ?></span>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <span class="<?php echo strtolower($property->MlsStatusText); ?>"><?php echo $property->MlsStatusText; ?></span>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <span>Buyer</span>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <?php
                                                                                                    }
                                                                                                }
                                                                                                ?>

                                                                                            </tbody>
                                                                                        </table>	
                                                                                    </div>
                                                                                </div>


                                                                                <div class="col-sm-6 padding-0">
                                                                                    <div class="represented">
                                                                                        <table class="table table-bordered">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th colspan="4" class="re-title">Saved</th>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <th>Property</th>
                                                                                                    <th>Address</th>
                                                                                                    <th>Status</th>
                                                                                                    <th>Role</th>
                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>
                                                                                                <?php
                                                                                                if (!empty($savedProperties)) {
                                                                                                    foreach ($savedProperties as $property) {
                                                                                                        ?>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <img src="<?php echo $property->ImageUrl; ?>" alt="" width="50px">
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <span><?php echo $property->AddressFull; ?></span>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <span class="<?php echo strtolower($property->MlsStatusText); ?>"><?php echo $property->MlsStatusText; ?></span>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <span>Buyer</span>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <?php
                                                                                                    }
                                                                                                }
                                                                                                ?>

                                                                                            </tbody>
                                                                                        </table>	
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>




                                                            </div>

                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="sidebar-main">
                                                                    <div class="widget">
                                                                        <div class="widget-body">
                                                                            <div class="team">
                                                                                <h3 class="text-uppercase">team</h3>

                                                                                <div class="who-knows">
                                                                                    <?php foreach ($teamMember as $member) {
                                                                                        ?>
                                                                                        <div class="avatar avatar-circle">
                                                                                            <a href="javascript:void(0)">
                                                                                                <img src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE_THUMB_PATH . "/" . $member->ProfileImage; ?>" alt="avatar">
                                                                                            </a>
                                                                                        </div>
                                                                                    <?php }
                                                                                    ?>

                                                                                </div>

                                                                            </div>

                                                                            <div class="rel-contacts">
                                                                                <h3 class="text-uppercase">related leads</h3>
                                                                                <button class="btn btn-outline-secondary button-sm text-uppercase pull-right" data-toggle="modal"  data-target="#create-relation"><i class="fa fa-plus"></i> Add</button>
                                                                                <table class="table">
                                                                                    <tbody>
                                                                                        <tr  ng-repeat = "related in relatedContacts">
                                                                                            <td class="green lato-regular">{{related.leadUserName}}</td>
                                                                                            <td class="dark-blue lato-regular">{{related.relationTitle}}</td>
                                                                                            <td>
                                                                                                <a class="light-green" ng-click="editRelatedContact($event)" href="javascript:;" relatedId = {{related.relationId}}><i class="fa fa-pencil"></i></a>
                                                                                                <a href="javascript:;" ng-click="deleteRelatedContact($event)" relatedId = {{related.relationId}}><i class="fa fa-times"></i></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>

                                                                            <div class="baskets">
                                                                                <h3 class="text-uppercase">Circle</h3>
                                                                                <form method="POST" name="LeadCircle" role="form" ng-submit="addLeadCircle()" id="frmAddLeadCircle">
                                                                                    <input  type="hidden"  ng-model="form.addleadcircle.leadId" name="leadId" />
                                                                                    <div class="select-basket">
                                                                                        <div class="checkbox" ng-repeat="circle in circles">
																							<input class="checkboxCircle" type="checkbox" ng-model="form.addleadcircle.leadcircle[circle.Id]" ng-init="form.addleadcircle.leadcircle[circle.Id] = circle.checked" id="cb-{{circle.Id}}">
																						<label for="cb-{{circle.Id}}"><span class="custom-color" style="background-color:{{circle.Color}}"></span>{{circle.Name}}</label>
                                                                                        </div>
                                                                                    </div> 
																					
																					
																					
																					<!--<div class="checkbox" ng-repeat="circle in FilterData.circles | filter:searchcircle">
																						<input ng-change="changeCircle(circleindex, circle)" ng-true-value="{{circle.Id}}" type="checkbox" ng-model="circleindex" id="circle-{{circle.Id}}">
																						<span class="custom-color" style="background-color:{{circle.Color}}"></span> 
																						<label for="circle-{{circle.Id}}">{{circle.Name}}</label>
																					</div>-->
																					
																					
																					
                                                                                    <button type="submit" class="btn btn-outline-secondary button-sm text-uppercase pull-right">Add</button>     
                                                                                </form>
                                                                            </div>



                                                                            <div class="documents">
                                                                                <h3 class="text-uppercase">Documents</h3>									
                                                                                <a class="green" href="javascript:;" data-toggle="modal"  data-target="#addLeadDocument"><i class="fa fa-plus"></i> Add Documents</a>
                                                                                <div class="list-of-documents">
                                                                                    <span class=""> 
                                                                                        <a target= "_blank" ng-repeat="leadDocument in leadDocumentsData" class="documents-name" href="<?php echo base_url() . UPLOAD_DIR . "/" . LEAD_DOCUMENT . "/" ?>{{leadDocument.DocumentPath}} ">
																						
																						<!--{{leadDocument.OriginalDocumentPath?leadDocument.OriginalDocumentPath:leadDocument.DocumentPath}}-->
																						
																						{{leadDocument.OriginalDocumentPath?leadDocument.OriginalDocumentPath:''}}
																						
                                                                                            <span ng-click="deleteDocument($event)" leadDocumentId="{{leadDocument.Id}}">X</span>	
                                                                                        </a>
                                                                                    </span>
                                                                                </div>
                                                                            </div>	

                                                                            <div class="tags">
                                                                                <h3 class="text-uppercase">Tags</h3>
                                                                                <form method="POST" name="LeadTag" role="form" ng-submit="addLeadTag()">
                                                                                    <input type="hidden" ng-init="form.addleadtag.leadId =<?php echo $leadDetails->Id; ?>" name="leadId"  ng-model="form.addleadtag.leadId" required />

                                                                                    <div class="form-group">
                                                                                        <select  type="hidden" ng-required="true" ui-select2 ="select2Options" multiple="multiple" class="custom-select form-control select2-option" name="leadStatus" id= "leadStatus" ng-model="form.addleadtag.selectedTags">
                                                                                            <option  ng-repeat="tag in tags" value="{{tag.TagTitle}}">{{tag.TagTitle}}</option>	
                                                                                        </select> 
                                                                                    </div>

                                                                                    <button type="submit" class="btn btn-outline-secondary button-sm text-uppercase pull-right">Add Tags</button> 
                                                                                </form>
                                                                                <div class="list-of-tags">
                                                                                    <span class="" ng-if="leadTags.length > 0"> 
                                                                                        <a ng-repeat="leadTag in leadTags" class="tag-text" href="javascript:;">{{leadTag.TagTitle}}  
                                                                                            <span ng-click="deleteTags($event)" tagId="{{leadTag.Id}}">X</span>	
                                                                                        </a>
                                                                                    </span>
                                                                                </div>
                                                                            </div>	
                                                                        </div>
                                                                    </div>
                                                                </div>						
                                                            </div>
                                                            </div>
                                                            <?php $this->load->view('leads/partial/relatedContactCreate'); ?>
                                                            <?php $this->load->view('leads/partial/houseHoldContact'); ?>
                                                            <?php $this->load->view('leads/partial/relatedContactEdit'); ?>
                                                            <?php $this->load->view('leads/partial/leadDocument'); ?>

                                                            </div>

                                                            <?php $this->load->view('components/footer'); ?>
                                                            <script src="<?php echo base_url() ?>app/controllers/LeadController.js"></script>
                                                            <script>
                                                                                                        var currentLeadId = "<?php echo $leadDetails->Id; ?>";
                                                                                                        var mapKey = "<?php echo MAPKEY; ?>";
                                                                                                        var input = document.getElementById('addressLine1');
                                                                                                        autocomplete = new google.maps.places.Autocomplete(input);
                                                                                                        google.maps.event.addListener(autocomplete, 'place_changed', function () {
                                                                                                        var times_Stamp = (Math.round((new Date().getTime()) / 1000)).toString();
                                                                                                                var place = autocomplete.getPlace();
                                                                                                                console.log(place);
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
															</script>

<style>
div#properties-content {
    display: none !important;
}
</style>