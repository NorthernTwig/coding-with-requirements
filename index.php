<?php
session_start();

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$r = new RegisterView();
$dtv = new DateTimeView();
$lv = new LayoutView();

$setCookies = $v->checkCookies();
$sessionBefore = $v->getThings();

if (isset($_GET["register"])) {
  $lv->render($v->isLoggedIn($setCookies), $r, $dtv, $sessionBefore, $setCookies);
} else {
  $lv->render($v->isLoggedIn($setCookies), $v, $dtv, $sessionBefore, $setCookies);
}
