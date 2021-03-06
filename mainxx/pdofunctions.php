<?php
function checkStatusIDUser($id) {
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM user where user_id = '$id' and status_id = 1";
        $q = $pdo->prepare($sql);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  	
  		if ($q->rowCount() > 0) {
			return true;
		}
		else
		{
			return false;
		}
		
	}	
	
}

function updateCurrentManagerID($current_manager_id) {

			if (checkManagerLastID() == $current_manager_id)
			{
				
				$new_manager_id = 1;
			}
			else
			{
				$new_manager_id =  $current_manager_id + 1;
			}
			//delete database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE system_config set current_manager_id = :new_manager_id where system_id = 1";
            $q = $pdo->prepare($sql);
			//$q->bindValue(':system_id', $system_id);
			$q->bindValue(':new_manager_id', $new_manager_id);
			//$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
			
			
}

function checkManagerLastID() {
	

    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM user_manager order by manager_id desc limit 1";
        $q = $pdo->prepare($sql);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  	
		return $data['manager_id'];	
	
}

function getManagerUserID($current_manager_id){
	
	if ($current_manager_id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM user_manager where manager_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($current_manager_id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data['user_id'];
		
	}
}

function getCurrentManagerID(){
	
	
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM system_config where system_id = 1";
        $q = $pdo->prepare($sql);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
		
		return $data['current_manager_id'];

}


function updateSorderDeliveryStatus($id, $status_id, $delivery_courier_company, $delivery_courier_ref_no){
	
	if ($id != ''){
 
		//$data = getSODetail($id);
		//$so_date = $data[so_date];
		//$year_id = date("Y", strtotime($so_date));
		//$month_id = date("m", strtotime($so_date));
	   	
		if($status_id == 1) // Delivery done
		{
			//update database
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE sorder set delivery_sw = :status_id, 
				   delivery_date = NOW(),
				   delivery_courier_company = :delivery_courier_company,
				   delivery_courier_ref_no = :delivery_courier_ref_no,
				   modified_by = :modified_by
				   WHERE so_id = :so_id";
			$q = $pdo->prepare($sql);
			$q->bindValue(':status_id', $status_id);
			$q->bindValue(':delivery_courier_company', $delivery_courier_company);
			$q->bindValue(':delivery_courier_ref_no', $delivery_courier_ref_no);
			//$q->bindValue(':approve_by', $_SESSION[user_id]);
			//$q->bindValue(':approve_by_name', $_SESSION[name]);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$q->bindValue(':so_id', $id);
			$update = $q->execute();
			Database::disconnect();
			
			//calcPersonalSale($year_id, $month_id);
			
		}
		
            
		
	}
}

function approveSOder($id) { 

	$sorderData = getSaleOrderDetail($id);
	$customer_id = $sorderData[customer_id];
	$file_name = $sorderData[file_name];
	$member_reg_no = $sorderData[member_reg_no];
	$paid_by_ewallet_sw = $sorderData[paid_by_ewallet_sw];
	$ewallet_id = $sorderData[ewallet_id];
	$ewallet_id_cancel = $sorderData[ewallet_id_cancel];
	$amount = $sorderData[amount];
	$status_id = $sorderData[status_id];

	
	if($status_id == 1) { // pending order
	
			
			updateSaleOrderStatus($id, 5);	
			
			//check if the user status is pending 
			$customerData = getUserDetail($customer_id);
			$customer_status_id = $customerData[status_id];
			
			if($customer_status_id == 0) { //pending customer
				
				updateUserStatus($customer_id, 1); // change user to active
				
				insertEmailSend('newmember', $attachment_path, $customer_id, 0);
				
				
				
			}
			
			saveReport($id,$file_name, 'sorder', $id);
			
			
			//if the user status is pending, activate the user and send out email
			
			
			
			
			calcUplineBonus($id, 3, $member_reg_no);
			
			deleteTableDetail('stock_history', 'so_id', $id);
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$sql = "SELECT * from sorder_detail where so_id = '$id'";
			$q2 = $pdo->prepare($sql);
			$q2->execute();
			//$data = $q->fetch(PDO::FETCH_ASSOC);
				
						
			while ($row2 = $q2->fetch(PDO::FETCH_ASSOC)) {
				
				$product_id = $row2[product_id];
				$quantity = $row2[quantity];
				$qty_out = 0;
				
		
				insertStockHistory($product_id, 0, $quantity, 0, 0, $id , '');
					
			}			    	
	
			
			Database::disconnect();
			
	}
				
}


function checkBankAccountExist($id) {
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM user where user_id = ? and bank_id > 0 and bank_name <> '' and bank_account_no <> ''";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  	
  		if ($q->rowCount() > 0) {
			return true;
		}
		else
		{
			return false;
		}
		
	}	
	
}


function getPendingWithdrawRequestTotal(){
	

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT count(request_id) as total_number FROM acct_ewallet_withdraw_request left join user on acct_ewallet_withdraw_request.user_id = user.user_id where acct_ewallet_withdraw_request.status_id = 0";
        $q = $pdo->prepare($sql);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data[total_number];
		
	
}

function getPendingSaleOrderTotal(){
	

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT count(so_id) as total_order from sorder where status_id = 1";
        $q = $pdo->prepare($sql);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data[total_order];
		
	
}

function getPendingMemberTotal(){
	

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT count(user_id) as total_number from user where status_id = 0 and user_group = 10";
        $q = $pdo->prepare($sql);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data[total_number];
		
	
}

function updateWithdrawStatus($request_id, $status_id) {

			//delete database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE acct_ewallet_withdraw_request  set status_id = :status_id, modified_by = :modified_by WHERE request_id = :request_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':status_id', $status_id);
			$q->bindValue(':request_id', $request_id);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}

function addWithdrawRequest($request_date, $user_id, $amount, $remark) {

			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into acct_ewallet_withdraw_request (request_date, user_id, amount, remark, created_by, created_date) values (NOW(), :user_id, :amount, :remark, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':user_id', $user_id);
			$q->bindValue(':amount',!empty($amount) ? $amount : 0);
			$q->bindValue(':remark', $remark);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
			//return $id;
			Database::disconnect();	

}

function updateProductStatus($id, $status_id)
{
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE product  set active_sw = :active_sw, modified_by = :modified_by WHERE product_id = :product_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':active_sw', $status_id);
			$q->bindValue(':product_id', $id);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}

function checkProductExistOnOrder($id) {
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM sorder_detail where product_id = ? limit 1";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  	
  		if ($q->rowCount() > 0) {
			return true;
		}
		else
		{
			return false;
		}
		
	}	
	
}

function getSaleOrderTotal($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT sum(unit_price * quantity) as total_amount_before_tax, sum(amount) as total_amount, sum(amount) - sum(unit_price * quantity) as total_tax_amount, sum(order_pv) as total_pv, sum(total_weight) as total_weight_in_gram from sorder_detail where so_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

function updateUserStatus($user_id, $status_id){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `user`  set  status_id = :status_id,`modified_by` = :modified_by, `approve_date` = NOW(), `approve_by_name` = :approve_by_name WHERE user_id = :user_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':user_id', $user_id);
			$q->bindValue(':status_id', $status_id);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$q->bindValue(':approve_by_name', $_SESSION[name]);
			$update = $q->execute();
            
            Database::disconnect();
}

function insertStockHistory($product_id, $qty_in, $qty_out, $forward_sw, $adjust_sw, $so_id, $stock_description) {
			
			//$stock_description = '';
			
			if($forward_sw == 1) {
				$stock_description = 'Balance brought forward';
			}
			
			if($so_id > 0) {
				$stock_description = 'Purchase of product';
			}
			
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into stock_history (stock_date, stock_datetime, stock_description, product_id,qty_in,qty_out,forward_sw,adjust_sw,so_id, created_by, created_date) values (NOW(), NOW(), :stock_description, :product_id,:qty_in,:qty_out,:forward_sw,:adjust_sw,:so_id, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':product_id', $product_id);
			$q->bindValue(':stock_description', $stock_description);
			$q->bindValue(':qty_in',!empty($qty_in) ? $qty_in : 0);
			$q->bindValue(':qty_out',!empty($qty_out) ? $qty_out : 0);
			$q->bindValue(':forward_sw',!empty($forward_sw) ? $forward_sw : 0);
			$q->bindValue(':adjust_sw',!empty($adjust_sw) ? $adjust_sw : 0);
			$q->bindValue(':so_id',!empty($so_id) ? $so_id : 0);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            //$id = $pdo->lastInsertId();
			//return $id;
			Database::disconnect();			
}

function monthEndClosingWallet($wallet_type, $year_id, $month_id) {
	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT user_id, COALESCE(SUM(amount_in), 0)  as total_amount_in, COALESCE(SUM(amount_out), 0)  as total_amount_out, COALESCE(SUM(amount_in), 0) - COALESCE(SUM(amount_out), 0) as balance from $wallet_type where year(trans_date) = ? and month(trans_date) = ? group by user_id";
        $q = $pdo->prepare($sql);
        $q->execute(array($year_id, $month_id));
        //$data = $q->fetch(PDO::FETCH_ASSOC);
						        
  		while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			
			$user_id = $row[user_id];
			$balance = $row[balance];
			
			if($balance >= 0) {
				$amount_in = $balance;
				$amount_out = 0;
			} else {
				$amount_in = 0;
				$amount_out = $balance;				
			}
				
			//insertStockHistory($product_id, $qty_in, $qty_out, 1, 0, 0);
			$trans_description = 'Balance brought forward';
			$trans_datetime = date("Y-m-d h:i:sa");
			
			wallet($wallet_type, 0, $user_id, $trans_description, $amount_in, $amount_out, '', $trans_datetime, 0, 1);
				
		}			    	
		
		Database::disconnect();
				
}


function monthEndClosingInventory($year_id, $month_id) {
	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT product_id, COALESCE(SUM(qty_in), 0)  as total_qty_in, COALESCE(SUM(qty_out), 0)  as total_qty_out, COALESCE(SUM(qty_in), 0) - COALESCE(SUM(qty_out), 0) as balance from stock_history where year(stock_date) = ? and month(stock_date) = ? group by product_id";
        $q = $pdo->prepare($sql);
        $q->execute(array($year_id, $month_id));
        //$data = $q->fetch(PDO::FETCH_ASSOC);
						        
  		while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			
			$product_id = $row[product_id];
			$balance = $row[balance];
			
			if($balance >= 0) {
				$qty_in = $balance;
				$qty_out = 0;
			} else {
				$qty_in = 0;
				$qty_out = $balance;				
			}
				
			insertStockHistory($product_id, $qty_in, $qty_out, 1, 0, 0);
				
		}			    	
		
		Database::disconnect();
				
}

function printFileReport($file_name)
{
	header("Location: ../upload_glsb/$file_name.pdf");	

}

function saveReport($main_id,$reportName, $reportFile, $sub_id)
{
	if($reportFile == 'sorder')
	{
		$dataCompanySetup = getCompanySetupDetailForm(1);
						
			if($dataCompanySetup['gst_sw'] == 1)
			{
				$reportFile = 'sorder_with_gst';
			}
			else
			{
				$reportFile = 'sorder';
			}
	}
	//Get the file
	$content = file_get_contents("http://localhost/cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$reportFile&aliasname=glsb&username=admin&password=&ParamMain_ID=$main_id&ParamSub_ID=$sub_id");
	//$content = file_get_contents("http://erp.tpsconstruction.com.sg/cgi-bin/repwebserver.dll/execute.pdf?reportname=\porder/$reportFile&aliasname=erp&username=admin&password=&ParamMain_ID=$main_id&ParamSub_ID=$sub_id");
			
	
	//Store in the filesystem.
	$fp = fopen("../upload_glsb/".$reportName.".pdf", "w");
	fwrite($fp, $content);
	fclose($fp);

}

function getMessageTemplate($message_type){
	
	if ($message_type != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM system_message_template where message_type = '$message_type'";
        $q = $pdo->prepare($sql);
        //$q->execute(array($message_type));
		$q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
		
		return $data;
		
	}
}

function insertEmailSend($message_type, $attachment_path, $user_id, $mass_email_sw, $user_temp_password) {

			$dataMessage = getMessageTemplate($message_type);
			$message_subject = $dataMessage[message_subject];
			$message_content = $dataMessage[message_content];
			$message_footer = $dataMessage[message_footer];
			$login_id = $_SESSION[user_id];
			
						
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into email (email_subject, email_message, email_message_footer, attachment_path, user_id, mass_email_sw, user_temp_password, created_by, created_date) values (:email_subject, :email_message,:email_message_footer, :attachment_path, :user_id, :mass_email_sw, :user_temp_password, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':email_subject', $message_subject);
			$q->bindValue(':email_message', $message_content);
			$q->bindValue(':email_message_footer', $message_footer);
			//$q->bindValue(':trans_date', $trans_datetime);
			$q->bindValue(':user_id', $user_id);
			$q->bindValue(':mass_email_sw', $mass_email_sw);
			$q->bindValue(':attachment_path', $attachment_path);
			$q->bindValue(':user_temp_password', $user_temp_password);
			//$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->bindValue(':created_by',!empty($login_id) ? $login_id : 0);
			$q->execute();
            $id = $pdo->lastInsertId();
			//return $id;
			Database::disconnect();		
}


function calcPoolBonus($year_id, $month_id) {
	

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
        $sql = "Insert into user_monthly_pv_total (total_calc_date, total_calc_month, created_by, created_date) values (NOW(), NOW(), :created_by, NOW())";
        $q = $pdo->prepare($sql);
		//$q->bindValue(':total_calc_month', $total_calc_month);
		$q->bindValue(':created_by', $_SESSION[user_id]);
		$q->execute();
        $total_id = $pdo->lastInsertId();
			

        $sql = "SELECT * from user where user_group = 10 and status_id = 1";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        //$data = $q->fetch(PDO::FETCH_ASSOC);
			
			        
  		while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			
			$user_id = $row[user_id];


			$sql2 = "SELECT *, sum(total_pv) as total_personal_pv from sorder inner join sorder_detail on sorder.so_id = sorder_detail.so_id where sorder.customer_id = $user_id and sorder.status_id = 5 and year(approve_date) = '$year_id' and month(approve_date) = '$month_id' group by sorder.customer_id";
			$q2 = $pdo->prepare($sql2);
			$q2->execute(array($id));
			$data2 = $q2->fetch(PDO::FETCH_ASSOC);
			$total_personal_pv = $data2[total_personal_pv];

			$sql3 = "SELECT *, sum(total_pv) as total_downline_pv from sorder inner join sorder_detail on sorder.so_id = sorder_detail.so_id left join user on user.user_id = sorder.customer_id where sorder.status_id = 5 and year(approve_date) = '$year_id' and month(approve_date) = '$month_id' and (user.upline_id = $user_id or user.upline_id2 = $user_id or user.upline_id3 = $user_id) group by sorder.customer_id";
			$q3 = $pdo->prepare($sql3);
			$q3->execute(array($id));			
			$data3 = $q3->fetch(PDO::FETCH_ASSOC);
			$total_downline_pv = $data3[total_downline_pv];	
					
			$sqlInsert = "Insert into user_monthly_pv (total_id, user_id, calc_month, total_personal_pv, total_downline_pv, created_by, created_date) values (:total_id, :user_id, NOW(), :total_personal_pv,:total_downline_pv, :created_by, NOW())";
			$qIn = $pdo->prepare($sqlInsert);
			//$q->bindValue(':total_calc_month', $total_calc_month);
			//$q->bindValue(':total_personal_pv', $total_personal_pv);
			//$q->bindValue(':total_downline_pv', $total_downline_pv);
			$qIn->bindValue(':total_personal_pv',!empty($total_personal_pv) ? $total_personal_pv : 0);
			$qIn->bindValue(':total_downline_pv',!empty($total_downline_pv) ? $total_downline_pv : 0);
			$qIn->bindValue(':user_id', $user_id);
			$qIn->bindValue(':total_id', $total_id);
			$qIn->bindValue(':created_by', $_SESSION[user_id]);
			$qIn->execute();	

				
		}			    	

		
		Database::disconnect();
				
}

function getDeliveryCharge($total_weight){
	
	if ($total_weight != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM setting_delivery where '$total_weight' between weight_from_gram and weight_to_gram";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
		
		$delivery_charge = $data[delivery_charge];
		return $delivery_charge;
		
	}
}

function wallet($wallet_type, $type_id, $user_id, $trans_description, $amount_in, $amount_out, $register_user_name, $trans_datetime, $sod_id, $forward_sw, $so_id) {

			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into $wallet_type (trans_date, type_id, user_id, trans_description, amount_in, amount_out,so_id, sod_id, forward_sw,  created_by, created_date) values (NOW(),:type_id, :user_id, :trans_description, :amount_in, :amount_out, :so_id, :sod_id, :forward_sw, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':type_id', $type_id);
			$q->bindValue(':sod_id', $sod_id);
			$q->bindValue(':so_id',!empty($so_id) ? $so_id : 0);
			//$q->bindValue(':trans_date', $trans_datetime);
			$q->bindValue(':user_id', $user_id);
			$q->bindValue(':trans_description', $trans_description);
			$q->bindValue(':amount_in', $amount_in);
			$q->bindValue(':amount_out', $amount_out);
			$q->bindValue(':forward_sw',!empty($forward_sw) ? $forward_sw : 0);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
			return $id;
			Database::disconnect();	

}


function calcUplineBonus($id, $total_level, $member_reg_no) {
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * from sorder inner join sorder_detail on sorder.so_id = sorder_detail.so_id left join product on product.product_id = sorder_detail.product_id where sorder_detail.so_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        //$data = $q->fetch(PDO::FETCH_ASSOC);
        
  		while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			
			$user_id = $row[customer_id];
			$userData = getUserDetail($user_id);

			
			$upline_id = $userData[upline_id];
			
			
						
			$comm_level1 = $row[comm_level1];
			$comm_level2 = $row[comm_level2];
			$comm_level3 = $row[comm_level3];
			$product_bonus_pool = $row[product_bonus_pool];
			$quantity = $row[quantity];
			$sod_id = $row[sod_id];
			
			$product_bonus_pool = $product_bonus_pool * $quantity;

			$trans_description = 'Pool Bonus';
			wallet('acct_mwallet', 3, $upline_id, $trans_description, $product_bonus_pool, 0, '', '', $sod_id, 0, $id);
			
									
			if($upline_id > 0){

				for ($x = 1; $x <= $total_level; $x++) {
					
					$comm_amount = ${'comm_level' . $x};
					$amount_in = $comm_amount * $quantity;
					
					if($upline_id > 0){
						
						if($amount_in > 0) {

							//insert into ewallet
							$trans_description = 'Sales Bonus Level ' . $x . ' (' . $member_reg_no . ')';
							wallet('acct_ewallet', 2, $upline_id, $trans_description, $amount_in, 0, '', $trans_datetime, $sod_id, 0, $id);
													
						}
						

						//check upline
						$userUplineData = getUserDetail($upline_id);			
						$upline_id = $userUplineData[upline_id];					
					}
				}
							
			}
			

				
		}
		
		Database::disconnect();
		//return $data;
		
	}	
}

function checkMemberRegNo($id) {
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM user where member_reg_no = ? limit 1";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  	
  		if ($q->rowCount() > 0) {
			return true;
		}
		else
		{
			return false;
		}
		
	}	
	
}

function checkUserName($id) {
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM user where user_name = ? limit 1";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  	
  		if ($q->rowCount() > 0) {
			return true;
		}
		else
		{
			return false;
		}
		
	}	
	
}

//update bank
function updateBankSetting($bank_id, $bank_name, $bank_swift_code, $country_id)
{
	
		
			//delete database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `bank`  set bank_name = :bank_name, bank_swift_code = :bank_swift_code, country_id = :country_id WHERE bank_id = :bank_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':bank_id', $bank_id);
			$q->bindValue(':bank_name', $bank_name);
			$q->bindValue(':bank_swift_code', $bank_swift_code);
			$q->bindValue(':country_id', $country_id);
			$update = $q->execute();
            
            Database::disconnect();
}

//add for Bank
function addBankSetting($bank_name, $bank_swift_code, $country_id)
{
	
		
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into bank (bank_name, bank_swift_code, country_id) values (:bank_name, :bank_swift_code, :country_id)";
            $q = $pdo->prepare($sql);
			$q->bindValue(':bank_name', $bank_name);
			$q->bindValue(':bank_swift_code', $bank_swift_code);
			$q->bindValue(':country_id', $country_id);
			$q->execute();
            $id = $pdo->lastInsertId();
			return $id;
			Database::disconnect();
			
}

//update country
function updateCountrySetting($country_id, $country_name, $prefix_name, $nationality_name)
{
	
		
			//delete database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `country`  set country_name = :country_name, prefix_name = :prefix_name, nationality_name = :nationality_name WHERE country_id = :country_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':country_id', $country_id);
			$q->bindValue(':country_name', $country_name);
			$q->bindValue(':prefix_name', $prefix_name);
			$q->bindValue(':nationality_name', $nationality_name);
			$update = $q->execute();
            
            Database::disconnect();
}

//add for country
function addCountrySetting($country_name, $prefix_name, $nationality_name)
{
	
		
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into country (country_name, prefix_name, nationality_name) values (:country_name, :prefix_name, :nationality_name)";
            $q = $pdo->prepare($sql);
			$q->bindValue(':country_name', $country_name);
			$q->bindValue(':prefix_name', $prefix_name);
			$q->bindValue(':nationality_name', $nationality_name);
			$q->execute();
            $id = $pdo->lastInsertId();
			return $id;
			Database::disconnect();
			
}

//get data announcement
function getInstantMessageDetail($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM instant_message where im_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}
//get data announcement
function getEmailDetail($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM email where email_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//add for email
function addEmail($email_subject, $email_message, $attachment_path)
{
	
		
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into email (email_subject, email_message, attachment_path, created_by, created_date) values (:email_subject, :email_message, :attachment_path, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':email_subject', $email_subject);
			$q->bindValue(':email_message', $email_message);
			$q->bindValue(':attachment_path', $attachment_path);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
			return $id;
			Database::disconnect();
			
}

//update announcement
function updateAnnouncementDetail($anno_id, $anno_title, $anno_date, $anno_description, $active_sw){
	
		
			//delete database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `announcement`  set `anno_title` = :anno_title, anno_date = :anno_date, `anno_description` = :anno_description, `active_sw` = :active_sw, `modified_by` = :modified_by WHERE anno_id = :anno_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':anno_id', $anno_id);
			$q->bindValue(':anno_title', $anno_title);
			$q->bindValue(':anno_date', $anno_date);
			$q->bindValue(':anno_description', $anno_description);
			$q->bindValue(':active_sw', $active_sw);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}

//get data announcement
function getAnnouncementDetailForm($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM announcement where anno_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//add for announcement
function addAnnouncementDetail($anno_title, $anno_date, $anno_description, $active_sw)
{
	
		
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into announcement (anno_title, anno_date, anno_description, active_sw, created_by, created_date) values (:anno_title, :anno_date, :anno_description, :active_sw, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':anno_title', $anno_title);
			$q->bindValue(':anno_date', $anno_date);
			$q->bindValue(':anno_description', $anno_description);
			$q->bindValue(':active_sw', $active_sw);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
			return $id;
			Database::disconnect();
			
}

//approve delivery charge setting
function updateDeliveryChargeSetting($delivery_charge_id, $weight_from_gram, $weight_to_gram, $delivery_charge){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `setting_delivery`  set `weight_from_gram` = :weight_from_gram, `weight_to_gram` = :weight_to_gram, `delivery_charge` = :delivery_charge, `modified_by` = :modified_by WHERE delivery_charge_id = :delivery_charge_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':delivery_charge_id', $delivery_charge_id);
			$q->bindValue(':weight_from_gram',!empty($weight_from_gram) ? $weight_from_gram : 0);
			$q->bindValue(':weight_to_gram',!empty($weight_to_gram) ? $weight_to_gram : 0);
			$q->bindValue(':delivery_charge',!empty($delivery_charge) ? $delivery_charge : 0);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}
//add to delivery charge setting
function addDeliveryChargeSetting($weight_from_gram, $weight_to_gram, $delivery_charge)
{
	
		
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into setting_delivery (weight_from_gram, weight_to_gram, delivery_charge, created_by, created_date) values (:weight_from_gram, :weight_to_gram, :delivery_charge, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':weight_from_gram',!empty($weight_from_gram) ? $weight_from_gram : 0);
			$q->bindValue(':weight_to_gram',!empty($weight_to_gram) ? $weight_to_gram : 0);
			$q->bindValue(':delivery_charge',!empty($delivery_charge) ? $delivery_charge : 0);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
			return $id;
			Database::disconnect();			
}

//update user registration
function updateUserRegistrationDetail($u_id, $name, $ic_no, $nationality_id, $nationality_name, $address1, $postcode, $city, $state_id, $state_prefix, $country_id, $country_name, $prefix_name, $tel, $email, $bank_id, $bank_name, $bank_swift_code, $bank_account_no, $user_name, $password, $temp_password, $user_group, $remark){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `user`  set `name` = :name, `ic_no` = :ic_no, `nationality_id` = :nationality_id, `nationality_name` = :nationality_name, `address1` = :address1, `postcode` = :postcode, `city` = :city,  `state_id` = :state_id, `state_prefix` = :state_prefix, `country_id` = :country_id, `country_name` = :country_name, `prefix_name` = :prefix_name, `tel` = :tel, `email` = :email, `bank_id` = :bank_id, `bank_name` = :bank_name, `bank_swift_code` = :bank_swift_code, `bank_account_no` = :bank_account_no,  `user_name` = :user_name,`user_group` = :user_group, `remark` = :remark, `modified_by` = :modified_by WHERE u_id = :u_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':u_id', $u_id);
			$q->bindValue(':name', $name);
			$q->bindValue(':ic_no', $ic_no);
			$q->bindValue(':nationality_id', $nationality_id);
			$q->bindValue(':nationality_name', $nationality_name);
			$q->bindValue(':address1', $address1);
			$q->bindValue(':postcode', $postcode);
			$q->bindValue(':city', $city);
			$q->bindValue(':state_id', $state_id);
			$q->bindValue(':state_prefix', $state_prefix);
			$q->bindValue(':country_id', $country_id);
			$q->bindValue(':country_name', $country_name);
			$q->bindValue(':prefix_name', $prefix_name);
			$q->bindValue(':tel', $tel);
			$q->bindValue(':email', $email);
			$q->bindValue(':bank_id', $bank_id);
			$q->bindValue(':bank_name', $bank_name);
			$q->bindValue(':bank_swift_code', $bank_swift_code);
			$q->bindValue(':bank_account_no', $bank_account_no);
			$q->bindValue(':user_name', $user_name);
			//$q->bindValue(':password', $password);
			//$q->bindValue(':temp_password', $temp_password);
			$q->bindValue(':user_group', $user_group);
			$q->bindValue(':remark', $remark);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}

//get data user registration
function getNewUserDetail($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT user.*, status_name FROM user left join user_status on user.status_id = user_status.status_id where u_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//add to user registration
function addUserRegistration($name, $ic_no, $nationality_id, $nationality_name, $address1, $postcode, $city, $state_id, $state_prefix, $country_id, $country_name, $prefix_name, $tel, $email, $bank_id, $bank_name, $bank_swift_code, $bank_account_no, $user_name, $password, $temp_password, $user_group, $remark, $member_reg_no,$sponsor_member_reg_no, $upline_id)
{
	
		
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into user (name, ic_no, nationality_id, nationality_name, address1, postcode, city, state_id, state_prefix, country_id, country_name, prefix_name, tel, email, bank_id, bank_name, bank_swift_code, bank_account_no, user_name, password, temp_password, user_group, remark, member_reg_no, sponsor_member_reg_no, upline_id, created_by, created_date) values (:name, :ic_no, :nationality_id, :nationality_name, :address1, :postcode, :city, :state_id, :state_prefix, :country_id, :country_name, :prefix_name, :tel, :email, :bank_id, :bank_name, :bank_swift_code, :bank_account_no, :user_name, :password, :temp_password, :user_group, :remark, :member_reg_no,:sponsor_member_reg_no, :upline_id, :created_by, NOW())";
			
			$q = $pdo->prepare($sql);
			$q->bindValue(':name', $name);
			$q->bindValue(':ic_no', $ic_no);
			$q->bindValue(':upline_id', $upline_id);
			$q->bindValue(':sponsor_member_reg_no', $sponsor_member_reg_no);
			$q->bindValue(':nationality_id', $nationality_id);
			$q->bindValue(':nationality_name', $nationality_name);
			$q->bindValue(':address1', $address1);
			$q->bindValue(':postcode', $postcode);
			$q->bindValue(':city', $city);
			$q->bindValue(':state_id', $state_id);
			$q->bindValue(':state_prefix', $state_prefix);
			$q->bindValue(':country_id', $country_id);
			$q->bindValue(':country_name', $country_name);
			$q->bindValue(':prefix_name', $prefix_name);
			$q->bindValue(':tel', $tel);
			$q->bindValue(':email', $email);
			$q->bindValue(':bank_id', $bank_id);
			$q->bindValue(':bank_name', $bank_name);
			$q->bindValue(':bank_swift_code', $bank_swift_code);
			$q->bindValue(':bank_account_no', $bank_account_no);
			$q->bindValue(':user_name', $user_name);
			$q->bindValue(':password', $password);
			$q->bindValue(':temp_password', $temp_password);
			$q->bindValue(':user_group', $user_group);
			$q->bindValue(':remark', $remark);
			
      

			$q->bindValue(':member_reg_no', $member_reg_no);
			$q->bindValue(':created_by',!empty($_SESSION[user_id]) ? $_SESSION[user_id] : 0);
			//$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
			return $id;
			Database::disconnect();			
}

//Get data to add into User
function getBank($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM bank where bank_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//Get data to add into User
function getState($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM state where state_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//Get data to add into User
function getCountry($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM country where country_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

function updateSaleOrderWalletID($so_id, $ewallet_id, $ewallet_id_cancel){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `sorder`  set ewallet_id = :ewallet_id, ewallet_id_cancel = :ewallet_id_cancel,  modified_by = :modified_by WHERE so_id = :so_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':so_id', $so_id);
			$q->bindValue(':ewallet_id',!empty($ewallet_id) ? $ewallet_id : 0);
			$q->bindValue(':ewallet_id_cancel',!empty($ewallet_id_cancel) ? $ewallet_id_cancel : 0);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}

function updateSaleOrderOnly($so_id, $so_address, $delivery_date, $delivery_courier_company, $delivery_courier_ref_no){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `sorder`  set `so_address` = :so_address, delivery_date = :delivery_date, delivery_courier_company = :delivery_courier_company, delivery_courier_ref_no = :delivery_courier_ref_no, modified_by = :modified_by WHERE so_id = :so_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':so_id', $so_id);
			$q->bindValue(':so_address', $so_address);
			$q->bindValue(':delivery_date',!empty($delivery_date) ? $delivery_date : NULL);
			$q->bindValue(':delivery_courier_company', $delivery_courier_company);
			$q->bindValue(':delivery_courier_ref_no', $delivery_courier_ref_no);
			//$q->bindValue(':courier_sw', $courier_sw);
			//$q->bindValue(':total_weight_in_gram', $total_weight_in_gram);
			//$q->bindValue(':courier_sw',!empty($courier_sw) ? $courier_sw : 0);
			//$q->bindValue(':courier_amount',!empty($courier_amount) ? $courier_amount : 0);	
			//$q->bindValue(':total_pv',!empty($total_pv) ? $total_pv : 0);	
			//$q->bindValue(':file_name', $reportName);	
			//$q->bindValue(':so_postcode', $so_postcode);
			//$q->bindValue(':so_state', $so_state);
			//$q->bindValue(':so_country', $so_country);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}
//approve Status ID Sale Order Setting
function updateSaleOrder($so_id, $so_address, $total_weight_in_gram, $courier_sw, $courier_amount, $total_pv, $reportName, $amount_before_tax, $tax_percentage, $tax_amount, $amount, $ewallet_id){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `sorder`  set `so_address` = :so_address, total_weight_in_gram = :total_weight_in_gram, courier_sw = :courier_sw, courier_amount = :courier_amount, total_pv = :total_pv, file_name = :file_name, amount_before_tax = :amount_before_tax,tax_percentage = :tax_percentage,tax_amount = :tax_amount, amount = :amount, ewallet_id = :ewallet_id, modified_by = :modified_by WHERE so_id = :so_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':so_id', $so_id);
			$q->bindValue(':so_address', $so_address);
			$q->bindValue(':total_weight_in_gram', $total_weight_in_gram);
			$q->bindValue(':courier_sw',!empty($courier_sw) ? $courier_sw : 0);
			$q->bindValue(':courier_amount',!empty($courier_amount) ? $courier_amount : 0);	
			$q->bindValue(':total_pv',!empty($total_pv) ? $total_pv : 0);	
			$q->bindValue(':amount_before_tax',!empty($amount_before_tax) ? $amount_before_tax : 0);
			$q->bindValue(':tax_percentage',!empty($tax_percentage) ? $tax_percentage : 0);
			$q->bindValue(':tax_amount',!empty($tax_amount) ? $tax_amount : 0);
			$q->bindValue(':amount',!empty($amount) ? $amount : 0);
			$q->bindValue(':ewallet_id',!empty($ewallet_id) ? $ewallet_id : 0);
			$q->bindValue(':file_name', $reportName);	
			//$q->bindValue(':so_postcode', $so_postcode);
			//$q->bindValue(':so_state', $so_state);
			//$q->bindValue(':so_country', $so_country);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}

function updateSaleOrderDeliveryStatus($so_id, $delivery_sw, $delivery_date, $delivery_courier_company, $delivery_courier_ref_no){
	
			//$approve_by_name = $_SESSION['name'];
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			if($delivery_sw == 1) {
				$sql = "UPDATE `sorder`  set delivery_sw = :delivery_sw, delivery_date = :delivery_date, delivery_courier_company = :delivery_courier_company, delivery_courier_ref_no = :delivery_courier_ref_no, modified_by = :modified_by WHERE so_id = :so_id";
			} else {
				$sql = "UPDATE `sorder`  set delivery_sw = :delivery_sw, delivery_date = :delivery_date, delivery_courier_company = :delivery_courier_company, delivery_courier_ref_no = :delivery_courier_ref_no, modified_by = :modified_by WHERE so_id = :so_id";
			}
			
            
            $q = $pdo->prepare($sql);
			$q->bindValue(':so_id', $so_id);
			$q->bindValue(':delivery_sw', $delivery_sw);
			$q->bindValue(':delivery_date', $delivery_date);
			$q->bindValue(':delivery_courier_company', $delivery_courier_company);
			$q->bindValue(':delivery_courier_ref_no', $delivery_courier_ref_no);
			
			//$q->bindValue(':approve_by_name', $_SESSION['name']);
			//$q->bindValue(':approve_by_name', $_SESSION[name]);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}

//approve Status ID Sale Order Setting
function updateSaleOrderStatus($so_id, $status_id){
	
			$approve_by_name = $_SESSION['name'];
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			if($status_id == 5) {
				$sql = "UPDATE `sorder`  set `status_id` = :status_id, approve_by_name = '$approve_by_name', approve_date = NOW(), modified_by = :modified_by WHERE so_id = :so_id";
			} else {
				$sql = "UPDATE `sorder`  set `status_id` = :status_id, modified_by = :modified_by WHERE so_id = :so_id";
			}
			
            
            $q = $pdo->prepare($sql);
			$q->bindValue(':so_id', $so_id);
			$q->bindValue(':status_id', $status_id);
			//$q->bindValue(':approve_by_name', $_SESSION['name']);
			//$q->bindValue(':approve_by_name', $_SESSION[name]);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}

//get data Sale Order
function getSaleOrderDetail($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT *, sorder.status_id as status_id, if(delivery_sw = 1, 'Delivered', '') as delivery_name FROM sorder left join sorder_status on sorder.status_id = sorder_status.status_id left join user on user.user_id = sorder.customer_id where so_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//add to sale order
function addSaleOrder($customer_id, $so_customer_name, $so_address, $courier_sw, $courier_amount, $paid_by_ewallet_sw )
{
	
		
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into sorder (so_date, customer_id, so_customer_name, so_address,courier_sw,courier_amount,paid_by_ewallet_sw , created_by, created_date) values (NOW(), :customer_id, :so_customer_name, :so_address, :courier_sw, :courier_amount,:paid_by_ewallet_sw, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':customer_id', $customer_id);
			$q->bindValue(':so_customer_name', $so_customer_name);
			$q->bindValue(':so_address', $so_address);
			//$q->bindValue(':courier_sw', $courier_sw);
			//$q->bindValue(':courier_amount', $courier_amount);
			$q->bindValue(':courier_sw',!empty($courier_sw) ? $courier_sw : 0);
			$q->bindValue(':paid_by_ewallet_sw',!empty($paid_by_ewallet_sw) ? $paid_by_ewallet_sw : 0);
			$q->bindValue(':courier_amount',!empty($courier_amount) ? $courier_amount : 0);
			//$q->bindValue(':so_city', $so_city);
			//$q->bindValue(':so_postcode', $so_postcode);
			//$q->bindValue(':so_state', $so_state);
			//$q->bindValue(':so_country', $so_country);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
			
			
			//updateSaleOrderStatus($id, 1);
			
			return $id;
			Database::disconnect();			
}

//add to sale order
function addSaleOrderDetail($id, $product_id, $product_code, $product_name, $unit_price, $tax_percentage, $unit_price_with_gst, $quantity, $amount, $product_weight, $total_weight, $product_pv, $order_pv, $product_bonus_pool, $product_cost)
{
	
		
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into sorder_detail (so_id, product_id, product_code, product_name, unit_price, tax_percentage, unit_price_with_gst, quantity, amount,product_weight,total_weight,product_pv,order_pv, product_bonus_pool, product_cost,  created_by, created_date) values (:so_id, :product_id, :product_code, :product_name, :unit_price, :tax_percentage, :unit_price_with_gst, :quantity, :amount,:product_weight,:total_weight,:product_pv,:order_pv,:product_bonus_pool,:product_cost, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':so_id', $id);
			$q->bindValue(':product_id', $product_id);
			$q->bindValue(':product_code', $product_code);
			$q->bindValue(':product_name', $product_name);
			$q->bindValue(':unit_price',!empty($unit_price) ? $unit_price : 0);
			$q->bindValue(':tax_percentage',!empty($tax_percentage) ? $tax_percentage : 0);
			$q->bindValue(':unit_price_with_gst',!empty($unit_price_with_gst) ? $unit_price_with_gst : 0);
			$q->bindValue(':quantity',!empty($quantity) ? $quantity : 0);
			$q->bindValue(':amount',!empty($amount) ? $amount : 0);
			$q->bindValue(':product_weight',!empty($product_weight) ? $product_weight : 0);
			$q->bindValue(':total_weight',!empty($total_weight) ? $total_weight : 0);
			$q->bindValue(':product_pv',!empty($product_pv) ? $product_pv : 0);
			$q->bindValue(':order_pv',!empty($order_pv) ? $order_pv : 0);
			$q->bindValue(':product_bonus_pool',!empty($product_bonus_pool) ? $product_bonus_pool : 0);
			$q->bindValue(':product_cost',!empty($product_cost) ? $product_cost : 0);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            //$id = $pdo->lastInsertId();
			
			
			//updateSaleOrderStatus($id, 1);
			
			return $id;
			Database::disconnect();			
}

function getUserDetailByMemberRegNo($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM user where member_reg_no = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//get data from user put into new order in form add
function getUserDetail($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM user where user_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//update Email Setting
function updateEmailSetting($setting_id, $host_name, $host_user_name, $host_password, $host_port, $host_mail_from, $host_mail_from_name, $notify_send_to){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `system_setting`  set `host_name` = :host_name, `host_user_name` = :host_user_name, `host_password` = :host_password, `host_port` = :host_port, `host_mail_from` = :host_mail_from, `host_mail_from_name` = :host_mail_from_name, `notify_send_to` = :notify_send_to WHERE setting_id = :setting_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':setting_id', $setting_id);
			$q->bindValue(':host_name', $host_name);
			$q->bindValue(':host_user_name', $host_user_name);
			$q->bindValue(':host_password', $host_password);			
			$q->bindValue(':host_port',!empty($host_port) ? $host_port : 0);
			$q->bindValue(':host_mail_from', $host_mail_from);
			$q->bindValue(':host_mail_from_name', $host_mail_from_name);
			$q->bindValue(':notify_send_to', $notify_send_to);
			$update = $q->execute();
            
            Database::disconnect();
}

//get data from Email Setting
function getEmailSettingDetailForm($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM system_setting where setting_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//update Company Setup
function updateCompanySetupDetail($setup_id, $gst_sw, $gst_rate, $pending_member_day, $pending_sale_order_day, $monthly_payout_day, $monthly_bonus_limit, $bonus_member_pv, $bonus_downline_pv, $min_account_value, $request_payout_charge, $activate_account_charge, $manual_withdrawal_charge, $admin_charge){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `company_setup`  set `gst_sw` = :gst_sw, `gst_rate` = :gst_rate, `pending_member_day` = :pending_member_day, `pending_sale_order_day` = :pending_sale_order_day, `monthly_payout_day` = :monthly_payout_day, `monthly_bonus_limit` = :monthly_bonus_limit, `bonus_member_pv` = :bonus_member_pv, `bonus_downline_pv` = :bonus_downline_pv, `min_account_value` = :min_account_value, `request_payout_charge` = :request_payout_charge, `activate_account_charge` = :activate_account_charge, `manual_withdrawal_charge` = :manual_withdrawal_charge, `admin_charge` = :admin_charge, `modified_by` = :modified_by WHERE setup_id = :setup_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':setup_id', $setup_id);
			$q->bindValue(':gst_sw',!empty($gst_sw) ? $gst_sw : 0);
			$q->bindValue(':gst_rate',!empty($gst_rate) ? $gst_rate : 0);
			$q->bindValue(':pending_member_day',!empty($pending_member_day) ? $pending_member_day : 0);
			$q->bindValue(':pending_sale_order_day',!empty($pending_sale_order_day) ? $pending_sale_order_day : 0);
			$q->bindValue(':monthly_payout_day',!empty($monthly_payout_day) ? $monthly_payout_day : 0);
			$q->bindValue(':monthly_bonus_limit',!empty($monthly_bonus_limit) ? $monthly_bonus_limit : 0);
			$q->bindValue(':bonus_member_pv',!empty($bonus_member_pv) ? $bonus_member_pv : 0);
			$q->bindValue(':bonus_downline_pv',!empty($bonus_downline_pv) ? $bonus_downline_pv : 0);
			$q->bindValue(':min_account_value',!empty($min_account_value) ? $min_account_value : 0);
			$q->bindValue(':request_payout_charge',!empty($request_payout_charge) ? $request_payout_charge : 0);
			$q->bindValue(':activate_account_charge',!empty($activate_account_charge) ? $activate_account_charge : 0);
			$q->bindValue(':manual_withdrawal_charge',!empty($manual_withdrawal_charge) ? $manual_withdrawal_charge : 0);
			$q->bindValue(':admin_charge',!empty($admin_charge) ? $admin_charge : 0);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}

//get data after add from company setup
function getCompanySetupDetailForm($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM company_setup where setup_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//update Company
function updateCompanyDetail($company_id, $company_name, $code, $register_no, $gst_no, $address1, $postcode, $city, $state, $country, $tel, $fax, $email, $remark, $invoice_message, $statement_message, $cheque_payable, $remit_to, $bank_name, $acct_type, $acct_no, $swiftcode, $send_to){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `company`  set `company_name` = :company_name, `code` = :code, `register_no` = :register_no, `gst_no` = :gst_no, `address1` = :address1, `postcode` = :postcode, `city` = :city, `state` = :state, `country` = :country,`tel` = :tel, `fax` = :fax, `email` = :email, `remark` = :remark, `invoice_message` = :invoice_message, `statement_message` = :statement_message, `cheque_payable` = :cheque_payable, `remit_to` = :remit_to, `bank_name` = :bank_name, `acct_type` = :acct_type, `acct_no` = :acct_no, `swiftcode` = :swiftcode, `send_to` = :send_to, `modified_by` = :modified_by WHERE company_id = :company_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':company_id', $company_id);
			$q->bindValue(':company_name', $company_name);
			$q->bindValue(':code', $code);
			$q->bindValue(':register_no', $register_no);
			$q->bindValue(':gst_no', $gst_no);
			$q->bindValue(':address1', $address1);
			$q->bindValue(':postcode',$postcode);
			$q->bindValue(':city', $city);
			$q->bindValue(':state', $state);
			$q->bindValue(':country', $country);
			$q->bindValue(':tel', $tel);
			$q->bindValue(':fax', $fax);
			$q->bindValue(':email', $email);
			$q->bindValue(':remark', $remark);
			$q->bindValue(':invoice_message', $invoice_message);
			$q->bindValue(':statement_message', $statement_message);
			$q->bindValue(':cheque_payable', $cheque_payable);
			$q->bindValue(':remit_to', $remit_to);
			$q->bindValue(':bank_name', $bank_name);
			$q->bindValue(':acct_type', $acct_type);
			$q->bindValue(':acct_no', $acct_no);
			$q->bindValue(':swiftcode', $swiftcode);
			$q->bindValue(':send_to', $send_to);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
}

//get data after add from company
function getCompanyDetailForm($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM company where company_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//add to product
function insertProduct($product_code, $product_category, $product_name, $product_short_name, $selling_price, $cost_of_good_sold, $profit, $bonus_pool, $comm_level1, $comm_level2,$comm_level3, $point_value, $gst_rate_type, $gst_rate, $weight_in_gram, $product_description)
{
		
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into product (product_code, product_category, product_name, product_short_name, selling_price, cost_of_good_sold, profit, bonus_pool, comm_level1, comm_level2, comm_level3, point_value, gst_rate_type, gst_rate,weight_in_gram, product_description, created_by, created_date) values (:product_code, :product_category, :product_name, :product_short_name, :selling_price, :cost_of_good_sold, :profit, :bonus_pool, :comm_level1, :comm_level2, :comm_level3, :point_value, :gst_rate_type, :gst_rate, :weight_in_gram, :product_description, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':product_code', $product_code);
			$q->bindValue(':product_category', $product_category);
			$q->bindValue(':product_name', $product_name);
			$q->bindValue(':product_short_name', $product_short_name);
			$q->bindValue(':selling_price',!empty($selling_price) ? $selling_price : 0);
			$q->bindValue(':cost_of_good_sold',!empty($cost_of_good_sold) ? $cost_of_good_sold : 0);
			$q->bindValue(':profit',!empty($profit) ? $profit : 0);
			$q->bindValue(':bonus_pool',!empty($bonus_pool) ? $bonus_pool : 0);
			$q->bindValue(':comm_level1',!empty($comm_level1) ? $comm_level1 : 0);
			$q->bindValue(':comm_level2',!empty($comm_level2) ? $comm_level2 : 0);
			$q->bindValue(':comm_level3',!empty($comm_level3) ? $comm_level3 : 0);
			$q->bindValue(':point_value',!empty($point_value) ? $point_value : 0);
			$q->bindValue(':gst_rate_type', $gst_rate_type);
			$q->bindValue(':gst_rate',!empty($gst_rate) ? $gst_rate : 0);
			$q->bindValue(':weight_in_gram',!empty($weight_in_gram) ? $weight_in_gram : 0);
			$q->bindValue(':product_description', $product_description);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
			return $id;
			Database::disconnect();			
}

//get data after add from product
function getProductDetail($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM product where product_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

//update Product
function updateProductDetail($product_id, $product_code, $product_category, $product_name, $product_short_name, $selling_price, $cost_of_good_sold, $profit, $bonus_pool, $comm_level1, $comm_level2,$comm_level3, $point_value, $gst_rate_type, $gst_rate , $weight_in_gram, $product_description){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `product`  set `product_code` = :product_code, `product_category` = :product_category, `product_name` = :product_name, `product_short_name` = :product_short_name, `selling_price` = :selling_price, `cost_of_good_sold` = :cost_of_good_sold, `profit` = :profit, `bonus_pool` = :bonus_pool, `comm_level1` = :comm_level1, `comm_level2` = :comm_level2, `comm_level3` = :comm_level3, `point_value` = :point_value, `gst_rate_type` = :gst_rate_type, `gst_rate` = :gst_rate, weight_in_gram = :weight_in_gram, product_description = :product_description, `modified_by` = :modified_by WHERE product_id = :product_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':product_id', $product_id);
			$q->bindValue(':product_code', $product_code);
			$q->bindValue(':product_category', $product_category);
			$q->bindValue(':product_name', $product_name);
			$q->bindValue(':product_short_name', $product_short_name);
			$q->bindValue(':selling_price',!empty($selling_price) ? $selling_price : 0);
			$q->bindValue(':cost_of_good_sold',!empty($cost_of_good_sold) ? $cost_of_good_sold : 0);
			$q->bindValue(':profit',!empty($profit) ? $profit : 0);
			$q->bindValue(':bonus_pool',!empty($bonus_pool) ? $bonus_pool : 0);
			$q->bindValue(':comm_level1',!empty($comm_level1) ? $comm_level1 : 0);
			$q->bindValue(':comm_level2',!empty($comm_level2) ? $comm_level2 : 0);
			$q->bindValue(':comm_level3',!empty($comm_level3) ? $comm_level3 : 0);
			$q->bindValue(':point_value',!empty($point_value) ? $point_value : 0);
			$q->bindValue(':gst_rate_type', $gst_rate_type);
			$q->bindValue(':gst_rate',!empty($gst_rate) ? $gst_rate : 0);
			$q->bindValue(':weight_in_gram',!empty($weight_in_gram) ? $weight_in_gram : 0);
			$q->bindValue(':product_description', $product_description);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
			
	
}

function deleteTableDetail($table_name, $table_id_name, $id){
	
		
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM $table_name WHERE $table_id_name = :id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':id', $id);
			$q->execute();
            Database::disconnect();

}
?>