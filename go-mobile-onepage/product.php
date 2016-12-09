<?php 
include "../inc/pdoconfig.php";
include "../inc/dbconfig.php";
//require_once 'template.php';



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
      <div class="gomenu radius20"><a href="#" onClick="swiperParent.swipeTo(9);"><img src="images/icons/contact.png" alt="" title="" /></a></div>
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
										$sql = "SELECT * from product";
										$q = $pdo->prepare($sql);
										$q->execute(array($id));
										//$data = $q->fetch(PDO::FETCH_ASSOC);
										
										while ($row = $q->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <div class="portfolio_item radius8">
                                             <div class="portfolio_image"><a rel="gallery-1" href="<?php echo $row[file_name]; ?>" class="swipebox" title="<?php echo $row['product_name'] ?>"><img src="<?php echo $row[file_name]; ?>" alt="" title="" border="0" /></a></div>
                                                 <div class="portfolio_details">
                                                 <h4><?php echo $row['product_name'] ?></h4>
                                                 <p><?php echo $row['product_description'] ?></p>
                                                 <a rel="gallery-2" href="<?php echo $row[file_name]; ?>" class="swipebox view_details" title="<?php echo $row['product_name'] ?>">view details</a>
                                                 </div>
                                        </div>
                                        <?php } ?>

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