<?php

include 'incs/header.php';
include 'classes/dbh.php';

if (isset($_SESSION['userId']) && $userRole == "user") {
    header("Location: 404.php");
}elseif(!isset($_SESSION['userId'])){
    header("Location: 404.php");
}

$dbh = new Dbh();

$productId = $_GET['id'];

$stmt = $dbh->connection()->prepare("SELECT * FROM product WHERE product_id = :productId");
$stmt->bindParam(':productId', $productId);
$stmt->execute();
$result = $stmt->fetchAll();
if (empty($result)) {
    header("Location: 400.php");
}


if (isset($_POST['submit'])) {
    $productName = $_POST['productName'];
    $productStock = $_POST['productStock'];
    $productDescription = $_POST['productDescription'];
    $productCategory = $_POST['productCategory'];
    if (!isset($_POST['productAvailability'])) {
        $productAvailability = "false";
    }else {
        $productAvailability = $_POST['productAvailability'];
    }
    $productImage = $_FILES['productImage']['name'];
    $productImageTmp = $_FILES['productImage']['tmp_name'];
    $productImageSize = $_FILES['productImage']['size'];
    $productImageType = $_FILES['productImage']['type'];
    $productImageExt = explode('.', $productImage);
    $productImageActualExt = strtolower(end($productImageExt));
    $allowed = array('jpg', 'jpeg', 'png');

    // if no image is uploaded then update the rest of the product
    if (empty($productImage)) {
        $stmt = $dbh->connection()->prepare("UPDATE product SET product_name = :productName, product_category = :productCategory, product_description = :productDescription, product_quantity = :productStock, product_availability = :productAvailability WHERE product_id = :productId");
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':productStock', $productStock);
        $stmt->bindParam(':productDescription', $productDescription);
        $stmt->bindParam(':productCategory', $productCategory);
        $stmt->bindParam(':productAvailability', $productAvailability);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        header("Location: products.php");
    } else {


        if (in_array($productImageActualExt, $allowed)) {
            if ($productImageSize < 1000000) {
                // delete old image
                $stmt = $dbh->connection()->prepare("SELECT * FROM product_image WHERE product_id = :productId");
                $stmt->bindParam(':productId', $productId);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $oldImage = $result['image_name'];
                unlink('imgs/' . $oldImage);
                $productImageNewName = uniqid('', true) . "." . $productImageActualExt;
                $productImageDestination = 'imgs/' . $productImageNewName;
                move_uploaded_file($productImageTmp, $productImageDestination);
                $stmt = $dbh->connection()->prepare("UPDATE product SET product_name = :productName, product_category = :productCategory, product_description = :productDescription, product_quantity = :productStock, product_availability = :productAvailability WHERE product_id = :productId");
                $stmt->bindParam(':productName', $productName);
                $stmt->bindParam(':productStock', $productStock);
                $stmt->bindParam(':productDescription', $productDescription);
                $stmt->bindParam(':productCategory', $productCategory);
                $stmt->bindParam(':productAvailability', $productAvailability);
                $stmt->bindParam(':productId', $productId);
                $stmt->execute();
                $stmt = $dbh->connection()->prepare("SELECT * FROM product WHERE product_name = :productName");
                $stmt->bindParam(':productName', $productName);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $productId = $row['product_id'];
                $stmtImg = $dbh->connection()->prepare("UPDATE product_image SET image_name = :productImage WHERE product_id = :productId");
                $stmtImg->bindParam(':productId', $productId);
                $stmtImg->bindParam(':productImage', $productImageNewName);
                $stmtImg->execute();
                header("Location: products.php");
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }
    }
}

?>

<?php
include 'incs/navBar.php';
?>

<div id="add-product-container">

<?php
$stmt = $dbh->connection()->prepare("SELECT * FROM product INNER JOIN product_image ON product_image.product_id = product.product_id  WHERE product.product_id = :productId");
$stmt->bindParam(':productId', $productId);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$productName = $row['product_name'];
$productDescription = $row['product_description'];
$productPrice = $row['product_price'];
$productImage = $row['image_name'];
$productCategory = $row['product_category'];
$productStock = $row['product_quantity'];
$productAvailability = $row['product_availability'];
// select category name
$stmt = $dbh->connection()->prepare("SELECT * FROM product_category WHERE category_id = :productCategory");
$stmt->bindParam(':productCategory', $productCategory);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$productCategoryName = $row['category_name'];
?>

<div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Product bewerken</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="" class="login-form" method="post" enctype="multipart/form-data">
            <img src="<?php echo "imgs/$productImage"?>" alt="Product foto" id="productPictureDisplay" onclick="triggerClick()">
        <input type="file" id="productPictureUpload" name="productImage" onchange="displayImage(this)" value="" style="display:none ;">
            <div class="form-control">
                <input type="text" name="productName" id="productName" placeholder="Naam product" value="<?php echo $productName ?>" required>
                <i class="fas fa-font"></i>
            </div>
            <div class="form-control">
                <input type="text" name="productStock" id="productStock" placeholder="Voorraad product" value="<?php echo $productStock?>" required>
                <i class="fas fa-boxes"></i>
            </div>
            <div class="form-control">
                <textarea name="productDescription" id="productDescription" cols="55" rows="10" placeholder="Beschrijving product" resize="none" required><?php echo $productDescription ?></textarea>
            </div>
            <div class="form-control">
                <select name="productCategory" id="productCategory" required>
                    <option value="<?php echo $productCategory?>"><?php echo $productCategoryName?></option>
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
            <br>
            <label for="productAvailability">Product beschikbaarheid</label>
            <br>
            <input type="checkbox" name="productAvailability" id="productAvailability" onclick="checkAvailability()" value="<?php echo $productAvailability?>" <?php if($productAvailability == "true"){echo "checked";}?>>
            <button class="submit" type="submit" name="submit">Bewerken</button>
            </form>
        </div>
    </div>
</div>

</div>

<?php
include 'incs/footer.php';
?>