<style>
blink{
    animation:blinker 0.6s linear infinite;
    color:#FF0000;
}
@keyframes blinker{
    50%{ opacity:0; }
}

</style>
<div class="row">
    <div class="col-md-6 col-lg-3 col-sm-6">
        <div class="panel panel-default panel-white core-box">
            <div class="panel-body no-padding">
                <div class="partition-green text-center core-icon">
                    <i class="fa fa-inr fa-2x icon-big"></i><br>
                   
					<span class="subtitle">
						
                    </span>
                </div>
                <a href="<?php echo base_url();?>employeeController/deliveryOrderList">
	                <div class="padding-20 core-content">
	                <!--	<h3 class="title block no-margin">Fee Reports</h3>-->
	                <h3 class="title block no-margin"><blink>Delivery order</blink></h3>
	                	<br/>
						<?php $toto =0;
						 $id=$this->session->userdata('id');
        $this->db->where("status",0);
         $this->db->where("del_boy",$id);
           $pin= $this->db->get("assignproduct");
           if($pin->num_rows()>0){
               $toto=$toto+$pin->num_rows();
               
           }
           $this->db->where("order_status",1);
           $this->db->where("detail_delivery",0);
            $this->db->where('del_boy_id',$id);
          $dt1= $this->db->get("order_serial");
          
          if($dt1->num_rows()>0){
               $toto=$toto+$dt1->num_rows();
           }?>
           <span class="subtitle">  <h3><blink ><?php echo $toto; ?></blink></h3>   </span>
                        
	                </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-sm-6">
        <div class="panel panel-default panel-white core-box">
            <div class="panel-body no-padding">
                <div class="partition-azure text-center core-icon">
                    <i class="fa fa-book fa-2x icon-big"></i>
                    	 <span class="subtitle">
					
                </div>
                <a href="#">
                <div class="padding-20 core-content">
                    <!-- <h4 class="title block no-margin">DayBook</h4>-->
                    <h4 class="title block no-margin">Total Delivered Order</h4>
					<br/>								
					<?php $this->db->where('del_boy_id',$this->session->userdata("id"));
						$this->db->where('detail_delivery',1);
						$this->db->where('order_status',1);
						$od_placed= $this->db->get('order_serial')->num_rows();?>
	                	<span class="subtitle"> <?php echo $od_placed; ?>  </span>
                </div>
                </a>
            </div>
        </div>
    </div>
	<?php 	$this->db->where('id',$this->session->userdata("id"));
                    $emppv = 	$this->db->get("emp_pv");
                    	if($emppv->num_rows()>0){
                    	    $pv = $emppv->row()->pv;
                    	    $pvr=$emppv->row()->rupee;
                    	}
                    	else{
                    	    $pv=0;
                    	     $pvr=0;
                    	}
                    ?>
<div class="col-md-6 col-lg-3 col-sm-6">
        <div class="panel panel-default panel-white core-box">
            <div class="panel-body no-padding">
                <div class="partition-pink text-center core-icon">
                    <i class="fa fa-users fa-2x icon-big"></i>
                     <br>
                    	<span class="subtitle">  </span>
                    
                </div>
                <a href="#">
                <div class="padding-20 core-content">
                    <h4 class="title block no-margin">Total PV In Your A/C</h4>
                    <br/>
                    <span class="subtitle"><?php echo $pv; ?> </span>
                </div>
                </a>
            </div>
        </div>
    </div> 
	<div class="col-md-6 col-lg-3 col-sm-6">
        <div class="panel panel-default panel-white core-box">
            <div class="panel-body no-padding">
                <div class="partition-blue text-center core-icon">
                    <i class="fa fa-users fa-2x icon-big"></i>
                   
                    	
                </div>
                <a href="<?php //echo base_url(); ?>index.php/login/newAdmission">
				<div class="padding-20 core-content">
				   
				   <h4 class="title block no-margin"> Total Rupees in Your A/C</h4><br>
				   <div class="row">
					   <div class="col-sm-6">
					   <h6 class="block no-margin"><?php echo  $pvr;?></h6>
						
					   </div>
					   <div class="col-sm-6">
					   <h6 class="block no-margin"></h6>
					   
					 
					   </div>
				   </div>
				  
                </div>
                </a>
            </div>
        </div>
    </div>


  

</div>


  
<!-- end: PAGE CONTENT-->