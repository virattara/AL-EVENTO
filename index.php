<?php
session_start();
if (isset($_SESSION['satanbloodbank'])) {
	if ($_SESSION['satanbloodbank'] === 'parkhov') 
	{
	header("Location:fbOAuth.php");
	exit();
	}
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">


<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="Chutiyap">
	<meta name="author" content="EHRA">
	<meta name="theme-color" content="#0D47A1">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#0D47A1">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#0D47A1">
	
	<title>AL:EVENTO</title>
	<link rel="icon" href="screenshots/logo.png">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/aspen.css">
	<link href="css/roboto.min.css" rel="stylesheet">
    <link href="css/material.min.css" rel="stylesheet">
    <link href="css/ripples.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Oswald:700,400' rel='stylesheet' type='text/css'>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/aspen2.js"></script>
<script src="js/ripples.min.js"></script>
<script src="js/material.min.js"></script>

<script>
    $(document).ready(function() {
    $.material.init();
        });
</script>



</head>


<body>	
	
	
	<style type="text/css">
	.navbar-inverse.navbar {
		background-color: #0D47A1;
					}
	.navbar-brand{	
		letter-spacing: 2px;
		left: 15px;
		font-size: 2em;
		font-family: "Oswald",sans-serif;
					}
	.container{
	z-index: 1;
}
.container-fluid{
	z-index: 0;
}
	</style>
		
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				
				<a class="navbar-brand page-scroll" href="#page-top">
					 AL:EVENTO
				</a>					
				</div>
				<div class="collapse navbar-collapse navbar-right navbar-main-collapse">
					<ul class="nav navbar-nav navbar-right">
						<!-- Hidden li included to remove active class from section1 link when scrolled up past section1 -->
                    <li>
                        <a class="page-scroll active" data-toggle="tab" href="#section1">Introduction</a>
                    </li>
                    <li>
                        <a class="page-scroll" data-toggle="tab" href="#section3">Features</a>
                    </li>
                    <li>
                        <a class="page-scroll" data-toggle="tab"href="#section5">Contact Us</a>
                    </li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container-fluid">
			<div class="row">
				<div class="intro">
					<div class="intro-body">
						<div class="col-md-offset-1 col-md-10 col-xs-10 c0l-xs-offset-1">							
							<h1 class="heading">AL : EVENTO</h1>
							<p>
							For the Stuff That Matters:<br> 
							Learn. Rank. Dominate.<br>
							

							</p>
							<a href="fbOAuth.php" class="btn btn-info">Login WIth Facebook</a><br>
							<a href="#section1"><span style="color:#000; font-size:20px;"class="glyphicon glyphicon-chevron-down"></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>

<div class="container">
	<div class="row">
		<div class="col-md-offset-1 col-md-10 col-md-offset-1" id="section_top">
			<div id="section1">
				<div class="info col-md-5 col-md-offset-2">
					<h2 class="mainheading">All Events.</h2>
					<p>Tired of looking out for posters throughout the campus? Here's a new effort to provide a fresh approach to publicity & much more...<br>Get to know about each & every society in your campus. Follow the admin,society,event. Basically, follow everything.</p>
				</div>
				<div class="col-md-5">
					<img src="screenshots/event1.jpg" class="img1">
				</div>
			</div>

			<div id="section2">
				<div class="col-md-5">
					<img src="screenshots/identity1.jpg" class="img1">
				</div>
				<div class="info col-md-offset-1 col-md-5">
					<h2 class="mainheading">...PlugIn to your Identity!</h2>
					<p> And come, become a part of this new platform to get a hang of up and running events in your Halls of Ivy!!.</p>
				</div>
			</div>

			<div id="section3">
				<div class="info col-md-5 col-md-offset-2">
					<h2 class="mainheading">Did Somebody Say Event?</h2>
						<p>	Every society with its own event...<br>
						covered by the people, to provide the people, with what all they need.<br> From posters, to recruits, to the main event and then the never-ending galleria of pictures and videos,<br> Post 'em All and Stay Updated.</p>				</div>
				<div class="col-md-5">
					<img src="screenshots/feature1.jpg" class="img1">
				</div>
			</div>
			<div id="section4">
				<div class="col-md-5">
					<img src="screenshots/stuff1.jpg" class="img1">
				</div>
				<div class="info col-md-offset-1 col-md-5 ">
					<h2 class="mainheading">Stuff that Matters...</h2>
					<p>Subscribe to Societies<br>
						Follow Events. Rank them. And make Them Trending.<br> After all, give them a title to fight for.</p>
				</div>
			</div>
			<div id="section5">
				<div class="info col-md-offset-2 col-md-7" style="text-align:center;">
					<h2 class="mainheading">See What We Mean?</h2>
					<p>If Not, <br>
						Drop a query at the e-mail below and we will be there to oblige.<br> Happy to help.
						<br> <h4>helpdesk@alevento.in</h4>
					</p>
				</div>
			</div>

		</div>
	</div>
</div>
<footer>
	<p>Copyright: Al:Evento 2015
	<a class="btn btn-sm pull-right page-scroll" data-toggle="tab" href="#page-top">Go back to top</a>
</p>
</footer>
</body>

</html>

