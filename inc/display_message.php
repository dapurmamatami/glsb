<?php 

function displayMsg($msg)
{
	switch ($msg)
	{
		case "deleted":
			$divClass = "icon fa fa-ban";
			$msgContent = "Record Deleted Sucessfully!";
			break;
		case "added":
			$divClass = "icon fa fa-ban";
			$msgContent = "Record Added Sucessfully!";
			break;
		case "updated":
			$divClass = "icon fa fa-ban";
			$msgContent = "Record Updated Sucessfully!";
			break;
		case "send":
			$divClass = "icon fa fa-ban";
			$msgContent = "Email Send Sucessfully!";
			break;			
		default:
			$divClass = "";
			$msgContent = "";
	}
	
	if($msgContent != "") { 
?>
	<div id="displayMsg" name="displayMsg" class="<?php echo $divClass; ?>">
	<?php echo $msgContent; ?>
	</div>


	<script type="text/javascript">
	
						//setTimeout(function() {
						//	$("#displayMsg").fadeOut().empty();
						//}, 2500);
	</script>		
	
<?php 

	} // end of if $msgContent not null

}
?>
