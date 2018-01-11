<?php //select TIMESTAMPDIFF(SECOND,`CreatedAt`,NOW()) from leads  ?>
<div ng-controller="DashboardController" ng-cloak>
    <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class= "col-md-12 col-sm-12 col-xs-12 padding-0">
                <div class="page-name">
                    <h1>Dashboard</h1>
                    <a href="<?php base_url();?>message" class="btn btn-outline-secondary button-sm"><i class="fa fa-envelope"></i> Messages</a>
                    <!--<button class="btn btn-outline-secondary button-sm" data-toggle="modal" data-target="#create-user"><i class="fa fa-plus"></i>Add Team Member</button> -->							
                    <button class="btn btn-outline-secondary button-sm" data-toggle="modal" data-target="#create-lead" ng-click="leadDropdown()"><i class="fa fa-plus"></i>Lead</button>							
                </div>
            </div>
            <div class="widget">
                <div class="widget-body dashboard-contact">
					
                    <ul id="profile-nav-tabs" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="nav-item">
                            <a href="#recently-added" class="nav-link active text-uppercase" aria-controls="profile-stream" role="tab" data-toggle="tab" aria-expanded="true">Recently Added</a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#hot-leads" class="nav-link text-uppercase" aria-controls="profile-photos" role="tab" data-toggle="tab" aria-expanded="false">
                                Hot Leads</a>
                        </li>
                       <!-- <a href="<?php echo base_url();?>contact/contactsmerge" class="btn btn-outline-secondary button-sm merge-btn">Merge Leads</a> -->
                    </ul>

                    <div class="tab-content">	
						
                        <div  role="tabpanel" class="tab-pane active" id="recently-added" aria-expanded="true">
                            <div class="row">
                                <div class="col-sm-12 table-responsive" id="recentlyLead">
									<div class="lead-scroll">
                                    <table class="table table-contact-list">
                                        <tbody>
                                            <tr ng-repeat="lead in recentLeadData">
                                                <td width="65%">
                                                    <div class="media stream-post">
                                                        <div class="avatar avatar-circle">
															
                                                          <a href="<?php echo base_url(); ?>leads/viewDetails/{{lead.Id}}" class="image-parent green-avatar">
                                                            <name-abbreviation name="{{lead.leadUserName}}"></name-abbreviation>
                                                        </a>
															
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading mt-1">
                                                                <a href="<?php echo base_url(); ?>leads/viewDetails/{{lead.Id}}" class="sp-auther">{{lead.leadUserName}}</a> 				
                                                            </h4>
                                                            <small class="sp-meta">Active {{lead.elpsadedTime}} </small>			
                                                        </div>
                                                    </div>	
                                                </td>
                                                 <td width="35%" class="perform-action">  
													<a href="javascript:;" class="pull-right" ng-click ="deleteLead($event)" leadId = {{lead.Id}} ><i class="fa fa-trash-o"></i></a>												
                                                    <span class="dropdown pull-right">                                                        
														<a href="javascript:;" class="dropdown-toggle" type="" id="dropdownElipsis" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                                        <div class="dropdown-menu media-list float-right animated scaleInDownLeft" aria-labelledby="dropdownElipsis">
                                                            <a  class="dropdown-item highlightIndDashboard" href="javascript:;"  ng-click="changeLeadStatusHot($event)" leadId = {{lead.Id}}>Hot Leads</a>
                                                            <a class="dropdown-item highlightIndDashboard" href="<?php echo base_url(); ?>leads/viewDetails/{{lead.Id}}">Contact Profile</a>
                                                        </div>
                                                    </span>																										                                                    													
													<button ng-click ="updateLeadId($event)" data-leadId = {{lead.Id}} class="btn btn-outline-secondary button-sm pull-right" data-toggle="modal" data-target="#create-task"><i class="fa fa-plus"></i> Add Task</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
									</div>
								</div>
                            </div>

                           <!-- <div class="row">
                                <div class="col-sm-12 expand-list text-center">
                                    <h4>
                                        <a href="javascript:;">
                                            <i class="fa fa-chevron-down"></i>
                                        </a>
                                    </h4>
                                </div>	
                            </div>-->
                        </div>

                        <div role="tabpanel" class="tab-pane" id="hot-leads" aria-expanded="true">
                            <div class="row">
							
                                <div class="col-sm-12 table-responsive" id="hotLeadData">
									<div class="lead-scroll">
                                    <table class="table table-contact-list">
                                        <tbody>
                                            <tr ng-repeat="lead in hotLeadData" >
                                                <td width="65%">
                                                    <div class="media stream-post">
                                                        <div class="avatar avatar-circle">
														  <a href="<?php echo base_url(); ?>leads/viewDetails/{{lead.Id}}" class="image-parent">
                                                            <img ng-if = "lead.userImage" src="<?php echo base_url() . UPLOAD_DIR . '/' . IMAGE . '/' . LEAD_IMAGE . '/'?>{{lead.userImage}}"  alt=""/>
														   <img ng-if = "!lead.userImage" src="<?php echo base_url() . ASSETS_DIR .'/global/images/Blank_Club_Website_Avatar_Gray.jpg'?>"  alt=""/></a>
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading mt-1">
                                                                <a href="<?php echo base_url(); ?>leads/viewDetails/{{lead.Id}}"class="sp-auther">{{lead.leadUserName}}</a>
                                                            </h4>
                                                            <small class="sp-meta">Active {{lead.elpsadedTime}}</small>						
                                                        </div>
                                                    </div>	
                                                </td>
                                                
												<td width="35%" class="perform-action">  
													<a href="javascript:;" class="pull-right" ng-click ="deleteLead($event)" leadId = {{lead.Id}} ><i class="fa fa-trash-o"></i></a>												
                                                    <span class="dropdown pull-right">                                                        
														<a href="javascript:;" class="dropdown-toggle" type="" id="dropdownElipsis" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                                        <div class="dropdown-menu media-list float-right animated scaleInDownLeft" aria-labelledby="dropdownElipsis">
                                                            <a class="dropdown-item" href="<?php echo base_url(); ?>leads/viewDetails/{{lead.Id}}">Contact Profile</a>
                                                        </div>
                                                    </span>																										                                                    													
													<button ng-click ="updateLeadId($event)" data-leadId = {{lead.Id}} class="btn btn-outline-secondary button-sm pull-right" data-toggle="modal" data-target="#create-task"><i class="fa fa-plus"></i> Add Task</button>
                                                </td>
											
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>

                           <!-- <div class="row">
                                <div class="col-sm-12 expand-list text-center">
                                    <h4>
                                        <a href="javascript:;">
                                            <i class="fa fa-chevron-down"></i>
                                        </a>
                                    </h4>
                                </div>	
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-body padding-0">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="daily-task">
                                <h3>
                                    <a href="<?php echo base_url() ?>/tasks">your daily task</a>
                                </h3>
                                <?php $taskFilter = json_decode(TASKFILTER); ?>
                                <div class="custom-select-daily">
									<div class="btn-group">
									  <button type="button"  class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span id="taskFilerBtnText">Today</span> 
									  </button>
									  <!--<ul class="dropdown-menu">
										<li><a href="javascript:;">Overdue</a></li>
										<li><a href="javascript:;">Today + Overdue</a></li>
										<li><a href="javascript:;">Tomorrow</a></li>										
										<li><a href="javascript:;">Next 7 days</a></li>
										<li><a href="javascript:;">Next 7 days + Overdue</a></li>
										<li><a href="javascript:;">This Month</a></li>
										<li><a href="javascript:;">All Open</a></li>
									  </ul> -->
									  <ul class="dropdown-menu">
									  <?php
										 foreach ($taskFilter as $key => $val) { ?>
											<li><a href="javascript:;" ng-click="taskFilter($event)" currentText = "<?php echo $val; ?>"  currentVal = <?php echo $key; ?> ><?php echo $val; ?></a></li>
										<?php
										 }
										?>
									</ul>
									</div>
                                    <!--<select ng-change = "taskFilter(filterOption)" class="form-control custom-select" ng-model = "filterOption">
                                        <?php foreach ($taskFilter as $key => $val) {
													$selected = "";
													if($val == 'today')
													{
														$selected = 'ng-selected="mySel"';
													}
                                            ?>
                                            <option  ng-selected="selected" <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                        <?php } ?>
                                    </select>-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="task-list daily">
                                <div class="task-list-head">
                                    <div class="days-head today">
                                        <span class="day">Today</span>	
                                        <span class="month-day"><?php echo date('F d, Y'); ?></span>
                                        <span class="week-day"><?php echo date('l'); ?></span>	
                                    </div>

                                    <div class="settings">
                                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                                        <a class="demobtn" role="button" data-toggle="collapse" href="#dailytask" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="more-less fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="task-list-body collapse show" id="dailytask">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr ng-repeat = "dailyTask in dailyTaskData">
                                                    <td>
                                                        <i class="fa fa-check-circle-o"></i>
                                                    </td>
													<td>
														 <div class="ticket-status">
                                                            <h6>{{dailyTask.DueDate}}</h6>
                                                            <h6><strong>Assigned to :</strong> {{dailyTask.assignUser}}</h6>
                                                            <h6><strong>Status :</strong> <span>{{dailyTask.taskStatus}}</span></h6>
                                                        </div>
													</td>
                                                    <td width="30%">
                                                        
														<div class="media"> 
															<div class="media-left">
																<span>{{dailyTask.taskTitle}} :</span> 
															</div> 
															<div class="media-body"> 																
																<p>{{dailyTask.taskDescription}}</p>																 
															</div> 
														</div>														
                                                    </td>
                                                    <td class="contact">
                                                        <h6>
                                                            Contact
                                                            <div class="avatar avatar-circle">
                                                                <img  src="{{dailyTask.leadUserImage}}" alt="Photo">
                                                            </div>
                                                            <span>{{dailyTask.leadUserName}}  </span>
                                                        </h6>	
                                                    </td>
                                                    <td class="task-actions">
                                                        <a ng-click="editTaskData($event)" href="javascript:;" taskId = {{dailyTask.Id}} data-toggle="modal" data-target="#create-task" ><i class="fa fa-pencil" ></i></a>

                                                        <a ng-click ="reminderTask($event)" href="javascript:;" data-toggle="modal" data-target="#task-reminder" taskId = {{dailyTask.Id}}><img src="<?php echo base_url() . ASSETS_DIR ?>/global/images/snooze.png"/></a>		
                                                        <a href="javascript:;"  ng-click="deleteTask($event)" taskId = {{dailyTask.Id}} ><i class="fa fa-trash-o"></i>
                                                        </a>
                                                        <span class="dropdown">
                                                            <a href="javascript:;" class="dropdown-toggle" type="" id="dropdownElipsis" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                                            <div class="dropdown-menu media-list float-right animated scaleInDownLeft" aria-labelledby="dropdownElipsis">
                                                                <a class="dropdown-item" 
                                                                   href="javascript:;"  ng-click="changeTaskStatus($event)" taskId = {{dailyTask.Id}}>Complete Task</a>

                                                                <a class="dropdown-item" href="<?php echo base_url(); ?>leads/viewDetails/{{dailyTask.leadId}}">Contact Profile</a>

                                                            </div>
                                                        </span>

                                                    </td>
                                                </tr>



                                            </tbody>
                                        </table>
                                    </div>
                                </div>												
                            </div>
                            <!-- overDue -->

                            <div class="task-list overdue">
                                <div class="task-list-head">
                                    <div class="days-head overdue">
                                        <span>Overdue <i class="fa fa-exclamation-circle"></i></span>	
                                    </div>

                                    <div class="settings">
                                        <a href="javascript:;"><i class="fa fa-cog"></i></a>
                                        <a class="demobtn" role="button" data-toggle="collapse" href="#overdue" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="more-less fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="task-list-body collapse show" id="overdue">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>

                                                <tr ng-repeat = "overDueTask in overDueTaskData">
                                                    <td>
                                                        <i class="fa fa-check-circle-o"></i>
                                                    </td>
													<td>
														<div class="ticket-status">
                                                            <h6 class="red">{{overDueTask.DueDate}}
                                                                | {{overDueTask.DueDate| datetimeToPast}}</h6>
                                                            <h6 class=""><strong>Assigned to :</strong> {{overDueTask.assignUser}}</h6>
                                                            <h6 class=""><strong>Status :</strong> <span class="red">{{overDueTask.taskStatus}}</span></h6>
                                                        </div>
													</td>
                                                    <td width="30%">
                                                        
														<div class="media"> 
															<div class="media-left">
																<span>{{overDueTask.taskTitle}} :</span> 
															</div> 
															<div class="media-body"> 																
																 <p>{{overDueTask.taskDescription}}</p> 																
															</div> 
														</div>		
                                                    </td>
                                                    <td class="contact">
                                                        Contact
                                                        <div class="avatar avatar-circle">
                                                            <img  src="{{overDueTask.leadUserImage}}" alt="Photo">
                                                        </div>
                                                        <span>{{overDueTask.leadUserName}}  </span>
                                                    </td>
                                                     <td class="task-actions">
                                                        <a ng-click="editTaskData($event)" href="javascript:;" taskId = {{overDueTask.Id}} data-toggle="modal" data-target="#create-task" ><i class="fa fa-pencil" ></i></a>

                                                        <a ng-click ="reminderTask($event)" href="javascript:;" data-toggle="modal" data-target="#task-reminder" taskId = {{overDueTask.Id}}><img src="<?php echo base_url() . ASSETS_DIR ?>/global/images/snooze.png"/></a>		
                                                        <a href="javascript:;"  ng-click="deleteTask($event)" taskId = {{overDueTask.Id}} ><i class="fa fa-trash-o"></i>
                                                        </a>
                                                        <span class="dropdown">
                                                            <a href="javascript:;" class="dropdown-toggle" type="" id="dropdownElipsis" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                                            <div class="dropdown-menu media-list float-right animated scaleInDownLeft" aria-labelledby="dropdownElipsis">
                                                                <a class="dropdown-item" 
                                                                   href="javascript:;"  ng-click="changeTaskStatus($event)" taskId = {{overDueTask.Id}}>Complete Task</a>

                                                                <a class="dropdown-item" href="<?php echo base_url(); ?>leads/viewDetails/{{overDueTask.leadId}}">Contact Profile</a>

                                                            </div>
                                                        </span>

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
            </div>	
        </div>
		<?php 
		$this->load->view('components/rightsidebar'); 
		?>
        
    </div>
    <?php $this->load->view('dashboard/partial/leadCreate'); ?>
    <?php $this->load->view('dashboard/partial/taskCreate'); ?>
    <?php $this->load->view('dashboard/partial/userCreate'); ?>
    <?php $this->load->view('dashboard/partial/connect-email-account'); ?>
	<?php $contact_add_data['circles'] = $circles; $this->load->view('dashboard/partial/contact_add',$contact_add_data); ?>
	<?php $this->load->view('dashboard/partial/connect-calender'); ?>
    <?php $this->load->view('dashboard/partial/create_message'); ?>
	
<div class="modal snooze" id="task-reminder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-circle">
                            <img src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{reminderTaskUserImage}}" alt=""> 
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading">
                                <a href="javascript:void(0)">{{reminderLeadUserName}}</a>
                            </h5>
                            <small class="media-meta">{{leadTitle}}</small>
                        </div>
                        <a class="clock" href="javascript:;"><img src="assets/global/images/alarm_clock.png" alt=""> </a>
                    </div>
                    <div class="snooze-desc">
                        <p>
                            <span>{{reminderTaskTitle}}:</span> {{reminderTaskDescription}}
                        </p>
                    </div>
                    <hr/>
                    <form method="POST" name="addReminder" role="form" ng-submit="saveReminderTask()">
                        <div class="set-snooze"> 
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class='input-group date' id='reminderDatePicker'> 
                                            <input  ng-model="form.reminderDate" type='text' class="form-control" name="reminderDate" placeholder="yyyy-mm-dd" id="reminderDate" required />
                                            <span class="input-group-addon" >
                                                <span class="fa fa-calendar-check-o"></span>
                                            </span>
                                        </div> 
                                    </div>
                        <!-- <div class="form-group">
                            <select id="selectDate" style="display: table-row; width: 30%;" class="form-control selectWidth">
                                <option ng-repeat="n in range(1,31)">{{n}}<option>
                            </select>
                            <select id="selectMonth" style="display: table-row; width: 30%;" class="form-control selectWidth">
                                <option ng-repeat="n in range(1,12)">{{n}}<option>
                            </select>
                            <select id="selectYear" style="display: table-row; width: 30%;" class="form-control selectWidth">
                               <option ng-repeat="n in range(1900,2015)">{{n}}<option>
                            </select>
                        </div> -->
                                </div>
                                <div class="col-sm-6">
                                    <input ng-init="taskId ='{{reminderTaskId}}'" type="hidden" name="taskId" id="reminderTaskId" ng-model="form.taskId"  />
                                    <button type="submit" ng-disabled="addReminder.$invalid" class="btn btn-yellow btn-block">Set Snooze</button>
                                </div>
                                <div class="col-sm-6">

                                    <button data-dismiss="modal" aria-label="Close"  class="btn btn-yellow-outline btn-block">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
<?php
$this->load->view('components/footer');?>
<script src="<?php echo base_url() ?>app/controllers/DashboardController.js"></script>
<script>
                                       /*  $('.modal').on('hidden.bs.modal', function(){
                                        $(this).find('form')[0].reset();
                                        }); */
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
                                        /*var lat = place.geometry.location.lat();
                                        var lng = place.geometry.location.lng();
                                        $.ajax({
                                        url:"https://maps.googleapis.com/maps/api/timezone/json?location=" + lat + "," + lng + "&timestamp=" + times_Stamp + "&key=" + "<?php echo MAPKEY; ?>",
                                                cache: false,
                                                type: "POST",
                                                async: false,
                                        }).done(function(response){
                                        console.log(response);
                                        if (response.timeZoneId != null){
                                        console.log(response.timeZoneName);
                                        $("#timezone").val(response.timeZoneName);
                                        angular.element($('#timezone')).triggerHandler('input');
                                        };
                                        });
                                        angular.element($('#location')).triggerHandler('input'); */
                                        });
    var ctx = document.getElementById("chartjs-line-2").getContext('2d');
	var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        //labels: ["Dec8", "Dec9", "Dec10", "Dec11", "Dec12", "Dec13"],
        labels: [<?=$graph_labels?>],
        datasets: [{
            label: 'Leads',
            //data: [25, 50, 80, 30, 60, 90],
            data: [<?=$graph_data?>],
            backgroundColor: [
                'rgba(168, 215, 134, 1)',
                'rgba(168, 215, 134, 1)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(168, 215, 134, 1)',
                'rgba(168, 215, 134, 1)',
                'rgba(168, 215, 134, 1)',
                'rgba(168, 215, 134, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
$(function(){
	$('#tagsList').tagsInput({width:'auto'});
})
<?php 
 if(!$this->session->userdata('emailConnect'))
 { ?>
	$(window).on('load',function(){
		$('#connect-emailaccount').modal('show');
	});
 <?php }
	else if(($this->session->userdata('emailConnect')) && !$this->session->userdata('calenderConnect'))
	{ ?>
		$(window).on('load',function(){
		$('#connect-calender').modal('show');
	});
	<?php } 
	 
	else if(($this->session->userdata('calenderConnect')) && !$this->session->userdata('contactAdded'))
	{ ?>
		$(window).on('load',function(){
		$('#contact-add').modal('show');
	});
	<?php } 
	 else if(!$this->session->userdata('contactAdded'))
	{ ?>
		$(window).on('load',function(){
		$('#create-message').modal('show');
	});
	<?php }  ?>
</script>