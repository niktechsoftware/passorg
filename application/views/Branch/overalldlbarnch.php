<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <!-- Zero config.table start -->
     

      <div class="panel panel-white">
        <div class="panel-heading panel-red">
        <center><a href="<?php echo base_url();?>welcome/product_list"><h2 class="text-bold">Demand List of Branch <?php echo $this->session->userdata("username");?></h2></a></center>
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
                                        <a href="#" class="export-xml" data-table="#sample-table-2">
                                            Save as XML
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
                     <?php if(($this->session->userdata("login_type")==1)){?> 
                     <div class="col-md-12 row"> 
                   
                    <div class="col-md-6"><a href ="<?php echo base_url(); ?>index.php/adminController/branchdemandtransfer/<?php echo $branchid;?>/1" class ="btn btn-success">
                                     View   Available Products  <i class="icon-arrow"></i>
                                        </a>  
                                    </div>    
                <div class="col-md-6">       <a href ="<?php echo base_url(); ?>index.php/adminController/branchdemandtransfer/<?php echo $branchid;?>/2" class ="btn btn-danger">
                                        View Not Available Products  <i class="icon-arrow"></i>
                                        </a>
                                </div>
                </div> 
                <?php }?>
                   <input type="hidden" id = "reciever" value = "<?php echo $this->session->userdata("username");?>" />
           <div class="dt-responsive table-responsive">
            <table id="sample-table-2" class="table table-striped table-bordered nowrap">
              <thead>
                <tr  style="background-color:#1ba593; color:white;">
                    <th>S.No.</th>
                    <th>Com. Name</th>
                    <th width="200">P.Name</th>
                    <th>P. Code</th>
                    <th>Volume</th>
                      <th>Mrp Price</th>
                    <th>P. Price</th>
                    <th>T.Of Pro</th>
                    <th>Image</th>
                    <th>N.of Subscriber</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                    </tr>
              </thead>
              <tbody>
             
                    <?php 
                     $tota=0;
                      $i=1; $h=0;
                 
                    $j=1;
                $pcode = array();
                $requir = array();
                $finalData = array();
                foreach($subBranchID as $shop):
                    
                    $branchData = array("subBranchID" => $shop);
                   
                	    $distinctpcode =	$this->db->query("select distinct(product_code) as p_code from favourite_list where sub_branchid='$shop'  ");
                		if($distinctpcode->num_rows()>0){
                			$j=0;
                		    $rowData = array();
                			foreach($distinctpcode->result() as $data):
                			    
                			    $prequiredQuantity = 1;
                					$this->db->select_sum("rec_quantity");
                					$this->db->select_sum("sale_quantity");
                					$this->db->where("subbranch_id",$shop);
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
                					$subdemand = (($receive-$saleq));
                					
                					// echo "subbranch quan =".$branchqu."<br>";
                					if($subdemand < $prequiredQuantity){
                					   //	echo $data->p_code."<br>";
                					    	$this->db->select_sum("rec_quantity");
                        					$this->db->select_sum("sale_quantity");
                        					$this->db->where_in("branch_id",$this->session->userdata("id"));
                        					$this->db->where("p_code",$data->p_code);
                        					$dtsbranch= $this->db->get("branch_wallet"); 
                        						if($dtsbranch->num_rows()>0){
                        						$receivebranch=  $dtsbranch->row()->rec_quantity;
                        						$saleqbranch = $dtsbranch->row()->sale_quantity;
                        					}
                        					else{
                        						$receivebranch=0;
                        						$saleqbranch=0;
                        					}
                        					if(($receivebranch-$saleqbranch)<1){
                					    $productData["product_code"] = $data->p_code;
                			            $productData["required_quantity"] =  1;
                			            $productData["available_quantity"]=0;
                					//echo $data->p_code;
                						}
                						else{
                						    $productData["product_code"] = $data->p_code;
                						    $productData["required_quantity"] = 0;
                						    $productData["available_quantity"] =  $receivebranch-$saleqbranch;
                						}
                						//echo json_encode($subranch);
                						// print_r($subranch) ;
                					//	print_r($productData);
                			
                				$j++;
                					if(($receivebranch-$saleqbranch) < 1){
                					    array_push($rowData, $productData);
                					}
                					}
                			endforeach; 
                			$branchData = array_merge($branchData, array("productData" => $rowData));
                				
                		}
                    array_push($finalData, array("branchData" => $branchData));
                    
                  
                    $j++; endforeach;
                        
           
                
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
               /* echo "<pre>";
                print_r($calculatedData);
                echo "</pre>";*/
                    $j=1; $i=1; $h=0; foreach($calculatedData as $key=>$val):
                        $this->db->where("id",$key);
                       $stckdt2= $this->db->get("stock_products")->row();
                       $this->db->where("branch_id",$this->session->userdata("id"));
                       $this->db->where("p_code",$key);
                      $productDe= $this->db->get("branch_wallet");
                      
                        $this->db->where("invoice_number","");
                            	     $this->db->where("p_code",$key);
                            	     $this->db->where("status",0);
                            	     $this->db->where("reciver_usernm",$this->session->userdata("username"));
                            	    $this->db->where("sender_usernm","muskan");
                            	    $oldcheck = $this->db->get("product_trans_detail");
                   ?>
                        <tr>
                            <td>    <?php echo $i;?>    </td>
                            <td>    <a href="#"><span ><?php echo $stckdt2->company;?></span></a>   </td>
                            <td width="200">    
                            <span style="color:red;"><?php echo $stckdt2->name;?></span>
                            </td>
                            <td><input type="hidden" id="p_code<?php echo $i;?>"  value ="<?php echo $stckdt2->id;?>" /><?php echo $stckdt2->hsn;?></td>
                            <td><?php echo $stckdt2->size;?></td>
                             <td><input  id="sitem_price<?php echo $i; ?>"  class="text-uppercase" name="sitem_price<?php echo $i; ?>" value ="<?php echo $productDe->row()->mrp_price;?>" style="width:70px;"></td></td>
                             <td> <input  id="item_price<?php echo $i; ?>"  class="text-uppercase" name="item_price<?php echo $i; ?>" value ="<?php echo $productDe->row()->selling_price;?>" style="width:70px;"></td>
                          
                            <td><?php echo $stckdt2->p_type;?></td>
                            <td><?php if($stckdt2->file1>0){ ?><img src="<?php echo $this->config->item('asset_url'). '/productimg/' .$stckdt2->file1; ?>"
                                            style="height:50px;width:100px;"><?php } else{ ?> <img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stckdt2->file2; ?>"
                                                        style="height:50px;width:100px;"><?php } ?>
                            </td>
                             
                            <td> <?php 
                                    $this->db->where_in("sub_branchid",$subBranchID);
                                    $this->db->where('product_code',$key);
                                    $row1=$this->db->get('favourite_list');
                                ?>
                              <a href="#"><span style="color:#01a9ac;font-size:20px;font-weight:1px;"><?php echo $row1->num_rows(); ?></span></a>
                            </td>
                           <!-- <td style="margin-left:50px;">
                                    <?php $j=1; foreach($row1->result() as $cusname): 
                                    $this->db->where('id',$cusname->customer_id);
                                    $row2=$this->db->get('customers')->row();
                                    echo $j."- " .  $row2->name. " [ " . $row2->username . " ]<br> ";
                                    $j++; endforeach;?>
                            </td>-->
                              <td>
                               <?php if($oldcheck->num_rows()>0){ $acquan=$oldcheck->row()->quantity;?>
                                <input readonly id="item_quantity<?php echo $i; ?>" class="text-uppercase"  name="item_quantity<?php echo $i; ?>" value = "<?php echo $acquan;?>" style="width:70px;" type="text"/>
                               <?php }else { $acquan= $row1->num_rows();?>
                               <button style="border-radius:50%;" type='button' class="btn btn-primary" id="add<?php echo $i;?>" >+</button>
                                <input readonly id="item_quantity<?php echo $i; ?>" class="text-uppercase"  name="item_quantity<?php echo $i; ?>" value = "<?php echo $row1->num_rows();;?>" style="width:70px;" type="text"/>
                                <button style="border-radius:50%;" type='button' class="btn btn-success" id="sub<?php echo $i;?>">-</button>
                          <?php }?>
                          </td>
                            <td><?php ?>
                                <input type="text" readonly id="total_price<?php echo $i; ?>" class="text-uppercase"  name="total_price<?php echo $i; ?>" value ="<?php if($oldcheck->num_rows()>0){echo number_format($oldcheck->row()->quantity*$productDe->row()->selling_price, 2,'.', '');;}else{echo number_format($row1->num_rows()*$productDe->row()->selling_price, 2,'.', '');}?>" style="width:70px;" type="text"/>
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
                                            alert(p_code+ reciever+quantity);
                                            $.post("<?php echo site_url("stockController/askSendStockbyadmin") ?>", {p_code : p_code , reciever: reciever, quantity : quantity,prc : prc , sprc : sprc}, function(data){
                                           
                                            if(data==1){
                                               var  cu_tt=totalp+(quantity*prc);
                                                 $("#total").val(cu_tt);
                                               
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
                        </tr>
                        <?php $i++; 
                        //
                        
                   
                         
                   
                    endforeach; 
                 ?>
                
                    
                
              </tbody>
              
            </table>
          </div>
            <form action="<?= base_url();?>index.php/stockController/askforadmintoDemand" method="post">   
          <div class="col-md-12 row">
                  <div class="col-md-4 ">  <input type ="text" id="totalproduct" value="<?php echo $h;?>" readonly/> <input id="total" name="total" value = "<?php echo number_format($tota,2,'.', '');?>" class="form-control" style="width:180px;" type="text" required  readonly /> </div>
                     <input type="hidden" id="number" name="number" value = "<?php  echo $i-1;?>" class="form-control" style="width:180px;" type="text" required   />
                   <div class="col-md-4 "><button class ="btn btn-purple" id="genInvoice" >Generate Invoice</button>
        </div>
        </div>
        </form>
       </div>
      
     
    </div>
  </div>
</div>