<?php
session_start();
error_reporting( E_ALL & ~E_NOTICE );
//security check! If the user does not have a valid key, send them back to the login form
$user_id = $_SESSION['user_id'];
$security_key = $_SESSION['security_key'];
$query = "SELECT *
          FROM users
          WHERE user_id = $user_id
          AND security_key = '$security_key'
          LIMIT 1";
$result = $db->query($query);
if( !$result ){
  header('Location:login.php?msg=bad_result');
}

if( $result->num_rows == 1 ){
  //this person is allowed into the admin panel
  $row = $result->fetch_assoc();
  define('USERNAME', $row['username']);
  define('IS_ADMIN', $row['is_admin']);
  define('USER_ID', $row['user_id']);
}else{
  echo $query;
 header('Location:login.php?msg=no_rows');
}
