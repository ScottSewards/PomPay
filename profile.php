<?php include_once("profile-code.php");?>
<?php
$title = "$profileUsername";
include_once("navigation.php");
?>
<main>


  <section id="profile">
    <img style='width: 250px' src="<?php echo $profilePictureLocation ?>" alt='<?php echo $profileUsername ?> Profile Image'/>
    <div>
      <h1 id="username"><?php echo "$profileUsername" ?></h1>
      <p><?php echo "$profileDescription" ?></p>
    </div>
  </section>

<?php

######################################################
# GETTING THE LAST TWO BLOG POSTS FROM THE USER    #
######################################################

$blog_profile_username = $_REQUEST['profile'];
$preQuery = mysqli_query($con, "SELECT id FROM users WHERE username = '$blog_profile_username' ");
$preQueryResults = mysqli_fetch_array($preQuery);
$profileBlogID = $preQueryResults['id'];

$profile_blog_query = mysqli_query($con, "SELECT * FROM profile_blog WHERE profile_id = '$profileBlogID' ORDER BY id DESC LIMIT 2");

?>
<section>

	<h1>Latest Blog</h1>

	<?php

	while ($results = mysqli_fetch_array($profile_blog_query)) {

		$resultID2 = $results['id'];
		$resultProfileID2 = $results['profile_id'];
		$resultTitle2 = $results['title'];
		$resultPost2 = $results['post'];
		$resultProfileDate2 = $results['date'];

		$lastSpace = strrpos(substr($resultPost2, 0, "550"), ' ');
        $snippit = substr($resultPost2, 0, $lastSpace) . "...";


		echo "

					<div id='blog_results_title' style='width: 100%; border: solid 0px red;'>

						<h3>$resultTitle2</h3>

					</div>

					<div id='blog_results_post' style='width: 100%; border: solid 0px green;'>

						<p>$snippit</p>

					</div>

					<br/>

				";

	}

	?>

<p><a href="profile-blog.php?profile=<?php echo "$profileUsername"?>">Visit blog!</a></p>
</section>


 <!--- <section id="progress">
    <h1>Progress</h1>
    <div id="progress-division">
      <progress id="progress-bar" min="0" value="20" max="100"></progress>
      <p>Current: £1000</p>
      <p>Target: £5000</p>
    </div>
    <button type="button" name="button">Contact</button>
    <button type="button" name="button">Donate</button>
  </section>

  -->

  <!--section id="wallet">
    <h1>Fundraiser</h1>
    <div id="bitcoin-address">
      <img src="images/test.png" alt="QR Code"/>
      <p>Bitcoin Address:<?php echo "$profileBitcoinAddress"; ?></p>
      <p>Bitcoin balance: <span id="bitcoin-balance"></span></p>
    </div>
     <div id="ethereum-address">
        <img src="images/test.png" alt="QR Code"/>
        <p>Ethereum Address:<?php echo "$profileEthereumAddress"; ?></p>
        <p>Ethereum balance: <span id="ethereum-balance"></span></p>
    </div>
    <p>Other ERC20 tokens balances:</p>
    <ul>
    <li>10 EtherBlue</li>
    <li>1m EXRN</li>
    </ul>
    <div id="piechart"></div>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'], ['Work', 8], ['Eat', 2], ['TV', 4], ['Gym', 2], ['Sleep', 8]
      ]);
      var options = {'title':'Portfolio', 'width':550, 'height':400};
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
    </script>
  </section-->
  <section id="video">
    <h1>Embed Video</h1>
		<div class="embedVideo">
			<center>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $profileVideo ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</center>
		</div>
  </section>
  <section id="rewards">
    <h1>Rewards or Milestones?</h1>
    <div class="timeline">
      <div class="milestone">
        <p class="title">Milestone #1</p>
        <time>2018-04-20</time>
        <p class="editable">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
      <div class="milestone">
        <p class="title">Milestone #2</p>
        <time>2018-05-20</time>
        <p class="editable">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
    </div>
  </section>
  <section>
    <h1>QR Code Test</h1>
    <?php
    if ($profileEthereumAddress == "") {
      echo "This account has no Ethereum wallet";
    } else {
      
    }
      /*
      if($profileEthereumAddress != null) {
        echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $profileEthereumAddress?>&choe=UTF-8' alt='<?php echo $profileUsername?> Ethereum QR Code'/>"
      } else {
        echo "<p>There is no address</p>";
      }
      */
    ?>
  </section>
  <section id="social-media">
    <h1>Social Media</h1>
    <ul>
      <li>Share <?php echo "$profileUsername"?> on Facebook</li>
      <li>Share <?php echo "$profileUsername"?> on Twitter</li>
      <li>Share <?php echo "$profileUsername"?> on YouTube</li>
    </ul>
    <ul>
      <li>View <?php echo "$profileUsername"?> on Facebook</li>
      <li>View <?php echo "$profileUsername"?> on Twitter</li>
      <li>View <?php echo "$profileUsername"?> on YouTube</li>
    </ul>
  </section>


</main>
<?php include_once("contents.php");?>
<?php include_once("footer.php"); ?>
