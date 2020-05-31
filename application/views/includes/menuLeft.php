<!-- start: PAGESLIDE RIGHT -->
<div id="pageslide-right" class="pageslide slide-fixed inner">
    <div class="right-wrapper">
        <div class="notifications">
            <div class="pageslide-title">
          
                You have <?php echo "0";?> notifications
            </div>
            <div>Notices <?php echo "0"; ?></div>
            <?php  //$r = $this->db->query("select * from notice where school_code='$school_code' ")->result();
            //foreach($r as $rcom):
            ?>
            <ul class="pageslide-list">
                <li>
                    <a href="#">
                        <span class="label label-primary"><i class="fa fa-user"></i></span> 
                        <span class="message"> <?php //echo implode(' ',array_slice(explode(' ',$rcom->message),0,7));
                        ?>...</span> 
                        <span class="time"> <?php //echo date("D/M",strtotime($rcom->date));
                        ?></span>
                    </a>
                </li>
               <?php //endforeach;?>
            </ul>
            <div class="view-all">
                <a href="#">
                    See All Notices <i class="fa fa-arrow-circle-o-right"></i>
                </a>
            </div>
            <div>Messages <?php echo $total; ?></div>
             <?php   //$v=$this->session->userdata('username');
             //$r = $this->db->query("select * from message where reciever_id='$v'")->result();
           // foreach($r as $rcom):
            ?>
            <ul class="pageslide-list">
                <li>
                    <a href="#">
                        <span class="label label-primary"><i class="fa fa-user"></i></span> 
                        <span class="message"> <?php //echo implode(' ',array_slice(explode(' ',$rcom->message),0,7));?>...</span> 
                        <span class="time"> <?php //echo date("D/M",strtotime($rcom->send_date))." ".$rcom->send_time;?></span>
                    </a>
                </li>
               <?php //endforeach;?>
            </ul>
            <div class="view-all">
                <a href="#">
                    See All Message <i class="fa fa-arrow-circle-o-right"></i>
                </a>
            </div>
            
            
            
            
            
        </div>
       
    </div>
</div>
<!-- end: PAGESLIDE RIGHT -->