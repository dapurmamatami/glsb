<?php
include "inc/dbconfig.php";
include "inc/dbfunctions.php";
include "main/functions.php";
include "inc/pdoconfig.php";
include "main/pdofunctions.php";
?>


<!DOCTYPE html><head>
  <link href='http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/css/bootstrap-switch.css' rel='stylesheet' type='text/css'>
  <link href='http://davidstutz.github.io/bootstrap-multiselect/css/bootstrap-multiselect.css' rel='stylesheet' type='text/css'>
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0/js/bootstrap.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='http://davidstutz.github.io/bootstrap-multiselect/js/bootstrap-multiselect.js' type='text/javascript'></script>
</head>


<style type="text/css">
.indent-small {
  margin-left: 5px;
}
.form-group.internal {
  margin-bottom: 0;
}
.dialog-panel {
  margin: 10px;
}
.datepicker-dropdown {
  z-index: 200 !important;
}
.panel-body {
  background: #e5e5e5;
  /* Old browsers */
  background: -moz-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  /* FF3.6+ */
  background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #e5e5e5), color-stop(100%, #ffffff));
  /* Chrome,Safari4+ */
  background: -webkit-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  /* Chrome10+,Safari5.1+ */
  background: -o-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  /* Opera 12+ */
  background: -ms-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  /* IE10+ */
  background: radial-gradient(ellipse at center, #e5e5e5 0%, #ffffff 100%);
  /* W3C */
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e5e5e5', endColorstr='#ffffff', GradientType=1);
  /* IE6-9 fallback on horizontal gradient */
  font: 600 15px "Open Sans", Arial, sans-serif;
}
label.control-label {
  font-weight: 600;
  color: #777;
}

</style>
<?php

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action)
{
	case 'add' :
		add();
	break;
}


function add()
{
		$name = mysql_escape_string($_POST[name]);
		$ic_no = mysql_escape_string($_POST[ic_no]);
		$nationality_id = $_POST[nationality_id];
		$address1 = $_POST[address1];
		$postcode = mysql_escape_string($_POST[postcode]);
		$city = mysql_escape_string($_POST[city]);		
		$state_id = $_POST[state_id];
		$country_id = $_POST[country_id];
		$tel = mysql_escape_string($_POST[tel]);
		$email = mysql_escape_string($_POST[email]);
		$bank_id = $_POST[bank_id];
		$bank_account_no = mysql_escape_string($_POST[bank_account_no]);
		$user_name = mysql_escape_string($_POST[user_name]);
		//$password = md5($_POST[password]);
		$random_password = createRandomPassword();
		$password = md5($random_password);
		$temp_password = $random_password;
		$user_group = $_POST[user_group];
		$remark = $_POST[remark];
		$sponsor_member_reg_no = mysql_escape_string($_POST[sponsor_member_reg_no]);
		
		$data = getCountry($country_id);
		$nationality_name = $data['nationality_name'];
		
		$data_state = getState($state_id);
		$state_prefix = $data_state['state_prefix'];
		
		$data_country = getCountry($country_id);
		$country_name = $data_country['country_name'];
		$prefix_name = $data_country['prefix_name'];
		
		$data_bank = getBank($bank_id);
		$bank_name = $data_bank['bank_name'];
		$bank_swift_code = $data_bank['bank_swift_code'];
		
		$userUplineData = getUserDetailByMemberRegNo($sponsor_member_reg_no);
		$upline_id = $userUplineData[user_id];
		
		if($name!="") 
		{
			$member_reg_no = ($prefix_name);
			$characters = array_merge(range('0','9'));
			for ($i = 0; $i < 7; $i++) {
			$rand = mt_rand(0, count($characters)-1);
			$member_reg_no .= $characters[$rand];
			}
			
			if(!checkUserName($user_name)) {
				
				if ($sponsor_member_reg_no == '0'){

					$current_manager_id = getCurrentManagerID();
					$upline_id = getManagerUserID($current_manager_id);
					
					$data_sponsor = getUserDetail($upline_id);
					$sponsor_member_reg_no = $data_sponsor['member_reg_no'];
					
					updateCurrentManagerID($current_manager_id);
					//$upline_id = 2;
					
				}
				
				if($upline_id > 0) {
					
					if(checkStatusIDUser($upline_id)){	
												
						$new_user_id = addUserRegistration($name, $ic_no, $nationality_id, $nationality_name, $address1, $postcode, $city, $state_id, $state_prefix, $country_id, $country_name, $prefix_name, $tel, $email, $bank_id, $bank_name, $bank_swift_code, $bank_account_no, $user_name, $password, $temp_password, $user_group, $remark, $member_reg_no, $sponsor_member_reg_no, $upline_id);
		
		
						$u_id = genID(user);
						$u_id = $u_id . '-' . $new_user_id;
														
								
						$sql = "SELECT upline_id_all, upline_id
								FROM user
								WHERE user_id = '$upline_id'
								";
						$result=dbQuery($sql);
						$row=dbFetchAssoc($result);
						$upline_id_all = $row[upline_id_all];
						$upline_id2 = $row[upline_id];
								
														
						$cart = array();
						$cart = array($upline_id_all, $new_user_id);
						$new_upline_id_all=implode(",",$cart);
														
														
						if($upline_id2 == 0)
						{
					
							$upline_id3 = 0;
						}
						else
						{
							$upline_id3 =  getCode('user', 'upline_id', 'user_id', $upline_id2);
						}
								
						if($upline_id3 == 0)
						{
							$upline_id4 = 0;
						}
						else
						{
							$upline_id4 =  getCode('user', 'upline_id', 'user_id', $upline_id3);
						}						
								
								
						$sql = "UPDATE user
								SET u_id='$u_id', upline_id_all = '$new_upline_id_all',upline_id2='$upline_id2', upline_id3='$upline_id3',upline_id4='$upline_id4'
								where user_id = $new_user_id
								";
						dbQuery($sql);	
						
						//$dataMessage = getMessageTemplate('newmember');
						//$message_subject = $dataMessage[message_subject];
						//$message_content = $dataMessage[message_content];
						//$message_footer = $dataMessage[message_footer];
						$attachment_path = '';
						
						
						insertEmailSend('pendingmember', $attachment_path, $new_user_id, 0, '');
					}
				}
			}
		}
}
?>
<body>
  <div class='container'>
    <div class='panel panel-primary dialog-panel'>
      <div class='panel-heading'>
        <h5>New Member & Order</h5>
      </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' action="form_glsb.php?action=add" method="post">
        
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Sponsor</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
                  <input name="sponsor_member_reg_no" type="text" class="form-control" id="sponsor_member_reg_no" onchange="getSponsorName(this.value)" value="0" />
            <input name="display_sponsor_name" type="text" class="form-control" id="display_sponsor_name" readonly=readoly/>
                </div>
              </div>
              
            </div>
          </div>
        
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Name</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='name' name="name" placeholder='Your Full Name' type='text'>
                </div>
              </div>
              
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>User ID</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
					<input type="text" name="user_name" id="user_name" class="form-control" />
                    <input type="hidden" name="user_group" id="user_group" class="form-control" value="10"/>
                </div>
              </div>
              
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>IC Number/Passport</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-5'>
                  <input class='form-control' id='ic_no' name='ic_no' placeholder='900909012112' type='text'>
                </div>
              </div>
              
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Nationality</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-4'>
                <select name='nationality_id' id='nationality_id' class="form-control">
						<?php
                        		$sql = "SELECT * FROM country";
                        		$result=dbQuery($sql);												
                                                                                
                        		if(dbNumRows($result)>0)
                        		{														
                        			while($row=dbFetchAssoc($result))
                        			{
                        				if($row[country_id]==$nationality_id)
										{
                       						 $cSelect="SELECTED";
                        				}
										else
										{
                        					$cSelect="";
                       					}
                        
										echo "<option value='$row[country_id]' $cSelect>$row[nationality_name]</option>";
                        			}
                        		}
                        ?>
                </select>
                </div>
              </div>
              
            </div>
          </div>
          
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments'>Address</label>
            <div class='col-md-6'>
              <textarea class='form-control' id='address1' name="address1" placeholder='Your Address' rows='3'></textarea>
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Postcode</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='postcode' name="postcode" placeholder='' type='text'>
                </div>
              </div>
              
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>City</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='city' name="city" placeholder='' type='text'>
                </div>
              </div>
              
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin'>State</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <select name='state_id' id='state_id' class="form-control">
						<?php
                        		$sql = "SELECT * FROM state";
                        		$result=dbQuery($sql);												
                                                                                
                        		if(dbNumRows($result)>0)
                        		{														
                        			while($row=dbFetchAssoc($result))
                        			{
                        				if($row[country_id]==$state_id)
										{
                       						 $cSelect="SELECTED";
                        				}
										else
										{
                        					$cSelect="";
                       					}
                        
										echo "<option value='$row[state_id]' $cSelect>$row[state_prefix] - $row[state_name]</option>";
                        			}
                        		}
                        ?>
                </select>
                </div>
              </div>
              <label class='control-label col-md-2' for='id_checkout'>Country</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <select name='country_id' id='country_id' class="form-control">
						<?php
                        		$sql = "SELECT * FROM country";
                        		$result=dbQuery($sql);												
                                                                                
                        		if(dbNumRows($result)>0)
                        		{														
                        			while($row=dbFetchAssoc($result))
                        			{
                        				if($row[country_id]==$country_id)
										{
                       						 $cSelect="SELECTED";
                        				}
										else
										{
                        					$cSelect="";
                       					}
                        
										echo "<option value='$row[country_id]' $cSelect>$row[prefix_name] - $row[country_name]</option>";
                        			}
                        		}
                        ?>
                </select>
                </div>
              </div>
            </div>
          </div>
          
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Mobile Phone</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='tel' name="tel" placeholder='' type='text'>
                </div>
              </div>
              
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Email</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='email' name="email" placeholder='' type='text'>
                </div>
              </div>
              
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Bank</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
                  <select name='bank_id' id='bank_id' class="form-control">
						<?php
                        		$sql = "SELECT * FROM bank order by bank_name";
                        		$result=dbQuery($sql);												
                                                                                
                        		if(dbNumRows($result)>0)
                        		{														
                        			while($row=dbFetchAssoc($result))
                        			{
                        				if($row[bank_id]==$bank_id)
										{
                       						 $cSelect="SELECTED";
                        				}
										else
										{
                        					$cSelect="";
                       					}
                        
										echo "<option value='$row[bank_id]' $cSelect>$row[bank_name]</option>";
                        			}
                        		}
                        ?>
                </select>
                </div>
              </div>
              
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Bank Account Number</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='bank_account_no' name="bank_account_no" placeholder='' type='text'>
                </div>
              </div>
              
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments'>Remark</label>
            <div class='col-md-6'>
              <textarea class='form-control' id='remark' name="remark" placeholder='Remark' rows='3'></textarea>
            </div>
          </div>
          
          <div class='form-group'>
          </div>
          
          <h4>New Order</h4>
          
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Order Date</label>
            <div class='col-md-6'>
            <?php echo date('d-m-Y'); ?>             
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Delivery Method</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
					<input name="courier_sw" id="courier_sw" type="radio" value="0" checked="checked"/> 
                    Pickup &nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="courier_sw" id="courier_sw" type="radio" value="1"  />
                    Courier
                </div>
              </div>
              
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Payment Method</label>
            <div class='col-md-6'>
            
              <div class='form-group'>
                <div class='col-md-11'>
                    <input name="paid_by_ewallet_sw" id="paid_by_ewallet_sw" type="radio" value="0" checked="checked"/> 
                    Cash &nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="paid_by_ewallet_sw" id="paid_by_ewallet_sw" type="radio" value="1"  />
                    eWallet
                </div>
              </div>
              
            </div>
          </div>
          
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>Delivery Address</label>
            <div class='col-md-6'>
              <textarea class='form-control' id='so_address' placeholder='Your Address' rows='3'></textarea>
              <input type="hidden" class="form-control" id="customer_id" name="customer_id"  value="<?php echo $user_data['user_id']; ?>" />
              <input type="hidden" class="form-control" id="so_customer_name" name="so_customer_name"  value="<?php echo $user_data['name']; ?>" />
            </div>
          </div>
          
                    <div class="form-group">
                            <div class="col-sm-1">  
                            </div>
                            <div class="col-sm-9">       
                                            
                            <table border="1" class="table table-bordered">
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th style="width: 40px">Quantity</th>
                            </tr>
                    
							<?php
                            	$sql = "SELECT *FROM product where active_sw = 1 order by product_id";
                           		$result=dbQuery($sql);
								
                            		if(dbNumRows($result)>0)
                            		{
                                                                                
                            			$x = 1;   
                            			$total_product = dbNumRows($result);
                                                              
                            			echo "<input type='hidden' name='total_product' id='total_product' class='form-control' value=".$total_product." />";
                                                               
                            				while($row=dbFetchAssoc($result))
                            				{
                            ?>
                            <tr>
                            <td><?php echo $x; echo "<input type='hidden' name='product_id$x' id='product_id$x' class='form-control' value=".$row[product_id]." />"; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['selling_price']; ?></td>
                            <td><?php  echo "<input type='text' name='product_qty$x' id='product_qty$x' class='form-control' />"; ?></td>
                            </tr>
                            
							<?php 
                           					$x++;
                           			 		}
                            		}
                                                                    
                            ?>
                            </table>
                            
            <div class='form-group'>
            	<div class='col-md-offset-4 col-md-3'>
            		<button class='btn-lg btn-primary' type='submit'>Submit</button>
            	</div>
            	<div class='col-md-3'>
            		<button class='btn-lg btn-danger' style='float:right' type='submit'>Cancel</button>
            	</div>
            </div>

                                            	</div>
                                            </div>
                                        </div>              
        </form>
      </div>
    </div>
  </div>
</body>