<div class="modal-body">
	<div class="modal snooze sucessImportModel modalImportCsvMsg" id="email-csv-success"  role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog modalDialogImportCsvMsg" >
	       <div class="modal-content popUpBoxSpaceImportMsg popUpBoxSpaceImportMsgIMG" background="<?php echo base_url(); ?>assets/global/images/successImport.png">
		        <div class="modal-body">
			        <div class="container">
			            <div class="row">
			                <div class="col-xs-12 col-sm-12 col-md-12">
			            	    <form class="nice nomargin ImportFontSetSuccMsg" name="formForImportCsv" id="import_contacts_form_CSV" action="<?php echo base_url();?>" accept-charset="UTF-8" method="post" enctype="multipart/form-data">
										<img src="<?php echo base_url(); ?>assets/global/images/successImport.png" alt="image not avail"/>
										<p class="successMsgImport">
											Success!
										</p>
										<p>
										import has been succefully uploaded</p>
										<p>
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