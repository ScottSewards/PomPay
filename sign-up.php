<?php
$title = 'Sign-up';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
$error = "";

if((isset($userPasswordCookie)) AND (isset($userIDCookie))) { //SIGNED IN
	header("location: dashboard.php?id=$userIDCookie"); //SEND USER TO DASHBOARD
}
//SECURE SUBMITTED DATA
$username = htmlspecialchars(addslashes($_POST['username']));
$email = htmlspecialchars(addslashes($_POST['email']));
$password = htmlspecialchars(addslashes($_POST['password']));
$confirmPassword = htmlspecialchars(addslashes($_POST['confirmPassword']));
$bitconWallet = htmlspecialchars(addslashes($_POST['bitcoinWallet']));
$ethereumWallet = htmlspecialchars(addslashes($_POST['ethereumWallet']));

if(isset($_POST['submit'])) { //USER SUBMITS FORM
	//CHECK EMAIL USED
	$emailQuery = mysqli_query($con, "SELECT id FROM users WHERE email = '$email' ");
	$rowcount = mysqli_num_rows($emailQuery);

	if($rowcount == '1') {
		$error = "email in use";
	}
	//CHECK USERNAME USED
	$emailUsernameQuery = mysqli_query($con, "SELECT id FROM users WHERE username = '$username' ");
	$usernameRowCount = mysqli_num_rows($emailUsernameQuery);

	if($usernameRowCount == '1') {
		$error = "username in use";
	}
	//CHECK PASSWORDS MATCH
	if($password == $confirmPassword) {
		$checkPassword = "1";
	} else {
		$error = "passwords do not match";
	}

	if(($rowcount == "0") AND ($checkPassword == "1") AND ($usernameRowCount == "0")) {
		//GENERATE A RANDOM CODE AND SEND THE USER AN EMAIL TO VALIDATE THEIR EMAIL
		$randomString = rand(100000000, 999999999999999999);
		$to = "$email";
		$subject = "Pompay Email Verification";
		$message = "Welcome to Pompay! Below you will find the email confirmation code.<br/><br/>$randomString<hr/>Copyright (c) 2019 Copyright Holder All Rights Reserved.";
		//SET CONTENT-TYPE
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <admin@myapp.sites.k-hosting.co.uk>' . "\r\n";
		//$headers .= 'Cc: myboss@example.com' . "\r\n";
		mail($to, $subject, $message, $headers);
		//CREATE STRONG PASSWORD
		$strongPassword = password_hash($password, PASSWORD_DEFAULT);
		//SUBMIT USER DATA AND CREATE ACCOUNT
		$CreateAccount = mysqli_query($con, "INSERT INTO users (email, email_code,username, password, profile_picture, profile_banner, ethereum_address, bitcoin_address)
		VALUES ('$email', '$randomString','$username', '$strongPassword', 'images/profile-pictures/default_profile.jpg', 'images/profile-banners/default_banner.jpg', '$ethereumWallet', '$bitconWallet') ");
		//GET USER ID AND LOGIN INFORMATION
		$loggingUserIn = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND password = '$strongPassword' ");
		$UsersData = mysqli_fetch_array($loggingUserIn);
		$usersID = $UsersData['id'];
		$usersPassword = $UsersData['password'];
		//CREATE USER PROFILE PAGE
		$CreatepProfile = mysqli_query($con, "INSERT INTO profile (owners_username, owners_id, description, state)
		VALUES ('$username', '$usersID', '', '0') ");
		//CREATE COOKIES
		setcookie("usersIDCookie", "$usersID", time()+86400);
		setcookie("usersPasswordCookie", "$strongPassword", time()+86400);
		header("location: dashboard.php"); //REDIRECT
	}
}
?>
<main>
	<?php
	if($error != "") {
		echo "<section class='info error'>
		<p>Error: $error</p>
		</section>";
	}
	?>
	<section>
		<h1>Sign-up</h1>
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
					<!--div class="field">
						<label for="bitcoinWallet">Bitcoin Wallet</label>
						<input type="text" name="bitcoinWallet" placeholder="0xa14ae9bc94005a93934a027024eb7421215853af (optional)"/>
						<button type="button" name="generateBitcoinWallet" id="generateBitcoinWallet" onclick="GenerateBitcoinWallet()">Generate</button>
					</div-->
					<div class="field">
						<label for="ethereumWallet">Ethereum Wallet</label>
						<input type="text" name="ethereumWallet" placeholder="0xa14ae9bc94005a93934a027024eb7421215853af (optional)"/>
						<button type="button" name="generateEthereumWallet" id="generateEthereumWallet" onclick="GenerateEthereumWallet()">Generate</button>
					</div>
				</div>
				<button type="submit" name="submit">Sign-up</button>
			</form>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
