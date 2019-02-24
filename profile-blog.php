<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require "connect.inc.php";
include_once("navigation.php");
$title = 'Blog';
$usersIDCookie = $_COOKIE['usersIDCookie'];  // SIGNED IN USERS COOKIE ID  #
############################################################################

#######################################################
# CHECKING IF THE TO SIGNED IN USER IS THE BLOG OWNER #
#######################################################

// SIGNED IN USERS ACCOUNT INFORMATION
$blogIDQuery = mysqli_query($con, "SELECT * FROM users WHERE id = '$usersIDCookie' ");
$blogIDQueryResults = mysqli_fetch_array($blogIDQuery);
// THE SIGNED IN USERS USERNAME
$signed_in_user_username = $blogIDQueryResults['username'];
// THE PROFILE BLOG USERNAME
$usersBlogUsername = $_REQUEST['profile'];
// IF THE SIGNED IN USERS USERNAME IS EQUAL TO THE PROFILE USERNAME THE BLOG IS OWNED BY THE SIGNED IN USER
if($signed_in_user_username==$usersBlogUsername) {
	// THE SIGNED IN USER IS THE BLOG OWNER
	include_once("blog-owner-form-code.php");
} else {
	// THE USER DOES NOT OWN THE BLOG
	include_once("blog-not-owner-code.php");
}

include_once("footer.php");
?>
