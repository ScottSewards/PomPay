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

$title = 'Change Email Address';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pomnia/navigation.php");
include_once("change-code.php");
require($_SERVER["DOCUMENT_ROOT"]."/Pomnia/connect.inc.php");

// UPDATE EMAIL ADDRESS
// GETTING THE USER POST DATA
$newEmail = $_POST['email'];
$confirmEmail = $_POST['confirmNewEmail'];
$password = $_POST['password'];
// GEETING THE SIGNED IN USERS ID
$usersIDCookie;
// IF THE USER ALREADY HAS UPDATED THEIR EMAIL
$state = $_REQUEST['s'];

if($state=="updated") {
	$confirmation = "Email has been updated.";
}

if((isset($newEmail))	AND	(isset($confirmEmail))	AND	(isset($password))) {
	if($newEmail==$confirmEmail) {
		// GETTING THE SIGNED IN USERS PASSWORD
		$passwordCheck = mysqli_query($con, "SELECT password FROM users WHERE id = '$usersIDCookie' ");
		$passwordcheckResults = mysqli_fetch_array($passwordCheck);
		$usersPassword = $passwordcheckResults['password'];

		if(password_verify($password,$usersPassword)) {
			// THE PASSWORD IS A MATCH // UPDATE USERS EMAIL ADDRESS
			mysqli_query($con, "UPDATE users SET email = '$newEmail' WHERE id = '$usersIDCookie;' ");
			header("location: change-email-address.php?s=updated");
		} else {
			$error_1 = "Password does not match.";
		}
	} else {
		$error_2 = "Emails do not match.";
	}
}
?>
<main>
	<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pomnia/templates/breadcrumbs.php"); ?>
	<section>
		<h1>Change Email Address</h1>
		<form action="dashboard/change-email-address.php" method="post">
			<div class="fields">
				<div class="field">
					<label for="email">New Email</label>
					<input type="email" name="email" placeholder="example@example.com" required/>
				</div>
				<div class="field">
					<label for="email">Confirm Email</label>
					<input type="email" name="confirmNewEmail" placeholder="example@example.com" required/>
				</div>
        <div class="field">
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="Jellybean1066" required/>
				</div>
			</div>
			<button type="submit" name="submit">Change Email Address</button>
		</form>
		<?php echo "<br/> $error_1 $error_2 $confirmation" ?>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pomnia/footer.php"); ?>
