<?php 
include "../inc/pdoconfig.php";
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../main/sessionNoLink.php";
include "../main/functions.php";
//include "../main/pdofunctions.php";
//require_once 'template.php';

$user_id = $_SESSION['user_id'];
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
      <div class="gohome radius20"><a href="#"><img src="images/icons/home.png" alt="" title="" /></a></div>
      <div class="gomenu radius20"><a href="#" onclick="swiperParent.swipeTo(9);"><img src="images/icons/contact.png" alt="" title="" /></a></div>
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
                                        
                                        <?php
										$pdo = Database::connect();
										$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										$sql = "SELECT * from acct_ewallet where user_id = '$user_id' and amount_in > 0 order by ewallet_id desc";
										$q = $pdo->prepare($sql);
										$q->execute();
										//$data = $q->fetch(PDO::FETCH_ASSOC);
										 
										if ($q->rowCount() > 0) {
											
											while ($row = $q->fetch(PDO::FETCH_ASSOC)) { ?>
											<div class="toogle_wrap radius8">
												<div class="trigger"><a href="#">Bonus ID: <?php echo $row['ewallet_id']; ?> - <?php echo $row['amount_in']; ?></a></div>
												<div class="toggle_container">
                                                    <ul class="listing_detailed">
                                                    <li>Order Date : <?php echo $row['trans_date']; ?></li>
                                                    <li>Total Amount: <?php echo $row['amount_in']; ?></li>
                                                    
                                                    </ul>
												</div>
                                                
                                                
											</div>
											<?php }
										}
										else 
										{
											echo 'No Commission History';
										} ?>
											
                                        
											
                                           
                                                                                                                      
      									
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