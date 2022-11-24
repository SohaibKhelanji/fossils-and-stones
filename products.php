<?php 
include 'incs/header.php';
include 'classes/dbh.php';

$dbh = new Dbh();
?>

<body>

<?php 
include 'incs/navBar.php';
?>

<form class="search-bar" methode="post" action="">
    <input id="search" class="input-search" type="text" name="search" placeholder="Zoek een product">
    <button type="submit" name="submit-search"><i class="fas fa-search"></i></button>
</form>


<div id="search-results"></div>

<div id= all-products>

<?php 
$stmtCategory = $dbh->connection()->prepare("SELECT * FROM products_categories ORDER BY rand()");
$stmtCategory->execute();
$resultCategory = $stmtCategory->fetchAll();


foreach ($resultCategory as $category) {
    echo "<div class=\"products-wrapper-category\">";
    echo "<h2 class=\"category-title\">$category[category_name]</h2>";

    $stmt = $dbh->connection()->prepare("SELECT * FROM products INNER JOIN products_categories ON products.product_category = products_categories.category_id INNER JOIN products_images ON products_images.product_id = products.product_id WHERE product_category = $category[category_id] ORDER BY rand();");

    $stmt->execute();

    $result = $stmt->fetchAll();

    echo "<div id=\"products-wrapper\">";
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
        <a href=\"#\">Bekijken</a>
      </div>
     </div>
   ";
    }
    echo "</div>";
    echo "</div>";

}

?>

</div>



<?php
include 'incs/footer.php';
?>