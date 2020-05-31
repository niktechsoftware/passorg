<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <!-- Zero config.table start -->
     

      <div class="panel panel-white">
        <div class="panel-heading panel-red">
        <center><a href="<?php echo base_url();?>welcome/product_list"><h2 class="text-bold">Demand List of Branch <?php echo $branchname;?></h2></a></center>
        </div>
        <div class="panel-body">
             <div class="row">
                        <div class="col-md-12 space20">
                            <div class="btn-group pull-right">
                                <button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
                                    Export <i class="fa fa-angle-down"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-light pull-right">
                                    <li>
                                        <a href="#" class="export-pdf" data-table="#sample-table-2">
                                            Save as PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-png" data-table="#sample-table-2">
                                            Save as PNG
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-csv" data-table="#sample-table-2">
                                            Save as CSV
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-txt" data-table="#sample-table-2">
                                            Save as TXT
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-xml" data-table="#sample-table-2">
                                            Save as XML
                                        </a>
                                    </li>
                                 <li>
                                        <a href="#" class="export-excel" data-table="#sample-table-2">
                                            Export to Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-doc" data-table="#sample-table-2">
                                            Export to Word
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-powerpoint" data-table="#sample-table-2">
                                            Export to PowerPoint
                                        </a>
                                    </li>

                            </div>
                        </div>
                    </div>
                     <div class="col-md-12 row"> 
                     <?php   if( $typepage ==2){?>
                     <div class="alert alert-danger">Not Available Product List</div>
                     <?php }else{?>
                      <div class="alert alert-info">Available Product List</div>
                     <?php }?>
                    <div class="col-md-6"><a href ="<?php echo base_url(); ?>index.php/adminController/branchdemandtransfer/<?php echo $branchid;?>/1" class ="btn btn-success">
                                     View   Available Products  <i class="icon-arrow"></i>
                                        </a>  
                                    </div>    
                <div class="col-md-6">       <a href ="<?php echo base_url(); ?>index.php/adminController/branchdemandtransfer/<?php echo $branchid;?>/2" class ="btn btn-danger">
                                        View Not Available Products  <i class="icon-arrow"></i>
                                        </a>
                                </div>
                </div> 
                  <?php $this->db->where("id",$branchid);
               $sbd =  $this->db->get("branch")->row();
               ?>
               <input type="hidden" id = "reciever" value = "<?php echo $sbd->username;?>" />
           <div class="dt-responsive table-responsive">
            <table id="sample-table-2" class="table table-striped table-bordered nowrap">
              <thead>
                <tr  style="background-color:#1ba593; color:white;">
                    
                    <th>S.No.</th>
                    <th>Com. Name</th>
                    <th>P.Name</th>
                    <th>P. Code</th>
                    <th>Volume</th>
                    <th>Price</th>
                    <th>T.Of Pro</th>
                    <th>Image</th>
                    <?php if( $typepage ==2){?>
                      <th>No.subscriber</th>
                     <?php }?>
                    <th>Admin qua.</th>
                    
                    <th>RQ</th>
                    <?php if( $typepage ==1){?>
                    <th>Quantity</th>
                    <th>Tot. Amount</th>
                      <th>Action</th>
                    <?php }?>
                  </tr>
                    </tr>
              </thead>
              <tbody>
             
                    <?php 
                     $tota=0;
                    $discrictd= $branchid;
                    $this->db->distinct();
                    $this->db->select("id");
                    $this->db->where("district",$discrictd);
                    $getbranch = $this->db->get("sub_branch");
                   
                    if($getbranch->num_rows()>0){
                    $getcode = $getbranch->result();
                    $i=1;
               
                foreach($getcode as $row):
                    $datasub[$i] = $row->id;
                    $i++; endforeach;
                  
                    $this->db->distinct();
                    $this->db->select("product_code");
                    $this->db->where_in("sub_branchid",$datasub);
                    $stckdt= $this->db->get("favourite_list");
                 
                    $this->db->where("branch_id",$discrictd);
                    $stckdtbr= $this->db->get("branch_wallet")->result();
                
                 
                    $i=1; foreach($stckdt->result() as $data):
                    $this->db->where("branch_id",$discrictd);      
                    $this->db->where("p_code",$data->product_code);
                    $dt= $this->db->get("branch_wallet");
                
                        $this->db->where("invoice_number !=","");
                        $this->db->where("p_code",$data->product_code);
                        $this->db->where("status",0);
                        $this->db->where("reciver_usernm",$sbd->username);
                        $this->db->where("sender_usernm",$this->session->userdata('username'));
                        $oldcheckorg = $this->db->get("product_trans_detail");
                    if($oldcheckorg->num_rows()<1){
                     if($dt->num_rows()>0){
                        $receive=  $dt->row()->rec_quantity;
                        $saleq = $dt->row()->sale_quantity;
                    }else{
                        $receive=0;
                        $saleq=0;
                    }
                     $total=$receive;
                     if((($receive-$saleq)<2)){
                            $this->db->where("id",$data->product_code);
                            $stckdt1= $this->db->get("stock_products");
                        
                        if($stckdt1->num_rows()>0){
                          // print_r( $stckdt1->row());
                            $totalquantity= $stckdt1->row()->quantity;
                            $totalquantity1= $receive;
                            
                        if( $typepage ==2){
                        if((($totalquantity) < 7)){
                        //  print_r($stckdt1->row());
                            $remainingquantity=$totalquantity- $total;
                            $stckdt2=$stckdt1->row();
                        ?>
                        <tr>
                            <td>    <?php echo $i;?>    </td>
                            <td>    <a href="#"><span ><?php echo $stckdt2->company;?></span></a>   </td>
                            <td>    <?php if($totalquantity<=$total){?><span style="color:red;"><?php echo $stckdt2->name;?></span>
                         
                            <?php } else{ echo $stckdt2->name;}?>
                            </td>
                            <td><?php echo $stckdt2->hsn;?></td>
                            <td><?php echo $stckdt2->size;?></td>
                            <td><?php echo $stckdt2->selling_price;?></td>
                            <td><?php echo $stckdt2->p_type;?></td>
                            <td><?php if($stckdt2->file1>0){ ?><img src="<?php echo $this->config->item('asset_url'). '/productimg/' .$stckdt2->file1; ?>"
                                            style="height:50px;width:100px;"><?php } else{ ?> <img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stckdt2->file2; ?>"
                                                        style="height:50px;width:100px;"><?php } ?>
                            </td>
                             
                            <?php 
                                $this->db->where_in("sub_branchid",$datasub);
                                    $this->db->where('product_code',$data->product_code);
                                    $row1=$this->db->get('favourite_list');
                               ?>
                            <td style="margin-left:50px;">
                                    <?php $j=1; foreach($row1->result() as $cusname): 
                                    $this->db->where('id',$cusname->customer_id);
                                    $row2=$this->db->get('customers')->row();
                                    echo $j."- " .  $row2->name. " [ " . $row2->username . " ]<br> ";
                                    $j++; endforeach;?>
                            </td>
                            <td>
                                <input readonly id="item_quantity_r<?php echo $i; ?>" class="text-uppercase" name="item_quantity_r<?php echo $i; ?>" value = "<?php echo $totalquantity;?>" style="width:70px;" type="text"/>
                            </td>
                            <td><span style="color:red;font-size:20px;font-weight:1px;"><?php echo  -$row1->num_rows();?></span>
                            </td>
                  
                          
                        </tr>
                        <?php $i++;  }
                            
                            
                        } else{
                           
                             $this->db->where("invoice_number","");
                            	     $this->db->where("p_code",$data->product_code);
                            	     $this->db->where("status",0);
                            	     $this->db->where("reciver_usernm",$sbd->username);
                            	    $this->db->where("sender_usernm",$this->session->userdata('username'));
                            	    $oldcheck = $this->db->get("product_trans_detail");
                                if((($totalquantity)>=7)  || ($oldcheck->num_rows()>0)){
                        //  print_r($stckdt1->row());
                            $remainingquantity=$totalquantity- $total;
                            $stckdt2=$stckdt1->row();
                        ?>
                        <tr>
                            <td>    <?php echo $i;?>    </td>
                            <td>    <a href="#"><span ><?php echo $stckdt2->company;?></span></a>   </td>
                            <td>    <?php if($totalquantity<=$total){?><span style="color:red;"><?php echo $stckdt2->name;?></span>
                         
                            <?php } else{ echo $stckdt2->name;}?>
                            </td>
                            <td><input type="hidden" id="p_code<?php echo $i;?>"  value ="<?php echo $stckdt2->id;?>" /><?php echo $stckdt2->hsn;?></td>
                            <td><?php echo $stckdt2->size;?></td>
                            <td> <input readonly id="item_price<?php echo $i; ?>"  class="text-uppercase" name="item_price<?php echo $i; ?>" value ="<?php echo $stckdt2->selling_price;?>" style="width:70px;"></td>
                            <td><?php echo $stckdt2->p_type;?></td>
                            <td><?php if($stckdt2->file1>0){ ?><img src="<?php echo $this->config->item('asset_url'). '/productimg/' .$stckdt2->file1; ?>"
                                            style="height:50px;width:100px;"><?php } else{ ?> <img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stckdt2->file2; ?>"
                                                        style="height:50px;width:100px;"><?php } ?>
                            </td>
                             
                             <?php 
                                    $this->db->where_in("sub_branchid",$datasub);
                                    $this->db->where('product_code',$data->product_code);
                                    $row1=$this->db->get('favourite_list');
                                ?>
                             <td>
                                     <input readonly id="item_quantity_r<?php echo $i; ?>" class="text-uppercase" name="item_quantity_r<?php echo $i; ?>" value = "<?php echo $totalquantity;?>" style="width:45px;" type="text"/>
                            </td>
                            
                            <td><span style="color:red;font-size:20px;font-weight:1px;"><?php echo  $row1->num_rows();?></span>
                            </td>
                           <td>
                               <?php if($oldcheck->num_rows()>0){ $acquan=$oldcheck->row()->quantity;?>
                                <input readonly id="item_quantity<?php echo $i; ?>" class="text-uppercase"  name="item_quantity<?php echo $i; ?>" value = "<?php echo $acquan;?>" style="width:70px;" type="text"/>
                               <?php }else { $acquan= $row1->num_rows();?>
                               <button style="border-radius:50%;" type='button' class="btn btn-primary" id="add<?php echo $i;?>" >+</button>
                                <input readonly id="item_quantity<?php echo $i; ?>" class="text-uppercase"  name="item_quantity<?php echo $i; ?>" value = "<?php echo $row1->num_rows();;?>" style="width:70px;" type="text"/>
                                <button style="border-radius:50%;" type='button' class="btn btn-success" id="sub<?php echo $i;?>">-</button>
                          <?php }?>
                          </td>
                           <td><?php ?>
                                <input type="text" readonly id="total_price<?php echo $i; ?>" class="text-uppercase"  name="total_price<?php echo $i; ?>" value ="<?php if($oldcheck->num_rows()>0){echo number_format($oldcheck->row()->quantity*$stckdt2->selling_price, 2,'.', '');;}else{echo number_format($row1->num_rows()*$stckdt2->selling_price, 2,'.', '');}?>" style="width:70px;" type="text"/>
                          </td>
                               <td><?php if($oldcheck->num_rows()>0){?><button class ='btn btn-blue' >Confirmed</button><?php $tota=$tota+$acquan*$stckdt2->selling_price; } else {?><button class ='btn btn-success' id="send<?php echo $i;?>">Send</button><?php }?></td>
                               <script>
                                      $("#send<?php echo $i;?>").click(function(){
                                            var p_code = $("#p_code<?php echo $i;?>").val();
                                            var reciever = $("#reciever").val();
                                            var quantity = Number($("#item_quantity<?php echo $i; ?>").val());
                                            var prc = parseFloat($("#item_price<?php echo $i;?>").val()); 
                                            var totalp  =   parseFloat($("#total").val());
                                            alert(p_code+ reciever+quantity);
                                            $.post("<?php echo site_url("stockController/sendStockbyadmin") ?>", {p_code : p_code , reciever: reciever, quantity : quantity}, function(data){
                                           
                                            if(data==1){
                                               var  cu_tt=totalp+(quantity*prc);
                                                 $("#total").val(cu_tt);
                                                  $('#send<?php echo $i;?>').html("Confirmed");
                                            }else{
                                                $('#send<?php echo $i;?>').html(data);
                                            }
                                            
                                        });
                                      });
                                    $("#add<?= $i;?>").click(function(){
                                        $("#add<?php echo $i;?>").hide();
                                          var t_qty = Number($("#item_quantity_r<?php echo $i;?>").val());
                                          var old_qty = Number($("#item_quantity<?php echo $i;?>").val());
                                          var prc = parseFloat($("#item_price<?php echo $i;?>").val()); 
                                          if((t_qty>1) && ((old_qty+1) < t_qty)) {
                                              
                                          var new_qty = old_qty + 1;
                                         
                                          var sub_ttt = new_qty * prc;
                                          var cu_tt = parseFloat($('#total').val()) + prc;
                                          $("#item_quantity<?php echo $i;?>").val(new_qty);
                                          $("#total_price<?php echo $i;?>").val(sub_ttt.toFixed(2));
                                         
                                          
            						
            							
                                          }else{
                                              alert("Check Your Stock||||");
                                          }
                                           $("#add<?php echo $i;?>").delay(2000).show();
                                        // //   alert(sub_ttt);
                                       });
                                     
                                     
                                     
                                       $("#sub<?= $i;?>").click(function(){
                                           $("#sub<?= $i;?>").hide();
                                          var t_qty = Number($("#item_quantity_r<?php echo $i;?>").val());
                                          var old_qty = Number($("#item_quantity<?php echo $i;?>").val());
                                          var prc = parseFloat($("#item_price<?php echo $i;?>").val()); 
                                          if(old_qty>0){
                                          var new_qty = old_qty - 1;
                                          var sub_ttt = new_qty * prc;
                                          var cu_tt = parseFloat($('#total').val()) - prc;
                                          $("#item_quantity<?php echo $i;?>").val(new_qty);
                                           $("#total_price<?php echo $i;?>").val(sub_ttt.toFixed(2));
                                         
                                          }
                                         
                                              $("#sub<?= $i;?>").delay(2000).show();
                                        // //   alert(sub_ttt);
                                       });
                                       
                                   
                               </script>
                        </tr>
                        <?php $i++;  }
                            }//
                        } 
                   
                         }}
                   
                    endforeach; } ?>
                
              </tbody>
              
            </table>
          </div><?php  if($typepage ==1){?>
         <form method="post" action="<?php echo base_url()?>index.php/stockController/generate_invoice">
              <div class="col-md-12 row">
                  <div class="col-md-4 ">  <input id="total" name="total" value = "<?php echo number_format($tota,2,'.', '');?>" class="form-control" style="width:180px;" type="text" required  readonly /> </div>
                   <div class="col-md-4 "> <button class = "btn btn-purple" id="confirmAll">Confirm To all</button>  </div>
                    <div class="col-md-4">
                           <label >Assign DI</label>
                            <?php if($this->session->userdata("login_type")==1){
                                                               
                        $aa= array('district'=>0,
                                'sub_branchid'=>0,
                                    'emp_type'=>'5',
                                    'status'=>'1');
                         
                          $this->db->where($aa);
                          $deliveryboy=$this->db->get('employee');
                                                                }else{if($this->session->userdata("login_type")==2){
                                                                     $id= $this->session->userdata("id");
                        $aa= array('district'=>$id,
                                    'emp_type'=>'5',
                                    'sub_branchid'=>0,
                                    'status'=>'1');
                         
                          $this->db->where($aa);
                          $deliveryboy=$this->db->get('employee');
                                                                }else{
                                                                $id= $this->session->userdata("id");
                        $aa= array('sub_branchid'=>$id,
                                    'emp_type'=>'5',
                                    'status'=>'1');
                         
                          $this->db->where($aa);
                          $deliveryboy=$this->db->get('employee');
                                                                }}?>
                                                              
                           <select class="form-control text-uppercase"  name = "selectdelivery" id="selectdelivery" style="width:150px;"  required="required">
                                <option value="">-Assign to-</option>
                                <?php if($deliveryboy->num_rows()>0) {
                                   foreach($deliveryboy->result() as $row1)  {  
                                   ?> 
                                    <option class="text-uppercase" style="color:#01a9ac" value="<?php echo $row1->id;?>"><?php echo  $row1->name." [ ". $row1->username. " ] ";?></option>     
                                        
                                  <?php }  }?>
                                 </select>
                                </div>
                
                </div>       
          
           
                <div class="col-md-12 row">
            
                                             <div class="col-md-4"> 
                                                <label >Enter Lock No.</label>
                                                     <input type="text" name="lock" id ="lockno" placeholder = "Lock"  style="width:180px;" class= "form-control" required="required" />
                                                     <input type="text" name="pass" id ="locknop"  style="width:180px;" class="form-control" required="required"  required="required" readonly/>
                                                </div>
                                                 <script>
                                                         $('#lockno').keyup(function(){
                                                            var lockno = $('#lockno').val();
                                                            $.post("<?php echo site_url("stockController/checklocp") ?>", {lockno : lockno}, function(data){
                                                            $('#locknop').val(data);
                                                            });
                                                            });
                                                 </script>
                                                 
                                                 <div class="col-md-4">
                                                     <br>
                                                   
                                                     <input type="hidden" name = "reciever" value = "<?php echo $sbd->username;?>" />
                                                            <button class="btn btn-success" target="_blank">Generate Invoice</button>
                                                     </div>
                                             </div> 
                                             </form>
           <?php }?>
        </div>
       </div>
      
     
    </div>
  </div>
</div>