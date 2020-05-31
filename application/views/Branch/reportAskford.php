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
					<?php $this->db->where("id",$userid);
          $branchd = $this->db->get("branch")->row();
           $branchd->b_name."[".$branchd->username."]";
           $this->db->where("invoice_no",$invoice_no);
           $getstatus = $this->db->get("askforproduct")->row()->status;?>
					<div class ="alert alert-info"> <h2>Ask For Admin Product List <?php echo $invoice_no." of ".$branchd->b_name."[".$branchd->username."]";;?></h2></div>
						<div class="table-responsive">
    <table id="shoppro" class="table table-bordered table-responsive">
      <thead>
        <tr>
          <th>SNO</th>
          <th>Product Code</th>
          <th>Name </th>
          <th>Company </th>
           <th>Category </th>
           <th>Rate</th>
          <th>Quantity</th>
           <th>Sub Total Amount</th>
          <th>Status</th>
          <th>Activity</th>
        </tr>
      </thead>
      <tbody>
        <?php  $i=1;
        $qut=0;
        $totbill=0;
        if($productlist->num_rows()>0){
         /*   echo '<pre>';
            print_r($productlist);
            echo '</pre>';*/
      $qut =0; $totbill=0;
      foreach($productlist->result()  as $row):?>
        <tr class="text-uppercase">
          <td><?php echo $i;?></td>
          <td style="width:20px;"><?php echo $row->p_code;?></td>
         
          <td><?php $this->db->where("id",$row->p_code);
          $pdetails = $this->db->get("stock_products")->row();
          echo $pdetails->name;?></td>
          <td><?php echo $pdetails->company;?></td>
          <td><?php $this->db->where("id",$pdetails->sub_category);
         $getsub = $this->db->get("sub_category")->row(); 
         echo $getsub->name;?></td>
          </td>
          <td><?php echo $row->rate;?></td>
          <td><?php  $qut= $qut+$row->quantity; echo $row->quantity;?></td>
         
       
            <td style="width:8px;color:black;"><?php $totbill=$totbill+$row->quantity*$row->rate; echo number_format($row->quantity*$row->rate,2,'.','');?></td>
            <td>
                <?php if($getstatus==1){ echo "Approved";}else{echo "Not Approve";}?>
           </td>   
         
         <td><?php if($getstatus==0){?><a href ="<?php echo base_url();?>branchController/deletereportAskford/<?php echo $row->invoice_no;?>/<?php echo $row->id;?>" class ="btn btn-danger">Delete</a><?php }?></td>

        </tr>
        <!-- <script type="59edefb75604f457019ed4b6-text/javascript" src="<?php echo base_url();?>assets/js/script.min.js">
        </script>
        <script src="<?php echo base_url();?>assets/js/jquery-3.4.0.min.js"></script>-->
       
        <?php  $i++;
                endforeach;}
                   ?>
        <tr>
            <td colspan="6">Total</td>
            <td><?php echo $qut;?></td>
            <td><?php echo  number_format($totbill,2,'.','');?></td>
            <td></td>
            <td></td>
          
           
            
            
        </tr>           
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