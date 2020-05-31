<div class="page-body">
  
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- start: EXPORT DATA TABLE PANEL  -->
			<div class="panel panel-white">
			<div class="panel-heading panel-red">
					<h4 class="panel-title"> <span class="text-bold">Receive And Transfer Product List</span></h4>
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
                                    <h4 class="media-heading text-center">Welcome to Receive OR Transfer Product List </h4>
                                    <p>Here you can see Tarnsfer Product List .<br>
                                    </p> 
                                </div>
				
					<form action="<?php echo base_url();?>index.php/shopController/transferproductlist/<?php echo $this->uri->segment(3);?>"  method ="post" role="form" id="form">
				    <!--search criteriya-->
					<div class="col-sm-12">
									<div class="form-group col-sm-6">
										<label class="col-sm-4 control-label" for="form-field-20">
											Start Date<span class="symbol required"></span>
										</label>
										<div class="col-sm-8">
											<input type="date" data-date-format="yyyy-mm-dd" data-date-viewmode="years" id="sdate" name="sdate" class="form-control date-picker">
										</div>
									</div>

									<div class="form-group col-sm-6">
										<label class="col-sm-3 control-label" for="form-field-20">
											End Date<span class="symbol required"></span>
										</label>
										<div class="col-sm-9">
											<input type="date" data-date-format="yyyy-mm-dd" data-date-viewmode="years" id="edate" name="edate" class="form-control date-picker">
										</div>
									</div>
								</div>
								<br>
							<center>OR</center>
								<div class="col-sm-12">
								<div class="form-group col-sm-6">
										<label class="col-sm-4 control-label" for="form-field-20">
											Invoice No.<span class="symbol required"></span>
										</label>
										<div class="col-sm-8">
											<input type="text"  id="invoice" name="invoice" class="form-control">
										</div>
									</div>
										<div class="form-group col-sm-6">
										<label class="col-sm-4 control-label" for="form-field-20">
										<span >  Product Type   </span>
										</label>
										<div class="col-sm-4">
            								<select name="selectType"   style="width: 120px;" class="form-control" required="required" >
            				                    <option  value="" >Select Type</option>
            				                    <option  value=0 >Not Recieved</option>
            				                    <option  value=1 >Recieved</option>
            				                      <option  value=2 >Both</option>
            				                </select>
										</div>
										
										
										<div class="col-sm-4">
									<input type="submit"   value ="Submit" class="btn btn-success "> 
										</div>
									</div>
				                </div>
				                
				                
				        </form>        
				
				<hr>
				<div id ='invoicesms'> </div>
				<!-- search criteriya end -->
					<div class="row">
						<div class="col-md-12 space20">
							<div class="btn-group pull-right">
								<button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
									Export <i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu dropdown-light pull-right">
								
								</ul>
							</div>
						</div>
					</div>
  
  

  
    <table id="sample-table-2" class="table table-striped table-bordered nowrap">
      <thead>
        <tr style="background-color:#1ba593; color:white;">
          <th style="width:8px;">Sno</th>

                <th style="width:20px;">Product Name</th>
                <th style="width:20px;">Product Code</th>
                <th style="width:40px;">Size</th>
                <th style="width:20px;">Image </th>
                <th style="width:30px;">Quantity</th>
                <th style="width:30px;"><?php if($match=="reciver_usernm"){echo "Sender Username";}else{ echo "Reciever Name";}?></th>
                <th style="width:30px;">Invoice Number</th>
                <th style="width:30px;">Date</th>
                <th style="width:30px;">Recieve</th>
          
            </tr>
      </thead>
      <tbody style="margin-top:2px;">
        <?php
                  
                    $i=1;foreach ($brwproduct->result() as  $value):
                $this->db->where('id',$value->p_code);
                  $sproduct1=$this->db->get('stock_products'); 
                  if($sproduct1->num_rows()>0){
                     $sproduct= $sproduct1->row();
                  
                  ?>
        <tr >
          <td><?php echo $i;?>
          </td>
          <td style="width:20px;"><?php if($sproduct->name){ echo $sproduct->name;}else{ echo "N/A";}?><input type ="hidden" id="tid<?php echo $i;?>" value="<?php echo $value->id;?>"/> </td>
          <td style="width:2px;"><?php if($sproduct->hsn) {echo $sproduct->hsn;}else{ "N/A" ;}?> </td>
           <td style="width:40px;color:black;"><?php if($sproduct->size) {echo $sproduct->size;} else{ "N/A"; }?> </td>
           <td style="width:30px;color:black;"><?php if($sproduct->file1){ ?><img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $sproduct->file1; ?>"
                                                style="height:50px;width:30px;"class="zoom1" ><?php } else{ echo "N/A"; }?> </td>
          <td><?php if($value->quantity){ echo $value->quantity;}else{ echo "N/A";}?> </td>
                    <td><?php if($match=="reciver_usernm") {echo $value->sender_usernm;} else{ echo $value->reciver_usernm;}?> </td>
                     <td><?php if($value->invoice_number){ echo $value->invoice_number;} else{ echo "N/A"; }?> </td>
                      <td><?php echo date("d-m-y",strtotime($value->date));;?> </td>
              <td><?php if($match=="reciver_usernm"){ if($value->status==0){ ?><button id= "nr<?php echo $i;?>" class="btn btn-danger"> Not Recieve </button><?php } else{?>  <button class="btn btn-success"> Recieved</button><?php }}
              else{  if($value->status==0){ echo "Not Recieved"; } else{ echo "Recieved";}} ?></td>
        <script>
            
            $("#invoice").keyup(function(){
                 var invoice=$("#invoice").val();
                                    //alert("r");
                    $.ajax({
                        "url": '<?php echo site_url("stockController/checkInvoice");?>',
						"method": 'POST',
						"data": {invoice : invoice},
						beforeSend: function(data) {
						 
							$("#invoicesms").html("<div>Wait....</div>")
						},
						success: function(data) {
						              $("#invoicesms").html(data);     
						},
						error: function(data) {
							$("#invoicesms").val("Error")
						}
                   });
            });
            $("#nr<?php echo $i;?>").click(function(){
                                    var pid=$("#tid<?php echo $i;?>").val();
                                   // alert(pid);
                    $.ajax({
                        "url": '<?php echo site_url("stockController/updateProductTranStatus");?>',
						"method": 'POST',
						"data": {pid : pid},
						beforeSend: function(data) {
						 
							$("#nr<?php echo $i;?>").val("Wait....")
						},
						success: function(data) {
						              $("#nr<?php echo $i;?>").html(data);     
						},
						error: function(data) {
							$("#nr<?php echo $i;?>").val("Error")
						}
                   });
            });
            
        </script>
        </tr>
        <?php  } $i++;endforeach;?>
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