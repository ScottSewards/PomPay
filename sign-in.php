<?php
$title = 'Sign-in';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
$error = "";

if((isset($userPasswordCookie)) AND (isset($userIDCookie))) {
	header("location: dashboard.php"); //REDIRECT
}
//REMOVE SPECIAL CHARACTERS AND ADD SLASHES
$loginEmail = htmlspecialchars(addslashes($_POST['email']));
$loginPassword = htmlspecialchars(addslashes($_POST['password']));
$loginSubmit = $_POST['submit'];

if(isset($loginSubmit)) {
	$loginQuery = mysqli_query($con, "SELECT * FROM users WHERE email = '$loginEmail'"); //GET PASSWORD
	$queryResults  = mysqli_fetch_array($loginQuery); //PUT QUERY INTO ARRAY
	$storedID = $queryResults['id'];
	$storedPassword = $queryResults['password'];
	if(password_verify($loginPassword, $storedPassword)) {	//CHECK PASSWORD WITH HASHED PASSWORD
		setcookie("usersIDCookie", $storedID, time()+86400); //CREATE COOKIES
		setcookie("usersPasswordCookie", $storedPassword, time()+86400);
		header("location: dashboard.php"); //REDIRECT TO DASHBOARD
	} else { //INCORRECT PASSWORD
		$error = "email or password was incorrect";
	}
}
?>
<main>
	<?php
	if($error != "") {
		echo "<section class='info'>
		<p>Error: $error</p>
		</section>";
	}
	?>
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
			<button type="submit" name="submit">Sign-in</button>
		</form>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
