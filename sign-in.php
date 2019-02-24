<?php
	/* checking if the user is signed in this is done by checking if the two cookies are there with
	the users ID and password */
	$usersIDCookie = $_COOKIE['usersIDCookie'];
	$usersPasswordCookie = $_COOKIE['usersPasswordCookie'];

	if((isset($usersPasswordCookie)) AND (isset($usersIDCookie))) {
		header("location: dashboard.php"); //REDIRECT TO DASHBOARD
	} else { //SIGNED OUT

	}
	// importing the connect.inc.php file
	require "connect.inc.php";
	// grabbing hold of the email and password submitted by the user
	$RAWEmail = $_POST['email'];
 	$RawPassword = $_POST['password'];
	// removing the special chars and adding slashes
	$loginPassword = htmlspecialchars(addslashes($RawPassword));
	$loginEmail = htmlspecialchars(addslashes($RAWEmail));
	$loginSubmit = $_POST['submit'];

	if(isset($loginSubmit)) {
		// CHECKING IF EMAIL AND PASSWORD ARE FILLED OUT
		if((!empty($loginEmail)) AND (!empty($loginPassword))) {
			// EMAIL AND PASSWORD FILLED
			// GET THE STORED PASSWORD FOR THE EMAIL
			$loginQuery = mysqli_query($con, "SELECT * FROM users WHERE email = '$loginEmail' ");
			// TAKING THAT QUERY AND PUTTING IT INTO AN ARRAY
			$queryResults  = mysqli_fetch_array($loginQuery);
			// TAKING THAT ARRAY AND CREATING VARIABLES
			$storedPassword = $queryResults['password'];
			$storedID = $queryResults['id'];
			// COMPARE USER INPUT PASSWORD WITH HASHED PASSWORD FROM DATABASE
			if(password_verify($loginPassword,$storedPassword)) {
				// CONTINUE TO LOGIN
				// CREATE COOKIES WITH USER ID AND SECURE PASSWORD
				setcookie("usersIDCookie", $storedID, time()+86400);
				setcookie("usersPasswordCookie", $storedPassword, time()+86400);
				header("location: dashboard.php");
			} else { //INCORRECT PASSWORD
				$error_incorrect_email_or_password = "The email or password was incorrect.";
			 }
		} else { //FILL BOTH EMAIL AND PASSWORD (SCOTT: ADDED VALIDATION)
			//$error_fill_both_fields = "You must fill both fields.";
		}
	}
?>
<?php
$title = 'Sign-in';
include_once("navigation.php");
?>
<main>
	<section>
		<h1>Sign-in</h1>
		<form action="sign-in.php" method="post">
			<div class="fields">
				<div class="field">
					<label for="email">Email</label>
					<input type="email" name="email" placeholder="example@example.com" required/>
				</div>
				<div class="field">
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="Jellybean2018" required/>
				</div>
			</div>
			<!--div id="captcha" class="g-recaptcha" data-sitekey="6LfBKHEUAAAAABTu_VAg-Dxw71_YTPmBsW6-cJRl">
			</div-->
			<button type="submit" name="submit">Sign-in</button>
		</form>
		<?php echo "$error_fill_both_fields $error_incorrect_email_or_password" ?>
	</section>
</main>
<?php include_once("footer.php"); ?>
