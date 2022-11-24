<?php 
include '../classes/dbh.php';

$dbh = new Dbh();

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $dbh->connection()->prepare("SELECT * FROM products INNER JOIN products_categories ON products.product_category = products_categories.category_id INNER JOIN products_images ON products_images.product_id = products.product_id WHERE product_name LIKE '%$search%' OR category_name LIKE '%$search%' ORDER BY rand();");
    $stmt->execute();
    $result = $stmt->fetchAll();
    echo "<h2 class=\"search-title\">Zoekresultaten voor: <span>$search</span></h2>";
    echo "<div id=\"products-wrapper\">";
    if ($result) {
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
    } else {
        echo "
        <div id=\"no-results\">
            <h2>Geen resultaten gevonden</h2>
            <p>Probeer het opnieuw met een andere zoekterm</p>
        </div>
            ";
    }
}
?>