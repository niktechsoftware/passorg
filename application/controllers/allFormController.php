<?php
class AllFormController extends CI_Controller{
    
    	public function __construct(){
		parent::__construct();
			$this->is_login();
	$this->load->model("smsmodel");	
	
	}
	
	
		function is_login(){
		$is_login = $this->session->userdata('is_login');
	
		if(($is_login != true)){
			
			redirect("index.php/homeController/index");
		}
	
	}
    function confirmotp(){
       $invoice =  $this->input->post("invoice");
       $otp = $this->input->post("otp");
       $this->db->where("invoice_no",$invoice);
       $this->db->where("otp",$otp);
         $this->db->where("status",0);
       $asp = $this->db->get("assignproduct");
       if($asp->num_rows()>0){
           echo "1";
       }else{
            $this->db->where("invoice_no",$invoice);
            $this->db->where("otp",$otp);
              $this->db->where("detail_delivery",0);
            $asp = $this->db->get("order_serial");
            if($asp->num_rows()>0){
                echo "1";
            }else{
                echo "0";
            }
       }
    }
    
   
    
    function confirmotpmatch(){
         $this->load->model("subscriber");
      $invoice=  $this->input->post("invoice");
       $paidamount=  $this->input->post("paidamount");
      
        $totalamount=  $this->input->post("totalamount");
         $mode=  $this->input->post("mode");
          $transid=  $this->input->post("transid");
           $this->db->where("invoice_no",$invoice);
           $db = $this->db->get("day_book");
           if($db->num_rows()>0){
               echo "Already Confirm";
           }else{   
               
                          $this->db->where("invoice_no",$invoice);
                             $this->db->where("status",0);
                           $asp = $this->db->get("assignproduct");
                            if($asp->num_rows()>0){
                                $asp=$asp->row();
                                $this->db->where("login_username",$asp->sender_username);
                                $this->db->where("opening_date",date('Y-m-d'));
         $op1 =  $this->db->get("opening_closing_balance");
        if($op1->num_rows()>0){
        $op1=  $op1->row();  
         $balance = $op1->closing_balance;
           $close1 = $balance + $paidamount;
         $bal = array(
            "closing_balance" => $close1,
            "login_username"=>$asp->sender_username
          );
          $this->db->where("login_username",$asp->sender_username);
          $this->db->where("opening_date",date('Y-m-d'));
          $this->db->update("opening_closing_balance",$bal);
        }  else{
           $close1=$paidamount;
        }                    
                                
                                $upstatus['status'] =1; 
                                 $this->db->where("invoice_no",$invoice);
                             $this->db->where("status",0);
                             $this->db->update("assignproduct",$upstatus);
                                $dataday = array(
                                    "paid_to"   =>$asp->sender_username,
                                    "paid_by"   =>$asp->reciver_usernm,
                                    "reason"    =>"product_tranfer ".$transid,
                                    "dabit_cradit"=>1,
                                    "amount"        =>$paidamount,
                                    "closing_balance"=>$close1,
                                    "pay_date"=>date("Y-m-d H:i:s"),
                                    "pay_mode" =>$mode,
                                    "invoice_no"=>$invoice
                                    );
                                    
                                    $this->db->insert("day_book",$dataday);
                                  $remainb =   $totalamount-$paidamount;
                                  $this->db->where("username",$asp->reciver_usernm);
                                 $mb =  $this->db->get("m_balance");
                                 if($mb->num_rows()>0){
                                     $updf['balance'] = $remainb+$mb->row()->balance;
                                      $this->db->where("username",$asp->reciver_usernm);
                                      $this->db->update("m_balance", $updf);
                                 }else{
                                      $updf['balance']=$remainb;
                                       $updf['username']=$asp->reciver_usernm;
                                       $this->db->insert("m_balance", $updf);
                                 }
                                    echo "Success";
                                $sms="Dear ".$asp->reciver_usernm." payment of ".$paidamount." is done successfully and updated with in 24 hours in your account.Thanks. www.passystem.in";
                                $sms1 = "Dear ".$asp->sender_username." Your invoice Order".$invoice." has been successfully delievered by the DI And amount of ".$paidamount." has been paid by the ".$asp->reciver_usernm.". thanks. www.passystem.in";
                                
                          $mobile =  $this->subscriber->getmobilefromuser($asp->reciver_usernm);
                          $mobile1 =  $this->subscriber->getmobilefromuser($asp->sender_username);
                          $getv= sms($mobile,$sms);
                            $max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
		        $master_id=$max_id->maxid+1;
                $this->smsmodel->sentmasterRecord($sms,2,$master_id,$getv);
                          $getv= sms($mobile1,$sms1);
                           
                            $max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
		        $master_id=$max_id->maxid+1;
                $this->smsmodel->sentmasterRecord($sms1,2,$master_id,$getv);
                           
                            }else{
                                $this->db->where("invoice_no",$invoice);
                                    $asp = $this->db->get("order_serial");
                                    if($asp->num_rows()>0){
                                        $asp= $asp->row();
                                          $this->db->where("id",$asp->sub_branchid);
                               $gsb =  $this->db->get("sub_branch")->row();
                                
                                          //$this->db->where("login_username",$gsb->username);
                                          	$op1 = $this->db->query("select * from opening_closing_balance where login_username='$gsb->username' ORDER BY id DESC LIMIT 1");
                               // $this->db->where("opening_date",date('Y-m-d'));
         //$op1 =  $this->db->get("opening_closing_balance")->row();
         
         if($op1->num_rows()>0){
        $op1=  $op1->row();  
         $balance = $op1->closing_balance;
           $close1 = $balance + $paidamount;
         $bal = array(
            "closing_balance" => $close1,
            "login_username"=>$gsb->username
          );
          $this->db->where("id",$op1->id);
          $this->db->update("opening_closing_balance",$bal);
        } 
              
                              
                                $upstatus['detail_delivery'] =1; 
                                 $this->db->where("invoice_no",$invoice);
                             $this->db->where("detail_delivery",0);
                             $this->db->update("order_serial",$upstatus);
                             $this->db->where("id",$asp->cust_id);
                             $cinfo = $this->db->get("customers")->row();
                                $dataday = array(
                                    "paid_to"   =>$gsb->username,
                                    "paid_by"   =>$cinfo->username,
                                    "reason"    =>"Online order ".$transid,
                                    "dabit_cradit"=>1,
                                    "amount"        =>$paidamount,
                                    "closing_balance"=>$close1,
                                    "pay_date"=>date("Y-m-d H:s:i"),
                                    "pay_mode" =>$mode,
                                    "invoice_no"=>$invoice
                                    );
                                    $this->db->insert("day_book",$dataday);
                                       $remainb =   $totalamount-$paidamount;
                                  $this->db->where("username",$cinfo->username);
                                 $mb =  $this->db->get("m_balance");
                                 if($mb->num_rows()>0){
                                     $updf['balance'] = $remainb+$mb->row()->balance;
                                      $this->db->where("username",$cinfo->username);
                                      $this->db->update("m_balance", $updf);
                                 }else{
                                      $updf['balance']=$remainb;
                                       $updf['username']=$cinfo->username;
                                       $this->db->insert("m_balance", $updf);
                                 } 
                                 echo "Success";
                                  $sms="Dear ".$cinfo->username." payment of ".$paidamount." is done successfully and updated with in 24 hours in your account.Thanks. www.passystem.in";
                                $sms1 = "Dear ".$gsb->username." Your invoice Order".$invoice." has been successfully delievered by the DI And amount of ".$paidamount." has been paid by the ".$cinfo->username.". thanks. www.passystem.in";
                         
                          $mobile =  $cinfo->mobile;
                          $mobile1 =  $this->subscriber->getmobilefromuser($gsb->username);
                          $getv= sms($mobile,$sms);
                            $max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
            		        $master_id=$max_id->maxid+1;
                            $this->smsmodel->sentmasterRecord($sms,2,$master_id,$getv);
                            $getv= sms($mobile1,$sms1);
                            $max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
            		        $master_id=$max_id->maxid+1;
                            $this->smsmodel->sentmasterRecord($sms1,2,$master_id,$getv);
                                    }
                                
                              
                                
                                
                                
                            }
                }
    }
	function getCity(){
		$state = $this->input->post("state");
		$this->load->model("allFormModel");
		$result = $this->allFormModel->getCity($state);
		
			echo '<option value="">-City-</option>';
		foreach ($result->result() as $row):
			echo '<option value="'.$row->city.'">'.$row->city.'</option>';
		endforeach;
	}
	
	function getArea(){
		$state = $this->input->post("state");
		$city = $this->input->post("city");
		$this->load->model("allFormModel");
		$result = $this->allFormModel->getArea($state,$city);
	
		echo '<option value="">-Area-</option>';
		foreach ($result->result() as $row):
		echo '<option value="'.$row->area.'">'.$row->area.'</option>';
		endforeach;
	}
	
	function getPin(){
		$state = $this->input->post("state");
		$city = $this->input->post("city");
		$area = $this->input->post("area");
		$this->load->model("allFormModel");
		$result = $this->allFormModel->getPin($state,$city,$area);
		
		foreach ($result->result() as $row):
		echo $row->pin;
		endforeach;
	}
	
	function changeStatus()
	{if($this->session->userdata("login_type")==1){
		$rowid  = $this->input->post("rowid");
		$tablename = $this->input->post("tablename");
		$currentstatus =$this->input->post("currentstatus");
		if($currentstatus==1)
		{
			$updateStatus=array("status"=>0);
		    $this->db->where("id",$rowid);
		    $this->db->update($tablename,$updateStatus);
		    echo "Inactivated";
		}
		else
		{
			$updateStatus=array("status"=>1);
			$this->db->where("id",$rowid);
			$this->db->update($tablename,$updateStatus);
			echo "Activated";
		} 
	}
	}
}