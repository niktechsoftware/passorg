
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- start: EXPORT DATA TABLE PANEL  -->
			<div class="panel panel-white">
			    <div class="panel-heading panel-red">
					<h4 class="panel-title"> <span class="text-bold">Subscriber Upline/Downline</span></h4>
				</div>
				<div class="panel-body">
				    <div style="text-align:center;" class="alert btn-purple">
				    	<!-- <button data-dismiss="alert" class="close"></button> -->
                        <h4 class="media-heading text-center">Welcome To Upline/Downline Area </h4>
                        <p>In This Section You can see Own Upline and Downline Scubscriber List.<br>
                        </p> 
                    </div>

                    <div class="container">
                        <form action="<?php echo base_url();?>subscriberController/tree" method='Get'>
                        <input type="text" name="find" placeholder="Enter Username">&nbsp; &nbsp;<button class="btn" type="submit" >Find</button>
                        </form>
                        <center>
                            <div class="table-responsive">
                        <table  class=" table " style=" margin-top:20px; color:blue; border:none;">
                            <tbody>
                                <tr>
                                    <td colspan="<?= sizeof($allChildDetails); ?>" style="text-align:center;">
                                   
                                        <?php
                                        if($secondParenDetail != null):
                                            if($secondParenDetail->image){?>
                                            	<img src="<?php echo $this->config->item('asset_url'); ?>/images/subscriber/<?php echo $secondParenDetail->image;?>" class="img-circle" width="50px" height="50px" alt="">
                                            <?php }else{?>
                                                     <img src="<?php echo $this->config->item('asset_url');?>/images/userlogo.png" width="50px" height="50px">  
                                           <?php  }
                                           
                                            echo '<a href="'.base_url().'subscriberController/tree?find='.$secondParenDetail->username.'">';
                                                echo $secondParenDetail->name . '<br/>';
                                                echo $secondParenDetail->username;
                                            echo '</a>';
                                        else:
                                            ?>
                                             <img src="<?= base_url(); ?>assets/tree/userlogo.png" width="50px" height="50px"><br/>
                                            <?php 
                                            echo 'No Name <br/>';
                                            echo 'No Username';
                                        endif;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="<?= sizeof($allChildDetails); ?>" style="text-align:center;" >
                                        <img src="<?= base_url(); ?>assets/tree/arrow2.png" width="35px" height="35px">
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="<?= sizeof($allChildDetails); ?>" style="text-align:center;">
                                  
                                        <?php
                                        if($parenDetail != null):
                                            if($parenDetail->image){?>
                                            	<img src="<?php echo $this->config->item('asset_url'); ?>/images/subscriber/<?php echo $parenDetail->image;?>" class="img-circle" width="50px" height="50px" alt="">
                                            <?php }else{?>
                                                     <img src="<?php echo $this->config->item('asset_url');?>/images/userlogo.png" width="50px" height="50px">  
                                           <?php  }
                                            echo '<a href="'.base_url().'subscriberController/tree?find='.$parenDetail->username.'">';
                                                echo $parenDetail->name . '<br/>';
                                                echo $parenDetail->username;
                                            echo '</a>';
                                        else:
                                               ?>
                                             <img src="<?= base_url(); ?>assets/tree/userlogo.png" width="50px" height="50px"><br/>
                                            <?php 
                                            echo 'No Name <br/>';
                                            echo 'No Username';
                                        endif;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="<?= sizeof($allChildDetails); ?>" style="text-align:center;">
                                        <img src="<?= base_url(); ?>assets/tree/arrow2.png" width="35px" height="35px">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="<?= sizeof($allChildDetails); ?>" style="text-align:center;">
                                        
                                        <?php
                                        
                                        if($customerResult != null):
                                            if($customerResult->image){ ?>
                                            	<img src="<?php echo $this->config->item('asset_url'); ?>/images/subscriber/<?php echo $customerResult->image;?>" class="img-circle" width="50px" height="50px" alt="">
                                            <?php }else{?>
                                              <img src="<?php echo $this->config->item('asset_url');?>/images/userlogo.png" width="50px" height="50px">  
                                            <?php }
                                            echo $customerResult->name . '<br/>';
                                            echo $customerResult->username;
                                            else:
                                                   ?>
                                             <img src="<?= base_url(); ?>assets/tree/userlogo.png" width="50px" height="50px"><br/>
                                            <?php 
                                            echo 'No Name <br/>';
                                            echo 'No Username';
                                        endif;
                                        
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if($allChildDetails !=null):
                                        
                                    $i=1;
                                        foreach($allChildDetails as $child):
                                            
                                            ?>
                                        <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $i ;?> <br>
                                       
                                                        
                                        <br><?php if($child->parentID) { if($child->image){?>
                                        	<img src="<?php echo $this->config->item('asset_url'); ?>/images/subscriber/<?php echo $child->image;?>" class="img-circle" width="50px" height="50px" alt="">
                                        <?php }else{?>
                                         <img src="<?php echo $this->config->item('asset_url');?>/images/userlogo.png" width="50px" height="50px">
                                        <?php }?>
                                        <a href="<?php echo base_url();?>subscriberController/tree?find=<?php echo $child->username; ?>"><?php echo $child->name ;?>  <br/> <?php echo $child->username; ?></a>
                                        <?php } else { ?> 
                                         <img src="<?php echo $this->config->item('asset_url');?>/images/userlogo.png" width="50px" height="50px">
                                        <a href="#"></a> <?php echo $child->name ;?>  <br/> <?php echo $child->username; ?></a><?php } ?></td>
                                            
                                <?php   $i++;  endforeach;
                                    
                                    
                                            endif;  
                                    
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        </center>
                    </div>
				</div>
			</div>
			<!-- end: EXPORT DATA TABLE PANEL -->
		</div>
	</div>
	<!-- end: PAGE CONTENT-->
