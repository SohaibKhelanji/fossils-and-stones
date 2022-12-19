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

<form class="search-bar" methode="post" action="">
    <input id="searchUser" class="input-search" type="text" name="searchUser" placeholder="Zoek een gebruiker">
    <button type="submit" name="submit-search"><i class="fas fa-search"></i></button>
</form>


<div id="search-results-users"></div>

<div id="all-users"> 
<div id="users-container">

<?php


$stmt = $dbh->connection()->prepare("SELECT * FROM user ORDER BY user_firstname ASC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($users as $user) {
    $databaseId = $user['user_id'];
    $Firstname = $user['user_firstname'];
    $Lastname = $user['user_lastname'];
    $Email = $user['user_email'];
    $Role = $user['user_role'];

    echo "
    <div class=\"user-card\" onclick=\"window.location.href='viewUserAdmin.php?id=$databaseId';\" >
    <h2>$Firstname $Lastname</h2>
    <p>$Email</p>
    <p>$Role</p>
    </div>
    ";
}

?>


</div>
</div>

<?php
include 'incs/footer.php';
?>