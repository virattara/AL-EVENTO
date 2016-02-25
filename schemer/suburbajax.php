<?php

require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 

$sticker_id = $_POST['sticker_id'];
$_SESSION['sticker_id'] = $sticker_id;

require '../crumbs/hospital.php';

$call = new commands();

$info = $call->query_fetch_ajax("SELECT childsticker_id,name from childsticker where sticker_id='$sticker_id'");

foreach ($info as $product) 
{
	echo "<option value=".$product['childsticker_id'].">".$product['name']."</option>";
}

?>