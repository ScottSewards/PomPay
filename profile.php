<?php
$title = "Profile"; // of $profileUsername";
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/profile-code.php");
?>
<main>
  <section id="banner">
    <div id="banner-container">
      <img id='banner-image' src='<?php echo $profileBannerLocation ?>' alt='Profile Banner'/>
    </div>
  </section>
  <section id="picture">
    <img id="picture-image" src="<?php echo $profilePictureLocation ?>" alt='Profile Picture'/>
    <!--input id='edit-banner' type="button" name="button" value="Change Banner"/-->
    <div>
      <h1 id="username"><?php echo $profileUsername ?></h1>
      <!--input id='edit-banner' type="button" name="button" value="Change Picture"/-->
      <p>
        <?php
        if($profileDescription != "") {
          echo "$profileDescription";
        } else {
          echo "User has not written an about section for their profile...";
        }
        ?>
      </p>
    </div>
  </section>
  <?php //GET LATEST TWO BLOG POSTS
  $bloggerUsername = $_REQUEST['profile'];
  $preQuery = mysqli_query($con, "SELECT id FROM users WHERE username = '$bloggerUsername' ");
  $preQueryResults = mysqli_fetch_array($preQuery);
  $profileBlogID = $preQueryResults['id'];
  $profileBlogQuery = mysqli_query($con, "SELECT * FROM profile_blog WHERE profile_id = '$profileBlogID' ORDER BY id DESC LIMIT 2");
  ?>
  <section>
	  <h1>Recent Blog Posts</h1>
    <div class="subsections">
      <?php
      while($results = mysqli_fetch_array($profileBlogQuery)) {
        $resultID = $results['id'];
        $resultProfileID = $results['profile_id'];
        $resultTitle = $results['title'];
        $resultPost = $results['post'];
        $resultProfileDate = $results['date'];
        $lastSpace = strrpos(substr($resultPost, 0, "550"), ' ');
        $snippit = substr($resultPost, 0, $lastSpace) . "...";
        echo "
        <div style='background: red; padding: 0 1em;'>
          <h2>$resultTitle</h2>
          <p>$snippit</p>
        </div>";
      }
      ?>
    </div>
    <p><a href="profile-blog.php?profile=<?php echo $profileUsername ?>">View blog</a></p>
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
  </section>
  <section id="video">
    <h1>Embed Video</h1>
		<div class="embedVideo">
			<center>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $profileVideo ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</center>
		</div>
  </section-->
  <section>
    <h1>Wallet</h1>
    <?php
    if($profileEthereumAddress != "") {
      echo "
      <p>This users Ethereum address is: $profileEthereumAddress</p>
      <img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$profileEthereumAddress&choe=UTF-8' alt='Ethereum Wallet QR Code'/>
      <input id='send-ethereum' type='button' name='send-ethereum' value='Send Ethereum'/>";
    } else {
      echo "This profile does not have an Ethereum address assigned.";
    }
    ?>
  </section>
  <!--section id="rewards">
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
  </section-->
  <section id="social-media">
    <h1>Social Media</h1>
    <!--ul>
      <li>Share <?php echo "$profileUsername"?> on Facebook</li>
      <li>Share <?php echo "$profileUsername"?> on Twitter</li>
      <li>Share <?php echo "$profileUsername"?> on YouTube</li>
    </ul>
    <ul>
      <li>View <?php echo "$profileUsername"?> on Facebook</li>
      <li>View <?php echo "$profileUsername"?> on Twitter</li>
      <li>View <?php echo "$profileUsername"?> on YouTube</li>
    </ul-->
  </section>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
