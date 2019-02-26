<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//CONNECTING TO THE DATABASE
require "connect.inc.php";
//USERS COOKIE INFORMATION
$usersIDCookie = $_COOKIE['usersIDCookie'];
//GETTING THE USERS EMAIL CODE FROM THE DATABASE
$codeQuery = mysqli_query($con, "SELECT * FROM users WHERE id = '$usersIDCookie' ");
$codeArray = mysqli_fetch_array($codeQuery);
$emailCode = $codeArray['email_code'];
$verified_email = $codeArray['verified_email'];
//CHECK THE USER HASNT ALREADY VERIFIED THEIR EMAIL
if($verified_email == '1') {
	header("location: dashboard.php");
}
//GET THE CODE THE USER HAS SUBMIT
$RAWsubmitCode = $_POST['code'];
$SubmitButton = $_POST['submit'];
$SubmitCode = htmlspecialchars(addslashes($RAWsubmitCode));
//IF THE USER HAS CLICKED SUBMIT
if(isset($SubmitButton)) {
	//CHECKING THE TWO CODES MATCH
	if($SubmitCode == $emailCode) {
		//THE CODE IS A MATCH
		//UPDATE THE USERS TABLE
		mysqli_query($con, "UPDATE users SET verified_email = '1' WHERE id = '$usersIDCookie'");
		header("location: dashboard.php");
	} else {
		$WrongCodeError = "The code you entered is incorrect.";
	}
}
$title = 'Verify Email';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
?>
<main>
	<section>
		<h1>Verify Email</h1>
		<p>Check your email address inbox for an email with an email verification code. Enter the code below to verify your email address. If you cannot see the email, check your junk folder or if you have not recieved the email, <a href="#">resend an email for verification.</a></p>
	</section>
	<section class="form-only">
		<form action='email_ver.php' method='post'>
			<input type='text' name='code' placeholder='62746354895'/>
			<input type='submit' name='submit' value='Verify Email'/>
		</form>
	</section>
	<section>
		<p><?php echo "$WrongCodeError"?></p>
		<p><a href='support.php'>Having trouble? Contact us through the support page.</a></p>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
