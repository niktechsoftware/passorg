<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <!-- Zero config.table start -->
      <div class="panel panel-white">
        <div class="panel-heading panel-red">
        <center><h2 class="text-bold">Payment Matching </h2></center>
        </div>
          <div class="panel-body">
        <form action="<?php echo base_url()?>shopController/adminpayment" method="post" >
          
                <div class="row" >
                    <div class="col-sm-6">
                        <div class="col-sm-12">
                         <label class ="col-sm-6"><strong>Select Date</strong></label>
                         <div class="col-sm-6">
                         <input type ="date" name ='edate' id = "edate" class="form control"/>
                         </div>
                        </div>
                        </div>
                     <div class="col-sm-6">
                       <div class="col-sm-12">
                            <?php if($this->session->userdata("login_type")==1){
                                $this->db->where("emp_type",5);
                       	       $delivery=$this->db->get('employee');
                       	       if($delivery->num_rows()>0){
                       	             ?>
                       	              <label class ="col-sm-6"><strong>Select Delivery Incharge</strong></label>
                       	                <div class="col-sm-6">
                                        <select id="delivery" class="form-control text-uppercase " style="height:35px;">
                                        <option value=""><span style="color:red">Select Delivery Boy</span></option>      
                                         <?php  foreach($delivery->result() as $row):?>
                                         <option  value="<?php echo $row->id?>"><span style="color:green;"></span><?php echo $row->name;?><span style="color:red;"><?php echo " [ ". $row->username. " ] "; ?></span></option>  
                                        <?php endforeach;}  ?></div>
                                 
                            <?php    }else{
                                    if($this->session->userdata("login_type")==2){
                                        $this->db->where("district",$this->session->userdata("id"));
                                       $this->db->where("emp_type",5);
                       	       $delivery=$this->db->get('employee');
                       	       if($delivery->num_rows()>0){
                       	             ?>
                       	              <label class ="col-sm-6"><strong>Select Delivery Incharge</strong></label>
                                         <div class="col-sm-6"> <select id="delivery" class="form-control text-uppercase " style="height:35px;">
                                        <option value=""><span style="color:red">Select Delivery Boy</span></option>      
                                         <?php  foreach($delivery->result() as $row):?>
                                         <option  value="<?php echo $row->id?>"><span style="color:green;"></span><?php echo $row->name;?><span style="color:red;"><?php echo " [ ". $row->username. " ] "; ?></span></option>  
                                        <?php endforeach;}  ?></div>
                              <?php   }else{
                                    $this->db->where("sub_branchid",$this->session->userdata("id"));
                                       $this->db->where("emp_type",5);
                       	       $delivery=$this->db->get('employee');
                       	       if($delivery->num_rows()>0){
                       	             ?>
                       	              <label class ="col-sm-6" ><strong>Select Delivery Incharge</strong></label>
                                          <div class="col-sm-6"><select id="delivery" class="form-control text-uppercase " style="height:35px;">
                                        <option value=""><span style="color:red">Select Delivery Boy</span></option>      
                                         <?php  foreach($delivery->result() as $row):?>
                                         <option  value="<?php echo $row->id?>"><span style="color:green;"></span><?php echo $row->name;?><span style="color:red;"><?php echo " [ ". $row->username. " ] "; ?></span></option>  
                                        <?php endforeach;}  ?></div>
                               <?php  }
                            }?>
                               
                                       </select>
                        </div>
                       </div>    
                       <!--     <div class="col-md-3" >-->
                         
                       <!--</div>-->
                          
                       </div>
                       
                       </form>
                      
                         <div class="row" style="margin-top:50px;">
                        
                           <!--<div class="col-sm-12">  -->
                           <div class="col-md-10"  id="amountdatashow" style="margin-left:30px;"></div>
                           <!--</div>-->
                          </div>
                          </div>
                        </div>
                        </div>
                        </div>
                        </div>
    
    <script>
     $(document).ready(function(){
        $("#showsubbranch").show();
        
       
    $("#delivery").change(function(){
       var edate=$("#edate").val();
       var delivery=$("#delivery").val();
      // alert(delivery);
       if( delivery!="" ){
          // alert(delivery);
      $.post("<?php echo site_url("shopController/gendelreciept")?>",{delivery:delivery,edate : edate},function(data){
        //  alert(data);
      $('#amountdatashow').html(data);
      });
       }
       else
       {
            $('#amountdatashow').html('<div><h3>please select any one option<h3></div>').css('color','red');
       }
        
     });
     
     });
 
        
    </script>
 
