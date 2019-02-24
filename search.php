<?php require "connect.inc.php"; ?>
<?php
$title = "Search Results";
include_once("navigation.php");
?>
<main>
  <?php include("templates/search-bar.php");?>
  <section id="users-returned">
    <h1>Search Results</h1>
    <!--p><?php $results = "this element must echo"; echo $results ?> $results but the variable is created after this point in the HTML file</p>
    <p>Also, fix the profile picture ratio, this will fix the horrible alignment of profiles</p-->
    <div class="profiles">
    <?php
      // GETTING THE SEARCH QUERY FROM THE SEARCH BAR // THIS WILL BE COMING FROM THE INDEX.PHP AND SEARCH.PHP
      $RAWusersSearchQuery = $_POST['search'];
      $usersSearchQuery = htmlspecialchars(addslashes($RAWusersSearchQuery));
      // TAKE THE USERS SEARCH KEYWORD
      // SEARCH PROFILE USERNAMES/DESCRIPTION/KEYWORDS FOR WORDS THAT ARE *LIKE* THE SEARCH QUERY
      // WILL HAVE TO ADD THE CONTENT CREATORS USERNAME TO THE PROFILE TABLE BUT WHEN THE USER UPDATES THEIR USERNAME
      // IT WILL HAVE TO UPDATE BOTH THE USERS AND PROFILE TABLE
      // OR CAN USE SQL *INNER JOIN* TO SEARCH BOTH TABLES FOR WORDS THAT ARE *LIKE* THE USERS SEARCH QUERY
      if (!empty($usersSearchQuery)) {
        $mainSearchQuery = mysqli_query($con, "SELECT * FROM profile WHERE (owners_username
        LIKE '%$usersSearchQuery%' OR description LIKE '%$usersSearchQuery%' OR keywords LIKE '%$usersSearchQuery%') AND (state='1') ");
        // THE NUMBER OF ROWS RETURNED
        $rowsReturned = mysqli_num_rows($mainSearchQuery);
        $results = "$rowsReturned results for '$usersSearchQuery";
        while ($searchResults = mysqli_fetch_array($mainSearchQuery)) {
          $resultsID = $searchResults['id'];
          $resultsUsername = $searchResults['owners_username'];
          $resultsDescription = $searchResults['description'];
          $resultsOwnersID = $searchResults['owners_id'];
          // GETTING THE RESULTS USERS PROFILE PICTURE FROM THE USERS TABLE
          $secondQuery = mysqli_query($con, "SELECT profile_picture FROM users WHERE id = '$resultsOwnersID' ");
          $secondResults = mysqli_fetch_array($secondQuery);
          $resultsProflePicture = $secondResults['profile_picture'];
          // TRIMMING DOWN THE TEXT TO CREATE A SNIPPIT FOR SEARCH RESULTS WITHOUT CUTONG WORDS IN HALF
          $lastSpace = strrpos(substr($resultsDescription, 0, "175"), ' ');
          $snippit = substr($resultsDescription, 0, $lastSpace) . "...";
          echo "<div class='profile'>
                  <div class='profile-picture'>
                    <img src='$resultsProflePicture' alt='$resultsUsername profile picture'/>
                    <a class='username' href='profile.php?profile=$resultsUsername'>$resultsUsername</a>
                  </div>
                  <p class='about'>$snippit</p>
                </div>";
        }
      }
    ?>
    </div>
  </section>
</main>
<?php include_once("footer.php"); ?>
