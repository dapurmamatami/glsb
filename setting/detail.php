<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
	if ($_GET[sub] == 'email'){
		
  getDetailForm($_GET[id],$_GET[displayMsg] );
	}
	if ($_GET[sub] == 'delivery_charge'){
		
  DeliveryChargeSettingForm($_GET[id],$_GET[displayMsg] );
	}	
	if ($_GET[sub] == 'country_setting'){
		
  CountrySettingForm($_GET[id],$_GET[displayMsg] );
	}
	if ($_GET[sub] == 'bank_setting')
	{	
		BankSettingForm($_GET[id],$_GET[displayMsg] );
	}	
}else{
  echo "You dont have the permission to this action.";
}
?>