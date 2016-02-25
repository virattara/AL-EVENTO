<?php
session_start();

$user_id = $_SESSION['user_id'];
$suburb_id = $_POST['value'];
require '../crumbs/hospital.php';

$call = new commands();
$marks = 1;

$count = $call->query_ajax("SELECT COUNT(*) FROM postrating WHERE user_id='$user_id' AND suburb_id='$suburb_id'");

if($count == 0){
//post rating
$call->query_ajax("INSERT INTO postrating (user_id,suburb_id,rating) VALUES ('$user_id','$suburb_id',$marks)");

$rank = $call->query_ajax("SELECT rank FROM suburb WHERE suburb_id='$suburb_id'");

$newRank = $rank + $marks;

$call->query_ajax("UPDATE suburb SET rank='$newRank' WHERE suburb_id='$suburb_id'");

//label and child label rating updatings
$id = $call->query_fetch_ajax("SELECT sticker_id,childsticker_id FROM suburb WHERE suburb_id='$suburb_id'");

$sticker_id = $id[0]['sticker_id'];

if (!empty($id[0]['childsticker_id'])) {
$childsticker_id = $id[0]['childsticker_id'];

$childRank = $call->query_ajax("SELECT rank FROM childsticker WHERE childsticker_id='$childsticker_id'");

$newchildRank = $childRank + $marks;

$call->query_ajax("UPDATE childsticker SET rank='$newchildRank' WHERE childsticker_id='$childsticker_id'");	
}

$stickerRank = $call->query_ajax("SELECT rank FROM sticker WHERE sticker_id='$sticker_id'");

$newstickerRank = $stickerRank + $marks;

$call->query_ajax("UPDATE sticker SET rank='$newstickerRank' WHERE sticker_id='$sticker_id'");


echo $newRank;
exit();
}
else 
{
	echo "liked";
	exit();
}
?>