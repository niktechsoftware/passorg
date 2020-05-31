<div class="row">
	<div class="col-md-12">
		<!-- start: RESPONSIVE TABLE PANEL -->
		<div class="panel panel-white">

			<div class="panel-heading panel-blue">
				<h4 class="panel-title ">View  <span class="text-bold">SMS Details</span></h4>
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
			<div class="alert alert-info"><h3 class="media-heading text-center">Welcome to Sent SMS Report Area</h3>
			<p class="media-timestamp">This is the <b>sent SMS Details Area </b>, where you can see the real details and track your sms report. 
			</div>
			<div><!--view form-->
		<div class="col-sm-12">
    <!-- start: FORM WIZARD PANEL -->
    
      	 <?php
      $id= $this->uri->segment(3);
     $uri4= $this->uri->segment(4);
     $uri5= $this->uri->segment(5);
      if($uri4==1 && $uri5==2){
      $arr =array("DELIVRD","Delivered");
      }else{
          $arr =array("Expired","Undelivered");
      }
      	$this->db->where("requestId",$id);
      	$this->db->where_in("status",$arr);
		$var = $this->db->get("savesms");
		$this->db->where("response_id",$id);
		$ssm = $this->db->get("sent_sms_master")->row();
	if($var->num_rows()>0){
       ?>
     
         <div class="table-responsive">
							<table class="table table-striped table-hover" id="sample-table-2">
								<thead>
									<tr style="background-color:#1ba593; color:white;">
										<th>SNo.</th>
										<th>Sent Number</th>
										<th>SMS</th>
										<th>SMS ID</th>
										<th>Date & Time</th>
										<th>Status</th>
										<th>Track</th>
										<th>Resend sms</th>
									</tr>
								</thead>
								<tbody><?php $i=1; foreach($var->result() as $lv): ?>
								<tr>
								    <input type="hidden" value="<?php echo $lv->mobileNumber;?>" id="number<?php echo $i;?>">
								       <input type="hidden" value="<?php echo $ssm->sms;?>" id="msg<?php echo $i;?>">
								<td><?php echo $i; ?></td>
								<td><?php echo $lv->mobileNumber;?></td>
								<td><?php echo $ssm->sms; ?></td>
								<td ><?php echo $lv->requestId; ?>
								<input type="hidden" id="smsid<?php echo $i;?>" value ="<?php echo $lv->requestId;?>"></td>
								<td><?php echo $lv->deliveryDateTime; ?></td>
								<td><?php echo $lv->status; ?></td>
								<td><?php echo $lv->senderId; ?></td>
								<td><a href="#" id="sms<?php echo $i;?>" class="btn btn-info">Send Sms</a> </td>
								</tr>
							    <script>
							        $(document).ready(function(){
							             
							            $('#sms<?php echo $i;?>').click(function(){
							               
							                var m_number=$('#number<?php echo $i;?>').val();
							                  var meg=$('#msg<?php echo $i;?>').val();
							                // alert(meg)
							                 $.post("<?php echo site_url();?>smsAjax/resendsms",{m_number : m_number ,meg : meg},function(data){
							                      $('#sms<?php echo $i;?>').html(data);
							                 })
							                  
							                 
							                
							            });
							        });
							        
							    </script>
							<?php $i++; endforeach; ?>
							</tbody>
			</table>
			</div>
      <?php }else{
      echo "Data Not Found";
      }?>
  			<!-- end: panel Body -->
		</div><!-- end: panel panel-white -->
	</div><!-- end: MAIN PANEL COL-SM-12 -->
</div><!-- end: PAGE ROW-->
	</div>
</div>
</div>