<?php
class SmsAjax extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->load->model("smsmodel");
		//$this->load->model("employeemodel");
		}
		
		function is_login(){
			$is_login = $this->session->userdata('is_login');
			$is_lock = $this->session->userdata('is_lock');
			$logtype = $this->session->userdata('login_type');
			if(($logtype == 1)){
			}else{
			
			if($logtype != "admin"){
				//echo $is_login;
				redirect("index.php/homeController/index");
			}
			elseif(!$is_login){
				//echo $is_login;
				redirect("index.php/homeController/index");
			}
			elseif(!$is_lock){
				redirect("index.php/homeController/lockPage");
			}
			}
		}
	
	function smsSetting(){
		$msg = $this->input->post("message");
		$val = $this->db->get("sms")->row();
		
		$val1 = $val->$msg;
// 		print_r($val);
//  		exit();
		if($val1){
			$data = array(
				"$msg" => 0
			);
			?>
				<script>
					$("#<?php echo $msg;?>").removeClass("btn btn-sm btn-light-green").addClass("btn btn-sm btn-light-red");
					$("#<?php echo $msg;?>").removeClass("fa fa-check").addClass("fa fa-times fa fa-white");
					$("#<?php echo $msg;?>").html(" NO");
				</script>
			<?php
		}else{
			$data = array(
				"$msg" => 1
			);
			?>
				<script>
					$("#<?php echo $msg;?>").removeClass("btn btn-sm btn-light-red").addClass("btn btn-sm btn-light-green");
					$("#<?php echo $msg;?>").removeClass("fa fa-times fa fa-white").addClass("fa fa-check");
					$("#<?php echo $msg;?>").html(" YES");
				</script>		
			<?php
		}
		$this->db->update("sms",$data);
	}
	
	function sendNotice(){
		$count=0;
		$sender = $this->smsmodel->getsmssender($this->session->userdata("school_code"));
		$sende_Detail =$sender;
     	$sende_Detail1=	$sende_Detail->row();
		$msg =	$this->input->post("meg");
		//print_r($msg);exit;
		$fmobile = $this->input->post("m_number");
		$getv =sms($fmobile,$msg);
		$max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
		        $master_id=$max_id->maxid+1;
                $this->smsmodel->sentmasterRecord($msg,2,$master_id,$getv);
		redirect("index.php/login/mobileNotice/Notice");
	}
	
	
	function sendallParent(){
		$smscount=0;
		$count=0;
		$sender = $this->smsmodel->getsmssender($this->session->userdata("school_code"));
		if($sender->num_rows()>0){
		$sende_Detail =$sender->row();
		$msg =$this->input->post("meg");
		$query = $this->smsmodel->getAllFatherNumber($this->session->userdata("school_code"));
		$isSMS = $this->smsmodel->getsmsseting($this->session->userdata("school_code"));
		$fmobile=$this->session->userdata("mobile_number");
		if($isSMS->parent_message)
		{
		if($query->num_rows() > 0)
		{   
		if($fmobile){
			foreach($query->result() as $parentmobile):
			if($parentmobile->mobile){
			
			if($smscount<90){
				$fmobile =$fmobile.",".$parentmobile->mobile;
				$count=$count+1;
				$smscount++;
			}else{
				sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
				$fmobile="8382829593";
				$smscount=0;
			}
			
			}
			endforeach;
			}
			sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
			
		
		}
		else{
			$data['subPage'] = 'Mobile Message And Notice';
			$data['title'] = 'Mobile Message And Notice';
			$data['headerCss'] = 'headerCss/noticeCss';
			$data['footerJs'] = 'footerJs/noticeJs';
			$data['mainContent'] = 'norecordFound';
			$this->load->view("includes/mainContent", $data);
		}
		}
		redirect("index.php/login/mobileNotice/Parent%20Message/$count");
	}else
		{
			$data['subPage'] = 'Mobile Message And Notice';
			$data['title'] = 'Mobile Message And Notice';
			$data['headerCss'] = 'headerCss/noticeCss';
			$data['footerJs'] = 'footerJs/noticeJs';
			$data['mainContent'] = 'error';
			$this->load->view("includes/mainContent", $data);
		}
	}
	
	function sendAnnuncement(){
		$smscount=0;
		$count=0;
		$sender = $this->smsmodel->getsmssender($this->session->userdata("school_code"));
		if($sender){
		$sende_Detail =$sender->row();
		$msg =$this->input->post("meg");
		$employee = $this->employeemodel->employeeList($this->session->userdata("school_code"));
	
		$isSMS = $this->smsmodel->getsmsseting($this->session->userdata("school_code"));
		
		$fmobile=$this->session->userdata("mobile_number");
		if($isSMS->announcement)
		{ 
			if($fmobile){
			foreach($employee->result() as $empmob):
			if($empmob->mobile){
			if($smscount<90){
				$fmobile =$fmobile.",".$empmob->mobile;
				$count=$count+1;
				$smscount++;
			}else{
				sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
				$fmobile="8382829593";
				$smscount=0;
			}
			
			}
			endforeach;
			}
			sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
		
			redirect("index.php/login/mobileNotice/Announcement/$count");
		}
		else{
		    	$data['pageTitle'] = 'SMS Panel';
		$data['smallTitle'] = 'Mobile SMS error in table';
		$data['mainPage'] = 'SMS Panel Area';
			$data['subPage'] = 'Mobile Message And Notice';
			$data['title'] = 'Mobile Message And Notice';
			$data['headerCss'] = 'headerCss/noticeCss';
			$data['footerJs'] = 'footerJs/noticeJs';
			$data['mainContent'] = 'error';
			$this->load->view("includes/mainContent", $data);
		}
	
	}
	else{
	    	$data['subPage'] = 'Mobile Message And Notice';
			$data['title'] = 'Sender ID Not Approved Error Please Contact Administrator';
			$data['headerCss'] = 'headerCss/noticeCss';
			$data['footerJs'] = 'footerJs/noticeJs';
			$data['mainContent'] = 'error';
			$this->load->view("includes/mainContent", $data);
	}
	}	
	
	function sendGreeting(){
		$smscount=0;
		$count=0;
		$sender = $this->smsmodel->getsmssender($this->session->userdata("school_code"));
		if($sender){
		$sende_Detail =$sender->row();
		
		$msg =$this->input->post("meg");
		
		
		$employee = $this->employeemodel->employeeList($this->session->userdata("school_code"));
		$query = $this->smsmodel->getAllFatherNumber($this->session->userdata("school_code"));
		$isSMS = $this->smsmodel->getsmsseting($this->session->userdata("school_code"));
		
		$fmobile=$this->session->userdata("mobile_number");
		if($isSMS->greeting)
		{
			if($fmobile){
			foreach($employee->result() as $empmob):
			if($empmob->mobile){
			
			if($smscount<90){
				$fmobile =$fmobile.",".$empmob->mobile;
				$count=$count+1;
				$smscount++;
			}else{
				sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
				$fmobile="8382829593";
				$smscount=0;
			}
			
			}
			endforeach;
			}
			sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
			if($fmobile){
				foreach($query->result() as $parentmobile):
				if($parentmobile->mobile){
						
					if($smscount<90){
						$fmobile =$fmobile.",".$parentmobile->mobile;
						$count=$count+1;
						$smscount++;
					}else{
						sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
						$fmobile="8382829593";
						$smscount=0;
					}
						
				}
				endforeach;
			}//print_r($count);exit();
			sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
				
			
			}
			else{
			    	$data['pageTitle'] = 'SMS Panel';
		$data['smallTitle'] = 'Mobile SMS';
		$data['mainPage'] = 'SMS Panel Area';
				$data['subPage'] = 'Mobile Message And Notice';
				$data['title'] = 'Mobile Message And Notice';
				$data['headerCss'] = 'headerCss/noticeCss';
				$data['footerJs'] = 'footerJs/noticeJs';
				$data['mainContent'] = 'norecordFound';
				$this->load->view("includes/mainContent", $data);
			}
			//echo $fmobile;
		}
		redirect("index.php/login/mobileNotice/Greeting/$count");
	}
	function classwise(){	
		$smscount=0;
		$count=0;
		$class_id = $this->input->post("class");
	//	$section_id = $this->input->post("section");
	
		$sender = $this->smsmodel->getsmssender($this->session->userdata("school_code"));
		if($sender->num_rows()>0){
		$sende_Detail =$sender->row();
		$msg =	$this->input->post("meg");
		$isSMS = $this->smsmodel->getsmsseting($this->session->userdata("school_code"));
		
		$fmobile=$this->session->userdata("mobile_number");
		if($isSMS->parent_message)
		{
			
				$query = $this->smsmodel->getClassFatherNumber($this->session->userdata("school_code"),$class_id);
				
		
			
		if($query->num_rows() > 0)
		{   
		if($fmobile){
			foreach($query->result() as $parentmobile):
			if($parentmobile->mobile){
			
			if($smscount<90){
				$fmobile =$fmobile.",".$parentmobile->mobile;
				$count=$count+1;
				$smscount++;
			}else{
				sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
				$fmobile="8382829593";
			echo 	$fmobile;
				$smscount=0;
			}
			
			}
			endforeach;
			}
			echo $fmobile;
			sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
			
		
		}
		else{	$data['pageTitle'] = 'SMS Panel';
		$data['smallTitle'] = 'Mobile SMS';
		$data['mainPage'] = 'SMS Panel Area';
			$data['subPage'] = 'Mobile Message And Notice';
			$data['title'] = 'Mobile Message And Notice';
			$data['headerCss'] = 'headerCss/noticeCss';
			$data['footerJs'] = 'footerJs/noticeJs';
			$data['mainContent'] = 'norecordFound';
			$this->load->view("includes/mainContent", $data);
		
		}}
	redirect("index.php/login/mobileNotice/classwise/$count");
		}else
		{	$data['pageTitle'] = 'SMS Panel';
		$data['smallTitle'] = 'Mobile SMS';
		$data['mainPage'] = 'SMS Panel Area';
			$data['subPage'] = 'Mobile Message And Notice';
			$data['title'] = 'Mobile Message And Notice';
			$data['headerCss'] = 'headerCss/noticeCss';
			$data['footerJs'] = 'footerJs/noticeJs';
			$data['mainContent'] = 'Error';
			$this->load->view("includes/mainContent", $data);
		}
	   
	}
	
	function transportwise(){	
		$smscount=0;
		$count=0;
		$vehicle_id = $this->input->post("vehicle");
		$sender = $this->smsmodel->getsmssender($this->session->userdata("school_code"));
		if($sender->num_rows()>0){
		$sende_Detail =$sender->row();
		$msg =	$this->input->post("meg");
		$isSMS = $this->smsmodel->getsmsseting($this->session->userdata("school_code"));
		$fmobile=$this->session->userdata("mobile_number");
		if($isSMS->parent_message)
		{
		  $query = $this->smsmodel->getTransportFatherNumber($vehicle_id);
	    if($query->num_rows() > 0)
	     	{   
	     	if($fmobile){
			foreach($query->result() as $parentmobile):
			if($parentmobile->mobile){
			
			 if($smscount<90){
				$fmobile =$fmobile.",".$parentmobile->mobile;
				$count=$count+1;
				$smscount++;
			 }else{
				sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
				$fmobile="8382829593";
			   echo $fmobile;
				$smscount=0;
			}
			
			 }
			endforeach;
			}
			
			echo $fmobile;
			echo sms($fmobile,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
			//exit;
	    }
		else{	
			$data['pageTitle'] = 'SMS Panel';
			$data['smallTitle'] = 'Mobile SMS';
			$data['mainPage'] = 'SMS Panel Area';
			$data['subPage'] = 'Mobile Message And Notice';
			$data['title'] = 'Mobile Message And Notice';
			$data['headerCss'] = 'headerCss/noticeCss';
			$data['footerJs'] = 'footerJs/noticeJs';
			$data['mainContent'] = 'norecordFound';
			$this->load->view("includes/mainContent", $data);
		
		}
	}
	redirect("index.php/login/mobileNotice/transportwise/$count");
		}else
		{	
			$data['pageTitle'] = 'SMS Panel';
			$data['smallTitle'] = 'Mobile SMS';
			$data['mainPage'] = 'SMS Panel Area';
			$data['subPage'] = 'Mobile Message And Notice';
			$data['title'] = 'Mobile Message And Notice';
			$data['headerCss'] = 'headerCss/noticeCss';
			$data['footerJs'] = 'footerJs/noticeJs';
			$data['mainContent'] = 'Error';
			$this->load->view("includes/mainContent", $data);
		}
	   
	}
	
	function smsPanel(){
		$sender = $this->smsmodel->getsmssender()->row();
		
		$data['sender_Detail'] =$sender;
		$data['cbs']=checkBalSms($sender->uname,$sender->password);
		$data['pageTitle'] = 'SMS Panel';
		$data['smallTitle'] = 'Mobile SMS';
		$data['mainPage'] = 'SMS Panel Area';
		$data['subPage'] = 'SMS Panel';
		$data['title'] = 'SMS Panel Area ';
		$data['headerCss'] = 'headerCss/listCss';
		$data['footerJs'] = 'footerJs/listJs';
		$data['mainContent'] = 'smsPanel';
		$this->load->view("includes/mainContent", $data);
	}	
	function smsreport(){
	
		$sent_report = $this->db->get("sent_sms_master");
		$data['result']  =$sent_report;
		$data['pageTitle'] = 'SMS Report Panel';
		$data['smallTitle'] = 'SMS PAnel';
		$data['mainPage'] = 'SMS Report Panel';
		$data['subPage'] = 'Get Sms Report / SMS Panel';

		$data['title'] = 'Get SMS Report / SMS Panel';
		$data['headerCss'] = 'headerCss/smsCss';
		$data['footerJs'] = 'footerJs/smsJs';
		$data['mainContent'] = 'smsreport';
		$this->load->view("includes/mainContent", $data);
	}
	
	function viewsmsdetail(){
			$data['pageTitle'] = 'View SMS Report';
		$data['smallTitle'] = 'View SMS Report';
		$data['mainPage'] = 'View SMS Report';
		$data['subPage'] = 'View SMS Report';
		$data['title'] = 'View SMS Report ';
		$data['headerCss'] = 'headerCss/smsCss';
		$data['footerJs'] = 'footerJs/smsJs';
		$data['mainContent'] = 'viewsmsdetail';
		$this->load->view("includes/mainContent", $data);
	}	
	function resendsms(){
    
    	$count=0;
		$smsc =0;
		$smscount=0;
// 		$totsmssent = $this->input->post("totsmsv");
// 		$totbal = $this->input->post("totbal");
	
// 		if($totbal > $totsmssent){

	
		$sender = $this->smsmodel->getsmssender();
		$sende_Detail =$sender->row();
// 		print_r($sende_Detail);
		$msg =	$this->input->post("meg");
	    
		$fmobile1 = $this->input->post("m_number");
		$fmobile1=substr($fmobile1,2);
		$str_arr=explode(",",$fmobile1);
		$totnumb =  sizeof($str_arr);
		$max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
		$master_id=$max_id->maxid+1;
		
		$fmobile = $fmobile1;
	    $getv=  sms($fmobile,$msg);
		$dt= $this->smsmodel->sentmasterRecord($msg,$totnumb,$master_id,$getv);
		if($dt){
		   echo "Send-".$fmobile; 
		}	

}
	function wrongsmsdetail(){
		$data['pageTitle'] = 'View SMS Report';
		$data['smallTitle'] = 'View SMS Report';
		$data['mainPage'] = 'View SMS Report';
		$data['subPage'] = 'View SMS Report';
		$data['title'] = 'View SMS Report ';
		$data['headerCss'] = 'headerCss/smsCss';
		$data['footerJs'] = 'footerJs/smsJs';
		$data['mainContent'] = 'wrongsmsdetail';
		$this->load->view("includes/mainContent", $data);
}
function reminderSms(){
    	$data['pageTitle'] = 'Reminder SMS ';
		$data['smallTitle'] = 'Reminder SMS';
		$data['mainPage'] = 'Reminder SMS';
		$data['subPage'] = 'Reminder SMS Report';
		$data['title'] = 'Reminder SMS ';
		$data['headerCss'] = 'headerCss/smsCss';
		$data['footerJs'] = 'footerJs/smsJs';
		$data['mainContent'] = 'reminderSMS';
		$this->load->view("includes/mainContent", $data);
}
}