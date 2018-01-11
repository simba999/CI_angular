 <div class="site-wrapper">
  <app-side-navbar><div class="sidenav" id="sidenav" role="navigation">
    
    <div class="logo w-100">
      <a routerlink="/" ng-reflect-router-link="/" ng-reflect-href="/" href="/">
       <img alt="" class="img-fluid" src="<?php echo base_url().ASSETS_DIR;?>/global/images/logo2.png"> 
      </a>
    </div>
 <div class="nav-menu">
		<ul class="nav">
        <li ng-reflect-router-link-active="active" ng-reflect-class-name="item-home" class="item-home">
          <a class="nav-link"  href="https://printbuilder.agentcloud.com/dashboard">
            <i ng-reflect-class-name="fa fa-home" class="https://printbuilder.agentcloud.com/dashboard"></i>
            <span class="nav-text">Home</span>
          </a>
			
        </li><li ng-reflect-router-link-active="active" ng-reflect-class-name="item-crm" class="item-crm menuactive">
          <a class="nav-link"  href="<?php echo  base_url(); ?>">
            <i ng-reflect-class-name="undefined" class="undefined"></i>
            <span class="nav-text">CRM</span>
          </a>
				<ul class="nav child">
				  <li class="child parent-link">
					<a class="nav-link"  href="<?php echo  base_url(); ?>">
					  <span class="nav-text">CRM</span>
					</a>
				  </li>
				<li class="child" ng-reflect-router-link-active="active">
					<a class="nav-link"  href="<?php echo  base_url(); ?>dashboard">
					<span class="nav-text">Dashboard</span>
					</a>
			  </li>
			  <li class="child" ng-reflect-router-link-active="active">
					<a class="nav-link"  href="<?php echo  base_url(); ?>circle">
						<span class="nav-text">Circles</span>
					</a>
			  </li>
				<li class="child" >
					<a class="nav-link"  href="<?php echo  base_url(); ?>message">
				  <span class="nav-text">Inbox</span>
				</a>
			  </li>
			  <li class="child">
				<a class="nav-link" href="<?php echo  base_url(); ?>tasks">
				  <span class="nav-text">Todo List</span>
				</a>
			  </li>
			  <li class="child" ng-reflect-router-link-active="active">
			   <a class="nav-link" href="<?php echo  base_url(); ?>listing">
				  <span class="nav-text">Listings</span>
				</a>
			  </li>
			  <li class="child" ng-reflect-router-link-active="active">
				<a class="nav-link" href="<?php echo  base_url(); ?>contact">
				  <span class="nav-text">Contacts</span>
				</a>
			  </li>
			  <li class="child" ng-reflect-router-link-active="active">
				<a class="nav-link" href="<?php echo  base_url(); ?>contact/contactsmerge">
				<span class="nav-text">Merge Contacts</span>
				
				</a>
			 </li>
        </ul>
       
        </li>
		<li ng-reflect-router-link-active="active" ng-reflect-class-name="item-events" class="item-events">
          <a class="nav-link" ng-reflect-router-link="/events" ng-reflect-href="/events" href="<?php echo CALENDAR_URL;?>?ac_token=<?php echo $this->session->userdata('token');?>">
            <i ng-reflect-class-name="undefined" class="undefined"></i>
            <span class="nav-text">Events</span>
          </a>
			<ul class="nav child">
				  <li class="child parent-link">
					<a class="nav-link"  href="<?php echo CALENDAR_URL;?>?ac_token=<?php echo $this->session->userdata('token');?>">
					  <span class="nav-text">Events</span>
					</a>
				  </li>
				<li class="child" ng-reflect-router-link-active="active">
					<a class="nav-link"  href="<?php echo CALENDAR_URL;?>?ac_token=<?php echo $this->session->userdata('token');?>">
					<span class="nav-text">Events</span>
					</a>
			  </li>
				<li class="child" >
					<a class="nav-link"  href="<?php echo CALENDAR_URL;?>event?ac_token=<?php echo $this->session->userdata('token');?>"><span class="nav-text">Add Event</span>
					</a>
			  </li>
			</ul>
        </li>
		<li ng-reflect-router-link-active="active" ng-reflect-class-name="item-printbuilder" class="item-printbuilder">
          <a class="nav-link"  href="https://printbuilder.agentcloud.com">
            <i ng-reflect-class-name="" class="undefined"></i>
            <span class="nav-text">Print Builder</span>
          </a>
		
        </li>
		<li ng-reflect-router-link-active="active" ng-reflect-class-name="item-webbuilder" class="item-webbuilder">
			  <a class="nav-link"  href="<?php echo WEBSITE_BUILDER_URL; ?>">
				<i ng-reflect-class-name="fa fa-internet" class="fa fa-internet"></i>
				<span class="nav-text">Web Builder</span>
			  </a>
				<ul class="nav child">
					 <li class="child parent-link">
					<a class="nav-link"  href="<?php echo WEBSITE_BUILDER_URL; ?>">
						<span class="nav-text">Web Builder</span>
					</a>
					 </li>	 
				</ul>
				
        </li>
		<li ng-reflect-router-link-active="active" ng-reflect-class-name="item-transactions" class="item-transactions">
          <a class="nav-link" href="#">
            <i ng-reflect-class-name="undefined" class="undefined"></i>
            <span class="nav-text">Transactions</span>
          </a>
        </li>
		<li ng-reflect-router-link-active="active" ng-reflect-class-name="item-screencast" class="item-screencast">
          <a class="nav-link" href="#">
            <i ng-reflect-class-name="undefined" class="undefined"></i>
            <span class="nav-text">ScreenCast</span>
          </a>
		 </li>
      </ul>
    </div>
</div>
</app-side-navbar>
        <!-- site-menubar -->
        <main class="site-main">
			<nav class="site-navbar navbar navbar-toggleable-sm navbar-inverse">
        <!-- navbar header -->
        
        <div class="collapse navbar-collapse" id="site-navbar-collapse">
            <ul class="navbar-nav mr-auto">
				<li class="nav-item hidden-sm-down hidden-md-up">
					<button data-toggle="menubar-fold" class="nav-link hamburger hamburger--arrowalt js-hamburger" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</li>
                <form class="form-inline">
				  <div class="form-group">					
					<div class="input-group">					  
					  <input type="text" class="form-control" id="exampleInputAmount" placeholder="">
					  <div class="input-group-addon"><i class="fa fa-search"></i></div>
					</div>
				  </div>				  
				</form>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
					<a href="<?php echo base_url(); ?>message" class="nav-link mail-count">
						<i class="fa fa-envelope"></i>
						<span>3</span>
					</a>
                </li>				
                <li class="nav-item dropdown">
					<a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="zmdi zmdi-hc-lg zmdi-notifications"></i>
					 </a>
                    <div class="dropdown-menu media-list float-right animated scaleInDownLeft">
                        <a href="javascript:void(0)" class="dropdown-item media">
                            <div class="avatar avatar-sm avatar-circle"><img src="assets/global/images/221.jpg" alt=""> <i class="status status-online"></i>
                            </div>
                            <div class="media-body">
                                <h6 class="media-heading">John Doe</h6><small class="media-meta">Active now</small>
                            </div>
                        </a>
                        <!-- ./media -->
                        <a href="javascript:void(0)" class="dropdown-item media">
                            <div class="avatar avatar-sm avatar-circle"><img src="assets/global/images/205.jpg" alt=""> <i class="status status-offline"></i>
                            </div>
                            <div class="media-body">
                                <h6 class="media-heading">John Doe</h6><small class="media-meta">2 hours ago</small>
                            </div>
                        </a>
                        <!-- ./media -->
                        <a href="javascript:void(0)" class="dropdown-item media">
                            <div class="avatar avatar-sm avatar-circle"><img src="assets/global/images/207.jpg" alt=""> <i class="status status-away"></i>
                            </div>
                            <div class="media-body">
                                <h6 class="media-heading">Sara Smith</h6><small class="media-meta">idle 5 min ago</small>
                            </div>
                        </a>
                        <!-- ./media -->
                        <a href="javascript:void(0)" class="dropdown-item media">
                            <div class="avatar avatar-sm avatar-circle"><img src="assets/global/images/211.jpg" alt=""> <i class="status status-away"></i>
                            </div>
                            <div class="media-body">
                                <h6 class="media-heading">Donia Dyab</h6><small class="media-meta">idle 5 min ago</small>
                            </div>
                        </a>
                        <!-- ./media -->
                    </div>
                </li>
                <li class="nav-item dropdown">
					<a href="javascript:void(0)" class="nav-link dropdown-toggle text-uppercase name" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<?php echo $this->session->userdata('user_fullname'); ?>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
					</a>
                   <div class="dropdown-menu float-right animated scaleInDownLeft">
						<a href="javascript:void(0)" class="dropdown-item py-3">
							<i class="zmdi mr-3 zmdi-hc-lg zmdi-account-box"></i>My Profile
						</a> 
						<a href="javascript:void(0)" class="dropdown-item py-3">
							<i class="zmdi mr-3 zmdi-hc-lg zmdi-balance-wallet"></i>Balance
						</a> 
						<a href="javascript:void(0)" class="dropdown-item py-3">
							<i class="zmdi mr-3 zmdi-hc-lg zmdi-phone-msg"></i>Connection
							<span class="badge badge-primary float-right">3</span> 
						</a>
						<a href="javascript:void(0)" class="dropdown-item py-3">
							<i class="zmdi mr-3 zmdi-hc-lg zmdi-info"></i>Privacy
						</a>
						<a href="<?php echo base_url(); ?>/logout" class="dropdown-item py-3">
							<i class="zmdi mr-3 zmdi-hc-lg zmdi-account-box"></i>Signout
						</a> 
						
						<!--<a href="javascript:void(0)" class="dropdown-item py-3">
							<i class="zmdi mr-3 zmdi-hc-lg zmdi-balance-wallet"></i>Balance
						</a> 
						<a href="javascript:void(0)" class="dropdown-item py-3">
							<i class="zmdi mr-3 zmdi-hc-lg zmdi-phone-msg"></i>Connection
							<span class="badge badge-primary float-right">3</span> 
						</a>
						<a href="javascript:void(0)" class="dropdown-item py-3">
							<i class="zmdi mr-3 zmdi-hc-lg zmdi-info"></i>privacy
						</a> -->
                    </div>
                </li>  
                </li>  
				<li class="nav-item profile-pic">
					<img class="avatar" src="<?php echo $this->session->userdata('user_profile'); ?>" alt="avatar">
				</li>				
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
 <div class="site-content">   
 <script> var UploadDirectory = '<?php echo base_url().UPLOAD_DIR.'/'.IMAGE.'/'.LEAD_IMAGE.'/'; ?>'</script>