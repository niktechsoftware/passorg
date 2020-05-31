<?php class deliveryBoyController extends CI_Controller{
public function invoice(){
    
      $data['orderno'] =$this->uri->segment(3);
		$data['title'] = "Fee reciept invoice";
		$this->load->view("Employee/generateinvoice",$data);
 }
  public function genrateinvoice(){
          
           $data['orderno'] =$this->uri->segment(3);
          $data['title'] = 'Order Products List';    
          $this->load->view("Shop/generateinvoicedetail", $data);

          }
 }