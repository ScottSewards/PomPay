<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require "connect.inc.php";
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
$title = 'Blog (Edit)';
$usersIDCookie = $_COOKIE['usersIDCookie'];
//USER ACCOUNT INFORMATION
$blogIDQuery = mysqli_query($con, "SELECT * FROM users WHERE id = '$usersIDCookie' ");
$blogIDQueryResults = mysqli_fetch_array($blogIDQuery);
// THE SIGNED IN USERS USERNAME
$signed_in_user_username = $blogIDQueryResults['username'];
// THE PROFILE BLOG USERNAME
$usersBlogUsername = $_REQUEST['profile'];
// IF THE SIGNED IN USERS USERNAME IS EQUAL TO THE PROFILE USERNAME THE BLOG IS OWNED BY THE SIGNED IN USER
if($signed_in_user_username == $usersBlogUsername) {

} else {
	header("location: index.php");
}

# GETTING THE POST DATA					  #
$postID = $_REQUEST['id'];
$state = $_REQUEST['s'];
$editPOSTQuery = mysqli_query($con, "SELECT * FROM profile_blog WHERE id = '$postID' ");
$editPOSTArray = mysqli_fetch_array($editPOSTQuery);
$postTitle = $editPOSTArray['title'];
$postPost = $editPOSTArray['post'];
## NEED TO MAKE SURE THE BLOG POST IS OWNED BY THE USER  #
$profile_id = $editPOSTArray['profile_id'];

if($profile_id==$usersIDCookie) {
	# UPDATING THE DATABASE
	$updatedTitle = $_POST['blogTitle'];
	$updatedPost = $_POST['blogPost'];
	if(isset($_POST['submit'])) {
		$postID = $_REQUEST['id'];
		mysqli_query($con, "UPDATE profile_blog SET title = '$updatedTitle' WHERE id = '$postID' ");
		mysqli_query($con, "UPDATE profile_blog SET post = '$updatedPost' WHERE id = '$postID' ");
		header("location: profile-blog.php?profile=$signed_in_user_username");
	}
} else {
	// USER DOES NOT OWN THE BLOG POST
	header("location: index.php");
}
?>
<main>
	<section>
		<form action="blog-edit.php?id=<?php echo $postID ?>&profile=<?php echo $signed_in_user_username ?>" method="post">
		  <div class="fields">
			<div class="field">
			  <input type="text" name="blogTitle" placeholder="Blog title..." value='<?php echo $postTitle ?>' required/>
			</div>
			<div class="field">
			  <textarea name="blogPost" rows="8" cols="80" placeholder="Write your blog entry..." required><?php echo $postPost ?></textarea>
			</div>
			<input type="submit" name="submit" value="Update"/>
		  </div>
		</form>s
	</section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
