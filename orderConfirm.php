<?php
include 'incs/header.php';

if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];
} else {
    header("Location: 404.php");
}
?>

<?php
include 'incs/navBar.php';
?>

<body>

    <h1 style="text-align: center;margin-top:40px;"> Bedankt voor uw bestelling! <br>Bestelnummer #<?php echo $orderId ?></h1>

    <div class="centered">
        <img src="imgs/confirmOrder.svg" alt="Bedankt voor uw bestelling">
    </div>

    <?php
    include 'incs/footer.php';
    ?>