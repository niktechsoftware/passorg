<div class="row">
	<div class="col-md-12">
		<!-- start: RESPONSIVE TABLE PANEL -->
		<div class="panel panel-white">

			<div class="panel-heading panel-blue">
				<h4 class="panel-title ">View  <span class="text-bold">Wrong Number SMS Details</span></h4>
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
			</div><br>
			
			<div class="panel-body">
			<div class="alert alert-info"><h3 class="media-heading text-center">Welcome to Sent Wrong Number SMS Report Area</h3>
			<p class="media-timestamp">This is the <b>sent wrong Number SMS Details Area </b>, where you can see the real details and track your sms report. 
			</div>
			<div><!--view form-->
		<div class="col-sm-12">
    <!-- start: FORM WIZARD PANEL -->
    
      	 <?php
      $id= $this->uri->segment(3);
      	$this->db->where("sms_master_id",$id);
		$var = $this->db->get("wrong_number_sms");
		$this->db->where("id",$id);
		$ssm = $this->db->get("sent_sms_master")->row();
	if($var->num_rows()>0){
       ?>
     
         <div class="table-responsive">
							<table class="table table-striped table-hover" id="sample-table-2">
								<thead>
									<tr style="background-color:#1ba593; color:white;">
										<th>SNo.</th>
										<th>Wrong Number</th>
										<th>SMS</th>
											<th>Date & Time</th>
										<th>Status</th>
										
									</tr>
								</thead>
								<tbody><?php $i=1; foreach($var->result() as $lv): ?>
								<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $lv->mobile;?></td>
								<td><?php echo $ssm->sms; ?></td>
									<td><?php echo $ssm->date; ?></td>
								<td>Failed</td>
								
								</tr>
								
							<?php $i++; endforeach; ?>
							</tbody>
			</table>
			</div>
      <?php }else{
      echo "0";
      }?>
  				-- end: panel Body -->
		</div><!-- end: panel panel-white -->
	</div><!-- end: MAIN PANEL COL-SM-12 -->
</div><!-- end: PAGE ROW-->
	</div>
</div>
</div>