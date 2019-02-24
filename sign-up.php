<?php
	require "connect.inc.php"; //CONNECT TO DATABASE
	$usersIDCookie = $_COOKIE['usersIDCookie'];
	$usersPasswordCookie = $_COOKIE['usersPasswordCookie'];

	if((isset($usersPasswordCookie)) AND (isset($usersIDCookie))) {
		header("location: dashboard.php?id=$usersIDCookie"); //SEND USER TO DASHBOARD
	} else { //SIGNED OUT

	}
	// getting hold of the raw user form data
	$RAWusername = $_POST['username'];
	$RAWemail = $_POST['email'];
	$RAWpassword = $_POST['password'];
	$RAWconfirmPassword = $_POST['confirmPassword'];
	$RAWEthereumWallet = $_POST['ethereumWallet'];
	$RAWBitcoinWallet = $_POST['bitcoinWallet'];
	$RAWsubmit = $_POST['submit'];
	// making sure the submit data is safe
	$username = htmlspecialchars(addslashes($RAWusername));
	$email = htmlspecialchars(addslashes($RAWemail));
	$ethereumWallet = htmlspecialchars(addslashes($RAWEthereumWallet));
	$bitconWallet = htmlspecialchars(addslashes($RAWBitcoinWallet));
	$password = htmlspecialchars(addslashes($RAWpassword));
	$confirmPassword = htmlspecialchars(addslashes($RAWconfirmPassword));
	// checking if the user has clicked the submit button
	if(isset($RAWsubmit)) {
		// user has clicked submit
		// checking to see if all forms are filled out
		if((!empty($username)) AND !empty($email) AND !empty($password) AND !empty($confirmPassword)) {
			// All feilds are fields
			// check that the email isnt already in use
			$emailQuery = mysqli_query($con, "SELECT id FROM users WHERE email = '$email' ");
			$rowcount = mysqli_num_rows($emailQuery);

			if($rowcount == '1') {
				$error_email_already_in_use = "Email already in use.";
			}
			// check that the username isnt already in use
			$emailUsernameQuery = mysqli_query($con, "SELECT id FROM users WHERE username = '$username' ");
			$UsernameRowCount = mysqli_num_rows($emailUsernameQuery);

			if($UsernameRowCount == '1') {
				$error_username_already_in_use = "Username already in use.";
			}
			// checking if the passwords match
			if($password == $confirmPassword) {
				// password match create variable
				$checkPassword = "1";
			} else {
				$error_password_dont_match = "Passwords do not match.";
			}

			if(($rowcount=="0") AND ($checkPassword=="1") AND ($UsernameRowCount=="0")) {
				// CREATING A RANDOM CODE AND SENDING THE USER AN EMAIL TO VALIDATE THEIR EMAIL
				$randomString = rand(100000000, 999999999999999999);
				$to = "$email";
				$subject = "Pompay Email Verification";
				$message = "Welcome to Pompay! Below you will find the email confirmation code.<br/><br/>$randomString<hr/>Copyright (c) 2019 Copyright Holder All Rights Reserved.";
				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// More headers
				$headers .= 'From: <admin@myapp.sites.k-hosting.co.uk>' . "\r\n";
				//$headers .= 'Cc: myboss@example.com' . "\r\n";
				mail($to,$subject,$message,$headers);
				// CREATE USER ACCOUNT
				// CREATE STRONG PASSWORD
				$strongPassword = password_hash($password, PASSWORD_DEFAULT);
				// SUBMIT USER DATA AND CREATE ACCOUNT
				$CreateAccount = mysqli_query($con, "INSERT INTO users (email, email_code,username, password, profile_picture, ethereum_address, bitcoin_address)
				VALUES ('$email', '$randomString','$username', '$strongPassword', 'images/profile-pictures/avatar.jpg', '$ethereumWallet', '$bitconWallet') ");
				// getting that users ID and login information
				$loggingUserIn = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND password = '$strongPassword' ");
				$UsersData = mysqli_fetch_array($loggingUserIn);
				$usersID = $UsersData['id'];
				$usersPassword = $UsersData['password'];
				// CREATE USER PROFILE PAGE
				$CreatepProfile = mysqli_query($con, "INSERT INTO profile (owners_username, owners_id, description, state)
				VALUES ('$username', '$usersID', 'Please write something about your page.', '0') ");
				// create cookies with users ID and password
				setcookie("usersIDCookie", "$usersID", time()+86400);
				setcookie("usersPasswordCookie", "$strongPassword", time()+86400);
				header("location: dashboard.php");
			}
		} else { //OLD VALIDATION
			// please fill in all fields
			//$error_fill_in_all_fields = "Please fill in all fields.";
		}
	}
?>
<?php
$title = 'Sign-up';
include_once("navigation.php");
?>
<main>
	<section>
		<h1>Sign-up</h1>
			<?php echo "$tempLogin $error_fill_in_all_fields $error_password_dont_match $error_email_already_in_use $error_username_already_in_use" ?>
			<form action="sign-up.php" method="post">
				<div class="fields">
					<div class="field">
						<label for="username">Username</label>
						<input type="text" name="username" value="<?php echo $RAWusername ?>" placeholder="User4114" required/>
					</div>
					<div class="field">
						<label for="email">Email</label>
						<input type="email" name="email" value="<?php echo $RAWemail ?>" placeholder="example@example.com" required/>
					</div>
					<div class="field">
						<label for="password">Password</label>
						<input type="password" name="password" placeholder="Jellybean6543" required/>
					</div>
					<div class="field">
						<label for="confirmPassword">Confirm Password</label>
						<input type="password" name="confirmPassword" placeholder="Jellybean6543" required/>
					</div>
					<div class="field">
						<label for="bitcoinWallet">Bitcoin Wallet</label>
						<input type="text" name="bitcoinWallet" placeholder="0xa14ae9bc94005a93934a027024eb7421215853af (optional)"/>
						<button type="button" name="generateBitcoinWallet" id="generateBitcoinWallet" onclick="GenerateBitcoinWallet()">Generate</button>
					</div>
					<div class="field">
						<label for="ethereumWallet">Ethereum Wallet</label>
						<input type="text" name="ethereumWallet" placeholder="0xa14ae9bc94005a93934a027024eb7421215853af (optional)"/>
						<button type="button" name="generateEthereumWallet" id="generateEthereumWallet" onclick="GenerateEthereumWallet()">Generate</button>
					</div>
				</div>
				<!--div class="g-recaptcha" data-sitekey="6LfBKHEUAAAAABTu_VAg-Dxw71_YTPmBsW6-cJRl"></div-->
				<button type="submit" name="submit">Sign-up</button>
			</form>
	</section>
</main>
<?php include_once("footer.php"); ?>
