<!-- Modal -->
<div class="modal fade sending-mail" id="create-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content snoozeZero">		  
            <div class="modal-body">
                    <form method="POST" id="createmessage" name="createMessage" role="form" ng-submit="sentMessage()">
                        <input type="hidden" ng-model="form.parentId" name="parentId" id="parentId" ng-init='form.parentId = 0'>
                        <input type="hidden" ng-model="form.replyMsg" name="replyMsg" id="replyMsg" ng-init='form.replyMsg = 0'>
                        <div class="form-group sent-mail-to" ng-class="{'has-error':createMessage.toUser.$invalid && !createMessage.toUser.$pristine }">
                    <div class="row StepFourHeader">
                        <div class="col-sm-12">
                            <div>
                                <p class="step-text"><span class="text-uppercase">STEP</span> 4 of 4 </p>
                            </div>
                        </div>
                    </div>
                    <hr class="EmailStepFour">
                           <div class="form-row align-items-center">
                                <div class="col-auto padding-0 text-center to-name-label">
                                    <span class="to-name">&nbsp;</span>
                                </div>
                                <div class="col-sm-11">
                                    <select style="width : 100%"  type="hidden" ng-required="true" ui-select2 ="select2Options" multiple="multiple" class="custom-select form-control select2-option" name="toUser" id= "assignUser" ng-model="form.toUser" required />
                                        <option   ng-repeat="assignUser in assignUsersMessage" value="{{assignUser.Email}}">{{assignUser.FirstName}} {{assignUser.LastName}}</option>	
                                    </select>
                                </div>
                                <div class="col-auto padding-0 text-center">
                                    <a class="add-cc" href="javascript:;">CC</a>
                                </div>
                                <div class="col-auto padding-0 text-center">
                                    <a class="add-bcc" href="javascript:;">BCC</a>
                                </div>
                            </div>
                        </div>
                        <div class="to-mail subject" ng-class="{'has-error':createMessage.subject.$invalid && !createMessage.subject.$pristine }">
                            <span>Subject:</span>
                            <input ng-model="form.subject" type="text" name="subject" class="form-control" required />
                            <p ng-show="createMessage.subject.$invalid && !createMessage.subject.$pristine" class="help-block">Subject is required.</p>
                        </div>
                        <div class="form-group EmailTextMsgArea"  ng-class="{'has-error':createMessage.content.$invalid && !createMessage.content.$pristine }">
                            <summernote  ng-model="form.content" class="messageContent" config="options" on-media-delete="mediaDelete(target)" required></summernote>
                            <p ng-show="createMessage.content.$invalid && !createMessage.content.$pristine" class="help-block">Message Content is required.</p>
                        </div>

<!--                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <input type="checkbox" id="cb-21"  ng-model="form.checkboxscheduleDate"  name="checkboxscheduleDate" value="yes">
                                    <strong>Schedule Date</strong>
                                    <div class="form-group" ng-show="form.checkboxscheduleDate">
                                        <div class='input-group date' id='schedulePicker'>
                                            <input  ng-model="form.schedule" type='text' class="form-control" name="schedule" placeholder="yyyy-mm-dd" id="scheduleDate" />
                                            <span class="input-group-addon">
										<span class="fa fa-calendar-check-o"></span>
									</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                       <div class="row send-mail">
                            <div class="col-sm-7">
                                <input type="hidden" value="" ng-model="form.messagetype">
                                <a class="save-draft" href="javascript:;">
                                    <button ng-click="savedraft()"  name="savedraft" value="savedraft"  type="submit" class="btn btn-yellow">
                                        <i class="fa fa-floppy-o"></i>
                                    </button>
                                </a>

                                <a class="reply-chain" href="javascript:;">
                                    <i class="fa fa-reply"></i>
                                </a>

                                <div class="checkbox">
                                    <input type="checkbox" id="cb-13" ng-model="form.checkboxnotifyopened" value="yes">
                                    <label for="cb-13">Notify me if opened</label>
                                </div>

                                <div class="checkbox">
                                    <input type="checkbox" id="cb-14"  ng-model="form.checkboxnotifyday"  name="checkboxnotifyday" value="yes">
                                    <label for="cb-14">Notify me if no reply: <span>__</span> days</label>
                                </div>

                            </div>

                           <div class="col-sm-2">
                               <div  ng-show="form.checkboxnotifyday">
                                   <input  ng-model="form.notifyday" type='number' placeholder="days" class="form-control" name="notifyday"  id="notifyDays" />
                               </div>
                           </div>
                            <div class="col-sm-3">
                                <button type="submit" ng-disabled="createMessage.$invalid" class="btn btn-yellow btn-block">Send</button>

                            </div>
                        </div>
						<div class="modal_n_footer StepFourEmail">
    						<div class="row">
    							<div class="col-sm-6 text-left">
    								<a href="javascript:;" ng-click="prevContactAdd($event)" class=""><i class="fa fa-chevron-left"></i> Prev</a>						
    							</div>
    							<div class="col-sm-6 text-right">
    								<a  href="javascript:;"    data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>Skip</a>
    							<a href="javascript:;"  data-dismiss="modal" aria-label="Close" class=""><i class="fa fa-check"></i> Complete </a> 						
    							</div>
    						</div>
			             </div>
                    </form>
                </div>			
            </div>		  
        </div>
    </div>
</div>
<!-- Modal -->