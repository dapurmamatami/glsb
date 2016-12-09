<?php 
include "../inc/pdoconfig.php";
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../main/session.php";
include "../main/functions.php";
//include "../main/pdofunctions.php";
require_once 'template.php';

$user_id = $_SESSION['user_id'];
//echo $user_id;
echo showDetail($user_id);


function showDetail($user_id) { ?>

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
										$sql = "SELECT * from acct_ewallet left join user on acct_ewallet.user_id = user.user_id where amount_in > 0 and acct_ewallet.user_id = '$user_id'";
										$q = $pdo->prepare($sql);
										$q->execute();
										//$data = $q->fetch(PDO::FETCH_ASSOC);
										 
										if ($q->rowCount() > 0) {
											
											while ($row = $q->fetch(PDO::FETCH_ASSOC)) { ?>
                                        	<div class="toogle_wrap radius8">
                                            <div class="trigger"><a href="#">Order# 1002 (Approved) </a></div>
                                            <div class="toggle_container">
                                            <ul class="listing_detailed">
                                            <li>Date : <?php echo $row['trans_date']; ?></li>
                                            <li>Description: <?php echo $row['trans_description']; ?></li>
                                            <li>Amount In : <?php echo $row['amount_in']; ?></li>
                                            <li>Amount Out: <?php echo $row['amount_in']; ?></li>
                                            </ul>
                                            </div>
                                        </div>
										<?php }
										}
										else 
										{
											echo 'No record Found';
										} ?>   
                                                                                                                        
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
  
<?php } ?>