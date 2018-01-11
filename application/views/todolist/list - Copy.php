<div ng-controller="ToDoListController">
    <div class="row">
        <div class="col-sm-9 col-xs-12">
            <div class="widget">
                <div class="widget-body padding-0">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="daily-task">
                                <h3>to do list</h3>
                                <button data-toggle="modal"  data-target="#taskTemplate" class="btn btn-outline-secondary button-sm pull-right"><i class="fa fa-plus"></i>Task Template</button>
                                <button data-toggle="modal"  data-target="#createTemplate"  class="btn btn-outline-secondary button-sm pull-right"><i class="fa fa-plus"></i>Create Template</button>
                                <button data-toggle="modal"  data-target="#create-task"  class="btn btn-outline-secondary button-sm pull-right"><i class="fa fa-plus"></i>Create Task</button>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="todolst">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr ng-repeat = "(taskTemplatekey, taskTemplate) in taskTemplates">
												<td width="1%">
                                                    <i class="fa fa-th"></i>
													
                                                </td>
                                                <td width="1%">
                                                    <h5 class="check-circle"><i class="fa fa-check-circle-o"></i></h5>
                                                </td>
                                                <td>
                                                    <div class="media stream-post">
                                                        <a  ng-if="taskTemplatekey.split('-')[0] ==  'notemplate'" class="demobtn" role="button" data-toggle="collapse" href="#dailytask" aria-expanded="false" aria-controls="collapseExample">
                                                            <i class="more-less fa fa-chevron-up"></i>
                                                        </a> 
														<a  ng-if="taskTemplatekey.split('-')[0] !=  'notemplate'" class="demobtn" role="button" data-toggle="collapse" href="#{{taskTemplatekey.split('-')[0]}}" aria-expanded="false" aria-controls="{{taskTemplatekey.split('-')[0]}}">
                                                            <i class="more-less fa fa-chevron-up"></i>
                                                        </a>
                                                        <div class="avatar avatar-circle">
                                                            <a href="<?php echo base_url();?>leads/viewDetails/{{taskTemplate.Id}}"><img src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{taskTemplate.leadimage}}" alt=""></a>
                                                        </div>
                                                        <div class="media-body" ng-if="taskTemplatekey.split('-')[0] ==  'notemplate'">
                                                            <h4 class="media-heading mt-1">
                                                                <a href="javascript:void(0)" class="sp-auther">{{taskTemplate.leadfname}}  {{taskTemplate.leadlname}}</a> 																			
                                                            </h4>
                                                            <small class="sp-meta">{{taskTemplate.leadname}}</small>																		
                                                        </div> 
														<div class="media-body" ng-if="taskTemplatekey.split('-')[0] !=  'notemplate'">
                                                            <h4 class="media-heading mt-1">
                                                                <a href="javascript:void(0)" class="sp-auther">{{taskTemplate.leadfname}}  {{taskTemplate.leadlname}}</a> 																			
                                                            </h4>
                                                            <small class="sp-meta">{{taskTemplate.leadname}}</small>																		
                                                        </div>

                                                        <div class="todosch" ng-if="taskTemplatekey.split('-')[0] ==  'notemplate'">
                                                            <h6>{{taskTemplate.Title}}</h6>
                                                        </div>
														<div class="todosch" ng-if="taskTemplatekey.split('-')[0] !=  'notemplate'">
                                                            <h6>{{taskTemplate.templateName}}</h6>
                                                        </div>
                                                    </div>
														
													<div class="collapse" id="{{taskTemplatekey.split('-')[0]}}">
                                                        <div class="sched-detail">
                                                            <table class="table">	
															<tr	 ng-repeat = "singelTask in  taskTemplate.allTask">
                                                                <td width="1%">
                                                                    <h5 class="check-circle"><i class="fa fa-check-circle-o"></i></h5>
                                                                </td>
																 <td>
                                                                    <div class="media stream-post">																		
                                                                        <div class="avatar avatar-circle">
                                                                            <img src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{taskTemplate.leadimage}}" alt="">
                                                                        </div>
                                                                        <div class="media-body">
                                                                            <h4 class="media-heading mt-1">
                                                                                <a href="javascript:void(0)" class="sp-auther">{{singelTask.Title}}</a> 																			
                                                                            </h4>																			
                                                                        </div>

                                                                        <div class="todosch">
                                                                            <h6>{{singelTask.DueDate |date : "MMM dd" }}</h6>
                                                                        </div>
																	</div>
                                                                </td>
															</tr>
															</table>
														
													</div>
												 </div>
														
														

                                                </td>
                                                <td class="scheldt">
                                                    <h6 class="date closed" data-provide="datepicker">{{taskTemplate.DueDate |date : "MMM dd" }}</h6>
                                                </td>
                                                <td width="3%">
                                                    <div class="avatar avatar-circle m-r-0">
                                                        <img src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{taskTemplate.memberimage}}" alt="">
                                                    </div>
                                                </td>
                                                <td class="task-actions">																			
                                                    <span class="dropdown">
                                                        <a href="javascript:;" class="dropdown-toggle" type="" id="dropdownElipsis" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                                        <div class="dropdown-menu media-list float-right animated scaleInDownLeft" aria-labelledby="dropdownElipsis">
                                                            <a class="dropdown-item" href="javascript:;">Hot Lead</a>
                                                            <a class="dropdown-item" href="javascript:;">Contact Profile</a>
                                                            <a class="dropdown-item" href="javascript:;">Complete Task</a>
                                                        </div>
                                                    </span>	
                                                    <a ng-click="deleteTask($event)" taskId = {{taskTemplate.Id}} href="javascript:;"><i class="fa fa-trash-o"></i></a>
                                                    <a href="javascript:;" data-toggle="modal" data-target="#myModal"><img src="assets/global/images/snooze.png"></a>		
                                                    <a ng-click="editTaskData($event)" href="javascript:;" taskId = {{taskTemplate.Id}} data-toggle="modal" data-target="#create-task"><i class="fa fa-pencil"></i></a>
                                                </td>
											
                                          </tr>
                                           <!-- <tr>
                                                <td width="1%">
                                                    <h6><i class="fa fa-th"></i></h6>
                                                </td>
                                                <td width="1%">
                                                    <h5 class="check-circle"><i class="fa fa-check-circle-o"></i></h5>
                                                </td>
                                                <td>
                                                    <div class="media stream-post">
                                                        <a class="demobtn" role="button" data-toggle="collapse" href="#meet-sched1" aria-expanded="false" aria-controls="collapseExample">
                                                            <i class="more-less fa fa-chevron-up"></i>
                                                        </a>
                                                        <div class="avatar avatar-circle">
                                                            <img src="assets/global/images/221.jpg" alt="">
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading mt-1">
                                                                <a href="javascript:void(0)" class="sp-auther">Denver Jones</a> 																			
                                                            </h4>
                                                            <small class="sp-meta">Creative Director</small>																		
                                                        </div>

                                                        <div class="todosch">
                                                            <h6>Call him to Schedule a meeting</h6>
                                                        </div>
                                                    </div>

                                                    <div class="collapse" id="meet-sched1">
                                                        <div class="sched-detail">
                                                            <table class="table">																
                                                                <td width="1%">
                                                                    <h5 class="check-circle"><i class="fa fa-check-circle-o"></i></h5>
                                                                </td>
                                                                <td>
                                                                    <div class="media stream-post">																		
                                                                        <div class="avatar avatar-circle">
                                                                            <img src="assets/global/images/221.jpg" alt="">
                                                                        </div>
                                                                        <div class="media-body">
                                                                            <h4 class="media-heading mt-1">
                                                                                <a href="javascript:void(0)" class="sp-auther">Call him to Schedule a meeting</a> 																			
                                                                            </h4>																			
                                                                        </div>

                                                                        <div class="todosch">
                                                                            <h6>Oct 21</h6>
                                                                        </div>
                                                                </td>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="scheldt">
                                                    <h6 class="date closed" data-provide="datepicker">Oct 21</h6>
                                                </td>
                                                <td width="3%">
                                                    <div class="avatar avatar-circle m-r-0">
                                                        <img src="assets/global/images/221.jpg" alt="">
                                                    </div>
                                                </td>
                                                <td class="task-actions">																			
                                                    <span class="dropdown">
                                                        <a href="javascript:;" class="dropdown-toggle" type="" id="dropdownElipsis" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                                        <div class="dropdown-menu media-list float-right animated scaleInDownLeft" aria-labelledby="dropdownElipsis">
                                                            <a class="dropdown-item" href="javascript:;">Hot Lead</a>
                                                            <a class="dropdown-item" href="javascript:;">Contact Profile</a>
                                                            <a class="dropdown-item" href="javascript:;">Complete Task</a>
                                                        </div>
                                                    </span>	
                                                    <a href="javascript:;"><i class="fa fa-trash-o"></i></a>
                                                    <a href="javascript:;" data-toggle="modal" data-target="#myModal"><img src="assets/global/images/snooze.png"></a>		
                                                    <a href="javascript:;"><i class="fa fa-pencil"></i></a>
                                                </td>
                                            </tr> -->
                                        </tbody>
                                    </table>
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
                        <div class="welcome">	
                            <h3 class="text-uppercase">welcome</h3>
                            <h6 class="text-uppercase">complete your account set up.</h6>

                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%;">
                                    <span class="">65% </span>
                                </div>
                            </div>

                            <ul>
                                <li class="cancel">Connect your email account</li>
                                <li class="cancel">Review your email signature</li>
                                <li class="cancel">Set your Brokerage information</li>
                                <li class="include">Connect your calendar</li>
                                <li class="include">Install the mobile app</li>
                                <li class="include">Circle 25 Contacts</li>
                                <li class="cancel">Send your first message</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="widget">
                    <div class="widget-body">
                        <div id="fullcalendar"  class="sidebar-calender"></div>

                        <div class="calendar-info">
                            <div class="task-color yellow">
                                <h6 class="text-uppercase">Task</h6>
                            </div>

                            <div class="task-color event">
                                <h6 class="text-uppercase">Event</h6>
                            </div>	

                            <div class="task-color appointment">
                                <h6 class="text-uppercase">Appointment</h6>
                            </div>

                            <div class="task-color overdue">
                                <h6 class="text-uppercase">Overdue</h6>
                            </div>	
                        </div>
                    </div>
                </div>


                <div class="widget">
                    <div id="dash2-flotchart-1" style="height: 320px;width: 100%"></div>							
                </div>
            </div>

        </div>
    </div>

    <div class="row">

    </div>



    <?php $this->load->view('todolist/particals/createTask'); ?>
    <?php $this->load->view('todolist/particals/createTemplate'); ?>
    <?php $this->load->view('todolist/particals/createTemplateTask'); ?>

</div>
</div>
<?php $this->load->view('components/footer');
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script>
<script src="<?php echo base_url() ?>app/controllers/ToDoListController.js"></script>
