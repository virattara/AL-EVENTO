<?php
require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 


$user_id = $_SESSION['user_id'];
$childsticker_id = $_POST['valve'];
require '../crumbs/hospital.php';

$call = new commands();
$marks = $_POST['likes'];

$count = $call->query_ajax("SELECT COUNT(*) FROM eventrating WHERE user_id='$user_id' AND childsticker_id='$childsticker_id'");

if($count == 0){

$call->query_ajax("INSERT INTO eventrating (user_id,childsticker_id) VALUES ('$user_id','$childsticker_id')");

$rank = $call->query_ajax("SELECT rank FROM childsticker WHERE childsticker_id='$childsticker_id'");

$newRank = $rank + $marks;

$call->query_ajax("UPDATE childsticker SET rank='$newRank' WHERE childsticker_id='$childsticker_id'");

$sticker_id = $call->query_ajax("SELECT sticker_id FROM childsticker WHERE childsticker_id='$childsticker_id'");

$stickerRank = $call->query_ajax("SELECT rank FROM sticker WHERE sticker_id='$sticker_id'");

$newstickerRank = $stickerRank + $marks;

$call->query_ajax("UPDATE sticker SET rank='$newstickerRank' WHERE sticker_id='$sticker_id'");


echo $newRank." likes";
exit();
}
else 
{
	$rank = $call->query_ajax("SELECT rank FROM childsticker WHERE childsticker_id='$childsticker_id'");
	echo $rank." likes";
	exit();
}
?>