<?php
		    $emailConnect = $this->session->userdata('emailConnect');
            $calenderConnect = $this->session->userdata('calenderConnect');
			//$this->session->set_userdata('contactAdded',1);
			//$this->session->set_userdata('firstMessageSent',1);
			$contactAdded = $this->session->userdata('contactAdded');
			$firstMessageSent = $this->session->userdata('firstMessageSent');
            
            $emailClass = "include";
            $calenderClass = "include";
            $contactClass = "include";
            $firstMessageClass = "include";
            $progressBarValue = 0;
            if($emailConnect)
            {
                $emailClass="cancel";
                $progressBarValue += 25;
            }
            if($calenderConnect)
            {
                $calenderClass="cancel";
                $progressBarValue += 25;
            }
            if($contactAdded)
            {
                $contactClass="cancel";
                $progressBarValue += 25;
            }
            if($firstMessageSent)
            {
                $firstMessageClass = "cancel";
                $progressBarValue += 25;
            }
?>
<div class="col-md-3 col-sm-12 col-xs-12">
            <div class="sidebar-main">
                <div class="widget">
                    <div class="widget-body sidebarPaddRemoveForWelcCalAnaly">
                        <div class="welcome">	
                            <h3 class="text-uppercase">welcome</h3>
                            <h6 class="text-uppercase">complete your account set up.</h6>
							<?php if($progressBarValue<100) { 
							if($progressBarValue!=0)
							{
								$progressBarValue = number_format((float) $progressBarValue, 2);
							}
							?>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $progressBarValue;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $progressBarValue;?>%;">
                                    <span class=""><?php echo $progressBarValue;?> % </span>
                                </div>
                            </div>
							<?php } else { ?>
							<div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $today_tasks_completed_in_progress;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $today_tasks_completed_in_progress;?>%;">
                                    <span class=""><?php echo $today_tasks_completed_in_progress;?> % </span>
                                </div>
                            </div>
							<?php } ?>
                            <ul>
								<li class="<?php echo $emailClass;?>"><a href="#" data-toggle="modal" data-target="#connect-emailaccount">Connect your email account</a></li>
                                <li class="<?php echo $calenderClass;?>"><a href="#" data-toggle="modal" data-target="#connect-calender">Connect Calendar</a></li>
								<li class="<?php echo $contactClass;?>"><a href="#" data-toggle="modal" data-target="#contact-add"cotact-add>Add 25 contacts to circles</a></li>
								<li class="<?php echo $firstMessageClass; ?>"><a href="#" data-toggle="modal" data-target="#create-message"cotact-add>Send your first message</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="widget">
                    <div class="widget-body sidebarPaddRemoveForWelcCalAnaly">
                        <div id="fullcalendar"  class="sidebar-calender"></div>

                        <div class="calendar-info">
                            <div class="task-color yellow">
                                <h6 class="text-uppercase">Task</h6>
                            </div>

                            <div class="task-color event">
                                <h6 class="text-uppercase">Event</h6>
                            </div>	

                            <div class="task-color appointment">
                                <h6 class="text-uppercase">Appointment</h6>
                            </div>

                            <div class="task-color overdue">
                                <h6 class="text-uppercase">Overdue</h6>
                            </div>	
                        </div>
                    </div>
                </div>
				<div class="widget">	
								<div class="widget-body sidebarPaddRemoveForWelcCalAnaly">
							<!--<div id="chartjs-line-1" style="height: 320px;width: 100%"></div>	-->
									<h2>Latest Analytics</h2>
								<canvas id="chartjs-line-2" width="100%"></canvas>						
								</div>
				</div>
            </div>

 </div>
 <?php if($progressBarValue==0) { ?>
 <style>
 
 .sidebarPaddRemoveForWelcCalAnaly .progress-bar {
    width: 100% !important;
	background:#eceeef !important;
}
 </style>
 <?php } ?>