<?php

  require('db-config.php');
  //use _once on function definitions to prevent duplicates
  include_once('functions.php');
  //get the doctype and header area
  include('user_loggedin.php');
  include('header.php');
?>
<main>
  <h2>You've entered the secret page! Lucky you.</h2>
  <img src="http://cdn0.dailydot.com/uploaded/images/original/2017/2/20/whiguyblink.gif" />
  <a href="login.php?action=logout">Log TF Out</a>
</main>
<?php
  include('footer.php');
?>
