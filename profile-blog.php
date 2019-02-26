<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require "connect.inc.php";
include_once("navigation.php");
$title = 'Blog';
$usersIDCookie = $_COOKIE['usersIDCookie'];
# CHECKING IF THE TO SIGNED IN USER IS THE BLOG OWNER #
// SIGNED IN USERS ACCOUNT INFORMATION
$blogIDQuery = mysqli_query($con, "SELECT * FROM users WHERE id = '$usersIDCookie' ");
$blogIDQueryResults = mysqli_fetch_array($blogIDQuery);
$signed_in_user_username = $blogIDQueryResults['username'];
$usersBlogUsername = $_REQUEST['profile'];
// IF THE SIGNED IN USERS USERNAME IS EQUAL TO THE PROFILE USERNAME THE BLOG IS OWNED BY THE SIGNED IN USER
if($signed_in_user_username==$usersBlogUsername) { //BLOG OWNER
	include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/blog-owner-form-code.php");
} else { //NOT BLOG OWNER
	include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/blog-not-owner-code.php");
}
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php");
?>
