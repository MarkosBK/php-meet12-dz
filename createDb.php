<?php
include_once("classes.php");
$link = connect();

$q = "CREATE TABLE Pictures(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(64),
    path varchar(256),
    size int
   ) default charset='utf8'";

mysqli_query($link, $q);
$error = mysqli_errno($link);
if ($error) {
    echo "<h3 align='center' style='color: red'>Query: " . $error . "</h3>";
    exit();
}
echo "<h3 align='center' style='color: green'>База создана успешно!</h3>";