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
    $stmt = $dbh->connection()->prepare("SELECT * FROM product INNER JOIN product_category ON product.product_category = product_category.category_id INNER JOIN product_image ON product_image.product_id = product.product_id WHERE product_availability = 'true' AND product_quantity > 0 ORDER BY rand() LIMIT 12;");

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