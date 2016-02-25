<?php 
require 'header.php';

if (empty($_GET['per'])) 
{
	header("Location:index.php");
	exit();
}
	
$call = new commands();

$user_id = $_GET['per'];
$username = $call->query("SELECT username FROM community WHERE user_id='$user_id'");

if (empty($username)) {
   exit();
}
$profile_pic = $call->query("SELECT email_id FROM community WHERE user_id='$user_id'");
$memberCount = $call->query("SELECT COUNT(*) FROM senator WHERE user_id='$user_id'");
$admin = $call->query_fetch("SELECT sticker_id,stickername FROM sticker where user_id='$user_id'");
$socId = $call->query_fetch("SELECT sticker_id from subscribe WHERE user_id='$user_id'");
?>

<div class="container-fluid act-body">
			<div class="row">
				
         		<div class="col-md-5 col-md-offset-1 col-lg-5" id="userabout">
         			<div class="card">

<img src="https://graph.facebook.com/<?php echo $profile_pic; ?>/picture?width=300" class="img img-responsive img-circle userpic1">
         				<div class="half1">
         					<h3>
         					<?php 
							echo $username;
         					 ?></h3>
         				</div>
         				<br>
         				<div class="half2">        		
         				  <div class="clearfix"></div>
         				  <div class="clearfix"></div>		
         					 <ul class="ul1">
<?php 
if (empty($memberCount)) 
{
echo "<li>Member of ".$memberCount." Society(s)</li>";	
}

if (!empty($admin)) 
{
echo '<li>Admin at<a class="btn btn-sm" style="color:#fff;font-size:1em;" href="society.php?soc='.$admin[0]['sticker_id'].'">'.$admin[0]['stickername'].'</a></li>';	
}

?>
         					 </ul>
         						<div class="clearfix"></div>
         						<div class="clearfix"></div>
         						<div class="clearfix"></div>
         						
    			</div>
         				</div>
         					
         				<div class="clearfix"></div>
         				<div class="clearfix"></div>

         			<div class="card">
         				<h3>Subscriptions</h3>
         				<div class="clearfix"></div>

         				<ul class="list-unstyled ul3">
         					
<?php
foreach ($socId as $socCount) 
{
   if (!empty($socCount)) {

   if (!empty($socCount['sticker_id'])) {
   $socCount1 = $socCount['sticker_id'];
   $naam = $call->query_fetch("SELECT stickername,picture FROM sticker WHERE sticker_id='$socCount1'"); 
	?>
<li>
<div class="soc">
<a href="society.php?soc=<?php echo $socCount1; ?>" class="btn btn-sm">

<img src="<?php if(!empty($naam[0]['picture'])) echo '../soc/'.$naam[0]['picture']; else echo "../img/noimage.png" ?>">
<h5><?php echo $naam[0]['stickername']; ?></h5>
</a>
</div>
</li>

<?php
}
}
else
{
   ?>
   <li>
<div class="soc">
<h5><em>This user hasn't subscribed to any societies at present.</em></h5>
</div>
</li>
<?php
}
}
?>

         				</ul>
         			</div>
         		</div>	
						
				<div class="col-md-6 col-lg-7" id="feed1">

<?php 

$result = $call->query_fetch("SELECT * FROM suburb WHERE user_id='$user_id' ORDER BY time DESC");

if (empty($result)) 
{
?>
<div class="card noposts"><div class="clearfix"></div><em>There are no posts to show for this user.</em></div>
<?php
}
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
	if ($post['picture'] != null) 
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
<a href="profile.php?user=<?php echo $owner_id ?>"><h4> <?php echo $result_c; ?> </h4></a>

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


if ($post['content'] != null) 
{
?>
<br><p><?php echo stripslashes(nl2br($post['content'])); ?></p>
<?php
}

//label name 
$sticker_id = $post['sticker_id'];
$result_a = $call->query("SELECT stickername FROM sticker WHERE sticker_id='$sticker_id'");
?>
<a href="society.php?soc=<?php echo $sticker_id ?>" style="margin-left:5px" class="pull-right label label-warning" name="<?php echo $sticker_id; ?>"><?php echo $result_a; ?></a>

<?php	
//childlabel name
if ($post['childsticker_id'] != null) 
{
	$childsticker_id = $post['childsticker_id'];
	$result_b = $call->query("SELECT name FROM childsticker WHERE childsticker_id='$childsticker_id'");
?>		
<a href="xxx.php?soc=<?php echo $childsticker_id ?>" class="pull-right label label-warning" name="<?php echo $childsticker_id; ?>"><?php echo $result_b; ?></a>

<?php
}
$suburb_id = $post['suburb_id'];
$rank = $call->query("SELECT rank FROM suburb WHERE suburb_id='$suburb_id'");
?>

<!-- LIKE BUTTON -->
<button onclick="like(this.value)" value="<?php echo $suburb_id; ?>" class="btn btn-sm"><i class="mdi-action-thumb-up"></i><span style="background-color:#2196F3" id="<?php echo $suburb_id; ?>" class="badge"><?php echo $rank; ?></span></button>


</div>		
<?php
}
?>				



					</div>
				</div>
			</div>
		</div>

</body>

<script>
   function like(id){
   $.ajax({
         data: 'value='+id,
      method: 'POST',
      url: 'rate.php',
      cache: false,
      error: function(object)
               {
                  document.write(object.responseText);
               },
      success: function(result)
            {
               if (result != 'liked') 
                  {
                     document.getElementById(id).innerHTML=result;
                  };
            }

    });  
</script>


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

<script>
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