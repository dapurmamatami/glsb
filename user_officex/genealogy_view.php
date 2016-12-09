<style type="text/css">
/* Define look of the table */
table {
    border-width: 1px;
		background-color: #DCDCB8;
    /* background-color: #52E385; */
}
tr, td {
    padding: 1px;
}

/* border-top-style example classes */
.b1 {border-top-style:none;}
.b2 {border-top-style:hidden;}
.b3 {border-top-style:dotted;}
.b4 {border-top-style:dashed;}
.b5 {border-top-style:solid;}
.b6 {border-top-style:double;}
.b7 {border-top-style:groove;}
.b8 {border-top-style:ridge;}
.b9 {border-top-style:inset;}
.b10 {border-top-style:outset;}
</style>

<?php

echo genealogy_view();

function genealogy_view()
{


			$user_name = $_GET['id'];
			
			$sql = "SELECT *
							FROM user
							WHERE user_name = '$user_name'
						 ";
			$result = dbQuery($sql);
			if(dbNumRows($result)==1)
			{
				$row=dbFetchAssoc($result);
				
				$u_id = $row[u_id];
				$id = $row[user_id];
				$upline_id = $row[upline_id];
				$user_name = $row[user_name];
				$full_name = $row[name];
				$name = substr($row[name],0,10);
				
				if($upline_id == 0)
				{
					$upline_id = 1;
				}
	

		//$upline_id = $_GET['user_id'];


			$upline_name = getCode('user', 'name', 'user_id', $upline_id);
		
	
?>



	
<form id="theForm" name="theForm" method="post" action="">


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="57%"><strong>Genealogy View for</strong> : <?php echo $full_name; ?> </td>
    <td width="23%"><div align="right"><strong>Member ID</strong></div></td>
    <td width="15%"><div align="right">
      <input name="id" type="text" id="id" value="<?php echo $_GET['id']; ?>" size="20" />
    </div></td>
    <td width="5%"><div align="right">
        <input name="SubmitCancel" type="submit" class="button" id="SubmitCancel" value="Search" onClick="document.theForm.action='info_inc.php?action=searchGenealogy'" />
    </div></td>
  </tr>
</table>
<br />
</form>

<div class="box-body table-responsive no-padding">		
<table class="table table-hover">
<!--		
<table width="100" border="1" align="center">
-->
	<tr>
      <?php
        echo '<td width="100" valign="top" class="b3">';
        echo '<div align="center"><img src="../images/user_active.gif" width="35" height="35" /></div>';
        echo '<div align="center">' . $user_name . '</div>';
				echo '<div align="center">' . $name . '</div>';
        echo '<div align="center"> | </div>';
        

				$sql = "SELECT count(*) as downline_no
								FROM user
								WHERE upline_id = $id
							 ";
				$result = dbQuery($sql);
				$row=dbFetchAssoc($result);
				$downline_no = $row[downline_no];
				
				$sql = "SELECT count(*) as downline_no
								FROM user
								WHERE upline_id2 = $id
							 ";
				$result = dbQuery($sql);
				$row=dbFetchAssoc($result);
				$downline_no2 = $row[downline_no];
				
				$sql = "SELECT count(*) as downline_no
								FROM user
								WHERE upline_id3 = $id
							 ";
				$result = dbQuery($sql);
				$row=dbFetchAssoc($result);
				$downline_no3 = $row[downline_no];		
			
				$total_width = ($downline_no + $downline_no + $downline_no2 + $downline_no2 + $downline_no3 + $downline_no3 ) * 100;
				/**
				if($downline_no2 > $downline_no)
				{
					$downline_no = $downline_no2;
				}		
				if($downline_no3 > $downline_no)
				{
					$downline_no = $downline_no3;
				}	
				**/								
			?>
	</tr>
</table>


      <?php 
							  //$downline_no = 1;	  
			if($downline_no == 0 ) { ?>

			<table width="100" border="1" align="center">
							    <tr>
								    <td>&nbsp;</td>
        </tr>
								  <tr>
								   <td align="center"><a href="index.php?view=add&u_id=<?php echo $u_id; ?>"><img src="../images/user_add.png" width="30" height="30" border="0" /></a> </td>
	      </tr>
								  <tr>
								    <td>&nbsp;</td>
	      </tr>
								  <tr>
								    <td>&nbsp;</td>
	      </tr>
								  <tr>
								    <td align="center">&nbsp;</td>
        </tr>
			</table>
                              
      <?php } else { 
			
							  $x = 1;
							  $lastColumn = $downline_no + 1;
								$total_column = $downline_no + $downline_no;
								//$total_width = ($total_column + 2) * 100;
							  ?>
							  
			<table border="1" align="center" width=<?php echo $total_width; ?>>	
          <tr> 
            <?php
						$sql = "SELECT *
										FROM user
										WHERE upline_id = $id
									 ";
						$result = dbQuery($sql);
						//$row=dbFetchAssoc($result);

						for ($x = 1; $x <= $lastColumn; $x++)  // first level column loop
						
            {		


									if($x == $lastColumn )
									{
										echo '<td width="100" valign="top" class="b3">';
										echo '<div align="center"><a href="index.php?view=add&u_id=';
										echo $u_id;									
										echo '"><img src="../images/user_add.png" width="35" height="35" /></a></div>';								
									}
									
									if(dbNumRows($result)>0) {	
							  	while($row=dbFetchAssoc($result)) // first level downline loop
									{

										$upline_id = $row[upline_id];
										$u_id2 = $row[u_id];
										$user_id = $row[user_id];
										$user_name = $row[user_name];
										$name = substr($row[name],0,10);
												
										echo '<td width="100" valign="top" class="b3">';
										echo '<div align="center"><img src="../images/user_active.gif" width="35" height="35" /></div>';
										echo '<div align="center">' . $user_name . '</div>';
										echo '<div align="center">' . $name . '</div>';		
										echo '<div align="center"> | </div>';

				?>
				
				
				
													<?php
													$sql = "SELECT count(*) as downline_no2
																	FROM user
																	WHERE upline_id = $user_id
																 ";
													$result2 = dbQuery($sql);
													$row=dbFetchAssoc($result2);
													$downline_no2 = $row[downline_no2];		

													$i = 1;
													$lastColumn2 = $downline_no2 + 1;	
													
													
													$sql = "SELECT count(*) as downline_no3
																	FROM user
																	WHERE upline_id2 = $user_id
																 ";
													$result2 = dbQuery($sql);
													$row=dbFetchAssoc($result2);
													$downline_no3 = $row[downline_no3];													

													if($downline_no3 > $downline_no2)
													{
														$downline_no2 = $downline_no3;
													}		

	
													$total_column = $downline_no2 + $downline_no2  + $downline_no3;	
													$total_width2 = ($total_column) * 100;		
													
													?>				
                      
										<table border="1" align="center" width = <?php echo $total_width2; ?>>	
												<tr> 
												<?php
		 																							  
												
													$sql = "SELECT *
																	FROM user
																	WHERE upline_id = $user_id
																 ";
													$result2 = dbQuery($sql);
													//$row=dbFetchAssoc($result);
																																	
													for ($i = 1; $i <= $lastColumn2; $i++) { // second level column loop
			
			
															if($i == $lastColumn2 )
															{
																echo '<td width="100" valign="top" >';
																echo '<div align="center"><a href="index.php?view=add&u_id=';
																echo $u_id2;									
																echo '"><img src="../images/user_add.png" width="35" height="35" /></a></div>';		
															}
															
															if(dbNumRows($result2)>0) {							
															while($row=dbFetchAssoc($result2)) // second level downline loop
															{		
																	$upline_id = $row[upline_id];
																	$user_id = $row[user_id];
																	$u_id3 = $row[u_id];
																	$user_name = $row[user_name];
																	$name = substr($row[name],0,10);
																	
																	echo '<td width="100" valign="top" class="b3">';
																	if($i == $lastColumn2 )
																	{
																			echo '<div align="center"><a href="index.php?view=add&u_id=';
																			echo $u_id3;									
																			echo '"><img src="../images/user_add.png" width="35" height="35" /></a></div>';		
																	}
																	else
																	{
																			echo '<div align="center"><img src="../images/user_active.gif" width="35" height="35" /></div>';
																			echo '<div align="center">' . $user_name . '</div>';
																			echo '<div align="center">' . $name . '</div>';		
																			echo '<div align="center"> | </div>';
																			echo '<div>' . $row['url'] . '</div>';
																			//echo '</td>';														
																	}
	
											 ?>
	

  
	

													
															<?php
									 
															$sql = "SELECT count(*) as downline_no
																								FROM user
																								WHERE upline_id = $user_id
																							 ";
															$result3 = dbQuery($sql);
															$row3=dbFetchAssoc($result3);
															$downline_no3 = $row3[downline_no];		
														 
															$j = 1;
							  							$lastColumn3 = $downline_no3 + 1;	
															$total_width3 = $lastColumn3 * 100;
																				
																				
															if($downline_no3 == 0 ) { 
															?>
																	<table border="1" align="center" height="60" >	
																		<tr> 															
																	<?php 															
																		//echo '<table border="1" align="center">	';
																		//echo '<tr>';
																		echo '<td width="100" valign="top" class="b3">';
																		echo '<div align="center"><a href="index.php?view=add&u_id=';
																		echo $u_id3;									
																		echo '"><img src="../images/user_add.png" width="35" height="35" /></a></div>';		
																		//echo '</tr>';
																	 // echo '</table>';
																	?>
																		</tr>
																	</table>												
											
															<?php } else { ?>






																<table border="1" align="center" width=<?php echo $total_width3; ?>>	
																			<tr> 
																			<?php
									 
																											  
																			
																				$sql = "SELECT *
																								FROM user
																								WHERE upline_id = $user_id
																							 ";
																				$result3 = dbQuery($sql);
																				//$row=dbFetchAssoc($result);
																																								
																				for ($j = 1; $j <= $lastColumn3; $j++) { // second level column loop
										
										
																						if($j == $lastColumn3 )
																						{
																							echo '<td width="100" valign="top" class="b3">';
																							echo '<div align="center"><a href="index.php?view=add&u_id=';
																							echo $u_id3;									
																							echo '"><img src="../images/user_add.png" width="35" height="35" /></a></div>';	

																			
																						}
																												
																						while($row=dbFetchAssoc($result3)) // second level downline loop
																						{		
																								$upline_id = $row[upline_id];
																								$user_id = $row[user_id];
																								$user_name = $row[user_name];
																								$name = substr($row[name],0,10);
																								
																								echo '<td width="100" valign="top" class="b3">';
																								if($j == $lastColumn3 )
																								{

																								}
																								else
																								{
																										echo '<div align="center"><img src="../images/user_active.gif" width="35" height="35" /></div>';
																										echo '<div align="center">' . $user_name . '</div>';
																										echo '<div align="center">' . $name . '</div>';																										echo '<div>' . $row['url'] . '</div>';
																										echo '</td>';														
																								}
										
																	
																			
																						}//end while loop - third level downline loop
																																		
																				}// end for loop - third level column loop
																				?>
																	</tr>
													</table>	    


															<?php } // end of if $downline_no3 <> 0?>
	
	



													</td>

													<?php 
															}
															}//end while loop - second level downline loop
																											
													}// end for loop - second level column loop
													?>
											</tr>
						</table>	                                
                                
                                
                  <?php
									echo '</td>';
									
									}
							  	}//end of while loop - first level downline loop
									
							}//end for loop - // first level column loop
							?>
							
  			</tr>
			</table>	
          </div>		
			<?php }  // end of downline_no == 0 ?>

<?php } 
	else
	{
	?>	
		
	<form id="theForm" name="theForm" method="post" action="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="57%">Genealogy View for : </td>
			<td width="23%"><div align="right"><strong>Member ID</strong></div></td>
			<td width="15%"><div align="right">
				<input name="id" type="text" id="id" value="<?php echo $_GET['id']; ?>" size="20" />
			</div></td>
			<td width="5%"><div align="right">
					<input name="SubmitCancel" type="submit" class="button" id="SubmitCancel" value="Search" onClick="document.theForm.action='info_inc.php?action=searchGenealogy'" />
			</div></td>
		</tr>
	</table>
	<div align="center">
	  <p>&nbsp;</p>
	  <p>No Record Found for Member ID - <?php echo $_GET['id']; ?><br />
    </p>
	</div>
	</form>	
	
	<?php 
	}
}
// end of function ?>

