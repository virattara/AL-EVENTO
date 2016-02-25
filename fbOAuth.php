<?php 
session_start();
$_SESSION['satanbloodbank'] = 'parkhov';
/* INCLUSION OF LIBRARY FILEs*/
  require_once( 'lib/Facebook/FacebookSession.php');
  require_once( 'lib/Facebook/FacebookRequest.php' );
  require_once( 'lib/Facebook/FacebookResponse.php' );
  require_once( 'lib/Facebook/FacebookSDKException.php' );
  require_once( 'lib/Facebook/FacebookRequestException.php' );
  require_once( 'lib/Facebook/FacebookRedirectLoginHelper.php');
  require_once( 'lib/Facebook/FacebookAuthorizationException.php' );
  require_once( 'lib/Facebook/GraphObject.php' );
  require_once( 'lib/Facebook/GraphUser.php' );
  require_once( 'lib/Facebook/GraphSessionInfo.php' );
  require_once( 'lib/Facebook/Entities/AccessToken.php');
  require_once( 'lib/Facebook/HttpClients/FacebookCurl.php' );
  require_once( 'lib/Facebook/HttpClients/FacebookHttpable.php');
  require_once( 'lib/Facebook/HttpClients/FacebookCurlHttpClient.php');

/* USE NAMESPACES */  
  use Facebook\FacebookSession;
  use Facebook\FacebookRedirectLoginHelper;
  use Facebook\FacebookRequest;
  use Facebook\FacebookResponse;
  use Facebook\FacebookSDKException;
  use Facebook\FacebookRequestException;
  use Facebook\FacebookAuthorizationException;
  use Facebook\GraphObject;
  use Facebook\GraphUser;
  use Facebook\GraphSessionInfo;
  use Facebook\FacebookHttpable;
  use Facebook\FacebookCurlHttpClient;
  use Facebook\FacebookCurl;
 

// Initialize app with app id (APPID) and secret (SECRET)
FacebookSession::setDefaultApplication('1012396155457786' ,'5c15452ad3e987960352af4d3888e36c');
 
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper('http://www.alevento.in/fbOAuth.php');

// see if we have a session in $_Session[]
if( isset($_SESSION['token']))
{
    // We have a token, is it valid? 
    $session = new FacebookSession($_SESSION['token']); 
    try
    {
        $session->Validate('1012396155457786' ,'5c15452ad3e987960352af4d3888e36c');
    }
    catch( FacebookAuthorizationException $ex)
    {
        // Session is not valid any more, get a new one.
        $session ='';
    }
}

else{
try
{
  // In case it comes from a redirect login helper
  $session = $helper->getSessionFromRedirect();
} 
catch( FacebookRequestException $ex ) 
{
  // When Facebook returns an error
  echo $ex;
} 
catch( Exception $ex ) 
{
  // When validation fails or other local issues
  echo $ex;
}
}
 
// see if we have a session
if ( isset( $session ) ) 
{   
    // set the PHP Session 'token' to the current session token
    $_SESSION['token'] = $session->getToken();
    // SessionInfo 
    //$info = $session->getSessionInfo();  
    // getAppId
    //echo "Appid: " . $info->getAppId() . "<br />"; 
    // session expire data
    //$expireDate = $info->getExpiresAt()->format('Y-m-d H:i:s');
    //echo 'Session expire time: ' . $expireDate . "<br />"; 
    // session token
    //echo 'Session Token: ' . $session->getToken() . "<br />"; 
      $user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
      $_SESSION['username'] = $user_profile->getName();                           
     
      $_SESSION['email'] = $user_profile->getId();
     // $_SESSION['friends'] = $user_profile->getProperty('user_friends');
      //$_SESSION['schemer'] = 'renegade';
      
      $username_fb = $_SESSION['username'];
      
      $email_fb = $_SESSION['email'];
            
      // database work ahead!
      require 'crumbs/hospital.php';
      $call = new commands();

      $count=$call->query("SELECT COUNT(*) FROM community WHERE email_id='$email_fb'");
      if($count == 0)
      {
        $call->query("INSERT INTO community(username,email_id) VALUES ('$username_fb','$email_fb')");
        $_SESSION['renegade'] = 'public';
        header("Location:./schemer/choose.php");
        exit();
      }

      $type=$call->query("SELECT type FROM community WHERE email_id='$email_fb'");

      if ($type == 'leader') 
      {
        $_SESSION['renegade'] = 'leader';
        header("Location:./schemer/");
        exit();
      }
      else if($type == 'senator')
      {
        $_SESSION['renegade'] = 'senator';
        header("Location:./schemer/");
        exit();
      }
      else 
      {
        $_SESSION['renegade'] = 'public';
        header("Location:./schemer/");
        exit(); 
      }
} 
else
{
  $direct=$helper->getLoginUrl(array('user_friends'));
  // show login url
  header("Location:$direct");
  exit();
}
?>


