 <div class="modal snooze" id="addLeadDocument" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Lead Document</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form  enctype="multipart/form-data" method="POST"  name="addDocument" role="form" ng-submit="saveLeadDocument()">
					
						<div class="row">
							<input ng-init="form.adddocument.leadId =<?php echo $leadDetails->Id; ?>"  ng-value ="{{<?php echo $leadDetails->Id; ?>}}" type="hidden" name="leadId" id="leadId" ng-model="form.adddocument.leadId" />
						<div class="col-sm-12">
							<label>Select Document</label>
							<div class="form-group">
                                <input  multiple  ng-model="form.adddocument.documents"  onchange="angular.element(this).scope().uploadDocuments(this.files)" type="file"  />
							
							</div>
						</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<button type="submit" ng-disabled="addDocument.$invalid" class="btn btn-yellow btn-block">Add Document</button>
							</div>
							<div class="col-sm-6">
								<button data-dismiss="modal" aria-label="Close"  class="btn btn-yellow-outline btn-block">Cancel</button>
							</div>
						</div>
					
				</form>
			</div>

		</div>

	</div>
</div>