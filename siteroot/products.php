<?php
  require('db-config.php');
  //use _once on function definitions to prevent duplicates
  include_once('functions.php');
  //get the doctype and header area
  include('header.php');
?>
<main>
  <?php
    $query = "SELECT products.product_id, product_images.image, products.name, reviews.rating, products.price, products.added_date
              FROM products, product_images, reviews
              WHERE products.product_id = product_images.product_id
              AND products.product_id = reviews.product_id
              ORDER BY products.added_date DESC
              LIMIT 10";
    // echo $query;
    $result = $db->query($query);

    if( $result->num_rows >= 1 ){
      while( $row = $result->fetch_assoc() ){
  ?>
  <figure>
    <img src="<?php echo $row['image'] ?>" />
    <figcaption>
      <h3><a href="single.php?product_id=<?php echo $row['product_id']; ?>"><?php echo $row['name'] ?></a></h3>
      <p><?php rating($row['rating']); ?></p>
      <p><?php echo $row['price']; ?></p>
      <p><?php echo stock($row['in_stock']); ?></p>
    </figcaption>
  </figure>
  <?php } //end while loop
} //end if there are products ?>
</main>
<?php
  include('footer.php');
?>
