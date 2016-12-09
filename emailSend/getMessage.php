<?php require_once('../Connections/mydbconn.php'); ?>
<?php
$getid = $_GET['message_id'];


if(isset($_GET['message_id'])){  
  $res = mysql_query("Select * from message_template where message_id='$getid'") or die(mysql_error());
  if($inf = mysql_fetch_array($res)){
    echo "formObj.subject.value = '".$inf["message_subject"]."';\n";  
	//echo "formObj.message.value = '".$inf["message_content"]."' + \n +  '".$inf["message_content"]."'";  
	echo 'formObj.message.value = "'.$inf["message_content"].'" + "\n\n\n\n\n" + "'.$inf["message_footer"].'"';
    
  }else{
    echo "formObj.message_subject.value = '';\n";    
	echo "formObj.message.value = '';\n"; 
  
  }    
}

?> 