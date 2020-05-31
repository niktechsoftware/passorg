<div class="row">
	<div class="col-md-12">
		<!-- start: RESPONSIVE TABLE PANEL -->
		<div class="panel panel-white">

			<div class="panel-heading panel-blue">
				<h4 class="panel-title "> <span class="text-bold">Send Reminder SMS</span></h4>
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
			<div class="alert alert-info"><h3 class="media-heading text-center">Welcome to Reminder SMS Area</h3>
			<p class="media-timestamp">This is the <b>Reminder SMS Area </b>, where you can see the send Reminder Message. 
			</div>
			<div><!--view form-->
		<div class="col-sm-12">
    <!-- start: FORM WIZARD PANEL -->
    
      	 <?php
   $var= $this->db->get("oldsms");
	if($var->num_rows()>0){
       ?>
     
         <div class="table-responsive">
							<table class="table table-striped table-hover" id="sample-table-2">
								<thead>
									<tr style="background-color:#1ba593; color:white;">
										<th>SNo.</th>
										<th>Position</th>
										<th>SMS</th>
										<th>status</th>
										<th>Edit</th>
										<th>Delete</th>
										
									</tr>
								</thead>
								<tbody><?php $i=1; foreach($var->result() as $lv): ?>
								<tr>
								    <input type="hidden" value="<?php echo $lv->id;?>" id="number<?php echo $i;?>">
								      
								<td><?php echo $i; ?></td>
								<td><?php $this->db->where("position",$lv->position);
								$lvn = $this->db->get("sms_type")->row();;echo $lvn->sms_position;?></td>
								<td> <textarea  rows="8" cols="100"  id="msg<?php echo $i;?>"><?php echo $lv->sms;?> </textarea></td>
								<td ><?php echo $lv->status; ?>
							
								<td><button class="btn btn-success">Edit </button></td>
								<td><button class="btn btn-danger">Delete </button> </td>
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