<?php
  require('db-config.php');
  include_once('functions.php');
  security_check();
  include('header.php');
?>
<main>
<section>
  <h2>Most Recent Products</h2>
  <?php
    //put query here
  ?>
</section>
<section>
  <h2>Highest Rated</h2>
  <?php
    $query = "SELECT products.name, products.description, products.price, product_images.image, AVG(reviews.rating) AS rating
              FROM products, reviews, product_images
              WHERE products.product_id = reviews.product_id
              GROUP BY reviews.product_id
              ORDER BY rating DESC
              LIMIT 6";
    $result = $db->query($query);
    if($result->num_rows >= 1){
      while( $row = $result->fetch_assoc()){
    ?>

    <a href="single.php?product_id=<?php echo $row['product_id']; ?>"><img src="<?php echo $row['image']; ?>" /></a>
    <figcaption>
      <h3><a href="single.php?product_id=<?php echo $row['product_id']; ?>"><?php echo $row['name']; ?></a></h3>
      <p><?php rating($row['rating']); ?></p>
      <p>$<?php echo $row['price']; ?></p>
      <p><?php echo stock($row['in_stock']); ?></p>
    </figcaption>
  </figure>

    <?php
      } // end while loop
    } //end if products

  ?>
</section>
</main>
<?php
  include('footer.php');
?>
