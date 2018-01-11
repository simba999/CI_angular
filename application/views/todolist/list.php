<div ng-controller="ToDoListController" ng-cloak>
    <div class="row">
        <div class="col-sm-9 col-xs-12">
            <div class="widget">
                <div class="widget-body padding-0">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="daily-task">
                                <h3>to do list</h3>
                                    <div class="dropdown pull-right">
                                        <button href="#" class="dropdown-toggle btn btn-outline-secondary button-sm pull-right" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Add Template<span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li class="center-item">
                                                <button data-toggle="modal"  data-target="#createTemplate"  class="btn btn-outline-secondary" style="width: 100%;">Create Template</button>
                                            </li>
                                            <li class="center-item">
                                                <button data-toggle="modal"  data-target="#taskTemplate" class="btn btn-outline-secondary" style="width: 100%;">Task Template</button>
                                            </li>
                                        </ul>
                                    </div>
                                
                                <button data-toggle="modal"  data-target="#create-task"  class="btn btn-outline-secondary button-sm pull-right">Create Task</button>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="todolst">
                                <div class="table-responsive" >
                                    <table class="table">
                                        <tbody>
                                            <tr ng-repeat = "(taskTemplatekey, taskTemplate) in taskTemplates" >
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
                                                            <a href="<?php echo base_url();?>leads/viewDetails/{{taskTemplate.Id}}">
															<img ng-if = "taskTemplate.leadimage" src="<?php echo base_url() . UPLOAD_DIR . '/' . IMAGE . '/' . LEAD_IMAGE . '/'?>{{taskTemplate.leadimage}}"  alt=""/>
														   <img ng-if = "!taskTemplate.leadimage" src="<?php echo base_url() . ASSETS_DIR .'/no-image-avilable.jpg'?>"  alt=""/>
														   
															
															
															</a>
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
                                                                            <h6  bg-date="{{singelTask.DueDate}}"></h6> 
                                                                        </div>
																	</div>
                                                                </td>
															</tr>
															</table>
														
													</div>
												 </div>
														
														

                                                </td>
                                                <td class="scheldt">
                                                    <h6 class="date closed"  enable-default="1" bg-date="{{taskTemplate.DueDate}}" ></h6>
                                                </td>
                                                <td width="3%">
                                                    <div class="avatar avatar-circle m-r-0">
                                                        <img src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{taskTemplate.memberimage}}" alt="">
                                                    </div>
                                                </td>
                                                <td class="task-actions">																			
                                                    <span class="dropdown">
                                                        <!-- <a href="javascript:;" class="dropdown-toggle" type="" id="dropdownElipsis" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a> -->
                                                        <div class="dropdown-menu media-list float-right animated scaleInDownLeft" aria-labelledby="dropdownElipsis">
															<a class="dropdown-item" href="">Contact Profile</a> 
                                                            <!--<a class="dropdown-item" href="javascript:;">Hot Lead</a>
                                                            <a class="dropdown-item" href="javascript:;">Contact Profile</a> 
                                                            <a class="dropdown-item" href="javascript:;">Complete Task</a>-->
                                                        </div>
                                                    </span>	
                                                    <a ng-click="deleteTask($event)" taskId = {{taskTemplate.Id}} href="javascript:;"><i class="fa fa-trash-o"></i></a>
                                                    <a href="javascript:;" data-toggle="modal" data-target="#myModal"><img src="assets/global/images/snooze.png"></a>		
                                                    <a ng-click="editTaskData($event)" href="javascript:;" taskId = {{taskTemplate.Id}} data-toggle="modal" data-target="#create-task"><i class="fa fa-pencil"></i></a>
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
				<!-- Completed Task -->
			<div class="widget">
                <div class="widget-body padding-0">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="daily-task">
                                <h3>Completed Task</h3>
                              </div>
                        </div>
                    </div>
					 <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="todolst">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr ng-repeat = "(taskTemplatekey, taskTemplate) in completedTaskTemplates">
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
														<a  ng-if="taskTemplatekey.split('-')[0] !=  'notemplate'" class="demobtn" role="button" data-toggle="collapse" href="#completed{{taskTemplatekey.split('-')[0]}}" aria-expanded="false" aria-controls="{{taskTemplatekey.split('-')[0]}}">
                                                            <i class="more-less fa fa-chevron-up"></i>
                                                        </a>
                                                        <div class="avatar avatar-circle">
                                                            <a href="<?php echo base_url();?>leads/viewDetails/{{taskTemplate.Id}}"><img ng-if = "taskTemplate.leadimage" src="<?php echo base_url() . UPLOAD_DIR . '/' . IMAGE . '/' . LEAD_IMAGE . '/'?>{{taskTemplate.leadimage}}"  alt=""/>
														   <img ng-if = "!taskTemplate.leadimage" src="<?php echo base_url() . ASSETS_DIR .'/no-image-avilable.jpg'?>"  alt=""/></a>
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
														
													<div class="collapse" id="completed{{taskTemplatekey.split('-')[0]}}">
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
                                                                            <h6 bg-date="{{singelTask.DueDate}}"> </h6>
                                                                        </div>
																	</div>
                                                                </td>
															</tr>
															</table>
														
													</div>
												 </div>
														
														

                                                </td>
                                                <td class="scheldt">
                                                    <h6 class="date closed" data-provide="datepicker" bg-date="{{taskTemplate.DueDate}}"></h6>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php $this->load->view('components/rightsidebar'); 	?>
	</div>
	
    <?php $this->load->view('todolist/particals/createTask'); ?>
    <?php $this->load->view('todolist/particals/createTemplate'); ?>
    <?php $this->load->view('todolist/particals/createTemplateTask'); ?>

</div>
<?php $this->load->view('components/footer');
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script>
<script src="<?php echo base_url() ?>app/controllers/ToDoListController.js"></script>
<script>
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
</script>
