
                             <div class="container">
                             <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Zero config.table start -->
                                            <div class="panel panel-white">
                                                <div class="panel-heading panel-red" style="text-align:center;color:#01a9ac;">
                                                </div>
                                                
                                                <div class="panel-body">
                                                  <div class="row col-md-12">
                                                  <div class = "col-md-6"  id="num" >
                                                      <label> Enter Number Of Item</label>
                                                      <input type="number" class="form-control" id="rows"   vale=""> 
                                                  </div>
                                                  </div>
                                                  <div class="col-md-12">
                                                   <div class="row" id="directrows">
                
                                                     </div>
                                              </div>
                             
                              <script>
                                  $(document).ready(function(data){
                                  $('#rows').keyup(function(data){
                                     var numrow= $('#rows').val();
                                     
                                       $.ajax({
                                             
                                               "url": "<?= site_url();?>index.php/stockController/askforview",
                                                "method": 'POST',
                                                "data": {numrow : numrow},
                                                beforeSend: function(data) {
                                                   $("#directrows").html("<center><img src='<?php echo base_url(); ?>assets/loading.gif' /></center>")
                                                },
                                                success: function(data) {
                                                    $("#directrows").html(data);
                                                },
                                                error: function(data) {
                                                    $("#directrows").html(data)
                                                }
                                            })
                                     
                                  
                                  
                                  });
                                  });
                              </script>
                              
                              
               
                              
             </div>
         </div>
                     </div>
          </div>
          </div>