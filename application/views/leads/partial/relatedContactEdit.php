 <div class="modal snooze" id="edit-relation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                <div class="modal-dialog" role="document" >
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="myModalLabel">Update Related Contacts</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form method="POST" name="editRelation" role="form" ng-submit="updateRelatedContact()">
                                                                                <div class="row">
                                                                                    <input ng-init="form.relationId = editRelationId"  ng-value = {{editRelationId}} type="hidden" name="relationId" id="relationId" ng-model="form.relationId" />
                                                                                    <div class="col-sm-12">
                                                                                        <div class="form-group">
                                                                                            <input  ng-model="form.editRelationTitle" type='text' class="form-control" name="editRelationTitle" placeholder="Relation" id="editRelationTitle" required />
                                                                                            <p ng-show="editRelation.editRelationTitle.$invalid && !editRelation.editRelationTitle.$pristine" class="help-block">Title is required.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-6">
                                                                                        <button type="submit" ng-disabled="editRelation.$invalid" class="btn btn-yellow btn-block">Update Relation</button>
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