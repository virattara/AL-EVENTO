    <script>
	$(document).ready(function (e) {
	$('#loading').hide();
	$("#uploadimage").on('submit',(function(e) 
	{
		e.preventDefault();
		$("#message").empty();
		$('#loading').show();
		$.ajax({
		url: "suburbinsert.php",  // Url to which the request is send
		type: "POST",             // Type of request to be send, called as method
		data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
		contentType: false,       // The content type used when sending data to the server.
		cache: false,             // To unable request pages to be cached
		processData:false,        // To send DOMDocument or non processed data file it is set to false
		success: function(data)   // A function to be called if request succeeds
		{
			$('#loading').hide();
			$("#message").html(data);
			document.location.reload();

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
//functions for chained text boxes
</script>

<script type="text/javascript">
function getState(id)
	{
	$.ajax
        ({
          data: 'sticker_id='+id,
          method: 'POST',
          url: 'suburbajax.php',
          cache: false,
          error: function(object)
          {
            document.write(object.responseText);
          },
		  success: function(result) 
          {
          	$("#states").html(result);
		  }
        });		
	};

function disable()
	{		 
		document.getElementById('states').value="null";
		$("#states").toggle();
	};
</script>

<div class="card post" >
<h3>Post an Update..</h3>

<form role="form" id="uploadimage" method="POST" enctype="multipart/form-data">

<div id="image_preview"><img id="previewing" class="preview"/></div>

<div class="form-group col-sm-10">

<p><textarea class="form-control" rows="2" placeholder="What's coming up?" rows="5" columns="5" name="content" required></textarea></p>
</div>

<div class="clearfix"></div>
<!--NOT NECCESSARY -->
<input class="col-sm-10" type="file" name="file" id="file"/>

<h4 id='loading' >loading..</h4>
<div id="message"></div>

<div class="clearfix"></div>

<?php
$user_id = $_SESSION['user_id'];
$call = new commands();

$result = $call->query_fetch("SELECT senator.sticker_id,sticker.stickername from sticker INNER JOIN senator ON senator.sticker_id = sticker.sticker_id WHERE senator.user_id='$user_id' AND senator.block='false'");
?>
<!--NECCESSARY -->
<div class="form-group col-sm-7">	
<label class="control-label">Choose the audience for this post: </label>
<select id="group" class="form-control" name="country" onChange="getState(this.value)" required>
<option value="">Select Society</option>
<?php
foreach ($result as $info) 
{
?>
<option value="<?php echo $info['sticker_id']; ?>"><?php echo $info['stickername']; ?></option>
<?php
}
?>
</select>
<br>
<!--NOT NECCESSARY -->
<p><input type="checkbox" onchange="disable()"> Post only to society</input></p>
<select name="state" class="form-control" id="states">  
<option value="">Select Event</option>
</select>

</div>
<br>
<button class="pull-right btn btn-primary" type="submit" value="Upload">POST</button>
</form>
</div>

