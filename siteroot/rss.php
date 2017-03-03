<?php
//connect to db
require('db-config.php');
include_once('functions.php');

//echo out the XML declaration since the <? characters confuse the PHP parser

echo '<?xml version="1.0" encoding="UTF-8"?>';

//get up to 10 published posts
$query = "SELECT products.name, products.description, products.price, products.in_stock, product_images.image
          FROM products, product_images
          WHERE products.product_id = product_images.product_id
          ORDER BY products.added_date DESC
          LIMIT 10";
// ▲ NOTE! products will not show unless they have an image ▲

//run it
$result = $db->query($query);
//check it
if(!$result){
  die($db->error);
}
?>
<rss version = "2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>ChromaBeauty</title>
    <link>http://localhost/naomi-php/chroma_beauty/siteroot/</link>
    <description>ChromaBeauty is a curated catalogue for those who are in love with color, whose definition of beauty has a bit of an edge. We express ourselves with a bold style that matches our energy. Our style is feminine, dangerous, and fun; A mix of spicy, sweet, and mysterious. Our selection is comprised of top rated, quality products that allows us express ourselves in extraordinary colors and styles.</description>
    <atom:link href="http://localhost/naomi-php/chroma_beauty/siteroot/" rel="self" type="application/rss+xml" />
    <?php while( $row = $result->fetch_assoc() ){ ?>
      <item>
        <title><?php echo $row['name']; ?></title>
        <link></link>
        <guid></guid>
        <pubDate><?php echo convertTimeRSS($row['added_date']); ?></pubDate>
        <description>
          <![CDATA[
            <img src="<?php echo $row['image']; ?>" />
            <br />
            <?php

              echo $row['description'];
            ?>
          ]]></description>
      </item>
    <?php } //end while loop ?>
  </channel>
</rss>
