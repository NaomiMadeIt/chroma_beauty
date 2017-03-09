<?php
  require('db-config.php');
  include_once('functions.php');
  security_check(true);
  include('header.php');

  $user_id = USER_ID;

  $query = "SELECT username, email, fname, lname, bio, user_pic, signup_date
            FROM users
            WHERE user_id = $user_id
            LIMIT 1";
  $result = $db->query($query);
  if($result->num_rows == 1) {
    $row = $result->fetch_assoc()
?>
<main>
  <h2><?php echo $row['username']; ?>'s Profile</h2>
  <?php echo show_userpic($user_id,'large'); ?>
  <ul>
    <li>Username: <?php echo $row['username']; ?></li>
    <li>Email: <?php echo $row['email']; ?></li>
    <li>First Name: <?php echo $row['fname']; ?></li>
    <li>Last Name: <?php echo $row['lname']; ?></li>
    <li>Bio: <p><?php echo $row['bio']; ?></p></li>
    <li>Been a User Since: <?php echo convertTimestamp($row['signup_date']); ?></li>
  </ul>
  <a href="editprofile.php" class="button">Edit Profile</a>
</main>
<?php
  } //end if there is user
  else{
    echo 'Sorry, profile could not be found.';
  }
  include('footer.php');
?>
