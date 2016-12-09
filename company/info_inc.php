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
	
  case 'updateCompanySetup' :
    updateCompanySetup();
    break;

				
  case 'delete' :
    delete();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
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
		$address1 = $_POST[address1];
		$postcode = mysql_escape_string($_POST[postcode]);
		$city = mysql_escape_string($_POST[city]);
		$state =  mysql_escape_string($_POST[state]);
		$country =  mysql_escape_string($_POST[country]);
		$tel = mysql_escape_string($_POST[tel]);
		$fax = mysql_escape_string($_POST[fax]);
		$email = mysql_escape_string($_POST[email]);
		$remark = $_POST[remark];
		$invoice_message = $_POST[invoice_message];
		$statement_message = $_POST[statement_message];
		$cheque_payable = mysql_escape_string($_POST[cheque_payable]);
		$remit_to = mysql_escape_string($_POST[remit_to]);
		$bank_name = mysql_escape_string($_POST[bank_name]);
		$acct_type = mysql_escape_string($_POST[acct_type]);
		$acct_no = mysql_escape_string($_POST[acct_no]);
		$swiftcode = mysql_escape_string($_POST[swiftcode]);
		$send_to =  $_POST[send_to];
		
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

function updateCompanySetup()
{
		$id = $_GET['id'];
		$setup_id = $_POST[setup_id];	
		$gst_sw = $_POST[gst_sw];
		$gst_rate = $_POST[gst_rate];
		$pending_member_day = $_POST[pending_member_day];
		$pending_sale_order_day = $_POST[pending_sale_order_day];
		$monthly_payout_day = $_POST[monthly_payout_day];
		$monthly_bonus_limit = $_POST[monthly_bonus_limit];
		$bonus_member_pv = $_POST[bonus_member_pv];
		$bonus_downline_pv =  $_POST[bonus_downline_pv];
		$min_account_value =  $_POST[min_account_value];
		$request_payout_charge = $_POST[request_payout_charge];
		$activate_account_charge = $_POST[activate_account_charge];
		$manual_withdrawal_charge = $_POST[manual_withdrawal_charge];
		$admin_charge = $_POST[admin_charge];
		$min_balance_to_keep = $_POST[min_balance_to_keep];

		
	if($id != '')
	{
		
		//update database
		 updateCompanySetupDetail($setup_id, $gst_sw, $gst_rate, $pending_member_day, $pending_sale_order_day, $monthly_payout_day, $monthly_bonus_limit, $bonus_member_pv, $bonus_downline_pv, $min_account_value, $request_payout_charge, $activate_account_charge, $manual_withdrawal_charge, $admin_charge, $min_balance_to_keep);
		
		
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


?>
