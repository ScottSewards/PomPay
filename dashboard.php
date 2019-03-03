<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require "connect.inc.php";
//checking if the user is signed in this is done by checking if the two cookies are there with the users ID and password
$usersIDCookie = $_COOKIE['usersIDCookie'];
$usersPasswordCookie = $_COOKIE['usersPasswordCookie'];

if((isset($usersPasswordCookie)) AND (isset($usersIDCookie))) {

} else { //USER IS NOT SIGNED-IN
	header("location: sign-in.php");
}

//GETTING THE USERS ACCOUNT INFORMATION
$accountQuery = mysqli_query($con, "SELECT * FROM users WHERE id = '$usersIDCookie' AND password = '$usersPasswordCookie' ");
$accountArray = mysqli_fetch_array($accountQuery);
// creating varibles using that array
$AccountPicture = $accountArray['profile_picture'];
$AccountID = $accountArray['id'];
$AccountUsername = $accountArray['username'];
$AccountEmail = $accountArray['email'];
$AccountEmailVarified = $accountArray['verified_email'];
$AccountEmailCode = $accountArray['email_code'];
$EthereumWalletAddress = $accountArray['ethereum_address'];
$BitcoinWalletAddress = $accountArray['bitcoin_address'];
// CHECKING IF THE USER HAS VERIFIED THEIR EMAIL ADDRESS
if ($AccountEmailVarified=="0") {
	$accountVerified = "not verified";
	//header("location:email_ver.php"); //COMMENT OUT WHEN OFFLINE
} else {
	$accountVerified = "verified";
}
// CHECKING IF THE USER HAS CLICKED EMAIL LINK
echo $email_code = $_REQUEST['code'];
// CHECK IF THE CODE IS A MATCH
if ($email_code==$AccountEmailCode) {
	 // UPDATE THE USERS TABLE
	mysqli_query($con, "UPDATE users SET verified_email	='1' WHERE id='$AccountID' ");
	header("location: dashboard/change-profile-picture.php");
}


// UPLOADING THE UERS PROFILE PICTURE
// CHECKING IF THE USER HAS SUBMIT AN IMAGE
$SubmitImage = $_POST['SubmitImage'];

if ( isset($SubmitImage) ) {
	$fileName = $AccountID . "_" . basename($_FILES["fileToUpload"]["name"]);
	$target_dir = "images/profile-pictures/";
	$target_file = $target_dir . $fileName;
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// CHECKING TO SEE IF THE FILE IS AN IMAGE
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "The file you uploaded is not an image.";
			$uploadOk = 0;
		}
	}
	// CHECK TO SEE IF THE FILE EXISTS
	if (file_exists($target_file)) {
		$error_4 = "The file you uploaded already exists.";
		$uploadOk = 0;
	}
	// CHECK THE FILE SIZE // MAX LIMIT 500000
	if ($_FILES["fileToUpload"]["size"] > 5000000) {
		$error_5 = "The file you uploaded is too large.";
		$uploadOk = 0;
	}
	// CHECK WHAT FILE FORMAT THE IMAGE IS // ONLY ALLOW CERTAIN FORMATS
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$error_3 = "Only JPG, JPEG, PNG, or GIF file formats can be uploaded.";
		$uploadOk = 0;
	}
	// CHECKING IF THE FILE IS OKAY TO UPLAOD
	if($uploadOk == 0) {
		$error_2 = "Your file could not be uploaded.";
	} else {
		// IF EVERYTHING IS OKAY UPLOAD THE FILE
		if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			// UPDATE PROFILE PICTURE NAME IN DATABASE
			$updateLocation = mysqli_query($con, "UPDATE users SET profile_picture='$fileName' WHERE id='$usersIDCookie' ");
			// BEFORE UPLOADING THE OLD IMAGE TO THE USED IMAHE TABLE CHECK TO SEE IF IT IS ALREADY THERE
			$pictire_history_query = mysqli_query($con, "SELECT id FROM used_profile_pics WHERE owners_id = '$AccountID' AND location = '$AccountPicture' ");
			$Picture_Row_Count = mysqli_num_rows($pictire_history_query);

			if($Picture_Row_Count=="0") {
				// ADD THE OLD OLD IMAGE INTO THE PREVIOUSLY USED IMAGES TABLE
				mysqli_query($con, "INSERT INTO used_profile_pics (owners_id, location) VALUES ('$AccountID', '$AccountPicture') ");
				header("location: dashboard/change-profile-picture.php");
			} else {
				header("location: dashboard/change-profile-picture.php");
			}
		} else {
			$error_1 = "There was an error uploading your file.";
		}
	}
}
?>
<?php
$title = 'Dashboard';
include_once("navigation.php");
?>
<main>
	<section class="info">
		<p>Welcome to your dashboard <?php echo $AccountUsername?>. Here you can modify your account, edit your profile page, and more. <a href="#">Click here to dismiss</a>.</p>
	</section>
	<section>
		<h1>MyProfile</h1>
		<p>Currently, one account can have one profile. We plan to allow one account to have multiple profiles. <a href="profile.php?profile=<?php echo $AccountUsername?>">View my profile</a>.</p>
	</section>
	<section class="subsections">
		<div id="account" class="subsection">
			<h1>MyAccount</h1>
			<ul>
				<li><a href="upload_crop.php">Change Profile Picture</a></li>
				<li><a href="change-profile-banner.php">Change Profile banner</a></li>
				<!--li><a href="dashboard/change-profile-picture.php">Change Profile Picture</a></li-->
				<!--li><a href="dashboard/change-profile-banner.php">Change Profile Banner</a></li-->
				<li><a href="dashboard/change-email-address.php">Change Email Address</a></li>
				<li><a href="dashboard/change-password.php">Change Password</a></li>
				<li><a href="dashboard/change-bitcoin-address.php"><?php echo $BitcoinWalletAddress != "" ? "Change" : "Set"; ?> Bitcoin Address</a></li>
				<li><a href="dashboard/change-ethereum-address.php"><?php echo $EthereumWalletAddress != "" ? "Change" : "Set"; ?> Ethereum Address</a></li>
			</ul>
		</div>
		<div id="checklist" class="subsection">
			<h1>MyChecklist</h1>
			<p>You must complete your checklist before you can create your profile page. You have completed 0 of 3 list items: </p>
			<ul>
				<li><a href="verify-email.php">Verify email address</a></li>
				<li><a href="dashboard/change-ethereum-address.php">Add Bitcoin and/or Ethereum address(es)</a> --- direct to update details</li>
				<li><a href="dashboard/change-profile-page.php?profile=<?php echo $AccountUsername?>">Complete MyProfile</a></li>
			</ul>
		</div>
	</section>
	<!--section id="my-picture" class="hide subsections">
		<div id="profile-picture" class="subsection">
			<h1>My Current Picture</h1>
			<img src='images/profile-pictures/<?php echo $AccountPicture ?>'/>
			<form action="dashboard.php" method="post" enctype="multipart/form-data">
				<input type="file" name="fileToUpload" id="fileToUpload"/>
				<input type="submit" value="Upload Image" name="SubmitImage"/>
			</form>
			<?php echo "$error_1 $error_2 $error_3 $error_4 $error_5"; ?>
		</div>
		<div id="past-pictures" class="subsection">
			<h1>My Past Picture(s)</h1>
			<?php
			$profile_picture_history = mysqli_query($con, "SELECT * FROM used_profile_pics WHERE owners_id = '$AccountID' ");
			while ($pictire_history_array = mysqli_fetch_array($profile_picture_history)) {
				$id = $pictire_history_array['id'];
				$owners_id = $pictire_history_array['owners_id'];
				$location = $pictire_history_array['location'];
				echo "
				<div class='picture'>
				<a href='dashboard.php'>
				<img src='images/profile-pictures/$location' alt='$location'/>
				</a>
				</div>";
			}
			// SELETING AN OLD PROFILE PICTURE
			$state = $_REQUEST['s'];
			$pictureLocation = $_REQUEST['p'];
			// NOW WE HAVE THE ID OF THE PICTURE THE USER WOULD LIEK TO SELECT WE NEED TO QUERY THE DATABASE AND GET THE IMAGE NAME
			// OR WE COULD SEND THE NAME OVER THE URL
			// NEED TO ADD MORE VALIDATION
			if($state == "np") {
				// NEED TO ADD VALIDATION SO USERS CANT CHANGE THE VALUES
				// MAKE SURE THE OWNERS ID IS EQUAL TO THE SIGNED IN COOKIE ID
				// BEFORE UPLOADING THE OLD IMAGE TO THE USED IMAHE TABLE CHECK TO SEE IF IT IS ALREADY THERE
				$pictire_history_query = mysqli_query($con, "SELECT id FROM used_profile_pics WHERE owners_id = '$AccountID' AND location = '$AccountPicture' ");
				$Picture_Row_Count = mysqli_num_rows($pictire_history_query);

				if($Picture_Row_Count=="0") {
					// ADD THE OLD OLD IMAGE INTO THE PREVIOUSLY USED IMAGES TABLE
					mysqli_query($con, "UPDATE users SET profile_picture='$pictureLocation' WHERE id='$usersIDCookie' ");
					mysqli_query($con, "INSERT INTO used_profile_pics (owners_id, location) VALUES ('$AccountID', '$AccountPicture') ");
					header("location: dashboard/change-profile-picture.php");


				} else {
					mysqli_query($con, "UPDATE users SET profile_picture='$pictureLocation' WHERE id='$usersIDCookie' ");
					header("location: dashboard/change-profile-picture.php");
				}
			}
			?>
		</div>
	</section-->
</main>
<?php include_once("footer.php"); ?>
