<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
//include "../main/session.php";
include "../main/functions.php";

include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";

header("Access-Control-Allow-Origin: *");

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  case 'add' :
    add();
    break;

  case 'add2' :
    add2();
    break;
			

  case 'update' :
    update();
    break;

  case 'approveUser' :
    approveUser();
    break;
				
  case 'delete' :
    delete();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
  }
 
 
function add2()
{
		
		
		$json = $_POST['mydata'];
		$dataA = json_decode($json);
		
		$jsonB = $_POST['mydataB'];
		$dataB = json_decode($jsonB);
		//$so_country = $dataB[so_country];
		$qty_validation_ok = 0;
		
	
		foreach($dataB  as $product) {		
				
				//$so_customer_name= $product->so_customer_name;
				//$customer_id= $product->customer_id;
				$sponsor_member_reg_no = $product->sponsor_member_reg_no;
				//$so_address= $product->so_address;
				//$so_city= $product->so_city;
				//$so_postcode= $product->so_postcode;
				//$so_state= $product->so_state;
				//$so_country= $product->so_country;
				//$total_product= $product->total_product;
				//$courier_sw= $product->courier_sw;
				//$paid_by_ewallet_sw= $product->paid_by_ewallet_sw;
				$name = $product->name;
				$ic_no = '';
				$nationality_id = 1;
				$address1 = $product->address1;
				$postcode = $product->postcode;
				$city = $product->city;
				$state_id = $product->state_id;
				$country_id = $product->country_id;
				$tel = $product->tel;
				$email = $product->email;
				//$bank_id = $product->bank_id;
				//$bank_account_no = $product->bank_account_no;
				//$user_name = $product->user_name;
				$user_name = '';
				$bank_id = 0;
				$bank_account_no = '';		
		
		}

		$random_password = createRandomPassword();
		$password = md5($random_password);
		$temp_password = $random_password;
		
		$data_country = getCountry($country_id);
		$country_name = $data_country['country_name'];
		$prefix_name = $data_country['prefix_name'];		
		
		$member_reg_no = ($prefix_name);
		$characters = array_merge(range('0','9'));
		for ($i = 0; $i < 7; $i++) {
			$rand = mt_rand(0, count($characters)-1);
			$member_reg_no .= $characters[$rand];
		}  
			
							
		$validate_total_amount = 0;
		
		foreach($dataA  as $product) {			
						
			//$total_product= $product->total_product;
			$product_id = $product->product_id;
			$product_qty = $product->product_qty;	




										
			if($product_qty > 0) {
				$qty_validation_ok = 1;
				
				$productData = getProductDetail($product_id);
				$unit_price = $productData[selling_price];
				$unit_price_with_gst = $productData[unit_price_with_gst];
				$amount = $unit_price * $product_qty;		
				$validate_total_amount = $validate_total_amount + $amount;		
			}
			
		}
		


		$memberData = getUserDetailByMemberRegNo($member_reg_no);
		$customer_id = $memberData[user_id];
		$so_customer_name = $memberData[name]; 
		$upline_id_all = $memberData[upline_id_all];
		
		$wallet_balance = walletAvailableBalance($customer_id);
						
						
		if(checkMemberRegNo($sponsor_member_reg_no) or $sponsor_member_reg_no == '')
		{
			if($qty_validation_ok == 1) {
				
				if($paid_by_ewallet_sw == 0 or ($paid_by_ewallet_sw == 1 and $wallet_balance > $validate_total_amount)) {
				
					if($courier_sw == 0 or ($courier_sw == 1 and $so_address != '')) {
	

						if($courier_sw == 0) {
							$so_address = 'Pick Up';
						}
						

		
						if ($sponsor_member_reg_no == ''){
		
							$current_manager_id = getCurrentManagerID();
							$upline_id = getManagerUserID($current_manager_id);
							
							$data_sponsor = getUserDetail($upline_id);
							$sponsor_member_reg_no = $data_sponsor['member_reg_no'];
							
							updateCurrentManagerID($current_manager_id);
							//$upline_id = 2;
							
						}else{

							$memberData = getUserDetailByMemberRegNo($sponsor_member_reg_no);
							$upline_id = $memberData[user_id];
								
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
										SET u_id='$u_id', upline_id_all = '$new_upline_id_all',upline_id2='$upline_id2', upline_id3='$upline_id3',upline_id4='$upline_id4',modified_by = 0
										where user_id = $new_user_id
										";
								dbQuery($sql);	
								
								
								addBeginningBalance($new_user_id);
								
								//$dataMessage = getMessageTemplate('newmember');
								//$message_subject = $dataMessage[message_subject];
								//$message_content = $dataMessage[message_content];
								//$message_footer = $dataMessage[message_footer];
								$attachment_path = '';
								
								
								insertEmailSend('pendingmember', $attachment_path, $new_user_id, 0, '');
								

								//$so_id = addSaleOrder($customer_id, $so_customer_name, $so_address, $courier_sw, $courier_amount, $paid_by_ewallet_sw,$upline_id_all);
								$courier_sw = 1;
								$courier_amount =0;
								$paid_by_ewallet_sw =0;
								

								$current_so_no = getCurrentSoNo();
								$so_no = 'P' . $current_so_no;
								
								$next_so_no = $current_so_no + 1;
								updateCurrentSoNo($next_so_no);
								
														
								$so_id = addSaleOrder($new_user_id, $name, $address1, $courier_sw, $courier_amount, $paid_by_ewallet_sw,$upline_id_all, $so_no);
								
								
								$total_weight_in_gram = 0;
								$total_pv = 0;
								
								$dataCompanySetup = getCompanySetupDetailForm(1);
								$gst_sw = $dataCompanySetup['gst_sw'];
								
								foreach($dataA  as $product) {			
										
									//$total_product= $product->total_product;
									$product_id = $product->product_id;
									$product_qty = $product->product_qty;
									
									
									if($product_qty > 0) {
										
										$productData = getProductDetail($product_id);
										$product_code = $productData[product_code];
										$product_name = $productData[product_name];
										$unit_price = $productData[selling_price];
										
										if($gst_sw == 0)
										{
											$tax_percentage = 0;
											$unit_price_with_gst = $productData[selling_price];
											$tax_amount = 0;
											$amount = $unit_price * $product_qty;
										}
										else
										{
											$tax_percentage = $productData[gst_rate];	
											
											if($tax_percentage > 0)
											{
												$tax_percentage = $tax_percentage / 100;
											}
											
											$unit_price_with_gst = $unit_price + ($unit_price * $tax_percentage);
											$amount = $unit_price_with_gst * $product_qty;
										}
										
										$product_weight = $productData[weight_in_gram];
										$product_pv = $productData[point_value];
										$product_bonus_pool = $productData[bonus_pool];
										$product_cost = $productData[cost_of_good_sold];
										
										
										$order_pv = $product_pv * $product_qty;
										
										$total_weight = $product_weight * $product_qty;
										//$total_weight_in_gram = $total_weight_in_gram + $total_weight;
										
										//$total_pv = $total_pv + $order_pv;
										
										//add sorder detail data
										addSaleOrderDetail($so_id, $product_id, $product_code, $product_name, $unit_price, $tax_percentage, $unit_price_with_gst, $product_qty, $amount, $product_weight, $total_weight, $product_pv, $order_pv, $product_bonus_pool, $product_cost);
										
										
									}
						
										
								}	
								
								$orderTotalData = getSaleOrderTotal($so_id);
								$total_amount = $orderTotalData[total_amount];
								$total_pv = $orderTotalData[total_pv];
								$total_weight_in_gram = $orderTotalData[total_weight_in_gram];
								$total_amount_before_tax = $orderTotalData[total_amount_before_tax];
								$total_tax_amount = $orderTotalData[total_tax_amount];
								
				
								if($courier_sw == 1) {
									$courier_amount = getDeliveryCharge($total_weight_in_gram);
									
									if($gst_sw == 1) {
										$tax_default = $dataCompanySetup['gst_rate'];
										$courier_amount = $courier_amount + ($courier_amount * $tax_default / 100);
										
										
									}									
											
								}else{
									$courier_amount = 0;
								}
								
								$total_amount = $total_amount + $courier_amount;
								
								if($paid_by_ewallet_sw == 1)  { //use ewallet to deduct sorder
								
									$trans_description = "Sales Order ID: " . $so_no;
									$trans_datetime = date("Y-m-d H:i:s");
									
									$ewallet_id = wallet('acct_ewallet', 11, $customer_id, $trans_description, 0, $total_amount, '', $trans_datetime, 0, 0, $so_id);
									
								}
								
										
								
								$reportName = uniqid() . '-' . $so_id;
								
								updateSaleOrder($so_id, $address1, $total_weight_in_gram, $courier_sw, $courier_amount, $total_pv, $reportName, $total_amount_before_tax, 0, $total_tax_amount, $total_amount, $ewallet_id);
								
								updateSaleOrderStatus($so_id, 1);
								
								saveReport($so_id,$reportName, 'sorder', $id);
								
								$file_name = $reportName . '.pdf';
								insertEmailSend('pendingorder', $file_name, $customer_id, 0);
								
								
								
								$customerSW = 1;

								
								//sucess show added message
								$displayMsg = "";
								$jsonArray= array('id' => $so_no,'success' => 1, 'displayMsg' => $displayMsg, 'customerSW' => $customerSW); 
								echo json_encode($jsonArray);
								//header("Location: redirect.php");
								
								//header('Location: http://google.com');  	  										
								//header("Location: index.php?view=add");
																				
								
			
							}
							else
							{
							//sucess show updated message
							$displayMsg = "User Need Approved by Admin First";
							$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
							echo json_encode($jsonArray);	
							}
						
						}else{
							//sucess show updated message
							$displayMsg = "Sponsor Member ID Not Found!";
							$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
							echo json_encode($jsonArray);					
						}
								

										
					}else{
	
						//show error message
						$displayMsg = "Delivery Address is required for courier service";
						$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
						echo json_encode($jsonArray);						
					}
				
				}else {
					
					//show error message
					$displayMsg = "Your ewallet is not enough for this purchase";
					$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
					echo json_encode($jsonArray);						
				}
		
			
			}else{
				//show error message
				$displayMsg = "Total Quantity can't be 0";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);				
			}
			



		}
		else
		{
			//show error message
			$displayMsg = "Member Reg No not found!";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
}
  
  
function add($name,$ic_no, $nationality_id, $address1,$postcode, $city, $state_id ,$country_id ,$tel, $email, $bank_id, $bank_account_no, $user_name)
{
		/**
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
		**/
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
		
		$login_id = $_SESSION['user_id'];
		if($login_id == '')
		{
			$login_id = 0;
		}
		
		if($name!="") {

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
								SET u_id='$u_id', upline_id_all = '$new_upline_id_all',upline_id2='$upline_id2', upline_id3='$upline_id3',upline_id4='$upline_id4',modified_by = '$login_id'
								where user_id = $new_user_id
								";
						dbQuery($sql);	
						
						//$dataMessage = getMessageTemplate('newmember');
						//$message_subject = $dataMessage[message_subject];
						//$message_content = $dataMessage[message_content];
						//$message_footer = $dataMessage[message_footer];
						$attachment_path = '';
						
						
						insertEmailSend('pendingmember', $attachment_path, $new_user_id, 0, '');
						
																		
						
						//sucess show updated message
						$displayMsg = "added";
						$jsonArray= array('id' => $u_id,'success' => 1, 'displayMsg' => $displayMsg); 
						echo json_encode($jsonArray);	
					}
					else
					{
					//sucess show updated message
					$displayMsg = "User Need Approved by Admin First";
					$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
					echo json_encode($jsonArray);	
					}
				
				}else{
					//sucess show updated message
					$displayMsg = "Sponsor Member ID Not Found!";
					$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
					echo json_encode($jsonArray);					
				}
				
			} else 
			{

				$displayMsg = "Sorry this user name has be taken!";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);	
								
			}


		}
		else
		{
			//show error message
			$displayMsg = "Missing Info";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function update()
{
		$id = $_GET['id'];
		
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
		$password = md5($_POST[password]);
		$temp_password = $_POST[password];
		$user_group = $_POST[user_group];
		$remark = $_POST[remark];
		
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
		
	if($id != '')
	{
		
		//update database
		updateUserRegistrationDetail($id, $name, $ic_no, $nationality_id, $nationality_name, $address1, $postcode, $city, $state_id, $state_prefix, $country_id, $country_name, $prefix_name, $tel, $email, $bank_id, $bank_name, $bank_swift_code, $bank_account_no, $user_name, $password, $temp_password, $user_group, $remark);
		
		
		//sucess show updated message
		$displayMsg = "updated";
		$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);				
	}
	else
	{
		//show error message
		$displayMsg = "Missing Info";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);			
	}
	
}


function approveUser()
{
	$id = $_GET['id'];
	
	if($id != '')
	{

 		$data = getNewUserDetail($id);	
		$user_id = $data[user_id];

		
		if($data[status_id] == 0) {

			
			updateUserStatus($user_id, 1);
			insertEmailSend('newmember', $attachment_path, $user_id, 0, $data['temp_password']);
			
			
			//sucess show updated message
			$displayMsg = "updated";
			$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
					
		} else { 
		
			//show error message
			$displayMsg = "Status Error while processing. Please refresh your page and try again";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);			
		}
		
		
				
	}
	else
	{
		//show error message
		$displayMsg = "Missing Info";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);			
	}
	
}

function delete()
{
	$id = $_GET['id'];
	
	
	if($id != '')
	{

 		$data = getNewUserDetail($id);	
		$user_id = $data[user_id];
		$status_id = $data[status_id];
		
		if($status_id == 0) { 
			//update database
			deleteTableDetail('user', 'user_id', $user_id);

			//sucess show deleted message
			$displayMsg = "deleted";
			//$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			//echo json_encode($jsonArray);
			header("Location: index.php?view=detail&id=$id&displayMsg=$displayMsg");	
					
		}else{
			
			//show error message
			$displayMsg = "You only can delete pending member only";
			$jsonArray= array('id' => $id,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);			
			
		}
		
		
		
			
	}
	else
	{
		//show error message
		$displayMsg = "Missing Info";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);			
	}
	
}

function cancelPage()
{
  if($_POST)
  {
    header("Location: index.php?view=list");
  }
}


?>
