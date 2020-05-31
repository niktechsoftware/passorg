<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing:border-box;
}
.button_responsive{
  padding:5px;
  float:left;
  width:12%; /* The width is 20%, by default */
}
/* Use a media query to add a break point at 800px: */
@media screen and (max-width:800px) {
  .button_responsive {
    width:100%; /* The width is 100%, when the viewport is 800px or smaller */
  }
}
</style>
<!-- start: MAIN CONTAINER -->
<div class="main-container inner">

<!-- start: PAGE -->
<div class="main-content">
<!-- start: PANEL CONFIGURATION MODAL FORM -->
<div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">Panel Configuration</h4>
            </div>
            <div class="modal-body">
                Here will be a configuration form
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save changes
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- end: SPANEL CONFIGURATION MODAL FORM -->
<div class="container">
<!-- start: PAGE HEADER -->
<!-- start: TOOLBAR -->
<div class="toolbar row">
    
    <div class="col-xs-6 col-sm-4">
        <div class="page-header ">
            <h1><?php echo $pageTitle; ?> <small><?php echo $smallTitle; ?> </small></h1>
        </div>
    </div>
    <div class="col-xs-6 col-sm-8">
        
             <?php if($this->session->userdata("login_type")=="1"){?>
             <center><a class="" style="font-size:10px; color: #f5f5f5;" href="#">Customer Care :<i class="fa fa-phone"></i>+91-&nbsp;6389027901,&nbsp;6389027903,&nbsp;6389027904
                <br>WhatsApp Number&nbsp;: <i class="fab fa-whatsapp"></i>+91-&nbsp;9580121878</a></center>
        <?php } else { ?>
            <center><a class="" style="font-size:10px; color: #f5f5f5;" href="#">Customer Care&nbsp;:&nbsp;<br><i class="fa fa-phone"></i>+91-&nbsp;7394826066,&nbsp;9450536966
                <br> Whatsapp: <i class="fab fa-whatsapp"></i>+91-&nbsp;7394826066</a></center>
        <?php } ?>
      
    </div>
    </div>
    
     <!-- <?php if($this->session->userdata("login_type")=="1"){?>
    <!-- <div class="col-sm-3" style="float:right; margin-top:15px;">
        <div class="page-header">
        <?php 
        $this->db->where("uname",'PASS');
		$sender=$this->db->get("sms_setting")->row(); 
        // $sender = $this->smsmodel->getsmssender($this->session->userdata("school_code"))->row(); ?>
        <a class="button_blink" href="#">Remaining SMS&nbsp;<br><?php //echo checkBalSms($sender->uname,$sender->password);?></a>
        </div>
    </div>-->
    <?php } ?>
    
   
<!-- end: TOOLBAR -->
<!-- end: PAGE HEADER -->
<!-- start: BREADCRUMB -->
<div class="container">
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li>
                <a href="#">
                    <?php echo $mainPage; ?>
                </a>
            </li>
            <li class="active">
                <?php echo $subPage; ?>
            </li>

        </ol>

       
    </div>
</div>
 <br>

<!-- end: BREADCRUMB -->