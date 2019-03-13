<?php
//GET AND SECURE DATA
$blogTitle = htmlspecialchars(addslashes($_POST['blogTitle']));
$blogPost = htmlspecialchars(addslashes($_POST['blogPost']));
//CHECK BOTH FORMS HAVE BEEN SUBMITTED
if((!empty($blogTitle)) AND (!empty($blogPost))) {
	//SUBMIT FORM DATA
	mysqli_query($con, "INSERT INTO profile_blog (profile_id, title, post) VALUES ('$userIDCookie', '$blogTitle', '$blogPost')");
	header("location: profile-blog.php?profile=$signeeUsername");
}
//CREATE QUERY
$mainPullQuery = mysqli_query($con, "SELECT * FROM profile_blog WHERE profile_id = '$userIDCookie' ORDER BY id DESC");

if(!empty($_REQUEST['s'])) {
	$userBlogID = $_REQUEST['id'];
	$deleteQuery = mysqli_query($con, "DELETE FROM profile_blog WHERE id = '$userBlogID'");
	header("location: profile-blog.php?profile=$signeeUsername");
}
?>
<main>
	<section>
		<form action="profile-blog.php?profile=<?php echo $signeeUsername ?>" method="post">
		  <div class="fields">
				<div class="field">
				  <input type="text" name="blogTitle" placeholder="Title..." required/>
				</div>
				<div class="field">
				  <textarea name="blogPost" rows="8" cols="80" placeholder="Write your blog..." required></textarea>
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
				echo "<div id='blog_results_title' style='width: 100%; border: solid 0px red;'>
						<h3>$resultTitle</h3>
					</div>
					<div id='blog_results_post' style='width: 100%; border: solid 0px green;'>
						<p>$resultPost</p>
					</div>
					<div id='blog_results_date' style='width: 100%; border: solid 0px blue; margin-top: 20px; margin-bottom: 20px'>
						<a style='float: left' href='profile-blog.php?profile=$signeeUsername&id=$resultID&s=d'>Delete</a>
						<a style='float: left; margin-left: 10px;' href='blog-edit.php?profile=$signeeUsername&id=$resultID&s=edit'>Edit</a>
						<p style='float: right'>$resultProfileDate</p>
					</div>";
			}
		?>
	</section>
</main>
