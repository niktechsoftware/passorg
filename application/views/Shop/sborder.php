<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <!-- Zero config.table start -->
     

      <div class="panel panel-white">
        <div class="panel-heading panel-red">
        <center><h2 class="text-bold">Demand List of Shop <?php echo $shopname;?></h2></center>
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
                                        <a href="#" class="export-pdf" data-table="#sample-table-2">
                                            Save as PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-png" data-table="#sample-table-2">
                                            Save as PNG
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-csv" data-table="#sample-table-2">
                                            Save as CSV
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-txt" data-table="#sample-table-2">
                                            Save as TXT
                                        </a>
                                    </li>
                                   <li>
                                        <a href="#" class="export-excel" data-table="#sample-table-2">
                                            Export to Excel
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="#" class="export-doc" data-table="#sample-table-2">
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
                         <input type="hidden" id = "reciever" value = "<?php echo $this->session->userdata("username");?>" />
          <div class=" table-responsive">
            <table id="sample-table-2" class="table table-striped table-bordered ">
              <thead>
                <tr >
                    <?php if($this->session->userdata("login_type")!=2){?>
                    <th>S.No.</th>
                    <th>Com. Name</th>
                    <th>P.Name</th>
                    <th>P. Code</th>
                    <th>Volume</th>
                    <th>Our Price</th>
                    <th>T.Of Pro</th>
                    <th>Image</th>
                    <th>Requirement</th>
                    <?php  if($ub=='b'){?>
                    <th>Shop Details</th>
                    <?php }else{
                     ?>
                      <th>Order Number</th>
              <?php    }}else{?>
               <th>S.No.</th>
                    <th>Com. Name</th>
                    <th>P.Name</th>
                    <th>P. Code</th>
                    <th>Volume</th>
                      <th>Mrp Price</th>
                    <th>P. Price</th>
                    <th>T.Of Pro</th>
                    <th>Image</th>
                    <th>Demand</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                     <th>Demand sub Branch</th>
                    <?php }?>
                 
                  </tr>
              </thead>
              <tbody>
             
                <?php 
                $tota=0;
                $pcode = array();
                $requir = array();
                $finalData = array();
                $s = 0;
                $subid =  $subBranchID;
                 $usernamefinal='b';
                //print_r($shopid);
                $ordernum=array();
                foreach($subid as $shop):
                    	
                    $branchData = array("subBranchID" => $shop);
                    
                	    $distinctpcode =	$this->db->query("select distinct(order_detail.p_code)  from order_detail join order_serial on order_detail.order_no=order_serial.order_no where order_serial.sub_branchid='$shop' and order_serial.status=0");
                		if($distinctpcode->num_rows()>0){
                			$j=0;
                		    $rowData = array();
                			foreach($distinctpcode->result() as $data):
                			    
                			    $prequiredQuantity = $this->db->query("select sum(order_detail.quantity) AS quantity from order_detail join order_serial on order_detail.order_no=order_serial.order_no where order_serial.sub_branchid='$shop' and order_serial.status=0 and p_code='$data->p_code'")->row();
                	      
                				if(($ub=='a')||($ub=='b')){
                					$this->db->select_sum("rec_quantity");
                					$this->db->select_sum("sale_quantity");
                					$this->db->where_in("subbranch_id",$shop);
                					$this->db->where("p_code",$data->p_code);
                					$dtsb= $this->db->get("subbranch_wallet"); 
                					
                					if($dtsb->num_rows()>0){
                						$receive=  $dtsb->row()->rec_quantity;
                						$saleq = $dtsb->row()->sale_quantity;
                					}
                					else{
                						$receive=0;
                						$saleq=0;
                					}
                					
                					$receiveb=0;
                					$saleqb=0;
                					$subdemand = (($receive-$saleq)-1);
                						$subdemand1 = (($receive-$saleq)-1);
                					// echo "subbranch quan =".$branchqu."<br>";
                					if($subdemand < $prequiredQuantity->quantity){
                					    $productData["product_code"] = $data->p_code;
                			            $productData["required_quantity"] =  0;
                			            $productData["available_quantity"]=0;
                						$this->db->where("id",$shop);
                						$sbde =  $this->db->get("sub_branch")->row();
                						$demandqu = $prequiredQuantity->quantity-$subdemand;
                						if(($this->session->userdata("login_type")==1) && ($ub=='b')){
                							$this->db->where("id",$data->p_code);
                							$stocadmin =  $this->db->get("stock_products");
                							if($stocadmin->num_rows()>0){
                								$receiveb=$stocadmin->row()->quantity-6;
                								$saleqb=0;
                							}
                							else{
                								$receiveb=-6;
                								$saleqb=0;
                							}
                						}
                						else {
                							if(($this->session->userdata("login_type")==1) && ($ub=='a')){
                								$this->db->select_sum("rec_quantity");
                								$this->db->select_sum("sale_quantity");
                								$this->db->where_in("branch_id",$sbde->district);
                								$this->db->where("p_code",$data->p_code);
                								$bqw =  $this->db->get("branch_wallet");
                								if($bqw->num_rows()>0){
                									$receiveba = $receiveb+$bqw->row()->rec_quantity-1;
                									$saleqba   = $saleqb+$bqw->row()->sale_quantity;
                								}
                								else{
                									$receiveba=-1;
                									$saleqba=0;
                								}
                								$demandqu =$demandqu-($receiveba-$saleqba);
                								$this->db->where("id",$data->p_code);
                								$stocadmin =  $this->db->get("stock_products");
                								
                								if($stocadmin->num_rows()>0){
                									$receiveb = $stocadmin->row()->quantity-6;
                									$saleqb = 0;
                								}
                								else{
                									$receiveb = $receiveba + 0 - 6;
                									$saleqb = $saleqba + 0;
                								}
                							}
                							else{
                
                								$this->db->select_sum("rec_quantity");
                								$this->db->select_sum("sale_quantity");
                								$this->db->where_in("branch_id",$sbde->district);
                								$this->db->where("p_code",$data->p_code);
                								$bqw =  $this->db->get("branch_wallet");
                								if($bqw->num_rows()>0){
                									$receiveb = $receiveb+$bqw->row()->rec_quantity-1;
                									$saleqb   = $saleqb+$bqw->row()->sale_quantity;
                								
                								}else{
                									$receiveb=-1;
                									$saleqb=0;
                								}
                							}
                						}
                						
                						
                
                						if((($receiveb-$saleqb)) < $demandqu){
                						     //$productData["available_quantity"] =  $demandqu;
                						      $productData["available_quantity"] =  $demandqu;
                							$demandqu=$demandqu-(($receiveb-$saleqb));
                							//$subranch[$shopid] ={$pcode,$requir
                							$productData["required_quantity"] = $demandqu;
                							
                				// 			array_push($productData, array("required_quantity" => $demandqu));
                							
                							$s++;
                						}
                						else{
                						    
                						    $productData["required_quantity"] = 0;
                						     $productData["available_quantity"] =  $demandqu;
                						}
                						//echo json_encode($subranch);
                						// print_r($subranch) ;
                						//print_r($productData);
                					}  
                					
                				}
                				else{ 
                					if($ub=='s'){
                					    $usernamefinal='sb';
                						$this->db->where("subbranch_id",$shop);
                						$this->db->where("p_code",$data->p_code);
                						$dt= $this->db->get("subbranch_wallet");
                						if($dt->num_rows()>0){
                							$receive=   $dt->row()->rec_quantity;
                							$saleq =    $dt->row()->sale_quantity;
                						}
                					    else{
                						    $receive=0;
                							$saleq=0;
                						}
                							$subdemand1 = (($receive-$saleq)-1);
                						if((($receive-$saleq)-1) < $prequiredQuantity->quantity){
                						 $productData["product_code"] = $data->p_code;
                			            $productData["required_quantity"] =  0;
                			            $productData["available_quantity"]=0;
                			            
                				// 			$productData["required_quantity"] = $totquan->quantity-(($receive-$saleq)-1);
                				            $productData["available_quantity"] =  $prequiredQuantity->quantity;
                				            $productData["required_quantity"] =  $prequiredQuantity->quantity-(($receive-$saleq)-1);
                							$s++;
                					
                						}
                						else {
                						 $productData["product_code"] = $data->p_code;
                						    $productData["available_quantity"] =  $prequiredQuantity->quantity;
                						    $productData["required_quantity"] =  0;
                						}
                					}
                				} 
                				$j++;
                					if($subdemand1 < $prequiredQuantity->quantity){
                					    array_push($rowData, $productData);
                					}
                			    
                			endforeach; 
                			$branchData = array_merge($branchData, array("productData" => $rowData));
                				
                		}
                    array_push($finalData, array("branchData" => $branchData));
                endforeach;
                
              /* echo "<pre>";
                 print_r($finalData);
                echo "</pre>";*/
                
              /*  if (in_array("100", $marks)) 
  { 
  echo "found"; 
  } 
else
  { 
  echo "not found"; 
  } */
                $productCode = array();
                $calculatedData = array();
                foreach($finalData as $branchData):
                    foreach($branchData as $productDetail):
                        if(array_key_exists("productData",$productDetail)) {
                            //$branchCodes = array();
                            //echo $productDetail['subBranchID'];
                            foreach($productDetail['productData'] as $product):
                                
                                if (!in_array($product['product_code'], $productCode)){
                                    $calculatedData[$product['product_code']] = $product['required_quantity'];
                                }
                                else {
                                    $calculatedData[$product['product_code']] += $product['required_quantity'];
                                }
                               // array_push($branchCodes,$productDetail['subBranchID']);
                                array_push($productCode, $product['product_code']);
                            endforeach;
                           // array_merge($productCode, $branchCodes);
                        }
                    
                    endforeach;
                    
                endforeach;
            /*    echo "<pre>";
                print_r($calculatedData);
                echo "</pre>";*/
                
                 if($this->session->userdata("login_type")==2){
               
            /*    echo "<pre>";
                print_r($calculatedData);
                echo "</pre>";*/
                
                $j=1; $i=0; $h=0; foreach($calculatedData as $key=>$val):
                     $this->db->where("invoice_number","");
                            	     $this->db->where("p_code",$key);
                            	     $this->db->where("status",0);
                            	     $this->db->where("reciver_usernm",$this->session->userdata("username"));
                            	    $this->db->where("sender_usernm","muskan");
                            	    $oldcheck = $this->db->get("product_trans_detail");
                   if($calculatedData[$key]>0){
                    $this->db->where("id",$key);
                    $stckdt1= $this->db->get("stock_products");
                    $stckdt2=$stckdt1->row();
                    
                     if($usernamefinal=="sb"){
                                                          $this->db->where("branch_id",$this->session->userdata("district"));
                                                          $this->db->where("p_code",$key);
                                                         $pprice =$this->db->get("branch_wallet")->row();
                                                      }else{
                                                            $this->db->where("branch_id",$this->session->userdata("id"));
                                                          $this->db->where("p_code",$key);
                                                         $pprice =$this->db->get("branch_wallet")->row();
                                                      }
                                                      ?>
                  <tr>
                        <td><?php echo $j;?></td>
                        <td><a href="#"><span ><?php echo $stckdt2->company;?></span></a></td>
                        <td>
                             <?php 
                              echo $stckdt2->name;
                              ?>
                        </td>
                      <td><input type="hidden" id="p_code<?php echo $i;?>"  value ="<?php echo $stckdt2->id;?>" /><?php echo $stckdt2->hsn;?></td>
                        <td><?php echo $stckdt2->size;?></td>
                        <td><input  id="sitem_price<?php echo $i; ?>"  class="text-uppercase" name="sitem_price<?php echo $i; ?>" value ="<?php echo $pprice->mrp_price;?>" style="width:70px;"></td></td>
                             <td> <input  id="item_price<?php echo $i; ?>"  class="text-uppercase" name="item_price<?php echo $i; ?>" value ="<?php echo $pprice->selling_price;?>" style="width:70px;"></td>
                          
                        <td><?php echo $stckdt2->p_type;?></td>
                        <td><?php if($stckdt2->file1>0){ ?><img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stckdt2->file1; ?>"
                                    style="height:50px;width:100px;"><?php } else{ ?> <img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stckdt2->file2; ?>"
                                                style="height:50px;width:100px;"><?php }?>"
                        </td>
                   
                        <td><a href="#"><span style="color:#01a9ac;font-size:20px;font-weight:1px;"><?php echo $calculatedData[$key]; ?></span></a>

              
                   </td>
                  <td>
                               <?php if($oldcheck->num_rows()>0){ $acquan=$oldcheck->row()->quantity;?>
                                <input readonly id="item_quantity<?php echo $i; ?>" class="text-uppercase"  name="item_quantity<?php echo $i; ?>" value = "<?php echo $acquan;?>" style="width:70px;" type="text"/>
                               <?php }else { $acquan= $calculatedData[$key];?>
                               <button style="border-radius:50%;" type='button' class="btn btn-primary" id="add<?php echo $i;?>" >+</button>
                                <input readonly id="item_quantity<?php echo $i; ?>" class="text-uppercase"  name="item_quantity<?php echo $i; ?>" value = "<?php echo $calculatedData[$key];?>" style="width:70px;" type="text"/>
                                <button style="border-radius:50%;" type='button' class="btn btn-success" id="sub<?php echo $i;?>">-</button>
                          <?php }?>
                          </td>
                            <td><?php ?>
                                <input type="text" readonly id="total_price<?php echo $i; ?>" class="text-uppercase"  name="total_price<?php echo $i; ?>" value ="<?php if($oldcheck->num_rows()>0){echo number_format($oldcheck->row()->quantity*$pprice->selling_price, 2,'.', '');;}else{echo number_format($calculatedData[$key]*$pprice->selling_price, 2,'.', '');}?>" style="width:70px;" type="text"/>
                          </td>
                            <td><?php if($oldcheck->num_rows()>0){?><button class ='btn btn-blue' >Asked</button><?php $h++; $tota=$tota+$oldcheck->row()->quantity*$oldcheck->row()->updated_price;  } else {?><button class ='btn btn-success' id="send<?php echo $i;?>">Ask</button><?php }?></td>
                               <script>
                                      $("#send<?php echo $i;?>").click(function(){
                                            var p_code = $("#p_code<?php echo $i;?>").val();
                                            var reciever = $("#reciever").val();
                                            var quantity = Number($("#item_quantity<?php echo $i; ?>").val());
                                            var sprc = parseFloat($("#sitem_price<?php echo $i;?>").val());
                                            var prc = parseFloat($("#item_price<?php echo $i;?>").val()); 
                                            var totalp  =   parseFloat($("#total").val());
                                              var totalproduct  =   Number($("#totalproduct").val());
                                            totalproduct=totalproduct+1;
                                            //alert(p_code+ reciever+quantity);
                                            $.post("<?php echo site_url("stockController/askSendStockbyadmin") ?>", {p_code : p_code , reciever: reciever, quantity : quantity,prc : prc , sprc : sprc}, function(data){
                                           
                                            if(data==1){
                                               var  cu_tt=totalp+(quantity*prc);
                                                 $("#total").val(cu_tt.toFixed(2));
                                               
                                           $("#totalproduct").val(totalproduct);
                                                  $('#send<?php echo $i;?>').html("Asked");
                                            }else{
                                                $('#send<?php echo $i;?>').html(data);
                                            }
                                            
                                        });
                                      });
                                    $("#add<?= $i;?>").click(function(){
                                        $("#add<?php echo $i;?>").hide();
                                          var t_qty = Number($("#item_quantity_r<?php echo $i;?>").val());
                                          var old_qty = Number($("#item_quantity<?php echo $i;?>").val());
                                          var prc = parseFloat($("#item_price<?php echo $i;?>").val()); 
                                        
                                          var new_qty = old_qty + 1;
                                         totalproduct=totalproduct+1;
                                          var sub_ttt = new_qty * prc;
                                          var cu_tt = parseFloat($('#total').val()) + prc;
                                          $("#item_quantity<?php echo $i;?>").val(new_qty);
                                          $("#total_price<?php echo $i;?>").val(sub_ttt.toFixed(2));
                                          
                                           $("#add<?php echo $i;?>").delay(2000).show();
                                        // //   alert(sub_ttt);
                                       });
                                     
                                     
                                     
                                       $("#sub<?= $i;?>").click(function(){
                                           $("#sub<?= $i;?>").hide();
                                          var t_qty = Number($("#item_quantity_r<?php echo $i;?>").val());
                                          var old_qty = Number($("#item_quantity<?php echo $i;?>").val());
                                          var prc = parseFloat($("#item_price<?php echo $i;?>").val()); 
                                          
                                          if(old_qty>0){
                                          var new_qty = old_qty - 1;
                                          var sub_ttt = new_qty * prc;
                                          var cu_tt = parseFloat($('#total').val()) - prc;
                                          $("#item_quantity<?php echo $i;?>").val(new_qty);
                                           $("#total_price<?php echo $i;?>").val(sub_ttt.toFixed(2));
                                          
                                         
                                          }
                                         
                                              $("#sub<?= $i;?>").delay(2000).show();
                                        // //   alert(sub_ttt);
                                       });
                                       
                                   
                               </script>
                 
                  <td>  <?php  
                  
                  // $bideo =   $this->db->query("select order_serial.order_no from order_serial join order_detail on order_serial.order_no = order_detail.order_no where order_detail.p_code='$roe' and order_serial.status=0 ");
                 	      
                 if($ub=='s'){
                    $sbid = $this->session->userdata("id");
                    
                       $bide =   $this->db->query("select distinct(order_serial.order_no)  from order_serial join order_detail on order_serial.order_no = order_detail.order_no where order_serial.sub_branchid ='$sbid' and order_detail.p_code='$key' and order_serial.status=0 ");
                       foreach($bide->result() as $t):
                           echo $t->order_no."<br>";
                           endforeach;
                 }
                 else{
                     $this->db->distinct();
                     $this->db->select('order_serial.sub_branchid'); 
                        $this->db->from('order_serial');
                        $this->db->join('order_detail', 'order_serial.order_no = order_detail.order_no', 'left'); 
                        $this->db->where_in("order_serial.sub_branchid",$subBranchID);
                        $this->db->where('order_detail.p_code',$key);
                        $bide = $this->db->get();
                      // $bide =   $this->db->query("select distinct(order_serial.sub_branchid)  from order_serial join order_detail on order_serial.order_no = order_detail.order_no where order_detail.p_code='$key' and order_serial.status=0  and  order_serial.sub_branchid IN  '$subBranchID' ");
                    if($bide->num_rows()>0){
                        foreach($bide->result() as $t):
                                $ordernum=array();
                                $this->db->where("id",$t->sub_branchid);
                                $getsbd = $this->db->get("sub_branch")->row();
                                echo $getsbd->username;
                                 $prequiredQuantity = $this->db->query("select sum(order_detail.quantity) AS quantity from order_detail join order_serial on order_detail.order_no=order_serial.order_no where order_serial.sub_branchid='$t->sub_branchid' and order_serial.status=0 and p_code='$key'")->row();
                
                               echo "[".$prequiredQuantity->quantity."] <br>";
                        
                        endforeach;
                    }
                 }
                 ?> 
                   </td>
                   </tr>
                    <?php  $j++;$i++;  } endforeach;   
                }else{
                    
                    
                     $j=1;  foreach($calculatedData as $key=>$val):
                   if($calculatedData[$key]>0){
                    $this->db->where("id",$key);
                    $stckdt1= $this->db->get("stock_products");
                    $stckdt2=$stckdt1->row();
                    
                     if($usernamefinal=="sb"){
                                                          $this->db->where("branch_id",$this->session->userdata("district"));
                                                          $this->db->where("p_code",$key);
                                                         $pprice =$this->db->get("branch_wallet")->row();
                                                      }else{
                                                            $this->db->where("branch_id",$this->session->userdata("id"));
                                                          $this->db->where("p_code",$key);
                                                         $pprice =$this->db->get("branch_wallet")->row();
                                                      }
                                                      ?>
                  <tr>
                        <td><?php echo $j;?></td>
                        <td><a href="#"><span ><?php echo $stckdt2->company;?></span></a></td>
                        <td>
                             <?php 
                              echo $stckdt2->name;
                              ?>
                        </td>
                      <td><?php echo $stckdt2->hsn;?></td>
                        <td><?php echo $stckdt2->size;?></td>
                      
                             <td><?php echo $pprice->selling_price;?></td>
                          
                        <td><?php echo $stckdt2->p_type;?></td>
                        <td><?php if($stckdt2->file1>0){ ?><img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stckdt2->file1; ?>"
                                    style="height:50px;width:100px;"><?php } else{ ?> <img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stckdt2->file2; ?>"
                                                style="height:50px;width:100px;"><?php }?>"
                        </td>
                   
                        <td><a href="#"><span style="color:#01a9ac;font-size:20px;font-weight:1px;"><?php echo $calculatedData[$key]; ?></span></a>

              
                   </td>
                
                  <td>  <?php  
                  
                  // $bideo =   $this->db->query("select order_serial.order_no from order_serial join order_detail on order_serial.order_no = order_detail.order_no where order_detail.p_code='$roe' and order_serial.status=0 ");
                 	      
                 if($ub=='s'){
                    $sbid = $this->session->userdata("id");
                    
                       $bide =   $this->db->query("select distinct(order_serial.order_no)  from order_serial join order_detail on order_serial.order_no = order_detail.order_no where order_serial.sub_branchid ='$sbid' and order_detail.p_code='$key' and order_serial.status=0 ");
                       foreach($bide->result() as $t):
                           echo $t->order_no."<br>";
                           endforeach;
                 }
                 else{
                     $this->db->distinct();
                     $this->db->select('order_serial.sub_branchid'); 
                        $this->db->from('order_serial');
                        $this->db->join('order_detail', 'order_serial.order_no = order_detail.order_no', 'left'); 
                        $this->db->where_in("order_serial.sub_branchid",$subBranchID);
                        $this->db->where('order_detail.p_code',$key);
                        $bide = $this->db->get();
                      // $bide =   $this->db->query("select distinct(order_serial.sub_branchid)  from order_serial join order_detail on order_serial.order_no = order_detail.order_no where order_detail.p_code='$key' and order_serial.status=0  and  order_serial.sub_branchid IN  '$subBranchID' ");
                    if($bide->num_rows()>0){
                        foreach($bide->result() as $t):
                                $ordernum=array();
                                $this->db->where("id",$t->sub_branchid);
                                $getsbd = $this->db->get("sub_branch")->row();
                                echo $getsbd->username;
                                 $prequiredQuantity = $this->db->query("select sum(order_detail.quantity) AS quantity from order_detail join order_serial on order_detail.order_no=order_serial.order_no where order_serial.sub_branchid='$t->sub_branchid' and order_serial.status=0 and p_code='$key'")->row();
                
                               echo "[".$prequiredQuantity->quantity."] <br>";
                        
                        endforeach;
                    }
                 }
                 ?> 
                   </td>
                   </tr>
                    <?php  $j++;} endforeach;   
                }
               
                   ?>
              </tbody>
              
            </table>
          </div>
          <?php if($this->session->userdata("login_type")==2){?>
           <form action="<?= base_url();?>index.php/stockController/askforadmintoDemand" method="post">   
          <div class="col-md-12 row">
                  <div class="col-md-4 ">  <input type ="text" id="totalproduct" value="<?php echo $h;?>" readonly/> <input id="total" name="total" value = "<?php echo number_format($tota,2,'.', '');?>" class="form-control" style="width:180px;" type="text" required  readonly /> </div>
                     <input type="hidden" id="number" name="number" value = "<?php  echo $i-1;?>" class="form-control" style="width:180px;" type="text" required   />
                   <div class="col-md-4 "><button class ="btn btn-purple" id="genInvoice" >Generate Invoice</button>
        </div>
        </div>
        </form>
          <?php } ?>
        </div>
     
   
      </div>
      
      
      


    </div>
  </div>
</div>