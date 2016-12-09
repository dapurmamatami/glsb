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

</head>
<body>

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