<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="description" content="Kiwi is a premium adman dashboard template based on bootstrap">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
		<link rel="apple-touch-icon" href="apple-touch-icon.html"><!-- core plugins -->
		<link rel="stylesheet" href="<?php echo base_url(). ASSETS_DIR . VENDOR_DIR.BOWER_COMPNENT;?>/animate.css/animate.min.css">
		
		<link rel="stylesheet" href="<?php echo base_url(). ASSETS_DIR.VENDOR_DIR.BOWER_COMPNENT;?>/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url(). ASSETS_DIR . VENDOR_DIR.BOWER_COMPNENT;?>/material-design-iconic-font/dist/css/material-design-iconic-font.css">
		<link rel="stylesheet" href="<?php echo base_url(). ASSETS_DIR.VENDOR_DIR;?>/css/bootstrap.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600">
		<link rel="stylesheet" href="<?php echo base_url(). ASSETS_DIR;?>/examples/css/pages/login.css">
		<title>Agent Cloud Login</title>
	</head>
	<body class="simple-page page-login">
		<div class="simple-page-wrap">
			<div class="simple-page-content mb-4">
					<div class="simple-page-logo animated zoomIn">
						<a href="#"><span><i class="fa fa-houzz"></i></span> 
								<span>Agent Cloud</span></a>
					</div><!-- logo -->
				<div class="simple-page-form animated flipInY" id="login-form">
					<h6 class="form-title mb-4 text-center">Sign In With Your Agent Cloud Account</h6>
						<div class="error_login">
							<?php echo validation_errors(); ?>
							<?php
							$error = $this->session->flashdata('error');
							$success = $this->session->flashdata('success');
							if (!empty($error)) {
								?>
								<div class="alert alert-danger"><?php echo $error; ?></div>
							<?php } ?>
							<?php if (!empty($success)) { ?>
								<div class="alert alert-success"><?php echo $success; ?></div>
							<?php } ?>
						</div>
						<form action="<?php echo base_url() ?>login" method="post">
						  <div class="form-group">
								<input name="username" id="username" type="text" class="form-control" placeholder="Username">
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
						   </div>
						 <div class="form-group">
								<input id="password" name="password" type="password" class="form-control" placeholder="Password">
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
						 </div>
						<!--<div class="form-group mb-5">
							<div class="checkbox checkbox-primary"><input type="checkbox" id=	"keep_me_logged_in"	><label for="keep_me_logged_in">Keep me signed in</label>
							</div>
						</div> -->
						<input type="submit" class="btn btn-primary" value="SIGN IN"></form>
					</div>
					<!-- #login-form -->
							<!-- <div class="text-center">
								<p><a href="password-forget.html" class="text-white">FORGOT YOUR PASSWORD ?</a></p>
							</div> -->
			 </div>	
		</div>
			<script src="<?php echo base_url(). ASSETS_DIR.VENDOR_DIR.BOWER_COMPNENT;?>/jquery/dist/jquery.min.js"></script>
			<script src="<?php echo base_url(). ASSETS_DIR.VENDOR_DIR.BOWER_COMPNENT;?>/tether/dist/js/tether.min.js"></script>
		<script src="<?php echo base_url(). ASSETS_DIR.VENDOR_DIR.BOWER_COMPNENT;?>/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>