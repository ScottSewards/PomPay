<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/profile-code.php");
$title = "$profileUsername";
include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/navigation.php");

if((isset($userPasswordCookie)) AND (isset($userIDCookie))) { //SIGNED-IN

} else { //SIGNED-OUT
	header("location: sign-in.php");
}
?>
<main id="editor">
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
          <input type="url" name="twitter" placeholder="@pompay" value="<?php echo $socialLinksTwitter ?>"/>
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
        <input name="videoCode" placeholder="Video ID" value=""/>
      </div>
		</div>
  </section>
  
  <!--
  <section>
		<h1>Activate Profile</h1>
		<p>Your profile is <?php echo $stateMessage ?></p><br/>
		<div class="fields">
			<div class="field">
				<label for="activate_deactivate">Activate</label>
				<input type="radio" name="activate_deactivate" value="1"/>
			</div>
			<div class="field">
				<label for="activate_deactivate">Deactivate</label>
				<input type="radio" name="activate_deactivate" value="0" checked/>
			</div>
		</div>
  </section>
  -->
  
  
  
  <section>
    <button type="submit" name="submit">Update My Profile</button>
  </section>
  </form>
</main>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/Pompay/footer.php"); ?>
