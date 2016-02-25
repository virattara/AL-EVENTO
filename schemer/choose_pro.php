<?php
require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 

require_once '../crumbs/hospital.php';

$stickers=explode(",", $_POST['stickersphp']);

$call = new commands;

$email_id = $_SESSION['email'];

$user_id = $call->query_ajax("SELECT user_id FROM community WHERE email_id='$email_id'");

$i = count($stickers);

for ($j=0; $j < $i; $j++) 
{ 
$label_id = $stickers[$j];
$call->query_ajax("INSERT INTO subscribe (user_id,sticker_id) VALUES ('$user_id','$label_id')");
}

$previous = $call->query_ajax("SELECT subscription_count FROM community WHERE user_id='$user_id'");
$new = $previous + $i;
$call->query_ajax("UPDATE community SET subscription_count='$new' WHERE user_id='$user_id'");
?>