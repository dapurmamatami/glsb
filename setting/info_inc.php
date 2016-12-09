<?php
include "../inc/pdoconfig.php";
include "../main/session.php";
include "../main/functions.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  case 'add' :
    add();
    break;

  case 'update' :
    update();
    break;
	
  case 'updateEmail' :
    updateEmail();
    break;
	
  case 'addDeliveryCharge' :
    addDeliveryCharge();
    break;
	
  case 'updateDeliveryCharge' :
    updateDeliveryCharge();
    break;

  case 'deleteDeliveryCharge' :
    deleteDeliveryCharge();
    break;
			
  case 'delete' :
    delete();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
	
  case 'addCountry' :
    addCountry();
    break;

  case 'updateCountry' :
    updateCountry();
    break;

  case 'deleteCountry' :
    deleteCountry();
    break;
	
  case 'addBank' :
    addBank();
    break;
	
	case 'updateBank' :
    updateBank();
    break;
	
	case 'deleteBank' :
    deleteBank();
    break;

	
	
}
function addDeliveryCharge ()
{
		$weight_from_gram = $_POST[weight_from_gram];
		$weight_to_gram = $_POST[weight_to_gram];
		$delivery_charge = $_POST[delivery_charge];
		
		if($delivery_charge !='')
		{
			$id = addDeliveryChargeSetting($weight_from_gram, $weight_to_gram, $delivery_charge);
				
			
				//sucess show updated message
				$displayMsg = "added";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
		}
		else
		{
				//show error message
				$displayMsg = "Missing Product Name";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
		}
}

function updateDeliveryCharge ()
{
		$id = $_POST['delivery_charge_id'];
		$weight_from_gram = $_POST[weight_from_gram];
		$weight_to_gram = $_POST[weight_to_gram];
		$delivery_charge = $_POST[delivery_charge];
		
		if($delivery_charge !='')
		{
				//update
				updateDeliveryChargeSetting($id, $weight_from_gram, $weight_to_gram, $delivery_charge);
				
			
				//sucess show updated message
				$displayMsg = "updated";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
		}
		else
		{
				//show error message
				$displayMsg = "Missing Product Name";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
		}
}
  
function add()
{
		$product_code = mysql_escape_string($_POST[product_code]);
		$product_category = mysql_escape_string($_POST[product_category]);
		$product_name = mysql_escape_string($_POST[product_name]);
		$product_short_name = mysql_escape_string($_POST[product_short_name]);
		$selling_price = mysql_escape_string($_POST[selling_price]);
		$cost_of_good_sold = mysql_escape_string($_POST[cost_of_good_sold]);
		$profit = mysql_escape_string($_POST[profit]);
		$bonus_pool =  mysql_escape_string($_POST[bonus_pool]);
		$comm_level1 =  mysql_escape_string($_POST[comm_level1]);
		$comm_level2 = mysql_escape_string($_POST[comm_level2]);
		$comm_level3 = mysql_escape_string($_POST[comm_level3]);
		$point_value = mysql_escape_string($_POST[point_value]);
		$gst_rate_type = mysql_escape_string($_POST[gst_rate_type]);
		$gst_rate = mysql_escape_string($_POST[gst_rate]);

		if($product_name!="")
		{
	
				$id = addProductForm($product_code, $product_category, $product_name, $product_short_name, $selling_price, $cost_of_good_sold, $profit, $bonus_pool, $comm_level1, $comm_level2,$comm_level3, $point_value, $gst_rate_type, $gst_rate);
				
			
				
				//sucess show updated message
				$displayMsg = "added";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);	  


		}
		else
		{
			//show error message
			$displayMsg = "Missing Product Name";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function update()
{
		$id = $_GET['id'];
		$company_name = mysql_escape_string($_POST[company_name]);
		$code = mysql_escape_string($_POST[code]);
		$register_no = mysql_escape_string($_POST[register_no]);
		$gst_no = mysql_escape_string($_POST[gst_no]);
		$address1 = mysql_escape_string($_POST[address1]);
		$postcode = mysql_escape_string($_POST[postcode]);
		$city = mysql_escape_string($_POST[city]);
		$state =  mysql_escape_string($_POST[state]);
		$country =  mysql_escape_string($_POST[country]);
		$tel = mysql_escape_string($_POST[tel]);
		$fax = mysql_escape_string($_POST[fax]);
		$email = mysql_escape_string($_POST[email]);
		$remark = mysql_escape_string($_POST[remark]);
		$invoice_message = mysql_escape_string($_POST[invoice_message]);
		$statement_message = mysql_escape_string($_POST[statement_message]);
		$cheque_payable = mysql_escape_string($_POST[cheque_payable]);
		$remit_to = mysql_escape_string($_POST[remit_to]);
		$bank_name = mysql_escape_string($_POST[bank_name]);
		$acct_type = mysql_escape_string($_POST[acct_type]);
		$acct_no = mysql_escape_string($_POST[acct_no]);
		$swiftcode = mysql_escape_string($_POST[swiftcode]);
		$send_to =  mysql_escape_string($_POST[send_to]);
		
	if($id != '')
	{
		
		//update database
		updateCompanyDetail($id, $company_name, $code, $register_no, $gst_no, $address1, $postcode, $city, $state, $country, $tel, $fax, $email, $remark, $invoice_message, $statement_message, $cheque_payable, $remit_to, $bank_name, $acct_type, $acct_no, $swiftcode, $send_to);
		
		
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

function updateEmail()
{
		$id = $_GET['id'];	
		$host_name = mysql_escape_string($_POST[host_name]);
		$host_user_name = mysql_escape_string($_POST[host_user_name]);
		$host_password = mysql_escape_string($_POST[host_password]);
		$host_port = $_POST[host_port];
		$host_mail_from = mysql_escape_string($_POST[host_mail_from]);
		$host_mail_from_name = mysql_escape_string($_POST[host_mail_from_name]);
		$notify_send_to =  mysql_escape_string($_POST[notify_send_to]);

		
	if($id != '')
	{
		
		//update database
		updateEmailSetting($id, $host_name, $host_user_name, $host_password, $host_port, $host_mail_from, $host_mail_from_name, $notify_send_to);
		
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



function delete()
{
	$id = $_GET['id'];
	
	
	if($id != '')
	{
		//update database
		deleteTableDetail('product', 'product_id', $id);
		
		
		//sucess show deleted message
		$displayMsg = "deleted";
		//$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		//echo json_encode($jsonArray);
		header("Location: index.php?view=detail&id=$id&displayMsg=$displayMsg");				
	}
	else
	{
		//show error message
		$displayMsg = "Missing Info";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);			
	}
	
}

function deleteDeliveryCharge()
{
	$delivery_charge_id = $_POST['delivery_charge_id'];
	
	
	if($delivery_charge_id != '')
	{
		//delete database
		deleteTableDetail('setting_delivery', 'delivery_charge_id', $delivery_charge_id);
		
		
		//sucess show deleted message
		$displayMsg = "deleted";
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

function addCountry ()
{
		$country_name =  mysql_escape_string($_POST[country_name]);
		$prefix_name =  mysql_escape_string($_POST[prefix_name]);
		$nationality_name =  mysql_escape_string($_POST[nationality_name]);
		
		if($country_name !='')
		{
			$id = addCountrySetting($country_name, $prefix_name, $nationality_name);
				
			
				//sucess show updated message
				$displayMsg = "added";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
		}
		else
		{
				//show error message
				$displayMsg = "Missing Country Name";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
		}
}

function updateCountry ()
{
		$id = $_POST['country_id'];	
		$country_name =  mysql_escape_string($_POST[country_name]);
		$prefix_name =  mysql_escape_string($_POST[prefix_name]);
		$nationality_name =  mysql_escape_string($_POST[nationality_name]);

		
	if($id != '')
	{
		
		//update database
		updateCountrySetting($id, $country_name, $prefix_name, $nationality_name);
		
		
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

function deleteCountry()
{
	$country_id = $_POST['country_id'];
	
	
	if($country_id != '')
	{
		//delete database
		deleteTableDetail('country', 'country_id', $country_id);
		
		
		//sucess show deleted message
		$displayMsg = "deleted";
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

function addBank ()
{
		$bank_name =  mysql_escape_string($_POST[bank_name]);
		$bank_swift_code =  mysql_escape_string($_POST[bank_swift_code]);
		$country_id =  $_POST[country_id];
		
		if($bank_name !='')
		{
			$id = addBankSetting($bank_name, $bank_swift_code, $country_id);
				
			
				//sucess show updated message
				$displayMsg = "added";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
		}
		else
		{
				//show error message
				$displayMsg = "Missing Country Name";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
		}
}

function updateBank ()
{
		$id = $_POST['bank_id'];	
		$bank_name =  mysql_escape_string($_POST[bank_name]);
		$bank_swift_code =  mysql_escape_string($_POST[bank_swift_code]);
		$country_id =  $_POST[country_id];

		
	if($id != '')
	{
		
		//update database
		updateBankSetting($id, $bank_name, $bank_swift_code, $country_id);
		
		
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

function deleteBank()
{
	$bank_id = $_POST['bank_id'];
	
	
	if($bank_id != '')
	{
		//delete database
		deleteTableDetail('bank', 'bank_id', $bank_id);
		
		
		//sucess show deleted message
		$displayMsg = "deleted";
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



?>
