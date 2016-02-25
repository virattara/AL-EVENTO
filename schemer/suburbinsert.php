<?php
require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 

if (empty($_POST["country"])) 
{
	echo "Empty Fields";
	exit();
}

require '../crumbs/hospital.php';
$sticker_id = $_POST['country']; 
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
	if(!file_exists('../'."posters".$sticker_id))
	{mkdir('../'."posters".$sticker_id);}
	//$targetPath = "posters".$sticker_id."/".uniqid().$_FILES['file']['name']; // Target path where file is to be stored
	$target = "../"."posters".$sticker_id."/".uniqid().$_FILES['file']['name'];
	move_uploaded_file($sourcePath,$target) ; // Moving Uploaded file
	}
	else
	{
		echo "<span id='invalid'>Invalid file Size or Type<span>";
		exit();
	}
}

$call = new commands();
$user_id = $_SESSION['user_id'];

if(!empty($_POST['content']))
$content = nl2br(addslashes($_POST['content']));
else
$content = null;

$childsticker_id = null;
if(!empty($_POST['state'])){
$childsticker_id = $_POST['state'];
$suburb_id = $call->query_id("INSERT INTO suburb (user_id,sticker_id,childsticker_id,content,picture) VALUES ('$user_id','$sticker_id','$childsticker_id','$content','$target')");
}
else
$suburb_id = $call->query_id("INSERT INTO suburb (user_id,sticker_id,content,picture) VALUES ('$user_id','$sticker_id','$content','$target')");

$call->query_ajax("INSERT INTO notify (suburb_id) VALUES ('$suburb_id')");


if ($sticker_id == 711238521) {
	
	function sendMessage(){
    $content = array(
      "en" => "New! update from Saturnalia 2k15"
      );
    
    $fields = array(
      'app_id' => "bf066476-7d73-11e5-9cff-a0369f2d9328",
      'included_segments' => array('All'),
      'send_after' => 'Fri May 02 2014 00:00:00 GMT-0700 (PDT)',
      'data' => array("foo" => "bar"),
      'contents' => $content
    );
    
    $fields = json_encode($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                           'Authorization: Basic YmYwNjY1MzQtN2Q3My0xMWU1LTljZmYtYTAzNjlmMmQ5MzI4'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
  }
  
  $response = sendMessage();
  $return["allresponses"] = $response;
  $return = json_encode( $return);

}


  
  


	echo "<span id='success'>Posted</span><br/>";
	exit();
?>