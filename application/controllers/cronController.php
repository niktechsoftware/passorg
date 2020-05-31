<?php
class cronController extends CI_Controller
{
    
    function autoSms(){
        $this->load->model("smsmodel");
        $positionFirstList=array();
        $positionSecondList=array();
         $positionThirdList=array();
         $positionFifthList=array();
        $this->db->where("status",1);
        $customerData = $this->db->get("customers");
        foreach($customerData->result() as $row):
            $this->db->where("id",$row->id);
           $getFevData =  $this->db->get("favourite_list");
           if($getFevData->num_rows()>0){
                $this->db->where("cust_usr",$row->id);
                $this->db->where("status",0);
                $getPurchaseStatus= $this->db->get("purchase_list");
                if($getPurchaseStatus->num_rows()>0){
                     $checkdaysv = $this->smsmodel->checkDays($row->id);
                      if($checkdaysv){
                        array_push($positionSecondList, $row->id);
                        }
                }else{
                  $orderDetails =  $this->db->query("select * from order_serial where status =1 and cust_id='$row->id' order by id desc limit 1");
                  if($orderDetails->num_rows()>0){
                  $cdate    =   date("Y-m-d");
                  $olddae   =   $orderDetails->row()->order_date;
                    $cdate    =date("Y-m-d");
                   $date1=date_create($orderDetails->row()->order_date);
                    $date2=date_create($cdate);
                    $diff=date_diff($date1,$date2);
                    $diffa =  $diff->format("%a");
                    if($diffa >27){
                        $checkdaysv = $this->smsmodel->checkDays($row->id);
                      if($checkdaysv){
                        array_push($positionThirdList, $row->id);
                        } 
                    }
                }
                }
              
           }else{
              $checkdaysv = $this->smsmodel->checkDays($row->id);
              if($checkdaysv){
                    array_push($positionFirstList, $row->id);
              }
                 
           }
            
            $this->db->where("parentID",$row->id);
        $getTreeDetails = $this->db->get("tree");
        if($getTreeDetails->num_rows()>19)
        {
             $checkdaysv = $this->smsmodel->checkDays($row->id);
             if($checkdaysv){
            array_push($positionFifthList, $row->id);
             }
        }
            
            endforeach;
          $this->smsmodel->sendLevelSms($positionFirstList,1);
          $this->smsmodel->sendLevelSms($positionSecondList,2);
          $this->smsmodel->sendLevelSms($positionThirdList,3);
          $this->smsmodel->sendLevelSms($positionFifthList,5);
          /*  echo "<pre>";
                print_r($positionFirstList);   
            echo "</pre>";
             echo "<pre>";
                print_r($positionSecondList);   
            echo "</pre>";
            echo "<pre>";
                print_r($positionThirdList);   
            echo "</pre>";
             echo "<pre>";
                print_r($positionFifthList);   
            echo "</pre>";*/
            
    }
    
 
  
 function autoSms1(){
     echo date('Y-m-d H:i:s');
 }   

}