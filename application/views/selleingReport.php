<div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Zero config.table start -->
                                            <div class="panel panel-white">
                                               
                                                <div class="panel-body">
                                                    <!-- <form action="<?= base_url();?>index.php/stockController/askforadminp" method="post">    -->
                                          <div class="dt-responsive table-responsive" >
                                			<table class="table table-hover">
                        						<thead>
                        	                        <tr class="text-uppercase">
                        	                           <th>SNO</th>
                        	                            <th class="text-center"><label>Shop ID</label></th>
                        	                           <th><label> Product</label></th>
                        	                           <th><label> Product  code</label></th>
                        	                           <th><label>volume </label></th>
                        	                           <th><label>Selling Quantity</label></th>
                        	                           <th><label> Purchase Rate</label></th>
                                                       <th><label>T. pur.Amount</label></th>
                                                        <th><label> Selling Rate</label></th>
                                                       <th><label>T. Sell.Amount</label></th>
                        	                            <th><label>Profit </label></th>
                        	                           <!-- <th><label>Total Price</label></th> -->
                        	                          <th><label>% GST On product(CGST+SGST)</label></th>
                        	                            <th><label>Amount GST On product </label></th>
                        	                             <th><label>Network Distribution </label></th>
                        	                              <th><label>Net Profit </label></th>
                        	                        </tr>
                        	                    </thead>
                        	                    <tbody>
                        	                      <?php $i=1; foreach($subBranch as $sub):
                        	                        $this->db->where("subbranch_id",$sub);
                        	                        $swp = $this->db->get("subbranch_wallet");
                        	                        if($swp->num_rows()>0){
                        	                         foreach($swp->result() as $pcoded):   
                        	                        $this->db->where("id",$sub);
                        	                       $shopDetails= $this->db->get("sub_branch")->row();
                        	                        ?>
                        	                       
                        	                        <tr>
                        	                            <td><?php echo $i;?></td>
                        	                            <td><?php echo $sub;?></td>
                        	                            <td><?php  $this->db->where("id",$pcoded->p_code);
                        	                           $precord =  $this->db->get("stock_products")->row();
                        	                           echo $precord->name;?></td>
                        	                            <td><?php echo $precord->hsn;?></td>
                        	                             <td><?php echo $precord->size;?></td>
                        	                            <td><?php $sumsale = $this->db->query("SELECT sum(product_sale.item_quant) as totsaleoffline from product_sale join invoice_serial on product_sale.bill_no = invoice_serial.invoice_no where invoice_serial.subbranch_id='$sub' and product_sale.p_code='$pcoded->p_code'")->row(); 
                        	                            //echo $sumsale->totsaleoffline;
                        	                           $sumsaleOnline = $this->db->query("SELECT sum(quantity) as totquans FROM  order_detail join order_serial on order_serial.order_no=order_detail.order_no where order_serial.sub_branchid='$sub' and order_detail.p_code='$pcoded->p_code' and order_serial.status=1")->row();
                        	                            //echo "+".$sumsaleOnline->totquans; 
                        	                            $totquanopf=$sumsaleOnline->totquans+$sumsale->totsaleoffline;
                        	                          echo $totquanopf;
                        	                            ?>
                        	                            </td>
                        	                            <td><?php $this->db->where("branch_id",$shopDetails->district);
                        	                                    $this->db->where("p_code",$pcoded->p_code);
                        	                                    $getpurRe=  $this->db->get("branch_wallet");
                        	                                    if($getpurRe->num_rows()>0){ 
                        	                                    $prate =$getpurRe->row()->purchase_price;
                        	                                    $cgst=$getpurRe->row()->cgst;
                        	                                    $sgst=$getpurRe->row()->sgst;
                        	                                    echo  $getpurRe->row()->purchase_price; }else{
                        	                                    $cgst=0;
                        	                                    $sgst=0;
                        	                                    $prate=0;}?>
                        	                           </td>
                        	                            <td><?php echo $sumsale->totsaleoffline*$prate;?></td>
                        	                             <td><?php $sumsaleAmount = $this->db->query("SELECT distinct(pries_per_item)  from product_sale join invoice_serial on product_sale.bill_no = invoice_serial.invoice_no where invoice_serial.subbranch_id='$sub' and product_sale.p_code='$pcoded->p_code'");; 
                        	                             foreach($sumsaleAmount->result() as $samount):
                        	                                 echo $samount->pries_per_item."<br>";
                        	                             endforeach;?></td>
                        	                            <td><?php $sumsaleAmount = $this->db->query("SELECT sum(product_sale.sub_total) as totsaleofflineAmount from product_sale join invoice_serial on product_sale.bill_no = invoice_serial.invoice_no where invoice_serial.subbranch_id='$sub' and product_sale.p_code='$pcoded->p_code'")->row(); 
                        	                           // echo $sumsaleAmount->totsaleofflineAmount;
                        	                             $sumsaleOnlineAmount = $this->db->query("SELECT sum(subtotal) as onlinetotal FROM  order_detail join order_serial on order_serial.order_no=order_detail.order_no where order_serial.sub_branchid='$sub' and order_detail.p_code='$pcoded->p_code' and order_serial.status=1")->row();
                        	                           echo  $sumsaleOnlineAmount->onlinetotal+$sumsaleAmount->totsaleofflineAmount;?>
                        	                            </td>
                        	                            <td><?php $totbanifit= $sumsaleOnlineAmount->onlinetotal+$sumsaleAmount->totsaleofflineAmount - $totquanopf*$prate;echo $totbanifit;?></td>
                        	                            <td><?php echo $totbanifit*$cgst/100;?>+<?php echo $totbanifit*$sgst/100;?></td>
                        	                            <td><?php echo $totbanifit*$sgst/100+$totbanifit*$cgst/100;?></td>
                        	                            <td></td>
                        	                        </tr>
                                                    <?php $i++; endforeach; } endforeach;?>
                                                             
                                                                          </tbody>
                                                                      </table>
                                                                      
                                                                        <div class="row">
                                                                            <div class="col-md-12">

                                                                                                            
                                                                                                           
                                                                                                          
                                                                                                        </div>
                                                                     
                                                                      </div>
                                                                      </form> 
                                             
                                                                </div>
                                                    
                                                       </div>
                                                </div>
                                        </div>
                    </div>        
                    