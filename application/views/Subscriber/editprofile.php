<?php //print_r($sub_data);
// exit;
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-heading panel-blue border-light">
				<h4 class="panel-title">Subscriber Full Profile</h4>
			</div>
			<div class="panel-body">
			
			 <!--   <div class="col-md-12">-->
			 <!--       <div class="alert alert-info">-->
		  <!--              <button data-dismiss="alert" class="close"></button>-->
		  <!--              <h3 class="media-heading text-center" style="text-align:center">Welcome to Profile View Area</h3>-->
		  <!--              <p style="text-align:center;margin-top:20px;margin-bottom:20px;"></p>-->
    <!--    		    </div>-->

				<!--	<div class="errorHandler alert alert-danger no-display">-->
				<!--		<i class="fa fa-times-sign"></i> You have some form errors. Please check below.-->
				<!--	</div>-->
					
				<!--</div>-->
                <?php if($sub_data->num_rows()>0){
                    $data=$sub_data->row();
                
                ?>
                <div class="row space15">     
                 <div class="col-md-12">
                            <div class="col-md-6">
                            Image
                            </div>
                            <div class="col-md-6">
                            <?php if(strlen($data->image)>0){?> <img class="zoom1" width=50px; height=50px; src="<?php echo $this->config->item('asset_url');?>/images/subscriber/<?php echo $data->image;?>"> <?php } else { ?><img class="zoom1" width=50px; height=50px; src="<?php echo $this->config->item('asset_url');?>/images/userlogo.png"> <?php } ?>
                            
                            </div>
                        </div>
                    </div>
	        	<form action="<?php echo base_url();?>index.php/subscriberController/update_profile"  method ="post" role="form" id="form">
	        	    
                
                    <div class="row space15">
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Name
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="name" class="form-control" value="<?php echo $data->name;?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    Father Name 
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="father_name" class="form-control" value="<?php echo $data->father_name;?>">
                            
                            </div>
                        </div> 
                    </div>    
                   <div class="row space15">     
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Mobile Number
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="mobile" class="form-control" value="<?php echo $data->mobile;?>">
                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    Email Id
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="email" class="form-control" value="<?php echo $data->email;?>">
                            
                            </div>
                        </div>
                    </div>    
                   <div class="row space15">     
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Address 
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="address" class="form-control" value="<?php echo $data->address;?>"/>
                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    Pin Code 
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="pin" class="form-control" value="<?php echo $data->pin;?>"/>
                            
                            </div>
                        </div>
                    </div>    
                     <div class="row space15">     
                        <div class="col-md-6">
                            <div class="col-md-6">
                               District 
                            </div>
                            <?php $this->db->where("id",$data->district);
                           $getbranch =  $this->db->get("branch")->row();?>
                            <div class="col-md-6">
                                 <input type="hidden" name="district" value="<?php echo $data->district;?>" >
                            <input type="text" name="district1" class="form-control" value="<?php echo $getbranch->district;?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    State 
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="state" class="form-control" value="<?php echo $data->state;?>"/>
                            
                            </div>
                        </div>
                    </div>    
                     <div class="row space15">     
                        <div class="col-md-6">
                            <div class="col-md-6">
                               Aadhar Number
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="adhar" class="form-control" value="<?php echo $data->adhar;?>"/>
                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    Pan Number
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="pan" class="form-control" value="<?php echo $data->pan;?>"/>
                            
                            </div>
                        </div>
                    </div>    
                     <div class="row space15">     
                        <div class="col-md-6">
                            <div class="col-md-6">
                              <label> Gender</label>
                            </div>
                            <div class="col-md-6">
                                <select name ="gender" class="form-control">
                                   
                                <option value = "1" <?php if($data->gender==1){echo 'selected="selected"';}?>>Male</option>
                                 <option value = "2" <?php if($data->gender==2){echo 'selected="selected"';}?>>Female</option>
                                  <option value = "3" <?php if($data->gender==3){echo 'selected="selected"';}?>>Other</option>
                                </select>
                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Registration Fee
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="amount" class="form-control" value="<?php echo $data->amount;?>"/>
                                
                            </div>
                        </div>
                    </div>    
                     <div class="row space15">     
                        <div class="col-md-6">
                            <div class="col-md-6">
                               1 Nominee Name
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="nom1" class="form-control" value="<?php echo $data->nom1;?>"/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                1 Nominee Aadhar No.
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="nom_ad1" class="form-control" value=" <?php echo $data->nom_ad1;?>"/>
                               
                            </div>
                        </div>
                   </div>    
                     <div class="row space15">     
                        <div class="col-md-6">
                            <div class="col-md-6">
                               1 Nominee Relation
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="nom_rel1" class="form-control" value="<?php echo $data->nom_rel1;?>"/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    2 Nominee Name
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="nom2" class="form-control" value="<?php echo $data->nom2;?>"/>
                                
                            </div>
                        </div>
                    </div>    
                    <div class="row space15">     
                        <div class="col-md-6">
                            <div class="col-md-6">
                               2 Nominee Aadhar No.
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="nom_ad2" class="form-control" value="<?php echo $data->nom_ad2;?>"/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                2 Nominee Relation
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="nom_rel2" class="form-control" value="<?php echo $data->nom_rel2;?>"/>
                                
                            </div>
                        </div>
                     </div>  
                     <div class="row space15">     
                        <div class="col-md-6">
                            <div class="col-md-6">
                               UserName
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="username" class="form-control" value="<?php echo $data->username;?>" readonly/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Password
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="password" class="form-control" value="<?php echo $data->password;?>"/>
                                
                            </div>
                        </div>
                    </div>
                       
                      <div class="row space15"> 
					 <div class="col-md-6 ">
                 
                    		 <div class="col-md-6">
                   				 Branch Name<span class="symbol required"></span>
                    		</div>
                			<div class="col-md-6">
                    			<?php 
                    			$id =$this->session->userdata('id');
                    		$this->db->where("id",$id);
                    		$empd= $this->db->get("customers")->row();
                    			  
                    			   $this->db->where("id",$empd->district);
                    			   $subbranch = $this->db->get("branch")->row();;
                    			  $branchlist= $this->db->get("branch");
                    			     ?>
                                        <select class="form-control" name="branch" id="branch" required="required">
                                            <option value="">-Select Branch Name-</option>
                                           <?php foreach($branchlist->result() as $bl):?>
                                            <option value="<?php echo $bl->id;?>" <?php if($bl->id==$subbranch->id){echo "selected ='selected'";}?> ><?php echo $bl->b_name; ?></option>
                                           <?php endforeach;?>
                                        </select>
                       
                    		</div>
               			
                    
                   		              
               		</div>	 
            	
                         <div class="col-md-6">
                            <div class="col-md-6">
                   				Sub Branch Name
                    		</div>
                    		<?php 	
                    		$id =$this->session->userdata('id');
                    		$this->db->where("id",$id);
                    		$empd= $this->db->get("customers")->row();
                    		$this->db->where("id",$empd->sub_branchid);
                    		$sbdetails=$this->db->get("sub_branch")->row();
                    		?>
                    		<div class="col-md-6">
                    			<select class="form-control" id="subbranch" name="subbranch" required="required">
                    			       <option value="<?php echo $sbdetails->id;?>"><?php echo $sbdetails->bname; ?></option>
                                </select>
                    		</div>
                    	
                		
                    	
               			</div> 
                        </div>
                       <script>
                            
                             $('#branch').change(function(){
                                  var branch= $('#branch').val();
                                  //alert(branch);
                                  $.post("<?php echo site_url("employeeController/subBranch") ?>", {
                                    branch: branch
                                        }, function(data) {
                                          $("#subbranch").html(data);
                                         // alert("data");
                                        });
                              });
                        </script>
                       <div class="row space15">     
                           <div class="col-md-6">
                            <div class="col-md-6">
                                Joiner Id
                            </div>
                            <?php $this->db->where("id",$data->parentID);
                            $cusd = $this->db->get("customers");?>
                            <div class="col-md-6">
                                <?php if($cusd->num_rows()>0){?>
                            <input type="text" name="parentID" class="form-control" value="<?php echo $cusd->row()->username."[".$cusd->row()->name."]";?>" readonly/>
                           <?php }else{?>
                           <input type="text" name="parentID" class="form-control" value="" readonly/>
                           <?php }?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                            Bank Name
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="bank_name" class="form-control" value="<?php echo $data->bank_name;?>"/>
                                
                            </div>
                        </div>
                    </div>    
                     <div class="row space15">     
                        <div class="col-md-6">
                            <div class="col-md-6">
                            Account Number
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="account_no" class="form-control" value="<?php echo $data->account_no;?>"/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                IFSC Code
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="ifsc" class="form-control" value="<?php echo $data->ifsc;?>"/>
                            
                            </div>
                        </div>
                    </div>
                <?php } ?>
                  
                <div class="col-md-12">
                            <div class="col-md-6">
                               
                            </div>
                            <div class="col-md-6">
                          <input class="btn btn-primary" type="submit" class="form-control" name="update" value="Submit"/>
                            
                            </div>
                        </div>
                 </div>
                  </div>
            </div>
        </div>
    </div>
</div>