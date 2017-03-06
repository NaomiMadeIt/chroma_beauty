<?php
  require('db-config.php');
  include_once('functions.php');
  include('header.php');

  //extract the keywords that the user is searching for
  $keywords = clean_string( $_GET['keywords']);

  //pagination configuration
  $per_page = 10;
  //start on page 1
  $current_page = 1;
?>
<main>
  <?php
    //Get all the published posts that contain the keywords in their title or body
    $query = "SELECT DISTINCT products.name, products.description, categories.cat_name
              FROM products, categories, product_categories
              WHERE products.product_id = product_categories.product_id
              AND categories.category_id = product_categories.category_id
              AND ( products.name LIKE '%$keywords%' OR products.description LIKE '%$keywords%' OR categories.cat_name LIKE '%$keywords%' )";
    // echo $query;
    //run the query. catch the returned info in a result
    $result = $db->query($query);

    //how many posts were found?
    $total_products = $result->num_rows;

    //check to see if the result has rows (products)
    if( $result->num_rows >= 1 ){
      //how many pages needed to hold all results?
      $total_pages = ceil( $total_products / $per_page );

      //what page is the user trying to view?
      //URL will look like search.php?keyword=stuff&page=2
      //if the ?page variable is not set, keep it at 1
      if( $_GET['page'] ){
        $current_page = $_GET['page'];
      }
      //make sure they are viewing a valid page
      if( $current_page <= $total_pages ){
        echo "<h2>Search Results for $keywords.</h2>";
        echo "<h3>Showing page $current_page of $total_pages</h3>";

        //modify the original query to get the right subset of results
        $offset = ($current_page - 1) * $per_page;
        $query = $query . "LIMIT $offset, $per_page";

        $result = $db->query($query);

        //loop through each row found, displaying the article each time
        while( $row = $result->fetch_assoc() ){
    ?>
    <article>
      <h2>
        <a href="single.php?product_id=<?php echo $row['product_id']; ?>">
              <?php echo $row['name']; ?>
        </a>
      </h2>
      <p><?php echo $row['description']; ?></p>
    </article>
  <?php
        } //end while there are posts

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
  <?php
      } //end if the user is on a valid page
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
