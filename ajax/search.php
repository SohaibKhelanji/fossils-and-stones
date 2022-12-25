<?php 
session_start();
if (isset($_SESSION['userId'])) {
    $userRole = $_SESSION['userRole'];
}
include '../classes/dbh.php';

$dbh = new Dbh();

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $dbh->connection()->prepare("SELECT * FROM product INNER JOIN product_category ON product.product_category = product_category.category_id INNER JOIN product_image ON product_image.product_id = product.product_id WHERE product_name LIKE '%$search%' OR category_name LIKE '%$search%' ORDER BY rand();");
    $stmt->execute();
    $result = $stmt->fetchAll();
    echo "<h2 class=\"search-title\">Zoekresultaten voor: <span>$search</span></h2>";
    echo "<div id=\"products-wrapper\">";
    if ($result) {
    foreach ($result as $row) {
      if (isset($_SESSION['userId']) && $userRole == "admin") {
        if (($row['product_quantity'] < 1) || ($row['product_availability'] != "true")) {
          echo "
            <div class=\"product\">
            <div class=\"imgbox\">
            <filter style=\"filter: grayscale(100%);\">
              <img src=\"imgs/$row[image_name]\">
            </filter>
            </div>
             <div class=\"detailsAdmin\">
               <h2>$row[product_name]</h2>
               <div class=\"price\">
               €$row[product_price],-
               </div>
               <a href=\"viewProduct.php?id=$row[product_id]\">Bekijken</a>
               <a href=\"editProduct.php?id=$row[product_id]\" style=\"background-color:orange\">Bewerken</a>
               <a href=\"deleteProduct.php?id=$row[product_id]\" style=\"background-color:darkred\">Verwijderen</a>
             </div>
             </div>";
        } else {
          echo "
              <div class=\"product\">
              <div class=\"imgbox\">
                <img src=\"imgs/$row[image_name]\">
              </div>
               <div class=\"detailsAdmin\">
                 <h2>$row[product_name]</h2>
                 <div class=\"price\">
                 €$row[product_price],-
                 </div>
                 <a href=\"viewProduct.php?id=$row[product_id]\">Bekijken</a>
                 <a href=\"editProduct.php?id=$row[product_id]\" style=\"background-color:orange\">Bewerken</a>
                 <a href=\"deleteProduct.php?id=$row[product_id]\" style=\"background-color:darkred\">Verwijderen</a>
               </div>
               </div>";
        }
      } elseif (($row['product_quantity'] > 0) && ($row['product_availability'] != "false")) {
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
             </div>";
      }elseif ((($row['product_quantity'] < 1) || ($row['product_availability'] != "true"))) {
        echo "
        <div id=\"no-results\">
            <h2>Geen resultaten gevonden</h2>
            <p>Probeer het opnieuw met een andere zoekterm</p>
        </div>
            ";
      }
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
