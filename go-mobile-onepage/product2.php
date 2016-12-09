<?php 
include "../inc/pdoconfig.php";
include "../inc/dbconfig.php";
include "../main/appfunctions.php";
include "../main/session.php";
require_once 'template.php';

?>

<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM product WHERE product_code='" . $_GET["product_code"] . "'");
			$itemArray = array($productByCode[0]["product_code"]=>array('product_name'=>$productByCode[0]["product_name"], 'product_code'=>$productByCode[0]["product_code"], 'quantity'=>$_POST["quantity"], 'selling_price'=>$productByCode[0]["selling_price"]));
			
			
			
			if(!empty($_SESSION["cart_item"])) {
				
				if(in_array($productByCode[0]["product_code"],$_SESSION["cart_item"])) {
					
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["product_code"] == $k)
								$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	
	case "save":
		$so_id = addSaleOrder($id);
		foreach ($_SESSION["cart_item"] as $item){
		
		$total = ($item["selling_price"]*$item["quantity"]);
        $item_total += ($item["selling_price"]*$item["quantity"]);
		
		addSaleOrderDetailApp($so_id, $item["product_code"], $item["product_name"], $item["quantity"]);
		}
		unset($_SESSION["cart_item"]);
	break;
	
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["product_code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>

<div id="shopping-cart">
<div class="txt-heading">Shopping Cart <a id="btnEmpty" href="product2.php?action=empty">Empty Cart</a></div>
<?php
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
?>	
<table cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th><strong>Product Name</strong></th>
<th><strong>Product Code</strong></th>
<th><strong>Quantity</strong></th>
<th><strong>Price</strong></th>
<th><strong>Action</strong></th>
<th><strong>Total</strong></th>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
		
		$total = ($item["selling_price"]*$item["quantity"]);
		?>
				<tr>
				<td><strong><?php echo $item["product_name"]; ?></strong></td>
				<td><?php echo $item["product_code"]; ?></td>
				<td><?php echo $item["quantity"]; ?></td>
				<td align=right><?php echo "RM".$item["selling_price"]; ?></td>
                <td align=right><?php echo "RM".$total; ?></td>
				<td><a href="product2.php?action=remove&product_code=<?php echo $item["product_code"]; ?>" class="btnRemoveAction">Remove Item</a></td>
				</tr>
				<?php
		
        $item_total += ($item["selling_price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="5" align=right><strong>Total:</strong> <?php echo "$".$item_total; ?></td>
</tr>
</tbody>
</table>		
  <?php
}
?>
</div>

<div id="header">
      <div class="gohome radius20"></div>
      <div class="gomenu radius20"></div>
</div>
  <div class="swiper-container swiper-parent">
    <div class="swiper-wrapper">
    
<!--Menu page-->    
<!--Page 4 content-->
      <div class="swiper-slide sliderbg">
      <div class="swiper-container swiper-nested">
               <div class="swiper-wrapper">
                    <div class="swiper-slide">
                              <div class="slide-inner">
                                        <div class="pages_container">
                                        <?php if(!empty($_SESSION["cart_item"])) { ?> 
                                        <h4><a href="product2.php?action=save" class="btnRemoveAction">Checkout</a><h4>
                                        <?php } ?>
                               
                                        <div class="toogle_wrap radius8">
                                            <div class="trigger"><a href="#">My Cart - RM <?php echo $item_total; ?></a></div>
                                            <div class="toggle_container">
                                            <ul class="listing_detailed">
                                            <?php
											if(isset($_SESSION["cart_item"])){
												$item_total = 0;


	
    foreach ($_SESSION["cart_item"] as $item){
		
		$total = ($item["selling_price"]*$item["quantity"]);
		?>

                <li><?php echo $item["product_name"]; ?> - <?php echo $item["product_code"]; ?> - <?php echo $item["quantity"]; ?> <a href="product2.php?action=remove&product_code=<?php echo $item["product_code"]; ?>" class="btnRemoveAction">    <img src="images/Cancel.jpg" width="15" height="15"/></a></li>
				<?php
		
        $item_total += ($item["selling_price"]*$item["quantity"]);
		}
		?>

		
  <?php
}
?>
                                            </ul>
                                            </div>
                                        </div>
										
	<?php
	$product_array = $db_handle->runQuery("SELECT * FROM product ORDER BY product_id");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
	<form method="post" action="product2.php?action=add&product_code=<?php echo $product_array[$key]["product_code"]; ?>">
                               <div class="portfolio_item radius8">
                                             <div class="portfolio_image"><a rel="gallery-1" href="images/portfolio_thumb.jpg" class="swipebox" title="Webdesign work"><img src="images/portfolio_thumb.jpg" alt="" title="" border="0" /></a></div>
                                                 <div class="portfolio_details">
                                                 <h4><?php echo $product_array[$key]["product_name"]; ?></h4>
                                                 <p><?php echo $product_array[$key]["product_description"]; ?></p>
                                                 <p><?php echo "RM".$product_array[$key]["selling_price"]; ?></p>
                                                 <div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
                                                 <a rel="gallery-2" href="images/portfolio_thumb.jpg" class="swipebox view_details" title="Webdesign work">view details</a>
                                                 </div>
                  </div>
                                        </form>
             
                                   
	<?php
			}
	}
	?>
                                        <div class="clearfix"></div>
      									<div class="scrolltop radius20"><a href="#"><img src="images/icons/top.png" alt="Go on top" title="Go on top" /></a></div>
                                </div>
                                        <!--End of page container-->
                              </div>
                    </div>
              </div>
              <div class="swiper-scrollbar"></div>
     </div>
     </div>
                                                                                                                        
                                        <div class="clearfix"></div>
      									<div class="scrolltop radius20"><a href="#"><img src="images/icons/top.png" alt="Go on top" title="Go on top" /></a></div>
                                        </div>
                                        <!--End of page container-->
                              </div>
                    </div>
              </div>
              <div class="swiper-scrollbar"></div>
     </div>
     </div>
      

       
     <!--End of pages--> 

    </div>
    <div class="pagination"></div>
  </div>
  
