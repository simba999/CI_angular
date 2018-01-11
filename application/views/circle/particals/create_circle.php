    
<!-- Modal -->
<div class="modal fade" id="create-circle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">		  
            <div class="modal-body">
                <div class="modal-header">
                    <h4 ng-if="editCircle == ''" class="modal-title" id="myModalLabel">Add Circle</h4>
                    <h4 ng-if="editCircle == 'edit'" class="modal-title" id="myModalLabel">Edit Circle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="media-body">
                    <form method="POST" name="createCircle" role="form" ng-submit="saveCircle()" id="createCircle">
                        <input value="{{editCircleId}}" type="hidden" name="circleId" id="circleId" ng-model="form.circleId" />
                        <div class="form-group" ng-class="{'has-error':createCircle.Name.$invalid && !createCircle.Name.$pristine }">
                            <span>Name:</span>

                            <input ng-model="form.Name" type="text"  name="Name" class="form-control"  required />

                            <p ng-show="createCircle.Name.$invalid && !createCircle.Name.$pristine" class="help-block">Circle Name is required.</p>
                        </div>
                        
                        <span>Color:</span>
                        <div class="form-group input-group" id="circlecolor"  ng-class="{'has-error':createCircle.color.$invalid && !createCircle.color.$pristine }">                            
                            
                                <input colorpicker="hex" ng-model="form.color"   type="text" name="color" class="form-control" required id="colorpicker" name ="colorpicker" />
                                <span class="input-group-addon"><i></i></span>
                            <p ng-show="createCircle.color.$invalid && !createCircle.color.$pristine" class="help-block">Color is required.</p>

                        </div>

                        <div class="form-group"  ng-class="{'has-error':createCircle.goal.$invalid && !createCircle.goal.$pristine }">
                            <span>Goal:</span>
                            <input ng-model="form.goal" type="text" name="goal" class="form-control" required />
                            <p ng-show="createCircle.goal.$invalid && !createCircle.goal.$pristine" class="help-block">Goal is required.</p>

                        </div>

						<div class="form-group">
							<div class="text"  ng-class="{'has-error':createCircle.reminder.$invalid && !createCircle.reminder.$pristine }">
								<span>Reminder (In Days):</span>
								<input placeholder = "Days" ng-model="form.reminder" type="number"  name="reminder" class="form-control" min="0" required />
								<p ng-show="createCircle.reminder.$invalid && !createCircle.reminder.$pristine" class="help-block">Reminder is required.</p>
							</div>
						</div>

                        
                            <button type="submit" ng-disabled="createCircle.$invalid" class="btn btn-yellow">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        
                    </form>
                </div>			
            </div>		  
        </div>
    </div>
</div>
<!-- Modal -->
<style>
.dayControl .text {
    width: 50%;
}
</style>