<?php
class Smsmodel extends CI_Model{
    
    function sendLevelSms($positionFirstList,$position){
    //days logic for eng hindi combination2 days continew hindi and english pending
     $this->db->where("position",$position);
    $smspo= $this->db->get("oldsms")->row();
     foreach($positionFirstList as $cid):
         $this->db->where("id",$cid);
         $cData = $this->db->get("customers")->row();
         $mobile =$cData->mobile;
         $msg = $smspo->sms;
         $this->db->where("cid",$cid);
         $coldsms = $this->db->get("customerDailySms");
         if($coldsms->num_rows()>0){
              $datad=array(
             "date"=>date("Y-m-d")
             );
              $this->db->where("cid",$cid);
             $this->db->update("customerDailySms",$datad);
         }else{
         $datad=array(
             "cid"=>$cid,
             "position"=>$position,
             "date"=>date("Y-m-d")
             );
             $this->db->insert("customerDailySms",$datad);
         }
           $getv =mysmsHindi($mobile,$msg);
                $max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
		        $master_id=$max_id->maxid+1;
                $this->smsmodel->sentmasterRecord($msg,3,$master_id,$getv);
         endforeach;
 }
 
    function sendTreeSms($pcid){
        $this->db->where("position",4);
    $smspo= $this->db->get("oldsms")->row();
       while($pcid!=0){
          $this->db->where("id",$pcid);
          $cud = $this->db->get("customers")->row();
         $this->db->where("parentID",$pcid);
        $getCust= $this->db->get("customers");
        if(($getCust->num_rows()>0) && ($getCust->num_rows()<20)){
            $mobile =$cud->mobile;
            $rtyu = 20 - $getCust->num_rows();
            $msg = "बधाई हो !!! आपकी सफलता एवं सम्पन्नता अब आपसे मात्र ".$rtyu."  स्टेप ही दूर है।  जल्द ही इसे पूरा करें और एक सम्पन्न एवं सुखद सामाजिक जीवन का आनंद प्राप्त करें। आपका सम्पूर्ण समय आनंददायक हो।";
            $getv =mysmsHindi($mobile,$msg);
                $max_id = $this->db->query("SELECT MAX(id) as maxid FROM sent_sms_master")->row();
		        $master_id=$max_id->maxid+1;
                $this->smsmodel->sentmasterRecord($msg,3,$master_id,$getv);
        }
        $pcid= $cud->parentID;
       }
    }
    
    
    function checkDays($id){
         $this->db->where("cid",$id);
               $oldRecord = $this->db->get("customerDailySms");
               if($oldRecord->num_rows()>0){
                    $cdate    =date("Y-m-d");
                   $date1=date_create($oldRecord->row()->date);
                    $date2=date_create($cdate);
                    $diff=date_diff($date1,$date2);
                    $diffa =  $diff->format("%a");
                 /* $oldRecord->row()->date;
                  $oldYear  =date("Y",$oldRecord->row()->date);
                  $oldMonth =date("m",$oldRecord->row()->date);
                  $oldDay   =date("d",$oldRecord->row()->date);
                 
                  $cYear    =date("m",$cdate);
                  $cMonth   =date("m",$cdate);
                  $cDay     =date("d",$cdate);
                  if(($oldYear <  $cYear) || ($oldMonth < $cMonth) ||  (($cDay-$oldDay)>2)){
                      return true;
                  }else{
                     return false; 
                  }*/
                if($diffa>2){
                     return true;
                }else{
                 return false;     
                }  
                  
               }else{
                  return true;  
               }
    }
    
	function sendReportmy($getv,$mid){
		    $data =array(
		        "response"=>$getv,
		        "mid"=>$mid
		        );
	  
		$this->db->insert("savesmsResponce",$data);
		return true;
	}
	
function sentmasterRecord($msg,$totsmssent,$master_id,$response_id){
		$schol_code = $this->session->userdata("username");
		$this->db->where("id",$master_id);
		$getcheck = $this->db->get("sent_sms_master");
		if($getcheck->num_rows()>0){
			return false;
		}else{
		$data=array(
				"id"=>$master_id,
				"tot_count"=>$totsmssent,
				"sms"=>$msg,
				"username"=>$schol_code,
				"date"=>Date("Y-m-d G:i:s"),
				"response_id"=>$response_id
		
		);
		$insertwrongnumber= $this->db->insert("sent_sms_master",$data);
		return true;
		}	
	}
	function sentmasterRecord1($msg,$totsmssent,$master_id,$response_id,$school_code){
		//$schol_code = $this->session->userdata("school_code");
		$this->db->where("id",$master_id);
		$getcheck = $this->db->get("sent_sms_master");
		if($getcheck->num_rows()>0){
			return false;
		}else{
		$data=array(
				"id"=>$master_id,
				"tot_count"=>$totsmssent,
				"sms"=>$msg,
				"school_code"=>$school_code,
				"date"=>Date("Y-m-d G:i:s"),
				"response_id"=>$response_id
		
		);
		$insertwrongnumber= $this->db->insert("sent_sms_master",$data);
		return true;
		}	
	}
	
	function smstest($msg,$date){
	  $school_code=$this->session->userdata("school_code");
	      $this->db->where("sms",$msg);
	        $this->db->where("school_code",$school_code);
	   $this->db->where("Date(date)",$date);
	   $smsdt= $this->db->get("sent_sms_master");
	   if($smsdt->num_rows()>0){
	      $row= $smsdt->row();
	          $smsdate=$row->date;
	          $cur=date("G",strtotime($smsdate));
	     
	          $curhour= date('H');
	      
            if($curhour==$cur){
              
            return false;
            }
            else{
              
            return true;
            }
	      
	      
	         
	
	       
	   }else{
	         
	       return true;
	   }
	    
	    
	}
	function getMobile($str_arr,$msg,$master_id,$mv){
	    if($mv==1){
	        $sessionv = 0;
	    $fmobile =$this->session->userdata("mobile_number");
	    	foreach($str_arr as $xuv):
			$checknum = $this->checknum($xuv,$msg,$master_id);
			if($checknum){
				if(!($sessionv)){
				    $sessionv=1;
					$fmobile =$checknum;
				}else{
					$fmobile=$fmobile.",".$checknum;
				}
			
			}
			endforeach;
			return $fmobile;
	    }else{
	         $fmobile =$this->session->userdata("mobile_number");
	    	foreach($str_arr as $xuv):
			$checknum = $this->checknum($xuv->mobile,$msg,$master_id);
			if($checknum){
				if(!($this->session->userdata("mobile_number"))){
					$fmobile =$checknum;
				}else{
					$fmobile=$fmobile.",".$checknum;
				}
			
			}
			endforeach;
			return $fmobile;
	    }
	}
	
	function getMobileSendSms($str_arr,$master_id,$mv,$sende_Detail){
		
			$sessionv = 0;
			$fmobile =$this->session->userdata("mobile_number");
		$i=0;	foreach($str_arr as $xuv):
			$checknum = $this->checknumSendSms($xuv->mobile,$master_id);
			if($checknum){
				$msg="Dear Student ".$xuv->name." your Username For login is ".$xuv->username." and Password is ".$xuv->password." Please Use for Login And check your account for homework, on line classess and other details.<br> For more info login to our website.".$sende_Detail->web_url;
			$getv=  mysms($sende_Detail->auth_key,$msg,$sende_Detail->sender_id,$checknum);
			$this->smsmodel->sentmasterRecord($msg,2,$master_id,$getv);
			$i++;
			}
			endforeach;
			return $i;
		
	}
	
	function checknumSendSms($cnumber,$master_id){
	  
		$cnumber = str_replace(' ', '', $cnumber);
		if((is_numeric($cnumber)) && (strlen($cnumber)==10)){
			return $cnumber;
		}else{
			$data=array(
					
					"mobile"=>$cnumber,
					"sms_master_id"=>$master_id
						
			);
			$insertwrongnumber= $this->db->insert("wrong_number_sms",$data);
			return false;
			
			
		}
			
	}
	
	function checknum($cnumber,$msg,$master_id){
	  
		$cnumber = str_replace(' ', '', $cnumber);
		if((is_numeric($cnumber)) && (strlen($cnumber)==10)){
			return $cnumber;
		}else{
			$data=array(
					
					"mobile"=>$cnumber,
					"sms_master_id"=>$master_id
						
			);
			$insertwrongnumber= $this->db->insert("wrong_number_sms",$data);
			return false;
		}
			
	}
	
	
	function sendReport($getv,$master_id){
	  
		foreach ($getv as $key => $rowValue):
			if($rowValue['sent_number']){
				$number=$rowValue['sent_number'];
				$msm_id = $rowValue['msg_id'];
				$smsf =$master_id;
				$data=array(
						'sent_number'=>$number,
						'msg_id'=>$msm_id,
						'sms_master_id'=>$master_id,
						'status'=>1,
						'date'=>date('Y-m-d H:s:i')
				);
				$this->db->insert("sent_sms_details",$data);
			}else{
				
			}
			
		endforeach;
		return true;
	}
	
		function getsmsseting(){
		$row = $this->db->get("sms")->row();
		return $row;
	}
	function getsmssender(){
		//$this->db->where("school_code",$school_code);
		$val=$this->db->get("sms_setting");
		return $val;
	}
	
	function getAllFatherNumber($school_code){
		$this->db->distinct();
		$this->db->select('student_info.mobile');
		$this->db->from('student_info');
		$this->db->join('class_info','class_info.id=student_info.class_id');
		$this->db->where("class_info.school_code",$school_code);
		$this->db->where("student_info.status",1);
		$query=$this->db->get();
		return $query;
	}
	function getClassFatherNumber($school_code,$classid){
	
			$this->db->distinct();
			$this->db->select('student_info.mobile');
			$this->db->from('student_info');
			$this->db->join('class_info','class_info.id=student_info.class_id');
			$this->db->where("student_info.class_id",$classid);
			$this->db->where("class_info.school_code",$school_code);
			$this->db->where("student_info.status",1);
			$query=$this->db->get();
			

		return $query;
	}
	function getClassFatherNumberWithDetails($school_code,$classid){
	
		
		$this->db->select('student_info.mobile');
		$this->db->select('student_info.name');
		$this->db->select('student_info.username');
		$this->db->select('student_info.password');
		$this->db->from('student_info');
		$this->db->join('class_info','class_info.id=student_info.class_id');
		$this->db->where("student_info.class_id",$classid);
		$this->db->where("class_info.school_code",$school_code);
		$this->db->where("student_info.status",1);
		$query=$this->db->get();
			
	
		return $query;
	}
	
	function getTransportFatherNumber($vid){
	
		$this->db->distinct();
		//$this->db->select('student_info.mobile');
		//$this->db->from('student_info');
		$this->db->where("v_id",$vid);
		$this->db->where("status",1);
		$query=$this->db->get('student_info');
		

	return $query;
}

}