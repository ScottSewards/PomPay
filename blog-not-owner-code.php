<?php

###################################################
# THE SIGNED IN USER IS NOT THE OWNER OF THE BLOG #
###################################################


#############################################
# GETTING THE BLOG POSTS FROM THE DATABASE  #
#############################################

// CREATING THE MAIN QUERY
$blog_profile_username = $_REQUEST['profile'];
$preQuery = mysqli_query($con, "SELECT id FROM users WHERE username = '$blog_profile_username' ");
$preQueryResults = mysqli_fetch_array($preQuery);
$profileBlogID = $preQueryResults['id'];
$mainPullQuery2 = mysqli_query($con, "SELECT * FROM profile_blog WHERE profile_id = '$profileBlogID' ORDER BY id DESC ");
?>
<main>
	<section>
		<?php
			while($results = mysqli_fetch_array($mainPullQuery2)) {
				$resultID2 = $results['id'];
				$resultProfileID2 = $results['profile_id'];
				$resultTitle2 = $results['title'];
				$resultPost2 = $results['post'];
				$resultProfileDate2 = $results['date'];

				echo "
					<div id='blog_results_title' style='width: 100%; border: solid 0px red;'>
						<h3>$resultTitle2</h3>
					</div>
					<div id='blog_results_post' style='width: 100%; border: solid 0px green;'>
						<p>$resultPost2</p>
					</div>
					<div id='blog_results_date' style='width: 100%; border: solid 0px blue; margin-top: 20px; margin-bottom: 20px'>
						<p style='float: right'>$resultProfileDate2</p>
					</div>
				";
			}
		?>
	</section>
</main>
