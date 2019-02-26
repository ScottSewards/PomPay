<?php
###################################################
# THE SIGNED IN USER IS THE OWNER OF THE BLOG     #
###################################################
#############################################
# SENDING THE POST DATA TO THE DATABASE     #
#############################################
// GETTING THE POST DATA
$RAWblogTitle = $_POST['blogTitle'];
$RAWblogPost = $_POST['blogPost'];
// MAKING SURE THE POST DATA IS SECURE
$blogTitle = htmlspecialchars(addslashes($RAWblogTitle));
$blogPost = htmlspecialchars(addslashes($RAWblogPost));
// CHECKING IF BOTH FORMS HAVE BEEN SUBMIT
if((!empty($blogTitle)) AND (!empty($blogPost))) {
	// BOTH FORMS HAVE BEEN FILLED IN
	// SUBMIT THE FORM DATA TO THE DATABASE
	mysqli_query($con, "INSERT INTO profile_blog (profile_id, title, post) VALUES ('$usersIDCookie', '$blogTitle', '$blogPost') ");
	header("location: profile-blog.php?profile=$signed_in_user_username");
}

#############################################
# GETTING THE BLOG POSTS FROM THE DATABASE  #
#############################################
// CREATING THE MAIN QUERY
$mainPullQuery = mysqli_query($con, "SELECT * FROM profile_blog WHERE profile_id = '$usersIDCookie' ORDER BY id DESC ");
#############################################
# BLOG POST DELETE AND EDIT SETTINGS        #
#############################################

// DELETE THE BLOG POST WHEN THE USER CLICKS DELETE
$state = $_REQUEST['s'];

if(!empty($state)) {
	$userBlogID = $_REQUEST['id'];
	$deleteQuery = mysqli_query($con, "DELETE FROM profile_blog WHERE id = '$userBlogID' ");
	header("location: profile-blog.php?profile=$signed_in_user_username");
}
?>
<main>
	<section>
		<form action="profile-blog.php?profile=<?php echo $signed_in_user_username ?>" method="post">
		  <div class="fields">
			<div class="field">
			  <input type="text" name="blogTitle" placeholder="Blog title..." required/>
			</div>
			<div class="field">
			  <textarea name="blogPost" rows="8" cols="80" placeholder="Write your blog entry..." required></textarea>
			</div>
			<input type="submit" name="submit" value="Post"/>
		  </div>
		</form>
	</section>
	<section>
		<?php
			while($results = mysqli_fetch_array($mainPullQuery)) {
				$resultID = $results['id'];
				$resultProfileID = $results['profile_id'];
				$resultTitle = $results['title'];
				$resultPost = $results['post'];
				$resultProfileDate = $results['date'];
				echo "
					<div id='blog_results_title' style='width: 100%; border: solid 0px red;'>
						<h3>$resultTitle</h3>
					</div>
					<div id='blog_results_post' style='width: 100%; border: solid 0px green;'>
						<p>$resultPost</p>
					</div>
					<div id='blog_results_date' style='width: 100%; border: solid 0px blue; margin-top: 20px; margin-bottom: 20px'>
						<a style='float: left' href='profile-blog.php?profile=$signed_in_user_username&id=$resultID&s=d'>Delete</a>
						<a style='float: left; margin-left: 10px;' href='blog-edit.php?profile=$signed_in_user_username&id=$resultID&s=edit'>Edit</a>
						<p style='float: right'>$resultProfileDate</p>
					</div>
				";
			}
		?>
	</section>
</main>
