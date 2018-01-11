<div class="modal" id="createTemplate" tabindex="-1" role="dialog" aria-labelledby="createTemplateModalLabel">
    <div class="modal-dialog" role="document" >
        <div class="modal-content createTemplateBoxBorder">
            <div class="modal-header">
                <h4 class="modal-title TitleTextSizeCTemplate text-uppercase" id="createTemplateModalLabel">Create Template</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form method="POST" name="createTemplate" role="form" ng-submit="saveTemplateTask()">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="col-form-label TextStyleTempTitle">Template Title</label>
                                <input ng-model= "form.templateTitle" type="text" id="" class="form-control" required>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input placeholder = "Task Title" type="text" name = "taskTitle[$index]" class="form-control" ng-model = "form.taskTitle[$index]" required>
                            </div>
                        </div>
                    </div>
                    <div class="taskTemplate" ng-repeat="taskElement in taskElements track by $index">
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="input-group"> 
                                                <input ng-model = "form.day[$index]" type='number' class="form-control noDaysToCTemp" name="day[$index]" placeholder="No. of days" id="day" required />
                                            </div> 
                                        </div>
                                        <div class="col-sm-9">
                                                <div ng-if = "$index >= 1" class="col-sm-2 deleteBtnForAddTempAss">
                                                    <!-- <div class="form-group">									
                                                        <div class="col-sm-12"> -->
                                                            <button  ng-click='removeElement($index)' type="button" class="btn button btn-danger removeDangerBtnAssCT"><i class="fa fa-trash-o"></i></button>
                                                        <!-- </div>
                                                    </div> -->
                                                </div>
                                            <input placeholder = "Assign to" type="text" name = "taskTitle[$index]" class="form-control" ng-model = "form.taskTitle[$index]" required>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="offset-md-4 col-md-7">
                            <div class="form-group">
                                <button  ng-click='addTasksElement()' type="button" class="btn btn-skyblue-outline btn-block btnSizeForAddCTemp"><i class="fa fa-plus"></i>Add Task</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="submit"  class="btn btn-yellow createOnCTemp">Create</button>
                        </div>
                        <div class="col-sm-5">
                            <button type="button" class="btn btn-yellow-outline cancelOnCTemp" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>                        
                </form>
            </div>

        </div>

    </div>
</div>