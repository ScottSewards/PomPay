<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age = 0");
header("Cache-Control: post-check = 0, pre-check = 0", false);
header("Pragma: no-cache");
$title = 'Verify Email';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
$error = "";
$codeQuery = mysqli_query($con, "SELECT * FROM users WHERE id = '$userIDCookie'");
$codeArray = mysqli_fetch_array($codeQuery);
$emailCode = $codeArray['email_code'];
$verifiedEmail = $codeArray['verified_email'];
//CHECK THE USER HASNT ALREADY VERIFIED THEIR EMAIL
if($verifiedEmail == '1') header("location: dashboard.php");

$submitCode = htmlspecialchars(addslashes($_POST['code']));

if(isset($_POST['submit'])) { //CHECK SUBMIT CLICKED
	if($submitCode == $emailCode) { //CHECK CODES MATCH
		mysqli_query($con, "UPDATE users SET verified_email = '1' WHERE id = '$userIDCookie'"); //UPDATE TABLE
		header("location: dashboard.php"); //REDIRECT TO DASHBOARD
	} else {
		$error = "incorrect code";
	}
}
?>
<main>
	<section>
		<h1>Verify Email</h1>
		<p>Check your email address inbox for an email with an email verification code. Enter the code below to verify your email address. If you cannot see the email, check your junk folder or if you have not recieved the email, <a href="#">resend an email for verification.</a></p>
	</section>
	<section class="form-only">
		<form action='verify-email.php' method='post'>
			<input type='text' name='code' placeholder='62746354895'/>
			<input type='submit' name='submit' value='Verify Email'/>
		</form>
	</section>
	<?php
	if($error != "") {
		echo "
		<section class='info error'>
			<p>Error: $error</p>
		</section>";
	}
	?>
	<section>
		<p><a href='support.php'>Having trouble? Contact us through the support page.</a></p>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
