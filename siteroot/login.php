<?php
  require('login-parser.php');

  //get the doctype and header area
  include('header.php');
?>
<main>
  <h1>Log In to Your Account</h1>

  <?php echo $feedback; ?>

  <form method="post" action="login.php">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" />

    <label>Password</label>
    <input type="password" name="password" />
    <input type="submit" value="Log In" />
    <input type="hidden" name="did_login" value="true" />
  </form>

</main>
<?php
  include('footer.php');
?>
