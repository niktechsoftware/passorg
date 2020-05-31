<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading panel-blue border-light">
                <h4 class="panel-title">Add Product Area </h4>
            </div>
            <div class="panel-body">

                <div class="col-md-12">
                    <div class="alert alert-info">
                        <button data-dismiss="alert" class="close"></button>
                        <h3 class="media-heading text-center">Welcome To Add And Update Product Area</h3>
                        Here you can add New Product and update product details in this page.

                    </div>
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                    </div>
                    <?php if($this->uri->segment(3)== 'false'){?>
                    <div class="successHandler alert alert-danger">
                        <i class="fa fa-ok"></i> <h4 style="color:red">Please Enter Same Hsn And Sec Number!!!!!</h4>
                    </div>
                    <?php }?>
                </div>
                <form action="<?php echo base_url();?>stockController/addproduct_value" method="post"
                    enctype="multipart/form-data" role="form" id="form">

                    <div class="row" id="rahul">
                        <div class="col-md-12 register-right">
                            Update HSN <span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase" name="phsnu" id="phsnu"
                                    required="" />

                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div id="validId"></div>
                                <div id="validId1"></div>
                                <?php 
                                      
                                 $cat =$this->db->get("category")->result();?>
                            </div>
                              <div class="form-group" id="branch">
                                <label><strong>Select Branch<span style="color:red;"> *</span></strong> </label>
                               <select name="branch" id="branchid" class="form-control" required="required">
                                   <?php if($this->session->userdata("login_type")==1){?>
                                    <option value = "">Select Branch </option>
                                   <?php
                                      $branchData= $this->db->get("branch");
                                      if($branchData->num_rows()>0){
                                         foreach($branchData->result() as $branchRow):
                                          ?>
                                          <option value = "<?php echo $branchRow->id;?>"> <?php echo $branchRow->b_name."[ ".$branchRow->username." ]";?> </option>
                                     <?php endforeach; }
                                   }else{
                                      $branchid = $this->session->userdata("id");
                                      $bname = $this->session->userdata("your_school_name");
                                      $username =$this->session->userdata("username");?>
                                        <option value = "<?php echo $branchid;?>"> <?php echo $bname."[ ".$username." ]";?> </option>
                                 <?php  }
                                   ?>
                               </select>
                            </div>
                            
                            <div class="form-group" id="cate">
                                <label><strong>Product Category <span style="color:red;"> *</span></strong> </label>
                                <select name="category" id="cate1" class="form-control">
                                    <option value="" disabled selected>-Select Category-</option>
                                    <?php foreach($cat as $row):?>
                                    <option value="<?php echo $row->id;?>"><?php echo $row->name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group" id="com">
                                <label><strong>Product Company Name <span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase" name="cname" id="cname"
                                    required="" />

                            </div>
                            <div class="form-group" id="companyname1">
                                <label><strong>Product Company Name <span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase" name="cname1" readonly
                                    id="companyname"  required="" />

                            </div>

                            <div class="form-group" id="categoryname">
                                <label><strong>Product Category Name<span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase" readonly id="categoryname1" />


                            </div>
                            <div class="form-group" id="prnmae">
                                <label><strong>Product Name <span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase" name="name" id="name"
                                    required="" />
                            </div>

                            <div class="form-group" id="pna">
                                <label><strong>Product Name <span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase" name="name1" readonly id="pnname"
                                     required="" />
                            </div>
                           
                            <div class="form-group" >
                                <label><strong>Product Quantity</strong> </label>
                                <input type="text" class="form-control text-uppercase" id="quantity" readonly name="quantity"
                                    id="onupadtequantity"  value="0" required="" />
                            </div>

                            <div class="form-group" id="extraqunatity">
                                <label><strong>Product Extra Qunatity</strong> </label>
                                <input type="text" class="form-control" id="extraqunatity1"
                                     />
                            </div>
                            <div class="form-group" id="file1">
                                <label><strong>Product File 1 <span style="color:red;"> *</span></strong> </label>
                                <input type="file" class="form-control" name="file1" placeholder="Image 1"
                                    required="" />
                            </div>
                            <div class="form-group" id="file2">
                                <label><strong>Product File 2<span style="color:red;"> *</span></strong> </label>
                                <input type="file" class="form-control" name="file2" placeholder="Image 2"
                                    required="" />
                            </div>

                            <div class="form-group" id="billno">
                                <label><strong>Purchase Invoice NO</strong> </label>
                                <input type="text" class="form-control" name="invoice_no" id="invoice_no"
                                   >
                            </div>
                            <div class="form-group" id="cgst1">
                                <label><strong>CGST Amount</strong> </label>
                                <input type="text" class="form-control" name="cgst" id="cgst" >
                            </div>
                            <div class="form-group" id="sgst1">
                                <label><strong>SGST Amount</strong> </label>
                                <input type="text" class="form-control" name="sgst" id="sgst">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                                <label><strong>Product Code(HSN)<span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase" id="hsn" name="p_code"
                                    required="" />
                                   <input type="hidden" class="form-control text-uppercase" id="hsn1" name="" />
                                   <input type="hidden" class="form-control text-uppercase" id="p_idd" name="p_idd" />
                            </div>
                            <div class="form-group" id="sub_category1">
                                <label><strong>Product Sub Category <span style="color:red;"> *</span></strong> </label>
                                <select name="sub_category" id="sub_category" class="form-control text-uppercase">
                                    <option value="" disabled selected></option>

                                </select>
                            </div>
                            <div class="form-group" id="sub_categoryname">
                                <label><strong>Product Sub Category</strong> </label>
                                <input type="text" class="form-control text-uppercase" readonly
                                    id="sub_categoryname1" />
                            </div>

                            <div class="form-group" id="hideee">
                                <label><strong>Product Type</strong> </label>
                                <input type="text" name="scname" id="scname" class="form-control text-uppercase"
                                     />
                            </div>
                            <div class="form-group" id="ptp1">
                                <label><strong>Product Type</strong> </label>
                                <input type="text" name="scname1" id="ptp" readonly class="form-control text-uppercase"
                                     />
                            </div>
                            <div class="form-group" id="size1">
                                <label><strong>Product Size<span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase" name="size" id="size"
                                     required="" />
                            </div>
                           
                           
                              <div class="form-group" id="pricep">
                                <label><strong>Purchase Price<span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase"  name="pprice" id="pprice"
                                     required="" />
                            </div>
                            <div class="form-group" id="prices">
                                <label><strong>Our Price<span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase" name="price" id="price"
                                     required="" />
                            </div>
                            <div class="form-group" id="pricem">
                                <label><strong>MRP Price<span style="color:red;"> *</span></strong> </label>
                                <input type="text" class="form-control text-uppercase" name="mrpprice" id="mrpprice"
                                     required="" />
                            </div>
                        

                            <div class="form-group" id="file4">
                                <label><strong>Offer Image</strong> </label>
                                <input type="file" class="form-control" name="file3" >
                            </div>

                            <div class="form-group" id="Purchase_total">
                                <label><strong>Total Purchase Amount</strong> </label>
                                <input type="text" class="form-control" name="totamount" id="total_amount" readonly
                                     required="" />
                            </div>

                            
                            <!--<div class="form-group">-->
                            <!--  <input type="submit" class="btnRegister"  value="Register"/>-->
                            <!--</div>-->
                            <div class="form-group" style="margin-top:50px;">

                                <button type="submit" class=" form-control btn-primary" id="productadd">Add
                                    Product</button>
                            </div>
                            <div class="form-group">
                                <a href="#" class=" form-control btn-success" id="updatequantity">Update
                                    product & Qunatity</a>
                            </div>
                            <input type="hidden" class="form-control" name="total_amount" id="total_amount1"
                                placeholder="Purchase Total Amount" required="" />

                        </div>

                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>
jQuery(document).ready(function() {


    $("#validId").hide();
    $("#categoryname").hide();
    $("#sub_categoryname").hide();
    $("#extraqunatity").hide();
    $("#updatequantity").hide();
   
    $("#companyname1").hide();
    $("#ptp1").hide();
    $("#pna").hide();
    $("#size21").hide();

    $("#hsn").keyup(function() {
           

        var cat = $("#hsn").val();
        var branchid=$("#branchid").val();
       
        
        $.ajax({	"url": "<?php echo site_url("stockController/checkp_code") ?>",
						"method": 'POST',
						"data": { cat: cat , branchid : branchid},
						beforeSend: function(data) {
							$("#rahul").prop('disabled', true);
							
						},
						success: function(data) {
						     $("#rahul").show()
						    $("#rahul").prop('disabled', false);
						   
						  //alert(d.indicator);
            var d = jQuery.parseJSON(data);
           // alert(data);
          // alert(d.indicator);
            $("#validId").show();
            $("#validId").html(d.msg);
            $("#hsn1").val(d.hsn);
            $("#phsnu").val(d.hsn);
            $("#cname").val(d.cname);
            $("#p_idd").val(d.idd);
            $("#companyname").val(d.cname);
            $("#name").val(d.name);
            $("#pnname").val(d.name);
            $("#quantity").val(d.quantity);
        
            $("#sno").val(d.sno);
            $("#scname").val(d.scname);
            $("#ptp").val(d.scname);
            $("#categoryname1").val(d.cat);
            $("#sub_categoryname1").val(d.subcat);
            $("#size").val(d.size);
            $("#pprice").val(d.pprice);
            $("#price").val(d.price);
             $("#mrpprice").val(d.mrpprice);
            $("#price2").val(d.price);
            if (d.quantity >= -100) {
                $("#extraqunatity").show();
               
            }
            if(d.indicator=='false'){
              
                $("#productadd").show();
               
                $("#updatequantity").hide();
            }else{
          
                $("#productadd").hide();
                $("#updatequantity").show();
            }
             
						},
						error: function(data) {
							$("#rahul").html(data)
						}
					})
        
       

    });

    $("#branchid").change(function(){
         $("#onupadtequantity").hide();
         $("#hsn1").val("");
          $("#hsn").val("");
            $("#cname").val("");
            $("#p_idd").val("");
            $("#companyname").val("");
            $("#name").val("");
            $("#pnname").val("");
            $("#quantity").val("");
  
            $("#sno").val("");
            $("#scname").val("");
            $("#ptp").val("");
            $("#categoryname1").val("");
            $("#sub_categoryname1").val("");
            $("#size").val("");
            $("#price").val("");
             $("#mrpprice").val("");
            $("#price2").val("");
          
                $("#extraqunatity").hide();
           
    });

    $("#invoice_no").keyup(function() {

        var cat = $("#invoice_no").val();
        //	alert(cat);
        $.post("<?php echo site_url("stockController/checkp_billno") ?>", {
            cat: cat
        }, function(data) {
            var d = jQuery.parseJSON(data);
            //alert(data);
            $("#validId1").show();

            $("#validId1").html(d.msg);
            // $("#hsn").val(d.hsn);
            $("#cgst").val(d.cgst);
            $("#sgst").val(d.sgst);
            $("#invoice_no").val(d.bill_no);
            $("#total_amount1").val(d.totalamount);

        });

    });

   

    $("#updatequantity").click(function() {

        var hsn1 = $("#hsn").val();
        var branchid=$("#branchid").val();
        var hsn = $("#hsn1").val();
        var idd2 = $('#p_idd').val();
        var price = $("#price").val();
        var pprice = $("#pprice").val();
         var phsnu = $("#phsnu").val();
        var Qt = Number($("#quantity").val());
        var Qt1 = Number($("#extraqunatity1").val());
        var invoice_no = $('#invoice_no').val();
        var cgst = $('#cgst').val();
        var total_amount = $('#total_amount').val();
        var mrpprice = $('#mrpprice').val();
        var sgst = $('#sgst').val();
        alert(hsn1);
        // alert(hsn + Qt);
      
            if (Qt1 != 0 || price != 0 || hsn != " ") {
            $.post("<?php echo site_url('stockController/updatequantity')?>", {
                hsn: hsn,
                hsn1: hsn1,
                price: price,
                idd2: idd2,
                phsnu : phsnu,
                pprice: pprice,
                Qt: Qt,
                Qt1: Qt1,
                invoice_no: invoice_no,
                cgst: cgst,
                total_amount: total_amount,
                sgst: sgst,
                mrpprice : mrpprice,
                branchid : branchid
                
            }, function(data) {
                 alert(data);
                //$("#updatequantity").html(data);
                //alert("Updated Successfully");
                //window.location.reload();
            });
           
        }
        else
        {
           
            alert("Please Contact Admin");
        }
    });



$("#cate1").change(function() {
    var classv = $("#cate1").val();
    //alert(classv);
    $.post("<?php echo site_url("/stockController/getsubcat") ?>", {
        classv: classv
    }, function(data) {
        $("#sub_category").html(data);
        //alert("data");
    });

});

 $("#extraqunatity1").keyup(function() {

        var exquantity = Number($("#extraqunatity1").val());
        var price = Number($("#pprice").val());
        //	alert(cat);
        var totprice = exquantity*price;
            $("#total_amount").val(totprice);
            $("#total_amount1").val(totprice);

      

    });
    $("#pprice").keyup(function() {

        var exquantity = Number($("#extraqunatity1").val());
        var price = Number($("#pprice").val());
        //	alert(cat);
        var totprice = exquantity*price;
            $("#total_amount").val(totprice);
            $("#total_amount1").val(totprice);

       

    });

 });
</script>