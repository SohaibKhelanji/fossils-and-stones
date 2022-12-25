<?php
include 'incs/header.php';
include 'classes/dbh.php';

$dbh = new Dbh();

if (!isset($_SESSION['userId'])) {
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

// check if order belongs to user
$stmt = $dbh->connection()->prepare("SELECT * FROM orders WHERE orders_id = $orderId AND user_id = $userId");
$stmt->execute();
$result = $stmt->fetchAll();

if (empty($result)) {
  header("Location: 400.php");
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
        <div> <?php echo $userFirstname . "&nbsp;" . $userLastname ?></div>
        <div><?php echo $userStreetName . "&nbsp;" . $userHouseNumber ?></div>
        <div><?php echo $userPostalCode . "&nbsp;" . $userCity ?></div>
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
        <div class="notice">Bedankt voor uw bestelling bij Fossils and Stones!</div>
      </div>
    </main>
  </div>

  <?php
  include 'incs/footer.php';
  ?>