<?php
  require('db-config.php');
  include_once('functions.php');
  security_check(true);
  include('header.php');

  include('editprofile-parser.php');

  $user_id = USER_ID;
  $query = "SELECT username, password, email, fname, lname, bio, user_pic
            FROM users
            WHERE user_id = $user_id";
  $result = $db->query($query);

  if($result->num_rows == 1){
    $row = $result->fetch_assoc();

    $username = $row['username'];
    $password = $row['password'];
    $email    = $row['email'];
    $fname    = $row['fname'];
    $lname    = $row['lname'];
    $bio      = $row['bio'];
    $user_pic = $row['user_pic'];
  }
?>
<main>
  <section>
    <h2>Edit Profile</h2>
    <?php show_feedback($message); ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

      <!-- TODO: EDIT IMAGE HERE -->

      <label for="username">Username</label>
      <input type="text" name="username" id="username" value="<?php echo $username; ?>" />

      <label for="password">Password</label>
      <input type="text" name="password" value="<?php echo $password; ?>" />

      <label for="">Email</label>
      <input type="text" name="" value="<?php echo $email; ?>" />

      <label for="fname">First Name</label>
      <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>" />

      <label for="lname">Last Name</label>
      <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>" />

      <label for="bio">Bio</label>
      <textarea type="text" name="bio" for="bio"><?php echo $bio; ?></textarea>

      <input type="submit" name="submit" value="Update Profile" />
      <input type="hidden" name="did_update" value="true" />
    </form>
    <a href='profile.php'>Return to Your Profile</a>
    <p class="subtext">Returning to your profile will not save your current changes. If you made any changes, please use the button above to save them.</p>
  </section>
</main>
<?php
  include('footer.php');
?>
