<?php include_once("head.php"); ?>
<nav>
	<div>
		<ul>
			<li id="index"><a href="./index.php">Index</a></li>
			<li id="support"><a href="./support.php">Support</a></li>
			<li id="options"><a href="./options.php">Options</a></li>
		</ul>
		<!--form id="search" action="search.php" method="post">
			<input id="search-bar" type="text" name="search" placeholder="Search..."/>
			<input id="search-submit" type="submit" name="submit" value="Search!"/>
		</form-->
		<ul id="local">
			<?php
			if((isset($usersPasswordCookie)) AND (isset($usersIDCookie))) {
				echo "<li id='dashboard'><a href='dashboard.php'>Dashboard</a></li>
				<li id='sign-out' class='caution'><a href='index.php?s=lo'>Sign-out</a></li>";
			} else {
				echo "<li id='sign-in'><a href='sign-in.php'>Sign-in</a></li>
				<li id='sign-up'><a href='sign-up.php'>Sign-up</a></li>";
			}
			?>
		</ul>
	</div>
</nav>
