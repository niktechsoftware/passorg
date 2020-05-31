 
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- start: EXPORT DATA TABLE PANEL  -->
			<div class="panel panel-white">
			<div class="panel-heading panel-red">
					<h4 class="panel-title"> <span class="text-bold">Pending delivered Invoices  List</span></h4>
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
<h4 class="media-heading text-center">Welcome to Pending Invoices to delivered Area </h4>
<p><br>
</p> </div>
				    
					<div class="row">
						<div class="col-md-12 space20">
							<div class="btn-group pull-right">
								<button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
									Export <i class="fa fa-angle-down"></i>
								</button>
								
								<ul class="dropdown-menu dropdown-light pull-right">
									<li>-->
										<a href="#" class="export-pdf" data-table="#sample-table-2" >
											Save as PDF
										</a>
									</li>
									<li>
										<a href="#" class="export-png" data-table="#sample-table-2">
											Save as PNG
										</a>
									</li>
									<li>
										<a href="#" class="export-csv" data-table="#sample-table-2" >
											Save as CSV
										</a>
									</li>
									<li>
										<a href="#" class="export-txt" data-table="#sample-table-2" >
											Save as TXT
										</a>
									</li>
									<li>
										<a href="#" class="export-xml" data-table="#sample-table-2" >
											Save as XML
										</a>
									</li>
									<li>
										<a href="#" class="export-sql" data-table="#sample-table-2" >
										Save as SQL
										</a>
									
									
										<a href="#" class="export-json" data-table="#sample-table-2" >
											Save as JSON
										</a>
									<li>
										<a href="#" class="export-excel" data-table="#sample-table-2" >
											Export to Excel
										</a>
									</li>
									<li>
										<a href="#" class="export-doc" data-table="#sample-table-2" >
										Export to Word
									</a>
									</li>
									<li>
										<a href="#" class="export-powerpoint" data-table="#sample-table-2">
											Export to PowerPoint
										</a>
									</li>
								
							</div>
						</div>
					</div>
					
						<div class="table-responsive">
							<table class="table table-striped table-hover" id="sample-table-2">
							 <thead>
                                  <tr >
                                    <th>SNO</th>
                                    <th>Invoice Number</th>
                                    <th>Subscriber Name</th>
                                     <th>Subscriber Mobile</th>
                                    <th>Total Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Order Date</th>
                                     <th>Sender Username</th>
                                    <th>Pay Mode</th>
                                    <th>Paid amount</th>
                                    <th>Trans. number</th>
                                    <th>Otp</th>
                                     <th>Status</th>
                                  
                                  </tr>
                                </thead>
								<tbody>
								<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.1.1.min.js"></script>
							
                  <?php $i=1;
                     if($oinvoice){
                  ?>
                  <?php  
                  foreach($oinvoice->result() as $row):
                  //print_r($row);exit();?>
                  <tr class="text-uppercase text-center">
                    <td><?php echo $i;?></td>
                       <td><?php if($row->status==1){?><a href="<?php echo base_url();?>employeeController/new_invoice/<?php echo $row->order_no;?>" class="btn btn-primary"><?php echo $row->invoice_no;?></a><?php }else{?><a href="#" class="btn btn-primary"><?php echo $row->invoice_no;?></a><?php }?></td>
                    <?php 
                             $this->db->select_sum('quantity');
                             $this->db->select_sum('subtotal');
                             $this->db->where('order_no',$row->order_no);
                           // $this->db->where('cust_username',$row->cust_username);
                            // $this->db->where('date',$row->order_date);
                             $dt1= $this->db->get("order_detail")->row();
                             // $username=$this->session->userdata('username');
                             $this->db->where('id',$row->cust_id);
                             $custdetail=$this->db->get('customers')->row();
                           ?>
                      <td><?php echo $custdetail->name;?></td>
                       <td><?php echo $custdetail->mobile;?></td>   
                      <td><?php echo $dt1->quantity;?></td>
                      <td><?php echo $dt1->subtotal;?></td>
                      <td><?php echo $row->order_date;?></td>
                    <td><?php echo $row->sub_branchid;?></td>
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
													<td width:"10px"><input style="width:70px;" type="text" name="otp<?php echo $i;?>" id= "otp<?php echo $i;?>" required/></td>
												
													<input type="hidden" id="invoice_no<?php echo $i;?>" value="<?php echo $row->invoice_no;?>">
													<input type="hidden" id="usernm<?php echo $i;?>" value="<?php echo $this->session->userdata("username");?>">
												
													<!--<td width:"10px"><input type="button" value="Receive"></td>-->
													<td width:"10px">
													    <input type="button" class="btn btn-success" name="ver<?php echo $i; ?>" id="ver<?php echo $i;?>" value="Confirm"/>
													    <input type="button" class="btn btn-danger" id="versd<?php echo $i; ?>" value="Wrong otp" />
													</td>
              </tr>  							
               
              <script>
                  
                       $('#ver<?php echo $i;?>').hide();
                        $('#versd<?php echo $i;?>').hide();
                 $('#otp<?php echo $i;?>').keyup(function(){
              var invoice=$('#invoice_no<?php echo $i;?>').val();
              var otp =$('#otp<?php echo $i;?>').val();
              
              $.post("<?php echo site_url('allFormController/confirmotp')?>", {invoice:invoice , otp : otp}, function(data){
                //  alert(data);
                  if(data=="1"){
                      $('#versd<?php echo $i;?>').hide();
                    $('#ver<?php echo $i;?>').show();
                  }else{
                       $('#versd<?php echo $i;?>').show();
                       $('#ver<?php echo $i;?>').hide();
                  }
                    });
                    });
                    $('#ver<?php echo $i;?>').click(function(){
                    var invoice=$('#invoice_no<?php echo $i;?>').val();
                        var paidamount =$('#paidamt<?php echo $i;?>').val();
                        var totalamount =$('#ordamt<?php echo $i;?>').val();
                         var mode =$('#p_mode<?php echo $i;?>').val();
                        var transid =$('#trans<?php echo $i;?>').val();
                       
              $.post("<?php echo site_url('allFormController/confirmotpmatch')?>", {invoice:invoice , paidamount : paidamount, totalamount : totalamount, mode : mode, transid : transid }, function(data){
                alert(data);
                $('#ver<?php echo $i;?>').val(data);
              });
                    });
                    </script>  
                  <?php  $i++;
                endforeach;
                   } ?>
                   
                   
                   
                   
                   <!-- -->
                     <?php
                     if($pinvoice){
                         
                  ?>
                  <?php  
                  foreach($pinvoice->result() as $row):
                      //echo $row->id;
                  //print_r($row);exit();?>
                  <tr class="text-uppercase text-center">
                    <td><?php echo $i;?></td>
                      <td><a href="<?php echo base_url();?>deliveryBoyController/invoice/<?php echo $row->invoice_no;?>" class="btn btn-danger"><?php echo $row->invoice_no;?></a></td>
                      <?php 
                             $this->db->where('invoice_number',$row->invoice_no);
                                         $chk = $this->db->get('product_trans_detail');
                                         	$tt=0; ?>
                      <td><?php echo $row->reciver_usernm;
                     /* $this->db->where("username",$row->reciver_usernm);
                     $bname = $this->db->get("branch")->row();*/
                      ?></td>
                         <td><?php echo $this->subscriber->getmobilefromuser($row->reciver_usernm);?></td>   
                     <?php 
                      $this->db->where('invoice_number',$row->invoice_no);
													$this->db->select_sum('quantity');
													$qty= $this->db->get('product_trans_detail')->row();
													?>
													<td width:"10px"><a class="btn btn-info" href="<?php echo base_url();?>shopController/recieveproductlist"><?php echo $qty->quantity; ?></a></td>
                      <?php foreach($chk->result() as $ro):
													      $this->db->where("id",$ro->p_code);
													     $ps =  $this->db->get("stock_products")->row();
													    $this->db->where("branch_id",$this->session->userdata("district"));
													    $this->db->where("p_code",$ro->p_code);
													    $bw =$this->db->get("branch_wallet")->row();
													      $tt = $tt + $ro->quantity*$bw->selling_price;
													      endforeach;
    												    ?>
					<td width:"10px"><input style="width:70px;" type="text" value="<?php echo $tt;?>" name="ordamt<?php echo $i;?>" id= "ordamt<?php echo $i;?>" readonly/></td>
                      
                      <td><?php echo $row->date;?></td>
                     <td width:"10px"><?php echo $row->reciver_usernm;?></td>
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
													<td width:"10px"><input style="width:70px;" type="text" name="otp<?php echo $i;?>" id= "otp<?php echo $i;?>" required/></td>
												
													<input type="hidden" id="invoice_no<?php echo $i;?>" value="<?php echo $row->invoice_no;?>">
													<input type="hidden" id="usernm<?php echo $i;?>" value="<?php echo $this->session->userdata("username");?>">
												
													<!--<td width:"10px"><input type="button" value="Receive"></td>-->
													<td width:"10px">
													    <input type="button" class="btn btn-success" name="ver<?php echo $i; ?>" id="ver<?php echo $i;?>" value="Confirm"/>
													    <input type="button" class="btn btn-danger" id="versd<?php echo $i; ?>" value="Wrong otp" />
													</td>
              </tr>  
             
                  <script>
                  
                       $('#ver<?php echo $i;?>').hide();
                        $('#versd<?php echo $i;?>').hide();
                 $('#otp<?php echo $i;?>').keyup(function(){
              var invoice=$('#invoice_no<?php echo $i;?>').val();
              var otp =$('#otp<?php echo $i;?>').val();
              
              $.post("<?php echo site_url('allFormController/confirmotp')?>", {invoice:invoice , otp : otp}, function(data){
                //  alert(data);
                  if(data=="1"){
                      $('#versd<?php echo $i;?>').hide();
                    $('#ver<?php echo $i;?>').show();
                  }else{
                       $('#versd<?php echo $i;?>').show();
                       $('#ver<?php echo $i;?>').hide();
                  }
                    });
                    });
                    $('#ver<?php echo $i;?>').click(function(){
                    var invoice=$('#invoice_no<?php echo $i;?>').val();
                        var paidamount =$('#paidamt<?php echo $i;?>').val();
                        if(paidamount.length > 0){
                        var totalamount =$('#ordamt<?php echo $i;?>').val();
                         var mode =$('#p_mode<?php echo $i;?>').val();
                        var transid =$('#trans<?php echo $i;?>').val();
                       
              $.post("<?php echo site_url('allFormController/confirmotpmatch')?>", {invoice:invoice , paidamount : paidamount, totalamount : totalamount, mode : mode, transid : transid }, function(data){
                alert(data);
                $('#ver<?php echo $i;?>').val(data);
              });
                        }else{
                            alert("plaese fill paid amount");
                        }
                    });
                    
                    </script>  
                  <?php  $i++;
                endforeach;
                   } ?>
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