<?php
require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:index.php ");
  exit();
} 
require '../crumbs/hospital.php';

$call = new commands();
$email = $_SESSION['email'];
$_SESSION['user_id'] = $call->query("SELECT user_id FROM community WHERE email_id='$email'");

if (!isset($_SESSION['user_id'])) 
{
	header("Location:../error.php");
	exit();
}

$user_id = $_SESSION['user_id'];

//label info for trending cards
$labels = $call->query_fetch("SELECT sticker_id,stickername,rank FROM sticker ORDER BY rank DESC LIMIT 5"); 

//childlabel info for trending cards
$childlabels = $call->query_fetch("SELECT childsticker_id,name,rank FROM childsticker ORDER BY rank DESC LIMIT 5"); 

?>

<html>
<head>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
  <script>  
    var OneSignal = OneSignal || [];

    OneSignal.push(["init", {appId: "bf066476-7d73-11e5-9cff-a0369f2d9328", subdomainName: "alevento"}]);
  </script>

<script>
    function registerForPush(event) {
      OneSignal.push(["registerForPushNotifications"]);
      event.preventDefault();
    }
    OneSignal.push(function() {
      if (OneSignal.isPushNotificationsSupported()) {
        OneSignal.isPushNotificationsEnabled(function(pushEnabled) {
          if (!pushEnabled)
            document.getElementById("registerForPushLink").addEventListener('click', registerForPush, false);
          else
            document.getElementById("registerForPushLink").innerHTML = "You're setup to receive push notifications!";
        });
      }
      else // Hide Subscribe if notifications are not supported.
        document.getElementById("registerForPushLink").style.display = 'none';
    });
  </script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="EHRA">
	<meta name="theme-color" content="#0D47A1">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#0D47A1">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#0D47A1">
	<title>ALEVENTO</title>
	
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/feed.css">
	<link href="../css/roboto.min.css" rel="stylesheet">
    <link href="../css/material.min.css" rel="stylesheet">
    <link href="../css/ripples.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Oswald:700,400' rel='stylesheet' type='text/css'>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script src="../js/ripples.min.js"></script>
<script src="../js/material.min.js"></script>
</script>
</head>

<body>
	<div class="clearfix"></div>

	<nav class="nav1 navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<div>
					<ul class="nav mynav navbar-nav navbar-right">
                    <li class="brand">
                    	<a href="index.php" class="navbar-brand">AL:EVENTO</a>
                    </li>
                    <li class="searchwell" style="cursor: not-allowed;">
                    	<form class="well well-sm has-feedback" >
							<input type="text" class="form-control" style="cursor: not-allowed;" placeholder="Search this site..">
							<span class= "form-control-feedback search glyphicon glyphicon-search pull-right"></span>
						</form>
                    </li>
                    <li class="notn">
                    	<button type="button" class="btn btn-sm notn-btn"><i style="color:#fff;" class="mdi-social-notifications"></i><span id="numberNotify1" class="badge"></span></button>
                    </li>
                    <li class="stathide-btn">
                    	<button type="button" class="btn btn-sm stathide"><i style="color:#fff;" class="mdi-action-trending-up"></i></button>
                    </li>
					</ul>
				</div>
				</div>
			
		</div>
	</nav>

<!--====================Navbar for sizes other than large==============-->

	<nav  id="nav2" class="nav2 navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<ul class="nav mynav navbar-nav">
                   
                   <li class="profile-btn">
                    <button type="button" class="btn btn-sm profile"><i style="color:#fff;" class="mdi-social-person"></i></button>
                    </li>

                    <li>
                    	<a href="index.php" class="navbar-brand">AL:EVENTO</a>
                    </li>

          <!---  Change in header files-->

                   <div class="nav-btns">
                    	<li class="search-btn">
                    		<button type="button" class="disabled btn btn-sm srch"><i style="color:#fff; width:15px;" class="mdi-action-search"></i></button>
                    	</li>
                    	<li class="notn">
                    		<button type="button" class="btn btn-sm notn-btn"><i  style="color:#fff; width:15px;" class="mdi-social-notifications"><span id="numberNotify2" class="badge"></span></i></button>
                    	</li>
                    <li class="stathide-btn">
                    	<button type="button" class="btn btn-sm stathide"><i  style="color:#fff; width:15px;" class="mdi-action-trending-up"></i></button>
                    </li>
                	</div>
				</ul>
			</div>
		</div>
	</nav>

<!--==========Search Bar for sizes other than large=================-->
<!--
	<div id="nav3" class="nav3 navbar-fixed-top" role="navigation">
		
		<ul class="mynav list-unstyled">

		<li class="back-btn"><button type="button" class="btn btn-sm back"><i class="mdi-navigation-arrow-back"></i></button></li>
		
		<li>
		<form class="has-feedback">
			<input type="text" class="form-control" placeholder="Search this site..">
			<span class= "form-control-feedback search glyphicon glyphicon-search pull-right"></span>
		</form>
		</li>
		
		</ul>

		<div class="search_results" id="search_results">
			<ul>
				<li class="li1" style="background-color:gray; height:30px;padding:5px;">Search the site for ...</li>
				<li>
				<a href="#" class="results_btn">
				<li class="li2">
				<div>
					<img src="img/contct.png" class="searchpic">
					<span class="searchtitle">Result 1</span>
				</div>
				</li>
				</a>
				</li>
				<li>
				<a href="#" class="results_btn">
				<li class="li2">
				<div>
					<img src="img/contct.png" class="searchpic">
					<span class="searchtitle">Result 1</span>
				</div>
				</li>
				</a>
				</li>
				<li>
				<a href="#" class="results_btn">
				<li class="li2">
				<div>
					<img src="img/contct.png" class="searchpic">
					<span class="searchtitle">Result 1</span>
				</div>
				</li>
				</a>
				</li>
			</ul>
			</div>	
	</div>
-->
	<!--===================For small size, extra small, medium and mid-large device===============-->

	<div class="stat1" id="stat1">
						<h4><b>Trending Events</b></h4>
						<ol type="1">
						<?php
						$childlabels1 = $call->query_fetch("SELECT childsticker_id,name,rank FROM childsticker ORDER BY rank DESC LIMIT 5"); 

						foreach ($childlabels1 as $childtopLabels1) 
							{
								if (!empty($childtopLabels1['rank'])) {
							?>
							<li><a href="event.php?eve=<?php echo $childtopLabels1['childsticker_id']; ?>"><?php echo $childtopLabels1['name']; ?></a></li>	
							<?php
							}
							}
							?>
						</ol>
					
						<h4><b>Trending Societies</b></h4>
						<ol type="1">
						<?php
						$labels1 = $call->query_fetch("SELECT sticker_id,stickername,rank FROM sticker ORDER BY rank DESC LIMIT 5"); 
						foreach ($labels1 as $topLabels1) 
							{
								if (!empty($topLabels1['rank'])) {
							?>
	<li><a href="society.php?soc=<?php echo $topLabels1['sticker_id']; ?>"><?php echo $topLabels1['stickername']; ?></a></li>	
							<?php
							}
							}
							?>
						</ol>
				</div>

	<div class="container-fluid">
		<div class="notify" id="notify">
			<h4 align="left"><b>Notifications</b></h4>
			<ul class="list1 list-group list-unstyled">
			<?php 
			//post notification
			$itr = 0;

			$notify = $call->query_fetch("SELECT * FROM notify ORDER BY time DESC");
			
			if(!empty($notify)){
			foreach ($notify as $note) 
				{
					$notify_id = $note['notify_id'];

					if (!empty($note['suburb_id'])) {
					$suburb_id = $note['suburb_id'];
													
					$sticker_id = $call->query("SELECT sticker_id FROM suburb WHERE suburb_id='$suburb_id'");

					if (!empty($sticker_id)) {
					$count1 = $call->query("SELECT COUNT(*) FROM subscribe WHERE sticker_id='$sticker_id' AND user_id='$user_id'");
					$count2 = $call->query("SELECT COUNT(*) FROM notified WHERE user_id='$user_id' AND notify_id='$notify_id'");
					
					if($count1 != 0 && $count2 == 0){
					$stickerInfo = $call->query_fetch("SELECT childsticker_id,user_id FROM suburb WHERE suburb_id='$suburb_id'");
					
					if (!empty($stickerInfo[0]['childsticker_id'])) {
					$childsticker_id = $stickerInfo[0]['childsticker_id'];
					$eventName = $call->query("SELECT name FROM childsticker WHERE childsticker_id='$childsticker_id'");
					}

					$stickername = $call->query("SELECT stickername FROM sticker WHERE sticker_id='$sticker_id'");
					$posterId = $stickerInfo[0]['user_id'];
					$posterName = $call->query("SELECT username FROM community WHERE user_id='$posterId'");
			?>		
					<a  type="button" href="notification.php?sub=<?php echo $suburb_id;?>&not=<?php echo $notify_id;?>">
					<li class="note"><div><h5><b><?php echo $stickername; ?></b>
					<span><?php if(isset($eventName)) echo '>'.$eventName; ?></span></h5>
					<p><span><em><?php echo $posterName; ?></em></span> posted an update</p></div></li></a>
					</li></a>
			<?php
					$itr = $itr+1;
					}
					}
					}
					//request notification
					if ($_SESSION['user_id'] == $note['user_id']) {
					if (!empty($note['sender_id']) && !empty($note['user_id'])){
						$sender_id = $note['sender_id'];
						$receiver_id = $note['user_id'];
						$sendername = $call->query("SELECT username FROM community WHERE user_id='$sender_id'");
						$sticker = $call->query_fetch("SELECT sticker_id,stickername FROM sticker WHERE user_id='$receiver_id'");

			?>		<li class="note">
					<div id="response">
					<h5><b><?php echo $sticker[0]['stickername']; ?></b></h5>
					<p><span><em><a  type="button" href="profile.php?per=<?php echo $sender_id; ?>"><?php echo $sendername; ?></a></em></span> requested to join.</p>
					<button  class="btn btn-sm" onclick="request(this.value)" value="<?php echo $sender_id.','.$sticker[0]['sticker_id'].',accept'.','.$notify_id; ?>"><i class="mdi-social-person-add" style="color:#424242;"></i></button>
					<button class="btn btn-sm" onclick="request(this.value)" value="<?php echo $sender_id.','.$sticker[0]['sticker_id'].',decline'.','.$notify_id; ?>"><i class="mdi-content-clear" style="color:#424242;"></i></button>
					</div>
					</li>

				<?php	
					$itr=$itr+1;	
				}
				}
				if ($_SESSION['user_id'] == $note['user_id']) {
				//request response notification
				if (!empty($note['user_id']) && empty($note['sender_id']) && empty($note['suburb_id']) && ($user_id == $note['user_id'])) 
				{
				?>
				<li class="note"><?php echo $note['content']; ?></li>
				<?php
				$remove = $note['notify_id'];
				$call->query("DELETE FROM notify WHERE notify_id='$remove'");
				}	
				}
				}
				}
				?>
			</ul>

		</div>
	</div>
	<!--Added in (768-991) size-->
	<div  class="profile1" id="profile1">
					<ul class="list-unstyled">
							<div>
<?php  
$profile_pic = $_SESSION['email'];
echo '<li><img src="https://graph.facebook.com/'.$profile_pic.'/picture?width=100" class="img img-responsive userpic"></li>';
?>
								<br>
								<li><h4>Welcome <span><?php echo $_SESSION['username'] ?></span></h4></li>
							</div>
							<div class="clearfix"></div>
							<?php if (($_SESSION['renegade'] == 'leader')) {
							?>
							<li><a href="#create-event" data-toggle="modal">Create New Event</a></li>
							<?php
							}
							?>
								<div class="dropdown">
										<a href="#" data-toggle="dropdown" class="dropdown-toggle">Member Of<b class="caret"></b></a>
									<ul class="dropdown-menu">
										 <?php
										 $groups = $call->query_fetch("SELECT sticker.sticker_id,sticker.stickername FROM sticker INNER JOIN senator ON senator.sticker_id=sticker.sticker_id WHERE senator.user_id='$user_id' AND senator.block='false'");
									 foreach ($groups as $group) {
									 	?>
										<li><a href="society.php?soc=<?php echo $group['sticker_id']; ?>"><?php echo $group['stickername']; ?></a></li>									 	
										<?php
									 	}
									 	?>
									</ul>
								</div>
						<li><a href="profile.php?per=<?php echo $_SESSION['user_id']; ?>">Profile</a></li>
						<li><a class="btn btn-sm" style="background-color:#EF5350; color:#fff;" href="logout.php">Logout</a></li>
							</ul>
							
					<a href="#" id="registerForPushLink">Subscribe to Notifications</a>
	</div>

<div class="clearfix"></div>







<!--==================This piece of code is written here to override the css files.===============-->
					<style type="text/css">
					.navbar-inverse.navbar {
						background-color: #0D47A1;
					}
					a{
						color: #0D47A1;
					}
					#profile{
						margin-right: 0px;
					}
					#feed{
						margin-right: 0px;
					}
					
					.card{
						margin-bottom: 3%;
						padding: 0 3% 3% 3%;
						-webkit-box-shadow: -1px 1px 15px 3px rgba(195,197,199,0.7);
						-moz-box-shadow: -1px 1px 15px 3px rgba(195,197,199,0.7);
						box-shadow: -1px 1px 15px 3px rgba(195,197,199,0.7);
					}
					/*------- card img class removed-------*/
					.post_options{
   						padding: 7px;
   						margin: 5px;
    					border: 0px solid #fff;
    					border-radius: 20px;
}
					}
					</style>
<!-- ================Search Results division===============-->

		<!--	<div class="search_results">
			<ul>
				<li class="li1" style="background-color:gray; height:20px;"></li>
				<li>
				<a href="#" class="results_btn">
				<li class="li2">
				<div>
					<span class="searchtitle">Result 1</span>
				</div>
				</li>
				</a>
				</li>
			</ul>
			</div> -->
		

<script>
    $(document).ready(function() {
    $.material.init();
        });
</script>

<script type="text/javascript">
	$(document).ready(function(event){
		$("#notify").hide(0);
		$(".notn-btn").click(function(){
			$("#notify").slideToggle(400);
		})
	});
	</script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		$("#stat1").hide(0);
		$(".stathide-btn").click(function() {
			$("#stat1").toggle(200);
		})
	})
	</script>

	<script type="text/javascript">
	$(document).ready(function(){
		$("#profile1").hide(0);
		$(".profile-btn").click(function() {
			$("#profile1").toggle(200);
		})
	})
	</script>

	<script type="text/javascript">
	$(document).ready(function(){
		$(".search-btn").click(function() {
			$("#nav3").show(300);
			$("#nav1").hide(0);
			$("#search_results").show(0);
		})
	})
	</script>

	<script type="text/javascript">
	$(document).ready(function(){
		$(".back-btn").click(function() {
			$("#nav3").hide(300);
			$("#search_results").hide(0);
		})
	})
	</script>

	<script>
	function request(value){
		var val = value;
		$.ajax({
			data:'info='+val,
			method: 'POST',
			url:'requestProcess.php',
			cache: false,
		error: function(object)
          {
            document.write(object.responseText);
          },
		  success: function(result) 
          {
          	document.getElementById('response').innerHTML = "Accepted";
		  }		
		});
	};

	function like(id){
   $.ajax({
   		data: 'value='+id,
    	method: 'POST',
    	url: 'rate.php',
    	cache: false,
    	error: function(object)
          		{
          			if (object.responseText == undefined) 
          				{
							document.getElementById(id).innerHTML="liked";          					
          				};
          		},
		success: function(result)
				{

					if (result != 'liked') 
						{
							document.getElementById(id).innerHTML=result;
						};
				}

    });	
};

$(document).ready(function(){
	document.getElementById('numberNotify1').innerHTML = "<?php echo $itr; ?>";
		document.getElementById('numberNotify2').innerHTML = "<?php echo $itr; ?>";


});

	</script>

	<style type="text/css">
	.notify a{
		color: #fff;
		text-decoration: none;
	}
	.note{
		margin: 5px 0 0 0;
		padding: 10px;
		color: #333;
		background-color: #EF5350;
	}
	.note h5{
		margin-top: 0px;
		color: #424242;
		font-size: 1.1em;

	}
	.note p{
		color: #fff;
	}
</style>




