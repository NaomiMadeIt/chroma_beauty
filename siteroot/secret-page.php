<?php
//begin or resume the session
session_start();
//if the cookie is still valid, re-create the session
if ( $_COOKIE['logged-in-cookie'] ) {
     $_SESSION['logged-in-session'] = true;
}
//security!
if ( ! $_SESSION['logged-in-session'] ) {
     //send them back to hell!
     header('location:login.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Secret Page</title>
  </head>
  <body>
    <h1>You have unlocked the secret page. Fucker.</h1>

    <a href="login.php?action=logout">Log Out</a>
  </body>
</html>
