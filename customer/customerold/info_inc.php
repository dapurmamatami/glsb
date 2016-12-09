<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../default_main/session.php";
include "../default_main/functions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  
  case 'add' :
    addCustomer();
    break;

  case 'update' :
    updateCustomer();
    break;
		
  case 'delete' :
    deleteCustomer();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
  }

			
function addCustomer()
{
			
		$customer_name = strtoupper(mysql_escape_string($_POST[customer_name]));
		$customer_name3 = strtoupper(mysql_escape_string($_POST[customer_name3]));
		$customer_type_id = $_POST[customer_type_id];	
		$customer_code = $_POST[customer_code];
		$customer_parent_code = $_POST[customer_parent_code];
		$reg_no = $_POST[reg_no];
		$gst_no = $_POST[gst_no];
		$address1 = $_POST[address1];
		$address2 = $_POST[address2];
		$address3 = $_POST[address3];
		$address4 = $_POST[address4];
		$address5 = $_POST[address5];		
		$city = $_POST[city];
		$postcode = $_POST[postcode];
		$state = $_POST[state];
		$country = $_POST[country];
		$tel = $_POST[tel];
		$fax = $_POST[fax];
		$email = $_POST[email];
		$contact_person = mysql_escape_string($_POST[contact_person]);
		$remark = mysql_escape_string($_POST[remark]);	
		$cust_region_id = $_POST[cust_region_id];
		
		//$sales_id = $_POST[sales_id];
		$tmb_name = mysql_escape_string($_POST[tmb_name]);
		
		//$tmb_sw = $_POST[tmb_sw];
		
		$company_id = $_SESSION[company_id];
		
		if($cust_region_id == '')
		{
			$cust_region_id = 0;	
		}
  
		if($customer_name!="")
		{
			if(!checkCustomer($customer_code, 0) or $customer_code == '' or $customer_code == NULL)
			{
			
				$sql = "SELECT user_id
								FROM user
								WHERE tmb_name = '$tmb_name' and delete_sw = 0
							 ";
				$result = dbQuery($sql);	
				$rowStatus=dbFetchAssoc($result);    
				$sales_id = $rowStatus[user_id];	
				if($sales_id > 0)
				{
				
				}
				else
				{
					$sales_id = 0;
				}
			
	
				$sql = "INSERT INTO customer(company_id,customer_type_id, customer_name,customer_name3, sales_id, user_tmb_name, customer_code,customer_parent_code, 
								address1, address2,address3,address4,address5,city, state, postcode,country,
								tel, fax,remark, cust_region_id, created_by, created_date)		
								VALUES('$company_id','$customer_type_id','$customer_name','$customer_name3', '$sales_id', '$tmb_name','$customer_code','$customer_parent_code', 
								 '$address1','$address2','$address3','$address4','$address5','$city','$state','$postcode','$country',
								 '$tel','$fax','$remark','$cust_region_id', $_SESSION[user_id], NOW())
								";
				dbQuery($sql);
				
				$customer_id = mysql_insert_id();
				
				$displayMsg = "added";
				$jsonArray= array('id' => $customer_id,'success' => 1, 'displayMsg' => $displayMsg); //*1 value is named LastID
				echo json_encode($jsonArray);	  
					//header('Location: index.php?view=detail&id='.$mid);
				//echo "success";
	
				
			}
			else
			{
	
				$displayMsg = "Duplicate Customer Code";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
				echo json_encode($jsonArray);	
					//return $response;
				
	
			}
		}
		else
		{
			$displayMsg = "Missing Company Name";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
			echo json_encode($jsonArray);
		}
}


function updateCustomer()
{
	$id = $_GET[id];
  
  if($_POST)
  {
	
		$customer_name = strtoupper(mysql_escape_string($_POST[customer_name]));
		$customer_name3 = strtoupper(mysql_escape_string($_POST[customer_name3]));
		$customer_code = $_POST[customer_code];
		$customer_parent_code = $_POST[customer_parent_code];
		$customer_type_id = $_POST[customer_type_id];
		$reg_no = $_POST[reg_no];
		$gst_no = $_POST[gst_no];
		$address1 = mysql_escape_string($_POST[address1]);
		$address2 = mysql_escape_string($_POST[address2]);
		$address3 = mysql_escape_string($_POST[address3]);
		$address4 = mysql_escape_string($_POST[address4]);
		$address5 = mysql_escape_string($_POST[address5]);
		$city = $_POST[city];
		$postcode = $_POST[postcode];
		$state = $_POST[state];
		$country = $_POST[country];
		$tel = $_POST[tel];
		$fax = $_POST[fax];
		$email = $_POST[email];
		$contact_person = mysql_escape_string($_POST[contact_person]);
		$remark = mysql_escape_string($_POST[remark]);	
		$duty_check = mysql_escape_string($_POST[duty_check]);
		
		//$sales_id = $_POST[sales_id];
		$tmb_name = mysql_escape_string($_POST[tmb_name]);
		$cust_region_id = $_POST[cust_region_id];
		
		//$tmb_sw = $_POST[tmb_sw];
  
		if(!checkCustomer($customer_code, $id) or $customer_code == '')
		{    

				$sql = "SELECT user_id
								FROM user
								WHERE tmb_name = '$tmb_name' and delete_sw = 0
							 ";
				$result = dbQuery($sql);	
				$rowStatus=dbFetchAssoc($result);    
				$sales_id = $rowStatus[user_id];	
				if($sales_id > 0)
				{
				
				}
				else
				{
					$sales_id = 0;
				}

				$sql = "UPDATE customer
								SET customer_type_id = '$customer_type_id',customer_name = '$customer_name',customer_name3 = '$customer_name3',
								customer_code = '$customer_code',customer_parent_code = '$customer_parent_code',
								address1 = '$address1',address2 = '$address2',address3 = '$address3',address4 = '$address4',address5 = '$address5',
								city = '$city',postcode = '$postcode',
								state = '$state',country = '$country',
								tel = '$tel',fax = '$fax', duty_check = '$duty_check', sales_id = '$sales_id',user_tmb_name = '$tmb_name',
								cust_region_id = '$cust_region_id',
								remark = '$remark', modified_by = $_SESSION[user_id]
								WHERE customer_id = $id
							 ";
				dbQuery($sql);
				
				
				
				$displayMsg = "updated";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);	
				
		}
		else
		{
				$displayMsg = "Duplicate Customer Code";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
				echo json_encode($jsonArray);			
		}
  }

}

function deleteCustomer()
{
	$id = $_GET[id];
  
  if($_POST)
  {
    
    $sql = "UPDATE customer
            SET delete_sw = '1', delete_by = $_SESSION[user_id],
						modified_by = $_SESSION[user_id]
            WHERE customer_id = $id
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

function checkCustomer($customer_code, $cust_id)
{
  $sql = "SELECT customer_code
          FROM customer
          WHERE customer_code = '$customer_code' and customer_id <> '$cust_id'
         ";
  $result=dbQuery($sql);
  if(dbNumRows($result)==1)
  {
    return true;
  }
  else
  {
    return false;
  }
}


?>
