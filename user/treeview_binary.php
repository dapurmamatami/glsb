<?php


echo treeview_binary();


  function hasChild($parent_id)
  {
    $sql = "SELECT COUNT(*) as count FROM user WHERE upline_id = '" . $parent_id . "'";
    $qry = mysql_query($sql);
    $rs = mysql_fetch_array($qry);
    return $rs['count'];
  }
  
  function CategoryTree($list,$parent,$append)
  {
    $list = '<li item-expanded="false">'.$parent['name']. " (". $parent['member_reg_no'] . ")";
    
    if (hasChild($parent['user_id'])) // check if the id has a child
    {
      $append++;
      $list .= "<ul>";
	  
      $sql = "SELECT * FROM user WHERE upline_id = '" . $parent['user_id'] . "'";
      $qry = mysql_query($sql);
      $child = mysql_fetch_array($qry);
      do{
        $list .= CategoryTree($list,$child,$append);
      }while($child = mysql_fetch_array($qry));
      $list .= "</ul>. </li>";
    }
    return $list;
  }
  function CategoryList($user_id)
  {
    $list = "";
    //$user_id = 1;
    $sql = "SELECT * FROM user where user_id = '$user_id'";
    $qry = mysql_query($sql);
    $parent = mysql_fetch_array($qry);
    $mainlist = "<ul>";
    do{
      $mainlist .= CategoryTree($list,$parent,$append = 0);
    }while($parent = mysql_fetch_array($qry));
    $list .= "</ul>";
    return $mainlist;
  }

function treeview_binary()
{



	
?>




   <!-- 
   <div id='jqxTree'>     
		
		<ul>            
            <li item-expanded='false'>Solutions
              <ul>
                  <li item-expanded='false'>Education</li>
                        <ul>
                            <li>Consumer photo and video</li>
                                <ul>
                                    <li>Consumer photo and video</li>
                                    <li>Mobile</li>
                                    <li>Rich Internet applications</li>
                                    <li>Technical communication</li>
                                    <li>Training and eLearning</li>
                                    <li>Web conferencing</li>
                                </ul>
                            <li>Mobile</li>
                            <li>Rich Internet applications</li>
                            <li>Technical communication</li>
                            <li>Training and eLearning</li>
                            <li>Web conferencing</li>
                        </ul>                  
                  <li>Financial services</li>
                  <li>Government</li>
                  <li>Manufacturing</li>
                  <li>Solutions
                        <ul>
                            <li>Consumer photo and video</li>
                            <li>Mobile</li>
                            <li>Rich Internet applications</li>
                            <li>Technical communication</li>
                            <li>Training and eLearning</li>
                            <li>Web conferencing</li>
                        </ul>
                  </li>
                  <li>All industries and solutions</li>
              </ul>
            </li>
        </ul>     
            
   </div>       
	-->
           
                
    <?php
    

    if($_SESSION['user_grp']==1)
    {
		$main_user_id = 2;
	}
	else
	{
		$main_user_id = $_SESSION[user_id];
	}
		
    
    ?>
    
    
    <script type="text/javascript">
            $(document).ready(function () {
                // Create jqxTree
                $('#jqxTree').jqxTree({ height: '500px', width: '800px' });
                
                /**
                $('#jqxTree').bind('select', function (event) {
                    var htmlElement = event.args.element;
                    var item = $('#jqxTree').jqxTree('getItem', htmlElement);
                    alert(item.label);
                });
                **/
            });
    </script>
    
    <div id='jqxTree'>
    
    <?php
    
    
            echo CategoryList($main_user_id); 
            
    ?>	
    </div>
        
    


               

	
<?php 


}
// end of function ?>

