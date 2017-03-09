<?php
  if($_POST['did_update']){

    $user_id = USER_ID;

    //sanitize
    $username = clean_string( $_POST['title'] );
    $password = clean_string( $_POST['title'] );
    $email    = clean_email( $_POST['title'] );
    $fname    = clean_string( $_POST['title'] );
    $lname    = clean_string( $_POST['title'] );
    $bio      = clean_string( $_POST['title'] );
    $user_pic = clean_string( $_POST['title'] );

    //validate
    $valid = true;
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
      // TODO! Check logic on password to make sure that when the password already set, it does not get re-sha1'd
      // TODO! Make it so that the new password gets Sha1'd
      $query = "UPDATE users
                SET
                username = '$username',
                password = '$password',
                email    = '$email',
                fname    = '$fname',
                lname    = '$lname',
                bio      = '$bio',
                user_pic = '$user_pic'";
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