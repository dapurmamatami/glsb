<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../main/session.php";
include "../main/functions.php";


$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  
  case 'add' :
    adduser();
    break;

  case 'update' :
    updateUser();
    break;
		
  case 'approve' :
    approveUser();
    break;		

  case 'reSend' :
    reSend();
    break;
			
  case 'resetPassword' :
    resetPassword();
    break;		

  case 'searchGenealogy' :
    searchGenealogy();
    break;			
	
  case 'freeUpgrade' :
    freeUpgrade();
    break;	
	
  case 'stockistUpgrade' :
    stockistUpgrade();
    break;		

  case 'oneTimePowerLeg' :
    oneTimePowerLeg();
    break;			  
				
  case 'delete' :
    deleteUser();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
  }
 
function reSend()
{

	$id = $_GET['id'];
	
	$temp_password = createRandomPassword();
	$password = md5($temp_password);	
	$hpSend = getCode('user', 'hpSend', 'u_id', $id);
	
	//send sms
	if($hpSend != '')
	{
		require_once ("../sendsms/sms_send_include.php");
		
		$sql = "UPDATE user
				SET password = '$password',temp_password = '$temp_password',
				modified_by = $_SESSION[user_id]
				WHERE u_id = '$id'
			   ";
		dbQuery($sql);
		
		$user_name = getCode('user', 'user_name', 'u_id', $id);
				
		$mysms = new sms();
		echo $mysms->session;
		$smsDescrption = 'RBS Network. Kata Laluan Baru Untuk ID ' . $user_name .  ' ialah ' . $temp_password .
						 'Sila Layari www.rbsnet.biz';
		$APIresponse = $mysms->send ($hpSend, "rbs", "$smsDescrption", "0", "dipping");										

		$displayMsg = "updated";
		$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); //*1 value is named LastID
		echo json_encode($jsonArray);																					
	}
	else
	{
		$displayMsg = "You need to input mobile phone in order to resend temporary password";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
		echo json_encode($jsonArray);				
	}			
}

function stockistUpgrade()
{
	require_once ("../sendsms/sms_send_include.php");
	
	$user_name = mysql_escape_string($_POST[user_name]);
	$pkg_id = $_POST[pkg_id];
	//$change_date = date("Y-m-d", strtotime($_POST['change_date']));
	$change_date = date("Y-m-d");
	$change_datetime = date("$change_date H:i:s");
	
	$user_id = getCode('user', 'user_id', 'user_name', $user_name);
	$user_placement_side = getCode('user', 'placement_side', 'user_name', $user_name);
	//$country_id = getCode('user', 'country_id', 'user_name', $user_name);
	$hpSend = getCode('user', 'hpSend', 'user_name', $user_name);

	
	$product_qty = getCode('product_package', 'product_qty', 'pkg_id', $pkg_id);
	$product_id1 = $_POST[product_id1];
	$product_id2 = $_POST[product_id2];
	$product_id3 = $_POST[product_id3];
	$product_id4 = $_POST[product_id4];
	
	$product_qty1 = $_POST[product_qty1];
	$product_qty2 = $_POST[product_qty2];
	$product_qty3 = $_POST[product_qty3];
	$product_qty4 = $_POST[product_qty4];
  
    $qty_select = $product_qty1 + $product_qty2 + $product_qty3 + $product_qty4;	
	
  	if($user_id > 1)
	{

		if(checkTotalQty($pkg_id, $product_qty, $qty_select))
		{		
			$sponsor_id = getCode('user', 'sponsor_id', 'user_name', $user_name);
			$upline_id = getCode('user', 'upline_id', 'user_name', $user_name);
			$original_pkg_id = getCode('user', 'pkg_id', 'user_id', $user_id);
			$original_pkg_name = getCode('user', 'pkg_name', 'user_id', $user_id);
			
			$state_id = getCode('user', 'state_id', 'user_id', $user_id);
			$west_sw = getCode('state', 'west_sw', 'state_id', $state_id);
				
			if($pkg_id > $original_pkg_id)
			{
	
				//$bonus = getCode('product_package', 'sponsor_bonus', 'pkg_id', $pkg_id);
				//$pkg_name = getCode('product_package', 'pkg_name', 'pkg_id', $pkg_id);
				//$pkg_point = getCode('product_package', 'pkg_point', 'pkg_id', $pkg_id);
				//$pkg_price = getCode('product_package', 'pkg_price', 'pkg_id', $pkg_id);
				//$stockist_commission = getCode('product_package', 'stockist_commission', 'pkg_id', $pkg_id);
				$checkProduct = checkPkgPrice($pkg_id, $west_sw);
				$pkg_price = $checkProduct['pkgPrice'];
				$bonus = $checkProduct['sponsorBonus'];
				$pkg_point = $checkProduct['pkgPoint'];
				$pkg_name = $checkProduct['pkgName'];
				$stockist_commission = $checkProduct['stockistCommission'];
											
				$stockist_pkg_price = $pkg_price - $stockist_commission;
										
				if(walletBalance('acct_rwallet', $_SESSION['user_id']) >= $stockist_pkg_price)
				{			
					$change_id = user_pkg_change($user_id, $original_pkg_id, $pkg_id, 0, $change_date, $change_datetime, 0);
	
					$rwallet_id = package_calc($user_name, $stockist_pkg_price, $pkg_name, $sponsor_id, $upline_id, $bonus, 0,$user_placement_side,$pkg_point, $change_datetime, $change_date, $hpSend);
					
					
					for ($x = 1; $x <= 4; $x++) 
					{
						$product_id = ${'product_id' . $x};
						$quantity = ${'product_qty' . $x};
						if($quantity > 0)
						{
							insertProductSelect($user_id, $product_id, $quantity, $change_date, 0, $change_datetime, $rwallet_id, 'Purchase From R-Wallet');
						}
									
									
					}					
					
					changeStatus('user_pkg_change', 'change_id', $change_id, 'status_id', 1);
					
					$displayMsg = "updated";
					$jsonArray= array('id' => 0,'success' => 1, 'displayMsg' => $displayMsg);
					echo json_encode($jsonArray);			
				}
				else
				{
					$displayMsg = "Sorry your R-Wallet not enought to this stockist upgrade";
					$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg);
					echo json_encode($jsonArray);				
				}
			}
			else
			{
				$displayMsg = "You have to upgrade higher package for this user. Original Package for this user is:" . $original_pkg_name;
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg);
				echo json_encode($jsonArray);		
			}
		
		}
		else
		{
				$displayMsg = "Total Quantity you input is " . $qty_select . ". Total product you can choose for this package is " . $product_qty;
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
				echo json_encode($jsonArray);				
		}
	}
	
	else
  	{
		$displayMsg = "Can't find this user";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg);
		echo json_encode($jsonArray);
  	}	
	
	
}
  
function freeUpgrade()
{
	$user_name = mysql_escape_string($_POST[user_name]);
	$pkg_id = $_POST[pkg_id];
	
	$user_id = getCode('user', 'user_id', 'user_name', $user_name);
	$change_date = date("Y-m-d");
	//$change_date = date("Y-m-d", strtotime($_POST['change_date']));
	$change_datetime = date("$change_date H:i:s");	
	
  	if($user_id > 1)
	{
		
		$original_pkg_id = getCode('user', 'pkg_id', 'user_id', $user_id);
		$original_pkg_name = getCode('user', 'pkg_name', 'user_id', $user_id);
		
		if($pkg_id > $original_pkg_id)
		{
			$change_id = user_pkg_change($user_id, $original_pkg_id, $pkg_id, 1, $change_date, $change_datetime, 0);
			changeStatus('user_pkg_change', 'change_id', $change_id, 'status_id', 1);
			
			$displayMsg = "updated";
			$jsonArray= array('id' => 0,'success' => 1, 'displayMsg' => $displayMsg);
			echo json_encode($jsonArray);			
		}
		else
		{
			$displayMsg = "You have to upgrade higher package for this user. Original Package for this user is:" . $original_pkg_name;
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg);
			echo json_encode($jsonArray);		
		}
		

	}
	
	else
  	{
		$displayMsg = "Can't find this user";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg);
		echo json_encode($jsonArray);
  	}	
	
	
}

   

function addUser()
{

	require_once ("../sendsms/sms_send_include.php");
    $remark = $_POST[remark];
	
	$placement_side = $_POST[placement_side];
	$pkg_id = $_POST[pkg_id];
	$user_name = mysql_escape_string($_POST[user_name]);
	$sponsor_user_name = mysql_escape_string($_POST[sponsor_user_name]);
	$upline_user_name = mysql_escape_string($_POST[upline_user_name]);
	$name = mysql_escape_string($_POST[name]);
	$id_no = mysql_escape_string($_POST[id_no]);
	$email = mysql_escape_string($_POST[email]);
	$address1 = mysql_escape_string($_POST[address1]);
	$city = mysql_escape_string($_POST[city]);
	$postcode = mysql_escape_string($_POST[postcode]);
	$state_id = $_POST[state_id];
	$country_id = $_POST[country_id];
	//$tel = mysql_escape_string($_POST[tel]);
	$hp = mysql_escape_string($_POST[hp]);
	$bank_id = $_POST[bank_id];
	//$bank_name = mysql_escape_string($_POST[bank_name]);
	$bank_account_holder = mysql_escape_string($_POST[bank_account_holder]);
	$bank_account_no = mysql_escape_string($_POST[bank_account_no]);
	
	//$upline_id = $_POST[upline_id];
	$auto_assign_user_name = 1;
	
	
	$west_sw = getCode('state', 'west_sw', 'state_id', $state_id);

	if($hp <> '')
	{
		$hpSend = $country_id . $hp;
	}
	else
	{
		$hpSend = '';
	}
  //$password = generateRdmPass(8);
  	$upline_id = getCode('user', 'user_id', 'user_name', $upline_user_name);
	$sponsor_id = getCode('user', 'user_id', 'user_name', $sponsor_user_name);
	$orginal_upline_id = $upline_id;
	
	$upline_level_name = getCode('user', 'level_name', 'user_name', $upline_user_name);
	
	//$upline_status_id = getCode('user', 'status_id', 'user_id', $upline_id);
	$sponsor_join_date = getCode('user', 'join_date', 'user_id', $sponsor_id);
	$sponsor_pkg_id = getCode('user', 'pkg_id', 'user_id', $sponsor_id);
	
	$pkg_name = mysql_escape_string(getCode('product_package', 'pkg_name', 'pkg_id', $pkg_id));
	$pkg_point = getCode('product_package', 'pkg_point', 'pkg_id', $pkg_id);
	$product_qty = getCode('product_package', 'product_qty', 'pkg_id', $pkg_id);


	$product_id1 = $_POST[product_id1];
	$product_id2 = $_POST[product_id2];
	$product_id3 = $_POST[product_id3];
	$product_id4 = $_POST[product_id4];
	
	$product_qty1 = $_POST[product_qty1];
	$product_qty2 = $_POST[product_qty2];
	$product_qty3 = $_POST[product_qty3];
	$product_qty4 = $_POST[product_qty4];
  
    $qty_select = $product_qty1 + $product_qty2 + $product_qty3 + $product_qty4;
	
	
	//$join_date = date("Y-m-d", strtotime($_POST['join_date']));
	$join_date = date("Y-m-d");
	$join_datetime = date("$join_date H:i:s");

  	$sql = "SELECT bank_account_no
          FROM user
          WHERE bank_account_no = '$bank_account_no' and bank_account_no <> ''
		  limit 1
         ";
  	$resultCheckBankAccountNo=dbQuery($sql);


	
  	if($upline_id !="")
  	{
		
		if(dbNumRows($resultCheckBankAccountNo)==0)
		{		
				if(checkLastDate($join_date))
				{
					
					if($sponsor_id !="")
					{					
						
						if(checkTotalQty($pkg_id, $product_qty, $qty_select))
						{
							if($auto_assign_user_name == 1)
							{
								//$user_name = getID('user_name');
								//updateID('user_name', $user_name);
								$user_name = 'RBS' . mt_rand(100000, 999999);
								
								if(checkUserName($user_name))
								{
									do
									{
									$user_name = 'RBS' . mt_rand(100000, 999999);
									}
									while (!checkUserName($user_name));
								}
				
							}
							else
							{
								$user_name = $_POST[user_name];
							}
							
							
							if(!checkUserName($user_name))
							{			
								if(checkValidUpline($upline_id, $sponsor_id))
								{
									//check downline left & right
									if(!checkUserPlacement($upline_user_name, $placement_side))
									{	
				
										$temp_password = createRandomPassword();
										$password = md5($temp_password);		
										$level_name = $upline_level_name + 1;
				
										//$bonus = getCode('product_package', 'sponsor_bonus', 'pkg_id', $pkg_id);
										//$pkg_point = getCode('product_package', 'pkg_point', 'pkg_id', $pkg_id);
			
										$checkProduct = checkPkgPrice($pkg_id, $west_sw);
										$pkg_price = $checkProduct['pkgPrice'];
										$bonus = $checkProduct['sponsorBonus'];
										$pkg_point = $checkProduct['pkgPoint'];
										$pkg_name = $checkProduct['pkgName'];
										$stockist_commission = $checkProduct['stockistCommission'];
										
						
										
										//$stockist_commission = getCode('product_package', 'stockist_commission', 'pkg_id', $pkg_id);
										$stockist_pkg_price = $pkg_price - $stockist_commission;
										
										if(walletBalance('acct_rwallet', $_SESSION['user_id']) >= $stockist_pkg_price or $_SESSION['user_grp']==1)
										{
														
											if($_SESSION['user_grp']==1)
											{
												$free_lot_sw = 1;
											}
											else
											{
												$free_lot_sw = 0;
											}
				
											
											$sql = "INSERT INTO user(name, user_name,user_group, join_date,join_datetime, password,
														 temp_password, remark, id_no, email, address1, 
														 city, postcode, state_id, country_id, hp, hpSend, upline_id,upline_user_name, placement_side,
														 sponsor_id,sponsor_user_name, level_name, pkg_id, pkg_name, free_lot_sw, bank_id, bank_account_holder, bank_account_no,
														 created_by, created_date)
														VALUES('$name', '$user_name', 3, '$join_date','$join_datetime', '$password', '$temp_password', '$remark', '$id_no', '$email', '$address1', 
														'$city', '$postcode', '$state_id', '$country_id', '$hp', '$hpSend', '$upline_id', '$upline_user_name',
														'$placement_side',
														'$sponsor_id', '$sponsor_user_name', $level_name,$pkg_id, '$pkg_name','$free_lot_sw','$bank_id','$bank_account_holder','$bank_account_no',
														$_SESSION[user_id], NOW())
													 ";
											dbQuery($sql);
											$new_user_id = mysql_insert_id();
											
				
											
											
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
															SET u_id='$u_id', upline_id_all = '$new_upline_id_all',upline_id2='$upline_id2', upline_id3='$upline_id3',
															upline_id4='$upline_id4',
															modified_by = $_SESSION[user_id]
															where user_id = $new_user_id
														 ";
											dbQuery($sql);	
																		
											
											if($upline_id <> 1)
											{
												/**
												$sql = "UPDATE user
																SET upline_id_all = concat(upline_id_all, ',', '$new_user_id'),
																modified_by = $_SESSION[user_id]
																where find_in_set( $upline_id, upline_id_all ) and user_group <> 1
															 ";
												dbQuery($sql);	
												**/		
											}	
											
				
											if($_SESSION['user_grp']!=1)
											{
												//calc package
												$rwallet_id = package_calc($user_name, $stockist_pkg_price, $pkg_name, $sponsor_id, $upline_id, $bonus, 1, $placement_side,$pkg_point, $join_datetime, $join_date, $hpSend);
											
											
												
											}
											else
											{
												$rwallet_id = 0;
												$product_select_remark = 'From Free Lot';
											}
											
											
											for ($x = 1; $x <= 4; $x++) 
											{
												$product_id = ${'product_id' . $x};
												$quantity = ${'product_qty' . $x};
												if($quantity > 0)
												{
													insertProductSelect($new_user_id, $product_id, $quantity, $join_date, 1, $join_datetime, $rwallet_id, $product_select_remark);
												}
												
												
											}
											
											
											//update last date							
											updateLastDate('last_date', $join_date);
											
											// to confirm all script has been run for all calculation
											$sql = "UPDATE user
													SET status_id = 1
													where user_id = $new_user_id
													";
											dbQuery($sql);							
											
											
											
											//send email
											if($email != '')
											{
												//sendPassword($email, $temp_password);
											}
											
											
											//send sms
											if($hpSend != '')
											{
												$mysms = new sms();
												echo $mysms->session;
												/**
												$smsDescrption = 'Selamat Datang ke RBS Network' . '</br>' .
																 'UserName: ' . $user_name . '</br>' .
																 'Password: ' . $temp_password . '</br>' .
																 'Package: ' . $pkg_name . '</br>' .
																 'Sila layari www.rbsnet.biz' . '</br>' .
																 'T.Kasih';
											    **/
												$smsDescrption = 'Selamat Datang ke RBS Network' . ' ' .
																 'UserName: ' . $user_name . ' ' .
																 'Password: ' . $temp_password . ' ' .
																 'Package: ' . $pkg_name . ' ' .
																 'Sila layari www.rbsnet.biz' . ' ' .
																 'T.Kasih';												
												$APIresponse = $mysms->send ($hpSend, "rbs", "$smsDescrption", "0", "dipping");										
												//echo $APIresponse;											
											}									
		
											
											
											$displayMsg = "added";
											$jsonArray= array('id' => $u_id,'success' => 1, 'displayMsg' => $displayMsg); //*1 value is named LastID
											echo json_encode($jsonArray);	  
											//exit;
											//header('Location: index.php?view=detail&id='.$mid);
											//echo "success";							
										}
										else
										{
				
											$displayMsg = 'Sorry, not enough money on your E-Wallet for this package';
											$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
											echo json_encode($jsonArray);								
										}
				
											
				
								
									}
									else
									{
										$displayMsg = 'Sorry, this placement is not allow, someone has been placed in this position';
										$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
										echo json_encode($jsonArray);					
									}					
								}
								else
								{
									$displayMsg = 'Sponsor ID not belong to this group';
									$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
									echo json_encode($jsonArray);						
								}
								
				
							}
							else
							{
							
									$displayMsg = 'Duplicate User Name';
									$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
									echo json_encode($jsonArray);	
							}
						}
						else
						{
							$displayMsg = "Total Quantity you input is " . $qty_select . ". Total product you can choose for this package is " . $product_qty;
							$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
							echo json_encode($jsonArray);				
						}
					}
					else
					{
						$displayMsg = "Sponsor Code not found";
						$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
						echo json_encode($jsonArray);			
					}
				}
				else
				{
					$displayMsg = "Sorry, your join date can't be ealier than system join date";
					$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
					echo json_encode($jsonArray);			
				}
				
		}
		else
		{
			$displayMsg = "Duplicate Bank Account Number Found, you cannot input same bank account number twice";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
			echo json_encode($jsonArray);			
		}				
  	}
  	else
  	{
		$displayMsg = "Placement Code not found";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
		echo json_encode($jsonArray);
  	}
  
}



function checkTotalQty($pkg_id, $product_qty, $qty_select)
{
	
	if($qty_select == $product_qty)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function package_calc($user_name, $stockist_pkg_price, $pkg_name, $sponsor_id, $upline_id, $bonus, $new_register, $placement_side, $pkg_point, $trans_datetime, $trans_date, $hpSend)
{
								
								$customer_name = getCode('user', 'name', 'user_name', $user_name);
								
								if($new_register == 1)
								{
									//calculate sponsor bonus
									$bonus_type_id = 1;
									$bonus_description = mysql_escape_string('Sponsor Bonus. Downline: ' . $user_name . ', Package: ' . $pkg_name);	
									//deduct R-Wallet
									$deduct_description = 'New Registration: ' . $user_name . '[' . $customer_name .  '] - Package:' . $pkg_name; 
									$calc_power_leg_sw = 1;
								}
								else
								{
									$bonus_type_id = 6;
									$bonus_description = mysql_escape_string('Upgrade Bonus. Downline: ' . $user_name . ', Package: ' . $pkg_name);	
									//deduct R-Wallet
									$deduct_description = 'Upgrade: ' . $user_name . '[' . $customer_name .  '] - Package:' . $pkg_name; ; 			
									$calc_power_leg_sw = 0;					
								}
									
									
								$rwallet_id = wallet('acct_rwallet', 10, $_SESSION[user_id], $deduct_description, 0, $stockist_pkg_price, $user_name, $trans_datetime);							
				
								
								
								/**
								$sql = "INSERT INTO acct_ewallet(trans_date,type_id, user_id, trans_description, amount_in,
											 register_user_name, created_by, created_date)
											VALUES(NOW(), $type_id, '$sponsor_id','$bonus_description', '$sponsor_bonus',
											'$user_name', $_SESSION[user_id], NOW())
										 ";
								dbQuery($sql);
								**/
								if($sponsor_id > 1)
								{
									$hpSponsor = getCode('user', 'hpSend', 'user_id', $sponsor_id);	
									
																	

									wallet('acct_ewallet', $bonus_type_id, $sponsor_id, $bonus_description, $bonus, 0, $user_name, $trans_datetime);	
									
									//deduct 10%
									$deduct_bonus_description = '10% into M-Wallet';
									$deduct_bonus = $bonus * 0.1;
									
									wallet('acct_ewallet', 4, $sponsor_id, $deduct_bonus_description, 0, $deduct_bonus, $user_name, $trans_datetime);
									wallet('acct_mwallet', $bonus_type_id, $sponsor_id, $deduct_bonus_description, $deduct_bonus, 0, $user_name, $trans_datetime);	

									//send sms
									if($hpSponsor != '')
									{
										$sponsorUserName = getCode('user', 'user_name', 'user_id', $sponsor_id);
										$mysms = new sms();
										echo $mysms->session;
										$smsDescrption = 'RBS Network. Tahniah ' . $sponsorUserName . 
														 '.Sponsor Bonus (' . $user_name . ') RM' . $bonus;
										$APIresponse = $mysms->send ($hpSponsor, "rbs", "$smsDescrption", "0", "dipping");										
										//echo $APIresponse;											
									}
									
							
																	
								}

		
								//end of calculate sponsor bonus
								
								
								//calc power leg
								
								if($calc_power_leg_sw == 1)
								{
									$powerleg_bonus = getCode('commission_type', 'bonus_amount', 'type_name', 'Powerleg');
									$upline_upline_id = $upline_id;
					
									
									for ($x = 1; $x <= 10; $x++) 
									{
										
										if($upline_upline_id > 1)
										{
											$bonus_description = 'Powerleg Bonus. Level: ' . $x;
											
											wallet('acct_ewallet', 2, $upline_upline_id, $bonus_description, $powerleg_bonus, 0, $user_name, $trans_datetime);
				
											//deduct 10%
											$bonus_description = '10% into M-Wallet';
											$powerleg_deduct_bonus = $powerleg_bonus * 0.1;
											$type_id = 4;
											
											wallet('acct_ewallet', 4, $upline_upline_id, $bonus_description, 0, $powerleg_deduct_bonus, $user_name, $trans_datetime);
											wallet('acct_mwallet', 2, $upline_upline_id, $bonus_description, $powerleg_deduct_bonus, 0, $user_name, $trans_datetime);										
										}
										
	
																	
										
										
										$upline_upline_id = getCode('user', 'upline_id', 'user_id', $upline_upline_id);
										if($upline_upline_id == 0 or $upline_upline_id == '')
										{
											$x = 11;
										}
									} 									
										
								}
								

								
								
								//check pairing
								/**
								if(checkPairing($upline_user_name, $sponsor_user_name))
								{
									$sql = "SELECT GROUP_CONCAT( user_name ) as pairing_user_name
													FROM user
													WHERE upline_user_name = '$upline_user_name'
												 ";
									$result=dbQuery($sql);
									$row=dbFetchAssoc($result);
									$pairing_user_name = $row['pairing_user_name'];
															
									$bonus_description = 'Pairing Bonus: ' . $pairing_user_name;
									wallet('acct_ewallet', 3, $sponsor_id, $bonus_description, 15, 0, $user_name);
								}
								**/
													
					
		
		
								$last_upline_boolean = false;
								
								
								do
								{
									
									if($upline_id > 0)
									{
										$last_placement_side = $placement_side;
		
										$sql = "SELECT user_id, user_name, upline_id, placement_side, 
												total_left, total_right, pkg_id
														FROM user
														WHERE user_id = '$upline_id'
													 ";
										$result=dbQuery($sql);
										$row=dbFetchAssoc($result);
										$current_user_id = $row[user_id];
										$current_user_name = $row[user_name];
										$current_pkg_id = $row[pkg_id];
										$upline_id = $row[upline_id];								
										$total_left = $row[total_left];
										$total_right = $row[total_right];
																		
										if($last_placement_side == 'Left')
										{
											$total_total_left = $total_left + 1;
											
											if($new_register == 1)
											{
												$sql = "UPDATE user
																SET total_left ='$total_total_left', 
																modified_by = $_SESSION[user_id]
																where user_id = $current_user_id
															 ";
												dbQuery($sql);	
											}
											
									
											$sql = "INSERT INTO acct_point(point_date,point_datetime, user_id, user_name, left_point,
														 right_point,register_user_name, 
														 created_by, created_date)
														VALUES('$trans_date', '$trans_datetime', '$current_user_id','$current_user_name','$pkg_point', 0, 
														'$user_name',
														$_SESSION[user_id], NOW())
													 ";
											dbQuery($sql);																	
										}
										
										if($last_placement_side == 'Right')
										{
											$total_total_right = $total_right + 1;

											if($new_register == 1)
											{											
												$sql = "UPDATE user
																SET total_right ='$total_total_right', 
																modified_by = $_SESSION[user_id]
																where user_id = $current_user_id
															 ";
												dbQuery($sql);
											}
											
											$sql = "INSERT INTO acct_point(point_date, point_datetime, user_id,user_name, left_point,
														 right_point,register_user_name, 
														 created_by, created_date)
														VALUES('$trans_date', '$trans_datetime','$current_user_id','$current_user_name',0 , '$pkg_point', '$user_name', 
														$_SESSION[user_id], NOW())
													 ";
											dbQuery($sql);																		
										}
										
										//checkPairing
										//$join_date = date("Y-m-d");
										
										checkPairing($current_user_id, $current_user_name, $current_pkg_id, $trans_datetime, $trans_date, 0);
										
										
										$placement_side = $row[placement_side];
										
										$checkYear = date("Y");	
										$checkMonth = date("m");
										
										//check universal qualification
										$universal_date_from = '2016-01-01';
										$universal_date_to = '2016-04-30';
										
										$sql = "SELECT acct_mwallet.user_id, user.user_name, sum(amount_in) as total_in, sum(amount_out) as total_out,
												sum(amount_in) - sum(amount_out) as mBalance, total_monthly_universal_fulfill
												FROM acct_mwallet inner join user on user.user_id = acct_mwallet.user_id

												group by acct_mwallet.user_id
												having sum(amount_in) - sum(amount_out) >= 120
												";
										$resultCheck=dbQuery($sql);
										if(dbNumRows($resultCheck) > 0)
										{
											while($rowCheckUniversal=dbFetchAssoc($resultCheck))
											{
												$mBalance = $rowCheckUniversal[mBalance];
												$mUser_ID = $rowCheckUniversal[user_id];	
												$mUser_Name = $rowCheckUniversal[user_name];

												
												$sql = "SELECT * from user_pool where user_name = '$mUser_Name'
														and year(join_date) = '$checkYear' 
														and month(join_date) = '$checkMonth'
														";
												$resultCheckPool=dbQuery($sql);
												if(dbNumRows($resultCheckPool) > 0)
												{
													$total_monthly_universal_fulfill = dbNumRows($resultCheckPool);
												}
												else
												{
													$total_monthly_universal_fulfill = 0;
												}
																						
												$total_eligible = 0;
												
												
												if($mBalance < 240) 
												{
													$total_eligible = 1;
												}
												else if($mBalance < 360) 
												{
													$total_eligible = 2;
												}
												else
												{
													$total_eligible = 3;
												}
												
												
												switch ($total_monthly_universal_fulfill) {
													case "0":
															$total_eligible = $total_eligible;										
														break;
													case "1":
															if($total_eligible >= 2)
															{
																$total_eligible = 2;
															}
															else
															{
																$total_eligible = $total_eligible;	
															}
														break;
													case "2":
															$total_eligible = 1;										
														break;
													case "3":
															$total_eligible = 0;										
														break;																	
												}

												/**
												if($total_monthly_universal_fulfill >= 3 and $new_balance > 0)
												{
													//$adjust_amount = $new_balance - 360;
													$adjust_amount = $new_balance;
													
													//adjust balance 10%
													$bonus_description = 'Adjust Auto Maintain';
													//$powerleg_deduct_bonus = $powerleg_bonus * 0.1;
													
													wallet('acct_ewallet', 19, $mUser_ID, $bonus_description, $adjust_amount, 0, $mUser_Name, $trans_datetime);
													wallet('acct_mwallet', 19, $mUser_ID, $bonus_description, 0, $adjust_amount, $mUser_Name, $trans_datetime);												
													
												}
												**/
												
																					
												if($total_eligible > 0)
												{
													/**
													$new_total_monthly_universal_fulfill = $total_monthly_universal_fulfill + $total_eligible;
													
													$sql = "UPDATE user
																	SET total_monthly_universal_fulfill ='$new_total_monthly_universal_fulfill'
																	where user_id = $mUser_ID
																 ";
													dbQuery($sql);		
													**/										
													
													for ($i = 1; $i <= $total_eligible; $i++)
													{											
			
													
														//check who is the next for placement
														$sql = "SELECT * FROM `user_pool` where user_id not in 
														(select upline_id from user_pool) or user_id in 
														(select upline_id from user_pool group by upline_id 
														having count(upline_id) < 2)
														order by level_name asc limit 1
																";
														$resultCheckPlacement=dbQuery($sql);
														if(dbNumRows($resultCheckPlacement)>0)
														{
															$rowCheckPlacement=dbFetchAssoc($resultCheckPlacement);
															$new_upline_id = $rowCheckPlacement[user_id];	
															$new_upline_name = $rowCheckPlacement[user_name];
															$new_level_name = $rowCheckPlacement[level_name] + 1;
					
					
															//check which leg for the placement
															$sql = "SELECT * FROM user_pool where upline_id = $new_upline_id
																	and placement_side = 'Left'
																	";
															$resultCheckLeg=dbQuery($sql);
															if(dbNumRows($resultCheckLeg)>0)
															{
																$new_placement_side = 'Right';
																
															}
															else
															{
																$new_placement_side = 'Left';
															}
																																	
														}
														else
														{
															$new_upline_id = 0;
															$new_upline_name = '';
															$new_level_name = 1;
														}
						

														//deduct mwallet 120
														$bonus_description = 'M-Wallet 120 Deduct';
														$deduct_bonus = 120;
														$type_id = 4;
														
														wallet('acct_mwallet', 4, $mUser_ID, $bonus_description,0, $deduct_bonus,  $mUser_Name, $trans_datetime);	
															
														//insert user into new user pool (universal)
														$sql = "INSERT INTO user_pool(user_name, join_date, join_datetime, upline_id,upline_user_name, 
																	placement_side,level_name, 
																	created_by, created_date)
																	VALUES('$mUser_Name', '$trans_date', '$trans_datetime','$new_upline_id','$new_upline_name', 
																	'$new_placement_side', '$new_level_name', 
																	$_SESSION[user_id], NOW())
																 ";
														dbQuery($sql);
														
														$pool_user_id = mysql_insert_id();

														$sql = "INSERT INTO user_pool_history(user_id, user_name, join_date, join_datetime, upline_id,upline_user_name, 
																	placement_side,level_name, 
																	created_by, created_date)
																	VALUES('$pool_user_id', '$mUser_Name', '$trans_date', '$trans_datetime','$new_upline_id','$new_upline_name', 
																	'$new_placement_side', '$new_level_name', 
																	$_SESSION[user_id], NOW())
																 ";
														dbQuery($sql);														
													
																								
													}
		
													
																					
												}											
											}
									
											
											
										}
										
		
																								
									}
									
									
			
														
									
									if($upline_id == 0 or $upline_id == '')
									{
										$last_upline_boolean = true;
									}
									
								}
								while ($last_upline_boolean == false);
								
	
								//
								if($sponsor_id > 1)
								{
									checkPromotion($sponsor_id, $trans_date, $trans_datetime);
									
								}	
								
								
								return $rwallet_id;	
	
}




function checkPromotion($user_id, $trans_date, $trans_datetime)
{

	  $sql = "SELECT *
			  FROM promotion
			  WHERE active_sw = 1
			  limit 1
			 ";
	  $result=dbQuery($sql);
	  if(dbNumRows($result)>0)
	  {
		 $row=dbFetchAssoc($result);
		 $date_from = $row[date_from];
		 $date_to = $row[date_to];
		 $qualify_day = $row[qualify_day];
		 $same_higher_level = $row[same_higher_level];

		  $sql = "SELECT *
				  FROM user_pkg_change
				  WHERE change_date between '$date_from' and '$date_to'
				  and user_id = '$user_id' and promotion_upgrade_sw = 1
				  limit 1
				 ";
		  $resultCheck=dbQuery($sql);
		  if(dbNumRows($resultCheck)==0)
		  {
			 $sponsor_pkg_id = getCode('user', 'pkg_id', 'user_id', $user_id);
			 $sponsor_join_date = getCode('user', 'join_date', 'user_id', $user_id);
				
			 if($sponsor_join_date >= $date_from)
			 {
				$start_date = $sponsor_join_date;
			 }
			 else
			 {
				$start_date = $date_from;
			 }
	
			 $valid_until = strtotime("+" .$qualify_day. "day", strtotime($start_date));		
			 $end_date = date('Y-m-d', $valid_until);
			
	
			  $sql = "SELECT user_name
					  FROM user
					  WHERE sponsor_id = '$user_id' and join_date between '$start_date' and '$end_date'
					  and pkg_id >= $sponsor_pkg_id
					 ";
			  $result=dbQuery($sql);
			  if(dbNumRows($result)>= $same_higher_level)
			  {
				//return true;
				$pkg_id_to = $sponsor_pkg_id + 1;
				//user_pkg_change($user_id, $sponsor_pkg_id, $pkg_id_to, 0);	
				$change_id = user_pkg_change($user_id, $sponsor_pkg_id, $pkg_id_to, 0, $trans_date, $trans_datetime, 1);
				changeStatus('user_pkg_change', 'change_id', $change_id, 'status_id', 1);
				
			  }
			  else
			  {
				//return false;
				//user_pkg_change($user_id, $sponsor_pkg_id, $pkg_id_to, 0);	
			  }				  
		  }

		  		

	  		
		
	  }
	  	


}


function user_pkg_change($user_id, $sponsor_pkg_id, $pkg_id_to, $free_upgrade, $change_date, $change_datetime, $promotion_upgrade_sw)
{
	$new_pkg_name = mysql_escape_string(getCode('product_package', 'pkg_name', 'pkg_id', $pkg_id_to));
	
	$sql = "UPDATE user
			SET pkg_id = '$pkg_id_to', pkg_name = '$new_pkg_name'
			where user_id = $user_id
			";
	dbQuery($sql);		

	$sql = "INSERT INTO user_pkg_change(change_date, change_datetime, user_id, pkg_from, pkg_to, free_upgrade_sw,
			promotion_upgrade_sw,
			created_by, created_date)
			VALUES('$change_date','$change_datetime', '$user_id','$sponsor_pkg_id', '$pkg_id_to', '$free_upgrade',
			'$promotion_upgrade_sw',
			$_SESSION[user_id], NOW())
			";
	dbQuery($sql);
	
	$change_id = mysql_insert_id();
	
	return $change_id;
}


function calc_daily_point($calc_date)
{
	
	$sql = "SELECT point_date, acct_point.user_id, sum(left_point) as total_left, sum(right_point) as total_right,
			user.pkg_id, max_daily_point
			FROM acct_point inner join user on user.user_id = acct_point.user_id
			inner join product_package on product_package.pkg_id = user.pkg_id
			WHERE point_date = '$calc_date'
			group by acct_point.user_id
			";
	$result=dbQuery($sql);
    if(dbNumRows($result)>0)
    {
 
	                                               
        $pairing_bonus = getCode('commission_type', 'bonus_amount', 'type_name_internal', 'pairing');
		
		while($row=dbFetchAssoc($result))
        {
			$total_left = $row['total_left'];
			$total_right = $row['total_right'];
			$max_daily_point = $row['max_daily_point'];
			$user_id = $row['user_id'];
			
			if($total_left > 0 and $total_right > 0)
			{
				if($total_left > $total_right)
				{
					$pair_point = $total_right;
				}
				else
				{
					$pair_point = $total_left;
				}
				
			}
			else
			{
				$pair_point = 0;
				
			}
			
			if($pair_point > $max_daily_point)
			{
				$pair_point =  $max_daily_point;
			}
			
			$total_bonus = $pairing_bonus * $pair_point;
			
			$sql = "SELECT cf_left, cf_right from acct_point_total
					WHERE user_id = $user_id and total_date < '$calc_date'
					order by total_date desc limit 1
					";
			$resultCF=dbQuery($sql);
			if(dbNumRows($resultCF)>0)
			{
    			$rowCF=dbFetchAssoc($resultCF);
				$cf_left = $rowCF[cf_left] + $total_left;
				$cf_right = $rowCF[cf_right] + $total_right;				
			}
			else
			{
				$cf_left = $total_left;
				$cf_right = $total_right;		
			}
					
			
			$sql = "INSERT INTO acct_point_total(total_date, user_id, total_left,total_right,
					pair_point, total_bonus, cf_left, cf_right,
					created_by, created_date)
					VALUES('$calc_date', '$user_id',$total_left , $total_right, 
					'$pair_point', '$total_bonus', '$total_left', '$total_right', 
					$_SESSION[user_id], NOW())
					";
			dbQuery($sql);	
			
			if($pair_point > 0)
			{
				$bonus_description = 'Pairing Bonus';
				wallet('acct_ewallet', 3, $user_id, $bonus_description, $total_bonus, 0, '');
				
				$pairing_deduct_bonus = 0.1 * $total_bonus;
				$bonus_description = '10% into M-Wallet';
				wallet('acct_ewallet', 4, $user_id, $bonus_description, 0, $pairing_deduct_bonus, '');	
				
				wallet('acct_mwallet', 3, $user_id, $bonus_description, $pairing_deduct_bonus, 0, '');			
			}
        }
    }
	
}

function testonly()
{
  $name = $_POST[name];
  
  
	$password = md5($_POST[password]);
    $user_group = $_POST[user_group];
    $temp_password = '';
    $remark = $_POST[remark];
	
	$id_no = mysql_escape_string($_POST[id_no]);
	$email = mysql_escape_string($_POST[email]);
	$address1 = mysql_escape_string($_POST[address1]);
	$address2 = mysql_escape_string($_POST[address2]);
	$address3 = mysql_escape_string($_POST[address3]);
	$city = mysql_escape_string($_POST[city]);
	$postcode = mysql_escape_string($_POST[postcode]);
	$state = mysql_escape_string($_POST[state]);
	$country = mysql_escape_string($_POST[country]);
	$tel = mysql_escape_string($_POST[tel]);
	$hp = mysql_escape_string($_POST[hp]);
	$bank_name = mysql_escape_string($_POST[bank_name]);
	$bank_account_no = mysql_escape_string($_POST[bank_account_no]);
	
	$upline_id = $_POST[upline_id];
	$auto_assign_user_name = 1;

  //$password = generateRdmPass(8);

  
  if($name!="")
  {
			
			if($auto_assign_user_name == 1)
			{
				//$user_name = getID('user_name');
				//updateID('user_name', $user_name);
				$user_name = 'rbs' . mt_rand(100000, 999999);
				
				if(checkUserName($user_name))
				{
					do
					{
					$user_name = 'rbs' . mt_rand(100000, 999999);
					}
					while (!checkUserName($user_name));
				}
				
								

			}
			else
			{
				$user_name = $_POST[user_name];
			}
			

			
			if(!checkUserName($user_name))
			{
					
			
						$temp_password = createRandomPassword();
						$password = md5($temp_password);		
						
									
						$sql = "INSERT INTO user(name, user_name, 
									 temp_password, remark, 
									 id_no, email, address1, 
									 city, postcode, state, country,  hp, upline_id,
									 created_by, created_date)
									VALUES('$name', '$user_name', '$password', '$remark', 
									'$id_no', '$email', '$address1', 
									'$city', '$postcode', '$state', '$country', '$hp', '$upline_id', 
									$_SESSION[user_id], NOW())
								 ";
						dbQuery($sql);
						$new_user_id = mysql_insert_id();
						
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
										SET u_id='$u_id', upline_id_all = '$new_upline_id_all',upline_id2='$upline_id2', upline_id3='$upline_id3',
										upline_id4='$upline_id4',
										modified_by = $_SESSION[user_id]
										where user_id = $new_user_id
									 ";
						dbQuery($sql);	
													
						
						if($upline_id <> 1)
						{
							/**
							$sql = "UPDATE user
											SET upline_id_all = concat(upline_id_all, ',', '$new_user_id'),
											modified_by = $_SESSION[user_id]
											where find_in_set( $upline_id, upline_id_all ) and user_group <> 1
										 ";
							dbQuery($sql);	
							**/		
						}					
										
						//send email
						if($email != '')
						{
							sendPassword($email, $temp_password);
						}
						
						
						$displayMsg = "added";
						$jsonArray= array('id' => $u_id,'success' => 1, 'displayMsg' => $displayMsg); //*1 value is named LastID
						echo json_encode($jsonArray);	  
						//exit;
						//header('Location: index.php?view=detail&id='.$mid);
						//echo "success";
			
						
			}
			else
			{
			
						$displayMsg = 'Duplicate User Name';
						$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
						echo json_encode($jsonArray);	
			}
  }
  else
  {
		$displayMsg = "Missing Info";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
		echo json_encode($jsonArray);
  }
  
}


function updateUser()
{
	$id = $_GET[id];

	$name = mysql_escape_string($_POST[name]);
	$id_no = mysql_escape_string($_POST[id_no]);
	$email = mysql_escape_string($_POST[email]);
	$address1 = mysql_escape_string($_POST[address1]);
	$city = mysql_escape_string($_POST[city]);
	$postcode = mysql_escape_string($_POST[postcode]);
	$state_id = $_POST[state_id];
	$country_id = $_POST[country_id];
		//$tel = mysql_escape_string($_POST[tel]);
	$hp = mysql_escape_string($_POST[hp]);
	$bank_id = $_POST[bank_id];
		//$bank_name = mysql_escape_string($_POST[bank_name]);
	$bank_account_holder = mysql_escape_string($_POST[bank_account_holder]);
	$bank_account_no = mysql_escape_string($_POST[bank_account_no]);
	$remark = mysql_escape_string($_POST[remark]);
	$delivery_address = mysql_escape_string($_POST[delivery_address]);

  	$sql = "SELECT bank_account_no
          FROM user
          WHERE bank_account_no = '$bank_account_no' and u_id <> '$id'
		  and bank_account_no <> ''
		  limit 1
         ";
  	$result=dbQuery($sql);
 	if(dbNumRows($result)==0)
 	{
	  

		if($hp <> '')
		{
			$hpSend = $country_id . $hp;
		}
		else
		{
			$hpSend = '';
		}
		
		
		
		$sql = "UPDATE user
				SET name = '$name',bank_account_holder = '$bank_account_holder',
				 email = '$email',address1 = '$address1',city = '$city',
				id_no = '$id_no',
				postcode = '$postcode',hp = '$hp',hpSend = '$hpSend',
				state_id = '$state_id',country_id = '$country_id',
				remark = '$remark',delivery_address = '$delivery_address',
				bank_id = '$bank_id',bank_account_no = '$bank_account_no',
				modified_by = $_SESSION[user_id]
				WHERE u_id = '$id'
			   ";
		dbQuery($sql);
		
		$displayMsg = "updated";
		$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);	
  	}
	else
	{
		$displayMsg = "Duplicate bank account number found, you are not allowed to input same bank account number twice";
		$jsonArray= array('id' => $id,'success' => 0, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);		
	}

}



function approveUser()
{
	$u_id = $_GET[id];
  
  if($_POST)
  {
		
		$sql = "SELECT *
										FROM user
										WHERE u_id = '$u_id'
									 ";
		$result=dbQuery($sql);
    $row=dbFetchAssoc($result);
		$id = $row[user_id];
    $status_id = $row[status_id];
		$upline_id_all = $row[upline_id_all];
		$upline_id = $row[upline_id];
		$upline_id2 = $row[upline_id2];
		$upline_id3 = $row[upline_id3];
		$upline_id4 = $row[upline_id4];
		
		if($status_id == 0)
		{

				$sql = "UPDATE user
								SET status_id = 5,
								modified_by = $_SESSION[user_id]
								WHERE user_id = $id
							 ";
				dbQuery($sql);
				
								
				$fullfill_1level_binary_sw = getCode('user', 'fullfill_1level_binary_sw', 'user_id', $upline_id);
				$fullfill_2level_binary_sw = getCode('user', 'fullfill_2level_binary_sw', 'user_id', $upline_id2);
				
				if($fullfill_1level_binary_sw == 0)
				{
						
						$total_1level = 0;
						
						$sql = "SELECT count(user_id) total_member
														FROM user
														WHERE upline_id = '$upline_id' 
													 ";
						$resultTotal=dbQuery($sql);
						$rowTotal=dbFetchAssoc($resultTotal);	
						$total_1level = $rowTotal['total_member'];
						if($total_1level > 2)
						{
								$sql = "UPDATE user
												SET fullfill_1level_binary_sw = 1
												WHERE user_id = $upline_id
											 ";
								dbQuery($sql);		
								
								upgradeLog($upline_id, 1, 0, 0, $id, $_SESSION[user_id]);				
						}
						
						
								
				}
				
				if($fullfill_2level_binary_sw == 0)
				{
						$sql = "SELECT fullfill_1level_binary_sw, fullfill_2level_binary_sw
														FROM user
														WHERE user_id = '$upline_id2' 
													 ";
						$resultUpline=dbQuery($sql);
						$rowUpline=dbFetchAssoc($resultUpline);	
						$fullfill_1level_binary_sw = $rowUpline['fullfill_1level_binary_sw'];
						$fullfill_2level_binary_sw = $rowUpline['fullfill_2level_binary_sw'];
						
						if($fullfill_1level_binary_sw == 1)
						{
						
								if($fullfill_2level_binary_sw == 0)
								{
								
											$sql = "SELECT count(distinct upline.user_id) as total_fullfill_1level_binary_sw
																			FROM user inner join user as upline on upline.user_id = user.upline_id
																			WHERE user.upline_id2 = $upline_id2 and upline.fullfill_1level_binary_sw = 1
																			group by user.upline_id2
																		 ";
											$resultDetail=dbQuery($sql);
											$rowDetail=dbFetchAssoc($resultDetail);	
											$total_fullfill_1level_binary_sw = $rowDetail['total_fullfill_1level_binary_sw'];
											if($total_fullfill_1level_binary_sw >= 2)
											{
													$sql = "UPDATE user
																	SET fullfill_2level_binary_sw = 1, manager_sw = 1
																	WHERE user_id = $upline_id2
																 ";
													dbQuery($sql);	
													
													upgradeLog($upline_id2, 0, 1, 0, $id, $_SESSION[user_id]);					
											}									
								}
				
						}
								
				}		
				
				
				if($upline_id3 > 1)
				{
				
						$sql = "SELECT fulfill_3depth
														FROM user
														WHERE user_id = '$upline_id3' 
													 ";
						$resultUpline=dbQuery($sql);
						$rowUpline=dbFetchAssoc($resultUpline);	
						$fulfill_3depth = $rowUpline[fulfill_3depth];
						
						if($fulfill_3depth == 0)
						{
						
							$sql = "UPDATE user
										SET fulfill_3depth = 1, member_type_id = 3
										WHERE user_id = $upline_id3
										";
							dbQuery($sql);		
							
							upgradeLog($upline_id3, 0, 0, 1, $id, $_SESSION[user_id]);							
						}		
			
				
				}		
				

				//sponsor commission
				$sql = "SELECT *
												FROM commission_type
												WHERE type_id = '1'
											 ";
				$result=dbQuery($sql);
				$row=dbFetchAssoc($result);
				$direct_sponsor_level1 = $row[direct_sponsor_level1];
				$direct_sponsor_level2 = $row[direct_sponsor_level2];
				$direct_sponsor_level3 = $row[direct_sponsor_level3];
				$direct_sponsor_level4 = $row[direct_sponsor_level4];
				
				$fullfill_2level_binary_sw = $row[fullfill_2level_binary_sw];
				$fulfill_3depth = $row[fulfill_3depth];
				
				$upline_id1 = $upline_id;
				$today_date = date("Y-m-d");
				$commission_balance = 100;
				
				for ($x = 1; $x <= 4; $x++) {
				
						$direct_sponsor_level = ${'direct_sponsor_level' . $x};
						$member_id = ${'upline_id' . $x};
						$comm_remark = 'New Member Sponsor - Level ' . $x;
						
						if($direct_sponsor_level > 0 and $member_id > 0)
						{
								
								$member_type_id =  getCode('user', 'member_type_id', 'user_id', $member_id);
								$c_id = genID(comm);
								$c_id = $c_id . $x;								
								
								$sql = "INSERT INTO commission(type_id, c_id, member_id, member_type_id,level_id,for_user_id,
											 comm_date, comm_percentage, 
											 amount, comm_remark,
											 created_by, created_date)
											VALUES(1,'$c_id', '$member_id', '$member_type_id', '$x', '$id',
											'$today_date', '$direct_sponsor_level', 
											'$direct_sponsor_level',  '$comm_remark',
											$_SESSION[user_id], NOW())
										 ";
								dbQuery($sql);
								
								$commission_balance = $commission_balance - $direct_sponsor_level;
								
						 }
					
				}		
				
				//calculate commission for manager (fullfill_2level_binary_sw)
				$sql = "SELECT user_id as manager_user_id, member_type_id
												FROM user
												WHERE user_id in ($upline_id_all) and fullfill_2level_binary_sw = 1
												and user_id <> 1
												order by user_id desc limit 1
											 ";
				$result=dbQuery($sql);
				
				if(dbNumRows($result)>0)
				{
					$row=dbFetchAssoc($result);	
					$manager_user_id = $row['manager_user_id'];
					$member_type_id = $row['member_type_id'];
					$comm_remark = 'New Member Sponsor - Manager';
					
					$commission_balance = $commission_balance - $fullfill_2level_binary_sw;
					$c_id = genID(comm);
					$c_id = $c_id . '5';		
								
					$sql = "INSERT INTO commission(type_id,c_id, member_id, member_type_id,level_id,for_user_id,
											 comm_date, comm_percentage, 
											 amount,comm_remark,
											 created_by, created_date)
											VALUES(1,'$c_id', '$manager_user_id', '$member_type_id', '0', '$id',
											'$today_date', '$fullfill_2level_binary_sw', 
											'$fullfill_2level_binary_sw', '$comm_remark', 
											$_SESSION[user_id], NOW())
										 ";
					dbQuery($sql);
													
				}


				//calculate commission for gold (qualify 3 depth)
				$sql = "SELECT user_id as gold_user_id, member_type_id
												FROM user
												WHERE user_id in ($upline_id_all) and member_type_id = 3
												and user_id <> 1
												order by user_id desc limit 1
											 ";
				$result=dbQuery($sql);
				
				if(dbNumRows($result)>0)
				{
					$row=dbFetchAssoc($result);	
					$gold_user_id = $row['gold_user_id'];
					$member_type_id = $row['member_type_id'];
					$comm_remark = 'New Member Sponsor - Gold';
					
					$commission_balance = $commission_balance - $fulfill_3depth;
					$c_id = genID(comm);
					$c_id = $c_id . '6';		
										
					$sql = "INSERT INTO commission(type_id,c_id, member_id, member_type_id,level_id,for_user_id,
											 comm_date, comm_percentage, 
											 amount,comm_remark,
											 created_by, created_date)
											VALUES(1,'$c_id', '$gold_user_id', '$member_type_id', '0', '$id',
											'$today_date', '$fulfill_3depth', 
											'$fulfill_3depth', '$comm_remark', 
											$_SESSION[user_id], NOW())
										 ";
					dbQuery($sql);
													
				}				
							
				
				//balance goes to admin
				//$cart = array();

				//$cart = array();
				$upline_id_all_array = explode(",", $upline_id_all);
				$total_upline= count($upline_id_all_array) - 1;
				$comm_remark = 'New Member Sponsor - HQ';
				$c_id = genID(comm);
				$c_id = $c_id . '7';		
					
				$sql = "INSERT INTO commission(type_id,c_id, member_id, member_type_id,level_id,for_user_id,
											 comm_date, comm_percentage, 
											 amount, comm_remark,
											 created_by, created_date)
											VALUES(1,'$c_id', '1', '3', '$total_upline', $id,
											'$today_date', '$commission_balance', 
											'$commission_balance', '$comm_remark', 
											$_SESSION[user_id], NOW())
										 ";
				dbQuery($sql);						
				
				$displayMsg = "updated";
				$jsonArray= array('id' => $u_id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);			
		} 
		else
		{
				$displayMsg = "This member has been approved before. You can't approve twice";
				$jsonArray= array('id' => $id,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);				
		} 

  }

}



function resetPassword()
{
	$id = $_GET[id];
  
  if($_POST)
  {

		$password = md5($_POST[password]);
    
    $sql = "UPDATE user
            SET password = '$password', modified_by = $_SESSION[user_id]
            WHERE user_id = $id
           ";
    dbQuery($sql);
    
		$displayMsg = "updated";
		$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);	
  }

}

function deleteUser()
{
	$id = $_GET[id];
  
  if($_POST)
  {
    
		$sql = "UPDATE user
										SET status_id= '-1', delete_sw = '1',delete_by = $_SESSION[user_id],
										modified_by = $_SESSION[user_id]
						WHERE user_id = '$id'
					";
		dbQuery($sql);
    
		$displayMsg = "deleted";
		header('Location: index.php?view=add&id='.$id.'&displayMsg='.$displayMsg.'');
  }

}


function cancelPage()
{
  if($_POST)
  {
    header("Location: index.php?view=list");
  }
}

function checkUserName($user_name)
{
  $sql = "SELECT user_name
          FROM user
          WHERE user_name = '$user_name'
         ";
  $result=dbQuery($sql);
  if(dbNumRows($result)>0)
  {
    return true;
  }
  else
  {
    return false;
  }
}

function checkValidUpline($upline_id, $sponsor_id)
{
  $sql = "SELECT user_name
          FROM user
          WHERE user_id = '$upline_id' and FIND_IN_SET($sponsor_id, upline_id_all)
		  limit 1
         ";
  $result=dbQuery($sql);
  if(dbNumRows($result)>0)
  {
    return true;
  }
  else
  {
    return false;
  }
}



function checkUserPlacement($user_name, $position)
{
  $sql = "SELECT user_name
          FROM user
          WHERE upline_user_name = '$user_name' and placement_side = '$position'
         ";
  $result=dbQuery($sql);
  if(dbNumRows($result)>0)
  {
    return true;
  }
  else
  {
    return false;
  }
}

function searchGenealogy()
{
  if($_POST)
  {
	$id = $_POST['id'];
    header("Location: index.php?view=genealogy_binary&id=$id&search_sw=1");
  }

}	


function oneTimePowerLegxxxxxx()
{
	
				$sql = "SELECT * from user where user_id > 2 and free_lot_sw = 0
						order by user_id
					 ";
				$result=dbQuery($sql);	
				if(dbNumRows($result)>0)
				{
					
					$powerleg_bonus = getCode('commission_type', 'bonus_amount', 'type_name', 'Powerleg');	
												   
				  while($row=dbFetchAssoc($result))
				  {
					  
					  			$upline_id = $row['upline_id'];
								$user_name = $row['user_name'];
								$trans_datetime = $row['join_datetime'];
								
								$upline_upline_id = $upline_id;
				
								
								for ($x = 1; $x <= 10; $x++) 
								{
									
									if($upline_upline_id > 1)
									{
										$bonus_description = 'Powerleg Bonus. Level: ' . $x;
										
										wallet('acct_ewallet', 2, $upline_upline_id, $bonus_description, $powerleg_bonus, 0, $user_name, $trans_datetime);
			
										//deduct 10%
										$bonus_description = '10% into M-Wallet';
										$powerleg_deduct_bonus = $powerleg_bonus * 0.1;
										$type_id = 4;
										
										wallet('acct_ewallet', 4, $upline_upline_id, $bonus_description, 0, $powerleg_deduct_bonus, $user_name, $trans_datetime);
										wallet('acct_mwallet', 2, $upline_upline_id, $bonus_description, $powerleg_deduct_bonus, 0, $user_name, $trans_datetime);										
									}
									

																
									
									
									$upline_upline_id = getCode('user', 'upline_id', 'user_id', $upline_upline_id);
									if($upline_upline_id == 0 or $upline_upline_id == '')
									{
										$x = 11;
									}
								} 
								
				  }

					$displayMsg = "updated";
					$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
					echo json_encode($jsonArray);		
						  
				}
				else
				{
					$displayMsg = "Not Run";
					$jsonArray= array('id' => $id,'success' => 0, 'displayMsg' => $displayMsg); 
					echo json_encode($jsonArray);							
				}


}


?>
