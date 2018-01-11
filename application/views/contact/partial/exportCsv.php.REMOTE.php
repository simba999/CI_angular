<?php //var_dump($getCircle);
?>
<div class="modal-body">
	<div class="modal snooze modalExportCsv" id="export-csv-lead"  role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog modalDialogExportCsv" >
	       <div class="modal-content popUpBoxSpaceExport">
		       <div class="modal-header">
	              <h4 class="modal-title ExportTitle" id="myModalLabel">EXPORT CONTACTS</h4>
	               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	            </div>
		        <div class="modal-body">
			        <div class="container">
			            <div class="row">
			                <div class="col-xs-12 col-sm-12 col-md-12">
				                <form role="form" novalidate ng-submit="ExportToCSV($event)" class="nice nomargin FormTextSetExport" name="Export" accept-charset="UTF-8" method="post" enctype="multipart/form-data">
			            	    <input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="WAezt923TfKZl36pUfLkSqF+O/AgLzga5TCIpKW7c02tXlkUM3zYahkcPFJWRhaVqD5wdx/FfgoU/8hKMnblSw==">
									<p  class="TextMiddleExport">
									Choose the contacts you would like to export:
									</p>
									<p class="marginExport">
										  <input type="radio" id="export_contact_All_show_me" value="export_contact_All_show_me" ng-model="Export.ExportChoose" name="ExportChooses"  required   class="radioExport"> All contacts<br>
										  <input type="radio" id="export_contact_from_search_show_me" value="export_contact_from_search_show_me" ng-model="Export.ExportChoose" name="ExportChooses"  required   class="radioExport"> Just this search<br>
										  <input type="radio" id="export_contact_from_circle_watch_me" value="export_contact_from_circle_watch_me" ng-model="Export.ExportChoose" name="ExportChooses"  required   class="radioExport"> From a Circle 
										  	<span class="error-text-color" ng-show="Export.$submitted">
			                                    <span ng-show="Export.ExportChooses.$error.required">Choose the atleast one contacts type.</span>
			                             	</span>

											<select name="circlename" ng-required="Export.ExportChoose == 'export_contact_from_circle_watch_me'" ng-show="Export.ExportChoose == 'export_contact_from_circle_watch_me'" id="export_contact_from_circle_show_me" class="form-control BoxSizeForAssign AssignForWidth" 
											ng-model="Export.AssignedUserId" ng-options="circle.Id as circle.Name for circle in FilterData.circles">
        						            <option value="">Please select</option></select>
        						        	<span class="error-text-color" ng-show="Export.$submitted">
			                                    <span ng-show="Export.circlename.$touched && Export.circlename.$error.required">Please select circle.</span>
			                             	</span>


												
									</p>
									<br>
									<p>
									<button id="exportPDFBtn"  class="btn btn-yellow text-uppercase ExportBtn">Export</button> 
									&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="submit" class="btn btn-yellow CancelBtnExport" data-dismiss="modal">CANCEL</button>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
	        </div>
	    </div>
	</div>
</div>