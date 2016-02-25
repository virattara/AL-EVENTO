<?php
// coming from ajax

require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 

require '../crumbs/hospital.php';

$call = new commands();
$user_id = $_SESSION['user_id'];
$sticker_id = $_POST['sticker_id'];
$count = $call->query_ajax("SELECT COUNT(*) FROM subscribe WHERE user_id='$user_id' AND sticker_id='$sticker_id'");
if ($count == 0) 
{
	$call->query_ajax("INSERT INTO subscribe (sticker_id,user_id) VALUES ('$sticker_id','$user_id')");
	echo "incept";
}
else
	{
	$call->query_ajax("DELETE FROM subscribe WHERE sticker_id='$sticker_id' AND user_id='$user_id'");
	echo "decept";
	}

?>