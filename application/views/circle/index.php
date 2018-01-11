<div ng-controller="CircleController">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="page-name">
                <div class="circle-head-lt">
                    <h1>Circle</h1>
                </div>

                <div class="circle-head-rt">
                    <div class="row">
                       <!-- <div class="col-auto">
                            <a class="help-circle" href="javascript:;">
                                Help ?
                            </a>
                        </div>-->

                        <div class="col-auto filter-circle">
										<div class="input-group mb-2 mb-sm-0">											
											<input ng-keyup ="searchCircle()"  type="text" class="form-control" id="serachCircleText" placeholder="Search">
											<span ng-click ="searchCircle()" class="input-group-addon"><i class="fa fa-search"></i></span>
										</div>
									</div>
									

                        <div class="col-auto">
                            <button  ng-click = "changeEditMode()"class="btn btn-yellow text-uppercase button-sm" data-toggle="modal" data-target="#create-circle"> Create Circle
                            </button>

                        </div>
                    </div>
                </div>						
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 lead-cycle-main" ng-repeat="circle in circles">
            <div class="widget">
                <div class="widget-body">
                    <div class="media lead-cycle">
                        <div class="avatar avatar-circle" href="javascript:;" ng-click="editCircleData($event)"  circleId = {{circle.Id}} data-toggle="modal" data-target="#create-circle" style="cursor: pointer;">
                            <span class="circle-lead" style="background:{{circle.Color}}">{{circle.totalLead}}</span>
                        </div>
                        <div class="media-body">
                            <div class="pull-left" href="javascript:;" ng-click="editCircleData($event)"  circleId = {{circle.Id}} data-toggle="modal" data-target="#create-circle" style="cursor: pointer;">
                                <h6>
                                    <a href="javascript:void(0)" class="" >{{circle.Name}}</a>
                                    <!--<a href="javascript:;" ng-click="editCircleData($event)"  circleId = {{circle.Id}} data-toggle="modal" data-target="#create-circle" ><i class="fa fa-pencil" ></i></a>
                                    <a href="javascript:;" ng-click="deleteCircle($event)" circleId = {{circle.Id}} ><i class="fa fa-trash-o"></i>
                                    </a> -->
                                </h6>
                                <small class="text-muted">{{circle.Goal}}</small>
								
                            </div>
							 
                            <div class="lead-cycle-circle">
                               <span class="reminder"><strong>Reminder:</strong>{{circle.ReminderDay}} days</span>
								<a href="javascript:;" ng-click="editCircleData($event)"  circleId = {{circle.Id}} data-toggle="modal" data-target="#create-circle" ><i class="fa fa-pencil" ></i>
								</a>
                                <a href="javascript:;" ng-click="deleteCircle($event)" circleId = {{circle.Id}} ><i class="fa fa-trash-o"></i>
                                 </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php $this->load->view('circle/particals/create_circle'); ?>
</div>





</div>
<?php $this->load->view('components/footer'); ?>
 <script src="<?php echo base_url() ?>app/controllers/CircleController.js"></script>
<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>

<script>
    $('.modal').on('hidden.bs.modal', function () {

        $(this).find('form')[0].reset();
    });


</script>