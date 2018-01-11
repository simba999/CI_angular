<div class="modal-body">
<div class="modal snooze modalImportCsv" id="import-csv-lead"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modalDialogImportCsv" >
       <div class="modal-content popUpBoxSpaceImport">
        	<div class="modal-header">
              <h4 class="modal-title popUpBoxSpaceImportTitle" id="myModalLabel">IMPORT CONTACTS</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
	        <div class="modal-body">
		        <div class="container">
		            <div class="row">
		                <div class="col-xs-12 col-sm-12 col-md-12">
		            	    <form class="nice nomargin ImportFontSet" id="import_contacts_form_CSV" name="addCsvContact"  enctype="multipart/form-data" method="POST" role="form" ng-submit="importContact()">
								<input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="WAezt923TfKZl36pUfLkSqF+O/AgLzga5TCIpKW7c02tXlkUM3zYahkcPFJWRhaVqD5wdx/FfgoU/8hKMnblSw==">
									<p class="TextOtherIm">
									Choose the containing contacts you want to import. In the next step, you’ll be able to map each column to a field in Agent Cloud. <!-- <span class="colorYelloText">Click for tips and tricks for importing your contacts </span> -->
									</p>
									<p class="MarginTextMiddel">
										Note: File must be a CSV file with first row as column titles. <!-- <span style="color:#f0c400;">Download Template</span> -->
										<a href="<?php echo base_url() . 'leads.csv'; ?>" title="Download sample template" class="colorYelloTextDownTemp" download>
										Download template
										</a>
									</p>
			<!-- Upload CSV : Start-->
<!-- ###################### demo start -->
			    <div class="imp-contact forBrowseBtn">
			    	<label class="custom-file UploadCsvLable">
			    		<input valid-file ng-model="form.contactCsv" class="custom-file-input" onchange="angular.element(this).scope().uploadCsv(this.files)" id="contactCsv" type="file" required>
			    		<span class="custom-file-control borderForUploadCsv"><img src="<?php echo base_url(); ?>assets/global/images/upload_browsee.png" alt="image not avail"/>&nbsp;&nbsp;&nbsp;<!-- <span id="chooseFileId"> --><lable class="ChooseFileText">Choose File...</lable><label class="fileNameGet"></label><!-- </span> --></span>
			    	</label>
			    		<p ng-show="addCsvContact.contactCsv.$error.pattern" class="help-block">
									  Must contain one lower &amp; uppercase letter, and one non-alpha character (a number or a symbol.)
						</p> 
			    </div>	
			    <br>
<!-- ##################### demo : End -->
									<!-- <img src="<?php //echo base_url(); ?>assets/global/images/upload_browsee.png" alt="image not avail"/> -->
									<!-- <input valid-file ng-model="form.contactCsv" class="form-control input-lg" onchange="angular.element(this).scope().uploadCsv(this.files)" type="file" name="contactCsv" id="contactCsv" required class="browse btn input-lg" type="button" value="BROWSE"> -->
									
									<p>Acceptable file types: CSV</p>
									<p>
									<button id="SuccessBtnYelloAllId" type="submit" ng-disabled="addCsvContact.$invalid" class="btn btn-yellow">SUBMIT</button>
									<button type="button" class="btn btn-yellow CancelBtnYelloBorWhietAll" data-dismiss="modal">CANCEL</button>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            //alert('The file "' + fileName +  '" has been selected.');
            $( ".ChooseFileText" ).hide();
            $(".fileNameGet").text(fileName);
        });
    });
</script>
<?php $this->load->view('contact/partial/successMsgImport');?>
