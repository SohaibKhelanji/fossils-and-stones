<?php 
session_start();


if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $userFirstname = $_SESSION['userFirstname'];
    $userLastname = $_SESSION['userLastname'];
    $userEmail = $_SESSION['userEmail'];
    $userStreetName = $_SESSION['userStreetName'];
    $userHouseNumber = $_SESSION['userHouseNumber'];
    $userPostalCode = $_SESSION['userPostalCode'];
    $userCity = $_SESSION['userCity'];
    $userPassword = $_SESSION['userPassword'];
    $userRole = $_SESSION['userRole'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" href="imgs/favicon.ico">
    <link rel="stylesheet" href="css/styles.css">

    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Roboto Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

   
    <title>Fossils and Stones</title>
</head>
