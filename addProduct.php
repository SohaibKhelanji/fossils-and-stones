<?php

include 'incs/header.php';
include 'classes/dbh.php';

if (isset($_SESSION['userId']) && $userRole == "user") {
    header("Location: 404.php");
} elseif (!isset($_SESSION['userId'])) {
    header("Location: 404.php");
}

$dbh = new Dbh();

if (isset($_POST['submit'])) {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productStock = $_POST['productStock'];
    $productDescription = $_POST['productDescription'];
    $productCategory = $_POST['productCategory'];
    $productImage = $_FILES['productImage']['name'];
    $productImageTmp = $_FILES['productImage']['tmp_name'];
    $productImageSize = $_FILES['productImage']['size'];
    $productImageType = $_FILES['productImage']['type'];
    $productImageExt = explode('.', $productImage);
    $productImageActualExt = strtolower(end($productImageExt));
    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($productImageActualExt, $allowed)) {
        if ($productImageSize < 1000000) {
            $productImageNewName = uniqid('', true) . "." . $productImageActualExt;
            $productImageDestination = 'imgs/' . $productImageNewName;
            move_uploaded_file($productImageTmp, $productImageDestination);
            $stmt = $dbh->connection()->prepare("INSERT INTO product (product_name, product_price, product_category, product_description, product_quantity) VALUES (:productName, :productPrice, :productCategory, :productDescription, :productStock)");
            $stmt->bindParam(':productName', $productName);
            $stmt->bindParam(':productPrice', $productPrice);
            $stmt->bindParam(':productStock', $productStock);
            $stmt->bindParam(':productDescription', $productDescription);
            $stmt->bindParam(':productCategory', $productCategory);
            $stmt->execute();
            $stmt = $dbh->connection()->prepare("SELECT * FROM product WHERE product_name = :productName");
            $stmt->bindParam(':productName', $productName);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $productId = $row['product_id'];
            $stmtImg = $dbh->connection()->prepare("INSERT INTO product_image (image_name, product_id) VALUES (:productImage, :productId)");
            $stmtImg->bindParam(':productId', $productId);
            $stmtImg->bindParam(':productImage', $productImageNewName);
            $stmtImg->execute();
            header("Location: products.php");
        } else {
            echo "Je afbeelding is te groot";
        }
    } else {
        echo "Je kunt alleen jpg, jpeg en png bestanden uploaden";
    }
}


?>

<body>

    <?php
    include 'incs/navBar.php';
    ?>


    <div id="add-product-container">
        <div class="title-row">
            <div class="col-md-12">
                <h1 class="text-center">Product toevoegen</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="" class="login-form" method="post" enctype="multipart/form-data">
                    <div class="form-control">
                        <input type="text" name="productName" id="productName" placeholder="Naam product" required>
                        <i class="fas fa-font"></i>
                    </div>
                    <div class="form-control">
                        <input type="text" name="productPrice" id="productPrice" placeholder="Prijs product" required>
                        <i class="fas fa-euro-sign"></i>
                    </div>
                    <div class="form-control">
                        <input type="text" name="productStock" id="productStock" placeholder="Voorraad product" required>
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="form-control">
                        <textarea name="productDescription" id="productDescription" cols="55" rows="10" placeholder="Beschrijving product" resize="none" required></textarea>
                    </div>
                    <div class="form-control">
                        <select name="productCategory" id="productCategory" required>
                            <option value="0">Selecteer een categorie</option>
                            <?php
                            $stmt = $dbh->connection()->prepare("SELECT * FROM product_category");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $categoryId = $row['category_id'];
                                $categoryName = $row['category_name'];
                                echo "<option value='$categoryId'>$categoryName</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-control">
                        <input type="file" name="productImage" id="productImage" placeholder="Afbeelding product" required>
                        <i class="fas fa-image"></i>
                    </div>
                    <button class="submit" type="submit" name="submit">Toevoegen</button>
                </form>
            </div>
        </div>
    </div>


    <?php
    include 'incs/footer.php';
    ?>