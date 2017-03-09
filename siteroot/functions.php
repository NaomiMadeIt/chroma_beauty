<?php

//a function to convert ugly timestamps to human friendly dates
function convertTimestamp( $ugly ){
  $date = new DateTime( $ugly );
  return $date->format('l, F jS, Y');
}

//a function to convert ugly timestamps to rss dates
function convertTimeRSS( $ugly ){
  $date = new DateTime( $ugly );
  return $date->format('r');
}

//clean any input string
function clean_string( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted , FILTER_SANITIZE_STRING ));
}

function clean_integer( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted , FILTER_SANITIZE_NUMBER_INT ));
}

function clean_email( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted , FILTER_SANITIZE_EMAIL ));
}
function clean_url( $untrusted ){
    global $db;
    return mysqli_real_escape_string($db, filter_var( $untrusted , FILTER_SANITIZE_URL ));
}
function clean_boolean( $untrusted ){
  if($untrusted != 1){
    $untrusted = 0;
  }
  return $untrusted;
}

// ▼ this below is called a docblock ▼
/**
 * Helper function to display user feedback after parsing a form
 * @param string $feedback  A quick feedback message to the user
 * @param array $errors     A list of any inline field errors
 * @return string           Displays a div containing all the feedback and errors.
 */
function show_feedback( $feedback, $errors = array() ){
  if( isset($feedback) ){
    echo '<div class="feedback">';
    echo $feedback;
    //if there are errors, show them as a list
    if( ! empty($errors) ){
      echo '<ul>';
      foreach ($errors as $error) {
        echo '<li>' . $error . '</li>';
      }
      echo '</ul>';
    }
    echo '</div>';
  }
}

function stock($stock){
  if(1){
    echo 'In Stock';
  }else{
    echo 'Out of Stock';
  }
}

function rating($rating){
  $rating = round($rating);
  switch ($rating) {
    case 1:
      echo "<i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart emptyheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart emptyheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart emptyheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart emptyheart\" aria-hidden=\"true\"></i>";
      break;
    case 2:
      echo "<i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart emptyheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart emptyheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart emptyheart\" aria-hidden=\"true\"></i>";
      break;
    case 3:
      echo "<i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart emptyheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart emptyheart\" aria-hidden=\"true\"></i>";
      break;
    case 4:
      echo "<i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart emptyheart\" aria-hidden=\"true\"></i>";
      break;
    case 5:
      echo "<i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i><i class=\"fa fa-heart fullheart\" aria-hidden=\"true\"></i>";
      break;
    default:
      echo "<span class=\"notrated\">Item not currently rated</span>";
  }
}

function security_check($redirect = false){
  global $db;
  //security check! If the user does not have a valid key, send them back to the login form
  $user_id = $_SESSION['user_id'];
  $security_key = $_SESSION['security_key'];
  $query = "SELECT *
            FROM users
            WHERE user_id = $user_id
            AND security_key = '$security_key'
            LIMIT 1";
  $result = $db->query($query);
  if( $redirect AND !$result ){
    header('Location:login.php?msg=bad_result');
  }

  if( $result->num_rows == 1 ){
    //this person is allowed into the admin panel
    $row = $result->fetch_assoc();
    define('USERNAME', $row['username']);
    define('IS_ADMIN', $row['is_admin']);
    define('USER_ID', $row['user_id']);
  }elseif( $redirect ){
    echo $query;
   header('Location:login.php?msg=no_rows');
  }
} //end security_check

function reccommend($would_rec){
  if($would_rec = 1){
    echo 'I would reccommend this product to a friend.';
  }else{
    echo 'I would not reccommend this product to a friend.';
  }
} //end would_rec

function show_userpic( $user_id, $size ){
	global $db;
	$query = "SELECT user_pic, username
			FROM users
			WHERE user_id = $user_id
			LIMIT 1";
	$result = $db->query($query);
	if( $result->num_rows == 1 ){
		//display the image if it exists, otherwise show the default user_pic
		$row = $result->fetch_assoc();
		if( $row['user_pic'] != '' ){
			echo '<img src="' . ROOT_URL . 'uploads/' . $row['user_pic'] . '_' . $size .
			'.jpg" class="userpic" alt="' . $row['username'] . '\'s user pic">';
		}else{
			echo '<img src="' . ROOT_URL . 'images/default_' . $size . '.jpg" class="userpic" alt="default userpic">';
		}
	}
} //end show user_pic

function show_prodimg( $product_id, $size ){
	global $db;
	$query = "SELECT product_images.image, products.name
			FROM product_images, products
			WHERE product_id = $product_id
			LIMIT 1";
	$result = $db->query($query);
	if( $result->num_rows == 1 ){
		//display the image if it exists, otherwise show the default user_pic
		$row = $result->fetch_assoc();
		if( $row['image'] != '' ){
			echo '<img src="' . ROOT_URL . 'images/' . $row['image'] . '_' . $size .
			'.jpg" class="prodimg" alt="' . $row['name'] . '">';
		}else{
			echo '<img src="' . ROOT_URL . 'images/prod_default_' . $size . '.jpg" class="prodimg" alt="default userpic">';
		}
	}
} //end show_prodimg
