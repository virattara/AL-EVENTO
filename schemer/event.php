<?php
require 'header.php';

if (!isset($_GET['eve'])) 
{
   header("Location:index.php");
   exit();
}

$call = new commands();
$childsticker_id = $_GET['eve'];


$info = $call->query_fetch("SELECT sticker_id,name,description FROM childsticker WHERE childsticker_id='$childsticker_id'");

if (empty($info)) {
  exit();
}

$sticker_id = $info[0]['sticker_id'];
$sticker = $call->query("SELECT stickername from sticker WHERE sticker_id='$sticker_id'");

?>
<div class="container-fluid act-body">
			<div class="row">
				<div class="col-lg-1"></div>
         		<div class="col-sm-6 col-md-6 col-lg-4" id="eventabout">
         			<div class="card">
         				
         				<h3><?php echo $info[0]['name']; ?></h3>
         				        		
         				<div class="clearfix"></div>
         							
         					<ul class="ul5 list-unstyled">
         						<li>Organised By <?php echo $sticker; ?> Society</li>
         						<div class="clearfix"></div>
         					</ul>
          			</div>
                <div class="card" id="description">
                  <h4><b>Description</b></h4>
                <p>
                <?php echo $info[0]['description']; ?>
                </p>              
              </div>
<script src="../js/jquery.raty.js"></script>
          			<div class="card" id="ratings">
         				<p>User Ratings on this event :
                <div id="ratyRating"></div> 
         				<span class="rating" id="ratyResult">
        					
    					</span><br>

    					</p>        				
         			</div>
         		</div>
						
				<div class="col-sm-6 col-md-5 col-md-offset-1 col-lg-6 col-lg-offset-1" id="feed1">

				<?php 

$result = $call->query_fetch("SELECT * FROM suburb WHERE childsticker_id='$childsticker_id' ORDER BY suburb.time DESC");
if (empty($result)) 
{
?>
<div class="card noposts"><div class="clearfix"></div>NO POSTS</div>
<?php
}

?>


<!--<div id="ratyRating"></div>-->
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
<a href="profile.php?per=<?php echo $owner_id ?>"><h5> <?php echo $result_c; ?> </h5></a>

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
   echo "<h5>Posted Today</h5>";
}
else if ($postTime == 1)
{
   echo "<h5>Posted Yesterday</h5>";
}
else 
   echo "<h5>Posted ".$postTime." days ago</h5>";


if ($post['content'] != null) 
{
?>
<p><?php echo stripslashes(nl2br($post['content'])); ?></p>
<?php
}

//label name 
$sticker_id = $post['sticker_id'];
$result_a = $call->query("SELECT stickername FROM sticker WHERE sticker_id='$sticker_id'");
?>
<a href="society.php?soc=<?php echo $sticker_id ?>"  style="margin-left:5px" class="pull-right label label-warning" name="<?php echo $sticker_id; ?>"><?php echo $result_a; ?></a>

<?php 
//childlabel name
if ($post['childsticker_id'] != null) 
{
   $childsticker_id = $post['childsticker_id'];
   $result_b = $call->query("SELECT name FROM childsticker WHERE childsticker_id='$childsticker_id'");
?>    
<a href="event.php?eve=<?php echo $childsticker_id ?>"  class="pull-right label label-warning" name="<?php echo $childsticker_id; ?>"><?php echo $result_b; ?></a>

<?php
}
$suburb_id = $post['suburb_id'];
$rank = $call->query("SELECT rank FROM suburb WHERE suburb_id='$suburb_id'");
?>

<!-- LIKE BUTTON -->
<button onclick="like(this.value)" value="<?php echo $suburb_id; ?>" class="btn btn-sm"><i class="mdi-action-thumb-up"></i><span style="background-color:#2196F3
" id="<?php echo $suburb_id; ?>" class="badge"><?php echo $rank; ?></span></button>

</div>      
<?php
}
?>          
               
            </div>
					
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
 };
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

$(document).ready(function() {
    $('#ratyRating').raty({
        path: '../images/',
        size: 24,
        // The name of hidden field generated by Raty
        scoreName: 'star',
        // Revalidate the star rating whenever user change it
        click: function (score) {
          var value = <?php echo $childsticker_id; ?>;
            $.ajax({
              data: 'likes='+score+'&valve='+value,
              method: 'POST',
              url: 'ratyRate.php',
              cache: false,
          error: function(object)
          {
            document.write(object.responseText);
          },
          success: function(result)
          {
            document.getElementById('ratyRating').innerHTML = result;
          }              

            });
        }
    });
    });
</script>