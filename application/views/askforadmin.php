               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
              
                   
               </script>
 
                   <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Zero config.table start -->
                                            <div class="panel panel-white">
                                               
                                                <div class="panel-body">
                                                     <form action="<?= base_url();?>index.php/stockController/askforadminp" method="post">    
                                                  
                                             
                                          <div class="dt-responsive table-responsive" >
                                			<table class="table table-hover">
                        						<thead>
                        	                        <tr class="text-uppercase">
                        	                           <th>SNO</th>
                        	                            <th class="text-center"><label>P Code</label></th>
                        	                           <th><label> Name</label></th>
                        	                           <th><label> Category</label></th>
                        	                           <th><label>Weight</label></th>
                        	                           <th><label>Price</label></th>
                        	                           <th><label> Qty</label></th>
                                                       <th><label>Pur. Qty</label></th>
                        	                           
                        	                           <!-- <th><label>Total Price</label></th> -->
                        	                           <th><label>Sub Total</label></th>
                        	                        </tr>
                        	                    </thead>
                        	                    <tbody>
                                                        <?php 
                                                         
                                                            $totd = 0; ?> 
                                                            <input type ="hidden" name ="nopa" value="<?php echo $number;?>" /> <?php
                                                             $i = 1; while($i <= $number){ ?>
                                                              <tr>
                                                                  <td width="40"   >
                                                                     <strong><?php echo $i; ?></strong>
                                                                    </td>
                                                                    <td>
                                                                        <input id="itemid<?php echo $i; ?>" type="hidden" name="itemid<?php echo $i; ?>"  style="width:90px;">
                                                                        <input id="item_no<?php echo $i; ?>" name="item_no<?php echo $i; ?>" value=" " style="width:90px;">
                                                                    </td>
                                                                    <td>
                                                                        <input id="item_name<?php echo $i; ?>" name="item_name<?php echo $i; ?>" style="width:150px;">
                                                                    </td>
                                                                    <td>
                                                                        <input readonly id="item_cat<?php echo $i; ?>" class="text-uppercase" name="item_cat<?php echo $i; ?>" style="width:110px;">
                                                                    </td>
                                                                    <td>
                                                                        <input readonly id="item_size<?php echo $i; ?>" class="text-uppercase" name="item_size<?php echo $i; ?>" style="width:70px;">
                                                                    </td>
                                                                    <td>
                                                                        <input  id="item_price<?php echo $i; ?>" value="" class="text-uppercase" name="item_price<?php echo $i; ?>" style="width:70px;">
                                                                    </td>
                                                                    <td>
                                                                        <input readonly id="item_quantity_r<?php echo $i; ?>" class="text-uppercase" name="item_quantity_r<?php echo $i; ?>" style="width:70px;" type="text"/>
                                                                    </td>
                                                                    <td>
                                                                       <button style="border-radius:50%;" type='button' class="btn btn-primary" id="add<?php echo $i;?>" >+</button>
                                                                       <input readonly id="item_quantity<?php echo $i; ?>" class="text-uppercase" value="0" name="item_quantity<?php echo $i; ?>" style="width:70px;" type="text"/>
                                                                       <button style="border-radius:50%;" type='button' class="btn btn-success" id="sub<?php echo $i;?>">-</button>
                                                                    </td>
                                                                    <td>
                                                                        <input  readonly id="sub_total<?php echo $i; ?>" value="<?php echo number_format(0,2,'.', '');?>" class="text-uppercase" name="sub_total<?php echo $i; ?>" style="width:70px;" type="text"/>
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" readonly id="total_price<?php echo $i; ?>" class="text-uppercase"  name="total_price<?php echo $i; ?>" style="width:70px;" type="text"/>
                                                                    </td>
                                                                    <td>
                                                                       <input type="hidden" id="username<?php echo $i; ?>" class="text-uppercase" name="username" style="width:70px;" type="text"/>
                                                                   </td>
                                                                    <td>
                                                                        <input  type="hidden" readonly id="item_catid<?php echo $i; ?>" class="text-uppercase" name="item_catid<?php echo $i; ?>" style="width:70px;">
                                                                    </td>
                                                                  </tr>
                                                                  
                                                                  <script>
                                                                              $('#item_no<?php echo $i; ?>').keyup(function(){
                                                                                var name = $('#item_no<?php echo $i; ?>').val();
                                                                                    if(name.length>0){
                                                                                       // alert(name);
                                                                                $.post("<?php echo site_url("stockController/checkStockProduct") ?>", {name : name}, function(data){
                                                                                var d = $.parseJSON(data);	
                                                                                $('#itemid<?php echo $i; ?>').val(d.itemid);
                                                                                $('#item_name<?php echo $i; ?>').val(d.itemName);
                                                                                $('#item_cat<?php echo $i; ?>').val(d.itemCat);
                                                                                $('#item_catid<?php echo $i; ?>').val(d.itemCatid);
                                                                                $('#item_quantity_r<?php echo $i;?>').val(d.qunatity);
                                                                                $('#item_size<?php echo $i; ?>').val(d.itemsize);
                                                                                $('#item_price<?php echo $i; ?>').val(d.price);
                                                                                });
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        alert("Worng Sec No.");    
                                                                                    }
                                                                                });
                                                                                
                                                    
                                                                               $("#add<?= $i;?>").click(function(){
                                                                                $("#add<?php echo $i;?>").hide();
                                                    						
                                                    						
                                                                                  var t_qty = Number($("#item_quantity_r<?php echo $i;?>").val());
                                                                                  var old_qty = Number($("#item_quantity<?php echo $i;?>").val());
                                                                                  var prc = parseFloat($("#item_price<?php echo $i;?>").val()); 
                                                                                      
                                                                                  var new_qty = old_qty + 1;
                                                                                 
                                                                                  var sub_ttt = new_qty * prc;
                                                                                  var cu_tt = parseFloat($('#total').val()) + prc;
                                                                                  $("#item_quantity<?php echo $i;?>").val(new_qty);
                                                                                  $("#sub_total<?php echo $i;?>").val(sub_ttt.toFixed(2));
                                                                                  $("#total").val(cu_tt.toFixed(2));
                                                                                  
                                                    						
                                                    							
                                                                                
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
                                                                                  $("#sub_total<?php echo $i;?>").val(sub_ttt.toFixed(2));
                                                                                  $("#total").val(cu_tt.toFixed(2));
                                                                                  }
                                                                                  $("#sub<?= $i;?>").delay(2000).show()
                                                                                   
                                                                                // //   alert(sub_ttt);
                                                                               });
                                                                               
                                                                          
                                                                           </script>
                                                                           <?php  $i++; } ?>
                                                                           <tr>
                                                                                	<!-- <td colspan="3"><strong>Previous Balance</strong></td> -->
                                                                                    <td colspan="5"><input type="hidden" readonly id="valid_id" name="p_balance" style="width:180px;" type="text"/></td>
                                                                           </tr>
                                                                          
                                                                           <!-- <tr >
                                                                                
                                                                                 <td >  <label>Direct Sale &nbsp;&nbsp;&nbsp;</label> <input  id="direct" class="text-uppercase" name="delivery" style="width:70px;" type="radio" value="cash" checked/>
                                                                                </td>
                                                                                <td> <label>Cash On Delivery &nbsp;&nbsp;&nbsp;</label>  <input  id="cash" class="text-uppercase" name="delivery"style="width:70px;" type="radio" />
                                                                                </td>
                                                                            </tr> -->
                                                                           <tr id="unm">
                                                                                
                                                                                 <td>  
                                                                                  <input  id="username" class="text-uppercase" name="username" style="width:180px;" type="hidden"/>
                                                                                                     
                                                                            </td>
                                                                               </tr>
                                                                           <tr>
                                                                                	<!-- <td colspan="3"><strong>Balance</strong></td> -->
                                                                                    <td colspan="5"><input type="hidden" id="balance" name="balance" style="width:180px;" type="text" /></td>
                                                                           </tr>
                                                                          </tbody>
                                                                      </table>
                                                                      
                                                                        <div class="row">
                                                                            <div class="col-md-12">

                                                                                                             <div class="col-md-2">
                                                                                                                <label >Total</label>
                                                                                                                <?php echo $i-1;?>
                                                                                                                <input id="total" name="total" value = "<?php echo number_format($totd,2,'.', '') ;?>" class="form-control" style="width:180px;" type="text" required  readonly />
                                                                                                               
                                                                                                           
                                                                                                                 
                                                                                                           <input type="hidden" id="number" name="number" value = "<?php  echo $i-1;?>" class="form-control" style="width:180px;" type="text" required   />
                                                                                                           
                                                                                                            </div>
                                                                                                            
                                                                                                           
                                                                                                            <div class="col-md-2" id="tosubmit">
                                                                                                                 <input type="submit" class ="btn btn-success" value="submit"  id="submt" >
                                                                                                                 </div>
                                                                                                        </div>
                                                                     
                                                                      </div>
                                                                      </form> 
                                             
                                                                </div>
                                                    
                                                       </div>
                                                </div>
                                        </div>
                    </div>        
                    