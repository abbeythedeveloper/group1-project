<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "library_db";
$conn = new mysqli($server, $user, $pass, $dbname);
if(!$conn){
    echo "Oops! : {$conn->connect_error}";
}
?>