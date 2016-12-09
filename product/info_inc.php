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

				
  case 'delete' :
    delete();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
	
	case 'addProductCommRate' :
    addProductCommRate();
    break;
	
	case 'updateProductCommRate' :
    updateProductCommRate();
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
		$weight_in_gram = $_POST[weight_in_gram];
		$personal_comm = $_POST[personal_comm];
		$product_description = mysql_escape_string($_POST[product_description]);
		
		$period_id = $_POST[period_id];
		$p_comm_level1 = $_POST[p_comm_level1];
		$p_comm_level2 = $_POST[p_comm_level2];
		$p_comm_level3 = $_POST[p_comm_level3];
		$p_personal_comm = $_POST[p_personal_comm];

		if($product_name!="") 
		{
	
				$id = insertProduct($product_code, $product_category, $product_name, $product_short_name, $selling_price, $cost_of_good_sold, $profit, $bonus_pool, $comm_level1, $comm_level2,$comm_level3, $point_value, $gst_rate_type, $gst_rate, $weight_in_gram, $product_description, $personal_comm);
				
				$dataCompanySetup = getCompanySetupDetailForm(1);
				$commission_period_sw = $dataCompanySetup['commission_period_sw'];
				
				if($commission_period_sw == 1)
				{
					$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "SELECT * from commission_period";
					$q = $pdo->prepare($sql);
					$q->execute();
					while ($row = $q->fetch(PDO::FETCH_ASSOC)) 
					{
						$period_id = $row[period_id];
						
						addProductCommissionRate($id, $period_id, $p_comm_level1, $p_comm_level2, $p_comm_level3, $p_personal_comm);
					}
				}
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
		$weight_in_gram = $_POST[weight_in_gram];
		$personal_comm = $_POST['personal_comm'];
		$product_description = mysql_escape_string($_POST[product_description]);
		
	if($id != '')
	{
		
		//update database
		updateProductDetail($id, $product_code, $product_category, $product_name, $product_short_name, 
		$selling_price, $cost_of_good_sold, $profit, $bonus_pool, $comm_level1, $comm_level2,$comm_level3, 
		$point_value, $gst_rate_type, $gst_rate, $weight_in_gram, $product_description, $personal_comm);
		
		
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
		if(checkProductExistOnOrder($id)) { //if sales order already has this product
			
			updateProductStatus($id, 0);
			
		}else{
			
			deleteTableDetail('product', 'product_id', $id);
			
		}
		
		
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

function addProductCommRate()
{
		$id = $_GET['id'];
		
		$period_id = $_POST[period_id];
		$p_comm_level1 = $_POST[p_comm_level1];
		$p_comm_level2 = $_POST[p_comm_level2];
		$p_comm_level3 = $_POST[p_comm_level3];
		$p_personal_comm = $_POST[p_personal_comm];
		
		if ($period_id !='')
		{
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into product_comm_rate (product_id, period_id, p_comm_level1, p_comm_level2, p_comm_level3, p_personal_comm, created_by, created_date) values (:id, :period_id, :p_comm_level1, :p_comm_level2, :p_comm_level3, :p_personal_comm, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':id', $id);
			$q->bindValue(':period_id',!empty($period_id) ? $period_id : 0);
			$q->bindValue(':p_comm_level1',!empty($p_comm_level1) ? $p_comm_level1 : 0);
			$q->bindValue(':p_comm_level2',!empty($p_comm_level2) ? $p_comm_level2 : 0);
			$q->bindValue(':p_comm_level3',!empty($p_comm_level3) ? $p_comm_level3 : 0);
			$q->bindValue(':p_personal_comm',!empty($p_personal_comm) ? $p_personal_comm : 0);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $estimate_id = $pdo->lastInsertId();
			Database::disconnect();
			
				
			//sucess show updated message
			$displayMsg = "added";
			$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);	  


		}
		else
		{
			//show error message
			$displayMsg = "All Period Name Already Added";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}


function updateProductCommRate()
{
		$id = $_GET['id'];
		$rate_id = $_POST[rate_id];
		$p_comm_level1 = $_POST[p_comm_level1];
		$p_comm_level2 = $_POST[p_comm_level2];
		$p_comm_level3 = $_POST[p_comm_level3];
		$p_personal_comm = $_POST[p_personal_comm];
		
	if($id !="")
		{
	
				//update database
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);							
				$sql = "UPDATE product_comm_rate  set p_comm_level1 = :p_comm_level1, p_comm_level2 = :p_comm_level2, p_comm_level3 = :p_comm_level3, p_personal_comm = :p_personal_comm, modified_by = :modified_by WHERE rate_id = :rate_id";			
          	 	$q = $pdo->prepare($sql);
				$q->bindValue(':rate_id', $rate_id);
				$q->bindValue(':p_comm_level1',!empty($p_comm_level1) ? $p_comm_level1 : 0);
				$q->bindValue(':p_comm_level2',!empty($p_comm_level2) ? $p_comm_level2 : 0);
				$q->bindValue(':p_comm_level3',!empty($p_comm_level3) ? $p_comm_level3 : 0);
				$q->bindValue(':p_personal_comm',!empty($p_personal_comm) ? $p_personal_comm : 0);
				$q->bindValue(':modified_by', $_SESSION[user_id]);
				$update = $q->execute();
				
				Database::disconnect();
				
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


?>
