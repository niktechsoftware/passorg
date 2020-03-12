
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- start: EXPORT DATA TABLE PANEL  -->
			<div class="panel panel-white">
			<div class="panel-heading panel-red">
					<h4 class="panel-title"> <span class="text-bold">Product Receive And Pay</span></h4>
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
									<tr style="background-color:#1ba593; color:white;">
                                        <th width:"10px">SNO</th>
                                        <th width:"10px">Invoice No</th>
                                        <th width:"10px">Amount</th>
                                        <th width:"10px">Trnf Qty</th>
                                        <th width:"10px">Date</th>
                                        <th width:"10px">Transfer TO</th>
                                        <th width:"10px">Payment Mode</th>
                                        <th width:"10px">Paid Amount</th>
                                        <th width:"10px">Transaction ID</th>
                                        <th width:"10px">Status</th>
                                       
									</tr>
							
<!-- select all boxes -->

									
								</thead>
                                <tbody>
                                    <?php
                                    
                                     $username= $this->session->userdata("username");
                                    $this->db->group_by('invoice_no');
                                     //$this->db->where('reciver_usernm',$username);
                                     $this->db->where('sender_username',$username);
                                     $e=$this->db->get('assignproduct'); 
                                     $i=1;
                                     foreach($e->result() as $e_data) {
                                         $this->db->where('invoice_number',$e_data->invoice_no);
                                        
                                         $chk = $this->db->get('product_trans_detail');
                                     if($chk->num_rows()>0){
                                     
                                      ?>
							                
												<tr class="text-uppercase text-center">
												    <td width:"10px"><?php echo $i; ?></td>
													<td width:"10px"><a class="btn btn-primary" href="<?php echo base_url();?>stockController/productinvoice/<?php echo $e_data->invoice_no; ?>"><?php echo $e_data->invoice_no; ?></a></td>
													<?php $tt=0; 
													  foreach($chk->result() as $ro):
													      $this->db->where("id",$ro->p_code);
													     $ps =  $this->db->get("stock_products")->row()->selling_price;
													      $tt = $tt + $ro->quantity*$ps;
													      endforeach;
    												    ?>
													 <td width:"10px"><input style="width:70px;" type="text" value="<?php echo $tt;?>" name="ordamt<?php echo $i;?>" id= "ordamt<?php echo $i;?>" readonly/></td>
														<?php $this->db->where('invoice_number',$e_data->invoice_no);
													$this->db->select_sum('quantity');
													$qty= $this->db->get('product_trans_detail')->row();
													?>
													<td width:"10px"><a class="btn btn-info" href="<?php echo base_url();?>shopController/recieveproductlist"><?php echo $qty->quantity; ?></a></td>
													<td width:"10px"><?php echo $e_data->date; ?></td>
													<td width:"10px"><?php echo $e_data->reciver_usernm;?></td>
													<?php 
												    $pmode = $this->db->get('pay_mode');
												    ?>
												
													<td width:"10px"><select id="p_mode<?php echo $i; ?>">
													    <option value="select">Select</option>
													    <option value="balance">From Balance</option>
													    <?php foreach($pmode->result() as $pt) { ?>
													    <option value="<?php echo $pt->id;?>"><?php echo $pt->pay_mode;?></option>
													    <?php } ?>
													</select></td>
													<td width:"10px"><input style="width:70px;" type="text" name="paidamt<?php echo $i;?>" id= "paidamt<?php echo $i;?>"required/></td>
													<td width:"10px"><input style="width:70px;" type="text" name="trans<?php echo $i;?>" id= "trans<?php echo $i;?>" required/></td>
												
													<input type="hidden" id="invoice_no<?php echo $i;?>" value="<?php echo $e_data->invoice_no;?>">
													<input type="hidden" id="usernm<?php echo $i;?>" value="<?php echo $this->session->userdata("username");?>">
												
													<!--<td width:"10px"><input type="button" value="Receive"></td>-->
													<td width:"10px">
													    <input type="button" class="btn btn-warning" name="ver<?php echo $i; ?>" id="ver<?php echo $i;?>" value="Verify"/>
													</td>
    												<!--<td width:"10px"></td>-->
    												<!--<td width:"10px"></td>-->
												</tr>
											
											<?php }
											$i++; } ?>
												
                                </tbody> 
							</table>
						</div>
						<a style=" margin:10px;" class="btn btn-warning" href="<?php //echo base_url();?>login/index">Back To Dashboard</a>
					</div>
				</div>
			</div>
			<!-- end: EXPORT DATA TABLE PANEL -->
		</div>
	</div>
	<!-- end: PAGE CONTENT-->
</div>