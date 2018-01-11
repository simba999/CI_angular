<div class="container">
	<div class="row">
		<h3 style="margin: 30px 0 20px">
		Import Contacts
		</h3>
	</div>
	<div class="row">
		<form class="nice nomargin" name="formForImportCsv" id="import_contacts_form_CSV" action="readCsv" accept-charset="UTF-8" method="post" enctype="multipart/form-data" >

		<input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="WAezt923TfKZl36pUfLkSqF+O/AgLzga5TCIpKW7c02tXlkUM3zYahkcPFJWRhaVqD5wdx/FfgoU/8hKMnblSw==">

			<p style="margin-bottom: 10px;">
			Choose the file containing the contacts you want to import. 
			</p>
			<p style="margin-bottom: 10px;">
			In the next step, you'll be able to map each column to a field in Contactually.
			</p>
				<p style="margin-bottom: 25px;">
					Note: File must be a CSV file with first row as column titles.
					<a href="<?php echo base_url().'leads.csv';?>" title="Download sample template" download>
					Download template
					</a>
				</p>
				<p style="margin-bottom: 25px;">
					<span class="chosen-file"></span>
				<!-- Choose file -->
					<input type="file" name="contactcsv" id="Uploadfile">
					<!-- <input type="hidden" name="name" id="name"> -->
					
				</p>
			<p>
			<input id="uploadBtn" class="uploadBtnClass" type="submit" name="Submit" value="Upload" data-disable-with="Submitting..." disabled>
			<a class="v4-button" href="<?php echo base_url()?>contact/import">Cancel</a>
			</p>
		</form>
	</div>
</div>
<?php $this->load->view('components/footer'); ?>

<!-- <script src="<?php //echo base_url() ?>assets/examples/js/contacts/custome.js"></script> -->

<script>
jQuery(document).ready(function(){
	$(document).on("change",'#Uploadfile',function(){
    		if ($(this).val()) {
                    $('#uploadBtn').attr('disabled',false);
                }
   	}) ;
});
</script>