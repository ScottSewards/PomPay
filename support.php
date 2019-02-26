<?php
	require "connect.inc.php";
	$usersIDCookie = $_COOKIE['usersIDCookie'];
	if(isset($usersIDCookie)) { //SIGNED IN
		$theUsersID = $usersIDCookie;
	} else { //NOT SIGNED IN
		$theUsersID = "NA";
	}
	//HAS USER ALREADY SUBMITTED
	$messageSent = $_REQUEST['m'];

	if(($messageSent == "s")) {
		$displayMessage1 = "We will contact you soon.";
	}
	//GET FORM DATA
	$RAWemailAddress = $_POST['email'];
	$RAWsubject = $_POST['subject'];
	$RAWmessage = $_POST['message'];
	$RAWsubmit = $_POST['submit'];
		// SECURING THAT DATA
	$SECUREemailAddress = htmlspecialchars(addslashes($RAWemailAddress));
	$SECUREsubject = htmlspecialchars(addslashes($RAWsubject));
	$SECUREmessage = htmlspecialchars(addslashes($RAWmessage));
		// CHECKING IF THE USER HAS CLICKED SEND
	if ( isset($RAWsubmit) ) {
			// CHECKING THE USER HAS FILLED OUT ALL BOXES
		if ((!empty($SECUREemailAddress))	AND	(!empty($SECUREsubject))	AND	(!empty($SECUREmessage))) {
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
$title = 'Support';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
?>
<main>
	<article id="faq">
		<h1>Frequently Asked Questions</h1>
		<p><a href="#contact">Contact us via email</a> if you cannot find the answer to your inquery in the FAQ section.</p>
		<h2>What is Pompay?</h2>
		<p>Pompay is a crowsfunding platform that allows you to setup donations, pledges, or subscriptions.</p>
		<h2>How does Pompay work?</h2>
		<p>It is a simple process.</p>
		<ol>
			<li>Send money to user wallet</li>
			<li>Depending on select type such as monthly, funds are donated at specified time each month, weekly, whenever, or per video. its upto you</li>
		</ol>
		<h2>Why use Pompay?</h2>
		<p>Here is a list of points why you should:</p>
		<ul>
			<li>0% fees</li>
			<li>analytical tools</li>
		</ul>
		<h2>What type of content is allowed on Pompay?</h2>
		<p>We allow anything.</p>
		<h2>What cryptocurrencies are supported?</h2>
		<p>We support both Bitcoin and Ethereum. This requires users to have two wallets.</p>
		<p>Personally, we recommend users use MetaMask. <a href="https://metamask.io/">You can download it here.</a></p>
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
			<input type="submit" name="submit" value="Send"/>
		</form>
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
