<?php
function oneTimePowerLeg()
{
?>
<script type="text/javascript">
$(document).ready(function () {


   
			
			$('#buttonAdd').on('click', function () {
                $('#theForm2').jqxValidator('validate');
            });
					
			
            // initialize validator.
            $('#theForm2').jqxValidator({
                rules: [
						// { input: '#change_date2', message: 'Required', action: 'keyup, blur', rule: 'required' }
						 			   
					   ]
            });
						
			//validate success & submit				
			$('#theForm2').bind('validationSuccess', function (event) { 
					
			var action = $("#theForm2").attr('action');
			$("#buttonAdd").jqxButton({ disabled: true, theme: 'shinyblack' });
							
			var form_data = {
				
				//tmb_sw: $('input:radio[name=tmb_sw]:checked').val(),
				is_ajax: 1
			};
				
				$.ajax({
					type: "POST",
					url: action,
					data: form_data,
					dataType: "json",
					
					success: function(response) {
					
						var id = response["id"];
						var success = response["success"];
						var displayMsg = response["displayMsg"];
		
			
						if (success == 1) {
						
							
							window.location.href = "index.php?view=list&displayMsg="+displayMsg;
		
						} else {
		
							$("#buttonAdd").jqxButton({ disabled: false});
							document.getElementById("errMsg").innerHTML=displayMsg;
							document.getElementById("errMsg").innerHTML='<div class="alert alert-danger fade in" >' + displayMsg + '</div>';
							document.getElementById("displayMsg").innerHTML="";
							
							setTimeout(function() {
								$("#displayMsg").fadeOut().empty();
							}, 100);
							
						}
					}
				});
			
			}); 
			//end of validate sucess and submit	
            
});        
</script>    	
				<!--=== Page Content ===-->
				<!--=== Full Size Inputs ===-->
				<form class="form-horizontal row-border" action="" method="post" name="theForm2" id="theForm2">
             	 <div class="box box-info">
                   <div class="box-body">                                   
                     <div class="col-md-12">  

                        <div class="box-header with-border">
                          <h3 class="box-title">one time power leg</h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="Run" id="buttonAdd" class="btn btn-primary" onClick="document.theForm2.action='info_inc.php?action=oneTimePowerLeg'"/>
	                  <?php } ?>
										</div>
                         </div>               

									<div class="form-group">
                                                            

									</div>								
										
							

				
					</div>		
					</div>
				</div>
				</form>
				<!-- /Page Content -->

<?php	
}
function stockistUpgradeForm()
{
	
	if(!checkUserStatusError())
	{

		if(walletBalance('acct_rwallet', $_SESSION['user_id']) >= checkMinStockistPkgPrice() or $_SESSION['user_grp']==1)
		{	
?>
<script type="text/javascript">
$(document).ready(function () {


            //$('#change_date').datepicker({ dateFormat: 'dd-mm-yy' }); 
			
			$('#buttonStockistUpgrade').on('click', function () {
                $('#theStockistUpgradeForm').jqxValidator('validate');
            });
					
			
            // initialize validator.
            $('#theStockistUpgradeForm').jqxValidator({
                rules: [
						 { input: '#user_name', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 { input: '#change_date', message: 'Required', action: 'keyup, blur', rule: 'required' }
						 			   
					   ]
            });
						
			//validate success & submit				
			$('#theStockistUpgradeForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theStockistUpgradeForm").attr('action');
			$("#buttonStockistUpgrade").jqxButton({ disabled: true, theme: 'shinyblack' });
							
			var form_data = {
				user_name: $("#user_name").val(),
				change_date: $("#change_date").val(),
				pkg_id: $("#pkg_id option:selected").val(),
				product_id1: $("#product_id1").val(),
				product_id2: $("#product_id2").val(),
				product_id3: $("#product_id3").val(),
				product_id4: $("#product_id4").val(),
				
				product_qty1: $("#product_qty1").val(),
				product_qty2: $("#product_qty2").val(),
				product_qty3: $("#product_qty3").val(),
				product_qty4: $("#product_qty4").val(),				
				//tmb_sw: $('input:radio[name=tmb_sw]:checked').val(),
				is_ajax: 1
			};
				
				$.ajax({
					type: "POST",
					url: action,
					data: form_data,
					dataType: "json",
					
					success: function(response) {
					
						var id = response["id"];
						var success = response["success"];
						var displayMsg = response["displayMsg"];
		
			
						if (success == 1) {
						
							
							window.location.href = "index.php?view=list&displayMsg="+displayMsg;
		
						} else {
		
							$("#buttonStockistUpgrade").jqxButton({ disabled: false});
							document.getElementById("errMsg").innerHTML=displayMsg;
							document.getElementById("errMsg").innerHTML='<div class="alert alert-danger fade in" >' + displayMsg + '</div>';
							document.getElementById("displayMsg").innerHTML="";
							
							setTimeout(function() {
								$("#displayMsg").fadeOut().empty();
							}, 100);
							
						}
					}
				});
			
			}); 
			//end of validate sucess and submit	
            
});        
</script>    		
				<!--=== Page Content ===-->
				<!--=== Full Size Inputs ===-->
				<form class="form-horizontal row-border" action="" method="post" name="theStockistUpgradeForm" id="theStockistUpgradeForm">
             	 <div class="box box-info">
                   <div class="box-body">                                   
                     <div class="col-md-12">  

                        <div class="box-header with-border">
                          <h3 class="box-title">R-Wallet Balance : <?php echo walletBalance('acct_rwallet', $_SESSION['user_id']); ?></h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="Stockist Upgrade" id="buttonStockistUpgrade" class="btn btn-primary" onClick="document.theStockistUpgradeForm.action='info_inc.php?action=stockistUpgrade'"/>
	                  <?php } ?>
										</div>
                         </div>               

								
								

								<div class="form-group">
								  <label class="col-md-1 control-label">Date:</label>
									<div class="col-md-2">
									  <input name="change_date" type="text" class="form-control" id="change_date" value="<?php echo date("d-m-Y"); ?>" readonly=readonly/>
									</div>                                                               
								  <label class="col-md-2 control-label">User Name :</label>
									<div class="col-md-2">
									  <input name="user_name" type="text" class="form-control" id="user_name" />
									</div>		
																																									
                                        
                                    	<label class="col-md-2 control-label">Upgrade Package :</label>
                                        <div class="col-md-2">
<select class="form-control" name='pkg_id' id='pkg_id'>
                                              <?php
                                              $sql = "SELECT *
                                                      FROM product_package
													  where pkg_id > 1
                                                      order by pkg_id
                                                     ";
                                              $result=dbQuery($sql);
                                              if(dbNumRows($result)>0)
                                              {
                                                echo "<option value=''></option>";
                                                            
                                                while($row=dbFetchAssoc($result))
                                                {
                                                  echo "<option value='$row[pkg_id]'>$row[pkg_name]</option>";
                                                }
                                              }
                                    
                                              ?>
                                             </select>                                         
                                        </div>                                                                             
					   </div>
                       
									<div class="form-group">
                                    	<label class="col-md-5 control-label">Product Quantity:</label>
                                        <div class="col-md-2">

                                              <?php
                                              $sql = "SELECT *
                                                      FROM product
													  where active_sw = 1
                                                      order by product_id
                                                     ";
                                              $result=dbQuery($sql);
                                              if(dbNumRows($result)>0)
                                              {
                                                
												$x = 1;            
                                                while($row=dbFetchAssoc($result))
                                                {
													echo $row['product_name'];
													echo "<input type='hidden' name='product_id$x' id='product_id$x' class='form-control' value=".$row[product_id]." />";
													echo "<input type='text' name='product_qty$x' id='product_qty$x' class='form-control' />";
												
													echo "</br>";
													$x++;
                                                  
                                                }
                                              }
                                    
                                              ?>
                                        
                                        </div>
                                    </div>                       


										
							

				
					</div>		
					</div>
				</div>
				</form>
				<!-- /Page Content -->	


<?php
         
			}
            else
            {
            	echo "Your don't have sufficient amount on your R-Wallet";
            }

	  }
	  else
	  {
		  echo "Temporary unable to stockist upgrade"; 
	  }
} 
function freeUpgradeForm()
{
?>
<script type="text/javascript">
$(document).ready(function () {

			
			//$('#change_date').datepicker({ dateFormat: 'dd-mm-yy' }); 
           
		    $('#buttonFreeUpgrade').on('click', function () {
                $('#theFreeUpgradeForm').jqxValidator('validate');
            });
					
			
            // initialize validator.
            $('#theFreeUpgradeForm').jqxValidator({
                rules: [
						 { input: '#user_name', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 { input: '#change_date', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 			   
					   ]
            });
						
			//validate success & submit				
			$('#theFreeUpgradeForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theFreeUpgradeForm").attr('action');
			$("#buttonFreeUpgrade").jqxButton({ disabled: true, theme: 'shinyblack' });
							
			var form_data = {
				user_name: $("#user_name").val(),
				change_date: $("#change_date").val(),
				pkg_id: $("#pkg_id option:selected").val(),
				//tmb_sw: $('input:radio[name=tmb_sw]:checked').val(),
				is_ajax: 1
			};
				
				$.ajax({
					type: "POST",
					url: action,
					data: form_data,
					dataType: "json",
					
					success: function(response) {
					
						var id = response["id"];
						var success = response["success"];
						var displayMsg = response["displayMsg"];
		
			
						if (success == 1) {
						
							
							window.location.href = "index.php?view=list&displayMsg="+displayMsg;
		
						} else {
		
							$("#buttonFreeUpgrade").jqxButton({ disabled: false});
							document.getElementById("errMsg").innerHTML=displayMsg;
							document.getElementById("errMsg").innerHTML='<div class="alert alert-danger fade in" >' + displayMsg + '</div>';
							document.getElementById("displayMsg").innerHTML="";
							
							setTimeout(function() {
								$("#displayMsg").fadeOut().empty();
							}, 100);
							
						}
					}
				});
			
			}); 
			//end of validate sucess and submit	
            
});        
</script>    		
				<!--=== Page Content ===-->
				<!--=== Full Size Inputs ===-->
				<form class="form-horizontal row-border" action="" method="post" name="theFreeUpgradeForm" id="theFreeUpgradeForm">
             	 <div class="box box-info">
                   <div class="box-body">                                   
                     <div class="col-md-12">  

                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="Free Upgrade" id="buttonFreeUpgrade" class="btn btn-primary" onClick="document.theFreeUpgradeForm.action='info_inc.php?action=freeUpgrade'"/>
	                  <?php } ?>
										</div>
                         </div>               

								
								

								<div class="form-group">
								  <label class="col-md-1 control-label">Date:</label>
									<div class="col-md-2">
									  <input name="change_date" type="text" class="form-control" id="change_date" value="<?php echo date("d-m-Y"); ?>" readonly=readonly/>
									</div>                                    
								  <label class="col-md-2 control-label">User Name :</label>
									<div class="col-md-2">
									  <input name="user_name" type="text" class="form-control" id="user_name" />
									</div>		
																																									
                                        
                                    	<label class="col-md-2 control-label">Upgrade Package :</label>
                                        <div class="col-md-2">
<select class="form-control" name='pkg_id' id='pkg_id'>
                                              <?php
                                              $sql = "SELECT *
                                                      FROM product_package
													  where pkg_id > 1
                                                      order by pkg_id
                                                     ";
                                              $result=dbQuery($sql);
                                              if(dbNumRows($result)>0)
                                              {
                                                echo "<option value=''></option>";
                                                            
                                                while($row=dbFetchAssoc($result))
                                                {
                                                  echo "<option value='$row[pkg_id]'>$row[pkg_name]</option>";
                                                }
                                              }
                                    
                                              ?>
                                             </select>                                         
                                        </div>                                                                             
					   </div>


										
							

				
					</div>		
					</div>
				</div>
				</form>
				<!-- /Page Content -->	
<?php
}

function addUserForm()
{

	if(!checkUserStatusError())
	{

		if(walletBalance('acct_rwallet', $_SESSION['user_id']) >= checkMinStockistPkgPrice() or $_SESSION['user_grp']==1)
		{
?>

<script type="text/javascript">
$(document).ready(function () {
 
			//$('#join_date').datepicker({ dateFormat: 'dd-mm-yy' });      

            $('input[name=name]').change(function() { 
				//alert($(this).val());
				$("#bank_account_holder").val($(this).val());
			});
			
			$('#buttonAdd').on('click', function () {
				
                $('#theForm').jqxValidator('validate');
            });
					
			
            // initialize validator.
            $('#theForm').jqxValidator({
                rules: [
						 { input: '#sponsor_user_name', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 { input: '#name', message: 'Required', action: 'keyup, blur', rule: 'required' },	
						 { input: '#user_name', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 { input: '#join_date', message: 'Required', action: 'keyup, blur', rule: 'required' },					 
						 { input: '#upline_user_name', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 {input: '#placement_side', message: 'Required', action: 'select', rule: function(input){
									var val = $("#placement_side option:selected").val();
									//alert(val);
									if(val==""){
									return false;
									}
									return true;
									}
						 },	
						 {input: '#pkg_id', message: 'Required', action: 'select', rule: function(input){
									var val = $("#pkg_id option:selected").val();
									//alert(val);
									if(val==""){
									return false;
									}
									return true;
									}
						 },
						 {input: '#state_id', message: 'Required', action: 'select', rule: function(input){
									var val = $("#state_id option:selected").val();
									//alert(val);
									if(val==""){
									return false;
									}
									return true;
									}
						 },						 
						 { input: '#product_qty1', message: 'Number Only', action: 'keyup, blur', rule: 'number' },
						 { input: '#product_qty2', message: 'Number Only', action: 'keyup, blur', rule: 'number' },
						 { input: '#product_qty3', message: 'Number Only', action: 'keyup, blur', rule: 'number' },
						 { input: '#product_qty4', message: 'Number Only', action: 'keyup, blur', rule: 'number' },						 
						 
						 {input: '#chkAgree', message: 'You have to agree before proceed', action: 'select', rule: function(input){
									var val = $("#chkAgree").prop("checked")?1:0;
									//alert(val);
									if(val=="0"){
									return false;
									}
									return true;
									}
						 }	
						 				 			   
					   ]
            });
			
			
			
			//validate success & submit				
			$('#theForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theForm").attr('action');
			$("#buttonAdd").jqxButton({ disabled: true, theme: 'shinyblack' });
							
			var form_data = {
				join_date: $("#join_date").val(),
				user_name: $("#user_name").val(),
				name: $("#name").val(),
				sponsor_user_name: $("#sponsor_user_name").val(),
				upline_user_name: $("#upline_user_name").val(),
				placement_side: $("#placement_side option:selected").val(),
				pkg_id: $("#pkg_id option:selected").val(),
				name: $("#name").val(),
				id_no: $("#id_no").val(),
				email: $("#email").val(),
				address1: $("#address1").val(),
				city: $("#city").val(),
				state_id: $("#state_id").val(),
				country_id: $("#country_id").val(),
				postcode: $("#postcode").val(),
				hp: $("#hp").val(),
				//bank_name: $("#bank_name").val(),
				bank_id: $("#bank_id option:selected").val(),
				bank_account_holder: $("#bank_account_holder").val(),
				bank_account_no: $("#bank_account_no").val(),
				
				product_id1: $("#product_id1").val(),
				product_id2: $("#product_id2").val(),
				product_id3: $("#product_id3").val(),
				product_id4: $("#product_id4").val(),
				
				product_qty1: $("#product_qty1").val(),
				product_qty2: $("#product_qty2").val(),
				product_qty3: $("#product_qty3").val(),
				product_qty4: $("#product_qty4").val(),
				//tmb_sw: $('input:radio[name=tmb_sw]:checked').val(),
				is_ajax: 1
			};
				
				$.ajax({
					type: "POST",
					url: action,
					data: form_data,
					dataType: "json",
					
					success: function(response) {
					
						var id = response["id"];
						var success = response["success"];
						var displayMsg = response["displayMsg"];
		
			
						if (success == 1) {
						
							
							window.location.href = "index.php?view=list&displayMsg="+displayMsg;
		
						} else {
		
							$("#buttonAdd").jqxButton({ disabled: false});
							document.getElementById("errMsg").innerHTML=displayMsg;
							document.getElementById("errMsg").innerHTML='<div class="alert alert-danger fade in" >' + displayMsg + '</div>';
							document.getElementById("displayMsg").innerHTML="";
							
							setTimeout(function() {
								$("#displayMsg").fadeOut().empty();
							}, 100);
							
						}
					}
				});
			
			}); 
			//end of validate sucess and submit			




			


	
			
});


var ajax = new Array();

function getSponsorName(x)
{		

		var sponsor_user_name = document.getElementById('sponsor_user_name').value;
		//stateName = inputState.options[inputState.selectedIndex].value;
		//document.getElementById('inputArea1').options.length = 'Please select area';
		//document.getElementById('inputArea2').options.length = 'Please select area';
		//document.getElementById('inputArea3').options.length = 'Please select area';
		//document.getElementById('inputArea4').options.length = 'Please select area';
				

				
		//if(sponsor_user_name.length>0){
		if(sponsor_user_name != ''){
					
			var index = ajax.length;
			ajax[index] = new sack();
						
			ajax[index].requestFile = 'getSponsorName.php?user_name='+sponsor_user_name;	// Specifying which file to get
			ajax[index].onCompletion = function(){ createSponsorName(index) };	// Specify function that will be executed after file has been found
			ajax[index].runAJAX();		// Execute AJAX function
						

		}
		else
		{				
			
		}
				
}
			
function createSponsorName(index)
{
		//var channel_id = document.getElementById('channel_id');
		var obj = document.getElementById('display_sponsor_user_name');
		//var obj = document.getElementById('inputArea1');
		//var obj2 = document.getElementById('inputArea2');
		//var obj3 = document.getElementById('inputArea3');
		//var obj4 = document.getElementById('inputArea4');

						
		eval(ajax[index].response);	// Executing the response from Ajax as Javascript code	
}
</script>   

				<!--=== Page Content ===-->
				<!--=== Full Size Inputs ===-->
				<form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
             	 <div class="box box-info">
                   <div class="box-body">                                   
                     <div class="col-md-12">  

                        <div class="box-header with-border">
                          <h3 class="box-title">R-Wallet Balance : <?php echo walletBalance('acct_rwallet', $_SESSION['user_id']); ?></h3> 	
										<div style="float: right;">								
										<?php if($_SESSION['user_grp'] <> 1 or ($_SESSION['user_grp']==1 and $_GET['side']=='')){ ?>
        						<input type="button" value="Add" id="buttonAdd" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=add'"/>
	                  <?php } ?>	
										</div>
                         </div>               

								
								

								<div class="form-group">
									<label class="col-md-2 control-label">Sponsor :</label>
									<div class="col-md-2">
									  <input name="sponsor_user_name" type="text" class="form-control" id="sponsor_user_name" onchange="getSponsorName(this.value)" />
									  <input name="display_sponsor_user_name" type="text" class="form-control" id="display_sponsor_user_name" readonly=readoly/>                                      
									</div>		
									<label class="col-md-2 control-label">User Name :</label>
									<div class="col-md-2">
									  <input name="user_name" type="text" class="form-control" id="user_name" value="[Auto Assign]" readonly=readonly/>
									</div>
								</div>

								<div class="form-group">
											<label class="col-md-2 control-label">Placement :</label>
									<div class="col-md-2">
									  <input name="upline_user_name" type="text" class="form-control" id="upline_user_name" value="<?php echo $_GET['upline']; ?>" />
									</div>		
																																									
									<label class="col-md-2 control-label">Join Date :</label>
									<div class="col-md-2">
									  <input name="join_date" type="text" class="form-control" id="join_date" value="<?php echo date("d-m-Y"); ?>" readonly=readonly/>
									</div>								
											
								</div>
                                	
                                    <div class="form-group">
                                    
                                    	<label class="col-md-2 control-label">Side :</label>
                                        <div class="col-md-2">
                                    		<select class="form-control" name='placement_side' id='placement_side'>
                                              <option value=''></option>
                                              <option value='Left' 
											  <?php 			if($_GET['side']=='left'){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																} echo $cSelect; ?> >Left</option>
                                              <option value='Right'  
											  <?php 			if($_GET['side']=='right'){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																} echo $cSelect; ?>>Right</option>
                                             </select>                                        
                                        </div>
                                        
                                    	<label class="col-md-2 control-label">Package :</label>
                                        <div class="col-md-2">
<select class="form-control" name='pkg_id' id='pkg_id'>
                                              <?php
                                              $sql = "SELECT *
                                                      FROM product_package
                                                      order by pkg_id
                                                     ";
                                              $result=dbQuery($sql);
                                              if(dbNumRows($result)>0)
                                              {
                                                echo "<option value=''></option>";
                                                            
                                                while($row=dbFetchAssoc($result))
                                                {
                                                  echo "<option value='$row[pkg_id]'>$row[pkg_name] ($row[pkg_price], $row[pkg_price_west])</option>";
                                                }
                                              }
                                    
                                              ?>
                                             </select>                                         
                                        </div>
                                                                            
                                    </div>																		
										
									<div class="form-group">
										
										<label class="col-md-2 control-label">Full Name :</label>
											<div class="col-md-6">
												<input name="name" type="text" class="form-control" id="name" />
											</div>
									</div>
									<div class="form-group">												
											<label class="col-md-2 control-label">IC/Passport/Company Reg No:</label>
											<div class="col-md-2">
												<input type="text" name="id_no" id="id_no" class="form-control" />
											</div>
											<label class="col-md-2 control-label">Mobile Phone (no space, no -):</label>
											<div class="col-md-2">
												<input type="text" name="hp" id="hp" class="form-control" />
											</div>											
										
									</div>
									

								  <div class="form-group">

											<label class="col-md-2 control-label">Address :</label>
											<div class="col-md-6">
                                              <textarea name="address1" rows="3" class="form-control" id="address1"></textarea>
										  </div>									
									</div>
									


									<div class="form-group">

											<label class="col-md-2 control-label">City :</label>
											<div class="col-md-2">
												<input type="text" name="city" id="city" class="form-control" />
											</div>	
											
											<label class="col-md-2 control-label">PostCode :</label>
											<div class="col-md-2">
												<input type="text" name="postcode" id="postcode" class="form-control" />
											</div>																					
									</div>
									
									<div class="form-group">

											<label class="col-md-2 control-label">State :</label>
                                            <div class="col-md-2">
   												 <select class="form-control" name='state_id' id='state_id'>
                                                  <?php
                                                  $sql = "SELECT *
                                                          FROM state
                                                          order by state_name
                                                         ";
                                                  $result=dbQuery($sql);
                                                  if(dbNumRows($result)>0)
                                                  {
                                                    echo "<option value=''></option>";
                                                                
                                                    while($row=dbFetchAssoc($result))
                                                    {
                                                      echo "<option value='$row[state_id]'>$row[state_name]</option>";
                                                    }
                                                  }
                                        
                                                  ?>
                                                 </select>                                         
                                            </div>
											
											<label class="col-md-2 control-label">Country :</label>
											<div class="col-md-2">
   												 <select class="form-control" name='country_id' id='country_id'>
                                                  <?php
                                                  $sql = "SELECT *
                                                          FROM country
                                                         ";
                                                  $result=dbQuery($sql);
                                                  if(dbNumRows($result)>0)
                                                  {
                                                                
                                                    while($row=dbFetchAssoc($result))
                                                    {
                                                      echo "<option value='$row[country_id]'>$row[country_name]</option>";
                                                    }
                                                  }
                                        
                                                  ?>
                                                 </select>   
											</div>																					
									</div>																																											


									<div class="form-group">

											<label class="col-md-2 control-label">Email :</label>
											<div class="col-md-2">
												<input type="text" name="email" id="email" class="form-control" />
											</div>	
	
																														
									</div>		

									<div class="form-group">

											<label class="col-md-2 control-label">Bank Name :</label>
											<div class="col-md-2">
   												 <select class="form-control" name='bank_id' id='bank_id'>
                                                  <?php
                                                  $sql = "SELECT *
                                                          FROM bank
                                                         ";
                                                  $result=dbQuery($sql);
												  
												  echo "<option value='0'></option>";
												  
                                                  if(dbNumRows($result)>0)
                                                  {
                                                                
                                                    while($row=dbFetchAssoc($result))
                                                    {
                                                      echo "<option value='$row[bank_id]'>$row[bank_name]</option>";
                                                    }
                                                  }
                                        
                                                  ?>
                                                 </select> 
											</div>	
											<label class="col-md-2 control-label">Account Holder :</label>
											<div class="col-md-2">
												<input type="text" name="bank_account_holder" id="bank_account_holder" class="form-control" readonly=readonly/>
											</div>	
                                    
                                            																														
									</div>
                                    
                                    <div class="form-group">
 											<label class="col-md-2 control-label">Account No :</label>
											<div class="col-md-2">
												<input type="text" name="bank_account_no" id="bank_account_no" class="form-control" />
											</div>                                      
                                    
                                    </div>
 
 									<div class="form-group">
											<label class="col-md-2 control-label">Delivery Address  :</label>
											<div class="col-md-6">
												<textarea name="delivery_address" class="form-control" id="delivery_address"></textarea>
											</div>
									</div>
                                                                       																			
					   <div class="form-group">
											<label class="col-md-2 control-label">Remark  :</label>
											<div class="col-md-6">
                                              <input name="remark" type="text" class="form-control" id="remark" value=""  />
							   </div>
									</div>
																	

									<div class="form-group">
                                    	<label class="col-md-2 control-label">Product Quantity:</label>
                                        <div class="col-md-2">

                                              <?php
                                              $sql = "SELECT *
                                                      FROM product
													  where active_sw = 1
                                                      order by product_id
                                                     ";
                                              $result=dbQuery($sql);
                                              if(dbNumRows($result)>0)
                                              {
                                                
												$x = 1;            
                                                while($row=dbFetchAssoc($result))
                                                {
													echo $row['product_name'];
													echo "<input type='hidden' name='product_id$x' id='product_id$x' class='form-control' value=".$row[product_id]." />";
													echo "<input type='text' name='product_qty$x' id='product_qty$x' class='form-control' />";
												
													echo "</br>";
													$x++;
                                                  
                                                }
                                              }
                                    
                                              ?>
                                        
                                        </div>
                                    </div>



									<div class="form-group">
											<label class="col-md-2 control-label"></label>
											<div class="col-md-6">
                                            	Agreement
												<textarea name="remark" rows="5" class="form-control" id="remark">This is the agreement here. You have to agree before you can proceed</textarea>
									  </div>
									</div>
                                                                            
									<div class="form-group">
											<label class="col-md-2 control-label"></label>
											<div class="col-md-6">
                                            I Agree	
                                            	<input name="chkAgree" type="checkbox" id="chkAgree" />
									  			
                                      		</div>
									</div>	
				
					</div>		
					</div>
				</div>
				</form>
				<!-- /Page Content -->
			
            <?php	
			}
            else
            {
            	echo "Your don't have sufficient amount on your R-Wallet";
            }

	  }
	  else
	  {
		  echo "Temporary unable to register new user"; 
	  }
} 
?>
<?php
function getUserDetailForm($id,$displayMsg)
{

	if($_SESSION['user_grp'] == 1)
	{
		$sql = "SELECT *
			   FROM user
			   WHERE u_id = '$id'
			   ";		
	}
	else
	{
		$sql = "SELECT *
			   FROM user
			   WHERE u_id = '$_SESSION[u_id]'
			   ";			
	}
	

 	$result = dbQuery($sql);
  	if(dbNumRows($result)==1)
  	{
    	$row=dbFetchAssoc($result);
		//$name = $row[name];
		$u_id = $row[u_id];
		
	}
?>

				<!--=== Page Content ===-->
				<!--=== Full Size Inputs ===-->
				<form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
             	 <div class="box box-info">
                   <div class="box-body">                                   
                     <div class="col-md-12">  

                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	



										<div style="float: right;">	
                                        <?php if($_SESSION['user_grp']==1){ ?>							
										<input type="button" value="Resend Password" id="buttonResend" class="btn btn-primary" onclick="document.theForm.action='info_inc.php?action=reSend&amp;id=<?php echo $u_id; ?>'"/>
                                        <?php } ?>
                                        										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="Update" id="buttonUpdate" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=update&id=<?php echo $u_id; ?>'"/>
	                  <?php } ?>	
										</div>
                         </div>               

								
									<div class="form-group">
										
										<label class="col-md-2 control-label">User Name:</label>
											<div class="col-md-6">
											 <?php echo $row[user_name]; ?>
											</div>
									</div>
 
 									<div class="form-group">
										
											<label class="col-md-2 control-label">Package:</label>
											<div class="col-md-2">
											 <?php echo $row[pkg_name]; ?>
											</div>
                                            
											<label class="col-md-2 control-label">Join Date:</label>
											<div class="col-md-2">
											 <?php echo $row[join_datetime]; ?>
											</div>                                            
									</div>
                                                                       																									
										
									<div class="form-group">
										
										<label class="col-md-2 control-label">Full Name:</label>
											<div class="col-md-6">
												<input name="name" type="text" class="form-control" id="name" value="<?php echo $row[name]; ?>" <?php if($_SESSION['user_grp']<>1){ ?> readonly=readonly <?php } ?>/> <?php if($_SESSION['user_grp']==1){ ?>
                                                Temp Password : <?php echo $row[temp_password]; ?>
                                                <?php } ?>
											</div>
									</div>
									<div class="form-group">												
											<label class="col-md-2 control-label">NRIC:</label>
											<div class="col-md-2">
												<input type="text" name="id_no" id="id_no" class="form-control"  value="<?php echo $row[id_no]; ?>" <?php if($_SESSION['user_grp']<>1){ ?> readonly=readonly <?php } ?>/>
											</div>
											<label class="col-md-2 control-label">Mobile Phone (no space, no -):</label>
											<div class="col-md-2">
												<input name="hp" type="text" class="form-control" id="hp" value="<?php echo $row[hp]; ?>" />
									  </div>	
																									
										
									</div>
									

								  <div class="form-group">

											<label class="col-md-2 control-label">Address Line 1  :</label>
											<div class="col-md-6">
                                              <textarea name="address1" rows="3" class="form-control" id="address1"><?php echo $row[address1]; ?></textarea>
										  </div>									
									</div>
									


									<div class="form-group">

											<label class="col-md-2 control-label">City :</label>
											<div class="col-md-2">
												<input name="city" type="text" class="form-control" id="city" value="<?php echo $row[city]; ?>" />
											</div>	
											
											<label class="col-md-2 control-label">PostCode :</label>
											<div class="col-md-2">
												<input name="postcode" type="text" class="form-control" id="postcode" value="<?php echo $row[postcode]; ?>" />
											</div>																					
									</div>
									
									<div class="form-group">

											<label class="col-md-2 control-label">State :</label>
											<div class="col-md-2">
												<select class="form-control" name='state_id' id='state_id'>
                                                  <?php
                                                  $sql = "SELECT *
                                                          FROM state
                                                          order by state_name
                                                         ";
                                                  $result=dbQuery($sql);
                                                  if(dbNumRows($result)>0)
                                                  {
                                                    echo "<option value=''></option>";
                                                                
                                                    while($rowState=dbFetchAssoc($result))
                                                    {

														if($rowState[state_id]==$row[state_id]){
															$cSelect="SELECTED";
														}else{
															$cSelect="";
														}		
																										
                                                      	echo "<option value='$rowState[state_id]' $cSelect>$rowState[state_name]</option>";
                                                    }
                                                  }
                                        
                                                  ?>
                                                 </select>
											</div>	
											
											<label class="col-md-2 control-label">Country :</label>
											<div class="col-md-2">
												<select class="form-control" name='country_id' id='country_id'>
                                                  <?php
                                                  $sql = "SELECT *
                                                          FROM country
                                                         ";
                                                  $result=dbQuery($sql);
                                                  if(dbNumRows($result)>0)
                                                  {
                                                    echo "<option value=''></option>";
                                                                
                                                    while($rowCountry=dbFetchAssoc($result))
                                                    {

														if($rowCountry[country_id]==$row[country_id]){
															$cSelect="SELECTED";
														}else{
															$cSelect="";
														}		
																										
                                                      	echo "<option value='$rowCountry[country_id]' $cSelect>$rowCountry[country_name]</option>";
                                                    }
                                                  }
                                        
                                                  ?>
                                                 </select>
											</div>																					
									</div>																																											


									<div class="form-group">

										<label class="col-md-2 control-label">Email :</label>
											<div class="col-md-2">
												<input name="email" type="text" class="form-control" id="email" value="<?php echo $row[email]; ?>" />
											</div>	
																
									</div>		

									<div class="form-group">

											<label class="col-md-2 control-label">Bank Name :</label>
											<div class="col-md-2">
   												 <select class="form-control" name='bank_id' id='bank_id'>
                                                  <?php
                                                  $sql = "SELECT *
                                                          FROM bank
                                                         ";
                                                  $result=dbQuery($sql);
												  
												  echo "<option value='0'></option>";
												  
                                                  if(dbNumRows($result)>0)
                                                  {
                                                                
                                                    while($rowBank=dbFetchAssoc($result))
                                                    {

														if($rowBank[bank_id]==$row[bank_id]){
															$cSelect="SELECTED";
														}else{
															$cSelect="";
														}															
                                                      echo "<option value='$rowBank[bank_id]' $cSelect>$rowBank[bank_name]</option>";
                                                    }
                                                  }
                                        
                                                  ?>
                                                 </select> 
											</div>	
											<label class="col-md-2 control-label">Account Holder :</label>
											<div class="col-md-2">
												<input name="bank_account_holder" type="text" class="form-control" id="bank_account_holder" value="<?php echo $row[bank_account_holder]; ?>" <?php if($_SESSION['user_grp']<>1){ ?> readonly=readonly <?php } ?>/>
											</div>	
                                    
                                            																														
									</div>
                                    
                                    <div class="form-group">
 											<label class="col-md-2 control-label">Account No :</label>
											<div class="col-md-2">
												<input name="bank_account_no" type="text" class="form-control" id="bank_account_no" value="<?php echo $row[bank_account_no]; ?>" />
											</div>                                      
                                    
                                    </div>
 
  									<div class="form-group">
											<label class="col-md-2 control-label">Delivery Address  :</label>
											<div class="col-md-6">
												<textarea name="delivery_address" class="form-control" id="delivery_address" ><?php echo $row[delivery_address]; ?> </textarea>
											</div>
									</div>
                                                                       																			
									<div class="form-group">
											<label class="col-md-2 control-label">Remark  :</label>
											<div class="col-md-6">
                                              <input name="remark" type="text" class="form-control" id="remark" value="<?php echo $row[remark]; ?>" />
											</div>
									</div>
										
							

				
					</div>		
					</div>
				</div>
				</form>
				<!-- /Page Content -->

<?php
}


function showUserList()
{

?>
<script type="text/javascript">

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'user_id', type: 'string'},
				{ name: 'u_id', type: 'string'},
				{ name: 'user_name', type: 'string'},
				{ name: 'join_date', type: 'string'},
				{ name: 'pkg_name', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'hp', type: 'string'}
			],
			
			cache: false,
			url: 'data.php',
			filter: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
			},
			root: 'Rows',
			pagesize: 50,
			beforeprocessing: function(data)
			{		
				if (data != null)
				{
					source.totalrecords = data[0].TotalRows;					
				}
			}
			};		
			var dataadapter = new $.jqx.dataAdapter(source, {
				loadError: function(xhr, status, error)
				{
					alert(error);
				}
			}
		);
		
	 	var linkrenderer = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
	
					//return "<a href='" + value + "' target='_blank'>Link Text</a>";
			return "<a href=index.php?view=detail&id=" + value + " >View</a>";
		}						

			
		$("#jqxgrid").jqxGrid(
		{	
			source: dataadapter,
			
			filterable: true,
			sortable: true,
			editable: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',		
			height: 550,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				<?php if($_SESSION['user_grp'] == 1){ ?>		
				{ text: '', editable: false, datafield: 'u_id', width: 80 ,cellsrenderer: linkrenderer},
				<?php } ?>
				{ text: 'User Name', editable: true, datafield: 'user_name', width: 120 },
				{ text: 'Name', editable: true, datafield: 'name', width: 300 },
				{ text: 'Join Date',editable: false, datafield: 'join_date', width: 120 },
				{ text: 'Package',editable: false, datafield: 'pkg_name', width: 120 },
				{ text: 'Mobile No',editable: true, datafield: 'hp', width: 130 } 
			]
		});  
		
				
						
});

</script>

				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">

							<div class="widget-content">
							
									<div id="jqxgrid">

									</div>
							</div>

					</div>
				</div>

<?php 
} // end of function showList

?>