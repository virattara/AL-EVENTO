<?php
require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 

if (empty($_POST['armata'])) {
	header("Location:index.php");
	exit();
}

$suburb_id = $_POST['armata'];

require '../crumbs/hospital.php';

$call = new commands();

$call->query("DELETE FROM suburb WHERE suburb_id='$suburb_id'");

exit();
?>