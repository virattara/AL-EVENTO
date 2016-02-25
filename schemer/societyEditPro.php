<?php
require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 

$user_id = $_SESSION['user_id'];

if (empty($_POST['content']) && empty($_FILES["file"]["type"])) {
	echo "Empty Fields";
	exit();
}

require '../crumbs/hospital.php';
$target = null;
if(!empty($_FILES["file"]["type"]))
{
	$validextensions = array("jpeg", "jpg", "png");
	$temporary = explode(".", $_FILES["file"]["name"]);
	$file_extension = end($temporary);

	if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 10000000) && in_array($file_extension, $validextensions)) 
	{

		if ($_FILES["file"]["error"] > 0)
		{
			echo "Error please contact the admin";
			exit();
		}

	$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable

	$target = "../soc/".uniqid().$_FILES['file']['name'];

	move_uploaded_file($sourcePath,$target) ; // Moving Uploaded file
	}
	else
	{
		echo "<span id='invalid'>Invalid file Size or Type<span>";
		exit();
	}
}

$call = new commands();

if(!empty($_POST['content']))
$content = nl2br(addslashes($_POST['content']));
else
$content = null;

if (!empty($target) && !empty($content)) 
{
$call->query_ajax("UPDATE sticker SET picture='$target',description='$content' WHERE user_id='$user_id'");
}
else if (!empty($target) && empty($content))
{
$call->query_ajax("UPDATE sticker SET picture='$target' WHERE user_id='$user_id'");
}
else if(empty($target) && !empty($content))
{
$call->query_ajax("UPDATE sticker SET description='$content' WHERE user_id='$user_id'");
}
else
	echo "Empty Fields";
	exit();

	?>