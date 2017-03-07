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
  <div>
    <h3>Rate This Product</h3>
    <form>
      <label for="review_title">Review Title</label>
      <input type="text" name="title" id="review_title" />

      <label for="review_body">Write Your Review Here</label>
      <textarea type="text" name="review" id="review_body"></textarea>

      <label>
        <input type="radio" name="rating" value="1"/> 1
      </label>
      <label>
        <input type="radio" name="rating" value="2"/> 2
      </label>
      <label>
        <input type="radio" name="rating" value="3"/> 3
      </label>
      <label>
        <input type="radio" name="rating" value="4"/> 4
      </label>
      <label>
        <input type="radio" name="rating" value="5"/> 5
      </label>

      <div>
        <input type="checkbox" name="wouldrec" id="wouldrec" value="1" />
        <label for="wouldrec">Would you reccommend this product to a friend?</label>
      </div>

      <input type="submit" value="Post Review" />
      <input type="hidden" />
    </form>
  </div>
  <?php } //end while loop ?>
  <?php } //end if one product is found
  else{
    echo 'Sorry, the product you were looking for could not be found or does not exist.';
  } ?>
</main>
<?php
  include('footer.php');
?>
