<?php
//$con = mysqli_connect("localhost", "dfbdfdfe_user2", "h76thgfuy65!£", "dfbdfdfe_myApplication"); //COMMENT OUT IF USING OFFLINE SERVER
$con = mysqli_connect("localhost", "root", "", "verde"); //COMMENT OUT IF USING ONLINE SERVER
if(mysqli_connect_error()) {
	echo "The website could not connect to the database";
	die();
}
?>
