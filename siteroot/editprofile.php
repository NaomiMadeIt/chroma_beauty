<?php
  require('db-config.php');
  include_once('functions.php');
  security_check(true);
  include('header.php');


    //begin did_upload parser
    if($_POST['did_upload']){
      //where is the uploads directory?
      $upload_path = 'uploads';

      //create a list of image sizes (max width in px)
      $sizes = array (
        'small'   => 50,
        'medium'  => 100,
        'large'   => 200,
      );

      //extra the image that was uploaded
      $uploadedfile = $_FILES['uploadedfile']['tmp_name'];

      //validate = make sure it has pixels
      list($width, $height) = getimagesize($uploadedfile);
      if( $width > 0 AND $height > 0){
        //what MIME type of image is it?
        $filetype = $_FILES['uploadedfile']['type'];
        switch( $filetype ){
          case 'image/gif':
            $source = imagecreatefromgif($uploadedfile);
          break;

          case 'image/jpeg':
          case 'image/pjpeg':
          case 'image/jpg':
            $source = imagecreatefromjpeg($uploadedfile);
          break;

          case 'image/png':
            ini_set( 'memory_limit', '16M' );
            $source = imagecreatefrompng($uploadedfile);
            ini_restore( 'memory_limit' );
          break;
          default:
            $message = 'Please upload an image that is a .gif, .png, or .jpeg';
        } //end switch

        //resize the image
        $uniquestring = sha1(microtime());
        foreach ($sizes as $name => $pixels) {
          if( $width < $pixels ){
            //keep the original size if the image is too small
            $new_width = $width;
            $new_height = $height;
          }else{
            //calculations to preserve the original aspect ratio
            $new_width = $pixels;
            $new_height = ( $new_width * $height ) / $width;
          }
          //create a new blank file at the correct size
          $tmp_canvas = imagecreatetruecolor($new_width, $new_height);

          imagecopyresampled($tmp_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

          $filename = $upload_path . '/' . $uniquestring . '_' . $name . '.jpg';
          $did_save = imagejpeg($tmp_canvas, $filename, 90);
        } //end foreach

        //if it saved the image, add the unique string to the DB
        if( $did_save ){
          //DELETE OLD FILE
            //look up the old image name
            $query_oldfile = "SELECT user_pic
                              FROM users
                              WHERE user_id = " . USER_ID . "LIMIT 1";
            $result_oldfile = $db->query($query_oldfile);
            if($result_oldfile->num_rows == 1){
              $row_oldfile = $result_oldfile->fetch_assoc();
              //delete old files
              foreach ( $sizes as $size_name => $size_width ){
                $old_file = ROOT_PATH . '/uploads/' . $row_oldfile['userpic'] . '_' . $size_name . '.jpg';
                //Delete the file from the directory with unlink()
                @unlink($old_file);
              } //end foreach
            } // END DELETE OLD FILE

          $user_id = USER_ID;
          $query = "UPDATE users
                    SET user_pic = '$uniquestring'
                    WHERE user_id = $user_id";
          $result = $db->query($query);
          if( $db->affected_rows == 1 ){
            $message = 'Success! Your Profile Picture has been updated!';
          }else{
            $message = 'Sorry, your user pic could not be saved to the database.';
          }
        } //end if did_save
        else{
          $message = 'Sorry, the picture you tried to upload did not save.';
        }
      } //end if $width, $height validator
      else{
        $message = 'Sorry, the image you tried to upload contains no pixels.';
      }
    } //end did_upload parser

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

  $query = "SELECT user_id, username, email, fname, lname, bio
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

    <h3>Current Profile Picture</h3>
    <?php show_userpic($row['user_id'],'large'); ?>

    <h3>Change Current Profile Picture</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
    enctype="multipart/form-data">
      <label>Upload Image</label>
      <input type="file" name="uploadedfile" />

      <input type="submit" name="changeprofilepic" value="Upload" />
      <input type="hidden" name="did_upload" value="1" />
    </form>

    <h3>Edit Profile Information</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
  </section>
</main>
<?php
  include('footer.php');
?>
