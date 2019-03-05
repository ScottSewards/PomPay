<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/connect.inc.php");
$userIDCookie = $_COOKIE['usersIDCookie'];
$userPasswordCookie = $_COOKIE['usersPasswordCookie'];
$usernameQuery = mysqli_query($con, "SELECT username FROM users WHERE id = '$userIDCookie'");
$queryResults = mysqli_fetch_array($usernameQuery);
$username = $queryResults['username'];
?>
<!DOCTYPE html>
<html>
  <head>
		<base href="http://localhost/Pompay/"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width = device-width, initial-scale = 1.0"/>
    <title id="title">Pompay <?php if($title != "") echo " - $title"; ?></title>
    <link href="images/favicon-new.png" rel="icon" type="image/gif" sizes="64x64"/>
		<link href="css/master.min.css" rel="stylesheet" type="text/css"/>
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/master.js" type="text/javascript"></script>
		<script src="js/dapp.js" type="text/javascript"></script>
		<script src="js/jquery-pack.js" type="text/javascript"></script>
		<script src="js/jquery.imgareaselect.min.js" type="text/javascript"></script>
	</head>
	<body>
