<?php
if (isset($_POST['left'])) {
	// CROPPING THE IMAGE
	$dst_x = 0;
	$dst_y = 0;
	$src_x = $_POST['left'];	// Crop Start X
	$src_y = $_POST['top'];	    // Crop Srart Y
	$dst_w = $_POST['width'];	// Thumb width
	$dst_h = $_POST['height'];	// Thumb height
	$src_w = $_POST['width'];	// $src_x + $dst_w
	$src_h = $_POST['height'];		// $src_y + $dst_h
	$dst_image = imagecreatetruecolor($dst_w,$dst_h);
	$src_image = imagecreatefromjpeg('images/original/test.jpg');
	imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
	imagejpeg($dst_image, 'images/thumb/test.jpg', 100);
}
?>
<?php
$title = "Crop";
include_once("navigation.php");
?>
<main>
  <section>
    <h1>Crop</h1>
    <div id='container'>
    	<div id='box'></div>
    	<img src='images/test.png'/>
    </div>
  </section>
  <section>
    <button id="crop" name='crop'>Crop</button>
  </section>
</main>
<?php include_once("footer.php"); ?>
