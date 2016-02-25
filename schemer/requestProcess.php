<?php 
require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 

require '../crumbs/hospital.php';

$info = explode(",", $_POST['info']);

$sender_id = $info[0];
$sticker_id = $info[1];
$notify_id = $info[3];

$call = new commands();

if ($info[2] == 'accept') 
{
	$call->query_ajax("UPDATE senator SET block='false' WHERE sticker_id='$sticker_id' AND user_id='$sender_id'");
	$call->query_ajax("UPDATE community SET TYPE = IF( TYPE =  'leader',  'leader',  'senator' ) WHERE user_id='$sender_id'");
	$stickername = $call->query_ajax("SELECT stickername FROM sticker WHERE sticker_id='$sticker_id'");
	$content = "You are now a member of ".$stickername;
	$call->query_ajax("INSERT INTO notify (user_id,content) VALUES ($sender_id,$content)");	
	$call->query_ajax("DELETE FROM notify WHERE notify_id='$notify_id'");
}
else if($info[2] == 'decline') {
	$call->query_ajax("DELETE FROM senator WHERE sticker_id='$sticker_id' AND user_id-'$sender_id'");
	$stickername = $call->query_ajax("SELECT stickername FROM sticker WHERE sticker_id='$sticker_id'");
	$content = "Your membership request was declined by ".$stickername;
	$call->query_ajax("INSERT INTO notify (user_id,content) VALUES ($sender_id,$content)");		
	$call->query_ajax("DELETE FROM notify WHERE notify_id='$notify_id'");

}
else
echo "string";


?>