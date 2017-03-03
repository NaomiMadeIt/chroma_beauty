<?php
  require('db-config.php');
  //use _once on function definitions to prevent duplicates
  include_once('functions.php');

  //begin parser
  if( $_POST['did_register']){
    //sanitize everything
    $username = clean_string( $_POST['username'] );
    $email = clean_email( $_POST['email'] );
    $password = clean_string( $_POST['password'] );
    $policy = clean_integer( $_POST['policy'] );
    //validate
    $valid = 1;
      //username wrong length
      if( strlen($username) < 4 OR strlen($username) > 50 ){
        $valid = 0;
        $errors['username'] = 'Choose a username between 5 and 50 characters long.';
      }else{
        //username already taken
        $query = "SELECT username
                  FROM users
                  WHERE username = '$username'
                  LIMIT 1";
        $result = $db->query($query);
        if( $result->num_rows == 1 ){
          $valid = 0;
          $error['username'] = 'Sorry, that username is already in use. Please pick another.';
        }
      }
      //password wrong length
      if( strlen($password) < 8 ){
        $valid = 0;
        $errors['password'] = 'Your password needs to be at least 8 characters.';
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
                  LIMIT 1";
        $result = $db->query($query);
        if($result->num_rows == 1){
          $valid = 0;
          $errors['email'] = 'That email already registered with us. Would you like to <a href="login.php">log in</a> instead?';
        }
      }

      //policy box not checked
      if( $policy != 1 ){
        $valid = 0;
        $error['policy'] = 'You must agree to our terms of service and privacy policy before signing up.';
      }
      //if valid, add the user to the users table!
      if($valid){
        $password = sha1($password . SALT);
        $query = "INSERT INTO users
                  ( username, password, email, is_admin, is_approved, signup_date )
                  VALUES
                  ( '$username', '$password', '$email', 0, 0, now() )";
        $result = $db->query($query);
        //if it worked, tell them to wait for confirmation. redirect to login
        if( $db->affected_rows == 1){
          $feedback = 'You are now signed up! As soon as you are approved by an admin, you can log in.';
        }else{
          //if it failed, show user feedback
          $feedback = 'Sorry, you account could not be created. Please try again later.';
        }
      } //end if valid
      else{
        $feedback = 'There are errors in the form. Please fix them and try again.';
      }
  } //end parser

  //get the doctype and header area
  include('header.php');
?>
<main>
  <h2>Create an Account</h2>
  <?php show_feedback( $feedback, $errors ); ?>

  <form action="register.php" method="post">
    <label for="username">Pick a Username</label>
    <input type="text" name="username" id="username" />
    <span class="hint">Between 5-50 characters</span>

    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" />

    <label for="password">Make a Password</label>
    <input type="password" name="password" id="password" />
    <span>At least 8 characters long</span>

    <label>
        <input type="checkbox" name="policy" value="1">
        I agree to the
        <a href="tos.php" target="_blank">terms of service and privacy policy</a>.
      </label>

      <input type="submit" value="Sign Up" />
      <input type="hidden" name="did_register" value="1" />
  </form>
</main>
<?php
  include('footer.php');
?>
