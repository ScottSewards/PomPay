<?php
require $_SERVER["DOCUMENT_ROOT"]."/Pompay/connect.inc.php"; //CONNECT TO DATABASE
$state = $_REQUEST['s']; //CHECK IF USER IS LOGGED OUT
if($state == "lo") {	//SIGN OUT BY REMOVING COOKIES
	setcookie("usersIDCookie", "", time()-86400);
	setcookie("usersPasswordCookie", "", time()-86400);
	header("location: index.php"); //REDIRECT TO INDEX
}
$title = 'Index';
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
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
		<h1>Newest</h1>
		<div class="profiles">
			<div class="profile">
				<div class="profile-picture">
					<img src="images/profile-pictures/avatar.jpg" alt="Profile Picture"/>
					<a class="username" href='profile.php?profile=Admin'>Admin</a>
				</div>
				<p class="about">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			</div>
		</div>
	</section>
	<section id="catagories">
		<ul>
			<li>Admin</li>
			<li>Gaming</li>
			<li>Board Games</li>
			<li>Entertainment</li>
			<li>Film</li>
			<li>Support</li>
		</ul>
	</section>
	<section id="users-popular">
		<h1>Popular</h1>
		<div class="profiles">
			<div class="profile">
				<div class="profile-picture">
					<img src="images/profile-pictures/avatar.jpg" alt="User Profile Picture"/>
					<a class="username" href='profile.php?profile=Admin'>Admin</a>
				</div>
				<p class="about">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			</div>
		</div>
	</section>
	<section id="news" class="info">
		<p>News: <a href="news.php">click here to see news!</a></p>
	</section>
</main>
<?php include_once("contents.php");?>
<?php include_once("footer.php"); ?>
