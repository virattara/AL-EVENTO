<?php
require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 

    if ($SM->sessionClose()) {
    	header("Location:../");
    	exit();
    }



?>