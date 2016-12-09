<?php

echo tree_view();

  function hasChild($parent_id)
  {
    $sql = "SELECT COUNT(*) as count FROM user_pool WHERE upline_id = '" . $parent_id . "'";
    $qry = mysql_query($sql);
    $rs = mysql_fetch_array($qry);
    return $rs['count'];
  }
  
  function CategoryTree($list,$parent,$append)
  {
    $list = '<li item-expanded="false">'.$parent['user_name']. " (". $parent['join_date'] . ")";
    
    if (hasChild($parent['user_id'])) // check if the id has a child
    {
      $append++;
      $list .= "<ul>";
	  
      $sql = "SELECT * FROM user_pool WHERE upline_id = '" . $parent['user_id'] . "'";
      $qry = mysql_query($sql);
      $child = mysql_fetch_array($qry);
      do{
        $list .= CategoryTree($list,$child,$append);
      }while($child = mysql_fetch_array($qry));
      $list .= "</ul>. </li>";
    }
    return $list;
  }
  function CategoryList($main_user_id)
  {
    $list = "";
    $user_id = 1;
    $sql = "SELECT * FROM user_pool where upline_id = '$main_user_id'";
    $qry = mysql_query($sql);
    $parent = mysql_fetch_array($qry);
    $mainlist = "<ul>";
    do{
      $mainlist .= CategoryTree($list,$parent,$append = 0);
    }while($parent = mysql_fetch_array($qry));
    $list .= "</ul>";
    return $mainlist;
  }

function tree_view()
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

$user_name = $_SESSION['user_name'];
		
$sql = "SELECT *
                FROM user_pool
				where user_name = '$user_name'
                order by user_id
				limit 1
               ";
$resultTotal=dbQuery($sql);
if(dbNumRows($resultTotal)>0)
{
	while($rowTotal=dbFetchAssoc($resultTotal))
	{


		$main_user_id = $rowTotal['user_id'];
		$main_level_name = $rowTotal['level_name'];	

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
		echo CategoryList(1); 
		
?>	
</div>
<?php	
		
	
	}


}

else
{
	echo "No record found!";
}

?>           



               

	
<?php 


}
// end of function ?>

