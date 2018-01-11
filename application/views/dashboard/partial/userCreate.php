<div class="modal snooze" id="create-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" >
        <div class="modal-content">
            <form  enctype="multipart/form-data" method="POST" name="addUser" role="form" ng-submit="saveUser()">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Add Team Member</h4>
			   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>First Name <span class="required_span_error">*</span></strong>
                            <div class="form-group" ng-class="{'has-error':addUser.userFirstName.$invalid && !addUser.userFirstName.$pristine}">
                                <input ng-model="form.userFirstName" type="text" id="userFirstName"  name="userFirstName" class="form-control" required />
								<p ng-show="addUser.userFirstName.$invalid && !addUser.userFirstName.$pristine" class="help-block">First Name is required.</p>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Last Name<span class="required_span_error">*</span></strong>
                            <div class="form-group" ng-class="{'has-error':addUser.userLastName.$invalid && !addUser.userLastName.$pristine}">
								<input ng-model="form.userLastName" type="text"  id="userLastName" name="userLastName" class="form-control" required />
								<p ng-show="addUser.userLastName.$invalid && !addUser.userLastName.$pristine" class="help-block">Last Name is required.</p>
                            </div>
                        </div>
                    </div>
					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Email Address<span class="required_span_error">*</span></strong>
							<div class="form-group" ng-class="{'has-error':addUser.userEmail.$invalid && !addUser.userEmail.$pristine}">
								 <input ng-model="form.userEmail" type="email"  id="userEmail" name="userEmail" class="form-control" required />
								<p ng-show="addUser.userEmail.$invalid && !addUser.userEmail.$pristine" class="help-block">Email is required.</p>
                            </div>
					     </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Username<span class="required_span_error">*</span></strong>
							<div class="form-group" ng-class="{'has-error':addUser.username.$invalid && !addUser.username.$pristine}">
								<input ng-model="form.username" type="text"  id="username" name="username" class="form-control" required />
								<p ng-show="addUser.username.$invalid && !addUser.username.$pristine" class="help-block">Username is required.</p>
                            </div>
                         </div>
                    </div>
					<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Password<span class="required_span_error">*</span></strong>
                            <div class="form-group" ng-class="{'has-error':addUser.userPassword.$invalid && !addUser.userPassword.$pristine}">
                                <input ng-model="form.userPassword" type="password" id="userPassword"  name="userPassword" class="form-control"  ng-minlength="8" ng-maxlength="50" ng-pattern="/(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z])/" required />
								<p ng-show="addUser.userPassword.$invalid && !addUser.userPassword.$pristine" class="help-block">Password is required.</p>
								 <p ng-show="addUser.userPassword.$error.minlength" class="help-block">
								  Passwords must be between 8 and 20 characters.</p>
								<p ng-show="addUser.userPassword.$error.pattern" class="help-block">
								  Must contain one lower &amp; uppercase letter, and one non-alpha character (a number or a symbol.)</p>
                            </div>
                        </div>
						<div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Confirm Password<span class="required_span_error">*</span></strong>
                            <div class="form-group" ng-class="{'has-error':addUser.userConfirmPassword.$invalid && !addUser.userConfirmPassword.$pristine}">
								<input ng-model="form.userConfirmPassword" type="password"  id="userConfirmPassword" name="userConfirmPassword" class="form-control"  valid-password-c="form.userPassword" required />
								 <p ng-show="addUser.userConfirmPassword.$error.noMatch" class="help-block">Passwords do not match.</p>
								<p ng-show="addUser.userConfirmPassword.$invalid && !addUser.userConfirmPassword.$pristine" class="help-block">Confirm Password is required.</p>
								
                            </div>
                        </div>
                    </div> 
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>User Image</strong>
                            <div class="form-group">
                                <input ng-model="form.userImage"   onchange="angular.element(this).scope().uploadImage(this.files)" type="file" id="userImage"  name="userImage" class="" accept="image/x-png,image/gif,image/jpeg" ngf-pattern=".jpg,.png" ngf-accept = "image/*"/>
									<p ng-show="addUser.userImage.$error.pattern" class="help-block">
								  Must contain one lower &amp; uppercase letter, and one non-alpha character (a number or a symbol.)</p>
                            </div>
                        </div>
					</div>
					<button type="submit" ng-disabled="addUser.$invalid" class="btn btn-yellow">Add User</button>
				    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    
                </div>
            </div>
            </form>
        </div>
    </div>
</div>