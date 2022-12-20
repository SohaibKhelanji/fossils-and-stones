<?php
include 'incs/header.php';
include 'classes/dbh.php';
include 'classes/user.php';

$dbh = new Dbh();
if (isset($_SESSION['user_id'])) {
    $user = new User($firstname, $lastname, $email, $streetname, $housenumber, $postalcode, $city, $password);
}



if (isset($_POST['cart'])) {

    //check if product id is already in the cart and if so, add the amount to the existing amount
    if (isset($_SESSION['cart'])) {
        $cartId = array_column($_SESSION['cart'], 'product_id');
        if (in_array($_GET['id'], $cartId)) {
            foreach ($_SESSION['cart'] as $key => $value) {
                if ($value['product_id'] == $_GET['id']) {
                    $_SESSION['cart'][$key]['product_quantity'] += $_POST['amount'];
                }
            }
        } else {
            $cart = array(
                'product_id' => $_GET['id'],
                'product_name' => $_POST['name'],
                'product_price' => $_POST['price'],
                'product_quantity' => $_POST['amount'],
                'product_image' => $_POST['image']
            );
            $_SESSION['cart'][] = $cart;
        }
    } else {
        $cart = array(
            'product_id' => $_GET['id'],
            'product_name' => $_POST['name'],
            'product_price' => $_POST['price'],
            'product_quantity' => $_POST['amount'],
            'product_image' => $_POST['image']
        );
        $_SESSION['cart'][] = $cart;
    }

}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['product_id'] == $_GET['id']) {
                unset($_SESSION['cart'][$key]);
            }
        }
    }
    if ($_GET['action'] == 'plus') {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['product_id'] == $_GET['id']) {
                $_SESSION['cart'][$key]['product_quantity'] += 1;
            }
        }
    }
    if ($_GET['action'] == 'minus') {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['product_id'] == $_GET['id']) {
                $_SESSION['cart'][$key]['product_quantity'] -= 1;
            }
        }
    }
}


if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['product_quantity'] < 1) {
            unset($_SESSION['cart'][$key]);
        }
    }
}


// if is submit and session is set, make variable for user_id and timestamp
if (isset($_POST['submit']) && isset($_SESSION['userId'])) {
    $user_id = $_SESSION['userId'];
    $timestamp = date("Y-m-d H:i:s");

    // insert into orders table
    $sql = "INSERT INTO orders (user_id, orders_timestamp) VALUES (?, ?)";
    $stmt = $dbh->connection()->prepare($sql);
    $stmt->execute([$user_id, $timestamp]);

// select order with same timestamp and user_id;
    $sql = "SELECT * FROM orders WHERE user_id = ? AND orders_timestamp = ?";
    $stmt = $dbh->connection()->prepare($sql);
    $stmt->execute([$user_id, $timestamp]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $last_id = $result['orders_id'];


    // insert into order_product table 
    foreach ($_SESSION['cart'] as $key => $value) {
        $sql = "INSERT INTO order_product (orders_id, product_id, order_product_quantity) VALUES (?, ?, ?)";
        $stmt = $dbh->connection()->prepare($sql);
        $stmt->execute([$last_id, $value['product_id'], $value['product_quantity']]);
    }

    // remove quantity from product table quantity
    foreach ($_SESSION['cart'] as $key => $value) {
        $sql = "UPDATE product SET product_quantity = product_quantity - ? WHERE product_id = ?";
        $stmt = $dbh->connection()->prepare($sql);
        $stmt->execute([$value['product_quantity'], $value['product_id']]);
    }


    // unset session cart
    unset($_SESSION['cart']);

    // redirect to orderConfirm page
    header("Location: orderConfirm.php?orderId=$last_id");

}

// if is submit and session is not set, make variable for timestamp
if (isset($_POST['submit']) && !isset($_SESSION['userId'])) {
    $timestamp = date("Y-m-d H:i:s");

    // insert into orders table
    $sql = "INSERT INTO orders (orders_timestamp) VALUES (?)";
    $stmt = $dbh->connection()->prepare($sql);
    $stmt->execute([$timestamp]);

    // select order with same timestamp and user_id;
    $sql = "SELECT * FROM orders WHERE orders_timestamp = ?";
    $stmt = $dbh->connection()->prepare($sql);
    $stmt->execute([$timestamp]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $last_id = $result['orders_id'];

    // insert into order_product table
    foreach ($_SESSION['cart'] as $key => $value) {
        $sql = "INSERT INTO order_product (orders_id, product_id, order_product_quantity) VALUES (?, ?, ?)";
        $stmt = $dbh->connection()->prepare($sql);
        $stmt->execute([$last_id, $value['product_id'], $value['product_quantity']]);
    }

    // remove quantity from product table quantity
    foreach ($_SESSION['cart'] as $key => $value) {
        $sql = "UPDATE product SET product_quantity = product_quantity - ? WHERE product_id = ?";
        $stmt = $dbh->connection()->prepare($sql);
        $stmt->execute([$value['product_quantity'], $value['product_id']]);
    }

    // insert address in order_adress table database
    $sql = "INSERT INTO order_address (orders_id, order_address_streetname, order_address_housenumber, order_address_postalcode, order_address_city) VALUES (?, ?, ?, ?, ?)";
    $stmt = $dbh->connection()->prepare($sql);
    $stmt->execute([$last_id, $_POST['streetname'], $_POST['housenumber'], $_POST['postalcode'], $_POST['city']]);

    // insert user firtsname and lastname and email in order_user table database
    $sql = "INSERT INTO order_user (orders_id, order_user_firstname, order_user_lastname, order_user_email) VALUES (?, ?, ?, ?)";
    $stmt = $dbh->connection()->prepare($sql);
    $stmt->execute([$last_id, $_POST['firstname'], $_POST['lastname'], $_POST['email']]);

    // unset session cart
    unset($_SESSION['cart']);

    // redirect to orderConfirm page
    header("Location: orderConfirm.php");

}


    







?>

<body>

<?php
include 'incs/navBar.php';
?>

<div class="wrapper">
		<h1>Winkelwagen</h1>
		<div class="project">
			<div class="shop">
                <?php 

                $total= 0;

                if (!empty($_SESSION['cart'])) {

                    foreach ($_SESSION['cart'] as $key => $value) {
                        echo "
                        <div class=\"box\">
					<img src=\"imgs/$value[product_image]\">
					<div class=\"content\">
                    <h3>$value[product_name]</h3>
                    <h4>€$value[product_price]</h4>
						<p class=\"unit\">Aantal:
                        <a href=\"shoppingCart.php?action=minus&id=$value[product_id]\"><i class=\"fas fa-minus\"></i></a>
                        $value[product_quantity]
                        <a href=\"shoppingCart.php?action=plus&id=$value[product_id]\"><i class=\"fas fa-plus\"></i></a>
                        </p>
						<a href = \"shoppingCart.php?action=delete&id=$value[product_id]\" class=\"btn-area\"><i aria-hidden=\"true\" class=\"fa fa-trash\"></i></a>
					</div>
                    </div>
                        ";

                        $total = $total + ($value['product_price'] * $value['product_quantity']);
                        $totalPrice = number_format($total, 2);

                    }
                    $totalPrice = $totalPrice;

                    if (!isset($_SESSION['userId'])) {
                        echo " 
                </div>
			<div class=\"right-bar\">	
            <p><span>Totaal:</span>€$totalPrice<span></span></p>
            <hr>
            <form class=\"login-form\" method=\"post\" action=\"\">
            <div class=\"form-control\">
                <input type=\"text\" name=\"firstname\" placeholder=\"Voornaam\" required>
                <i class=\"fas fa-id-card\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" name=\"lastname\" placeholder=\"Achternaam\" required>
                <i class=\"fas fa-id-card\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" name=\"email\" placeholder=\"E-mail\" required>
                <i class=\"fas fa-at\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" name=\"streetname\" placeholder=\"Straatnaam\" required>
                <i class=\"fas fa-road\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" name=\"housenumber\" placeholder=\"Huisnummer\" required>
                <i class=\"fas fa-hashtag\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" name=\"postalcode\" placeholder=\"Postcode\" required>
                <i class=\"fas fa-map-marker-alt\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" name=\"city\" placeholder=\"Stad\" required>
                <i class=\"fas fa-city\"></i>
            </div>
            <button name=\"submit\" type=\"submit\" id=\"submit\" class=\"submit-cart\"><i class=\"fa fa-shopping-cart\"></i>Bestellen</button>
            </form>
			</div>
		</div>
	</div>
                ";
                    } else {
                        echo "
                        </div>
                        <div class=\"right-bar\">	
                        <p><span>Totaal:</span>€$totalPrice<span></span></p>
                        <hr>
                        <form class=\"login-form\" method=\"post\" action=\"\">
                        <div class=\"form-control\">
                            <input type=\"text\" name=\"firstname\" placeholder=\"Voornaam\" value=\"$userFirstname\" required disabled>
                            <i class=\"fas fa-id-card\"></i>
                        </div>
                        <div class=\"form-control\">
                            <input type=\"text\" name=\"lastname\" placeholder=\"Achternaam\" value=\"$userLastname\" required disabled>
                            <i class=\"fas fa-id-card\"></i>
                        </div>
                        <div class=\"form-control\">
                            <input type=\"text\" name=\"email\" placeholder=\"E-mail\" value=\"$userEmail\" required disabled>
                            <i class=\"fas fa-at\"></i>
                        </div>
                        <div class=\"form-control\">
                            <input type=\"text\" name=\"streetname\" placeholder=\"Straatnaam\" value=\"$userStreetName\" required disabled>
                            <i class=\"fas fa-road\"></i>
                        </div>
                        <div class=\"form-control\">
                            <input type=\"text\" name=\"housenumber\" placeholder=\"Huisnummer\" value=\"$userHouseNumber\" required disabled>
                            <i class=\"fas fa-hashtag\"></i>
                        </div>
                        <div class=\"form-control\">
                            <input type=\"text\" name=\"postalcode\" placeholder=\"Postcode\" value=\"$userPostalCode\" required disabled>
                            <i class=\"fas fa-map-marker-alt\"></i>
                        </div>
                        <div class=\"form-control\">
                            <input type=\"text\" name=\"city\" placeholder=\"Stad\" value=\"$userCity\" required disabled>
                            <i class=\"fas fa-city\"></i>
                        </div>
                        <button name=\"submit\" type=\"submit\" id=\"submit\" class=\"submit-cart\"><i class=\"fa fa-shopping-cart\"></i>Bestellen</button>
                        </form>
                        </div>
                    </div>
                </div> 
                        ";
                    }
                 } else {
                        echo "<h3 class= \"empty-cart-text\">Winkelwagen is leeg</h3>";
                    }
                ?>



<!-- button that unsets session cart -->
<!-- <form action="shoppingCart.php" method="post">
    <input type="submit" name="empty" value="Empty Cart">
</form>

<?php 
if (isset($_POST['empty'])) {
    unset($_SESSION['cart']);
    header("Location: shoppingCart.php");
}
?> -->

<?php
include 'incs/footer.php';
?>

