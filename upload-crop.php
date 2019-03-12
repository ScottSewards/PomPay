<?php
error_reporting (E_ALL ^ E_NOTICE);
session_start(); //Do not remove this
//only assign a new timestamp if the session variable is empty
if(!isset($_SESSION['random_key']) || strlen($_SESSION['random_key']) == 0) {
  $_SESSION['random_key'] = strtotime(date('Y-m-d H:i:s')); //assign the timestamp to the session variable
	$_SESSION['user_file_ext']= "";
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$title = 'Change Profile Picture';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
$error = '';
$uploadDirectory = "images/profile-pictures"; 				// The directory for the images to be saved in
$uploadPath = $uploadDirectory."/";				// The path to where the image will be saved
$largeImagePrefix = "resize_"; 			// The prefix name to large image
$thumbImagePrefix = "thumbnail_";			// The prefix name to the thumb image
$largeImageName = $largeImagePrefix.$_SESSION['random_key'];     // New name of the large image (append the timestamp to the filename)
$thumbImageName = $thumbImagePrefix.$_SESSION['random_key'];     // New name of the thumbnail image (append the timestamp to the filename)
$max_file = "5"; 							// Maximum file size in MB
$maxWidth = "1000";						// Max width allowed for the large image
$thumbWidth = "250";						// Width of thumbnail image
$thumbHeight = "250";						// Height of thumbnail image
// Only one of these image types should be allowed for upload
$allowed_image_types = array('image/pjpeg' => "jpg", 'image/jpeg' => "jpg", 'image/jpg' => "jpg", 'image/png' => "png", 'image/x-png' => "png", 'image/gif' => "gif");
$allowed_image_ext = array_unique($allowed_image_types); // do not change this
$image_ext = "";	// initialise variable, do not change this.

foreach($allowed_image_ext as $mime_type => $ext) $image_ext.= strtoupper($ext)." ";
//IMAGE FUNCTIONS
function resizeImage($image, $width, $height, $scale) {
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);

	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image);
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image);
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image);
			break;
  	}

	imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $width, $height);

  switch($imageType) {
		case "image/gif":
	  	imagegif($newImage, $image);
			break;
    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  	imagejpeg($newImage, $image,90);
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage, $image);
			break;
  }

	chmod($image, 0777);
	return $image;
}

function resizeThumbnailImage($thumbImageName, $image, $width, $height, $startWidth, $startHeight, $scale) {
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);

  switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image);
			break;
	  case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image);
			break;
	  case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image);
			break;
  }

  imagecopyresampled($newImage, $source, 0, 0, $startWidth, $startHeight, $newImageWidth, $newImageHeight, $width, $height);

  switch($imageType) {
		case "image/gif":
	  		imagegif($newImage, $thumbImageName);
			break;
    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage, $thumbImageName,90);
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage, $thumbImageName);
			break;
  }

  chmod($thumbImageName, 0777);
	return $thumbImageName;
}

function getHeight($image) {
	$size = getimagesize($image);
	$height = $size[1];
	return $height;
}

function getWidth($image) {
	$size = getimagesize($image);
	$width = $size[0];
	return $width;
}

// IMAGE LOCATIONS
$largeImageLocation = $uploadPath.$largeImageName.$_SESSION['user_file_ext'];
$thumbImageLocation = $uploadPath.$thumbImageName.$_SESSION['user_file_ext'];


// CHECK TO SEE IF ANY IMAGES WITH THE SAME NAME ALREADY EXIST
if(file_exists($largeImageLocation)) {
	if(file_exists($thumbImageLocation)) {
		$thumbPhotoExists = "<img src=\"".$uploadPath.$thumbImageName.$_SESSION['user_file_ext']."\" alt=\"Thumbnail Image\"/>";
	} else {
		$thumbPhotoExists = "";
	}

  $largePhotoExists = "<img src=\"".$uploadPath.$largeImageName.$_SESSION['user_file_ext']."\" alt=\"Large Image\"/>";
} else {
  $largePhotoExists = "";
	$thumbPhotoExists = "";
}

if(isset($_POST["upload"])) {
	//Get the file information
	$userFileName = $_FILES['image']['name'];
	$userFileTemp = $_FILES['image']['tmp_name'];
	$userFileSize = $_FILES['image']['size'];
	$userFileType = $_FILES['image']['type'];
	$filename = basename($_FILES['image']['name']);
	$fileExtension = strtolower(substr($filename, strrpos($filename, '.') + 1));
	//ONLY ALLOW IF JPG, PNG OR GIF AND HAS TO BE BELOW THE ALLOWED LIMIT
	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
		foreach ($allowed_image_types as $mime_type => $ext) {
			//loop through the specified image types and if they match the extension then break out
			//everything is ok so go and check file size
			if($fileExtension==$ext && $userFileType==$mime_type){
				$error = "";
				break;
			} else {
				$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
			}
		}
		//check if the file size is above the allowed limit
		if ($userFileSize > ($max_file*1048576)) {
			$error.= "Images must be under ".$max_file."MB in size";
		}
	} else {
		$error= "Select an image for upload";
	}

	// ALL IS OKAY SO UPLOAD THE IMAGE
	if(strlen($error) == 0) {
		if(isset($_FILES['image']['name'])) {
			//this file could now has an unknown file extension (we hope it's one of the ones set above!)
			$largeImageLocation = $largeImageLocation.".".$fileExtension;
			$thumbImageLocation = $thumbImageLocation.".".$fileExtension;
			//put the file ext in the session so we know what file to look for once its uploaded
			$_SESSION['user_file_ext'] = ".".$fileExtension;
			move_uploaded_file($userFileTemp, $largeImageLocation);
			chmod($largeImageLocation, 0777);
			$width = getWidth($largeImageLocation);
			$height = getHeight($largeImageLocation);
			//Scale the image if it is greater than the width set above
			if($width > $maxWidth) {
				$scale = $maxWidth / $width;
				$uploaded = resizeImage($largeImageLocation, $width, $height, $scale);
			} else {
				$scale = 1;
				$uploaded = resizeImage($largeImageLocation, $width, $height, $scale);
			}

			if(file_exists($thumbImageLocation)) unlink($thumbImageLocation); //DELETE THUMBNAIL
		}

		$currentPictureQuery = mysqli_query($con, "SELECT * FROM users WHERE id = '$userIDCookie'");
		$currentPictureArray = mysqli_fetch_array($currentPictureQuery);
		$currentImageLoc = $currentPictureArray['profile_picture'];
		//REFRESH
		mysqli_query($con, "UPDATE users SET profile_picture='$thumbImageLocation' WHERE id='$userIDCookie'");

		// CHECK TO SEE IF THE CURRENT IMAGE IS ALREADY IN THE USED PROFILE PICTURES TABLE
		$countQuery = mysqli_query($con, "SELECT * FROM used_profile_pics WHERE location = '$currentImageLoc' AND owners_id = '$userIDCookie' ");
		$countQueryArray = mysqli_fetch_array($countQuery);
		$currentImageLoc2 = $currentPictureArray2['profile_picture'];
		$numRows = mysqli_num_rows($countQuery);

		if($numRows == '0') mysqli_query($con, "INSERT INTO used_profile_pics (owners_id, location) values ('$userIDCookie', '$currentImageLoc')"); //ADD PICTURE TO OLD PICTURES

		header("location:upload-crop.php?c=confirm");
		//exit();
	}
}

if(isset($_POST["upload_thumbnail"]) && strlen($largePhotoExists) > 0) {
	//Get the new coordinates to crop the image.
	$xa = $_POST["x1"];
	$ya = $_POST["y1"];
	$xb = $_POST["x2"];
	$yb = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumbWidth / $w;
	$cropped = resizeThumbnailImage($thumbImageLocation, $largeImageLocation, $w, $h, $xa, $ya, $scale);
	//Reload the page again to view the thumbnail
	session_destroy();
	header("location: upload-crop.php?c=confirm");
	exit();
}

if($_GET['a'] == "delete" && strlen($_GET['t']) > 0) {
//get the file locations
	$largeImageLocation = $uploadPath.$largeImagePrefix.$_GET['t'];
	$thumbImageLocation = $uploadPath.$thumbImagePrefix.$_GET['t'];

	if(file_exists($largeImageLocation)) unlink($largeImageLocation);
	if(file_exists($thumbImageLocation)) unlink($thumbImageLocation);

	header("location:".$_SERVER["PHP_SELF"]);
	exit();
}
?>
<main>
  <?php
  $error2 = $_REQUEST['error2']; //SHOW ERROR IF USER TRYS TO DELETE ACTIVE PROFILE PICTURE

  if($error2 == '1'	) {
  	echo "<section class='info error'>
  		<p>Error: the image you want to delete is your current profile pictire.</p>
  	</section>";
  }

  if($_REQUEST['c'] == 'confirm') {
  	echo "<section class='info'>
  		<p>Notice: your profile picture has been updated.</p>
  	</section>";
  }
  ?>
  <section>
    <h1>Post New Profile Picture</h1>
    <?php
    //Only display the javacript if an image has been uploaded
    if(strlen($largePhotoExists) > 0) {
    	$currentLargeImageWidth = getWidth($largeImageLocation);
    	$currentLargeImageHeight = getHeight($largeImageLocation);?>

      <script type="text/javascript">
      function preview(img, selection) {
      	var scaleX = <?php echo $thumbWidth;?> / selection.width;
      	var scaleY = <?php echo $thumbHeight;?> / selection.height;

      	$('#thumbnail + div > img').css({
      		width: Math.round(scaleX * <?php echo $currentLargeImageWidth;?>) + 'px',
      		height: Math.round(scaleY * <?php echo $currentLargeImageHeight;?>) + 'px',
      		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
      		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
      	});
      	$('#x1').val(selection.x1);
      	$('#y1').val(selection.y1);
      	$('#x2').val(selection.x2);
      	$('#y2').val(selection.y2);
      	$('#w').val(selection.width);
      	$('#h').val(selection.height);
      }

      $(document).ready(function () {
      	$('#save_thumb').click(function() {
      		var x1 = $('#x1').val();
      		var y1 = $('#y1').val();
      		var x2 = $('#x2').val();
      		var y2 = $('#y2').val();
      		var w = $('#w').val();
      		var h = $('#h').val();
      		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
      			alert("You must make a selection first");
      			return false;
      		}else{
      			return true;
      		}
      	});
      });

      $(window).load(function () {
      	$('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumbHeight / $thumbWidth;?>', onSelectChange: preview });
      });
      </script>
    <?php } ?>
    <?php
    //Display error message if there are any
    if(strlen($error) > 0){
    	echo "<ul><li><strong>Error!</strong></li><li>".$error."</li></ul>";
    }
    if(strlen($largePhotoExists) > 0 && strlen($thumbPhotoExists) > 0){
    	echo $largePhotoExists."&nbsp;".$thumbPhotoExists;
    	//echo "<p><a href=\"".$_SERVER["PHP_SELF"]."?a=delete&t=".$_SESSION['random_key'].$_SESSION['user_file_ext']."\">Delete images</a></p>";
    	//echo "<p><a href=\"".$_SERVER["PHP_SELF"]."\">Upload another</a></p>";
    	//Clear the time stamp session and user file extension
    	$_SESSION['random_key']= "";
    	$_SESSION['user_file_ext']= "";
    } else {
    	if(strlen($largePhotoExists) > 0) {?>
    		<h2>Crop and Save</h2>
    		<div align="center">
    			<img src="<?php echo $uploadPath.$largeImageName.$_SESSION['user_file_ext'];?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
    			<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumbWidth;?>px; height:<?php echo $thumbHeight;?>px;">
    				<img src="<?php echo $uploadPath.$largeImageName.$_SESSION['user_file_ext'];?>" style="position: relative;" alt="Thumbnail Preview" />
    			</div>
    			<form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    				<input type="hidden" name="x1" value="" id="x1" />
    				<input type="hidden" name="y1" value="" id="y1" />
    				<input type="hidden" name="x2" value="" id="x2" />
    				<input type="hidden" name="y2" value="" id="y2" />
    				<input type="hidden" name="w" value="" id="w" />
    				<input type="hidden" name="h" value="" id="h" />
    				<input type="submit" name="upload_thumbnail" value="Crop and save" id="save_thumb" />
    			</form>
    		</div>
	    <?php } ?>
    <form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    	<input type="file" name="image" size="30" />
      <input type="submit" name="upload" value="Upload" />
    </form>
    <?php } ?>
  </section>
  <section>
    <h1>Previous Profile Pictures</h1>
    <?php // DELETE OLD PROFILE PICTURE
  	$delete = $_REQUEST['d'];

  	if(!empty($delete)) {
    	// QUERY TO GET THE IMAGE LOCATION
    	$deleteQuery = mysqli_query($con, "SELECT * FROM used_profile_pics WHERE id = '$delete'");
    	$deleteQueryArray = mysqli_fetch_array($deleteQuery);
    	$deleteImgOwnersID = $deleteQueryArray['owners_id'];
    	$deleteImagePath = $deleteQueryArray['location'];
  		// SECURITY CHECK IF THE USER IS THE OWNER IF THE IMAGE
  		if($deleteImgOwnersID == $userIDCookie) {
  			$imageCheckQuery = mysqli_query($con, "SELECT profile_picture FROM users WHERE id = '$userIDCookie'");
  			$imageCheckQueryResult = mysqli_fetch_array($imageCheckQuery);
  			$currentBannerIMG = $imageCheckQueryResult['profile_picture'];
    		//CHECK IF THE IMAGE IS NOT THE CURRENT SET IMAGE
  			if($deleteImagePath !== $currentBannerIMG) {
  				// DELETE THE ROW FROM THE DATABASE
  				mysqli_query($con, "DELETE FROM used_profile_pics WHERE id='$delete';");
  				//CHECK IF THE IMAGE IS THE DEAFULT IMAGE
  				if ($deleteImagePath !== 'images/profile-pictures/default_profile.jpg') {
  					//DELETE THE IMAGE FROM THE IMAGES FOLDER
  					$imagePath = "$deleteImagePath";
  					unlink($imagePath);
  				}

  				header("location: upload-crop.php"); //REFRESH PAGE
			  } else {
				//DISPLAY ERROR MESSAGE
				header("location: upload-crop.php?error2=1");
			}
		} else { // NOT THE USERS IMAGE
			header("location: upload-crop.php");
		}
	}
  //SELECT A PREVIOUS PROFILE PICTURE
  $image = $_REQUEST['img'];

  if((!empty($image))) {
    //CHECK IF THE IMAGE IS OWNED BY THE USER
    //CHECK IF THE USER CHANGED THE IMAGE ID IN THE URL
    $securityQuery = mysqli_query($con, "SELECT * FROM used_profile_pics WHERE id = '$image'");
    $securityQueryArray = mysqli_fetch_array($securityQuery);
    $securityID = $securityQueryArray['owners_id'];
    $imageLocation = $securityQueryArray['location'];

    if($userIDCookie == $securityID) {
  		$currentPictureQuery2 = mysqli_query($con, "SELECT * FROM users WHERE id = '$userIDCookie'");
  		$currentPictureArray2 = mysqli_fetch_array($currentPictureQuery2);
  		$currentImageLoc2 = $currentPictureArray2['profile_picture'];
  		// CHECK TO SEE IF THE CURRENT IMAGE IS ALREADY IN THE USED PROFILE PICTURES TABLE
  		$countQuery = mysqli_query($con, "SELECT * FROM used_profile_pics WHERE location = '$currentImageLoc2' AND owners_id = '$userIDCookie'");
    	$countQueryArray = mysqli_fetch_array($countQuery);
    	$numRows = mysqli_num_rows($countQuery);

  		if ($numRows=='0') {
    		// ADD CURRENT PICTURE TO THE OLD PROFILE PICTURES
    		mysqli_query($con, "INSERT INTO used_profile_pics (owners_id, location) values ('$userIDCookie', '$currentImageLoc2')");
  		}
    		// UPDATE USERS PROFILE PICTURE
  		mysqli_query($con, "UPDATE users SET profile_picture = '$imageLocation' WHERE id = '$userIDCookie'");
  		header("location: upload-crop.php?c=confirm");
    } else {
      echo "<br/>Error!";
    }
  }    //ADD OLD PROFILE PICTURES

  $oldProfileQuery = mysqli_query($con, "SELECT * FROM used_profile_pics WHERE owners_id = '$userIDCookie'");

  while($queryArray = mysqli_fetch_array($oldProfileQuery)) {
    $picture_id = $queryArray['id'];
    $picture_owners_id = $queryArray['owners_id'];
    $picture_location = $queryArray['location'];
    echo "<div style='float: left; border: solid 0px red;margin-top: 5px; margin-bottom: 5px;' >
		  <div style='; border: solid 0px black'>
        <a href='upload-crop.php?img=$picture_id'>
				<img src='$picture_location' alt='broken-link'/>
			  </a>
			</div>
			<div style='; border: solid 0px black'>
				<a href='upload-crop.php?d=$picture_id'>Delete</a>
			</div>
		</div>";
  }
  ?>
  </section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
