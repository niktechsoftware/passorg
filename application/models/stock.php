<?php
class stock extends CI_Model{
	
	
	function insert_Category($stream){
		$db = array(
				"name" => $stream,
				
		);
		if(strlen($stream) > 1){
				
			$this->db->insert("category",$db);
		}
		$this->db->order_by("name", "asc");
		$query = $this->db->get("category");
		return $query;
		
	}
	
  public function checkjoinerid($tid){
	
    $this->db->where("username",$tid);
    $rw= $this->db->get("customers");
    return $rw;
  
 }
 
public function checkStockp($itemNo){
    
   $sid= $this->session->userdata("id");
   
	$this->db->where("subbranch_id",$sid);
	$this->db->where("p_code",$itemNo);
//	$this->db->where("hsn",$itemNo);
	$req = $this->db->get("subbranch_wallet");
//   print_r($req);
	return $req;

}
public function checkStockproduct($itemNo){
   // echo $itemNo;
    $this->db->where("hsn",$itemNo);
	$req = $this->db->get("stock_products");
//   print_r($req);
//echo "found";
//exit();
if($req->num_rows()>0){
	return $req;
}else{
     $this->db->where("sec",$itemNo);
	$bq = $this->db->get("branch_wallet");
	if($bq->num_rows()>0){
	   $this->db->where("id",$bq->row()->p_code);
	$req = $this->db->get("stock_products"); 
	return $req;
	}
}

}



	public function editstock($id){
			$this->db->where("id",$id);
			$data=$this->db->get("stock_products");
			if($data->num_rows()>0){
			$cat_id=$data->row()->sub_category;
	     	$dataarr=$data->row_array();
			$this->db->where("id",$cat_id);
			$subcat_name =$this->db->get("sub_category")->row()->name;
			$data['row'] =  $dataarr;
		   $data['catname']   = $subcat_name;
		   return $data;

	}

	 }
	public function getsubcat1($tid){
		$query = $this->db->query("SELECT DISTINCT * FROM sub_category WHERE  cat_id = '$tid' order by id");
			 return $query;
	 }


	function update_category($streamId,$streamName){

		$val = array(
				"name" => $streamName,
				
		);
		
		$this->db->where("id",$streamId);
		$query = $this->db->update("category",$val);
		return true;
	}

	function updatesub_category($streamId,$streamName){
	
		$val = array(
		    "name" => $streamName,
		    );
		
		$this->db->where("id",$streamId);
		$query = $this->db->update("sub_category",$val);
		return $query;
	}
	
	function delete_category($streamId){
		
		$this->db->where("cat_id",$streamId);
		$subCate=$this->db->get('sub_category');
		if($subCate->num_rows()>0){
				
			echo "<script>alert('you can not delete this stream because this stream is already used in class');</script>";
			return false;
		}
		
		else{
			$this->db->where("id",$streamId);
			$query = $this->db->delete("category");
			return $query;
	}
	}

	function insertsub_Category($subcatname,$catid){
		$db11 = array(
				"name" => $subcatname,
				"cat_id" => $catid
				
		);
		if(strlen($subcatname) > 1){
		// print_r(strlen($subcatname));
		// exit();
				
			$this->db->insert('sub_category',$db11);
		}
		$this->db->order_by("name", "asc");
		$query = $this->db->get("sub_category");
		return $query;
		
	}
	

	function deletesub_category($streamId){
	  
	        
			$this->db->where("id",$streamId);
			$query = $this->db->delete("sub_category");
			return $query;
           
	
	}
	function getDemandAvailable($subBranchID,$ub){
	     $finalData = array();
                $s = 0;
                $subid =  $subBranchID;
                //print_r($shopid);
               
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
                						if(($this->session->userdata("login_type")==1) && ($ub=='2')){
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
                							if(($this->session->userdata("login_type")==1) && ($ub=='1')){
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
                					
                				
                			
                				$j++;
                					if($subdemand1 < $prequiredQuantity->quantity){
                					    array_push($rowData, $productData);
                					}
                			    
                			endforeach; 
                			$branchData = array_merge($branchData, array("productData" => $rowData));
                				
                		}
                    array_push($finalData, array("branchData" => $branchData));
                endforeach;
               /*  echo "<pre>";
                 print_r($finalData);
                echo "</pre>";*/
                
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
                return $calculatedData;
	}
		function getDemandAvailable1($subBranchID,$ub){
	     $finalData = array();
                $s = 0;
                $subid =  $subBranchID;
                //print_r($shopid);
               
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
                						if(($this->session->userdata("login_type")==1) && ($ub=='2')){
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
                							if(($this->session->userdata("login_type")==1) && ($ub=='1')){
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
                
                 $productCode = array();
                 
                $calculatedAvai = array();
                foreach($finalData as $branchData):
                    foreach($branchData as $productDetail):
                        if(array_key_exists("productData",$productDetail)) {
                            //$branchCodes = array();
                            //echo $productDetail['subBranchID'];
                            foreach($productDetail['productData'] as $product):
                                
                                if (!in_array($product['product_code'], $productCode)){
                                    $calculatedAvai[$product['product_code']] = $product['available_quantity'];
                                }
                                else {
                                    $calculatedAvai[$product['product_code']] += $product['available_quantity'];
                                }
                               // array_push($branchCodes,$productDetail['subBranchID']);
                                array_push($productCode, $product['product_code']);
                            endforeach;
                           // array_merge($productCode, $branchCodes);
                        }
                    
                    endforeach;
                    
                endforeach;
                return $calculatedAvai;
	}
	

	
}