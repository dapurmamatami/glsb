<?php

include "../main/session.php";


$lang = $_SESSION['lang'];
 
switch ($lang) {
  case 'en':
  $lang_file = 'lang.en.php';
  break;
 
  case 'my':
  $lang_file = 'lang.my.php';
  break;
 
  default:
  $lang_file = 'lang.en.php';
 
}

 
include '../main/' . $lang_file;
?>