              
 
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
                        	                            <th class="text-center"><label>Subscriber Name</label></th>
                        	                           <th><label>Subscriber ID</label></th>
                        	                           <th><label> Shop ID </label></th>
                        	                           <th><label>CashBack Amount </label></th>
                        	                           <th><label>Total Amount</label></th>
                        	                           <th><label> Lucky Draw Amount</label></th>
                                                       <th><label>Festival Other Discount</label></th>
                                                        <th><label>total cashback</label></th>
                                                      
                        	                        </tr>
                        	                    </thead>
                        	                    <tbody>
                                                    <?php 
                                                   $i=1; foreach($subBranch as $sub):
                                                       $this->db->where("id",$sub);
                                                      $subBranchD = $this->db->get("sub_branch")->row();
                                                          $result= $this->db->query("select * from customers where sub_branchid ='$sub' and status=1");
                                                          foreach($result->result() as $res):
                                                            $pvdetails=  $this->db->query("select sum(pv) as totpv from pvday_book where paid_to='$res->username'")->row();
                                                        ?><tr>
                                                            <td><?php echo $i;?></td>
                                                            <td><?php echo $res->name;?></td>
                                                            <td><?php echo $res->username;?></td>
                                                            <td><?php echo $subBranchD->username;?></td>
                                                            <td><?php echo $pvdetails->totpv;?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr><?php $i++; endforeach; endforeach;?>
                                                             
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
                    
              