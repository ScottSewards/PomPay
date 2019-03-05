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
		<div class="profiles">
			<div class="profile">
				<div class="profile-picture">
					<img src="images/favicon.png" alt="Profile Picture"/>
					<a class="username" href='profile.php?profile=Admin'>Pompay</a>
				</div>
				<p>We are Pompay; the developers of this website and we need your support to continue development.</p>
			</div>
		</div>
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
