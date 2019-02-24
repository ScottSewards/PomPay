<?php
	// CONNECTING TO THE DATABASE
	require "connect.inc.php";
	// GETTING THE USERS COOKIE ID
	$usersIDCookie = $_COOKIE['usersIDCookie'];
	if (	isset($usersIDCookie)	) {
		// THE USER IS SIGNED IN
		$theUsersID = $usersIDCookie;
	} else {
		// THE USER IS NOT SIGNED IN
		$theUsersID = "NA";
	}
	// IF THE USER HAS ALREADY SUBMIT A MESSAGE
	$messageSent = $_REQUEST['m'];

	if(($messageSent=="s")) { //CREATE THANK YOU MESSAGE
		$displayMessage1 = "Thank you. We will contact you soon.";
	}
	//GETTING THE FORM DATA SUBMIT BY THE USER
	$RAWemailAddress = $_POST['email'];
	$RAWsubject = $_POST['subject'];
	$RAWmessage = $_POST['message'];
	$RAWsubmit = $_POST['submit'];
	//SECURING THAT DATA
	$SECUREemailAddress = htmlspecialchars(addslashes($RAWemailAddress));
	$SECUREsubject = htmlspecialchars(addslashes($RAWsubject));
	$SECUREmessage = htmlspecialchars(addslashes($RAWmessage));
		// CHECKING IF THE USER HAS CLICKED SEND
		if(isset($RAWsubmit)) { //CHECKING THE USER HAS FILLED OUT ALL BOXES
			if((!empty($SECUREemailAddress))	AND	(!empty($SECUREsubject))	AND	(!empty($SECUREmessage))) {
				// USER HAS FILLED OUT ALL BOXES // SUBMIT SUPPORT INFORMATION TO THE DATABASE
			$SubmitQuery = mysqli_query($con, "INSERT INTO support (usersID, email, subject, message, dateTime)
			VALUES ('$theUsersID', '$SECUREemailAddress', '$RAWsubject', '$RAWmessage', 'DateTime') ");
				header("location: support.php?m=s");
			}
			else {
			// USER HAS NOT FILLED OUT ALL BOXES
			$error1 = "Please fill out all fields.";
		}
	}
?>
<?php
$title = 'Support';
include_once("navigation.php");
?>
<main>
	<article id="faq">
		<h1>Frequently Asked Questions</h1>



		<!--div class="">
			<script src="jq/jq.js">
				print("Test");
			</script>
			<h2>Table of Contents</h2>
			<ul>
				<li>Item 1</li>
				<li>Item 1</li>
			</ul>
		</div-->

		<h2>What is Pompay?</h2>
		<p>Pompay is a crowdsfunding-membership platform focusing on cryptocurrency. This means you can setup a profile page and/or a project page to provide information about yourself, a product or whatever you wish to receive cryptocurrency.</p>

		<h2>What is cryptocurrency?</h2>
		<p>Are you sure your in the right place mate?</p>

		<h2>What is a wallet?</h2>
		<p>We use MetaMask and we recommend you do too. You can <a href="https://metamask.io/">download MetaMask on the official website.</a></p>

		<h2>How do I use Pompay?</h2>
		<p>We aim to make it as simple to use as possible. Not everyone understand cryptocurrency.</p>
		<ol>
			<li>Send money to user wallet</li>
			<li>Depending on select type such as monthly, funds are donated at specified time each month, weekly, whenever, or per video. its upto you</li>
		</ol>

		<h2>Why use Pompay?</h2>
		<p>Here is a list of points why you should:</p>
		<ul>
			<li>5% processing fees</li>
			<li>in-depth analytical tools</li>
		</ul>

		<h2>What type of content is allowed on Pompay?</h2>
		<p>We allow anything.</p>

		<h2>What cryptocurrencies are supported?</h2>
		<p>We support Ethereum. However, we will support for Bitcoin soon.</p>

		<p><a href="#contact">Contact us via email</a> if you cannot find the answer to your inquery in the FAQ section.</p>
	</article>
	<section id="contact">
		<h1>Contact Us</h1>
		<?php echo "$error1 $displayMessage1" ?>
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
			<input type="submit" name="submit" value="Send Message"/>
		</form>
	</section>
</main>
<?php include_once("footer.php"); ?>
