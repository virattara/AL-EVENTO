<?php
require 'header.php';

if (!isset($_GET['soc'])) 
{
   header("Location:index.php");
   exit();
}

$call = new commands();
$sticker_id = $_GET['soc'];


$stickerInfo = $call->query_fetch("SELECT stickername,picture,description FROM sticker WHERE sticker_id='$sticker_id'");

if (empty($stickerInfo)) {
   exit();
}

$admin = $call->query_fetch("SELECT community.user_id,community.username FROM community NATURAL JOIN sticker WHERE sticker.sticker_id='$sticker_id'");
$memCount = $call->query("SELECT COUNT(*) FROM senator where sticker_id='$sticker_id' AND block='false'");
$subCount = $call->query("SELECT COUNT(*) FROM subscribe where sticker_id='$sticker_id'");
$events = $call->query_fetch("SELECT childsticker_id,name FROM childsticker where sticker_id='$sticker_id'");
?>


<div class="container-fluid act-body">
			<div class="row">
				
         		<div class="col-md-5 col-md-offset-1 col-lg-5" id="userabout">
         			<div class="card">
         					<img src="<?php if(!empty($stickerInfo[0]['picture'])) echo $stickerInfo[0]['picture']; else echo "../img/noimage.png"; ?>" class="userpic1 img img-responsive img-circle">
         				<div class="half1">
         					<h3><?php echo $stickerInfo[0]['stickername']; ?></h3>
         				</div>
         				<div class="half2">        		
         				<div class="clearfix"></div>		
         					<ul class="ul4">
         						<li><?php if(!empty($admin[0]['username'])) echo $admin[0]['username']; ?></li>
         						<li>Number of Members: <?php echo $memCount; ?></li>
                           <li>Number of Subscribers: <?php echo $subCount; ?></li>

         						<div class="clearfix"></div>

                 <!-- Button for editing info, modal at line 209-->          
                           <button type="button" style="background-color:#0D47A1; color:#fff;" class="btn btn-sm" href="#edit_info" data-toggle="modal">Edit Details</button>
         					</ul>
<?php 
if (!empty($admin[0]['user_id'])) {
if ($admin[0]['user_id'] != $_SESSION['user_id']) {
require 'societyTest.php'; 
}
}
?>
         				</div>
         					
         				<div class="clearfix"></div>
         				<div class="clearfix"></div>

         			</div>
               <ul class="nav nav-tabs" style="background-color:#EF5350;">
               <li class="active"><a data-toggle="tab" href="#description">About This Society</a></li>
               <li><a data-toggle="tab" href="#event_list">Events Organised by them</a></li>
               </ul>
               <div class="tab-content">
                  <div class="card tab-pane fade in active" id="description">
                     <h3 class="pad7"><b>Description</b></h3>
                     <p><?php echo $stickerInfo[0]['description']; ?></p>
                  </div>

         			<div class="card tab-pane fade" id="event_list">
                     <h3 class="pad7">Events Organised</h3>
                     <div class="clearfix"></div>
                     <ul class="list-unstyled ul3">

               <?php
foreach ($events as $tyohar) 
{
?>
<li>
<a href="event.php?eve=<?php echo $tyohar['childsticker_id']; ?>">
<div class="soc btn btn-sm">
<h5><?php echo $tyohar['name']; ?></h5>
</div>
</a>
</li>
<?php
}
?>
</ul>
               
         			</div>	
         			</div>
         		</div>	
						
				<div class="col-md-6 col-lg-7" id="feed1">


<?php 

$result = $call->query_fetch("SELECT * FROM suburb WHERE sticker_id='$sticker_id' ORDER BY time DESC");
if (empty($result)) 
{
?>
<div class="card noposts"><div class="clearfix"></div><em>There are no posts to show at the moment. <br>We will send you a notification when a new post is made.</em></div>
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
<a href="society.php?soc=<?php echo $sticker_id ?>" style="margin-left:5px" class="pull-right label label-warning" name="<?php echo $sticker_id; ?>"><?php echo $result_a; ?></a>

<?php 
//childlabel name
if ($post['childsticker_id'] != null) 
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

      <!-- Edit Society Info Modal button at line 46-->
      <div class="modal fade" id="edit_info" role="dialog" style="top:100px;">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="close">
                     <span aria-hidden="true">&times;</span>
                  </button>
                  <h3 style="color:#333;" align="center"><b>Edit Your Details</b></h3>
               </div>

               <div class="modal-body" id="create_event">
                  <p class="text text-primary" align="center">

                  <div id="image_preview"><img id="previewing" class="preview"/></div>
                  
                  <form role="form" id="uploadimage" method="POST" enctype="multipart/form-data"> 
<input class="col-sm-10" type="file" name="file" id="file"/>

<h4 id='loading' >Loading..</h4>
<div id="message"></div>
                  <div class="form-group col-sm-10">
                     <label>Change Description</label>
                     <textarea id="content" class="form-control" rows="2" placeholder="Add the required details..." name="content"></textarea>
                     <div class="clearfix"></div>

                     <button type="submit" class="pull-right btn btn-primary">Save Changes?</button>
                  </div>                  
                  <div class="clearfix"></div>
               </form>
                  </p>
                  <br>
            </div>

            
            <!-- CREATE EVENT ENDS -->

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
    } 
</script>
    <script>
	$(document).ready(function (e) {
	$('#loading').hide();
	$("#uploadimage").on('submit',(function(e) 
	{
		e.preventDefault();
		$("#message").empty();
		$('#loading').show();
		$.ajax({
		url: "societyEditPro.php",  // Url to which the request is send
		type: "POST",             // Type of request to be send, called as method
		data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
		contentType: false,       // The content type used when sending data to the server.
		cache: false,             // To unable request pages to be cached
		processData:false,        // To send DOMDocument or non processed data file it is set to false
		success: function(data)   // A function to be called if request succeeds
		{
			$('#loading').hide();
			$("#message").html(data);
			document.getElementById("uploadimage").reset();
		}
		});
	}));

// Function to preview image after validation
	$(function() 
	{
		$("#file").change(function() 
		{
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match= ["image/jpeg","image/png","image/jpg","null"];

			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3])))
			{
				$('#previewing').attr('src','noimage.png');
				$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
				return false;
			}
			else
			{
			var reader = new FileReader();
			reader.onload = imageIsLoaded;
			reader.readAsDataURL(this.files[0]);
			}
		});
	});

	function imageIsLoaded(e) 
	{
		$("#file").css("color","green");
		$('#image_preview').css("display", "block");
		$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '250px');
		$('#previewing').attr('height', '230px');
	};

	
});

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


