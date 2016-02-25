<?php
if (empty($_GET['soc'])) 
{
	header("Location:index.php");
	exit();
}

?>
<script type="text/javascript">
	function subscribe(id){
		var sub = <?php echo $_GET['soc'] ; ?>;
		document.getElementById(id).value = "loading...";
		$.ajax({
			data: 'sticker_id='+sub,
         	method: 'POST',
			url: "society_pro.php",
			cache: false,
          	error: function(object)
          		{
            		document.write(object.responseText);
          		},
		  	success: function(result) 
          		{
          			if (result == 'incept') 
          				{
          					document.getElementById(id).value = "un-subscribe";
          				};
          			if (result == 'decept') 
          				{
          					document.getElementById(id).value = "subscribe";
          				};
		  		}
		});
	};

	function member(id,value){
		var sub = <?php echo $_GET['soc'] ; ?>;
		var tokenjs = value;
		document.getElementById(id).value = "loading...";

		$.ajax({
			data: 'sticker_id='+sub+'&token='+tokenjs,
         	method: 'POST',
			url: "society_mem_pro.php",
			cache: false,
          	error: function(object)
          		{
            		document.write(object.responseText);
          		},
		  	success: function(result) 
          		{
          			if (result == 'incept') 
          				{
          					document.getElementById(id).value = "Cancel Request";
          				};
          			if (result == 'decept') 
          				{
          					document.getElementById(id).value = "Become a Member";
          				};
          			if (result == 'deceptfinal') 
          				{
          					document.getElementById(id).value = "Become a Member";
          				};
          			if (result == 'bad request') 
          				{
          					document.write("Bad Request");
          				};
		  		}
		});
	};
	</script>

<?php

if (!isset($_GET['soc'])) 
{
	session_destroy();
	header("Location:index.php");
	exit();
}


//EDIT button only for admin
#make this on joning day

//subscribe button
$user_id = $_SESSION['user_id'];
$count = $call->query("SELECT COUNT(*) FROM subscribe WHERE user_id='$user_id' AND sticker_id='$sticker_id'");
if ($count == 0) 
{
?>
	<input class="btn btn-sm subs-btn" style="color:#fff;" type="button" id="911" onclick="subscribe(this.id)" value="subscribe"></input>
<?php
}
else 
{
?>
	<input class="btn btn-sm subs-btn" style="color:#fff;" type="button" id="9112" onclick="subscribe(this.id)" value="un-subscribe"></input>
<?php
}


//membership request button
$count_b = $call->query("SELECT COUNT(*) FROM senator WHERE user_id='$user_id' AND sticker_id='$sticker_id'");
if ($count_b == 0) 
{
?>

	<input class="btn btn-sm add-btn" type="button" style="color:#fff;" id="9113" onclick="member(this.id,this.value)" value="Become a Member"></input>

<?php
}
else
{
	$count_c = $call->query("SELECT COUNT(*) FROM senator WHERE user_id='$user_id' AND sticker_id='$sticker_id' AND block='true'");
	if ($count_c == 0) 
	{
	?>
	
		<input class="btn btn-sm add-btn" style="color:#fff;" type="button" id="9114" onclick="member(this.id,this.value)" value="Resign"></input>
	<?php
	}
	else 
	{
	?>

		<input class="btn btn-sm add-btn" style="color:#fff;" type="button" id="9115" onclick="member(this.id,this.value)" value="Cancel Request"></input>	
	<?php
	}
}




?>

