<?php
$title = 'Change Ethereum Address';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
$message = "";
header("Cache-Control: no-store, no-cache, must-revalidate, max-age = 0");
header("Cache-Control: post-check = 0, pre-check = 0", false);
header("Pragma: no-cache");

if((isset($userPasswordCookie)) AND (isset($userIDCookie))) { //SIGNED-IN

} else { //SIGNED-OUT
	header("location: sign-in.php");
}
//GET POST DATA
$oldAddress;
$newAddress = $_POST['newAddress'];
$confirmNewAddress = $_POST['confirmNewAddress'];
$password = $_POST['password'];

if($_REQUEST['s'] == "updated") {
	$message = "Your Ethereum wallet address has been updated!";
}

if((isset($newAddress))	AND	(isset($confirmNewAddress))	AND	(isset($password))) {
	if($newAddress == $confirmNewAddress) { //CHECK PASSWORDS MATCH
		$passwordCheck = mysqli_query($con, "SELECT password FROM users WHERE id = '$userIDCookie'"); //GET PASSWORD
		$passwordCheckResults = mysqli_fetch_array($passwordCheck);
		$usersPassword = $passwordCheckResults['password'];

		if(password_verify($password, $usersPassword)) { //PASSWORDS MATCH
			mysqli_query($con, "UPDATE users SET ethereum_address = '$newAddress' WHERE id = '$userIDCookie;'");
			header("location: change-ethereum-address.php?s=updated");
		} else $message = "Your password is incorrect.";
	} else $message = "The Ethereum wallet addresses do not match.";
}
?>
<main>
	<section>
		<h1>Change Ethereum Address</h1>
		<form action="dashboard/change-ethereum-address.php" method="post">
			<div class="fields">
				<div class="field">
					<label for="email">New Ethereum Address</label>
					<input name="newAddress" placeholder="0xD971cacA6f32D89582D213d85aF1968e18c0DBD8" value='<?php //$oldAddress !== "" ? echo $oldAddress : "" ?>' required/>
				</div>
				<div class="field">
					<label for="email">Confirm Ethereum Address</label>
					<input name="confirmNewAddress" placeholder="0xD971cacA6f32D89582D213d85aF1968e18c0DBD8" required/>
				</div>
        <div class="field">
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="Jellybean1066" required/>
				</div>
			</div>
			<button type="submit" name="submit">Change Ethereum Address</button>
		</form>
	</section>
	<section class="info">
		<?php
		if($message != "") {
			echo "<p>$message</p>";
		} else {
			echo "<p>Tip: don't have an ethereum wallet? That's okay. <a href='support.php'>You can generate an ethereum wallet with us</a>!</p>";
		}
		?>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
