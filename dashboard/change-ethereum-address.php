<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//checking if the user is signed in this is done by checking if the two cookies are there with the users ID and password
$usersIDCookie = $_COOKIE['usersIDCookie'];
$usersPasswordCookie = $_COOKIE['usersPasswordCookie'];

if((isset($usersPasswordCookie)) AND (isset($usersIDCookie))) { //USER IS SIGNED-IN

} else { //USER IS NOT SIGNED-IN
	header("location: sign-in.php");
}

$title = 'Change Ethereum Address';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
include_once("change-code.php");
require($_SERVER["DOCUMENT_ROOT"]."/Pompay/connect.inc.php");

// UPDATE EMAIL ADDRESS
// GETTING THE USER POST DATA
$newAddress = $_POST['newAddress'];
$confirmNewAddress = $_POST['confirmNewAddress'];
$password = $_POST['password'];
// GEETING THE SIGNED IN USERS ID
$usersIDCookie;
// IF THE USER ALREADY HAS UPDATED THEIR EMAIL
$state = $_REQUEST['s'];

if($state=="updated") {
	$confirmation = "Address has been updated.";
}

if((isset($newAddress))	AND	(isset($confirmNewAddress))	AND	(isset($password))) {
	if($newAddress==$confirmNewAddress) {
		// GETTING THE SIGNED IN USERS PASSWORD
		$passwordCheck = mysqli_query($con, "SELECT password FROM users WHERE id = '$usersIDCookie' ");
		$passwordcheckResults = mysqli_fetch_array($passwordCheck);
		$usersPassword = $passwordcheckResults['password'];

		if(password_verify($password,$usersPassword)) {
			// THE PASSWORD IS A MATCH // UPDATE USERS EMAIL ADDRESS
			mysqli_query($con, "UPDATE users SET ethereum_address = '$newAddress' WHERE id = '$usersIDCookie;' ");
			header("location: change-ethereum-address.php?s=updated");
		} else {
			$error_1 = "Password does not match.";
		}
	} else {
		$error_2 = "Addresses do not match.";
	}
}
?>
<main>
	<section>
		<h1>Change Ethereum Address</h1>
		<form action="dashboard/change-ethereum-address.php" method="post">
			<div class="fields">
				<div class="field">
					<label for="email">New Ethereum Address</label>
					<input name="newAddress" placeholder="1FVtAuaz56xHUXrCNLbtMDxcw6o5GNn4xqX" required/>
				</div>
				<div class="field">
					<label for="email">Confirm Ethereum Address</label>
					<input name="confirmNewAddress" placeholder="1FVtAuaz56xHUXrCNLbtMDxcw6o5GNn4xqX" required/>
				</div>
        <div class="field">
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="Jellybean1066" required/>
				</div>
			</div>
			<button type="submit" name="submit">Change Ethereum Address</button>
		</form>
		<?php echo "$error_1 $error_2 $confirmation" ?>
	</section>
	<section class="info">
		<p>Support: don't have an ethereum wallet? That's okay. <a href="support.php">You can generate an ethereum wallet with us</a>!</p>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
