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
	
  case 'addWagesHistory' :
    addWagesHistory();
    break;
	
  case 'updateDetailWorkerWagesHistory' :
    updateDetailWorkerWagesHistory();
    break;

  case 'changeStatus' :
    changeStatus();
    break;

  case 'approve' :
    approve();
    break;
					
  case 'delete' :
    delete();
    break;

  case 'deleteWorkerWagesHistory' :
    deleteWorkerWagesHistory();			
	  
  case 'cancel' :
    cancelPage();
    break;
  }
  
  
function add()
{
		$worker_name = mysql_escape_string($_POST[worker_name]);
		$country_id = mysql_escape_string($_POST[country_id]);
		$join_date = ($_POST['join_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['join_date'])) . "" : NULL;
		$status_id = mysql_escape_string($_POST[status_id]);
		$permit_sw = mysql_escape_string($_POST[permit_sw]);
		$permit_expiry_date = ($_POST['permit_expiry_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['permit_expiry_date'])) . "" : NULL;
		$bank_id = mysql_escape_string($_POST[bank_id]);
		$bank_account_no = mysql_escape_string($_POST[bank_account_no]);
		$daily_rate = $_POST[daily_rate];
		$remark = mysql_escape_string($_POST[remark]);

		if($worker_name!="")
		{
	
				$id = addWorkerDetail($worker_name, $country_id, $join_date, $status_id, $permit_sw, $permit_expiry_date, $bank_id, $bank_account_no, $daily_rate, $remark);
				
				if ($daily_rate > 0){
					
					addWorkerWagesHistory($id, $daily_rate, $request_by);
				}				
				
				//sucess show updated message
				$displayMsg = "added";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);	  


		}
		else
		{
			//show error message
			$displayMsg = "Missing Worker Name";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function update()
{
		$id = $_GET['id'];
		$worker_name = mysql_escape_string($_POST[worker_name]);
		$country_id = mysql_escape_string($_POST[country_id]);
		$join_date = ($_POST['join_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['join_date'])) . "" : NULL;
		$status_id = mysql_escape_string($_POST[status_id]);
		$permit_sw = mysql_escape_string($_POST[permit_sw]);
		$permit_expiry_date = ($_POST['permit_expiry_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['permit_expiry_date'])) . "" : NULL;
		$bank_id = mysql_escape_string($_POST[bank_id]);
		$bank_account_no = mysql_escape_string($_POST[bank_account_no]);
		$daily_rate = $_POST[daily_rate];
		$remark = mysql_escape_string($_POST[remark]);
		
	if($id != '')
	{
		//update database
		updateWorkerDetail($id, $worker_name, $country_id, $join_date, $status_id, $permit_sw, $permit_expiry_date, $bank_id, $bank_account_no, $daily_rate, $remark);	
		
		
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
		deleteTableDetail('worker', 'worker_id', $id);
		
		
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

function changeStatus()
{
	$id = $_GET['id'];
	
	
	if($id != '')
	{
		//update database
		updateWorkerStatus($worker_id, $status_id);
		
		//sucess show updated message
		$displayMsg = "updated";
		$jsonArray= array('id' => 0,'success' => 1, 'displayMsg' => $displayMsg); 
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

function approve()
{
	$id = $_GET['id'];
	$status_id = $_GET['status_id'];
	
	
	if($id != '')
	{
		//update database
		updateWorkerStatus($id, $status_id);
		
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

function addWagesHistory()
{
		$id = $_GET['id'];
		$request_amount = $_POST[request_amount];
		$request_by = mysql_escape_string($_POST[request_by]);

		if($request_amount!="")
		{
	
			addWorkerWagesHistory($id, $request_amount, $request_by);
						
			//sucess show updated message
			$displayMsg = "added";
			$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);	  


		}
		else
		{
			//show error message
			$displayMsg = "Missing Request Amount";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function updateDetailWorkerWagesHistory()
{
		$id = $_GET['id'];
		$history_id = $_POST[history_id];
		$request_amount = $_POST[request_amount];
		$request_by = mysql_escape_string($_POST[request_by]);
	
	if($id != '')
	{
				//update database
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);							
				$sql = "UPDATE `worker_wages_history`  set `request_amount` = :request_amount, `request_by` = :request_by, `modified_by` = :modified_by WHERE history_id = :history_id";			
          	 	$q = $pdo->prepare($sql);
				$q->bindValue(':history_id', $history_id);
				$q->bindValue(':request_amount', $request_amount);
				$q->bindValue(':request_by', $request_by);
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

function deleteWorkerWagesHistory()
{
	$id = $_GET['id'];
	$history_id = $_POST[history_id];
	
	
	if($id != '')
	{
		//delete database
		deleteTableDetail('worker_wages_history', 'history_id', $history_id);	
		
		$displayMsg = "deleted";
		$jsonArray= array('id' => 2,'success' => 1, 'displayMsg' => $displayMsg); 
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
