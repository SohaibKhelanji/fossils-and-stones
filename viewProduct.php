<?php 
include 'incs/header.php';
include 'classes/dbh.php';

$dbh = new Dbh();

?>
<body>
<?php 
include 'incs/navBar.php';
?>

<?php
$id = $_GET['id'];
$stmt = $dbh->connection()->prepare("SELECT * FROM products INNER JOIN products_categories ON products.product_category = products_categories.category_id INNER JOIN products_images ON products_images.product_id = products.product_id WHERE products.product_id = $id;");

$stmt->execute();

$result = $stmt->fetchAll();

$rowCount = $stmt->rowCount();

if (!$rowCount < 1) {

    foreach ($result as $row) {
        echo "
        <div class = \"main-wrapper\">
        <div class = \"container\">
            <div class = \"product-div\">
                <div class = \"product-div-left\">
                    <div class = \"img-container\">
                        <img src = \"imgs/$row[image_name]\" alt = \"Product foto\">
                    </div>
                </div>
                <div class = \"product-div-right\">
                    <span class = \"product-name\">$row[product_name]</span>
                    <span class = \"product-price\">€$row[product_price]</span>
                    <p class = \"product-description\">$row[product_description]</p>
                    <div class = \"btn-groups\">
                    <form action=\"shoppingCart.php?id=$row[product_id]\" method=\"post\">
                        <input type = \"number\" name = \"amount\" id = \"amount\" value = \"1\" min = \"1\" max = \"10\">
                        <input type = \"hidden\" name = \"name\" value = \"$row[product_name]\">
                        <input type = \"hidden\" name = \"price\" value = \"$row[product_price]\">
                        <input type = \"hidden\" name = \"image\" value = \"$row[image_name]\">
                        <br>
                        <br>
                        <button type = \"submit\" class = \"add-cart-btn\" name = \"cart\"><i class = \"fas fa-shopping-cart\"></i>Toevoegen aan winkelwagen</button>
                        <button type = \"button\" class = \"buy-now-btn\"><i class = \"fas fa-heart\"></i>Toevoegen aan verlanglijst</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        ";
        }
    }else{
        header("Location: 400.php");
    }
?>

<?php
include 'incs/footer.php';
?>