<?php
  require('db-config.php');
  include_once('functions.php');
  include('header.php');

  //shows what post we're trying to show
  //URL will look like: ../single.php?_product_id=X\
  if( isset($_GET['product_id']) ){
    $product_id = $GET_['product_id'];
  }else{
    $product_id = 0;
  }
?>
<main>
  <?php
    $query = "SELECT product_images.image, products.name, products.description, products.price, products.in_stock, products.added_date
              FROM products, product_images
              WHERE products.product_id = $product_id
              AND products.prodimg_id = product_images.prodimg_id
              LIMIT 1";
    // echo $query;
    $result = $db->query($query);

    if( $result->num_rows >= 1 ){
      while( $row = $result->fetch_assoc() ){
  ?>
  <article>
    <img src="<?php echo $row['image']; ?>" />
    <h2><?php echo $row['name']; ?></h2>
    <p><?php echo $row['description']; ?></p>
    <p><?php echo $stock; ?></p>
    <p>$<?php echo $row['price']; ?></p>

  </article>
  <?php } //end while loop ?>
  <?php } //end if one product is found ?>
</main>
<?php
  include('footer.php');
?>
