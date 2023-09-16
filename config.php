<?php
$dsn = "mysql:host=localhost;dbname=vichy1";
$user = "root";
$pass = "";

try {

    $db = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
