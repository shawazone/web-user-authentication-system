<?php

$username ='root';
$password ='root';

try{
    $pdo = new PDO('mysql:host=localhost;dbname=users', $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

?>
