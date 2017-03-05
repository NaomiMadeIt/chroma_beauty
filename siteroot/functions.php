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
