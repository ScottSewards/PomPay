<?php
$title = 'Change Profile Banner';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
error_reporting (E_ALL ^ E_NOTICE);
session_start(); //DO NOT REMOVE

if(!isset($_SESSION['random_key']) || strlen($_SESSION['random_key']) == 0) { //ASSIGN TIMESTAMP IF SESSION IS EMPTY
  $_SESSION['random_key'] = strtotime(date('Y-m-d H:i:s'));
	$_SESSION['user_file_ext'] = "";
}
//BASIC CODE
header("Cache-Control: no-store, no-cache, must-revalidate, max-age = 0");
header("Cache-Control: post-check = 0, pre-check = 0", false);
header("Pragma: no-cache");
$uploadDirectory = "images/profile-banners"; //DIRECTORY FOR IMAGES
$uploadPath = $uploadDirectory."/";	//PATH TO DIRECTORY
$largeImagePrefix = "og-";
$thumbImagePrefix = "tn-";
$largeImageName = $largeImagePrefix.$_SESSION['random_key'];
$thumbImageName = $thumbImagePrefix.$_SESSION['random_key'];
$maxFileSize = "5";
$maxLargeWidth = "1500";
$maxThumbWidth = "1000";
$thumb_height = "300";
// Only one of these image types should be allowed for upload
$imageTypes = array('image/pjpeg' => "jpg", 'image/jpeg' => "jpg", 'image/jpg' => "jpg", 'image/png' => "png", 'image/x-png' => "png", 'image/gif' => "gif");
$imageExtension = "";

foreach(array_unique($imageTypes) as $mimeType => $extension) $imageExtension.= strtoupper($extension)." ";

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
	  	imagejpeg($newImage, $image, 90);
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
			$source = imagecreatefromgif($image);
			break;
	  case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source = imagecreatefromjpeg($image);
			break;
	  case "image/png":
		case "image/x-png":
			$source = imagecreatefrompng($image);
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

$largeImageLocation = $uploadPath.$largeImageName.$_SESSION['user_file_ext'];
$thumbImageLocation = $uploadPath.$thumbImageName.$_SESSION['user_file_ext'];

//CHECK IF ANY IMAGES WITH THE SAME NAME ALREADY EXIST
if(file_exists($largeImageLocation)){
	if(file_exists($thumbImageLocation)){
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
	$userFileName = $_FILES['image']['name'];
	$userFileTemp = $_FILES['image']['tmp_name'];
	$userFileSize = $_FILES['image']['size'];
	$userFileType = $_FILES['image']['type'];
	$filename = basename($_FILES['image']['name']);
	$fileExtension = strtolower(substr($filename, strrpos($filename, '.') + 1));

	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
		foreach($imageTypes as $mimeType => $extension) {
			//loop through the specified image types and if they match the extension then break out
			if($fileExtension == $extension && $userFileType == $mimeType){
				$error = "";
				break;
			} else {
				$error = "Only ".$imageExtension." images accepted for upload";
			}
		}

		if($userFileSize > ($maxFileSize * 1048576)) { //CHECK FILE SIZE
			$error .= "Images must be under ".$maxFileSize."MB in size";
		}
	} else {
		$error = "Select an image for upload";
	}

  if(strlen($error) == 0) {
		if(isset($_FILES['image']['name'])) {
			$largeImageLocation = $largeImageLocation.".".$fileExtension;
			$thumbImageLocation = $thumbImageLocation.".".$fileExtension;
      $_SESSION['user_file_ext'] = ".".$fileExtension; //EXTEND FILE
			move_uploaded_file($userFileTemp, $largeImageLocation);
			chmod($largeImageLocation, 0777);
			$width = getWidth($largeImageLocation);
			$height = getHeight($largeImageLocation);

			if($width > $maxLargeWidth) { //SCALE IMAGE
				$scale = $maxLargeWidth/$width;
				$uploaded = resizeImage($largeImageLocation,$width,$height,$scale);
      } else {
				$scale = 1;
				$uploaded = resizeImage($largeImageLocation, $width, $height, $scale);
			}

      if(file_exists($thumbImageLocation)) unlink($thumbImageLocation); //DELETE THUMBNAIL
		}

		$currentPictureQuery = mysqli_query($con, "SELECT * FROM users WHERE id = '$userIDCookie' ");
		$currentPictureArray = mysqli_fetch_array($currentPictureQuery);
		$currentImageLoc = $currentPictureArray['profile_banner'];
    //REFRESH
		mysqli_query($con, "UPDATE users SET profile_banner = '$thumbImageLocation' WHERE id = '$userIDCookie'");
    //CHECK IF THE IMAGE IS ALREADY IN PROFILE PICTURES TABLE
		$countQuery = mysqli_query($con, "SELECT * FROM old_profile_banners WHERE location = '$currentImageLoc' AND owners_id = '$userIDCookie'");
		$countQueryArray = mysqli_fetch_array($countQuery);
		$currentImageLoc2 = $currentPictureArray2['profile_banner'];
		$numRows = mysqli_num_rows($countQuery);

		if($numRows == '0')	mysqli_query($con, "INSERT INTO old_profile_banners (owners_id, location) values ('$userIDCookie', '$currentImageLoc')"); //ADD BANNER TO OLD BANNERS

		header("location: change-profile-banner.php?c=confirm");
		//exit();
	}
}

if(isset($_POST["upload_thumbnail"]) && strlen($largePhotoExists) > 0) {
  //IMAGE COORDINATES
  $xa = $_POST["x1"];
	$ya = $_POST["y1"];
	$xb = $_POST["x2"];
	$yb = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//SCALE IMAGE
  $scale = $maxThumbWidth / $w;
	$cropped = resizeThumbnailImage($thumbImageLocation, $largeImageLocation, $w, $h, $xa, $ya, $scale);
  //REFRESH
	session_destroy();
	header("location: change-profile-banner.php?c=confirm");
	exit();
}

if($_GET['a'] == "delete" && strlen($_GET['t']) > 0) {
  //GET FILE LOCATION
	$largeImageLocation = $uploadPath.$largeImagePrefix.$_GET['t'];
	$thumbImageLocation = $uploadPath.$thumbImagePrefix.$_GET['t'];

  if(file_exists($largeImageLocation)) unlink($largeImageLocation);
	if(file_exists($thumbImageLocation)) unlink($thumbImageLocation);

	session_destroy();
	header("location: change-profile-banner.php?c=confirm");
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

  if ($_REQUEST['c'] == 'confirm') { //SHOW MESSAGE
  	echo "<section class='info'>
  		<p>Your banner has been updated.</p>
  	</section>";
  }
  ?>
  <section>
    <h1>Post New Profile Banner</h1>
    <?php
    //Only display the javacript if an image has been uploaded
    if(strlen($largePhotoExists)>0){
    	$current_large_image_width = getWidth($largeImageLocation);
    	$current_large_image_height = getHeight($largeImageLocation);?>

    <script type="text/javascript">
    function preview(img, selection) {
    	var scaleX = <?php echo $maxThumbWidth; ?> / selection.width;
    	var scaleY = <?php echo $thumb_height; ?> / selection.height;

    	$('#thumbnail + div > img').css({
    		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px',
    		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
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
    	$('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$maxThumbWidth;?>', onSelectChange: preview });
    });
    </script>
    <?php }?>
    <?php
    //Display error message if there are any
    if(strlen($error)>0){
    	echo "<ul><li><strong>Error!</strong></li><li>".$error."</li></ul>";
    }
    if(strlen($largePhotoExists)>0 && strlen($thumbPhotoExists)>0){
    	echo $largePhotoExists."&nbsp;".$thumbPhotoExists;
    	//echo "<p><a href=\"".$_SERVER["PHP_SELF"]."?a=delete&t=".$_SESSION['random_key'].$_SESSION['user_file_ext']."\">Delete images</a></p>";
    	//echo "<p><a href=\"".$_SERVER["PHP_SELF"]."\">Upload another</a></p>";
    	//Clear the time stamp session and user file extension
    	$_SESSION['random_key']= "";
    	$_SESSION['user_file_ext']= "";
    } else {
    	if(strlen($largePhotoExists)>0){?>
    		<h2>Crop and Save</h2>
    		<div align="center">
    			<img src="<?php echo $uploadPath.$largeImageName.$_SESSION['user_file_ext'];?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
    			<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $maxThumbWidth;?>px; height:<?php echo $thumb_height;?>px;">
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
	    <?php 	} ?>
    <form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    	<input type="file" name="image" size="30" />
      <input type="submit" name="upload" value="Upload" />
    </form>
    <?php } ?>
  </section>
  <section>
    <h1>Previous Profile Banner</h1>
    <?php

	// DELETE OLD PROFILE PICTURE
	$delete = $_REQUEST['d'];

	if (	!empty($delete)	) {


	// QUERY TO GET THE IMAGE LOCATION
	$deleteQuery = mysqli_query($con, "SELECT * FROM old_profile_banners WHERE id = '$delete' ");
	$deleteQueryArray = mysqli_fetch_array($deleteQuery);

	$deleteImgOwnersID = $deleteQueryArray['owners_id'];
	$deleteImgLoc = $deleteQueryArray['location'];

		// SECURITY CHECK IF THE USER IS THE OWNER IF THE IMAGE
		if ($deleteImgOwnersID==$usersIDCookie) {

			$imageCheckQuery = mysqli_query($con, "SELECT profile_banner FROM users WHERE id = '$usersIDCookie' ");
			$imageCheckQueryResult = mysqli_fetch_array($imageCheckQuery);
			$currentBannerIMG = $imageCheckQueryResult['profile_banner'];
			// CHECK IF THE IMAGE IS NOT THE CURRENT SET IMAGE
			if ($deleteImgLoc!==$currentBannerIMG) {




				// DELETE THE ROW FROM THE DATABASE
				mysqli_query($con, "DELETE FROM old_profile_banners WHERE id='$delete'; ");

				// DELETE THE IMAGE FROM THE IMAGES FOLDER
				// CHECK IF THE IMAGE IS THE DEAFULT IMAGE
				if ($deleteImgLoc!=='images/profile-banners/default_banner.jpg') {

					// DELETE THE IMAGE FROM THE IMAGES FOLDER
					$imgPath = "$deleteImgLoc";
					unlink($imgPath);

				}

				// REFRESH THE PAGE
				header("location: change-profile-banner.php");


			} else {

					// DISPLAY ERROR MESSAGE
					header("location: change-profile-banner.php?error2=1");


			}

			} else {

				// NOT THE USERS IMAGE
				header("location: change-profile-banner.php");

			}


	}


    //SELECT A PREVIOUS PROFILE PICTURE
    $img = $_REQUEST['img'];
    if((!empty($img))) {
      //CHECK IF THE IMAGE IS OWNED BY THE USER
      //CHECK IF THE USER CHANGED THE IMAGE ID IN THE URL
      $securityQuery = mysqli_query($con, "SELECT * FROM old_profile_banners WHERE id = '$img' ");
      $securityQueryArray = mysqli_fetch_array($securityQuery);
      $securityID = $securityQueryArray['owners_id'];
      $imageLocation = $securityQueryArray['location'];
      if($usersIDCookie == $securityID) {
    		$currentPictureQuery2 = mysqli_query($con, "SELECT * FROM users WHERE id = '$usersIDCookie' ");
    		$currentPictureArray2 = mysqli_fetch_array($currentPictureQuery2);
    		$currentImageLoc2 = $currentPictureArray2['profile_banner'];
    		// CHECK TO SEE IF THE CURRENT IMAGE IS ALREADY IN THE USED PROFILE PICTURES TABLE
    		$countQuery = mysqli_query($con, "SELECT * FROM old_profile_banners WHERE location = '$currentImageLoc2' AND owners_id = '$usersIDCookie' ");
    		$countQueryArray = mysqli_fetch_array($countQuery);
    		$numRows = mysqli_num_rows($countQuery);

    		if ($numRows=='0') {
    			// ADD CURRENT PICTURE TO THE OLD PROFILE PICTURES
    			mysqli_query($con, "INSERT INTO old_profile_banners (owners_id, location) values ('$usersIDCookie', '$currentImageLoc2') ");
    		}
    		// UPDATE USERS PROFILE PICTURE
    		mysqli_query($con, "UPDATE users SET profile_banner = '$imageLocation' WHERE id = '$usersIDCookie' ");
    		header("location: change-profile-banner.php?c=confirm");
      } else {
        echo "<br/>Error!";
      }
    }    //ADD OLD PROFILE PICTURES
    $oldProfileQuery = mysqli_query($con, "SELECT * FROM old_profile_banners WHERE owners_id = '$usersIDCookie'");
    while($queryArray = mysqli_fetch_array($oldProfileQuery)) {
      $picture_id = $queryArray['id'];
      $picture_owners_id = $queryArray['owners_id'];
      $picture_location = $queryArray['location'];
      echo "

	   <div style='float: left; border: solid 0px red;margin-top: 5px; margin-bottom: 5px;' >

		   <div style='border: solid 0px black'>

			   <a href='change-profile-banner.php?img=$picture_id'>
				<img style='width: 500px' src='$picture_location' alt='broken-link'/>
			   </a>
			</div>
			<div style='; border: solid 0px black'>

				<a href='change-profile-banner.php?d=$picture_id'>Delete</a>

			</div>

		</div>

		";
    }

  ?>


</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
