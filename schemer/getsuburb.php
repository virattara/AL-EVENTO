<script>
      function insert() {
        var contentjs = $('#content').val();
        var namejs = $('#name').val();
        $.ajax({
          data: 'contentphp='+contentjs+'&namephp='+namejs,
          method: 'POST',
          url: 'child_labelinsert.php',
          cache: false,
          error: function(object)
          {
            document.write(object.responseText);
          },
	      success: function(result) 
	      {	
		  }
        });
      };

      function deletePost(id){
      	$.ajax({
      		data:'armata='+id,
      		method: 'POST',
      		url: 'deletePost.php',
      		cache: false,
      		error: function(object)
      		{
      			document.write(object.responseText);
      		},
      		success: function(result)
      		{
      			window.location.reload();
      		}
      	});
      };
</script>

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

<html>
<!--
loading!!!
<div class="card cload" style="display:none;width:50%">
<div class="container" id="cload">
		<div class="clear-loading loading-effect-2">
			<span></span>
		</div>
</div>
</div>
-->
<div class="container-fluid act-body">
			<div class="row">
				<div class="col-md-4 col-lg-3" id="profile">

					<ul class="list-unstyled">
							<div>
								<li><h4>Welcome <span><em><?php echo $_SESSION['username']; ?></em></span></h4></li>
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
									$user_id = $_SESSION['user_id'];
									  $groups = $call->query_fetch("SELECT sticker.sticker_id,sticker.stickername FROM sticker INNER JOIN senator ON senator.sticker_id=sticker.sticker_id WHERE senator.user_id='$user_id' AND senator.block='false'");
									 foreach ($groups as $group) {
									 	?>
										<li><a href="society.php?soc=<?php echo $group['sticker_id']; ?>"><?php echo $group['stickername']; ?></a></li>									 	
										<?php
									 	}
									 	?>
									</ul>
								</div>
						<li><a href="profile.php?per=<?php echo $_SESSION['user_id']; ?>"><b>Profile</b></a></li>
						<li><a class="btn btn-sm" style="background-color:#EF5350; color:#fff;" href="logout.php">Logout</a></li>
					</ul>

					<a href="#" id="registerForPushLink">Subscribe to Notifications</a>

				</div>

				<div class="col-md-7 col-lg-6 center-head">
				<ul class="nav nav-tabs" style="background-color:#EF5350; color:#fff;">
        			<li class="active"><a data-toggle="tab" href="#feed">Your News Feed</a></li>
        			<li><a data-toggle="tab" href="#soclist">List of Societies</a></li>
    				</ul>
    			</div>

				<div class="col-md-7 col-lg-6 center tab-content">
    			

				<div id="feed" class="tab-pane fade in active">
					
			
<?php 
if (($_SESSION['renegade'] == 'leader') || ($_SESSION['renegade'] == 'senator')) 
{
require 'suburb.php';
}



$call = new commands();

$result = $call->query_fetch("SELECT suburb.* FROM suburb INNER JOIN subscribe ON suburb.sticker_id = subscribe.sticker_id WHERE subscribe.user_id='$user_id' ORDER BY suburb.time DESC");

?>


<?php
foreach ($result as $post) 
{
?>
<div class="card">
<?php
$deletePriv = $call->query("SELECT sticker_id FROM sticker WHERE user_id='$user_id'");
if ($user_id == $post['user_id'] || (($_SESSION['renegade'] == 'leader') && ($deletePriv == $post['sticker_id']))) 
{
?> 

	<!--DELETE BUTTON-->
	<div class="dropdown pull-right">
  		<button class="btn dropdown-toggle post_options" type="button" data-toggle="dropdown"><i class="mdi-navigation-more-vert "></i></button>
  			<ul class="dropdown-menu">
    			<li><button onclick="deletePost(this.value)" value="<?php echo $post['suburb_id']; ?>">Delete Post</button></li>
  			</ul>
	</div>

<?php
}
	if (!empty($post['picture'])) 
	{
		$pic = $post['picture'];
?>
<img src="<?php echo $pic; ?>" class="postpic">
<?php
	}

//post owner
$owner_id = $post['user_id'];
$result_c = $call->query("SELECT username FROM community WHERE user_id='$owner_id'");
?>
<a href="profile.php?per=<?php echo $owner_id ?>"><h4> <?php echo $result_c; ?> </h4></a>

<?php
//post's time
$time = $post['time'];
$date = explode(' ',$time);
$date1 = date_create($date[0]);
$date2 = date_create(date("Y-m-d"));
$diff = date_diff($date1,$date2);
$postTime = $diff->format("%a");

if ($postTime == 0) 
{
	echo "<h6>Posted Today</h6>";
}
else if ($postTime == 1)
{
	echo "<h6>Posted Yesterday</h6>";
}
else 
	echo "<h6>Posted ".$postTime." days ago</h6>";


if (!empty($post['content'])) 
{
?>
<p><br><?php echo stripslashes(nl2br($post['content'])); ?></p>
<?php
}

//label name 
$sticker_id = $post['sticker_id'];
$result_a = $call->query("SELECT stickername FROM sticker WHERE sticker_id='$sticker_id'");


?>
<a href="society.php?soc=<?php echo $sticker_id ?>" style="margin-left:5px" class="pull-right label label-warning" name="<?php echo $sticker_id; ?>"><?php echo $result_a; ?></a>



<?php	
//childlabel name
if (!empty($post['childsticker_id'])) 
{
	$childsticker_id = $post['childsticker_id'];
	$result_b = $call->query("SELECT name FROM childsticker WHERE childsticker_id='$childsticker_id'");
	
?>		
<a href="event.php?eve=<?php echo $childsticker_id ?>" class="pull-right label label-warning" name="<?php echo $childsticker_id; ?>"><?php echo $result_b; ?></a>

<?php
}
$suburb_id = $post['suburb_id'];
$rank = $call->query("SELECT rank FROM suburb WHERE suburb_id='$suburb_id'");
?>

<!-- LIKE BUTTON -->
<button onclick="like(this.value)" value="<?php echo $suburb_id; ?>" class="btn btn-sm"><i class="mdi-action-thumb-up"></i><span style="background-color:#2196F3" id="<?php echo $suburb_id; ?>" class="badge">
<?php echo $rank; ?></span></button>

</div>		
<?php
}
?>				
					
				</div>

				<div id="soclist" class="tab-pane fade">
					<div class="card">
    					<ul>
    					<?php

$output=$call->query_fetch("SELECT * FROM sticker");
?>
<?php
foreach ($output as $label) 
{
	$label_id = $label['sticker_id'];
?>
<li><div class="soclist_option" style="width:150px; overflow:hidden;"><a href="society.php?soc=<?php echo $label['sticker_id']; ?>"><?php echo $label['stickername']; ?></a>

<?php $output2=$call->query("SELECT COUNT(*) FROM subscribe WHERE user_id='$user_id' AND sticker_id='$label_id'"); 
if (!empty($output2)) 
{
	?>
	<span class="label">Subscribed</span>
<?php
}
?>
</div></li>
<?php
}
?>
    						
    						
    					</ul>
    				</div>
    			</div>

			</div>

				<div class="col-md-5 col-lg-3" id="stats">
					<div class="card">
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
					</div>
					<div class="card card-s">
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
				</div>
				
			</div>
		</div>
	
		<div class="modal fade" id="create-event" role="dialog" style="top:100px;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h3 style="color:#333;" align="center">Create New Event</h3>
					</div>

					<!-- CREATE EVENT -->
					<div class="modal-body" id="create_event">
						<p class="text text-primary" align="center">
						<form role="form" action="" method="post"> 

						<div class="form-group col-sm-10">
							<label>Event Name:</label>
							<input type="text" id="name" class="form-control" name="label-name">
							<br>
							<textarea id="content" class="form-control" rows="2" placeholder="Add the required details..."></textarea>
							<div class="clearfix"></div>
							<button type="submit" class="pull-right btn btn-primary" onclick="insert()">Create</button>
						</div>						
						<div class="clearfix"></div>
					</form>
						</p>
				</div>

				
				<!-- CREATE EVENT ENDS -->

					</div>
			</div>
		</div>
		
		<div class="error" id="tata">
			<span id="tata2"></span>
			<button  style="color:#EF5350;"type="button"class="btn btn-sm pull-right">
				Close
			</button>
		</div>	

</body>
</html>

<?php
//label colors
$labelColors = array("#424242","#01579B","#0288D1","#29B6F6","#B3E5FC");
$i=0;
foreach ($labels as $topLabels) {
   if (!empty($topLabels['rank'])) {
      $labelId = $topLabels['sticker_id'];
      $labelCount = $call->query("SELECT COUNT(*) FROM suburb WHERE sticker_id='$labelId'");
?>

<script type="text/javascript">
      for(var i = 0; i < <?php echo $labelCount; ?>; i++)
      {
         document.getElementsByName(<?php echo $labelId; ?>)[i].style.backgroundColor = "<?php echo $labelColors[$i]; ?>";
      };
</script>

<?php
$i=$i+1;
}
}

//childlabel colors
$childlabelColors = array("#424242","558B2F","#8BC34A","#AED581","#DCEDC8");
$j=0;
foreach ($childlabels as $childtopLabels) {
   if (!empty($childtopLabels['rank'])) {
      $childlabelId = $childtopLabels['childsticker_id'];
      $childlabelCount = $call->query("SELECT COUNT(*) FROM suburb WHERE childsticker_id='$childlabelId'");
?>

<script type="text/javascript">
      for(var i = 0; i < <?php echo $childlabelCount; ?>; i++)
      {
         document.getElementsByName(<?php echo $childlabelId; ?>)[i].style.backgroundColor = "<?php echo $childlabelColors[$j]; ?>";
      };
</script>

<?php
$j=$j+1;
}
}
?>
