<?php
include 'incs/header.php';
include 'classes/dbh.php';

$dbh = new Dbh();

if (isset($_SESSION['userId']) && $userRole == "user") {
  header("Location: 404.php");
} elseif (!isset($_SESSION['userId'])) {
  header("Location: 404.php");
}

$orderId = $_GET['id'];

// check if order exists
$stmt = $dbh->connection()->prepare("SELECT * FROM orders WHERE orders_id = $orderId");
$stmt->execute();
$result = $stmt->fetchAll();

if (empty($result)) {
  header("Location: 404.php");
}


if (empty($result)) {
  header("Location: 400.php");
}

// check if orders user_id is not null
$stmt = $dbh->connection()->prepare("SELECT * FROM orders WHERE orders_id = $orderId AND user_id IS NOT NULL");
$stmt->execute();
$result = $stmt->fetchAll();

if (empty($result)) {
  $noAccount = "true";
} else {
  $noAccount = "false";
}

// change order status if get is set
if (isset($_GET['status'])) {
  $status = $_GET['status'];

  $stmt = $dbh->connection()->prepare("UPDATE orders SET orders_processed = '$status' WHERE orders_id = $orderId");
  $stmt->execute();

  header("Location: viewOrderAdmin.php?id=$orderId");
}



?>

<body style="background-color: grey;">
  <div id=invoice>
    <header class="clearfix">
      <div id="logo">
        <img src="imgs/logo-inverted.png">
      </div>
      <h1>BESTELLING #<?php echo $orderId ?></h1>
      <div id="company" class="clearfix">
        <div>Fossils and Stones</div>
        <div>Lorem ipsum 1<br /> 0000 LI Lorem</div>
        <div><a href="mailto:contact@fossilsandstones.nl">contact@fossilsandstones.nl</a></div>
      </div>
      <div id="project">
        <?php

        if ($noAccount = "true") {
          $stmt = $dbh->connection()->prepare("SELECT * FROM order_address INNER JOIN order_user ON order_address.orders_id = order_user.orders_id INNER JOIN  orders ON order_address.orders_id = orders.orders_id WHERE orders.orders_id = $orderId");
          $stmt->execute();
          $result = $stmt->fetchAll();

          foreach ($result as $orderAddress) {
            $orderFirstname = $orderAddress['order_user_firstname'];
            $orderLastname = $orderAddress['order_user_lastname'];
            $orderStreetName = $orderAddress['order_address_streetname'];
            $orderHouseNumber = $orderAddress['order_address_housenumber'];
            $orderPostalCode = $orderAddress['order_address_postalcode'];
            $orderCity = $orderAddress['order_address_city'];

            echo "<div>$orderFirstname $orderLastname</div>";
            echo "<div>$orderStreetName $orderHouseNumber</div>";
            echo "<div>$orderPostalCode $orderCity</div>";
          }
        }
        if ($noAccount = "false") {
          // get user info from user_id that is linked to the order
          $stmt = $dbh->connection()->prepare("SELECT * FROM user INNER JOIN orders ON orders.user_id = user.user_id INNER JOIN user_address ON user.user_id = user_address.user_id WHERE orders.orders_id = $orderId");
          $stmt->execute();
          $result = $stmt->fetchAll();

          foreach ($result as $order) {
            $orderFirstname = $order['user_firstname'];
            $orderLastname = $order['user_lastname'];
            $orderStreetName = $order['address_streetname'];
            $orderHouseNumber = $order['address_housenumber'];
            $orderPostalCode = $order['address_postalcode'];
            $orderCity = $order['address_city'];

            echo "<div>$orderFirstname $orderLastname</div>";
            echo "<div>$orderStreetName $orderHouseNumber</div>";
            echo "<div>$orderPostalCode $orderCity</div>";
          }
        }
        ?>
        <div><?php

              $stmt = $dbh->connection()->prepare("SELECT * FROM orders WHERE orders_id = $orderId");
              $stmt->execute();
              $result = $stmt->fetchAll();

              foreach ($result as $order) {
                $orderTimestamp = date("d-m-Y H:i", strtotime($order['orders_timestamp']));
                $orderTimestamp = date("l j F Y ", strtotime($orderTimestamp));

                $orderTimestamp = str_replace("January", "Januari", $orderTimestamp);
                $orderTimestamp = str_replace("February", "Februari", $orderTimestamp);
                $orderTimestamp = str_replace("March", "Maart", $orderTimestamp);
                $orderTimestamp = str_replace("April", "April", $orderTimestamp);
                $orderTimestamp = str_replace("May", "Mei", $orderTimestamp);
                $orderTimestamp = str_replace("June", "Juni", $orderTimestamp);
                $orderTimestamp = str_replace("July", "Juli", $orderTimestamp);
                $orderTimestamp = str_replace("August", "Augustus", $orderTimestamp);
                $orderTimestamp = str_replace("September", "September", $orderTimestamp);
                $orderTimestamp = str_replace("October", "Oktober", $orderTimestamp);
                $orderTimestamp = str_replace("November", "November", $orderTimestamp);
                $orderTimestamp = str_replace("December", "December", $orderTimestamp);

                $orderTimestamp = str_replace("Monday", "Maandag", $orderTimestamp);
                $orderTimestamp = str_replace("Tuesday", "Dinsdag", $orderTimestamp);
                $orderTimestamp = str_replace("Wednesday", "Woensdag", $orderTimestamp);
                $orderTimestamp = str_replace("Thursday", "Donderdag", $orderTimestamp);
                $orderTimestamp = str_replace("Friday", "Vrijdag", $orderTimestamp);
                $orderTimestamp = str_replace("Saturday", "Zaterdag", $orderTimestamp);
                $orderTimestamp = str_replace("Sunday", "Zondag", $orderTimestamp);
                echo $orderTimestamp;
              }

              ?></div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">PRODUCT</th>
            <th class="desc">BESCHRIJVING</th>
            <th>PRIJS</th>
            <th>AANTAL</th>
            <th>TOTAAL</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  get all products from order
          $stmt = $dbh->connection()->prepare("SELECT * FROM order_product WHERE orders_id = $orderId");
          $stmt->execute();
          $result = $stmt->fetchAll();

          foreach ($result as $row) {
            $productId = $row['product_id'];
            $quantity = $row['order_product_quantity'];

            // get product info
            $stmt = $dbh->connection()->prepare("SELECT * FROM product WHERE product_id = $productId");
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
              $productName = $row['product_name'];
              $productDescription = $row['product_description'];
              $productPrice = $row['product_price'];
            }

            $total = $productPrice * $quantity;
            $total = number_format($total, 2, '.', '');
            $productPrice = number_format($productPrice, 2, '.', '');

            echo "<tr>
            <td class='service'>$productName</td>
            <td class='desc'>$productDescription</td>
            <td class='unit'>€$productPrice</td>
            <td class='qty'>$quantity</td>
            <td class='total'>€$total</td>
            </tr>";
          }

          $stmt = $dbh->connection()->prepare("SELECT * FROM order_product WHERE orders_id = $orderId");
          $stmt->execute();
          $result = $stmt->fetchAll();

          $total = 0;

          foreach ($result as $row) {
            $productId = $row['product_id'];
            $quantity = $row['order_product_quantity'];

            // get product info
            $stmt = $dbh->connection()->prepare("SELECT * FROM product WHERE product_id = $productId");
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
              $productPrice = $row['product_price'];
            }

            $total += $productPrice * $quantity;
          }

          $total = number_format($total, 2, '.', '');

          echo "<tr>
        <td colspan='4' class='grand total'>Totaal</td>
        <td class=''>€$total</td>
        </tr>";


          ?>

        </tbody>
      </table>
      <div id="notices">
        <div class="notice">
          <!-- if order is not processed echo button to change database status to 1 else to 0-->
          <?php
          // get order status
          $stmt = $dbh->connection()->prepare("SELECT * FROM orders WHERE orders_id = $orderId");
          $stmt->execute();
          $result = $stmt->fetchAll();

          foreach ($result as $row) {
            $orderStatus = $row['orders_processed'];


            if ($orderStatus == 0) {
              echo "
              <p>Deze bestelling is nog niet verwerkt.</p>
              <a href='viewOrderAdmin.php?id=$orderId&status=1' class='btn btn-primary'>Bestelling verwerken</a>
              ";
            } else {
              echo "
              <p>Deze bestelling is verwerkt.</p>
              <a href='viewOrderAdmin.php?id=$orderId&status=0' class='btn btn-primary'>Verwerking ongedaan maken</a>
              ";
            }
          }
          ?>
        </div>
      </div>
    </main>
  </div>

  <?php
  include 'incs/footer.php';
  ?>