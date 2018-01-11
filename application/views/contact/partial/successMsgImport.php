<div class="modal-body">
	<div class="modal snooze sucessImportModel modalImportCsvMsg" id="import-csv-success"  role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog modalDialogImportCsvMsg" >
	       <div class="modal-content popUpBoxSpaceImportMsg">
		        <div class="modal-body">
			        <div class="container">
			            <div class="row">
			                <div class="col-xs-12 col-sm-12 col-md-12">
			            	    <form class="nice nomargin ImportFontSetSuccMsg" name="formForImportCsv" id="import_contacts_form_CSV" action="<?php echo base_url() ?>contact" accept-charset="UTF-8" method="post" enctype="multipart/form-data">
									<input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="WAezt923TfKZl36pUfLkSqF+O/AgLzga5TCIpKW7c02tXlkUM3zYahkcPFJWRhaVqD5wdx/FfgoU/8hKMnblSw==">
										<img src="<?php echo base_url(); ?>assets/global/images/successImport.png" alt="image not avail"/>
											<p class="successMsgImport">
												SUCCESS!
											</p>
											<p class="FontTextSuccMsgImp">
											import has been succefully uploaded</p>
										<p>
										<input id="checkMailBtn" class="checkMailBtnClass btn btn-yellow SuccessBtnYelloAll" type="submit" name="Submit" value="CHECK MAIL" data-disable-with="Submitting...">
										<button type="button" ng-click="returnToImport()" class="btn btn-yellow CancelBtnYelloBorWhietAll" data-dismiss="modal">RETURN</button>
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