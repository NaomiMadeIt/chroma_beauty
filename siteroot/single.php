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
    $query = "SELECT product_images.image, products.name, products.description, products.price, products.in_stock, products.added_date, reviews.rating
              FROM products, product_images, reviews
              WHERE products.product_id = $product_id
              -- AND products.prodimg_id = product_images.prodimg_id
              -- ▲ NOTE: line makes some not work, is it even necessary? Ask Melissa. May need to remove it from table all together. ▲
              AND products.product_id = reviews.product_id
              LIMIT 1";
    // echo $query;
    $result = $db->query($query);

    if( $result->num_rows == 1 ){
      while( $row = $result->fetch_assoc() ){
  ?>
  <article>
    <img src="<?php echo $row['image']; ?>" />
    <h2><?php echo $row['name']; ?></h2>
    <p><?php echo $row['description']; ?></p>
    <p><?php echo stock($row['in_stock']); ?></p>
    <p><?php rating($row['rating']); ?></p>
    <p>$<?php echo $row['price']; ?></p>

  </article>
  <?php } //end while loop ?>
  <?php } //end if one product is found
  else{
    echo 'Sorry, the product you were looking for could not be found or does not exist.';
  } ?>
</main>
<?php
  include('footer.php');
?>
