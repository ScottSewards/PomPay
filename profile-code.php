<?php
// CONNECTING TO THE DATABASE
require "connect.inc.php";
// GETTING COOKIE INFORMATION
$usersIDCookie = $_COOKIE['usersIDCookie'];
// REQUESTING THE PROFILE ID
$profileUsername = $_REQUEST['profile'];
// GETTING THE PROFILE INFORMATION
$queryOne = mysqli_query($con, "SELECT * FROM profile WHERE owners_username = '$profileUsername' ");
$queryResults = mysqli_fetch_array($queryOne);
$profileState = $queryResults['state'];
$profileUsername = $queryResults['owners_username'];
$profileOwnersID = $queryResults['owners_id'];
$profileID = $queryResults['id'];
$profileDescription = $queryResults['description'];
$profileVideo = $queryResults['embed_video'];

$socialLinksFacebook = $queryResults['facebook'];
$socialLinksTwitter = $queryResults['twitter'];
$socialLinksYouTube = $queryResults['youtube'];

$queryTwo = mysqli_query($con, "SELECT * FROM users WHERE id = '$profileOwnersID' ");
$queryResultsTwo = mysqli_fetch_array($queryTwo);
$profilePictureLocation = $queryResultsTwo['profile_picture'];
$profileBannerLocation = $queryResultsTwo['profile_banner'];
$UsersUsername = $queryResultsTwo['username'];
$profileEthereumAddress = $queryResultsTwo['ethereum_address'];
$profileBitcoinAddress = $queryResultsTwo['bitcoin_address'];

// CREATE REDIRECT IF THE PROFILE IS NOT ACTIVE // AND THE USER IS NOT THE OWNER OF THE PROFILE
if($profileState == 0) {
	$stateMessage = "inactive and cannot be seen by other users.";
	if($profileOwnersID==$usersIDCookie) {
		//DO NOTHING
	} else {
		header("location: index.php");
	}
} else {
	$stateMessage = "active and can be seen by other users.";
}
// CREATE A SCRIPT TO REDIRECT THE USER BACK TO THE INDEX IF THEY EDIT THE URL
//UPDATING THE SOCIAL ACCOUNTS // 255 CHAR LIMIT
$LINKsubmit = $_POST['submit'];
$LINKfacebook = $_POST['facebook'];
$LINKtwitter = $_POST['twitter'];
$LINKyoutube = $_POST['youtube'];
// UPDATING THE ABOUT
$profileAbout = $_POST['profile-about'];
$profileStateAD = $_POST['activate_deactivate'];
$embed_video = $_POST['videoCode'];

if(isset($LINKsubmit)) {
	$updateSocial = mysqli_query($con, "UPDATE profile SET facebook = '$LINKfacebook' WHERE owners_id = '$usersIDCookie' ");
	$updateSocial = mysqli_query($con, "UPDATE profile SET twitter = '$LINKtwitter' WHERE owners_id = '$usersIDCookie' ");
	$updateSocial = mysqli_query($con, "UPDATE profile SET youtube = '$LINKyoutube' WHERE owners_id = '$usersIDCookie' ");
	$updateSocial = mysqli_query($con, "UPDATE profile SET description = '$profileAbout' WHERE owners_id = '$usersIDCookie' ");
	$updateSocial = mysqli_query($con, "UPDATE profile SET state = '$profileStateAD' WHERE owners_id = '$usersIDCookie' ");
	$updateSocial = mysqli_query($con, "UPDATE profile SET embed_video = '$embed_video' WHERE owners_id = '$usersIDCookie' ");
	header("location: profile-editor.php?profile=$UsersUsername");
}
?>
