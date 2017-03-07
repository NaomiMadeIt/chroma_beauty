<?php
  require('db-config.php');
  include_once('functions.php');
  include('header.php');
  include('sidebar.php');

  //pagination configuration
  $per_page = 10;
  //start on page 1
  $current_page = 1;
?>
<main>
  <?php
    $query = "SELECT products.product_id, product_images.image, products.name, reviews.rating, products.price, products.added_date
              FROM products, product_images, reviews
              WHERE products.product_id = product_images.product_id
              AND products.product_id = reviews.product_id
              ORDER BY products.added_date DESC";
    // echo $query;
    $result = $db->query($query);
    //  echo "number of rows:" . $result->num_rows;

    //how many posts were found?
    $total_products = $result->num_rows;

    //check to see if the result has rows (products)
    if( $result->num_rows >= 1 ){
      //how many pages needed to hold all results?
      $total_pages = ceil( $total_products / $per_page );

      //what page is the user trying to view?
      //URL will look like products.php?page=2
      //if the ?page variable is not set, keep it at 1
      if( $_GET['page'] ){
        $current_page = $_GET['page'];
      }
      //make sure they are viewing a valid page
      if( $current_page <= $total_pages ){
        echo "<h3>Showing page $current_page of $total_pages</h3>";

        //modify the original query to get the right subset of results
        $offset = ($current_page - 1) * $per_page;
        $query = $query . " LIMIT $offset, $per_page";

        $result = $db->query($query);

        //tells me exactly where the issue is
        if(! $result ){
          echo $db->error;
        }
        while( $row = $result->fetch_assoc() ){
  ?>
  <figure>
    <a href="single.php?product_id=<?php echo $row['product_id']; ?>"><img src="<?php echo $row['image']; ?>" /></a>
    <figcaption>
      <h3><a href="single.php?product_id=<?php echo $row['product_id']; ?>"><?php echo $row['name']; ?></a></h3>
      <p><?php rating($row['rating']); ?></p>
      <p>$<?php echo $row['price']; ?></p>
      <p><?php echo stock($row['in_stock']); ?></p>
    </figcaption>
  </figure>
  <?php } //end while loop

      $prev = $current_page - 1;
      $next = $current_page + 1;
  ?>
  <div>
    <?php
      if( $current_page != 1 ){
    ?>
    <a href="search.php?keywords=<?php echo $keywords; ?>&amp;page<?php echo $prev; ?>">Previous Page</a>
    <?php } ?>

    <?php
      if( $current_page < $total_pages ){
    ?>
    <a href="search.php?keywords=<?php echo $keywords; ?>&amp;page=<?php echo $next; ?>">Next Page</a>
    <?php } ?>
  </div>
<?php } //end if valid page
      else{
        show_feedback('Invalid page');
      }
    } //end if there are products
    else{
    show_feedback('Sorry, there are no products to show.');
    }
?>
</main>
<?php
  include('footer.php');
?>
