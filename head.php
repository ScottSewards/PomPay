<?php
	//$con = mysqli_connect("localhost", "dfbdfdfe_user2", "h76thgfuy65!£", "dfbdfdfe_myApplication"); //COMMENT OUT IF USING OFFLINE SERVER
	$con = mysqli_connect("localhost", "root", "", "verde"); //COMMENT OUT IF USING ONLINE SERVER

	if(mysqli_connect_error()) {
		echo "The website could not connect to the database.";
		die();
	}

	$usersIDCookie = $_COOKIE['usersIDCookie'];
	$usersPasswordCookie = $_COOKIE['usersPasswordCookie'];
	// GETTING THE SIGNED IN USERS USERNAME
	$usernameQuery = mysqli_query($con, "SELECT username FROM users WHERE id = '$usersIDCookie' ");
	$QueryResults = mysqli_fetch_array($usernameQuery);
	$TheUserUsername = $QueryResults['username'];
?>
<!DOCTYPE html>
<html>
  <head>
		<base href="http://localhost/Pomnia/"/> <!--SUPER-->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title id="title">Pompay - <?php echo $title; ?></title>
    <link rel="icon" type="image/gif" href="images/logo.png" sizes="64x64"/>
		<link href="css/new.min.css" rel="stylesheet" type="text/css"/>
    <script src="jq/jq.js" type="text/javascript"></script>
		<script src="js/rs.js" type="text/javascript"></script>
    <script src="js/ts.js" type="text/javascript"></script>
		<!--SORT THESE LINKS-->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  </head>
  <body>
