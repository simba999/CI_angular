  <div class="modal snooze" id="household-contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">House Hold Contacts</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<form method="POST" name="addHouseHoldContact" role="form" ng-submit="saveHouseHoldContact()">
						<div ng-if="relatedLeadsDropdown.length > 0"> 
							<div class="row">
								<input ng-init="form.houseHold.leadId =<?php echo $leadDetails->Id; ?>" ng-value ="{{<?php echo $leadDetails->Id; ?>}}" type="hidden" name="leadId" id="leadId" ng-model="form.houseHold.leadId" />
								<div class="col-sm-12">
									<div class="form-group">
										<select ng-model = "form.houseHold.houseHoldLead"  style="width: 100%" class="custom-select form-control" id="houseHoldLead" name="houseHoldLead" required>
											<option ng-repeat ="relatedLeads in relatedLeadsDropdown" value="{{relatedLeads.leadId}}">{{relatedLeads.leadUserName}}</option>	
										</select>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<input  ng-model="form.houseHold.houseHoldRelationTitle" type='text' class="form-control" name="houseHoldRelationTitle" placeholder="Relation" id="houseHoldRelationTitle" required />
										<p ng-show="addHouseHoldContact.houseHoldRelationTitle.$invalid && !addHouseHoldContact.houseHoldRelationTitle.$pristine" class="help-block">Title is required.</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<button type="submit" ng-disabled="addHouseHoldContact.$invalid" class="btn btn-yellow btn-block">Add Household Contact</button>
								</div>
								<div class="col-sm-6">
									<button data-dismiss="modal" aria-label="Close"  class="btn btn-yellow-outline btn-block">Cancel</button>
								</div>
							</div>
						</div>
						<div  ng-if="relatedLeadsDropdown.length == 0">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<h3>No Leads Available </h3>
								</div>
							</div>
						</div>
					</form>
				</div>

			</div>

		</div>
</div>