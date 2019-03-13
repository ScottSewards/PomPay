<?php
//$con = mysqli_connect("localhost", "dfbdfdfe_user2", "h76thgfuy65!£", "dfbdfdfe_myApplication"); //COMMENT OUT IF OFFLINE
//$con = mysqli_connect("localhost", "root", "", "verde"); //COMMENT OUT IF SCOTT
$con = mysqli_connect("localhost", "root", "", "pompay"); //COMMENT OUT IF TOM
if(mysqli_connect_error()) {
	echo "Connection failed.";
	die();
}
?>
