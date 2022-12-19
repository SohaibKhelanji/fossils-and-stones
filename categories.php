<?php

include 'incs/header.php';
include 'classes/dbh.php';

if (isset($_SESSION['userId']) && $userRole == "user") {
    header("Location: 404.php");
}elseif(!isset($_SESSION['userId'])){
    header("Location: 404.php");
}

$dbh = new Dbh();
?>

<body>

<?php 
include 'incs/navBar.php';
?>


    <div id="admin-products-nav">
    <a href= "products.php" id="admin-nav-producten" class= "admin-products-nav-title" style="opacity: 0.3">Producten</a>
    <a href="categories.php\" id="admin-nav-categorieen" class= "admin-products-nav-title" style="border-bottom: 3px solid #253d84">Categorieën</a>
    </div>
  


<form class="search-bar" methode="post" action="">
    <input id="searchCategory" class="input-search" type="text" name="searchCategory" placeholder="Zoek een product">
    <button type="submit" name="submit-search"><i class="fas fa-search"></i></button>
</form>


<div id="search-results-categories"></div>

<div id= all-categories>


  <div id="add-product">
  <a href="addCategory.php" id="add-product-href"> +<br>Categorie toevoegen</a>
  </div>

<h2 id=categories-title>Categorieën</h2>

<div id="categories-wrapper">
  <?php
    $stmtCategory = $dbh->connection()->prepare("SELECT * FROM product_category ORDER BY category_name ASC");
    $stmtCategory->execute();
    $resultCategory = $stmtCategory->fetchAll();

  foreach ($resultCategory as $row) {
    echo "
    <div class=\"category\">
    <p>$row[category_name]</p>
    <a href=\"editCategory.php?id=$row[category_id]\" style=\"background-color:orange\">Bewerken</a>
    <a href=\"deleteCategory.php?id=$row[category_id]\" style=\"background-color:darkred\">Verwijderen</a>
    </div>
    ";
    
}
    ?>


</div>
</div>



<?php
include 'incs/footer.php';
?>