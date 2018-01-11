<div class="modal" id="taskTemplate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" >
        <div class="modal-content createTemplateBoxBorder">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase" id="myModalLabel">Task Template</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form method="POST" name="addTaskTemplate" role="form" ng-submit="saveAssignTemplateTask()">

                    <div class="modal-body mainBodyForCTTask">
                        <div class="container mainConBorderForCTTask">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Choose Template
                                        <span class="required_span_error">*</span>
                                    </strong>
                                    <div class="form-group">

                                        <select type="hidden" style="width: 100%" ng-required="true" ui-select2 ="select2Options" multiple="multiple" class="custom-select form-control select2-option" name="selectTemplate" id= "selectTemplate" ng-model="form.selectTemplate"  >
                                            <option  ng-repeat="template in templateList" value={{template.Id}}>{{template.Title}}</option>	
                                        </select> 

                                            <!-- <select class="custom-select form-control" multiple name="selectTemplate" id= "selectTemplate" ng-model="form.selectTemplate">
                                                <option ng-repeat="template in templateList track by $index" value={{template.Id}}>{{template.Title}}</option>
                                            </select> -->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Assign Lead
                                        <span class="required_span_error">*</span>
                                    </strong>
                                    <div class="form-group">
                                        <select class="custom-select form-control" name="selectLead" id= "selectLead" ng-model="form.selectLead">
                                            <option ng-repeat="leads in leadDropDown" value={{leads.Id}}>{{leads.leadUserName}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Assign Member
                                        <span class="required_span_error">*</span>
                                    </strong>
                                    <div class="form-group">
                                        <select class="custom-select form-control" name="selectAssign" id= "selectAssign" ng-model="form.selectAssign">
                                            <option ng-repeat="assign in assignUsers" value={{assign.Id}}>{{assign.FirstName}} {{assign.LastName}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Start Date<span class="required_span_error">*</span></strong>
                                    <div class="form-group">
                                        <div class='input-group date' id='taskdeadlineDatePicker'>
                                            <input  ng-model="form.taskdeadline" type='text' class="form-control " name="taskdeadline" placeholder="yyyy-mm-dd" id="taskdeadline" />
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar-check-o"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <!-- <button type="submit"  class="btn btn-yellow createOnCTemp">Create</button> -->
                                    <button type="submit" ng-disabled="addTaskTemplate.$invalid" class="btn btn-yellow">Assign Template</button>
                                </div>
                                <div class="col-sm-4">
                                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
                                    <button type="button" class="btn btn-yellow-outline cancelOnCTemp" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>       
                            

                        </div>
                    </div>
                </form>


            </div>

        </div>

    </div>
</div>