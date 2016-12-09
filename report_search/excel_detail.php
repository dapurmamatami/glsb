<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";

	$report_name = $_GET['report_name'];
	$date_from = $_GET['date_from'];
	$date_to = $_GET['date_to'];
	$year_id = $_GET['year_id'];
	$database_table = $_GET['database_table'];
	$main_id = $_GET['main_id'];

	if ($report_name == 'export_data') 
	{
			if($database_table == 'user')
			{
					$exportName = 'Member Registration';
					
					$select = "select user_name, member_reg_no, name, ic_no, nationality_name, state_name, country_name, address1, postcode, city, hp, email, bank_name, bank_account_no, approve_date from user left join state on user.state_id = state.state_id where user_group = 10 and date(approve_date) between '$date_from' and '$date_to'
										";	
			}
			
			if($database_table == 'sorder')
			{
					$exportName = 'Sale Order';
					
					$select = "select user_name, member_reg_no, status_name, so_date, product_name, quantity, if(delivery_sw=1, 'Delivered', '') as delivery_name, if(courier_sw=1, 'Courier', 'Pickup') as delivery_method, sorder_status.status_name
as order_status_name, sorder_detail.amount as detail_amount from sorder left join sorder_status on sorder_status.status_id = sorder.status_id left join user on user.user_id = sorder.customer_id left join sorder_detail on sorder_detail.so_id = sorder.so_id where date(so_date) between '$date_from' and '$date_to'
										";	
			}

			if($database_table == 'ewallet')
			{
					$exportName = 'EWallet History';
					
					$select = "select user_name, member_reg_no, trans_date, trans_description, amount_in, amount_out from acct_ewallet left join user on acct_ewallet.user_id = user.user_id where date(trans_date) between '$date_from' and '$date_to'";	
			}	
			
			if($database_table == 'ewallet_withdraw')
			{
					$exportName = 'Payout';
					
					$select = "select user_name, member_reg_no, trans_date, trans_description, amount_in, amount_out from acct_ewallet left join user on user.user_id = acct_ewallet.user_id where acct_ewallet.type_id in (11,12) and date(trans_date) between '$date_from' and '$date_to'
										";	
			}
			
			if($database_table == 'product_select')
			{
					$exportName = 'Product Sold';
					
					$select = "select user_name, name, select_datetime, product_name, quantity, product_select.remark, address1, city, postcode, state_name, delivery_address, hp, email, pkg_name, user.remark from product_select left join user on product_select.user_id = user.user_id left join product on product.product_id = product_select.product_id
					left join state on state.state_id = user.state_id
										";	
			}																												
	}

			if ($report_name == 'monthly_payout') 
			{
					$exportName = 'Monthly Payout';
							
					$select = "select withdraw_date as Payout_date, bank_holder_name as Name, bank_name as Bank_Name, bank_account_no as Bank_Account_No, amount_out as amount FROM acct_ewallet_withdraw inner join acct_ewallet on acct_ewallet_withdraw.withdraw_id = acct_ewallet.withdraw_id where acct_ewallet.withdraw_id = '$main_id'";
			}

			if($database_table == 'user_by_earning')
			{
				$exportName = 'List of Member by Earnings';
				
				$select = "select member_reg_no, name, ic_no, state_name, city from user left join state on user.state_id = state.state_id where user_group = 10 and date(approve_date) between '$date_from' and '$date_to'";	
			}
			
			if($database_table == 'sales_product')
			{
				$exportName = 'Sales Perfomance Report';
				
				$select = "SELECT sd.product_name,
				COALESCE(SUM(if(month(approve_date)='01',sd.amount,0)),0) as total_month1,
				COALESCE(SUM(if(month(approve_date)='02',sd.amount,0)),0) as total_month2,
				COALESCE(SUM(if(month(approve_date)='03',sd.amount,0)),0) as total_month3, 
				COALESCE(SUM(if(month(approve_date)='04',sd.amount,0)),0) as total_month4, 
				COALESCE(SUM(if(month(approve_date)='05',sd.amount,0)),0) as total_month5, 
				COALESCE(SUM(if(month(approve_date)='06',sd.amount,0)),0) as total_month6, 
				COALESCE(SUM(if(month(approve_date)='07',sd.amount,0)),0) as total_month7, 
				COALESCE(SUM(if(month(approve_date)='08',sd.amount,0)),0) as total_month8, 
				COALESCE(SUM(if(month(approve_date)='09',sd.amount,0)),0) as total_month9, 
				COALESCE(SUM(if(month(approve_date)='10',sd.amount,0)),0) as total_month10, 
				COALESCE(SUM(if(month(approve_date)='11',sd.amount,0)),0) as total_month11, 
				COALESCE(SUM(if(month(approve_date)='12',sd.amount,0)),0) as total_month12
				FROM sorder s left join sorder_detail sd on s.so_id = sd.so_id WHERE status_id = 5 and year(approve_date) = '$year_id' group by sd.product_id";	
			}

	//dbQuery($sql);		
$export = mysql_query($select) or die("Sql error : " . mysql_error());

$fields = mysql_num_fields($export);

for($i = 0; $i < $fields; $i++)
{
    $header .= mysql_field_name($export , $i). "\t";
}

while($row = mysql_fetch_row($export))
{
    $line = '';
    foreach($row as $value)
    {                                            
        if(!isset($value) || trim($value) == "")
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace('"' , '""' , $value);
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim($line). "\n";
}
$data = str_replace("\r" , "" , $data);

if(trim($data) == "")
{
    $data = "\n(0)Records Found!\n";                        
}


header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=$exportName.xls");

header("Pragma: no-cache");
header("Expires: 0");



//print "$header\n$data";
print "$header\n$data";

?>