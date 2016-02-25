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
//new approach

	switch ($_POST['token']) {
		case 'Become a Member':
			$name = $call->query_ajax("SELECT username FROM community WHERE user_id='$user_id'");
			$content = "Membership request by ".$name;
			$admin = $call->query_ajax("SELECT user_id from sticker WHERE sticker_id='$sticker_id'"); 
			$call->query_ajax("INSERT INTO notify (user_id,content,sender_id) VALUES ('$admin','$content','$user_id')");
			$call->query_ajax("INSERT INTO senator (user_id,sticker_id) VALUES ('$user_id','$sticker_id')");
			echo "incept";
			break;
		
		case 'Cancel Request':
			$name = $call->query_ajax("SELECT username FROM community WHERE user_id='$user_id'");
			$content = "Membership request by ".$name;		
			$admin = $call->query_ajax("SELECT user_id from sticker WHERE sticker_id='$sticker_id'"); 
			$call->query_ajax("DELETE FROM senator WHERE sticker_id='$sticker_id' AND user_id='$user_id'");
			$call->query_ajax("DELETE FROM notify WHERE user_id='$admin' AND sender_id='$user_id' AND content='$content'");
			echo "decept";
			break;

		case 'Resign':
			$name = $call->query_ajax("SELECT username FROM community WHERE user_id='$user_id'");
			$content = $name." Resigned from your society";		
			$admin = $call->query_ajax("SELECT user_id from sticker WHERE sticker_id='$sticker_id'"); 
			$call->query_ajax("DELETE FROM senator WHERE sticker_id='$sticker_id' AND user_id='$user_id'");
			$call->query_ajax("INSERT INTO notify (user_id,content,sender_id) VALUES ('$admin','$content','$user_id')");
			echo "deceptfinal";
			break;
		
		default:
			echo "bad request";
			break;
	}
?>