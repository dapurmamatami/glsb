<?php 
include "../inc/pdoconfig.php";
include "../inc/dbconfig.php";
include "../main/appfunctions.php";
include "../main/pdofunctions.php";
include "../main/sessionContent.php";
//require_once 'template.php';

?>

<?php
session_start();
$item_total = 0;

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
		$so_id = addSaleOrderApp($id);
		foreach ($_SESSION["cart_item"] as $item){
		
		$total = ($item["selling_price"]*$item["quantity"]);
        $item_total += ($item["selling_price"]*$item["quantity"]);
		
		addSaleOrderDetailApp($so_id, $item["product_code"], $item["product_name"], $item["quantity"]);
		}
		unset($_SESSION["cart_item"]);
		
						$orderTotalData = getSaleOrderTotal($so_id);
						$total_amount = $orderTotalData[total_amount];
						$total_pv = $orderTotalData[total_pv];
						$total_weight_in_gram = $orderTotalData[total_weight_in_gram];
						$total_amount_before_tax = $orderTotalData[total_amount_before_tax];
						$total_tax_amount = $orderTotalData[total_tax_amount];
						
						$reportName = uniqid() . '-' . $so_id;
						
						updateSaleOrder($so_id, $so_address, $total_weight_in_gram, $courier_sw, $courier_amount, $total_pv, $reportName, $total_amount_before_tax, 0, $total_tax_amount, $total_amount, $ewallet_id);
						
						updateSaleOrderStatus($so_id, 1);
						
						saveReport($so_id,$reportName, 'sorder', $id);
						
						$file_name = $reportName . '.pdf';
						insertEmailSend('pendingorder', $file_name, $customer_id, 0);
						
		$item_total = 0;
								
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

<?php
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
?>

<?php		
    foreach ($_SESSION["cart_item"] as $item){
		
		$total = ($item["selling_price"]*$item["quantity"]);

		
        $item_total += ($item["selling_price"]*$item["quantity"]);
	
		
	}

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
<link rel="apple-touch-startup-image" href="images/apple-touch-startup-image-320x460.png" />
<meta name="author" content="FamousThemes" />
<meta name="description" content="GoMobile - A next generation web app theme" />
<meta name="keywords" content="mobile web app, mobile template, mobile design, mobile app design, mobile app theme, mobile wordpress theme, my mobile app" />
<title>GoMobile - A next generation web app theme</title>
<link type="text/css" rel="stylesheet" href="css/style.css"/>
<link type="text/css" rel="stylesheet" href="colors/green/green.css"/>
<link type="text/css" rel="stylesheet" href="css/idangerous.swiper.css"/>
<link type="text/css" rel="stylesheet" href="css/swipebox.css" />
<link href='http://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css' />


<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>

<style type="text/css">
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(images/Preloader_4.gif) center no-repeat #fff;
}
</style>

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
                                        <h4><a href="mycart.php?action=save" class="btnRemoveAction">Complete My Order</a><h4>
                                        <?php } ?>
                               
                                        <div class="toogle_wrap radius8">
                                            <div class="trigger"><a href="#">My Cart - [ Total Amount : RM <?php echo $item_total; ?> ]</a></div>
                                            <div class="toggle_container">
                                            <ul class="listing_detailed">
                                            <?php
											if(isset($_SESSION["cart_item"])){
												$item_total = 0;


	
    foreach ($_SESSION["cart_item"] as $item){
		
		$total = ($item["selling_price"]*$item["quantity"]);
		?>

                <li><?php echo $item["product_name"]; ?>  
                	<ul> Qty : <?php echo $item["quantity"]; ?>    <a href="mycart.php?action=remove&product_code=<?php echo $item["product_code"]; ?>" class="btnRemoveAction">    <img src="images/Cancel.jpg" width="15" height="15"/></a>
                    </ul>
                </li>
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
	<form method="post" action="mycart.php?action=add&product_code=<?php echo $product_array[$key]["product_code"]; ?>">
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
  


<script type="text/javascript" src="js/jquery.swipebox.js"></script>
<script type="text/javascript" src="js/idangerous.swiper-2.1.min.js"></script>
<script type="text/javascript" src="js/idangerous.swiper.scrollbar-2.1.js"></script>
<script type="text/javascript" src="js/jquery.tabify.js"></script>
<script type="text/javascript" src="js/jquery.fitvids.js"></script>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/load.js"></script>
<!--Twitter Feed-->
<script type="text/javascript" src="js/twitter/jquery.tweet.js" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
var $ = jQuery.noConflict();  
jQuery(function($){
$(".tweet").tweet({
  modpath: 'js/twitter/',
  join_text: "auto",
  username: "famousthemes",
  count: 5,
  auto_join_text_default: "we said,",
  auto_join_text_ed: "we",
  auto_join_text_ing: "we were",
  auto_join_text_reply: "we replied",
  auto_join_text_url: "we were checking out",
  loading_text: "loading tweets..."
});
});

	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
</script>


<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>

<div class="se-pre-con"></div>

</body>
</html>