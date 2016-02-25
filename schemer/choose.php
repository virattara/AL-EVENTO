<?php
require '../crumbs/class.SessionManagement.php';
$SM = new SessionManagement();
$SM->sessionOpen();
if(!$SM->checkSession()) {
  header("Location:../");
  exit();
} 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE-edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="EHRA">
  
  <title>Aspen Technologies</title>
  
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
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
</head>


<body>
<div class="clearfix"></div>

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
          <ul class="nav mynav navbar-nav navbar-right">
              <li class="brand navbar-brand">AL:EVENTO</li>
          </ul>
        </div>
    </div>
  </nav>
<style type="text/css">
.navbar-brand{
            letter-spacing: 2px;
            left: 15px;
            font-size: 2em;
            color: #EF5350;
            font-family: "Oswald",sans-serif;
          }

</style>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card select" id="select">
          <h3>Personalised Subscriptions</h3>
          <br>
          <p> You will recieve notifications and posts from the soceities you choose:</p>
          <br>
          <ul class="list-unstyled">
<?php


require '../crumbs/hospital.php';
$call = new commands();

$result=$call->query_fetch("SELECT * FROM sticker");
?>

<?php
foreach ($result as $card) 
{
      $pic = '../soc/'.$card['picture'];

?>
<li>
    <div class="select_soc">
    <img src="<?php echo $pic; ?>">
    <form class="form-control">
    <div class="checkbox checkbox-primary"><label><input name="sticker" type="checkbox" class="pull-left" value="<?php echo $card['sticker_id']; ?>"><?php echo ' '.$card['stickername']; ?></label></div>
    </div>
    </form>

</li>
<?php
}
?>      
          </ul>
          <div class="clearfix"></div>
        <button type="submit" class="select_submit btn pull-right" onclick="load()">Submit Choices</button>
        
        </div>
      </div>
    </div>
  </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {
    $.material.init();
        });
      function load() 
      {
        
        var checkboxes = document.querySelectorAll('input[name="sticker"]:checked'), stickers = [];
        Array.prototype.forEach.call(checkboxes, function(el) 
        {
          stickers.push(el.value);
        });
        
        $.ajax
        ({
          data: 'stickersphp='+stickers,
          method: 'POST',
          url: './choose_pro.php',
          cache: false,
          error: function(object)
          {
            document.write(object.responseText);
          },
		  success: function(result) 
          {
            window.location = "./index.php";
		      }
        });
      };

    </script>


