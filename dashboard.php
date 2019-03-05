<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$title = 'Dashboard';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
$error = "";
//checking if the user is signed in this is done by checking if the two cookies are there with the users ID and password

if((isset($userPasswordCookie)) AND (isset($userIDCookie))) {

} else { //SIGNED-OUT
	header("location: sign-in.php");
}

//GETTING THE USERS ACCOUNT INFORMATION
$accountQuery = mysqli_query($con, "SELECT * FROM users WHERE id = '$userIDCookie' AND password = '$userPasswordCookie' ");
$accountArray = mysqli_fetch_array($accountQuery);
// creating varibles using that array
$accountPicture = $accountArray['profile_picture'];
$accountID = $accountArray['id'];
$accountUsername = $accountArray['username'];
$accountEmail = $accountArray['email'];
$accountEmailCode = $accountArray['email_code'];
$accountVerified = $accountArray['verified_email'];
$bitcoinWalletAddress = $accountArray['bitcoin_address'];
$ethereumWalletAddress = $accountArray['ethereum_address'];

echo $email_code = $_REQUEST['code']; //CHECK IF USER CLICKED EMAIL LINK

if($email_code == $accountEmailCode) { //CHECK IF CODE MATCHES
	mysqli_query($con, "UPDATE users SET verified_email	='1' WHERE id='$accountID'"); //UPDATE TABLE
	//header("location: dashboard/change-profile-picture.php"); WHY DOES THIS DIRECT YOU TO CHANGE YOUR PROFILE PICTURE, THATS JUST BAD DESIGN MATE
}
?>
<main>
	<section>
		<h1><?php echo "$username's " ?>Dashboard</h1>
		<input onclick="window.location.href='profile.php?profile=<?php echo $accountUsername?>'" type="button" name="" value="View Profile Page"/>
	</section>
	<section class="subsections">
		<div id="account" class="subsection">
			<h1>Account</h1>
			<ul>
				<li><a href="profile-editor.php?profile=<?php echo $accountUsername?>">Change About Me</a></li>
				<li><a href="upload_crop.php">Change Profile Picture</a></li>
				<li><a href="change-profile-banner.php">Change Profile Banner</a></li>
				<li><a href="dashboard/change-email-address.php">Change Email Address</a></li>
				<li><a href="dashboard/change-password.php">Change Password</a></li>
				<!--li><a href="dashboard/change-bitcoin-address.php"><?php echo $bitcoinWalletAddress != "" ? "Change" : "Set"; ?> Bitcoin Address</a></li-->
				<li><a href="dashboard/change-ethereum-address.php"><?php echo $ethereumWalletAddress != "" ? "Change" : "Set"; ?> Ethereum Wallet Address</a></li>
			</ul>
		</div>
		<div id="checklist" class="subsection">
			<h1>Checklist</h1>
			<ul>
				<?php
				if($accountVerified == 0) {
					echo "<li><a href='verify-email.php'>Verify email address</a></li>";
				}

				if($ethereumWalletAddress == "") {
					echo "<li><a href='dashboard/change-ethereum-address.php'>Add Ethereum Wallet Address</a></li>";
				}
				?>
			</ul>
		</div>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
