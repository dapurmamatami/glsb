<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/display_message.php";
include "../main/session.php";
include "../main/functions.php";
include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";
include "info.php";

$current_folder = basename(dirname($_SERVER['PHP_SELF']));
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
$displayMsg = (isset($_GET['displayMsg']) && $_GET['displayMsg'] != '') ? $_GET['displayMsg'] : '';
$wallet = (isset($_GET['wallet']) && $_GET['wallet'] != '') ? $_GET['wallet'] : '';

switch($view)
{
  case 'transfer' :
    $content = 'transfer.php';		
		$pageTitle = 'Wallet Transfer';  	
		$pageDescription = 'Details';  
    break;
		
  case 'detail' :
    $content = 'detail.php';		
		$pageTitle = 'Wallet Info';  	
		$pageDescription = 'Details';  
    break;

  case 'manualFlush' :
    $content = 'manualFlush.php';		
		$pageTitle = 'Daily Auto Flush';  	
		$pageDescription = 'Daily Auto Flush';  
    break;

  case 'manualWithdraw' :
    $content = 'manualWithdraw.php';		
		$pageTitle = 'Weekly Auto Withdraw';  	
		$pageDescription = 'Weekly Auto Withdraw';  
    break;
		 
   case 'add' :
    	$content = 'add.php';		
		$pageTitle = 'E-Wallet Withdraw Request';  	  
		//$pageDescription = 'Add New'; 
    break; 

   case 'withdraw' :
    $content = 'withdraw.php';		
		$pageTitle = 'Withdraw Info';  	  
		$pageDescription = ''; 
    break; 
	
	case 'listWithdraw' :
		$content = 'listWithdraw.php';		
		$pageTitle = 'E-Wallet Withdraw Request';  	  
		$pageDescription = ''; 
    break; 

	case 'listWithdrawRequest' :
		$content = 'listWithdrawRequest.php';		
		$pageTitle = 'E-Wallet Withdraw Request';  	  
		$pageDescription = ''; 
    break; 
	
	case 'listWithdrawPending' :
		$content = 'listWithdrawPending.php';		
		$pageTitle = 'E-Wallet Withdraw Request Pending';  	  
		$pageDescription = ''; 
    break; 
	
	case 'listEWalletAdjustment' :
		$content = 'listEWalletAdjustment.php';		
		$pageTitle = 'E-Wallet Ajustment';  	  
		$pageDescription = ''; 
    break; 
		      
  default:
  	if($wallet == 'ewallet')
	{
		$pageTitle = 'E-Wallet History';
		$pageDescription = '';  
		//$wallet_balance = walletBalance('acct_ewallet', $_SESSION['user_id']);	
	}
  	if($wallet == 'rwallet')
	{
		$pageTitle = 'R-Wallet History';
		$pageDescription = '';  	
		//$wallet_balance = walletBalance('acct_rwallet', $_SESSION['user_id']);		
	}	
  	if($wallet == 'mwallet')
	{
		$pageTitle = 'M-Wallet History';
		$pageDescription = '';  
		//$wallet_balance = walletBalance('acct_mwallet', $_SESSION['user_id']);			
	}
  	if($wallet == 'ewalletWithdraw')
	{
		$pageTitle = 'E-Wallet Withdraw History';
		$pageDescription = '';  
		//$wallet_balance = walletBalance('acct_mwallet', $_SESSION['user_id']);			
	}		
    $content = 'list.php';


}


?>

<?php 
require_once '../main/template.php';

?>

