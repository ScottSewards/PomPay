<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/profile-code.php");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require $_SERVER["DOCUMENT_ROOT"]."/Pompay/connect.inc.php";
//checking if the user is signed in this is done by checking if the two cookies are there with the users ID and password
$usersIDCookie = $_COOKIE['usersIDCookie'];
$usersPasswordCookie = $_COOKIE['usersPasswordCookie'];

if((isset($usersPasswordCookie)) AND (isset($usersIDCookie))) {

} else { //USER IS NOT SIGNED-IN
	header("location: sign-in.php");
}

$title = "Change Profile Page";
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");
?>
<main id="editor">
  <section id="help" class="info">
    <p>Help: a tutorial is available on <a href="support.php#help">the support page</a>.</p>
  </section>
  <form action="profile-code.php?profile=<?php echo $UsersUsername ?>" method="post">
  <section id="about">
    <h1>About Me</h1>
    <textarea name="profile-about" rows="8" cols="80" placeholder="Write an about for your profile..."><?php echo $profileDescription ?></textarea>
  </section>
  <section>
    <h1>Social Media</h1>
      <div class="fields">
        <div class="field">
          <label for="facebook">Facebook</label>
          <input type="url" name="facebook" placeholder="Facebook" value="<?php echo $socialLinksFacebook ?>"/>
        </div>
        <div class="field">
          <label for="twitter">Twitter</label>
          <input type="url" name="twitter" placeholder="Twitter" value="<?php echo $socialLinksTwitter ?>"/>
        </div>
        <div class="field">
          <label for="youtube">YouTube</label>
          <input type="url" name="youtube" placeholder="YouTube" value="<?php echo $socialLinksYouTube ?>"/>
        </div>
      </div>
  </section>
  <section>
    <h1>Embed YouTube Video</h1>
    <div class="fields">
	    <div class="field">
	      <label for="videoCode">Video ID</label>
	      <input name="videoCode" placeholder="Video ID"/>
    	</div>
		</div>
  </section>
  <section>
		<p>Your profile is <?php echo $stateMessage ?></p><br/>
	 	<input type="radio" name="activate_deactivate" value="1"> Activate<br>
	 	<input type="radio" name="activate_deactivate" value="0"> Deactivate<br>
  </section>
  <section class="info">
    <p>Caution: You cannot undo any updates! However, expect an import-export feature soon.</p>
  </section>
  <section>
    <button type="submit" name="submit">Update</button>
  </section>
  </form>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
