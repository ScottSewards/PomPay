<?php
$title = 'Index';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
$state = $_REQUEST['s']; //CHECK IF USER IS SIGNED-OUT
if($state == "lo") { //SIGN-OUT VIA REMOVING COOKIES
	setcookie("usersIDCookie", "", time()-86400);
	setcookie("usersPasswordCookie", "", time()-86400);
	header("location: index.php"); //REDIRECT
}
?>
<main>
	<?php include("search-bar.php");?>
	<section class="hide">
		<h1>Featured</h1>
		<div class="pages">
			<div class="profile">
				<img src="images/test.png"/>
				<a href="profile.php">Profile Test Page</a>
			</div>
			<div class="project">
				<img src="images/test.png"/>
				<a href="project.php">Project Test Page</a>
			</div>
		</div>
	</section>
	<section id="featured-profiles">
	<h1>Featured</h1>
	
	<?php
		
			// THE FEATURED PROFILES
			$featuredQueryMain = mysqli_query($con, "SELECT * FROM featured_profiles LIMIT 5");
			
			while ($featuredResults = mysqli_fetch_array($featuredQueryMain)) {
				
					$featuredID = $featuredResults['id'];
					$featuredProfileID = $featuredResults['profile_id'];
					
					// GETTING THE FEATURED PROFILE DATA
					$featuredQuerySecondary = mysqli_query($con, "SELECT * FROM profile WHERE id = '$featuredProfileID' ");
					$QuerySecondaryResults = mysqli_fetch_array($featuredQuerySecondary);
					$ownersUsername = $QuerySecondaryResults['owners_username'];
					$description = $QuerySecondaryResults['description'];
					
					$state = $QuerySecondaryResults['state'];
					
					// CUTTING DOWN THE TEXT WITHOUT LEAVING HALF WORDS
					$lastSpace = strrpos(substr($description, 0, "175"), ' ');
					$snippit = substr($description, 0, $lastSpace) . "...";
					
					// GETTING THE USERS PROFILE IMAGE
					$featuredQueryThree = mysqli_query($con, "SELECT profile_picture FROM users WHERE id = '$featuredProfileID' ");
					$queryThreeResults = mysqli_fetch_array($featuredQueryThree);
					$profileImage = $queryThreeResults['profile_picture'];
					
					if ($state=='1') {
					
					echo "
				
						<div class='profiles'>
							<div class='profile'>
								<div class='profile-picture'>
									<img src='$profileImage' alt='Profile Picture'/>
								<a class='username' href='profile.php?profile=$ownersUsername'>$ownersUsername</a>
							</div>
							<p>$snippit</p>
							</div>
						</div>
				
					";
					
					}
			}
		
	?>
		
	</section>
	
	<section id="newest-profiles">
	<h1>Newest Users</h1>
	
	<?php
		
		$newestQuery = mysqli_query($con, "SELECT * FROM profile WHERE state = '1' ORDER BY id DESC LIMIT 5");
		
		while ($newestQueryArray = mysqli_fetch_array($newestQuery)) {
			
			$owners_ID = $newestQueryArray['owners_id'];
			$owners_Username = $newestQueryArray['owners_username'];
			$profile_descript = $newestQueryArray['description'];
			
			// CUTTING DOWN THE TEXT WITHOUT LEAVING HALF WORDS
			$NlastSpace = strrpos(substr($profile_descript, 0, "175"), ' ');
			$Nsnippit = substr($profile_descript, 0, $NlastSpace) . "...";
			
			// GETTING THE USERS PROFILE IMAGE
			$NewestQueryThree = mysqli_query($con, "SELECT profile_picture FROM users WHERE id = '$owners_ID' ");
			$queryThreeResults = mysqli_fetch_array($NewestQueryThree);
			$newestProfileImage = $queryThreeResults['profile_picture'];
			
			
			echo "
				
						<div class='profiles'>
							<div class='profile'>
								<div class='profile-picture'>
									<img src='$newestProfileImage' alt='Profile Picture'/>
								<a class='username' href='profile.php?profile=$owners_Username'>$owners_Username</a>
							</div>
							<p>$Nsnippit</p>
							</div>
						</div>
				
					";
			
		}
	
	?>
		
	</section>
	

	<!--section id="catagories">
		<ul>
			<li>Admin</li>
			<li>Gaming</li>
			<li>Board Games</li>
			<li>Entertainment</li>
			<li>Film</li>
			<li>Support</li>
		</ul>
	</section-->
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>