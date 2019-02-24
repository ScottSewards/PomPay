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

$title = 'Change Password';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pomnia/navigation.php");
include_once("change-code.php");
require($_SERVER["DOCUMENT_ROOT"]."/Pomnia/connect.inc.php");

// UPDATE EMAIL ADDRESS
// GETTING THE USER POST DATA
$newPassword = $_POST['newPassword'];
$confirmNewPassword = $_POST['confirmPassword'];
$password = $_POST['password'];
// GEETING THE SIGNED IN USERS ID
$usersIDCookie;
// IF THE USER ALREADY HAS UPDATED THEIR EMAIL
$state = $_REQUEST['s'];

if ($state=="updated") {
	//$confirmation = "Password has been updated.";
	//header("location: change-password.php");
	//echo "<meta http-equiv='refresh' content='300'>";
}

if (	(isset($newPassword))	AND	(isset($confirmNewPassword))	AND	(isset($password))	) {
	if ($newPassword==$confirmNewPassword) {
		// GETTING THE SIGNED IN USERS PASSWORD
		$passwordCheck = mysqli_query($con, "SELECT password FROM users WHERE id = '$usersIDCookie' ");
		$passwordcheckResults = mysqli_fetch_array($passwordCheck);
		$usersPassword = $passwordcheckResults['password'];

		if(password_verify($password,$usersPassword)) {
			$strongPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			// THE PASSWORD IS A MATCH // UPDATE USERS EMAIL ADDRESS
			mysqli_query($con, "UPDATE users SET password = '$strongPassword' WHERE id = '$usersIDCookie;' ");
			setcookie("usersIDCookie", "", time()-86400);
			setcookie("usersPasswordCookie", "", time()-86400);
			header("location: /Pomnia/index.php?s=lo");
		} else {
			$error_1 = "Current password does not match.";
		}
	} else {
		$error_2 = "New passwords do not match.";
	}
}
?>
<main>
	<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pomnia/templates/breadcrumbs.php"); ?>
	<section>
		<h1>Change Password</h1>
		<form action="dashboard/change-password.php" method="post">
			<div class="fields">
				<div class="field">
					<label for="newPassword">New Password</label>
					<input type="password" name="newPassword" placeholder="Pineapple4114" required/>
				</div>
        <div class="field">
					<label for="confirmPassword">Confirm Password</label>
					<input type="password" name="confirmPassword" placeholder="Pineapple4114" required/>
				</div>
        <div class="field">
					<label for="old-password">Old Password</label>
					<input type="password" name="password" placeholder="Jellybean1066" required/>
				</div>
			</div>
			<button type="submit" name="submit">Change Password</button>
		</form>
		<?php echo "$error_1 $error_2 $confirmation" ?>
	</section>
	<section class="info">
		<p>Caution: you will be signed out so you will need to sign back in.</p>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pomnia/footer.php"); ?>
