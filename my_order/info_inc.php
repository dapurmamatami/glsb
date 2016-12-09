<?php
include "../inc/pdoconfig.php";
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../main/session.php";
include "../main/functions.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  
  case 'add' :
    addSOrder();
    break;
	
  case 'changestatus' :
    changeOrderStatus();
    break;
		
  case 'changeDeliveryStatus' :
    changeDeliveryStatus();
    break;	

  case 'update' :
    update();
    break;
	
  case 'delete' :
    delete();
    break;

  case 'approveBySelection' :
    approveBySelection();
    break;
	
	case 'deliveryBySelection' :
    deliveryBySelection();
    break;
		
  case 'printReport' :
    printReport();
    break;
	
	case 'printReportAll' :
    printReportAll();
    break;	
	
	case 'printReportAll2' :
    printReportAll2();
    break;	

}
  
  
function addSOrder()
{
		//$customer_id = mysql_escape_string($_POST[customer_id]);
		//$so_customer_name = mysql_escape_string($_POST[so_customer_name]);
		//$so_address = mysql_escape_string($_POST[so_address]);
		//$so_city = mysql_escape_string($_POST[so_city]);
		//$so_postcode = mysql_escape_string($_POST[so_postcode]);
		//$so_state = mysql_escape_string($_POST[so_state]);
		
		
		$json = $_POST['mydata'];
		$dataA = json_decode($json);
		
		$jsonB = $_POST['mydataB'];
		$dataB = json_decode($jsonB);
		//$so_country = $dataB[so_country];
		$qty_validation_ok = 0;
		
	
		foreach($dataB  as $product) {		
				
				//$so_customer_name= $product->so_customer_name;
				//$customer_id= $product->customer_id;
				$member_reg_no = $product->member_reg_no;
				$so_address= $product->so_address;
				//$so_city= $product->so_city;
				//$so_postcode= $product->so_postcode;
				//$so_state= $product->so_state;
				//$so_country= $product->so_country;
				$total_product= $product->total_product;
				//$courier_sw= $product->courier_sw;
				$courier_sw= 1;
				$paid_by_ewallet_sw= $product->paid_by_ewallet_sw;
				$internal_remark= $product->internal_remark;
				$period_id= $product->period_id;
				
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
		

		
		
						
						
		if(checkMemberRegNo($member_reg_no))
		{
			if($qty_validation_ok == 1) {
				
				if($paid_by_ewallet_sw == 0 or ($paid_by_ewallet_sw == 1 and $wallet_balance > $validate_total_amount)) {
				
					if($courier_sw == 0 or ($courier_sw == 1 and $so_address != '')) {
	

						if($courier_sw == 0) {
							$so_address = 'Pick Up';
						}
						
						$current_so_no = getCurrentSoNo();
						$so_no = 'P' . $current_so_no;
						
						$next_so_no = $current_so_no + 1;
						updateCurrentSoNo($next_so_no);
						//$internal_remark = $_POST[internal_remark];
						
						$so_id = addSaleOrder($customer_id, $so_customer_name, $so_address, $courier_sw, $courier_amount, $paid_by_ewallet_sw,$upline_id_all, $so_no, $internal_remark, $period_id);
						

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
								
								//for product_commission
								$p_comm_level1 = $productData[p_comm_level1];
								$p_comm_level2 = $productData[p_comm_level2];
								$p_comm_level3 = $productData[p_comm_level3];
								$p_personal_comm = $productData[p_personal_comm];
								
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
								addSaleOrderDetail($so_id, $product_id, $product_code, $product_name, $unit_price, $tax_percentage, $unit_price_with_gst, $product_qty, $amount, $product_weight, $total_weight, $product_pv, $order_pv, $product_bonus_pool, $product_cost, $p_comm_level1, $p_comm_level2, $p_comm_level3, $p_personal_comm);
								
								
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
						
						updateSaleOrder($so_id, $so_address, $total_weight_in_gram, $courier_sw, $courier_amount, $total_pv, $reportName, $total_amount_before_tax, 0, $total_tax_amount, $total_amount, $ewallet_id);
						
						updateSaleOrderStatus($so_id, 1);
						
						saveReport($so_id,$reportName, 'sorder', $id);
						
						$file_name = $reportName . '.pdf';
						insertEmailSend('pendingorder', $file_name, $customer_id, 0);
						
						
						
						$customerSW = 0;
						
						if($_SESSION['user_grp'] == 10) { //customer
							$customerSW = 1;
						} 
						
						//sucess show added message
						$displayMsg = "added";
						$jsonArray= array('id' => $so_id,'success' => 1, 'displayMsg' => $displayMsg, 'customerSW' => $customerSW); 
						echo json_encode($jsonArray);	  		
										
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



function approveBySelection()
{
	$id = $_GET['id'];
	
	$json = $_POST['mydata'];
	$data = json_decode($json);
	$validate_msg = '';
	
	
	
	foreach($data  as $lineItem)
	{
					
			$chkBox = $lineItem->chkBox;
			$so_id = $lineItem->so_id;

			$sorderData = getSaleOrderDetail($so_id);
			$file_name = $sorderData[file_name];
			$customer_id = $sorderData[customer_id];
			
			//$file_name = $file_name . '.pdf';
			$file_name = 'App'. $file_name. '.pdf';
			
			approveSOder($so_id);
			saveReport($so_id,$file_name, 'sorder', $id);
			insertEmailSend('approveOrder', $file_name, $customer_id, 0);
			
	}
		//show error message
		$displayMsg = $so_id;
		$jsonArray= array('id' => 0,'success' => 1, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);			
	
}


function changeOrderStatus()
{
	$id = $_GET['id'];
	$status_id = $_GET['status_id'];

	$sorderData = getSaleOrderDetail($id);
	$customer_id = $sorderData[customer_id];
	$file_name = $sorderData[file_name];
	$member_reg_no = $sorderData[member_reg_no];
	$paid_by_ewallet_sw = $sorderData[paid_by_ewallet_sw];
	$ewallet_id = $sorderData[ewallet_id];
	$ewallet_id_cancel = $sorderData[ewallet_id_cancel];
	$amount = $sorderData[amount];
	
	
	

	
	if($id != '')
	{
		//$file_name = $file_name . '.pdf';
		//$file_name = $file_name . '.pdf';
		 
		if($status_id == 5) { // approve order
			
			if(!checkIfUserNameEmpty($customer_id)) {
				
				
				$file_name = 'App' . $file_name . '.pdf';
				
				approveSOder($id);
				insertEmailSend('approveOrder', $file_name, $customer_id, 0);

				//update database
				//updateSaleOrderStatus($id, $status_id);		
				
				
				//sucess show added message
				$displayMsg = "updated";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);					
				
			}else{

				//show error message
				$displayMsg = "Customer User name not assigned yet!";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);				
			}
			
			
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

function deliveryBySelectionXX()
{
	$id = $_GET['id'];
	$delivery_courier_company = $_GET[delivery_courier_company];
	$delivery_courier_ref_no = $_GET[delivery_courier_ref_no];
	
	$json = $_POST['mydata'];
	$data = json_decode($json);
	$validate_msg = '';
	
	foreach($data  as $lineItem)
	{
					
			$chkBox = $lineItem->chkBox;
			$so_id = $lineItem->so_id;
			
			$sorderData = getSaleOrderDetail($so_id);
			$file_name = $sorderData[file_name];
			

			//approveSOder($so_id);
			updateSorderDeliveryStatus($so_id, 1, $delivery_courier_company, $delivery_courier_ref_no);
			saveReport($so_id,$file_name, 'sorder', $id);
			
	}
	//show error message
	$displayMsg = 'Record Updated';
	$jsonArray= array('id' => 0,'success' => 1, 'displayMsg' => $displayMsg); 
	echo json_encode($jsonArray);			
	
}


function changeDeliveryStatus()
{
	$id = $_GET['id'];
	$status_id = $_GET['status_id'];

	//$data = getSaleOrderDetail($id);
	//$product_id = $data[product_id];
	//$product_id = $data[product_id];
	
	if($id != '')
	{
		//update database
		//updateSaleOrderStatus($id, $status_id);

		$jsonB = $_POST['mydataB'];
		$dataB = json_decode($jsonB);
		
		foreach($dataB  as $product) {		
				
				$so_customer_name= $product->so_customer_name;
				$customer_id= $product->customer_id;
				$so_address= $product->so_address;
				//$so_city= $product->so_city;
				//$so_postcode= $product->so_postcode;
				//$so_state= $product->so_state;
				//$so_country= $product->so_country;
				$total_product= $product->total_product;
				//$courier_sw= $product->courier_sw;
				$courier_sw= 1;
				$delivery_date= $product->delivery_date;
				$delivery_courier_company= $product->delivery_courier_company;
				$delivery_courier_ref_no= $product->delivery_courier_ref_no;
				
		}
		
		$delivery_date = ($delivery_date != "") ? "" . date("Y-m-d", strtotime($delivery_date)) . "" : NULL;
		$sorderData = getSaleOrderDetail($id);
		$file_name = $sorderData[file_name];
		$customer_id = $sorderData[customer_id];
				
		if($status_id == 1) { 
		
			if($delivery_date != '') {
				
				updateSaleOrderDeliveryStatus($id, $status_id, $delivery_date, $delivery_courier_company, $delivery_courier_ref_no);
				
				$file_name = 'App'. $file_name;
				saveReport($id,$file_name, 'sorder', $id);
				
				$file_name = 'App'. $file_name. '.pdf';
				insertEmailSend('deliverOrder', $file_name, $customer_id, 0);			

				//sucess show added message
				$displayMsg = "updated";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);	
							
			} else {
				//show error message
				$displayMsg = "Delivery Date is required";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
								
			}
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
		$so_address = mysql_escape_string($_POST[so_address]);
		$so_city = mysql_escape_string($_POST[so_city]);
		$so_postcode = mysql_escape_string($_POST[so_postcode]);
		$so_state = mysql_escape_string($_POST[so_state]);
		$so_country = mysql_escape_string($_POST[so_country]);
		$delivery_date = ($delivery_date != "") ? "" . date("Y-m-d", strtotime($delivery_date)) . "" : NULL;
		$internal_remark = $_POST[internal_remark];
		$period_id = $_POST[period_id];

		$jsonB = $_POST['mydataB'];
		$dataB = json_decode($jsonB);
		
		$sorderData = getSaleOrderDetail($id);
		$file_name = $sorderData[file_name];
		
		foreach($dataB  as $product) {		
				
				$so_customer_name= $product->so_customer_name;
				$customer_id= $product->customer_id;
				$so_address= $product->so_address;
				//$so_city= $product->so_city;
				//$so_postcode= $product->so_postcode;
				//$so_state= $product->so_state;
				//$so_country= $product->so_country;
				$total_product= $product->total_product;
				//$courier_sw= $product->courier_sw;
				$courier_sw= 1;
				$delivery_date= $product->delivery_date;
				$delivery_courier_company= $product->delivery_courier_company;
				$delivery_courier_ref_no= $product->delivery_courier_ref_no;
				$internal_remark= $product->internal_remark;
				$period_id= $product->period_id;
				
		}
		
		if($courier_sw == 0 or ($courier_sw == 1 and $so_address!=""))
		{
				
				updateSaleOrderOnly($id, $so_address, $delivery_date, $delivery_courier_company, $delivery_courier_ref_no, $internal_remark, $period_id);
				
				saveReport($id,$file_name, 'sorder', $id);
				
				$file_name = 'App'. $file_name;
				saveReport($id, $file_name, 'sorder', $id);
				
				//updateSaleOrder($id, $so_address, $so_city, $so_postcode, $so_state, $so_country);
				//sucess show update message
				$displayMsg = "updated";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);	  


		}
		else
		{
			//show error message
			$displayMsg = "Delivery Address is required for courier";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function delete()
{
	$id = $_GET['id'];
	$sorderData = getSaleOrderDetail($id);
	$customer_id = $sorderData[customer_id];
	$status_id = $sorderData[status_id];
	$member_reg_no = $sorderData[member_reg_no];
	$paid_by_ewallet_sw = $sorderData[paid_by_ewallet_sw];
	$ewallet_id = $sorderData[ewallet_id];
	$ewallet_id_cancel = $sorderData[ewallet_id_cancel];
	$amount = $sorderData[amount];	
	
	if($id != '')
	{


		
		if($status_id == 1) { //cancelled order
		
			
			if($paid_by_ewallet_sw == 1 and $ewallet_id_cancel == 0) {
								
				$trans_description = 'Order Cancelled - ID: ' . $id; 
				$trans_datetime = date("Y-m-d H:i:s");
				$ewallet_id_cancel =  wallet('acct_ewallet', 11, $customer_id, $trans_description, $amount, 0, '', $trans_datetime, 0, 0, $id);	
					
				updateSaleOrderWalletID($id, $ewallet_id, $ewallet_id_cancel);						
			}

			//update database
			updateSaleOrderStatus($id, '-1');
					
		
		}		
		
		//sucess show deleted message
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

function printReport()
{
	$file_name = $_GET[id];
	
	printFileReport($file_name);
}

function printReportAll()
{
 
		$report_name = $_GET['report_name'];

		header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$report_name&aliasname=glsb$rpt_alias&username=admin&password=&Parammain_id=$main_id");		
		

}

function printReportAll2()
{		
		
if($_GET['sub'] == 'AllOrder'){
			
		$main_id = $_GET['id'];
		$report_name = 'order_member_all';
		$date_from = ($_POST['date_from'] != "") ? "" . date("Y-m-d", strtotime($_POST['date_from'])) . "" : NULL; 
		$date_to = ($_POST['date_to'] != "") ? "" . date("Y-m-d", strtotime($_POST['date_to'])) . "" : NULL;
		$status_id = $_POST[status_id];	
		
			
		header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$report_name&aliasname=glsb&username=admin&password=&Parammain_id=$main_id&ParamDate_From=$date_from&ParamDate_To=$date_to&Paramstatus_id=$status_id");		
		}
		
		else if($_GET['sub'] == 'myorder')
		{
			
		$main_id = $_GET['id'];
		$report_name = 'sorder_history';
		$user_id = $_SESSION['user_id'];
		$date_from = ($_POST['date_from'] != "") ? "" . date("Y-m-d", strtotime($_POST['date_from'])) . "" : NULL; 
		$date_to = ($_POST['date_to'] != "") ? "" . date("Y-m-d", strtotime($_POST['date_to'])) . "" : NULL;
		
			
		header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$report_name&aliasname=glsb&username=admin&password=&Parammain_id=$main_id&Paramuser_id=$user_id&ParamDate_From=$date_from&ParamDate_To=$date_to");
		}
}





?>
