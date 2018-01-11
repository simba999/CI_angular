<div class="modal snooze" id="create-task" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" >
        <div class="modal-content createTemplateBoxBorder">
             <div class="modal-header">
                    <h4 ng-if="editTask==''" class="modal-title text-uppercase" id="myModalLabel">Create a Task</h4>
              <h4 ng-if="editTask=='edit'" class="modal-title text-uppercase" id="myModalLabel">Edit Task</h4>
                    
              
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            <form method="POST" name="addTask" role="form" ng-submit="saveTask()">
                
               
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong>Task Title<span class="required_span_error">*</span></strong>
                                <input value="{{editTaskId}}" type="hidden" name="taskId" id="taskId" ng-model="form.taskId" />
                                <div class="form-group">
                                    <input ng-model="form.taskTitle" type="text"  name="taskTitle" class="form-control" value="{{reminderTaskTitle}}"  ng-value= "{{reminderTaskTitle}}" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong>Assign To Lead</strong>
                                <div class="form-group">
                                    <select class="custom-select form-control" name="assignLead" id= "assignLead" ng-model="form.assignLead" required>
                                        <option ng-repeat="leads in leadDropDown" value={{leads.Id}}>{{leads.leadUserName}} </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong>Description</strong>
                                <div class="form-group">
                                    <textarea rows = 5 cols = 10 ng-model = "form.taskDescription" id ="taskDescription" name = "taskDescription" class="form-control">{{reminderTaskDescription}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-4">
                                <strong>Due Date<span class="required_span_error">*</span></strong>
                                <div class="form-group">
                                    <div class='input-group date' id='dueDatePicker'> 
                                        <input  ng-model="form.taskDueDate" type='text' class="form-control DueDateCtask" name="taskDueDate" placeholder="mm-dd-yyyy" id="taskDueDate" required />
                                        <span class="input-group-addon iconDueDate">
                                            <span class="fa fa-calendar-check-o"></span>
                                        </span>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-7 col-md-8">
                                <strong>Assign To<span class="required_span_error">*</span></strong>
                                <div class="form-group">
                                    <select class="custom-select form-control" name="assignUser" id= "assignUser" ng-model="form.assignUser" required>
                                        <option ng-repeat="assign in assignUsers" value={{assign.Id}}>{{assign.FirstName}} {{assign.LastName}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button  type="submit" ng-disabled="addTask.$invalid" class="btn btn-yellow">Create</button>
                        
                        <button type="button" class="btn btn-yellow-outline" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>