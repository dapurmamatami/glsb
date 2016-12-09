<?php

echo genealogy_view();

$total =0;


function getTotalLeg($memid,$leg){
  $sql="select user_id from user where 
        upline_id='".$memid."' and placement_side='".$leg."'";
    
  $res=mysql_query($sql);
  
  global $total;
   
    
  $total=$total+mysql_num_rows($res);
  $row=mysql_fetch_array($res);
 
     if($row['user_id']!=''){
       getTotalLeg ($row['user_id'],'Left');
       getTotalLeg ($row['user_id'],'Right');
      }

    return $total;

}  

function user_info($user_name, $side)
{

   $sql = "SELECT *
           FROM user
           WHERE upline_user_name = '$user_name' and placement_side='$side'
   		  ";
   $result = dbQuery($sql);
   if(dbNumRows($result) > 0)
   {
       $row=dbFetchAssoc($result);
	   $user_name = $row['user_name'];
	   
	   return $user_name;

   }
}


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
				$join_date = $row[join_date];
				$total=0; 
				$total_left = getTotalLeg($id,'Left');
				
				
				global $total;
				$total = 0;
				$total_right = getTotalLeg($id,'Right');
				

			

			


	
   		
?>


              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">    
                         <div class="box-header with-border">
                          
                        	 <form class="form-horizontal" action="info_inc.php?action=searchGenealogy" method="post" name="theForm" id="theForm">
                            <div class="form-group">

                              <div class="col-sm-2">
                                <input type="text" class="form-control" id="id" name="id" placeholder="Member ID">
                              </div>
                              <button type="submit" class="btn btn-info">Search</button>
                            </div>                          
                            </form>
                          </div><!-- /.box-header -->
                         

                  <table width="100%" border="0">
                    <tr>
                      <td align="center"><img src="../images/user_active.gif" width="38" height="38" /><br />
                        <?php echo $user_name;  echo " {"; echo $total_left; echo " : "; echo $total_right; echo "}"?>
                        <br />
                        Sponsor : <?php echo $user_name; ?>
                        <br />  
                        Join Date : <?php echo $join_date; ?>
                        <br />                                               
                      <img src="../images/genealogy_line.png" width="250" height="31" /><br />

                                         
                      <table width="450" border="0">
                        <tr>
                          <td align="center" valign="top"><?php
                        //second level left 
                        
                        $sql = "SELECT *
                                        FROM user
                                        WHERE upline_user_name = '$user_name' and placement_side='Left'
                                     ";
                        $resultLevel2Left = dbQuery($sql);
                        if(dbNumRows($resultLevel2Left) > 0)
                        {
                            $rowLevel2Left=dbFetchAssoc($resultLevel2Left);
                            
                            $id = $rowLevel2Left[user_id];
							$user_name_level2left = $rowLevel2Left[user_name];
                            $total=0; 
                            $total_left = getTotalLeg($id,'Left');
                            
                            
                            global $total;
                            $total = 0;
                            $total_right = getTotalLeg($id,'Right');
                            
            
                        
					  ?>                          
                            <a href="index.php?view=genealogy_binary&amp;id=<?php echo $rowLevel2Left[user_name]; ?>"><img src="../images/user_active.gif" width="38" height="38" /></a><br />
                        <?php echo $rowLevel2Left[user_name];  echo " {"; echo $total_left; echo " : "; echo $total_right; echo "}"?>
                        <br />
                        Sponsor : <?php echo $rowLevel2Left[sponsor_user_name]; ?>
                        <br />  
                        Join Date : <?php echo $rowLevel2Left[join_date]; ?>
                        
                      <?php } else { ?>   <a href="index.php?view=add&amp;upline=<?php echo $user_name; ?>&amp;side=left"><img src="../images/user_add.png" width="38" height="38" /></a><br /> 
                      <?php } ?>
                      <br /> 
                          
                          <img src="../images/genealogy_line.png" width="250" height="31" /></td>
                            
                          <td align="center" valign="top"><?php
                        //second level right 
                        
                        $sql = "SELECT *
                                        FROM user
                                        WHERE upline_user_name = '$user_name' and placement_side='Right'
                                     ";
                        $resultLevel2Right = dbQuery($sql);
                        if(dbNumRows($resultLevel2Right) > 0)
                        {
                            $rowLevel2Right=dbFetchAssoc($resultLevel2Right);
                            
                            $id = $rowLevel2Right[user_id];
							$user_name_level2Right = $rowLevel2Right[user_name];
							
                            $total=0; 
                            $total_left = getTotalLeg($id,'Left');
                            
                            
                            global $total;
                            $total = 0;
                            $total_right = getTotalLeg($id,'Right');
                            
            
                        
					  ?>                          
                            <a href="index.php?view=genealogy_binary&amp;id=<?php echo $rowLevel2Right[user_name]; ?>"><img src="../images/user_active.gif" width="38" height="38" /></a><br />
                        <?php echo $rowLevel2Right[user_name];  echo " {"; echo $total_left; echo " : "; echo $total_right; echo "}"?>
                        <br />
                        Sponsor : <?php echo $rowLevel2Right[sponsor_user_name]; ?>
                        <br />  
                        Join Date : <?php echo $rowLevel2Right[join_date]; ?>
                        
                      <?php } else { ?>   <a href="index.php?view=add&amp;upline=<?php echo $user_name; ?>&amp;side=right"><img src="../images/user_add.png" width="38" height="38" /></a><br /> 
                      <?php } ?>
                      <br />  
                          <img src="../images/genealogy_line.png" width="250" height="31" /></td>
                        </tr>
                      </table>
                      <table width="42%" border="0">
                        <tr>
                          <td width="25%" align="left" valign="top">
                     <?php
                        //third level left 1
                        
                        $sql = "SELECT *
                                        FROM user
                                        WHERE upline_user_name = '$user_name_level2left' and placement_side='Left'
                                     ";
                        $resultLevel3Left1 = dbQuery($sql);
                        if(dbNumRows($resultLevel3Left1) > 0)
                        {
                            $rowLevel3Left1=dbFetchAssoc($resultLevel3Left1);
                            
                            $id = $rowLevel3Left1[user_id];
                            $total=0; 
                            $total_left = getTotalLeg($id,'Left');
                            
                            
                            global $total;
                            $total = 0;
                            $total_right = getTotalLeg($id,'Right');
                            
            
                        
					  ?>                          
                          <a href="index.php?view=genealogy_binary&amp;id=<?php echo $rowLevel3Left1[user_name]; ?>"><img src="../images/user_active.gif" width="38" height="38" /></a><br />
                        <?php echo $rowLevel3Left1[user_name];  echo " {"; echo $total_left; echo " : "; echo $total_right; echo "}"?>
                        <br />
                        Sponsor : <?php echo $rowLevel3Left1[sponsor_user_name]; ?>
                        <br />  
                        Join Date : <?php echo $rowLevel3Left1[join_date]; ?>
                        <br />
                      <?php } else if($user_name_level2left == '') { ?>
                      	<img src="../images/user_inactive.png" width="38" height="38" />
                        <br />
                      <?php } else {
					  ?>   <a href="index.php?view=add&amp;upline=<?php echo $user_name_level2left; ?>&amp;side=left"><img src="../images/user_add.png" width="38" height="38" /></a><br /> 
                      <?php } ?> 
                        <br />  </td>
                          <td width="24%" align="right" valign="top">
<?php
                        //third level right 1
                        
                        $sql = "SELECT *
                                        FROM user
                                        WHERE upline_user_name = '$user_name_level2left' and placement_side='Right'
                                     ";
                        $resultLevel3Right1 = dbQuery($sql);
                        if(dbNumRows($resultLevel3Right1) > 0)
                        {
                            $rowLevel3Right1=dbFetchAssoc($resultLevel3Right1);
                            
                            $id = $rowLevel3Right1[user_id];

                            $total=0; 
                            $total_left = getTotalLeg($id,'Left');
                            
                            
                            global $total;
                            $total = 0;
                            $total_right = getTotalLeg($id,'Right');
                            
            
                        
					  ?>                          
                          <a href="index.php?view=genealogy_binary&amp;id=<?php echo $rowLevel3Right1[user_name]; ?>"><img src="../images/user_active.gif" width="38" height="38" /></a><br />
                        <?php echo $rowLevel3Right1[user_name];  echo " {"; echo $total_left; echo " : "; echo $total_right; echo "}"?>
                        <br />
                        Sponsor : <?php echo $rowLevel3Right1[sponsor_user_name]; ?>
                        <br />  
                        Join Date : <?php echo $rowLevel3Right1[join_date]; ?>
                        <br />
                      <?php } else if($user_name_level2left == '') { ?>
                      	<img src="../images/user_inactive.png" width="38" height="38" />
                        <br />
                      <?php } else {
					  ?>   <a href="index.php?view=add&amp;upline=<?php echo $user_name_level2left; ?>&amp;side=right"><img src="../images/user_add.png" width="38" height="38" /></a><br /> 
                      <?php } ?>  </td>
                          <td width="2%" align="left" valign="top">&nbsp;</td>
                          <td width="24%" align="left" valign="top">
                       <?php
                        //third level left 2
                        
                        $sql = "SELECT *
                                        FROM user
                                        WHERE upline_user_name = '$user_name_level2Right' and placement_side='Left'
                                     ";
                        $resultLevel3Left2 = dbQuery($sql);
                        if(dbNumRows($resultLevel3Left2) > 0)
                        {
                            $rowLevel3Left2=dbFetchAssoc($resultLevel3Left2);
                            
                            $id = $rowLevel3Left2[user_id];

                            $total=0; 
                            $total_left = getTotalLeg($id,'Left');
                            
                            
                            global $total;
                            $total = 0;
                            $total_right = getTotalLeg($id,'Right');
                            
            
                        
					  ?>                          
                          <a href="index.php?view=genealogy_binary&amp;id=<?php echo $rowLevel3Left2[user_name]; ?>"><img src="../images/user_active.gif" width="38" height="38" /></a><br />
                        <?php echo $rowLevel3Left2[user_name];  echo " {"; echo $total_left; echo " : "; echo $total_right; echo "}"?>
                        <br />
                        Sponsor : <?php echo $rowLevel3Left2[sponsor_user_name]; ?>
                        <br />  
                        Join Date : <?php echo $rowLevel3Left2[join_date]; ?>
                        <br />
                                           
                      <?php } else if($user_name_level2Right == '') { ?>
                      	<img src="../images/user_inactive.png" width="38" height="38" />
                        <br />
                      <?php } else {
					  ?>   <a href="index.php?view=add&amp;upline=<?php echo $user_name_level2Right; ?>&amp;side=left"><img src="../images/user_add.png" width="38" height="38" /></a><br /> 
                      <?php } ?> </td>
                          <td width="25%" align="right" valign="top">                       <?php
                        //third level right 2
                        
                        $sql = "SELECT *
                                        FROM user
                                        WHERE upline_user_name = '$user_name_level2Right' and placement_side='Right'
                                     ";
                        $resultLevel3Right2 = dbQuery($sql);
                        if(dbNumRows($resultLevel3Right2) > 0)
                        {
                            $rowLevel3Right2=dbFetchAssoc($result);
                            
                            $u_id = $row[u_id];
                            $id = $row[user_id];
                            $upline_id = $row[upline_id];
                            $user_name_right = $row[user_name];
                            $full_name = $row[name];
                            $name = substr($row[name],0,10);
                            $join_date = $row[join_date];
                            $total=0; 
                            $total_left = getTotalLeg($id,'Left');
                            
                            
                            global $total;
                            $total = 0;
                            $total_right = getTotalLeg($id,'Right');
                            
            
                        
					  ?>                          
                            <a href="index.php?view=genealogy_binary&amp;id=<?php echo $rowLevel3Right2[user_name]; ?>"><img src="../images/user_active.gif" width="38" height="38" /></a><br />
                        <?php echo $rowLevel3Right2[user_name];  echo " {"; echo $total_left; echo " : "; echo $total_right; echo "}"?>
                        <br />
                        Sponsor : <?php echo $rowLevel3Right2[sponsor_user_name]; ?>
                        <br />  
                        Join Date : <?php echo $rowLevel3Right2[join_date]; ?>
                        <br />
                      <?php } else if($user_name_level2Right == '') { ?>
                      	<img src="../images/user_inactive.png" width="38" height="38" />
                        <br />
                      <?php } else {
					  ?>   <a href="index.php?view=add&amp;upline=<?php echo $user_name_level2Right; ?>&amp;side=right"><img src="../images/user_add.png" width="38" height="38" /></a><br /> 
                      <?php } ?>  </td>
                        </tr>
                      </table>
                      <p><br />
                      </p></td>
                    </tr>
                  </table>   
                                                                
                    </div>
                  </div>
              </div>       
              

      
<?php 

			}
			else
			{
			?>
				
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">    
                         <div class="box-header with-border">
                          
                        	 <form class="form-horizontal" action="info_inc.php?action=searchGenealogy" method="post" name="theForm" id="theForm">
                            <div class="form-group">

                              <div class="col-sm-2">
                                <input type="text" class="form-control" id="id" name="id" placeholder="Member ID">
                              </div>
                              <button type="submit" class="btn btn-info">Search</button>
                            </div>                          
                            </form>
                          </div><!-- /.box-header -->				
				<?php
			
				
				echo "No Record Found!";
			}
} 
?>

