                               <div class="page-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Zero config.table start -->
                                            <div class="panel panel-white">
                                   
                                                <div class="panel-heading panel-red">
                                                <center>  <h5 class="text-bold"> Order List Details</h5></center>
                                                </div>
                                               
                                                <div class="panel-body">
                                                  <div class="col-sm-12"> 
                                                  <div class="col-sm-6">
                                               <div class=" table-responsive">
                  <table id="pendingorder" class="table  table-bordered ">
                <thead>
                  <tr style="background-color:#1ba593; color:white;">
                    <th>SNO</th>
                    <th>Username</th>
                   <th> Name</th>
                  </tr>
                </thead>
                <tbody>
                    
                  <?php 
                       //print_r($orderdetails);
                    $pcode = array();
                    $requir = array();
                    $finalData = array();
                    $i=0; $m=0; $k=0; $o=0;  $j=0;$p=0;
                   if($subBranchID){
                       foreach($subBranchID as $shop):
                        $branchData = array("subBranchID" => $shop);
                    
                	    $distinctpcode =	$this->db->query("select distinct(order_detail.p_code)  from order_detail join order_serial on order_detail.order_no=order_serial.order_no where order_serial.sub_branchid='$shop' and order_serial.status=0");
                		if($distinctpcode->num_rows()>0){
                			$j=0;
                		    $rowData = array();
                			foreach($distinctpcode->result() as $data):
                			    
                			    $prequiredQuantity = $this->db->query("select sum(order_detail.quantity) AS quantity from order_detail join order_serial on order_detail.order_no=order_serial.order_no where order_serial.sub_branchid='$shop' and order_serial.status=0 and p_code='$data->p_code'")->row();
                	      
                			
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
                						if(($this->session->userdata("login_type")==1) && ($type=='b')){
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
                							if(($this->session->userdata("login_type")==1) && ($type=='a')){
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
                							
                						
                						}
                						else{
                						    
                						    $productData["required_quantity"] = 0;
                						     $productData["available_quantity"] =  $demandqu;
                						}
                						//echo json_encode($subranch);
                						// print_r($subranch) ;
                						//print_r($productData);
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
               }   
          /*     echo "<pre>";
                 print_r($finalData);
                echo "</pre>";
                
                */
                
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
              /*  echo "<pre>";
                print_r($calculatedData);
                echo "</pre>";*/
                $avail=array();
                $availabelshop = array();
                $Demandshop = array();
                $requi=array();
                foreach($finalData as $branchData):
                   $k=0; foreach($branchData as $productDetail):
                        if(array_key_exists("productData",$productDetail)) {
                            $demandcounter =0;
                            $avaicounter=0;
                             foreach($productDetail['productData'] as $product):
                                if($product['required_quantity']>0){
                                   $demandcounter++;
                                }
                                if($product['available_quantity']>0){
                                  $avaicounter++;
                                }
                                 
                             endforeach;
                             if($demandcounter>0){
                               array_push($Demandshop,$productDetail['subBranchID']);
                                
                             }
                             else{
                                 if($avaicounter>0){
                               array_push($availabelshop, $productDetail['subBranchID']);
                                 }
                             }
                             $k++;
                          
                              //array_push($Demandshop, $requireproduct);
                              //array_push($availabelshop, $availableproduct);
                              //echo $productDetail['subBranchID'];
                        }
                    endforeach;   
                 endforeach;
               /*   echo "<pre>";
                print_r($Demandshop);
                echo "</pre>";*/
                $notinavai=array();
                $notindemand=array();
                if($Demandshop){
                    $this->db->distinct();
                    $this->db->select("district");
                    $this->db->where_in("id",$Demandshop);
                   $getdemandbranch=  $this->db->get("sub_branch");
                   if($getdemandbranch->num_rows()>0){
                  $h=0; foreach($getdemandbranch->result() as $gdb):
                       $notinavai[$h]=$gdb->district;
                      $h++; endforeach;
                }
                }
                /* if($availabelshop){
                    $this->db->distinct();
                    $this->db->select("district");
                    $this->db->where_in("id",$availabelshop);
                    $this->db->get("sub_branch");
                     $getavibranch=  $this->db->get("sub_branch");
                  $h=0; foreach($getavibranch->result() as $gdb1):
                       $notinavai[$h]=$gdb1->district;
                      $h++; endforeach;
                }*/
                
                   if($type=='a'){
                       
                                if( $this->uri->segment(3)==2){
                                 $h=1;   
                                 if($Demandshop){
                                 $arrayadmind=array();
                                    foreach($Demandshop as $row1):
                                     $this->db->where("id",$row1);
                                     $sbhj =  $this->db->get("sub_branch")->row();
                                     $arrayadmind[$h]=$sbhj->district;
                                   $h++; endforeach;
                                   
                                     $this->db->where_in("id",$arrayadmind);
                                     $bt =  $this->db->get("branch");
                                    foreach($bt->result() as $b){   
                                    	$this->db->where("reciver_usernm",$b->username);
                                	    	$this->db->where("status",0);
                                	    	$this->db->where("invoice_number !=","");
                                	    	
                                		    $checkold = $this->db->get("product_trans_detail");
                                		    if($checkold->num_rows()<1){
                                    ?>
                	                    <tr class="text-uppercase text-center">
                                            <td><?php echo $h;?></td>
                                    
                                            <td><button id ="selectlidad<?php echo $h;?>" value = "<?php echo $b->id;?>" class="btn btn-success"><?php echo  $b->username;?></button></td>
                                                    <td><?php echo $b->b_name;?></td>
                                              </tr>
                                            <script>
                                                $('#selectlidad<?php echo $h;?>').click(function(){
                                                    var sid = $('#selectlidad<?php echo $h;?>').val();
                                                    //alert(sid);
                                                    var type =1;
                                                    //alert(type);
                                                $.post("<?php echo site_url('shopController/findlessproductb')?>", { sid : sid ,type : type }, function(data){ 
                                                  $('#showdetails').html(data);
                                                  })
                                               });
                                          </script>
                                        <?php $h++; }} }}else{
                                              if($availabelshop){
                                           $h=1; 
                                                    $this->db->distinct();
                                                    $this->db->select("district");
                                                    $this->db->where_in("id",$availabelshop);
                                                    $bt1 =  $this->db->get("sub_branch");
                                                    if($bt1->num_rows()>0){
                                                     foreach($bt1->result() as $bt4){
                                                        //echo "hh".$bt4->district;
                                                        $this->db->where_not_in("id",$notinavai);
                                                         $this->db->where("id",$bt4->district);
                                                        
                                                        $bt= $this->db->get("branch");
                                                        if($bt->num_rows()>0){
                                                            $bt=$bt->row();
                                                        
                                                        	$this->db->where("reciver_usernm",$bt->username);
                                                	    	$this->db->where("status",0);
                                                	    	$this->db->where("invoice_number !=","");
                                                	    	
                                                		    $checkold = $this->db->get("product_trans_detail");
                                                		    if($checkold->num_rows()<1){
                                                    ?>
                                                        <tr class="text-uppercase text-center">
                                                            <td><?php echo $h;?></td>
                                                            <td><button id ="selectlid<?php echo $h;?>" value = "<?php echo $bt->id;?>" class="btn btn-success"><?php echo $bt->username;?></button></td>
                                                            <td><?php echo $bt->b_name;?></td>
                                                        </tr>
                                                    <script>
                                                        $('#selectlid<?php echo $h;?>').click(function(){
                                                              var sid = $('#selectlid<?php echo $h;?>').val();
                                                             var type =1;
                                                            
                                                              $.post("<?php echo site_url('index.php/branchController/branchavi')?>", { sid : sid ,type : type }, function(data){ 
                                                             
                                                                  $('#showdetails').html(data);
                                                              })
                                                            });
                                                    </script>
                                        <?php  $h++;}} }}}     }
                            }else{   
                                                   
                                                    if( $this->uri->segment(3)==2){
                                                         if($Demandshop){
                                                               // print_r($deid);
                                             $h=1;    foreach($Demandshop as $row1){
                                                $this->db->where_in("id",$row1);
                                              $rty =  $this->db->get("sub_branch")->row();
                                              	$this->db->where("reciver_usernm",$rty->username);
                                	    	$this->db->where("status",0);
                                	    	$this->db->where("invoice_number !=","");
                                	    	
                                		    $checkold = $this->db->get("product_trans_detail");
                                		    if($checkold->num_rows()<1){
                            	            ?>
                            	            <tr class="text-uppercase text-center">
                                                <td><?php echo $h;?></td>
                                                <td><button id ="selectlid<?php echo $h;?>" value = "<?php echo $rty->id;?>" class="btn btn-success"><?php echo $rty->username;?>
                                                    </button></td>
                                                <td><?php echo $rty->bname;?></td>
                                              </tr>
                                          
                                            <script>
                                                $('#selectlid<?php echo $h;?>').click(function(){
                                                      var sid = $('#selectlid<?php echo $h;?>').val();
                                                      //alert(sid);
                                                       var type =2;
                                                       
                                                      $.post("<?php echo site_url('shopController/findlessproductb')?>", { sid : sid ,type : type }, function(data){ 
                                                          $('#showdetails').html(data);
                                                      })
                                                    });
                                                    </script>
                                  <?php $h++; }} }}else{
                                      //print_r($avail);
                                   $h=1;    if($availabelshop){
                                            foreach($availabelshop as $row1){
                                                $this->db->where("id",$row1);
                                                $bt =  $this->db->get("sub_branch")->row();
                                                	$this->db->where("reciver_usernm",$bt->username);
                                	    	$this->db->where("status",0);
                                	    	$this->db->where("invoice_number !=","");
                                	    	
                                		    $checkold = $this->db->get("product_trans_detail");
                                		    if($checkold->num_rows()<1){?>
                                                <tr class="text-uppercase text-center">
                                                    <td><?php echo $h;?></td>
                                                    <td><button id ="selectlid<?php echo $h;?>" value = "<?php echo $row1;?>" class="btn btn-success"><?php echo $bt->username;?></button></td>
                                                    <td><?php echo $bt->bname;?></td>
                                                       
                                                </tr>
                                          
                                            <script>
                                                $('#selectlid<?php echo $h;?>').click(function(){
                                                      var sid = $('#selectlid<?php echo $h;?>').val();
                                                     // alert(sid);
                                                        var type =2;
                                                      $.post("<?php echo site_url('index.php/branchController/branchavi')?>", { sid : sid , type : type }, function(data){ 
                                                          $('#showdetails').html(data);
                                                      })
                                                    });
                                            </script>
                                            <?php  $h++;} }} }
                                               }
                                               ?>
                </tbody>
              </table>
            </div>   
            </div>    
            <div class="col-sm-6" id ="showdetails">
            </div> 
        </div>
        </div>
        </div>
        </div>
        </div>
</div>

