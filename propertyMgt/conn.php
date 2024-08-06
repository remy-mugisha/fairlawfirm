<?php
$host = "localhost";
$dbname = "properties";
$charset = "utf8";
$username = "root";
$password = "Remier@&30";

try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=$charset",
        $username,
        $password,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
} catch (Exception $ex) {

    die("<center><h1> No result found </h1> </center>");

    //die("Error: " . $ex->getMessage());
}
?>
