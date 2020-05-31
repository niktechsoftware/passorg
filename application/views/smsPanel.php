<!-- start: PAGE CONTENT -->
<div class="row">
  <div class="col-md-12">
    <!-- start: RESPONSIVE TABLE PANEL -->
    <div class="panel panel-white">
      <div class="panel-heading panel-red">
        <h4 class="panel-title">Welcome to <span class="text-bold">SMS Panel</span></h4>
        <div class="panel-tools">
          <div class="dropdown">
            <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
              <i class="fa fa-cog"></i>
            </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li>
                <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
              </li>
              <li>
                <a class="panel-refresh" href="#">
                  <i class="fa fa-refresh"></i> <span>Refresh</span>
                </a>
              </li>
              <li>
                <a class="panel-config" href="#panel-config" data-toggle="modal">
                  <i class="fa fa-wrench"></i> <span>Configurations</span>
                </a>
              </li>
              <li>
                <a class="panel-expand" href="#">
                  <i class="fa fa-expand"></i> <span>Fullscreen</span>
                </a>
              </li>
            </ul>
          </div>
          <a class="btn btn-xs btn-link panel-close" href="#">
            <i class="fa fa-times"></i>
          </a>
        </div>
      </div>
									<div class="panel-body">
									<div>
											<p class="alert alert-success"> SMS Balance = <?php echo $cbs;?></p>
											</div>
			
										<div class="col-sm-4"><a href="<?php echo base_url(); ?>index.php/adminController/smssetting">
												<button class="btn panel-green btn-icon btn-block space10">
												<font size="5">SMS Setting</font><span class="badge badge-green partition-orenge"> 1 </span>

												</button>
												</a>
											</div>
											
										<div class="col-sm-4"><a href="<?php echo base_url(); ?>index.php/smsAjax/reminderSms">
												<button class="btn panel-blue btn-icon btn-block space10">
												<font size="5">Reminder SMS</font><span class="badge badge-blue partition-orenge"> 2 </span>
												</button>
												</a>
											</div>
										<div class="col-sm-4"><a href="<?php echo base_url(); ?>index.php/login/mobileNotice/Announcement">
												<button class="btn panel-purple btn-icon  btn-block space10">
												<font size="5">Send All Employee SMS</font><span class="badge badge-purple partition-orenge"> 3 </span>
												</button>
												</a>
											</div>
											<br></br>
											<br></br>
										<div class="col-sm-4"><a href="<?php echo base_url(); ?>index.php/login/mobileNotice/Greeting">
 												<button class="btn panel-red btn-block btn-icon space10 ">
                            				<font size="5">Send SMS<br> Subscriber and Employee</font><span class="badge badge-red partition-orenge"> 4 </span>
												</button>
											</div>
										<div class="col-sm-4"><a href="<?php echo base_url(); ?>index.php/login/mobileNotice/Parent%20Message">
												<button class="btn panel-yellow btn-block btn-icon space10">
									    <font size="5">Send All SMS</font><span class="badge badge-yellow partition-orenge"> 5 </span>
												</button>
												</a>
											</div>
										<div class="col-sm-4"><a href="<?php echo base_url(); ?>index.php/login/mobileNotice/Notice">
												<button class="btn panel-orange btn-block btn-icon space10 ">

											<font size="5">	Send Individual Notice<span class="badge badge-orange partition-orenge"> 6 </span>
												</button>
												</a>
											</div>
									<div class="col-sm-4"><a href="<?php echo base_url(); ?>index.php/login/mobileNotice/Greeting">
												<button class="btn panel-pink btn-block btn-icon space10">

											<font size="5">Send to All<span class="badge badge-pink partition-orenge"> 7 </span>
												</button>
												</a>
											</div>
									<div class="col-sm-4"><a href="<?php echo base_url(); ?>index.php/login/mobileNotice/classwise">
												<button class="btn panel-purple btn-block btn-icon space10 ">

											<font size="5">Send Level Wise SMS <span class="badge badge-purple partition-orenge"> 8 </span>
												</button>
												</a>
											</div>
										<div class="col-sm-4"><a href="<?php echo base_url(); ?>index.php/smsAjax/smsreport">
												<button class="btn panel-green btn-icon btn-block space10">
												<font size="5"> SMS Report</font><span class="badge badge-green partition-orenge"> 9 </span>

												</button>
												</a>
											</div>
										
											
										<!--	<div class="col-sm-4"><a href="<?php echo base_url(); ?>index.php/login/mobileNotice/templateSms">
												<button class="btn panel-azure btn-block  btn-icon space10">
											<font size="5">	Send Template SMS  <span class="badge badge-info partition-orenge"> 12 </span>
												</button>
											</div> -->

								

								</div>


								

 								</div>
               </div>
           </div>
         </div>
         </div>




