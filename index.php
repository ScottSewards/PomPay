<?php
require "connect.inc.php"; //CONNECT TO DATABASE
$state = $_REQUEST['s']; //CHECK IF USER HAS LOGGED OUT
if ($state == "lo") {	//SIGN OUT BY REMOVING COOKIES
	setcookie("usersIDCookie", "", time()-86400);
	setcookie("usersPasswordCookie", "", time()-86400);
	header("location: index.php"); //REDIRECT TO INDEX
}
?>
<?php
$title = 'Index';
include_once("navigation.php");
?>
<main>
	<?php include("templates/search-bar.php");?>
	<section class="info">
		<p>Welcome to Pompay. If you have any inqueries you can find our FAQ on <a href="support.php">the support page</a>.</p>
	</section>
	<section class="info">
		<p><a href="profile-picture.php">Click here to test the picture crop feature!</a></p>
	</section>
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
	<section id="breadcrumbs" class="breadcrumbs">
		<ul>
			<li><a href="#test">Index</a></li>
			<li><a href="#test">Link 2</a></li>
		</ul>
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
