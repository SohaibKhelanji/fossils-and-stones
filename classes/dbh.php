<?php

class dbh
{
    public function connection()
    {
        try {
            $username = "root";
            $password = "";
            $pdo = new PDO('mysql:host=localhost;dbname=fas', $username, $password);
            return $pdo;
        } catch (PDOException $e) {
            print "Error!:" . $e->getMessage() . "<br/>";
            die();
        }
    }
}
