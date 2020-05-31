<?php
	class Reports extends CI_Controller{
		public function __construct(){
		parent::__construct();
			$this->is_login();
		$this->load->model("employee");
		$this->load->model("branch");
		$this->load->model("shop");
		$this->load->model("subscriber");
		$this->load->model("smsmodel");
	}
		function is_login(){
		$is_login = $this->session->userdata('is_login');
	
		if(($is_login != true)){
			
			redirect("index.php/homeController/index");
		}
	}
	
	function reportPanel(){
	    
	    $subBranchID=array();
		    $branchID=array();
		    $subsciberID=array();
		     if($this->session->userdata("login_type")==1){
                        $getallb = $this->db->get("branch");
                		if($getallb->num_rows()>0){
                		foreach($getallb->result() as $bid):
                		    array_push($branchID, $bid->id);
                		endforeach;	 
                		$this->db->where_in("district",$branchID);
    		            $subBranchData = $this->db->get("sub_branch");
    		            foreach($subBranchData->result() as $subBranchRow):
        				    array_push($subBranchID, $subBranchRow->id);
        		        endforeach;
                		}
                  }else{
                      if($this->session->userdata("login_type")==2){
                          $this->db->where("id",$this->session->userdata("id"));
                           $getallb = $this->db->get("branch");
                		if($getallb->num_rows()>0){
                		foreach($getallb->result() as $bid):
                		    array_push($branchID, $bid->id);
                		endforeach;	 
                		$this->db->where_in("district",$branchID);
    		            $subBranchData = $this->db->get("sub_branch");
    		            foreach($subBranchData->result() as $subBranchRow):
        				    array_push($subBranchID, $subBranchRow->id);
        		        endforeach;
                		}
                         }else{
                             $subBranchID[0]=$this->session->userdata("id");
                         }
                  }
		$data['subBranch'] =$subBranchID;     
	    
		$data['pageTitle'] = 'Report Panel';
		$data['smallTitle'] = 'Report';
		$data['mainPage'] = 'Report Panel Area';
		$data['subPage'] = 'Report Panel';
		$data['title'] = 'Report Panel Area ';
		$data['headerCss'] = 'headerCss/listCss';
		$data['footerJs'] = 'footerJs/listJs';
		$data['mainContent'] = 'reportPanel';
		$this->load->view("includes/mainContent", $data);
	}	
	
	function selleingReport1(){
		  
		$data['subBranch'] =$subBranchID;     
		$data['pageTitle'] = 'Selling Report';
		$data['smallTitle'] = 'Report';
		$data['mainPage'] = 'Report Panel Area';
		$data['subPage'] = 'Selling Report';
		$data['title'] = 'Report Panel Area ';
		$data['headerCss'] = 'headerCss/listCss';
		$data['footerJs'] = 'footerJs/listJs';
		$data['mainContent'] = 'selleingReport1';
		$this->load->view("includes/mainContent", $data);
	}
	
		function selleingReport(){
		    $subBranchID=array();
		    $branchID=array();
		     if($this->session->userdata("login_type")==1){
                        $getallb = $this->db->get("branch");
                		if($getallb->num_rows()>0){
                		foreach($getallb->result() as $bid):
                		    array_push($branchID, $bid->id);
                		endforeach;	 
                		$this->db->where_in("district",$branchID);
    		            $subBranchData = $this->db->get("sub_branch");
    		            foreach($subBranchData->result() as $subBranchRow):
        				    array_push($subBranchID, $subBranchRow->id);
        		        endforeach;
                		}
                  }else{
                      if($this->session->userdata("login_type")==2){
                          $this->db->where("id",$this->session->userdata("id"));
                           $getallb = $this->db->get("branch");
                		if($getallb->num_rows()>0){
                		foreach($getallb->result() as $bid):
                		    array_push($branchID, $bid->id);
                		endforeach;	 
                		$this->db->where_in("district",$branchID);
    		            $subBranchData = $this->db->get("sub_branch");
    		            foreach($subBranchData->result() as $subBranchRow):
        				    array_push($subBranchID, $subBranchRow->id);
        		        endforeach;
                		}
                         }else{
                             $subBranchID[0]=$this->session->userdata("id");
                         }
                  }
		$data['subBranch'] =$subBranchID;     
		$data['pageTitle'] = 'Selling Report';
		$data['smallTitle'] = 'Report';
		$data['mainPage'] = 'Report Panel Area';
		$data['subPage'] = 'Selling Report';
		$data['title'] = 'Report Panel Area ';
		$data['headerCss'] = 'headerCss/listCss';
		$data['footerJs'] = 'footerJs/listJs';
		$data['mainContent'] = 'selleingReport';
		$this->load->view("includes/mainContent", $data);
	}	
		function cashBackDesc(){
		     $subBranchID=array();
		    $branchID=array();
		     if($this->session->userdata("login_type")==1){
                        $getallb = $this->db->get("branch");
                		if($getallb->num_rows()>0){
                		foreach($getallb->result() as $bid):
                		    array_push($branchID, $bid->id);
                		endforeach;	 
                		$this->db->where_in("district",$branchID);
    		            $subBranchData = $this->db->get("sub_branch");
    		            foreach($subBranchData->result() as $subBranchRow):
        				    array_push($subBranchID, $subBranchRow->id);
        		        endforeach;
                		}
                  }else{
                      if($this->session->userdata("login_type")==2){
                          $this->db->where("id",$this->session->userdata("id"));
                           $getallb = $this->db->get("branch");
                		if($getallb->num_rows()>0){
                		foreach($getallb->result() as $bid):
                		    array_push($branchID, $bid->id);
                		endforeach;	 
                		$this->db->where_in("district",$branchID);
    		            $subBranchData = $this->db->get("sub_branch");
    		            foreach($subBranchData->result() as $subBranchRow):
        				    array_push($subBranchID, $subBranchRow->id);
        		        endforeach;
                		}
                         }else{
                             $subBranchID[0]=$this->session->userdata("id");
                         }
                  }
		$data['subBranch'] =$subBranchID; 
		$data['pageTitle'] = 'Cash Back Report';
		$data['smallTitle'] = 'Report';
		$data['mainPage'] = 'Report Panel Area';
		$data['subPage'] = 'Cash Back';
		$data['title'] = 'Report Panel Area ';
		$data['headerCss'] = 'headerCss/listCss';
		$data['footerJs'] = 'footerJs/listJs';
		$data['mainContent'] = 'cashBackDesc';
		$this->load->view("includes/mainContent", $data);
	}	
	
		function cashPayment(){
		$data['pageTitle'] = 'Accounting';
		$data['smallTitle'] = 'Transaction';
		$data['mainPage'] = 'Transaction';
		$data['subPage'] = 'Cash Payment';
		$data['title'] = 'cashPayment';
		$data['headerCss'] = 'headerCss/listCss';
		$data['footerJs'] = 'footerJs/listJs';
		$data['mainContent'] = 'cashPayment';
		$this->load->view("includes/mainContent", $data);
	}
	function staffSallery(){
		$data['pageTitle'] = 'Staff Salary Report';
		$data['smallTitle'] = 'Report';
		$data['mainPage'] = 'Report Panel Area';
		$data['subPage'] = 'Staff Salary';
		$data['title'] = 'Report Panel Area ';
		$data['headerCss'] = 'headerCss/listCss';
		$data['footerJs'] = 'footerJs/listJs';
		$data['mainContent'] = 'staffSallery';
		$this->load->view("includes/mainContent", $data);
	}	
		function balancesheet(){
		$data['pageTitle'] = 'Balance Sheet Report';
		$data['smallTitle'] = 'Report';
		$data['mainPage'] = 'Report Panel Area';
		$data['subPage'] = 'Balance Sheet';
		$data['title'] = 'Report Panel Area ';
		$data['headerCss'] = 'headerCss/listCss';
		$data['footerJs'] = 'footerJs/listJs';
		$data['mainContent'] = 'balancesheet';
		$this->load->view("includes/mainContent", $data);
	}
	
	function expendture(){
		$data['pageTitle'] = 'Balance Sheet Report';
		$data['smallTitle'] = 'Report';
		$data['mainPage'] = 'Report Panel Area';
		$data['subPage'] = 'Balance Sheet';
		$data['title'] = 'Report Panel Area ';
		$data['headerCss'] = 'headerCss/listCss';
		$data['footerJs'] = 'footerJs/listJs';
		$data['mainContent'] = 'expendture';
		$this->load->view("includes/mainContent", $data);
	}
	
	}