<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/examples/css/contacts/jquery.dataTables.min.css"/>
<!-- <link rel="stylesheet" type="text/css" href="<?php //base_url()?>/assets/examples/css/contacts/jquery.dataTables.min.css"/> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/examples/css/contacts/buttons.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/examples/css/contacts/style.css"/>

<div ng-controller="ContactController">
 <div class="row">
					<div class="col-md-9 col-sm-12 col-xs-12">
						<div class="page-name">
							<div class="circle-head-lt">
								<h1>Leads</h1>
							</div>
							
							<div class="circle-head-rt">
								<div class="row contacts-filter">
									<div class="col-auto">
										<div class="custom-select-daily">
											<select class="form-control">
												<option>Assigned</option>
												<option>Assigned 1</option>
												<option>Assigned 2</option>
												<option>Assigned 3</option>
											</select>
										</div>
									</div>
									
									<div class="col-auto">
									<button class="btn btn-skyblue text-uppercase" data-toggle="modal" data-target="#create-lead"></i>Create Contact</button>
									</div>
									
									<div class="col-auto">
										<a href="<?php echo base_url()?>contact/import" class="btn btn-yellow text-uppercase" data-toggle="modal" data-target="#import-csv-lead">Import</a>

										
									</div>
									
									<div class="col-auto">
									<a href="<?php echo base_url()?>contact/import" class="btn btn-yellow text-uppercase" data-toggle="modal" data-target="#export-csv-lead">Export</a>
										<!-- <button id="exportPDFBtn" class="btn btn-yellow text-uppercase" data-toggle="modal" data-target="#export-csv-lead">Export</button> -->
									</div>
								</div>
							</div>
							
							<hr/>
							
							<!-- <div class="row contacts-search">
								<div class="col-6">									  
								  <div class="input-group mb-2 mb-sm-0">
									<div class="input-group-addon"><i class="fa fa-search"></i></div>
									<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search in Results">
								  </div>
								</div>
								
								<div class="col-auto">
									<div class="custom-select-daily">
										<select class="form-control">
											<option>Searches</option>
											<option>Searches 1</option>
											<option>Searches 2</option>
											<option>Searches 3</option>
										</select>
									</div>
								</div>
								
								<div class="col-auto">
									<div class="custom-select-daily">
										<select class="form-control">
											<option>Sort</option>
											<option>Sort 1</option>
											<option>Sort 2</option>
											<option>Sort 3</option>
										</select>
									</div>
								</div>
								
								<div class="col-auto">
									<nav aria-label="Page navigation example">
									</nav>
								</div>
							</div> -->	
							
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<table id="exampleForContactTbl" class="table table-bordered contact-list-table">
										<thead>
											<tr>
												<th>
													<div class="checkbox">
														<input type="checkbox" id="cb-01">
														<label for="cb-01"></label>
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
										<?php 

										/*var_dump($teamMembers);*/
										foreach($teamMembers as $ConMemData){ 

											?>
											<tr>
												<td>
													<div class="checkbox">
														<input type="checkbox" id="cb-01">
														<label for="cb-01"></label>
													</div>
												</td>
												<td class="text-center">
													<div class="avatar avatar-circle">
													<?php 
													if(empty($ConMemData->ProfileImage)){?>
														<img src="<?php echo base_url();?>assets/global/images/203.jpg" alt="image not avail"/>
													<?php } 
													else{ ?>
													<img src="<?php echo base_url().UPLOAD_DIR."/".IMAGE."/".LEAD_IMAGE_THUMB_PATH ."/".$ConMemData->ProfileImage;?>" alt="image not avail"/>
													<?php 
													}
													?>
													</div>
													<div class="media-body">
														<h5 class="media-heading">
														<?php echo $ConMemData->contactName; ?>
															<a href="javascript:void(0)"><i class="fa fa-pencil"></i></a>
														</h5>														
													</div>
												</td>
												<td>
													<span><?php echo str_replace(',', '<br>', $ConMemData->circlesAll); ?>
													</span>
												</td>
												<td>

												<!--<div class="custom-select-daily">
													<select class="form-control"> -->
												<select class="form-control BoxSizeForAssign AssignForWidth">
															<option value="Assign To">Assign To</option>
															<option value="Assign 1">Assign 1</option>
															<option value="Assign 2">Assign 2</option>
															<option value="Assign 3">Assign 3</option>
												</select>
												<!-- </select>
													 </div>  -->
												</td>
												<td>
													<span><?php echo date("d/m/Y",strtotime($ConMemData->CreatedAt)); ?></span>

												</td>
												<!-- <td>
													<span>tags<?php //echo $ConMemData->tagsName;?></span>
												</td> -->
												<td>
												<a onclick="displayEmail('<?php echo $ConMemData->Email;?>')"><i class="fa fa-envelope"></i></a>
												<a onclick="displayDescription('<?php echo $ConMemData->contactTitle;?>')"><i class="fa fa-comment"></i></a>
												<a onclick="displayPhone('<?php echo $ConMemData->PhoneNo;?>')"><i class="fa fa-phone"></i></a>
												<?php
												//echo '<script>alert("You Have Successfully updated this Record!");</script>';?>
												</td>												
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							
						</div>
					</div>

					
					
					<div class="col-md-3 col-sm-12 col-xs-12">
						<div class="sidebar-main filters">
							<div class="widget">
								<div class="widget-body">
									<div class="">
										<h2 class="text-uppercase filter-title">filters</h2>
									</div>
									
									<div class="baskets">
										<div class="row">
											<div class="col-sm-12">
												<h3 class="">Baskets</h3>
												<a class="pull-right" data-toggle="collapse" href="#basket-list" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down"></i></a>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-12">
												<div class="collapse" id="basket-list">
													<div class="input-group mb-2">
														<div class="input-group-addon"><i class="fa fa-search"></i></div>
														<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search in Baskets">
													</div>
												
													<div class="select-basket">
														<div class="checkbox" ng-repeat="circle in FilterData.circles">
															<input ng-change="changeCircle(circleindex, circle)" ng-true-value="{{circle.Id}}" type="checkbox" ng-model="circleindex" id="circle-{{circle.Id}}">
															<label for="circle-{{circle.Id}}">{{circle.Name}}</label>
														</div>
														
														
														<a href="javascript:;">Manage Baskets</a>
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
														<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search in Tags">
													</div>
													<div class="checkbox" ng-repeat="tag in FilterData.tags">
														<input ng-change="changeTags(tagindex, tag)" type="checkbox" ng-model="tagindex" id="tag-{{tag.TagTitle}}" > 
														<label  for="tag-{{tag.TagTitle}}">{{tag.TagTitle}}</label>
													</div>
													
													<span>You do not have any tags yet</span> <br/>	
													<a href="javascript:;">Manage Baskets</a>		
												</div>
											</div>
										</div>
									</div>
									
									<div class="deals status-sidebar">
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
									</div>
									
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
														<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search Teammates">
													</div>
													<div class="checkbox" ng-repeat="user in FilterData.AssignedUsers">
														<input ng-change="changeAssignedUsers(userindex, user)" ng-true-value="{{user.Id}}" type="checkbox" ng-model="userindex" id="user-{{user.Id}}">
														<label for="user-{{user.Id}}">{{user.UserName}}</label>
													</div>


													
												</div>
											</div>
										</div>
									</div>
									
									<div class="deals status-sidebar">
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
										</div>
									
									
								</div>
							</div>
						</div>
					</div>
</div>
</div>

<div ng-controller="DashboardController">
<?php $this->load->view('contact/partial/contactCreate'); ?>
<?php $this->load->view('contact/partial/importCsv'); ?>
<?php $this->load->view('contact/partial/exportCsv'); ?>
</div>

<?php $this->load->view('components/footer'); ?>

<script src="<?php echo base_url() ?>app/controllers/ContactController.js"></script>
<script src="<?php echo base_url() ?>app/controllers/DashboardController.js"></script>
<script src="<?php echo base_url() ?>assets/examples/js/contacts/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/examples/js/contacts/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/examples/js/contacts/buttons.flash.min.js"></script>
<script src="<?php echo base_url() ?>assets/examples/js/contacts/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/examples/js/contacts/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/examples/js/contacts/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/examples/js/contacts/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/examples/js/contacts/buttons.print.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>
-->

<script src="<?php echo base_url() ?>assets/examples/js/contacts/custome.js"></script>