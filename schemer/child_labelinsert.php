<?php
require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 

//from ajax

if (empty($_POST['namephp']) || empty($_POST['contentphp'])) 
{
	echo "Empty Fields";
	exit();
}

require_once '../crumbs/hospital.php';

$child_sticker = $_POST['namephp'];
$stick_content = $_POST['contentphp'];

$call = new commands();

$user_id = $_SESSION['user_id'];

$sticker_id = $call->query_ajax("SELECT sticker_id from sticker WHERE user_id='$user_id'");

if (empty($sticker_id)) 
{
	echo "Error please contact the admin";
	exit();
}


$call->query_ajax("INSERT INTO childsticker (sticker_id,name,description)VALUES('$sticker_id','$child_sticker','$stick_content')");


echo "success650";
exit();
?>