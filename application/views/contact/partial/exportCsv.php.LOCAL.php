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
				                <form class="nice nomargin FormTextSetExport" name="formForImportCsv" id="import_contacts_form_CSV" id="exportPDFBtn" accept-charset="UTF-8" method="post" enctype="multipart/form-data">
			            	    <input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="WAezt923TfKZl36pUfLkSqF+O/AgLzga5TCIpKW7c02tXlkUM3zYahkcPFJWRhaVqD5wdx/FfgoU/8hKMnblSw==">
									<p  class="TextMiddleExport">
									Choose the contacts you would like to export:
									</p>
									<p class="marginExport">
										  <input type="radio" id="export_contact_All_show_me" name="ExportChoose" value="" class="radioExport"> All contacts<br>
										  <input type="radio" id="export_contact_from_search_show_me" name="ExportChoose" value="" class="radioExport"> Just this search<br>
										  <input type="radio" id="export_contact_from_circle_watch_me" name="ExportChoose" value="FromACircle" class="radioExport"> From a Circle 
										  <select id="export_contact_from_circle_show_me" class="form-control TextstyleExport">									  
										  <?php foreach ($getCircle as $Circle) { ?>
											<option><?php echo $Circle->Name;?></option>
										  <?php } ?>	
											</select>
									</p>
									<br>
									<p>
									<button id="exportPDFBtn" class="btn btn-yellow text-uppercase ExportBtn">Export</button> 
									&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="button" class="btn btn-yellow CancelBtnExport" data-dismiss="modal">CANCEL</button>
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