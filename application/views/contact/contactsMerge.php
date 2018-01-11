<!-- ################################# Demo data for merge contact page  :Start  ######################### -->
<div class="site-content">                              
                
                <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="widget">
							<div class="widget-body">
								<div class="row">
									<div class="col-sm-4">
										<button class="btn btn-outline-secondary button-sm text-uppercase">Yes all</button>
										<button class="btn btn-outline-secondary button-sm text-uppercase">No all</button>
									</div>
									<div class = "col-sm-8">
										<a href="<?php echo base_url();?>googleoauth" id="importGmailConBtn" class="btn btn-yellow text-uppercase">Import From Gmail</a>
										
										<button class="btn btn-yellow text-uppercase pull-right" data-toggle="modal" data-target="#look-contact" onclick="javascript:SaveContact();">Confirm Selected</button>
									</div>
								</div>
								
								<hr/>
								
								<div class="row">
									<div class="col-sm-12">
										<table class="table merging-contacts">
											<thead>
												<tr>
													<th colspan="2">Suggested Contacts</th>
													<th colspan="3">Merge with</th>	
												</tr>
											</thead>
											<tbody>
											<?php 
											//foreach ($contact_Data as $rowGmailContact) {
											/*pr($ContactMember);
											pr($suggetedContact);*/
											$i = 0;
											foreach ($ContactMember as $rowContact) {
											?>
												<tr>
													<td class="widthOFBtnYesNo">
														<?php if(isset($suggetedContact[$i]->Email))
														{ ?>

															<button class="btn btn-outline-secondary button-sm text-uppercase widthOFBtnOnlyYN" onclick='javascript:FindMatchInLocalContact(<?php echo json_encode($suggetedContact[$i],JSON_FORCE_OBJECT);?>);'>Yes</button>
															<button class="btn btn-outline-secondary button-sm text-uppercase widthOFBtnOnlyYN" onclick='javascript:FindMatchInLocalContact(0);'>No</button>
														<?php } ?>
													</td>
													<td class="mail FixWidthColForEmail">
													<?php if(isset($suggetedContact[$i]->Email))
														{ ?>
														<a href="javascript:;">
														<?php echo isset($suggetedContact[$i]->Email) ? $suggetedContact[$i]->Email : ""; ?>
														<!-- MichaelLucas@gmail.com --> <i class="fa fa-pencil"></i></a>
														<?php } ?>
													</td>
													<td class="profile-name FixWidthCol">
														<div class="media align-items-center">
																<!--<div class="avatar avatar-circle">
																	<img src="assets/global/images/Michael Lucas.png" alt=""> 
																</div>-->
																<div class="media-body">
																	<h5 class="media-heading">
																		<a href="javascript:void(0)"><?php echo $rowContact->ContactUserName;?>
																			<!-- Michael Lucas -->
																		</a>
																	</h5><small class="media-meta">
																	<?php echo $rowContact->EmailLead;?>
																	<!-- MichaelLucas@gmail.com --></small>
																</div>
																
															</div>
													</td>
												</tr>
												<?php 
													$i++;
												} 
												//}?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					
					
				</div>					
</div>
<script type="text/javascript">
    document.getElementById("importGmailConBtn").onclick = function () {
    location.href = "https://accounts.google.com/o/oauth2/auth?client_id=329695175100-ujsq41kpgaathhetvigfdhgsa09vkg6f.apps.googleusercontent.com&redirect_uri=<?php echo base_url();?>OAuth&scope=https://www.google.com/m8/feeds/&response_type=code";
    };
</script>
<script type="text/javascript">
	"use strict";
	/*init functions*/	 
	var mergedContacts = JSON.parse(localStorage.mergedContacts || null) || {};
	var localContacts = <?php echo json_encode($ContactMember);?>;
	// not usefull
	var suggetedContacts = <?php echo json_encode($suggetedContact);?>;

	SaveInLocalStorage({});
	/*core functions for merge code*/ 
	function FindMatchInLocalContact($suggetedContact){
		if($suggetedContact){
			/*console.log(arguments[0]);*/
			var firstName,emailPrefix;
			firstName = $suggetedContact.FirstName
			emailPrefix = $suggetedContact.Email.split("@")[0];
			var matched = FindTerms(firstName,emailPrefix);
			MergeContact(matched,$suggetedContact);
		}

		function FindTerms($firstName,$emailPrefix){
			/*console.log(sanitizeMatchTerms($firstName),$emailPrefix);*/
			var firstName = $firstName;
			var emailPrefix = $emailPrefix;
			var foundMatchs = localContacts.filter(function(contact){
				var ContactFirstName = sanitizeMatchTerms(contact.ContactUserName);
				var firstName = sanitizeMatchTerms(firstName);
				var EmailLead = contact.EmailLead.split("@")[0];
				var emailPrefix = emailPrefix;
				/*console.log($firstName + '== '+ ContactFirstName + '|| '+ $emailPrefix + '== '+ EmailLead);*/
				if($firstName == ContactFirstName || $emailPrefix == EmailLead){
					/*console.log($firstName,$emailPrefix,contact);*/
					return true;
				}
			});
			return foundMatchs;


			function sanitizeMatchTerms($input){
				if($input){
					return $input.trim().replace(/ /gi,'_').toLowerCase();
				}
			}
		}
	}
	function MergeContact(matched,$suggetedContact){
		/*console.log(mergedContacts,matched,$suggetedContact);*/
		var loopTimes = matched.length;
		for(var i = 0; i < loopTimes; i++){
			if(mergedContacts[matched[i].Id]){
				mergedContacts[matched[i].Id].push($suggetedContact);
			} else{
				mergedContacts[matched[i].Id] = [$suggetedContact];
			}
		}
		/*console.log(mergedContacts);*/
		SaveInLocalStorage(mergedContacts);
	}
	function SaveContact(){
		if(Object.keys(mergedContacts).length > 0){
			$.ajax({
				type: "POST",
				url: base_url + "contact/savecontactsmerge",
				data: mergedContacts,
				dataType: "json",
				success: function(data) {
					if(data.status){
						//alert('success');
						alertify.alert("Merge contact is completed successfully.").setHeader('<em>Confirmation</em>');
					} else {
						//alert('error');
						alertify.alert("Error").setHeader('<em>Confirmation</em>');
					} 
				},
				error: function(){
					//alert('error');	
					alertify.alert("There is some error please try again letter.").setHeader('<em>Confirmation</em>');
				}
			});
		} else {
			//alert('No Merge data found!');
			alertify.alert("No Merge data found!").setHeader('<em>Confirmation</em>');
			//console.info("No Merge data found!");
		}
	}
	function SaveInLocalStorage(data){
		localStorage.mergedContacts = JSON.stringify(data);
	}
</script>
<!-- ################################# Demo data for merge contact page  : End   ################################ -->

<?php $this->load->view('components/footer'); ?>	