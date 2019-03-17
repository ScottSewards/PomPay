<?php
$title = 'Support';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
$message = "";
$userID = $userIDCookie ? $usersIDCookie : "NA";
$messageSent = $_REQUEST['m']; //HAS USER ALREADY SUBMITTED

if(($messageSent == "s")) {
	$message = "we will contact you soon";
}
//SECURE SUBMIT DATA
$SECUREemailAddress = htmlspecialchars(addslashes($_POST['email']));
$SECUREsubject = htmlspecialchars(addslashes($_POST['subject']));
$SECUREmessage = htmlspecialchars(addslashes($_POST['message']));

if(isset($_POST['submit'])) { //SUBMIT DATA
	$SubmitQuery = mysqli_query($con, "INSERT INTO support (usersID, email, subject, message, dateTime)
	VALUES ('$userID', '$SECUREemailAddress', '$SECUREsubject', '$SECUREmessage', 'DateTime')");
	header("location: support.php?m=s");
}
?>
<main>
	<article id="faq">
		<h1>Frequently Asked Questions</h1>
		<h2>What is Pompay?</h2>
		<p>Pompay is a crowdsfunding-membership platform. Here you can create a profile or a project page to provide information about yourself, a product or anything you want to  revieve crowdfunding, donations, etc.</p>

		<h2>What cryptocurrencies are supported?</h2>
		<p>Currently, we support only Ethereum. However, we hope to add support for Bitcoin and Litecoin in a future update.</p>

		<h2>How do I use Pompay?</h2>
		<p>Cryptocurrency can be perplexing so we want to make it as simple to use as possible so we recommend you follow this checklist:</p>
		<ol>
			<li>Install MetaMask, <a href="https://metamask.io/">you can download it here.</a></li>
			<li><a href="sign-up.php">Create an account.</a></li>
			<li>You're done.</li>

		</ol>
	</article>
	<?php
	if($message != "") {
		echo "
		<section class='info notice'>
			<p>Notice: $message</p>
		</section>";
	}
	?>
	<section id="contact">
		<h1>Contact Us</h1>
		<form action="support.php" method="post">
			<div class="fields">
				<div class="field">
					<label for="email">Return Address</label>
					<input type="email" name="email" placeholder="example@example.com" required/>
				</div>
				<div class="field">
					<label for="subject">Subject</label>
					<input type="text" name="subject" placeholder="Subject..." required/>
				</div>
				<div class="field">
					<label for="message">Message</label>
					<textarea name="message" rows="8" cols="80" placeholder="Message..." required></textarea>
				</div>
			</div>
			<input type="submit" name="submit" value="Send"/>
		</form>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
