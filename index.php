<?php 
include 'incs/header.php';
include 'classes/dbh.php';

$dbh = new Dbh();
?>

<body>

<?php 
include 'incs/navBar.php';
?>
<div id="homepage-banner"></div>

<h2 class="homepage-title">Onze producten</h2>

<div id="products-wrapper">
 <?php
$stmt = $dbh->connection()->prepare("SELECT * FROM products INNER JOIN products_categories ON products.product_category = products_categories.category_id INNER JOIN products_images ON products_images.product_id = products.product_id ORDER BY rand() LIMIT 6;");

$stmt->execute();

$result = $stmt->fetchAll();

foreach ($result as $row) {
    echo "
    <div class=\"product\">
    <div class=\"imgbox\">
      <img src=\"imgs/$row[image_name]\">
    </div>
    <div class=\"details\">
      <h2>$row[product_name]<br><span>$row[category_name]</span></h2>
      <div class=\"price\">
      €$row[product_price],-
      </div>
      <a href=\"viewProduct.php?id=$row[product_id]\">Bekijken</a>
    </div>
  </div>
    ";
}

?>

</div>

<div id="more-products">
<a href="products.php" id="more-products-href">Bekijk alle producten</a>
</div>

<?php
include 'incs/footer.php';
?>