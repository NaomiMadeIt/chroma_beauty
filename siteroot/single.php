<?php
  require('db-config.php');
  include_once('functions.php');
  include('header.php');

  //shows what post we're trying to show
  //URL will look like: ../single.php?product_id=X\
  if( isset($_GET['product_id']) ){
    $product_id = $_GET['product_id'];
  }else{
    $product_id = 0;
    //echo 'Product not found.';
  }

  //Parsing the comment form
  if( $POST_['did_comment']){
    //sanitize
    // NOTE! Check if you have to make the $_POST item exactly the same as the one in the db (which most likely is the case)
    $user_id = USER_ID;
  	$title	   = clean_string( $_POST['title'] );
  	$body 	   = clean_string( $_POST['body'] );
  	$rating_one    = clean_integer( $_POST['rating'] );
    $rating_two    = clean_integer( $_POST['rating'] );
    $rating_three    = clean_integer( $_POST['rating'] );
    $rating_four    = clean_integer( $_POST['rating'] );
    $rating_five    = clean_integer( $_POST['rating'] );
  	$would_rec = clean_boolean( $_POST['would_rec'] );


    //validate
    $valid = true;

    //if the title is blank
    if( $title == '' ){
      $valid = false;
      $errors['title'] = 'Please make a title for your review.';
    }

    if( $body == '' ){
      $valid = false;
      $errors['body'] = 'Please tell us how you feel about the product and your personal experiences with it.';
    }

    if( !$rating_one && !$rating_two && !$rating_three && !$rating_four && !$rating_five ){
      $valid = false;
      $errors['body'] = 'Please tell us how you feel about the product and your personal experiences with it.';
    }else{
      // TODO: Check which was rated/chosen
    }

    // TODO: fillout
    if( $valid ){
    $query = "INSERT INTO reviews
              ( title, body, rating, date, user_id, product_id, is_published, would_rec )
              VALUES
              ( '$title', '$body', INPUTSHITHERE, now(), $user_id, $product_id, 1, $would_rec )";
    $result = $db->query($query);

    if( $db->affected_rows == 1 ){
      $status = 'success';
      $message = 'Thank you for reviewing this item!';
    }else{
      $status = 'error';
      $message = 'Database Error';
    }
  }else{
    $status = 'error';
    $message = 'Invalid submission';
  }
} //end of parser
?>
<main>
  <?php
    $query = "SELECT product_images.image, products.name, products.description, products.price, products.in_stock, products.added_date
              FROM products, product_images
              WHERE products.product_id = $product_id
              AND products.product_id = product_images.product_id
              LIMIT 1";
    // echo $query;
    $result = $db->query($query);

    if( $result->num_rows == 1 ){
      while( $row = $result->fetch_assoc() ){
        $query = "SELECT AVG(rating) as rating
                  FROM reviews
                  WHERE product_id = $product_id";
        $result = $db->query($query);
    $row_rating = $result->fetch_assoc();
  ?>
  <article>
    <img src="<?php echo $row['image']; ?>" />
    <h2><?php echo $row['name']; ?></h2>
    <p><?php echo $row['description']; ?></p>
    <p><?php echo stock($row['in_stock']); ?></p>
    <p><?php rating($row_rating['rating']); ?></p>
    <p>$<?php echo $row['price']; ?></p>
  </article>
  <?php } //end while loop
      } //end if one product is found
      else{
        echo 'Sorry, the product you were looking for could not be found or does not exist.';
      }

  //get all approved reviews about THIS product
  $query = "SELECT reviews.title, reviews.body, reviews.rating, reviews.date, reviews.would_rec, users.username
            FROM reviews, users
            WHERE reviews.is_published = 1
            AND reviews.product_id = $product_id
            AND reviews.user_id = users.user_id
            ORDER BY date DESC
            LIMIT 10";
  echo $query;
  $result = $db->query($query);
  if( $result->num_rows >= 1 ){
  ?>
  <section>
    <h2>Recent Reviews for this Product</h2>
    <?php while( $row = $result->fetch_assoc() ) { ?>
      <div>
        <h3><?php echo $row['title']; ?></h3>
        <p><?php echo $row['body']; ?></p>
        <p><?php reccommend($row['would_rec']); ?></p>
        <p>Rating: <?php echo rating($row['rating']); ?></p>
        <div>
          <h4>Reviewed by <?php echo $row['username']; ?></h4>
          <p>on <?php echo convertTimestamp( $row['date'] ); ?></p>
        </div>
      </div>
    <?php } //end while ?>
  </section>
    <?php
      } //end if there are comments
      else {
        echo 'This post does not have any reviews yet.';
      }
    ?>
  <section>
    <h2>Rate This Product</h2>
    <?php
      //user feedback
      show_feedback($message);
    ?>
    <form action"<?php echo $_SERVER['PHP_SELF']; ?>" class="ratingform">
      <label for="review_title">Review Title</label>
      <input type="text" name="title" id="review_title" />

      <label for="review_body">Write Your Review Here</label>
      <textarea type="text" name="review" id="review_body"></textarea>

      <label>
        <input type="radio" name="rating_one" value="1"<?php //if($rating >= 1){ echo 'class="filled"';} ?>/><span>1</span>
      </label>
      <label>
        <input type="radio" name="rating_two" value="2"/><span>2</span>
      </label>
      <label>
        <input type="radio" name="rating_three" value="3"/><span>3</span>
      </label>
      <label>
        <input type="radio" name="rating_four" value="4"/><span>4</span>
      </label>
      <label>
        <input type="radio" name="rating_five" value="5"/> 5
      </label>

      <div>
        <input type="checkbox" name="wouldrec" id="wouldrec" value="1" />
        <label for="wouldrec">Would you reccommend this product to a friend?</label>
      </div>

      <input type="submit" value="Post Review" />
      <input type="hidden" name="did_review" value="true" />
    </form>
  </section>
</main>
<?php
  include('footer.php');
?>
