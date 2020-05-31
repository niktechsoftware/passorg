<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- start: EXPORT DATA TABLE PANEL  -->
			<div class="panel panel-white">
			<div class="panel-heading panel-red">
					<h4 class="panel-title"> <span class="text-bold">Registered Active Branch List</span></h4>
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
                                        <h4 class="media-heading text-center">Welcome to Registered Active List </h4>
                                        <p>Now you can Inactive a Branch By clicking given Active Button in consern row.<br>
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
    <table id="shoppro" class="table table-bordered table-responsive">
      <thead>
        <tr>
          <th>SNO</th>
          <th>Invoice Numver</th>
          <th>Branch</th>
          <th>Date</th>
          <th>Quantity</th>
          <th>Total Amount</th>
          <th>Status</th>
          <th>Activity</th>
        </tr>
      </thead>
      <tbody>
        <?php  $i=1;
        if($productlist->num_rows()>0){
       foreach($productlist->result()  as $row):?>
        <tr class="text-uppercase">
          <td><?php echo $i;?></td>

       
          <td style="width:20px;"><?php echo $row->invoice_no;?>
          </td>
          <td><?php $this->db->where("id",$row->user_id);
          $branchd = $this->db->get("branch")->row();
          echo $branchd->b_name."[".$branchd->username."]";?></td>
          <td><?php echo $row->date;?></td>
         
       
            <td style="width:8px;color:black;"><?php $this->db->select_sum("quantity");
            $this->db->where("invoice_no",$row->invoice_no);
           $totquantity =  $this->db->get("askforproducttable")->row()->quantity;
           echo $totquantity;?></td>
            <td><?php  $this->db->where("invoice_no",$row->invoice_no);
           $totbill =  $this->db->get("askforproducttable");
           if($totbill->num_rows()>0){
              $totbillamount =0;foreach($totbill->result() as $r):
                   $totbillamount=$totbillamount +$r->quantity*$r->rate;
                   endforeach;
                   echo $totbillamount;
           }else{
               echo "0.00";
           }
           ?>
           </td>   
         
          <td><?php echo $row->status;?></td>
          <td><a href="<?php echo base_url();?>branchController/reportAskford/<?php echo $row->invoice_no;?> "  class="btn btn-primary">View</a>
         <?php  if($row->status==0){?> <a href="<?php echo base_url();?>branchController/delreportAskford/<?php echo $row->invoice_no;?>"  class="btn btn-danger">Delete</a><?php }?>
          <?php if($this->session->userdata("login_type")==1){
          if($row->status==1){echo "Approved";}else{?>
             <a href="<?php echo base_url();?>adminController/approveAskford/<?php echo $row->invoice_no;?>" class="btn btn-purple">Approve</button> 
         <?php }}
           ?>
          </td>

        </tr>
     
       
        <?php  $i++;
                endforeach;}
                   ?>
      </tbody>

    </table>
  </div>
	</div>
			</div>
			<!-- end: EXPORT DATA TABLE PANEL -->
		</div>
	</div>
	<!-- end: PAGE CONTENT-->
</div>