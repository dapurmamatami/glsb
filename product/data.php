<?php
include('../inc/dbconfig.php'); 

$connect = mysql_connect($dbHost, $dbUser, $dbPass)
or die('Could not connect: ' . mysql_error());
//Select The database
$bool = mysql_select_db($dbName, $connect);
if ($bool === False){
   print "can't find $database";
}

// get data and store in a json array

	$pagenum = $_GET['pagenum'];
	$pagesize = $_GET['pagesize'];
	$start = $pagenum * $pagesize;
	

	$query = "SELECT SQL_CALC_FOUND_ROWS *, product.product_id as product_id2, format((profit / selling_price * 100),2) as profit_percentage, COALESCE(sum(qty_in),0) as total_qty_in, COALESCE(sum(qty_out),0) as total_qty_out, COALESCE(sum(qty_in),0)-COALESCE(sum(qty_out),0) as balance FROM product left join stock_history on product.product_id = stock_history.product_id where product.active_sw = 1 group by product.product_id LIMIT $start, $pagesize";		
	

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$sql = "SELECT FOUND_ROWS() AS `found_rows`;";
	$rows = mysql_query($sql);
	$rows = mysql_fetch_assoc($rows);
	$total_rows = $rows['found_rows'];
	$filterquery = "";
	

	// filter data.
	if (isset($_GET['filterscount']))
	{
		$filterscount = $_GET['filterscount'];
		
		if ($filterscount > 0)
		{
			$where = " WHERE (";
			$tmpdatafield = "";
			$tmpfilteroperator = "";
			for ($i=0; $i < $filterscount; $i++)
		    {
				// get the filter's value.
				$filtervalue = $_GET["filtervalue" . $i];
				// get the filter's condition.
				$filtercondition = $_GET["filtercondition" . $i];
				// get the filter's column.
				$filterdatafield = $_GET["filterdatafield" . $i];
				// get the filter's operator.
				$filteroperator = $_GET["filteroperator" . $i];
				
				if ($tmpdatafield == "")
				{
					$tmpdatafield = $filterdatafield;			
				}
				else if ($tmpdatafield <> $filterdatafield)
				{
					$where .= ")AND(";
				}
				else if ($tmpdatafield == $filterdatafield)
				{
					if ($tmpfilteroperator == 0)
					{
						$where .= " AND ";
					}
					else $where .= " OR ";	
				}
				
				// build the "WHERE" clause depending on the filter's condition, value and datafield.
				switch($filtercondition)
				{
					case "NOT_EMPTY":
					case "NOT_NULL":
						$where .= " " . $filterdatafield . " NOT LIKE '" . "" ."'";
						break;
					case "EMPTY":
					case "NULL":
						$where .= " " . $filterdatafield . " LIKE '" . "" ."'";
						break;
					case "CONTAINS_CASE_SENSITIVE":
						$where .= " BINARY  " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
						break;
					case "CONTAINS":
						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
						break;
					case "DOES_NOT_CONTAIN_CASE_SENSITIVE":
						$where .= " BINARY " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
						break;
					case "DOES_NOT_CONTAIN":
						$where .= " " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
						break;
					case "EQUAL_CASE_SENSITIVE":
						$where .= " BINARY " . $filterdatafield . " = '" . $filtervalue ."'";
						break;
					case "EQUAL":
						$where .= " " . $filterdatafield . " = '" . $filtervalue ."'";
						break;
					case "NOT_EQUAL_CASE_SENSITIVE":
						$where .= " BINARY " . $filterdatafield . " <> '" . $filtervalue ."'";
						break;
					case "NOT_EQUAL":
						$where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";
						break;
					case "GREATER_THAN":
						$where .= " " . $filterdatafield . " > '" . $filtervalue ."'";
						break;
					case "LESS_THAN":
						$where .= " " . $filterdatafield . " < '" . $filtervalue ."'";
						break;
					case "GREATER_THAN_OR_EQUAL":
						$where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";
						break;
					case "LESS_THAN_OR_EQUAL":
						$where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";
						break;
					case "STARTS_WITH_CASE_SENSITIVE":
						$where .= " BINARY " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
						break;
					case "STARTS_WITH":
						$where .= " " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
						break;
					case "ENDS_WITH_CASE_SENSITIVE":
						$where .= " BINARY " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
						break;
					case "ENDS_WITH":
						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
						break;
				}

				//added by uw support
				$where = $where . ' and delete_sw = 0';
												
				if ($i == $filterscount - 1)
				{
					$where .= ")";
				}
				
				$tmpfilteroperator = $filteroperator;
				$tmpdatafield = $filterdatafield;			
			}
			// build the query.
			$query = "SELECT *, (profit / selling_price * 100) as profit_percentage FROM product ".$where;
			$filterquery = $query;
			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";
			$rows = mysql_query($sql);
			$rows = mysql_fetch_assoc($rows);
			$new_total_rows = $rows['found_rows'];		
			$query = "SELECT *, (profit / selling_price * 100) as profit_percentage FROM product ".$where." LIMIT $start, $pagesize";		
			$total_rows = $new_total_rows;	
		}
	}
	
	if (isset($_GET['sortdatafield']))
	{
	
		$sortfield = $_GET['sortdatafield'];
		$sortorder = $_GET['sortorder'];
		
		if ($sortorder != '')
		{
			if ($_GET['filterscount'] == 0)
			{
				if ($sortorder == "desc")
				{
					$query = "SELECT *, (profit / selling_price * 100) as profit_percentage FROM product ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";
				}
				else if ($sortorder == "asc")
				{
					$query = "SELECT *, (profit / selling_price * 100) as profit_percentage FROM product ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";
				}
			}
			else
			{
				if ($sortorder == "desc")
				{
					$filterquery .= " ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";
				}
				else if ($sortorder == "asc")	
				{
					$filterquery .= " ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";
				}
				$query = $filterquery;
			}		
		}
	}
	
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$orders = null;
	// get data and store in a json array
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$orders[] = array(
				'product_id' => $row['product_id2'],
				'product_code' => $row['product_code'],
				'product_category' => $row['product_category'],
				'product_name' => $row['product_name'],
				'product_short_name' => $row['product_short_name'],
				'selling_price' => $row['selling_price'],
				'profit' => $row['profit'],
				'point_value' => $row['point_value'],
				'profit_percentage' => $row['profit_percentage'],
				'balance' => $row['balance'],
		  );
	}
      $data[] = array(
       'TotalRows' => $total_rows,
	   'Rows' => $orders
	);
	echo json_encode($data);
	

	


?>