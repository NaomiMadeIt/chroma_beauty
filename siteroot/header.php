<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ChromaBeauty About Us</title>
    <!-- TODO: ADD RESET -->
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link href="https://fonts.googleapis.com/css?family=Boogaloo|Nunito:400,400i,700,700i|Pacifico" rel="stylesheet">
    <script src="https://use.fontawesome.com/8e339bb4b9.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="alternate" type="application/rss+xml" href="rss.php">
    <meta name=viewport content="width=device-width, initial-scale=1">
  </head>
  <body>
    <header>
      <div class="headtop">
        <a href="index.php"><h1><span class="chroma">CHROMA</span><span class="beauty">Beauty</span></h1></a>
        <div class="accountbox">
        <?php if(!defined('USER_ID')){ ?>
          <a href="login.php">Login</a> / <a href="register.php">Sign Up</a>
        <?php
          } // close if not logged in
          else{
            $user_id = USER_ID;
            $query = "SELECT username
                      FROM users
                      WHERE user_id = $user_id
                      LIMIT 1";
            $result = $db->query($query);
            if($result->num_rows == 1 ){
              $row = $result->fetch_assoc();
        ?>
          <a href="profile.php"><?php echo $row['username']; ?></a><span class="tinypic"><?php echo show_userpic($user_id,'small'); ?></span> / <a href="login.php?action=logout">Log Out</a>

        <?php } } //end if logged in ?>
        </div>
      </div>
      <div>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="about.php">About Us</a></li>
        </ul>
        <form action="search.php" method="get">
          <label for="keywords">Search:</label>
          <input type="search" name="keywords" id="keywords" />
          <input type="submit" value="Find" />
        </form>
      </div>
    </header>
