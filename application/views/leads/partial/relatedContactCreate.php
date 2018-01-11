   <div class="modal snooze" id="create-relation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                <div class="modal-dialog relatedContact" role="document" >
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="myModalLabel">Create Related Contacts</h4>
                                                                            <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!--<form method="POST" name="addRelation" role="form" ng-submit="saveRelatedContact()">-->
                                                                                <div> 
                                                                                    <div class="searchArea">
                                                                                        <input value="<?php echo $leadDetails->Id; ?>" required   ng-value ="{{<?php echo $leadDetails->Id; ?>}}" type="hidden" name="leadId" id="leadId" ng-model="form.leadId" />
                                                                                        <!--<div class="col-sm-12">-->
																						<table class="table table-contact-list leadTable">
																						<tbody>
																						<tr>
																						<td width="72.5%">
                                                                                            <div class="form-group">	
																								<div class="leadSearchControls">
																										<input type="text" class="form-control" id="searchContact" name="searchContact"/>
																								</div>
																						</td>
																						<td width="27.5%">
																							<div class="form-group">	
																									
																										<button ng-click="searchRelatedContact()" type="button" class="btn btn-success searchRelatedContact">Search</button>
																									
																							</div>
																						</td>	
                                                                                        </tr>
																						</table>
                                                                                        <!--</div>-->
                                                                                    </div>
																				</div>
																				<div class="relatedContactData"></div>
                                                                            <!--</form>-->
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>