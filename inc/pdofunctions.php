<?php
require 'pdoconfig.php';


$db = new PDO('mysql:host=localhost;dbname=hennesy;charset=utf8', 'root', 'ycy123');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

function connectDB (){
    try {
        $connectDB = new PDO('mysql:host='.HOST_NAME.';dbname='.DATABASE_NAME, USER_NAME, DB_PASSWORD);
        $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    return $connectDB;
}

function getCustomerDetails ($customerID){
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT * FROM `customer` WHERE customer_id = :id');
    $records->bindParam(':id', $customerID);
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}

function verifyUser($username, $password){
    
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT * FROM  user WHERE user_name = :username');
    $records->bindParam(':username', $username);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    
    if(count($results) > 0) {
        if (password_verify($password, $results['user_pass'])){    
            return $results['user_id'];
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function getUserDetails($param) {
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT * FROM  user WHERE user_id = :userid');
    $records->bindParam(':userid', $_SESSION['user']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    
    if(count($results) > 0) {
        return $results[$param];    
    }else{
        return false;    
    }
}
function getDistinctPBBId (){
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT DISTINCT `pbb_id`, `batchCode` FROM `matchtrx` WHERE `match_tagging` IS NULL ORDER BY RAND()');
    $records->execute();
    $results = $records->fetchAll();
	
    return $results;
}

function getDistinctNAPIC ($pbbID, $batchCode){
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT DISTINCT a.napic_id FROM matchtrx a, tp_consortium b, tp_analytica c WHERE a.pbb_id = :id and a.batchCode = :batchcode and  b.id = a.pbb_id and c.id = a.napic_id order by c.area, STR_TO_DATE(c.contract_date, \'%m-%d-%Y\') desc LIMIT 20');
    $records->bindParam(':id', $pbbID);
    $records->bindParam(':batchcode', $batchCode);
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}

function getAllNAPIC ($pbbID, $batchCode){
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT DISTINCT `napic_id` FROM `matchtrx` WHERE `pbb_id` = :id and batchCode = :batchcode');
    $records->bindParam(':id', $pbbID);
    $records->bindParam(':batchcode',  $batchCode);
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}
function getPBBDetails ($pbbID){
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT `collecteral_id`, `state`, `town`, `property_type`, `value_date`, CONCAT(`address1`, " - ",  `address2`, ", ", `address3`, ", ", `address4`) as `address`, `project_name`, `land_area`, `build_up_area`, `napic_prop_type`, `address3`, `dollar_value`, `build_up_area_unit`, `land_area_unit`, `storey` FROM `tp_consortium` WHERE `id` = :id');
    $records->bindParam(':id', $pbbID);
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}
function getPBBIDWithParam ($paramArray){
    
   
    $connectDB = connectDB();
    $query="";
    if(empty($paramArray)== false){
        $whereOptions = "";
        foreach($paramArray as $key => $value){
            
            $paramsKeyVal = " " . $key . " LIKE '%" . $value . "%' AND";     
            $whereOptions .=  $paramsKeyVal;
        }
        
        $whereOptions = substr($whereOptions, 0, -3);
       
        $query = 'SELECT DISTINCT a.id FROM tp_consortium a, matchtrx b  WHERE a.id = b.pbb_id AND'. $whereOptions.' LIMIT 50'; 
       
    }else{
        $query = 'SELECT DISTINCT a.id FROM tp_consortium a, matchtrx b WHERE a.id = b.pbb_id LIMIT 50';    
    }
    
    $records = $connectDB->prepare($query);
    
   
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}
function getNAPICDetails ($napicID){
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT `id`, `state`, `sector`, `property_type`, `price`, `address`, `lot_area_sqm`, `pbb_prop_type`, `mukim`, `area`, `residential`, STR_TO_DATE(`contract_date`, \'%m-%d-%Y\'),`lot_build_sqm` FROM `tp_analytica` WHERE `id` = :id order by area asc, STR_TO_DATE(`contract_date`, \'%m-%d-%Y\') desc');
    $records->bindParam(':id', $napicID);
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}

function updateSelection($selection, $id, $userid, $status, $pbbID, $batchCode){
    $connectDB = connectDB();
    $records = $connectDB->prepare('UPDATE `matchtrx` SET `match_tagging` = :tagging, `updated_by` = :userid, `updated_time` = NOW(), `status` = :status  WHERE `napic_id`= :id and `pbb_id`= :pbbId and `batchCode`= :batchcode');
    $records->bindParam(':tagging', $selection);
    $records->bindParam(':userid', $userid);
    $records->bindParam(':status', $status);
	$records->bindParam(':id', $id);
	$records->bindParam(':pbbId', $pbbID);
    $records->bindParam(':batchcode', $batchCode);
	if ($records->execute()){
        return true;
    }else{
        return false;
    }
}
function checkUpdated($pbbID, $batchCode){
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT * FROM matchtrx WHERE pbb_id = :pbbID AND batchCode=:batchcode AND updated_by IS NULL');
    $records->bindParam(':pbbID', $pbbID);
    $records->bindParam(':batchcode', $batchCode);
    $records->execute();
    $results = $records->fetchAll();
    if(empty($results)== true){
        return true;
    }else{
        return false;
    }
}
function approveOrRejectData($status, $userid, $pbbID, $batchCode){
    $connectDB = connectDB();
    $records = $connectDB->prepare('UPDATE `matchtrx` SET `approved` = :approval, `approved_by` = :userid WHERE `pbb_id`= :pbbId AND `batchCode`= :batchcode');
    $records->bindParam(':approval', $status);
    $records->bindParam(':tagging', $userid);
    $records->bindParam(':pbbId', $pbbID);
    $records->bindParam(':batchcode', $batchCode);
	if ($records->execute()){
        return true;
    }else{
        return false;
    }
}
function getDistinctPropertyType(){
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT DISTINCT property_type FROM tp_consortium');
    $records->execute();
    $results = $records->fetchAll();
    return $results;

	
}

function getStat ($state){
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT DISTINCT `project`, AVG(price) FROM `tp_analytica` where state = :state ');
    $records->bindParam(':state', $state);
	//$records->bindParam(':area', $area);
    $records->execute();
    $results = $records->fetchAll();

	
	return $results;
	
}
    
function getArea($state){
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT DISTINCT `area` FROM `tp_analytica` where state = :state');
    $records->bindParam(':state', $state);
	
    $records->execute();
    $results = $records->fetchAll();

	
	return $results;
	
}



?>