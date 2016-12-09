<?php
include "../inc/pdoconfig.php";
//include "../main/session.php";
include "../main/functions.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';


				$displayMsg = "added";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);


?>
