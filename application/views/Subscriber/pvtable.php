
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- start: EXPORT DATA TABLE PANEL  -->
			<div class="panel panel-white">
			<div class="panel-heading panel-red">
					<h4 class="panel-title"> <span class="text-bold">Master P V Details</span></h4>
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
				    			<div class="alert btn-purple">
				    			    <button data-dismiss="alert" class="close"></button>
<h4 class="media-heading text-center"> Welcome to Pass Value View Area. </h4>
<p>Here you can see Edit and Delete Pass Value .<br>Note: 1 P.V. = 0.8 Rs. 
</p> </div>
				    
					<div class="row">
						<div class="col-md-12 space20">
							<div class="btn-group pull-right">
								<button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
									Export <i class="fa fa-angle-down"></i>
								</button>
								
								<ul class="dropdown-menu dropdown-light pull-right">
									
									<li>
										<a href="#" class="export-excel" data-table="#sample-table-2" >
											Export to Excel
										</a>
									</li>
								</ul>
								
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<div class="table-responsive">
							<table class="table table-striped table-hover" id="sample-table-2">
							<thead>
                  <tr>
                    <th>S.NO.</th>
                    <th>Level</th>
                    <th>percentage</th>
                    <th>Activity</th>
                   
                  </tr>
                </thead>
							 <tbody>
                  <?php
                    $comm = $this->db->get("commission")->result();
                      
                  ?>
                  <?php  $i=1;
                  foreach($comm as $row):?>
                  <tr class="text-uppercase">
                    <td><?php echo $i;?></td>
                    <td><?php echo $row->id;?></td>
                    <td><input type="text" id ="c<?php echo $row->id;?>" value="<?php echo $row->com_percentage;?>"/> </td>
                     <td><button class ="btn btn-purple" id="edit<?php echo $row->id;?>" value ="<?php echo $row->id;?>">Edit</button></td>
                     <script>
                         	$("#edit<?php echo $row->id;?>").click(function(){
            					var level = $("#edit<?php echo $row->id;?>").val();
            					var levelv = $("#c<?php echo $row->id;?>").val();
            				
            					$.post("<?php echo site_url("index.php/subscriberController/editLevelc") ?>",{level : level , levelv : levelv}, function(data){
            						$("#edit<?php echo $row->id;?>").html(data);
            						});
            					
            					});

                         
                     </script>
                 </tr>
                  <?php  $i++;
                endforeach;
                   ?>
                </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- end: EXPORT DATA TABLE PANEL -->
		</div>
	</div>
	<!-- end: PAGE CONTENT-->
</div>