<?php

function addForm()
{

?>

<script>

$(document).ready(function () {
       
      		
			$('#buttonAdd').on('click', function () {
                $('#theForm').jqxValidator('validate');
            });

            $('#buttonUpdate').on('click', function () {
                $('#theForm').jqxValidator('validate');
            });
			
 			  $('#buttonDelete').on('click', function () {
				var answer = confirm("Are you sure you want to delete this?");
				if (answer) {
					var validationResult = function (isValid) {
						if (isValid) {
							$("#theForm").submit();
						}
					}
							$('#theForm').jqxValidator('validate', validationResult);
				}else{
					return false;
				
				}
            });	


            // initialize validator.
            $('#theForm').jqxValidator({
                rules: [

						 //{ input: '#name', message: 'Req', action: 'keyup, blur', rule: 'required' },
						// { input: '#tel', message: 'Req', action: 'keyup, blur', rule: 'required' },
						 { input: '#name', message: 'Req', action: 'keyup, blur', rule: 'required' },
						 { input: '#user_name', message: 'Req', action: 'keyup, blur', rule: 'required' },
						 { input: '#email', message: 'Req', action: 'keyup, blur', rule: 'required' },
						 { input: '#email', message: 'Req', action: 'keyup, blur', rule: 'email' },
						 { input: '#password', message: 'Req', action: 'keyup, blur', rule: 'required' },					   
					   ]
            });
			
			
			
			//validate success & submit				
			$('#theForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theForm").attr('action');
			$("#buttonAdd").jqxButton({ disabled: true, theme: 'shinyblack' });
							
			var form_data = {
				name: $("#name").val(),
				ic_no: $("#ic_no").val(),
				nationality_id: $("#nationality_id option:selected").val(),
				nationality_name: $("#nationality_id option:selected").text(),
				address1: $("#address1").val(),
				postcode: $("#postcode").val(),
				city: $("#city").val(),		
				state_id: $("#state_id option:selected").val(),
				state_prefix: $("#state_id option:selected").text(),
				country_id: $("#country_id option:selected").val(),
				country_name: $("#country_id option:selected").text(),
				prefix_name: $("#country_id option:selected").text(),
				tel: $("#tel").val(),
				email: $("#email").val(),
				bank_id: $("#bank_id option:selected").val(),
				bank_name: $("#bank_id option:selected").text(),
				bank_swift_code: $("#bank_id option:selected").text(),
				bank_account_no: $("#bank_account_no").val(),
				user_name: $("#user_name").val(),
				password: $("#password").val(),
				user_group: $("#user_group").val(),
				remark: $("#remark").val(),
				member_reg_no: $("#member_reg_no").val(),
				sponsor_member_reg_no: $("#sponsor_member_reg_no").val(),
				u_id: $("#u_id").val(),
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
						
							
							window.location.href = "index.php?view=detail&id="+id+'&displayMsg='+displayMsg;
		
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

		var sponsor_member_reg_no = document.getElementById('sponsor_member_reg_no').value;
		//stateName = inputState.options[inputState.selectedIndex].value;
		//document.getElementById('inputArea1').options.length = 'Please select area';
		//document.getElementById('inputArea2').options.length = 'Please select area';
		//document.getElementById('inputArea3').options.length = 'Please select area';
		//document.getElementById('inputArea4').options.length = 'Please select area';
				

				
		//if(sponsor_user_name.length>0){
		if(sponsor_member_reg_no != ''){
					
			var index = ajax.length;
			ajax[index] = new sack();
						
			ajax[index].requestFile = 'getSponsorName.php?member_reg_no='+sponsor_member_reg_no;	// Specifying which file to get
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
		var obj = document.getElementById('display_sponsor_name');
		//var obj = document.getElementById('inputArea1');
		//var obj2 = document.getElementById('inputArea2');
		//var obj3 = document.getElementById('inputArea3');
		//var obj4 = document.getElementById('inputArea4');

						
		eval(ajax[index].response);	// Executing the response from Ajax as Javascript code	
}
</script> 
              
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
	
        						<input type="button" value="ADD" id="buttonAdd" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=add'"/>
	                  </div>
                         </div>                       
                                  <div class="nav-tabs-custom">
                                    <!--
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a href="#detail" data-toggle="tab">Worker Details</a></li>	
                                    </ul>
                                    -->
                                    <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail">

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Sponsor :</label>
                                            <div class="col-md-2">
                                              <input name="sponsor_member_reg_no" type="text" class="form-control" id="sponsor_member_reg_no" onchange="getSponsorName(this.value)" value="0" />
                                              <input name="display_sponsor_name" type="text" class="form-control" id="display_sponsor_name" readonly=readoly/>                                      
                                            </div>		
                                           
                                            </div>
                                        </div>
                                                                      
                                        <div class="form-group">
                                           	<label class="col-md-2 control-label">Name</label>
											<div class="col-md-6">
												<input name="name" type="text" class="form-control" id="name" />
											</div>
										</div>
                                        
									<div class="form-group">												
											<label class="col-md-2 control-label">User ID</label>
											<div class="col-md-3">
												<input type="text" name="user_name" id="user_name" class="form-control" /><input type="hidden" name="user_group" id="user_group" class="form-control" value="10"/>
											</div>
											
												
									</div>
                                    
                                     <div class="form-group">
                                           	<label class="col-md-2 control-label">Password</label>
											<div class="col-md-3">
												<input name="password" type="text" class="form-control" id="password" />
											</div>   
                                            
                                            <label class="col-md-1 control-label">Email</label>
											<div class="col-md-4">
												<input name="email" type="text" class="form-control" id="email" />
											</div>
                                            
                                         
									</div>                                     
                                                                            
                                     	<div class="form-group">
                                           	<label class="col-md-2 control-label">IC Number/Passport</label>
											<div class="col-md-3">
												<input name="name" type="text" class="form-control" id="ic_no" />
											</div>
                                            <label for="inputName" class="col-sm-3 control-label">Nationality</label>
                                            <div class="col-sm-2">
                                              <select name='nationality_id' id='nationality_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM country
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[country_id]==$nationality_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[country_id]' $cSelect>$row[nationality_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>              
									</div>
 									<div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Address</label>
                                            <div class="col-sm-5">
                                              <textarea class="form-control" id="address1"></textarea>
                                            </div>
                                            
                                            <label for="inputName" class="col-sm-1 control-label">Postcode</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="postcode" >
                                             </div>
                                                                                                                                                               </div>
                                                                                                                                                               
                                                                                                                                                                                                     
                                          <div class="form-group">   
                                                                                     
                                              
                                            <label for="inputName" class="col-sm-2 control-label">City</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="city" >
                                            </div>     
                                          
                                           <label for="inputName" class="col-sm-1 control-label">State</label>
                                            <div class="col-sm-2">
                                              <select name='state_id' id='state_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM state
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[state_id]==$state_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[state_id]' $cSelect>$row[state_prefix] - $row[state_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                            
                                             <label for="inputName" class="col-sm-1 control-label">Country</label>
                                            <div class="col-sm-2">
                                              <select name='country_id' id='country_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM country
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[country_id]==$country_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[country_id]' $cSelect>$row[prefix_name] - $row[country_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                            </div> 
                                            
                                     <div class="form-group">
                                           	<label class="col-md-2 control-label">Mobile Phone</label>
											<div class="col-md-3">
												<input name="name" type="text" class="form-control" id="tel" />
											</div>
                                            
                      
									</div> 
                                    
                                    <div class="form-group"> 

                                           <label for="inputName" class="col-sm-2 control-label">Bank</label>
                                            <div class="col-sm-3">
                                              <select name='bank_id' id='bank_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM bank order by bank_name
																	 ";
														$result=dbQuery($sql);
														
														echo "<option value='0'></option>";												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[bank_id]==$bank_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[bank_id]' $cSelect>$row[bank_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                            
                                            	<label class="col-md-2 control-label">Bank Account Number</label>
											<div class="col-md-3">
												<input name="bank_account_no" type="text" class="form-control" id="bank_account_no" />
											</div>
                                            </div>
                                              
                                                                                    

                                    
									<div class="form-group">
											<label class="col-md-2 control-label">Remark</label>
											<div class="col-md-6">
												<textarea name="remark" class="form-control" id="remark"></textarea>
											</div>
									</div>
                                   
                                      </div><!-- /.tab-pane -->
                                                                          
 
                                    </div><!-- /.tab-content -->
                                  </div>
                                  <!-- /.nav-tabs-custom -->
                                </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
	
                  </div><!-- /.box-footer -->
               	
              </div><!-- /.box -->
		      </form>


<?php } //end of fuction add ?>


<?php
function getDetailForm($id)
{
	
		$data = getUserDetailApp($_SESSION[user_id]);	

		if ($data != ""){
?>


              <a href="../main/logoutApp.php" class="btn btn-default btn-flat">Logout</a>

              <form class="form-horizontal row-border" action="info_inc.php?action=update&id=<?php echo $_SESSION[user_id]; ?>" method="post" name="theForm" id="theForm">

  					
        	  
       
	
              <div class="box box-info">
 
              
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        
                                  <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail"> <div class="form-group"></div>
                                      <div class="form-group">
                                           	<label class="col-md-2 control-label">Member Registration Number</label>
                                            <div class="col-md-2">
												<input name="name" type="text" class="form-control" id="member_reg_no" value="<?PHP echo $data['member_reg_no']?>" disabled="disabled" />
											</div>

                                           	<label class="col-md-2 control-label">Status</label>
                                            <div class="col-md-2">
												<?PHP echo $data['status_name']?>
											</div>
                                            											
									</div>
                                        <div class="form-group">
                                           	<label class="col-md-2 control-label">Name</label>
											<div class="col-md-6">
												<input name="name" type="text" class="form-control" id="name" value="<?PHP echo $data['name']?>" />
											</div>
									</div>
                                              
 
 									<div class="form-group">												
											<label class="col-md-2 control-label">User ID</label>
											<div class="col-md-3">
												<input type="text" name="user_name" id="user_name" class="form-control" value="<?PHP echo $data['user_name']?>" readonly=readonly/>
											</div>
                                           
                                           
                                           <input type="hidden" name="user_group" id="user_group" class="form-control" value="<?PHP echo $data['user_group']?>" />
                                            
	
										<label class="col-md-2 control-label">Password</label>
											<div class="col-md-3">
												
 											<input name="password" type="text" class="form-control" id="password" value="" />                                               
											</div>	
 									
									</div>
                                                                               <div class="form-group">
                                           	<label class="col-md-2 control-label">IC Number/Passport</label>
											<div class="col-md-3">
												<input name="ic_no" type="text" class="form-control" id="ic_no" value="<?PHP echo $data['ic_no']?>" />
											</div>
                                            <label for="inputName" class="col-sm-3 control-label">Nationality</label>
                                            <div class="col-sm-2">
                                              <select name='nationality_id' id='nationality_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM country
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[country_id]==$data['nationality_id']){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[country_id]' $cSelect>$row[nationality_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>              
									</div>
 									<div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Address</label>
                                            <div class="col-sm-5">
                                              <textarea class="form-control" id="address1" name="address1"><?PHP echo $data['address1']?></textarea>
                                            </div>
                                            
                                            <label for="inputName" class="col-sm-1 control-label">Postcode</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="postcode" name="postcode" value="<?PHP echo $data['postcode']?>" >
                                             </div>
                                                                                                                                                               </div>
                                                                                                                                                               
                                                                                                                                                                                                     
                                          <div class="form-group">   
                                                                                     
                                              
                                            <label for="inputName" class="col-sm-2 control-label">City</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="city" name="city" value="<?PHP echo $data['city']?>" >
                                            </div>     
                                          
                                           <label for="inputName" class="col-sm-1 control-label">State</label>
                                            <div class="col-sm-2">
                                              <select name='state_id' id='state_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM state
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[state_id]==$data['state_id']){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[state_id]' $cSelect>$row[state_prefix] - $row[state_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                            
                                             <label for="inputName" class="col-sm-1 control-label">Country</label>
                                            <div class="col-sm-2">
                                              <select name='country_id' id='country_id' class="form-control" disabled="disabled">
            <?php
														$sql = "SELECT *
																		FROM country
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[country_id]==$data['country_id']){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[country_id]' $cSelect>$row[prefix_name] - $row[country_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                            </div> 
                                            
                                     <div class="form-group">
                                           	<label class="col-md-2 control-label">Mobile Phone</label>
											<div class="col-md-3">
												<input name="tel" type="text" class="form-control" id="tel" value="<?PHP echo $data['tel']?>" />
											</div>
                                            
                                            <label class="col-md-1 control-label">Email</label>
											<div class="col-md-4">
												<input name="email" type="text" class="form-control" id="email" value="<?PHP echo $data['email']?>" />
											</div>
									</div> 
                                    
                                    <div class="form-group"> 

                                           <label for="inputName" class="col-sm-2 control-label">Bank</label>
                                            <div class="col-sm-3">
                                              <select name='bank_id' id='bank_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM bank order by bank_name
																	 ";
														$result=dbQuery($sql);												
														
														echo "<option value='0'></option>";
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[bank_id]==$data['bank_id']){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[bank_id]' $cSelect>$row[bank_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                            
                                            	<label class="col-md-2 control-label">Bank Account Number</label>
											<div class="col-md-3">
												<input name="bank_account_no" type="text" class="form-control" id="bank_account_no" value="<?PHP echo $data['bank_account_no']?>" />
											</div>
                                            </div>
                                                                                    

										
										
									<div class="form-group">
											<label class="col-md-2 control-label">Remark</label>
											<div class="col-md-6">
												<textarea name="remark" class="form-control" id="remark"><?PHP echo $data['remark']?></textarea>
											</div>
									</div>

                                   
                                      </div><!-- /.tab-pane -->
                                                                          
 									<input type="submit" value="Update" id="buttonUpdate" class="btn btn-primary" />
                                    </div><!-- /.tab-content -->
                                  </div><!-- /.nav-tabs-custom -->
                                </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
	
                  </div><!-- /.box-footer -->
               	
              </div><!-- /.box -->
		      </form>


<?php }
else {
	echo '';
	}
	
}
	
?>

<?php

function showList()
{

?>
<script type="text/javascript">

$(document).ready(function () {

		
		var user_sub = '<?php echo  $_GET['sub']; ?>';
				
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'user_id', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'ic_no', type: 'string'},
				{ name: 'address1', type: 'string'},
				{ name: 'tel', type: 'string'},
				{ name: 'email', type: 'string'},
				{ name: 'bank_name', type: 'string'},
				{ name: 'bank_swift_code', type: 'string'},
				{ name: 'bank_account_no', type: 'string'},
				{ name: 'user_name', type: 'string'},
				{ name: 'member_reg_no', type: 'string'},
				{ name: 'status_name', type: 'string'},
			],
				
			cache: false,
			url: 'data.php?sub='+user_sub,
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
			
			//filterable: true,
			//sortable: true,
			columnsresize: true,
			editable: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',		
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				//{ text: '', editable: false, datafield: 'user_id', width: 80 ,cellsrenderer: linkrenderer},
				
				{ text: 'Member Registration Number',editable: true, datafield: 'member_reg_no', width: 230 },
				{ text: 'Status',editable: true, datafield: 'status_name', width: 120 },
				{ text: 'Name', editable: true, datafield: 'name', width: 300 },
				//{ text: 'Address',editable: false, datafield: 'address1', width: 300 },
				{ text: 'Mobile Phone', editable: true, datafield: 'tel', width: 130 },
				{ text: 'Email',editable: true, datafield: 'email', width: 300 },
				//{ text: 'Bank',editable: false, datafield: 'bank_name', width: 150 },
				//{ text: 'Bank Swift Code',editable: false, datafield: 'bank_swift_code', width: 150 },
				//{ text: 'Bank Account',editable: false, datafield: 'bank_account_no', width: 150 },
				//{ text: 'User ID',editable: false, datafield: 'user_name', width: 150 },
				
				
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

<?php

function showListMember($status_id)
{

?>
<script type="text/javascript">

$(document).ready(function () {

		
		var status_id = '<?php echo  $_GET['status_id']; ?>';
				
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'user_id', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'ic_no', type: 'string'},
				{ name: 'address1', type: 'string'},
				{ name: 'tel', type: 'string'},
				{ name: 'email', type: 'string'},
				{ name: 'bank_name', type: 'string'},
				{ name: 'bank_swift_code', type: 'string'},
				{ name: 'bank_account_no', type: 'string'},
				{ name: 'user_name', type: 'string'},
				{ name: 'u_id', type: 'string'},
			],
				
			cache: false,
			url: 'dataMember.php?status_id='+status_id,
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
			columnsresize: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',		
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				{ text: '', editable: false, datafield: 'u_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: 'Name', editable: false, datafield: 'name', width: 200 },
				{ text: 'IC Number',editable: false, datafield: 'ic_no', width: 150 },
				{ text: 'Address',editable: false, datafield: 'address1', width: 300 },
				{ text: 'Mobile Phone', editable: false, datafield: 'tel', width: 100 },
				{ text: 'Email',editable: false, datafield: 'email', width: 200 },
				{ text: 'Bank',editable: false, datafield: 'bank_name', width: 150 },
				{ text: 'Bank Swift Code',editable: false, datafield: 'bank_swift_code', width: 150 },
				{ text: 'Bank Account',editable: false, datafield: 'bank_account_no', width: 150 },
				{ text: 'User ID',editable: false, datafield: 'user_name', width: 150 },
				
				
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