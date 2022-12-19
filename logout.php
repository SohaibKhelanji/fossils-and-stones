<?php
require_once 'incs/header.php';

if (isset($_SESSION['userId'])) {

    include_once 'classes/dbh.php';
    include_once 'classes/user.php';


    $user = new User($userFirstname, $userLastname, $userEmail, $userStreetName, $userHouseNumber, $userPostalCode, $userCity, $userPassword);
    $user->logoutUser();
    unset($_SESSION['cart']);

    header("location: login.php");

}
else {
    header("location: index.php");
    exit();
}
