<?php
class branchController extends CI_Controller{
	function __construct(){
		parent::__construct();
			$this->is_login();
		$this->load->model("branch");
		$this->load->model("admin");
		$this->load->model("employee");
		$this->load->model("smsmodel");
	}
	function is_login(){
		$is_login = $this->session->userdata('is_login');
		if(!$is_login){
			redirect("index.php/homeController/index");
		}
		else{
			
			if($this->session->userdata("login_type")>2)
			{
				redirect("index.php/homeController/index");
			}
			
		}
	}
	/*function hg(){
	     $this->load->model("subscriber");
	     $mobile =  $this->subscriber->getmobilefromuser("PSH3S2");
	     echo $mobile;
	}*/
	function reportAskfor(){
	    if($this->session->userdata("login_type")==1){
	      $data['productlist']=$this->db->get("askforproduct"); 
	    }else{
	   $uid =  $this->session->userdata("id");
	   $data['uid']=$uid;
	   $this->db->where("user_id",$uid);
	   $data['productlist']=$this->db->get("askforproduct");
	    }
	    $data['pageTitle'] = 'Stock Section';
			$data['smallTitle'] = 'Progeny Alteratiom Of Subsctibing System';
			$data['mainPage'] = 'Stock Section';
			$data['subPage'] = 'Stock Section';
			$data['title'] = 'Stock Section in PASS';
			$data['headerCss'] = 'headerCss/stockCss';
			$data['footerJs'] = 'footerJs/stockJs';
			$data['mainContent'] = 'Branch/reportAskfor';
			$this->load->view("includes/mainContent", $data);
	}
	function deletereportAskford(){
	    $invoice =  $this->uri->segment(3);
	     $id =  $this->uri->segment(4);
	      $this->db->where("invoice_no",$invoice);
           $getstatus = $this->db->get("askforproduct")->row()->status;
           if($getstatus==0){
	     $this->db->where("id",$id);
	     $this->db->delete("askforproducttable");
           }else{
               ?><script>alert("Please Ask For Admin");</script>
          <?php }
          redirect("branchController/reportAskford/".$invoice); 
          
	}
	function delreportAskford(){
	     $invoice =  $this->uri->segment(3);
	     $this->db->where("invoice_no",$invoice);
	      $this->db->where("status",0);
	      $checkv = $this->db->get("askforproduct");
	      if($checkv->num_rows()>0){
    	       $this->db->where("invoice_no",$invoice);
    	       $this->db->delete("askforproducttable");
    	      $this->db->where("invoice_no",$invoice);
    	      $this->db->delete("askforproduct");
	      }else{
	          ?><script>alert("Please Ask For Admin");</script>  
	     <?php }
	       redirect("branchController/reportAskfor"); 
	}
		function reportAskford(){
	   $invoice =  $this->uri->segment(3);
	   $data['invoice_no']=$invoice;
	   $this->db->where("invoice_no",$invoice);
	   $data['productlist']=$this->db->get("askforproducttable");
	   $this->db->where("invoice_no",$invoice);
	   $data['userid']=$this->db->get("askforproduct")->row()->user_id;
	    $data['pageTitle'] = 'Stock Section';
			$data['smallTitle'] = 'Progeny Alteratiom Of Subsctibing System';
			$data['mainPage'] = 'Stock Section';
			$data['subPage'] = 'Stock Section';
			$data['title'] = 'Stock Section in PASS';
			$data['headerCss'] = 'headerCss/stockCss';
			$data['footerJs'] = 'footerJs/stockJs';
			$data['mainContent'] = 'Branch/reportAskford';
			$this->load->view("includes/mainContent", $data);
	}
	
	function askForProduct(){
	     $data['pageTitle'] = 'Stock Section';
			$data['smallTitle'] = 'Progeny Alteratiom Of Subsctibing System';
			$data['mainPage'] = 'Stock Section';
			$data['subPage'] = 'Stock Section';
			$data['title'] = 'Stock Section in PASS';
			$data['headerCss'] = 'headerCss/stockCss';
			$data['footerJs'] = 'footerJs/stockJs';
			$data['mainContent'] = 'Branch/askforAddProduct';
			$this->load->view("includes/mainContent", $data);
	}
	
	
	
	
	function tranferbyav(){
	  $subuser=$this->input->post("username");
	    $this->load->model("subscriber");
        $shopid = $this->input->post('shopid');
         $htype = $this->input->post('htype');
       
         if(($this->session->userdata("login_type")==1)&&($htype==1)){
              $this->db->where("id",$shopid);
        $subuser = $this->db->get("branch")->row();
        }else{
            $this->db->where("id",$shopid);
        $subuser = $this->db->get("sub_branch")->row();
        }
        $reciever=$subuser->username;
        $lock = $this->input->post("lock");
       $selectdelivery = $this->input->post("selectdelivery");
        $recieverusername =$reciever;
         $date=Date("y-m-d");
        $dt=date("dmy",strtotime($date));
    // $senderusername=$this->session->userdata("username");
        $count=$this->db->Count_All("assignproduct");
        $count=$count+1;
        $invoice = $dt."PI".$count;
        $randamnum = rand(9999,99999);
            $arras=array(
                "sender_username"=>$this->session->userdata("username"),
                "invoice_no"=>$invoice,
                "del_boy"=>$selectdelivery,
                "date"=>date("Y-m-d"),
                "reciver_usernm"=>$recieverusername,
                "status"=>0,
                "lock_no"=>$lock,
                "otp"=>$randamnum,
                  
                   );
        if($this->db->insert("assignproduct",$arras)){
        $loop = $this->input->post('loop');
        for($k=0; $k < $loop; $k++){
            $pr="proidt".$k;
            $pq="proqt".$k;
            $pcode = $this->input->post($pr);
           $sendq =  $this->input->post($pq);
            $updated['p_code']=$pcode;
            $updated['quantity']=$sendq;
            $updated['date']=date("Y-m-d");
            $updated['sender_usernm']=$this->session->userdata("username");
            $updated['reciver_usernm']=$subuser->username;
            $updated['invoice_number']=$invoice;
            $updated['status']=0;
            
           if(($htype=="1")&&($this->session->userdata("login_type")==1)){
                $this->db->where('id',$pcode);
                   $rty  =   $this->db->get("stock_products")->row();
                    $darray = array(
                    "quantity"=>$rty->quantity-$sendq
                    );
                     $this->db->where("id",$pcode);
                    $this->db->update("stock_products",$darray);
           }else{
               if($this->session->userdata("login_type")==1){
                    $this->db->where('id',$pcode);
                   $rty  =   $this->db->get("stock_products")->row();
                    $darray = array(
                    "quantity"=>$rty->quantity-$sendq
                    );
                     $this->db->where("id",$pcode);
                    $this->db->update("stock_products",$darray);
               }else{
             $this->db->where("branch_id",$this->session->userdata('id'));
                    $this->db->where('p_code',$pcode);
                   $rty  =   $this->db->get("branch_wallet")->row();
                     $darray = array(
                    "sale_quantity"=>$rty->sale_quantity+$sendq
                    );
                   
                    $this->db->where("branch_id",$this->session->userdata('id'));
                    $this->db->where("p_code",$pcode);
                    $this->db->update("branch_wallet",$darray);
           }      }
                     $this->db->insert("product_trans_detail", $updated);
                     //
                    
                     //
        }
        
        
         $this->db->where("id",$selectdelivery);
        $this->db->where("emp_type",5);
        $di= $this->db->get("employee")->row();
        $gn = $this->session->userdata("username");
        $sms = "Dear ".$recieverusername." an Invoice [".$invoice."] has been successfully Generated by ".$gn." please Contact ".$di->name."[".$di->mobile."] with lock number ".$lock.". Your one time password is ".$randamnum." please keep and donot share with anyone. Feel free to login your account.https://passystem.in ";
       $mobile =  $this->subscriber->getmobilefromuser($recieverusername);
       $sms1 ="Dear ".$di->name." a new order ".$invoice."  has been assign to you for more details visit you login. https://www.passystem.in/";
       $mobile1=$di->mobile;
      $getv= sms($mobile,$sms);
        $max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
		        $master_id=$max_id->maxid+1;
                $this->smsmodel->sentmasterRecord($sms,2,$master_id,$getv);
       $getv= sms($mobile1,$sms1);
        $max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
		        $master_id=$max_id->maxid+1;
                $this->smsmodel->sentmasterRecord($sms1,2,$master_id,$getv);
      redirect("stockController/productinvoice/".$invoice);
	}
	}
	function branchavi(){
	     $j=0;
	 $sid =   $this->input->post("sid");
	     $type = $this->input->post("type");
	       $shopid =array();
	     if($type==1){
	        	$this->db->where_in("district",$sid);
    		$subBranchData = $this->db->get("sub_branch");
    		if($subBranchData->num_rows()>0) {    
    		    foreach($subBranchData->result() as $subBranchRow):
    				 array_push($shopid, $subBranchRow->id);
    				 endforeach;
    			 $usernamefinal="sb";
    		}
	     }else{
	        $usernamefinal="b";
               $shopid[0]=$sid;
	     }
	     
	     
               $this->load->model("stock");
               $finalData = $this->stock->getDemandAvailable1($shopid,$this->input->post("type"));
               
             /* echo "<pre>";
              print_r($finalData);
              echo "</pre>";*/
	     ?>
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

						<li>
							<a href="#" class="export-csv" data-table="#sample-table-2" >
								Save as CSV
							</a>
						</li>
						<li>
							<a href="#" class="export-doc" data-table="#sample-table-2" data-ignoreColumn ="3,4">
								Export to Word
							</a>
						</li>

					</ul>
				</div>
			</div>
		</div>
		 <form action="<?php echo base_url();?>index.php/branchController/tranferbyav" method="post" role="form" id="form">
	      <div class=" table-responsive">
            <table id="sample-table-2" class="table table-striped table-bordered ">
              <thead>
                <tr >
                    <th>#</th>
                    <th>Com. Name</th>
                    <th>P.Name</th>
                    <th>P. Code</th>
                    <th>Volume</th>
                    <th>Price</th>
                    <th>Req.</th>
                 <th>Order Number</th>
                  </tr>
              </thead>
              <tbody>
             
                <?php 
               if(!empty($finalData)){
               
                foreach($finalData as $key=>$val):
                   if($finalData[$key]>0){
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
                  
                  <tr >
                      
                    <td><?php echo $j+1;?></td>
                     <td><a href="#"><span ><?php echo $stckdt2->company;?></span></a></td>
                  <td>
                 <?php 
                  echo $stckdt2->name;
                  ?>
                 </td>
                  <td><?php echo $stckdt2->hsn;?></td>
                  <td><?php echo $stckdt2->size;?></td>
                         <td><?php echo $pprice->selling_price;?></td> 
                <td><a href="#"><span style="color:#01a9ac;font-size:20px;font-weight:1px;"><?php echo $finalData[$key]; ?></span></a>
            <input type ="hidden" name="proidt<?php echo $j;?>" value ="<?php echo $key;?>" >
            <input type ="hidden" name="proqt<?php echo $j;?>" value ="<?php echo $finalData[$key];?>" >
                  <!-- 
                   <span style="color:#01a9ac;"><?php echo $row1->name. " [ ". $row1->username . " ] ";?></span> -->
                   </td>
                 
                   <td>
                  <?php   
                    if($this->session->userdata("login_type")!=2){
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
                        $this->db->where_in("order_serial.sub_branchid",$shopid);
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
                   ?> </td>
                  
                  
                   </tr>
                    <?php  $j++; } endforeach; }  
                   
                   ?>
              </tbody>
              
            </table>
           
            <?php echo $j;
             if(($this->session->userdata("login_type")==1) && ($this->input->post("type")==1)){
                   $this->db->where("id",$sid);
               $subu=  $this->db->get("branch")->row();
             }else{
                 $this->db->where("id",$sid);
                $subu =  $this->db->get("sub_branch")->row();
             }
          
            ?>
             <input type ="hidden" name="shopid" value ="<?php echo $sid;?> " >
               <input type ="hidden" name="username" value ="<?php echo $subu->username;?> " >
             <input type ="hidden" name="loop" value ="<?php echo $j;?> " >
          
             <div class="col-md-12 row">
             <div class="col-md-4">
                                                             <label >Assign Delivery Incharge</label>
                                                            <?php 
                                                            if($this->session->userdata("login_type")==1){
                                                              $id=0; 
                                                              $sub_branchid=0;
                                                            }else{
                                                                if($this->session->userdata("login_type")==2){
                                                                $id= $this->session->userdata("id");
                                                                $sub_branchid=0;
                                                            }else{
                                                                $sub_branchid= $this->session->userdata("id");
                                                                $this->db->where("id",$sub_branchid);
                                                               $id = $this->db->get("sub_branch")->row()->district;
                                                            }
                                                            }
                    $aa= array('district'=>$id,
                                'sub_branchid'=>$sub_branchid,
                                'emp_type'=>'5',
                                'status'=>'1');
                     
                      $this->db->where($aa);
                      $deliveryboy=$this->db->get('employee');?>
                       <select class="form-control text-uppercase"  name = "selectdelivery" id="selectdelivery" style="width:180px;" class= class="form-control" required="required">
                            <option value="">-Assign to-</option>
                            <?php if($deliveryboy->num_rows()>0) {
                               foreach($deliveryboy->result() as $row1)  {  
                               ?> 
                          <option class="text-uppercase" style="color:#01a9ac" value="<?php echo $row1->id;?>"><?php echo  $row1->name." [ ". $row1->username. " ] ";?></option>     
                                    
                              <?php }  }?></select>
                                               </div>
                                             <div class="col-md-4"> <label >Enter Lock No.</label>
                                                 <input type="text" name="lock" id ="lockno" placeholder = "Lock"  style="width:180px;" class= class="form-control" required="required" />
                                                 <input type="text" name="pass" id ="locknop"  style="width:180px;" class= class="form-control" required="required"  required="required" readonly/>
                                                 </div>
                                                 <script>
                                                         $('#lockno').keyup(function(){
                                                            var lockno = $('#lockno').val();
                                                                
                                                            $.post("<?php echo site_url("stockController/checklocp") ?>", {lockno : lockno}, function(data){
                                                            $('#locknop').val(data);
                                                            });
                                                               
                                                            });
                                                 </script>
                                                 <div class="col-md-2">
                                                     <?php  if(($this->session->userdata("login_type")==1) && ($this->input->post("type")==1)){?>
                                                     <button class = "btn btn-success" id = "confirm" >Transfer to Shop</button>
                                                     <input type = "hidden" name ="htype" value='1'/>
                                                     <?php }else{?>
                                                           <button class = "btn btn-success" id = "confirm" >Transfer to shop</button>
                                                              <input type = "hidden" name ="htype" value='2'/>
                                                     <?php } ?>
                                                     </div>
                                             </div>    
                                           
            </form>
              <script>
	TableExport.init();
	
                   
	
</script>
          </div>
          </form>
	    <?php
	     
	  
	  
	  
	  
	  
	  //end
	  
	}
	
	function index(){
	    $username = $this->session->userdata("username");
		$this->db->where("login_username",$username);
		$this->db->where("DATE(opening_date)",date("Y-m-d"));
		$checkopeningclo  = $this->db->get("opening_closing_balance");
		if($checkopeningclo->num_rows()>0){
			
		}else{
		    
			$clo1 = $this->db->query("select * from opening_closing_balance where  login_username ='$username' ORDER BY id DESC LIMIT 1");
			if($clo1->num_rows()>0){
				$clo =$clo1->row();
			$cl_date = $clo->closing_date;
			$cl_balance = $clo->closing_balance;
			$cr_date = date('Y-m-d');

			if($cl_date != $cr_date)
			{
				$this->ocbalance->insert_ocbalance($cl_balance,$cl_balance,$username);
			}
			}else{
				$this->ocbalance->insert_ocbalance(0,0,$username);
			}
		}
		$data['pageTitle'] = 'Branch Dashboard';
		$data['smallTitle'] = 'Overview of all Section';
		$data['mainPage'] = 'Branch Dashboard';
		$data['subPage'] = 'Branch dashboard';
		$data['title'] = 'Branch Dashboard';
		$data['headerCss'] = 'headerCss/dashboardCss';
		$data['footerJs'] = 'footerJs/dashboardJs';
		$data['mainContent'] = 'Branch/dashboard';
		$this->load->view("includes/mainContent", $data);
	
	}
	
	
	function bregistration(){
		$data['pageTitle'] = 'Branch Registration';
		$data['smallTitle'] = 'Branch Registration';
		$data['mainPage'] = 'Add Branch Area';
		$data['subPage'] = 'New Branch Registration';
		$data['title'] = 'Add Branch Area';
		$data['headerCss'] = 'headerCss/branchCss';
		$data['footerJs'] = 'footerJs/branchJs';
		$data['mainContent'] = 'Branch/brachRegistration';
		$this->load->view("includes/mainContent", $data);
	}
	function daybook(){
		$data['pageTitle'] = 'DayBook Section';
		$data['smallTitle'] = 'DayBook';
		$data['mainPage'] = 'DayBook';
		$data['subPage'] = 'DayBook';
		$data['title'] = 'DayBook';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/daybook';
		$this->load->view("includes/mainContent", $data);
	} 
	
	function saveBranch(){
		$maxid=$this->branch->getMax();
		$maxid=$maxid+1;
		$name=$this->input->post('name');
		$username="PBR".$maxid;
		$value['username']= $username;
		$value['b_name']=$this->input->post('b_name');
		$value['district']=$this->input->post('district');
		$value['name']=$this->input->post('name');
		$value['mobile']=$this->input->post('mob_no');
		$value['aadhar']=$this->input->post('aadhar');
		$value['email_id']=$this->input->post('email');
		$value['password']=$this->input->post('password');
		$bname = $this->input->post('b_name');
		$passw = $this->input->post('password');
		$adminStocklist = $this->db->get("stock_products");
		$dt=$this->branch->insert($value,$adminStocklist);
		  if($dt)
		  {
             $msg = "Dear ". $name . " Your Branch Registration in PAS System is Successfully Done. Your Branch Name is " .$bname . "  and Your Username is ".$username." and Password is ".$passw.". Please Wait For Activation. Best Regards from  PAS System Admin- 7394826066. https://www.passystem.in/";
              $mobile = $this->input->post('mob_no');
                 $getv= sms($mobile,$msg);
                   $max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
		        $master_id=$max_id->maxid+1;
                $this->smsmodel->sentmasterRecord($msg,2,$master_id,$getv);
                  //echo $msg;
             redirect(base_url().'branchController/bregistration/5');
		            //   // redirect('https://passystem.in/auth/signupShop','refresh');
		        }else{?>
<?php
		           redirect(base_url().'branchController/error');
		        }
	}
	function error(){
		echo "error";
	}
	
	function branchListActive(){
		$dt = $this->branch->getActiveList();
		$data['activeList']=$dt;
		$data['pageTitle'] = 'Active Branch List';
		$data['smallTitle'] = 'Active  Branch List';
		$data['mainPage'] = 'Active Branch List';
		$data['subPage'] = 'Active Branch List ';
		$data['title'] = 'Active Branch List';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/branchListActive';
		$this->load->view("includes/mainContent", $data);
		
	}

	function producttransfer(){
		$data['pageTitle'] = 'Product Transfer';
		$data['smallTitle'] = 'Product Transfer';
		$data['mainPage'] = 'Product Transfer';
		$data['subPage'] = 'Product Transfer'; 
		$data['title'] = 'Product Transfer';
		$data['headerCss'] = 'headerCss/branchListCss';
		$data['footerJs'] = 'footerJs/producttransfer';
		$data['mainContent'] = 'stock/producttransfer';
		$this->load->view("includes/mainContent", $data);
		
	} 

	function branchListinActive(){
		$dt = $this->branch->getinActiveList();
		$data['activeList']=$dt;
		$data['pageTitle'] = 'Inactive Branch List';
		$data['smallTitle'] = 'Inactive Branch List';
		$data['mainPage'] = 'Inactive Branch List';
		$data['subPage'] = 'Inactive Branch List ';
		$data['title'] = 'Inactive Branch List';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/branchListinActive';
		$this->load->view("includes/mainContent", $data);
	}
	public function branchstocklist(){
		$data['unm'] = $this->branch->getValue();
		$data['pageTitle'] = 'Branch Product List';
		$data['smallTitle'] = 'Full Product List';
		$data['mainPage'] = 'Active Product List ';
		$data['subPage'] = 'Branch Product List';
		$data['title'] = 'Branch Product List';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/branchstocklist';
		$this->load->view("includes/mainContent", $data);
	}
	
	public function overalldlbarnch(){
	        $subBranchID =array();
	     	$data['branchid'] = $this->session->userdata('id');
    		$this->db->where("district",$this->session->userdata('id'));
    		$subBranchData =  $this->db->get("sub_branch");
	     	foreach($subBranchData->result() as $subBranchRow):
	     	    array_push($subBranchID, $subBranchRow->id);
        		endforeach;
        $data['subBranchID']=$subBranchID;
	    $data['pageTitle'] = 'Overall Demand';
		$data['smallTitle'] = 'Branch Demand List';
		$data['mainPage'] = 'Branch Demand';
		$data['subPage'] = 'Branch Demand List';
		$data['title'] = 'Branch Demand List';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/overalldlbarnch';
		$this->load->view("includes/mainContent", $data);
	}
	public function subbranchstocklist(){
		$data['pageTitle'] = 'Shop Product List';
		$data['smallTitle'] = 'Shop Product List';
		$data['mainPage'] = 'Shop Product List ';
		$data['subPage'] = 'Shop Product List';
		$data['title'] = 'Shop Product List';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/subbranchstocklist';
		$this->load->view("includes/mainContent", $data);
	}
	public function branchfull_profile(){
		$id=$this->uri->segment(3);
		//print_r($id);exit();
		if($this->session->userdata("login_type")== 1){
			
			$data['unm'] = $this->branch->full_profile($id);
		}else{
		$data['unm'] = $this->branch->getValue();}
		$data['pageTitle'] = 'Branch Profile';
		$data['smallTitle'] = 'Full Profile';
		$data['mainPage'] = 'Active Branch ';
		$data['subPage'] = 'Branch ';
		$data['title'] = 'Branch';
		$data['headerCss'] = 'headerCss/branchListCss';
		$data['footerJs'] = 'footerJs/branchListJs';
		$data['mainContent'] = 'Branch/branchfull_profile';
		$this->load->view("includes/mainContent", $data);
	}
	public function updateBranch(){
		$id= $this->uri->segment(3);
		$value['b_name']=$this->input->post('b_name');
			$value['name']=$this->input->post('name');
				$value['mobile']=$this->input->post('mob_no');
		$value['email_id'] = $this->input->post('email');
		$value['bank_name'] = $this->input->post('bankname');
		$value['account_no'] = $this->input->post('acc_no');
		$value['branch_name'] = $this->input->post('branchName');
		$value['ifsc'] = $this->input->post('ifsc');
	//	$value['image'] =time().trim($_FILES['image']['name']);
		$value['password'] = $this->input->post('password');
		
		
		 $photo_name1 = time().trim($_FILES['image']['name']); 
		// if($query)
		// {
			$this->load->library('upload');
			//$image_path = realpath(APPPATH . '../assets/images/branch');
			$asset_name = $this->db->get('upload_asset')->row()->asset_name;
		
						$image_path = $asset_name.'/images/branch/';
			$config['upload_path'] = $image_path;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|';
			$config['max_size'] = '50';
			$config['file_name'] = $photo_name1;
		//	print_r($config);exit();
		//}
		if (!empty($_FILES['image']['name'])) {
			$this->upload->initialize($config);
			$this->upload->do_upload('image');
			$value['image'] = $photo_name1;
		//	print_r("hiiii");
		//	print_r($value);exit();
		}
		$this->db->where('id',$id);
		$query=$this->db->update('branch',$value);
		
		redirect('index.php/branchController/branchfull_profile/'.$id.'/5');
	}
	
	
	function error1(){
		echo "error";
	}
	function match_pan1(){
	    $pan=$this->input->post('panVal');
	    $data = $this->branch->panCard($pan);
	    if($data){
	        echo "<p class='error' style='color:red;'>You can not use duplicate pan number!!</p>";
	    }else{
	       echo "<p class='error' style='color:green;'>Valid Pan Number</p>";
	    }
	}

	
	  

	function checkjoinerid(){
		  $tid = $this->input->post("cat");
		  $this->load->model("registration1");
		  $var = $this->registration1->checkjoinerid($tid);
		  if($var->num_rows()>0){
		   $rw1=$var->row();
		   print_r($rw1);exit();
		 $this->db->where("parentID",$rw1->id);
		 $data= $this->db->get("tree");
		if($data->num_rows()<20){  }
	}
}

	 function adminproductsend()
 {
    $senderid=$this->input->post('admin');
    $sendquantity=$this->input->post('sendquantity');
    $recquantity=$this->input->post('stockquantity');
    $pcode=$this->input->post('pcode');
    $reciverchk=$this->input->post('reciverchk');
    $recivebranch=$this->input->post('recivebranch');
    $recisubbranch=$this->input->post('recisubbranch');

    if($reciverchk==1)
    { ?>
        <script>
        alert("Can not send Admin to Admin Product");
        $("#sendcheckid").get(0).selectedIndex = 0;
        $("#sendproductdetail").hide();
        </script>
        <?php 
    }
    if($reciverchk==2)
    {
     $this->db->where('id',$pcode);
     $sadminstock=$this->db->get('stock_products')->row();
      if(strlen($sadminstock->sec)>0){
     $data13=array(
      'quantity' =>$sadminstock->quantity-$sendquantity,
      'protrans_date'=>date('Y-m-d'), 
      ); 
      $this->db->where('id',$sadminstock->id);
      $adstockup=$this->db->update('stock_products',$data13);
     

      $this->db->where('p_code',$pcode);
      $this->db->where('branch_id',$recivebranch);
      $admwallet=$this->db->get('branch_wallet');

    if($admwallet->num_rows()>0){
      $adwall=$admwallet->row();
      $data15=array(
        'rec_quantity' =>$adwall->rec_quantity+$sendquantity, 
        'sec'=>$sadminstock->sec,
        'date'=>date('Y-m-d'),
        );
      $this->db->where('id',$adwall->id);
      $newinsert=$this->db->update('branch_wallet',$data15);
    }
  else
  {
    $data16=array(
      'branch_id' =>$recivebranch,
       'p_code'=>$pcode,
       'rec_quantity'=>$sendquantity,
       'sec'=>$sadminstock->sec,
      'date'=>date('Y-m-d'),
      );
     $newinsert=$this->db->insert('branch_wallet',$data16);
    }
   
      $this->db->where('id',$senderid);
      $admusernm=$this->db->get('general_settings')->row();
   
                $this->db->where('id',$recivebranch);
      $branusernm=$this->db->get('branch')->row();

    $data17=array(
    'p_code' =>$pcode,
    'Discription'=>"Admin to Branch",
    'quantity'=>$sendquantity,
     'sender_usernm'=>$admusernm->admin_username,
     'reciver_usernm'=>$branusernm->username,
    );
    $insertpr=$this->db->insert('product_trans_detail',$data17); 

     if($insertpr&& $newinsert){
  $data['recivebranch']=$recivebranch;
   $data['senqt']=$sendquantity;
  $this->load->view('Admin/admintobranch',$data);
    }
      } else{?>

<script>
alert('please update Your Product With Sec Number');
return false;
</script>

<?php } 
    }
    if($reciverchk==3)
    {
     $this->db->where('id',$pcode);
     $sadminstock=$this->db->get('stock_products')->row();
      if(strlen($sadminstock->sec)>0){
     $data18=array(
      'quantity' =>$sadminstock->quantity-$sendquantity,
      'protrans_date'=>date('y-m-d'), 
      ); 
      $this->db->where('id',$sadminstock->id);
      $adstockup=$this->db->update('stock_products',$data18);
      
      $this->db->where('p_code',$pcode);
      $this->db->where('subbranch_id',$recisubbranch);
      $admwallets=$this->db->get('subbranch_wallet');

    if($admwallets->num_rows()>0){
      $adwalls=$admwallets->row();
      $data20=array(
        'rec_quantity' =>$adwalls->rec_quantity+$sendquantity, 
       'sec'=>$sadminstock->sec,
        'date'=>date('Y-m-d'),
        );
      $this->db->where('id',$adwalls->id);
      $newinserts=$this->db->update('subbranch_wallet',$data20);
    }
  else
  {
    $data21=array(
      'subbranch_id' =>$recisubbranch,
       'p_code'=>$pcode,
       'rec_quantity'=>$sendquantity,
        'sec'=>$sadminstock->sec,
         'date'=>date('Y-m-d'),
      );
     $newinserts=$this->db->insert('subbranch_wallet',$data21);
    }
   
      $this->db->where('id',$senderid);
      $admusernms=$this->db->get('general_settings')->row();
   
        $this->db->where('id',$recisubbranch);
      $branusernms=$this->db->get('sub_branch')->row();

    $data22=array(
    'p_code' =>$pcode,
    'Discription'=>"Admin to Subbranch",
    'quantity'=>$sendquantity,
   
     'sender_usernm'=>$admusernms->admin_username,
     'reciver_usernm'=>$branusernms->username,
    );
    $insertpr=$this->db->insert('product_trans_detail',$data22); 
   
   if($insertpr&&$newinserts){
    
    $data['recisubbranch']=$recisubbranch;
    $data['senqt']=$sendquantity;
    $this->load->view('Admin/admintosbbranch',$data);
  }

    } 
    else { ?>
<script>
alert('Please Update Your Product detail with sec');
return false;
</script>

<?php  }
    

 }
}

 function branchproduct(){

	$branchid=$this->input->post('branchid');
	
	$product=$this->branch->getbranchproduct($branchid);
	if($product->num_rows>0){
		
			 $data['adminreciver']=$this->input->post("reciadmin");
			 $data['branchreciver']=$this->input->post("recivebranch");
			 $data['subbranchreciver']=$this->input->post("recisubbranch");
			 $data['brproduct']=$product->result();
			 $this->load->view('Branch/branchproduct',$data);
		
}
}
 function shopproduct(){

	$sbranchid=$this->input->post('subbranchid');

	$product=$this->branch->getshopproduct($sbranchid);
	if($product->num_rows>0){
			$data['adminreciver']=$this->input->post("reciadmin");
			 $data['branchreciver']=$this->input->post("recivebranch");;
			 $data['subbranchreciver']=$this->input->post("recisubbranch");;
			 $data['brproduct']=$product->result();
			 $this->load->view('Branch/subbranchproduct',$data);
}
}

function getsubbranch() {

	$tid = $this->input->post("classv");
	
	$var = $this->branch->getsbranch($tid);
		if($var->num_rows() > 0){
		?>

<option value="">-Select Sub Branch-</option>

<?php
			foreach ($var->result() as $row)
			{?>

<option value="<?php echo $row->id;?>" class="text-uppercase"><?php echo $row->bname;?></option>

<?php }

		}
}



function branchtransferproduct() {

	
	$senderid=$this->input->post('senderid');
	$sendquantity=$this->input->post('sendquantity');
	$recquantity=$this->input->post('recquantity');
	$pcode=$this->input->post('pcode');
	$reciever=$this->input->post('reciever');
	 $idcheck=$this->input->post('idcheck');
 
				$this->db->where('id',$senderid);
				$sendusernm=$this->db->get('branch')->row();
 
				$this->db->where('id',$reciever);
				$reciusernm=$this->db->get('branch')->row();
				print_r($reciever);
				// echo "<br>";
				// print_r($senderid);
				// echo "<br>";
				// print_r($sendquantity);
				// echo "<br>";
				// print_r($recquantity);
				// echo "<br>";
				// print_r($pcode);
				// echo "<br>";
				// print_r($idcheck);
				// print_r($reciusernm);
				exit();
	
	if($idcheck==1){
 
 
			$this->db->where('id',$pcode);
			$getstock=$this->db->get('stock_products')->row();
 
			$data1=array(
		 'quantity' =>$getstock->quantity+$sendquantity,
		 'protrans_date'=>date('Y-m-d'),
		 
		 );
			$this->db->where('id',$getstock->id);
			$updatestock=$this->db->update('stock_products', $data1);
 
				$this->db->where('branch_id',$senderid);
			 $this->db->where('p_code',$pcode);
			$getbranchwallet=$this->db->get('branch_wallet')->row();
			echo"<pre>";
//  print_r($getbranchwallet);
//  print_r($senderid);
//   print_r($sendquantity);
//   print_r($pcode);
//  exit();
	 $data3=array(
			'sale_quantity'=>$getbranchwallet->sale_quantity+$sendquantity,
		 'rec_quantity' =>$getbranchwallet->rec_quantity-$sendquantity,
	 );
			$this->db->where('id', $getbranchwallet->id);
			$branchwallet=$this->db->update('branch_wallet',$data3);
		
				 $this->db->where('id',$reciever);
			$getadmin=$this->db->get('general_settings')->row();
 
		 $data2=array(
			 'p_code' =>$pcode , 
			 'Discription'=>"Branch to Admin",
				'quantity'=> $sendquantity,
				'sender_usernm'=>$sendusernm->username,
				'reciver_usernm'=>$getadmin->admin_username,
		 );
			$prdetail=$this->db->insert('product_trans_detail', $data2);
		if($prdetail &&$branchwallet&& $updatestock){
			//$data['p_code']=$pcode;
			$this->load->view('Branch/branchtoadmin');
			}
	}
			if($idcheck==2)
			{
		 if($senderid!=$reciever)
		 {
			 $this->db->where('p_code',$pcode);
			 $this->db->where('branch_id',$reciever);
			 $brawallet=$this->db->get('branch_wallet');
 
		 if($brawallet->num_rows()>0){
			 $bwll=$brawallet->row();
			 $data7=array(
				 'rec_quantity' =>$bwll->rec_quantity+$sendquantity,
				 );
			 $this->db->where('id',$bwll->id);
			 $newinsert=$this->db->update('branch_wallet',$data7);
		 }
	 else
	 {
		 $data4=array(
			 'branch_id' =>$reciever,
				'p_code'=>$pcode,
				'rec_quantity'=>$sendquantity,
				'date'=> Date("y-m-d")
			 
			 );
			$newinsert=$this->db->insert('branch_wallet',$data4);
		 }
			if($newinsert)
			{
			 $this->db->where('p_code',$pcode);
			 $this->db->where('branch_id',$senderid);
			 $brawallet=$this->db->get('branch_wallet')->row();
 
			$data5=array(
			 'rec_quantity'=>$brawallet->rec_quantity-$sendquantity,
				'sale_quantity'=>$brawallet->sale_quantity+$sendquantity,
				'date'=>Date('y-m-d')
			 );
			$this->db->where('id',$brawallet->id);
			 $brawallet=$this->db->update('branch_wallet', $data5);
		}
		$data6=array(
		 'p_code' =>$pcode,
		 'Discription'=>"Branch to Branch",
		 'quantity'=>$sendquantity,
			'sender_usernm'=>$sendusernm->username,
			'reciver_usernm'=>$reciusernm->username,
		 );
		 $insertpr=$this->db->insert('product_trans_detail',$data6);
		 if($insertpr&&$brawallet){
		 
			 $data['reciever']=$reciever;
			 $this->load->view('Branch/branchtobranch',$data);
		 }
	 }
		 else
		 {?>
<script>
alert("You can not send own Branch Product");
$("#sendproductdetail").hide();
window.location.reload();
</script>
<?php 
		 } 
			}
			if($idcheck==3){
			
			$this->db->where('p_code',$pcode);
			 $this->db->where('subbranch_id',$reciever);
			 $sbrawallet=$this->db->get('subbranch_wallet');
		 if($sbrawallet->num_rows()>0){
			 $sbwll=$sbrawallet->row();
			 $data9=array(
				 'rec_quantity' =>$sbwll->rec_quantity+$sendquantity, 
				 );
			 $this->db->where('id',$sbwll->id);
			 $newinsert=$this->db->update('subbranch_wallet',$data9);
		 }
	 else
	 {
		 $data10=array(
			 'subbranch_id' =>$reciever,
				'p_code'=>$pcode,
				'rec_quantity'=>$sendquantity,
				'date'=>Date('y-m-d')
			 );
			$newinsert=$this->db->insert('subbranch_wallet',$data10);
		 }
			
			if($newinsert)
			{
			 $this->db->where('p_code',$pcode);
			 $this->db->where('branch_id',$senderid);
			 $brawallet=$this->db->get('branch_wallet')->row();
 
			$data11=array(
			 'rec_quantity'=>$brawallet->rec_quantity-$sendquantity,
			 'sale_quantity'=>$brawallet->sale_quantity+$sendquantity,
			 'date'=>Date('y-m-d')
			 );
			$this->db->where('id',$brawallet->id);
			 $brawallet=$this->db->update('branch_wallet', $data11);
		}
			 $this->db->where('id',$reciever);
			 $subbranch=$this->db->get('sub_branch')->row();
		$data12=array(
		 'p_code' =>$pcode,
		 'Discription'=>"Branch to Subbranch",
		 'quantity'=>$sendquantity,
			'sender_usernm'=>$sendusernm->username,
			'reciver_usernm'=>$subbranch->username,
		 );
		 $insertpr=$this->db->insert('product_trans_detail',$data12); 
			 if($insertpr&& $brawallet){
			 $data['reciever']=$reciever;
			 $this->load->view('Branch/branchtosubbranch',$data);
			}
 
			 }
	}





	function subbratransferproduct()
	{
 
	$senderid=$this->input->post('senderid');
	$sendquantity=$this->input->post('sendquantity');
	$recquantity=$this->input->post('recquantity');
	$pcode=$this->input->post('pcode');
	$reciever=$this->input->post('reciever');
	 $idcheck=$this->input->post('idcheck');
 
			 $this->db->where('id',$senderid);
				$ssendusernm=$this->db->get('sub_branch')->row();
 
				$this->db->where('id',$reciever);
				$sreciusernm=$this->db->get('sub_branch')->row();
	
	if($idcheck==1){
			$this->db->where('id',$pcode);
			$getstock=$this->db->get('stock_products')->row();
			$data24=array(
		 'quantity' =>$getstock->quantity+$sendquantity,
		 'protrans_date'=>date('Y-m-d'),
		 );
			$this->db->where('id',$getstock->id);
			$updatestock=$this->db->update('stock_products', $data24);
 
			$this->db->where('subbranch_id',$senderid);
			$this->db->where('p_code',$pcode);
			$sgetsbranchwallet=$this->db->get('subbranch_wallet')->row();
 
	 $data25=array(
		 'sale_quantity' =>$sgetsbranchwallet->sale_quantity+$sendquantity,
		 'rec_quantity' =>$sgetsbranchwallet->rec_quantity-$sendquantity, 
	 );
			$this->db->where('id',$sgetsbranchwallet->id);
			$sbranchwallet=$this->db->update('subbranch_wallet',$data25);
		
				 $this->db->where('id',$reciever);
			$sgetadmin=$this->db->get('general_settings')->row();
 
		 $data26=array(
			 'p_code' =>$pcode , 
			 'Discription'=>"Subbranch to Admin",
				'quantity'=> $sendquantity,
				'sender_usernm'=>$ssendusernm->username,
				'reciver_usernm'=>$sgetadmin->admin_username,
		 );
		 $pp=$this->db->insert('product_trans_detail', $data26);
	 if($pp&&$sbranchwallet&&$updatestock){ 
		
	 // $data['p_code']=$pcode;
		$this->load->view('Admin/subbranchtoadmin');
	 
			}
 }
			if($idcheck==3)
			{
		 if($senderid!=$reciever)
		 {
			 $this->db->where('p_code',$pcode);
			 $this->db->where('subbranch_id',$reciever);
			 $sbrawallet=$this->db->get('subbranch_wallet');
 
		 if($sbrawallet->num_rows()>0){
			 $sbwll=$sbrawallet->row();
			 $data27=array(
				 'rec_quantity' =>$sbwll->rec_quantity+$sendquantity, 
				
				 );
			 $this->db->where('id',$sbwll->id);
			 $newinsert=$this->db->update('subbranch_wallet',$data27);
		 }
	 else
	 {
		 $data28=array(
			 'subbranch_id' =>$reciever,
				'p_code'=>$pcode,
				'rec_quantity'=>$sendquantity,
				'date'=>Date("y-m-d")
			 
			 );
			$newinsert=$this->db->insert('subbranch_wallet',$data28);
		 }
			
			if($newinsert)
			{
			 $this->db->where('p_code',$pcode);
			 $this->db->where('subbranch_id',$senderid);
			 $sbrawallet=$this->db->get('subbranch_wallet')->row();
 
			$data29=array(
			 'rec_quantity'=>$sbrawallet->rec_quantity-$sendquantity, 
			'sale_quantity' =>$sbrawallet->sale_quantity+$sendquantity,
			'date'=>Date('y-m-d')
			 );
			$this->db->where('id',$sbrawallet->id);
			 $brawallet=$this->db->update('subbranch_wallet', $data29);
		}
		$data30=array(
		 'p_code' =>$pcode,
		 'Discription'=>"Subbranch to Subbranch",
		 'quantity'=>$sendquantity,
			'sender_usernm'=>$ssendusernm->username,
			'reciver_usernm'=>$sreciusernm->username,
			
		 );
		 $insertprs=$this->db->insert('product_trans_detail',$data30);
		 if($insertprs&&$brawallet&& $newinsert){
				 
		 $data['reciever']=$reciever;   
		 $this->load->view('Branch/subbranchtosubbranch',$data);
				}
		 }
		 else
		 {?>
<script>
alert("You can not send own Subbranch Product");
$("#sendproductdetail").hide();
window.location.reload();
</script>
<?php 
		 } 
			}
			if($idcheck==2){
			$this->db->where('p_code',$pcode);
			 $this->db->where('branch_id',$reciever);
			 $brawallet=$this->db->get('branch_wallet');
 
		 if($brawallet->num_rows()>0){
			 $bwll=$brawallet->row();
			 $data31=array(
				 'rec_quantity' =>$bwll->rec_quantity+$sendquantity, 
				 'date'=> Date("y-m-d")
				
				 );
			 $this->db->where('id',$bwll->id);
			 $newinsert=$this->db->update('branch_wallet',$data31);
		 }
	 else
	 {
		 $data32=array(
			 'branch_id' =>$reciever,
				'p_code'=>$pcode,
				'rec_quantity'=>$sendquantity,
				'date'=> Date("y-m-d")
			 );
			$newinsert=$this->db->insert('branch_wallet',$data32);
		 }
			
			if($newinsert)
			{
			 $this->db->where('p_code',$pcode);
			 $this->db->where('subbranch_id',$senderid);
			 $sbrawallet=$this->db->get('subbranch_wallet')->row();
 
			$data32=array(
			 'rec_quantity'=>$sbrawallet->rec_quantity-$sendquantity, 
				'sale_quantity' =>$sbrawallet->sale_quantity+$sendquantity,
			 );
			$this->db->where('id',$sbrawallet->id);
			 $brawallet=$this->db->update('subbranch_wallet', $data32);
		}
			 $this->db->where('id',$reciever);
			 $branch=$this->db->get('branch')->row();
		$data33=array(
		 'p_code' =>$pcode,
		 'Discription'=>"Subbranch to Branch",
		 'quantity'=>$sendquantity,
			'sender_usernm'=>$ssendusernm->username,
			'reciver_usernm'=>$branch->username,
		 );
		 $insertprss=$this->db->insert('product_trans_detail',$data33); 
 
			if($insertprss&& $brawallet&&$newinsert){
					$data['reciever']=$reciever;
				$this->load->view('Branch/subbranchtobranch',$data);
				} 
		}
		}
		function delete_branch(){

		 $id=$this->uri->segment(3);
		 $data['view']= $this->branch->deleteBranch($id);
		 redirect(base_url().'branchController/branchListActive');
		}
		public function offlinepaymentapproval()         
		{
		$data['branch']= $this->branch->getValue();
		$data['pageTitle'] = 'Payment Approval';
		$data['smallTitle'] = 'Payment Approval';
		$data['mainPage'] = 'Payment Approval';
		$data['subPage'] = 'Payment Approval';
		$data['title'] = 'Admin Payment Approval';
		$data['headerCss'] = 'headerCss/adminapprovelcss';
		$data['footerJs'] = 'footerJs/branchproducttransferJs';
		$data['mainContent'] = 'Branch/offlinepaymentapproval';
		$this->load->view("includes/mainContent", $data);
		}
		function getsubpayment() {
			$tid = $this->input->post("branch");
			$var = $this->branch->getsbranch($tid);
			if($var->num_rows() > 0){
		?>
<option value="">-Select Sub Branch-</option>
<?php	foreach ($var->result() as $row)
			{?>
<option value="<?php echo $row->id;?>" class="text-uppercase"><?php echo $row->bname;?></option>
<?php }
		}
		
}	
function getemptype(){
$subbranch= $this->input->post('subBranch');
$emp= $this->employee->empSubbranch1($subbranch);
			if($emp->num_rows()>0){
				?>
		<option value="">-Select Employee-</option>
<?php	foreach ($emp->result() as $row)
			{?>
<option value="<?php echo $row->id;?>" class="text-uppercase"><?php echo $row->name;?></option>
		<?php	}
		}
 }
 function remainingamount(){
	 $data['branchid']=$this->input->post('branchid');
	$data['subbranchid']=$this->input->post('sbranchid');
	$data['enddate']=$this->input->post('enddate');
	$data['delivery']=$this->input->post('delivery');
	$this->db->where('del_boy_id',$this->input->post('delivery'));
	$this->db->where('order_date',$this->input->post('enddate'));
	$this->db->where('sub_branchid',$this->input->post('sbranchid'));
	$order=$this->db->get('order_serial');
	$data['odrdernum']=$order->num_rows();
	$data['oderdetail']=$order->result();
	$this->load->view('Branch/paymentdetail',$data);
 }
 function branchorderapprove(){
 	$data['pageTitle'] = 'Branch Approval';
	$data['smallTitle'] = 'Branch Approval';
	$data['mainPage'] = 'Branch Approval';
	$data['subPage'] = 'Branch Approval';
	$data['title'] = 'Branch Approval';
	$data['headerCss'] = 'headerCss/adminapprovelcss';
	$data['footerJs'] = 'footerJs/producttransfer';
	$data['mainContent'] = 'Branch/branchorderapprove';
	$this->load->view("includes/mainContent", $data);
 }
 	function match_name_branch(){
	     $name=$this->input->post('name');
	    $this->db->where('b_name',$name);
	    $panno=$this->db->get('branch')->row();
	    if($panno){
	        echo "<p class='error' style='color:red;'>You can not use duplicate Branch Name!!</p>";
	    }else{
	       echo "<p class='error' style='color:green;'>Correct</p>";
	    }
	}
	function paidInvoice(){
	 $data['pageTitle'] = 'Paid Invoice';
	$data['smallTitle'] = 'Paid Invoice';
	$data['mainPage'] = 'Paid Invoice';
	$data['subPage'] = 'Paid Invoice';
	$data['title'] = 'Paid Invoice';
	$data['headerCss'] = 'headerCss/adminapprovelcss';
	$data['footerJs'] = 'footerJs/producttransfer';
	$data['mainContent'] = 'Branch/paidInvoice';
	$this->load->view("includes/mainContent", $data);
	}
}
 