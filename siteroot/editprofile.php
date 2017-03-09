<?php
  require('db-config.php');
  include_once('functions.php');
  security_check(true);
  include('header.php');

    //start did_update parser
    if($_POST['did_update']){

      $user_id = USER_ID;

      //sanitize
      $username = clean_string( $_POST['username'] );
      $email    = clean_email( $_POST['email'] );
      $fname    = clean_string( $_POST['fname'] );
      $lname    = clean_string( $_POST['lname'] );
      $bio      = clean_string( $_POST['bio'] );

      //validate
      $valid = 1;
        //username is wrong length
        if( strlen($username) < 4 OR strlen($username) > 50 ){
          $valid = 0;
          $errors['username'] = 'Choose a username between 5 and 50 characters long.';
        }else{
          //username already taken
          $query = "SELECT username
                    FROM users
                    WHERE username = '$username'
                    AND user_id != $user_id
                    LIMIT 1";
          $result = $db->query($query);
          if( $result->num_rows == 1 ){
            $valid = 0;
            $error['username'] = 'Sorry, that username is already in use. Please pick another.';
          }
        }
        //email bad format
        if( ! filter_var($email, FILTER_VALIDATE_EMAIL ) ){
          $valid = 0;
          $errors['email'] = 'Please provide a valid email';
        }else{
          //email already taken
          $query = "SELECT email
                    FROM users
                    WHERE email = '$email'
                    AND user_id != $user_id
                    LIMIT 1";
          $result = $db->query($query);
          if($result->num_rows == 1 ){
            $valid = 0;
            $errors['email'] = 'That email already registered with us to another user.';
          }
        }
      //if valid, update the database
      if($valid){
        $query = "UPDATE users
                  SET
                  username = '$username',
                  email    = '$email',
                  fname    = '$fname',
                  lname    = '$lname',
                  bio      = '$bio'
                  WHERE user_id = $user_id";
        $result = $db->query($query);
        if( $db->affected_rows == 1 ){
          //show user feedback
          $feedback = 'Success! Your post was saved.';
        }else{
          $feedback = 'No changes were made.';
        } //end if row added
      }else{
        $feedback = 'Please fix the errors in the form.';
      }
    } //end if did update

  $query = "SELECT username, email, fname, lname, bio
            FROM users
            WHERE user_id = $user_id";
  $result = $db->query($query);

  if($result->num_rows == 1){
    $row = $result->fetch_assoc();

    $username = $row['username'];
    $email    = $row['email'];
    $fname    = $row['fname'];
    $lname    = $row['lname'];
    $bio      = $row['bio'];
    // $user_pic = $row['user_pic'];
  }
?>
<main>
  <section>
    <h2>Edit Profile</h2>
    <?php show_feedback($feedback,$errors); ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

      <!-- TODO: EDIT IMAGE HERE -->

      <label for="username">Username</label>
      <input type="text" name="username" id="username" value="<?php echo $username; ?>" />

      <label for="">Email</label>
      <input type="text" name="email" value="<?php echo $email; ?>" />

      <label for="fname">First Name</label>
      <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>" />

      <label for="lname">Last Name</label>
      <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>" />

      <label for="bio">Bio</label>
      <textarea type="text" name="bio" for="bio"><?php echo $bio; ?></textarea>

      <input type="submit" name="submit" value="Update Profile" />
      <input type="hidden" name="did_update" value="1" />
    </form>
    <a href='profile.php'>Return to Your Profile</a>
    <p class="subtext">Returning to your profile will not save your current changes.</p>
  </section>
</main>
<?php
  include('footer.php');
?>
